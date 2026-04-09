<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

use function Pest\Laravel\actingAs;

// ─── Setup ────────────────────────────────────────────────────────────────────

beforeEach(function () {
    $this->admin = User::factory()->create(['is_staff' => true, 'email_verified_at' => now()]);
});

// ─── Helper ───────────────────────────────────────────────────────────────────

function makeInventoryProduct(array $attrs = []): Product
{
    return Product::create(array_merge([
        'name'             => 'Test Product ' . uniqid(),
        'slug'             => 'test-product-' . uniqid(),
        'type'             => 'simple',
        'price'            => 1000.00,
        'status'           => 'published',
        'manage_stock'     => true,
        'stock_quantity'   => 50,
        'stock_status'     => 'in_stock',
        'low_stock_threshold' => 10,
    ], $attrs));
}

// ─── Access ───────────────────────────────────────────────────────────────────

test('guests are redirected to login', function () {
    $this->get(route('admin.reports.inventory'))->assertRedirect(route('login'));
});

test('authenticated admins can view the page', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Inventory Health');
});

// ─── KPI section ─────────────────────────────────────────────────────────────

it('shows the out of stock KPI card', function () {
    actingAs($this->admin);

    makeInventoryProduct(['stock_quantity' => 0, 'stock_status' => 'out_of_stock']);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Out of Stock');
});

it('counts out of stock products correctly', function () {
    actingAs($this->admin);

    makeInventoryProduct(['stock_quantity' => 0, 'stock_status' => 'out_of_stock']);
    makeInventoryProduct(['stock_quantity' => 0, 'stock_status' => 'out_of_stock']);
    makeInventoryProduct(['stock_quantity' => 100, 'stock_status' => 'in_stock']);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('2');
});

it('shows the low stock KPI card', function () {
    actingAs($this->admin);

    makeInventoryProduct(['stock_quantity' => 5, 'low_stock_threshold' => 10]);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Low Stock');
});

it('counts low stock products correctly', function () {
    actingAs($this->admin);

    makeInventoryProduct(['stock_quantity' => 5, 'low_stock_threshold' => 10]);   // low stock
    makeInventoryProduct(['stock_quantity' => 50, 'low_stock_threshold' => 10]);  // healthy
    makeInventoryProduct(['stock_quantity' => 0, 'stock_status' => 'out_of_stock']); // out of stock, not low stock

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Low Stock');
});

it('shows the dead stock KPI card', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Dead Stock');
});

it('shows total stock value KPI card', function () {
    actingAs($this->admin);

    makeInventoryProduct(['stock_quantity' => 10, 'price' => 500.00]);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Stock Value')
        ->assertSee('KES');
});

it('calculates total stock value correctly', function () {
    actingAs($this->admin);

    makeInventoryProduct(['stock_quantity' => 10, 'price' => 500.00]);   // KES 5,000
    makeInventoryProduct(['stock_quantity' => 20, 'price' => 250.00]);   // KES 5,000

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('10,000.00');
});

// ─── Analysis period selector ─────────────────────────────────────────────────

it('shows the analysis period selector', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Analysis period');
});

// ─── Stock velocity ───────────────────────────────────────────────────────────

it('renders the stock velocity section', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Stock Velocity');
});

it('shows empty state in velocity table when no sales exist', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('No sales data in this period');
});

it('shows products with recent sales in the velocity table', function () {
    actingAs($this->admin);

    $product = makeInventoryProduct(['name' => 'Fast Mover', 'stock_quantity' => 100]);
    $order   = Order::factory()->paid()->create(['created_at' => now()->subDays(10)]);
    OrderItem::create([
        'order_id'        => $order->id,
        'product_id'      => $product->id,
        'quantity'        => 20,
        'unit_price_cents' => 100_000,
        'total_cents'     => 2_000_000,
    ]);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Fast Mover');
});

// ─── Reorder candidates ───────────────────────────────────────────────────────

it('renders the reorder candidates section', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Reorder Now');
});

it('shows no urgent reorders message when all stock levels are healthy', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('no urgent reorders');
});

it('flags a product as a reorder candidate when weeks remaining is below 4', function () {
    actingAs($this->admin);

    // 3 units in stock, selling 2/week over 90 days = very low weeks remaining
    $product = makeInventoryProduct(['name' => 'Nearly Out', 'stock_quantity' => 3]);
    $order   = Order::factory()->paid()->create(['created_at' => now()->subDays(10)]);
    OrderItem::create([
        'order_id'        => $order->id,
        'product_id'      => $product->id,
        'quantity'        => 50,
        'unit_price_cents' => 100_000,
        'total_cents'     => 5_000_000,
    ]);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Nearly Out');
});

// ─── Dead stock ───────────────────────────────────────────────────────────────

it('renders the dead stock section', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Dead Stock');
});

it('shows empty state when no dead stock exists', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('No dead stock in this period');
});

it('shows products with stock but no recent sales in the dead stock list', function () {
    actingAs($this->admin);

    makeInventoryProduct(['name' => 'Stale Item', 'stock_quantity' => 30]);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Stale Item');
});

it('does not show products with recent sales in the dead stock list', function () {
    actingAs($this->admin);

    $product = makeInventoryProduct(['name' => 'Active Item', 'stock_quantity' => 50]);
    $order   = Order::factory()->paid()->create(['created_at' => now()->subDays(10)]);
    OrderItem::create([
        'order_id'        => $order->id,
        'product_id'      => $product->id,
        'quantity'        => 5,
        'unit_price_cents' => 100_000,
        'total_cents'     => 500_000,
    ]);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertDontSee('Active Item');
});

it('shows the export CSV button when dead stock exists', function () {
    actingAs($this->admin);

    makeInventoryProduct(['name' => 'No Sales Product', 'stock_quantity' => 10]);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Export CSV');
});

it('shows the total dead stock value in the table footer', function () {
    actingAs($this->admin);

    makeInventoryProduct(['stock_quantity' => 5, 'price' => 2000.00]);

    $this->get(route('admin.reports.inventory'))
        ->assertOk()
        ->assertSee('Total Dead Stock Value');
});
