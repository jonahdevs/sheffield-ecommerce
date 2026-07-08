<?php

use App\Enums\OrderStatus;
use App\Enums\QuoteStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Quote;
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = actingAsAdmin();
});

it('renders the customer-style status timeline on the admin order page', function () {
    $order = Order::factory()->create(['status' => OrderStatus::PROCESSING]);
    OrderItem::factory()->create(['order_id' => $order->id]);
    $order->recordStatusChange(OrderStatus::PENDING, OrderStatus::PROCESSING, 'Payment confirmed.', $this->admin->id);

    Livewire::test('pages::admin.orders.show', ['order' => $order])
        ->assertSee('Status history')
        ->assertSee('Order Placed')
        ->assertSee('Being Prepared')
        // Staff attribution carried over from the old admin design.
        ->assertSee('by '.$this->admin->name)
        ->assertSee('Payment confirmed.');
});

it('shows the cancelled terminal step on the admin order timeline', function () {
    $order = Order::factory()->create(['status' => OrderStatus::CANCELLED]);
    OrderItem::factory()->create(['order_id' => $order->id]);
    $order->recordStatusChange(OrderStatus::PENDING, OrderStatus::CANCELLED, 'Customer changed their mind.', $this->admin->id);

    Livewire::test('pages::admin.orders.show', ['order' => $order])
        ->assertSee('Order Cancelled')
        ->assertSee('Customer changed their mind.');
});

it('renders a status timeline on the admin quote page', function () {
    $quote = Quote::factory()->create(['status' => QuoteStatus::AWAITING_APPROVAL]);
    $quote->recordStatusChange(QuoteStatus::DRAFT, QuoteStatus::AWAITING_APPROVAL, 'Priced and sent.', $this->admin->id);

    Livewire::test('pages::admin.quotes.show', ['quote' => $quote])
        ->assertSee('Quotation history')
        ->assertSee('Request Submitted')
        ->assertSee('Quotation Ready')
        ->assertSee('by '.$this->admin->name);
});

it('shows the declined terminal step on the admin quote timeline', function () {
    $quote = Quote::factory()->create(['status' => QuoteStatus::DECLINED]);
    $quote->recordStatusChange(QuoteStatus::AWAITING_APPROVAL, QuoteStatus::DECLINED, 'Budget not approved.', $this->admin->id);

    Livewire::test('pages::admin.quotes.show', ['quote' => $quote])
        ->assertSee('Quote Declined')
        ->assertSee('Budget not approved.');
});
