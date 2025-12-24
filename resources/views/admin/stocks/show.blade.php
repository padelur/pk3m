@extends('layouts.admin')

@section('title', 'Riwayat Stok - Makmur Mandiri Medika')
@section('page-title', 'Riwayat Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Riwayat Stok</h2>
        <p class="text-muted mb-0">{{ $product->name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.stocks.edit', $product) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Sesuaikan Stok
        </a>
        <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>Informasi Produk</h5>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">Nama Produk</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $product->category->name ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">Stok Saat Ini</th>
                        <td><strong class="h4">{{ $product->stock }}</strong></td>
                    </tr>
                    <tr>
                        <th>Brand</th>
                        <td>{{ $product->brand->name ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Log Perubahan Stok</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="historyTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Perubahan</th>
                        <th>Tipe</th>
                        <th>Keterangan</th>
                        <th>Oleh</th>
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
    $('#historyTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.stocks.show-datatable', $product) }}",
            type: 'GET',
        },
        columns: [
            { data: 0, name: 'stock_logs.id', orderable: false, searchable: false },
            { data: 1, name: 'stock_logs.created_at', orderable: true, searchable: false },
            { data: 2, name: 'stock_logs.quantity_change', orderable: true, searchable: false },
            { data: 3, name: 'stock_logs.change_type', orderable: true, searchable: true },
            { data: 4, name: 'stock_logs.description', orderable: true, searchable: true },
            { data: 5, name: 'users.name', orderable: true, searchable: true }
        ],
        order: [[1, 'desc']], // Order by Date desc
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Show All Option
    });
});
</script>
@endpush


