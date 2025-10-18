<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Makmur Mandiri Medika - Solution for Medical Devices')</title>
    <meta name="description" content="@yield('description', 'PT. Makmur Mandiri Medika (PT3M) menyediakan solusi lengkap untuk alat medis berkualitas tinggi.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-green: #2d7d32;
            --light-green: #4caf50;
            --soft-green: #e8f5e8;
            --dark-green: #1b5e20;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-green) !important;
        }

        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
        }

        .btn-outline-primary {
            color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%);
            padding: 80px 0;
        }

        .section-title {
            color: var(--primary-green);
            font-weight: 600;
            position: relative;
            margin-bottom: 2rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--light-green);
        }

        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .product-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .clickable-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .clickable-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .clickable-card:hover .card-title {
            color: var(--primary-green) !important;
        }

        /* Product Detail Styles */
        .product-detail-image {
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .product-detail-image:hover {
            transform: scale(1.02);
        }

        .product-info {
            padding: 20px 0;
        }

        .product-description {
            line-height: 1.8;
            color: var(--text-dark);
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: var(--text-light);
        }

        .breadcrumb-item a {
            color: var(--primary-green);
        }

        .breadcrumb-item a:hover {
            color: var(--dark-green);
        }

        .price {
            color: var(--primary-green);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .search-section {
            background-color: var(--soft-green);
            padding: 40px 0;
        }

        .footer {
            background-color: var(--text-dark);
            color: white;
            padding: 40px 0 20px;
        }

        .footer a {
            color: #adb5bd;
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--light-green);
        }

        .brand-logo {
            max-height: 60px;
            width: auto;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .badge {
            background-color: var(--light-green);
        }

        .form-control:focus {
            border-color: var(--light-green);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .btn-success {
            background-color: var(--light-green);
            border-color: var(--light-green);
        }

        .btn-success:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                @if($settings && $settings->logo_path)
                    <img src="{{ Storage::url($settings->logo_path) }}" alt="Logo" height="40" class="me-2">
                @else
                    <i class="fas fa-heartbeat me-2 text-success"></i>
                @endif
                <span>Makmur Mandiri Medika</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('history') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index') }}">Kontak</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-success mb-3">Makmur Mandiri Medika</h5>
                    <p class="mb-3">Solution for Medical Devices</p>
                    @if($settings && $settings->address)
                        <p class="small mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $settings->address }}
                        </p>
                    @endif
                    @if($settings && $settings->phone)
                        <p class="small mb-2">
                            <i class="fas fa-phone me-2"></i>
                            {{ $settings->phone }}
                        </p>
                    @endif
                    @if($settings && $settings->email)
                        <p class="small mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            {{ $settings->email }}
                        </p>
                    @endif
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="text-success mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}">Produk</a></li>
                        <li class="mb-2"><a href="{{ route('history') }}">Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('contact.index') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="text-success mb-3">Kategori Produk</h6>
                    <ul class="list-unstyled">
                        @foreach($categories ?? [] as $category)
                            <li class="mb-2">
                                <a href="{{ route('products.index', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="text-success mb-3">Brand Kami</h6>
                    <div class="row g-2">
                        @foreach($brands ?? [] as $brand)
                            <div class="col-6">
                                @if($brand->logo_path)
                                    <img src="{{ Storage::url($brand->logo_path) }}" alt="{{ $brand->name }}" class="brand-logo img-fluid">
                                @else
                                    <div class="small text-center">{{ $brand->name }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="small mb-0">&copy; {{ date('Y') }} PT. Makmur Mandiri Medika. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="small mb-0">Solution for Medical Devices</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script>
        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('productSearch');
            const categoryFilter = document.getElementById('categoryFilter');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    filterProducts();
                });
            }

            if (categoryFilter) {
                categoryFilter.addEventListener('change', function() {
                    filterProducts();
                });
            }

            function filterProducts() {
                const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
                const selectedCategory = categoryFilter ? categoryFilter.value : '';

                // This would typically make an AJAX request to filter products
                // For now, we'll just show all products
                console.log('Search:', searchTerm, 'Category:', selectedCategory);
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
