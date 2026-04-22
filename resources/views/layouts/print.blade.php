<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - IAM System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }

        .header h2 {
            margin: 0;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .filter-info {
            margin-top: 10px;
            padding: 10px;
            background: #f4f4f4;
            border-radius: 5px;
            font-size: 12px;
        }

        .summary {
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .signature {
            margin-top: 50px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
            }

            .btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    @yield('content')

    <div class="no-print text-center mt-4">
        <button onclick="window.print();" class="btn btn-primary">
            <i class="bi bi-printer"></i> Print
        </button>
        <button onclick="window.close();" class="btn btn-secondary">
            <i class="bi bi-x"></i> Close
        </button>
    </div>
</body>

</html>
