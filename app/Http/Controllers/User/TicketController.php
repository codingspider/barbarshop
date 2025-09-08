<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Enums\OrderStatus;
use App\Traits\OrderTrait;
use App\Traits\TicketTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    use TicketTrait;
    use OrderTrait;

    public function ticketStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $cartTotal = Cart::total();
            $cartItems = Cart::content();
            $cartSubtotal = Cart::subtotal();
            $customer_id = Auth::guard('user')->user()->id;

            $ticket = $this->createTicket($customer_id);
            $order = $this->createOrder($customer_id, $ticket, $cartTotal, $cartSubtotal);
            $items = $this->createOrderItems($order, $cartItems);
            Cart::destroy();
            DB::commit();

            return response()->json(['success' => true, 'id' => $ticket->id ]);
           
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function assignBarbar(Request $request)
    {
        // Create validator
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'barber_id' => 'required|exists:users,id',
        ]);

        DB::beginTransaction();
        try {

            $ticket = Ticket::find($request->ticket_id);
            $ticket->assigned_barber_id = $request->barber_id;
            $ticket->status = OrderStatus::ASSIGNED;
            $ticket->requested_at = now();
            $ticket->save();

            DB::commit();

           return redirect()->back()->with('success', 'Barber assigned successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    public function barberAction(Request $request)
    {
        // Create validator
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'status' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $id = Auth::guard('user')->user()->id;
            $ticket = Ticket::where('id', $request->ticket_id)->where('assigned_barber_id', $id)->first();

            if($ticket){
                if($request->status == 'open'){
                    $ticket->status = OrderStatus::IN_SERVICE;
                    $ticket->started_at = now();
                }elseif($request->status == 'completed'){
                    $ticket->status = OrderStatus::COMPLETED;
                    $ticket->finished_at = now();
                }else{
                    $ticket->status = OrderStatus::CANCELLED;
                }
                
                $ticket->save();
            }


            DB::commit();

           return redirect()->back()->with('success', 'Action completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function barberAllAction($status){
        $id = Auth::guard('user')->user()->id;
        $tickets = Ticket::with('customer')->where('status', $status)->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->paginate(10);
        return view('user.dashboard.barber_completed', compact('tickets'));
    }
    
    public function allServices(){
        $id = Auth::guard('user')->user()->id;
        $tickets = Ticket::with('customer')->orderBy('id', 'desc')->paginate(10);
        return view('user.dashboard.barber_completed', compact('tickets'));
    }

    public function dailyReport()
    {
        $tickets = Ticket::whereDate('created_at', today())->get();

        return view('user.reports.tickets', [
            'tickets' => $tickets,
            'openTickets' => $tickets->where('status', 'open')->count(),
            'doneTickets' => $tickets->where('status', 'done')->count(),
            'pendingTickets' => $tickets->where('status', 'waiting')->count(),
            'cancelledTickets' => $tickets->where('status', 'cancelled')->count(),
        ]);
    }


    public function cancellTicket($id){
        $ticket = Ticket::find($id);
        if($ticket){
            $ticket->status = OrderStatus::CANCELLED;
            $ticket->save();
        }
        return redirect()->route('home');
    }
}
