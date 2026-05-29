<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EventStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventSaveRequest;
use App\Http\Requests\Admin\EventStatusRequest;
use App\Models\Avenue;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->string('sort')->toString();
        $dir = $request->string('dir')->toString() === 'asc' ? 'asc' : 'desc';
        $allowedSorts = ['title', 'start_at', 'event_status', 'created_at'];
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'created_at';

        $events = Event::with(['category', 'avenue', 'creator'])
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('title', 'like', '%'.$term.'%')
                        ->orWhere('description', 'like', '%'.$term.'%')
                        ->orWhere('event_status', 'like', '%'.$term.'%')
                        ->orWhereHas('category', fn ($cat) => $cat->where('name', 'like', '%'.$term.'%'))
                        ->orWhereHas('avenue', fn ($av) => $av->where('name', 'like', '%'.$term.'%'));
                });
            })
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.event.event', [
            'events' => $events,
            'statuses' => EventStatus::cases(),
            'sortOptions' => $allowedSorts,
        ]);
    }

    public function create()
    {
        return view('admin.event.create-update', [
            'event' => new Event(),
            'categories' => Category::query()->where('status', 'active')->orderBy('name')->get(),
            'avenues' => Avenue::query()->where('status', 'active')->orderBy('name')->get(),
            'statuses' => EventStatus::cases(),
            'action' => route('admin.events.store'),
            'method' => 'POST',
            'title' => 'Create Event',
        ]);
    }

    public function store(EventSaveRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated = $this->applyAvenueDefaults($validated);
        $validated['created_by'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request);
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('flash', ['type' => 'success', 'message' => 'Event created successfully.']);
    }

    public function show(Event $event)
    {
        $event->load(['category', 'avenue', 'creator', 'payments.user']);

        return view('admin.event.show', [
            'event' => $event,
        ]);
    }

    public function edit(Event $event)
    {
        return view('admin.event.create-update', [
            'event' => $event,
            'categories' => Category::query()->where('status', 'active')->orderBy('name')->get(),
            'avenues' => Avenue::query()->where('status', 'active')->orderBy('name')->get(),
            'statuses' => EventStatus::cases(),
            'action' => route('admin.events.update', $event),
            'method' => 'PUT',
            'title' => 'Update Event',
        ]);
    }

    public function update(EventSaveRequest $request, Event $event): RedirectResponse
    {
        $validated = $request->validated();
        $validated = $this->applyAvenueDefaults($validated);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request);
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('flash', ['type' => 'success', 'message' => 'Event updated successfully.']);
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Event deleted successfully.']);
    }

    public function updateStatus(EventStatusRequest $request, Event $event): RedirectResponse
    {
        $event->update(['event_status' => $request->validated('event_status')]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Event status updated successfully.']);
    }

    private function uploadImage(Request $request): string
    {
        $path = $request->file('image')->store('events', 'public');
        $fullPath = storage_path('app/public/'.$path);
        ImageOptimizer::optimize($fullPath);

        return $path;
    }

    private function applyAvenueDefaults(array $validated): array
    {
        if (empty($validated['avenue_id'])) {
            return $validated;
        }

        $avenue = Avenue::query()->find($validated['avenue_id']);
        if (! $avenue) {
            return $validated;
        }

        if (empty($validated['venue'])) {
            $validated['venue'] = $avenue->name.' - '.$avenue->place;
        }

        if (empty($validated['address']) && ! empty($avenue->address)) {
            $validated['address'] = $avenue->address;
        }

        return $validated;
    }
}
