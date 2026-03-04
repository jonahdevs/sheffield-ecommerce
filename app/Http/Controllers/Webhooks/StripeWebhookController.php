<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Payment\Gateways\StripeGateway;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, StripeGateway $gateway): Response
    {
        Log::info('Webhook received', [
            'gateway' => 'mpesa', // or pesawise/stripe
            'ip' => $request->ip(),
        ]);
        $gateway->handleWebhook($request);

        return response('OK', 200);
    }
}
