@extends('layouts.admin')

@section('title', 'Manajemen Brand - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Brand')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Brand</h2>
        <p class="text-muted mb-0">Kelola brand produk alat medis</p>
    </div>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Brand
    </a>
</div>
<div class="card">
	<div class="table-responsive">
		<table class="table table-striped mb-0">
			<thead><tr><th>#</th><th>Nama</th><th>Slug</th><th>Logo</th><th width="200">Aksi</th></tr></thead>
			<tbody>
				@foreach($brands as $brand)
				<tr>
					<td>{{ $brand->id }}</td>
					<td>{{ $brand->name }}</td>
					<td>{{ $brand->slug }}</td>
					<td>@if($brand->logo_path)<img src="{{ Storage::url($brand->logo_path) }}" alt="logo" style="height:32px">@endif</td>
					<td>
						<div class="btn-group" role="group">
							<a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-warning">
								<i class="fas fa-edit"></i>
							</a>
							<form method="post" action="{{ route('admin.brands.destroy', $brand) }}" class="d-inline" onsubmit="return confirm('Hapus brand ini?')">
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
	<div class="card-footer">{{ $brands->links() }}</div>
</div>
@endsection
