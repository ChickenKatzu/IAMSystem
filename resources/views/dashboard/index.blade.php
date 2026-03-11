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
                        <h6 class="m-0 font-weight-bold text-primary">Inventory Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Total Items</th>
                                        <th>In Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Electronics</td>
                                        <td>450</td>
                                        <td>320</td>
                                        <td><span class="badge bg-success">Good</span></td>
                                    </tr>
                                    <tr>
                                        <td>Furniture</td>
                                        <td>280</td>
                                        <td>210</td>
                                        <td><span class="badge bg-success">Good</span></td>
                                    </tr>
                                    <tr>
                                        <td>Stationery</td>
                                        <td>520</td>
                                        <td>180</td>
                                        <td><span class="badge bg-warning">Low Stock</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">New Item Added</h6>
                                    <small>5 mins ago</small>
                                </div>
                                <p class="mb-1">Laptop Dell XPS 13 added to inventory</p>
                            </div>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Asset Maintenance</h6>
                                    <small>2 hours ago</small>
                                </div>
                                <p class="mb-1">Printer HP LaserJet maintenance completed</p>
                            </div>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Stock Update</h6>
                                    <small>1 day ago</small>
                                </div>
                                <p class="mb-1">50 units of A4 paper added to stationery</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
