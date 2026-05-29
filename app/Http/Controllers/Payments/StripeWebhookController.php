<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Services\Stripe\StripePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function __construct(private StripePaymentService $stripe) {}

    /**
     * Receive and process asynchronous Stripe events (server-to-server).
     */
    public function __invoke(Request $request): JsonResponse
    {
        $signature = $request->header('Stripe-Signature', '');

        try {
            $this->stripe->handleWebhook($request->getContent(), $signature);
        } catch (SignatureVerificationException) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        return response()->json(['received' => true]);
    }
}
