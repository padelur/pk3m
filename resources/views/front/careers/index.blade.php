@extends('layouts.app')

@section('content')
<div class="py-4">
	<h1 class="h3 mb-3">Karir</h1>
	@forelse($jobs as $job)
		<div class="card mb-3">
			<div class="card-body">
				<h2 class="h5 mb-1"><a href="{{ route('careers.show', $job->id) }}" class="text-decoration-none">{{ $job->title }}</a></h2>
				<div class="small text-muted mb-2">Tutup: {{ $job->closing_date ? \Carbon\Carbon::parse($job->closing_date)->format('d M Y') : '-' }}</div>
				<div class="text-truncate">{!! Str::limit(strip_tags($job->description), 150) !!}</div>
			</div>
		</div>
	@empty
		<em>Belum ada lowongan.</em>
	@endforelse
	<div class="mt-3">{{ $jobs->links() }}</div>
</div>
@endsection
