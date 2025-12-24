<div class="btn-group" role="group">
    @if(auth()->user()->hasPermission('purchase_orders.view'))
    <a href="{{ route('admin.purchase-orders.show', $purchaseOrder) }}" class="btn btn-sm btn-outline-info" title="Detail">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.purchase-orders.pdf', $purchaseOrder) }}" class="btn btn-sm btn-outline-primary" target="_blank" title="PDF">
        <i class="fas fa-file-pdf"></i>
    </a>
    @endif

    @if($purchaseOrder->status === 'Draft' && auth()->user()->hasPermission('purchase_orders.create'))
    <a href="{{ route('admin.purchase-orders.edit', $purchaseOrder) }}" class="btn btn-sm btn-outline-warning" title="Edit">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('admin.purchase-orders.destroy', $purchaseOrder) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus PO ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
            <i class="fas fa-trash"></i>
        </button>
    </form>
    @endif
</div>
