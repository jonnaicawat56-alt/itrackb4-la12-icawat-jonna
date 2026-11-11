
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/featured', [ProductController::class, 'featured'])
    ->name('products.featured');

Route::get('/products/filter/{stock?}', [ProductController::class, 'filter'])
    ->name('products.filter');

Route::resource('products', ProductController::class);
