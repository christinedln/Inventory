<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Role Management</title>
    @vite(['resources/css/inventory.css'])
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
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Role Management</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        Add New Role
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->role }}</td>
                                    <td>
                                        <span class="badge {{ $role->status === 'Active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $role->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-3 align-items-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" 
                                                    id="roleToggle{{ $role->id }}"
                                                    {{ $role->status === 'Active' ? 'checked' : '' }}
                                                    onchange="toggleRole({{ $role->id }}, this)">
                                            </div>
                                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteRole({{ $role->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addRoleForm">
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="roleName" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addRole()">Add Role</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Delete Confirmation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this role? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="bi bi-trash me-2"></i>Delete Role
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleRole(id, element) {
    fetch(`/admin/roles/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const statusBadge = element.closest('tr').querySelector('.badge');
            if (data.status === 'Active') {
                statusBadge.classList.remove('bg-danger');
                statusBadge.classList.add('bg-success');
            } else {
                statusBadge.classList.remove('bg-success');
                statusBadge.classList.add('bg-danger');
            }
            statusBadge.textContent = data.status;
        } else {
            element.checked = !element.checked;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        element.checked = !element.checked;
    });
}

function addRole() {
    const roleName = document.getElementById('roleName').value;
    
    fetch('/admin/roles', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            role: roleName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while creating the role.');
    });
}

let roleIdToDelete = null;
const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

function confirmDeleteRole(id) {
    roleIdToDelete = id;
    deleteModal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (!roleIdToDelete) return;
    
    fetch(`/admin/roles/${roleIdToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.querySelector(`#roleToggle${roleIdToDelete}`).closest('tr');
            row.remove();
            deleteModal.hide();
            
            // Show success toast
            const toast = new bootstrap.Toast(Object.assign(document.createElement('div'), {
                className: 'toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3',
                innerHTML: `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-check-circle me-2"></i>
                            Role successfully deleted
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `
            }));
            document.body.appendChild(toast.element);
            toast.show();
            
            setTimeout(() => toast.element.remove(), 3000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        deleteModal.hide();
        alert('An error occurred while deleting the role.');
    });
});
</script>

<!-- Add custom styles for the toggle switch -->
<style>
.form-switch .form-check-input {
    width: 3em;
    height: 1.5em;
    cursor: pointer;
}
.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

    .transition {
        transition: transform 0.2s;
    }
    .rotate-caret {
        transform: rotate(180deg);
    }

.toast {
    z-index: 1050;
}

.modal-header .btn-close {
    margin: -0.5rem -0.5rem -0.5rem auto;
}
</style>
</body>
</html>