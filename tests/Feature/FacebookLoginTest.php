<?php

use App\Models\User;
use App\Settings\IntegrationSettings;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Two\User as SocialiteUser;

function makeFacebookSocialiteUser(string $id, string $name, string $email): SocialiteUser
{
    $socialiteUser = new SocialiteUser;
    $socialiteUser->id = $id;
    $socialiteUser->name = $name;
    $socialiteUser->email = $email;

    return $socialiteUser;
}

function mockFacebookDriver(SocialiteUser $socialiteUser): void
{
    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('redirect')->andReturn(redirect('/fake-fb-redirect'));
    $provider->shouldReceive('user')->andReturn($socialiteUser);

    $factory = Mockery::mock(SocialiteFactory::class);
    $factory->shouldReceive('driver')->with('facebook')->andReturn($provider);

    app()->instance(SocialiteFactory::class, $factory);
}

beforeEach(function () {
    app(IntegrationSettings::class)->fill(['facebook_login_enabled' => true])->save();
});

test('facebook redirect aborts when facebook login is disabled', function () {
    app(IntegrationSettings::class)->fill(['facebook_login_enabled' => false])->save();

    $this->get(route('auth.facebook.redirect'))->assertNotFound();
});

test('facebook redirect returns redirect when enabled', function () {
    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('redirect')->andReturn(redirect('/fake-fb-redirect'));

    $factory = Mockery::mock(SocialiteFactory::class);
    $factory->shouldReceive('driver')->with('facebook')->andReturn($provider);
    app()->instance(SocialiteFactory::class, $factory);

    $this->get(route('auth.facebook.redirect'))->assertRedirect();
});

test('facebook callback creates new user', function () {
    $fbUser = makeFacebookSocialiteUser('fb-123', 'Jane Doe', 'jane@example.com');
    mockFacebookDriver($fbUser);

    $this->get(route('auth.facebook.callback'))->assertRedirect();

    $this->assertDatabaseHas('users', [
        'email' => 'jane@example.com',
        'facebook_id' => 'fb-123',
    ]);
});

test('facebook callback links existing user by email', function () {
    $user = User::factory()->create(['email' => 'existing@example.com', 'facebook_id' => null]);
    $fbUser = makeFacebookSocialiteUser('fb-456', 'Existing User', 'existing@example.com');
    mockFacebookDriver($fbUser);

    $this->get(route('auth.facebook.callback'))->assertRedirect();

    $user->refresh();
    expect($user->facebook_id)->toBe('fb-456');
});

test('facebook callback finds user by facebook_id', function () {
    $user = User::factory()->create(['facebook_id' => 'fb-789']);
    $fbUser = makeFacebookSocialiteUser('fb-789', $user->name, $user->email);
    mockFacebookDriver($fbUser);

    $this->get(route('auth.facebook.callback'))->assertRedirect();

    $this->assertAuthenticatedAs($user);
});

test('facebook callback redirects with error on socialite exception', function () {
    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('user')->andThrow(new Exception('OAuth error'));

    $factory = Mockery::mock(SocialiteFactory::class);
    $factory->shouldReceive('driver')->with('facebook')->andReturn($provider);
    app()->instance(SocialiteFactory::class, $factory);

    $this->get(route('auth.facebook.callback'))
        ->assertRedirect(route('login'));
});

test('facebook callback aborts when facebook login is disabled', function () {
    app(IntegrationSettings::class)->fill(['facebook_login_enabled' => false])->save();

    $this->get(route('auth.facebook.callback'))->assertNotFound();
});
