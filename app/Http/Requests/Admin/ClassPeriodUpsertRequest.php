<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClassPeriodUpsertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,upcoming,closed',
            'learning_mode' => 'required|in:online,offline',
            'batch_type' => 'required|in:regular,private',
            'batch_number' => 'nullable|integer|min:1',
            'teacher_id'   => 'nullable|exists:users,id',
        ];
    }
}
