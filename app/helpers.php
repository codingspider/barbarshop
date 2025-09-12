<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Addon;
use App\Models\Ticket;
use App\Models\Service;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Typography\FontFactory;


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

if (!function_exists('defaultCurrency')) {
    function defaultCurrency()
    {
        $currency = \App\Models\Currency::where('is_default', 1)->first();
        return $currency ? $currency->symbol : null;
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


function serviceName($serviceId)
{
    $service = Service::find($serviceId);

    if (!$service) {
        return '';
    }

    $locale = app()->getLocale();

    return match ($locale) {
        'fr' => $service->name_fr ?? $service->name,
        'ar' => $service->name_ar ?? $service->name,
        default => $service->name,
    };
}

function addonName($addonId)
{
    $addon = Addon::find($addonId);

    if (!$addon) {
        return '';
    }

    $locale = app()->getLocale();

    return match ($locale) {
        'fr' => $addon->name_fr ?? $addon->name,
        'ar' => $addon->name_ar ?? $addon->name,
        default => $addon->name,
    };
}


function generateTextImage(string $escposText, string $fontFile, int $imgWidth = 384, string $outputFile = 'ticket.png')
{
    // Split your ESC/POS-like text into lines
    $lines = preg_split("/\r\n|\n|\r/", $escposText);

    $lineHeight = 20; // adjust spacing
    $imgHeight = count($lines) * $lineHeight + 40;

    $manager = ImageManager::gd();
    $image = $manager->create($imgWidth, $imgHeight)->fill('#ffffff');

    $y = 30; // padding top
    foreach ($lines as $line) {
        $image->text($line, $imgWidth / 2, $y, function (FontFactory $font) use ($fontFile) {
            $font->filename($fontFile); // Arabic capable font e.g. Amiri-Regular.ttf
            $font->size(18);
            $font->align('center');
            $font->valign('top');
            $font->color('#000000');
        });
        $y += $lineHeight;
    }

    $path = public_path($outputFile);
    $image->save($path);

    return $path;
}


function barberAbilityCheck($id){
    $barber = User::where('user_type', 'barber')->where('id', $id)->first();
    if($barber->status == 'active'){
        return true;
    }else{
        return false;
    }
}

function availableCount (){
    $availableCount = User::where('user_type', 'barber')
    ->where('status', 'active')
    ->count();

    return $availableCount;
}