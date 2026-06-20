<?php

use App\Models\User;

it('logs out a banned user and redirects to login without looping', function () {
    $user = User::factory()->create(['banned_at' => now()]);

    $this->actingAs($user)
        ->get(route('home'))
        ->assertRedirect(route('login'));

    // The session must be torn down, otherwise the next request would hit the
    // same middleware and redirect again (ERR_TOO_MANY_REDIRECTS).
    $this->assertGuest();
});

it('shows a blocked message on the login page after a ban redirect', function () {
    $user = User::factory()->create(['banned_at' => now()]);

    $this->actingAs($user)
        ->followingRedirects()
        ->get(route('home'))
        ->assertOk()
        ->assertSee('blocked');
});

it('lets an unbanned user browse normally', function () {
    $user = User::factory()->create(['banned_at' => null]);

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk();

    $this->assertAuthenticated();
});
