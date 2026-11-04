@extends('layouts.app')

@section('title', 'My Product List')

@section('content')

<style>
    .filter-outline-btn {
        display: inline-block;
        color: #0d6efd;
        background-color: transparent;
        border: 1px solid #0d6efd;
        border-radius: 5px;
        padding: 6px 12px;
        text-decoration: none;
        font-size: 13px;
        transition: 0.2s ease;
    }

    .filter-outline-btn:hover {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .add-product-btn {
        display: inline-block;
        color: #fff;
        background-color: #0d6efd;
        border: 1px solid #0d6efd;
        border-radius: 5px;
        padding: 8px 14px;
        text-decoration: none;
        font-size: 13px;
        transition: 0.2s ease;
    }

    .add-product-btn:hover {
        color: #fff;
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    .query-count-box {
        margin-bottom: 20px;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f8f9fa;
        color: #212529;
        font-size: 14px;
    }
</style>

<div style="
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
">
    <h2 style="margin: 0;">My Product List</h2>

    <a href="{{ route('products.create') }}"
       class="add-product-btn">
        + Add Product
    </a>
</div>

{{-- SQL query count --}}
<div class="query-count-box">
    Queries: {{ $queryCount }}
</div>

<div class="filter-section">
    <strong>Filter by name:</strong>

    @foreach ($products as $product)
        <a href="{{ route('products.index', array_filter([
                'name' => $product->name,
                'benchmark' => request('benchmark')
            ], fn ($value) => $value !== null)) }}"
           class="filter-outline-btn"
           style="margin: 2px;">
            {{ $product->name }}
        </a>
    @endforeach
</div>

<div class="filter-section" style="margin-top: 12px;">
    <strong>Filter by stock:</strong>

    <a href="{{ route('products.index', array_filter([
            'stock' => 20,
            'benchmark' => request('benchmark')
        ], fn ($value) => $value !== null)) }}"
       class="filter-outline-btn">
        20+ stock
    </a>
</div>

<div style="margin-top: 15px; margin-bottom: 20px;">
    <a href="{{ route('products.index', request('benchmark')
            ? ['benchmark' => request('benchmark')]
            : []) }}"
       class="filter-outline-btn">
        Clear filters
    </a>
</div>

@if (!empty($name))
    <p>
        Showing products matching:
        <strong>{{ $name }}</strong>.
    </p>
@elseif (isset($stock) && $stock !== null && $stock !== '')
    <p>
        Showing products with
        <strong>{{ $stock }}+ stock</strong>.
    </p>
@else
    <p>Showing all products.</p>
@endif

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $product->id }}</td>

                <td>
                    <a href="{{ route('products.show', $product) }}">
                        {{ $product->name }}
                    </a>
                </td>

                <td>{{ $product->category?->name ?? '' }}</td>

                <td>
                    ₱{{ number_format($product->price, 2) }}
                </td>

                <td>
                    @if ($product->stock > 0)
                        <span style="
                            display: inline-block;
                            background-color: #198754;
                            color: white;
                            padding: 7px 12px;
                            border-radius: 6px;
                            font-size: 13px;
                            font-weight: 500;
                            text-align: center;
                        ">
                            {{ $product->stock }} in stock
                        </span>
                    @else
                        <span style="
                            display: inline-block;
                            background-color: #dc3545;
                            color: white;
                            padding: 7px 12px;
                            border-radius: 6px;
                            font-size: 13px;
                            font-weight: 500;
                            text-align: center;
                        ">
                            Out of Stock
                        </span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('products.edit', $product) }}"
                       class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                          onsubmit="return confirm('Delete this record?')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No products found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
