<div class="d-flex gap-2">
    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
