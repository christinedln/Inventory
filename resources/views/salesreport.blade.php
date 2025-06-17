<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cuffed</title>
  @vite(['resources/css/salesreport.css'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
 
</head>
<body>


<!-- Header for small screens -->
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


    
    <div class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar p-3">
      <h4><strong>Cuffed</strong></h4>
      <ul class="nav flex-column">
        <li><a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
        <li><a href="{{ route('inventory') }}" class="nav-link"><i class="bi bi-box-seam me-2"></i>Inventory</a></li>
        <li><a href="{{ route('salesreport') }}" class="nav-link active"><i class="bi bi-clipboard-data me-2"></i>Sales Report</a></li>
         <li><a href="{{ route('notification') }}" class="nav-link"><i class="bi bi-bell me-2"></i>Notification @if($unresolvedCount > 0)
            <span class="badge bg-danger">{{ $unresolvedCount }}</span>
        @endif </a></li>
      </ul>
    </div>


    
    <div class="col-md-9 col-lg-10 p-4">
      <h3 class="mb-4">Sales Report</h3>


      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr class="text-center">
                  <th>Month</th>
                  <th>Total Sales Revenue</th>
                  <th>Total Sales (Units)</th>
                  <th>Target Sales Revenue</th>
                   <th>Accomplishment (%)</th>
                    <th>Growth per Month (%)</th>
                </tr>
              </thead>
              <tbody>
                @if($salesReports->isEmpty())
                                <tr class="text-center">
                                    <td colspan="6">No sales data available.</td>
                                </tr>
                @else
                  @foreach ($salesReports as $report)
                    <tr class="text-center">
                      <td>{{ \Carbon\Carbon::parse($report->month)->format('F Y') }}</td>
                      <td>₱{{ number_format($report->total_sales_revenue, 2) }}</td>
                      <td>{{ $report->total_sales }}</td>
                      <td>₱{{ $report->target_sales_revenue }}</td>
                      <td>
                        @if($report->accomplishment == 0 && $report->total_sales >= $report->target_sales_revenue)
                          {{ number_format($report->accomplishment, 2) }}%
                        @elseif($report->accomplishment == 0)
                          {{ number_format($report->accomplishment, 2) }}%
                        @elseif ($report->accomplishment > 0)
                          <span class="text-success">▲ {{ number_format($report->accomplishment, 2) }}%</span>
                        @else
                          <span class="text-danger">▼ {{ number_format(abs($report->accomplishment), 2) }}%</span>
                        @endif
                      </td>
                      <td>
                        @if ($report->growth_per_month == 0)
                          {{ number_format($report->growth_per_month, 2) }}%
                        @elseif ($report->growth_per_month > 0)
                          <span class="text-success">▲ {{ number_format($report->growth_per_month, 2) }}%</span>
                        @else
                          <span class="text-danger">▼ {{ number_format(abs($report->growth_per_month), 2) }}%</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>



          <nav>
            {{ $salesReports->links('pagination::bootstrap-5') }}
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Cuffed</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
      <li><a href="{{ route('inventory') }}" class="nav-link">Inventory</a></li>
      <li><a href="{{ route('salesreport') }}" class="nav-link active">Sales Report</a></li>
      <li><a href="{{ route('notification') }}" class="nav-link">Notification @if($unresolvedCount > 0)
            <span class="badge bg-danger">{{ $unresolvedCount }}</span>
        @endif </a></li>
    </ul>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>