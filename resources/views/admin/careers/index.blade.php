@extends('layouts.admin')

@section('title', 'Manajemen Karir - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Karir')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Karir</h2>
        <p class="text-muted mb-0">Kelola lowongan kerja dan karir</p>
    </div>
    <a href="{{ route('admin.careers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Lowongan
    </a>
</div>
<div class="card">
	<div class="table-responsive">
		<table class="table table-striped mb-0">
			<thead><tr><th>#</th><th>Judul</th><th>Status</th><th>Tutup</th><th width="200">Aksi</th></tr></thead>
			<tbody>
				@foreach($careers as $job)
				<tr>
					<td>{{ $job->id }}</td>
					<td>{{ $job->title }}</td>
					<td><span class="badge {{ $job->status==='open'?'bg-success':'bg-secondary' }}">{{ $job->status }}</span></td>
					<td>{{ $job->closing_date }}</td>
					<td>
						<div class="btn-group" role="group">
							<a href="{{ route('admin.careers.edit', $job) }}" class="btn btn-sm btn-warning">
								<i class="fas fa-edit"></i>
							</a>
							<form method="post" action="{{ route('admin.careers.destroy', $job) }}" class="d-inline" onsubmit="return confirm('Hapus lowongan ini?')">
								@csrf @method('DELETE')
								<button class="btn btn-sm btn-danger">
									<i class="fas fa-trash"></i>
								</button>
							</form>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="card-footer">{{ $careers->links() }}</div>
</div>
@endsection
