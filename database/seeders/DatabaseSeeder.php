<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            ManagerUserSeeder::class,
            ProductsTableSeeder::class,
            DailySalesSeeder::class,
            TargetSalesSeeder::class,
            CategorySeeder::class,
            SizeSeeder::class,,
            CartSeeder::class,
            CheckoutSeeder::class,
            CategoriesSeeder::class,
            SizesSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
