<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quote;
use App\Support\TaxCalculator;
use Illuminate\Support\Facades\DB;

class QuoteConversionService
{
    public function __construct(private TaxCalculator $tax) {}

    /**
     * Convert a quote into a pending order, link the order back to the quote,
     * and return the new order. Does not change the quote's status - callers
     * are responsible for that.
     *
     * Idempotent: the quote row is locked and re-read inside the transaction,
     * so concurrent or repeated accepts can never produce a second order - once
     * `order_id` is set the existing order is returned instead.
     */
    public function convert(Quote $quote): Order
    {
        return DB::transaction(function () use ($quote) {
            $quote = Quote::lockForUpdate()->findOrFail($quote->getKey());

            if ($quote->order_id) {
                return $quote->order()->firstOrFail();
            }

            $lines = $quote->items()
                ->with(['product.taxClass', 'product.media'])
                ->get();

            // For items where the admin didn't link a product, resolve by SKU.
            $unresolvedSkus = $lines
                ->whereNull('product_id')
                ->pluck('product_snapshot.sku')
                ->filter()
                ->unique()
                ->values();

            $resolvedBySku = $unresolvedSkus->isNotEmpty()
                ? Product::with('media')
                    ->whereIn('sku', $unresolvedSkus)
                    ->get()
                    ->keyBy('sku')
                : collect();

            $lines = $lines->map(function ($item) use ($resolvedBySku) {
                if (! $item->product_id && isset($item->product_snapshot['sku'])) {
                    $resolved = $resolvedBySku->get($item->product_snapshot['sku']);
                    if ($resolved) {
                        $item->product_id = $resolved->id;
                        $item->setRelation('product', $resolved);
                    }
                }

                $rate = $item->product
                    ? $this->tax->rateForProduct($item->product)
                    : ($this->tax->enabled() ? $this->tax->defaultRate() : 0.0);

                return [
                    'item' => $item,
                    'rate' => $rate,
                    'tax_cents' => $this->tax->taxForLine((int) $item->line_total_cents, $rate),
                ];
            });

            $subtotalCents = (int) $lines->sum(fn ($line) => $line['item']->line_total_cents);
            $vatCents = (int) $lines->sum('tax_cents');

            // The customer approved the quote's total, so the order must carry the
            // staff-set discount and delivery charge through rather than rebuilding
            // the total from line items alone. Mirrors the quote's own arithmetic:
            // (subtotal - discount) + VAT (unless tax-inclusive) + shipping.
            $discountCents = (int) $quote->discount_cents;
            $deliveryCents = (int) $quote->shipping_cents;
            $afterDiscount = max(0, $subtotalCents - $discountCents);
            $totalCents = $afterDiscount
                + ($this->tax->pricesIncludeTax() ? 0 : $vatCents)
                + $deliveryCents;

            $order = Order::create([
                'user_id' => $quote->user_id,
                'order_number' => Order::generateNumber(),
                'status' => OrderStatus::PENDING,
                'subtotal_cents' => $subtotalCents,
                'vat_cents' => $vatCents,
                'discount_cents' => $discountCents,
                'delivery_cents' => $deliveryCents,
                'installation_cents' => 0,
                'total_cents' => $totalCents,
                // Provenance is captured by the quote relationship (and the
                // "Created from a quotation" callout); carry the customer's own
                // notes through rather than a boilerplate "converted from" string.
                'notes' => $quote->notes,
            ]);

            foreach ($lines as $line) {
                $item = $line['item'];
                $snapshot = $item->product_snapshot ?? [];
                if ($item->product?->cover_url) {
                    $snapshot['cover_url'] = $item->product->cover_url;
                }

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_snapshot' => $snapshot,
                    'unit_price_cents' => $item->unit_price_cents,
                    'quantity' => $item->quantity,
                    'line_total_cents' => $item->line_total_cents,
                    'tax_rate' => $line['rate'],
                    'tax_cents' => $line['tax_cents'],
                ]);
            }

            $quote->update(['order_id' => $order->id]);

            return $order;
        }, 3);
    }
}
