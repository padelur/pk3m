<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerController extends Controller
{
	public function index(): View
	{
		$careers = Career::orderByDesc('id')->paginate(20);
		return view('admin.careers.index', compact('careers'));
	}

	public function create(): View
	{
		return view('admin.careers.create');
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'title' => ['required','string','max:255'],
			'description' => ['nullable','string'],
			'requirements' => ['nullable','string'],
			'status' => ['required','in:open,closed'],
			'closing_date' => ['nullable','date'],
		]);
		Career::create($validated);
		return redirect()->route('admin.careers.index')->with('success','Lowongan ditambahkan.');
	}

	public function edit(Career $career): View
	{
		return view('admin.careers.edit', compact('career'));
	}

	public function update(Request $request, Career $career): RedirectResponse
	{
		$validated = $request->validate([
			'title' => ['required','string','max:255'],
			'description' => ['nullable','string'],
			'requirements' => ['nullable','string'],
			'status' => ['required','in:open,closed'],
			'closing_date' => ['nullable','date'],
		]);
		$career->update($validated);
		return redirect()->route('admin.careers.index')->with('success','Lowongan diperbarui.');
	}

	public function destroy(Career $career): RedirectResponse
	{
		$career->delete();
		return redirect()->route('admin.careers.index')->with('success','Lowongan dihapus.');
	}
}
