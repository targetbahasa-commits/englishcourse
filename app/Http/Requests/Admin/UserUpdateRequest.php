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
            'role' => 'required|in:admin,teacher,student,guest,test-taker,intern',
            'status' => 'required|in:active,inactive',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'teacher_id' => 'nullable|exists:users,id',
            'program_id' => 'nullable|exists:programs,id',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:programs,id',
            'class_period_id' => 'nullable|exists:class_periods,id',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'nullable|exists:users,id',
            'class_period_ids' => 'nullable|array',
            'class_period_ids.*' => 'nullable|exists:class_periods,id',
            'learning_mode' => 'required|in:online,offline,both',
            'camp_id' => 'nullable|exists:camps,id',
            'camp_room_id' => 'nullable|exists:camp_rooms,id',
            'bio' => 'nullable|string',
        ];
    }
}
