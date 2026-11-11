<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
        ]);
    }
}
