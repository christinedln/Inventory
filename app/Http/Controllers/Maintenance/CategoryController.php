<?php


namespace App\Http\Controllers\Maintenance;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;




class CategoryController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $categories = Category::all();

        if ($role === User::ROLE_ADMIN) {
            $clothingTypes = DB::table('products')->distinct()->pluck('clothing_type');
            return view('maintenance.admincategory', compact('categories', 'role', 'clothingTypes'));
        } elseif ($role === User::ROLE_INVENTORY_MANAGER) {
            return view('maintenance.managercategory', compact('categories', 'role'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255|unique:categories,category',
        ]);


        Category::create([
            'category' => $request->category,
        ]);


        return redirect()->route('maintenance.category')->with('success', 'Category added!');
    }
public function edit($id)
{
    $category = Category::findOrFail($id);
    $role = Auth::user()->role;
    return view('maintenance.editcategory', compact('category', 'role'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'category' => 'required|string|max:255|unique:categories,category,' . $id . ',category_id',
    ]);
    $category = Category::findOrFail($id);
    $category->category = $request->category;
    $category->save();

    return redirect()->route('maintenance.category')->with('success', 'Category updated!');
}

public function destroy($id)
{
    $role = Auth::user()->role;
    if ($role !== User::ROLE_ADMIN) {
        abort(403, 'Unauthorized action.');
    }
    $category = Category::findOrFail($id);
    $category->delete();

    return redirect()->route('maintenance.category')->with('success', 'Category deleted!');
}
}



