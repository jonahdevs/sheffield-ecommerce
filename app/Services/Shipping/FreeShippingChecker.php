<?php

namespace App\Services\Shipping;

use App\Models\FreeShippingRule;
use Illuminate\Support\Facades\Cache;

/**
 * Class FreeShippingChecker.
 */
class FreeShippingChecker
{
    /**
     * Check if order qualifies for free shipping
     *
     * @param float $orderSubtotal
     * @param float $totalWeight
     * @param int $shippingZoneId
     * @param int|null $shippingMethodId
     * @return FreeShippingRule|null
     */
    public function check(
        float $orderSubtotal,
        float $totalWeight,
        int $shippingZoneId,
        ?int $shippingMethodId = null
    ): ?FreeShippingRule {
        $cacheKey = "free_shipping_{$orderSubtotal}_{$totalWeight}_{$shippingZoneId}_{$shippingMethodId}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use (
            $orderSubtotal,
            $totalWeight,
            $shippingZoneId,
            $shippingMethodId
        ) {
            return FreeShippingRule::query()
                ->where('is_active', true)
                ->where('min_order_amount', '<=', $orderSubtotal)
                // Weight constraint (if specified)
                ->where(function ($query) use ($totalWeight) {
                    $query->whereNull('max_weight')
                        ->orWhere('max_weight', '>=', $totalWeight);
                })
                // Zone constraint (if specified)
                ->where(function ($query) use ($shippingZoneId) {
                    $query->whereNull('shipping_zone_id')
                        ->orWhere('shipping_zone_id', $shippingZoneId);
                })
                // Method constraint (if specified)
                ->where(function ($query) use ($shippingMethodId) {
                    $query->whereNull('shipping_method_id')
                        ->orWhere('shipping_method_id', $shippingMethodId);
                })
                // Time-based constraints
                ->where(function ($query) {
                    $now = now();
                    $query->where(function ($q) use ($now) {
                        $q->whereNull('starts_at')
                            ->orWhere('starts_at', '<=', $now);
                    })->where(function ($q) use ($now) {
                        $q->whereNull('ends_at')
                            ->orWhere('ends_at', '>=', $now);
                    });
                })
                ->orderBy('min_order_amount', 'desc') // Prioritize higher threshold rules
                ->first();
        });
    }

    /**
     * Check how much more is needed for free shipping
     *
     * @param float $currentSubtotal
     * @param int $shippingZoneId
     * @param int|null $shippingMethodId
     * @return array|null ['amount_needed' => float, 'rule' => FreeShippingRule]
     */
    public function getAmountNeededForFreeShipping(
        float $currentSubtotal,
        int $shippingZoneId,
        ?int $shippingMethodId = null
    ): ?array {
        $nextRule = FreeShippingRule::query()
            ->where('is_active', true)
            ->where('min_order_amount', '>', $currentSubtotal)
            // Zone constraint
            ->where(function ($query) use ($shippingZoneId) {
                $query->whereNull('shipping_zone_id')
                    ->orWhere('shipping_zone_id', $shippingZoneId);
            })
            // Method constraint
            ->where(function ($query) use ($shippingMethodId) {
                $query->whereNull('shipping_method_id')
                    ->orWhere('shipping_method_id', $shippingMethodId);
            })
            // Time-based constraints
            ->where(function ($query) {
                $now = now();
                $query->where(function ($q) use ($now) {
                    $q->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', $now);
                })->where(function ($q) use ($now) {
                    $q->whereNull('ends_at')
                        ->orWhere('ends_at', '>=', $now);
                });
            })
            ->orderBy('min_order_amount', 'asc')
            ->first();

        if (!$nextRule) {
            return null;
        }

        return [
            'amount_needed' => $nextRule->min_order_amount - $currentSubtotal,
            'threshold' => $nextRule->min_order_amount,
            'rule' => $nextRule,
        ];
    }

    /**
     * Get all active free shipping rules
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveRules()
    {
        $now = now();

        return FreeShippingRule::query()
            ->where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', $now);
                })->where(function ($q) use ($now) {
                    $q->whereNull('ends_at')
                        ->orWhere('ends_at', '>=', $now);
                });
            })
            ->orderBy('min_order_amount')
            ->get();
    }

    /**
     * Check if any free shipping is available for a zone
     *
     * @param int $shippingZoneId
     * @return bool
     */
    public function hasFreeShippingAvailable(int $shippingZoneId): bool
    {
        return $this->getActiveRules()
            ->where(function ($rule) use ($shippingZoneId) {
                return $rule->shipping_zone_id === null || $rule->shipping_zone_id === $shippingZoneId;
            })
            ->isNotEmpty();
    }
}
