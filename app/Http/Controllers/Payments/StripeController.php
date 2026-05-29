<?php

namespace App\Http\Controllers\Payments;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Stripe\StripePaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    /**
     * Handle the success redirect from Stripe Checkout.
     * Confirms the payment via session retrieval and advances to the order page.
     */
    public function success(Request $request, StripePaymentService $stripe): RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if ($sessionId) {
            $payment = $stripe->confirmFromSession($sessionId);

            if ($payment) {
                return redirect()
                    ->route('account.orders.show', $payment->order_id)
                    ->with('success', 'Payment confirmed — your order is being processed.');
            }
        }

        return redirect()
            ->route('account.orders.index')
            ->with('info', 'Your payment is being confirmed. Check your orders shortly.');
    }

    /**
     * Handle the cancel redirect from Stripe Checkout.
     * Marks the payment cancelled and returns the customer to checkout to retry.
     */
    public function cancel(Request $request): RedirectResponse
    {
        $payment = Payment::find($request->query('payment'));

        if ($payment && $payment->isPending()) {
            $payment->update(['status' => PaymentStatus::CANCELLED]);
        }

        return redirect()
            ->route('checkout')
            ->with('warning', 'Card payment was cancelled. Your cart is intact — try again whenever you\'re ready.');
    }
}
