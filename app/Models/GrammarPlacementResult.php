<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrammarPlacementResult extends Model
{
    protected $fillable = [
        'grammar_placement_package_id',
        'student_name',
        'student_phone',
        'user_id',
        'administered_by',
        'answers_data',
        'correct_count',
        'total_count',
        'percentage',
        'cefr_level',
        'recommended_program_id',
        'notes',
    ];

    protected $casts = [
        'answers_data' => 'array',
        'percentage' => 'float',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(GrammarPlacementPackage::class, 'grammar_placement_package_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'administered_by');
    }

    public function recommendedProgram(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'recommended_program_id');
    }
}
