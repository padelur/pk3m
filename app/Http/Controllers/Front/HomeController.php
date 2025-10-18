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
		$featuredProducts = Product::with(['brand', 'category'])->publicVisible()->latest()->take(6)->get();
		return view('front.home', compact('settings', 'brands', 'categories', 'featuredProducts'));
	}

	public function history(): View
	{
		$settings = Setting::first();
		return view('front.history', compact('settings'));
	}
}
