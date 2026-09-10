<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActiveClassMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'program_id' => 'required|integer|exists:programs,id',
            'class_meeting_id' => 'required|integer|exists:class_meetings,id',
        ];
    }

    public function programId(): int
    {
        return $this->integer('program_id');
    }

    public function classMeetingId(): int
    {
        return $this->integer('class_meeting_id');
    }
}
