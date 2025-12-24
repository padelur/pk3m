<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\ChecksPermissions;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
	use ChecksPermissions;

	public function index(): View
	{
		$this->checkPermission('categories.view');
		return view('admin.categories.index');
	}

	public function datatable(Request $request)
	{
		$this->checkPermission('categories.view');

		$columns = [
			0 => 'categories.id',
			1 => 'categories.name',
			2 => 'categories.slug',
			3 => 'brands.name',
		];

		$baseQuery = Category::query()
			->leftJoin('brands', 'categories.brand_id', '=', 'brands.id')
			->select('categories.*', 'brands.name as brand_name');
		
		$totalRecords = (clone $baseQuery)->count();

		// Filtering
		$searchValue = $request->input('search.value');
		if ($searchValue) {
			$baseQuery->where(function ($q) use ($searchValue) {
				$q->where('categories.name', 'like', "%{$searchValue}%")
				  ->orWhere('categories.slug', 'like', "%{$searchValue}%")
				  ->orWhere('brands.name', 'like', "%{$searchValue}%");
			});
		}

		$filteredRecords = (clone $baseQuery)->count();

		// Ordering
		$orderColumnIndex = (int) $request->input('order.0.column', 0);
		$orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
		$orderColumn = $columns[$orderColumnIndex] ?? 'categories.id';
		$baseQuery->orderBy($orderColumn, $orderDir);

		// Paging
		$start = (int) $request->input('start', 0);
		$length = (int) $request->input('length', 10);
		if ($length > 0) {
			$baseQuery->skip($start)->take($length);
		}

		$categories = $baseQuery->get();

		$data = [];
		$rowNumber = $start + 1;
		foreach ($categories as $category) {
			$actions = view('admin.categories.partials.actions', ['category' => $category])->render();

			$data[] = [
				$rowNumber++,
				e($category->name),
				e($category->slug),
				e($category->brand_name ?? '-'),
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
		$this->checkPermission('categories.create');
		$brands = Brand::orderBy('name')->get();
		return view('admin.categories.create', compact('brands'));
	}

	public function store(Request $request): RedirectResponse
	{
		$this->checkPermission('categories.create');
		$validated = $request->validate([
			'brand_id' => ['required','exists:brands,id'],
			'name' => ['required','string','max:255'],
			'description' => ['nullable','string'],
		]);

		$validated['slug'] = $this->uniqueSlug(Str::slug($validated['name']));
		Category::create($validated);
		return redirect()->route('admin.categories.index')->with('success','Kategori ditambahkan.');
	}

	public function edit(Category $category): View
	{
		$this->checkPermission('categories.edit');
		$brands = Brand::orderBy('name')->get();
		return view('admin.categories.edit', compact('category','brands'));
	}

	public function update(Request $request, Category $category): RedirectResponse
	{
		$this->checkPermission('categories.edit');
		$validated = $request->validate([
			'brand_id' => ['required','exists:brands,id'],
			'name' => ['required','string','max:255'],
			'description' => ['nullable','string'],
		]);

		$slug = Str::slug($validated['name']);
		if ($slug !== $category->slug) {
			$validated['slug'] = $this->uniqueSlug($slug, $category->id);
		}
		$category->update($validated);
		return redirect()->route('admin.categories.index')->with('success','Kategori diperbarui.');
	}

	public function destroy(Category $category): RedirectResponse
	{
		$this->checkPermission('categories.delete');
		$category->delete();
		return redirect()->route('admin.categories.index')->with('success','Kategori dihapus.');
	}

	private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
	{
		$slug = $baseSlug;
		$counter = 1;
		while (Category::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id','!=',$ignoreId))->exists()) {
			$slug = $baseSlug.'-'.$counter++;
		}
		return $slug;
	}
}
