<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GrammarPlacementPackage extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(GrammarPlacementQuestion::class);
    }

    public function activeQuestions(): HasMany
    {
        return $this->questions()->active()->ordered();
    }

    public function results(): HasMany
    {
        return $this->hasMany(GrammarPlacementResult::class);
    }
}
