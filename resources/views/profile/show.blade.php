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
                    <img src="https://via.placeholder.com/120" alt="Profile Picture" class="rounded-circle border border-gray-300">
                </div>

                <!-- Profile Details -->
                <div class="mb-2">
                    <label class="fw-bold">Name</label>
                    <p class="mb-1">John Doe</p>
                </div>

                <div class="mb-2">
                    <label class="fw-bold">Email</label>
                    <p class="mb-1">johndoe@example.com</p>
                </div>

                <div class="mb-2">
                    <label class="fw-bold">Phone</label>
                    <p class="mb-1">+880 1234567890</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Shipping Address</label>
                    <p class="mb-1">Demo Street, City, Country</p>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="#" class="btn btn-outline-primary">Edit Profile</a>
                    <form action="#" method="post" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Sign Out</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ORDER HISTORY -->
        <div class="col-lg-8">
            <div class="card shadow-sm p-4">
                <h4 class="mb-4">Order History</h4>
                <p class="text-muted mb-3">Showing recent orders</p>

                <!-- Single Order Row -->
                <div class="card mb-3 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1"><strong>Order #ORDER_NUMBER</strong></p>
                            <p class="text-muted mb-0">Placed on ORDER_DATE — 3 items</p>
                        </div>
                        <div class="text-end">
                            <p class="mb-1"><strong>Total Amount</strong></p>
                            <p class="text-muted mb-1">৳ 1200</p>
                            <span class="badge bg-success">Status: Delivered</span>
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                        <a href="#" class="btn btn-sm btn-outline-secondary">Reorder</a>
                    </div>
                </div>

                <!-- You can repeat the above block for multiple orders -->
            </div>
        </div>

    </div>
</div>
@endsection
