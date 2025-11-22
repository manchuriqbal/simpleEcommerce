@extends('layouts.home')


@section('header')
    <!-- Header-->
    @include('home.partials.header')
@endsection
@section('content')
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($products as $product)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale
                            </div>
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ Str::limit($product->title, 25, '...') }}</h5>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">${{ $product->price + 40}} </span>
                                    ${{ $product->price }}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    {{-- <a class="btn btn-outline-dark mt-auto"
                                        href="{{ route('addToCart', $product->id) }}">Add to cart</a> --}}
                                    @php
                                        $routeName = auth()->check() ? 'cart.add' : 'guest.cart.add';
                                    @endphp
                                    <form action="{{ route($routeName, $product->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <input class="btn btn-outline-dark mt-auto" type="submit" value="Add to cart">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $products->links() }}
        </div>
    </section>
@endsection