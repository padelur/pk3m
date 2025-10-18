<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BrandController extends Controller
{
	public function index(): View
	{
		$brands = Brand::orderBy('name')->paginate(20);
		return view('admin.brands.index', compact('brands'));
	}

	public function create(): View
	{
		return view('admin.brands.create');
	}

	public function store(Request $request): RedirectResponse
	{
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
		return view('admin.brands.edit', compact('brand'));
	}

	public function update(Request $request, Brand $brand): RedirectResponse
	{
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
