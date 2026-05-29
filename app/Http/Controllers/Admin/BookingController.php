<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingSaveRequest;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['client', 'event'])
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('booking_code', 'like', '%'.$term.'%')
                        ->orWhere('status', 'like', '%'.$term.'%')
                        ->orWhereHas('client', fn ($q) => $q->where('name', 'like', '%'.$term.'%'))
                        ->orWhereHas('event', fn ($q) => $q->where('title', 'like', '%'.$term.'%'));
                });
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.booking.booking', [
            'bookings' => $bookings,
            'clients' => Client::query()->orderBy('name')->get(),
            'events' => Event::query()->orderBy('title')->get(),
            'statuses' => Booking::statusOptions(),
        ]);
    }

    public function store(BookingSaveRequest $request): RedirectResponse
    {
        Booking::create($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Booking created successfully.']);
    }

    public function update(BookingSaveRequest $request, Booking $booking): RedirectResponse
    {
        $booking->update($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Booking updated successfully.']);
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Booking deleted successfully.']);
    }
}
