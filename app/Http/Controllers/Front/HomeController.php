<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
	public function index(): View
	{
		$settings = Setting::first();
		$brands = Brand::orderBy('name')->get();
		$categories = Category::orderBy('name')->get();
		$products = Product::publicVisible()->get();
		
		// Ambil 3 produk dengan kategori berbeda
		$featuredProducts = collect();
		$usedCategoryIds = [];
		
		// Ambil produk terbaru dengan kategori berbeda
		$allProducts = Product::with(['brand', 'category'])
			->publicVisible()
			->latest()
			->get();
		
		foreach ($allProducts as $product) {
			if ($featuredProducts->count() >= 3) {
				break;
			}
			
			// Hanya ambil jika kategori belum digunakan dan produk memiliki kategori
			if ($product->category_id && !in_array($product->category_id, $usedCategoryIds)) {
				$featuredProducts->push($product);
				$usedCategoryIds[] = $product->category_id;
			}
		}
		
		return view('front.home', compact('settings', 'brands', 'categories', 'products', 'featuredProducts'));
	}

	public function history(): View
	{
		$settings = Setting::first();
		return view('front.history', compact('settings'));
	}
}
