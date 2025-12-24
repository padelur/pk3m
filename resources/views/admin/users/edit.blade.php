@extends('layouts.admin')

@section('title', 'Edit Admin - Makmur Mandiri Medika')
@section('page-title', 'Edit Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Admin</h2>
        <p class="text-muted mb-0">Ubah data admin: {{ $user->name }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.users.update', $user) }}" class="card p-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    @if(!$user->isSuperAdmin())
    <div class="mb-3">
        <div class="form-check">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Aktif</label>
        </div>
        <small class="text-muted">Nonaktifkan untuk mencegah admin login</small>
    </div>
    @endif

    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
@endsection
