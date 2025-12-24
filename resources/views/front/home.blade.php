@extends('layouts.front')

@section('title', 'Makmur Mandiri Medika - Solution for Medical Devices')
@section('description', 'PT. Makmur Mandiri Medika (PT3M) menyediakan solusi lengkap untuk alat medis berkualitas tinggi dengan berbagai produk consumable, instrument, dan laboratory.')

@section('content')
<!-- Hero Section -->
@php
    $heroImage = null;
    if (file_exists(public_path('images/hero-image.jpg'))) {
        $heroImage = asset('images/hero-image.jpg');
    } elseif (file_exists(public_path('images/hero-image.png'))) {
        $heroImage = asset('images/hero-image.png');
    } else {
        $heroImage = 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80';
    }
@endphp
<section class="hero-section" style="background-image: url('{{ $heroImage }}');">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8 text-center hero-content">
                <h1 class="hero-title">Solution for Medical Devices</h1>
                <p class="lead mb-4 hero-subtitle">
                    PT. Makmur Mandiri Medika menyediakan solusi lengkap untuk kebutuhan alat medis berkualitas tinggi dengan standar internasional.
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center mb-5">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-box me-2"></i>Lihat Produk
                    </a>
                    @if($settings && $settings->catalog_pdf_path)
                        <a href="{{ Storage::url($settings->catalog_pdf_path) }}" target="_blank" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-download me-2"></i>Unduh Katalog
                        </a>
                    @endif
                </div>
                <div class="row g-4 justify-content-center hero-stats">
                    <div class="col-auto">
                        <div class="stat-card">
                            <h3 class="stat-number">{{ $products->count() ?? 0 }}+</h3>
                            <small class="stat-label">Produk Tersedia</small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-card">
                            <h3 class="stat-number">{{ $categories->count() ?? 0 }}+</h3>
                            <small class="stat-label">Kategori Produk</small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-card">
                            <h3 class="stat-number">{{ $brands->count() ?? 0 }}+</h3>
                            <small class="stat-label">Brand Terpercaya</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="search-section" style="padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg" style="border-radius: 20px; padding: 2rem;">
                    <h2 class="text-center mb-4" style="color: var(--primary-green); font-weight: 700;">
                        <i class="fas fa-search me-2"></i>Cari Produk Medis Anda
                    </h2>
                    <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group" style="border-radius: 50px; overflow: hidden; box-shadow: var(--shadow-sm);">
                                <span class="input-group-text bg-white border-0" style="padding-left: 1.5rem;">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-0"
                                       placeholder="Cari produk berdasarkan nama atau kategori..."
                                       value="{{ request('search') }}"
                                       style="padding: 1rem 1.5rem;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="category" class="form-select" id="categoryFilter"
                                    style="border-radius: 50px; padding: 1rem 1.5rem; box-shadow: var(--shadow-sm); border: none;">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 50px; padding: 0.75rem 3rem;">
                                <i class="fas fa-search me-2"></i>Cari Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-6" style="background: linear-gradient(to bottom, #ffffff 0%, var(--soft-green) 100%); padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <h2 class="section-title">Produk Kami</h2>
        <p class="text-center text-muted mb-5" style="font-size: 1.1rem;">Temukan produk alat medis berkualitas tinggi untuk kebutuhan Anda</p>
        <div class="row g-4 justify-content-center">
            @forelse($featuredProducts as $product)
            <div class="col-lg-4 col-md-6">
                <div class="card product-card h-100">
                    @if($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image text-muted fa-3x"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        @if($product->category)
                            <p class="small text-muted mb-2">
                                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                            </p>
                        @endif
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($product->description ?? '', 100) }}
                        </p>
                        <div class="mt-auto">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada produk</h4>
                    <p class="text-muted">Produk akan segera ditambahkan</p>
                </div>
            </div>
            @endforelse
        </div>
        @if($featuredProducts->count() > 0)
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-arrow-right me-2"></i>Lihat Semua Produk
            </a>
        </div>
        @endif
    </div>
</section>



<!-- Brands Section -->
<section class="py-6" style="background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%); padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <h2 class="section-title">Brand Kami</h2>
        <p class="text-center text-muted mb-5" style="font-size: 1.1rem;">Bekerja sama dengan brand terkemuka di industri medis</p>
        <div class="row g-4 justify-content-center">
            @foreach($brands as $brand)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card h-100 text-center p-4 border-0 shadow-sm" style="background-color: white; border-radius: 15px;">
                    @if($brand->logo_path)
                        <img src="{{ Storage::url($brand->logo_path) }}" class="img-fluid mb-3" alt="{{ $brand->name }}" style="max-height: 100px; transition: all 0.3s ease; object-fit: contain; filter: none !important;">
                    @else
                        <div class="fw-bold text-success mb-3" style="font-size: 1.1rem;">{{ $brand->name }}</div>
                    @endif
                    @if($brand->description)
                        <p class="small text-muted mb-0">{{ Str::limit($brand->description, 80) }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-6" style="background: linear-gradient(to bottom, #ffffff 0%, var(--soft-green) 100%); padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <h2 class="section-title">Hubungi Kami</h2>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="lead mb-4" style="font-size: 1.2rem; color: var(--text-dark);">Kami siap membantu kebutuhan alat medis Anda dengan solusi terbaik.</p>

                <div class="row g-3">
                    @if($settings && $settings->address)
                    <div class="col-12">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-success fa-lg"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Alamat</h6>
                                <p class="mb-0 text-muted">{{ $settings->address }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($settings && $settings->phone)
                    <div class="col-12">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-phone text-success fa-lg"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Telepon</h6>
                                <p class="mb-0 text-muted">{{ $settings->phone }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($settings && $settings->email)
                    <div class="col-12">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-envelope text-success fa-lg"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Email</h6>
                                <p class="mb-0 text-muted">{{ $settings->email }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($settings && $settings->whatsapp_link)
                    <div class="col-12">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="fab fa-whatsapp text-success fa-lg"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">WhatsApp</h6>
                                <a href="{{ $settings->whatsapp_link }}" target="_blank" class="btn btn-success btn-sm">
                                    <i class="fab fa-whatsapp me-1"></i>Hubungi Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                @if($settings && $settings->map_embed_url)
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow">
                    <iframe src="{{ $settings->map_embed_url }}" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                @else
                <div class="bg-light rounded-3 p-5 text-center">
                    <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Peta Lokasi</h5>
                    <p class="text-muted">Peta akan ditampilkan di sini</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
