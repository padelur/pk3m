@extends('layouts.front')

@section('title', $product->name . ' - Makmur Mandiri Medika')
@section('description', Str::limit($product->description, 160))

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="page-breadcrumb">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </div>
</nav>

<!-- Product Detail -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="product-image-container">
                    @if($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}"
                             class="img-fluid rounded shadow-sm product-detail-image"
                             alt="{{ $product->name }}"
                             style="width: 100%; height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded shadow-sm d-flex align-items-center justify-content-center"
                             style="height: 400px;">
                            <div class="text-center">
                                <i class="fas fa-image text-muted fa-4x mb-3"></i>
                                <p class="text-muted">Gambar tidak tersedia</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <h1 class="display-6 fw-bold text-dark mb-3">{{ $product->name }}</h1>

                    <!-- Brand & Category -->
                    <div class="mb-3">
                        @if($product->brand)
                            <span class="badge bg-primary me-2">
                                <i class="fas fa-star me-1"></i>{{ $product->brand->name }}
                            </span>
                        @endif
                        @if($product->category)
                            <span class="badge bg-success">
                                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Price -->
                    @if($product->price)
                        <div class="mb-4">
                            <h3 class="text-success fw-bold mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                        </div>
                    @endif

                    <!-- Size -->
                    @if($product->size)
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Ukuran</h6>
                            <p class="mb-0">{{ $product->size }}</p>
                        </div>
                    @endif

                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Deskripsi Produk</h6>
                        <div class="product-description">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex">
                        @if($product->e_catalog_url)
                            <a href="{{ $product->e_catalog_url }}" target="_blank" class="btn btn-success btn-lg flex-fill">
                                <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                            </a>
                        @endif
                        @if($product->pdf_path)
                            <a href="{{ Storage::url($product->pdf_path) }}" target="_blank" class="btn btn-outline-primary btn-lg flex-fill">
                                <i class="fas fa-download me-2"></i>Download Katalog
                            </a>
                        @endif
                    </div>

                    <!-- Back Button -->
                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
