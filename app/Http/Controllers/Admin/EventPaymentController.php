<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventPaymentSaveRequest;
use App\Models\Event;
use App\Models\EventPayment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class EventPaymentController extends Controller
{
    public function index()
    {
        return view('admin.payment.payment', [
            'payments' => EventPayment::with(['event', 'user'])->latest()->paginate(10),
            'events' => Event::query()->where('event_status', 'published')->orderBy('title')->get(),
            'users' => User::query()->orderBy('name')->get(),
            'methods' => PaymentMethod::cases(),
            'statuses' => PaymentStatus::cases(),
        ]);
    }

    public function store(EventPaymentSaveRequest $request): RedirectResponse
    {
        EventPayment::create($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Payment created successfully.']);
    }

    public function update(EventPaymentSaveRequest $request, EventPayment $payment): RedirectResponse
    {
        $payment->update($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Payment updated successfully.']);
    }

    public function destroy(EventPayment $payment): RedirectResponse
    {
        $payment->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Payment deleted successfully.']);
    }
}
