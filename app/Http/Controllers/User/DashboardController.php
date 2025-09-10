<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Service;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(Request $request){
        $id =  Auth::guard('user')->user()->id;
        $tickets = Ticket::with('customer')->where('status', OrderStatus::WAITING)->where('assigned_barber_id', $id)->orderBy('id', 'asc')->paginate(10);

        return view("user.dashboard", compact('tickets'));
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

    public function ticketWaiting(){
        try {
            $tickets = Ticket::with('customer')->where('status', OrderStatus::WAITING)->whereDate('created_at', Carbon::today())->orderBy('id', 'asc')->paginate(10);
            $barbers = User::where('user_type', 'barber')->get();
            return view('user.dashboard.waiting', compact('tickets', 'barbers'));
        }catch(\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }
    
    public function inService(){
        try {
            $tickets = Ticket::with(['customer', 'barber'])->where('status', OrderStatus::IN_SERVICE)->whereDate('created_at', Carbon::today())->orderBy('id', 'asc')->paginate(10);
            return view('user.dashboard.inservice', compact('tickets'));
        }catch(\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }
    
    public function completed(){
        try {
            $tickets = Ticket::with(['customer', 'barber'])->where('status', OrderStatus::COMPLETED)->whereDate('created_at', Carbon::today())->orderBy('id', 'asc')->paginate(10);
            return view('user.dashboard.completed', compact('tickets'));
        }catch(\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function paymentReceive(){
        $tickets = Ticket::with(['customer', 'order.payments'])
        ->where('status', OrderStatus::DONE)
        ->whereDoesntHave('order.payments')
        ->whereDate('created_at', Carbon::today())
        ->orderBy('id', 'asc')
        ->paginate(10);
        $ticket_payments = Ticket::with(['customer', 'order', 'order.payments'])->whereHas('order.payments')->paginate(10);
        return view('user.dashboard.payment_receive', compact('tickets', 'ticket_payments'));
    }

    public function getTicketDetails($id){
        
        $order = Order::where('ticket_id', $id)->first();
        if($order){
            Session::put('ticket_id', $id);
            Session::put('order_id', $order->id);
            return $order;
        }else{

            return 0;
        }
    }

    public function makePayment(Request $request)
    {
        try {
            // Retrieve session data
            $ticket_id = Session::get('ticket_id');
            $order_id = Session::get('order_id');

            if (!$order_id) {
                return redirect()->route('user.payment-receive')->with('error', 'Order not found in session.');
            }

            // Retrieve order
            $order = Order::find($order_id);
            if (!$order) {
                return redirect()->route('user.payment-receive')->with('error', 'Order not found.');
            }

            // Create payment
            $payment = Payment::create([
                'order_id'     => $order_id,
                'method'       => $request->method,
                'amount'       => $order->total,
                'payment_date' => $request->date ?? now(),
            ]);

            $order->paid_at = now();
            $order->status = 'paid';
            $order->cashier_id = Auth::guard('user')->user()->id;
            $order->save();

            return redirect()->route('user.payment-receive')->with('message', 'Payment recorded successfully.',);

        } catch (\Exception $e) {
            return redirect()->route('user.payment-receive')->with('error', $e->getMessage());
        }
    }

    public function getStatus()
    {
        $users = User::where('user_type', 'barber')->get();
        $data = [];

        foreach ($users as $user) {
            $schedule = getBarberSchedule($user->id);
            $data[] = [
                'id' => $user->id,
                'waiting' => $schedule['waiting'],
                'time' => $schedule['time'],
            ];
        }

        return response()->json($data);
    }
}
