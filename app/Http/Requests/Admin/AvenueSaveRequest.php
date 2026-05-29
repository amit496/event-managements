<?php

namespace App\Http\Requests\Admin;

use App\Enums\AvenueStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AvenueSaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $avenue = $this->route('avenue');

        return [
            'name' => ['required', 'string', 'max:150', Rule::unique('avenues', 'name')->ignore($avenue?->id)],
            'place' => ['required', 'string', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status' => ['required', Rule::in(array_column(AvenueStatus::cases(), 'value'))],
            'location_images' => ['nullable', 'array'],
            'location_images.*' => ['image', 'max:3072'],
            'event_room_images' => ['nullable', 'array'],
            'event_room_images.*' => ['image', 'max:3072'],
            'building_images' => ['nullable', 'array'],
            'building_images.*' => ['image', 'max:3072'],
            'remove_location_images' => ['nullable', 'array'],
            'remove_location_images.*' => ['string'],
            'remove_event_room_images' => ['nullable', 'array'],
            'remove_event_room_images.*' => ['string'],
            'remove_building_images' => ['nullable', 'array'],
            'remove_building_images.*' => ['string'],
        ];
    }
}

