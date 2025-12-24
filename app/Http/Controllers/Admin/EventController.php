<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use App\Http\Controllers\Admin\Traits\ChecksPermissions;

class EventController extends Controller
{
    use ChecksPermissions;

    public function index(): View
    {
        $this->checkPermission('events.view');
        return view('admin.events.index');
    }

    public function datatable(Request $request)
    {
        $this->checkPermission('events.view');
        $columns = [
            0 => 'events.id',
            1 => 'events.name',
            2 => 'events.date',
        ];

        $baseQuery = Event::query()->select('events.*');
        $totalRecords = (clone $baseQuery)->count();

        // Filtering
        $searchValue = $request->input('search.value');
        if ($searchValue) {
            $baseQuery->where(function ($q) use ($searchValue) {
                $q->where('events.name', 'like', "%{$searchValue}%")
                  ->orWhere('events.description', 'like', "%{$searchValue}%");
            });
        }

        $filteredRecords = (clone $baseQuery)->count();

        // Ordering
        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc') === 'asc' ? 'asc' : 'desc';
        $orderColumn = $columns[$orderColumnIndex] ?? 'events.id';
        $baseQuery->orderBy($orderColumn, $orderDir);

        // Paging
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        if ($length > 0) {
            $baseQuery->skip($start)->take($length);
        }

        $events = $baseQuery->get();

        $data = [];
        $rowNumber = $start + 1;
        foreach ($events as $event) {
            $image = $event->image_path 
                ? '<img src="'.Storage::url($event->image_path).'" height="50" class="rounded">' 
                : '-';
            
            $actions = view('admin.events.partials.actions', ['event' => $event])->render();

            $data[] = [
                $rowNumber++,
                $image,
                e($event->name),
                $event->date ? \Carbon\Carbon::parse($event->date)->format('d M Y') : '-',
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
        $this->checkPermission('events.create');
        return view('admin.events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkPermission('events.create');
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image' => ['required','image','max:2048'], // 2MB Max
            'date' => ['nullable','date'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('events', 'public');
        }

        Event::create($validated);
        return redirect()->route('admin.events.index')->with('success','Event ditambahkan.');
    }

    public function edit(Event $event): View
    {
        $this->checkPermission('events.edit');
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $this->checkPermission('events.edit');
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image' => ['nullable','image','max:2048'],
            'date' => ['nullable','date'],
        ]);

        if ($request->hasFile('image')) {
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);
        return redirect()->route('admin.events.index')->with('success','Event diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->checkPermission('events.delete');
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success','Event dihapus.');
    }
}
