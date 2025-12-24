<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\ChecksPermissions;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
	use ChecksPermissions;

	public function index(): View
	{
		$this->checkPermission('products.view');
		return view('admin.products.index');
	}

	public function datatable(Request $request): JsonResponse
	{
		$this->checkPermission('products.view');

		$columns = [
			0 => 'products.id',
			1 => 'products.name',
			2 => 'brands.name',
			3 => 'categories.name',
			4 => 'products.price',
			5 => 'products.stock',
			6 => 'products.is_active',
		];

		$baseQuery = Product::query()
			->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
			->leftJoin('categories', 'products.category_id', '=', 'categories.id')
			->select(
				'products.*',
				'brands.name as brand_name',
				'categories.name as category_name'
			);

		$totalRecords = (clone $baseQuery)->count();

		// Filtering
		$searchValue = $request->input('search.value');
		if ($searchValue) {
			$baseQuery->where(function ($q) use ($searchValue) {
				$q->where('products.name', 'like', "%{$searchValue}%")
					->orWhere('categories.name', 'like', "%{$searchValue}%")
					->orWhere('products.description', 'like', "%{$searchValue}%")
					->orWhereRaw('CAST(products.price AS CHAR) LIKE ?', ["%{$searchValue}%"]);
			});
		}

		$filteredRecords = (clone $baseQuery)->count();

		// Ordering
		$orderColumnIndex = (int) $request->input('order.0.column', 0);
		$orderDir = $request->input('order.0.dir', 'desc') === 'asc' ? 'asc' : 'desc';
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
		$rowNumber = $start + 1; // Start numbering from current page offset
		foreach ($products as $product) {
			$actions = view('admin.products.partials.actions', ['product' => $product])->render();

			$data[] = [
				$rowNumber++, // Sequential row number instead of ID
				e($product->name),
				e($product->brand_name ?? '-'),
				e($product->category_name ?? '-'),
				$product->price !== null ? 'Rp ' . number_format($product->price, 0, ',', '.') : '-',
				$product->stock,
				$product->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>',
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
		$this->checkPermission('products.create');
		$brands = Brand::orderBy('name')->get();
		$categories = Category::orderBy('name')->get();
		return view('admin.products.create', compact('brands','categories'));
	}

	public function store(Request $request): RedirectResponse
	{
		$this->checkPermission('products.create');
		$validated = $request->validate([
			'name' => ['required','string','max:255'],
			'brand_id' => ['required','exists:brands,id'],
			'category_id' => ['required','exists:categories,id'],
			'description' => ['nullable','string'],
			'size' => ['nullable','string','max:255'],
			'price' => ['nullable','numeric','min:0'],
			'stock' => ['required','integer','min:0'],
			'e_catalog_url' => ['nullable','url'],
			'is_active' => ['sometimes','boolean'],
			'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
			'pdf' => ['nullable','mimes:pdf','max:5120'],
		]);

		$slug = Str::slug($validated['name']);
		$validated['slug'] = $this->uniqueSlug($slug);
		$validated['is_active'] = $request->boolean('is_active');

		$imagePath = null;
		$pdfPath = null;
		if ($request->hasFile('image')) {
			$imagePath = $request->file('image')->store('products/images','public');
		}
		if ($request->hasFile('pdf')) {
			$pdfPath = $request->file('pdf')->store('products/pdfs','public');
		}
		$validated['image_path'] = $imagePath;
		$validated['pdf_path'] = $pdfPath;

		$product = Product::create($validated);

		$this->logAudit($product, 'create', [], $product->toArray());

		return redirect()->route('admin.products.index')->with('success','Produk berhasil ditambahkan.');
	}

	public function edit(Product $product): View
	{
		$this->checkPermission('products.edit');
		$brands = Brand::orderBy('name')->get();
		$categories = Category::orderBy('name')->get();
		return view('admin.products.edit', compact('product','brands','categories'));
	}

	public function update(Request $request, Product $product): RedirectResponse
	{
		$this->checkPermission('products.edit');
		$validated = $request->validate([
			'name' => ['required','string','max:255'],
			'brand_id' => ['required','exists:brands,id'],
			'category_id' => ['required','exists:categories,id'],
			'description' => ['nullable','string'],
			'size' => ['nullable','string','max:255'],
			'price' => ['nullable','numeric','min:0'],
			'stock' => ['required','integer','min:0'],
			'e_catalog_url' => ['nullable','url'],
			'is_active' => ['sometimes','boolean'],
			'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
			'pdf' => ['nullable','mimes:pdf','max:5120'],
		]);

		$old = $product->replicate()->toArray();

		$slug = Str::slug($validated['name']);
		if ($slug !== $product->slug) {
			$validated['slug'] = $this->uniqueSlug($slug, $product->id);
		}
		$validated['is_active'] = $request->boolean('is_active');

		if ($request->hasFile('image')) {
			if ($product->image_path) {
				Storage::disk('public')->delete($product->image_path);
			}
			$validated['image_path'] = $request->file('image')->store('products/images','public');
		}
		if ($request->hasFile('pdf')) {
			if ($product->pdf_path) {
				Storage::disk('public')->delete($product->pdf_path);
			}
			$validated['pdf_path'] = $request->file('pdf')->store('products/pdfs','public');
		}

		$product->update($validated);

		$this->logAudit($product, 'update', $old, $product->toArray());

		return redirect()->route('admin.products.index')->with('success','Produk berhasil diperbarui.');
	}

	public function destroy(Product $product): RedirectResponse
	{
		$this->checkPermission('products.delete');
		$old = $product->toArray();
		if ($product->image_path) {
			Storage::disk('public')->delete($product->image_path);
		}
		if ($product->pdf_path) {
			Storage::disk('public')->delete($product->pdf_path);
		}
		$product->delete();

		$this->logAudit($product, 'delete', $old, []);

		return redirect()->route('admin.products.index')->with('success','Produk berhasil dihapus.');
	}

	public function history(Product $product): View
	{
		$this->checkPermission('products.view');
		$auditLogs = $product->audits()->with('user')->orderByDesc('created_at')->paginate(30);
		return view('admin.products.history', compact('product','auditLogs'));
	}

	private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
	{
		$slug = $baseSlug;
		$counter = 1;
		while (Product::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id','!=',$ignoreId))->exists()) {
			$slug = $baseSlug.'-'.$counter++;
		}
		return $slug;
	}

	private function logAudit(Product $product, string $action, array $oldValues, array $newValues): void
	{
		$changes = [
			'old' => $oldValues,
			'new' => $newValues,
		];
		ProductAudit::create([
			'product_id' => $product->id,
			'user_id' => Auth::id() ?? 1,
			'action' => $action,
			'changes' => $changes,
		]);
	}
}
