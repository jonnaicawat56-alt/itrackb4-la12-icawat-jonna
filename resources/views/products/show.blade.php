
@extends('layouts.app')

@section('title', 'Product Details')

@section('content')

<div class="container-fluid py-3">

    <h2 class="mb-3">Product Details</h2>

    <div class="card shadow-sm" style="max-width: 450px;">
        <div class="card-body p-4">

            <h3 class="mb-3">{{ $product->name }}</h3>

            <p>
                <strong>ID:</strong>
                {{ $product->id }}
            </p>

            <p>
                <strong>Category:</strong>
                {{ $product->category?->name ?? 'Uncategorized' }}
            </p>

            <p>
                <strong>Price:</strong>
                ₱{{ number_format($product->price, 2) }}
            </p>

            <p>
                <strong>Stock:</strong>
                {{ $product->stock }}
            </p>

            <p>
                <strong>Availability:</strong>

                @if ($product->available)
                    <span class="badge bg-success">Available</span>
                @else
                    <span class="badge bg-danger">Not Available</span>
                @endif
            </p>

            <p>
                <strong>Description:</strong><br>
                {{ $product->description ?? 'No description available.' }}
            </p>

            <div class="d-flex gap-2 mt-4">

                <a href="{{ route('products.index') }}"
                   class="btn btn-primary">
                    Back to Products
                </a>

                <form action="{{ route('products.destroy', $product) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this product?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>

                </form>

            </div>

        </div>
    </div>

</div>

@endsection
