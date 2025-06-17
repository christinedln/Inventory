<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuffed</title>
    @vite(['resources/css/notification.css'])
    @vite(['resources/js/notification.js'])
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
                <li><a href="#" class="nav-link active"><i class="bi bi-bell me-2"></i>Notification @if($unresolvedCount > 0)
            <span class="badge bg-danger">{{ $unresolvedCount }}</span>
        @endif</a></li>
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
                    <li><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li><a href="{{ route('inventory') }}" class="nav-link">Inventory</a></li>
                    <li><a href="{{ route('salesreport') }}" class="nav-link">Sales Report</a></li>
                    <li><a href="#" class="nav-link active">Notification @if($unresolvedCount > 0)
            <span class="badge bg-danger">{{ $unresolvedCount }}</span>
        @endif</a></li>
                </ul>
            </div>
        </div>
    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Notification</h4>
        </div>

        <!-- Product List -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Notification</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Alert</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($notifications as $notification)
                        <tr class="{{ $notification->status === 'unresolved' ? 'table-primary' : '' }}">

                            <td>
                                @if($notification->type === 'warning')
                                    <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>
                                @endif
                                {{ $notification->notification }}
                            </td>
                           <td>
                                @if($notification->status === 'resolved' && $notification->updated_at && $notification->updated_at != $notification->created_at)
                                    Resolved at {{ $notification->updated_at }}
                                @else
                                    {{ $notification->created_at }}
                                @endif
                            </td>
                           <td>
                                @if($notification->category === 'inventory')
                                <div class="d-flex flex-column flex-md-row align-items-center gap-1">

                                    <form action="{{ route('notifications.resolve', $notification->notifiable_id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm {{ $notification->status === 'unresolved' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                            {{ $notification->status === 'resolved' ? 'disabled' : '' }}>
                                            Resolve
                                        </button>
                                    </form>

                                    <form action="{{ route('notifications.toggleStatus', $notification->notification_id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm {{ $notification->status === 'unresolved' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                            {{ $notification->status === 'unresolved' ? 'Mark as Resolved' : 'Mark as Unresolved' }}
                                        </button>
                                    </form>

                                </div>
                                @else
                                    {{ $notification->category }}
                                @endif
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="mt-3">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
        </div>
        </div>
    </main>
</body>
</html>