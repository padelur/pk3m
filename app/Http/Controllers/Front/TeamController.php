<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Team;
use Illuminate\View\View;

class TeamController extends Controller
{
	public function index(): View
	{
		$members = Team::orderBy('name')->get();
		$settings = Setting::first();
		return view('front.team.index', compact('members', 'settings'));
	}
}
