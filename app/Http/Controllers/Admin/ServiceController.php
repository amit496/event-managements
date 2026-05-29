<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceSaveRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('name', 'like', '%'.$term.'%')
                        ->orWhere('description', 'like', '%'.$term.'%');
                });
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.service.service', [
            'services' => $services,
        ]);
    }

    public function store(ServiceSaveRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = (bool) ($validated['status'] ?? false);
        Service::create($validated);

        return back()->with('flash', ['type' => 'success', 'message' => 'Service created successfully.']);
    }

    public function update(ServiceSaveRequest $request, Service $service): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = (bool) ($validated['status'] ?? false);
        $service->update($validated);

        return back()->with('flash', ['type' => 'success', 'message' => 'Service updated successfully.']);
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Service deleted successfully.']);
    }
}
