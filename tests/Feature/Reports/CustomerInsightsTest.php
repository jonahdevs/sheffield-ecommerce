<?php

use App\Models\Order;
use App\Models\User;

use function Pest\Laravel\actingAs;

// ─── Setup ────────────────────────────────────────────────────────────────────

beforeEach(function () {
    $this->admin = User::factory()->create(['is_staff' => true, 'email_verified_at' => now()]);
});

// ─── Access ───────────────────────────────────────────────────────────────────

test('guests are redirected to login', function () {
    $this->get(route('admin.reports.customers'))->assertRedirect(route('login'));
});

test('authenticated admins can view the page', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('Customer Insights');
});

// ─── KPI section ─────────────────────────────────────────────────────────────

it('shows total customer count in KPI section', function () {
    actingAs($this->admin);

    User::factory()->count(4)->create(['is_staff' => false]);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('Total Customers');
});

it('shows new customers registered in the period', function () {
    actingAs($this->admin);

    User::factory()->count(2)->create(['is_staff' => false, 'created_at' => now()]);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('New in Period');
});

it('shows average lifetime spend in KPI section', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('Avg Lifetime Spend');
});

it('shows at-risk customers KPI card', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('At-Risk Customers');
});

// ─── Acquisition trend ───────────────────────────────────────────────────────

it('renders the acquisition trend section', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('New Customer Acquisition');
});

// ─── Spend tiers ─────────────────────────────────────────────────────────────

it('renders the spend tiers section with tier labels', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('Customer Value Segments')
        ->assertSee('High Value')
        ->assertSee('Regular')
        ->assertSee('Low Value')
        ->assertSee('One-time');
});

// ─── Top spenders ────────────────────────────────────────────────────────────

it('renders the top spenders table', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('Top Spenders');
});

it('shows customer name in top spenders when paid orders exist', function () {
    actingAs($this->admin);

    $customer = User::factory()->create(['is_staff' => false, 'name' => 'Jane Spender']);
    Order::factory()->paid()->create(['user_id' => $customer->id, 'total_cents' => 500_000, 'created_at' => now()]);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('Jane Spender');
});

it('shows empty state in top spenders when no paid orders exist', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('No paying customers yet');
});

it('shows the export CSV button when top spenders exist', function () {
    actingAs($this->admin);

    $customer = User::factory()->create(['is_staff' => false]);
    Order::factory()->paid()->create(['user_id' => $customer->id, 'total_cents' => 100_000, 'created_at' => now()]);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('Export CSV');
});

// ─── At-risk customers ────────────────────────────────────────────────────────

it('shows a customer who has not ordered recently as at-risk', function () {
    actingAs($this->admin);

    $customer = User::factory()->create(['is_staff' => false, 'name' => 'Old Buyer']);
    Order::factory()->paid()->create([
        'user_id'    => $customer->id,
        'created_at' => now()->subDays(120),
    ]);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('Old Buyer');
});

it('shows empty state in at-risk section when no at-risk customers exist', function () {
    actingAs($this->admin);

    $this->get(route('admin.reports.customers'))
        ->assertOk()
        ->assertSee('No at-risk customers');
});
