<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\ChecksPermissions;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    use ChecksPermissions;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->checkPermission('suppliers.view');
        return view('admin.suppliers.index');
    }

    public function datatable(Request $request)
    {
        $this->checkPermission('suppliers.view');

        $columns = [
            0 => 'suppliers.id',
            1 => 'suppliers.name',
            2 => 'suppliers.address',
            3 => 'suppliers.phone',
            4 => 'suppliers.is_active',
        ];

        $baseQuery = Supplier::query()->select('suppliers.*');
        $totalRecords = (clone $baseQuery)->count();

        // Filtering
        $searchValue = $request->input('search.value');
        if ($searchValue) {
            $baseQuery->where(function ($q) use ($searchValue) {
                $q->where('suppliers.name', 'like', "%{$searchValue}%")
                  ->orWhere('suppliers.address', 'like', "%{$searchValue}%")
                  ->orWhere('suppliers.phone', 'like', "%{$searchValue}%")
                  ->orWhere('suppliers.email', 'like', "%{$searchValue}%");
            });
        }

        $filteredRecords = (clone $baseQuery)->count();

        // Ordering
        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
        $orderColumn = $columns[$orderColumnIndex] ?? 'suppliers.id';
        $baseQuery->orderBy($orderColumn, $orderDir);

        // Paging
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        if ($length > 0) {
            $baseQuery->skip($start)->take($length);
        }

        $suppliers = $baseQuery->get();

        $data = [];
        $rowNumber = $start + 1;
        foreach ($suppliers as $supplier) {
            $address = \Illuminate\Support\Str::limit($supplier->address, 50) ?? '-';
            
            $contact = '';
            if ($supplier->phone) {
                $contact .= '<div><i class="fas fa-phone me-1"></i>' . e($supplier->phone) . '</div>';
            }
            if ($supplier->email) {
                $contact .= '<div><i class="fas fa-envelope me-1"></i>' . e($supplier->email) . '</div>';
            }
            if (empty($contact)) {
                $contact = '-';
            }

            $status = $supplier->is_active 
                ? '<span class="badge bg-success">Aktif</span>' 
                : '<span class="badge bg-secondary">Nonaktif</span>';
            
            $actions = view('admin.suppliers.partials.actions', ['supplier' => $supplier])->render();

            $data[] = [
                $rowNumber++,
                '<strong>' . e($supplier->name) . '</strong>',
                $address,
                $contact,
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
        $this->checkPermission('suppliers.create');
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkPermission('suppliers.create');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Supplier::create($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): View
    {
        $this->checkPermission('suppliers.view');
        $supplier->load('purchaseOrders.items.product');
        return view('admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier): View
    {
        $this->checkPermission('suppliers.edit');
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $this->checkPermission('suppliers.edit');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $supplier->update($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier): RedirectResponse
    {
        $this->checkPermission('suppliers.delete');
        // Check if supplier has purchase orders
        if ($supplier->purchaseOrders()->count() > 0) {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'Tidak dapat menghapus supplier yang memiliki Purchase Order.');
        }

        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
