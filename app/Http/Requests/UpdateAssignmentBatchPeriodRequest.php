<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentBatchPeriodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'program_id' => 'required|integer|exists:programs,id',
            'period' => 'required|string|max:255',
        ];
    }

    public function programId(): int
    {
        return $this->integer('program_id');
    }

    public function period(): string
    {
        return $this->string('period')->toString();
    }
}