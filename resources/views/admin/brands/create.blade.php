@extends('layouts.admin')

@section('title', 'Tambah Brand - Makmur Mandiri Medika')
@section('page-title', 'Tambah Brand')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Tambah Brand Baru</h2>
        <p class="text-muted mb-0">Tambahkan brand produk baru</p>
    </div>
    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
<form method="post" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data" class="card p-3">
	@csrf
	<div class="mb-3">
		<label class="form-label">Nama</label>
		<input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
		@error('name')<div class="text-danger small">{{ $message }}</div>@enderror
	</div>
	<div class="mb-3">
		<label class="form-label">Deskripsi</label>
		<textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
	</div>
	<div class="mb-3">
		<label class="form-label">Logo</label>
		<input type="file" name="logo" class="form-control" accept="image/*">
		@error('logo')<div class="text-danger small">{{ $message }}</div>@enderror
	</div>
	<div>
		<a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
			<i class="fas fa-times me-2"></i>Batal
		</a>
		<button class="btn btn-primary">
			<i class="fas fa-save me-2"></i>Simpan
		</button>
	</div>
</form>
@endsection
