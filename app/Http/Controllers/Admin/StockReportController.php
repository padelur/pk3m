<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\ChecksPermissions;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\StockOut;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class StockReportController extends Controller
{
    use ChecksPermissions;

    /**
     * Display stock logs report with filters
     */
    public function stockLogs(Request $request): View
    {
        $this->checkPermission('stocks.view');

        $query = StockLog::with(['product.category', 'creator']);

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by admin/creator
        if ($request->filled('user_id')) {
            $query->where('created_by', $request->user_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $stockLogs = $query->orderBy('created_at', 'desc')->paginate(50);
        $products = Product::orderBy('name')->get();
        $users = User::where('role', 'admin')->orWhere('role', 'super_admin')->orderBy('name')->get();

        return view('admin.reports.stock-logs', compact('stockLogs', 'products', 'users'));
    }

    /**
     * Display stock out report (Super Admin only)
     */
    public function stockOutReport(Request $request): View
    {
        $this->checkPermission('stocks.view');

        // Only Super Admin can access
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat mengakses laporan ini.');
        }

        $query = StockOut::with(['items.product', 'creator', 'approver'])
            ->where('status', StockOut::STATUS_COMPLETED);

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('completed_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('completed_at', '<=', $request->date_to);
        }

        // Filter by customer
        if ($request->filled('customer')) {
            $query->where('customer_name', 'like', '%' . $request->customer . '%');
        }

        // Filter by admin
        if ($request->filled('user_id')) {
            $query->where('created_by', $request->user_id);
        }

        $stockOuts = $query->orderBy('completed_at', 'desc')->paginate(50);
        $users = User::where('role', 'admin')->orWhere('role', 'super_admin')->orderBy('name')->get();

        return view('admin.reports.stock-out-report', compact('stockOuts', 'users'));
    }

    /**
     * Export stock logs to PDF
     */
    public function exportStockLogsPdf(Request $request)
    {
        $this->checkPermission('stocks.view');

        $query = StockLog::with(['product.category', 'creator']);

        // Apply same filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('user_id')) {
            $query->where('created_by', $request->user_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $stockLogs = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.reports.stock-logs-pdf', [
            'stockLogs' => $stockLogs,
            'filters' => $request->all(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Stok-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export stock logs to CSV
     */
    public function exportStockLogsCsv(Request $request): Response
    {
        $this->checkPermission('stocks.view');

        $query = StockLog::with(['product.category', 'creator']);

        // Apply filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('user_id')) {
            $query->where('created_by', $request->user_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $stockLogs = $query->orderBy('created_at', 'desc')->get();

        $filename = 'Laporan-Stok-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($stockLogs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Produk', 'Kategori', 'Tipe', 'Jumlah', 'Stok Sebelum', 'Stok Sesudah', 'Keterangan', 'Referensi', 'Dibuat Oleh']);

            foreach ($stockLogs as $log) {
                fputcsv($file, [
                    $log->created_at->format('d/m/Y H:i'),
                    $log->product->name ?? '-',
                    $log->product->category->name ?? '-',
                    $log->type,
                    $log->quantity,
                    $log->stock_before,
                    $log->stock_after,
                    $log->description,
                    $log->reference_number ?? '-',
                    $log->creator->name ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export stock out report to PDF
     */
    public function exportStockOutPdf(Request $request)
    {
        $this->checkPermission('stocks.view');

        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat mengakses laporan ini.');
        }

        $query = StockOut::with(['items.product', 'creator', 'approver'])
            ->where('status', StockOut::STATUS_COMPLETED);

        // Apply filters
        if ($request->filled('date_from')) {
            $query->whereDate('completed_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('completed_at', '<=', $request->date_to);
        }
        if ($request->filled('customer')) {
            $query->where('customer_name', 'like', '%' . $request->customer . '%');
        }
        if ($request->filled('user_id')) {
            $query->where('created_by', $request->user_id);
        }

        $stockOuts = $query->orderBy('completed_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.reports.stock-out-pdf', [
            'stockOuts' => $stockOuts,
            'filters' => $request->all(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Stok-Keluar-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export stock out report to CSV
     */
    public function exportStockOutCsv(Request $request): Response
    {
        $this->checkPermission('stocks.view');

        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat mengakses laporan ini.');
        }

        $query = StockOut::with(['items.product', 'creator', 'approver'])
            ->where('status', StockOut::STATUS_COMPLETED);

        // Apply filters
        if ($request->filled('date_from')) {
            $query->whereDate('completed_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('completed_at', '<=', $request->date_to);
        }
        if ($request->filled('customer')) {
            $query->where('customer_name', 'like', '%' . $request->customer . '%');
        }
        if ($request->filled('user_id')) {
            $query->where('created_by', $request->user_id);
        }

        $stockOuts = $query->orderBy('completed_at', 'desc')->get();

        $filename = 'Laporan-Stok-Keluar-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($stockOuts) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal Selesai', 'No. Invoice', 'Customer', 'Produk', 'Jumlah', 'Harga', 'Total', 'Dibuat Oleh', 'Disetujui Oleh', 'Status']);

            foreach ($stockOuts as $stockOut) {
                foreach ($stockOut->items as $item) {
                    fputcsv($file, [
                        $stockOut->completed_at?->format('d/m/Y H:i') ?? '-',
                        $stockOut->invoice_number,
                        $stockOut->customer_name,
                        $item->product->name ?? '-',
                        $item->quantity,
                        number_format($item->price, 0, ',', '.'),
                        number_format($item->price * $item->quantity, 0, ',', '.'),
                        $stockOut->creator->name ?? '-',
                        $stockOut->approver->name ?? '-',
                        $stockOut->status,
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
