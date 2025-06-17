<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuffed</title>
    @vite(['resources/css/dashboard.css'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
        <div class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar p-3">
            <h4><strong>Cuffed</strong></h4>
            <ul class="nav flex-column">
                <li><a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                <li><a href="{{ route('inventory') }}" class="nav-link"><i class="bi bi-box-seam me-2"></i>Inventory</a></li>
                <li><a href="{{ route('salesreport') }}" class="nav-link"><i class="bi bi-clipboard-data me-2"></i>Sales Report</a></li>
                <li><a href="#" class="nav-link active"><i class="bi bi-bell me-2"></i>Notification</a></li>
            </ul>
        </div>

        <!-- Offcanvas for small screens -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Inventory</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li><a href="#" class="nav-link active">Dashboard</a></li>
                    <li><a href="{{ route('inventory') }}" class="nav-link">Inventory</a></li>
                    <li><a href="#" class="nav-link">Sales Report</a></li>
                    <li><a href="#" class="nav-link">Notification</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>