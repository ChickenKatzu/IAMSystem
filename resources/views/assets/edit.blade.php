@extends('layouts.app')

@section('title', 'Edit Asset - ' . $asset->name)

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-pencil-square"></i> Edit Asset
            </h1>
            <a href="{{ route('assets.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-building"></i> Form Edit Asset
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('assets.update', $asset->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Asset <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $asset->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kode Asset <span class="text-danger">*</span></label>
                                <input type="text" name="asset_code"
                                    class="form-control @error('asset_code') is-invalid @enderror"
                                    value="{{ old('asset_code', $asset->asset_code) }}" required>
                                @error('asset_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror"
                                    required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="elektronik"
                                        {{ old('category', $asset->category) == 'elektronik' ? 'selected' : '' }}>Elektronik
                                    </option>
                                    <option value="furniture"
                                        {{ old('category', $asset->category) == 'furniture' ? 'selected' : '' }}>Furniture
                                    </option>
                                    <option value="kendaraan"
                                        {{ old('category', $asset->category) == 'kendaraan' ? 'selected' : '' }}>Kendaraan
                                    </option>
                                    <option value="mesin"
                                        {{ old('category', $asset->category) == 'mesin' ? 'selected' : '' }}>Mesin &
                                        Peralatan</option>
                                    <option value="it"
                                        {{ old('category', $asset->category) == 'it' ? 'selected' : '' }}>IT & Hardware
                                    </option>
                                    <option value="others"
                                        {{ old('category', $asset->category) == 'others' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" name="location"
                                    class="form-control @error('location') is-invalid @enderror"
                                    value="{{ old('location', $asset->location) }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ditugaskan Kepada</label>
                                <input type="text" name="assigned_to" class="form-control"
                                    value="{{ old('assigned_to', $asset->assigned_to) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active"
                                        {{ old('status', $asset->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="maintenance"
                                        {{ old('status', $asset->status) == 'maintenance' ? 'selected' : '' }}>Maintenance
                                    </option>
                                    <option value="disposed"
                                        {{ old('status', $asset->status) == 'disposed' ? 'selected' : '' }}>Disposed
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pembelian <span class="text-danger">*</span></label>
                                <input type="date" name="purchase_date"
                                    class="form-control @error('purchase_date') is-invalid @enderror"
                                    value="{{ old('purchase_date', $asset->purchase_date->format('Y-m-d')) }}" required>
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Harga Pembelian <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="purchase_price"
                                        class="form-control @error('purchase_price') is-invalid @enderror"
                                        value="{{ old('purchase_price', $asset->purchase_price) }}" required>
                                </div>
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nilai Saat Ini <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="current_value"
                                        class="form-control @error('current_value') is-invalid @enderror"
                                        value="{{ old('current_value', $asset->current_value) }}" required>
                                </div>
                                @error('current_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Nilai asset setelah penyusutan</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description', $asset->description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $asset->notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Asset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
