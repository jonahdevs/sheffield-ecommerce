<?php

use App\Enums\OrderStatus;
use App\Events\OrderPlaced;
use App\Events\OrderUpdated;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('broadcasts OrderUpdated when the status changes', function () {
    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);

    Event::fake([OrderUpdated::class]);

    $order->update(['status' => OrderStatus::OUT_FOR_DELIVERY]);

    Event::assertDispatched(OrderUpdated::class, fn (OrderUpdated $event) => $event->order->is($order));
});

it('broadcasts OrderUpdated when the KRA receipt is stored', function () {
    $order = Order::factory()->create();

    Event::fake([OrderUpdated::class]);

    $order->update(['receipt_path' => 'kra-receipts/test-receipt.pdf']);

    Event::assertDispatched(OrderUpdated::class);
});

it('does not broadcast OrderUpdated for unrelated changes', function () {
    $order = Order::factory()->create();

    Event::fake([OrderUpdated::class]);

    $order->update(['staff_notes' => 'internal note']);

    Event::assertNotDispatched(OrderUpdated::class);
});

it('broadcasts OrderUpdated when a pending order is confirmed', function () {
    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);

    Event::fake([OrderUpdated::class, OrderPlaced::class]);
    Notification::fake();

    $order->markConfirmed();

    Event::assertDispatched(OrderUpdated::class, fn (OrderUpdated $event) => $event->order->is($order));
});

it('refreshes the customer order page when OrderUpdated is received', function () {
    $user = User::factory()->create();
    $order = Order::factory()->for($user)->create(['status' => OrderStatus::PENDING]);

    $component = Livewire::actingAs($user)->test('pages::account.orders.show', ['order' => $order])
        ->assertSee(OrderStatus::PENDING->label());

    Order::withoutEvents(fn () => $order->update(['status' => OrderStatus::OUT_FOR_DELIVERY]));

    $component->dispatch('echo-private:orders.'.$order->id.',OrderUpdated')
        ->assertSee(OrderStatus::OUT_FOR_DELIVERY->label());
});

it('shows the invoice button on the customer order page after the receipt event', function () {
    Storage::fake('local');
    $user = User::factory()->create();
    $order = Order::factory()->for($user)->create(['receipt_path' => null]);

    $component = Livewire::actingAs($user)->test('pages::account.orders.show', ['order' => $order])
        ->assertDontSee('Download Invoice');

    Storage::disk('local')->put('kra-receipts/receipt.pdf', 'pdf');
    Order::withoutEvents(fn () => $order->update(['receipt_path' => 'kra-receipts/receipt.pdf']));

    $component->dispatch('echo-private:orders.'.$order->id.',OrderUpdated')
        ->assertSee('Download Invoice');
});

it('refreshes the admin order page when OrderUpdated is received', function () {
    actingAsAdmin();

    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);

    $component = Livewire::test('pages::admin.orders.show', ['order' => $order]);

    Order::withoutEvents(fn () => $order->update(['status' => OrderStatus::OUT_FOR_DELIVERY, 'cu_number' => 'CU-123']));

    $component->dispatch('echo-private:orders.'.$order->id.',OrderUpdated')
        ->assertSee(OrderStatus::OUT_FOR_DELIVERY->label())
        ->assertSet('status', OrderStatus::OUT_FOR_DELIVERY->value);
});
