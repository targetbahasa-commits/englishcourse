<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrammarWritingPeriodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_period_id' => 'required|integer|exists:class_periods,id',
        ];
    }

    public function classPeriodId(): int
    {
        return $this->integer('class_period_id');
    }
}