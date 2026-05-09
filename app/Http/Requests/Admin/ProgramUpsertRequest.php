<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProgramUpsertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'brochure_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'brochure_pdf' => 'nullable|mimes:pdf|max:20480',
            'access_key' => 'nullable|string|max:255',
        ];
    }
}
