@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="btn btn-sm btn-primary shadow-sm">
                <i class="bi bi-download"></i> Generate Report
            </a>
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
                                    {{ number_format($totalItems ?? 0, 0, ',', '.') }}
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
                                    {{ number_format($lowStockCount ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- card out of stock --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Out of Stock</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($outOfStockCount ?? 0, 0, ',', '.') }}
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


        <!-- Content Row -->
        <div class="row">
            <!-- Inventory Status Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Inventory Status by Category</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Options:</div>
                                <a class="dropdown-item" href="{{ route('inventory.index') }}">View All</a>
                                <a class="dropdown-item" href="{{ route('inventory.create') }}">Add New Item</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Category</th>
                                        <th class="text-center">Total Items</th>
                                        <th class="text-center">In Stock</th>
                                        <th class="text-center">Low Stock</th>
                                        <th class="text-center">Out of Stock</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($inventoryByCategory as $category)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $icons = [
                                                            'Elektronik' => 'bi-phone',
                                                            'Furniture' => 'bi-house',
                                                            'Stationary' => 'bi-pencil',
                                                            'Lainnya' => 'bi-grid',
                                                        ];
                                                        $icon = $icons[$category->category] ?? 'bi-tag';
                                                    @endphp
                                                    <i class="bi {{ $icon }} me-2 text-primary"></i>
                                                    {{ $category->category }}
                                                </div>
                                            </td>
                                            <td class="text-center fw-bold">{{ number_format($category->total_items) }}</td>
                                            <td class="text-center text-success fw-bold">
                                                {{ number_format($category->in_stock) }}</td>
                                            <td class="text-center text-warning fw-bold">
                                                {{ number_format($category->low_stock ?? 0) }}</td>
                                            <td class="text-center text-danger fw-bold">
                                                {{ number_format($category->out_of_stock ?? 0) }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-{{ $category->status_class }} bg-opacity-25 text-{{ $category->status_class }} px-3 py-2">
                                                    <i class="bi {{ $category->status_icon }} me-1"></i>
                                                    {{ $category->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                                No inventory data available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="table-light">
                                    @php
                                        $totalItems = $inventoryByCategory->sum('total_items');
                                        $totalInStock = $inventoryByCategory->sum('in_stock');
                                        $totalLowStock = $inventoryByCategory->sum('low_stock');
                                        $totalOutOfStock = $inventoryByCategory->sum('out_of_stock');
                                    @endphp
                                    <tr>
                                        <th class="text-end">Total:</th>
                                        <th class="text-center">{{ number_format($totalItems) }}</th>
                                        <th class="text-center">{{ number_format($totalInStock) }}</th>
                                        <th class="text-center">{{ number_format($totalLowStock) }}</th>
                                        <th class="text-center">{{ number_format($totalOutOfStock) }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Mini Stats -->
                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <div class="small">
                                <span class="text-success me-3">
                                    <i class="bi bi-check-circle-fill"></i> Good
                                </span>
                                <span class="text-warning me-3">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Warning
                                </span>
                                <span class="text-danger me-3">
                                    <i class="bi bi-x-octagon-fill"></i> Critical
                                </span>
                            </div>
                            <div class="small text-muted">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                Updated {{ now()->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - You can add another chart/table here -->
            <div class="col-xl-6 col-lg-6">
                <!-- Add another card here if needed -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <a href="{{ route('inventory.create') }}" class="btn btn-primary w-100 py-3">
                                    <i class="bi bi-plus-circle d-block fs-4 mb-2"></i>
                                    Add New Item
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('inventory.index') }}" class="btn btn-success w-100 py-3">
                                    <i class="bi bi-list-ul d-block fs-4 mb-2"></i>
                                    View All Items
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="btn btn-warning w-100 py-3">
                                    <i class="bi bi-file-pdf d-block fs-4 mb-2"></i>
                                    Export Report
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="btn btn-info w-100 py-3">
                                    <i class="bi bi-graph-up d-block fs-4 mb-2"></i>
                                    Analytics
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
