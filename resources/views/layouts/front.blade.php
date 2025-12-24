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
            --white: #ffffff;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.12);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.16);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Navbar Modern */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            padding: 1rem 0;
        }

        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-green) !important;
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary-green);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }

        .nav-link:hover {
            color: var(--primary-green) !important;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        }

        .btn-outline-primary {
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--light-green) 0%, var(--primary-green) 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Hero Section */
        .hero-section {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 150px 0 120px;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(45, 125, 50, 0.85) 0%, rgba(0, 0, 0, 0.6) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
            animation: fadeInUp 0.8s ease;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.95);
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
            line-height: 1.8;
        }

        .hero-stats {
            margin-top: 3rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Timeline Styles */
        .timeline-container {
            position: relative;
            padding: 2rem 0;
        }

        .timeline-container::before {
            content: '';
            position: absolute;
            left: 30px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, var(--primary-green) 0%, var(--light-green) 100%);
        }

        .timeline-item {
            position: relative;
            padding-left: 80px;
            margin-bottom: 3rem;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .timeline-icon {
            width: 60px;
            height: 60px;
            background: white;
            border: 4px solid var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-green);
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(45, 125, 50, 0.2);
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .timeline-item:hover .timeline-icon {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(45, 125, 50, 0.3);
            background: var(--primary-green);
            color: white;
        }

        .timeline-content {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-green);
        }

        .timeline-item:hover .timeline-content {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            transform: translateX(5px);
        }

        .timeline-date {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .timeline-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 1rem;
        }

        .timeline-description {
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .timeline-quote {
            background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%);
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid var(--primary-green);
            font-style: italic;
            color: var(--text-dark);
            font-size: 1.05rem;
            line-height: 1.8;
            margin-top: 1rem;
        }

        .timeline-quote i {
            color: var(--primary-green);
            font-size: 1.2rem;
        }

        .timeline-achievement {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-top: 1rem;
        }

        .timeline-achievement h4 {
            color: white;
            font-weight: 600;
        }

        .timeline-achievement p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
        }

        .achievement-number {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            line-height: 1;
        }

        .achievement-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Page Header Styles */
        .page-header-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .page-header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .page-header-section .container {
            position: relative;
            z-index: 1;
        }

        .page-header-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .page-header-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.95);
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
            line-height: 1.6;
            margin-bottom: 0;
        }

        .page-header-stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .page-header-stat-card .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
            line-height: 1;
        }

        .page-header-stat-card .stat-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .page-header-stat-card i {
            color: white;
            filter: drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.3));
        }

        /* Page Breadcrumb */
        .page-breadcrumb {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            padding: 1rem 0;
        }

        .page-breadcrumb .breadcrumb {
            background: transparent;
            margin-bottom: 0;
        }

        .page-breadcrumb .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .page-breadcrumb .breadcrumb-item a:hover {
            color: white;
        }

        .page-breadcrumb .breadcrumb-item.active {
            color: white;
            font-weight: 600;
        }

        .page-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            padding: 0 0.5rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Section Title */
        .section-title {
            color: var(--primary-green);
            font-weight: 700;
            font-size: 2.5rem;
            position: relative;
            margin-bottom: 3rem;
            text-align: center;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--light-green) 0%, var(--primary-green) 100%);
            border-radius: 2px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            background: white;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .product-card {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
        }

        .product-card .card-img-top {
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .card-img-top {
            transform: scale(1.1);
        }

        .clickable-card {
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .clickable-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .clickable-card:hover .card-title {
            color: var(--primary-green) !important;
        }

        /* Product Detail */
        .product-detail-image {
            border-radius: 20px;
            transition: transform 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .product-detail-image:hover {
            transform: scale(1.05);
        }

        .product-info {
            padding: 20px 0;
        }

        .product-description {
            line-height: 1.8;
            color: var(--text-dark);
            font-size: 1.1rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 1rem 0;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: var(--text-light);
            font-size: 1.2rem;
        }

        .breadcrumb-item a {
            color: var(--primary-green);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--dark-green);
            text-decoration: underline;
        }

        /* Price */
        .price {
            color: var(--primary-green);
            font-weight: 700;
            font-size: 1.5rem;
        }

        /* Search Section */
        .search-section {
            background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%);
            padding: 80px 0;
            position: relative;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c3e50 100%);
            color: white;
            padding: 60px 0 30px;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--light-green) 0%, var(--primary-green) 100%);
        }

        .footer h5, .footer h6 {
            color: var(--light-green);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer a:hover {
            color: var(--light-green);
            transform: translateX(5px);
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 0.75rem;
        }

        /* Brand Logo */
        .brand-logo {
            max-height: 60px;
            width: auto;
            transition: all 0.3s ease;
        }

        .brand-logo:hover {
            transform: scale(1.1);
        }

        /* Social Media Links */
        .social-media-link {
            transition: all 0.3s ease;
        }

        .social-media-link:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.25) !important;
        }

        /* Badge */
        .badge {
            background: linear-gradient(135deg, var(--light-green) 0%, var(--primary-green) 100%);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
        }

        /* Form Controls */
        .form-control:focus {
            border-color: var(--light-green);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                background-attachment: scroll;
                min-height: 80vh;
                padding: 100px 0 80px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .stat-card {
                padding: 1rem 1.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .timeline-container::before {
                left: 20px;
            }

            .timeline-item {
                padding-left: 60px;
            }

            .timeline-marker {
                width: 40px;
                height: 40px;
            }

            .timeline-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
                border-width: 3px;
            }

            .timeline-content {
                padding: 1.5rem;
            }

            .timeline-title {
                font-size: 1.25rem;
            }

            .timeline-description {
                font-size: 1rem;
            }

            .achievement-number {
                font-size: 2.5rem;
            }

            .page-header-section {
                padding: 80px 0 60px;
            }

            .page-header-title {
                font-size: 2.5rem;
            }

            .page-header-subtitle {
                font-size: 1.1rem;
            }

            .page-header-stat-card {
                padding: 1.25rem;
            }

            .page-header-stat-card .stat-number {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Makmur Mandiri Medika" height="50" class="me-2">
                @elseif(file_exists(public_path('images/logo.jpg')))
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo Makmur Mandiri Medika" height="50" class="me-2">
                @elseif($settings && $settings->logo_path)
                    <img src="{{ Storage::url($settings->logo_path) }}" alt="Logo Makmur Mandiri Medika" height="50" class="me-2">
                @else
                    <i class="fas fa-heartbeat me-2" style="color: var(--primary-green); font-size: 1.5rem;"></i>
                @endif
                <span class="d-none d-md-inline">Makmur Mandiri Medika</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}" href="{{ route('history') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('team.*') || request()->routeIs('careers.*') ? 'active' : '' }}" href="{{ route('team.index') }}">Tim & Karir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">Kontak</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
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
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Makmur Mandiri Medika" height="60" class="mb-3">
                    @elseif(file_exists(public_path('images/logo.jpg')))
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Makmur Mandiri Medika" height="60" class="mb-3">
                    @elseif($settings && $settings->logo_path)
                        <img src="{{ Storage::url($settings->logo_path) }}" alt="Logo Makmur Mandiri Medika" height="60" class="mb-3">
                    @else
                        <h5 class="text-success mb-3">Makmur Mandiri Medika</h5>
                    @endif
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
                        <li class="mb-2"><a href="{{ route('team.index') }}">Tim & Karir</a></li>
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
            <!-- Social Media Links -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="text-success mb-3">Ikuti Kami</h6>
                    <div class="d-flex gap-3 flex-wrap">
                        @php
                            $instagramUrl = $settings->instagram_url ?? 'https://www.instagram.com/makmurmandirimedika/';
                            $facebookUrl = $settings->facebook_url ?? 'https://www.facebook.com/profile.php?id=61551806735128&sk=about';
                            $linkedinUrl = $settings->linkedin_url ?? 'https://www.linkedin.com/company/97402523/admin/feed/posts/';
                        @endphp
                        @if($instagramUrl)
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" 
                               class="social-media-link" 
                               style="display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 45px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); border-radius: 50%; color: white; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <i class="fab fa-instagram" style="font-size: 1.25rem;"></i>
                            </a>
                        @endif
                        @if($facebookUrl)
                            <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" 
                               class="social-media-link" 
                               style="display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 45px; background: #1877f2; border-radius: 50%; color: white; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <i class="fab fa-facebook-f" style="font-size: 1.25rem;"></i>
                            </a>
                        @endif
                        @if($linkedinUrl)
                            <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" 
                               class="social-media-link" 
                               style="display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 45px; background: #0077b5; border-radius: 50%; color: white; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <i class="fab fa-linkedin-in" style="font-size: 1.25rem;"></i>
                            </a>
                        @endif
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
        // Navbar scroll effect
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Fade in animation on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in-up');
                    }
                });
            }, observerOptions);

            // Observe all cards and sections
            document.querySelectorAll('.card, .section-title').forEach(el => {
                observer.observe(el);
            });

            // Search functionality
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
                console.log('Search:', searchTerm, 'Category:', selectedCategory);
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
