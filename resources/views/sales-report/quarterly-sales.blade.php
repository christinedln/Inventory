<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quarterly Sales Report</title>
    @vite(['resources/css/salesreport.css'])
    @vite(['resources/js/salesreport.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .table-header-primary {
            background-color: #f8f9fa !important;
            color: #212529 !important;
            font-weight: bold;
        }
        .quarter-header {
            background-color: #f8f9fa !important;
            color: #212529 !important;
            text-align: center;
        }
        .sub-header {
            background-color: #e9ecef;
            text-align: center;
            font-weight: bold;
        }
        .value-cell {
            text-align: center;
            vertical-align: middle;
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
                    <h4 class="mb-3 mb-md-0">Quarterly Sales Report - {{ $currentYear }}</h4>
                    <div></div>
                </div>
                <div class="card shadow-lg">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-header-primary">
                                    <th colspan="9" class="text-center">
                                        Overview
                                    </th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="align-middle text-center table-header-primary">
                                        Targets and Accomplishments across Quarters
                                    </th>
                                    @for($i = 1; $i <= 4; $i++)
                                        <th colspan="2" class="quarter-header">Q{{ $i }}</th>
                                    @endfor
                                </tr>
                                <tr class="sub-header">
                                    @for($i = 1; $i <= 4; $i++)
                                        <th class="text-center">T</th>
                                        <th class="text-center">A</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle text-center">
                                        <!-- You can remove this row or leave it empty if not needed -->
                                    </td>
                                    @for($i = 1; $i <= 4; $i++)
                                        <td class="value-cell">₱{{ number_format($quarterlyData[$i]['target'], 0) }}</td>
                                        <td class="value-cell">
                                            ₱{{ number_format($quarterlyData[$i]['accomplished'], 0) }}
                                            @if($quarterlyData[$i]['accomplished'] > $quarterlyData[$i]['target'])
                                                <span class="text-success">▲</span>
                                            @elseif($quarterlyData[$i]['accomplished'] < $quarterlyData[$i]['target'])
                                                <span class="text-danger">▼</span>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>