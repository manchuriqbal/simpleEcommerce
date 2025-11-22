@extends('layouts.home')

@section('content')
    <!-- CART PAGE BODY -->
    <div class="container my-5">
        <div class="row">

            <!-- Cart Items -->
            <div class="col-lg-8">
                <h3 class="mb-4">Your Shopping Cart</h3>

                <!-- Cart Item -->
                @foreach ($cartProducts as $cartProduct)
                    <div class="card mb-3 shadow-sm">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-3">
                                <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="img-fluid rounded-start"
                                    alt="Product Image">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div style="width: 800px">

                                            <h5 class="card-title mb-1">
                                                {{ auth()->check() ? $cartProduct->product->title : $cartProduct['title'] }}
                                            </h5>
                                            <p class="text-muted mb-2 small">
                                                {{ auth()->check() ? $cartProduct->product->description : $cartProduct['description'] }}
                                            </p>
                                            <span
                                                class="fw-semibold">${{ auth()->check() ? $cartProduct->product->price : $cartProduct['price'] }}</span>
                                        </div>

                                        @php
                                            $delete_route = auth()->check()
                                                ? route('cart.delete', $cartProduct->id)
                                                : route('guest.cart.delete', $cartProduct['product_id']);
                                        @endphp

                                        <form action="{{ $delete_route }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" style="width: 100px"
                                                class="btn btn-sm btn-outline-danger ms-2">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </form>
                                    </div>

                                    @php
                                        $decrement_route = auth()->check()
                                            ? route('cart.decrement', $cartProduct->id)
                                            : route('guest.cart.decrement', $cartProduct['product_id']);

                                        $increment_route = auth()->check()
                                            ? route('cart.increment', $cartProduct->id)
                                            : route('guest.cart.increment', $cartProduct['product_id']);
                                    @endphp
                                    <div class="mt-3 d-flex align-items-center">
                                        <label class="me-2 mb-0 small text-muted">Quantity:</label>
                                        <div class="input-group input-group-sm" style="width: 120px;">
                                            <form action="{{ $decrement_route }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="submit" class="btn btn-outline-secondary decrement"
                                                    value="-">
                                            </form>

                                            <input type="number" class="form-control text-center qty-input"
                                                value="{{ $cartProduct['quantity'] }}" min="1">

                                            <form action="{{ $increment_route }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="submit" class="btn btn-outline-secondary increment"
                                                    value="+">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @php
                    $clear_carts_route = auth()->check()
                        ? route('cart.clear')
                        : route('guest.cart.clear');
                @endphp


                <!-- Continue / Clear Cart Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        ← Continue Shopping
                    </a>
                    <a href="{{ $clear_carts_route }}" class="btn btn-outline-danger">
                        Clear Cart
                    </a>
                </div>
            </div>




            <!-- Order Summary -->
            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Order Summary</h5>

                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>${{ $totalAmount }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tax </span>
                            <span>$0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong>${{ $totalAmount }}</strong>
                        </div>



                        <!-- Checkout -->
                        <div class="d-grid">
                            <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">Proceed to Checkout</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
