<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id =  Auth::guard('user')->user()->id;
        $tickets = Ticket::with('customer')->where('status', OrderStatus::WAITING)->where('assigned_barber_id', $id)->orderBy('id', 'asc')->paginate(10);
        return view('user.home', compact('tickets'));
    }
}
