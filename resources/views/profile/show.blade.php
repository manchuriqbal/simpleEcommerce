@extends('layouts.home')

@section('content')
    <div class="container py-5">
        <div class="row g-4">

            <!-- PROFILE INFO -->
            <div class="col-lg-4">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-4">My Profile</h4>

                    <!-- Profile Picture -->
                    <div class="text-center mb-3">
                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Profile Picture"
                            class="rounded-circle border border-gray-300">
                    </div>

                    <!-- Profile Details -->
                    <div class="mb-2">
                        <label class="fw-bold">Name</label>
                        <p class="mb-1">{{ $user->name }}</p>
                    </div>

                    <div class="mb-2">
                        <label class="fw-bold">Email</label>
                        <p class="mb-1">{{ $user->email }}</p>
                    </div>

                    <div class="mb-2">
                        <label class="fw-bold">Phone</label>
                        <p class="mb-1">{{ $user->phone }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Shipping Address</label>
                        <p class="mb-1">{{ $user->address }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="#" class="btn btn-outline-primary">Edit Profile</a>
                        <form action="{{ route('logout') }}" method="post" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ORDER HISTORY -->
            <div class="col-lg-8">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-4">Order History</h4>
                    <p class="text-muted mb-3">Showing your recent orders</p>
                    @foreach ($orders as $order)
                        <!-- Single Order Row -->
                        <div class="card mb-3 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1"><strong>Order #{{ $order->order_code }}</strong></p>
                                    <p class="text-muted mb-0">Placed on {{ $order->created_at->diffForHumans() }} —
                                        {{ $order->items->count() }} items</p>
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
                                <div class="text-end">
                                    <p class="mb-1"><strong>Total Amount</strong></p>
                                    <p class="text-muted mb-1">৳ {{ $order->total_amount }}</p>
                                    <p>Status: <span class="badge bg-{{$status}}">{{ $order->status }}</span></p>
                                </div>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{route('order.show', $order->id)}}" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="#" class="btn btn-sm btn-outline-secondary">Reorder</a>
                            </div>
                        </div>
                    @endforeach

                    <!-- You can repeat the above block for multiple orders -->
                </div>
            </div>

        </div>
    </div>
@endsection
