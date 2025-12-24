@php
    $canView = auth()->user()->hasPermission('suppliers.view');
    $canEdit = auth()->user()->hasPermission('suppliers.edit');
    $canDelete = auth()->user()->hasPermission('suppliers.delete');
@endphp

<div class="btn-group" role="group">
    @if($canView)
    <a href="{{ route('admin.suppliers.show', $supplier) }}" class="btn btn-sm btn-outline-info" title="Detail">
        <i class="fas fa-eye"></i>
    </a>
    @endif
    @if($canEdit)
    <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-warning" title="Edit">
        <i class="fas fa-edit"></i>
    </a>
    @endif
    @if($canDelete)
    <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
            <i class="fas fa-trash"></i>
        </button>
    </form>
    @endif
</div>
