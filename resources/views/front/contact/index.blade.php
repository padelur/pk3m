@extends('layouts.front')

@section('title', 'Kontak - Makmur Mandiri Medika')
@section('description', 'Hubungi PT. Makmur Mandiri Medika (PT3M) untuk informasi produk dan layanan peralatan kesehatan.')

@section('content')
<!-- Page Header -->
<section class="page-header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="page-header-title">Hubungi Kami</h1>
                <p class="page-header-subtitle">
                    Kami siap membantu kebutuhan alat medis Anda dengan solusi terbaik
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-6" style="padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5">
                        <h2 class="mb-4 fw-bold" style="color: var(--primary-green);">Kirim Pesan</h2>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form method="post" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" 
                                       placeholder="Masukkan nama Anda" required
                                       style="border-radius: 10px; padding: 0.75rem 1rem;">
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" 
                                       placeholder="nama@email.com" required
                                       style="border-radius: 10px; padding: 0.75rem 1rem;">
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Pesan <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="5" 
                                          placeholder="Tulis pesan Anda di sini..." required
                                          style="border-radius: 10px; padding: 0.75rem 1rem;">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100" style="border-radius: 50px;">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5">
                        <h2 class="mb-4 fw-bold" style="color: var(--primary-green);">Informasi Kontak</h2>
                        
                        @if($settings)
                            <div class="row g-4">
                                @if($settings->address)
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-map-marker-alt text-success"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fw-bold mb-1">Alamat</h6>
                                            <p class="mb-0 text-muted">{{ $settings->address }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($settings->phone)
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-phone text-success"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fw-bold mb-1">Telepon</h6>
                                            <p class="mb-0">
                                                <a href="tel:{{ $settings->phone }}" class="text-decoration-none text-muted">
                                                    {{ $settings->phone }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($settings->email)
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-envelope text-success"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fw-bold mb-1">Email</h6>
                                            <p class="mb-0">
                                                <a href="mailto:{{ $settings->email }}" class="text-decoration-none text-muted">
                                                    {{ $settings->email }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($settings->whatsapp_link)
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fab fa-whatsapp text-success"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fw-bold mb-1">WhatsApp</h6>
                                            <a href="{{ $settings->whatsapp_link }}" target="_blank" class="btn btn-success btn-sm">
                                                <i class="fab fa-whatsapp me-1"></i>Hubungi via WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            @if($settings->map_embed_url)
                            <div class="mt-4">
                                <h6 class="fw-bold mb-3">Lokasi Kami</h6>
                                <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow">
                                    <iframe src="{{ $settings->map_embed_url }}" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                </div>
                            </div>
                            @endif
                        @else
                            <p class="text-muted">Informasi kontak belum tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
