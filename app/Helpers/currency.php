<?php

use Illuminate\Support\Number;

if (!function_exists('format_currency')) {
    /**
     * Format amount as currency
     */
    function format_currency(float|int $amount, ?string $currency = null, ?string $locale = null): string
    {
        $currency = $currency ?? config('app.currency', 'KES');
        $locale = $locale ?? config('app.locale', 'en_KE');
        
        return Number::currency($amount, $currency, $locale);
    }
}

if (!function_exists('format_price')) {
    /**
     * Format price without decimals
     */
    function format_price(float|int $amount, ?string $currency = null): string
    {
        $currency = $currency ?? config('app.currency', 'KES');
        
        return Number::currency(round($amount), $currency);
    }
}
