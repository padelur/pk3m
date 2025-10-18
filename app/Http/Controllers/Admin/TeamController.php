<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamController extends Controller
{
	public function index(): View
	{
		$teams = Team::orderBy('name')->paginate(20);
		return view('admin.teams.index', compact('teams'));
	}

	public function create(): View
	{
		return view('admin.teams.create');
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required','string','max:255'],
			'position' => ['required','string','max:255'],
			'description' => ['nullable','string'],
			'photo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
		]);
		if ($request->hasFile('photo')) {
			$validated['photo_path'] = $request->file('photo')->store('teams','public');
		}
		Team::create($validated);
		return redirect()->route('admin.teams.index')->with('success','Anggota tim ditambahkan.');
	}

	public function edit(Team $team): View
	{
		return view('admin.teams.edit', compact('team'));
	}

	public function update(Request $request, Team $team): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required','string','max:255'],
			'position' => ['required','string','max:255'],
			'description' => ['nullable','string'],
			'photo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
		]);
		if ($request->hasFile('photo')) {
			if ($team->photo_path) {
				Storage::disk('public')->delete($team->photo_path);
			}
			$validated['photo_path'] = $request->file('photo')->store('teams','public');
		}
		$team->update($validated);
		return redirect()->route('admin.teams.index')->with('success','Anggota tim diperbarui.');
	}

	public function destroy(Team $team): RedirectResponse
	{
		if ($team->photo_path) {
			Storage::disk('public')->delete($team->photo_path);
		}
		$team->delete();
		return redirect()->route('admin.teams.index')->with('success','Anggota tim dihapus.');
	}
}
