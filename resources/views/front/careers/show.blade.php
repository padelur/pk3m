@extends('layouts.front')

@section('title', $job->title . ' - Karir - Makmur Mandiri Medika')
@section('description', Str::limit(strip_tags($job->description ?? ''), 160))

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="page-breadcrumb">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('careers.index') }}" class="text-decoration-none">Karir</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $job->title }}</li>
        </ol>
    </div>
</nav>

<!-- Job Detail Section -->
<section class="py-6" style="padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="mb-4">
                    <a href="{{ route('team.index') }}" class="btn btn-outline-secondary" style="border-radius: 50px;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Tim & Karir
                    </a>
                </div>

                <div class="card border-0 shadow-lg mb-4" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5">
                        <h1 class="display-6 fw-bold mb-4" style="color: var(--primary-green);">{{ $job->title }}</h1>
                        
                        <div class="mb-4">
                            @if($job->department)
                                <span class="badge bg-success me-2" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                    <i class="fas fa-building me-1"></i>{{ $job->department }}
                                </span>
                            @endif
                            @if($job->closing_date)
                                <span class="badge bg-warning text-dark" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                    <i class="fas fa-calendar me-1"></i>
                                    Tutup: {{ \Carbon\Carbon::parse($job->closing_date)->format('d M Y') }}
                                </span>
                            @endif
                            @if($job->status === 'open')
                                <span class="badge bg-primary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                    <i class="fas fa-check-circle me-1"></i>Dibuka
                                </span>
                            @endif
                        </div>

                        @if($job->description)
                        <div class="mb-5">
                            <h3 class="fw-bold mb-3" style="color: var(--primary-green);">
                                <i class="fas fa-info-circle me-2"></i>Deskripsi Pekerjaan
                            </h3>
                            <div class="text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                                {!! nl2br(e($job->description)) !!}
                            </div>
                        </div>
                        @endif

                        @if($job->requirements)
                        <div class="mb-4">
                            <h3 class="fw-bold mb-3" style="color: var(--primary-green);">
                                <i class="fas fa-list-check me-2"></i>Persyaratan
                            </h3>
                            <div class="text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                                {!! nl2br(e($job->requirements)) !!}
                            </div>
                        </div>
                        @endif

                        @if($job->location)
                        <div class="mb-4">
                            <h3 class="fw-bold mb-3" style="color: var(--primary-green);">
                                <i class="fas fa-map-marker-alt me-2"></i>Lokasi
                            </h3>
                            <p class="text-muted mb-0" style="font-size: 1.05rem;">{{ $job->location }}</p>
                        </div>
                        @endif

                        @if($job->salary_range)
                        <div class="mb-4">
                            <h3 class="fw-bold mb-3" style="color: var(--primary-green);">
                                <i class="fas fa-money-bill-wave me-2"></i>Kisaran Gaji
                            </h3>
                            <p class="text-muted mb-0" style="font-size: 1.05rem;">{{ $job->salary_range }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%);">
                    <div class="card-body p-5 text-center">
                        <h4 class="fw-bold mb-3" style="color: var(--primary-green);">Tertarik dengan posisi ini?</h4>
                        <p class="text-muted mb-4">Kirim lamaran Anda melalui email atau hubungi kami untuk informasi lebih lanjut</p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            @if($job->recruitment_link)
                                <a href="{{ $job->recruitment_link }}" 
                                   target="_blank" 
                                   class="btn btn-primary btn-lg" 
                                   style="border-radius: 50px; padding: 0.75rem 2rem;">
                                    <i class="fas fa-paper-plane me-2"></i>Lamar Sekarang
                                </a>
                            @else
                                @if($settings && $settings->email)
                                    <a href="mailto:{{ $settings->email }}?subject=Lamaran: {{ $job->title }}" 
                                       class="btn btn-primary btn-lg" 
                                       style="border-radius: 50px; padding: 0.75rem 2rem;">
                                        <i class="fas fa-envelope me-2"></i>Kirim Email
                                    </a>
                                @endif
                                @if($settings && $settings->whatsapp_link)
                                    <a href="{{ $settings->whatsapp_link }}" 
                                       target="_blank" 
                                       class="btn btn-success btn-lg" 
                                       style="border-radius: 50px; padding: 0.75rem 2rem;">
                                        <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
