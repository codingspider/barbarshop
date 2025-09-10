<?php

namespace App\Traits;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

  
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
    
    public function createOrderItems($order, $cartItems)
    {

        foreach ($cartItems as $item) {
            // 1. Save the main service
            $orderItem = OrderItem::create([
                'order_id'      => $order->id,
                'item_type'     => 'service',
                'item_id'       => Session::get('service_id'),
                'name_snapshot' => $item['service'],
                'qty'           => $item['qty'],
                'unit_price'    => $item['price'],
                'line_total'    => $item['total'],
            ]);

            // 2. Save addons in another table (assuming you have OrderItemAddon model)
            // if (!empty($item['addons'])) {
            //     foreach ($item['addons'] as $addon) {
            //         OrderItemAddon::create([
            //             'order_item_id' => $orderItem->id,
            //             'addon_id'      => $addon['id'],
            //             'name_snapshot' => $addon['name'],
            //             'qty'           => 1, // if addons have no qty, default to 1
            //             'unit_price'    => $addon['price'],
            //             'line_total'    => $addon['price'],
            //         ]);
            //     }
            // }
        }

        return $orderItem;
    }

}