<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'product_name' => 'Oxford Button-Down Shirt',
                'clothing_type' => 'Shirts',
                'color' => 'White',
                'size' => 'M',
                'quantity' => 45,
                'date' => Carbon::now()->subDays(30),
            ],
            [
                'product_name' => 'Dress Shirt',
                'clothing_type' => 'Shirts',
                'color' => 'Blue',
                'size' => 'L',
                'quantity' => 38,
                'date' => Carbon::now()->subDays(60),
            ],
            [
                'product_name' => 'Wool Sweater',
                'clothing_type' => 'Sweaters',
                'color' => 'Gray',
                'size' => 'M',
                'quantity' => 25,
                'date' => Carbon::now()->subDays(45),
            ],
            [
                'product_name' => 'Cashmere Sweater',
                'clothing_type' => 'Sweaters',
                'color' => 'Black',
                'size' => 'L',
                'quantity' => 5,
                'date' => Carbon::now()->subDays(90),
            ],
            [
                'product_name' => 'Running Shorts',
                'clothing_type' => 'Shorts',
                'color' => 'Black',
                'size' => 'M',
                'quantity' => 30,
                'date' => Carbon::now()->subDays(15),
            ],
            [
                'product_name' => 'Zip-up Hoodie',
                'clothing_type' => 'Hoodies',
                'color' => 'Gray',
                'size' => 'L',
                'quantity' => 15,
                'date' => Carbon::now()->subDays(75),
            ],
            [
                'product_name' => 'Pullover Hoodie',
                'clothing_type' => 'Hoodies',
                'color' => 'Black',
                'size' => 'M',
                'quantity' => 20,
                'date' => Carbon::now()->subDays(20),
            ],
            [
                'product_name' => 'Chino Pants',
                'clothing_type' => 'Pants',
                'color' => 'Khaki',
                'size' => '32',
                'quantity' => 3,
                'date' => Carbon::now()->subDays(40),
            ],
            [
                'product_name' => 'Pleated Skirt',
                'clothing_type' => 'Skirts',
                'color' => 'Navy',
                'size' => 'S',
                'quantity' => 18,
                'date' => Carbon::now()->subDays(25),
            ],
            [
                'product_name' => 'Dress Trousers',
                'clothing_type' => 'Trousers',
                'color' => 'Black',
                'size' => '34',
                'quantity' => 7,
                'date' => Carbon::now()->subDays(100),
            ],
            [
                'product_name' => 'Evening Dress',
                'clothing_type' => 'Dresses',
                'color' => 'Red',
                'size' => 'S',
                'quantity' => 12,
                'date' => Carbon::now()->subDays(55),
            ],
            [
                'product_name' => 'Cargo Shorts',
                'clothing_type' => 'Shorts',
                'color' => 'Green',
                'size' => 'L',
                'quantity' => 40,
                'date' => Carbon::now()->subDays(10),
            ],
            [
                'product_name' => 'Cotton Dress',
                'clothing_type' => 'Dresses',
                'color' => 'White',
                'size' => 'M',
                'quantity' => 22,
                'date' => Carbon::now()->subDays(35),
            ],
            [
                'product_name' => 'Slim Fit Trousers',
                'clothing_type' => 'Trousers',
                'color' => 'Gray',
                'size' => '30',
                'quantity' => 9,
                'date' => Carbon::now()->subDays(70),
            ],
            [
                'product_name' => 'V-neck Sweater',
                'clothing_type' => 'Sweaters',
                'color' => 'Navy',
                'size' => 'XL',
                'quantity' => 0,
                'date' => Carbon::now()->subDays(85),
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
