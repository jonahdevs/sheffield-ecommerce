<?php

use App\Enums\OrderStatus;
use App\Enums\ShipmentStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    actingAsAdmin();
});

it('loads the orders admin index', function () {
    $this->get(route('admin.orders.index'))->assertOk();
});

it('lists orders and filters by status', function () {
    Order::factory()->create(['status' => OrderStatus::PENDING, 'order_number' => 'SHF-AAA']);
    Order::factory()->create(['status' => OrderStatus::COMPLETED, 'order_number' => 'SHF-BBB']);

    Livewire::test('pages::admin.orders.index')
        ->assertSee('SHF-AAA')
        ->assertSee('SHF-BBB')
        ->set('filterStatus', OrderStatus::PENDING->value)
        ->assertSee('SHF-AAA')
        ->assertDontSee('SHF-BBB');
});

it('filters orders by a custom date range', function () {
    $recent = Order::factory()->create(['order_number' => 'SHF-RECENT', 'created_at' => now()->subDays(2)]);
    $old = Order::factory()->create(['order_number' => 'SHF-OLD', 'created_at' => now()->subDays(40)]);

    Livewire::test('pages::admin.orders.index')
        ->assertSee('SHF-RECENT')
        ->assertSee('SHF-OLD')
        ->set('dateFrom', now()->subDays(7)->toDateString())
        ->set('dateTo', now()->toDateString())
        ->call('applyDateRange')
        ->assertHasNoErrors()
        ->assertSee('SHF-RECENT')
        ->assertDontSee('SHF-OLD');
});

it('rejects a date range whose end precedes its start', function () {
    Livewire::test('pages::admin.orders.index')
        ->set('dateFrom', now()->toDateString())
        ->set('dateTo', now()->subDays(5)->toDateString())
        ->call('applyDateRange')
        ->assertHasErrors('dateTo');
});

it('searches orders by order number', function () {
    Order::factory()->create(['order_number' => 'SHF-FINDME']);
    Order::factory()->create(['order_number' => 'SHF-OTHER']);

    Livewire::test('pages::admin.orders.index')
        ->set('search', 'FINDME')
        ->assertSee('SHF-FINDME')
        ->assertDontSee('SHF-OTHER');
});

it('updates an order status from the show page', function () {
    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);
    OrderItem::factory()->create(['order_id' => $order->id]);

    Livewire::test('pages::admin.orders.show', ['order' => $order])
        ->set('status', OrderStatus::COMPLETED->value)
        ->call('updateStatus')
        ->assertHasNoErrors();

    expect($order->fresh()->status)->toBe(OrderStatus::COMPLETED);
});

it('creates a shipment with a human delivery driver', function () {
    $order = Order::factory()->create(['status' => OrderStatus::PROCESSING]);
    OrderItem::factory()->create(['order_id' => $order->id]);

    Livewire::test('pages::admin.orders.show', ['order' => $order])
        ->set('trackingNumber', 'SHF-TRK-001')
        ->set('driverName', 'John Kamau')
        ->set('driverPhone', '0712345678')
        ->call('createShipment')
        ->assertHasNoErrors();

    $shipment = $order->fresh()->shipment;
    expect($shipment->driver_name)->toBe('John Kamau')
        ->and($shipment->driver_phone)->toBe('0712345678')
        ->and($shipment->hasDriver())->toBeTrue();
});

it('shows the delivery driver on the customer tracking page once out for delivery', function () {
    $customer = User::factory()->create();
    $order = Order::factory()->create([
        'user_id' => $customer->id,
        'status' => OrderStatus::OUT_FOR_DELIVERY,
    ]);
    $order->shipment()->create([
        'status' => ShipmentStatus::OUT_FOR_DELIVERY,
        'driver_name' => 'Grace Achieng',
        'driver_phone' => '0798765432',
    ]);

    $this->actingAs($customer)
        ->get(route('account.orders.tracking', $order))
        ->assertOk()
        ->assertSee('Grace Achieng')
        ->assertSee('0798765432');
});

it('forbids a view-only user from mutating an order', function () {
    $viewer = User::factory()->create();
    $viewer->givePermissionTo('orders.view');
    $this->actingAs($viewer);

    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);

    Livewire::test('pages::admin.orders.show', ['order' => $order])
        ->set('status', OrderStatus::COMPLETED->value)
        ->call('updateStatus')
        ->assertForbidden();

    expect($order->fresh()->status)->toBe(OrderStatus::PENDING);
});
