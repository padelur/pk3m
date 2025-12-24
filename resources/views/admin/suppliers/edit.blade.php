@extends('layouts.admin')

@section('title', 'Edit Supplier - Makmur Mandiri Medika')
@section('page-title', 'Edit Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Supplier</h2>
        <p class="text-muted mb-0">Ubah data supplier: {{ $supplier->name }}</p>
    </div>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}" class="card p-4">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Nama Supplier *</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $supplier->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">Nomor Telepon</label>
            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $supplier->phone) }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $supplier->email) }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-check mt-4">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                       {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Aktif</label>
            </div>
        </div>

        <div class="col-12 mb-3">
            <label for="address" class="form-label">Alamat</label>
            <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $supplier->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 mb-3">
            <label for="notes" class="form-label">Catatan</label>
            <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $supplier->notes) }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
@endsection

