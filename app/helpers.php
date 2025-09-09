<?php

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Service;
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

if (!function_exists('getBarberSchedule')) {
    function getBarberSchedule($barberId)
    {
        // Get waiting tickets for this barber
        $tickets = Ticket::query()
            ->where('assigned_barber_id', $barberId)
            ->where('status', 'waiting')
            ->get();

        // Extract service IDs
        $serviceIds = $tickets->pluck('selected_service_id')->toArray();

        // Sum service durations
        $sum = 0;
        foreach($serviceIds as $id){
            $totalDuration = Service::where('id', $id)->first();
            $sum += $totalDuration->duration_minutes;
        }

        return [
            'waiting' => $tickets->count(),
            'time'    => $sum
        ];
    }
}


if (!function_exists('uploadPublicImage')) {
    function uploadPublicImage($file, $folder = 'images', $filename = null)
    {
        if (!$file) return null;

        $filename = $filename ?? time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $destinationPath = public_path($folder);

        // Create folder if not exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);

        // Return URL accessible via browser
        return asset($folder . '/' . $filename);
    }
}