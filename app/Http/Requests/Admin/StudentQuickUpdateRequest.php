<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentQuickUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student');
        $studentId = is_object($student) ? $student->id : $student;

        return [
            'phone_number' => 'nullable|string|max:30',
            'referral_code' => 'nullable|string|max:50|unique:users,referral_code,' . $studentId,
        ];
    }
}
