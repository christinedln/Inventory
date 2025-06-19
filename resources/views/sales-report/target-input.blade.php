<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quarterly Target Input</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-header-primary {
            background-color: var(--bs-primary) !important;
            color: white !important;
            font-weight: bold;
        }
        .table-header-primary th {
            background-color: var(--bs-primary) !important;
            color: white !important;
            border-color: var(--bs-primary) !important;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="table-header-primary">
                                <th colspan="3" class="text-center h4">Quarterly Sales Target Input Form</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('target-input.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="quarter" class="form-label">Select Quarter</label>
                        <select name="quarter" id="quarter" class="form-select" required>
                            <option value="">Select a quarter</option>
                            @for($i = 1; $i <= 4; $i++)
                                @if(!isset($existingQuarters) || !in_array($i, $existingQuarters))
                                    <option value="{{ $i }}">Q{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="target_revenue" class="form-label">Target Revenue</label>
                        <input type="number" class="form-control" id="target_revenue" name="target_revenue" min="0" step="0.01" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <div class="mt-4">
                    <table class="table">
                        <thead>
                            <tr class="table-header-primary">
                                <th>Quarter</th>
                                <th>Target Revenue</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($targets as $target)
                                <tr>
                                    <td>Q{{ $target->quarter }}</td>
                                    <td>${{ number_format($target->target_revenue, 2) }}</td>
                                    <td>
                                        <form action="{{ route('target-input.destroy', $target->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>