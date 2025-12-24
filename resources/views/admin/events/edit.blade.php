@extends('layouts.admin')

@section('title', 'Edit Event - Makmur Mandiri Medika')
@section('page-title', 'Edit Event')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Event</h2>
        <p class="text-muted mb-0">Ubah data event: {{ $event->name }}</p>
    </div>
    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form method="post" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="card p-3">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">Nama Event</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
            @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', $event->date) }}">
            @error('date')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Gambar Event</label>
            @if($event->image_path)
                <div class="mb-2">
                    <img src="{{ Storage::url($event->image_path) }}" alt="Preview" style="height: 100px;" class="rounded">
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
            <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>
            @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description', $event->description) }}</textarea>
            @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
            <i class="fas fa-times me-2"></i>Batal
        </a>
        <button class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Simpan Perubahan
        </button>
    </div>
</form>
@endsection
