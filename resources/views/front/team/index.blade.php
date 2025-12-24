@extends('layouts.front')

@section('title', 'Tim Kami - Makmur Mandiri Medika')
@section('description', 'Kenali tim profesional PT. Makmur Mandiri Medika (PT3M) yang siap melayani kebutuhan peralatan kesehatan Anda.')

@section('content')
<!-- Page Header -->
<section class="page-header-section text-white text-center py-5" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('images/team_meeting.png') }}') no-repeat center center/cover;">
    <div class="container">
        <h1 class="display-4 fw-bold">Tim Kami</h1>
        <p class="lead mb-0">Dedikasi dan profesionalisme untuk pelayanan kesehatan terbaik</p>
    </div>
</section>

<!-- Founder Section -->
<section class="py-5" style="background-color: var(--soft-green);">
    <div class="container py-lg-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="position-relative">
                    <img src="{{ asset('images/founder.png') }}" 
                         alt="Sadriman Tanjung - Founder & CEO" 
                         class="img-fluid shadow-lg rounded-3 w-100"
                         style="object-fit: cover; min-height: 400px;">
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 text-center text-white" 
                         style="background: linear-gradient(to top, rgba(45, 125, 50, 0.9), transparent); border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
                        <h4 class="mb-0">Sadriman Tanjung</h4>
                        <small>Founder & CEO</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <h5 class="text-uppercase letter-spacing-2 mb-2 fw-bold" style="color: var(--primary-green); letter-spacing: 2px;">Founder & CEO of PT. Makmur Mandiri Medika (PT3M)</h5>
                <h2 class="display-5 fw-bold mb-4">Sadriman Tanjung</h2>
                
                <p class="lead text-muted mb-4">
                    Beliau memiliki pengalaman lebih dari 18 tahun dalam Bisnis Pemasaran Kesehatan. Perjalanan karirnya mencerminkan dedikasi yang mendalam pada industri ini.
                </p>
                <p class="text-secondary mb-4" style="line-height: 1.8;">
                    Pengalamannya bekerja dimulai dari <strong>PT. Dosniroha</strong>, kemudian melanjutkan karir di <strong>PT. Anugrah Argon Medika</strong>, dan menghabiskan lebih dari 15 tahun berkarya di <strong>PT. Enseval Medika Prima (Kalbe Group)</strong>. Bekal pengalaman panjang inilah yang menjadi fondasi kuat dalam membangun PT. Makmur Mandiri Medika.
                </p>
                
                <figure class="bg-white p-4 rounded-3 shadow-sm border-start border-5 border-success mt-4">
                    <blockquote class="blockquote mb-0">
                        <p class="fst-italic mb-0 text-dark">
                            "Kejujuran serta Rasa Tanggung Jawab adalah pintu sukses dalam mencapai tujuan bersama."
                        </p>
                    </blockquote>
                </figure>
            </div>
        </div>
    </div>
</section>

@if($events->count() > 0)
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3" style="color: var(--primary-green);">Bersama Mencapai Tujuan</h2>
                <p class="text-muted">Kekompakan dan integritas adalah kunci keberhasilan tim kami dalam melayani mitra kesehatan di seluruh Indonesia.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-3 shadow-lg">
                        @foreach($events as $key => $event)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="card border-0 overflow-hidden">
                                @if($event->image_path)
                                <img src="{{ Storage::url($event->image_path) }}" class="d-block w-100" alt="{{ $event->name }}" style="max-height: 500px; object-fit: cover;">
                                @else
                                <div class="d-block w-100 bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                                    <span class="text-muted">No Image Available</span>
                                </div>
                                @endif
                                <div class="card-footer bg-success text-white text-center py-3">
                                    <h5 class="mb-0 fw-bold">{{ $event->name }}</h5>
                                    @if($event->description)
                                    <p class="mb-0 small mt-1">{{ $event->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($events->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Management & Team Grid -->
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container col-xxl-10 px-4 py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title position-relative d-inline-block pb-2">Tim Kami</h2>
        </div>

        @php $hasMembers = false; @endphp

        @foreach($groupedMembers as $groupName => $members)
            @if($members->count() > 0)
                @php $hasMembers = true; @endphp
                <div class="mb-5">
                    <h3 class="fw-bold text-center mb-4" style="color: var(--dark-green);">{{ $groupName == 'Lainnya' ? 'Tim Lainnya' : $groupName }}</h3>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                        @foreach($members as $member)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm hover-card transition-all" style="border-radius: 15px;">
                                <div class="overflow-hidden position-relative" style="height: 320px; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                                    @if($member->photo_path)
                                        <img src="{{ Storage::url($member->photo_path) }}" 
                                             class="card-img-top w-100 h-100 object-fit-cover" 
                                             alt="{{ $member->name }}"
                                             style="object-position: top;">
                                    @else
                                        <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-secondary fa-5x"></i>
                                        </div>
                                    @endif
                                    <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-3" 
                                         style="background: linear-gradient(to top, rgba(45, 125, 50, 0.9) 0%, transparent 100%); opacity: 0; transition: opacity 0.3s;">
                                        <p class="text-white small mb-0">{{ Str::limit($member->bio ?? '', 100) }}</p>
                                    </div>
                                </div>
                                <div class="card-body text-center bg-white" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                                    <h5 class="card-title fw-bold mb-1 text-dark">{{ $member->name }}</h5>
                                    <!-- Position removed as requested -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if(!$hasMembers)
        <div class="text-center py-5">
            <div class="d-inline-block p-5 bg-white rounded-circle shadow-sm mb-3">
                <i class="fas fa-users fa-3x text-muted"></i>
            </div>
            <h4 class="text-muted">Tim segera hadir</h4>
        </div>
        @endif
    </div>
</section>

<!-- Careers Section -->
<section class="py-5" style="background-color: var(--white);">
    <div class="container col-xxl-10 px-4 py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title position-relative d-inline-block pb-2">Karir</h2>
            <p class="lead text-muted">Bergabunglah dengan tim profesional kami</p>
        </div>

        @if(isset($jobs) && $jobs->count() > 0)
        <div class="row g-4">
            @foreach($jobs as $job)
            <div class="col-12">
                <div class="card border-0 shadow-lg h-100 career-card" style="border-radius: 20px; overflow: hidden; transition: all 0.3s ease;">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h3 class="fw-bold mb-3" style="color: var(--primary-green);">
                                    <a href="{{ route('careers.show', $job->id) }}" 
                                       class="text-decoration-none" 
                                       style="color: var(--primary-green);">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <div class="mb-3">
                                    <span class="badge bg-success me-2" style="padding: 0.5rem 1rem;">
                                        <i class="fas fa-briefcase me-1"></i>{{ $job->department ?? 'Umum' }}
                                    </span>
                                    @if($job->closing_date)
                                        <span class="badge bg-warning text-dark" style="padding: 0.5rem 1rem;">
                                            <i class="fas fa-calendar me-1"></i>
                                            Tutup: {{ \Carbon\Carbon::parse($job->closing_date)->format('d M Y') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-muted mb-0">
                                    {!! Str::limit(strip_tags($job->description ?? ''), 200) !!}
                                </p>
                            </div>
                            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                                <a href="{{ route('careers.show', $job->id) }}" 
                                   class="btn btn-outline-primary btn-lg" 
                                   style="border-radius: 50px; padding: 0.75rem 2rem;">
                                    <i class="fas fa-arrow-right me-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm mx-auto" style="border-radius: 20px; padding: 3rem; max-width: 600px;">
                <i class="fas fa-briefcase fa-4x text-muted mb-4"></i>
                <h4 class="text-muted mb-2">Belum ada lowongan</h4>
                <p class="text-muted">Lowongan pekerjaan akan segera ditambahkan. Pantau terus halaman ini untuk kesempatan berkarir bersama kami.</p>
            </div>
        </div>
        @endif
    </div>
</section>

<style>
    .letter-spacing-2 { letter-spacing: 2px; }
    .hover-card:hover { transform: translateY(-10px); box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; }
    .hover-card:hover .overlay { opacity: 1 !important; }
    .career-card:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.15)!important; }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--primary-green);
        border-radius: 2px;
    }
</style>
@endsection
