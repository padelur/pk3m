@extends('layouts.admin')

@section('title', 'Detail Supplier - Makmur Mandiri Medika')
@section('page-title', 'Detail Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Detail Supplier</h2>
        <p class="text-muted mb-0">{{ $supplier->name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Supplier</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">Nama</th>
                        <td>{{ $supplier->name }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($supplier->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    @if($supplier->address)
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $supplier->address }}</td>
                    </tr>
                    @endif
                    @if($supplier->phone)
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $supplier->phone }}</td>
                    </tr>
                    @endif
                    @if($supplier->email)
                    <tr>
                        <th>Email</th>
                        <td>{{ $supplier->email }}</td>
                    </tr>
                    @endif
                    @if($supplier->notes)
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $supplier->notes }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Purchase Orders</h5>
            </div>
            <div class="card-body">
                @if($supplier->purchaseOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>PO Number</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplier->purchaseOrders->take(5) as $po)
                            <tr>
                                <td>{{ $po->po_number }}</td>
                                <td>
                                    <span class="badge bg-{{ $po->status === 'Received' ? 'success' : ($po->status === 'Approved' ? 'primary' : 'secondary') }}">
                                        {{ $po->status }}
                                    </span>
                                </td>
                                <td>{{ $po->order_date->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.purchase-orders.show', $po) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-0">Belum ada Purchase Order</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

