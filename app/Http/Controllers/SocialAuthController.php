<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Settings\IntegrationSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Supported providers mapped to the settings flag that enables them and the
     * users column holding their provider id.
     *
     * @var array<string, array{flag: string, column: string, label: string}>
     */
    private const PROVIDERS = [
        'google' => ['flag' => 'google_login_enabled', 'column' => 'google_id', 'label' => 'Google'],
        'facebook' => ['flag' => 'facebook_login_enabled', 'column' => 'facebook_id', 'label' => 'Facebook'],
    ];

    public function redirectToGoogle(IntegrationSettings $settings): RedirectResponse
    {
        return $this->redirectToProvider('google', $settings);
    }

    public function handleGoogleCallback(IntegrationSettings $settings): RedirectResponse
    {
        return $this->handleProviderCallback('google', $settings);
    }

    public function redirectToFacebook(IntegrationSettings $settings): RedirectResponse
    {
        return $this->redirectToProvider('facebook', $settings);
    }

    public function handleFacebookCallback(IntegrationSettings $settings): RedirectResponse
    {
        return $this->handleProviderCallback('facebook', $settings);
    }

    /**
     * Send the user to the provider, 404ing when an admin has disabled it.
     */
    private function redirectToProvider(string $provider, IntegrationSettings $settings): RedirectResponse
    {
        abort_unless($settings->{self::PROVIDERS[$provider]['flag']}, 404);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Sign the user in from the provider's callback, creating the account on
     * first use and linking it to an existing one by email.
     */
    private function handleProviderCallback(string $provider, IntegrationSettings $settings): RedirectResponse
    {
        ['flag' => $flag, 'column' => $column, 'label' => $label] = self::PROVIDERS[$provider];

        abort_unless($settings->{$flag}, 404);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception) {
            return redirect()->route('login')->withErrors(['email' => $label.' sign-in failed. Please try again.']);
        }

        // Find by provider id first, then fall back to email (links existing accounts).
        $user = User::firstWhere($column, $socialUser->getId())
            ?? User::firstWhere('email', $socialUser->getEmail());

        if ($user) {
            $user->fill([
                $column => $socialUser->getId(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        } else {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                $column => $socialUser->getId(),
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'));
    }
}
