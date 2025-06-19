<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quarterly Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-header-primary {
            background-color: var(--bs-primary) !important;
            color: white !important;
            font-weight: bold;
        }
        .quarter-header {
            background-color: var(--bs-primary) !important;
            color: white !important;
            text-align: center;
        }
        .sub-header {
            background-color: #e9ecef;
            text-align: center;
            font-weight: bold;
        }
        .value-cell {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg"> <!-- Added shadow-lg class here -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-header-primary">
                            <th colspan="9" class="text-center">CUFFED</th>
                        </tr>
                        <tr>
                            <th rowspan="2" class="align-middle text-center table-header-primary">
                                Quarterly Sales Report
                            </th>
                            @for($i = 1; $i <= 4; $i++)
                                <th colspan="2" class="quarter-header">Q{{ $i }}</th>
                            @endfor
                        </tr>
                        <tr class="sub-header">
                            @for($i = 1; $i <= 4; $i++)
                                <th class="text-center">T</th>
                                <th class="text-center">A</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle text-center">
                                Targets and Accomplishments across Quarters
                            </td>
                            @for($i = 1; $i <= 4; $i++)
                                <td class="value-cell">₱{{ number_format($quarterlyData[$i]['target'], 0) }}</td>
                                <td class="value-cell">
                                    ₱{{ number_format($quarterlyData[$i]['accomplished'], 0) }}
                                    @if($quarterlyData[$i]['accomplished'] > $quarterlyData[$i]['target'])
                                        <span class="text-success">▲</span>
                                    @elseif($quarterlyData[$i]['accomplished'] < $quarterlyData[$i]['target'])
                                        <span class="text-danger">▼</span>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>