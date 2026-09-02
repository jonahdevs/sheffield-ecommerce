<?php

namespace App\Services\Paystack;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Thin wrapper around the Paystack REST API (Initialize Transaction, Verify
 * Transaction, Create Refund). Authenticates with the secret key as a bearer
 * token. Amounts are exchanged in the currency subunit (cents for KES).
 */
class PaystackClient
{
    private const BASE_URL = 'https://api.paystack.co';

    public function __construct(private string $secretKey) {}

    /**
     * Initialize a transaction and return the decoded response. On success the
     * response carries data.access_code (used to resume the inline popup) and
     * data.reference.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public function initializeTransaction(array $payload): array
    {
        return $this->client()->post(self::BASE_URL.'/transaction/initialize', $payload)->json() ?? [];
    }

    /**
     * Verify a transaction by reference. This is the authoritative status check
     * before delivering value.
     *
     * @return array<string, mixed>
     */
    public function verifyTransaction(string $reference): array
    {
        // Idempotent GET, and the customer has already been charged by the time we
        // ask - a transient network blip here must not read as "payment failed".
        // Only connection errors and Paystack 5xx are retried; a 404 (unknown
        // reference) is a real answer and retrying it just delays the response.
        return $this->client()
            ->retry(3, 200, fn (Throwable $e): bool => $e instanceof ConnectionException
                || ($e instanceof RequestException && $e->response->serverError()), throw: false)
            ->get(self::BASE_URL.'/transaction/verify/'.$reference)
            ->json() ?? [];
    }

    /**
     * Create a refund against a settled transaction. Returns the raw response so
     * the caller can distinguish a queued refund from a gateway rejection.
     *
     * @param  array<string, mixed>  $payload
     */
    public function createRefund(array $payload): Response
    {
        return $this->client()->post(self::BASE_URL.'/refund', $payload);
    }

    private function client(): PendingRequest
    {
        return Http::withToken($this->secretKey)
            ->acceptJson()
            ->asJson()
            ->timeout(15)
            ->connectTimeout(5);
    }
}
