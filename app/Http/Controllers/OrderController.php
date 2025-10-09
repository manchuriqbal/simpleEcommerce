<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout()
    {
        $user = auth()->user();
        $carts = Cart::with('product')
            ->whereUserId($user->id)
            ->get();
        $cartCount = 0;
        $totalAmount = 0;
        foreach ($carts as $cart ) {
            $totalAmount += $cart->product->price * $cart->quantity;
            $cartCount += 1*$cart->quantity;
        }
        
        return view('home.pages.checkout')->with([
            'carts' => $carts,
            'totalAmount' => $totalAmount,
            'user' => $user,
            'cartCount' => $cartCount,
        ]);
    }

    public function place_order(Request $request){
        $validateData = $request->validate([
            'phone' => ['required',  'regex:/^\+?[0-9]{11,14}$/'],
            'address' => ['required'],
        ]);
        
        // save user
        $user = auth()->user();

        DB::beginTransaction();
        try {
           
            
            $user->phone = $validateData['phone'];
            $user->address = $validateData['address'];
            $user->save();
    

            // save order
            $cartItems = Cart::with('product')
                ->whereUserId($user->id)
                ->get();

            $totalAmount = 0;
            foreach ($cartItems as $cart ) {
                $totalAmount += $cart->product->price * $cart->quantity;
            }
            // $order = Order::create([
            //     'user_id' => $user->id,
            //     'total_amount' => $totalAmount,
            //     'status' => 'pending',
            // ]);
            $order = new Order();
            $order->user_id = $user->id;
            $order->total_amount = $totalAmount;
            $order->status = 'pending';
            $order->save();


            // Save OrderItems
            foreach ($cartItems as $item ) {
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $item->product->id;
                $order_item->price = $item->product->price;
                $order_item->quantity = $item->quantity;
                $order_item->save();
                // OrderItem::create([
                //     'order_id' => $order->id,
                //     'product_id' => $item->product->id,
                //     'price' => $item->product->price,
                //     'quantity' => $item->quantity,
                // ]);
            }

            Cart::whereUserId($user->id)->delete();
            
            DB::commit();

            return redirect()->route('order.success')->with('success', 'Order Place Succssfully!');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'There was a problem in your code: ' . $e->getMessage());
        }
        
        
    }

    public function order_success(){
        dd('Successfully Placed Oder!');
    }


    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
