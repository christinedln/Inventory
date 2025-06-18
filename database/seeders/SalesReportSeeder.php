<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesReport;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales_report')->truncate();

        $currentYear = Carbon::now()->year;
        $previousMonthRevenue = 0;

        $reportsData = [
            [
                'month_day' => 1,
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
            $accomplishment = ($data['target_sales_revenue'] > 0)
                ? round(($data['total_sales_revenue'] / $data['target_sales_revenue']) * 100, 2)
                : 0;

            $growth_per_month = 0;
            if ($index > 0 && $previousMonthRevenue > 0) {
                $growth_per_month = round((($data['total_sales_revenue'] - $previousMonthRevenue) / $previousMonthRevenue) * 100, 2);
            }

            SalesReport::create([
                'month' => Carbon::create($currentYear, $data['month_day'], 1)->format('Y-m-d'),
                'total_sales_revenue' => $data['total_sales_revenue'],
                'total_sales' => $data['total_sales'],
                'target_sales_revenue' => $data['target_sales_revenue'],
                'accomplishment' => $accomplishment,
                'growth_per_month' => $growth_per_month,
            ]);

            $previousMonthRevenue = $data['total_sales_revenue'];
        }
    }
}