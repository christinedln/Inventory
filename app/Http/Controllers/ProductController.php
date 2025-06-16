<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        try {
            $products = Product::paginate(10);
            return view('home', compact('products'));
        } catch (\Exception $e) {
            // If there's an error, return an empty collection with pagination
            $products = new \Illuminate\Pagination\LengthAwarePaginator(
                [],     // items
                0,      // total
                10,     // per page
                1       // current page
            );
            return view('home', compact('products'));
        }
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

        // Map the form field names to database column names
        $data = [
            'name' => $validated['product_name'],
            'category' => $validated['clothing_type'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'date' => $validated['date'],
            'quantity' => $validated['quantity'],
        ];

        Product::create($data);

        return redirect('/')->with('success', 'Product added successfully!');
    }

    public function delete($id)
    {
        DB::table('products')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'clothing_type' => 'required|string',
            'color' => 'required|string',
            'size' => 'required|string',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        // Map the form field names to database column names
        $data = [
            'name' => $validated['product_name'],
            'category' => $validated['clothing_type'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'date' => $validated['date'],
            'quantity' => $validated['quantity'],
        ];

        $product = Product::findOrFail($id);
        $product->update($data);

        return redirect('/')->with('success', 'Product updated successfully!');
    }
}
