<?php

namespace App\Http\Controllers\Cart;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthCartController extends Controller
{
    // Show Cart
    public function index()
    {
        $authUser = auth()->user()->id;
        $carts = Cart::with('product')->whereUserId($authUser)->latest()->get();
        if ($carts->isEmpty()) {
            return redirect()->route('home')->with('error', 'Not Cart found');
        }

        $totalAmount = 0;
        foreach ($carts as $cart) {
            if ($cart->product) {
                $totalAmount += $cart->product->price * $cart->quantity;
            }
        }

        return view('home.cart.index', [
            'cartProducts' => $carts,
            'totalAmount' => $totalAmount,
        ]);
    }

    // Add To Cart
    public function addToCart(Request $request, $productId)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);
        $user = auth()->user();
        if ($user) {
            $existing = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();

            if ($existing) {
                $existing->increment('quantity');
            } else {
                Cart::create([
                    'quantity' => $validated['quantity'],
                    'user_id' => $user->id,
                    'product_id' => $productId,
                ]);
            }
        }

        return back()->with('success', 'Product added to cart!');
    }

    // Decrement Quantity
    public function decrement(Request $request, $cartProductId)
    {
        $cartItem = Cart::find($cartProductId);

        if (!$cartItem) {
            return back()->with('error', 'Cart Not found');
        }

        if ($cartItem->quantity <= 1) {
            return back()->with('warning', "You Can't decrement more quantity");
        }
        $cartItem->quantity -= 1;
        $cartItem->save();
        return back()->with('success', 'cart item updated');
    }

    // Increment Quantity
    public function increment(Request $request, $cartProductId)
    {
        $cartItem = Cart::find($cartProductId);

        if (!$cartItem) {
            return back()->with('error', 'Not found');
        }

        $productStock = $cartItem->product->stock;

        if ($productStock <= 0) {
            return back()->with('error', 'Product out of stock');
        }

        if ($cartItem->quantity >= $productStock) {
            return back()->with('warning', "You Can't increment more quantity");
        }
        $cartItem->quantity += 1;
        $cartItem->save();
        return back()->with('success', 'cart item updated');
    }

    // Delete Cart
    public function delete($productId)
    {
        Cart::destroy($productId);
        return back()->with('warning', 'Product Successfully Delete from Cart');
    }

    // Clear Cart
    public function clearCart()
    {
        $user_id = auth()->user()->id;
        // dd($user_id);
        $carts = Cart::where('user_id', $user_id)->get();
        if ($carts->isEmpty()) {
            return redirect()->route('home')->with('error', 'Not Cart found');
        }
        foreach ($carts as $cart) {
            $cart->delete();
        }
        return redirect()->route('home')->with('waring', 'The Cart is clear form everyware!');
    }
}
