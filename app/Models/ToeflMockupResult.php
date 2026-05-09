<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflMockupResult extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'exam_type',
        'test_family',
        'source_context',
        'submitted_by_role',
        'package_number',
        'listening_correct',
        'structure_correct',
        'reading_correct',
        'listening_score',
        'structure_score',
        'reading_score',
        'total_score',
        'raw_scores',
        'scaled_scores',
        'result_payload',
        'answers_data',
        'completed_at',
    ];

    protected $casts = [
        'raw_scores' => 'array',
        'scaled_scores' => 'array',
        'result_payload' => 'array',
        'answers_data' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getExamLabelAttribute(): string
    {
        return match ($this->exam_type ?: 'toefl_itp') {
            'ielts' => 'IELTS',
            'pte' => 'PTE',
            default => 'TOEFL ITP',
        };
    }

    public function getSourceLabelAttribute(): string
    {
        return match ($this->source_context ?: 'assignment_mock_test') {
            'assignment_mock_test' => 'Assignment Mock Test',
            default => ucfirst(str_replace('_', ' ', (string) $this->source_context)),
        };
    }
}
