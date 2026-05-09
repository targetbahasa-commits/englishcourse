<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,teacher,student,guest',
            'status' => 'required|in:active,inactive',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'teacher_id' => 'nullable|exists:users,id',
            'program_id' => 'nullable|exists:programs,id',
            'learning_mode' => 'required|in:online,offline,both',
            'bio' => 'nullable|string',
        ];
    }
}
