@extends('layouts.admin')

@section('title', 'Manajemen Kategori - Makmur Mandiri Medika')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manajemen Kategori</h2>
        <p class="text-muted mb-0">Kelola kategori produk alat medis</p>
    </div>
    @if(auth()->user()->hasPermission('categories.create'))
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Kategori
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0" id="categoriesTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Brand</th>
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
    $('#categoriesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.categories.datatable') }}",
            type: 'GET',
        },
        columns: [
            { data: 0, name: 'row_number', orderable: false, searchable: false },
            { data: 1, name: 'name', orderable: true, searchable: true },
            { data: 2, name: 'slug', orderable: true, searchable: true },
            { data: 3, name: 'brand_name', orderable: true, searchable: true },
            { data: 4, name: 'actions', orderable: false, searchable: false }
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Show All Option
    });
});
</script>
@endpush
