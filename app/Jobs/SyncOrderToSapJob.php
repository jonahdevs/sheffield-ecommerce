<?php

namespace App\Jobs;

use App\Enums\SapSyncStatus;
use App\Events\SapSyncStatusUpdated;
use App\Models\Order;
use App\Notifications\SapSyncFailedNotification;
use App\Services\Sap\SapApiException;
use App\Services\Sap\SapIntegrationService;
use App\Support\StaffRecipients;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SyncOrderToSapJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public array $backoff = [60, 300, 900];

    public int $timeout = 120;

    public function __construct(public readonly Order $order)
    {
        $this->onQueue('sap');
    }

    /**
     * Phase 1: POST /api/invoice/create
     *
     * Saves sap_doc_entry before dispatching RecoverSapInvoiceJob so that if
     * this job crashes after the SAP call but before the dispatch, a retry
     * will skip the create and go straight to re-dispatching the recovery job.
     */
    public function handle(SapIntegrationService $sap): void
    {
        $order = $this->order->fresh();

        if ($order->sap_sync_status === SapSyncStatus::COMPLETED) {
            return;
        }

        // Create already succeeded on a previous attempt but the dispatch was lost.
        if ($order->sap_doc_entry && $order->sap_sync_status === SapSyncStatus::AWAITING_CU) {
            Log::info('SAP: create already done - re-dispatching recovery job.', [
                'order_id' => $order->id,
                'sap_doc_entry' => $order->sap_doc_entry,
            ]);

            RecoverSapInvoiceJob::dispatch($order);

            return;
        }

        Log::info('SAP: sync started.', ['order_id' => $order->id, 'attempt' => $this->attempts()]);

        $order->update(['sap_sync_status' => SapSyncStatus::SYNCING]);
        SapSyncStatusUpdated::dispatch($order->fresh(), SapSyncStatus::SYNCING);

        try {
            $result = $sap->syncOrder($order);
        } catch (SapApiException $e) {
            if (! $e->isRetryable()) {
                $this->fail($e);

                return;
            }

            throw $e;
        }

        // Persist doc refs before dispatching recovery - guards against partial failures.
        // On an "already exists" outcome SAP may not echo the docEntry, so keep any
        // value we already had rather than blanking it.
        $order->update([
            'sap_doc_entry' => $result->docEntry ?: $order->sap_doc_entry,
            'sap_doc_number' => $result->docNumber ?? $order->sap_doc_number,
            'sap_sync_status' => SapSyncStatus::AWAITING_CU,
            'sap_synced_at' => now(),
            'sap_sync_attempts' => $this->attempts(),
            'sap_sync_error' => null,
        ]);
        $order = $order->fresh();
        SapSyncStatusUpdated::dispatch($order, SapSyncStatus::AWAITING_CU);

        activity()->performedOn($order)
            ->withProperties([
                'sap_doc_entry' => $order->sap_doc_entry,
                'attempt' => $this->attempts(),
                'already_exists' => $result->alreadyExists,
            ])
            ->log('sap_sync_completed');

        // The recovery job polls the validate endpoint by docEntry - only useful
        // when we actually have one. Without it (e.g. a duplicate SAP couldn't
        // re-identify), the webhook remains the path to the CU number.
        if ($order->sap_doc_entry) {
            RecoverSapInvoiceJob::dispatch($order);
        }
    }

    public function failed(\Throwable $exception): void
    {
        $order = $this->order->fresh();

        if ($order->sap_sync_status === SapSyncStatus::FAILED) {
            return;
        }

        // Phase 1 already succeeded on SAP's side - sap_doc_entry is persisted and
        // RecoverSapInvoiceJob is queued to run Phase 2 (validate + CU number).
        // Don't mark FAILED here; let RecoverSapInvoiceJob own the final outcome.
        if ($order->sap_doc_entry) {
            Log::warning('SAP: SyncOrderToSapJob failed after invoice was created - RecoverSapInvoiceJob will complete Phase 2.', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'sap_doc_entry' => $order->sap_doc_entry,
                'error' => $exception->getMessage(),
            ]);

            return;
        }

        Log::error('SAP: sync permanently failed.', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'error' => $exception->getMessage(),
        ]);

        $order->update([
            'sap_sync_status' => SapSyncStatus::FAILED,
            'sap_sync_attempts' => $this->tries,
            'sap_sync_error' => $exception->getMessage(),
        ]);
        SapSyncStatusUpdated::dispatch($order->fresh(), SapSyncStatus::FAILED);

        activity()->performedOn($order)
            ->withProperties(['error' => $exception->getMessage()])
            ->log('sap_sync_failed');

        Notification::send(
            StaffRecipients::for('orders.manage'),
            new SapSyncFailedNotification($order, $exception),
        );
    }
}
