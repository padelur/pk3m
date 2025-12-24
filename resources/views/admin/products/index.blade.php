@extends('layouts.admin')

@section('title', 'Manajemen Produk - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Produk</h2>
        <p class="text-muted mb-0">Kelola semua produk alat medis</p>
    </div>
    @if(auth()->user()->hasPermission('products.create'))
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Produk
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="productsTable">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Brand</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = $('#productsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.products.datatable') }}",
            type: 'GET',
        },
        columns: [
            { data: 0, name: 'row_number', orderable: false, searchable: false },
            { data: 1, name: 'name', orderable: true, searchable: true },
            { data: 2, name: 'brand_name', orderable: true, searchable: true },
            { data: 3, name: 'category_name', orderable: true, searchable: true },
            { data: 4, name: 'price', orderable: true, searchable: true },
            { data: 5, name: 'stock', orderable: true, searchable: false },
            { data: 6, name: 'is_active', orderable: false, searchable: false },
            { data: 7, name: 'actions', orderable: false, searchable: false }
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Show All Option
    });
});
</script>
@endpush
