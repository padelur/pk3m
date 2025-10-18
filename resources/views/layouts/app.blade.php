<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="{{ asset('css/theme.css') }}" rel="stylesheet">

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 d-flex flex-column">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="container py-4">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-4 flex-fill">
                <div class="container">
                    @yield('content')
                </div>
            </main>

            <footer class="site-footer mt-4 py-4">
                <div class="container">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="fw-bold">PT. MAKMUR MANDIRI MEDIKA (PT3M)</div>
                            <small>Jl. Pendidikan, Komplek Pesona Cilebut 1 Blok. B2 No.3, Sukaraja, Bogor</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="{{ route('home') }}" class="me-3">Beranda</a>
                            <a href="{{ route('history') }}" class="me-3">Sejarah</a>
                            <a href="{{ route('products.index') }}" class="me-3">Produk</a>
                            <a href="{{ route('careers.index') }}" class="me-3">Karir</a>
                            <a href="{{ route('contact.index') }}">Kontak</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
