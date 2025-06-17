<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total products count
        $totalProducts = Product::count();

        // Get low stock products (less than 10 items)
        $lowStockCount = Product::where('quantity', '<', 10)->count();

        // Get products by category for pie chart
        $productsByCategory = Product::select('clothing_type', DB::raw('count(*) as count'))
            ->groupBy('clothing_type')
            ->get();

        // Get stock levels for bar chart
        $stockLevels = Product::select('product_name', 'quantity')
            ->orderBy('quantity', 'desc')
            ->limit(10)
            ->get();

        // KPI Data

        // 1. Monthly stock trends (last 6 months)
        $monthlyStockTrends = Product::select(
            DB::raw('DATE_TRUNC(\'month\', date) as month'),
            DB::raw('SUM(quantity) as total_quantity')
        )
        ->whereDate('date', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // 2. Top performing products (by quantity)
        $topPerformers = Product::select('product_name', 'quantity')
            ->orderBy('quantity', 'desc')
            ->limit(5)
            ->get();

        // 3. Stock distribution by type
        $stockDistribution = Product::select(
            'clothing_type',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('COUNT(*) as product_count')
        )
        ->groupBy('clothing_type')
        ->get();

        // 4. Low stock alerts with details
        $lowStockItems = Product::where('quantity', '<', 10)
            ->select('product_name', 'quantity', 'clothing_type')
            ->orderBy('quantity')
            ->get();

        // Stock levels by size
        $stockBySize = Product::select('size', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('size')
            ->orderBy('size')
            ->get();

        // Get critical stock levels by size (items with less than 5 units)
        $criticalStockBySize = Product::select(
            'size',
            'product_name',
            'clothing_type',
            'quantity'
        )
        ->where('quantity', '<', 5)
        ->orderBy('size')
        ->orderBy('quantity')
        ->get()
        ->groupBy('size');

        return view('dashboard', compact(
            'totalProducts',
            'lowStockCount',
            'productsByCategory',
            'stockLevels',
            'monthlyStockTrends',
            'topPerformers',
            'stockDistribution',
            'lowStockItems',
            'stockBySize',
            'criticalStockBySize'
        ));
    }
}
