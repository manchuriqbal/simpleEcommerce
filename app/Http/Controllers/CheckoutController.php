<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $user = auth()->user();
        $carts = Cart::with('product')
            ->whereUserId($user->id)
            ->get();
        $cartCount = 0;
        $totalAmount = 0;
        foreach ($carts as $cart) {
            $totalAmount += $cart->product->price * $cart->quantity;
            $cartCount += 1 * $cart->quantity;
        }

        return view('home.checkout.index')->with([
            'carts' => $carts,
            'totalAmount' => $totalAmount,
            'user' => $user,
            'cartCount' => $cartCount,
        ]);
    }
}
