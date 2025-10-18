@extends('layouts.app')

@section('content')
<div class="py-4">
	<h1 class="h3 mb-3">Kontak</h1>
	<div class="row g-4">
		<div class="col-md-6">
			@if(session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			<form method="post" action="{{ route('contact.store') }}">
				@csrf
				<div class="mb-3">
					<label class="form-label">Nama</label>
					<input type="text" name="name" class="form-control" value="{{ old('name') }}">
					@error('name')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="mb-3">
					<label class="form-label">Email</label>
					<input type="email" name="email" class="form-control" value="{{ old('email') }}">
					@error('email')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="mb-3">
					<label class="form-label">Pesan</label>
					<textarea name="message" class="form-control" rows="5">{{ old('message') }}</textarea>
					@error('message')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<button class="btn btn-primary">Kirim</button>
			</form>
		</div>
		<div class="col-md-6">
			@if($settings)
				<ul class="list-unstyled mb-3">
					@if($settings->address)<li><strong>Alamat:</strong> {{ $settings->address }}</li>@endif
					@if($settings->email)<li><strong>Email:</strong> {{ $settings->email }}</li>@endif
					@if($settings->phone)<li><strong>Telepon:</strong> {{ $settings->phone }}</li>@endif
					@if($settings->whatsapp_link)<li><strong>WhatsApp:</strong> <a href="{{ $settings->whatsapp_link }}" target="_blank">Hubungi via WhatsApp</a></li>@endif
				</ul>
				@if($settings->map_embed_url)
					<div class="ratio ratio-16x9">
						<iframe src="{{ $settings->map_embed_url }}" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
					</div>
				@endif
			@endif
		</div>
	</div>
</div>
@endsection
