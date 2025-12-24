@extends('layouts.admin')

@section('title', 'Purchase Orders - Makmur Mandiri Medika')
@section('page-title', 'Purchase Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Purchase Orders</h2>
        <p class="text-muted mb-0">Kelola pemesanan barang ke supplier</p>
    </div>
    @if(auth()->user()->hasPermission('purchase_orders.create'))
    <a href="{{ route('admin.purchase-orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Buat PO Baru
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="purchaseOrdersTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Tanggal Order</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
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
    $('#purchaseOrdersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.purchase-orders.datatable') }}",
            type: 'GET',
        },
        columns: [
            { data: 0, name: 'row_number', orderable: false, searchable: false },
            { data: 1, name: 'po_number', orderable: true, searchable: true },
            { data: 2, name: 'supplier_name', orderable: true, searchable: true },
            { data: 3, name: 'order_date', orderable: true, searchable: false },
            { data: 5, name: 'status', orderable: true, searchable: true },
            { data: 6, name: 'actions', orderable: false, searchable: false }
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]], // Show All Option
        order: [[3, 'desc']] // Order by Order Date desc
    });
});
</script>
@endpush
