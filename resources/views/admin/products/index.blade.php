@extends('layouts.admin')

@section('title', 'Manajemen Produk - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Produk</h2>
        <p class="text-muted mb-0">Kelola semua produk alat medis</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Produk
    </a>
</div>

<div class="card">
	<div class="table-responsive">
		<table class="table table-striped mb-0">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama</th>
					<th>Brand</th>
					<th>Kategori</th>
					<th>Stok</th>
					<th>Status</th>
					<th width="220">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach($products as $product)
					<tr>
						<td>{{ $product->id }}</td>
						<td>{{ $product->name }}</td>
						<td>{{ $product->brand->name ?? '-' }}</td>
						<td>{{ $product->category->name ?? '-' }}</td>
						<td>{{ $product->stock }}</td>
						<td>
							<span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span>
						</td>
						<td>
							<div class="btn-group" role="group">
								<a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">
									<i class="fas fa-edit"></i>
								</a>
								<a href="{{ route('admin.products.history', $product) }}" class="btn btn-sm btn-info">
									<i class="fas fa-history"></i>
								</a>
								<form method="post" action="{{ route('admin.products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
									@csrf
									@method('DELETE')
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
	<div class="card-footer">
		{{ $products->links() }}
	</div>
</div>
@endsection
