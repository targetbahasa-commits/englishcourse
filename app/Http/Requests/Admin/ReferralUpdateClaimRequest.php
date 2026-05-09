<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReferralUpdateClaimRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,processed,shipped,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ];
    }
}
