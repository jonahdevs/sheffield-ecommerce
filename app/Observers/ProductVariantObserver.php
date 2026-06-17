<?php

namespace App\Observers;

use App\Events\LowStockDetected;
use App\Models\ProductVariant;
use App\Settings\InventorySettings;

class ProductVariantObserver
{
    public function updated(ProductVariant $productVariant): void
    {
        if (! $productVariant->wasChanged('stock_quantity') || $productVariant->stock_quantity === null) {
            return;
        }

        $product = $productVariant->product;

        if (! $product) {
            return;
        }

        $threshold = $product->low_stock_threshold
            ?? app(InventorySettings::class)->low_stock_threshold;

        if ($productVariant->stock_quantity <= $threshold) {
            LowStockDetected::dispatch($product, $productVariant->stock_quantity);
        }
    }
}
