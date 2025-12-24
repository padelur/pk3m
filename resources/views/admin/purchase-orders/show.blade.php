@extends('layouts.admin')

@section('title', 'Detail Purchase Order - Makmur Mandiri Medika')
@section('page-title', 'Detail Purchase Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Detail Purchase Order</h2>
        <p class="text-muted mb-0">{{ $purchaseOrder->po_number }}</p>
    </div>
    <div class="d-flex gap-2">
        @if($purchaseOrder->status === 'Draft' && auth()->user()->hasPermission('purchase_orders.create'))
        <a href="{{ route('admin.purchase-orders.edit', $purchaseOrder) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        @endif
        @if(auth()->user()->hasPermission('purchase_orders.view'))
        <a href="{{ route('admin.purchase-orders.pdf', $purchaseOrder) }}" class="btn btn-outline-primary" target="_blank">
            <i class="fas fa-file-pdf me-2"></i>Cetak PDF
        </a>
        @endif
        @if($purchaseOrder->canBeApproved() && auth()->user()->hasPermission('purchase_orders.approve'))
        <form action="{{ route('admin.purchase-orders.approve', $purchaseOrder) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success" onclick="return confirm('Setujui PO ini?')">
                <i class="fas fa-check me-2"></i>Setujui
            </button>
        </form>
        @endif
        @if($purchaseOrder->canBeSent() && auth()->user()->hasPermission('purchase_orders.create'))
        <form action="{{ route('admin.purchase-orders.send', $purchaseOrder) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary" onclick="return confirm('Kirim PO ini ke supplier?')">
                <i class="fas fa-paper-plane me-2"></i>Kirim
            </button>
        </form>
        @endif
        @if($purchaseOrder->canBeReceived() && auth()->user()->hasPermission('purchase_orders.receive'))
        <a href="{{ route('admin.purchase-orders.receive', $purchaseOrder) }}" class="btn btn-info">
            <i class="fas fa-box me-2"></i>Terima Barang
        </a>
        @endif
        <a href="{{ route('admin.purchase-orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi PO</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">PO Number</th>
                                <td><strong>{{ $purchaseOrder->po_number }}</strong></td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>{{ $purchaseOrder->supplier->name }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-{{ $purchaseOrder->status === 'Received' ? 'success' : ($purchaseOrder->status === 'Approved' ? 'primary' : ($purchaseOrder->status === 'Sent' ? 'warning' : 'secondary')) }}">
                                        {{ $purchaseOrder->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Order</th>
                                <td>{{ $purchaseOrder->order_date->format('d/m/Y') }}</td>
                            </tr>
                            @if($purchaseOrder->expected_delivery_date)
                            <tr>
                                <th>Tanggal Pengiriman</th>
                                <td>{{ $purchaseOrder->expected_delivery_date->format('d/m/Y') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Dibuat Oleh</th>
                                <td>{{ $purchaseOrder->creator->name }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Dibuat</th>
                                <td>{{ $purchaseOrder->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($purchaseOrder->approver)
                            <tr>
                                <th>Disetujui Oleh</th>
                                <td>{{ $purchaseOrder->approver->name }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Disetujui</th>
                                <td>{{ $purchaseOrder->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endif
                            @if($purchaseOrder->receiver)
                            <tr>
                                <th>Diterima Oleh</th>
                                <td>{{ $purchaseOrder->receiver->name }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                @if($purchaseOrder->notes)
                <div class="mt-3">
                    <strong>Catatan:</strong>
                    <p class="mb-0">{{ $purchaseOrder->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Item Produk</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kemasan</th>
                                <th>Jumlah Dipesan</th>
                                <th>Diterima</th>
                                <th>Sisa</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchaseOrder->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product->name }}</strong><br>
                                    <small class="text-muted">{{ $item->product->category->name ?? '' }}</small>
                                </td>
                                <td>{{ $item->packaging ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    @if($purchaseOrder->status === 'Received' || $purchaseOrder->status === 'Sent')
                                        <span class="badge bg-{{ $item->received_quantity >= $item->quantity ? 'success' : 'warning' }}">
                                            {{ $item->received_quantity }} / {{ $item->quantity }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ max($item->quantity - $item->received_quantity, 0) }}</td>
                                <td>{{ $item->notes ?: '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Supplier</h5>
            </div>
            <div class="card-body">
                <p><strong>{{ $purchaseOrder->supplier->name }}</strong></p>
                @if($purchaseOrder->supplier->address)
                <p class="mb-2">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    {{ $purchaseOrder->supplier->address }}
                </p>
                @endif
                @if($purchaseOrder->supplier->phone)
                <p class="mb-2">
                    <i class="fas fa-phone me-2"></i>
                    {{ $purchaseOrder->supplier->phone }}
                </p>
                @endif
                @if($purchaseOrder->supplier->email)
                <p class="mb-0">
                    <i class="fas fa-envelope me-2"></i>
                    {{ $purchaseOrder->supplier->email }}
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

