<?php

namespace App\Http\Controllers;

use App\Models\TargetInputForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TargetInputFormController extends Controller
{
    public function index()
    {
        if (!in_array(Auth::user()->role, [User::ROLE_ADMIN, User::ROLE_INVENTORY_MANAGER])) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }

        $targets = TargetInputForm::orderBy('quarter')->get();
        $existingQuarters = $targets->pluck('quarter')->toArray();
        $isAdmin = Auth::user()->role === User::ROLE_ADMIN;
        
        return view('sales-report.target-input', compact('targets', 'existingQuarters', 'isAdmin'));
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, [User::ROLE_ADMIN, User::ROLE_INVENTORY_MANAGER])) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }

        $validator = Validator::make($request->all(), TargetInputForm::$rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'This quarter already has a target set.');
        }

        TargetInputForm::create([
            'quarter' => $request->quarter,
            'target_revenue' => $request->target_revenue
        ]);

        return redirect()->route('sales-report.target-input.index')
            ->with('success', 'Quarterly target has been set successfully.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== User::ROLE_ADMIN) {
            return redirect()->back()->with('error', 'Only administrators can delete targets.');
        }

        $target = TargetInputForm::findOrFail($id);
        $target->delete();

        return redirect()->route('sales-report.target-input.index')
            ->with('success', 'Target has been deleted successfully.');
    }
}