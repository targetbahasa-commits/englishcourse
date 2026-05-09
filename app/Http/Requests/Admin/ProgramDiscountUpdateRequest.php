<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProgramDiscountUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,fixed_idr',
            'discount_value' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'regions' => 'nullable|string',
        ];
    }
}
