<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    	public function index()
	{
		if (!auth()->user()->isSuperAdmin()) {
			abort(403, 'Unauthorized access. Only Super Admin can manage users.');
		}

		return view('admin.users.index');
	}

	public function datatable(Request $request)
	{
		if (!auth()->user()->isSuperAdmin()) {
			abort(403, 'Unauthorized access.');
		}

		$columns = [
			0 => 'users.id',
			1 => 'users.name',
			2 => 'users.email',
			3 => 'users.role',
			4 => 'users.is_active',
		];

		$baseQuery = User::where('role', 'admin');
		$totalRecords = (clone $baseQuery)->count();

		// Filtering
		$searchValue = $request->input('search.value');
		if ($searchValue) {
			$baseQuery->where(function ($q) use ($searchValue) {
				$q->where('users.name', 'like', "%{$searchValue}%")
				  ->orWhere('users.email', 'like', "%{$searchValue}%");
			});
		}

		$filteredRecords = (clone $baseQuery)->count();

		// Ordering
		$orderColumnIndex = (int) $request->input('order.0.column', 0);
		$orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
		$orderColumn = $columns[$orderColumnIndex] ?? 'users.id';
		$baseQuery->orderBy($orderColumn, $orderDir);

		// Paging
		$start = (int) $request->input('start', 0);
		$length = (int) $request->input('length', 10);
		if ($length > 0) {
			$baseQuery->skip($start)->take($length);
		}

		$users = $baseQuery->get();

		$data = [];
		$rowNumber = $start + 1;
		foreach ($users as $user) {
			$status = $user->is_active 
				? '<span class="badge bg-success">Aktif</span>' 
				: '<span class="badge bg-secondary">Nonaktif</span>';
			
			$role = '<span class="badge bg-info">' . ucfirst($user->role) . '</span>';
			
			$actions = view('admin.users.partials.actions', ['user' => $user])->render();

			$data[] = [
				$rowNumber++,
				e($user->name),
				e($user->email),
				$role,
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
    public function create()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admin can manage users.');
        }

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admin can manage users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admin can manage users.');
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admin can manage users.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admin can manage users.');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat mengubah data Super Admin.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'sometimes|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->has('permissions')) {
            $data['permissions'] = $request->permissions;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admin can manage users.');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus Super Admin.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin berhasil dihapus.');
    }

    /**
     * Toggle user active status
     */
    public function toggleActive(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admin can manage users.');
        }

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Tidak dapat menonaktifkan Super Admin.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Admin berhasil {$status}.");
    }

    /**
     * Show permissions form
     */
    public function permissions(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admin can manage users.');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Super Admin memiliki semua akses.');
        }

        $availablePermissions = [
            'Produk' => [
                'products.view' => 'Lihat Produk',
                'products.create' => 'Tambah Produk',
                'products.edit' => 'Edit Produk',
                'products.delete' => 'Hapus Produk',
            ],
            'Kategori' => [
                'categories.view' => 'Lihat Kategori',
                'categories.create' => 'Tambah Kategori',
                'categories.edit' => 'Edit Kategori',
                'categories.delete' => 'Hapus Kategori',
            ],
            'Supplier' => [
                'suppliers.view' => 'Lihat Supplier',
                'suppliers.create' => 'Tambah Supplier',
                'suppliers.edit' => 'Edit Supplier',
                'suppliers.delete' => 'Hapus Supplier',
            ],
            'Purchase Order' => [
                'purchase_orders.view' => 'Lihat Purchase Order',
                'purchase_orders.create' => 'Buat Purchase Order',
                'purchase_orders.approve' => 'Setujui Purchase Order',
                'purchase_orders.receive' => 'Terima Barang PO',
            ],
            'Stok' => [
                'stocks.view' => 'Lihat Stok',
                'stocks.manage' => 'Kelola Stok',
            ],
            'Stok Keluar' => [
                'stock_outs.view' => 'Lihat Stok Keluar',
                'stock_outs.create' => 'Buat Stok Keluar',
                'stock_outs.approve' => 'Setujui Stok Keluar',
                'stock_outs.complete' => 'Selesaikan Stok Keluar',
            ],
            'Brand' => [
                'brands.view' => 'Lihat Brand',
                'brands.create' => 'Tambah Brand',
                'brands.edit' => 'Edit Brand',
                'brands.delete' => 'Hapus Brand',
            ],
            'Tim' => [
                'teams.view' => 'Lihat Tim',
                'teams.create' => 'Tambah Anggota Tim',
                'teams.edit' => 'Edit Anggota Tim',
                'teams.delete' => 'Hapus Anggota Tim',
            ],
            'Karir' => [
                'careers.view' => 'Lihat Karir',
                'careers.create' => 'Tambah Karir',
                'careers.edit' => 'Edit Karir',
                'careers.delete' => 'Hapus Karir',
            ],
            'Event' => [
                'events.view' => 'Lihat Event',
                'events.create' => 'Tambah Event',
                'events.edit' => 'Edit Event',
                'events.delete' => 'Hapus Event',
            ],
            'Pengaturan' => [
                'settings.view' => 'Lihat Pengaturan',
                'settings.edit' => 'Edit Pengaturan',
            ],
        ];

        return view('admin.users.permissions', compact('user', 'availablePermissions'));
    }

    /**
     * Update user permissions
     */
    public function updatePermissions(Request $request, User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only Super Admin can manage users.');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Super Admin memiliki semua akses.');
        }

        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $user->setPermissions($request->permissions ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', 'Hak akses admin berhasil diperbarui.');
    }
}
