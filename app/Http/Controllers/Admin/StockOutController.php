<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\ChecksPermissions;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class StockOutController extends Controller
{
    use ChecksPermissions;

    public function index(): View
    {
        $this->checkPermission('stock_outs.view');
        return view('admin.stock-outs.index');
    }

    public function datatable(Request $request)
    {
        $this->checkPermission('stock_outs.view');

        $columns = [
// ...
            0 => 'stock_outs.id',
            1 => 'stock_outs.invoice_number',
            2 => 'stock_outs.request_date',
            3 => 'stock_outs.customer_name',
            4 => 'creators.name', // Join for sorting
            5 => 'stock_outs.status',
        ];
// ... (rest of datatable unchanged)
        $baseQuery = StockOut::query()
            ->leftJoin('users as creators', 'stock_outs.created_by', '=', 'creators.id')
            ->select('stock_outs.*', 'creators.name as creator_name');

        $totalRecords = (clone $baseQuery)->count();

        // Filtering
        $searchValue = $request->input('search.value');
        if ($searchValue) {
            $baseQuery->where(function ($q) use ($searchValue) {
                $q->where('stock_outs.invoice_number', 'like', "%{$searchValue}%")
                  ->orWhere('stock_outs.customer_name', 'like', "%{$searchValue}%")
                  ->orWhere('creators.name', 'like', "%{$searchValue}%")
                  ->orWhere('stock_outs.status', 'like', "%{$searchValue}%");
            });
        }

        $filteredRecords = (clone $baseQuery)->count();

        // Ordering
        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
        $orderColumn = $columns[$orderColumnIndex] ?? 'stock_outs.created_at';
        $baseQuery->orderBy($orderColumn, $orderDir);

        // Paging
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        if ($length > 0) {
            $baseQuery->skip($start)->take($length);
        }

        $stockOuts = $baseQuery->get();

        $data = [];
        $rowNumber = $start + 1;
        foreach ($stockOuts as $stockOut) {
            $status = match($stockOut->status) {
                StockOut::STATUS_APPROVED => '<span class="badge bg-info">Approved</span>',
                StockOut::STATUS_COMPLETED => '<span class="badge bg-success">Completed</span>',
                StockOut::STATUS_REJECTED => '<span class="badge bg-danger">Rejected</span>',
                default => '<span class="badge bg-secondary">Draft</span>',
            };

            $totalItems = $stockOut->items()->sum('quantity');

            // Pass the model instance to the view, ensuring relationships if needed for actions logic
            // But actions view logic mainly relies on status which is already loaded.
            $actions = view('admin.stock-outs.partials.actions', ['stockOut' => $stockOut])->render();

            $data[] = [
                $rowNumber++,
                '<span class="fw-bold text-primary">' . e($stockOut->invoice_number) . '</span>',
                \Carbon\Carbon::parse($stockOut->request_date)->format('d M Y'),
                e($stockOut->customer_name),
                $totalItems . ' item',
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

    public function create(): View
    {
        $this->checkPermission('stock_outs.create');
        $products = Product::orderBy('name')->get();

        return view('admin.stock-outs.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkPermission('stock_outs.create');

        $validated = $request->validate([
// ... (rest unchanged)
            'customer_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);

        // Cek stok tersedia (validasi saja, tidak dikurangi)
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stock < $item['quantity']) {
                return back()
                    ->withInput()
                    ->with('error', "Stok untuk produk {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}");
            }
        }

        // Generate nomor invoice sederhana
        $prefix = 'SO-' . date('Ymd');
        $last = StockOut::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();
        $sequence = $last ? ((int) substr($last->invoice_number, -4)) + 1 : 1;
        $invoiceNumber = $prefix . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        $stockOut = StockOut::create([
            'invoice_number' => $invoiceNumber,
            'customer_name' => $validated['customer_name'],
            'notes' => $validated['notes'] ?? null,
            'request_date' => now()->toDateString(),
            'created_by' => auth()->id(),
            'status' => StockOut::STATUS_DRAFT, // Set status to Draft
        ]);

        foreach ($validated['items'] as $itemData) {
            $product = Product::findOrFail($itemData['product_id']);
            $price = $product->price ?? 0;

            $stockOut->items()->create([
                'product_id' => $product->id,
                'quantity' => $itemData['quantity'],
                'price' => $price,
                'notes' => $itemData['notes'] ?? null,
            ]);

            // TIDAK mengurangi stok di sini - stok akan dikurangi saat status Completed
        }

        return redirect()
            ->route('admin.stock-outs.show', $stockOut)
            ->with('success', 'Surat pesanan berhasil dibuat dengan status Draft. Menunggu persetujuan Super Admin.');
    }

    public function show(StockOut $stockOut): View
    {
        $this->checkPermission('stock_outs.view');
        $stockOut->load(['items.product', 'creator', 'approver']);

        return view('admin.stock-outs.show', compact('stockOut'));
    }

    public function approve(StockOut $stockOut): RedirectResponse
    {
        $this->checkPermission('stock_outs.approve');

        // Only Super Admin can approve
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat menyetujui surat pesanan.');
        }

        if (!$stockOut->canBeApproved()) {
            return back()->with('error', 'Surat pesanan tidak dapat disetujui. Status harus Draft.');
        }

        $stockOut->update([
            'status' => StockOut::STATUS_APPROVED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Surat pesanan berhasil disetujui.');
    }

    public function complete(StockOut $stockOut): RedirectResponse
    {
        $this->checkPermission('stock_outs.complete');
// ... (rest unchanged)
        if (!$stockOut->canBeCompleted()) {
            return back()->with('error', 'Surat pesanan tidak dapat diselesaikan. Status harus Approved.');
        }

        DB::beginTransaction();
        try {
            // Cek stok tersedia untuk semua item
            foreach ($stockOut->items as $item) {
                $product = Product::find($item->product_id);
                if (!$product || $product->stock < $item->quantity) {
                    DB::rollBack();
                    return back()->with('error', "Stok untuk produk {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}, Dibutuhkan: {$item->quantity}");
                }
            }

            // Kurangi stok dan catat log
            foreach ($stockOut->items as $item) {
                $product = Product::findOrFail($item->product_id);
                $product->updateStock(
                    -$item->quantity,
                    'Stock Out',
                    "Pengeluaran barang untuk {$stockOut->customer_name} - {$stockOut->invoice_number}",
                    $stockOut->invoice_number
                );
            }

            // Update status to Completed
            $stockOut->update([
                'status' => StockOut::STATUS_COMPLETED,
                'completed_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Surat pesanan berhasil diselesaikan dan stok telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pdf(StockOut $stockOut)
    {
        $this->checkPermission('stock_outs.view');
        $stockOut->load(['items.product', 'creator']);

        $pdf = Pdf::loadView('admin.stock-outs.pdf', [
            'stockOut' => $stockOut,
        ])->setPaper('a4');

        return $pdf->download('Faktur-Stok-Out-' . $stockOut->invoice_number . '.pdf');
    }
}


