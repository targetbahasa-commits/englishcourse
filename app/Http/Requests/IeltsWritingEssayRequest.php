<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IeltsWritingEssayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'essay' => 'required|string|min:50',
            'task_type' => 'required|in:1,2',
            'meeting_id' => 'nullable|integer',
        ];
    }

    public function essay(): string
    {
        return (string) $this->validated('essay');
    }

    public function taskType(): string
    {
        return (string) $this->validated('task_type');
    }

    public function meetingId(): ?int
    {
        return $this->input('meeting_id') ? (int) $this->input('meeting_id') : null;
    }
}