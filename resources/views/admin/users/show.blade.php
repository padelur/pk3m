@extends('layouts.admin')

@section('title', 'Detail Admin - Makmur Mandiri Medika')
@section('page-title', 'Detail Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Detail Admin</h2>
        <p class="text-muted mb-0">Informasi lengkap admin: {{ $user->name }}</p>
    </div>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Admin</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Nama Lengkap</strong></td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Role</strong></td>
                        <td>
                            <span class="badge bg-{{ $user->isSuperAdmin() ? 'danger' : 'primary' }}">
                                {{ $user->isSuperAdmin() ? 'Super Admin' : 'Admin' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Dibuat</strong></td>
                        <td>{{ $user->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Terakhir Diupdate</strong></td>
                        <td>{{ $user->updated_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Data
                    </a>
                    @if(!$user->isSuperAdmin())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Hapus Admin
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
