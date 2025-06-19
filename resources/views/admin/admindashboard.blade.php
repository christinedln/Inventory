<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuffed</title>
    @vite(['resources/css/dashboard.css'])
    @vite(['resources/js/dashboard.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text display-6">{{ $totalProducts }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card bg-warning text-dark h-100">
                        <div class="card-body">
                            <h5 class="card-title">Low Stock Alert</h5>
                            <p class="card-text display-6">{{ $lowStockCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">Total Stock Value</h5>
                            <p class="card-text display-6">{{ $stockLevels->sum('quantity') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">Categories</h5>
                            <p class="card-text display-6">{{ $productsByCategory->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            Products by Category
                        </div>
                        <div class="card-body">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            Stock Levels
                        </div>
                        <div class="card-body">
                            <canvas id="stockChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPI Charts -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            Top Performing Products
                        </div>
                        <div class="card-body">
                            <canvas id="topPerformersChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            Stock Levels by Size
                        </div>
                        <div class="card-body">
                            <canvas id="sizeStockChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Low Stock Alert Table -->
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h6 class="card-title mb-0">Low Stock Items</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockItems as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->clothing_type }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>
                                @if($item->quantity == 0)
                                    <span class="badge bg-danger">OUT OF STOCK</span>
                                @elseif($item->quantity <= 5)
                                    <span class="badge bg-danger">CRITICAL STOCK</span>
                                @else
                                    <span class="badge bg-warning">LOW STOCK</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Charts Initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Define consistent color mapping for all charts
    const categoryColors = {
        'Shirts': '#FF6384',      // Pink
        'Pants': '#36A2EB',       // Blue
        'Dresses': '#FFCE56',     // Yellow
        'Skirts': '#4BC0C0',      // Teal
        'Hoodies': '#9966FF',     // Purple
        'Sweaters': '#FF9F40',    // Orange
        'Shorts': '#2ECC71',    // Green
        'Trouser': '#E74C3C',       // Red
    };

    // Category Pie Chart
    const categoryData = @json($productsByCategory);
    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: {
            labels: categoryData.map(item => item.clothing_type),
            datasets: [{
                data: categoryData.map(item => item.count),
                backgroundColor: categoryData.map(item => categoryColors[item.clothing_type] || '#95A5A6'),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Stock Levels Doughnut Chart
    const stockData = @json($stockLevels);
    new Chart(document.getElementById('stockChart'), {
        type: 'doughnut',
        data: {
            labels: stockData.map(item => item.product_name),
            datasets: [{
                data: stockData.map(item => item.quantity),
                backgroundColor: stockData.map(item => categoryColors[item.clothing_type] || '#95A5A6'),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Stock Distribution by Product'
                }
            },
            cutout: '60%'
        }
    });



    // Top Performers Horizontal Bar Chart
    const topPerformersData = @json($topPerformers);
    new Chart(document.getElementById('topPerformersChart'), {
        type: 'bar',
        data: {
            labels: topPerformersData.map(item => item.product_name),
            datasets: [{
                label: 'Stock Quantity',
                data: topPerformersData.map(item => item.quantity),
                backgroundColor: '#FF6384',
                borderRadius: 5
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // Stock Levels by Size Bar Chart
    const sizeColors = {
        'XXS': '#FF6384', // Pink
        'XS': '#36A2EB',  // Blue
        'S': '#FFCE56',   // Yellow
        'M': '#4BC0C0',   // Teal
        'L': '#9966FF',   // Purple
        'XL': '#FF9F40',  // Orange
        'XXL': '#2ECC71', // Green
        '3XL': '#E74C3C', // Red
        '4XL': '#3498DB', // Light Blue
        '5XL': '#9B59B6'  // Violet
    };

    const sizeStockData = @json($stockBySize);
    new Chart(document.getElementById('sizeStockChart'), {
        type: 'bar',
        data: {
            labels: sizeStockData.map(item => item.size),
            datasets: [{
                label: 'Total Stock',
                data: sizeStockData.map(item => item.total_quantity),
                backgroundColor: sizeStockData.map(item => sizeColors[item.size] || '#95A5A6'), // Default to gray if size not in mapping
                borderColor: '#dee2e6',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Stock Quantity by Size'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Stock: ${context.parsed.y} items`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Items'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Size'
                    }
                }
            }
        }
    });
});
</script>
</body>
</html>
