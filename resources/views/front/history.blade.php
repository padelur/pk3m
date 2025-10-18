@extends('layouts.app')

@section('content')
<div class="py-4">
	<h1 class="h3 mb-3">Sejarah Perusahaan</h1>
	<p>PT 3M didirikan dengan visi menghadirkan produk unggulan dan layanan terbaik untuk pelanggan di seluruh Indonesia. (Isi narasi sejarah di sini.)</p>
	@if($settings && $settings->catalog_pdf_path)
		<p class="mt-3"><a href="{{ Storage::url($settings->catalog_pdf_path) }}" class="btn btn-outline-primary" target="_blank">Unduh Katalog PDF</a></p>
	@endif
</div>
@endsection
