<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    Route::get('/_test/403', fn () => abort(403))->middleware('web');
    Route::get('/_test/401', fn () => abort(401))->middleware('web');
    Route::get('/_test/429', fn () => abort(429))->middleware('web');
    Route::get('/_test/500', fn () => abort(500))->middleware('web');
});

it('renders a 404 page for unknown routes', function () {
    $this->get('/this-route-does-not-exist-xyz-123')
        ->assertNotFound()
        ->assertSee('404')
        ->assertSee('Page not found');
});

it('renders a 403 page for forbidden access', function () {
    $this->get('/_test/403')
        ->assertForbidden()
        ->assertSee('403')
        ->assertSee('Access denied');
});

it('renders a 401 page for unauthenticated access', function () {
    $this->get('/_test/401')
        ->assertUnauthorized()
        ->assertSee('401')
        ->assertSee('Authentication required');
});

it('renders a 429 page for rate limiting', function () {
    $this->get('/_test/429')
        ->assertStatus(429)
        ->assertSee('429')
        ->assertSee('Too many requests');
});

it('renders a 500 page for server errors', function () {
    $this->get('/_test/500')
        ->assertStatus(500)
        ->assertSee('500')
        ->assertSee('Something went wrong');
});

it('shows back to dashboard button for admin users on 403', function () {
    $admin = User::factory()->create(['is_staff' => true]);

    $this->actingAs($admin)
        ->get('/_test/403')
        ->assertForbidden()
        ->assertSee('Back to dashboard');
});

it('shows back to homepage button for guest users on 403', function () {
    $this->get('/_test/403')
        ->assertForbidden()
        ->assertSee('Back to homepage');
});

it('419 view renders session expired content', function () {
    $rendered = view('errors.419')->render();

    expect($rendered)
        ->toContain('419')
        ->toContain('Session expired')
        ->toContain('Refresh page');
});

it('503 view renders maintenance content without database', function () {
    $rendered = view('errors.503')->render();

    expect($rendered)
        ->toContain('503')
        ->toContain('Under maintenance')
        ->toContain('Contact support');
});
