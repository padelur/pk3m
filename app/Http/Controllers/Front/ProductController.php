<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
	public function index(Request $request): View
	{
		$search = $request->query('search');
		$categoryId = $request->query('category');
		$brandSlug = $request->query('brand');

		$query = Product::publicVisible()->with(['brand', 'category']);

		// Search functionality
		if ($search) {
			$query->where(function($q) use ($search) {
				$q->where('name', 'like', "%{$search}%")
				  ->orWhere('description', 'like', "%{$search}%")
				  ->orWhereHas('category', function($categoryQuery) use ($search) {
					  $categoryQuery->where('name', 'like', "%{$search}%");
				  })
				  ->orWhereHas('brand', function($brandQuery) use ($search) {
					  $brandQuery->where('name', 'like', "%{$search}%");
				  });
			});
		}

		// Filter by category
		if ($categoryId) {
			$query->where('category_id', $categoryId);
		}

		// Filter by brand
		if ($brandSlug) {
			$query->whereHas('brand', fn($q) => $q->where('slug', $brandSlug));
		}

		$products = $query->orderBy('name')->paginate(12)->withQueryString();
		$brands = Brand::orderBy('name')->get();
		$categories = Category::orderBy('name')->get();
		$settings = Setting::first();

		return view('front.products.index', compact('products', 'brands', 'categories', 'search', 'categoryId', 'brandSlug', 'settings'));
	}

	public function show(string $slug): View
	{
		$product = Product::publicVisible()->with(['brand', 'category'])->where('slug', $slug)->firstOrFail();
		$settings = Setting::first();
		return view('front.products.show', compact('product', 'settings'));
	}
}
