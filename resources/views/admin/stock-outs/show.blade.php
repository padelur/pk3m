@extends('layouts.admin')

@section('title', 'Detail Stok Keluar - Makmur Mandiri Medika')
@section('page-title', 'Detail Stok Keluar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Detail Stok Keluar</h2>
        <p class="text-muted mb-0">{{ $stockOut->invoice_number }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.stock-outs.pdf', $stockOut) }}" class="btn btn-outline-primary" target="_blank">
            <i class="fas fa-file-pdf me-2"></i>Cetak Faktur
        </a>
        <a href="{{ route('admin.stock-outs.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Permintaan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="140">No. Invoice</th>
                        <td>{{ $stockOut->invoice_number }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($stockOut->status === 'Draft')
                                <span class="badge bg-secondary">Draft</span>
                            @elseif($stockOut->status === 'Approved')
                                <span class="badge bg-info">Approved</span>
                            @elseif($stockOut->status === 'Completed')
                                <span class="badge bg-success">Completed</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $stockOut->request_date?->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Customer</th>
                        <td>{{ $stockOut->customer_name }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Oleh</th>
                        <td>{{ $stockOut->creator->name ?? '-' }}</td>
                    </tr>
                    @if($stockOut->approved_by)
                    <tr>
                        <th>Disetujui Oleh</th>
                        <td>{{ $stockOut->approver->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Disetujui</th>
                        <td>{{ $stockOut->approved_at?->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                    @if($stockOut->completed_at)
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $stockOut->completed_at?->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
                @if($stockOut->notes)
                <div class="mt-3">
                    <strong>Catatan:</strong>
                    <p class="mb-0">{{ $stockOut->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                @if($stockOut->canBeApproved() && auth()->user()->isSuperAdmin())
                    <form action="{{ route('admin.stock-outs.approve', $stockOut) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-2" onclick="return confirm('Apakah Anda yakin ingin menyetujui surat pesanan ini?')">
                            <i class="fas fa-check me-2"></i>Setujui Surat Pesanan
                        </button>
                    </form>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Surat pesanan ini menunggu persetujuan Super Admin. Stok belum dikurangi.
                    </p>
                @elseif($stockOut->canBeCompleted())
                    <form action="{{ route('admin.stock-outs.complete', $stockOut) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 mb-2" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan surat pesanan ini? Stok akan dikurangi.')">
                            <i class="fas fa-check-double me-2"></i>Tandai Selesai
                        </button>
                    </form>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Surat pesanan sudah disetujui. Klik tombol di atas untuk menyelesaikan dan mengurangi stok.
                    </p>
                @elseif($stockOut->isCompleted())
                    <div class="alert alert-success mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        Surat pesanan telah selesai diproses dan stok telah dikurangi.
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Surat pesanan menunggu persetujuan Super Admin.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Item Barang</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Catatan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach($stockOut->items as $index => $item)
                            @php
                                $lineTotal = ($item->price ?? 0) * $item->quantity;
                                $grandTotal += $lineTotal;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->product->name }}</strong><br>
                                    <small class="text-muted">{{ $item->product->category->name ?? '' }}</small>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($lineTotal, 0, ',', '.') }}</td>
                                <td>{{ $item->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th colspan="2">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


