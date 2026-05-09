<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserBulkAssignProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_ids' => 'required|string',
            'program_id' => 'required|exists:programs,id',
        ];
    }
}
