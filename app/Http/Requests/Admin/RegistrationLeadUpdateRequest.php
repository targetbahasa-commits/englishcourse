<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationLeadUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $registrationLead = $this->route('registrationLead');
        $convertedUserId = is_object($registrationLead) ? $registrationLead->converted_user_id : null;

        return [
            'full_name' => 'required|string|max:150',
            'whatsapp' => 'required|string|max:20',
            'email' => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')->ignore($convertedUserId)],
            'city' => 'required|string|max:100',
            'profession' => 'required|in:student_sma,mahasiswa,karyawan,other',
            'profession_other' => 'nullable|string|max:100',
            'program_id' => 'nullable|exists:programs,id',
            'class_period_id' => 'nullable|exists:class_periods,id',
            'mode' => 'required|in:online,offline,flexible',
        ];
    }
}
