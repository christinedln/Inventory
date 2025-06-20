<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cart_items')->truncate();

        DB::table('cart_items')->insert([
            'user_id' => 1,
            'product_id' => 1,
            'product_name' => 'Aria',
            'image_path' => 'product_images/aria.jpg',
            'size' => 'M',
            'color' => 'White',
            'price' => 299.99,
            'quantity' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

