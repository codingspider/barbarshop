public function ticketPrint($id)
    {
        try {
            $ticket = Ticket::with(['barber','service', 'order.items'])->findOrFail($id);
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
            $escpos .= __("messages.ticket_no") . " : #" . $ticket->ticket_no . "\n";
            $escpos .= __("messages.barber") . " : " . $ticket->barber?->name . "\n";
            $escpos .= __("messages.invoice_no") . ": INV-" . str_pad($ticket->id, 6, "0", STR_PAD_LEFT) . "\n";
            $escpos .= __("messages.date") . "      : " . $ticket->created_at->format('Y-m-d H:i') . "\n";
            $escpos .= __("messages.minutes") . "   : " . $data['time'] . "\n";
            $escpos .= __("messages.waiting") . "   : " . $data['waiting'] . "\n";
            $escpos .= "--------------------------------\n";

            // === Services + Addons ===
            $total = 0;
            $currentLocale = app()->getLocale();

            if ($ticket->order) {
                foreach ($ticket->order->items as $item) {
                    // Service item
                    $service = Service::find($item['item_id']);
                    if($service && $currentLocale == 'fr'){
                        $name = $service->name_fr;
                    }elseif($service && $currentLocale == 'ar'){
                        $name = $service->name_ar;
                    }else{
                        $name = $service->name;
                    }

                    $line = str_pad($name, 22) . str_pad(formatPrice($service->price, 2), 10, ' ', STR_PAD_LEFT);
                    $escpos .= $line . "\n";
                    $total += $service->price;

                    // Addons
                    $order_addons = OrderItemAddon::where('order_id', $ticket->order->id)->get();
                    

                    foreach ($order_addons ?? [] as $addon) {
                        $main_addon = Addon::find($addon['addon_id']);

                        if($main_addon && $currentLocale == 'fr'){
                            $addon_name = $main_addon->name_fr;
                        }elseif($main_addon && $currentLocale == 'ar'){
                            $addon_name = $main_addon->name_ar;
                        }else{
                            $addon_name = $main_addon->name;
                        }

                        $line = "  + " . str_pad($addon_name, 18) . str_pad(formatPrice($addon->price, 2), 10, ' ', STR_PAD_LEFT);
                        $escpos .= $line . "\n";
                        $total += $addon->price;
                    }
                }
            }

            $escpos .= "--------------------------------\n";

            // === Totals ===
            $escpos .= str_pad(__("messages.subtotal"), 22) . str_pad(formatPrice($total, 2), 10, ' ', STR_PAD_LEFT) . "\n";

            // Optional tax/discount
            $tax = 0; // Example only
            $grandTotal = $total + $tax;

            if ($tax > 0) {
                $escpos .= str_pad("Tax", 22) . str_pad(formatPrice($tax, 2), 10, ' ', STR_PAD_LEFT) . "\n";
            }

            $escpos .= str_pad(__("messages.total"), 22) . str_pad(formatPrice($grandTotal, 2), 10, ' ', STR_PAD_LEFT) . "\n";
            $escpos .= "--------------------------------\n";

            // === Footer ===
            $escpos .= "\x1B\x61\x01"; // Centered
            $escpos .= __("messages.your_turn") . "\n";
            $escpos .= __("messages.thank_you") . "\n";

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