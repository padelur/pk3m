@extends('layouts.front')

@section('title', 'Tentang Kami - Makmur Mandiri Medika')
@section('description', 'Tentang PT. Makmur Mandiri Medika (PT3M) - Sejarah, Visi, dan Misi perusahaan penyedia peralatan kesehatan terpercaya di Indonesia.')

@section('content')
<!-- Page Header -->
<section class="page-header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="page-header-title">Tentang Kami</h1>
                <p class="page-header-subtitle">
                    PT. Makmur Mandiri Medika (PT3M) - Solusi Terpercaya untuk Peralatan Kesehatan
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Sejarah Section -->
<section class="py-6" style="padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2 class="section-title mb-5">
                    <i class="fas fa-history me-3 text-success"></i>Sejarah Perusahaan
                </h2>

                <!-- Timeline -->
                <div class="timeline-container">
                    <!-- Timeline Item 1: Pendirian -->
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <div class="timeline-icon">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">14 Agustus 2019</div>
                            <h3 class="timeline-title">Pendirian Perusahaan</h3>
                            <p class="timeline-description">
                                <strong>PT. Makmur Mandiri Medika (PT3M)</strong> didirikan di <strong>Kota Pariaman - Sumatera Barat</strong>.
                                Bergerak di bidang <strong>Penyediaan dan Distribusi Peralatan Kesehatan</strong> yang meliputi wilayah Indonesia.
                            </p>
                            <div class="timeline-quote">
                                <i class="fas fa-quote-left"></i>
                                PT. Makmur Mandiri Medika berdiri atas dasar solusi dari kebutuhan peralatan kesehatan.
                                <i class="fas fa-quote-right"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Item 2: Kantor Perdana -->
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <div class="timeline-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">2019</div>
                            <h3 class="timeline-title">Kantor Perdana</h3>
                            <p class="timeline-description">
                                Beroperasi dari <strong>Kota Pariaman, Sumatera Barat</strong> sebagai kantor pertama dan pusat operasional awal perusahaan.
                            </p>
                        </div>
                    </div>

                    <!-- Timeline Item 3: Perluasan Operasional -->
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <div class="timeline-icon">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </div>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">2020 - Sekarang</div>
                            <h3 class="timeline-title">Perluasan Operasional</h3>
                            <p class="timeline-description">
                                Perusahaan berkembang dengan membuka <strong>Representative Office di Bogor, Jawa Barat</strong>
                                sambil mempertahankan <strong>Head Office di Pariaman, Sumatera Barat</strong>.
                            </p>
                        </div>
                    </div>

                    <!-- Timeline Item 4: Ekspansi Wilayah -->
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <div class="timeline-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">2020 - Sekarang</div>
                            <h3 class="timeline-title">Ekspansi Area Cakupan</h3>
                            <p class="timeline-description">
                                Area cakupan kerja meliputi seluruh wilayah <strong>Sumatera</strong>:
                            </p>
                            <div class="row g-2 mt-3">
                                <div class="col-md-6">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Lampung</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Sumatera Selatan</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Jambi</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Sumatera Barat</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Riau</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Kepulauan Riau</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Sumatera Utara</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Aceh</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Item 5: Pencapaian -->
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <div class="timeline-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-date">Sekarang</div>
                            <h3 class="timeline-title">Pencapaian</h3>
                            <div class="timeline-achievement">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="mb-2">Lebih dari <strong>10.000</strong> transaksi penjualan</h4>
                                        <p class="mb-0">Data tersebut terus tumbuh dengan bertambahnya kepercayaan customer terhadap pelayanan prima kami.</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="achievement-number">10K+</div>
                                        <small class="achievement-label">Transaksi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="py-6" style="background: linear-gradient(to bottom, #ffffff 0%, var(--soft-green) 100%); padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <h2 class="section-title">Visi & Misi</h2>
        <div class="row g-4">
            <!-- Visi -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-eye text-success fa-3x"></i>
                            </div>
                        </div>
                        <h3 class="text-center mb-4 fw-bold" style="color: var(--primary-green);">Visi</h3>
                        <p class="text-center lead" style="font-size: 1.1rem; line-height: 1.8; color: var(--text-dark);">
                            Menjadi perusahaan penyedia dan distributor peralatan kesehatan terdepan di Indonesia yang dikenal dengan kualitas produk, pelayanan prima, dan komitmen terhadap kesehatan masyarakat.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Misi -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-bullseye text-success fa-3x"></i>
                            </div>
                        </div>
                        <h3 class="text-center mb-4 fw-bold" style="color: var(--primary-green);">Misi</h3>
                        <ul class="list-unstyled" style="font-size: 1.05rem; line-height: 2;">
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Menyediakan produk peralatan kesehatan berkualitas tinggi dengan standar internasional
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Memberikan pelayanan prima kepada seluruh customer di seluruh wilayah Indonesia
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Mengembangkan jaringan distribusi yang luas dan efisien
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Membangun kepercayaan melalui transparansi dan komitmen terhadap kualitas
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Berkontribusi dalam meningkatkan aksesibilitas peralatan kesehatan di Indonesia
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lokasi Kantor Section -->
<section class="py-6" style="padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <h2 class="section-title">Lokasi Kantor</h2>
        <div class="row g-4">
            <!-- Representative Office -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-map-marker-alt text-success fa-2x"></i>
                            </div>
                            <h4 class="mb-0 fw-bold" style="color: var(--primary-green);">Representative Office</h4>
                        </div>
                        <div class="ms-4">
                            <p class="mb-2" style="font-size: 1.05rem; line-height: 1.8;">
                                <strong>PT. MAKMUR MANDIRI MEDIKA (PT3M)</strong>
                            </p>
                            <p class="mb-0" style="color: var(--text-dark); line-height: 1.8;">
                                Jl. Pendidikan, Komplek Pesona Cilebut 1 Blok. B2, No. 3<br>
                                Kel. Sukaraja, Kec. Sukaraja, Kab. Bogor<br>
                                Jawa Barat - Indonesia
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Head Office -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-building text-success fa-2x"></i>
                            </div>
                            <h4 class="mb-0 fw-bold" style="color: var(--primary-green);">Head Office</h4>
                        </div>
                        <div class="ms-4">
                            <p class="mb-2" style="font-size: 1.05rem; line-height: 1.8;">
                                <strong>PT. MAKMUR MANDIRI MEDIKA (PT3M)</strong>
                            </p>
                            <p class="mb-0" style="color: var(--text-dark); line-height: 1.8;">
                                Jl. Imam Bonjol, Kel. Cimparuh<br>
                                Kec. Pariaman Tengah, Kota Pariaman 25517<br>
                                Sumatera Barat - Indonesia
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="py-6" style="background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%); padding-top: 5rem !important; padding-bottom: 5rem !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5 text-center">
                        <h3 class="mb-4 fw-bold" style="color: var(--primary-green);">Hubungi Kami</h3>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-4">
                                    <i class="fas fa-envelope text-success fa-3x mb-3"></i>
                                    <h5 class="mb-2">Email</h5>
                                    <p class="mb-0">
                                        <a href="mailto:makmurmandirimedika@pt3m.co.id" class="text-decoration-none" style="color: var(--text-dark);">
                                            makmurmandirimedika@pt3m.co.id
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4">
                                    <i class="fas fa-phone text-success fa-3x mb-3"></i>
                                    <h5 class="mb-2">Telepon</h5>
                                    <p class="mb-0">
                                        <a href="tel:07514784177" class="text-decoration-none" style="color: var(--text-dark);">
                                            0751-4784177
                                        </a>
                                    </p>
                                    <p class="mb-0 mt-2">
                                        <a href="tel:+6281372121044" class="text-decoration-none" style="color: var(--text-dark);">
                                            +62 813-7212-1044
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg" style="border-radius: 50px;">
                                <i class="fas fa-envelope me-2"></i>Kirim Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
@endsection
