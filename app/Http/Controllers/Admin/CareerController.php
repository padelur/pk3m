<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Controllers\Admin\Traits\ChecksPermissions;

class CareerController extends Controller
{
    use ChecksPermissions;

	public function index(): View
	{
        $this->checkPermission('careers.view');
		return view('admin.careers.index');
	}

	public function datatable(Request $request)
	{
        $this->checkPermission('careers.view');
		$columns = [
			0 => 'careers.id',
			1 => 'careers.title',
			2 => 'careers.status',
			3 => 'careers.closing_date',
		];

		$baseQuery = Career::query()->select('careers.*');
		$totalRecords = (clone $baseQuery)->count();

		// Filtering
		$searchValue = $request->input('search.value');
		if ($searchValue) {
			$baseQuery->where(function ($q) use ($searchValue) {
				$q->where('careers.title', 'like', "%{$searchValue}%")
				  ->orWhere('careers.status', 'like', "%{$searchValue}%");
			});
		}

		$filteredRecords = (clone $baseQuery)->count();

		// Ordering
		$orderColumnIndex = (int) $request->input('order.0.column', 0);
		$orderDir = $request->input('order.0.dir', 'desc') === 'asc' ? 'asc' : 'desc';
		$orderColumn = $columns[$orderColumnIndex] ?? 'careers.id';
		$baseQuery->orderBy($orderColumn, $orderDir);

		// Paging
		$start = (int) $request->input('start', 0);
		$length = (int) $request->input('length', 10);
		if ($length > 0) {
			$baseQuery->skip($start)->take($length);
		}

		$careers = $baseQuery->get();

		$data = [];
		$rowNumber = $start + 1;
		foreach ($careers as $career) {
			$statusBadge = $career->status === 'open' 
				? '<span class="badge bg-success">open</span>' 
				: '<span class="badge bg-secondary">closed</span>';
			
			$actions = view('admin.careers.partials.actions', ['career' => $career])->render();

			$data[] = [
				$rowNumber++,
				e($career->title),
				$statusBadge,
				$career->closing_date ?? '-',
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
        $this->checkPermission('careers.create');
		return view('admin.careers.create');
	}

	public function store(Request $request): RedirectResponse
	{
        $this->checkPermission('careers.create');
		$validated = $request->validate([
			'title' => ['required','string','max:255'],
			'description' => ['nullable','string'],
			'requirements' => ['nullable','string'],
			'status' => ['required','in:open,closed'],
			'closing_date' => ['nullable','date'],
			'recruitment_link' => ['nullable','url'],
		]);
		Career::create($validated);
		return redirect()->route('admin.careers.index')->with('success','Lowongan ditambahkan.');
	}

	public function edit(Career $career): View
	{
        $this->checkPermission('careers.edit');
		return view('admin.careers.edit', compact('career'));
	}

	public function update(Request $request, Career $career): RedirectResponse
	{
        $this->checkPermission('careers.edit');
		$validated = $request->validate([
			'title' => ['required','string','max:255'],
			'description' => ['nullable','string'],
			'requirements' => ['nullable','string'],
			'status' => ['required','in:open,closed'],
			'closing_date' => ['nullable','date'],
			'recruitment_link' => ['nullable','url'],
		]);
		$career->update($validated);
		return redirect()->route('admin.careers.index')->with('success','Lowongan diperbarui.');
	}

	public function destroy(Career $career): RedirectResponse
	{
        $this->checkPermission('careers.delete');
		$career->delete();
		return redirect()->route('admin.careers.index')->with('success','Lowongan dihapus.');
	}
}
