@extends('layouts.admin')

@section('title', 'Sesuaikan Stok - Makmur Mandiri Medika')
@section('page-title', 'Sesuaikan Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Sesuaikan Stok</h2>
        <p class="text-muted mb-0">{{ $product->name }}</p>
    </div>
    <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>Informasi Produk</h5>
        <table class="table table-borderless">
            <tr>
                <th width="150">Nama Produk</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $product->category->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Stok Saat Ini</th>
                <td><strong class="h5">{{ $product->stock }}</strong></td>
            </tr>
        </table>
    </div>
</div>

<form method="POST" action="{{ route('admin.stocks.update', $product) }}" class="card p-4">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="stock" class="form-label">Stok Baru *</label>
            <input type="number" name="stock" id="stock" 
                   class="form-control @error('stock') is-invalid @enderror"
                   value="{{ old('stock', $product->stock) }}" min="0" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Stok saat ini: <strong>{{ $product->stock }}</strong></small>
        </div>

        <div class="col-12 mb-3">
            <label for="description" class="form-label">Keterangan Penyesuaian</label>
            <textarea name="description" id="description" rows="3" 
                      class="form-control @error('description') is-invalid @enderror"
                      placeholder="Jelaskan alasan penyesuaian stok">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Perhatian:</strong> Perubahan stok akan tercatat di log dengan tipe "Adjustment".
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Penyesuaian</button>
    </div>
</form>
@endsection

