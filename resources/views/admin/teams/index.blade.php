@extends('layouts.admin')

@section('title', 'Manajemen Tim - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Tim')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Tim</h2>
        <p class="text-muted mb-0">Kelola anggota tim perusahaan</p>
    </div>
    <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Anggota
    </a>
</div>
<div class="card">
	<div class="table-responsive">
		<table class="table table-striped mb-0">
			<thead><tr><th>#</th><th>Nama</th><th>Jabatan</th><th>Foto</th><th width="200">Aksi</th></tr></thead>
			<tbody>
				@foreach($teams as $m)
				<tr>
					<td>{{ $m->id }}</td>
					<td>{{ $m->name }}</td>
					<td>{{ $m->position }}</td>
					<td>@if($m->photo_path)<img src="{{ Storage::url($m->photo_path) }}" alt="foto" style="height:32px">@endif</td>
					<td>
						<div class="btn-group" role="group">
							<a href="{{ route('admin.teams.edit', $m) }}" class="btn btn-sm btn-warning">
								<i class="fas fa-edit"></i>
							</a>
							<form method="post" action="{{ route('admin.teams.destroy', $m) }}" class="d-inline" onsubmit="return confirm('Hapus anggota ini?')">
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
	<div class="card-footer">{{ $teams->links() }}</div>
</div>
@endsection
