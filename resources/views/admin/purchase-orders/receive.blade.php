@extends('layouts.admin')

@section('title', 'Terima Barang PO - Makmur Mandiri Medika')
@section('page-title', 'Terima Barang Purchase Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Terima Barang Purchase Order</h2>
        <p class="text-muted mb-0">{{ $purchaseOrder->po_number }} - {{ $purchaseOrder->supplier->name }}</p>
    </div>
    <a href="{{ route('admin.purchase-orders.show', $purchaseOrder) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>
    Masukkan jumlah barang yang diterima untuk setiap item. Stok produk akan otomatis bertambah setelah disimpan.
</div>

<form method="POST" action="{{ route('admin.purchase-orders.receive', $purchaseOrder) }}" class="card p-4">
    @csrf

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah PO</th>
                    <th>Sudah Diterima</th>
                    <th>Jumlah Diterima</th>
                    <th>Sisa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->items as $index => $item)
                <tr>
                    <td>
                        <strong>{{ $item->product->name }}</strong><br>
                        <small class="text-muted">{{ $item->product->category->name ?? '' }}</small>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->received_quantity }}</td>
                    <td>
                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                        <input type="number" 
                               name="items[{{ $index }}][received_quantity]" 
                               class="form-control" 
                               min="0" 
                               max="{{ $item->quantity - $item->received_quantity }}"
                               value="{{ $item->quantity - $item->received_quantity }}"
                               required>
                    </td>
                    <td>{{ $item->remaining_quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="alert alert-warning mt-3">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Perhatian:</strong> Setelah disimpan, stok produk akan otomatis bertambah sesuai jumlah yang diterima.
    </div>

    <div class="d-flex gap-2 mt-4">
        <a href="{{ route('admin.purchase-orders.show', $purchaseOrder) }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary" onclick="return confirm('Konfirmasi penerimaan barang? Stok akan otomatis bertambah.')">
            <i class="fas fa-check me-2"></i>Simpan Penerimaan
        </button>
    </div>
</form>
@endsection

