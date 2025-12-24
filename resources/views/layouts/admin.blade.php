<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard - Makmur Mandiri Medika')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Admin CSS -->
    <style>
        :root {
            --primary-green: #2d7d32;
            --light-green: #4caf50;
            --soft-green: #e8f5e8;
            --dark-green: #1b5e20;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .sidebar-brand:hover {
            color: white;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 0;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0;
        }

        .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
            border-right: 3px solid var(--light-green);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .nav-dropdown {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .nav-dropdown .nav-link {
            padding-left: 3rem;
            font-size: 0.9rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Header */
        .admin-header {
            background: white;
            height: var(--header-height);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--text-dark);
            cursor: pointer;
            display: none;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-dark);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-radius: 10px;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            border-radius: 10px 10px 0 0 !important;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
        }

        .btn-success {
            background-color: var(--light-green);
            border-color: var(--light-green);
        }

        .btn-success:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .content-area {
                padding: 1rem;
            }

            .admin-header {
                padding: 0 1rem;
            }
        }

        /* Badge */
        .badge {
            font-size: 0.75rem;
        }

        /* Table */
        .table {
            background: white;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40" style="filter: brightness(0) invert(1);">
                @elseif(file_exists(public_path('images/logo.jpg')))
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" height="40" style="filter: brightness(0) invert(1);">
                @elseif($settings && $settings->logo_path)
                    <img src="{{ Storage::url($settings->logo_path) }}" alt="Logo" height="40" style="filter: brightness(0) invert(1);">
                @else
                    <i class="fas fa-heartbeat"></i>
                @endif
                <span>Admin Panel</span>
            </a>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- MASTER DATA -->
                <li class="nav-item mt-3">
                    <div class="nav-link text-uppercase small fw-bold" style="opacity: 0.7; cursor: default;">
                        <span>Master Data</span>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.brands.index') }}" class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                        <i class="fas fa-star"></i>
                        <span>Brand</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                        <i class="fas fa-truck"></i>
                        <span>Supplier</span>
                    </a>
                </li>

                <!-- INVENTORY SYSTEM -->
                <li class="nav-item mt-3">
                    <div class="nav-link text-uppercase small fw-bold" style="opacity: 0.7; cursor: default;">
                        <span>Inventaris & Stok</span>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.purchase-orders.index') }}" class="nav-link {{ request()->routeIs('admin.purchase-orders.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i>
                        <span>Purchase Order</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.stocks.index') }}" class="nav-link {{ request()->routeIs('admin.stocks.index') || request()->routeIs('admin.stocks.create') || request()->routeIs('admin.stocks.show') || request()->routeIs('admin.stocks.edit') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i>
                        <span>Manajemen Stok</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.stocks.logs') }}" class="nav-link {{ request()->routeIs('admin.stocks.logs') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Stok</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.stock-outs.index') }}" class="nav-link {{ request()->routeIs('admin.stock-outs.*') ? 'active' : '' }}">
                        <i class="fas fa-arrow-up"></i>
                        <span>Stok Keluar</span>
                    </a>
                </li>

                <!-- COMPANY PROFILE -->
                <li class="nav-item mt-3">
                    <div class="nav-link text-uppercase small fw-bold" style="opacity: 0.7; cursor: default;">
                        <span>Company Profile</span>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.teams.index') }}" class="nav-link {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Tim</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.careers.index') }}" class="nav-link {{ request()->routeIs('admin.careers.*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i>
                        <span>Karir</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Event</span>
                    </a>
                </li>

                <!-- SYSTEM ADMIN -->
                 <li class="nav-item mt-3">
                    <div class="nav-link text-uppercase small fw-bold" style="opacity: 0.7; cursor: default;">
                        <span>System</span>
                    </div>
                </li>
                @if(auth()->user()->isSuperAdmin())
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Manajemen Admin</span>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>

                <li class="nav-item mt-3">
                    <a href="{{ route('home') }}" class="nav-link" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        <span>Lihat Website</span>
                    </a>
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                        <small class="text-muted">
                            {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : 'Admin' }}
                        </small>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
