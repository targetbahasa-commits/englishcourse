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
            $val = $this->input($field);
            if ($val !== null && $val !== '') {
                $cleaned = preg_replace('/[^0-9]/', '', (string) $val);
                $mergeData[$field] = $cleaned === '' ? 0 : (int) $cleaned;
            } else {
                $mergeData[$field] = 0;
            }
        }

        // Per-price discount pairs: treat a half-filled pair (type chosen but no
        // value, or vice versa) as "no discount" rather than failing validation -
        // these are optional, and a stray selection shouldn't block saving prices.
        foreach ($priceFields as $field) {
            $typeKey = $field . '_discount_type';
            $valueKey = $field . '_discount_value';
            $type = $this->input($typeKey);
            $value = $this->input($valueKey);

            if ($type === null || $type === '' || $value === null || $value === '') {
                $mergeData[$typeKey] = null;
                $mergeData[$valueKey] = null;
                continue;
            }

            $cleanedValue = preg_replace('/[^0-9]/', '', (string) $value);
            $mergeData[$valueKey] = $cleanedValue === '' ? null : (int) $cleanedValue;
            $mergeData[$typeKey] = $type;
        }

        $mergeData['is_active'] = $this->boolean('is_active');
        $mergeData['delivery_mode'] = $this->input('delivery_mode', 'online');

        $this->merge($mergeData);
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
            'price_discount_type' => 'nullable|in:percentage,fixed_idr',
            'price_discount_value' => 'nullable|integer|min:0',
            'price_offline_discount_type' => 'nullable|in:percentage,fixed_idr',
            'price_offline_discount_value' => 'nullable|integer|min:0',
            'price_semi_private_discount_type' => 'nullable|in:percentage,fixed_idr',
            'price_semi_private_discount_value' => 'nullable|integer|min:0',
            'price_semi_private_offline_discount_type' => 'nullable|in:percentage,fixed_idr',
            'price_semi_private_offline_discount_value' => 'nullable|integer|min:0',
            'price_private_discount_type' => 'nullable|in:percentage,fixed_idr',
            'price_private_discount_value' => 'nullable|integer|min:0',
            'price_private_offline_discount_type' => 'nullable|in:percentage,fixed_idr',
            'price_private_offline_discount_value' => 'nullable|integer|min:0',
            'program_type' => 'required|in:paket,satuan',
            'delivery_mode' => 'required|in:online,offline',
            'min_cefr_level' => 'nullable|in:A1,A2,B1,B2,C1,C2',
            'max_cefr_level' => 'nullable|in:A1,A2,B1,B2,C1,C2',
            'brochure_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'brochure_pdf' => 'nullable|mimes:pdf|max:20480',
            'access_key' => 'nullable|string|max:255',
            'subprograms' => 'nullable|array',
            'subprograms.*' => 'exists:programs,id',
            'is_active' => 'nullable|boolean',
        ];
    }
}