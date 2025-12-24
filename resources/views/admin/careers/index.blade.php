@extends('layouts.admin')

@section('title', 'Manajemen Karir - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Karir')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Karir</h2>
        <p class="text-muted mb-0">Kelola lowongan kerja dan karir</p>
    </div>
    <a href="{{ route('admin.careers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Lowongan
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="careersTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tutup</th>
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
    $('#careersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.careers.datatable') }}",
            type: 'GET',
        },
        columns: [
            { data: 0, name: 'row_number', orderable: false, searchable: false },
            { data: 1, name: 'title', orderable: true, searchable: true },
            { data: 2, name: 'status', orderable: true, searchable: true },
            { data: 3, name: 'closing_date', orderable: true, searchable: false },
            { data: 4, name: 'actions', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Show All Option
    });
});
</script>
@endpush
