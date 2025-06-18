<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->truncate();

        DB::table('products')->insert([
            [
                'product_name' => 'Aria',
                'clothing_type' => 'Shirts',
                'color' => 'White',
                'size' => 'M',
                'quantity' => 25,
                'price' => 299.99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_name' => 'Maria',
                'clothing_type' => 'Pants',
                'color' => 'Blue',
                'size' => 'S',
                'quantity' => 12,
                'price' => 799.50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_name' => 'Layla',
                'clothing_type' => 'Hoodies',
                'color' => 'Black',
                'size' => 'L',
                'quantity' => 45,
                'price' => 1299.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
