<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventory - IAM System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            font-size: 12px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        
        .header h2 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 20px;
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
            font-size: 11px;
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
            vertical-align: top;
        }
        
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
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
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .signature {
            margin-top: 50px;
        }
        
        .signature-table {
            width: 100%;
            margin-top: 30px;
        }
        
        .signature-cell {
            text-align: center;
            padding-top: 30px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .badge {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            th {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>LAPORAN DATA INVENTORY</h2>
            <p>Inventory & Asset Management System</p>
            <p>Tanggal Cetak: {{ date('d F Y H:i:s') }}</p>
            @if(request()->has('search') && request('search') || request()->has('category') && request('category'))
                <div class="filter-info">
                    <strong>Filter yang diterapkan:</strong><br>
                    @if(request('search')) • Pencarian: "{{ request('search') }}"<br>@endif
                    @if(request('category')) • Kategori: {{ ucfirst(request('category')) }}<br>@endif
                    @if(request('stock_status')) 
                        • Status Stok: 
                        @if(request('stock_status') == 'in_stock') In Stock (>10)
                        @elseif(request('stock_status') == 'low_stock') Low Stock (1-10)
                        @else Out of Stock (0)
                        @endif
                    @endif
                </div>
            @endif
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">SKU</th>
                    <th width="20%">Nama Item</th>
                    <th width="12%">Kategori</th>
                    <th width="8%">Stok</th>
                    <th width="12%">Harga</th>
                    <th width="15%">Total Nilai</th>
                    <th width="10%">Supplier</th>
                    <th width="6%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->sku }}</td>
                    <td>
                        {{ $item->name }}
                        @if($item->description)
                            <br><small style="color: #666;">{{ Str::limit($item->description, 50) }}</small>
                        @endif
                    </td>
                    <td>
                        @php
                            $categoryLabels = [
                                'elektronik' => 'Elektronik',
                                'furniture' => 'Furniture',
                                'stationery' => 'Stationery',
                                'others' => 'Lainnya',
                            ];
                        @endphp
                        {{ $categoryLabels[$item->category] ?? ucfirst($item->category) }}
                    </td>
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
                @empty
                <tr>
                    <td colspan="9" class="text-center" style="text-align: center; padding: 40px;">
                        <strong>Tidak ada data inventory yang ditemukan</strong>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if(count($items) > 0)
            <tfoot>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td colspan="6" class="text-right"><strong>Total Keseluruhan:</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalValue, 0, ',', '.') }}</strong></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            @endif
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span><strong>Total Item:</strong> {{ $items->count() }}</span>
                <span><strong>Total Nilai Inventory:</strong> Rp {{ number_format($totalValue, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span><strong>Total Stok Keseluruhan:</strong> {{ number_format($items->sum('quantity')) }} unit</span>
                <span><strong>Rata-rata Harga:</strong> Rp {{ number_format($items->avg('price') ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span><strong>Low Stock (1-10):</strong> {{ $items->whereBetween('quantity', [1, 10])->count() }} item</span>
                <span><strong>Out of Stock (0):</strong> {{ $items->where('quantity', 0)->count() }} item</span>
            </div>
            <div class="summary-row">
                <span><strong>In Stock (>10):</strong> {{ $items->where('quantity', '>', 10)->count() }} item</span>
                <span><strong>Total Kategori:</strong> {{ $items->groupBy('category')->count() }} kategori</span>
            </div>
        </div>

        <!-- Signature -->
        <div class="signature">
            <table class="signature-table">
                <tr>
                    <td class="signature-cell" width="50%">
                        <div>Mengetahui,</div>
                        <div>Manajer</div>
                        <br><br><br>
                        <div>(_____________________)</div>
                        <div><small>Nama jelas & stempel</small></div>
                    </td>
                    <td class="signature-cell" width="50%">
                        <div>Petugas Inventory,</div>
                        <br><br><br>
                        <div>(_____________________)</div>
                        <div><small>Nama jelas</small></div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Dicetak pada: {{ date('d/m/Y H:i:s') }} | Sistem Inventory & Asset Management</p>
            <p>Dokumen ini adalah bukti sah dan valid</p>
        </div>
    </div>

    <!-- Print Button (only visible on screen) -->
    <div class="no-print" style="text-align: center; margin-top: 30px; padding: 20px; position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.print();" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">
            🖨️ Print / Cetak
        </button>
        <button onclick="window.close();" style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">
            ✖️ Close / Tutup
        </button>
    </div>

    <script>
        // Auto print (optional - uncomment if you want auto print)
        // window.onload = function() {
        //     window.print();
        // }
        
        // Handle after print
        window.onafterprint = function() {
            // Uncomment if you want auto close after print
            // window.close();
        };
    </script>
</body>
</html>