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

        // Write data rows
        $total = 0;
        foreach ($sales as $sale) {
            // Format date as text to prevent Excel from converting it
            fputcsv($handle, [
                "'" . $sale->date->format('Y-m-d'),  // Add single quote to force text format
                sprintf('%.2f', $sale->daily_revenue) // Format number with 2 decimal places
            ]);
            $total += $sale->daily_revenue;
        }

        // Write total row
        fputcsv($handle, ['Total', sprintf('%.2f', $total)]);

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}