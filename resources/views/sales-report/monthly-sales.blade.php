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
                        <form action="{{ route('monthly-sales.export') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success export-button">
                                <i class="fas fa-file-export me-2"></i>Export
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Total Sales</th>
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
                                                        <span class="text-success">
                                                            ▲
                                                        </span>
                                                    @elseif($currentSales < $previousSales)
                                                        <span class="text-danger">
                                                            ▼
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            $previousSales = $currentSales;
                                        @endphp
                                    @endforeach
                                    <tr class="table-primary font-weight-bold">
                                        <td>Total</td>
                                        <td>₱{{ number_format($totalSales, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>