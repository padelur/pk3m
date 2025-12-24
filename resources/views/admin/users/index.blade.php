@extends('layouts.admin')

@section('title', 'Manajemen Admin - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Admin</h2>
        <p class="text-muted mb-0">Kelola aku administrator sistem</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Admin
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="usersTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
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
    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.users.datatable') }}",
            type: 'GET',
        },
        columns: [
            { data: 0, name: 'row_number', orderable: false, searchable: false },
            { data: 1, name: 'name', orderable: true, searchable: true },
            { data: 2, name: 'email', orderable: true, searchable: true },
            { data: 3, name: 'role', orderable: true, searchable: true },
            { data: 4, name: 'is_active', orderable: true, searchable: false },
            { data: 5, name: 'actions', orderable: false, searchable: false }
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Show All Option
    });
});
</script>
@endpush
