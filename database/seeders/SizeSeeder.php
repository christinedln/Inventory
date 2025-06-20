<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the sizes table before seeding
        DB::table('sizes')->truncate();

        $sizes = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

        foreach ($sizes as $size) {
            Size::firstOrCreate(['size' => $size]);
        }
    }
}
