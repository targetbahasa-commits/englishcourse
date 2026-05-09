<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationLeadUpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:new,contacted,converted,cancelled',
            'admin_notes' => 'nullable|string|max:2000',
        ];
    }
}
