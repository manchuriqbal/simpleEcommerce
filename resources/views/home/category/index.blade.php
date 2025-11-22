@extends('layouts.home')

@section('content')
<div class="container py-5">

    <h3 class="mb-4">Categories</h3>

    <div class="row g-4">
        @foreach ($categories as $category)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img 
                        src="{{ $category->image ?? 'https://via.placeholder.com/600x300' }}" 
                        class="card-img-top" 
                        alt="Category Image">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">{{ $category->name }}</h5>

                        <div class="mb-2 text-muted small">
                            {{ $category->products_count ?? $category->products->count() }} products
                        </div>

                        <a href="" 
                           class="btn btn-outline-primary mt-auto">
                            View Products →
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
