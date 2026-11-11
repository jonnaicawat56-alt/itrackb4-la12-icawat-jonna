
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
    }

    .add-product-btn:hover {
        color: #fff;
        background-color: #0b5ed7;
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

    .stock-label {
        display: inline-block;
        background-color: #198754;
        color: white;
        padding: 5px 8px;
        border-radius: 5px;
        font-size: 12px;
        white-space: nowrap;
    }

    .out-stock-label {
        display: inline-block;
        background-color: #dc3545;
        color: white;
        padding: 5px 8px;
        border-radius: 5px;
        font-size: 12px;
        white-space: nowrap;
    }

    .product-table th,
    .product-table td {
        padding: 10px;
        vertical-align: middle;
    }

    .search-form {
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid py-3">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">My Product List</h2>

        <a href="{{ route('products.create') }}" class="add-product-btn">
            + Add Product
        </a>
    </div>

    {{-- Query Count --}}
    <div class="query-count-box">
        Queries: {{ $queryCount }}
    </div>

    {{-- Search and Filter Form --}}
    <form method="GET"
          action="{{ route('products.index') }}"
          class="search-form">

        <div class="row g-3 align-items-end">

            {{-- Search by Product Name --}}
            <div class="col-md-3">
                <label for="name" class="form-label">
                    Search by product name
                </label>

                <input type="text"
                       name="name"
                       id="name"
                       class="form-control"
                       placeholder="Enter product name"
                       value="{{ request('name') }}">
            </div>

            {{-- Category Dropdown --}}
            <div class="col-md-2">
                <label for="category_id" class="form-label">
                    Filter by category
                </label>

                <select name="category_id"
                        id="category_id"
                        class="form-select">

                    <option value="">All Categories</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Availability Dropdown --}}
            <div class="col-md-2">
                <label for="available" class="form-label">
                    Availability
                </label>

                <select name="available"
                        id="available"
                        class="form-select">

                    <option value="">Any</option>

                    <option value="1"
                        @selected(request('available') === '1')>
                        Available
                    </option>

                    <option value="0"
                        @selected(request('available') === '0')>
                        Not Available
                    </option>

                </select>
            </div>

            {{-- Sort Dropdown --}}
            <div class="col-md-3">
                <label for="sort" class="form-label">
                    Sort by
                </label>

                <select name="sort"
                        id="sort"
                        class="form-select">

                    <option value="name"
                        @selected(request('sort', 'name') === 'name')>
                        Product Name
                    </option>

                    <option value="price"
                        @selected(request('sort') === 'price')>
                        Price
                    </option>

                    <option value="stock"
                        @selected(request('sort') === 'stock')>
                        Stock
                    </option>

                </select>
            </div>

            {{-- Apply and Clear Buttons --}}
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Apply
                </button>

                <a href="{{ route('products.index') }}"
                   class="btn btn-outline-secondary">
                    Clear
                </a>
            </div>

        </div>

        {{-- Preserve Stock Filter --}}
        @if (request('stock') !== null && request('stock') !== '')
            <input type="hidden"
                   name="stock"
                   value="{{ request('stock') }}">
        @endif

        {{-- Preserve Benchmark --}}
        @if (request('benchmark'))
            <input type="hidden"
                   name="benchmark"
                   value="{{ request('benchmark') }}">
        @endif

    </form>

    {{-- Stock Filter --}}
    <div class="mb-3">
        <strong>Filter by stock:</strong>

        <a href="{{ route('products.index', array_filter([
                'name' => $name,
                'category_id' => $categoryId,
                'available' => $available,
                'stock' => 20,
                'sort' => $sort,
                'benchmark' => request('benchmark')
            ], fn ($value) => $value !== null && $value !== '')) }}"
           class="filter-outline-btn">
            20+ stock
        </a>
    </div>

    {{-- Filter Description --}}
    @if ($name || $categoryId || ($available !== null && $available !== '') || ($stock !== null && $stock !== ''))
        <p>
            Showing filtered products.

            @if ($name)
                Search: <strong>{{ $name }}</strong>.
            @endif

            @if ($categoryId)
                Category:
                <strong>{{ $categories->firstWhere('id', (int) $categoryId)?->name }}</strong>.
            @endif

            @if ($available !== null && $available !== '')
                Availability:
                <strong>{{ $available === '1' ? 'Available' : 'Not Available' }}</strong>.
            @endif

            @if ($stock !== null && $stock !== '')
                Stock: <strong>{{ $stock }}+.</strong>
            @endif
        </p>
    @else
        <p>Showing all products.</p>
    @endif

    {{-- Products Table --}}
    <div class="table-responsive">

        <table class="table table-hover product-table">

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
                        <td>{{ $products->firstItem() + $loop->index }}</td>

                        <td>{{ $product->id }}</td>

                        <td>
                            <a href="{{ route('products.show', $product) }}">
                                {{ $product->name }}
                            </a>
                        </td>

                        <td>
                            {{ $product->category?->name ?? 'Uncategorized' }}
                        </td>

                        <td>
                            ₱{{ number_format($product->price, 2) }}
                        </td>

                        <td>
                            {{ $product->stock }}

                            @if ($product->stock > 0)
                                <span class="stock-label">in stock</span>
                            @else
                                <span class="out-stock-label">out of stock</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-1">

                                <a href="{{ route('products.edit', $product) }}"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this record?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        Delete
                                    </button>

                                </form>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {{-- Pagination --}}
        {{ $products->links() }}

    </div>

</div>

@endsection
