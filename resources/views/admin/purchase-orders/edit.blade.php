@extends('layouts.admin')

@section('title', 'Edit Purchase Order - Makmur Mandiri Medika')
@section('page-title', 'Edit Purchase Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Purchase Order</h2>
        <p class="text-muted mb-0">{{ $purchaseOrder->po_number }}</p>
    </div>
    <a href="{{ route('admin.purchase-orders.show', $purchaseOrder) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.purchase-orders.update', $purchaseOrder) }}" id="poForm" class="card p-4">
    @csrf
    @method('PUT')

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <label for="supplier_id" class="form-label">Supplier *</label>
            <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                <option value="">Pilih Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchaseOrder->supplier_id) == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
            @error('supplier_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3 mb-3">
            <label for="order_date" class="form-label">Tanggal Order *</label>
            <input type="date" name="order_date" id="order_date" 
                   class="form-control @error('order_date') is-invalid @enderror"
                   value="{{ old('order_date', $purchaseOrder->order_date->format('Y-m-d')) }}" required>
            @error('order_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3 mb-3">
            <label for="expected_delivery_date" class="form-label">Tanggal Pengiriman</label>
            <input type="date" name="expected_delivery_date" id="expected_delivery_date" 
                   class="form-control @error('expected_delivery_date') is-invalid @enderror"
                   value="{{ old('expected_delivery_date', $purchaseOrder->expected_delivery_date?->format('Y-m-d')) }}">
            @error('expected_delivery_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 mb-3">
            <label for="notes" class="form-label">Catatan</label>
            <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes', $purchaseOrder->notes) }}</textarea>
        </div>
    </div>

    <hr class="my-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Item Produk</h5>
        <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
            <i class="fas fa-plus me-1"></i>Tambah Item
        </button>
    </div>

    <div id="itemsContainer">
        @foreach($purchaseOrder->items as $index => $item)
        <div class="item-row card p-3 mb-3">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Produk *</label>
                    <select name="items[{{ $index }}][product_id]" class="form-select product-select" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    {{ old("items.{$index}.product_id", $item->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} - {{ $product->category->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kemasan</label>
                    <input type="text" name="items[{{ $index }}][packaging]" 
                           class="form-control packaging-input" 
                           placeholder="Contoh: Box"
                           value="{{ old("items.{$index}.packaging", $item->packaging) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah *</label>
                    <input type="number" name="items[{{ $index }}][quantity]" 
                           class="form-control quantity-input" 
                           min="1" 
                           value="{{ old("items.{$index}.quantity", $item->quantity) }}" 
                           required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <label class="form-label">Catatan Item</label>
                    <input type="text" name="items[{{ $index }}][notes]" 
                           class="form-control item-notes" 
                           value="{{ old("items.{$index}.notes", $item->notes) }}"
                           placeholder="Catatan untuk item ini">
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex gap-2 mt-4">
        <a href="{{ route('admin.purchase-orders.show', $purchaseOrder) }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemsContainer = document.getElementById('itemsContainer');
    const addItemBtn = document.getElementById('addItemBtn');
    
    if (!itemsContainer || !addItemBtn) {
        console.error('PO Edit Form: Elements not found:', { itemsContainer, addItemBtn });
        return;
    }
    
    let itemIndex = {{ $purchaseOrder->items->count() }};
    console.log('PO Edit Form: Initial item count:', itemIndex);

    addItemBtn.addEventListener('click', () => {
        console.log('PO Edit Form: Add button clicked!');
        const template = itemsContainer.querySelector('.item-row');
        if (!template) {
            console.error('PO Edit Form: Template not found!');
            return;
        }

        const newItem = template.cloneNode(true);

        newItem.querySelectorAll('select, input').forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/\[\d+\]/, `[${itemIndex}]`);
            }
            if (input.classList.contains('product-select')) {
                input.value = '';
            }
            if (input.classList.contains('quantity-input')) {
                input.value = 1;
            }
            if (input.classList.contains('packaging-input')) {
                input.value = '';
            }
            if (input.classList.contains('item-notes')) {
                input.value = '';
            }
        });

        itemsContainer.appendChild(newItem);
        itemIndex++;
        console.log('PO Edit Form: New item added. Total items:', itemIndex);
    });

    itemsContainer.addEventListener('click', (event) => {
        if (event.target.closest('.remove-item')) {
            const rows = itemsContainer.querySelectorAll('.item-row');
            if (rows.length <= 1) {
                console.log('PO Edit Form: Cannot remove last item');
                return;
            }
            event.target.closest('.item-row').remove();
            console.log('PO Edit Form: Item removed. Remaining items:', rows.length - 1);
        }
    });
    
    console.log('PO edit form JavaScript initialized successfully');
});
</script>
@endpush
@endsection

