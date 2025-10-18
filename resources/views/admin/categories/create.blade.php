@extends('layouts.admin')

@section('title', 'Tambah Kategori - Makmur Mandiri Medika')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Tambah Kategori Baru</h2>
        <p class="text-muted mb-0">Tambahkan kategori produk baru</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
<form method="post" action="{{ route('admin.categories.store') }}" class="card p-3">
	@csrf
	<div class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Nama</label>
			<input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
			@error('name')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-6">
			<label class="form-label">Brand</label>
			<select name="brand_id" class="form-select" required>
				<option value="">Pilih</option>
				@foreach($brands as $b)
					<option value="{{ $b->id }}" @selected(old('brand_id')==$b->id)>{{ $b->name }}</option>
				@endforeach
			</select>
			@error('brand_id')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-12">
			<label class="form-label">Deskripsi</label>
			<textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
		</div>
	</div>
	<div class="mt-3">
		<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
			<i class="fas fa-times me-2"></i>Batal
		</a>
		<button class="btn btn-primary">
			<i class="fas fa-save me-2"></i>Simpan
		</button>
	</div>
</form>
@endsection
