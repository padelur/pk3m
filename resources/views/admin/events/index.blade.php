@extends('layouts.admin')

@section('title', 'Events - Makmur Mandiri Medika')
@section('page-title', 'Management Events')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Event</h5>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Event
        </a>
    </div>
    <div class="table-responsive text-nowrap p-3">
        <table class="table" id="eventsTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#eventsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.events.datatable') }}",
            columns: [
                { data: 0, name: 'events.id' },
                { data: 1, name: 'events.image_path', orderable: false, searchable: false },
                { data: 2, name: 'events.name' },
                { data: 3, name: 'events.date' },
                { data: 4, orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
@endsection
