<?php

namespace App\Http\Controllers;

use App\Models\SalesReport;
use Illuminate\Http\Request;

/**
 * Controller responsible for handling sales report related actions.
 */
class SalesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * Retrieves paginated sales reports and passes them to the view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $salesReports = SalesReport::orderBy('month', 'asc')->paginate(5);

        return view('salesreport', compact('salesReports'));
    }
}