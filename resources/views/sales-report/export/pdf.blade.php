<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .month-header {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .grand-total {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Sales Report - {{ now()->format('Y-m-d') }}</h1>

    @foreach($monthlySales as $month => $data)
        <h3>{{ $data['sales'][0]->date->format('F Y') }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['sales'] as $sale)
                    <tr>
                        <td>{{ $sale->date->format('Y-m-d') }}</td>
                        <td>₱{{ number_format($sale->daily_revenue, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td>Monthly Total</td>
                    <td>₱{{ number_format($data['total'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach

    <div class="grand-total">
        Grand Total: ₱{{ number_format($grandTotal, 2) }}
    </div>
</body>
</html>