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


        if ($role === User::ROLE_ADMIN) {
            $sizes = Size::all();
            return view('maintenance.adminsize', compact('sizes'));
        } elseif ($role === User::ROLE_INVENTORY_MANAGER) {
            return view('maintenance.managersize');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function store(Request $request)
    {
        $role = Auth::user()->role;
        if ($role !== User::ROLE_ADMIN) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'size' => 'required|string|unique:sizes,size',
        ]);
        Size::create(['size' => $request->size]);
        return redirect()->route('maintenance.size')->with('success', 'Size added successfully!');
    }
    public function edit($id)
    {
        $size = \App\Models\Size::findOrFail($id);
        return view('maintenance.editsize', compact('size'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'size' => 'required|string|max:255|unique:sizes,size,' . $id . ',size_id',
        ]);

        $size = \App\Models\Size::findOrFail($id);
        $size->size = $request->size;
        $size->save();

        return redirect()->route('maintenance.size')->with('success', 'Size updated!');
    }
    public function destroy($id)
    {
        $size = \App\Models\Size::findOrFail($id);
        $size->delete();

        return redirect()->route('maintenance.size')->with('success', 'Size deleted!');
    }
}



