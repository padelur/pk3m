@extends('layouts.admin')

@section('title', 'Manajemen Stok - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Stok</h2>
        <p class="text-muted mb-0">Kelola stok produk alat medis</p>
    </div>
    <div class="d-flex gap-2">
        @if(auth()->user()->hasPermission('stocks.manage'))
        <a href="{{ route('admin.stocks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Input Stok Manual
        </a>
        @endif
        @if(auth()->user()->hasPermission('stocks.view'))
        <a href="{{ route('admin.stocks.logs') }}" class="btn btn-outline-info">
            <i class="fas fa-history me-2"></i>Riwayat Stok
        </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="stocksTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Brand</th>
                        <th>Kategori</th>
                        <th>Stok Saat Ini</th>
                        <th width="200">Aksi</th>
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
    $('#stocksTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.stocks.datatable') }}",
            type: 'GET',
        },
        columns: [
            { data: 0, name: 'row_number', orderable: false, searchable: false },
            { data: 1, name: 'name', orderable: true, searchable: true },
            { data: 2, name: 'brand_name', orderable: true, searchable: true },
            { data: 3, name: 'category_name', orderable: true, searchable: true },
            { data: 4, name: 'stock', orderable: true, searchable: false },
            { data: 5, name: 'actions', orderable: false, searchable: false }
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Show All Option
    });
});
</script>
@endpush
