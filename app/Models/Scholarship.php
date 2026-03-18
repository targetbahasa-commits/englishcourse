<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'provider',
        'location',
        'level_of_study',
        'funding_type',
        'majors',
        'has_work_contract',
        'opening_date',
        'description',
        'requirements',
        'requires_certification',
        'benefits',
        'deadline',
        'apply_link',
        'image_path',
        'is_active',
        'country',
        'min_ielts',
        'min_toefl',
        'min_gpa',
        'max_age',
        'ingest_source_type',
        'ingest_source_ref',
        'ingest_parser',
        'ingested_at',
        'ingest_quality_pass',
    ];

    protected $casts = [
        'opening_date' => 'date',
        'deadline' => 'date',
        'requires_certification' => 'boolean',
        'is_active' => 'boolean',
        'majors' => 'array',
        'has_work_contract' => 'boolean',
        'ingested_at' => 'datetime',
        'ingest_quality_pass' => 'boolean',
    ];

    /**
     * Get the users who have saved this scholarship.
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_scholarships', 'scholarship_id', 'user_id')->withTimestamps();
    }

    /**
     * Get the users who have targeted this scholarship.
     */
    public function targetedByUsers()
    {
        return $this->belongsToMany(User::class, 'target_scholarships', 'scholarship_id', 'user_id')->withTimestamps();
    }
}
