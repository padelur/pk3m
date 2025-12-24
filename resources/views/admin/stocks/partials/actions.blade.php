@php
    $canView = auth()->user()->hasPermission('stocks.view');
    $canManage = auth()->user()->hasPermission('stocks.manage');
@endphp

<div class="btn-group" role="group">
    @if($canView)
    <a href="{{ route('admin.stocks.show', $product) }}" class="btn btn-sm btn-outline-info" title="Riwayat Stok">
        <i class="fas fa-history"></i>
    </a>
    @endif
    @if($canManage)
    <a href="{{ route('admin.stocks.edit', $product) }}" class="btn btn-sm btn-outline-warning" title="Sesuaikan Stok">
        <i class="fas fa-edit"></i>
    </a>
    @endif
</div>
