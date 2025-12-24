<div class="btn-group" role="group">
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
        <i class="fas fa-edit"></i>
    </a>
    
    <a href="{{ route('admin.users.permissions', $user) }}" class="btn btn-sm btn-info text-white" title="Hak Akses">
        <i class="fas fa-key"></i>
    </a>

    <form method="post" action="{{ route('admin.users.toggle-active', $user) }}" class="d-inline">
        @csrf
        <button class="btn btn-sm {{ $user->is_active ? 'btn-secondary' : 'btn-success' }}" 
                title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                onclick="return confirm('Apakah Anda yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} user ini?')">
            <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check' }}"></i>
        </button>
    </form>

    <form method="post" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-danger" title="Hapus">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
