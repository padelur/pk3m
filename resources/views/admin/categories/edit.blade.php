@extends('layouts.admin')

@section('title', 'Edit Kategori - Makmur Mandiri Medika')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Kategori</h2>
        <p class="text-muted mb-0">Ubah data kategori: {{ $category->name }}</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
<form method="post" action="{{ route('admin.categories.update', $category) }}" class="card p-3">
	@csrf @method('PUT')
	<div class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Nama</label>
			<input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
			@error('name')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-md-6">
			<label class="form-label">Brand</label>
			<select name="brand_id" class="form-select" required>
				@foreach($brands as $b)
					<option value="{{ $b->id }}" @selected(old('brand_id', $category->brand_id)==$b->id)>{{ $b->name }}</option>
				@endforeach
			</select>
			@error('brand_id')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="col-12">
			<label class="form-label">Deskripsi</label>
			<textarea name="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
		</div>
	</div>
	<div class="mt-3">
		<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
			<i class="fas fa-times me-2"></i>Batal
		</a>
		<button class="btn btn-primary">
			<i class="fas fa-save me-2"></i>Simpan Perubahan
		</button>
	</div>
</form>
@endsection
