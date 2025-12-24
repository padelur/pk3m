@extends('layouts.admin')

@section('title', 'Hak Akses Admin - Makmur Mandiri Medika')
@section('page-title', 'Hak Akses Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Hak Akses Admin</h2>
        <p class="text-muted mb-0">Atur hak akses untuk: {{ $user->name }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.users.update-permissions', $user) }}" class="card p-4">
    @csrf

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        Pilih hak akses yang diizinkan untuk admin ini. Super Admin memiliki semua akses secara otomatis.
    </div>

    <div class="row">
        @foreach($availablePermissions as $group => $permissions)
        <div class="col-12 mb-4">
            <div class="card h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">{{ $group }}</h5>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input group-select-all" 
                               data-group="{{ Str::slug($group) }}" id="select_all_{{ Str::slug($group) }}">
                        <label class="form-check-label small" for="select_all_{{ Str::slug($group) }}">
                            Pilih Semua
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($permissions as $permission => $label)
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" id="perm_{{ Str::slug($permission) }}" 
                                       class="form-check-input permission-checkbox group-{{ Str::slug($group) }}" 
                                       value="{{ $permission }}"
                                       {{ in_array($permission, $user->getPermissions()) ? 'checked' : '' }}>
                                <label for="perm_{{ Str::slug($permission) }}" class="form-check-label">
                                    {{ $label }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex gap-2 mt-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Hak Akses</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle "Select All" click
        const groupSelectAlls = document.querySelectorAll('.group-select-all');
        
        groupSelectAlls.forEach(selectAll => {
            const group = selectAll.dataset.group;
            const checkboxes = document.querySelectorAll(`.group-${group}`);
            
            // Initial check: if all checkboxes in group are checked, check the "Select All"
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
            });

            // Handle individual checkbox click to update "Select All" state
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const allNowChecked = Array.from(checkboxes).every(c => c.checked);
                    selectAll.checked = allNowChecked;
                });
            });
        });
    });
</script>
@endpush

