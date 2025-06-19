<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSizeController extends Controller
{
    public function index()
    {
        return view('maintenance.adminsize');
    }
}
