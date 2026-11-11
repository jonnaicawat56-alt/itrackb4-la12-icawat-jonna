<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Display all products with search, filters, sorting, and pagination
    public function index(Request $request)
    {
        // Get search and filter values
        $name = $request->query('name');
        $categoryId = $request->query('category_id');
        $available = $request->query('available');
        $stock = $request->query('stock');
        $benchmark = $request->query('benchmark');

        // Get sorting value
        $sort = $request->query('sort', 'name');

        // Validate sorting column
        $allowedSorts = ['name', 'price', 'stock'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        // Start product query
        $query = Product::with('category');

        // Search by product name
        if ($name !== null && $name !== '') {
            $query->where('name', 'like', "%{$name}%");
        }

        // Filter by category
        if ($categoryId !== null && $categoryId !== '') {
            $query->where('category_id', $categoryId);
        }

        // Filter by availability
        if ($available !== null && $available !== '') {
            $query->where('available', $available);
        }

        // Filter by stock
        if ($stock !== null && $stock !== '') {
            $query->where('stock', '>=', $stock);
        }

        // Sort products
        $query->orderBy($sort);

        // Count database queries
        DB::flushQueryLog();
        DB::enableQueryLog();

        try {
            // Paginate and preserve search/filter values
            $products = $query->paginate(7)->withQueryString();

            // Benchmark condition
            if ($benchmark !== 'after') {
                foreach ($products as $product) {
                    $product->category;
                }
            }

            $queryCount = count(DB::getQueryLog());

        } finally {
            DB::disableQueryLog();
        }

        // Get categories for dropdown
        $categories = Category::all();

        // Return data to view
        return view('products.index', compact(
            'products',
            'categories',
            'name',
            'categoryId',
            'available',
            'stock',
            'sort',
            'queryCount'
        ));
    }

    // Show the form for creating a product
    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    // Store a newly created product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'available' => 'nullable|boolean',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['available'] = $request->boolean('available');

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully!');
    }

    // Display the specified product
    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    // Show the form for editing a product
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('products.edit', compact(
            'product',
            'categories'
        ));
    }

    // Update the specified product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'available' => 'nullable|boolean',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['available'] = $request->boolean('available');

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    // Remove the specified product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
