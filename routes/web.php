<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/products/featured', [ProductController::class, 'featured'])
    ->name('products.featured');

Route::get('/products/filter/{stock?}', [ProductController::class, 'filter'])
    ->name('products.filter');

Route::resource('products', ProductController::class);