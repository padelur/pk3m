<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Setting;
use Illuminate\View\View;

class CareerController extends Controller
{
	public function index(): View
	{
		$jobs = Career::where('status', 'open')->orderBy('closing_date')->paginate(10);
		$settings = Setting::first();
		return view('front.careers.index', compact('jobs', 'settings'));
	}

	public function show(int $id): View
	{
		$job = Career::findOrFail($id);
		$settings = Setting::first();
		return view('front.careers.show', compact('job', 'settings'));
	}
}
