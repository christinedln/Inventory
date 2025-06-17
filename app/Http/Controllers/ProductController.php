<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class ProductController extends Controller
{

    public function index()
    {
         $products = Product::orderBy('product_id', 'desc')->paginate(10);
        return view('inventory', compact('products'));
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


        return redirect('inventory')->with('success', 'Product added successfully!');
    }


    // Delete function for PostgreSQL
    public function delete($id)
    {
        DB::table('products')->where('product_id', $id)->delete();


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

        $data = [
            'product_name' => $validated['product_name'],
            'clothing_type' => $validated['clothing_type'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'date' => $validated['date'],
            'quantity' => $validated['quantity'],
        ];

        $product = Product::findOrFail($id);
        $product->update($data);

        return redirect('inventory')->with('success', 'Product updated successfully!');
    }
}



