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
            'role' => 'required|in:admin,teacher,student,guest,test-taker,intern',
            'status' => 'required|in:active,inactive',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'teacher_id' => 'nullable|exists:users,id',
            'program_id' => 'nullable|exists:programs,id',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:programs,id',
            'class_period_id' => 'nullable|exists:class_periods,id',
            'learning_mode' => 'required|in:online,offline,both',
            'camp_id' => 'nullable|exists:camps,id',
            'camp_room_id' => 'nullable|exists:camp_rooms,id',
            'bio' => 'nullable|string',
        ];
    }
}
