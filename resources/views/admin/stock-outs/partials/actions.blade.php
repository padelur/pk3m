<div class="btn-group" role="group">
    <a href="{{ route('admin.stock-outs.show', $stockOut) }}" class="btn btn-sm btn-outline-info" title="Detail">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.stock-outs.pdf', $stockOut) }}" class="btn btn-sm btn-outline-primary" target="_blank" title="Cetak PDF">
        <i class="fas fa-file-pdf"></i>
    </a>
</div>
