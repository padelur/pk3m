@extends('layouts.admin')

@section('title', 'Dashboard Admin - Makmur Mandiri Medika')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">Selamat datang, {{ auth()->user()->name }}! 👋</h2>
                        <p class="text-muted mb-0">Kelola website Makmur Mandiri Medika dengan mudah melalui dashboard admin.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ now()->format('d F Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-primary me-3">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <h3 class="stats-number">{{ $stats['total_products'] }}</h3>
                    <p class="stats-label">Total Produk</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-success me-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3 class="stats-number">{{ $stats['active_products'] }}</h3>
                    <p class="stats-label">Produk Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-info me-3">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="stats-number">{{ $stats['total_categories'] }}</h3>
                    <p class="stats-label">Kategori</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-warning me-3">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <h3 class="stats-number">{{ $stats['total_brands'] }}</h3>
                    <p class="stats-label">Brand</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Products -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-box me-2"></i>Produk Terbaru
                    </h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($recent_products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Brand</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->image_path)
                                            <img src="{{ Storage::url($product->image_path) }}"
                                                 class="rounded me-2" width="40" height="40"
                                                 style="object-fit: cover;" alt="{{ $product->name }}">
                                        @else
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $product->name }}</h6>
                                            @if($product->price)
                                                <small class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($product->brand)
                                        <span class="badge bg-light text-dark">{{ $product->brand->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->category)
                                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $product->created_at->format('d/m/Y') }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada produk</h6>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Tambah Produk
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Users -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Produk
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-tag me-2"></i>Tambah Kategori
                    </a>
                    <a href="{{ route('admin.brands.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-star me-2"></i>Tambah Brand
                    </a>
                    @if(auth()->user()->isSuperAdmin())
                    <a href="{{ route('admin.users.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-user-plus me-2"></i>Tambah Admin
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        @if(auth()->user()->isSuperAdmin())
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>Admin Terbaru
                    </h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($recent_users->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($recent_users as $user)
                    <div class="list-group-item px-0 border-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="badge bg-{{ $user->isSuperAdmin() ? 'danger' : 'primary' }}">
                                    {{ $user->isSuperAdmin() ? 'Super Admin' : 'Admin' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-3">
                    <i class="fas fa-users fa-2x text-muted mb-2"></i>
                    <h6 class="text-muted">Belum ada admin</h6>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
