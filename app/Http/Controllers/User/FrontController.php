<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Addon;
use App\Models\Service;
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
        return view('front.step_four', compact('products'));
    }
    
    public function stepFive($addon_id){
        $firstItem = Cart::content()->first();
        $rowId = $firstItem->rowId;
        Cart::update($rowId, ['options'  => ['addon' => $addon_id]]);
        $addons = Addon::where('active', 1)->get();
        $services = Service::where('active', 1)->get();
        $carts = Cart::content();
        return view('front.step_five', compact('addons'));
    }
}
