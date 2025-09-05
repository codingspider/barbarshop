<?php

namespace App\Traits;
use App\Models\Ticket;
use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

  
trait TicketTrait {

    public function createTicket($customer_id) {
        $ticket = Ticket::create([
            'ticket_no' => $this->generateTicketNo(),
            'customer_id' => $customer_id,
            'status' => OrderStatus::WAITING,
            'requested_at'  => now(),
            'created_at' => now()
        ]);

        return $ticket;
    }


    public function generateTicketNo(){
        return 'T-' . Str::upper(Str::random(8));
    }
}