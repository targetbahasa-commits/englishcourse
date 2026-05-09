<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReferralStoreRewardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
