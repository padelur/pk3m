<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\ChecksPermissions;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller
{
    use ChecksPermissions;

    /**
     * Display stock management page
     */
	public function index(Request $request): View
	{
		$this->checkPermission('stocks.view');
		return view('admin.stocks.index');
	}

	public function datatable(Request $request)
	{
		$this->checkPermission('stocks.view');

		$columns = [
			0 => 'products.id',
			1 => 'products.name',
			2 => 'brands.name',
			3 => 'categories.name',
			4 => 'products.stock',
		];

		$baseQuery = Product::query()
			->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
			->leftJoin('categories', 'products.category_id', '=', 'categories.id')
			->select('products.*', 'brands.name as brand_name', 'categories.name as category_name');

		$totalRecords = (clone $baseQuery)->count();

		// Filtering
		$searchValue = $request->input('search.value');
		if ($searchValue) {
			$baseQuery->where(function ($q) use ($searchValue) {
				$q->where('products.name', 'like', "%{$searchValue}%")
				  ->orWhere('brands.name', 'like', "%{$searchValue}%")
				  ->orWhere('categories.name', 'like', "%{$searchValue}%");
			});
		}

		$filteredRecords = (clone $baseQuery)->count();

		// Ordering
		$orderColumnIndex = (int) $request->input('order.0.column', 0);
		$orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
		$orderColumn = $columns[$orderColumnIndex] ?? 'products.id';
		$baseQuery->orderBy($orderColumn, $orderDir);

		// Paging
		$start = (int) $request->input('start', 0);
		$length = (int) $request->input('length', 10);
		if ($length > 0) {
			$baseQuery->skip($start)->take($length);
		}

		$products = $baseQuery->get();

		$data = [];
		$rowNumber = $start + 1;
		foreach ($products as $product) {
			$actions = view('admin.stocks.partials.actions', ['product' => $product])->render();
			$stock = $product->stock <= 5 
				? "<span class='text-danger fw-bold'>{$product->stock}</span>" 
				: $product->stock;

			$data[] = [
				$rowNumber++,
				e($product->name),
				e($product->brand_name ?? '-'),
				e($product->category_name ?? '-'),
				$stock,
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
     * Show form for manual stock input
     */
    public function create(): View
    {
        $this->checkPermission('stocks.manage');
        $products = Product::orderBy('name')->get();
        return view('admin.stocks.create', compact('products'));
    }

    /**
     * Store manual stock input
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkPermission('stocks.manage');
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'invoice_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $product->updateStock(
            $validated['quantity'],
            'Manual Input',
            $validated['description'] ?? "Input stok manual berdasarkan invoice {$validated['invoice_number']}",
            $validated['invoice_number'] ?? null
        );

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Stok berhasil ditambahkan.');
    }

    /**
     * Show stock adjustment form
     */
    public function edit(Product $product): View
    {
        $this->checkPermission('stocks.manage');
        return view('admin.stocks.edit', compact('product'));
    }

    /**
     * Update stock (adjustment)
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->checkPermission('stocks.manage');
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $newStock = $validated['stock'];
        $currentStock = $product->stock;
        $quantityChange = $newStock - $currentStock;

        if ($quantityChange != 0) {
            $product->updateStock(
                $quantityChange,
                'Adjustment',
                $validated['description'] ?? 'Penyesuaian stok manual',
                null
            );
        }

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Stok berhasil disesuaikan.');
    }

    /**
     * Show stock logs
     */
    /**
     * Show stock logs
     */
    public function logs(Request $request): View
    {
        $this->checkPermission('stocks.view');
        $products = Product::orderBy('name')->get();

        return view('admin.stocks.logs', compact('products'));
    }

    public function logsDatatable(Request $request)
    {
        $this->checkPermission('stocks.view');

        $columns = [
            0 => 'stock_logs.id',
            1 => 'stock_logs.created_at',
            2 => 'products.name',
            3 => 'stock_logs.quantity_change',
            4 => 'stock_logs.change_type',
            5 => 'stock_logs.description',
            6 => 'users.name',
        ];

        $baseQuery = StockLog::query()
            ->join('products', 'stock_logs.product_id', '=', 'products.id')
            ->leftJoin('users', 'stock_logs.created_by', '=', 'users.id')
            ->select('stock_logs.*', 'products.name as product_name', 'users.name as creator_name');

        // Apply filters
        if ($request->filled('product_id')) {
            $baseQuery->where('stock_logs.product_id', $request->product_id);
        }
        if ($request->filled('change_type')) {
            $baseQuery->where('stock_logs.change_type', $request->change_type);
        }

        $totalRecords = (clone $baseQuery)->count();

        // Filtering
        $searchValue = $request->input('search.value');
        if ($searchValue) {
            $baseQuery->where(function ($q) use ($searchValue) {
                $q->where('products.name', 'like', "%{$searchValue}%")
                  ->orWhere('stock_logs.description', 'like', "%{$searchValue}%")
                  ->orWhere('stock_logs.change_type', 'like', "%{$searchValue}%")
                  ->orWhere('users.name', 'like', "%{$searchValue}%")
                  ->orWhere('stock_logs.reference_number', 'like', "%{$searchValue}%");
            });
        }

        $filteredRecords = (clone $baseQuery)->count();

        // Ordering
        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
        $orderColumn = $columns[$orderColumnIndex] ?? 'stock_logs.created_at';
        $baseQuery->orderBy($orderColumn, $orderDir);

        // Paging
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        if ($length > 0) {
            $baseQuery->skip($start)->take($length);
        }

        $logs = $baseQuery->get();

        $data = [];
        $rowNumber = $start + 1;
        foreach ($logs as $log) {
            $change = $log->quantity_change > 0 
                ? "<span class='text-success fw-bold'>+{$log->quantity_change}</span>" 
                : "<span class='text-danger fw-bold'>{$log->quantity_change}</span>";

            $typeBadge = match($log->change_type) {
                'Manual Input' => '<span class="badge bg-primary">Manual Input</span>',
                'Stock Out' => '<span class="badge bg-warning text-dark">Stock Out</span>',
                'PO Received' => '<span class="badge bg-success">PO Received</span>',
                'Adjustment' => '<span class="badge bg-info text-dark">Adjustment</span>',
                default => "<span class='badge bg-secondary'>{$log->change_type}</span>",
            };

            $desc = $log->description;
            if ($log->reference_number) {
                $desc .= "<br><small class='text-muted'>Ref: {$log->reference_number}</small>";
            }

            $data[] = [
                $rowNumber++,
                $log->created_at->format('d M Y H:i'),
                e($log->product_name),
                $change,
                $typeBadge,
                $desc,
                e($log->creator_name ?? 'System'),
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
     * Show product stock history
     */
    public function show(Product $product): View
    {
        $this->checkPermission('stocks.view');
        $product->load(['brand', 'category']);
        return view('admin.stocks.show', compact('product'));
    }

    public function showDatatable(Request $request, Product $product)
    {
        $this->checkPermission('stocks.view');

        $columns = [
            0 => 'stock_logs.id',
            1 => 'stock_logs.created_at',
            2 => 'stock_logs.quantity_change',
            3 => 'stock_logs.change_type',
            4 => 'stock_logs.description',
            5 => 'users.name',
        ];

        $baseQuery = $product->stockLogs()
            ->leftJoin('users', 'stock_logs.created_by', '=', 'users.id')
            ->select('stock_logs.*', 'users.name as creator_name');

        $totalRecords = (clone $baseQuery)->count();

        // Filtering
        $searchValue = $request->input('search.value');
        if ($searchValue) {
            $baseQuery->where(function ($q) use ($searchValue) {
                $q->where('stock_logs.description', 'like', "%{$searchValue}%")
                  ->orWhere('stock_logs.change_type', 'like', "%{$searchValue}%")
                  ->orWhere('users.name', 'like', "%{$searchValue}%")
                  ->orWhere('stock_logs.reference_number', 'like', "%{$searchValue}%");
            });
        }

        $filteredRecords = (clone $baseQuery)->count();

        // Ordering
        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
        $orderColumn = $columns[$orderColumnIndex] ?? 'stock_logs.created_at';
        $baseQuery->orderBy($orderColumn, $orderDir);

        // Paging
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        if ($length > 0) {
            $baseQuery->skip($start)->take($length);
        }

        $logs = $baseQuery->get();

        $data = [];
        $rowNumber = $start + 1;
        foreach ($logs as $log) {
            $change = $log->quantity_change > 0 
                ? "<span class='text-success fw-bold'>+{$log->quantity_change}</span>" 
                : "<span class='text-danger fw-bold'>{$log->quantity_change}</span>";

            $typeBadge = match($log->change_type) {
                'Manual Input' => '<span class="badge bg-primary">Manual Input</span>',
                'Stock Out' => '<span class="badge bg-warning text-dark">Stock Out</span>',
                'PO Received' => '<span class="badge bg-success">PO Received</span>',
                'Adjustment' => '<span class="badge bg-info text-dark">Adjustment</span>',
                default => "<span class='badge bg-secondary'>{$log->change_type}</span>",
            };

            $desc = $log->description;
            if ($log->reference_number) {
                $desc .= "<br><small class='text-muted'>Ref: {$log->reference_number}</small>";
            }

            $data[] = [
                $rowNumber++,
                $log->created_at->format('d M Y H:i'),
                $change,
                $typeBadge,
                $desc,
                e($log->creator_name ?? 'System'),
            ];
        }

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }
}

