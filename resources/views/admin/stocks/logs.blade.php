@extends('layouts.admin')

@section('title', 'Riwayat Log Stok - Makmur Mandiri Medika')
@section('page-title', 'Riwayat Log Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Riwayat Log Stok</h2>
        <p class="text-muted mb-0">Semua perubahan stok produk</p>
    </div>
    <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Stok
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Filter Data</h5>
    </div>
    <div class="card-body">
        <form id="filterForm" class="row g-3">
            <div class="col-md-5">
                <label for="product_id" class="form-label">Produk</label>
                <select name="product_id" id="product_id" class="form-select">
                    <option value="">Semua Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="change_type" class="form-label">Tipe Perubahan</label>
                <select name="change_type" id="change_type" class="form-select">
                    <option value="">Semua Tipe</option>
                    <option value="PO Received">PO Received</option>
                    <option value="Manual Input">Manual Input</option>
                    <option value="Adjustment">Adjustment</option>
                    <option value="Stock Out">Stock Out</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" id="btnFilter" class="btn btn-primary me-2">Filter</button>
                <button type="button" id="btnReset" class="btn btn-outline-secondary">Reset</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="logsTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
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
    const table = $('#logsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.stocks.logs-datatable') }}",
            type: 'GET',
            data: function (d) {
                d.product_id = $('#product_id').val();
                d.change_type = $('#change_type').val();
            }
        },
        columns: [
            { data: 0, name: 'stock_logs.id', orderable: false, searchable: false },
            { data: 1, name: 'stock_logs.created_at', orderable: true, searchable: false },
            { data: 2, name: 'products.name', orderable: true, searchable: true },
            { data: 3, name: 'stock_logs.quantity_change', orderable: true, searchable: false },
            { data: 4, name: 'stock_logs.change_type', orderable: true, searchable: true },
            { data: 5, name: 'stock_logs.description', orderable: true, searchable: true },
            { data: 6, name: 'users.name', orderable: true, searchable: true }
        ],
        order: [[1, 'desc']], // Order by Date desc
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Show All Option
    });

    $('#btnFilter').click(function() {
        table.draw();
    });

    $('#btnReset').click(function() {
        $('#product_id').val('');
        $('#change_type').val('');
        table.draw();
    });
});
</script>
@endpush


