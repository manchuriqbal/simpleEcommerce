@extends('layouts.home')


@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <div class="row g-4">

                <!-- LEFT: Shipping & Payment -->
                <div class="col-lg-8">
                    <form action="{{ route('order.place_order') }}" method="post">
                        @csrf
                        <h4 class="mb-3">Checkout</h4>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="mb-3">Contact</h6>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input class="form-control" name="name" value="{{ $user->name }}" readonly>

                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" name="phone" placeholder="phone" aria-label="phone"
                                            value="{{ $user->phone }}">
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="mb-3">Shipping address</h6>

                                <div class="row g-2">
                                    <div class="col-12">
                                        <input class="form-control" name="address" placeholder="Street address"
                                            aria-label="Street address" value="{{ $user->address }}">
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">← Continue shopping</a>
                            <input type="submit" class="btn btn-primary btn-lg" id="place-order" value="Place Order">
                        </div>
                    </form>
                </div>

                <!-- RIGHT: Order summary -->
                <div class="col-lg-4">
                    <div class="card card-summary p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0">Order summary</h6>
                                <div class="text-muted-small">{{ $cartCount }} items</div>
                            </div>
                            {{-- <span class="chip">₹ 400.00</span> --}}
                        </div>

                        <div class="mb-3">
                            <!-- product list -->
                            @foreach ($carts as $cartItem)


                                <div class="d-flex align-items-start mb-3 product-row">
                                    <img src="https://via.placeholder.com/72" alt="" class="product-thumb">
                                    <div class="flex-grow-1 ms-2">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="fw-bold">{{ $cartItem->product->title }}</div>
                                                {{-- <div class="text-muted-small">Color: Black</div> --}}
                                            </div>
                                            <div class="text-end" style="width: 40%">
                                                <div class="fw-bold">৳ {{$cartItem->product->price}}</div>
                                                <div class="text-muted-small">Unit price</div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-muted-small">Quantity: {{$cartItem->quantity}}</div>
                                            <div class="text-muted-small">Subtotal:
                                                ৳{{$cartItem->product->price * $cartItem->quantity}}</div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach


                        </div>


                        <hr>
                        <!-- Coupon -->
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Promo code">
                            <button class="btn btn-primary" type="button">Apply</button>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div class="text-muted-small">Subtotal</div>
                            <div class="fw-bold">৳ {{ $totalAmount }}</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="text-muted-small">Shipping</div>
                            <div class="fw-bold">Free</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="text-muted-small">Tax (5%)</div>
                            <div class="fw-bold">৳ 00</div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="fw-bold">Total</div>
                            <div class="fs-5 fw-bold">৳ {{ $totalAmount }}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection