@extends('layouts.front')

@section('title', 'Produk - Makmur Mandiri Medika')
@section('description', 'Lihat semua produk alat medis berkualitas tinggi dari Makmur Mandiri Medika. Berbagai kategori produk untuk kebutuhan medis Anda.')

@section('content')
<!-- Page Header -->
<section class="py-5" style="background-color: var(--soft-green);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-success mb-3">Produk Kami</h1>
                <p class="lead mb-0">Solusi lengkap untuk kebutuhan alat medis berkualitas tinggi</p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="text-muted">
                    <i class="fas fa-box me-2"></i>
                    {{ $products->total() }} Produk Tersedia
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-4 bg-white">
    <div class="container">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="Cari produk..." value="{{ $search }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="brand" class="form-select">
                    <option value="">Semua Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->slug }}" {{ $brandSlug == $brand->slug ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                </div>
            </div>
        </form>

        @if($search || $categoryId || $brandSlug)
        <div class="mt-3">
            <div class="d-flex flex-wrap gap-2">
                @if($search)
                    <span class="badge bg-primary">
                        Pencarian: "{{ $search }}"
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-white ms-1">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if($categoryId)
                    @php $selectedCategory = $categories->firstWhere('id', $categoryId) @endphp
                    <span class="badge bg-success">
                        Kategori: {{ $selectedCategory->name }}
                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="text-white ms-1">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if($brandSlug)
                    @php $selectedBrand = $brands->firstWhere('slug', $brandSlug) @endphp
                    <span class="badge bg-info">
                        Brand: {{ $selectedBrand->name }}
                        <a href="{{ request()->fullUrlWithQuery(['brand' => null]) }}" class="text-white ms-1">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-refresh me-1"></i>Reset Filter
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Products Grid -->
<section class="py-5">
    <div class="container">
        @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                    <div class="card product-card h-100 clickable-card">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image text-muted fa-3x"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0 text-dark">{{ $product->name }}</h5>
                                @if($product->brand)
                                    <span class="badge bg-light text-dark">{{ $product->brand->name }}</span>
                                @endif
                            </div>

                            @if($product->category)
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                </p>
                            @endif

                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($product->description, 120) }}
                            </p>

                            @if($product->size)
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-ruler me-1"></i>Ukuran: {{ $product->size }}
                                </p>
                            @endif

                            @if($product->price)
                                <p class="price mb-3 text-success fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @endif

                            <div class="mt-auto">
                                @if($product->e_catalog_url)
                                    <a href="{{ $product->e_catalog_url }}" target="_blank" class="btn btn-success w-100" onclick="event.stopPropagation();">
                                        <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                                    </a>
                                @else
                                    <div class="text-center">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Klik untuk melihat detail
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Produk tidak ditemukan</h4>
            <p class="text-muted">Coba gunakan kata kunci atau filter yang berbeda</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="fas fa-refresh me-2"></i>Lihat Semua Produk
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
