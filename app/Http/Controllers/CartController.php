<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
       
        $authUser = auth()->user()->id;
        // $cartCount = Cart::whereUserId($authUser)->count();
        $cartProducts = Cart::with('product')
            ->whereUserId( $authUser)
            ->latest()
            ->get();

        $totalAmount = 0;
        foreach ($cartProducts as $cart) {
            if ($cart->product) { 
                $totalAmount += $cart->product->price * $cart->quantity;
            }
        }
        
        
        return view('home.pages.cart', [
            'cartProducts' => $cartProducts,
            'totalAmount' =>$totalAmount
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addToCart(Request $request, $productId)
    {
        $validated  = $request->validate([
            'quantity' => ['required', 'integer', 'min:1']
        ]);
        $user = auth()->user();

        $existing = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();
                  
        if ($existing) {
           $existing->increment('quantity');
        }
        else{
            Cart::create([
                'quantity' => $validated['quantity'],
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
        }
        

        return back()->with('success','Product added to cart!');
    }


    public function decrement(Request $request,  $cartProductId)
    {
        $cartItem = Cart::find($cartProductId);
        
        if(!$cartItem){
            return back()->with('error', 'Not found');
        }

        if ($cartItem->quantity <= 1) {
            return back()->with('warning', "You Can't decrement more quantity");
        }
        else {
            $cartItem->quantity -= 1;
            $cartItem->save();
            return back()->with('cart item updated');
        }
    }

    public function increment(Request $request,  $cartProductId)
    {
        $cartItem = Cart::find($cartProductId);
        
        
        if(!$cartItem){
            return back()->with('error', 'Not found');
        }

        $productStock = $cartItem->product->stock;

        if ($cartItem->quantity >=  $productStock) {
            return back()->with('warning', "You Can't increment more quantity");
        }
        else {
            $cartItem->quantity += 1;
            $cartItem->save();
            return back()->with('cart item updated');
        }
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        Cart::destroy($cart->id);
        return back()->with('warning', 'Product Successfully Delete from Cart');
    }
}
