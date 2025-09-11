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
        $users = User::with(['tickets' => function($query) {
            $query->where('status', 'waiting')
                ->orderBy('requested_at', 'asc')
                ->take(3);
        }])->where('user_type', 'barber')->where('status', 'active')
        ->get();
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
        try {
         $addon_id = $request->get('addon_id');
        $firstItem = Cart::content()->first();

        if ($firstItem) {
            $rowId = $firstItem->rowId;

            $cartItem = Cart::get($rowId);
            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found.',
                ], 404);
            }

            if ($addon_id) {
                $addon = Addon::find($addon_id);
                $addonPrice = $addon ? $addon->price : 0;

                // Convert options to array
                $options = $cartItem->options->toArray();

                // Store base_price once (if not already stored)
                if (!isset($options['base_price'])) {
                    $options['base_price'] = $cartItem->price;
                }

                // Get existing addons
                $addons = $options['addons'] ?? [];

                // Add new addon
                $addons[] = [
                    'id'    => $addon_id,
                    'name'  => $addon->name,
                    'price' => $addonPrice,
                ];

                // Update addons back in options
                $options['addons'] = $addons;

                // Recalculate price
                $basePrice  = $options['base_price'];
                $addonTotal = collect($addons)->sum('price');
                $newPrice   = $basePrice;

                // Update the cart item
                Cart::update($rowId, [
                    'price'   => $newPrice,
                    'options' => $options, 
                ]);

                dd(Cart::content());
            }

            return response()->json([
                'success' => true,
                'message' => 'Addon added successfully',
                'cart'    => Cart::content(),
            ]);
        }


        } catch (\Exception $e) {
            \Log::error('Cart update error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    
    public function removeFromCart(Request $request)
    {
        $addon_id = $request->get('addon_id');
        $firstItem = Cart::content()->first();
        dd($firstItem);

        if ($firstItem) {
            $rowId = $firstItem->rowId;

            $cartItem = Cart::get($rowId);
            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found.',
                ], 404);
            }

            // Get options
            $options = $cartItem->options->toArray();
            $addons  = $options['addons'] ?? [];

            // Filter out the addon we want to remove
            $addons = collect($addons)
                ->reject(fn($a) => $a['id'] == $addon_id)
                ->values()
                ->toArray();

            // Update options
            $options['addons'] = $addons;

            // Recalculate price
            $basePrice  = $options['base_price'] ?? $cartItem->price;
            $addonTotal = collect($addons)->sum('price');
            $newPrice   = $basePrice;

            // Update cart
            Cart::update($rowId, [
                'price'   => $newPrice,
                'options' => $options,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Addon removed successfully',
                'cart'    => Cart::content(),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Cart is empty.',
        ], 404);
    }

    
    public function ticketSummery(Request $request)
    {
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
