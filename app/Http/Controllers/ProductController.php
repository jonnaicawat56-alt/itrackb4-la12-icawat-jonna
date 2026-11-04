<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        abort(500);
        $categoryId = $request->query('category_id');
        $stock = $request->query('stock');
        $benchmark = $request->query('benchmark');

        $query = Product::with('category');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($stock !== null && $stock !== '') {
            $query->where('stock', '>=', $stock);
        }

        DB::flushQueryLog();
        DB::enableQueryLog();

        try {
            $products = $query->get();

            // Benchmark: simulate lazy loading when requested.
            if ($benchmark !== 'after') {
                foreach ($products as $product) {
                    $product->category;
                }
            }

            $queryCount = count(DB::getQueryLog());
        } finally {
            DB::disableQueryLog();
        }

        $categories = Category::all();

        return view('products.index', compact(
            'products',
            'categories',
            'categoryId',
            'stock',
            'queryCount'
        ));
    }

    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'available' => 'nullable|boolean',
        ]);

        $validated['available'] = $request->boolean('available');

        $product = Product::create($validated);

        Log::info('Product saved', [
            'id' => $product->id,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'available' => 'nullable|boolean',
        ]);

        $validated['available'] = $request->boolean('available');

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        abort_if(
            Product::where('category_id', $product->category_id)->count() <= 1,
            403,
            'FORBIDDEN'
        );

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function featured()
    {
        $products = Product::where('available', true)->get();

        return view('products.featured', compact('products'));
    }

    public function filter($stock = null)
    {
        return redirect()->route('products.index', [
            'stock' => $stock,
        ]);
    }
}

