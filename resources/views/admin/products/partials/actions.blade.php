@php
    $canEdit = auth()->user()->hasPermission('products.edit');
    $canViewHistory = auth()->user()->hasPermission('products.view');
    $canDelete = auth()->user()->hasPermission('products.delete');
@endphp

<div class="btn-group" role="group">
    @if($canEdit)
    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    @endif

    @if($canViewHistory)
    <a href="{{ route('admin.products.history', $product) }}" class="btn btn-sm btn-info">
        <i class="fas fa-history"></i>
    </a>
    @endif

    @if($canDelete)
    <form method="post" action="{{ route('admin.products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
    @endif
</div>


