@extends('layouts.app')

@section('title', 'Daftar Inventory')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-box"></i> Daftar Inventory
            </h1>
            <a href="{{ route('inventory.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="bi bi-plus-circle"></i> Tambah Item Baru
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
                <form action="{{ route('inventory.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Item</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Nama item atau SKU..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Semua Kategori</option>
                            <option value="elektronik" {{ request('category') == 'elektronik' ? 'selected' : '' }}>
                                Elektronik</option>
                            <option value="furniture" {{ request('category') == 'furniture' ? 'selected' : '' }}>Furniture
                            </option>
                            <option value="stationery" {{ request('category') == 'stationery' ? 'selected' : '' }}>
                                Stationery</option>
                            <option value="others" {{ request('category') == 'others' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="stock_status" class="form-label">Status Stok</label>
                        <select class="form-select" id="stock_status" name="stock_status">
                            <option value="">Semua Status</option>
                            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock
                            </option>
                            <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low
                                Stock</option>
                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                                Out of Stock</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Inventory Table Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-table"></i> Data Inventory
                </h6>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-file-pdf"></i> PDF</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-file-excel"></i> Excel</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-printer"></i> Print</a></li>
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

                {{-- table index --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">SKU</th>
                                <th width="20%">Nama Item</th>
                                <th width="15%">Kategori</th>
                                <th width="10%">Stok</th>
                                <th width="15%">Harga</th>
                                <th width="10%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                                <tr>
                                    <td>{{ $items->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $item->sku }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $item->name }}</strong>
                                        @if ($item->description)
                                            <br><small class="text-muted">{{ Str::limit($item->description, 30) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $categoryLabels = [
                                                'elektronik' => ['label' => 'Elektronik', 'class' => 'info'],
                                                'furniture' => ['label' => 'Furniture', 'class' => 'success'],
                                                'stationery' => ['label' => 'Stationery', 'class' => 'warning'],
                                                'others' => ['label' => 'Lainnya', 'class' => 'secondary'],
                                            ];
                                            $category = $categoryLabels[$item->category] ?? [
                                                'label' => ucfirst($item->category),
                                                'class' => 'secondary',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $category['class'] }}">
                                            {{ $category['label'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold">{{ number_format($item->quantity) }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">{{ $item->formatted_price }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $status = $item->stock_status;
                                        @endphp
                                        <span class="badge bg-{{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                        @if ($item->quantity <= 10 && $item->quantity > 0)
                                            <br><small class="text-warning">Sisa {{ $item->quantity }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('inventory.show', $item->id) }}"
                                                class="btn btn-sm btn-info" title="Lihat Detail"
                                                data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            {{-- <a href="{{ route('inventory.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="tooltip">
                                                <i class="bi bi-pencil"></i>
                                            </a> --}}
                                            <button type="button" class="btn btn-sm btn-warning" title="Edit"
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                </div>
                </td>
                </tr>
                {{-- modal section --}}
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menghapus item berikut?</p>
                                <p>
                                    <strong>SKU:</strong> {{ $item->sku }}<br>
                                    <strong>Nama:</strong> {{ $item->name }}
                                </p>
                                <p class="text-danger">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Tindakan ini tidak dapat dibatalkan!
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x"></i> Batal
                                </button>
                                <form action="{{ route('inventory.destroy', $item->id) }}" method="POST"
                                    class="d-inline">
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
                {{-- add modal edit --}}
                <div class="modal fade" id="editModal{{ $item->id }}" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-lg modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModal">Form Edit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('inventory.updateInventory', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nama_item" class="form-label">Nama
                                                Item</label>
                                            <input type="text" class="form-control" placeholder="Nama Item"
                                                name="nama_item" id="nama_item" value="{{ $item->name }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kategori" class="form-label">Kategori</label>
                                            <select class="form-select" name="kategori" id="kategori">
                                                @php
                                                    $categories = [
                                                        'Elektronik' => 'Elektronik',
                                                        'Furniture' => 'Furniture',
                                                        'Stationary' => 'Stationary',
                                                        'Lainnya' => 'Lainnya',
                                                    ];
                                                @endphp
                                                @foreach ($categories as $value => $values)
                                                    <option value="{{ $value }}"
                                                        {{ old('kategori', $item->category) == $value ? 'selected' : '' }}>
                                                        {{ $values }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sku" class="form-label">SKU</label>
                                            <input type="text" class="form-control" placeholder="SKU" name="sku"
                                                value=" {{ $item->sku }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" placeholder="Quantity"
                                                name="quantity" value="{{ $item->quantity }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="harga" class="form-label">Harga</label>
                                            <input type="number" class="form-control" placeholder="Harga"
                                                name="harga" value="{{ $item->price }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="supplier" class="form-label">Supplier</label>
                                            <input type="text" class="form-control" placeholder="Supplier"
                                                name="supplier" value="{{ $item->supplier }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea name="deskripsi" placeholder="Deskripsi" id="deskripsi" cols="140" rows="5"
                                                value="{{ $item->description }}">{{ $item->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="reset" class="btn btn-secondary me-md-2">
                                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> Simpan Item
                                        </button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <img src="https://via.placeholder.com/150?text=No+Data" alt="No Data" class="mb-3"
                            style="opacity: 0.5">
                        <h5 class="text-muted">Belum ada data inventory</h5>
                        <p class="text-muted">Klik tombol "Tambah Item Baru" untuk menambahkan data</p>
                        <a href="{{ route('inventory.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Item Baru
                        </a>
                    </td>
                </tr>
                @endforelse
                </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <div class="text-muted small">
                    Menampilkan {{ $items->firstItem() }} ke {{ $items->lastItem() }} dari {{ $items->total() }}
                    Hasil
                    <nav>
                        <ul class="pagination pagination-sm-mb-0">
                            <li class="page-item {{ $items->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link pagination-link" href="{{ $items->previousPageUrl() }}">&laquo;</a>
                            </li>
                            @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $items->currentPage() ? 'active' : '' }}">
                                    <a class="page-link pagination-link"
                                        href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            <li class="page-item {{ $items->onLastPage() ? 'disabled' : '' }}">
                                <a class="page-link pagination-link" href="{{ $items->nextPageUrl() }}">&raquo;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <!-- Summary Cards -->
    <div class="row">
        {{-- total items --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Item</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalItems ?? $items->total() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- card total stock value --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Nilai Inventory</div>
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
        {{-- card stock low --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Low Stock Items</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $lowStockCount ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- card stock count --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Out of Stock</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $outOfStockCount ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-octagon fa-2x text-gray-300"></i>
                        </div>
                    </div>
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
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simpan posisi scroll sebelum meninggalkan halaman
            const paginationLinks = document.querySelectorAll('.pagination-link');

            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Simpan posisi scroll di sessionStorage
                    sessionStorage.setItem('scrollPosition', window.scrollY);
                    sessionStorage.setItem('currentUrl', window.location.href);

                    // Navigasi ke halaman yang dituju
                    window.location.href = this.href;
                });
            });

            // Kembalikan ke posisi scroll yang disimpan
            const savedPosition = sessionStorage.getItem('scrollPosition');
            const savedUrl = sessionStorage.getItem('currentUrl');

            if (savedPosition && savedUrl && savedUrl !== window.location.href) {
                // Beri sedikit delay untuk memastikan halaman sudah selesai loading
                setTimeout(() => {
                    window.scrollTo({
                        top: parseInt(savedPosition),
                        behavior: 'smooth' // Bisa diganti 'auto' jika tidak ingin efek smooth
                    });

                    // Hapus data setelah digunakan
                    sessionStorage.removeItem('scrollPosition');
                    sessionStorage.removeItem('currentUrl');
                }, 100);
            }
        });
    </script>
@endpush
