<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\SalesReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'min:6'],
            'role' => ['required', 'in:' . User::ROLE_ADMIN . ',' . User::ROLE_INVENTORY_MANAGER . ',' . User::ROLE_USER],
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully');
    }

    public function sales()
    {
        $sales = SalesReport::with('product')->get();
        return view('admin.sales', compact('sales'));
    }

    public function inventory()
    {
        $products = Product::all();
        return view('admin.inventory', compact('products'));
    }
}
