@extends('layouts.admin')

@section('title', 'Tambah Anggota Tim - Makmur Mandiri Medika')
@section('page-title', 'Tambah Anggota Tim')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Tambah Anggota Tim</h2>
        <p class="text-muted mb-0">Tambahkan anggota tim baru</p>
    </div>
    <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
<form method="post" action="{{ route('admin.teams.store') }}" enctype="multipart/form-data" class="card p-3">
	@csrf
	<div class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Nama</label>
			<input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
			@error('name')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-6">
			<label class="form-label">Divisi</label>
			<select name="division" class="form-select" required>
				<option value="">-- Pilih Divisi --</option>
				<option value="Manajemen" {{ old('division') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
				<option value="Marketing Executive" {{ old('division') == 'Marketing Executive' ? 'selected' : '' }}>Marketing Executive</option>
				<option value="Back Office" {{ old('division') == 'Back Office' ? 'selected' : '' }}>Back Office</option>
				<option value="Head Support" {{ old('division') == 'Head Support' ? 'selected' : '' }}>Head Support</option>
			</select>
			@error('division')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-12">
			<label class="form-label">Deskripsi</label>
			<textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
		</div>
		<div class="col-md-6">
			<label class="form-label">Foto</label>
			<input type="file" name="photo" class="form-control" accept="image/*">
			@error('photo')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
	</div>
	<div class="mt-3">
		<a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">
			<i class="fas fa-times me-2"></i>Batal
		</a>
		<button class="btn btn-primary">
			<i class="fas fa-save me-2"></i>Simpan
		</button>
	</div>
</form>
@endsection
