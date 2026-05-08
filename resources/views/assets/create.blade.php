@extends('layouts.app')

@section('title', 'Register Asset Baru')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-plus-square"></i> Register Asset Baru
            </h1>
            <a href="{{ route('assets.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-building"></i> Form Registrasi Asset
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('assets.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Kiri -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Asset <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Contoh: Laptop Dell XPS 13" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="asset_code" class="form-label">Kode Asset <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('asset_code') is-invalid @enderror"
                                    id="asset_code" name="asset_code" value="{{ old('asset_code') }}"
                                    placeholder="Contoh: AST-2024-001" required>
                                @error('asset_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kode unik untuk identifikasi asset</small>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category"
                                    name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="elektronik" {{ old('category') == 'elektronik' ? 'selected' : '' }}>
                                        Elektronik</option>
                                    <option value="furniture" {{ old('category') == 'furniture' ? 'selected' : '' }}>
                                        Furniture</option>
                                    <option value="kendaraan" {{ old('category') == 'kendaraan' ? 'selected' : '' }}>
                                        Kendaraan</option>
                                    <option value="mesin" {{ old('category') == 'mesin' ? 'selected' : '' }}>Mesin &
                                        Peralatan</option>
                                    <option value="it" {{ old('category') == 'it' ? 'selected' : '' }}>IT & Hardware
                                    </option>
                                    <option value="others" {{ old('category') == 'others' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                    id="location" name="location" value="{{ old('location') }}"
                                    placeholder="Contoh: Gedung A Lt. 3, Ruang IT" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Aktif)
                                    </option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                        Maintenance (Perbaikan)</option>
                                    <option value="disposed" {{ old('status') == 'disposed' ? 'selected' : '' }}>Disposed
                                        (Dihapus)</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kanan -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="purchase_date" class="form-label">Tanggal Pembelian <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('purchase_date') is-invalid @enderror"
                                    id="purchase_date" name="purchase_date"
                                    value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="purchase_price" class="form-label">Harga Pembelian <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('purchase_price') is-invalid @enderror"
                                        id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}"
                                        placeholder="0" min="0" required>
                                </div>
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="current_value" class="form-label">Nilai Saat Ini <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                        class="form-control @error('current_value') is-invalid @enderror"
                                        id="current_value" name="current_value" value="{{ old('current_value') }}"
                                        placeholder="0" min="0" required>
                                </div>
                                @error('current_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Nilai asset setelah penyusutan</small>
                            </div>

                            <div class="mb-3">
                                <label for="assigned_to" class="form-label">Ditugaskan Kepada</label>
                                <input type="text" class="form-control @error('assigned_to') is-invalid @enderror"
                                    id="assigned_to" name="assigned_to" value="{{ old('assigned_to') }}"
                                    placeholder="Nama karyawan/departemen">
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Full Width -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Spesifikasi, merk, serial number, dll">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Catatan penting lainnya">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Asset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto generate asset code based on category and date
        document.getElementById('category').addEventListener('change', function() {
            const category = this.value;
            const date = new Date();
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');

            if (category && !document.getElementById('asset_code').value) {
                let prefix = '';
                switch (category) {
                    case 'elektronik':
                        prefix = 'ELE';
                        break;
                    case 'furniture':
                        prefix = 'FUR';
                        break;
                    case 'kendaraan':
                        prefix = 'VHC';
                        break;
                    case 'mesin':
                        prefix = 'MCH';
                        break;
                    case 'it':
                        prefix = 'IT';
                        break;
                    default:
                        prefix = 'AST';
                }
                const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                document.getElementById('asset_code').value = `${prefix}-${year}${month}-${random}`;
            }
        });

        // Auto calculate depreciation
        document.getElementById('purchase_price').addEventListener('input', function() {
            const purchasePrice = parseFloat(this.value) || 0;
            const currentValue = document.getElementById('current_value');
            if (!currentValue.value) {
                currentValue.value = purchasePrice;
            }
        });
    </script>
@endpush
