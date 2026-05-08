@extends('layouts.app')

@section('title', 'Detail Asset - ' . $asset->name)

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-building"></i> Detail Asset
            </h1>
            <div>
                <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-warning shadow-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('assets.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Main Info -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-info-circle"></i> Informasi Asset
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Kode Asset</th>
                                    <td><span class="badge bg-secondary">{{ $asset->asset_code }}</span></td>
                                </tr>
                                <tr>
                                    <th>Nama Asset</th>
                                    <td><strong>{{ $asset->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>
                                        @php
                                            $categoryLabels = [
                                                'elektronik' => 'Elektronik',
                                                'furniture' => 'Furniture',
                                                'kendaraan' => 'Kendaraan',
                                                'mesin' => 'Mesin & Peralatan',
                                                'it' => 'IT & Hardware',
                                                'others' => 'Lainnya',
                                            ];
                                        @endphp
                                        <span
                                            class="badge bg-info">{{ $categoryLabels[$asset->category] ?? ucfirst($asset->category) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td><i class="bi bi-geo-alt"></i> {{ $asset->location }}</td>
                                </tr>
                                <tr>
                                    <th>Ditugaskan Kepada</th>
                                    <td>{{ $asset->assigned_to ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ $asset->status_badge['class'] }}">
                                            {{ $asset->status_badge['label'] }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pembelian</th>
                                    <td>{{ \Carbon\Carbon::parse($asset->purchase_date)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Pembelian</th>
                                    <td class="text-primary fw-bold">{{ $asset->formatted_purchase_price }}</td>
                                </tr>
                                <tr>
                                    <th>Nilai Saat Ini</th>
                                    <td class="text-success fw-bold">{{ $asset->formatted_current_value }}</td>
                                </tr>
                                <tr>
                                    <th>Penyusutan</th>
                                    <td class="text-danger">Rp {{ number_format($asset->depreciation, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $asset->description ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>{{ $asset->notes ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>{{ $asset->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Update</th>
                                    <td>{{ $asset->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Info -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-graph-up"></i> Ringkasan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="display-4 fw-bold text-primary">
                                {{ $asset->status_badge['label'] }}
                            </div>
                            <p class="text-muted">Status Asset</p>
                        </div>

                        <div class="progress mb-3" style="height: 20px;">
                            @php
                                $depreciationPercent =
                                    $asset->purchase_price > 0
                                        ? ($asset->depreciation / $asset->purchase_price) * 100
                                        : 0;
                                $remainingPercent = 100 - $depreciationPercent;
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $remainingPercent }}%;" aria-valuenow="{{ $remainingPercent }}"
                                aria-valuemin="0" aria-valuemax="100">
                                Nilai Tersisa: {{ number_format($remainingPercent, 1) }}%
                            </div>
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ $depreciationPercent }}%;">
                                Penyusutan: {{ number_format($depreciationPercent, 1) }}%
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-calculator"></i>
                            <strong>Informasi Nilai:</strong><br>
                            - Harga Beli: {{ $asset->formatted_purchase_price }}<br>
                            - Nilai Kini: {{ $asset->formatted_current_value }}<br>
                            - Total Penyusutan: Rp {{ number_format($asset->depreciation, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-lightning"></i> Aksi Cepat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#maintenanceModal">
                                <i class="bi bi-tools"></i> Maintenance
                            </button>
                            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#transferModal">
                                <i class="bi bi-arrow-left-right"></i> Transfer Asset
                            </button>
                            @if ($asset->status != 'disposed')
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#disposalModal">
                                    <i class="bi bi-trash"></i> Disposal
                                </button>
                            @endif
                            <a href="#" class="btn btn-outline-secondary" onclick="window.print();">
                                <i class="bi bi-printer"></i> Print Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Modal -->
    <div class="modal fade" id="maintenanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catatan Maintenance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('assets.maintenance.store', $asset->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Asset</label>
                            <input type="text" class="form-control"
                                value="{{ $asset->name }} ({{ $asset->asset_code }})" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Maintenance</label>
                            <input type="date" name="maintenance_date" class="form-control" value="{{ date('Y-m-d') }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Maintenance</label>
                            <select name="maintenance_type" class="form-select" required>
                                <option value="routine">Routine (Rutin)</option>
                                <option value="corrective">Corrective (Perbaikan)</option>
                                <option value="preventive">Preventive (Pencegahan)</option>
                                <option value="emergency">Emergency (Darurat)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Biaya Maintenance</label>
                            <input type="number" name="cost" class="form-control" placeholder="0" min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
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

    <!-- Transfer Modal -->
    <div class="modal fade" id="transferModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('assets.transfer.store', $asset->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Asset</label>
                            <input type="text" class="form-control"
                                value="{{ $asset->name }} ({{ $asset->asset_code }})" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi Asal</label>
                            <input type="text" class="form-control" value="{{ $asset->location }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi Tujuan</label>
                            <input type="text" name="new_location" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ditugaskan Kepada</label>
                            <input type="text" name="assigned_to" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Transfer</label>
                            <input type="date" name="transfer_date" class="form-control" value="{{ date('Y-m-d') }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alasan Transfer</label>
                            <textarea name="reason" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Transfer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Disposal Modal -->
    <div class="modal fade" id="disposalModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Disposal Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <p>Apakah Anda yakin ingin melakukan disposal pada asset berikut?</p>
                    <p>
                        <strong>Nama Asset:</strong> {{ $asset->name }}<br>
                        <strong>Kode Asset:</strong> {{ $asset->asset_code }}<br>
                        <strong>Nilai Saat Ini:</strong> {{ $asset->formatted_current_value }}
                    </p>
                    <form action="{{ route('assets.disposal', $asset->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <label class="form-label">Alasan Disposal</label>
                            <textarea name="disposal_reason" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Ya, Disposal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {

            .btn,
            .modal,
            .nav,
            .sidebar,
            .footer,
            .card-header .btn {
                display: none !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            body {
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
@endpush
