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
            'period' => 'required|string|max:255',
        ];
    }

    public function period(): string
    {
        return $this->string('period')->toString();
    }
}