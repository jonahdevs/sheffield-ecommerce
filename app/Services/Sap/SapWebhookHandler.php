<?php

namespace App\Services\Sap;

use App\Enums\SapSyncStatus;
use App\Events\SapSyncStatusUpdated;
use App\Models\Order;
use App\Models\SapSyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SapWebhookHandler
{
    public function __construct(
        private readonly KraReceiptService $receipts,
        private readonly SapConfig $config,
    ) {}

    public function handle(Request $request): void
    {
        $payload = $request->json()->all();

        if (! $this->validateSignature($request)) {
            Log::warning('SAP webhook rejected - invalid secret.', ['ip' => $request->ip()]);
            abort(401, 'Unauthorized.');
        }

        $reference = $payload['data']['external_reference'] ?? $payload['external_reference'] ?? null;

        if (! $reference) {
            Log::warning('SAP webhook: missing external_reference.');

            return;
        }

        $order = Order::where('order_number', $reference)->first();

        if (! $order) {
            Log::warning('SAP webhook: unknown order reference.', ['reference' => $reference]);

            return;
        }

        $event = $payload['event'] ?? null;

        match (true) {
            $event === 'invoice.cu_number_generated', isset($payload['cu_number']), isset($payload['data']['cu_number']) => $this->handleCuNumber($order, $payload),
            ($payload['status'] ?? null) === 'returned' => $this->handleReturn($order, $payload),
            default => Log::info('SAP webhook: unrecognised event.', [
                'order_id' => $order->id,
                'event' => $event,
            ]),
        };
    }

    public function validateSignature(Request $request): bool
    {
        $secret = $this->config->webhookSecret();

        if (empty($secret)) {
            return true;
        }

        $provided = (string) $request->header('X-SAP-Secret', '');

        return hash_equals($secret, $provided);
    }

    private function handleCuNumber(Order $order, array $payload): void
    {
        $data = $payload['data'] ?? $payload;
        $cuNumber = $data['cu_number'] ?? null;

        if (! $cuNumber) {
            Log::warning('SAP webhook: missing cu_number.', ['order_id' => $order->id]);

            return;
        }

        $validStates = [SapSyncStatus::SYNCING, SapSyncStatus::AWAITING_CU, SapSyncStatus::FAILED];

        if (! in_array($order->sap_sync_status, $validStates)) {
            Log::warning('SAP webhook: CU number ignored - order not in a syncable state.', [
                'order_id' => $order->id,
                'sap_sync_status' => $order->sap_sync_status->value,
            ]);

            return;
        }

        // Idempotency - skip duplicate delivery
        if ($order->cu_number === $cuNumber) {
            Log::info('SAP webhook: duplicate CU number ignored.', [
                'order_id' => $order->id,
                'cu_number' => $cuNumber,
            ]);

            return;
        }

        $order->update([
            'cu_number' => $cuNumber,
            'sap_synced_at' => now(),
            'sap_sync_status' => SapSyncStatus::COMPLETED,
        ]);

        SapSyncLog::create([
            'order_id' => $order->id,
            'operation' => 'cu_webhook',
            'status' => 'success',
            'endpoint' => '/api/webhooks/sap',
            'http_method' => 'POST',
            'request_payload' => $payload,
            'http_status_code' => 200,
        ]);

        Log::info('SAP webhook: CU number stored.', [
            'order_id' => $order->id,
            'cu_number' => $cuNumber,
        ]);

        activity()->performedOn($order)
            ->withProperties(['cu_number' => $cuNumber])
            ->log('sap_kra_validated');

        // Keep the admin SAP-sync monitor live on the webhook path, matching
        // the polling path in RecoverSapInvoiceJob.
        SapSyncStatusUpdated::dispatch($order->fresh(), SapSyncStatus::COMPLETED);

        // Receipt failure must never cause a 500 - SAP would keep retrying the webhook.
        $this->receipts->generate($order);
    }

    private function handleReturn(Order $order, array $payload): void
    {
        $validStates = [SapSyncStatus::AWAITING_CU, SapSyncStatus::COMPLETED];

        if (! in_array($order->sap_sync_status, $validStates)) {
            Log::warning('SAP webhook: RETURNED event ignored - invalid state.', [
                'order_id' => $order->id,
                'sap_sync_status' => $order->sap_sync_status->value,
            ]);

            return;
        }

        $order->update(['sap_sync_status' => SapSyncStatus::RETURNED]);

        SapSyncLog::create([
            'order_id' => $order->id,
            'operation' => 'return_webhook',
            'status' => 'success',
            'endpoint' => '/api/webhooks/sap',
            'http_method' => 'POST',
            'request_payload' => $payload,
            'http_status_code' => 200,
        ]);

        Log::info('SAP webhook: order returned.', ['order_id' => $order->id]);

        activity()->performedOn($order)->log('sap_order_returned');
    }
}
