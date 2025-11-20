<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests\UpdateCartRequest;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Session::get('cart', []);

        if (empty($carts)) {
            return redirect()->route('home')->with('waring', 'there is no Cart!');
        }
        $totalAmount = 0;
        foreach ($carts as $cart) {
            if ($cart) {
                $totalAmount += $cart['price'] * $cart['quantity'];
            }
        }
        return view('home.pages.cart', [
            'cartProducts' => $carts,
            'totalAmount' => $totalAmount,
        ]);


        // $authUser = auth()->user()->id;
        // // $cartCount = Cart::whereUserId($authUser)->count();
        // $cartProducts = Cart::with('product')->whereUserId($authUser)->latest()->get();

        // dd($carts);

        // foreach ($carts as $cart) {
        //     if ($cart->product) {
        //         $totalAmount += $cart->product->price * $cart->quantity;
        //     }
        // }

        // return view('home.pages.cart', [
        //     'cartProducts' => $carts,
        //     'totalAmount' => $totalAmount,
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrfail($productId);

        $carts = Session::get('cart', []);

        if (isset($carts[$productId])) {
            $carts[$productId]['quantity'] += 1;
            Session::flash('succes', 'Cart Update Succesfully!');
        } else {
            $carts[$productId] = [
                'product_id' => $productId,
                'title' => $product->title,
                'quantity' => 1,
                'price' => $product->price,
                'product_stock' => $product->stock,
                'description' => $product->description,
            ];
        }
        Session::put('cart', $carts);
        Session::flash('succes', 'Product added to cart!');
        return back();

        // $validated = $request->validate([
        //     'quantity' => ['required', 'integer', 'min:1'],
        // ]);
        // $user = auth()->user();
        // if ($user) {
        //     $existing = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();

        //     if ($existing) {
        //         $existing->increment('quantity');
        //     } else {
        //         Cart::create([
        //             'quantity' => $validated['quantity'],
        //             'user_id' => $user->id,
        //             'product_id' => $productId,
        //         ]);
        //     }
        // }

        // return back()->with('success', 'Product added to cart!');
    }

    public function decrement(Request $request, $cartProductId)
    {
        $carts = Session::get('cart', []);
        $cart = $carts[$cartProductId];

        if (!$cart) {
            Session::flash('warning', 'Cart Product Not found!');
            return back();
        }
        if ($cart['quantity'] <= 1) {
            Session::flash('warning', 'This Product is no more ableable in stock!');
            return back();
        }

        $cart['quantity'] -= 1;
        $carts[$cartProductId] = $cart;
        Session::put('cart', $carts);
        Session::flash('success', 'Cart Update Succesfully!');
        return back();

        // $cartItem = Cart::find($cartProductId);

        // if (!$cartItem) {
        //     return back()->with('error', 'Not found');
        // }

        // if ($cartItem->quantity <= 1) {
        //     return back()->with('warning', "You Can't decrement more quantity");
        // } else {
        //     $cartItem->quantity -= 1;
        //     $cartItem->save();
        //     return back()->with('cart item updated');
        // }
    }

    public function increment(Request $request, $cartProductId)
    {
        $cart = Session::get('cart', []);
        $cartItem = $cart[$cartProductId];
        // dd($productStock);

        if (!$cartItem) {
            return back()->with('error', 'Not found');
        }
        $productStock = Product::findOrFail($cartProductId)->stock;

        if ($cartItem['quantity'] >= $productStock) {
            return back()->with('warning', "You Can't increment more quantity");
        }

        $cartItem['quantity'] += 1;
        $cart[$cartProductId] = $cartItem;
        Session::put('cart', $cart);
        Session::flash('succes', 'Cart Update Succesfully!');
        return back();

        // $cartItem = Cart::find($cartProductId);

        // if (!$cartItem) {
        //     return back()->with('error', 'Not found');
        // }

        // $productStock = $cartItem->product->stock;

        // if ($cartItem->quantity >= $productStock) {
        //     return back()->with('warning', "You Can't increment more quantity");
        // } else {
        //     $cartItem->quantity += 1;
        //     $cartItem->save();
        //     return back()->with('cart item updated');
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        //
    }


    public function delete($productId)
    {
        $carts = Session::get('cart', []);

        if (isset($carts[$productId])) {
            unset($carts[$productId]);
        }
        Session::put('cart', $carts);
        Session::flash('waring', 'Product Delete Succesfully Form Cart!');
        if (empty($carts)) {
            return redirect()->route('home')->with('waring', 'there is no Cart!');
        }
        return back();
        // dd($productId);
        // Cart::destroy($cart->id);
        // return back()->with('warning', 'Product Successfully Delete from Cart');
    }

    public function clearCart()
    {
        $carts = Session::get('cart', []);
        Session::forget('cart');
        Session::flash('waring', 'Clear Cart!');

        return redirect()->route('home')->with('waring', 'there is no Cart!');
    }
}
