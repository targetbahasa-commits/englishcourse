<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeflStructureQuestion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'section_id',
        'question_number',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
    ];

    public function meeting()
    {
        return $this->belongsTo(ToeflStructureMeeting::class, 'section_id');
    }

    public static function formatQuestionText(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        // If it's a Written Expression question with error-option,
        // dashes are em-dashes (parenthetical dashes), so replace with ' — '
        if (str_contains($value, 'error-option')) {
            $value = preg_replace('/\s*-{3,}\s*/', ' — ', $value);
            return trim($value);
        }

        // Clean up combined underscores and dashes
        $value = preg_replace('/_{1,}\s*-{2,}/', '_____', $value);
        $value = preg_replace('/-{2,}\s*_{1,}/', '_____', $value);

        // For Structure questions, '---' (or '----', etc.) represents the blank '_____'
        // 1. If at start of string before a word (e.g. '---ratchet'): '_____ $1'
        $value = preg_replace('/^-{3,}([a-zA-Z0-9])/', '_____ ${1}', $value);

        // 2. If between words without spaces (e.g. 'contributions ---a politician'): '$1 _____ $2'
        $value = preg_replace('/([a-zA-Z0-9])\s*-{3,}\s*([a-zA-Z0-9])/', '${1} _____ ${2}', $value);

        // 3. If after a word without space (e.g. 'word---'): '$1 _____'
        $value = preg_replace('/([a-zA-Z0-9])-{3,}/', '${1} _____', $value);

        // 4. If before a word without space (e.g. '---word'): '_____ $1'
        $value = preg_replace('/-{3,}([a-zA-Z0-9])/', '_____ ${1}', $value);

        // 5. Any remaining 3 or more dashes (e.g. '---,', '--- .', ' --- ')
        $value = preg_replace('/-{3,}/', '_____', $value);

        // 6. Clean up multiple spaces
        $value = preg_replace('/[ ]{2,}/', ' ', $value);

        return trim($value);
    }

    public function getQuestionTextAttribute($value)
    {
        return self::formatQuestionText($value);
    }

    public function setQuestionTextAttribute($value)
    {
        $this->attributes['question_text'] = self::formatQuestionText($value);
    }

    public function getOptionAAttribute($value)
    {
        return $value ? self::formatQuestionText($value) : $value;
    }

    public function getOptionBAttribute($value)
    {
        return $value ? self::formatQuestionText($value) : $value;
    }

    public function getOptionCAttribute($value)
    {
        return $value ? self::formatQuestionText($value) : $value;
    }

    public function getOptionDAttribute($value)
    {
        return $value ? self::formatQuestionText($value) : $value;
    }
}
