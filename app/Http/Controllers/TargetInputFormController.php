<?php

namespace App\Http\Controllers;

use App\Models\TargetInputForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TargetInputFormController extends Controller
{
    public function index()
    {
        $targets = TargetInputForm::orderBy('quarter')->get();
        $existingQuarters = $targets->pluck('quarter')->toArray();
        
        return view('sales-report.target-input', compact('targets', 'existingQuarters'));
    }

    public function store(Request $request)
    {
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

        return redirect()->route('target-input.index')
            ->with('success', 'Quarterly target has been set successfully.');
    }

    public function destroy($id)
    {
        $target = TargetInputForm::findOrFail($id);
        $target->delete();

        return redirect()->route('target-input.index')
            ->with('success', 'Target has been deleted successfully.');
    }
}