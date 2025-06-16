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

<!-- Header with toggle on small screens -->
<nav class="navbar navbar-light bg-light d-md-none">
    <div class="container-fluid">
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
            <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand mb-0 h1">Inventory</span>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar p-3">
            <h4><strong>Inventory</strong></h4>
            <ul class="nav flex-column">
                <li><a href="#" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                <li><a href="#" class="nav-link active"><i class="bi bi-box-seam me-2"></i>Inventory</a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-cart-check me-2"></i>Sales Orders</a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-truck me-2"></i>Suppliers</a></li>
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
                    <li><a href="#" class="nav-link">Dashboard</a></li>
                    <li><a href="#" class="nav-link active">Inventory</a></li>
                    <li><a href="#" class="nav-link">Sales Orders</a></li>
                    <li><a href="#" class="nav-link">Suppliers</a></li>
                </ul>
            </div>
        </div>

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Inventory</h4>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Add New Product
            </a>
        </div>

        <!-- Product List -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Product List</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Product Name</th>
                            <th>Clothing Type</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                         @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->clothing_type }}</td>
                        <td>{{ $product->color }}</td>
                        <td>{{ $product->size }}</td>
                        <td>{{ $product->date }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <a href="#" 
                            class="edit-product"
                            data-id="{{ $product->product_id }}"
                            data-product_name="{{ e($product->product_name) }}"
                            data-clothing_type="{{ $product->clothing_type }}"
                            data-color="{{ $product->color }}"
                            data-size="{{ $product->size }}"
                            data-date="{{ $product->date }}"
                            data-quantity="{{ $product->quantity }}"
                            data-bs-toggle="modal" 
                            data-bs-target="#editProductModal"
                            title="Edit"><i class="bi bi-pencil-square"></i></a>
                            
                            <a href="{{ url('/product/delete/' . $product->product_id) }}" 
                            class="text-danger ms-2" 
                            onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                        </tbody>
                    </table>
                </div>

                <nav class="mt-3">
                    {{ $products->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
    </main>
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" id="productName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="clothing_type" class="form-label">Clothing Type</label>
                            <select class="form-select" name="clothing_type" id="clothing_type" required>
                                <option value="" selected disabled>Select clothing type</option>
                                <option value="Shirts">Shirts</option>
                                <option value="Sweaters">Sweaters</option>
                                <option value="Hoodies">Hoodies</option>
                                <option value="Pants">Pants</option>
                                <option value="Skirts">Skirts</option>
                                <option value="Trousers">Trousers</option>
                                <option value="Shorts">Shorts</option>
                                <option value="Dresses">Dresses</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" name="color" class="form-control" id="color" required>
                        </div>
                        <div class="col-md-6">
                            <label for="size" class="form-label">Size</label>
                            <select class="form-select" name="size" id="size" required>
                                <option value="" selected disabled>Select size</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="Free Size">Free Size</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" id="date" required>
                        </div>
                        <script>
                            const today = new Date().toISOString().split('T')[0];
                            document.getElementById('date').setAttribute('max', today);
                        </script>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" id="quantity" required>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editForm" action="">
                    @method('POST')
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit-productName" class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" id="edit-productName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit-clothing_type" class="form-label">Clothing Type</label>
                            <select class="form-select" name="clothing_type" id="edit-clothing_type" required>
                                <option value="" selected disabled>Select clothing type</option>
                                <option value="Shirts">Shirts</option>
                                <option value="Sweaters">Sweaters</option>
                                <option value="Hoodies">Hoodies</option>
                                <option value="Pants">Pants</option>
                                <option value="Skirts">Skirts</option>
                                <option value="Trousers">Trousers</option>
                                <option value="Shorts">Shorts</option>
                                <option value="Dresses">Dresses</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit-color" class="form-label">Color</label>
                            <input type="text" name="color" class="form-control" id="edit-color" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit-size" class="form-label">Size</label>
                            <select class="form-select" name="size" id="edit-size" required>
                                <option value="" selected disabled>Select size</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="Free Size">Free Size</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit-date" class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" id="edit-date" required>
                        </div>
                        <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    const today = new Date().toISOString().split('T')[0];
                                    const editDate = document.getElementById('edit-date');
                                    if (editDate) {
                                        editDate.setAttribute('max', today);
                                    }
                                });
                            </script>
                        <div class="col-md-6">
                            <label for="edit-quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" id="edit-quantity" required>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-product');

            editButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const id = this.dataset.id;
                    const product_name = this.dataset.product_name;
                    const clothing_type = this.dataset.clothing_type;
                    const color = this.dataset.color;
                    const size = this.dataset.size;
                    const date = this.dataset.date;
                    const quantity = this.dataset.quantity;

                    const form = document.getElementById('editForm');
                    form.action = `/product/update/${id}`;

                    document.getElementById('edit-productName').value = product_name;
                    document.getElementById('edit-clothing_type').value = clothing_type;
                    document.getElementById('edit-color').value = color;
                    document.getElementById('edit-size').value = size;
                    document.getElementById('edit-date').value = date;
                    document.getElementById('edit-quantity').value = quantity;
                });
            });
        });
    </script>

</body>
</html>