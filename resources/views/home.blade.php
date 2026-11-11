
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-4">
            <h2 class="fw-bold">My Product</h2>

            <p class="text-secondary">
                Manage and organize product records in one place.
                View product information, prices, available stocks,
                and product categories.
            </p>

            <a href="{{ route('products.index') }}" class="btn btn-primary">
                View All Products
            </a>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-secondary text-uppercase">Products</small>
                    <h2 class="display-6 mb-0">{{ $productCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-secondary text-uppercase">Categories</small>
                    <h2 class="display-6 mb-0">{{ $categoryCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body d-flex align-items-center">
            <img src="{{ asset('img/profile.jpg') }}"
                 width="65"
                 height="65"
                 class="rounded-circle me-3"
                 style="object-fit: cover;"
                 alt="Profile Photo">

            <div>
                <small class="text-secondary text-uppercase">Prepared by</small>
                <h6 class="mb-1">Jonna Icawat</h6>
                <small class="text-secondary">
                    BS Information Technology · 4th Year · Block 4A
                </small>
            </div>
        </div>
    </div>

</div>
@endsection
