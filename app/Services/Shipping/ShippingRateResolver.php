<?php

namespace App\Services\Shipping;

use App\Models\ShippingRate;
use Illuminate\Support\Facades\Cache;

/**
 * Class ShippingRateResolver.
 */
class ShippingRateResolver
{
    /**
     * Find the applicable shipping rate for given parameters
     *
     * @param int $shippingZoneId
     * @param int $shippingMethodId
     * @param float $weight
     * @return ShippingRate|null
     */
    public function findRate(int $shippingZoneId, int $shippingMethodId, float $weight): ?ShippingRate
    {
        // Cache key for performance
        $cacheKey = "shipping_rate_{$shippingZoneId}_{$shippingMethodId}_{$weight}";

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($shippingZoneId, $shippingMethodId, $weight) {
            return ShippingRate::query()
                ->where('shipping_zone_id', $shippingZoneId)
                ->where('shipping_method_id', $shippingMethodId)
                ->where('is_active', true)
                ->where('min_weight', '<=', $weight)
                ->where('max_weight', '>=', $weight)
                ->orderBy('price', 'asc') // Get cheapest if multiple matches
                ->first();
        });
    }

    /**
     * Get all rates for a shipping zone and method
     *
     * @param int $shippingZoneId
     * @param int $shippingMethodId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRates(int $shippingZoneId, int $shippingMethodId)
    {
        return ShippingRate::query()
            ->where('shipping_zone_id', $shippingZoneId)
            ->where('shipping_method_id', $shippingMethodId)
            ->where('is_active', true)
            ->orderBy('min_weight')
            ->get();
    }

    /**
     * Get the maximum weight supported for a zone and method
     *
     * @param int $shippingZoneId
     * @param int $shippingMethodId
     * @return float|null
     */
    public function getMaxSupportedWeight(int $shippingZoneId, int $shippingMethodId): ?float
    {
        $rate = ShippingRate::query()
            ->where('shipping_zone_id', $shippingZoneId)
            ->where('shipping_method_id', $shippingMethodId)
            ->where('is_active', true)
            ->orderBy('max_weight', 'desc')
            ->first();

        return $rate?->max_weight;
    }

    /**
     * Check if a weight is shippable to a zone via a method
     *
     * @param int $shippingZoneId
     * @param int $shippingMethodId
     * @param float $weight
     * @return bool
     */
    public function isWeightShippable(int $shippingZoneId, int $shippingMethodId, float $weight): bool
    {
        return $this->findRate($shippingZoneId, $shippingMethodId, $weight) !== null;
    }

    /**
     * Clear rate cache (useful after updating rates)
     */
    public function clearCache(): void
    {
        Cache::flush(); // Or use more specific cache tags if available
    }
}
