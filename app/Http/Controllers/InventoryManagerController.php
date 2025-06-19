<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryManagerController extends Controller
{
    public function dashboard()
    {
        return view('manager.managerdashboard');
    }

}