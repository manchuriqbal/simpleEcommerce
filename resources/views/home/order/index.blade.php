@extends('layouts.home')

@section('content')
    <div class="container py-5">

        <h3 class="mb-4">My Orders</h3>

        <div class="card shadow-sm p-4">

            <h5 class="mb-3">Order History</h5>
            <p class="text-muted">Showing all your orders</p>

            <!-- Order List -->
            <div class="list-group">

                @foreach ($orders as $order)
                    <!-- Single Order -->
                    <div class="list-group-item list-group-item-action py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Order #{{$order->order_code}}</h6>
                                <div class="text-muted small">
                                    Placed on {{$order->created_at->diffForHumans()}} — {{$order->items->count()}} items
                                </div>
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
                                <div class="mt-1">
                                    Status:
                                    <span class="badge bg-{{$status}}">{{$order->status}}</span>
                                </div>
                            </div>

                            <div class="text-end">
                                <div class="fw-bold">৳ {{$order->total_amount}}</div>
                                <a href="{{route('order.show', $order->id)}}" class="btn btn-outline-primary btn-sm mt-2">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Repeat this order block dynamically for all orders -->

            </div>
        </div>
    </div>
@endsection
