<?php

namespace App\Http\Controllers;

use App\Models\SalesReport;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $salesReports = SalesReport::orderBy('month', 'asc')->paginate(5);

        return view('salesreport', compact('salesReports'));
    }
}