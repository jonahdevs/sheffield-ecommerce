<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\Orders\RefundProcessed;
use App\Services\RefundService;
use Database\Seeders\PermissionSeeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

/** Fakes the Paystack refund endpoint accepting every reversal. */
function fakePaystackRefundAccepted(): void
{
    Http::fake(['https://api.paystack.co/refund' => Http::response(['status' => true, 'message' => 'Refund has been queued'])]);
}

/** A settled payment of the given amount against a fresh customer's order. */
function settledPayment(string $provider, int $amountCents, OrderStatus $orderStatus = OrderStatus::PROCESSING): Payment
{
    $user = User::factory()->create();
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'status' => $orderStatus,
        'total_cents' => $amountCents,
    ]);

    return Payment::factory()
        ->when($provider === 'paystack', fn ($f) => $f->paystack())
        ->successful()
        ->create([
            'order_id' => $order->id,
            'provider' => $provider,
            'amount_cents' => $amountCents,
        ]);
}

it('fully refunds a paystack payment through the gateway and notifies the customer', function () {
    Notification::fake();
    fakePaystackRefundAccepted();

    $payment = settledPayment('paystack', 500000);

    app(RefundService::class)->refund($payment, 500000, 'Customer returned the unit');

    $payment->refresh();
    $order = $payment->order;

    expect($payment->status)->toBe(PaymentStatus::REFUNDED)
        ->and($payment->refund_cents)->toBe(500000)
        ->and($payment->refunded_at)->not->toBeNull()
        ->and($order->status)->toBe(OrderStatus::REFUNDED)
        ->and($order->statusHistories()->where('to_status', 'refunded')->exists())->toBeTrue();

    Notification::assertSentTo($order->user, RefundProcessed::class);
    Http::assertSent(fn ($request) => str_contains($request->url(), '/refund') && $request['amount'] === 500000);
});

it('does not record a paystack refund when the gateway rejects it', function () {
    Http::fake(['https://api.paystack.co/refund' => Http::response(['status' => false, 'message' => 'Transaction not refundable'], 400)]);

    $payment = settledPayment('paystack', 500000);

    expect(fn () => app(RefundService::class)->refund($payment, 500000))
        ->toThrow(RuntimeException::class);

    expect($payment->fresh()->status)->toBe(PaymentStatus::SUCCESS)
        ->and((int) $payment->fresh()->refund_cents)->toBe(0);
});

it('records a partial refund without closing the order, then completes it on the balance', function () {
    Notification::fake();
    fakePaystackRefundAccepted();

    $payment = settledPayment('paystack', 500000);

    app(RefundService::class)->refund($payment, 200000);

    expect($payment->fresh()->status)->toBe(PaymentStatus::SUCCESS)
        ->and($payment->fresh()->refund_cents)->toBe(200000)
        ->and($payment->order->fresh()->status)->toBe(OrderStatus::PROCESSING);

    app(RefundService::class)->refund($payment->fresh(), 300000);

    expect($payment->fresh()->status)->toBe(PaymentStatus::REFUNDED)
        ->and($payment->fresh()->refund_cents)->toBe(500000)
        ->and($payment->order->fresh()->status)->toBe(OrderStatus::REFUNDED);

    Http::assertSentCount(2);
});

it('rejects a refund larger than the remaining amount', function () {
    fakePaystackRefundAccepted();

    $payment = settledPayment('paystack', 100000);

    expect(fn () => app(RefundService::class)->refund($payment, 150000))
        ->toThrow(InvalidArgumentException::class);

    expect($payment->fresh()->status)->toBe(PaymentStatus::SUCCESS)
        ->and((int) $payment->fresh()->refund_cents)->toBe(0);

    Http::assertNothingSent();
});

it('rejects refunding a payment that has not settled', function () {
    fakePaystackRefundAccepted();

    $payment = settledPayment('paystack', 100000);
    $payment->update(['status' => PaymentStatus::PENDING]);

    expect(fn () => app(RefundService::class)->refund($payment, 100000))
        ->toThrow(InvalidArgumentException::class);

    Http::assertNothingSent();
});

it('records an mpesa refund without a gateway call and notifies the customer', function () {
    Notification::fake();
    Http::fake();

    $payment = settledPayment('mpesa', 300000, OrderStatus::COMPLETED);

    app(RefundService::class)->refund($payment, 300000, 'Out of stock');

    expect($payment->fresh()->status)->toBe(PaymentStatus::REFUNDED)
        ->and($payment->order->fresh()->status)->toBe(OrderStatus::REFUNDED);

    Notification::assertSentTo($payment->order->user, RefundProcessed::class);
    Http::assertNothingSent();
});

it('lets an admin issue a refund from the payment page', function () {
    Notification::fake();
    actingAsAdmin();
    fakePaystackRefundAccepted();

    $payment = settledPayment('paystack', 500000);

    Livewire::test('pages::admin.payments.show', ['payment' => $payment])
        ->set('refundAmount', '5000.00')
        ->call('refund')
        ->assertHasNoErrors();

    expect($payment->fresh()->status)->toBe(PaymentStatus::REFUNDED)
        ->and($payment->order->fresh()->status)->toBe(OrderStatus::REFUNDED);
});

it('normalises a currency-formatted refund amount from the masked input', function () {
    Notification::fake();
    actingAsAdmin();
    fakePaystackRefundAccepted();

    $payment = settledPayment('paystack', 500000);

    // The mask shows thousand separators; the value submitted must still resolve
    // to the correct cents amount (5,000.00 → 500,000 cents).
    Livewire::test('pages::admin.payments.show', ['payment' => $payment])
        ->set('refundAmount', '5,000.00')
        ->call('refund')
        ->assertHasNoErrors();

    expect($payment->fresh()->refund_cents)->toBe(500000)
        ->and($payment->fresh()->status)->toBe(PaymentStatus::REFUNDED);
});

it('forbids a view-only staff member from issuing a refund', function () {
    $this->seed(PermissionSeeder::class);
    $viewer = User::factory()->create();
    $viewer->givePermissionTo('payments.view');
    $this->actingAs($viewer);

    Http::fake();

    $payment = settledPayment('paystack', 500000);

    Livewire::test('pages::admin.payments.show', ['payment' => $payment])
        ->set('refundAmount', '5000.00')
        ->call('refund')
        ->assertForbidden();

    expect($payment->fresh()->status)->toBe(PaymentStatus::SUCCESS);
    Http::assertNothingSent();
});
