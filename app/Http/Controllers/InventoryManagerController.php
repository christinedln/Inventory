<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryManagerController extends Controller
{
    public function dashboard()
    {
        return view('inventory.managerdashboard');
    }

    public function products()
    {
        $products = Product::all();
        return view('inventory.products', compact('products'));
    }

    // Add more inventory manager-specific methods here as needed
}
