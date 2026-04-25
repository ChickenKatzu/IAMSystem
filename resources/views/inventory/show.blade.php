@extends('layouts.app')

@section('title', 'Detail Item - ' . $item->name)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-box"></i> Detail Item
        </h1>
        <div>
            <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-sm btn-warning shadow-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-info-circle"></i> Informasi Item
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">SKU</th>
                                <td><span class="badge bg-secondary">{{ $item->sku }}</span></td>
                            </tr>
                            <tr>
                                <th>Nama Item</th>
                                <td><strong>{{ $item->name }}</strong></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>
                                    @php
                                        $categoryLabels = [
                                            'elektronik' => 'Elektronik',
                                            'furniture' => 'Furniture',
                                            'stationery' => 'Stationery',
                                            'lainnya' => 'Lainnya',
                                        ];
                                    @endphp
                                    <span class="badge bg-info">
                                        {{ $categoryLabels[$item->category] ?? ucfirst($item->category) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>
                                    <span class="fw-bold">{{ number_format($item->quantity) }}</span>
                                    @php $status = $item->stock_status; @endphp
                                    <span class="badge bg-{{ $status['class'] }} ms-2">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td><span class="fw-bold text-primary">{{ $item->formatted_price }}</span></td>
                            </tr>
                            <tr>
                                <th>Total Nilai</th>
                                <td><span class="fw-bold text-success">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span></td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>{{ $item->supplier ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $item->description ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Ditambahkan Pada</th>
                                <td>{{ $item->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Terakhir Diupdate</th>
                                <td>{{ $item->updated_at->format('d F Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Stock Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-graph-up"></i> Status Stok
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="display-4 fw-bold {{ $item->quantity > 10 ? 'text-success' : ($item->quantity > 0 ? 'text-warning' : 'text-danger') }}">
                            {{ number_format($item->quantity) }}
                        </div>
                        <p class="text-muted">Unit Tersedia</p>
                    </div>

                    <div class="progress mb-3" style="height: 20px;">
                        @php
                            $maxStock = 100; // Bisa disesuaikan dengan logika bisnis
                            $percentage = min(($item->quantity / $maxStock) * 100, 100);
                        @endphp
                        <div class="progress-bar {{ $item->quantity > 10 ? 'bg-success' : ($item->quantity > 0 ? 'bg-warning' : 'bg-danger') }}"
                             role="progressbar"
                             style="width: {{ $percentage }}%;"
                             aria-valuenow="{{ $item->quantity }}"
                             aria-valuemin="0"
                             aria-valuemax="{{ $maxStock }}">
                            {{ number_format($percentage, 1) }}%
                        </div>
                    </div>

                    <div class="alert {{ $item->quantity > 10 ? 'alert-success' : ($item->quantity > 0 ? 'alert-warning' : 'alert-danger') }}">
                        <i class="bi {{ $item->quantity > 10 ? 'bi-check-circle' : ($item->quantity > 0 ? 'bi-exclamation-triangle' : 'bi-x-octagon') }}"></i>
                        {{ $item->quantity > 10 ? 'Stok aman' : ($item->quantity > 0 ? 'Stok menipis, segera lakukan restock!' : 'Stok habis!') }}
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-lightning"></i> Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">
                            <i class="bi bi-plus-circle"></i> Tambah Stok
                        </button>
                        <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#kurangistockModal">
                            <i class="bi bi-dash-circle"></i> Kurangi Stok
                        </button>
                        <a href="#" class="btn btn-outline-info">
                            <i class="bi bi-arrow-repeat"></i> Mutasi Stok
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventory.tambahstockModal', $item->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Item</label>
                        <input type="text" class="form-control" value="{{ $item->name }} ({{ $item->sku }})" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok Saat Ini</label>
                        <input type="text" class="form-control" value="{{ number_format($item->quantity) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Tambahan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quantity" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reduce Stock Modal -->
<div class="modal fade" id="kurangistockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kurangi Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventory.kurangistockModal', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Item</label>
                        <input type="text" class="form-control" value="{{ $item->name }} ({{ $item->sku }})" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok Saat Ini</label>
                        <input type="text" class="form-control" value="{{ number_format($item->quantity) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Pengurangan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quantity" min="1" max="{{ $item->quantity }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="deskripsi" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Kurangi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
