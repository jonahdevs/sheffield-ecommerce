<?php

namespace App\Services\Sap;

use App\Models\Order;
use App\Models\SapSyncLog;
use App\Services\Sap\DTOs\SapOrderPayload;
use App\Services\Sap\ValueObjects\SapSyncResult;
use App\Services\Sap\ValueObjects\SapValidationResult;
use Illuminate\Support\Facades\Log;

class SapIntegrationService
{
    /**
     * Substrings in SAP's rejection message that mean the order was already
     * invoiced on a previous attempt. Matched case-insensitively.
     */
    private const ALREADY_EXISTS_SIGNALS = [
        'invoice already created',
        'already invoiced',
        'already exists',
    ];

    public function __construct(private readonly SapClient $client) {}

    /**
     * Phase 1 — POST /api/invoice/create.
     * Sends the confirmed order to SAP and returns the document references.
     *
     * @throws SapApiException
     */
    public function syncOrder(Order $order): SapSyncResult
    {
        $payload = SapOrderPayload::fromOrder($order);
        $start = microtime(true);

        $response = $this->client->post('/api/invoice/create', $payload);

        $durationMs = (int) ((microtime(true) - $start) * 1000);
        $data = $response->json() ?? [];

        $success = $response->successful() && ($data['success'] ?? false) === true;
        $docEntry = (string) ($data['docEntry'] ?? '');
        $docNumber = isset($data['docNumber']) ? (string) $data['docNumber'] : null;

        // SAP rejects a re-send of an order it has already invoiced. That is not a
        // failure — the invoice exists; we only need the CU number. Treat it as a
        // benign, idempotent outcome instead of retrying and alerting staff.
        $alreadyExists = ! $success && $this->indicatesInvoiceExists($data, $response->body());
        $ok = $success || $alreadyExists;

        SapSyncLog::create([
            'order_id' => $order->id,
            'operation' => 'create_invoice',
            'status' => $ok ? 'success' : 'failed',
            'endpoint' => '/api/invoice/create',
            'http_method' => 'POST',
            'request_payload' => $this->redactPayload($payload),
            'response_payload' => $data,
            'http_status_code' => $response->status(),
            'error_message' => $ok ? null : ($data['message'] ?? $response->body()),
            'sap_document_number' => $success ? ($docEntry ?: null) : null,
            'duration_ms' => $durationMs,
        ]);

        if ($alreadyExists) {
            Log::info('SAP invoice already exists — treating as synced.', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'doc_entry' => $docEntry ?: null,
                'message' => $data['message'] ?? null,
            ]);

            return new SapSyncResult($docEntry, $docNumber, $data, alreadyExists: true);
        }

        if (! $success) {
            $error = $data['message'] ?? "SAP returned HTTP {$response->status()}";

            Log::error('SAP invoice creation failed', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'http_status' => $response->status(),
                'error' => $error,
                'duration_ms' => $durationMs,
            ]);

            throw new SapApiException(
                message: $error,
                httpStatus: $response->status(),
                endpoint: '/api/invoice/create',
            );
        }

        Log::info('SAP invoice created', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'doc_entry' => $docEntry,
            'doc_number' => $docNumber,
            'duration_ms' => $durationMs,
        ]);

        return new SapSyncResult($docEntry, $docNumber, $data);
    }

    /**
     * Phase 2 — POST /api/invoice/validate/{docEntry}.
     * Called by RecoverSapInvoiceJob if no webhook arrived within the delay window.
     *
     * @throws SapApiException
     */
    public function validateInvoice(Order $order): SapValidationResult
    {
        $docEntry = $order->sap_doc_entry;
        $path = "/api/invoice/validate/{$docEntry}";
        $start = microtime(true);

        // 4-minute timeout — KRA validation can be slow, but we don't want to
        // block a worker indefinitely. The webhook is always the primary path.
        $response = $this->client->post($path, [], timeoutSeconds: 240);

        $durationMs = (int) ((microtime(true) - $start) * 1000);
        $data = $response->json() ?? [];

        $cuNumber = $data['cuNumber'] ?? null;
        $success = $response->successful() && ($data['success'] ?? false) === true && $cuNumber;

        SapSyncLog::create([
            'order_id' => $order->id,
            'operation' => 'validate_invoice',
            'status' => $success ? 'success' : 'failed',
            'endpoint' => $path,
            'http_method' => 'POST',
            'request_payload' => ['doc_entry' => $docEntry],
            'response_payload' => $data,
            'http_status_code' => $response->status(),
            'error_message' => $success ? null : ($data['message'] ?? $response->body()),
            'sap_document_number' => $success ? $cuNumber : null,
            'duration_ms' => $durationMs,
        ]);

        if (! $success) {
            $error = $data['message'] ?? "SAP validate returned HTTP {$response->status()} without cuNumber";

            Log::error('SAP invoice validation failed', [
                'order_id' => $order->id,
                'doc_entry' => $docEntry,
                'http_status' => $response->status(),
                'error' => $error,
                'duration_ms' => $durationMs,
            ]);

            throw new SapApiException(
                message: $error,
                httpStatus: $response->status(),
                endpoint: $path,
            );
        }

        Log::info('SAP invoice validated', [
            'order_id' => $order->id,
            'cu_number' => $cuNumber,
            'duration_ms' => $durationMs,
        ]);

        return new SapValidationResult($cuNumber, $docEntry, $data);
    }

    /**
     * Does SAP's rejection mean the invoice already exists for this order? SAP
     * answers HTTP 200 with success=false and a message like "Invoice already
     * created" when we re-send an order it has already invoiced.
     *
     * @param  array<string, mixed>  $data
     */
    private function indicatesInvoiceExists(array $data, string $body): bool
    {
        $message = strtolower((string) ($data['message'] ?? $body));

        foreach (self::ALREADY_EXISTS_SIGNALS as $signal) {
            if (str_contains($message, $signal)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Mask only the genuinely sensitive payment fields before persisting to
     * sap_sync_logs. The reusable card handle and national ID are secrets; the
     * rest of the block — transaction references, card brand, the masked last-4,
     * expiry, payment count — stays visible so the sync can actually be audited
     * and the per-gateway mapping verified.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function redactPayload(array $payload): array
    {
        $sensitiveKeys = ['creditCardToken', 'personalId'];

        if (isset($payload['credit_guard_response'])) {
            foreach ($sensitiveKeys as $key) {
                if (filled($payload['credit_guard_response'][$key] ?? null)) {
                    $payload['credit_guard_response'][$key] = '[redacted]';
                }
            }
        }

        return $payload;
    }
}
