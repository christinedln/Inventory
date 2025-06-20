<?php


namespace App\Http\Controllers\Maintenance;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Size;


class SizeController extends Controller
{
    public function index()
{
    $role = Auth::user()->role;
    $sizes = Size::all(); // ✅ Moved outside the role condition

    if ($role === User::ROLE_ADMIN) {
        return view('maintenance.adminsize', compact('sizes'));
    } elseif ($role === User::ROLE_INVENTORY_MANAGER) {
        return view('maintenance.managersize', compact('sizes'));
    } else {
        abort(403, 'Unauthorized action.');
    }
}


    public function store(Request $request)
{
    $user = auth()->user();

    // Allow only admin or manager roles
    if (!in_array($user->role, ['admin', 'manager'])) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'size' => 'required|string|unique:sizes,size',
    ]);

    Size::create(['size' => $request->size]);

    if ($user->role === 'admin') {
        return redirect()->route('admin.maintenance.size')->with('success', 'Size added successfully!');
    } elseif ($user->role === 'manager') {
        return redirect()->route('manager.maintenance.size')->with('success', 'Size added successfully!');
    }
}

    public function edit($id)
{
    $size = \App\Models\Size::findOrFail($id);
    $user = auth()->user();

    if ($user->role === 'admin') {
        return view('maintenance.adminsize', compact('size'));
    } elseif ($user->role === 'manager') {
        return view('maintenance.managersize', compact('size'));
    } else {
        abort(403, 'Unauthorized action.');
    }
}

    public function update(Request $request, $id)
{
    $user = auth()->user();

    // Only allow admin or manager
    if (!in_array($user->role, ['admin', 'manager'])) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'size' => 'required|string|max:255|unique:sizes,size,' . $id . ',size_id',
    ]);

    $size = \App\Models\Size::findOrFail($id);
    $size->size = $request->size;
    $size->save();


    if ($user->role === 'admin') {
        return redirect()->route('admin.maintenance.size')->with('success', 'Size updated!');
    } elseif ($user->role === 'manager') {
        return redirect()->route('manager.maintenance.size')->with('success', 'Size updated!');
    }
}

    public function destroy($id)
{
    $user = auth()->user();

    // Only admin can delete
    if ($user->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $size = \App\Models\Size::findOrFail($id);
    $size->delete();

    return redirect()->route('admin.maintenance.size')->with('success', 'Size deleted!');
}

}



