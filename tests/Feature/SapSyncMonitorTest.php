<?php

use App\Enums\SapSyncStatus;
use App\Jobs\SyncOrderToSapJob;
use App\Models\Order;
use App\Models\SapSyncLog;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

beforeEach(function () {
    actingAsAdmin();
});

it('loads the SAP sync monitor page', function () {
    $this->get(route('admin.sap-sync'))->assertOk();
});

it('lists failed and stuck orders on their own tabs', function () {
    $failed = Order::factory()->create(['sap_sync_status' => SapSyncStatus::FAILED, 'sap_sync_error' => 'timeout']);
    $stuck = Order::factory()->create([
        'sap_sync_status' => SapSyncStatus::AWAITING_CU,
        'updated_at' => now()->subHours(3),
    ]);
    Order::factory()->create(['sap_sync_status' => SapSyncStatus::COMPLETED]);

    Livewire::test('pages::admin.sap-sync')
        ->assertCount('failed', 1)
        ->assertCount('stuck', 1)
        ->assertSet('stuckCount', 1)
        // Default tab is "failed": its order shows, the stuck one doesn't.
        ->assertSee($failed->order_number)
        ->assertDontSee($stuck->order_number)
        // Switch to the stuck tab.
        ->set('tab', 'stuck')
        ->assertSee($stuck->order_number)
        ->assertDontSee($failed->order_number);
});

it('paginates the failed-orders tab and respects the per-page selector', function () {
    Order::factory()->count(12)->create(['sap_sync_status' => SapSyncStatus::FAILED]);

    $component = Livewire::test('pages::admin.sap-sync')->set('perPage', 10);

    $component->assertCount('failed', 10); // page size honoured
    expect($component->get('failed')->hasPages())->toBeTrue();

    // Raising the page size shows everything on one page.
    $component->set('perPage', 50)->assertCount('failed', 12);
});

it('does not treat a recently-syncing order as stuck', function () {
    Order::factory()->create([
        'sap_sync_status' => SapSyncStatus::SYNCING,
        'updated_at' => now()->subMinutes(5),
    ]);

    Livewire::test('pages::admin.sap-sync')->assertCount('stuck', 0);
});

it('re-queues a single failed order and resets its sync state', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'sap_sync_status' => SapSyncStatus::FAILED,
        'sap_sync_attempts' => 3,
        'sap_sync_error' => 'boom',
    ]);

    Livewire::test('pages::admin.sap-sync')
        ->call('resync', $order->id);

    $order->refresh();
    expect($order->sap_sync_status)->toBe(SapSyncStatus::PENDING)
        ->and($order->sap_sync_attempts)->toBe(0)
        ->and($order->sap_sync_error)->toBeNull();

    Queue::assertPushed(SyncOrderToSapJob::class);
});

it('re-queues every failed order at once', function () {
    Queue::fake();

    Order::factory()->count(3)->create(['sap_sync_status' => SapSyncStatus::FAILED]);
    Order::factory()->create(['sap_sync_status' => SapSyncStatus::COMPLETED]);

    Livewire::test('pages::admin.sap-sync')->call('resyncAllFailed');

    expect(Order::where('sap_sync_status', SapSyncStatus::PENDING)->count())->toBe(3);
    Queue::assertPushed(SyncOrderToSapJob::class, 3);
});

it('exposes the request and response payload for a sync attempt', function () {
    $order = Order::factory()->create(['sap_sync_status' => SapSyncStatus::FAILED]);
    $log = SapSyncLog::create([
        'order_id' => $order->id,
        'operation' => 'create_invoice',
        'status' => 'failed',
        'endpoint' => '/api/invoices',
        'http_method' => 'POST',
        'request_payload' => ['doc_total' => 1500],
        'response_payload' => ['error' => 'Customer not found'],
        'http_status_code' => 422,
        'error_message' => 'Customer not found',
    ]);

    Livewire::test('pages::admin.sap-sync')
        ->set('tab', 'activity')
        ->call('viewLog', $log->id)
        ->assertSet('selectedLogId', $log->id)
        ->assertSee('doc_total')
        ->assertSee('Customer not found')
        ->assertSee('/api/invoices');
});

it('opens the latest log for a failed order from the failed tab', function () {
    $order = Order::factory()->create(['sap_sync_status' => SapSyncStatus::FAILED]);
    SapSyncLog::create([
        'order_id' => $order->id,
        'operation' => 'create_invoice',
        'status' => 'failed',
        'response_payload' => ['error' => 'stale attempt'],
    ]);
    $latest = SapSyncLog::create([
        'order_id' => $order->id,
        'operation' => 'create_invoice',
        'status' => 'failed',
        'response_payload' => ['error' => 'latest attempt'],
    ]);

    Livewire::test('pages::admin.sap-sync')
        ->call('viewOrderLog', $order->id)
        ->assertSet('selectedLogId', $latest->id)
        ->assertSee('latest attempt');
});

it('forbids a view-only user from resyncing', function () {
    $viewer = User::factory()->create();
    $viewer->givePermissionTo('orders.view');
    $this->actingAs($viewer);

    $order = Order::factory()->create(['sap_sync_status' => SapSyncStatus::FAILED]);

    Livewire::test('pages::admin.sap-sync')
        ->call('resync', $order->id)
        ->assertForbidden();
});
