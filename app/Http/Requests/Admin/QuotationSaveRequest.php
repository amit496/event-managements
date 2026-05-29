<?php

namespace App\Http\Requests\Admin;

use App\Models\Quotation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuotationSaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $quotation = $this->route('quotation');

        return [
            'booking_id' => ['nullable', 'exists:bookings,id'],
            'event_id' => ['nullable', 'exists:events,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'quote_no' => ['required', 'string', 'max:40', Rule::unique('quotations', 'quote_no')->ignore($quotation?->id)],
            'subtotal' => ['nullable', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'valid_until' => ['nullable', 'date'],
            'status' => ['required', Rule::in(Quotation::statusOptions())],
            'notes' => ['nullable', 'string'],
        ];
    }
}
