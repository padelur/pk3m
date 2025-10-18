@extends('layouts.admin')

@section('title', 'Riwayat Produk - Makmur Mandiri Medika')
@section('page-title', 'Riwayat Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Riwayat Perubahan</h2>
        <p class="text-muted mb-0">Produk: {{ $product->name }}</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Produk
    </a>
</div>
<div class="card">
	<div class="table-responsive">
		<table class="table table-striped mb-0">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Admin</th>
					<th>Aksi</th>
					<th>Perubahan</th>
				</tr>
			</thead>
			<tbody>
				@foreach($auditLogs as $log)
					<tr>
						<td>{{ $log->created_at }}</td>
						<td>{{ $log->user->name ?? 'System' }}</td>
						<td><span class="badge text-bg-secondary">{{ $log->action }}</span></td>
						<td>
							<pre class="mb-0 small">{{ json_encode($log->changes, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="card-footer">{{ $auditLogs->links() }}</div>
</div>
@endsection
