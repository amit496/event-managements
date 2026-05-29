<?php

namespace App\Http\Requests\Admin;

use App\Enums\EventStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventSaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $event = $this->route('event');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'avenue_id' => ['nullable', 'exists:avenues,id'],
            'title' => ['required', 'string', 'max:180', Rule::unique('events', 'title')->ignore($event?->id)],
            'description' => ['required', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after_or_equal:start_at'],
            'venue' => ['nullable', 'string', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'client_payable_amount' => ['nullable', 'numeric', 'min:0'],
            'event_status' => ['required', Rule::in(array_column(EventStatus::cases(), 'value'))],
            'payment_required' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }
}
