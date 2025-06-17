<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class ProductController extends Controller
{

    public function index(Request $request)
    {
        $highlightId = session('highlight_id'); 

        $products = Product::orderBy('product_id', 'desc')->paginate(10);

        return view('inventory', compact('products', 'highlightId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'clothing_type' => 'required|string',
            'color' => 'required|string',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
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
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $data = [
            'product_name' => $validated['product_name'],
            'clothing_type' => $validated['clothing_type'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
        ];

        $product = Product::findOrFail($id);
        $product->update($data);

            
        if ($product->quantity < 10) {
            DB::table('notifications')->updateOrInsert(
                ['notification' => "{$product->product_name} is low on stock"],
                [
                    'type' => 'warning',
                    'category' => 'inventory',
                    'notifiable_id' => $product->product_id,
                ]
            );
    }

        return redirect('inventory')->with('success', 'Product updated successfully!');
    }
}



