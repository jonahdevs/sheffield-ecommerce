<?php

use App\Models\User;
use App\Settings\MaintenanceSettings;
use Spatie\Permission\Models\Role;

it('serves the storefront normally when maintenance mode is off', function () {
    $this->get(route('home'))->assertOk();
});

it('shows the maintenance page to guests when maintenance mode is on', function () {
    app(MaintenanceSettings::class)->fill([
        'maintenance_mode' => true,
        'maintenance_message' => 'Back online at noon.',
    ])->save();

    $this->get(route('home'))
        ->assertStatus(503)
        ->assertSee('Back online at noon.');
});

it('keeps the login route reachable during maintenance', function () {
    app(MaintenanceSettings::class)->fill([
        'maintenance_mode' => true,
        'maintenance_message' => 'Down for now.',
    ])->save();

    $this->get('/login')->assertOk();
});

it('lets an admin browse the storefront during maintenance', function () {
    app(MaintenanceSettings::class)->fill([
        'maintenance_mode' => true,
        'maintenance_message' => 'Down for now.',
    ])->save();

    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin', 'web'));

    $this->actingAs($admin)->get(route('home'))->assertOk();
});

it('keeps payment webhooks reachable during maintenance', function () {
    app(MaintenanceSettings::class)->fill([
        'maintenance_mode' => true,
        'maintenance_message' => 'Down for now.',
    ])->save();

    // The gateway has already taken the customer's money; a 503 here would lose
    // the callback that marks the order paid. Any non-503 means it reached the
    // controller rather than the maintenance page.
    expect($this->postJson(route('payments.paystack.webhook'), [])->status())->not->toBe(503);
    expect($this->postJson(route('payments.mpesa.callback'), [])->status())->not->toBe(503);
});
