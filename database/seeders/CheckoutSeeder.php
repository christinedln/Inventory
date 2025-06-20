<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CheckoutSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('checkouts')->truncate(); 

        DB::table('checkouts')->insert([
            'user_id'      => 1,
            'product_id'   => 1,
            'product_name' => 'Aria',
            'color'        => 'White',
            'size'         => 'M',
            'price'        => 299.99,
            'quantity'     => 1,
            'total'        => 299.99, // price * quantity
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}
