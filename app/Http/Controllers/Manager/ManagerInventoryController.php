<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ManagerInventoryController extends Controller
{
    // Display the product inventory with pagination
    public function index(Request $request)
    {
        $highlightId = session('highlight_id');

        $products = Product::orderBy('product_id', 'desc')->paginate(10);
        return view('manager.managerinventory', compact('products', 'highlightId'));
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
            'image' => 'required|image|max:15360',
             // 15MB max
        ]);

        // Check for duplicate product
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

        // Store the image and get the storage path
        $imagePath = $request->file('image')->store('product_images', 'public');

        // Create the product with image path
        Product::create([
            'product_name' => $validated['product_name'],
            'clothing_type' => $validated['clothing_type'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('manager.inventory')->with('success', 'Product added successfully!');
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
    $product = Product::findOrFail($id);
    $originalQuantity = $product->quantity;

    $validated = $request->validate([
        'product_name' => 'required|string|max:255',
        'clothing_type' => 'required|string',
        'color' => 'required|string',
        'size' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'reason' => 'nullable|string|max:1000',
    ]);

    $data = [
        'product_name' => $validated['product_name'],
        'clothing_type' => $validated['clothing_type'],
        'color' => $validated['color'],
        'size' => $validated['size'],
        'quantity' => $validated['quantity'],
        'price' => $validated['price'],
    ];

    // Add last_reason *after* defining $data
    if ($validated['quantity'] < $originalQuantity) {
        if (!$request->filled('reason')) {
            return back()->withErrors(['reason' => 'Please provide a reason for reducing the quantity.'])->withInput();
        }

        $data['last_reason'] = $validated['reason'];
    }

    // Handle image replacement
    if ($request->hasFile('image')) {
        if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
            \Storage::disk('public')->delete($product->image_path);
        }

        $imagePath = $request->file('image')->store('product_images', 'public');
        $data['image_path'] = $imagePath;
    }

    $product->update($data);

    // Low stock check
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

    return redirect()->route('manager.inventory')->with('success', 'Product updated successfully!');
}

}
