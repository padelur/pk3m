@extends('layouts.admin')

@section('title', 'Edit Brand - Makmur Mandiri Medika')
@section('page-title', 'Edit Brand')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Brand</h2>
        <p class="text-muted mb-0">Ubah data brand: {{ $brand->name }}</p>
    </div>
    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
<form method="post" action="{{ route('admin.brands.update', $brand) }}" enctype="multipart/form-data" class="card p-3">
	@csrf @method('PUT')
	<div class="mb-3">
		<label class="form-label">Nama</label>
		<input type="text" name="name" class="form-control" value="{{ old('name', $brand->name) }}" required>
		@error('name')<div class="text-danger small">{{ $message }}</div>@enderror
	</div>
	<div class="mb-3">
		<label class="form-label">Deskripsi</label>
		<textarea name="description" class="form-control" rows="4">{{ old('description', $brand->description) }}</textarea>
	</div>
	<div class="mb-3">
		<label class="form-label">Logo</label>
		<input type="file" name="logo" class="form-control" accept="image/*">
		@if($brand->logo_path)
			<small class="text-muted">Logo saat ini: <a href="{{ Storage::url($brand->logo_path) }}" target="_blank">lihat</a></small>
		@endif
		@error('logo')<div class="text-danger small">{{ $message }}</div>@enderror
	</div>
	<div>
		<a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
			<i class="fas fa-times me-2"></i>Batal
		</a>
		<button class="btn btn-primary">
			<i class="fas fa-save me-2"></i>Simpan Perubahan
		</button>
	</div>
</form>
@endsection
