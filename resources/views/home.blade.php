<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    @vite(['resources/css/home.css']) 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3 shadow-sm" style="width: 250px;">
        <h4 class="mb-4"><strong>Inventory</strong></h4>
        <ul class="nav flex-column mb-auto">
            <li><a href="#" class="nav-link">Dashboard</a></li>
            <li><a href="#" class="nav-link active">Inventory</a></li>
            <li><a href="#" class="nav-link">Sales Orders</a></li>
            <li><a href="#" class="nav-link">Suppliers</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Inventory</h4>
            <a href="#" class="btn btn-primary"> Add New Product</a>
        </div>

        <!-- Product List -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Product List</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $products = [
                                ['T-Shirt', 'Clothing', 'Red', 'M', '2024-01-01', '44'],
                                ['Hoodie', 'Clothing', 'Black', 'L', '2024-01-02', '30'],
                                ['Sneakers', 'Footwear', 'White', '9', '2024-01-03', '25'],
                                ['Hat', 'Accessories', 'Blue', 'Free Size', '2024-01-04', '12'],
                                ['Jacket', 'Clothing', 'Green', 'XL', '2024-01-05', '18'],
                            ];
                        @endphp
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $product[0] }}</td>
                                <td>{{ $product[1] }}</td>
                                <td>{{ $product[2] }}</td>
                                <td>{{ $product[3] }}</td>
                                <td>{{ $product[4] }}</td>
                                <td>{{ $product[5] }}</td>
                                <td class="action-icons">
                                    <a href="{{ url('/product/edit/'.$index) }}" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <a href="{{ url('/product/delete/'.$index) }}" class="delete" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


                <!-- Pagination -->
                <nav>
                    <ul class="pagination justify-content-center mt-3">
                        <li class="page-item disabled"><a class="page-link" href="#">&lt;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#">&gt;</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





