<?php

namespace App\Http\Controllers\Cart;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuestCartController extends Controller
{
    // SHOW CART

    public function index()
    {
        $carts = session()->get('cart', []);

        if (empty($carts)) {
            return redirect()->route('home')->with('warning', 'Your cart is empty!');
        }

        $totalAmount = collect($carts)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('home.cart.index', [
            'cartProducts' => $carts,
            'totalAmount' => $totalAmount,
        ]);
    }

    // ADD TO CART

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            session()->flash('success', 'Cart updated successfully!');
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'title' => $product->title,
                'quantity' => 1,
                'price' => $product->price,
                'product_stock' => $product->stock,
                'description' => $product->description,
            ];
            session()->flash('success', 'Product added to cart!');
        }

        session()->put('cart', $cart);
        return back();
    }

    // DECREMENT QUANTITY

    public function decrement($productId)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return back()->with('warning', 'Product not found in cart!');
        }

        if ($cart[$productId]['quantity'] <= 1) {
            return back()->with('warning', 'Quantity cannot be less than 1.');
        }

        $cart[$productId]['quantity']--;
        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated successfully!');
    }

    // INCREMENT QUANTITY

    public function increment($productId)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return back()->with('warning', 'Product not found in cart!');
        }

        $productStock = Product::findOrFail($productId)->stock;

        if ($cart[$productId]['quantity'] >= $productStock) {
            return back()->with('warning', 'No more stock available.');
        }

        $cart[$productId]['quantity']++;
        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated successfully!');
    }

    // DELETE SINGLE ITEM

    public function delete($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);

        if (empty($cart)) {
            return redirect()->route('home')->with('warning', 'Your cart is now empty!');
        }

        return back()->with('success', 'Product removed from cart!');
    }

    // CLEAR CART

    public function clearCart()
    {
        session()->forget('cart');

        return redirect()->route('home')->with('warning', 'Your cart has been cleared!');
    }
}
