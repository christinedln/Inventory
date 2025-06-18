<?php

namespace App\Http\Controllers;

use App\Models\SalesReport;
use Illuminate\Http\Request;

// Controller responsible for handling sales report related actions.
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
        // Fetch sales reports from the database, ordered by month in ascending order.
        // Paginate the results, showing 5 reports per page.
        $salesReports = SalesReport::orderBy('month', 'asc')->paginate(5);

        // Return the 'salesreport' view, passing the fetched sales reports to it.
        return view('salesreport', compact('salesReports'));
    }
}