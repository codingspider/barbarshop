<?php

namespace App\Http\Controllers\User;

use App\Models\Addon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CustomCartController extends Controller
{
    public function addToCart(Request $request)
    {
        // clear cart if needed (optional)
        Session::forget('cart');

        // Create item array
        $item = [
            'id'       => $request->id,
            'name'     => serviceName($request->id),
            'qty'      => $request->qty ?? 1,
            'price'    => $request->price,
            'base_price' => $request->price,
            'addons'   => [],
        ];

        // Store in session
        Session::put('cart.item', $item);
        Session::put('service_id', $request->id);

        return response()->json([
            'success' => true,
            'item'    => $item,
            'cart'    => Session::get('cart')
        ]);
    }


    public function stepFive(Request $request)
    {
        try {
            $addon_id = $request->get('addon_id');
            $cart = Session::get('cart.item');

            if (!$cart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty.',
                ], 404);
            }

            if ($addon_id) {
                $addon = Addon::find($addon_id);
                $addonPrice = $addon ? $addon->price : 0;

                // Check if addon already exists
                $exists = collect($cart['addons'])->contains(fn($a) => $a['id'] == $addon_id);
                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This addon is already added.',
                    ], 409);
                }

                // Add addon
                $cart['addons'][] = [
                    'id'    => $addon_id,
                    'name'  => addonName($addon->id),
                    'price' => $addonPrice,
                ];

                // Recalculate price
                $addonTotal = collect($cart['addons'])->sum('price');
                $cart['price'] = $cart['base_price'] + $addonTotal;

                // Save back to session
                Session::put('cart.item', $cart);
            }

            return response()->json([
                'success' => true,
                'message' => 'Addon added successfully',
                'cart'    => Session::get('cart')
            ]);
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
        $cart = Session::get('cart.item');

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty.',
            ], 404);
        }

        // Remove addon
        $cart['addons'] = collect($cart['addons'])
            ->reject(fn($a) => $a['id'] == $addon_id)
            ->values()
            ->toArray();

        // Recalculate price
        $addonTotal = collect($cart['addons'])->sum('price');
        $cart['price'] = $cart['base_price'] + $addonTotal;

        // Save back to session
        Session::put('cart.item', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Addon removed successfully',
            'cart'    => Session::get('cart')
        ]);
    }

    public function cartDetails()
    {
        // Get cart from session
        $cart = Session::get('cart.item');

        if (!$cart) {
            return response()->json([
                'items' => [],
                'total' => 0,
            ]);
        }

        // Prepare cart details
        $addonsTotal = collect($cart['addons'] ?? [])->sum('price');

        // Calculate numeric totals first
        $basePrice = (float) $cart['base_price'];
        $qty       = (float) ($cart['qty'] ?? 1);
        $totalPriceNumeric = $basePrice + $addonsTotal;
        $subtotalNumeric   = $totalPriceNumeric * $qty;

        // Prepare details array
        $details = [
            'service'  => $cart['name'],
            'price'    => formatPrice($basePrice),
            'addons'   => $cart['addons'] ?? [],
            'total'    => formatPrice($totalPriceNumeric),
            'qty'      => $qty,
            'subtotal' => formatPrice($subtotalNumeric)
        ];


        return response()->json([
            'items' => $details,
            'total' => formatPrice($basePrice * ($cart['qty'] ?? 1))
        ]);
    }

}
