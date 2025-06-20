<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Size;


class AdminInventoryController extends Controller
{
    // Display the product inventory with pagination
    public function index(Request $request)
    {
        $highlightId = session('highlight_id');
        $categories = Category::orderBy('category')->pluck('category');
        $sizes = Size::orderByRaw("
        CASE 
            WHEN size = 'XXS' THEN 1
            WHEN size = 'XS' THEN 2
            WHEN size = 'S' THEN 3
            WHEN size = 'M' THEN 4
            WHEN size = 'L' THEN 5
            WHEN size = 'XL' THEN 6
            WHEN size = 'XXL' THEN 7
            WHEN size = '3XL' THEN 8
            WHEN size = '4XL' THEN 9
            WHEN size = '5XL' THEN 10
            WHEN size ~ E'^\\\\d+$' THEN 11  -- if size is a number (like 28, 30), put after named sizes
            ELSE 12
        END,
        CASE 
            WHEN size ~ E'^\\\\d+$' THEN CAST(size AS INTEGER)
            ELSE NULL
        END
    ")->pluck('size');

        $products = Product::orderBy('product_id', 'desc')->paginate(10);
        return view('admin.admininventory', compact('products', 'highlightId', 'categories', 'sizes'));
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
            'image' => 'required|image|max:15360', // 15MB max
                ], [
                    'image.max' => 'The image must not be larger than 15MB.',
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

        return redirect()->route('admin.inventory')->with('success', 'Product added successfully!');
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
        'image' => 'nullable|image|max:15360', // 15MB max
    ], [
        'image.max' => 'The image must not be larger than 15MB.',
    ]);

    // Check if the product is in cart_items or checkouts
    $isInCart = DB::table('cart_items')->where('product_id', $product->product_id)->exists();
    $isInCheckout = DB::table('checkouts')->where('product_id', $product->product_id)->exists();

    // Restrict field changes if in cart or checkout
    if ($isInCart || $isInCheckout) {
        if (
            $validated['product_name'] !== $product->product_name ||
            $validated['clothing_type'] !== $product->clothing_type ||
            $validated['color'] !== $product->color ||
            $validated['size'] !== $product->size
        ) {
            return back()->withErrors([
                'restricted' => 'You cannot edit the product name, clothing type, color, or size because this product exists in a cart or has already been checked out.'
            ])->withInput();
        }

        $data = [
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
        ];
    } else {
        $data = [
            'product_name' => $validated['product_name'],
            'clothing_type' => $validated['clothing_type'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
        ];
    }

    if ($validated['quantity'] < $originalQuantity) {
        if (!$request->filled('reason')) {
            return back()->withErrors(['reason' => 'Please provide a reason for reducing the quantity.'])->withInput();
        }
        $data['last_reason'] = $validated['reason'];
    }

    if ($request->hasFile('image')) {
        if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
            \Storage::disk('public')->delete($product->image_path);
        }
        $imagePath = $request->file('image')->store('product_images', 'public');
        $data['image_path'] = $imagePath;
    }

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

    return redirect()->route('admin.inventory')->with('success', 'Product updated successfully!');
}


public function approve($id)
{
    $product = Product::findOrFail($id);

    if ($product->status === 'for approval' && $product->requested_reduction !== null) {

        // Subtract reduction but prevent going below zero
        $newQuantity = max(0, $product->quantity - $product->requested_reduction);
        $product->quantity = $newQuantity;

        // Update status only
        $product->status = 'approved';

        $product->save();

        return redirect()->back()->with('success', 'Product reduction approved successfully.');
    }

    return redirect()->back()->with('error', 'This product is not pending approval or no reduction was requested.');
}



}
