@extends('layouts.admin')

@section('title', 'Permintaan Barang - Makmur Mandiri Medika')
@section('page-title', 'Permintaan Barang Customer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Form Permintaan Barang</h2>
        <p class="text-muted mb-0">Catat permintaan barang dari customer dan pengeluaran stok</p>
    </div>
    <a href="{{ route('admin.stock-outs.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.stock-outs.store') }}" class="card p-4">
    @csrf

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <label class="form-label">Nama Customer *</label>
            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                   value="{{ old('customer_name') }}" required>
            @error('customer_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="1" class="form-control">{{ old('notes') }}</textarea>
        </div>
    </div>

    <hr class="my-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Item Barang</h5>
        <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
            <i class="fas fa-plus me-1"></i>Tambah Item
        </button>
    </div>

    <div id="itemsContainer">
        <div class="item-row card p-3 mb-3">
            <div class="row g-3">
                <div class="col-md-7">
                    <label class="form-label">Produk *</label>
                    <select name="items[0][product_id]" class="form-select product-select" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                data-stock="{{ $product->stock }}"
                                data-price="{{ $product->price ?? 0 }}">
                                {{ $product->name }} - {{ $product->category->name ?? '' }} (Stok: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Qty *</label>
                    <input type="number" name="items[0][quantity]" class="form-control quantity-input" min="1" value="1" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-item" style="display: none;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <label class="form-label">Catatan Item</label>
                    <input type="text" name="items[0][notes]" class="form-control item-notes" placeholder="Catatan untuk item ini (opsional)">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 mt-4">
        <a href="{{ route('admin.stock-outs.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Surat Pesanan (Draft)</button>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemsContainer = document.getElementById('itemsContainer');
    const addItemBtn = document.getElementById('addItemBtn');
    
    if (!itemsContainer || !addItemBtn) {
        console.error('Elements not found:', { itemsContainer, addItemBtn });
        return;
    }
    
    let itemIndex = itemsContainer.querySelectorAll('.item-row').length;
    console.log('Stock Out Form: Initial item count:', itemIndex);

    function addItemRow() {
        console.log('Adding new item row...');
        const template = itemsContainer.querySelector('.item-row');
        if (!template) {
            console.error('Template not found!');
            return;
        }

        const newItem = template.cloneNode(true);

        newItem.querySelectorAll('select, input').forEach((input) => {
            if (input.name) {
                input.name = input.name.replace(/\[\d+\]/, '[' + itemIndex + ']');
            }
            if (input.classList.contains('product-select')) {
                input.value = '';
            }
            if (input.classList.contains('quantity-input')) {
                input.value = 1;
            }
            if (input.classList.contains('item-notes')) {
                input.value = '';
            }
        });

        const removeBtn = newItem.querySelector('.remove-item');
        if (removeBtn) {
            removeBtn.style.display = 'block';
        }

        itemsContainer.appendChild(newItem);
        itemIndex++;
        console.log('New item added. Total items:', itemIndex);
    }

    addItemBtn.addEventListener('click', function(e) {
        console.log('Add button clicked!');
        addItemRow();
    });

    itemsContainer.addEventListener('click', function (event) {
        const removeBtn = event.target.closest('.remove-item');
        if (!removeBtn) return;

        const rows = itemsContainer.querySelectorAll('.item-row');
        if (rows.length <= 1) {
            console.log('Cannot remove last item');
            return;
        }

        removeBtn.closest('.item-row').remove();
        console.log('Item removed. Remaining items:', rows.length - 1);
    });
    
    console.log('Stock out form JavaScript initialized successfully');
});
</script>
@endpush
@endsection


