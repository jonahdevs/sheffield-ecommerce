<?php

namespace App\Http\Middleware;

use App\Rules\Recaptcha;
use Closure;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ValidateRecaptcha
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string $action = 'submit'): Response
    {
        if (! Recaptcha::isConfigured()) {
            return $next($request);
        }

        try {
            $result = Http::asForm()
                ->timeout(5)
                ->connectTimeout(3)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret'),
                    'response' => $request->input('g-recaptcha-response', ''),
                    'remoteip' => $request->ip(),
                ])->json();
        } catch (ConnectionException) {
            // Google unreachable: fail closed with the normal message rather than
            // 500ing the form, and never hold the request past the 5s timeout.
            $result = [];
        }

        if (! ($result['success'] ?? false) || ($result['score'] ?? 0) < 0.5) {
            return back()->withErrors(['email' => __('Security verification failed. Please try again.')]);
        }

        return $next($request);
    }
}
