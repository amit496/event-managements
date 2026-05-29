<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorSaveRequest;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $vendors = Vendor::with('services')
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('name', 'like', '%'.$term.'%')
                        ->orWhere('service_type', 'like', '%'.$term.'%')
                        ->orWhere('contact_person', 'like', '%'.$term.'%')
                        ->orWhere('phone', 'like', '%'.$term.'%')
                        ->orWhereHas('services', fn ($serviceQuery) => $serviceQuery->where('name', 'like', '%'.$term.'%'));
                });
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.vendor.vendor', [
            'vendors' => $vendors,
            'services' => Service::query()->where('status', true)->orderBy('name')->get(),
        ]);
    }

    public function store(VendorSaveRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $serviceIds = $validated['service_ids'] ?? [];
        unset($validated['service_ids']);
        $validated['status'] = (bool) ($validated['status'] ?? false);
        $vendor = Vendor::create($validated);
        $vendor->services()->sync($serviceIds);

        return back()->with('flash', ['type' => 'success', 'message' => 'Vendor created successfully.']);
    }

    public function update(VendorSaveRequest $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validated();
        $serviceIds = $validated['service_ids'] ?? [];
        unset($validated['service_ids']);
        $validated['status'] = (bool) ($validated['status'] ?? false);
        $vendor->update($validated);
        $vendor->services()->sync($serviceIds);

        return back()->with('flash', ['type' => 'success', 'message' => 'Vendor updated successfully.']);
    }

    public function destroy(Vendor $vendor): RedirectResponse
    {
        $vendor->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Vendor deleted successfully.']);
    }
}
