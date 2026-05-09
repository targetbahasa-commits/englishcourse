<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');
        $userId = is_object($user) ? $user->id : $user;

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)],
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
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
