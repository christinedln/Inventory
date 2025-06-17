<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total products and low stock count
        $totalProducts = Product::count();
        $lowStockCount = Product::where('quantity', '<', 10)->count();

        // Monthly trends with created_at
        $monthlyStockTrends = DB::table('products')
            ->select(
                DB::raw('DATE_TRUNC(\'month\', created_at) as month'),
                'clothing_type',
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->whereNotNull('created_at')
            ->groupBy('month', 'clothing_type')
            ->orderBy('month', 'asc')
            ->get();

        // Format data for monthly trends chart
        $labels = $monthlyStockTrends->pluck('month')
            ->unique()
            ->map(function($date) {
                return Carbon::parse($date)->format('M Y');
            });

        $datasets = [];
        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
            '#9966FF', '#FF9F40', '#00CC99', '#FF99CC'
        ];

        $colorIndex = 0;
        foreach ($monthlyStockTrends->pluck('clothing_type')->unique() as $type) {
            $data = [];
            foreach ($monthlyStockTrends->pluck('month')->unique() as $month) {
                $quantity = $monthlyStockTrends
                    ->where('month', $month)
                    ->where('clothing_type', $type)
                    ->sum('total_quantity');
                $data[] = $quantity;
            }

            $datasets[] = [
                'label' => $type,
                'data' => $data,
                'borderColor' => $colors[$colorIndex % count($colors)],
                'backgroundColor' => $colors[$colorIndex % count($colors)] . '40',
                'tension' => 0.4,
                'fill' => true
            ];
            $colorIndex++;
        }

        // Category distribution for pie chart
        $productsByCategory = Product::select('clothing_type', DB::raw('count(*) as count'))
            ->groupBy('clothing_type')
            ->get();

        $categoryLabels = [];
        $categoryValues = [];
        $categoryData = DB::table('products')
            ->select('clothing_type', DB::raw('count(*) as count'))
            ->groupBy('clothing_type')
            ->get();

        foreach ($categoryData as $category) {
            $categoryLabels[] = $category->clothing_type;
            $categoryValues[] = $category->count;
        }

        // Stock levels by size for bar chart
        $sizeLabels = [];
        $sizeValues = [];
        $stockBySize = DB::table('products')
            ->select('size', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('size')
            ->orderBy('size')
            ->get();

        foreach ($stockBySize as $size) {
            $sizeLabels[] = $size->size;
            $sizeValues[] = $size->total_quantity;
        }

        // Get total stock value
        $totalStockValue = DB::table('products')
            ->sum(DB::raw('quantity * price'));

        // Get number of categories
        $categoryCount = DB::table('products')
            ->distinct()
            ->count('clothing_type');

        $stockLevels = DB::table('products')
        ->select('product_name', 'quantity')
        ->orderBy('quantity', 'asc')  // Show lowest stock first
        ->get();

        // Get top performing products by quantity
        $topPerformers = Product::select('product_name', 'quantity')
            ->orderBy('quantity', 'desc')
            ->limit(5)
            ->get();

        // Get low stock items (less than 10 units)
        $lowStockItems = Product::where('quantity', '<', 10)
            ->select('product_name', 'quantity', 'clothing_type')
            ->orderBy('quantity')
            ->get();

        return view('dashboard', compact(
            'labels',
            'datasets',
            'categoryLabels',
            'categoryValues',
            'sizeLabels',
            'sizeValues',
            'totalProducts',
            'lowStockCount',
            'totalStockValue',
            'categoryCount',
            'stockLevels',
            'productsByCategory',
            'lowStockItems',
            'monthlyStockTrends',
            'topPerformers',
            'stockBySize'
        ));
    }
}
