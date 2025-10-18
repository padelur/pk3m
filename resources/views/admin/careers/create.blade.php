@extends('layouts.admin')

@section('title', 'Tambah Lowongan - Makmur Mandiri Medika')
@section('page-title', 'Tambah Lowongan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Tambah Lowongan Kerja</h2>
        <p class="text-muted mb-0">Tambahkan lowongan kerja baru</p>
    </div>
    <a href="{{ route('admin.careers.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
<form method="post" action="{{ route('admin.careers.store') }}" class="card p-3">
	@csrf
	<div class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Judul</label>
			<input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
			@error('title')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-3">
			<label class="form-label">Status</label>
			<select name="status" class="form-select">
				<option value="open" @selected(old('status')==='open')>open</option>
				<option value="closed" @selected(old('status')==='closed')>closed</option>
			</select>
		</div>
		<div class="col-md-3">
			<label class="form-label">Tanggal Penutupan</label>
			<input type="date" name="closing_date" class="form-control" value="{{ old('closing_date') }}">
		</div>
		<div class="col-12">
			<label class="form-label">Deskripsi</label>
			<textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
		</div>
		<div class="col-12">
			<label class="form-label">Persyaratan</label>
			<textarea name="requirements" class="form-control" rows="5">{{ old('requirements') }}</textarea>
		</div>
	</div>
	<div class="mt-3">
		<a href="{{ route('admin.careers.index') }}" class="btn btn-secondary">
			<i class="fas fa-times me-2"></i>Batal
		</a>
		<button class="btn btn-primary">
			<i class="fas fa-save me-2"></i>Simpan
		</button>
	</div>
</form>
@endsection
