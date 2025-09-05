<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Service;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(Request $request){
        $data = [];
        return view("user.dashboard", $data);
    }
    
    // public function ticketPrint(Request $request){
    //     return view("user.dashboard", $data);
    // }

    public function allProducts()
    {
        $products = Service::where('active', 1)->get();
        return view('user.products', compact('products'));
    }

    public function customerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required',
        ]);

        try {
            $data = $request->only('name','email', 'phone');
            $data['password'] = Hash::make('12345678'); 
            $data['user_type'] = 'customer'; 

            $customer = User::create($data);

            // Return JSON for AJAX
            return response()->json([
                'success' => true,
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
            ]);
        } catch (\Exception $e) {
            // Return error JSON
            return response()->json([
                'success' => false,
                'message' => 'Failed to add customer: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getPeopleAhead()
    {

        $peopleAhead = Ticket::where('status', OrderStatus::WAITING)
            ->where('created_at', '<', now())
            ->count('id');

        return response()->json(['success' => true, 'total' => $peopleAhead]);
    }

    public function generateTicket($id)
    {
        $ticket = Ticket::with('customer')->where('id', $id)->first();

        $data = [
            'ticket_no' => $ticket->ticket_no,
            'customer_name' => $ticket->customer->name,
            'created_at' => $ticket->created_at->format('d M Y H:i A'),
        ];

        return view('user.ticket', compact('data'));
    }

}
