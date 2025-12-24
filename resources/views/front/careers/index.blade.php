@extends('layouts.front')

@section('title', 'Karir - Makmur Mandiri Medika')
@section('description', 'Bergabunglah dengan tim PT. Makmur Mandiri Medika (PT3M). Lihat lowongan pekerjaan yang tersedia.')

@section('content')
<!-- Page Header -->
<section class="page-header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="page-header-title">Karir</h1>
                <p class="page-header-subtitle">
                    Bergabunglah dengan tim profesional kami dan kembangkan karir Anda
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Careers Section -->
<section class="py-6" style="padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        @if($jobs->count() > 0)
        <div class="row g-4">
            @foreach($jobs as $job)
            <div class="col-12">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; overflow: hidden; transition: all 0.3s ease;">
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
                                   class="btn btn-primary btn-lg" 
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

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $jobs->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; padding: 3rem;">
                <i class="fas fa-briefcase fa-4x text-muted mb-4"></i>
                <h4 class="text-muted mb-2">Belum ada lowongan</h4>
                <p class="text-muted">Lowongan pekerjaan akan segera ditambahkan</p>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
