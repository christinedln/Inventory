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


    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar p-3">
      <h4><strong>Cuffed</strong></h4>
      <ul class="nav flex-column">
        <li><a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
        <li><a href="{{ route('inventory') }}" class="nav-link"><i class="bi bi-box-seam me-2"></i>Inventory</a></li>
        <li><a href="#" class="nav-link active"><i class="bi bi-clipboard-data me-2"></i>Sales Report</a></li>
        <li><a href="{{ route('notification') }}" class="nav-link"><i class="bi bi-bell me-2"></i>Notification</a></li>
      </ul>
    </div>


    <!-- Main content -->
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
                  <th>Target Sales (Units)</th>
                   <th>Accomplishment (%)</th>
                    <th>Growth per Month (%)</th>
                </tr>
              </thead>
              <tbody>
                <tr class="text-center">
                  <td>January</td>
                  <td>₱120,000</td>
                  <td>400</td>
                  <td>380</td>
                  <td>—</td>
                  <td class="text-success">▲ 105.26%</td>
                </tr>
                <tr class="text-center">
                  <td>February</td>
                  <td>₱135,000</td>
                  <td>450</td>
                  <td>400</td>
                  <td class="text-success">▲ 12.5%</td>
                  <td class="text-success">▲ 112.5%</td>
                </tr>
                <tr class="text-center">
                  <td>March</td>
                  <td>₱142,500</td>
                  <td>475</td>
                  <td>420</td>
                  <td class="text-success">▲ 5.56%</td>
                   <td class="text-success">▲ 113.1%</td>
                </tr>
                <tr class="text-center">
                  <td>April</td>
                  <td>₱150,000</td>
                  <td>500</td>
                  <td>450</td>
                  <td class="text-success">▲ 5.26%</td>
                   <td class="text-success">▲ 111.1%</td>
                </tr>
                <tr class="text-center">
                  <td>May</td>
                  <td>₱165,000</td>
                  <td>550</td>
                  <td>500</td>
                  <td class="text-success">▲ 10%</td>
                   <td class="text-success">▲ 110%</td>
                </tr>
                <tr class="text-center">
                  <td>June</td>
                  <td>₱170,000</td>
                  <td>570</td>
                  <td>520</td>
                  <td class="text-success">▲ 3.03%</td>
                   <td class="text-success">▲ 109.6%</td>
                </tr>
              </tbody>
            </table>
          </div>


          <!-- Pagination -->
          <nav>
            <ul class="pagination mt-3">
              <li class="page-item"><a class="page-link" href="#">«</a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">»</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Cuffed</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
      <li><a href="{{ route('inventory') }}" class="nav-link">Inventory</a></li>
      <li><a href="#" class="nav-link active">Sales Report</a></li>
      <li><a href="{{ route('notification') }}" class="nav-link">Notification</a></li>
    </ul>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



