<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProgramBrochureUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brochure_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'brochure_pdf' => 'nullable|mimes:pdf|max:20480',
        ];
    }
}
