<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\FreeShippingRule;
use App\Models\PickupStation;
use App\Models\ShippingMethod;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ShippingCalculator Service
 *
 * Handles all shipping cost calculations including:
 * - Weight-based rate calculation
 * - Free shipping rule application
 * - Pickup station logic
 * - Multi-rate comparison
 */
class ShippingCalculator
{
    /**
     * Calculate shipping options for a given cart and address
     *
     * @param Cart $cart
     * @param Address|null $address
     * @return array
     */
    public function calculateShippingOptions(Cart $cart, ?Address $address = null): array
    {
        try {
            // If no address provided, return empty options
            if (!$address) {
                return [
                    'success' => false,
                    'message' => 'Please select a delivery address to calculate shipping costs',
                    'options' => [],
                    'total_weight' => 0,
                ];
            }

            // Calculate total cart weight
            $totalWeight = $this->calculateCartWeight($cart);

            if ($totalWeight < 0) {
                return [
                    'success' => false,
                    'message' => 'Unable to calculate shipping - products have no weight information',
                    'options' => [],
                    'total_weight' => 0,
                ];
            }

            // Get shipping zone from address
            $shippingZone = ShippingZone::find($address->shipping_zone_id);

            if (!$shippingZone || !$shippingZone->is_active) {
                return [
                    'success' => false,
                    'message' => 'Shipping is not available for your selected area',
                    'options' => [],
                    'total_weight' => $totalWeight,
                ];
            }

            // Get all active shipping methods
            $shippingMethods = ShippingMethod::where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            $options = [];
            $cartSubtotal = $this->calculateSubtotal($cart);

            foreach ($shippingMethods as $method) {
                $option = $this->calculateMethodOption(
                    $method,
                    $shippingZone,
                    $totalWeight,
                    $cartSubtotal,
                    $address
                );

                if ($option) {
                    $options[] = $option;
                }
            }

            return [
                'success' => true,
                'message' => count($options) > 0 ? 'Shipping options available' : 'No shipping options available for your location',
                'options' => $options,
                'total_weight' => $totalWeight,
                'zone_name' => $shippingZone->name,
            ];
        } catch (Exception $e) {
            Log::error('Shipping calculation error', [
                'cart_id' => $cart->id,
                'address_id' => $address?->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Unable to calculate shipping at this time. Please try again.',
                'options' => [],
                'total_weight' => 0,
            ];
        }
    }

    /**
     * Calculate shipping option for a specific method
     *
     * @param ShippingMethod $method
     * @param ShippingZone $zone
     * @param float $weight
     * @param float $subtotal
     * @param Address $address
     * @return array|null
     */
    protected function calculateMethodOption(
        ShippingMethod $method,
        ShippingZone $zone,
        float $weight,
        float $subtotal,
        Address $address
    ): ?array {
        // Special handling for pickup method
        if ($method->code === 'pickup') {
            return $this->calculatePickupOption($method, $address);
        }

        // Find matching shipping rate
        $rate = $this->findMatchingRate($zone->id, $method->id, $weight);

        if (!$rate) {
            // No rate found for this weight/zone/method combination
            return null;
        }

        // Check for free shipping rules
        $freeShippingRule = $this->checkFreeShipping($zone->id, $method->id, $subtotal, $weight);

        $originalPrice = (float) $rate->price;
        $finalPrice = $freeShippingRule ? 0 : $originalPrice;
        $isFree = $freeShippingRule !== null;

        return [
            'method_id' => $method->id,
            'method_code' => $method->code,
            'method_name' => $method->name,
            'method_description' => $method->description,
            'method_icon' => $method->icon,
            'rate_id' => $rate->id,
            'rate_name' => $rate->name,
            'original_price' => $originalPrice,
            'final_price' => $finalPrice,
            'is_free' => $isFree,
            'free_shipping_rule' => $freeShippingRule ? [
                'id' => $freeShippingRule->id,
                'name' => $freeShippingRule->name,
            ] : null,
            'estimated_days_min' => $rate->estimated_days_min,
            'estimated_days_max' => $rate->estimated_days_max,
            'estimated_delivery' => $this->formatEstimatedDelivery($rate->estimated_days_min, $rate->estimated_days_max),
            'weight_range' => [
                'min' => (float) $rate->min_weight,
                'max' => (float) $rate->max_weight,
            ],
        ];
    }

    /**
     * Calculate pickup option (always free)
     *
     * @param ShippingMethod $method
     * @param Address $address
     * @return array|null
     */
    protected function calculatePickupOption(ShippingMethod $method, Address $address): ?array
    {
        // Get available pickup stations in the user's county/area
        $pickupStations = PickupStation::where('is_active', true)
            ->where('county_id', $address->county_id)
            ->when($address->area_id, function ($query) use ($address) {
                $query->where('area_id', $address->area_id);
            })
            ->get();

        if ($pickupStations->isEmpty()) {
            // No pickup stations available in user's area
            return null;
        }

        return [
            'method_id' => $method->id,
            'method_code' => $method->code,
            'method_name' => $method->name,
            'method_description' => $method->description,
            'method_icon' => $method->icon,
            'rate_id' => null,
            'rate_name' => 'Pickup Station',
            'original_price' => 0,
            'final_price' => 0,
            'is_free' => true,
            'free_shipping_rule' => null,
            'estimated_days_min' => 1,
            'estimated_days_max' => 2,
            'estimated_delivery' => 'Available for pickup within 1-2 business days',
            'pickup_stations' => $pickupStations->map(function ($station) {
                return [
                    'id' => $station->id,
                    'name' => $station->name,
                    'address' => $station->address,
                    'phone' => $station->phone,
                    'operating_hours' => $station->operating_hours,
                    'latitude' => $station->latitude,
                    'longitude' => $station->longitude,
                ];
            })->toArray(),
            'weight_range' => null,
        ];
    }

    /**
     * Find matching shipping rate for zone, method and weight
     *
     * RATE MATCHING LOGIC:
     * - Finds rates where weight falls within min_weight and max_weight (inclusive)
     * - If multiple rates match, selects the most specific one (smallest range)
     * - If no exact match, uses the highest available rate for that zone/method
     *
     * @param int $zoneId
     * @param int $methodId
     * @param float $weight
     * @return ShippingRate|null
     */
    protected function findMatchingRate(int $zoneId, int $methodId, float $weight): ?ShippingRate
    {
        // Try to find exact match where weight is within range
        // weight >= min_weight AND weight <= max_weight
        $exactMatches = ShippingRate::where('shipping_zone_id', $zoneId)
            ->where('shipping_method_id', $methodId)
            ->where('is_active', true)
            ->where('min_weight', '<=', $weight)
            ->where('max_weight', '>=', $weight)
            ->orderBy(DB::raw('(max_weight - min_weight)'), 'asc') // Prefer smallest range (most specific)
            ->get();

        if ($exactMatches->isNotEmpty()) {
            return $exactMatches->first();
        }

        // No exact match found - use the highest rate available for this zone/method
        // This handles cases where cart weight exceeds all defined ranges
        $highestRate = ShippingRate::where('shipping_zone_id', $zoneId)
            ->where('shipping_method_id', $methodId)
            ->where('is_active', true)
            ->orderBy('max_weight', 'desc')
            ->first();

        return $highestRate;
    }

    /**
     * Check if free shipping rules apply
     *
     * FREE SHIPPING RULE PRIORITY:
     * 1. Most specific (zone + method specific) wins
     * 2. Zone-specific (any method) second
     * 3. Method-specific (any zone) third
     * 4. Global (any zone + any method) last
     *
     * @param int $zoneId
     * @param int $methodId
     * @param float $subtotal
     * @param float $weight
     * @return FreeShippingRule|null
     */
    protected function checkFreeShipping(int $zoneId, int $methodId, float $subtotal, float $weight): ?FreeShippingRule
    {
        $now = now();

        // Priority 1: Zone + Method specific
        $rule = FreeShippingRule::where('is_active', true)
            ->where('shipping_zone_id', $zoneId)
            ->where('shipping_method_id', $methodId)
            ->where('min_order_amount', '<=', $subtotal)
            ->where(function ($query) use ($weight) {
                $query->whereNull('max_weight')
                    ->orWhere('max_weight', '>=', $weight);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            })
            ->first();

        if ($rule) {
            return $rule;
        }

        // Priority 2: Zone specific (any method)
        $rule = FreeShippingRule::where('is_active', true)
            ->where('shipping_zone_id', $zoneId)
            ->whereNull('shipping_method_id')
            ->where('min_order_amount', '<=', $subtotal)
            ->where(function ($query) use ($weight) {
                $query->whereNull('max_weight')
                    ->orWhere('max_weight', '>=', $weight);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            })
            ->first();

        if ($rule) {
            return $rule;
        }

        // Priority 3: Method specific (any zone)
        $rule = FreeShippingRule::where('is_active', true)
            ->whereNull('shipping_zone_id')
            ->where('shipping_method_id', $methodId)
            ->where('min_order_amount', '<=', $subtotal)
            ->where(function ($query) use ($weight) {
                $query->whereNull('max_weight')
                    ->orWhere('max_weight', '>=', $weight);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            })
            ->first();

        if ($rule) {
            return $rule;
        }

        // Priority 4: Global (any zone, any method)
        $rule = FreeShippingRule::where('is_active', true)
            ->whereNull('shipping_zone_id')
            ->whereNull('shipping_method_id')
            ->where('min_order_amount', '<=', $subtotal)
            ->where(function ($query) use ($weight) {
                $query->whereNull('max_weight')
                    ->orWhere('max_weight', '>=', $weight);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            })
            ->first();

        return $rule;
    }

    /**
     * Calculate total weight of cart items (in grams)
     *
     * @param Cart $cart
     * @return float Weight in KG
     */
    protected function calculateCartWeight(Cart $cart): float
    {
        $totalWeightGrams = $cart->items->reduce(function ($carry, $item) {
            $product = $item->product;

            if (!$product) {
                return $carry;
            }

            // Get weight from variant if available, otherwise from product
            $weightGrams = 0;

            if ($item->variant_id && $item->variant) {
                // Variant has its own weight
                $weightGrams = $item->variant->weight ?? $product->weight ?? 0;
            } else {
                // Use product weight
                $weightGrams = $product->weight ?? 0;
            }

            return $carry + ($weightGrams * $item->quantity);
        }, 0);

        // Convert grams to KG
        return round($totalWeightGrams / 1000, 2);
    }

    /**
     * Calculate cart subtotal
     *
     * @param Cart $cart
     * @return float
     */
    protected function calculateSubtotal(Cart $cart): float
    {
        return $cart->items->reduce(function ($carry, $item) {
            return $carry + ($item->product->final_price * $item->quantity);
        }, 0);
    }

    /**
     * Format estimated delivery time
     *
     * @param int|null $minDays
     * @param int|null $maxDays
     * @return string
     */
    protected function formatEstimatedDelivery(?int $minDays, ?int $maxDays): string
    {
        if (!$minDays && !$maxDays) {
            return 'Delivery time varies';
        }

        if ($minDays && $maxDays && $minDays === $maxDays) {
            return $minDays === 1 ? 'Next business day' : "{$minDays} business days";
        }

        if ($minDays && $maxDays) {
            return "{$minDays}-{$maxDays} business days";
        }

        if ($minDays) {
            return "From {$minDays} business days";
        }

        return "Up to {$maxDays} business days";
    }

    /**
     * Get cheapest shipping option
     *
     * @param array $options
     * @return array|null
     */
    public function getCheapestOption(array $options): ?array
    {
        if (empty($options)) {
            return null;
        }

        return collect($options)->sortBy('final_price')->first();
    }

    /**
     * Get fastest shipping option
     *
     * @param array $options
     * @return array|null
     */
    public function getFastestOption(array $options): ?array
    {
        if (empty($options)) {
            return null;
        }

        return collect($options)->sortBy(function ($option) {
            return $option['estimated_days_min'] ?? 999;
        })->first();
    }

    /**
     * Validate if a specific shipping option is available
     *
     * @param Cart $cart
     * @param Address $address
     * @param int $methodId
     * @param int|null $rateId
     * @return array
     */
    public function validateShippingOption(Cart $cart, Address $address, int $methodId, ?int $rateId = null): array
    {
        $allOptions = $this->calculateShippingOptions($cart, $address);

        if (!$allOptions['success']) {
            return [
                'valid' => false,
                'message' => $allOptions['message'],
            ];
        }

        $selectedOption = collect($allOptions['options'])->first(function ($option) use ($methodId, $rateId) {
            if ($rateId) {
                return $option['method_id'] === $methodId && $option['rate_id'] === $rateId;
            }
            return $option['method_id'] === $methodId;
        });

        if (!$selectedOption) {
            return [
                'valid' => false,
                'message' => 'Selected shipping option is not available',
            ];
        }

        return [
            'valid' => true,
            'option' => $selectedOption,
        ];
    }
}
