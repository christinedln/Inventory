<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.adminrole', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|unique:roles,role|max:255'
        ]);

        $role = Role::create([
            'role' => $validated['role'],
            'status' => 'Active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'role' => $role
        ]);
    }

    public function toggle(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->status = ($role->status === 'Active') ? 'Inactive' : 'Active';
        $role->save();

        return response()->json([
            'success' => true,
            'status' => $role->status
        ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        
        // Prevent deletion if users are assigned to this role
        if ($role->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete role with assigned users'
            ], 400);
        }
        
        $role->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully'
        ]);
    }
}