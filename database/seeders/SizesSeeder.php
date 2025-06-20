<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SizesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sizes')->truncate(); // Optional: clears old data

        DB::table('sizes')->insert([
            ['size' => 'XS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size' => 'S',  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size' => 'M',  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size' => 'L',  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size' => 'XL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size' => 'XXL','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['size' => 'Free Size','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
