<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    // Add item to cart
    public function addToCart(Request $request)
    {

        $item = Cart::add([
            'id'      => $request->id,
            'name'    => $request->name,
            'qty'     => $request->qty ?? 1,
            'price'   => $request->price,
            'weight'  => 0,
            'options' => $request->options ?? [],
        ]);

        return response()->json(['success' => true, 'item' => $item, 'cart' => Cart::content()]);
    }

    // Update quantity
    public function updateCart(Request $request)
    {
        Cart::update($request->rowId, $request->qty);
        return response()->json(['success' => true, 'cart' => Cart::content()]);
    }

    // Remove item
    public function removeCart(Request $request)
    {
        $productId = $request->id;
        $item = Cart::content()->where('id', $productId)->first();
        if ($item) {
            Cart::remove($item->rowId);
            return response()->json(['success' => true, 'message' => 'Item removed']);
        }else{
            return response()->json(['success' => false, 'message' => 'Item not found in cart content']);
        }
    }

    // Get subtotal
    public function subtotal()
    {
        return response()->json(['subtotal' => formatPrice((float)Cart::subtotal())]);
    }

    // Get total (subtotal + tax)
    public function total()
    {
        return response()->json(['total' => formatPrice((float)Cart::total())]);
    }

    // Get tax
    public function tax()
    {
        return response()->json(['tax' => formatPrice(0)]);
    }

    // VAT calculation
    public function vat()
    {
        return response()->json(['vat' => 0]);
    }
    
    // Discount calculation
    public function discount()
    {
        $cartTotal = Cart::total();
        $discount = 0.00;
        session()->put('cart_discount', $discount);
        $total = max($cartTotal - $discount, 0);

        return response()->json([
            'discount' => formatPrice($discount, 2),
            'total' => formatPrice($total, 2)
        ]);
    }

    // Get count 
    public function count()
    {
        return response()->json(['count' => Cart::count()]);
    }

    // Get full cart content
    public function content()
    {
        $cartItems = Cart::content()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        });

        return response()->json(['cart' => $cartItems->values()]);
    }
}
