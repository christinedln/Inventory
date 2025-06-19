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

@extends('layouts.app')

@section('content')
    <h1>Sizes</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSizeModal">
            Add Size
        </button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Size</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sizes as $size)
                <tr>
                    <td>{{ $size->size_id }}</td>
                    <td>{{ $size->size }}</td>
                    <td>{{ $size->created_at }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button
                            class="btn btn-sm btn-warning edit-size-btn"
                            data-id="{{ $size->size_id }}"
                            data-size="{{ $size->size }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editSizeModal">
                            Edit
                        </button>
                        <!-- Delete Button -->
                        <form action="{{ route('maintenance.size.delete', $size->size_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this size?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No sizes found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Add Size Modal -->
    <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="addSizeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('maintenance.size.add') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSizeModalLabel">Add Size</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="size" class="form-label">Size Name</label>
                            <input type="text" name="size" class="form-control" id="size" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Size</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Size Modal -->
    <div class="modal fade" id="editSizeModal" tabindex="-1" aria-labelledby="editSizeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editSizeForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSizeModalLabel">Edit Size</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-size" class="form-label">Size Name</label>
                            <input type="text" name="size" class="form-control" id="edit-size" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Size</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-size-btn');
            const editForm = document.getElementById('editSizeForm');
            const editSizeInput = document.getElementById('edit-size');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const size = this.getAttribute('data-size');
                    editSizeInput.value = size;
                    editForm.action = `/admin/maintenance/size/${id}`;
                });
            });
        });
    </script>
@endsection

</body>
</html>
