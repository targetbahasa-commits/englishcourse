<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMediaPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'program',
        'title',
        'content_type',
        'platforms',
        'caption',
        'cta',
        'hashtags',
        'publish_date',
        'publish_time',
        'assigned_to',
        'reviewer',
        'status',
        'notes',
        'checklist_caption',
        'checklist_design',
        'checklist_video',
        'checklist_review',
        'checklist_publish',
        'stat_views',
        'stat_likes',
        'stat_comments',
        'stat_shares',
        'stat_clicks',
        'stat_leads',
        'stat_registrations',
        'is_archived',
    ];

    protected $casts = [
        'platforms' => 'array',
        'publish_date' => 'date',
        'checklist_caption' => 'boolean',
        'checklist_design' => 'boolean',
        'checklist_video' => 'boolean',
        'checklist_review' => 'boolean',
        'checklist_publish' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function links()
    {
        return $this->hasMany(SocialMediaLink::class);
    }

    public function getChecklistPercentageAttribute(): int
    {
        $items = [
            $this->checklist_caption,
            $this->checklist_design,
            $this->checklist_video,
            $this->checklist_review,
            $this->checklist_publish,
        ];
        $done = count(array_filter($items));
        return (int) round(($done / 5) * 100);
    }

    public function getProgramLabelAttribute(): string
    {
        return static::programLabel($this->program);
    }

    public static function programLabel(string $program): string
    {
        return [
            'grammar-writing'  => 'Grammar for Writing',
            'toefl-itp'        => 'TOEFL ITP',
            'ielts-academic'   => 'IELTS Academic',
            'ielts-general'    => 'IELTS General',
            'toefl-ibt'        => 'TOEFL iBT',
            'pte-academic'     => 'PTE Academic',
            'speaking'         => 'Speaking',
        ][$program] ?? ucwords(str_replace('-', ' ', $program));
    }

    public static function programs(): array
    {
        return [
            'grammar-writing'  => 'Grammar for Writing',
            'toefl-itp'        => 'TOEFL ITP',
            'ielts-academic'   => 'IELTS Academic',
            'ielts-general'    => 'IELTS General',
            'toefl-ibt'        => 'TOEFL iBT',
            'pte-academic'     => 'PTE Academic',
            'speaking'         => 'Speaking',
        ];
    }
}
