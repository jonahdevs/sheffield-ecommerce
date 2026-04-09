<?php

use App\Models\Order;
use App\Models\Quote;
use App\Models\User;

use function Pest\Laravel\actingAs;

// ─── Setup ────────────────────────────────────────────────────────────────────

beforeEach(function () {
    $this->admin = User::factory()->create(['is_staff' => true, 'email_verified_at' => now()]);
});

// ─── Access ───────────────────────────────────────────────────────────────────

test('guests are redirected to login', function () {
    $this->get(route('admin.reports.overview'))->assertRedirect(route('login'));
});

test('authenticated admins can view the page', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('Business Overview');
});

// ─── KPI section ─────────────────────────────────────────────────────────────

it('shows paid revenue in the KPI section', function () {
    actingAs($this->admin);

    Order::factory()->paid()->create(['total_cents' => 100_000, 'created_at' => now()]);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('KES 1,000.00');
});

it('does not include unpaid orders in the revenue KPI', function () {
    actingAs($this->admin);

    // Only unpaid orders — revenue KPI should be 0
    Order::factory()->pending()->create(['total_cents' => 50_000, 'created_at' => now()]);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('KES 0.00');
});

it('shows new customer count in the KPI section', function () {
    actingAs($this->admin);

    User::factory()->count(3)->create(['is_staff' => false, 'created_at' => now()]);

    $this->get(route('admin.reports.overview'))->assertOk()->assertSee('New Customers');
});

// ─── Fulfillment funnel ───────────────────────────────────────────────────────

it('renders the fulfillment funnel section with stage labels', function () {
    actingAs($this->admin);

    Order::factory()->delivered()->create(['created_at' => now()]);
    Order::factory()->shipped()->create(['created_at' => now()]);
    Order::factory()->cancelled()->create(['created_at' => now()]);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('Order Fulfillment Funnel')
        ->assertSee('Delivered')
        ->assertSee('Shipped')
        ->assertSee('Lost (Cancelled + Returned)');
});

it('shows the delivered percentage badge in the funnel header', function () {
    actingAs($this->admin);

    Order::factory()->delivered()->create(['created_at' => now()]);
    Order::factory()->delivered()->create(['created_at' => now()]);
    Order::factory()->pending()->create(['created_at' => now()]);
    Order::factory()->pending()->create(['created_at' => now()]);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('50%')
        ->assertSee('delivered');
});

it('shows empty state when no orders exist in the funnel', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('No orders in this period');
});

// ─── B2B vs B2C ───────────────────────────────────────────────────────────────

it('renders the B2B vs B2C split section', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('B2B')
        ->assertSee('B2C');
});

it('shows B2B revenue for quote-converted paid orders', function () {
    actingAs($this->admin);

    $quote = Quote::factory()->create();
    Order::factory()->paid()->create(['quote_id' => $quote->id, 'total_cents' => 200_000, 'created_at' => now()]);
    Order::factory()->paid()->create(['quote_id' => null,       'total_cents' => 300_000, 'created_at' => now()]);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('KES 2,000.00') // B2B revenue
        ->assertSee('KES 3,000.00'); // B2C revenue
});

it('shows empty state in B2B/B2C section when no paid orders exist', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('No paid orders in this period');
});

// ─── Monthly breakdown table ──────────────────────────────────────────────────

it('renders the monthly breakdown table', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('Monthly Breakdown')
        ->assertSee(now()->format('M Y'));
});

it('shows correct revenue per month in the breakdown table', function () {
    actingAs($this->admin);

    Order::factory()->paid()->create(['total_cents' => 500_000, 'created_at' => now()->startOfYear()]);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('KES 5,000.00');
});

it('shows the totals row when multiple months have data', function () {
    actingAs($this->admin);

    Order::factory()->paid()->create(['total_cents' => 100_000, 'created_at' => now()->startOfYear()]);
    Order::factory()->paid()->create(['total_cents' => 200_000, 'created_at' => now()->startOfYear()->addMonths(1)]);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('Total');
});

// ─── Revenue by zone ─────────────────────────────────────────────────────────

it('renders the revenue by shipping zone section', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('Revenue by Shipping Zone');
});

// ─── Export button ────────────────────────────────────────────────────────────

it('shows the export CSV button', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.overview'))
        ->assertOk()
        ->assertSee('Export CSV');
});
