<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

use App\Http\Controllers\Admin\Traits\ChecksPermissions;

class BrandController extends Controller
{
    use ChecksPermissions;

	public function index(): View
	{
        $this->checkPermission('brands.view');
		return view('admin.brands.index');
	}

	public function datatable(Request $request)
	{
        $this->checkPermission('brands.view');
		$columns = [
			0 => 'brands.id',
// ... (rest of datatable logic unchanged, just permissions check added)
			1 => 'brands.name',
			2 => 'brands.slug',
			3 => 'brands.logo_path',
		];

		$baseQuery = Brand::query()->select('brands.*');
		$totalRecords = (clone $baseQuery)->count();

		// Filtering
		$searchValue = $request->input('search.value');
		if ($searchValue) {
			$baseQuery->where(function ($q) use ($searchValue) {
				$q->where('brands.name', 'like', "%{$searchValue}%")
				  ->orWhere('brands.slug', 'like', "%{$searchValue}%");
			});
		}

		$filteredRecords = (clone $baseQuery)->count();

		// Ordering
		$orderColumnIndex = (int) $request->input('order.0.column', 0);
		$orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
		$orderColumn = $columns[$orderColumnIndex] ?? 'brands.id';
		$baseQuery->orderBy($orderColumn, $orderDir);

		// Paging
		$start = (int) $request->input('start', 0);
		$length = (int) $request->input('length', 10);
		if ($length > 0) {
			$baseQuery->skip($start)->take($length);
		}

		$brands = $baseQuery->get();

		$data = [];
		$rowNumber = $start + 1;
		foreach ($brands as $brand) {
			$logo = $brand->logo_path 
				? '<img src="' . Storage::url($brand->logo_path) . '" alt="logo" style="height:32px">' 
				: '-';
			
			$actions = view('admin.brands.partials.actions', ['brand' => $brand])->render();

			$data[] = [
				$rowNumber++,
				e($brand->name),
				e($brand->slug),
				$logo,
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
        $this->checkPermission('brands.create');
		return view('admin.brands.create');
	}

	public function store(Request $request): RedirectResponse
	{
        $this->checkPermission('brands.create');
		$validated = $request->validate([
			'name' => ['required','string','max:255'],
			'description' => ['nullable','string'],
			'logo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
		]);

		$validated['slug'] = $this->uniqueSlug(Str::slug($validated['name']));
		if ($request->hasFile('logo')) {
			$validated['logo_path'] = $request->file('logo')->store('brands','public');
		}

		Brand::create($validated);
		return redirect()->route('admin.brands.index')->with('success','Brand ditambahkan.');
	}

	public function edit(Brand $brand): View
	{
        $this->checkPermission('brands.edit');
		return view('admin.brands.edit', compact('brand'));
	}

	public function update(Request $request, Brand $brand): RedirectResponse
	{
        $this->checkPermission('brands.edit');
		$validated = $request->validate([
			'name' => ['required','string','max:255'],
			'description' => ['nullable','string'],
			'logo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
		]);

		$slug = Str::slug($validated['name']);
		if ($slug !== $brand->slug) {
			$validated['slug'] = $this->uniqueSlug($slug, $brand->id);
		}
		if ($request->hasFile('logo')) {
			if ($brand->logo_path) {
				Storage::disk('public')->delete($brand->logo_path);
			}
			$validated['logo_path'] = $request->file('logo')->store('brands','public');
		}

		$brand->update($validated);
		return redirect()->route('admin.brands.index')->with('success','Brand diperbarui.');
	}

	public function destroy(Brand $brand): RedirectResponse
	{
        $this->checkPermission('brands.delete');
		if ($brand->logo_path) {
			Storage::disk('public')->delete($brand->logo_path);
		}
		$brand->delete();
		return redirect()->route('admin.brands.index')->with('success','Brand dihapus.');
	}

	private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
	{
		$slug = $baseSlug;
		$counter = 1;
		while (Brand::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id','!=',$ignoreId))->exists()) {
			$slug = $baseSlug.'-'.$counter++;
		}
		return $slug;
	}
}
