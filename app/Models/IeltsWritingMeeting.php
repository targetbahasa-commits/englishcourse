<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IeltsWritingMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_type',
        'meeting_number',
        'title',
        'prompt',
        'image',
        'view_type',
        'category',
        'idioms',
        'collocations',
        'is_locked',
        'is_free_tier',
        'test_type',
        'graph_data_json',
        'system_prompt_override',
    ];


    protected $casts = [
        'idioms' => 'array',
        'collocations' => 'array',
        'is_locked' => 'boolean',
        'is_free_tier' => 'boolean',
        'graph_data_json' => 'array',
    ];

    public function questions()
    {
        return $this->hasMany(IeltsWritingQuestion::class)->orderBy('order');
    }
}
