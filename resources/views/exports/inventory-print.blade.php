@extends('layouts.print')

@section('title', 'Laporan Inventory')

@section('content')
<div class="container">
    <div class="header">
        <h2>LAPORAN DATA INVENTORY</h2>
        <p>Inventory & Asset Management System</p>
        <p>Tanggal Cetak: {{ date('d F Y H:i:s') }}</p>
        @if(request()->has('search') || request()->has('category'))
        <div class="filter-info">
            <strong>Filter yang diterapkan:</strong><br>
            @if(request('search')) • Pencarian: "{{ request('search') }}"<br>@endif
            @if(request('category')) • Kategori: {{ request('category') }}<br>@endif
        </div>
        @endif
    </div>

    <table class="table table-bordered table-striped">
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
            @forelse($items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}
            </tr>
            <td>{{ $item->sku }} </tr>
            <td>{{ $item->name }} </tr>
            <td>{{ ucfirst($item->category) }} </tr>
            <td class="text-center">{{ number_format($item->quantity) }} </tr>
            <td>Rp {{ number_format($item->price, 0, ',', '.') }} </tr>
            <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }} </tr>
            <td>
                @if($item->quantity > 10)
                <span class="badge bg-success">In Stock</span>
                @elseif($item->quantity > 0)
                <span class="badge bg-warning">Low Stock ({{ $item->quantity }})</span>
                @else
                <span class="badge bg-danger">Out of Stock</span>
                @endif
                </tr>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-end">Total Keseluruhan:</th>
                <th colspan="2">Rp {{ number_format($totalValue, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="summary">
        <div class="row">
            <div class="col-md-4">
                <strong>Total Item:</strong> {{ $items->count() }}
            </div>
            <div class="col-md-4">
                <strong>Low Stock:</strong> {{ $items->whereBetween('quantity', [1, 10])->count() }}
            </div>
            <div class="col-md-4">
                <strong>Out of Stock:</strong> {{ $items->where('quantity', 0)->count() }}
            </div>
        </div>
    </div>

    <div class="signature">
        <table width="100%">
            <tr>
                <td width="50%">
                    <div class="text-center">
                        <p>Mengetahui,</p>
                        <p>Manajer</p>
                        <br><br><br>
                        <p>(_____________________)</p>
                    </div>
                </td>
                <td width="50%">
                    <div class="text-center">
                        <p>Petugas Inventory,</p>
                        <br><br><br>
                        <p>(_____________________)</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    window.print();
    window.onafterprint = function() {
        window.close();
    };
</script>
@endsection