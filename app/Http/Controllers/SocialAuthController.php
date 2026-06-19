<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Settings\IntegrationSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle(IntegrationSettings $settings): RedirectResponse
    {
        abort_unless($settings->google_login_enabled, 404);

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(IntegrationSettings $settings): RedirectResponse
    {
        abort_unless($settings->google_login_enabled, 404);

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception) {
            return redirect()->route('login')->withErrors(['email' => 'Google sign-in failed. Please try again.']);
        }

        // Find by google_id first, then fall back to email (links existing accounts).
        $user = User::firstWhere('google_id', $googleUser->getId())
            ?? User::firstWhere('email', $googleUser->getEmail());

        if ($user) {
            $user->fill([
                'google_id' => $googleUser->getId(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'));
    }

    public function redirectToFacebook(IntegrationSettings $settings): RedirectResponse
    {
        abort_unless($settings->facebook_login_enabled, 404);

        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(IntegrationSettings $settings): RedirectResponse
    {
        abort_unless($settings->facebook_login_enabled, 404);

        try {
            $fbUser = Socialite::driver('facebook')->user();
        } catch (\Exception) {
            return redirect()->route('login')->withErrors(['email' => 'Facebook sign-in failed. Please try again.']);
        }

        // Find by facebook_id first, then fall back to email (links existing accounts).
        $user = User::firstWhere('facebook_id', $fbUser->getId())
            ?? User::firstWhere('email', $fbUser->getEmail());

        if ($user) {
            $user->fill([
                'facebook_id' => $fbUser->getId(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        } else {
            $user = User::create([
                'name' => $fbUser->getName(),
                'email' => $fbUser->getEmail(),
                'facebook_id' => $fbUser->getId(),
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'));
    }
}
