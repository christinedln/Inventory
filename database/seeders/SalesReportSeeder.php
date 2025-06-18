<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesReport;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Seeder class for populating the sales_report table with sample data.
class SalesReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This method is called when the `db:seed` Artisan command is executed.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the table to start with a clean slate on each seed.
        DB::table('sales_report')->truncate();

        // Get the current year to use for the 'month' field.
        $currentYear = Carbon::now()->year;
        // Initialize previous month's revenue to 0 for calculating growth for the first entry.
        $previousMonthRevenue = 0;

        // Array of sample sales report data for different months.
        $reportsData = [
            [
                'month_day' => 1, // Represents month 1 (January).
                'total_sales_revenue' => 130000,
                'total_sales' => 420,
                'target_sales_revenue' => 120000,
            ],
            [
                'month_day' => 2,
                'total_sales_revenue' => 125000,
                'total_sales' => 400,
                'target_sales_revenue' => 125000,
            ],
            [
                'month_day' => 3,
                'total_sales_revenue' => 95000,
                'total_sales' => 310,
                'target_sales_revenue' => 110000,
            ],
            [
                'month_day' => 4,
                'total_sales_revenue' => 140000,
                'total_sales' => 450,
                'target_sales_revenue' => 130000,
            ],
            [
                'month_day' => 5,
                'total_sales_revenue' => 140000,
                'total_sales' => 440,
                'target_sales_revenue' => 140000,
            ],
            [
                'month_day' => 6,
                'total_sales_revenue' => 190000,
                'total_sales' => 550,
                'target_sales_revenue' => 165000,
            ],
        ];

        foreach ($reportsData as $index => $data) {
            // Calculate accomplishment percentage.
            $accomplishment = ($data['target_sales_revenue'] > 0)
                ? round(($data['total_sales_revenue'] / $data['target_sales_revenue']) * 100, 2)
                : 0;

            // Calculate growth percentage compared to the previous month.
            $growth_per_month = 0;
            if ($index > 0 && $previousMonthRevenue > 0) {
                $growth_per_month = round((($data['total_sales_revenue'] - $previousMonthRevenue) / $previousMonthRevenue) * 100, 2);
            }

            // Create a SalesReport record.
            SalesReport::create([
                // Format the month as 'YYYY-MM-DD', using the 1st day of the specified month.
                'month' => Carbon::create($currentYear, $data['month_day'], 1)->format('Y-m-d'),
                'total_sales_revenue' => $data['total_sales_revenue'],
                'total_sales' => $data['total_sales'],
                'target_sales_revenue' => $data['target_sales_revenue'],
                'accomplishment' => $accomplishment,
                'growth_per_month' => $growth_per_month,
            ]);

            // Update previous month's revenue for the next iteration's growth calculation.
            $previousMonthRevenue = $data['total_sales_revenue'];
        }
    }
}