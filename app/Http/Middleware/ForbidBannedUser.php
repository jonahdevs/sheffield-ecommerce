<?php

namespace App\Http\Middleware;

use Closure;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Blocks banned users from the application. Unlike the package middleware, this
 * logs the banned user out before redirecting, so the next request is no longer
 * authenticated and cannot re-trigger the block - otherwise every redirect
 * target runs this middleware again and the browser loops (ERR_TOO_MANY_REDIRECTS).
 */
class ForbidBannedUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user instanceof BannableContract && $user->isBanned()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'This account has been blocked. Please contact support.',
            ]);
        }

        return $next($request);
    }
}
