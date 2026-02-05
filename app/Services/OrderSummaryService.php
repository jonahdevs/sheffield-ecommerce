<?php

namespace App\Services;

/**
 * Class OrderSummaryService.
 */
class OrderSummaryService
{

    public function summary()
    {
        $subtotal = $this->calculateSubtotal();
        $discount = $this->calculateDiscount();
        $shipping_cost = 0;
        $tax = 0;
        $total = $this->calculateTotal();

        return [
            'subtotal' => format_currency($subtotal),
            'discount' => format_currency($discount),
            'shipping_cost' => format_currency($shipping_cost),
            'tax' => $tax,
            'total' => format_currency($total),
        ];
    }

    protected function calculateSubtotal()
    {
        $subtotal = auth()->user()->cart->items->reduce(function ($carry, $item) {
            return $carry + ($item->product->final_price * $item->quantity);
        }, 0);

        return $subtotal;
    }

    public function calculateDiscount()
    {
        $discount = auth()->user()->cart->items->reduce(function ($carry, $item) {
            $product = $item->product;

            if (!$product->sale_price) {
                return $carry;
            }

            return $carry + (($item->product->price - $item->product->sale_price) * $item->quantity);
        }, 0);

        return $discount;
    }

    public function calculateShippingCost()
    {
        return 0;
    }

    public function calculateTax()
    {
        return 0;
    }

    public function calculateTotal()
    {
        $subtotal = $this->calculateSubtotal();
        $discount = $this->calculateDiscount();
        $shipping_cost = $this->calculateShippingCost();
        $tax = $this->calculateTax();

        return $subtotal + $shipping_cost + $tax;
    }

}
