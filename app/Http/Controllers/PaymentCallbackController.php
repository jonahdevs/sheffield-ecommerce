<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Enhanced Payment Callback Controller with security and proper error handling
 */
class PaymentCallbackController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private InventoryService $inventoryService
    ) {
    }

    /**
     * Handle payment callback - receives BOTH POST (webhook) and GET (user redirect)
     */
    public function handleSuccess(Request $request)
    {
        Log::info('=== PAYMENT CALLBACK RECEIVED ===', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'all_data' => $request->all(),
            'raw_body' => $request->getContent(),
        ]);

        // POST request = Webhook from Pesawise with payment status
        if ($request->isMethod('post')) {
            return $this->handleWebhook($request);
        }

        // GET request = User redirect after clicking "Continue"
        return $this->handleUserRedirect($request);
    }

    public function handleCancel(Request $request)
    {
        Log::info('=== CANCEL CALLBACK ===', [
            'method' => $request->method(),
            'all_data' => $request->all(),
        ]);

        return redirect()->route('checkout.summary')
            ->with('error', 'Payment was cancelled.');
    }

    /**
     * Handle POST webhook from Pesawise
     */
    private function handleWebhook(Request $request)
    {
        Log::info('=== POST WEBHOOK PROCESSING ===');

        try {
            $data = $request->json()->all();
            
            $status = $data['status'] ?? null;
            $externalId = $data['externalId'] ?? null;
            $orderId = $data['orderId'] ?? null;
            $amount = $data['amount'] ?? null;

            Log::info('Webhook data parsed', [
                'status' => $status,
                'externalId' => $externalId,
                'orderId' => $orderId,
                'amount' => $amount,
            ]);

            if ($status === 'SUCCESS' && $externalId) {
                $order = Order::where('reference', $externalId)->first();
                
                if ($order) {
                    $this->processSuccessfulPayment($order, $orderId, $amount);
                    Log::info('Payment processed successfully', ['order' => $externalId]);
                } else {
                    Log::error('Order not found', ['externalId' => $externalId]);
                }
            } else {
                Log::warning('Webhook with non-SUCCESS status', ['status' => $status]);
            }

        } catch (\Exception $e) {
            Log::error('Webhook processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Always return 200 to acknowledge receipt
        return response()->json(['status' => 'received'], 200);
    }
    // public function handleSuccess(Request $request)
    // {
    //     Log::info(
    //         'Pesawise Callback Received: ' .
    //         json_encode([
    //             'method' => $request->method(), // ✅ Add this
    //             'all_params' => $request->all(),
    //             'query_params' => $request->query(),
    //             'body' => $request->getContent(), // ✅ Also log raw body
    //             'url' => $request->fullUrl(),
    //         ], JSON_PRETTY_PRINT)
    //     );


    //     if ($request->isMethod('post')) {
    //         return $this->handleWebhook($request);
    //     }

    //     return $this->handleUserRedirect($request);
    // }


    public function handleSuccessPost(Request $request)
    {
        Log::info('Pesawise POST Callback Received', [
            'all_params' => $request->all(),
            'query_params' => $request->query(),
            'url' => $request->fullUrl(),
        ]);
    }

    /**
     * Handle POST webhook from Pesawise server
     */
    // private function handleWebhook(Request $request)
    // {
    //     Log::info('Pesawise POST Callback Received', [
    //         'all_params' => $request->all(),
    //         'query_params' => $request->query(),
    //         'url' => $request->fullUrl(),
    //     ]);
    //     try {
    //         $data = $request->json()->all();

    //         $status = $data['status'] ?? null;
    //         $externalId = $data['externalId'] ?? null; // This is your order reference
    //         $pesawiseOrderId = $data['orderId'] ?? null;
    //         $amount = $data['amount'] ?? null;

    //         Log::info('Processing Pesawise webhook', [
    //             'status' => $status,
    //             'externalId' => $externalId,
    //             'orderId' => $pesawiseOrderId,
    //             'amount' => $amount,
    //         ]);

    //         if (!$externalId) {
    //             Log::error('Webhook missing externalId');
    //             return response()->json(['error' => 'Missing externalId'], 400);
    //         }

    //         $order = Order::where('reference', $externalId)->first();

    //         if (!$order) {
    //             Log::error('Order not found for webhook', ['externalId' => $externalId]);
    //             return response()->json(['error' => 'Order not found'], 404);
    //         }

    //         if ($status === 'SUCCESS') {
    //             $this->processSuccessfulPayment($order, $pesawiseOrderId, $amount);
    //         } else {
    //             Log::warning('Payment webhook with non-SUCCESS status', [
    //                 'status' => $status,
    //                 'order_id' => $order->id,
    //             ]);
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Webhook processed'
    //         ], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Webhook processing failed', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         return response()->json([
    //             'error' => 'Webhook processing failed'
    //         ], 500);
    //     }
    // }

    /**
     * Handle GET redirect when user clicks "Continue"
     */
    private function handleUserRedirect(Request $request)
    {
        Log::info('=== USER REDIRECT PROCESSING ===');

        // Show success page - webhook has already processed payment
        return redirect()->route('checkout.success-page')
            ->with('info', 'Payment is being verified. You will receive confirmation shortly.');
    }

    /**
     * Handle payment cancellation
     */
    // public function handleCancel(Request $request)
    // {
    //     Log::info('Pesawise Cancellation Callback', [
    //         'query' => $request->query(),
    //     ]);

    //     $orderId = $request->query('order_id');
    //     $reference = $request->query('reference');

    //     if ($orderId && $reference) {
    //         $order = Order::where('id', $orderId)
    //             ->where('reference', $reference)
    //             ->first();

    //         if ($order) {
    //             DB::transaction(function () use ($order) {
    //                 $order->update([
    //                     'payment_status' => 'cancelled',
    //                     'status' => 'cancelled',
    //                 ]);

    //                 $order->payment->update([
    //                     'status' => 'cancelled',
    //                 ]);
    //             });

    //             Log::info('Order cancelled', [
    //                 'order_id' => $order->id,
    //                 'reference' => $order->reference,
    //             ]);

    //             return redirect()->route('checkout.index')
    //                 ->with('error', 'Payment was cancelled. Please try again.');
    //         }
    //     }

    //     return redirect()->route('checkout.index')
    //         ->with('info', 'Payment was cancelled.');
    // }

    /**
     * Process successful payment
     */
    private function processSuccessfulPayment(Order $order, ?string $pesawiseOrderId, ?int $amount)
    {
        DB::transaction(function () use ($order, $pesawiseOrderId, $amount) {
            // Update order
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);

            // Update payment record
            $order->payment->update([
                'status' => 'completed',
                'paid_at' => now(),
                'meta' => array_merge($order->payment->meta ?? [], [
                    'pesawise_order_id' => $pesawiseOrderId,
                    'paid_amount' => $amount,
                    'confirmed_at' => now()->toISOString(),
                ]),
            ]);

            Log::info('Payment processed successfully', [
                'order_id' => $order->id,
                'reference' => $order->reference,
                'pesawise_order_id' => $pesawiseOrderId,
                'amount' => $amount,
            ]);

            // Clear session data
            session()->forget([
                'pesawise_payment_order_id',
                'pesawise_payment_reference',
                'pesawise_payment_started_at',
            ]);

            // Dispatch events (uncomment as needed)
            // event(new OrderPaid($order));
            // Mail::to($order->user)->send(new OrderConfirmationMail($order));
        });
    }
}
