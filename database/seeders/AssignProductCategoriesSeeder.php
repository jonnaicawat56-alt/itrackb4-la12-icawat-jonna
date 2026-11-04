<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class AssignProductCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $snacks = Category::firstOrCreate(['name' => 'Snacks']);
        $drinks = Category::firstOrCreate(['name' => 'Drinks']);
        $fastFood = Category::firstOrCreate(['name' => 'Fast Food']);

        Product::where('name', 'Coffee')
            ->update(['category_id' => $drinks->id]);

        Product::where('name', 'Chocolate')
            ->update(['category_id' => $snacks->id]);

        Product::where('name', 'Fries')
            ->update(['category_id' => $snacks->id]);

        Product::where('name', 'Burger')
            ->update(['category_id' => $fastFood->id]);

        Product::where('name', 'Pizza')
            ->update(['category_id' => $fastFood->id]);
    }
}