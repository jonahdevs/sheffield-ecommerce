<?php

namespace App\Services\Sap\DTOs;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;

/**
 * Builds the SAP invoice creation payload from an Order.
 * Extracted from SapIntegrationService so it can be tested independently.
 */
final readonly class SapOrderPayload
{
    /**
     * @return array<string, mixed>
     */
    public static function fromOrder(Order $order): array
    {
        $order->loadMissing(['items', 'payments', 'user', 'address']);

        $payment = $order->payments
            ->where('status', PaymentStatus::SUCCESS)
            ->sortByDesc('paid_at')
            ->first();

        return [
            'credit_guard_response' => self::paymentBlock($payment),
            'customer' => self::customerBlock($order),
            'order' => self::orderBlock($order),
        ];
    }

    /**
     * Maps our payment record to the SAP credit_guard_response shape.
     *
     * The keys are the legacy Credit Guard (card gateway) contract SAP's
     * middleware parses; we keep them stable and populate them from whichever
     * gateway actually settled the payment. Card fields are only filled for card
     * channels (Paystack `card` / Stripe); every method fills `uid` with the
     * settlement reference SAP reconciles the receipt against. Unknown fields are
     * left empty - SAP middleware accepts partial data.
     *
     * @return array<string, string>
     */
    private static function paymentBlock(?Payment $payment): array
    {
        $block = [
            'authNumber' => '',
            'cardBrand' => '',
            'cardExpiration' => '',
            'cardId' => '',
            'cardNo' => '',
            'cgUid' => '',
            'creditCardToken' => '',
            'numberOfPayments' => '0',
            'personalId' => '',
            'uid' => '',
        ];

        if ($payment === null) {
            return $block;
        }

        $block['numberOfPayments'] = '1';
        $block['uid'] = self::settlementReference($payment);
        $block['cgUid'] = self::gatewayTransactionId($payment);

        if (self::isCardPayment($payment)) {
            $block['cardBrand'] = (string) ($payment->card_brand ?? '');
            $block['cardNo'] = (string) ($payment->card_last4 ?? '');
            $block['cardExpiration'] = self::cardExpiration($payment);
            // Reusable card handle the gateway returned (Paystack authorization
            // code / Stripe payment intent) so SAP can store a card-on-file token.
            $block['creditCardToken'] = (string) ($payment->authorization_code
                ?? $payment->stripe_payment_intent_id
                ?? '');
        }

        return $block;
    }

    /**
     * Was the payment made on a card rail? Only then do the card-specific fields
     * carry meaningful data. Paystack reports the concrete channel post-verify;
     * Stripe only ever charges cards.
     */
    private static function isCardPayment(Payment $payment): bool
    {
        return $payment->provider === 'stripe' || $payment->channel === 'card';
    }

    /**
     * The unique reference SAP reconciles the receipt against. Prefer the
     * mobile-money/M-Pesa receipt when one exists (direct Daraja, and Paystack
     * mobile-money which surfaces the network receipt), otherwise the gateway's
     * own reference.
     */
    private static function settlementReference(Payment $payment): string
    {
        return (string) ($payment->mpesa_receipt
            ?? $payment->paystack_reference
            ?? $payment->stripe_charge_id
            ?? $payment->stripe_payment_intent_id
            ?? '');
    }

    /**
     * The gateway's own internal transaction id, kept distinct from `uid` so SAP
     * can trace the charge back inside the provider's dashboard.
     */
    private static function gatewayTransactionId(Payment $payment): string
    {
        return match ($payment->provider) {
            'paystack' => (string) (data_get($payment->payload, 'id') ?? $payment->paystack_reference ?? ''),
            'stripe' => (string) ($payment->stripe_charge_id ?? $payment->stripe_payment_intent_id ?? ''),
            'mpesa' => (string) ($payment->checkout_request_id ?? ''),
            default => '',
        };
    }

    /**
     * Card expiry in Credit Guard's MMYY format, sourced from the gateway payload
     * (Paystack authorization). Returns empty when the gateway did not report it.
     */
    private static function cardExpiration(Payment $payment): string
    {
        $month = data_get($payment->payload, 'authorization.exp_month');
        $year = data_get($payment->payload, 'authorization.exp_year');

        if (! $month || ! $year) {
            return '';
        }

        return str_pad((string) $month, 2, '0', STR_PAD_LEFT).substr((string) $year, -2);
    }

    /**
     * @return array<string, string|null>
     */
    private static function customerBlock(Order $order): array
    {
        return [
            'created_at' => $order->user?->created_at?->toISOString() ?? $order->created_at->toISOString(),
            'email' => $order->user?->email ?? $order->shipping_email ?? '',
            'full_address' => $order->address?->line1 ?? $order->shipping_line1 ?? '',
            'full_name' => $order->address?->fullName() ?? $order->shipping_name ?? $order->user?->name ?? '',
            'mobile_phone' => $order->address?->phone ?? $order->shipping_phone ?? '',
            'note' => $order->notes,
            'updated_at' => $order->user?->updated_at?->toISOString() ?? $order->updated_at->toISOString(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function orderBlock(Order $order): array
    {
        return [
            // SAP types Orderid as an Int64, so it must stay our numeric order id.
            // The human-facing reference travels alongside it in `reference`.
            'Orderid' => $order->id,
            'reference' => $order->order_number,
            'name' => $order->address?->fullName() ?? $order->shipping_name ?? $order->user?->name ?? '',
            'phone' => $order->address?->phone ?? $order->shipping_phone ?? '',
            'payment_status' => 'Paid',
            'cart' => [
                'debit_total_price' => $order->total_cents / 100,
                'lines' => $order->items->map(fn ($item) => [
                    'code' => $item->product_snapshot['sku'] ?? '',
                    'item_id' => $item->product_id,
                    'line_item_id' => $item->id,
                    'price' => $item->unit_price_cents / 100,
                    'quantity' => $item->quantity,
                    'linetotal' => $item->line_total_cents,
                ])->values()->toArray(),
            ],
        ];
    }
}
