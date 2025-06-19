<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Shirts', 'Sweaters', 'Hoodies', 'Pants',
            'Skirts', 'Trousers', 'Shorts', 'Dresses'
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['category' => $cat]);
        }
    }
}
