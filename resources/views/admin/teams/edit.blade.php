@extends('layouts.admin')

@section('title', 'Edit Anggota Tim - Makmur Mandiri Medika')
@section('page-title', 'Edit Anggota Tim')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Anggota Tim</h2>
        <p class="text-muted mb-0">Ubah data anggota: {{ $team->name }}</p>
    </div>
    <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
<form method="post" action="{{ route('admin.teams.update', $team) }}" enctype="multipart/form-data" class="card p-3">
	@csrf @method('PUT')
	<div class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Nama</label>
			<input type="text" name="name" class="form-control" value="{{ old('name', $team->name) }}" required>
			@error('name')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-6">
			<label class="form-label">Jabatan</label>
			<input type="text" name="position" class="form-control" value="{{ old('position', $team->position) }}" required>
			@error('position')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-12">
			<label class="form-label">Deskripsi</label>
			<textarea name="description" class="form-control" rows="4">{{ old('description', $team->description) }}</textarea>
		</div>
		<div class="col-md-6">
			<label class="form-label">Foto</label>
			<input type="file" name="photo" class="form-control" accept="image/*">
			@if($team->photo_path)
				<small class="text-muted">Foto saat ini: <a href="{{ Storage::url($team->photo_path) }}" target="_blank">lihat</a></small>
			@endif
			@error('photo')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
	</div>
	<div class="mt-3">
		<a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">
			<i class="fas fa-times me-2"></i>Batal
		</a>
		<button class="btn btn-primary">
			<i class="fas fa-save me-2"></i>Simpan Perubahan
		</button>
	</div>
</form>
@endsection
