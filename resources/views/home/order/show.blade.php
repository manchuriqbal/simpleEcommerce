@extends('layouts.home')

@section('content')
    <div class="container py-5">
        <div class="row g-4 justify-content-center">

            <div class="col-lg-8">
                <h3 class="mb-4">Order Details</h3>

                <div class="card shadow-sm p-4">

                    @php
                        $status = '';
                        if ($order->status == 'pending') {
                            $status = 'warning';
                        } elseif ($order->status == 'cancelled') {
                            $status = 'danger';
                        } elseif ($order->status == 'confirmed') {
                            $status = 'info';
                        } elseif ($order->status == 'completed') {
                            $status = 'success';
                        }
                    @endphp
                    <!-- Order Header -->
                    <div class="mb-4">
                        <h5>Order {{ $order->order_code }}</h5>
                        <p class="text-muted">Placed on {{ $order->created_at->diffForHumans() }} — Status: <span
                                class="badge bg-{{$status}}">{{$order->status}}</span></p>
                    </div>

                    <!-- Order Summary Table -->
                    <div class="mb-4">
                        <h6>Order Summary</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                {{-- @php
                                    dd($item)
                                @endphp --}}
                                <tr>
                                    <td>
                                        <strong>{{$item->product->title}}</strong>
                                        <p class="text-muted small">{{Str::limit($item->product->description, 60, '...')}}</p>
                                    </td>
                                    <td>{{$item->quantity}}</td>
                                    <td>৳ {{$item->price}}</td>
                                    <td>৳ {{$item->price * $item->quantity}}</td>
                                </tr>
                                @endforeach
                                <!-- Repeat for multiple products -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Shipping & Payment -->
                    <div class="mb-4 row">
                        <div class="col-md-6">
                            <h6 class="">Shipping To</h6>
                            <p>{{$order->user->name}}</p>
                            <p>{{$order->user->phone}}</p>
                            <p>{{$order->user->address}}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Payment Method</h6>
                            <p>Cash on Delivariy</p>
                        </div>
                    </div>

                    <!-- Amount Summary -->
                    <div class="mb-4">
                        <h6>Payment Summary</h6>
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span>৳ {{$order->total_amount}}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Tax</span>
                            <span>৳ 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span>৳ {{$order->total_amount}}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{route('order.index')}}" class="btn btn-outline-secondary">Back to Orders</a>
                        <button class="btn btn-primary" onclick="window.print()">Print Receipt</button>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
