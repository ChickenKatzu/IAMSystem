<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
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
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .bg-success {
            background-color: #28a745;
            color: white;
        }
        .bg-warning {
            background-color: #ffc107;
            color: #333;
        }
        .bg-danger {
            background-color: #dc3545;
            color: white;
        }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background: #f4f4f4;
            font-size: 10px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #666;
            padding: 10px;
        }
        .signature {
            margin-top: 40px;
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
                @if(request('category')) | Kategori: {{ request('category') }} @endif
            </p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">SKU</th>
                <th width="18%">Nama Item</th>
                <th width="10%">Kategori</th>
                <th width="7%">Stok</th>
                <th width="12%">Harga</th>
                <th width="15%">Total Nilai</th>
                <th width="13%">Supplier</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->sku }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ ucfirst($item->category) }}</td>
                <td class="text-center">{{ number_format($item->quantity) }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                <td>{{ $item->supplier ?? '-' }}</td>
                <td class="text-center">
                    @if($item->quantity > 10)
                        <span class="badge bg-success">In Stock</span>
                    @elseif($item->quantity > 0)
                        <span class="badge bg-warning">Low Stock</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        @if(count($items) > 0)
        <tfoot>
            <tr style="background-color: #f2f2f2; font-weight: bold;">
                <td colspan="6" class="text-right">Total Keseluruhan:</td>
                <td class="text-right">Rp {{ number_format($totalValue, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="summary">
        <strong>Ringkasan:</strong><br>
        Total Item: {{ $items->count() }}<br>
        Total Nilai Inventory: Rp {{ number_format($totalValue, 0, ',', '.') }}<br>
        Total Stok: {{ number_format($items->sum('quantity')) }} unit<br>
        Low Stock (1-10): {{ $items->whereBetween('quantity', [1, 10])->count() }} item<br>
        Out of Stock: {{ $items->where('quantity', 0)->count() }} item
    </div>

    <div class="signature">
        <table width="100%">
            <tr>
                <td width="50%" style="text-align: center;">
                    <p>Mengetahui,</p>
                    <p>Manajer</p>
                    <br><br><br>
                    <p>(_____________________)</p>
                </td>
                <td width="50%" style="text-align: center;">
                    <p>Petugas Inventory,</p>
                    <br><br><br>
                    <p>(_____________________)</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }} | Inventory & Asset Management System
    </div>
</body>
</html>