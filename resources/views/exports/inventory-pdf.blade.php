<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .summary {
            margin-top: 20px;
            padding: 10px;
            background: #f4f4f4;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
        }

        .text-success {
            color: #28a745;
        }

        .text-warning {
            color: #ffc107;
        }

        .text-danger {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN INVENTORY</h1>
        <p>Inventory & Asset Management System</p>
        <p>Tanggal: {{ date('d F Y H:i') }}</p>
        @if(request()->has('search') || request()->has('category'))
        <p>
            <strong>Filter:</strong>
            @if(request('search')) Pencarian: {{ request('search') }} @endif
            @if(request('category')) Kategori: {{ request('category') }} @endif
        </p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>SKU</th>
                <th>Nama Item</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Total Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}
            </tr>
            <td>{{ $item->sku }} </tr>
            <td>{{ $item->name }} </tr>
            <td>{{ ucfirst($item->category) }} </tr>
            <td class="text-center">{{ $item->quantity }} </tr>
            <td>Rp {{ number_format($item->price, 0, ',', '.') }} </tr>
            <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }} </tr>
            <td>
                @if($item->quantity > 10)
                <span class="badge text-success">In Stock</span>
                @elseif($item->quantity > 0)
                <span class="badge text-warning">Low Stock</span>
                @else
                <span class="badge text-danger">Out of Stock</span>
                @endif
                </tr>
                </tr>
                @endforeach
        </tbody>
    </table>

    <div class="summary">
        <strong>Ringkasan:</strong><br>
        Total Item: {{ $items->count() }}<br>
        Total Nilai Inventory: Rp {{ number_format($totalValue, 0, ',', '.') }}<br>
        Low Stock Items: {{ $items->whereBetween('quantity', [1, 10])->count() }}<br>
        Out of Stock Items: {{ $items->where('quantity', 0)->count() }}
    </div>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }} | Inventory & Asset Management System
    </div>
</body>

</html>