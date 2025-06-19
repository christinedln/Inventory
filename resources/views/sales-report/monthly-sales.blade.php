<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly Sales Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for arrows -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header position-relative">
                        <h2 class="mb-0">Monthly Sales Report - {{ $currentYear }}</h2>
                        <div class="position-absolute end-0 top-50 translate-middle-y me-2">
                            <div class="btn-group me-2">
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-file-export me-2"></i>Export
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
                                        <i class="fas fa-trash-alt me-2"></i>Delete All
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Total Sales</th>
                                        @if($isAdmin)
                                            <th></th>  <!-- Removed the "Actions" text -->
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
                                                                <i class="fas fa-trash-alt"></i>
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
                                    <tr class="table-primary font-weight-bold">
                                        <td>Total</td>
                                        <td colspan="{{ $isAdmin ? '2' : '1' }}">₱{{ number_format($totalSales, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>