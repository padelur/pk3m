@extends('layouts.admin')

@section('title', 'Manajemen Supplier - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Supplier</h2>
        <p class="text-muted mb-0">Kelola data supplier alat medis</p>
    </div>
    @if(auth()->user()->hasPermission('suppliers.create'))
    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Supplier
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="suppliersTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
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
    $('#suppliersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.suppliers.datatable') }}",
            type: 'GET',
        },
        columns: [
            { data: 0, name: 'row_number', orderable: false, searchable: false },
            { data: 1, name: 'name', orderable: true, searchable: true },
            { data: 2, name: 'address', orderable: true, searchable: true },
            { data: 3, name: 'contact', orderable: false, searchable: true },
            { data: 4, name: 'is_active', orderable: true, searchable: false },
            { data: 5, name: 'actions', orderable: false, searchable: false }
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Show All Option
    });
});
</script>
@endpush
