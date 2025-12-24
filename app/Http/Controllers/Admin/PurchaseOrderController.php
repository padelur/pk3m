<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\ChecksPermissions;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    use ChecksPermissions;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->checkPermission('purchase_orders.view');
        return view('admin.purchase-orders.index');
    }

    public function datatable(Request $request)
    {
        $this->checkPermission('purchase_orders.view');

        $columns = [
            0 => 'purchase_orders.id',
            1 => 'purchase_orders.po_number',
            2 => 'suppliers.name',
            3 => 'purchase_orders.order_date',
            4 => 'purchase_orders.total_amount', // Calculated or join
            5 => 'purchase_orders.status',
        ];

        $baseQuery = PurchaseOrder::query()
            ->join('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->select('purchase_orders.*', 'suppliers.name as supplier_name');

        $totalRecords = (clone $baseQuery)->count();

        // Filtering
        $searchValue = $request->input('search.value');
        if ($searchValue) {
            $baseQuery->where(function ($q) use ($searchValue) {
                $q->where('purchase_orders.po_number', 'like', "%{$searchValue}%")
                  ->orWhere('suppliers.name', 'like', "%{$searchValue}%")
                  ->orWhere('purchase_orders.status', 'like', "%{$searchValue}%");
            });
        }

        $filteredRecords = (clone $baseQuery)->count();

        // Ordering
        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
        $columnName = $columns[$orderColumnIndex] ?? 'purchase_orders.created_at';
        
        // Handle special columns
        if ($columnName === 'purchase_orders.total_amount') {
             // Sorting by total amount is complex without a column, so fallback to ID or handle if needed.
             // For now, let's just sort by ID if total is selected, or skip
             $baseQuery->orderBy('purchase_orders.id', $orderDir);
        } else {
             $baseQuery->orderBy($columnName, $orderDir);
        }

        // Paging
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        if ($length > 0) {
            $baseQuery->skip($start)->take($length);
        }

        $purchaseOrders = $baseQuery->get();

        $data = [];
        $rowNumber = $start + 1;
        foreach ($purchaseOrders as $po) {
            $status = match($po->status) {
                'Approved' => '<span class="badge bg-info">Approved</span>',
                'Sent' => '<span class="badge bg-primary">Sent</span>',
                'Received' => '<span class="badge bg-success">Received</span>',
                'Cancelled' => '<span class="badge bg-danger">Cancelled</span>',
                default => '<span class="badge bg-secondary">Draft</span>',
            };

            // Calculate total manually since it's not in DB column for PO (usually calculated from items)
            // But if we want to sort by it, better to have it cached or joined. 
            // For now, display calculation.
            $total = 'Rp ' . number_format($po->items->sum(function($item) {
                return $item->quantity * $item->price;
            }), 0, ',', '.');

            $actions = view('admin.purchase-orders.partials.actions', ['purchaseOrder' => $po])->render();

            $data[] = [
                $rowNumber++,
                '<span class="fw-bold text-primary">' . e($po->po_number) . '</span>',
                e($po->supplier_name),
                \Carbon\Carbon::parse($po->order_date)->format('d M Y'),
                $total,
                $status,
                $actions,
            ];
        }

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->checkPermission('purchase_orders.create');
        $suppliers = Supplier::active()->orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('admin.purchase-orders.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkPermission('purchase_orders.create');
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.packaging' => 'nullable|string',
            'items.*.notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Generate PO number
            $poNumber = $this->generatePONumber();

            $purchaseOrder = PurchaseOrder::create([
                'po_number' => $poNumber,
                'supplier_id' => $validated['supplier_id'],
                'status' => 'Draft',
                'created_by' => auth()->id(),
                'order_date' => $validated['order_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create PO items
            foreach ($validated['items'] as $item) {
                $purchaseOrder->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'packaging' => $item['packaging'] ?? null,
                    'price' => 0,
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('success', 'Purchase Order berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder): View
    {
        $this->checkPermission('purchase_orders.view');
        $purchaseOrder->load(['supplier', 'creator', 'approver', 'receiver', 'items.product']);
        return view('admin.purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Download PO as PDF.
     */
    public function pdf(PurchaseOrder $purchaseOrder)
    {
        $this->checkPermission('purchase_orders.view');
        $purchaseOrder->load(['supplier', 'creator', 'approver', 'items.product']);
        $settings = Setting::first();

        $pdf = Pdf::loadView('admin.purchase-orders.pdf', [
            'purchaseOrder' => $purchaseOrder,
            'settings' => $settings,
        ])->setPaper('a4');

        $fileName = 'PO-' . $purchaseOrder->po_number . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder): View
    {
        $this->checkPermission('purchase_orders.create');
        if ($purchaseOrder->status !== 'Draft') {
            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Hanya PO dengan status Draft yang dapat diedit.');
        }

        $suppliers = Supplier::active()->orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $purchaseOrder->load('items.product');

        return view('admin.purchase-orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->checkPermission('purchase_orders.create');
        if ($purchaseOrder->status !== 'Draft') {
            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Hanya PO dengan status Draft yang dapat diedit.');
        }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.packaging' => 'nullable|string',
            'items.*.notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $purchaseOrder->update([
                'supplier_id' => $validated['supplier_id'],
                'order_date' => $validated['order_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Delete existing items
            $purchaseOrder->items()->delete();

            // Create new items
            foreach ($validated['items'] as $item) {
                $purchaseOrder->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'packaging' => $item['packaging'] ?? null,
                    'price' => 0,
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('success', 'Purchase Order berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Approve Purchase Order (Super Admin only)
     */
    public function approve(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        // Check permission first
        $this->checkPermission('purchase_orders.approve');

        // Additional check: only Super Admin can approve
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat menyetujui PO.');
        }

        if (!$purchaseOrder->canBeApproved()) {
            return back()->with('error', 'PO tidak dapat disetujui. Status harus Draft.');
        }

        $purchaseOrder->update([
            'status' => 'Approved',
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Purchase Order berhasil disetujui.');
    }

    /**
     * Send Purchase Order
     */
    public function send(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->checkPermission('purchase_orders.create');
        if (!$purchaseOrder->canBeSent()) {
            return back()->with('error', 'PO tidak dapat dikirim. Status harus Approved.');
        }

        $purchaseOrder->update([
            'status' => 'Sent',
        ]);

        return back()->with('success', 'Purchase Order berhasil dikirim.');
    }

    /**
     * Show receive form
     */
    public function showReceive(PurchaseOrder $purchaseOrder): View
    {
        $this->checkPermission('purchase_orders.receive');
        if (!$purchaseOrder->canBeReceived()) {
            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('error', 'PO tidak dapat menerima barang. Status harus Sent.');
        }

        $purchaseOrder->load('items.product');
        return view('admin.purchase-orders.receive', compact('purchaseOrder'));
    }

    /**
     * Receive Purchase Order items
     */
    public function receive(Request $request, PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->checkPermission('purchase_orders.receive');
        if (!$purchaseOrder->canBeReceived()) {
            return back()->with('error', 'PO tidak dapat menerima barang. Status harus Sent.');
        }

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:purchase_order_items,id',
            'items.*.received_quantity' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['items'] as $itemData) {
                $item = $purchaseOrder->items()->findOrFail($itemData['id']);
                $receivedQty = (int) $itemData['received_quantity'];

                if ($receivedQty > 0 && $receivedQty <= $item->quantity) {
                    $oldReceivedQty = $item->received_quantity;
                    $item->received_quantity = $receivedQty;
                    $item->save();

                    // Update stock if quantity increased
                    if ($receivedQty > $oldReceivedQty) {
                        $quantityToAdd = $receivedQty - $oldReceivedQty;
                        $item->product->updateStock(
                            $quantityToAdd,
                            'PO Received',
                            "Penerimaan barang dari PO {$purchaseOrder->po_number}",
                            $purchaseOrder->po_number
                        );
                    }
                }
            }

            // Check if all items are fully received
            if ($purchaseOrder->isFullyReceived()) {
                $purchaseOrder->update([
                    'status' => 'Received',
                    'received_by' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('success', 'Barang berhasil diterima dan stok telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->checkPermission('purchase_orders.create');
        if ($purchaseOrder->status !== 'Draft') {
            return redirect()->route('admin.purchase-orders.index')
                ->with('error', 'Hanya PO dengan status Draft yang dapat dihapus.');
        }

        $purchaseOrder->delete();

        return redirect()->route('admin.purchase-orders.index')
            ->with('success', 'Purchase Order berhasil dihapus.');
    }

    /**
     * Generate unique PO number
     */
    private function generatePONumber(): string
    {
        $prefix = 'PO-' . date('Ymd');
        $lastPO = PurchaseOrder::where('po_number', 'like', $prefix . '%')
            ->orderBy('po_number', 'desc')
            ->first();

        if ($lastPO) {
            $lastNumber = (int) substr($lastPO->po_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
