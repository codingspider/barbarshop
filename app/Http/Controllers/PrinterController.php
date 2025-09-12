<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\OrderItemAddon;
use Illuminate\Support\Facades\Session;

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
            $ticket = Ticket::with(['service', 'order.items'])->findOrFail($id);
            $barber_id = Session::get('barber_id');     
            $data = getBarberSchedule($barber_id);

            // ESC/POS string
            $escpos  = "\x1B@"; // Initialize printer

            // === Centered Store/App Name ===
            $escpos .= "\x1B\x61\x01"; // Align center
            $escpos .= "\x1B!\x38" . strtoupper(config('app.name')) . "\n"; // Big bold text
            $escpos .= "\x1B!\x00"; // Normal text
            $escpos .= "--------------------------------\n";

            // === Ticket/Invoice Info ===
            $escpos .= "\x1B\x61\x00"; // Align left
            $escpos .= "Ticket No : #" . $ticket->ticket_no . "\n";
            $escpos .= "Invoice No: INV-" . str_pad($ticket->id, 6, "0", STR_PAD_LEFT) . "\n";
            $escpos .= "Date      : " . $ticket->created_at->format('Y-m-d H:i') . "\n";
            $escpos .= "Minutes   : " . $data['time'] . "\n";
            $escpos .= "Waiting # : " . $data['waiting'] . "\n";
            $escpos .= "--------------------------------\n";

            // === Services + Addons ===
            $total = 0;
            if ($ticket->order) {
                foreach ($ticket->order->items as $item) {
                    // Service item
                    $line = str_pad($item->name, 22) . str_pad(formatPrice($item->price, 2), 10, ' ', STR_PAD_LEFT);
                    $escpos .= $line . "\n";
                    $total += $item->price;

                    // Addons
                    $addons = OrderItemAddon::where('order_id', $item->id)->get();
                    foreach ($addons ?? [] as $addon) {
                        $line = "  + " . str_pad($addon->name, 18) . str_pad(formatPrice($addon->price, 2), 10, ' ', STR_PAD_LEFT);
                        $escpos .= $line . "\n";
                        $total += $addon->price;
                    }
                }
            }

            $escpos .= "--------------------------------\n";

            // === Totals ===
            $escpos .= str_pad("Subtotal", 22) . str_pad(formatPrice($total, 2), 10, ' ', STR_PAD_LEFT) . "\n";

            // Optional tax/discount
            $tax = 0; // Example only
            $grandTotal = $total + $tax;

            if ($tax > 0) {
                $escpos .= str_pad("Tax", 22) . str_pad(formatPrice($tax, 2), 10, ' ', STR_PAD_LEFT) . "\n";
            }

            $escpos .= str_pad("TOTAL", 22) . str_pad(formatPrice($grandTotal, 2), 10, ' ', STR_PAD_LEFT) . "\n";
            $escpos .= "--------------------------------\n";

            // === Footer ===
            $escpos .= "\x1B\x61\x01"; // Centered
            $escpos .= "Please wait for your turn\n";
            $escpos .= "Thank you for visiting!\n";
            $escpos .= "--------------------------------\n\n";

            // Cut paper
            $escpos .= "\x1D\x56\x41";



            $payload = base64_encode($escpos);

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
