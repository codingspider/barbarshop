<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    // public function ticketPrint($id)
    // {
    //     try {
    //         $ticket = Ticket::findOrFail($id);
    //         return view('user.ticket', compact('ticket'));
    //     } catch (\Exception $e) {
    //         \Log::error("Ticket print failed: " . $e->getMessage());
    //         return response()->json(['status' => 'error', 'message' => 'Print failed: ' . $e->getMessage()]);
    //     }
    // }
    
    // public function ticketPrint($id)
    // {
    //     try {
    //         $ticket = Ticket::findOrFail($id);

    //         // 🖨 ESC/POS string dynamically
    //         $escpos =
    //             "\x1B@" .
    //             "\x1B!\x38" . strtoupper(config('app.name')) . "\n" . 
    //             "\x1B!\x00" .
    //             "Ticket No: #" . $ticket->ticket_no . "\n" .
    //             "Date: " . $ticket->created_at->format('Y-m-d H:i') . "\n\n";

    //         $escpos .= "---------------------------\n";
    //         $escpos .= "Please wait for your turn\n";
    //         $escpos .= "Thank you for visiting!\n\n";
    //         $escpos .= "\x1D\x56\x41"; // Cut
    //         $payload = base64_encode($escpos);

    //         return view('user.ticket', compact('payload', 'ticket'));

    //     } catch (\Exception $e) {
    //         \Log::error("Ticket print failed: " . $e->getMessage());
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Print failed: ' . $e->getMessage()
    //         ]);
    //     }
    // }

    public function ticketPrint($id)
    {
        try {
            $ticket = Ticket::with(['service', 'addons'])->findOrFail($id);
            $barber_id = Session::get('barber_id');     
            $data = getBarberSchedule($barber_id);

            // ESC/POS string
            $escpos  = "\x1B@"; // Initialize printer

            // === Logo (if supported by RawBT) ===
            // RawBT supports only text or inline images via Base64 ESC/POS.
            // Example text logo (instead of image for compatibility)
            $escpos .= "\x1B!\x38" . strtoupper(config('app.name')) . "\n";
            $escpos .= "\x1B!\x00"; // Normal text

            // === Ticket/Invoice Info ===
            $escpos .= "Ticket No: #" . $ticket->ticket_no . "\n";
            $escpos .= "Invoice No: INV-" . str_pad($ticket->id, 6, "0", STR_PAD_LEFT) . "\n";
            $escpos .= "Date: " . $ticket->created_at->format('Y-m-d H:i') . "\n";
            $escpos .= "Minutes: " . $data['time'] . "\n";
            $escpos .= "Waiting No: " . $data['waiting'] . "\n\n";

            $escpos .= "---------------------------\n";

            // === Services + Addons ===
            if ($ticket->orders && $ticket->orders->items->count() > 0) {
                foreach ($ticket->orders->items as $item) {
                    $escpos .= $item->name . "   " . formatPrice($item->price, 2) . "\n";

                    // Addons for this order
                    $addons = $ticket->orders->order_addon_items->where('order_id', $item->id);
                    if ($addons->count() > 0) {
                        foreach ($addons as $addon) {
                            $escpos .= "  + " . $addon->name . "   " . formatPrice($addon->price, 2) . "\n";
                        }
                    }
                }
            }

            $escpos .= "---------------------------\n";
            $escpos .= "Please wait for your turn\n";
            $escpos .= "Thank you for visiting!\n\n";

            // Cut paper
            $escpos .= "\x1D\x56\x41";

            $payload = base64_encode($escpos);

            return view('user.ticket', compact('payload'));

        } catch (\Exception $e) {
            \Log::error("Ticket print failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Print failed: ' . $e->getMessage()
            ]);
        }
    }

}
