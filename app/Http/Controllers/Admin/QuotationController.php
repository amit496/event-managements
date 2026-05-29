<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuotationSaveRequest;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Event;
use App\Models\Quotation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $quotations = Quotation::with(['booking', 'client', 'event'])
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('quote_no', 'like', '%'.$term.'%')
                        ->orWhere('status', 'like', '%'.$term.'%')
                        ->orWhereHas('client', fn ($q) => $q->where('name', 'like', '%'.$term.'%'));
                });
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.quotation.quotation', [
            'quotations' => $quotations,
            'bookings' => Booking::query()->orderBy('booking_code')->get(),
            'clients' => Client::query()->orderBy('name')->get(),
            'events' => Event::query()->orderBy('title')->get(),
            'statuses' => Quotation::statusOptions(),
        ]);
    }

    public function store(QuotationSaveRequest $request): RedirectResponse
    {
        Quotation::create($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Quotation created successfully.']);
    }

    public function update(QuotationSaveRequest $request, Quotation $quotation): RedirectResponse
    {
        $quotation->update($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Quotation updated successfully.']);
    }

    public function destroy(Quotation $quotation): RedirectResponse
    {
        $quotation->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Quotation deleted successfully.']);
    }
}
