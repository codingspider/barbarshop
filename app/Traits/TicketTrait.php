<?php

namespace App\Traits;
use App\Models\Ticket;
use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

  
trait TicketTrait {

    public function createTicket($customer_id) {
        $service_id = Session::get('service_id');
        $barber_id = Session::get('barber_id');

        $ticket = Ticket::create([
            'ticket_no' => $this->generateTicketNo(),
            'customer_id' => $customer_id,
            'selected_service_id' => $service_id,
            'assigned_barber_id' => $barber_id,
            'status' => OrderStatus::WAITING,
            'created_at' => now(),
            'requested_at' => now(),
        ]);

        return $ticket;
    }


    public function generateTicketNo(){
        return 'T-' . Str::upper(Str::random(8));
    }
}