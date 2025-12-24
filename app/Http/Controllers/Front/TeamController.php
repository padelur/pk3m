<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Team;
use Illuminate\View\View;

use App\Models\Career;
use App\Models\Event;

class TeamController extends Controller
{
	public function index(): View
	{
		$members = Team::orderBy('name')->get();
		$settings = Setting::first();
		$jobs = Career::where('status', 'open')->orderBy('closing_date')->get();
		$events = Event::latest('date')->get();

		// Group members by division
		$groupedMembers = [
			'Marketing Executive' => $members->where('division', 'Marketing Executive'),
			'Manajemen' => $members->where('division', 'Manajemen'),
			'Back Office' => $members->where('division', 'Back Office'),
			'Head Support' => $members->where('division', 'Head Support'),
			'Lainnya' => $members->whereNull('division')->whereNotIn('division', ['Marketing Executive', 'Manajemen', 'Back Office', 'Head Support']),
		];

		return view('front.team.index', compact('groupedMembers', 'settings', 'jobs', 'events'));
	}
}
