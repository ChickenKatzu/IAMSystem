@extends('layouts.app')

@section('title', 'Daftar Asset')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-building"></i> Daftar Asset
            </h1>
            <a href="{{ route('assets.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="bi bi-plus-circle"></i> Register Asset
            </a>
        </div>

        <!-- Filter and Search Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-search"></i> Filter & Pencarian
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('assets.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Cari Asset</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Nama atau kode asset..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Semua Kategori</option>
                            <option value="elektronik" {{ request('category') == 'elektronik' ? 'selected' : '' }}>
                                Elektronik</option>
                            <option value="furniture" {{ request('category') == 'furniture' ? 'selected' : '' }}>Furniture
                            </option>
                            <option value="kendaraan" {{ request('category') == 'kendaraan' ? 'selected' : '' }}>Kendaraan
                            </option>
                            <option value="mesin" {{ request('category') == 'mesin' ? 'selected' : '' }}>Mesin & Peralatan
                            </option>
                            <option value="it" {{ request('category') == 'it' ? 'selected' : '' }}>IT & Hardware
                            </option>
                            <option value="others" {{ request('category') == 'others' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>
                                Maintenance</option>
                            <option value="disposed" {{ request('status') == 'disposed' ? 'selected' : '' }}>Disposed
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Lokasi..."
                            value="{{ request('location') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Asset</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $totalAssets ?? $assets->total() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-building fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Nilai Asset</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($totalValue ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-cash-stack fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Dalam Maintenance</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $maintenanceCount ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-tools fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Disposed</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $disposedCount ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-trash fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asset Table Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-table"></i> Data Asset
                </h6>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('assets.export.excel', request()->query()) }}">
                                <i class="bi bi-file-excel text-success"></i> Export to Excel
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('assets.export.pdf', request()->query()) }}">
                                <i class="bi bi-file-pdf text-danger"></i> Export to PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('assets.print', request()->query()) }}"
                                target="_blank">
                                <i class="bi bi-printer text-primary"></i> Print
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">Kode Asset</th>
                                <th width="20%">Nama Asset</th>
                                <th width="12%">Kategori</th>
                                <th width="12%">Lokasi</th>
                                <th width="10%">Nilai</th>
                                <th width="10%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assets as $index => $asset)
                                <tr>
                                    <td>{{ $assets->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $asset->asset_code }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $asset->name }}</strong>
                                        @if ($asset->assigned_to)
                                            <br><small class="text-muted">
                                                <i class="bi bi-person"></i> {{ $asset->assigned_to }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $categoryLabels = [
                                                'elektronik' => ['label' => 'Elektronik', 'class' => 'primary'],
                                                'furniture' => ['label' => 'Furniture', 'class' => 'success'],
                                                'kendaraan' => ['label' => 'Kendaraan', 'class' => 'info'],
                                                'mesin' => ['label' => 'Mesin', 'class' => 'warning'],
                                                'it' => ['label' => 'IT Hardware', 'class' => 'dark'],
                                                'others' => ['label' => 'Lainnya', 'class' => 'secondary'],
                                            ];
                                            $category = $categoryLabels[$asset->category] ?? [
                                                'label' => ucfirst($asset->category),
                                                'class' => 'secondary',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $category['class'] }}">
                                            {{ $category['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="bi bi-geo-alt"></i> {{ $asset->location }}
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">{{ $asset->formatted_current_value }}</span>
                                        @if ($asset->depreciation > 0)
                                            <br><small class="text-danger">
                                                Penyusutan: {{ number_format($asset->depreciation_percent, 1) }}%
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @php $status = $asset->status_badge; @endphp
                                        <span class="badge bg-{{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-sm btn-info"
                                                title="Lihat Detail" data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('assets.edit', $asset->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="tooltip">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $asset->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $asset->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus asset berikut?</p>
                                                        <p>
                                                            <strong>Kode:</strong> {{ $asset->asset_code }}<br>
                                                            <strong>Nama:</strong> {{ $asset->name }}
                                                        </p>
                                                        <div class="alert alert-danger">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            Tindakan ini tidak dapat dibatalkan!
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bi bi-x"></i> Batal
                                                        </button>
                                                        <form action="{{ route('assets.destroy', $asset->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-building" style="font-size: 48px; color: #ccc;"></i>
                                        <h5 class="mt-3 text-muted">Belum ada data asset</h5>
                                        <p class="text-muted">Klik tombol "Register Asset" untuk menambahkan asset baru</p>
                                        <a href="{{ route('assets.create') }}" class="btn btn-primary mt-2">
                                            <i class="bi bi-plus-circle"></i> Register Asset
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan {{ $assets->firstItem() ?? 0 }} - {{ $assets->lastItem() ?? 0 }}
                        dari {{ $assets->total() }} data
                    </div>
                    <div>
                        {{ $assets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Auto hide alert after 5 seconds
        setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>
@endpush
