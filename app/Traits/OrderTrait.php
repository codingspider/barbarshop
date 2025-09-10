<?php

namespace App\Traits;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

  
trait OrderTrait {

    public function createOrder($customer_id, $ticket, $cartTotal, $cartSubtotal) {
        $order = Order::create([
            'customer_id' => $customer_id,
            'ticket_id' => $ticket['id'],
            'subtotal' => (float)$cartSubtotal,
            'total' => (float)$cartTotal,
            'status'  => OrderStatus::OPEN,
            'created_at' => now()
        ]);

        return $order;
    }
    
    
    public function createOrderItems($order, $cartItems) {

        foreach ($cartItems as $key => $value) {
            $order = OrderItem::create([
                'order_id' => $order->id,
                'item_type' => OrderStatus::SERVICE,
                'item_id' => $value->id,
                'name_snapshot' => $value->name,
                'qty'  => $value->qty,
                'unit_price' => $value->price,
                'line_total' => $value->price * $value->qty,
            ]);
        }
        

        return true;
    }
}