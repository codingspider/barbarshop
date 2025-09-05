<?php

namespace App\Models;

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
}
