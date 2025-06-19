<div class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar p-3">
    <h4><strong>Cuffed</strong></h4>
    <ul class="nav flex-column">
        <li><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
        <li><a href="{{ route('inventory') }}" class="nav-link"><i class="bi bi-box-seam me-2"></i>Inventory</a></li>
        <li><a href="{{ route('salesreport') }}" class="nav-link"><i class="bi bi-clipboard-data me-2"></i>Sales Report</a></li>
        <li><a href="#" class="nav-link active">
            <i class="bi bi-bell me-2"></i>Notification
            @if($unresolvedCount > 0)
                <span class="badge bg-danger">{{ $unresolvedCount }}</span>
            @endif
        </a></li>
    </ul>
</div>

<!-- Offcanvas (mobile sidebar) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Inventory</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a></li>
            <li><a href="{{ route('inventory') }}" class="nav-link">Inventory</a></li>
            <li><a href="{{ route('salesreport') }}" class="nav-link">Sales Report</a></li>
            <li><a href="#" class="nav-link active">
                Notification
                @if($unresolvedCount > 0)
                    <span class="badge bg-danger">{{ $unresolvedCount }}</span>
                @endif
            </a></li>
        </ul>
    </div>
</div>
