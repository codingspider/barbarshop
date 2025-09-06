<?php

use Carbon\Carbon;
use App\Models\Ticket;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Auth;
    
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

if (!function_exists('humanDateTime')) {
    function humanDateTime($datetime)
    {
        return Carbon::parse($datetime)->format('F j, Y \\a\\t g:i A');
    }
}

if (!function_exists('getBarberTickets')) {
    function getBarberTickets()
    {
        $id = Auth::guard('user')->user()->id;
        $tickets = Ticket::with('customer')->whereIn('status', [OrderStatus::ASSIGNED, OrderStatus::OPEN])->whereDate('requested_at', Carbon::today())->orderBy('id', 'asc')->paginate(10);
        return $tickets;
    }
}