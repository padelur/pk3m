<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use App\Http\Controllers\Admin\Traits\ChecksPermissions;

class TeamController extends Controller
{
    use ChecksPermissions;

	public function index(): View
	{
        $this->checkPermission('teams.view');
		return view('admin.teams.index');
	}

	public function datatable(Request $request)
	{
        $this->checkPermission('teams.view');
		$columns = [
			0 => 'teams.id',
// ...
			1 => 'teams.name',
			2 => 'teams.division',
			3 => 'teams.photo_path',
		];

		$baseQuery = Team::query()->select('teams.*');
		$totalRecords = (clone $baseQuery)->count();

		// Filtering
		$searchValue = $request->input('search.value');
		if ($searchValue) {
			$baseQuery->where(function ($q) use ($searchValue) {
						$q->where('teams.name', 'like', "%{$searchValue}%")
				  ->orWhere('teams.division', 'like', "%{$searchValue}%");
			});
		}

		$filteredRecords = (clone $baseQuery)->count();

		// Ordering
		$orderColumnIndex = (int) $request->input('order.0.column', 0);
		$orderDir = $request->input('order.0.dir', 'asc') === 'asc' ? 'asc' : 'desc';
		$orderColumn = $columns[$orderColumnIndex] ?? 'teams.id';
		$baseQuery->orderBy($orderColumn, $orderDir);

		// Paging
		$start = (int) $request->input('start', 0);
		$length = (int) $request->input('length', 10);
		if ($length > 0) {
			$baseQuery->skip($start)->take($length);
		}

		$teams = $baseQuery->get();

		$data = [];
		$rowNumber = $start + 1;
		foreach ($teams as $team) {
			$photo = $team->photo_path 
				? '<img src="' . Storage::url($team->photo_path) . '" alt="foto" style="height:32px">' 
				: '-';
			
			$actions = view('admin.teams.partials.actions', ['team' => $team])->render();

			$data[] = [
				$rowNumber++,
				e($team->name),
				e($team->division ?? '-'),
				$photo,
				$actions,
			];
		}

		return response()->json([
			'draw' => (int) $request->input('draw'),
			'recordsTotal' => $totalRecords,
			'recordsFiltered' => $filteredRecords,
			'data' => $data,
		]);
	}

	public function create(): View
	{
        $this->checkPermission('teams.create');
		return view('admin.teams.create');
	}

	public function store(Request $request): RedirectResponse
	{
        $this->checkPermission('teams.create');
		$validated = $request->validate([
			'name' => ['required','string','max:255'],
			'division' => ['required','string','in:Manajemen,Marketing Executive,Back Office,Head Support'],
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
        $this->checkPermission('teams.edit');
		return view('admin.teams.edit', compact('team'));
	}

	public function update(Request $request, Team $team): RedirectResponse
	{
        $this->checkPermission('teams.edit');
		$validated = $request->validate([
			'name' => ['required','string','max:255'],
			'division' => ['required','string','in:Manajemen,Marketing Executive,Back Office,Head Support'],
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
        $this->checkPermission('teams.delete');
		if ($team->photo_path) {
			Storage::disk('public')->delete($team->photo_path);
		}
		$team->delete();
		return redirect()->route('admin.teams.index')->with('success','Anggota tim dihapus.');
	}
}
