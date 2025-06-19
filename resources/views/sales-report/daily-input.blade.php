<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daily Sales Input</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 2rem;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .thead-dark {
            background-color: #343a40;
            color: white;
        }
        .table td {
            vertical-align: middle;
        }
        .modal-dialog {
            max-width: 800px;
        }
        .history-table th {
            background-color: #343a40;
            color: white;
        }
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
        .history-table thead {
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .history-table thead th {
            background-color: #343a40;
            color: white;
        }
        .action-buttons {
            margin-top: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .action-buttons .btn {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        .input-table {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Daily Sales Input</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('daily-sales.store') }}" method="POST">
                    @csrf
                    <!-- Input Table -->
                    <div class="table-responsive input-table">
                        <table class="table table-bordered mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Daily Revenue (₱)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="date" class="form-control" id="date" 
                                            name="date" value="{{ $today }}" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" class="form-control" 
                                            id="daily_revenue" name="daily_revenue" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#historyModal">
                            <i class="fas fa-history"></i> View Sales History
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="historyModalLabel">Sales History</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover history-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Daily Revenue</th>
                                    <th>Entry Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entries as $entry)
                                <tr>
                                    <td>{{ $entry->date->format('M d, Y') }}</td>
                                    <td>₱ {{ number_format($entry->daily_revenue, 2) }}</td>
                                    <td>{{ $entry->created_at->format('h:i A') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle pagination clicks in modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('historyModal');
            modal.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' && e.target.getAttribute('href')) {
                    e.preventDefault();
                    fetch(e.target.getAttribute('href'))
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('.modal-body').innerHTML = html;
                        });
                }
            });
        });
    </script>
</body>
</html>