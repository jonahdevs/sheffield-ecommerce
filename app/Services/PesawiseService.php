<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

/**
 * Class PesawiseService.
 */
class PesawiseService
{

    private string $apiUrl;
    private string $apiKey;
    private string $apiSecret;
    private string $balanceId;

    public function __construct()
    {
        $this->apiUrl = config('services.pesawise.api_url');
        $this->apiKey = config('services.pesawise.api_key');
        $this->apiSecret = config('services.pesawise.api_secret');
        $this->balanceId = config('services.pesawise.balance_id_kes');
    }

    /**
     * Create payment order with Pesawise
     */
    public function createPaymentOrder(Order $order)
    {
        $payload =         private function buildPayload(Order $order): array
        {
            // IMPORTANT: callbackUrl receives BOTH POST webhook AND GET redirect from Pesawise
            // For local development with ngrok: Set PESAWISE_CALLBACK_BASE_URL in .env
            // For production: Leave empty to use APP_URL

            $baseUrl = config('services.pesawise.callback_base_url') ?: config('app.url');

            // Pesawise sends POST to this URL first with payment data,
            // then GET when user clicks "Continue" button
            $callbackUrl = rtrim($baseUrl, '/') . '/payment/callback/success';
            $cancellationUrl = rtrim($baseUrl, '/') . '/payment/callback/cancel';

            Log::info('Pesawise callback URLs', [
                'baseUrl' => $baseUrl,
                'callbackUrl' => $callbackUrl,
                'externalId' => $order->reference,
            ]);

            $payload = [
                'amount' => $order->total,
                'customerName' => $this->getCustomerName($order),
                'currency' => "KES",
                'externalId' => $order->reference,
                'description' => "Payment for Order #{$order->reference}",
                'balanceId' => $this->balanceId,
                'callbackUrl' => $callbackUrl,  // Receives BOTH POST and GET
                'cancellationUrl' => $cancellationUrl,
                'notificationId' => (string) $order->id,
                'timeValidityMinutes' => 30,
                'customerData' => [
                    'email' => $order->user?->email ?? '',
                    'phoneNumber' => $this->getPhoneNumber($order),
                    'city' => $order->shipping_address['area']['name'] ?? 'Nairobi',
                    'state' => $order->shipping_address['county']['name'] ?? 'Nairobi County',
                    'address' => $order->shipping_address['address'] ?? '',
                    'countryCode' => 'KE',
                ],
            ];

            return $payload;
        }
;

        try {
            $response = $this->initiatePayment($payload);

            $this->updatePaymentRecord($order, $response);

            session([
                'pesawise_payment_order_id' => $order->id,
                'pesawise_payment_reference' => $order->reference,
                'pesawise_payment_started_at' => now()->toISOString(),
            ]);

            return $response;
        } catch (\Throwable $th) {
            throw new \Exception('Payment gateway request failed. Please try again.');
        }
    }

    private function buildPayload(Order $order): array
    {
        // Use API route for POST webhook (no CSRF, cleaner handling)
        $webhookUrl = url('/api/webhooks/pesawise');
        
        // Use web route for GET redirect (user clicks "Continue")
        $callbackUrl = url('/payment/callback/success');
        $cancellationUrl = url('/payment/callback/cancel');

        // For testing with webhook.site
        // $webhookUrl = "https://webhook.site/6b0dd07e-93f0-463e-b7d4-eb6dd106b577";

        $payload = [
            'amount' => $order->total,
            'customerName' => $this->getCustomerName($order),
            'currency' => "KES",
            'externalId' => $order->reference,
            'description' => "Payment for Order #{$order->reference}",
            'balanceId' => $this->balanceId,
            'callbackUrl' => $webhookUrl,  // GET - user redirect
            'cancellationUrl' => $cancellationUrl,
            'notificationId' => (string) $order->id,
            'timeValidityMinutes' => 30,
            'customerData' => [
                'email' => $order->user?->email ?? '',
                'phoneNumber' => $this->getPhoneNumber($order),
                'city' => $order->shipping_address['area']['name'] ?? 'Nairobi',
                'state' => $order->shipping_address['county']['name'] ?? 'Nairobi County',
                'address' => $order->shipping_address['address'] ?? '',
                'countryCode' => 'KE',
            ],
        ];

        // Add webhook URL if Pesawise supports it as a separate parameter
        // Check Pesawise docs - they might have 'webhookUrl' or 'notificationUrl'
        // $payload['webhookUrl'] = $webhookUrl;

        Log::info('Pesawise payload', [
            'webhookUrl' => $webhookUrl,
            'callbackUrl' => $callbackUrl,
            'externalId' => $order->reference,
        ]);

        return $payload;
    }

    private function initiatePayment(array $payload)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl . "/e-com/create-order",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: */*',
                'api-key: ' . $this->apiKey,
                'api-secret: ' . $this->apiSecret
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            Log::error('Pesawise cURL Error: ' . $error);
            throw new \Exception('Payment gateway connection failed');
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $decodedResponse = json_decode($response, true);

        Log::info('Pesawise response: ' . json_encode($response, JSON_PRETTY_PRINT));
        return $decodedResponse;
    }

    private function updatePaymentRecord(Order $order, array $response): void
    {
        $createdPaymentOrder = $response['createdPaymentOrder'];

        $order->payment->update([
            'gateway_order_id' => $createdPaymentOrder['orderId'],
            'transaction_id' => $createdPaymentOrder['orderRequestId'],
            'status' => 'processing',
            'meta' => [
                'request_id' => $response['requestId'],
                'load_url' => $createdPaymentOrder['loadUrl'],
                'order_request_id' => $createdPaymentOrder['orderRequestId'],
                'created_at' => now()->toISOString(),
            ],
        ]);
    }

    private function getCustomerName(Order $order): string
    {
        if ($order->user && $order->user->name) {
            return $order->user->name;
        }

        $shippingAddress = $order->shipping_address;

        if (!empty($shippingAddress['first_name'])) {
            $lastName = $shippingAddress['last_name'] ?? '';
            return trim($shippingAddress['first_name'] . ' ' . $lastName);
        }

        return 'Guest Customer';
    }

    private function getPhoneNumber(Order $order): string
    {
        if ($order->user && $order->user->phone_number) {
            return $order->user->phone_number;
        }

        return $order->shipping_address['phone_number'] ?? '';
    }
}
