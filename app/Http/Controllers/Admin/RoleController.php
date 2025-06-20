<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = User::select('users.*', 'roles.role as role_name', 'roles.status as role_status')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->get();
        
        return view('admin.adminrole', compact('roles', 'users'));
    }

    public function toggle(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->status = ($role->status === 'Active') ? 'Inactive' : 'Active';
        $role->save();

        // Update status for users with this role
        User::where('role_id', $id)->update(['status' => $role->status]);

        return response()->json([
            'success' => true,
            'status' => $role->status
        ]);
    }
}