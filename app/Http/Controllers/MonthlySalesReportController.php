<?php

namespace App\Http\Controllers;

use App\Models\DailySales;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class MonthlySalesReportController extends Controller
{
    public function index()
    {
        $currentYear = Carbon::now()->year;
        
        $monthlySales = DailySales::select(
            DB::raw('EXTRACT(MONTH FROM date) as month'),
            DB::raw('EXTRACT(YEAR FROM date) as year'),
            DB::raw('SUM(daily_revenue) as total_sales')
        )
        ->whereYear('date', $currentYear)
        ->groupBy('year', 'month')
        ->orderBy('month')
        ->get();

        return view('sales-report.monthly-sales', compact('monthlySales', 'currentYear'));
    }

    public function export()
    {
        $sales = DailySales::select('date', 'daily_revenue')
            ->orderBy('date', 'asc')
            ->get();

        $filename = 'sales_report_' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'r+');

        // Add BOM for Excel to properly detect UTF-8
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        // Write headers
        fputcsv($handle, ['Date', 'Revenue']);

        // Group sales by month
        $monthlySales = [];
        $grandTotal = 0;

        foreach ($sales as $sale) {
            $monthKey = $sale->date->format('Y-m');
            if (!isset($monthlySales[$monthKey])) {
                $monthlySales[$monthKey] = [
                    'sales' => [],
                    'total' => 0
                ];
            }
            $monthlySales[$monthKey]['sales'][] = $sale;
            $monthlySales[$monthKey]['total'] += $sale->daily_revenue;
            $grandTotal += $sale->daily_revenue;
        }

        // Write data rows with monthly totals
        foreach ($monthlySales as $month => $data) {
            // Write month header
            fputcsv($handle, [$data['sales'][0]->date->format('F Y'), '']);

            // Write daily sales
            foreach ($data['sales'] as $sale) {
                fputcsv($handle, [
                    "'" . $sale->date->format('Y-m-d'),
                    sprintf('%.2f', $sale->daily_revenue)
                ]);
            }

            // Write monthly total
            fputcsv($handle, ['Monthly Total', sprintf('%.2f', $data['total'])]);
            fputcsv($handle, ['', '']); // Empty line for spacing
        }

        // Write grand total
        fputcsv($handle, ['Grand Total', sprintf('%.2f', $grandTotal)]);

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}