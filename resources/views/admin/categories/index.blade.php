@extends('layouts.admin')

@section('title', 'Manajemen Kategori - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Kategori</h2>
        <p class="text-muted mb-0">Kelola kategori produk alat medis</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Kategori
    </a>
</div>
<div class="card">
	<div class="table-responsive">
		<table class="table table-striped mb-0">
			<thead><tr><th>#</th><th>Nama</th><th>Slug</th><th>Brand</th><th width="200">Aksi</th></tr></thead>
			<tbody>
				@foreach($categories as $cat)
				<tr>
					<td>{{ $cat->id }}</td>
					<td>{{ $cat->name }}</td>
					<td>{{ $cat->slug }}</td>
					<td>{{ $cat->brand->name ?? '-' }}</td>
					<td>
						<div class="btn-group" role="group">
							<a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-warning">
								<i class="fas fa-edit"></i>
							</a>
							<form method="post" action="{{ route('admin.categories.destroy', $cat) }}" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
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
	<div class="card-footer">{{ $categories->links() }}</div>
</div>
@endsection
