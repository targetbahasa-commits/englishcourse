<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProgramUpsertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $priceFields = [
            'price', 'price_offline', 
            'price_private', 'price_private_offline', 
            'price_semi_private', 'price_semi_private_offline'
        ];

        $mergeData = [];
        foreach ($priceFields as $field) {
            if ($this->has($field) && is_string($this->{$field})) {
                $mergeData[$field] = preg_replace('/[^0-9]/', '', $this->{$field});
            }
        }
        
        if (!empty($mergeData)) {
            $this->merge($mergeData);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'price_offline' => 'nullable|numeric|min:0',
            'price_private' => 'nullable|numeric|min:0',
            'price_private_offline' => 'nullable|numeric|min:0',
            'price_semi_private' => 'nullable|numeric|min:0',
            'price_semi_private_offline' => 'nullable|numeric|min:0',
            'program_type' => 'required|in:paket,satuan',
            'brochure_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'brochure_pdf' => 'nullable|mimes:pdf|max:20480',
            'access_key' => 'nullable|string|max:255',
            'subprograms' => 'nullable|array',
            'subprograms.*' => 'exists:programs,id',
        ];
    }
}
