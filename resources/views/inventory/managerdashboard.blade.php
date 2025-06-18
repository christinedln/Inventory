<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .role-header {
            font-size: 3rem;
            font-weight: bold;
            color: #198754;
            text-align: center;
            margin-top: 100px;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">Inventory Manager Area</a>
            <div class="navbar-nav ms-auto">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="role-header">
            INVENTORY MANAGER DASHBOARD
        </div>
        <div class="text-center mt-4">
            <p class="lead">Welcome, {{ Auth::user()->username }}</p>
            <p>You are logged in as an Inventory Manager</p>
        </div>
        <div class="card shadow">
            <div class="card-body text-center">
                <h1 class="display-4 text-success mb-4">INVENTORY MANAGER DASHBOARD</h1>
                <p class="lead">Welcome, {{ Auth::user()->username }}</p>
                <p>You are logged in as an Inventory Manager</p>
                <hr>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
