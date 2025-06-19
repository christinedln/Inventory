<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuffed</title>
    @vite(['resources/css/salesreport.css'])
    @vite(['resources/js/salesreport.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .trend-icon {
            font-size: 0.8em;
            margin-left: 10px;
        }
        .export-button {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>
<body>
<!-- Header with toggle on small screens -->
<nav class="navbar navbar-light bg-light d-md-none">
    <div class="container-fluid">
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
            <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand mb-0 h1">Cuffed</span>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <h4 class="mb-3 mb-md-0">Monthly Sales Report - {{ $currentYear }}</h4>
                <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-file-earmark-arrow-down me-2"></i>Export
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportModal">
                                    Export with Date Range
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('sales-report.monthly-sales.export') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="format" value="csv">
                                    <input type="hidden" name="date_range" value="all">
                                    <button type="submit" class="dropdown-item">Export All (CSV)</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('sales-report.monthly-sales.export') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="format" value="pdf">
                                    <input type="hidden" name="date_range" value="all">
                                    <button type="submit" class="dropdown-item">Export All (PDF)</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @if($isAdmin)
                        <form action="{{ route('sales-report.monthly-sales.delete-all') }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete ALL sales data? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Delete All
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Month</th>
                                    <th>Total Sales</th>
                                    @if($isAdmin)
                                        <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $monthNames = [
                                        1 => 'January', 2 => 'February', 3 => 'March',
                                        4 => 'April', 5 => 'May', 6 => 'June',
                                        7 => 'July', 8 => 'August', 9 => 'September',
                                        10 => 'October', 11 => 'November', 12 => 'December'
                                    ];
                                    $totalSales = 0;
                                    $previousSales = 0;
                                @endphp

                                @foreach($monthNames as $monthNumber => $monthName)
                                    @php
                                        $monthData = $monthlySales->firstWhere('month', $monthNumber);
                                        $currentSales = $monthData ? $monthData->total_sales : 0;
                                        $totalSales += $currentSales;
                                    @endphp
                                    <tr>
                                        <td>{{ $monthName }}</td>
                                        <td>
                                            ₱{{ number_format($currentSales, 2) }}
                                            @if($monthNumber > 1)
                                                @if($currentSales > $previousSales)
                                                    <span class="text-success">▲</span>
                                                @elseif($currentSales < $previousSales)
                                                    <span class="text-danger">▼</span>
                                                @endif
                                            @endif
                                        </td>
                                        @if($isAdmin)
                                            <td>
                                                @if($currentSales > 0)
                                                    <form action="{{ route('sales-report.monthly-sales.delete-month', ['month' => $monthNumber, 'year' => $currentYear]) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete all sales data for {{ $monthName }}?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            DELETE
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                    @php
                                        $previousSales = $currentSales;
                                    @endphp
                                @endforeach
                                <tr class="table-primary fw-bold">
                                    <td>Total</td>
                                    <td colspan="{{ $isAdmin ? '2' : '1' }}">₱{{ number_format($totalSales, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Sales Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sales-report.monthly-sales.export') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="format" class="form-label">Export Format</label>
                        <select class="form-select" id="format" name="format">
                            <option value="csv">CSV</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <input type="hidden" name="date_range" value="custom">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>