@extends('layouts.admin')

@section('title', 'Input Stok Manual - Makmur Mandiri Medika')
@section('page-title', 'Input Stok Manual')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Input Stok Manual</h2>
        <p class="text-muted mb-0">Input stok berdasarkan invoice pembelian</p>
    </div>
    <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.stocks.store') }}" class="card p-4">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="product_id" class="form-label">Produk *</label>
            <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                <option value="">Pilih Produk</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} - Stok: {{ $product->stock }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="quantity" class="form-label">Jumlah Stok *</label>
            <input type="number" name="quantity" id="quantity" 
                   class="form-control @error('quantity') is-invalid @enderror"
                   value="{{ old('quantity') }}" min="1" required>
            @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="invoice_number" class="form-label">Nomor Invoice</label>
            <input type="text" name="invoice_number" id="invoice_number" 
                   class="form-control @error('invoice_number') is-invalid @enderror"
                   value="{{ old('invoice_number') }}" placeholder="INV-2024-001">
            @error('invoice_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 mb-3">
            <label for="description" class="form-label">Keterangan</label>
            <textarea name="description" id="description" rows="3" 
                      class="form-control @error('description') is-invalid @enderror"
                      placeholder="Contoh: Pembelian dari supplier ABC berdasarkan invoice INV-2024-001">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        Stok produk akan otomatis bertambah sesuai jumlah yang diinput. Perubahan ini akan tercatat di log stok.
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Stok</button>
    </div>
</form>
@endsection

