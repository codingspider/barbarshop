<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Addon;
use App\Models\Ticket;
use App\Models\Service;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class FrontController extends Controller
{
    public function stepOne(){
        $users = User::where('user_type', 'barber')->get();
        return view('front.step_one', compact('users'));
    }
    
    public function stepTwo(){
        $products = Service::where('active', 1)->get();
        return view('front.step_two', compact('products'));
    }
    
    public function stepThree(){
        $users = User::where('user_type', 'barber')->get();
        return view('front.step_three', compact('users'));
    }
    
    public function stepFour($barber_id){
        Session::put('barber_id', $barber_id);
        $products = Addon::where('active', 1)->get();
        return view('front.step_four', compact('products', 'barber_id'));
    }
    
    public function stepFive(Request $request)
    {
        $addon_id = $request->get('addon_id');
        $firstItem = Cart::content()->first();

        if ($firstItem) {
            $rowId = $firstItem->rowId;

            if ($addon_id) {
                $addon = Addon::where('id', $addon_id)->first();
                $addonPrice = $addon ? $addon->price : 0;

                // Update the cart with addon
                Cart::update($rowId, [
                    'options' => [
                        'addon_id' => $addon_id,
                        'addon_price' => $addonPrice
                    ]
                ]);
            }
        }

        $addons = Addon::where('active', 1)->get();
        $services = Service::where('active', 1)->get();
        $carts = Cart::content();
        $barber_id = Session::get('barber_id');
        $datas = getBarberSchedule($barber_id);

        return view('front.step_five', compact('addons', 'datas'));
    }



    public function stepSix($id){
        $barber_id = Session::get('barber_id');
        $datas = getBarberSchedule($barber_id);
        $ticket = Ticket::find($id);
        $tickets = Ticket::with('service')->where('status', OrderStatus::WAITING)->whereDate('created_at', Carbon::today())->where('assigned_barber_id', $barber_id)->orderBy('id', 'asc')->take(3)->get();
        return view('front.step_six', compact('datas', 'tickets', 'ticket'));
    }
}
