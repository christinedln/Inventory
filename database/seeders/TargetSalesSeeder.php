<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TargetInputForm;
use Illuminate\Support\Facades\DB;

class TargetSalesSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate the table first
        DB::table('target_sales')->truncate();

        TargetInputForm::create([
            'quarter' => 1,
            'target_revenue' => 420000,
        ]);

        TargetInputForm::create([
            'quarter' => 2,
            'target_revenue' => 450000,
        ]);
    }
}