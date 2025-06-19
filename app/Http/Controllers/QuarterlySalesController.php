<?php

namespace App\Http\Controllers;

use App\Models\DailySales;
use App\Models\TargetInputForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuarterlySalesController extends Controller
{
    public function index()
    {
        // Get quarterly sales using PostgreSQL's EXTRACT function
        $quarterlySales = DailySales::select(
            DB::raw('EXTRACT(QUARTER FROM date) as quarter'),
            DB::raw('SUM(daily_revenue) as total_sales')  // Changed to daily_revenue
        )
        ->groupBy(DB::raw('EXTRACT(QUARTER FROM date)'))
        ->get()
        ->keyBy('quarter');

        // Get quarterly targets
        $targets = TargetInputForm::all()->keyBy('quarter');

        // Prepare data for all quarters
        $quarterlyData = [];
        for ($i = 1; $i <= 4; $i++) {
            $quarterlyData[$i] = [
                'target' => $targets[$i]->target_revenue ?? 0,
                'accomplished' => $quarterlySales[$i]->total_sales ?? 0
            ];
        }

        return view('sales-report.quarterly-sales', compact('quarterlyData'));
    }
}