@extends('layouts.admin')

@section('title', 'Stok Keluar - Makmur Mandiri Medika')
@section('page-title', 'Stok Keluar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Stok Keluar</h2>
        <p class="text-muted mb-0">Pencatatan pengeluaran barang ke customer</p>
    </div>
    @if(auth()->user()->hasPermission('stocks.manage'))
    <a href="{{ route('admin.stock-outs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Permintaan Barang Baru
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="stockOutsTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total Item</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
    $('#stockOutsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.stock-outs.datatable') }}",
            type: 'GET',
        },
        columns: [
            { data: 0, name: 'row_number', orderable: false, searchable: false },
            { data: 1, name: 'invoice_number', orderable: true, searchable: true },
            { data: 2, name: 'request_date', orderable: true, searchable: false },
            { data: 3, name: 'customer_name', orderable: true, searchable: true },
            { data: 4, name: 'items_count', orderable: false, searchable: false },
            { data: 5, name: 'status', orderable: true, searchable: true },
            { data: 6, name: 'actions', orderable: false, searchable: false }
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]], // Show All Option
        order: [[1, 'desc']] // Order by Invoice Number desc
    });
});
</script>
@endpush
