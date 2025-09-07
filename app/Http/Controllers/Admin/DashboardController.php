<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function index(Request $request){
        $tickets = Ticket::whereDate('created_at', today())->get();
        $data = [
            'tickets' => $tickets,
            'openTickets' => $tickets->where('status', 'open')->count(),
            'doneTickets' => $tickets->where('status', 'done')->count(),
            'pendingTickets' => $tickets->where('status', 'waiting')->count(),
            'cancelledTickets' => $tickets->where('status', 'cancelled')->count(),
        ];
        return view("admin.dashboard", compact('data'));
    }
}