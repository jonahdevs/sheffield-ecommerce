<?php

use App\Enums\OrderStatus;
use App\Enums\SapSyncStatus;
use App\Jobs\RecoverSapInvoiceJob;
use App\Jobs\SyncOrderToSapJob;
use App\Models\Order;
use App\Models\Payment;
use App\Models\SapSyncLog;
use App\Models\User;
use App\Notifications\SapSyncFailedNotification;
use App\Services\Sap\DTOs\SapOrderPayload;
use App\Services\Sap\SapApiException;
use App\Services\Sap\SapIntegrationService;
use App\Services\Sap\SapWebhookHandler;
use App\Services\Sap\ValueObjects\SapSyncResult;
use App\Settings\IntegrationSettings;
use App\Settings\NotificationSettings;
use Database\Seeders\PermissionSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\postJson;

// ==================================================
// WEBHOOK - CU NUMBER DELIVERY
// ==================================================

it('stores the CU number and marks the order completed when the webhook fires', function () {
    config(['sap.webhook_secret' => '']);

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::AWAITING_CU,
        'sap_doc_entry' => 'DOC-001',
    ]);

    $handler = app(SapWebhookHandler::class);
    $request = Request::create('/api/webhooks/sap', 'POST', [], [], [], [], json_encode([
        'event' => 'invoice.cu_number_generated',
        'data' => [
            'external_reference' => $order->order_number,
            'cu_number' => 'KRA-CU-12345',
            'validated_at' => '2026-06-06T10:00:00Z',
        ],
    ]));
    $request->headers->set('Content-Type', 'application/json');

    $handler->handle($request);

    $order->refresh();
    expect($order->cu_number)->toBe('KRA-CU-12345')
        ->and($order->sap_sync_status)->toBe(SapSyncStatus::COMPLETED)
        ->and($order->sap_synced_at)->not->toBeNull();
});

it('persists a sap_sync_log entry on CU webhook receipt', function () {
    config(['sap.webhook_secret' => '']);

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::AWAITING_CU,
    ]);

    $handler = app(SapWebhookHandler::class);
    $request = Request::create('/api/webhooks/sap', 'POST', [], [], [], [], json_encode([
        'event' => 'invoice.cu_number_generated',
        'data' => [
            'external_reference' => $order->order_number,
            'cu_number' => 'KRA-CU-99999',
        ],
    ]));
    $request->headers->set('Content-Type', 'application/json');

    $handler->handle($request);

    expect(SapSyncLog::where('order_id', $order->id)->where('operation', 'cu_webhook')->exists())->toBeTrue();
});

it('ignores a duplicate CU number webhook without overwriting', function () {
    config(['sap.webhook_secret' => '']);

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::COMPLETED,
        'cu_number' => 'KRA-EXISTING',
    ]);

    $handler = app(SapWebhookHandler::class);
    $request = Request::create('/api/webhooks/sap', 'POST', [], [], [], [], json_encode([
        'event' => 'invoice.cu_number_generated',
        'data' => [
            'external_reference' => $order->order_number,
            'cu_number' => 'KRA-EXISTING',
        ],
    ]));
    $request->headers->set('Content-Type', 'application/json');

    $handler->handle($request);

    expect($order->fresh()->cu_number)->toBe('KRA-EXISTING');
    expect(SapSyncLog::where('order_id', $order->id)->count())->toBe(0);
});

it('handles the legacy flat payload shape (cu_number at root)', function () {
    config(['sap.webhook_secret' => '']);

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::AWAITING_CU,
    ]);

    $handler = app(SapWebhookHandler::class);
    $request = Request::create('/api/webhooks/sap', 'POST', [], [], [], [], json_encode([
        'external_reference' => $order->order_number,
        'cu_number' => 'KRA-LEGACY-001',
    ]));
    $request->headers->set('Content-Type', 'application/json');

    $handler->handle($request);

    expect($order->fresh()->cu_number)->toBe('KRA-LEGACY-001');
});

// ==================================================
// WEBHOOK - RETURNED STATUS
// ==================================================

it('marks order as RETURNED when a return webhook arrives in a valid state', function () {
    config(['sap.webhook_secret' => '']);

    foreach ([SapSyncStatus::AWAITING_CU, SapSyncStatus::COMPLETED] as $state) {
        $order = Order::factory()->create([
            'status' => OrderStatus::PROCESSING,
            'sap_sync_status' => $state,
        ]);

        $handler = app(SapWebhookHandler::class);
        $request = Request::create('/api/webhooks/sap', 'POST', [], [], [], [], json_encode([
            'external_reference' => $order->order_number,
            'status' => 'returned',
        ]));
        $request->headers->set('Content-Type', 'application/json');

        $handler->handle($request);

        expect($order->fresh()->sap_sync_status)->toBe(SapSyncStatus::RETURNED);
    }
});

it('ignores a RETURNED webhook for orders not in a valid state', function () {
    config(['sap.webhook_secret' => '']);

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::SYNCING,
    ]);

    $handler = app(SapWebhookHandler::class);
    $request = Request::create('/api/webhooks/sap', 'POST', [], [], [], [], json_encode([
        'external_reference' => $order->order_number,
        'status' => 'returned',
    ]));
    $request->headers->set('Content-Type', 'application/json');

    $handler->handle($request);

    expect($order->fresh()->sap_sync_status)->toBe(SapSyncStatus::SYNCING);
});

// ==================================================
// WEBHOOK - CONTROLLER + AUTH
// ==================================================

it('returns 401 when the SAP webhook secret is wrong', function () {
    config(['sap.webhook_secret' => 'correct-secret']);

    postJson('/api/webhooks/sap', [], ['X-SAP-Secret' => 'wrong'])->assertUnauthorized();
});

it('returns 200 for valid SAP webhook requests', function () {
    config(['sap.webhook_secret' => 'test-secret']);

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::AWAITING_CU,
    ]);

    postJson('/api/webhooks/sap', [
        'event' => 'invoice.cu_number_generated',
        'data' => [
            'external_reference' => $order->order_number,
            'cu_number' => 'KRA-TEST-001',
        ],
    ], ['X-SAP-Secret' => 'test-secret'])
        ->assertOk()
        ->assertJson(['success' => true]);
});

// ==================================================
// SYNC JOB
// ==================================================

it('dispatches SyncOrderToSapJob when markConfirmed transitions PENDING to PROCESSING', function () {
    Queue::fake();
    $this->seed(PermissionSeeder::class);

    app(IntegrationSettings::class)->fill([
        'sap_enabled' => true,
        'sap_auto_sync_orders' => true,
    ])->save();

    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);

    $order->markConfirmed();

    Queue::assertPushed(SyncOrderToSapJob::class, fn ($job) => $job->order->is($order));
});

it('does not dispatch the SAP job when sap_auto_sync_orders is disabled', function () {
    Queue::fake();
    $this->seed(PermissionSeeder::class);

    app(IntegrationSettings::class)->fill([
        'sap_enabled' => true,
        'sap_auto_sync_orders' => false,
    ])->save();

    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);
    $order->markConfirmed();

    Queue::assertNotPushed(SyncOrderToSapJob::class);
});

it('does not dispatch the job when the order is already past PENDING', function () {
    Queue::fake();

    $order = Order::factory()->create(['status' => OrderStatus::PROCESSING]);
    $order->markConfirmed();

    Queue::assertNothingPushed();
});

it('handles the job: updates status to AWAITING_CU and dispatches RecoverSapInvoiceJob', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::PENDING,
    ]);

    $sap = Mockery::mock(SapIntegrationService::class);
    $sap->shouldReceive('syncOrder')
        ->once()
        ->with(Mockery::type(Order::class))
        ->andReturn(new SapSyncResult('DOC-ENTRY-001', 'DOC-NUM-001', []));

    (new SyncOrderToSapJob($order))->handle($sap);

    $order->refresh();
    expect($order->sap_doc_entry)->toBe('DOC-ENTRY-001')
        ->and($order->sap_sync_status)->toBe(SapSyncStatus::AWAITING_CU);

    Queue::assertPushed(RecoverSapInvoiceJob::class);
});

it('skips create and re-dispatches RecoverSapInvoiceJob if doc_entry exists and status is AWAITING_CU', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::AWAITING_CU,
        'sap_doc_entry' => 'DOC-EXISTING',
    ]);

    $sap = Mockery::mock(SapIntegrationService::class);
    $sap->shouldNotReceive('syncOrder');

    (new SyncOrderToSapJob($order))->handle($sap);

    Queue::assertPushed(RecoverSapInvoiceJob::class);
});

it('skips entirely when order is already COMPLETED', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::COMPLETED,
    ]);

    $sap = Mockery::mock(SapIntegrationService::class);
    $sap->shouldNotReceive('syncOrder');

    (new SyncOrderToSapJob($order))->handle($sap);

    Queue::assertNothingPushed();
});

it('marks order FAILED and notifies staff when the job permanently fails', function () {
    Notification::fake();
    $this->seed(PermissionSeeder::class);

    // Fan out to individual staff; default seeded routing is 'central' (one inbox).
    app(NotificationSettings::class)->fill(['staff_email_routing' => 'individual'])->save();

    $staff = User::factory()->create();
    $staff->assignRole('staff');

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::SYNCING,
    ]);

    $job = new SyncOrderToSapJob($order);
    $job->failed(new RuntimeException('SAP server error'));

    $order->refresh();
    expect($order->sap_sync_status)->toBe(SapSyncStatus::FAILED)
        ->and($order->sap_sync_error)->toBe('SAP server error');

    Notification::assertSentTo($staff, SapSyncFailedNotification::class);
});

it('does not double-flag a FAILED order in the failed callback', function () {
    Notification::fake();

    $order = Order::factory()->create([
        'status' => OrderStatus::PROCESSING,
        'sap_sync_status' => SapSyncStatus::FAILED,
        'sap_sync_error' => 'original error',
    ]);

    $job = new SyncOrderToSapJob($order);
    $job->failed(new RuntimeException('another error'));

    expect($order->fresh()->sap_sync_error)->toBe('original error');
    Notification::assertNothingSent();
});

// ==================================================
// SAP ORDER PAYLOAD DTO
// ==================================================

it('builds the SAP payload with order items and customer details', function () {
    $order = Order::factory()->create(['notes' => 'ring bell']);

    Payment::factory()->successful()->create([
        'order_id' => $order->id,
        'mpesa_receipt' => 'MPE123456789',
    ]);

    $payload = SapOrderPayload::fromOrder($order);

    expect($payload)->toHaveKeys(['credit_guard_response', 'customer', 'order'])
        ->and($payload['customer']['email'])->toBe($order->user->email)
        ->and($payload['customer']['note'])->toBe('ring bell')
        ->and($payload['credit_guard_response']['uid'])->toBe('MPE123456789')
        ->and($payload['order']['Orderid'])->toBe($order->id)
        ->and($payload['order']['reference'])->toBe($order->order_number)
        ->and($payload['order']['payment_status'])->toBe('Paid');
});

it('fills card fields for a Paystack card payment', function () {
    $order = Order::factory()->create();

    Payment::factory()->paystack()->successful()->create([
        'order_id' => $order->id,
        'paystack_reference' => 'SHF-2026-00042-ABCDEFGH',
        'authorization_code' => 'AUTH_abc123',
        'card_brand' => 'visa',
        'card_last4' => '4242',
        'payload' => [
            'id' => 987654321,
            'authorization' => ['exp_month' => '9', 'exp_year' => '2029'],
        ],
    ]);

    $block = SapOrderPayload::fromOrder($order)['credit_guard_response'];

    expect($block['uid'])->toBe('SHF-2026-00042-ABCDEFGH')
        ->and($block['cgUid'])->toBe('987654321')
        ->and($block['cardBrand'])->toBe('visa')
        ->and($block['cardNo'])->toBe('4242')
        ->and($block['cardExpiration'])->toBe('0929')
        ->and($block['creditCardToken'])->toBe('AUTH_abc123')
        ->and($block['numberOfPayments'])->toBe('1');
});

it('leaves card fields empty for a Paystack mobile-money payment and uses the receipt as uid', function () {
    $order = Order::factory()->create();

    Payment::factory()->paystackMobileMoney()->successful()->create([
        'order_id' => $order->id,
        'mpesa_receipt' => 'QGH7XY8Z9A',
        'paystack_reference' => 'SHF-2026-00099-ZZZZ',
    ]);

    $block = SapOrderPayload::fromOrder($order)['credit_guard_response'];

    // Mobile money settles against the network receipt, not the gateway ref.
    expect($block['uid'])->toBe('QGH7XY8Z9A')
        ->and($block['cardBrand'])->toBe('')
        ->and($block['cardNo'])->toBe('')
        ->and($block['creditCardToken'])->toBe('')
        ->and($block['numberOfPayments'])->toBe('1');
});

it('fills card fields for a Stripe payment', function () {
    $order = Order::factory()->create();

    Payment::factory()->stripe()->successful()->create([
        'order_id' => $order->id,
        'stripe_payment_intent_id' => 'pi_test_123',
        'stripe_charge_id' => 'ch_test_456',
        'card_brand' => 'mastercard',
        'card_last4' => '4444',
    ]);

    $block = SapOrderPayload::fromOrder($order)['credit_guard_response'];

    expect($block['uid'])->toBe('ch_test_456')
        ->and($block['cgUid'])->toBe('ch_test_456')
        ->and($block['cardBrand'])->toBe('mastercard')
        ->and($block['cardNo'])->toBe('4444')
        ->and($block['creditCardToken'])->toBe('pi_test_123');
});

it('returns an empty payment block when the order has no successful payment', function () {
    $order = Order::factory()->create();

    Payment::factory()->failed()->create(['order_id' => $order->id]);

    $block = SapOrderPayload::fromOrder($order)['credit_guard_response'];

    expect($block['uid'])->toBe('')
        ->and($block['cardBrand'])->toBe('')
        ->and($block['numberOfPayments'])->toBe('0');
});

it('logs the real payment details but masks only the card token in the audit log', function () {
    Http::fake([
        '*/api/invoice/create' => Http::response(['success' => true, 'docEntry' => '5001'], 200),
    ]);

    $order = Order::factory()->create();

    Payment::factory()->paystack()->successful()->create([
        'order_id' => $order->id,
        'paystack_reference' => 'SHF-2026-00042-ABCDEFGH',
        'authorization_code' => 'AUTH_secret123',
        'card_brand' => 'visa',
        'card_last4' => '4242',
    ]);

    app(SapIntegrationService::class)->syncOrder($order->fresh());

    $logged = SapSyncLog::where('order_id', $order->id)
        ->where('operation', 'create_invoice')
        ->firstOrFail()
        ->request_payload['credit_guard_response'];

    // Secrets masked…
    expect($logged['creditCardToken'])->toBe('[redacted]')
        // …but the meaningful, non-sensitive details survive for verification.
        ->and($logged['uid'])->toBe('SHF-2026-00042-ABCDEFGH')
        ->and($logged['cardBrand'])->toBe('visa')
        ->and($logged['cardNo'])->toBe('4242')
        ->and($logged['numberOfPayments'])->toBe('1');

    // And the request actually sent to SAP carries the unmasked token.
    Http::assertSent(fn ($request) => $request['credit_guard_response']['creditCardToken'] === 'AUTH_secret123'
        && $request['order']['Orderid'] === $order->id
        && $request['order']['reference'] === $order->order_number);
});

// ==================================================
// IDEMPOTENT "INVOICE ALREADY CREATED"
// ==================================================

it('treats an "invoice already created" response as an idempotent success', function () {
    Http::fake([
        '*/api/invoice/create' => Http::response(['success' => false, 'message' => 'Invoice already created'], 200),
    ]);

    $order = Order::factory()->create();
    Payment::factory()->successful()->create(['order_id' => $order->id]);

    $result = app(SapIntegrationService::class)->syncOrder($order->fresh());

    expect($result->alreadyExists)->toBeTrue();

    $log = SapSyncLog::where('order_id', $order->id)->where('operation', 'create_invoice')->firstOrFail();
    expect($log->status)->toBe('success')
        ->and($log->error_message)->toBeNull();
});

it('marks AWAITING_CU without failing or alerting when the invoice already exists', function () {
    Notification::fake();
    Queue::fake();

    Http::fake([
        '*/api/invoice/create' => Http::response(['success' => false, 'message' => 'Invoice already created'], 200),
    ]);

    $order = Order::factory()->create(['sap_sync_status' => SapSyncStatus::PENDING]);
    Payment::factory()->successful()->create(['order_id' => $order->id]);

    (new SyncOrderToSapJob($order))->handle(app(SapIntegrationService::class));

    $order->refresh();
    expect($order->sap_sync_status)->toBe(SapSyncStatus::AWAITING_CU)
        ->and($order->sap_sync_error)->toBeNull();

    Notification::assertNothingSent();
    // No docEntry to validate, so the recovery poll is not queued - the webhook
    // remains the path to the CU number.
    Queue::assertNotPushed(RecoverSapInvoiceJob::class);
});

it('stores the docEntry and queues recovery when SAP echoes it on an already-exists response', function () {
    Queue::fake();

    Http::fake([
        '*/api/invoice/create' => Http::response([
            'success' => false,
            'message' => 'Invoice already created',
            'docEntry' => '23394',
        ], 200),
    ]);

    $order = Order::factory()->create(['sap_sync_status' => SapSyncStatus::PENDING]);
    Payment::factory()->successful()->create(['order_id' => $order->id]);

    (new SyncOrderToSapJob($order))->handle(app(SapIntegrationService::class));

    expect($order->fresh()->sap_doc_entry)->toBe('23394');
    Queue::assertPushed(RecoverSapInvoiceJob::class);
});

it('still hard-fails on a genuine SAP error', function () {
    Http::fake([
        '*/api/invoice/create' => Http::response(['success' => false, 'message' => 'G/L account needs DR assignment'], 200),
    ]);

    $order = Order::factory()->create();
    Payment::factory()->successful()->create(['order_id' => $order->id]);

    expect(fn () => app(SapIntegrationService::class)->syncOrder($order->fresh()))
        ->toThrow(SapApiException::class);

    $log = SapSyncLog::where('order_id', $order->id)->where('operation', 'create_invoice')->firstOrFail();
    expect($log->status)->toBe('failed');
});

// ==================================================
// SAP RESYNC COMMAND
// ==================================================

it('sap:resync dispatches a job for a single order by number', function () {
    Queue::fake();

    $order = Order::factory()->create(['sap_sync_status' => SapSyncStatus::FAILED]);

    $this->artisan('sap:resync', ['order' => $order->order_number])
        ->assertSuccessful();

    Queue::assertPushed(SyncOrderToSapJob::class, fn ($job) => $job->order->is($order));
    expect($order->fresh()->sap_sync_status)->toBe(SapSyncStatus::PENDING);
});

it('sap:resync --failed dispatches jobs for all failed orders', function () {
    Queue::fake();

    Order::factory()->count(3)->create(['sap_sync_status' => SapSyncStatus::FAILED]);
    Order::factory()->create(['sap_sync_status' => SapSyncStatus::COMPLETED]);

    $this->artisan('sap:resync', ['--failed' => true])->assertSuccessful();

    Queue::assertPushed(SyncOrderToSapJob::class, 3);
});

it('sap:resync --stuck dispatches jobs for orders stuck over an hour', function () {
    Queue::fake();

    Order::factory()->count(2)->create([
        'sap_sync_status' => SapSyncStatus::SYNCING,
        'updated_at' => now()->subHours(2),
    ]);
    Order::factory()->create([
        'sap_sync_status' => SapSyncStatus::SYNCING,
        'updated_at' => now()->subMinutes(30),
    ]);

    $this->artisan('sap:resync', ['--stuck' => true])->assertSuccessful();

    Queue::assertPushed(SyncOrderToSapJob::class, 2);
});
