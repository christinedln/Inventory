<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailySales;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DailySalesSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing records
        DailySales::truncate();

        // Create period from April 1 to May 31
        $period = CarbonPeriod::create('2025-04-01', '2025-05-31');

        // Iterate through each day and create a record
        foreach ($period as $date) {
            DailySales::create([
                'date' => $date->format('Y-m-d'),
                'daily_revenue' => rand(3000, 7000),
            ]);
        }
    }
}