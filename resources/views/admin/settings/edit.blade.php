@extends('layouts.admin')

@section('title', 'Edit Pengaturan - Makmur Mandiri Medika')
@section('page-title', 'Edit Pengaturan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Pengaturan Website</h2>
        <p class="text-muted mb-0">Ubah konfigurasi website dan informasi perusahaan</p>
    </div>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
<form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="card p-3">
	@csrf @method('PUT')
	<div class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Nama Perusahaan</label>
			<input type="text" name="company_name" class="form-control" value="{{ old('company_name', $setting->company_name ?? '') }}">
		</div>
		<div class="col-md-6">
			<label class="form-label">Email</label>
			<input type="email" name="email" class="form-control" value="{{ old('email', $setting->email ?? '') }}">
		</div>
		<div class="col-md-6">
			<label class="form-label">Telepon</label>
			<input type="text" name="phone" class="form-control" value="{{ old('phone', $setting->phone ?? '') }}">
		</div>
		<div class="col-md-6">
			<label class="form-label">WhatsApp Link</label>
			<input type="url" name="whatsapp_link" class="form-control" value="{{ old('whatsapp_link', $setting->whatsapp_link ?? '') }}">
		</div>
		<div class="col-md-4">
			<label class="form-label">Instagram URL</label>
			<input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $setting->instagram_url ?? '') }}" placeholder="https://www.instagram.com/...">
		</div>
		<div class="col-md-4">
			<label class="form-label">Facebook URL</label>
			<input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $setting->facebook_url ?? '') }}" placeholder="https://www.facebook.com/...">
		</div>
		<div class="col-md-4">
			<label class="form-label">LinkedIn URL</label>
			<input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $setting->linkedin_url ?? '') }}" placeholder="https://www.linkedin.com/...">
		</div>
		<div class="col-12">
			<label class="form-label">Alamat</label>
			<textarea name="address" class="form-control" rows="3">{{ old('address', $setting->address ?? '') }}</textarea>
		</div>
		<div class="col-md-6">
			<label class="form-label">Katalog PDF</label>
			<input type="file" name="catalog_pdf" class="form-control" accept="application/pdf">
			@if(!empty($setting?->catalog_pdf_path))
				<small class="text-muted">Saat ini: <a href="{{ Storage::url($setting->catalog_pdf_path) }}" target="_blank">lihat</a></small>
			@endif
		</div>
		<div class="col-md-6">
			<label class="form-label">Map Embed URL</label>
			<input type="url" name="map_embed_url" class="form-control" value="{{ old('map_embed_url', $setting->map_embed_url ?? '') }}">
		</div>
	</div>
	<div class="mt-3">
		<a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
			<i class="fas fa-times me-2"></i>Batal
		</a>
		<button class="btn btn-primary">
			<i class="fas fa-save me-2"></i>Simpan Perubahan
		</button>
	</div>
</form>
@endsection
