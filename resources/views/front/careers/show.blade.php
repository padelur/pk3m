@extends('layouts.app')

@section('content')
<div class="py-4">
	<a href="{{ route('careers.index') }}" class="btn btn-link p-0 mb-3">&larr; Kembali</a>
	<h1 class="h3 mb-2">{{ $job->title }}</h1>
	<div class="small text-muted mb-3">Tutup: {{ $job->closing_date ? \Carbon\Carbon::parse($job->closing_date)->format('d M Y') : '-' }}</div>
	<div class="mb-3">
		<h2 class="h5">Deskripsi</h2>
		<div>{!! nl2br(e($job->description)) !!}</div>
	</div>
	<div>
		<h2 class="h5">Persyaratan</h2>
		<div>{!! nl2br(e($job->requirements)) !!}</div>
	</div>
</div>
@endsection
