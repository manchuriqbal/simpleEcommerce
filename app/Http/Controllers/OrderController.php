<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use phpDocumentor\Reflection\Types\String_;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $orders = Order::where('user_id', $user_id)->get();
        return view('home.order.index')->with([
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */


    public function place_order(Request $request)
    {
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
            foreach ($cartItems as $cart) {
                $totalAmount += $cart->product->price * $cart->quantity;
            }
            // $order = Order::create([
            //     'user_id' => $user->id,
            //     'total_amount' => $totalAmount,
            //     'status' => 'pending',
            // ]);
            $order = new Order();
            $order->order_code = Str::random(3) . '-' . Date('Ymd');
            $order->user_id = $user->id;
            $order->total_amount = $totalAmount;
            $order->status = 'pending';
            $order->save();


            // Save OrderItems
            foreach ($cartItems as $item) {
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

            return redirect()->route('order.success', $order->order_code)->with('success', 'Order Place Succssfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'There was a problem in your code: ' . $e->getMessage());
        }
    }

    public function order_success($order_code)
    {
        $order = Order::with('user')->where('order_code', $order_code)->first();
        return view('home.order.success-order')->with([
            'order' => $order,
        ]);
    }


    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);

        return view('home.order.show')->with([
            'order' => $order,
        ]);
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
