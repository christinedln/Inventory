@php
    $user = auth()->user();
@endphp

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@vite(['resources/js/sidebar.js'])

@if($user && $user->role === \App\Models\User::ROLE_ADMIN || $user->role === \App\Models\User::ROLE_INVENTORY_MANAGER);
<div class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar p-3">
    <h4><strong>Cuffed</strong></h4>
    <ul class="nav flex-column">
        <li><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
        <li><a href="{{ route('inventory') }}" class="nav-link"><i class="bi bi-box-seam me-2"></i>Inventory</a></li>

        <li class="nav-item">
            <button class="nav-link d-flex justify-content-between align-items-center w-100 border-0 bg-transparent"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#salesReportCollapse"
                aria-expanded="false"
                aria-controls="salesReportCollapse"
                id="salesReportToggle">
                <span><i class="bi bi-clipboard-data me-2"></i>Sales Report</span>
                <i class="bi bi-caret-down-fill transition" id="salesReportCaret"></i>
            </button>

            <div class="collapse" id="salesReportCollapse">
                <div class="border-start ms-3">
                    <ul class="nav flex-column ps-3 mt-1">
                        <li><a class="nav-link py-1" href="#">Daily Report</a></li>
                        <li><a class="nav-link py-1" href="#">Monthly Report</a></li>
                        <li><a class="nav-link py-1" href="#">Annual Report</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <!-- User Maintenance Dropdown (Bootstrap Collapse) -->
        <li class="nav-item">
            <button class="nav-link d-flex justify-content-between align-items-center w-100 border-0 bg-transparent"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#userMaintenanceCollapse"
                aria-expanded="false"
                aria-controls="userMaintenanceCollapse"
                id="userCollapseToggle">
                <span><i class="bi bi-people me-2"></i>User Maintenance</span>
                <i class="bi bi-caret-down-fill transition" id="caretIcon"></i>
            </button>

            <div class="collapse" id="userMaintenanceCollapse">
                <div class="border-start ms-3">
                    <ul class="nav flex-column ps-3 mt-1">
                        <li><a class="nav-link py-1" href="#">User Accounts</a></li>
                        <li><a class="nav-link py-1" href="#">Roles and Permissions</a></li>
                        <li><a class="nav-link py-1" href="#">User Access Control</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <button class="nav-link d-flex justify-content-between align-items-center w-100 border-0 bg-transparent"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#maintenanceCollapse"
                aria-expanded="false"
                aria-controls="maintenanceCollapse"
                id="maintenanceToggle">
                <span><i class="bi bi-gear me-2"></i>Maintenance</span>
                <i class="bi bi-caret-down-fill transition" id="maintenanceCaret"></i>
            </button>

            <div class="collapse" id="maintenanceCollapse">
                <div class="border-start ms-3">
                    <ul class="nav flex-column ps-3 mt-1">
                        <li><a class="nav-link py-1" href="#">Categories</a></li>
                        <li><a class="nav-link py-1" href="#">Size</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <li><a href="#" class="nav-link active"><i class="bi bi-bell me-2"></i>Notifications
            @if(isset($unresolvedCount) && $unresolvedCount > 0)
                <span class="badge bg-danger">{{ $unresolvedCount }}</span>
            @endif
        </a></li>
    </ul>
</div>

@elseif($user && $user->role === \App\Models\User::ROLE_INVENTORY_MANAGER)
<div class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar p-3">
    <h4><strong>Cuffed</strong></h4>
    <ul class="nav flex-column">
        <li><a href="{{ route('manager.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
        <li><a href="{{ route('inventory') }}" class="nav-link"><i class="bi bi-box-seam me-2"></i>Inventory</a></li>
        {{-- <li><a href="{{ route('salesreport') }}" class="nav-link"><i class="bi bi-clipboard-data me-2"></i>Sales Report</a></li> --}}
        <li><a href="#" class="nav-link"><i class="bi bi-gear me-2"></i>Maintenance</a></li>
        <li><a href="#" class="nav-link active">
            <i class="bi bi-bell me-2"></i>Notifications
            @if(isset($unresolvedCount) && $unresolvedCount > 0)
                <span class="badge bg-danger">{{ $unresolvedCount }}</span>
            @endif
        </a></li>
    </ul>
</div>
@endif

<!-- Offcanvas (mobile sidebar) -->
@if($user && ($user->role === \App\Models\User::ROLE_ADMIN || $user->role === \App\Models\User::ROLE_INVENTORY_MANAGER))
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Inventory</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            @if($user->role === \App\Models\User::ROLE_ADMIN)
                <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a></li>
                <li><a href="{{ route('inventory') }}" class="nav-link">Inventory</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        User Maintenance
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdownMobile">
                        <li><a class="dropdown-item" href="#">User Accounts</a></li>
                        <li><a class="dropdown-item" href="#">Roles and Permissions</a></li>
                        <li><a class="dropdown-item" href="#">User Access Control</a></li>
                    </ul>
                </li>
                <li><a href="#" class="nav-link">Maintenance</a></li>
                <li><a href="#" class="nav-link active">
                    Notifications
                    @if(isset($unresolvedCount) && $unresolvedCount > 0)
                        <span class="badge bg-danger">{{ $unresolvedCount }}</span>
                    @endif
                </a></li>
            @elseif($user->role === \App\Models\User::ROLE_INVENTORY_MANAGER)
                <li><a href="{{ route('manager.dashboard') }}" class="nav-link">Dashboard</a></li>
                <li><a href="{{ route('inventory') }}" class="nav-link">Inventory</a></li>
                {{-- <li><a href="{{ route('salesreport') }}" class="nav-link">Sales Report</a></li> --}}
                <li><a href="#" class="nav-link">Maintenance</a></li>
                <li><a href="#" class="nav-link active">
                    Notifications
                    @if(isset($unresolvedCount) && $unresolvedCount > 0)
                        <span class="badge bg-danger">{{ $unresolvedCount }}</span>
                    @endif
                </a></li>
            @endif
        </ul>
    </div>
</div>
@endif

<!-- Caret rotation for collapse -->
<style>
    .transition {
        transition: transform 0.2s;
    }
    .rotate-caret {
        transform: rotate(180deg);
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const caretIcon = document.getElementById('caretIcon');
    const collapseDiv = document.getElementById('userMaintenanceCollapse');

    if (!caretIcon || !collapseDiv) return;

    collapseDiv.addEventListener('show.bs.collapse', () => {
        caretIcon.classList.add('rotate-caret');
    });

    collapseDiv.addEventListener('hide.bs.collapse', () => {
        caretIcon.classList.remove('rotate-caret');
    });
});
</script>

