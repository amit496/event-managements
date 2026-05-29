<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AvenueStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AvenueSaveRequest;
use App\Http\Requests\Admin\AvenueStatusRequest;
use App\Models\Avenue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class AvenueController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->string('sort')->toString();
        $dir = $request->string('dir')->toString() === 'asc' ? 'asc' : 'desc';
        $allowedSorts = ['name', 'place', 'city', 'status', 'created_at'];
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'created_at';

        $avenues = Avenue::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('name', 'like', '%'.$term.'%')
                        ->orWhere('place', 'like', '%'.$term.'%')
                        ->orWhere('city', 'like', '%'.$term.'%')
                        ->orWhere('address', 'like', '%'.$term.'%');
                });
            })
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.avenue.avenue', [
            'avenues' => $avenues,
            'statuses' => AvenueStatus::cases(),
            'sortOptions' => $allowedSorts,
        ]);
    }

    public function create()
    {
        return view('admin.avenue.create-update', [
            'avenue' => new Avenue(),
            'statuses' => AvenueStatus::cases(),
            'action' => route('admin.avenues.store'),
            'method' => 'POST',
            'title' => 'Create Avenue',
        ]);
    }

    public function store(AvenueSaveRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated = $this->attachUploadedImages($request, $validated);
        Avenue::create($validated);

        return redirect()->route('admin.avenues.index')
            ->with('flash', ['type' => 'success', 'message' => 'Avenue created successfully.']);
    }

    public function show(Avenue $avenue)
    {
        $avenue->load(['events.category']);

        return view('admin.avenue.show', [
            'avenue' => $avenue,
        ]);
    }

    public function edit(Avenue $avenue)
    {
        return view('admin.avenue.create-update', [
            'avenue' => $avenue,
            'statuses' => AvenueStatus::cases(),
            'action' => route('admin.avenues.update', $avenue),
            'method' => 'PUT',
            'title' => 'Update Avenue',
        ]);
    }

    public function update(AvenueSaveRequest $request, Avenue $avenue): RedirectResponse
    {
        $validated = $request->validated();
        $validated = $this->syncImagesOnUpdate($request, $avenue, $validated);
        $avenue->update($validated);

        return redirect()->route('admin.avenues.index')
            ->with('flash', ['type' => 'success', 'message' => 'Avenue updated successfully.']);
    }

    public function destroy(Avenue $avenue): RedirectResponse
    {
        $this->deleteStoredImages($avenue->location_images);
        $this->deleteStoredImages($avenue->event_room_images);
        $this->deleteStoredImages($avenue->building_images);
        $avenue->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Avenue deleted successfully.']);
    }

    public function updateStatus(AvenueStatusRequest $request, Avenue $avenue): RedirectResponse
    {
        $avenue->update(['status' => $request->validated('status')]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Avenue status updated successfully.']);
    }

    private function attachUploadedImages(Request $request, array $validated): array
    {
        $validated['location_images'] = $this->uploadImages($request, 'location_images', 'avenues/location');
        $validated['event_room_images'] = $this->uploadImages($request, 'event_room_images', 'avenues/event-room');
        $validated['building_images'] = $this->uploadImages($request, 'building_images', 'avenues/building');

        return $validated;
    }

    private function syncImagesOnUpdate(Request $request, Avenue $avenue, array $validated): array
    {
        $validated['location_images'] = $this->syncImageGroup(
            $request,
            $avenue->location_images ?? [],
            'location_images',
            'remove_location_images',
            'avenues/location'
        );
        $validated['event_room_images'] = $this->syncImageGroup(
            $request,
            $avenue->event_room_images ?? [],
            'event_room_images',
            'remove_event_room_images',
            'avenues/event-room'
        );
        $validated['building_images'] = $this->syncImageGroup(
            $request,
            $avenue->building_images ?? [],
            'building_images',
            'remove_building_images',
            'avenues/building'
        );

        return $validated;
    }

    private function syncImageGroup(
        Request $request,
        array $existingImages,
        string $uploadField,
        string $removeField,
        string $directory
    ): array {
        $existingImages = array_values(array_filter($existingImages, 'is_string'));
        $removePaths = array_values(array_intersect(
            $existingImages,
            array_filter((array) $request->input($removeField, []), 'is_string')
        ));

        if ($removePaths !== []) {
            $this->deleteStoredImages($removePaths);
            $existingImages = array_values(array_diff($existingImages, $removePaths));
        }

        $newImages = $this->uploadImages($request, $uploadField, $directory);

        return array_values(array_merge($existingImages, $newImages));
    }

    /**
     * @return list<string>
     */
    private function uploadImages(Request $request, string $field, string $directory): array
    {
        $uploaded = $request->file($field, []);
        if (! is_array($uploaded)) {
            return [];
        }

        $paths = [];
        foreach ($uploaded as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $path = $file->store($directory, 'public');
            ImageOptimizer::optimize(storage_path('app/public/'.$path));
            $paths[] = $path;
        }

        return $paths;
    }

    /**
     * @param  array<int, string>|null  $paths
     */
    private function deleteStoredImages(?array $paths): void
    {
        if (empty($paths)) {
            return;
        }

        foreach ($paths as $path) {
            if (is_string($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
