<?php

namespace App\Http\Controllers\User;

use App\Traits\OrderTrait;
use App\Traits\TicketTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    use TicketTrait;
    use OrderTrait;

    public function ticketStore(Request $request)
    {
        // Create validator
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $cartTotal = Cart::total();
            $cartItems = Cart::content();
            $cartSubtotal = Cart::subtotal();
            $customer_id = $request->customer_id;

            $ticket = $this->createTicket($customer_id);
            $order = $this->createOrder($customer_id, $ticket, $cartTotal, $cartSubtotal);
            $items = $this->createOrderItems($order, $cartItems);
            Cart::destroy();
            DB::commit();

            return response()->json(['success' => true, 'ticket_id' => $ticket->id,'message' => 'Ticket created successfully !']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
