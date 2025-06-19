<?php


namespace App\Http\Controllers\Maintenance;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class CategoryController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;


        if ($role === User::ROLE_ADMIN) {
            return view('maintenance.admincategory');
        } elseif ($role === User::ROLE_INVENTORY_MANAGER) {
            return view('maintenance.managercategory');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}



