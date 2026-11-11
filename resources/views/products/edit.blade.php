@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
    <h2>Edit Product</h2>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="name">Product Name</label><br>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $product->name) }}">
            @error('name')
                <div style="color: #dc3545; font-size: 13px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="category_id">Category</label><br>
            <select id="category_id" name="category_id" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div style="color: #dc3545; font-size: 13px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="price">Price</label><br>
            <input type="number" id="price" name="price"
                   value="{{ old('price', $product->price) }}" min="0" required>
            @error('price')
                <div style="color: #dc3545; font-size: 13px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="stock">Stock</label><br>
            <select id="stock" name="stock" required>
                <option value="">-- Select Stock --</option>
                @foreach ([0, 10, 15, 18, 20, 25, 30] as $stock)
                    <option value="{{ $stock }}"
                        {{ old('stock', (string) $product->stock) == (string) $stock ? 'selected' : '' }}>
                        {{ $stock }}
                    </option>
                @endforeach
            </select>
            @error('stock')
                <div style="color: #dc3545; font-size: 13px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Update Product</button>
        <a href="{{ route('products.index') }}">Cancel</a>
    </form>
@endsection