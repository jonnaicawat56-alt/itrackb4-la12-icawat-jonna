<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create lookup rows first
        $a = Category::create(['name' => 'Drinks']);
        $b = Category::create(['name' => 'Snacks']);
        $c = Category::create(['name' => 'Fast Food']);

        // Create products with real category IDs
        $products = [
            [
                'name' => 'Coffee',
                'price' => 120,
                'stock' => 20,
                'available' => true,
                'description' => 'Freshly brewed coffee.',
                'category_id' => $a->id,
            ],
            [
                'name' => 'Chocolate',
                'price' => 80,
                'stock' => 15,
                'available' => true,
                'description' => 'Sweet chocolate snack.',
                'category_id' => $b->id,
            ],
            [
                'name' => 'Fries',
                'price' => 75,
                'stock' => 30,
                'available' => true,
                'description' => 'Crispy potato fries.',
                'category_id' => $c->id,
            ],
            [
                'name' => 'Burger',
                'price' => 150,
                'stock' => 25,
                'available' => true,
                'description' => 'Burger with fresh vegetables.',
                'category_id' => $c->id,
            ],
            [
                'name' => 'Pizza',
                'price' => 250,
                'stock' => 10,
                'available' => true,
                'description' => null,
                'category_id' => $c->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
