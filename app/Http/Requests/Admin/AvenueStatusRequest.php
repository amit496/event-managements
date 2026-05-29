<?php

namespace App\Http\Requests\Admin;

use App\Enums\AvenueStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AvenueStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(array_column(AvenueStatus::cases(), 'value'))],
        ];
    }
}

