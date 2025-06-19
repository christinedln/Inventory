<?php


namespace App\Http\Controllers\Maintenance;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class SizeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;


        if ($role === User::ROLE_ADMIN) {
            return view('maintenance.adminsize');
        } elseif ($role === User::ROLE_INVENTORY_MANAGER) {
            return view('maintenance.managersize');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}



