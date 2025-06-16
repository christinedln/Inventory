<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'clothing_type' => 'required|string',
            'color' => 'required|string',
            'size' => 'required|string',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        // Save to the database
        Product::create($validated);

        // Redirect back or to a success page
        return redirect('/')->with('success', 'Product added successfully!');
    }
}
