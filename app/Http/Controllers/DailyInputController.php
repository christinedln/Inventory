<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailySales;
use Carbon\Carbon;

class DailyInputController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d');
        $entries = DailySales::latest()->get();
        
        return view('sales-report.daily-input', compact('today', 'entries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'daily_revenue' => 'required|numeric|min:0',
        ]);

        DailySales::create([
            'date' => $request->date,
            'daily_revenue' => $request->daily_revenue,
        ]);

        return redirect()->back()->with('success', 'Daily sales recorded successfully!');
    }
}