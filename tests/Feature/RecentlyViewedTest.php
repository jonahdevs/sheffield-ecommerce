<?php

use App\Models\Product;
use App\Models\RecentlyViewed;
use App\Models\User;

it('renders the recently viewed page with the viewed product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['name' => 'Blast Chiller 500L']);

    RecentlyViewed::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'viewed_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('account.recently-viewed'))
        ->assertOk()
        ->assertSee('Blast Chiller 500L');
});

it('shows the empty state when nothing has been viewed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('account.recently-viewed'))
        ->assertOk()
        ->assertSee('Nothing here yet');
});
