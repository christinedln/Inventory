{{-- resources/views/maintenance/managersize.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Sizes</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSizeModal">Add Size</button>
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
            @foreach($sizes as $size)
                <tr>
                    <td>{{ $size->size_id ?? $size->id }}</td>
                    <td>{{ $size->size }}</td>
                    <td>{{ $size->created_at }}</td>
                    <td>
                        <!-- No Edit or Delete button for inventory manager -->
                        <span class="text-muted">No actions</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add Size Modal -->
    <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="addSizeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('manager.maintenance.size.add') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSizeModalLabel">Add Size</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="size" class="form-control" placeholder="Size Name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
