@extends('layouts.home')

@section('content')
    <div class="container py-5">
        <div class="row g-4 justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow-sm p-4 text-center">

                    <!-- Success Icon -->
                    <div class="my-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 70px"></i>
                    </div>

                    <!-- Title -->
                    <h2 class="fw-bold mb-2">Order Placed Successfully!</h2>
                    <p class="text-muted mb-4">
                        Thank you for your purchase. Your order has been confirmed and is being prepared.
                    </p>

                    <!-- Order Info Box -->
                    <div class="card shadow-sm p-3 text-start mb-4">
                        <h5 class="fw-bold mb-3">Order Details</h5>

                        <p class="mb-1"><strong>Order ID:</strong> {{$order->order_code}}</p>
                        <p class="mb-1"><strong>Name:</strong> {{$order->user->name}}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{$order->user->phone}} </p>
                        <p class="mb-1"><strong>Shipping Address:</strong> {{$order->user->address}} </p>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Total Amount:</span>
                            <span class="fw-bold fs-5">৳{{$order->total_amount}} </span>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <a href="{{route('home')}}" class="btn btn-outline-primary px-4">Continue Shopping</a>
                        <a href="{{route('order.show', $order->id)}}" class="btn btn-success px-4">View Order</a>
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection
