<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class ProductController extends Controller
{
    // Display the product inventory with pagination
    public function index(Request $request)
    {
        $highlightId = session('highlight_id'); 

        $products = Product::orderBy('product_id', 'desc')->paginate(10);

        return view('inventory', compact('products', 'highlightId'));
    }

    //Store a new product in the products table
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

        // Check if a product with the same product_name, clothing_type, color, and size already exists
       $exists = Product::where('product_name', $validated['product_name'])
            ->where('clothing_type', $validated['clothing_type'])
            ->where('color', $validated['color'])
            ->where('size', $validated['size'])
            ->exists();

    if ($exists) {
        return redirect()->back()->withErrors([
            'duplicate' => 'That product already exists.'
        ])->withInput();
    }


        Product::create($validated);


        return redirect('inventory')->with('success', 'Product added successfully!');
    }


    // Delete a product by its ID
    public function delete($id)
    {
        DB::table('products')->where('product_id', $id)->delete();


        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    //Update a product’s information and triggers a notification if a products's quantity is below 10
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
            $latestNotification = DB::table('notifications')
                ->where('notification', "{$product->product_name} is low on stock")
                ->where('notifiable_id', $product->product_id)
                ->where('category', 'inventory')
                ->orderByDesc('created_at')
                ->first();

            if (!$latestNotification || $latestNotification->status === 'resolved') {
                DB::table('notifications')->insert([
                    'notification'   => "{$product->product_name} is low on stock",
                    'type'           => 'warning',
                    'category'       => 'inventory',
                    'notifiable_id'  => $product->product_id,
                    'status'         => 'unresolved',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }


        return redirect('inventory')->with('success', 'Product updated successfully!');
    }
}



