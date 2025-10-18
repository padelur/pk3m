@extends('layouts.admin')

@section('title', 'Pengaturan Website - Makmur Mandiri Medika')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Pengaturan Website</h2>
        <p class="text-muted mb-0">Kelola konfigurasi website dan informasi perusahaan</p>
    </div>
    <a href="{{ route('admin.settings.edit') }}" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>Edit Pengaturan
    </a>
</div>
<div class="card">
	<div class="card-body">
		<dl class="row mb-0">
			<dt class="col-sm-3">Nama Perusahaan</dt><dd class="col-sm-9">{{ $setting->company_name ?? '-' }}</dd>
			<dt class="col-sm-3">Alamat</dt><dd class="col-sm-9">{{ $setting->address ?? '-' }}</dd>
			<dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $setting->email ?? '-' }}</dd>
			<dt class="col-sm-3">Telepon</dt><dd class="col-sm-9">{{ $setting->phone ?? '-' }}</dd>
			<dt class="col-sm-3">WhatsApp</dt><dd class="col-sm-9">{{ $setting->whatsapp_link ?? '-' }}</dd>
			<dt class="col-sm-3">Katalog PDF</dt><dd class="col-sm-9">@if($setting && $setting->catalog_pdf_path)<a href="{{ Storage::url($setting->catalog_pdf_path) }}" target="_blank">Lihat</a>@else - @endif</dd>
			<dt class="col-sm-3">Map Embed URL</dt><dd class="col-sm-9">{{ $setting->map_embed_url ?? '-' }}</dd>
		</dl>
	</div>
</div>
@endsection
