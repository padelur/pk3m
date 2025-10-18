@extends('layouts.admin')

@section('title', 'Edit Produk - Makmur Mandiri Medika')
@section('page-title', 'Edit Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Produk</h2>
        <p class="text-muted mb-0">Ubah data produk: {{ $product->name }}</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
<form method="post" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="card p-3">
	@csrf
	@method('PUT')
	<div class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Nama</label>
			<input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
			@error('name')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-3">
			<label class="form-label">Brand</label>
			<select name="brand_id" class="form-select" required>
				@foreach($brands as $b)
					<option value="{{ $b->id }}" @selected(old('brand_id', $product->brand_id)==$b->id)>{{ $b->name }}</option>
				@endforeach
			</select>
			@error('brand_id')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-3">
			<label class="form-label">Kategori</label>
			<select name="category_id" class="form-select" required>
				@foreach($categories as $c)
					<option value="{{ $c->id }}" @selected(old('category_id', $product->category_id)==$c->id)>{{ $c->name }}</option>
				@endforeach
			</select>
			@error('category_id')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-12">
			<label class="form-label">Deskripsi</label>
			<textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
			@error('description')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-6">
			<label class="form-label">Ukuran</label>
			<input type="text" name="size" value="{{ old('size', $product->size) }}" class="form-control" placeholder="Contoh: 10x15 cm, L, M, S">
			@error('size')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-6">
			<label class="form-label">Link e-Katalog</label>
			<input type="url" name="e_catalog_url" value="{{ old('e_catalog_url', $product->e_catalog_url) }}" class="form-control" placeholder="https://example.com">
			@error('e_catalog_url')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-3">
			<label class="form-label">Harga (opsional)</label>
			<input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="form-control">
			@error('price')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-3">
			<label class="form-label">Stok</label>
			<input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control" required>
			@error('stock')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-3">
			<label class="form-label">Gambar</label>
			<input type="file" name="image" class="form-control" accept="image/*">
			@if($product->image_path)
				<small class="text-muted">Gambar saat ini: <a href="{{ Storage::url($product->image_path) }}" target="_blank">lihat</a></small>
			@endif
			@error('image')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-3">
			<label class="form-label">File PDF</label>
			<input type="file" name="pdf" class="form-control" accept="application/pdf">
			@if($product->pdf_path)
				<small class="text-muted">PDF saat ini: <a href="{{ Storage::url($product->pdf_path) }}" target="_blank">unduh</a></small>
			@endif
			@error('pdf')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $product->is_active))>
				<label class="form-check-label" for="is_active">Aktif</label>
			</div>
		</div>
	</div>
	<div class="mt-3">
		<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
			<i class="fas fa-times me-2"></i>Batal
		</a>
		<button class="btn btn-primary">
			<i class="fas fa-save me-2"></i>Simpan Perubahan
		</button>
	</div>
</form>
@endsection
