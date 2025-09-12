<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Ticket;
use App\Models\Service;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use App\Models\OrderItemAddon;
use Illuminate\Support\Facades\Session;

class PrinterController extends Controller
{
    public function ticketPrint($id)
    {
        try {
            $ticket = Ticket::with(['barber','service', 'order.items'])->findOrFail($id);
            $barber_id = Session::get('barber_id');     
            $data = getBarberSchedule($barber_id);

            $currentLocale = app()->getLocale();

            // === Build plain string instead of ESC/POS ===
            $text  = strtoupper(config('app.name')) . "\n";
            $text .= "--------------------------------\n";
            $text .= __("messages.ticket_no") . " : #" . $ticket->ticket_no . "\n";
            $text .= __("messages.barber") . " : " . $ticket->barber?->name . "\n";
            $text .= __("messages.invoice_no") . ": INV-" . str_pad($ticket->id, 6, "0", STR_PAD_LEFT) . "\n";
            $text .= __("messages.date") . "      : " . $ticket->created_at->format('Y-m-d H:i') . "\n";
            $text .= __("messages.minutes") . "   : " . $data['time'] . "\n";
            $text .= __("messages.waiting") . "   : " . $data['waiting'] . "\n";
            $text .= "--------------------------------\n";

            // === Services + Addons ===
            $total = 0;
            if ($ticket->order) {
                foreach ($ticket->order->items as $item) {
                    $service = Service::find($item['item_id']);
                    $name = $service?->{"name_" . $currentLocale} ?? $service?->name ?? '';
                    $text .= str_pad($name, 22) . str_pad(formatPrice($service->price, 2), 10, ' ', STR_PAD_LEFT) . "\n";
                    $total += $service->price;

                    $order_addons = OrderItemAddon::where('order_id', $ticket->order->id)->get();
                    foreach ($order_addons as $addon) {
                        $main_addon = Addon::find($addon['addon_id']);
                        $addon_name = $main_addon?->{"name_" . $currentLocale} ?? $main_addon?->name ?? '';
                        $text .= "  + " . str_pad($addon_name, 18) . str_pad(formatPrice($addon->price, 2), 10, ' ', STR_PAD_LEFT) . "\n";
                        $total += $addon->price;
                    }
                }
            }

            $text .= "--------------------------------\n";
            $text .= str_pad(__("messages.subtotal"), 22) . str_pad(formatPrice($total, 2), 10, ' ', STR_PAD_LEFT) . "\n";
            $text .= str_pad(__("messages.total"), 22) . str_pad(formatPrice($total, 2), 10, ' ', STR_PAD_LEFT) . "\n";
            $text .= "--------------------------------\n";
            $text .= __("messages.your_turn") . "\n";
            $text .= __("messages.thank_you") . "\n";
            $text .= "--------------------------------\n";

            // === Generate image from plain text ===
            $fontFile = public_path('fonts/amiri.ttf'); // Arabic font

            $imgPath = generateTextImage($text, $fontFile);

            // === Convert to base64 for RawBT ===
            $payload = base64_encode(file_get_contents($imgPath));

            return view('user.ticket', compact('payload'));

        } catch (\Exception $e) {
            \Log::error("Ticket print failed: " . $e->getMessage() . " in file " . $e->getFile() . " on line " . $e->getLine());
            return response()->json([
                'status' => 'error',
                'message' => 'Print failed: ' . $e->getMessage()
            ]);
        }
    }


}
