<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuffed</title>
    @vite(['resources/css/inventory.css'])
    @vite(['resources/js/admininventory.js'])
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
        @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Inventory</h4>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Add New Product
            </a>
        </div>
             @if ($errors->has('duplicate'))
                    <div class="alert alert-danger">
                        {{ $errors->first('duplicate') }}
                    </div>
                @endif
                                    @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        @if ($errors->has('restricted'))
    <div class="alert alert-danger">
        {{ $errors->first('restricted') }}
    </div>
@endif

        <!-- Product List -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Product List</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Clothing Type</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Requested Reduction</th>
                            <th>Reason for Reduced Quantities</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                         @foreach ($products as $product)
                    <tr class="text-center @if($highlightId == $product->product_id) table-primary @endif">
                        <td>
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Product Image" width="60" height="60">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->clothing_type }}</td>
                        <td>{{ $product->color }}</td>
                        <td>{{ $product->size }}</td>
                        <td>
                        @if ($product->created_at == $product->updated_at)
                          Added, {{ $product->created_at->timezone('Asia/Manila') }}
                        @else
                         Updated, {{ $product->updated_at->timezone('Asia/Manila')
                        }}
                        @endif
                        </td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->requested_reduction }}</td>
                        <td>{{ $product->last_reason }}</td>
                        <td>{{ $product->status }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>
                            <a href="#"
                            class="edit-product"
                            data-id="{{ $product->product_id }}"
                            data-image="{{ asset('storage/' . $product->image_path) }}"
                            data-product_name="{{ e($product->product_name) }}"
                            data-clothing_type="{{ $product->clothing_type }}"
                            data-color="{{ $product->color }}"
                            data-size="{{ $product->size }}"
                            data-date="{{ $product->updated_at ? $product->updated_at : '' }}"
                            data-quantity="{{ $product->quantity }}"
                            data-last_reason="{{ $product->last_reason }}"
                            data-price="{{ $product->price }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editProductModal"
                            title="Edit"><i class="bi bi-pencil-square"></i></a>
                           
                            <a href="{{ route('manager.product.delete', $product->product_id) }}"
                            class="text-danger ms-2"
                            onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="bi bi-trash"></i>
                            </a>
                            @if($product->status === 'for approval')
                                <form action="{{ route('admin.product.approve', $product->product_id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                            @endif
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

                <form method="POST" action="{{ route('manager.inventory.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="productImage" class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control" id="productImage" accept="image/*" required>
                        </div>
                        <div class="col-md-6">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" id="productName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="clothing_type" class="form-label">Clothing Type</label>
                           <select class="form-select" name="clothing_type" id="clothing_type" required>
                            <option value="" selected disabled>Select clothing type</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
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
                                @foreach($sizes as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" id="quantity" required min="0" value="0">
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price (₱)</label>
                            <input type="number" step="0.01" name="price" class="form-control" id="price" required min="0" value="0.00">
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
                <form method="POST" id="editForm" action="" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Current Image</label><br>
                            <img id="edit-current-image" src="" alt="Product Image" width="100" height="100" class="mb-2">
                            <input type="file" name="image" class="form-control mt-2" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="edit-productName" class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" id="edit-productName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit-clothing_type" class="form-label">Clothing Type</label>
                           <select class="form-select" name="clothing_type" id="edit-clothing_type" required>
                                <option value="" selected disabled>Select clothing type</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
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
                                @foreach($sizes as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
               
                        <div class="col-md-6">
                            <label for="edit-quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" id="edit-quantity" required>
                        </div>
                        <div class="col-md-12 mt-3" id="edit-reason-container" style="display: none;">
                            <label for="edit-reason" class="form-label">Reason for Reducing Quantity</label>
                            <textarea name="reason" class="form-control" id="edit-reason" rows="3" placeholder="Enter reason here..."></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="edit-price" class="form-label">Price (₱)</label>
                            <input type="number" step="0.01" name="price" class="form-control" id="edit-price" required>
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

</body>
</html>
