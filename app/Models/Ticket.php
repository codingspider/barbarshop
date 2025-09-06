<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = ['id'];
    
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function barber()
    {
        return $this->belongsTo(User::class, 'assigned_barber_id');
    }

    // public function service()
    // {
    //     return $this->belongsTo(Service::class, 'selected_service_id');
    // }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function statusBadge(): string
    {
        $status = $this->status;

        $colors = [
            OrderStatus::PENDING    => 'warning text-dark',
            OrderStatus::PROCESSING => 'info text-dark',
            OrderStatus::COMPLETED  => 'success',
            OrderStatus::CANCELLED  => 'danger',
            OrderStatus::WAITING    => 'secondary',
            OrderStatus::ASSIGNED   => 'primary',
            OrderStatus::IN_SERVICE => 'info text-dark',
            OrderStatus::DONE       => 'success',
            OrderStatus::OPEN       => 'warning text-dark',
            OrderStatus::PAID       => 'success',
            OrderStatus::VOID       => 'danger',
        ];

        $colorClass = $colors[$status] ?? 'secondary';
        $text = __('messages.' . $status);

        return "<span class='badge bg-{$colorClass}'>{$text}</span>";
    }
}
