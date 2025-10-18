<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
	public function index(): View
	{
		$products = Product::with(['brand','category'])->orderByDesc('id')->paginate(20);
		return view('admin.products.index', compact('products'));
	}

	public function create(): View
	{
		$brands = Brand::orderBy('name')->get();
		$categories = Category::orderBy('name')->get();
		return view('admin.products.create', compact('brands','categories'));
	}

	public function store(Request $request): RedirectResponse
	{
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
		$brands = Brand::orderBy('name')->get();
		$categories = Category::orderBy('name')->get();
		return view('admin.products.edit', compact('product','brands','categories'));
	}

	public function update(Request $request, Product $product): RedirectResponse
	{
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
