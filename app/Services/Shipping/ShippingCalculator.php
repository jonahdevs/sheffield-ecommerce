<?php

namespace App\Services\Shipping;

use App\Models\Address;
use App\Models\ShippingMethod;
use Illuminate\Support\Collection;

/**
 * Class ShippingCalculator.
 */
class ShippingCalculator
{
    protected ShippingRateResolver $rateResolver;
    protected FreeShippingChecker $freeShippingChecker;

    public function __construct(
        ShippingRateResolver $rateResolver,
        FreeShippingChecker $freeShippingChecker
    ) {
        $this->rateResolver = $rateResolver;
        $this->freeShippingChecker = $freeShippingChecker;
    }

    /**
     * Calculate shipping cost for a given cart and address
     *
     * @param Collection $cartItems - Collection of cart items with 'weight' and 'price'
     * @param Address $address
     * @param int|null $shippingMethodId - Optional: specific method to calculate for
     * @return array
     */
    public function calculate(Collection $cartItems, Address $address, ?int $shippingMethodId = null): array
    {
        // Step 1: Calculate totals
        $totalWeight = $this->calculateTotalWeight($cartItems);
        $subtotal = $this->calculateSubtotal($cartItems);

        // Step 2: Get shipping zone from address
        $shippingZoneId = $address->shipping_zone_id;

        // Step 3: Get available shipping methods for this zone
        $availableMethods = $this->getAvailableShippingMethods($shippingZoneId, $totalWeight);

        if ($availableMethods->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No shipping methods available for your location',
                'available_methods' => [],
                'selected_method' => null,
            ];
        }

        // Step 4: Calculate shipping for each method or specific method
        $methodsWithCost = $this->calculateShippingForMethods(
            $availableMethods,
            $shippingZoneId,
            $totalWeight,
            $subtotal,
            $shippingMethodId
        );

        // Step 5: Determine the selected/default method
        $selectedMethod = $this->determineSelectedMethod($methodsWithCost, $shippingMethodId);

        return [
            'success' => true,
            'total_weight' => $totalWeight,
            'subtotal' => $subtotal,
            'shipping_zone_id' => $shippingZoneId,
            'available_methods' => $methodsWithCost,
            'selected_method' => $selectedMethod,
            'shipping_cost' => $selectedMethod['final_cost'] ?? 0,
        ];
    }

    /**
     * Calculate shipping for all available methods
     */
    protected function calculateShippingForMethods(
        Collection $methods,
        int $shippingZoneId,
        float $totalWeight,
        float $subtotal,
        ?int $specificMethodId = null
    ): array {
        $results = [];

        foreach ($methods as $method) {
            // Skip if specific method requested and this isn't it
            if ($specificMethodId && $method->id !== $specificMethodId) {
                continue;
            }

            // Find applicable rate
            $rate = $this->rateResolver->findRate(
                $shippingZoneId,
                $method->id,
                $totalWeight
            );

            if (!$rate) {
                continue;
            }

            $baseCost = $rate->price;

            // Check for free shipping
            $freeShippingRule = $this->freeShippingChecker->check(
                $subtotal,
                $totalWeight,
                $shippingZoneId,
                $method->id
            );

            $finalCost = $freeShippingRule ? 0 : $baseCost;
            $isFree = $freeShippingRule !== null;

            $results[] = [
                'shipping_method_id' => $method->id,
                'shipping_method_name' => $method->name,
                'shipping_method_code' => $method->code,
                'shipping_method_description' => $method->description,
                'shipping_method_icon' => $method->icon,
                'shipping_rate_id' => $rate->id,
                'base_cost' => $baseCost,
                'final_cost' => $finalCost,
                'is_free' => $isFree,
                'free_shipping_rule_id' => $freeShippingRule?->id,
                'free_shipping_rule_name' => $freeShippingRule?->name,
                'estimated_days_min' => $rate->estimated_days_min,
                'estimated_days_max' => $rate->estimated_days_max,
                'estimated_delivery' => $this->formatEstimatedDelivery(
                    $rate->estimated_days_min,
                    $rate->estimated_days_max
                ),
            ];
        }

        return $results;
    }

    /**
     * Calculate total weight of cart items
     */
    protected function calculateTotalWeight(Collection $cartItems): float
    {
        return $cartItems->sum(function ($item) {
            $weight = $item->weight ?? $item->product->weight ?? 0;
            $quantity = $item->quantity ?? 1;
            return $weight * $quantity;
        });
    }

    /**
     * Calculate subtotal of cart items
     */
    protected function calculateSubtotal(Collection $cartItems): float
    {
        return $cartItems->sum(function ($item) {
            $price = $item->price ?? $item->product->price ?? 0;
            $quantity = $item->quantity ?? 1;
            return $price * $quantity;
        });
    }

    /**
     * Get available shipping methods for a zone
     */
    protected function getAvailableShippingMethods(int $shippingZoneId, float $totalWeight): Collection
    {
        return ShippingMethod::query()
            ->where('is_active', true)
            ->whereHas('shippingRates', function ($query) use ($shippingZoneId, $totalWeight) {
                $query->where('shipping_zone_id', $shippingZoneId)
                    ->where('is_active', true)
                    ->where('min_weight', '<=', $totalWeight)
                    ->where('max_weight', '>=', $totalWeight);
            })
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Determine which method is selected (or default to cheapest)
     */
    protected function determineSelectedMethod(array $methodsWithCost, ?int $requestedMethodId): ?array
    {
        if (empty($methodsWithCost)) {
            return null;
        }

        // If specific method requested, return it
        if ($requestedMethodId) {
            foreach ($methodsWithCost as $method) {
                if ($method['shipping_method_id'] === $requestedMethodId) {
                    return $method;
                }
            }
        }

        // Otherwise, return the cheapest method
        return collect($methodsWithCost)->sortBy('final_cost')->first();
    }

    /**
     * Format estimated delivery time
     */
    protected function formatEstimatedDelivery(?int $minDays, ?int $maxDays): ?string
    {
        if (!$minDays && !$maxDays) {
            return null;
        }

        if ($minDays === $maxDays) {
            return "{$minDays} " . str_plural('day', $minDays);
        }

        return "{$minDays}-{$maxDays} days";
    }

    /**
     * Quick method to get just the shipping cost
     */
    public function getShippingCost(Collection $cartItems, Address $address, ?int $shippingMethodId = null): float
    {
        $result = $this->calculate($cartItems, $address, $shippingMethodId);
        return $result['shipping_cost'] ?? 0;
    }

    /**
     * Validate if shipping is available for given parameters
     */
    public function isShippingAvailable(Collection $cartItems, Address $address): bool
    {
        $result = $this->calculate($cartItems, $address);
        return $result['success'] && !empty($result['available_methods']);
    }
}
