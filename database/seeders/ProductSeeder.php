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

        // Create 20 products with different categories
        $products = [
            // Drinks
            [
                'name' => 'Coffee',
                'price' => 120,
                'stock' => 20,
                'available' => true,
                'description' => 'Freshly brewed coffee.',
                'category_id' => $a->id,
            ],
            [
                'name' => 'Milk Tea',
                'price' => 100,
                'stock' => 18,
                'available' => true,
                'description' => 'Sweet milk tea drink.',
                'category_id' => $a->id,
            ],
            [
                'name' => 'Orange Juice',
                'price' => 85,
                'stock' => 25,
                'available' => true,
                'description' => 'Fresh orange juice.',
                'category_id' => $a->id,
            ],
            [
                'name' => 'Iced Chocolate',
                'price' => 95,
                'stock' => 12,
                'available' => true,
                'description' => 'Cold chocolate drink.',
                'category_id' => $a->id,
            ],
            [
                'name' => 'Lemonade',
                'price' => 70,
                'stock' => 30,
                'available' => true,
                'description' => 'Refreshing lemon drink.',
                'category_id' => $a->id,
            ],
            [
                'name' => 'Strawberry Smoothie',
                'price' => 130,
                'stock' => 15,
                'available' => true,
                'description' => 'Blended strawberry drink.',
                'category_id' => $a->id,
            ],
            [
                'name' => 'Bottled Water',
                'price' => 25,
                'stock' => 40,
                'available' => true,
                'description' => 'Purified drinking water.',
                'category_id' => $a->id,
            ],

            // Snacks
            [
                'name' => 'Chocolate',
                'price' => 80,
                'stock' => 15,
                'available' => true,
                'description' => 'Sweet chocolate snack.',
                'category_id' => $b->id,
            ],
            [
                'name' => 'Potato Chips',
                'price' => 45,
                'stock' => 22,
                'available' => true,
                'description' => 'Crunchy potato chips.',
                'category_id' => $b->id,
            ],
            [
                'name' => 'Cookies',
                'price' => 55,
                'stock' => 20,
                'available' => true,
                'description' => 'Freshly baked cookies.',
                'category_id' => $b->id,
            ],
            [
                'name' => 'Donut',
                'price' => 50,
                'stock' => 16,
                'available' => true,
                'description' => 'Sweet glazed donut.',
                'category_id' => $b->id,
            ],
            [
                'name' => 'Popcorn',
                'price' => 60,
                'stock' => 28,
                'available' => true,
                'description' => 'Buttery popcorn snack.',
                'category_id' => $b->id,
            ],
            [
                'name' => 'Cupcake',
                'price' => 65,
                'stock' => 14,
                'available' => true,
                'description' => 'Soft vanilla cupcake.',
                'category_id' => $b->id,
            ],

            // Fast Food
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
                'description' => 'Cheese and pepperoni pizza.',
                'category_id' => $c->id,
            ],
            [
                'name' => 'Chicken Sandwich',
                'price' => 130,
                'stock' => 18,
                'available' => true,
                'description' => 'Crispy chicken sandwich.',
                'category_id' => $c->id,
            ],
            [
                'name' => 'Hotdog Sandwich',
                'price' => 90,
                'stock' => 20,
                'available' => true,
                'description' => 'Hotdog with special sauce.',
                'category_id' => $c->id,
            ],
            [
                'name' => 'Cheeseburger',
                'price' => 170,
                'stock' => 12,
                'available' => true,
                'description' => 'Burger with melted cheese.',
                'category_id' => $c->id,
            ],
            [
                'name' => 'Chicken Nuggets',
                'price' => 110,
                'stock' => 24,
                'available' => true,
                'description' => 'Crispy chicken nuggets.',
                'category_id' => $c->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}