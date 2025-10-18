@extends('layouts.app')

@section('content')
<div class="py-4">
	<h1 class="h3 mb-3">Tim Kami</h1>
	<div class="row g-3">
		@forelse($members as $member)
			<div class="col-6 col-md-3">
				<div class="card h-100 text-center">
					@if($member->photo_path)
						<img src="{{ Storage::url($member->photo_path) }}" class="card-img-top" alt="{{ $member->name }}">
					@endif
					<div class="card-body">
						<h3 class="h6 mb-1">{{ $member->name }}</h3>
						<div class="small text-muted">{{ $member->position }}</div>
					</div>
				</div>
			</div>
		@empty
			<div class="col-12"><em>Belum ada data tim.</em></div>
		@endforelse
	</div>
</div>
@endsection
