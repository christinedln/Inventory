<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['Small', 'Medium', 'Large', 'Extra Large', 'XXL', 'XXXL'];

        foreach ($sizes as $size) {
            Size::firstOrCreate(['size' => $size]);
        }
    }
}
