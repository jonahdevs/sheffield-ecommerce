<?php

use App\Models\Order;
use App\Models\User;

it('renders the shared confirm dialog in the admin layout', function () {
    actingAsAdmin();

    $this->get(route('admin.staff.index'))
        ->assertOk()
        ->assertSee('data-confirm-dialog', false)
        ->assertSee('confirmDialog.proceed', false);
});

it('renders the shared confirm dialog in the storefront layout', function () {
    $user = User::factory()->create();
    $order = Order::factory()->for($user)->create();

    $this->actingAs($user)
        ->get(route('account.orders.show', $order))
        ->assertOk()
        ->assertSee('data-confirm-dialog', false);
});
