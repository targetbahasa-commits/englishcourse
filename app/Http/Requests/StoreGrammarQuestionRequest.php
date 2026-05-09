<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrammarQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meeting_number' => 'required|integer',
            'question_number' => 'required|integer',
            'question_text' => 'required|string',
            'correct_answer' => 'required|string',
            'example_id' => 'nullable|string',
            'example_en' => 'nullable|string',
            'section' => 'nullable|string',
            'tense' => 'nullable|string',
            'structure' => 'nullable|string',
            'formula' => 'nullable|string',
            'vocab' => 'nullable',
        ];
    }
}