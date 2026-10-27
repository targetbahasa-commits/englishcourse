<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SelfStudyDraft extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course',
        'module',
        'topic',
        'answers',
        'submitted',
    ];

    protected $casts = [
        'answers' => 'array',
        'submitted' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
