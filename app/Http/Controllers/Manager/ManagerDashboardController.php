<?php

namespace App\Http\Controllers\Manager;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== User::ROLE_INVENTORY_MANAGER) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }

        $totalProducts = Product::count(); // Get total products
        $lowStockCount = Product::where('quantity', '<', 10)->count(); // Count low stock

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
        $stockBySize = DB::table('products')
            ->select('size', DB::raw('SUM(quantity) as total_quantity'))
            ->whereNotNull('size')
            ->groupBy('size')
            ->orderBy(DB::raw('CASE
                WHEN size = \'XS\' THEN 1
                WHEN size = \'S\' THEN 2
                WHEN size = \'M\' THEN 3
                WHEN size = \'L\' THEN 4
                WHEN size = \'XL\' THEN 5
                WHEN size = \'XXL\' THEN 6
                ELSE 7 END'))
            ->get();

        $sizeLabels = $stockBySize->pluck('size');
        $sizeValues = $stockBySize->pluck('total_quantity');

        // Get total stock value
        $totalStockValue = DB::table('products')
            ->sum(DB::raw('quantity * price'));

        // Get number of categories
        $categoryCount = DB::table('products')
            ->distinct()
            ->count('clothing_type');

        $stockLevels = Product::select('product_name', 'quantity', 'clothing_type')
            ->orderBy('quantity', 'asc')
            ->get();

        $topPerformers = Product::select('product_name', 'quantity')
            ->orderBy('quantity', 'desc')
            ->limit(5)
            ->get();

        $lowStockItems = Product::where('quantity', '<', 10)
            ->select('product_name', 'quantity', 'clothing_type')
            ->orderBy('quantity')
            ->get();

        return view('manager.managerdashboard', compact(
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
            'topPerformers',
            'stockBySize'
        ));
    }
}