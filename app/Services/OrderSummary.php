<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * OrderSummary Service
 *
 * Calculates and formats order summary including:
 * - Subtotal
 * - Discounts
 * - Shipping
 * - Tax (reserved for future)
 * - Total
 */
class OrderSummary
{
    protected ShippingCalculator $shippingCalculator;

    public function __construct(ShippingCalculator $shippingCalculator)
    {
        $this->shippingCalculator = $shippingCalculator;
    }

    /**
     * Generate complete order summary
     *
     * @param Cart $cart
     * @param Address|null $address
     * @param array|null $selectedShippingOption Format: ['method_id' => int, 'rate_id' => int|null]
     * @return array
     */
    public function generate(Cart $cart, ?Address $address = null, ?array $selectedShippingOption = null): array
    {
        try {
            // Calculate items summary
            $itemsSummary = $this->calculateItemsSummary($cart);


            \Log::info($address);
            // Calculate shipping
            $shippingSummary = $this->calculateShippingSummary($cart, $address, $selectedShippingOption);

            // Calculate tax (reserved for future use)
            $taxSummary = $this->calculateTaxSummary($itemsSummary['subtotal'], $shippingSummary['shipping_cost']);

            // Calculate total
            $total = $itemsSummary['subtotal'] + $shippingSummary['shipping_cost'] + $taxSummary['tax_amount'];

            return [
                'success' => true,
                'items' => $itemsSummary,
                'shipping' => $shippingSummary,
                'tax' => $taxSummary,
                'total' => round($total, 2),
                'formatted' => [
                    'subtotal' => 'KSh ' . number_format($itemsSummary['subtotal'], 2),
                    'discount' => $itemsSummary['discount_amount'] > 0 ? 'KSh ' . number_format($itemsSummary['discount_amount'], 2) : null,
                    'shipping' => $shippingSummary['shipping_cost'] > 0 ? 'KSh ' . number_format($shippingSummary['shipping_cost'], 2) : 'FREE',
                    'tax' => $taxSummary['tax_amount'] > 0 ? 'KSh ' . number_format($taxSummary['tax_amount'], 2) : null,
                    'total' => 'KSh ' . number_format($total, 2),
                ],
            ];
        } catch (Exception $e) {
            Log::error('Order summary generation error', [
                'cart_id' => $cart->id,
                'address_id' => $address?->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Unable to calculate order summary. Please try again.',
                'items' => [
                    'subtotal' => 0,
                    'discount_amount' => 0,
                    'items_count' => 0,
                ],
                'shipping' => [
                    'shipping_cost' => 0,
                    'available' => false,
                ],
                'tax' => [
                    'tax_amount' => 0,
                    'tax_rate' => 0,
                ],
                'total' => 0,
            ];
        }
    }

    /**
     * Calculate items summary (subtotal, discounts)
     *
     * @param Cart $cart
     * @return array
     */
    protected function calculateItemsSummary(Cart $cart): array
    {
        $subtotal = 0;
        $originalTotal = 0;
        $itemsCount = 0;

        foreach ($cart->items as $item) {
            if (!$item->product) {
                continue;
            }

            $quantity = $item->quantity;
            $finalPrice = $item->product->final_price;
            $originalPrice = $item->product->price;

            $subtotal += ($finalPrice * $quantity);
            $originalTotal += ($originalPrice * $quantity);
            $itemsCount += $quantity;
        }

        $discountAmount = $originalTotal - $subtotal;

        return [
            'subtotal' => round($subtotal, 2),
            'original_total' => round($originalTotal, 2),
            'discount_amount' => round($discountAmount, 2),
            'items_count' => $itemsCount,
            'has_discount' => $discountAmount > 0,
        ];
    }

    /**
     * Calculate shipping summary
     *
     * @param Cart $cart
     * @param Address|null $address
     * @param array|null $selectedShippingOption
     * @return array
     */
    protected function calculateShippingSummary(Cart $cart, ?Address $address, ?array $selectedShippingOption): array
    {
        \Log::info('Calculating shipping summary', [
            'cart_id' => $cart->id,
            'address_id' => $address?->id,
            'selected_shipping_option' => $selectedShippingOption,
        ]);
        if (!$address) {
            return [
                'shipping_cost' => 0,
                'original_shipping_cost' => 0,
                'available' => false,
                'message' => 'Select delivery address to calculate shipping',
                'options' => [],
                'selected_option' => null,
            ];
        }

        // Calculate all available shipping options
        $shippingResult = $this->shippingCalculator->calculateShippingOptions($cart, $address);

        if (!$shippingResult['success'] || empty($shippingResult['options'])) {
            return [
                'shipping_cost' => 0,
                'original_shipping_cost' => 0,
                'available' => false,
                'message' => $shippingResult['message'] ?? 'No shipping options available',
                'options' => [],
                'selected_option' => null,
            ];
        }

        $options = $shippingResult['options'];

        // Determine which option to use
        $selectedOption = null;

        if ($selectedShippingOption) {
            // User has selected a specific option
            $selectedOption = collect($options)->first(function ($option) use ($selectedShippingOption) {
                return $option['method_id'] === $selectedShippingOption['method_id'];
            });
        }

        // If no selection or invalid selection, use cheapest option as default
        if (!$selectedOption) {
            $selectedOption = $this->shippingCalculator->getCheapestOption($options);
        }

        return [
            'shipping_cost' => $selectedOption ? round($selectedOption['final_price'], 2) : 0,
            'original_shipping_cost' => $selectedOption ? round($selectedOption['original_price'], 2) : 0,
            'is_free' => $selectedOption ? $selectedOption['is_free'] : false,
            'available' => true,
            'message' => null,
            'options' => $options,
            'selected_option' => $selectedOption,
            'total_weight' => $shippingResult['total_weight'],
            'zone_name' => $shippingResult['zone_name'] ?? null,
        ];
    }

    /**
     * Calculate tax summary
     *
     * RESERVED FOR FUTURE IMPLEMENTATION
     * Kenya VAT is 16% but can be inclusive or exclusive
     *
     * @param float $subtotal
     * @param float $shippingCost
     * @return array
     */
    protected function calculateTaxSummary(float $subtotal, float $shippingCost): array
    {
        // Currently not implementing tax
        // When implementing, uncomment and adjust the following:

        /*
        // Option 1: Tax on subtotal only
        $taxableAmount = $subtotal;

        // Option 2: Tax on subtotal + shipping
        // $taxableAmount = $subtotal + $shippingCost;

        $taxRate = 0.16; // 16% VAT
        $taxAmount = $taxableAmount * $taxRate;

        return [
            'tax_amount' => round($taxAmount, 2),
            'tax_rate' => $taxRate,
            'tax_percentage' => ($taxRate * 100) . '%',
            'taxable_amount' => round($taxableAmount, 2),
            'is_inclusive' => false, // or true if prices already include VAT
        ];
        */

        return [
            'tax_amount' => 0,
            'tax_rate' => 0,
            'tax_percentage' => null,
            'taxable_amount' => 0,
            'is_inclusive' => null,
        ];
    }

    /**
     * Get order summary breakdown for display
     *
     * @param Cart $cart
     * @param Address|null $address
     * @param array|null $selectedShippingOption
     * @return array
     */
    public function getBreakdown(Cart $cart, ?Address $address = null, ?array $selectedShippingOption = null): array
    {
        $summary = $this->generate($cart, $address, $selectedShippingOption);

        if (!$summary['success']) {
            return $summary;
        }

        $breakdown = [];

        // Subtotal
        $breakdown[] = [
            'label' => 'Subtotal',
            'sublabel' => $summary['items']['items_count'] . ' item(s)',
            'amount' => $summary['items']['subtotal'],
            'formatted' => $summary['formatted']['subtotal'],
            'type' => 'subtotal',
        ];

        // Discount (if any)
        if ($summary['items']['has_discount']) {
            $breakdown[] = [
                'label' => 'Discount',
                'sublabel' => 'Product savings',
                'amount' => -$summary['items']['discount_amount'],
                'formatted' => '- ' . $summary['formatted']['discount'],
                'type' => 'discount',
                'is_savings' => true,
            ];
        }

        // Shipping
        if ($summary['shipping']['available']) {
            $shippingLabel = $summary['shipping']['selected_option']['method_name'] ?? 'Shipping';

            if ($summary['shipping']['is_free'] && $summary['shipping']['original_shipping_cost'] > 0) {
                // Free shipping with original cost (show savings)
                $breakdown[] = [
                    'label' => $shippingLabel,
                    'sublabel' => $summary['shipping']['selected_option']['estimated_delivery'] ?? null,
                    'amount' => 0,
                    'original_amount' => $summary['shipping']['original_shipping_cost'],
                    'formatted' => 'FREE',
                    'original_formatted' => 'KSh ' . number_format($summary['shipping']['original_shipping_cost'], 2),
                    'type' => 'shipping',
                    'is_free' => true,
                ];
            } else {
                // Regular shipping cost
                $breakdown[] = [
                    'label' => $shippingLabel,
                    'sublabel' => $summary['shipping']['selected_option']['estimated_delivery'] ?? null,
                    'amount' => $summary['shipping']['shipping_cost'],
                    'formatted' => $summary['formatted']['shipping'],
                    'type' => 'shipping',
                    'is_free' => $summary['shipping']['is_free'],
                ];
            }
        } else {
            // Shipping not yet calculated
            $breakdown[] = [
                'label' => 'Shipping',
                'sublabel' => $summary['shipping']['message'] ?? 'To be calculated',
                'amount' => 0,
                'formatted' => 'TBD',
                'type' => 'shipping',
                'not_calculated' => true,
            ];
        }

        // Tax (if applicable in future)
        if ($summary['tax']['tax_amount'] > 0) {
            $breakdown[] = [
                'label' => 'VAT (' . $summary['tax']['tax_percentage'] . ')',
                'sublabel' => null,
                'amount' => $summary['tax']['tax_amount'],
                'formatted' => $summary['formatted']['tax'],
                'type' => 'tax',
            ];
        }

        // Total
        $breakdown[] = [
            'label' => 'Total',
            'sublabel' => null,
            'amount' => $summary['total'],
            'formatted' => $summary['formatted']['total'],
            'type' => 'total',
            'is_bold' => true,
        ];

        return [
            'success' => true,
            'breakdown' => $breakdown,
            'summary' => $summary,
        ];
    }

    /**
     * Quick summary for cart badge/mini cart
     *
     * @param Cart $cart
     * @return array
     */
    public function quickSummary(Cart $cart): array
    {
        $itemsSummary = $this->calculateItemsSummary($cart);

        return [
            'items_count' => $itemsSummary['items_count'],
            'subtotal' => $itemsSummary['subtotal'],
            'formatted_subtotal' => 'KSh ' . number_format($itemsSummary['subtotal'], 2),
        ];
    }
}
