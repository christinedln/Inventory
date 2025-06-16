<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::paginate(10); 
        return view('home', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'clothing_type' => 'required|string',
            'color' => 'required|string',
            'size' => 'required|string',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        Product::create($validated);

        return redirect('/')->with('success', 'Product added successfully!');
    }

    // Delete function for PostgreSQL
    public function delete($id)
    {
        DB::table('products')->where('product_id', $id)->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}
