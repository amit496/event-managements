<?php

namespace App\Http\Requests\Admin;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingSaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $booking = $this->route('booking');

        return [
            'event_id' => ['nullable', 'exists:events,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'booking_code' => ['required', 'string', 'max:40', Rule::unique('bookings', 'booking_code')->ignore($booking?->id)],
            'expected_amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(Booking::statusOptions())],
            'event_date' => ['nullable', 'date'],
            'guest_count' => ['nullable', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
