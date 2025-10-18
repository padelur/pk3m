<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
	public function index(): View
	{
		$categories = Category::with('brand')->orderBy('name')->paginate(20);
		return view('admin.categories.index', compact('categories'));
	}

	public function create(): View
	{
		$brands = Brand::orderBy('name')->get();
		return view('admin.categories.create', compact('brands'));
	}

	public function store(Request $request): RedirectResponse
	{
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
		$brands = Brand::orderBy('name')->get();
		return view('admin.categories.edit', compact('category','brands'));
	}

	public function update(Request $request, Category $category): RedirectResponse
	{
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
