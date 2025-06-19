<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailySales;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DailyInputController extends Controller
{
    public function index(Request $request)
    {
        if (!in_array(Auth::user()->role, [User::ROLE_ADMIN, User::ROLE_INVENTORY_MANAGER])) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }

        $today = Carbon::now()->format('Y-m-d');
        $entries = DailySales::orderBy('date', 'desc')->get();
        
        return view('sales-report.daily-input', compact('today', 'entries'));
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, [User::ROLE_ADMIN, User::ROLE_INVENTORY_MANAGER])) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }

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

    public function destroy($id)
    {
        if (!in_array(Auth::user()->role, [User::ROLE_ADMIN, User::ROLE_INVENTORY_MANAGER])) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }

        $entry = DailySales::findOrFail($id);
        $entry->delete();
        
        return redirect()->back()->with('success', 'Sales entry deleted successfully!');
    }
}