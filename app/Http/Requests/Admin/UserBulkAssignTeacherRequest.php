<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserBulkAssignTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_ids' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
        ];
    }
}
