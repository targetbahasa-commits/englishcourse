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
            'class_period_id' => 'required|integer|exists:class_periods,id',
        ];
    }

    public function programId(): int
    {
        return $this->integer('program_id');
    }

    public function classPeriodId(): int
    {
        return $this->integer('class_period_id');
    }
}