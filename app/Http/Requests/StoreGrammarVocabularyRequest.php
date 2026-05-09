<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrammarVocabularyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meeting_number' => 'required|integer',
            'word' => 'required|string',
            'translation' => 'required|string',
            'pos' => 'required|string',
            'section' => 'nullable|string',
        ];
    }
}