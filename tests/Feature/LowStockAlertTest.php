<?php

use App\Enums\OrderStatus;
use App\Enums\StockStatus;
use App\Events\LowStockDetected;
use App\Listeners\HandleLowStockAlert;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Notifications\Inventory\LowStockAlert;
use App\Settings\InventorySettings;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    Notification::fake();
});

// ── Order path ───────────────────────────────────────────────────────────────

it('decrements product stock when an order is confirmed', function () {
    $product = Product::factory()->create(['stock_quantity' => 10, 'low_stock_threshold' => null]);
    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);
    OrderItem::factory()->forProduct($product)->for($order)->create(['quantity' => 3]);

    $order->markConfirmed();

    expect($product->fresh()->stock_quantity)->toBe(7);
});

it('fires LowStockDetected via observer when order confirmation drops stock to threshold', function () {
    Event::fake([LowStockDetected::class]);

    $product = Product::factory()->create(['stock_quantity' => 5, 'low_stock_threshold' => 5]);
    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);
    OrderItem::factory()->forProduct($product)->for($order)->create(['quantity' => 2]);

    $order->markConfirmed();

    Event::assertDispatched(LowStockDetected::class, function (LowStockDetected $event) use ($product) {
        return $event->product->is($product) && $event->currentQuantity === 3;
    });
});

it('does not fire LowStockDetected when stock remains above threshold', function () {
    Event::fake([LowStockDetected::class]);

    $product = Product::factory()->create(['stock_quantity' => 20, 'low_stock_threshold' => 5]);
    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);
    OrderItem::factory()->forProduct($product)->for($order)->create(['quantity' => 2]);

    $order->markConfirmed();

    Event::assertNotDispatched(LowStockDetected::class);
});

it('does not decrement stock when stock_quantity is untracked', function () {
    $product = Product::factory()->create(['stock_quantity' => null, 'low_stock_threshold' => null]);
    $order = Order::factory()->create(['status' => OrderStatus::PENDING]);
    OrderItem::factory()->forProduct($product)->for($order)->create(['quantity' => 2]);

    $order->markConfirmed();

    expect($product->fresh()->stock_quantity)->toBeNull();
});

// ── Global threshold fallback ─────────────────────────────────────────────────

it('fires LowStockDetected using global threshold when product has none set', function () {
    Event::fake([LowStockDetected::class]);

    app(InventorySettings::class)->fill(['low_stock_threshold' => 5])->save();

    $product = Product::factory()->create(['stock_quantity' => 10, 'low_stock_threshold' => null]);
    $order   = Order::factory()->create(['status' => OrderStatus::PENDING]);
    OrderItem::factory()->forProduct($product)->for($order)->create(['quantity' => 7]);

    $order->markConfirmed();

    Event::assertDispatched(LowStockDetected::class, function (LowStockDetected $event) use ($product) {
        return $event->product->is($product) && $event->currentQuantity === 3;
    });
});

// ── SAP sync path ─────────────────────────────────────────────────────────────

it('fires LowStockDetected via observer when SAP sync sets product stock at or below threshold', function () {
    Event::fake([LowStockDetected::class]);

    $product = Product::factory()->create(['stock_quantity' => 20, 'low_stock_threshold' => 5]);

    $product->update(['stock_quantity' => 3, 'stock_status' => StockStatus::IN_STOCK]);

    Event::assertDispatched(LowStockDetected::class, function (LowStockDetected $event) use ($product) {
        return $event->product->is($product) && $event->currentQuantity === 3;
    });
});

it('fires LowStockDetected via observer when SAP sync sets variant stock at or below product threshold', function () {
    Event::fake([LowStockDetected::class]);

    $product = Product::factory()->create(['low_stock_threshold' => 5]);
    $variant = ProductVariant::factory()->for($product)->create(['stock_quantity' => 20]);

    $variant->update(['stock_quantity' => 2, 'stock_status' => StockStatus::IN_STOCK]);

    Event::assertDispatched(LowStockDetected::class, function (LowStockDetected $event) use ($product) {
        return $event->product->is($product) && $event->currentQuantity === 2;
    });
});

it('does not fire LowStockDetected when SAP sync keeps stock above threshold', function () {
    Event::fake([LowStockDetected::class]);

    $product = Product::factory()->create(['stock_quantity' => 10, 'low_stock_threshold' => 5]);

    $product->update(['stock_quantity' => 8]);

    Event::assertNotDispatched(LowStockDetected::class);
});

// ── Notification delivery ─────────────────────────────────────────────────────

it('sends LowStockAlert to staff with products.view permission', function () {
    $staff = User::factory()->create();
    $staff->givePermissionTo(Permission::firstOrCreate(['name' => 'products.view', 'guard_name' => 'web']));

    $product = Product::factory()->create(['stock_quantity' => 3, 'low_stock_threshold' => 5]);

    $listener = new HandleLowStockAlert;
    $listener->handle(new LowStockDetected($product, 3));

    Notification::assertSentTo($staff, LowStockAlert::class, function (LowStockAlert $n) use ($product) {
        return $n->product->is($product) && $n->currentQuantity === 3;
    });
});
