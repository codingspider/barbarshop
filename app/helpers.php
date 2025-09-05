<?php
    
if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        static $currency = null;
        if ($currency === null) {
            $currency = \App\Models\Currency::where('is_default', 1)->first();
        }

        return $currency ? $currency->symbol . '' . number_format($price, 2) : $price;
    }
}