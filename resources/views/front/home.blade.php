@extends('layouts.front')

@section('title', 'Makmur Mandiri Medika - Solution for Medical Devices')
@section('description', 'PT. Makmur Mandiri Medika (PT3M) menyediakan solusi lengkap untuk alat medis berkualitas tinggi dengan berbagai produk consumable, instrument, dan laboratory.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-success mb-3">Solution for Medical Devices</h1>
                <p class="lead mb-4">PT. Makmur Mandiri Medika menyediakan solusi lengkap untuk kebutuhan alat medis berkualitas tinggi dengan standar internasional.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-box me-2"></i>Lihat Produk
                    </a>
                    @if($settings && $settings->catalog_pdf_path)
                        <a href="{{ Storage::url($settings->catalog_pdf_path) }}" target="_blank" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-download me-2"></i>Unduh Katalog
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                     class="img-fluid rounded-3 shadow-lg" alt="Medical Devices" style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="search-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-center mb-4">Cari Produk Medis Anda</h2>
                <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0"
                                   placeholder="Cari produk berdasarkan nama atau kategori..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select" id="categoryFilter">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Produk Unggulan Kami</h2>
        <div class="row g-4">
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
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($product->description, 100) }}
                        </p>
                        @if($product->size)
                            <p class="small text-muted mb-2">
                                <i class="fas fa-ruler me-1"></i>Ukuran: {{ $product->size }}
                            </p>
                        @endif
                        @if($product->price)
                            <p class="price mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        @endif
                        <div class="mt-auto">
                            @if($product->e_catalog_url)
                                <a href="{{ $product->e_catalog_url }}" target="_blank" class="btn btn-success w-100">
                                    <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                                </a>
                            @else
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                </a>
                            @endif
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

<div class="section-soft py-4">
	<h2 class="section-title h4 mb-3">Katalog Produk</h2>
	<div class="row g-3">
		<div class="col-md-6">
			<div class="card h-100">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div>
						<div class="h6 mb-1">Katalog Produk Instrument PT3M 2025</div>
						<div class="text-muted small">PDF</div>
					</div>
					@if($settings && $settings->catalog_pdf_path)
						<a href="{{ Storage::url($settings->catalog_pdf_path) }}" class="btn btn-success" target="_blank">Unduh</a>
					@else
						<a href="#" class="btn btn-success disabled">Tidak tersedia</a>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card h-100">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div>
						<div class="h6 mb-1">Katalog Produk Consumable PT3M 2024</div>
						<div class="text-muted small">PDF</div>
					</div>
					<a href="#" class="btn btn-success disabled">Segera</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Brands Section -->
<section class="py-5" style="background-color: var(--soft-green);">
    <div class="container">
        <h2 class="section-title text-center mb-5">Brand Terpercaya Kami</h2>
        <div class="row g-4">
            @foreach($brands as $brand)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card h-100 text-center p-4 border-0" style="background-color: white;">
                    @if($brand->logo_path)
                        <img src="{{ Storage::url($brand->logo_path) }}" class="img-fluid mb-3 brand-logo" alt="{{ $brand->name }}" style="max-height: 80px;">
                    @else
                        <div class="fw-semibold text-success mb-3">{{ $brand->name }}</div>
                    @endif
                    @if($brand->description)
                        <p class="small text-muted">{{ Str::limit($brand->description, 80) }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="section-title mb-4">Hubungi Kami</h2>
                <p class="lead mb-4">Kami siap membantu kebutuhan alat medis Anda dengan solusi terbaik.</p>

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
