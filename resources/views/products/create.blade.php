
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Product</h2>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Product Name</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
            >
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select
                id="category_id"
                name="category_id"
                class="form-control"
                required
            >
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input
                type="number"
                id="price"
                name="price"
                class="form-control"
                value="{{ old('price') }}"
                min="0"
                step="0.01"
                required
            >
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <select
                id="stock"
                name="stock"
                class="form-control"
                required
            >
                <option value="">Select Stock</option>
                @foreach ([0, 5, 10, 15, 20, 25, 30] as $quantity)
                    <option
                        value="{{ $quantity }}"
                        {{ old('stock') == (string) $quantity ? 'selected' : '' }}
                    >
                        {{ $quantity }}
                    </option>
                @endforeach
            </select>
            @error('stock')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                Save Product
            </button>

            <a href="{{ route('products.index') }}" class="btn-cancel">
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
    .form-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-save {
        background-color: #198754;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 15px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-save:hover {
        background-color: #146c43;
    }

    .btn-cancel {
        display: inline-block;
        background-color: #6c757d;
        color: #ffffff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 15px;
    }

    .btn-cancel:hover {
        background-color: #565e64;
        color: #ffffff;
    }
</style>
@endsection
