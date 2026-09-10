<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlacementTestResult extends Model
{
    protected $fillable = [
        'user_id',
        'placement_test_package_id',
        'status',
        'reading_score',
        'listening_score',
        'writing_score',
        'speaking_score',
        'overall_percentage',
        'cefr_level',
        'answers_data',
        'evaluation_data',
        'recommended_program_ids',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'reading_score' => 'decimal:2',
        'listening_score' => 'decimal:2',
        'writing_score' => 'decimal:2',
        'speaking_score' => 'decimal:2',
        'overall_percentage' => 'decimal:2',
        'answers_data' => 'array',
        'evaluation_data' => 'array',
        'recommended_program_ids' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(PlacementTestPackage::class, 'placement_test_package_id');
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function getScoreDisplayAttribute(): string
    {
        if ($this->overall_percentage === null) {
            return '—';
        }

        $val = (float) $this->overall_percentage;
        $formatted = ((int) $val == $val) ? (string) (int) $val : number_format($val, 1);
        return "Skor {$formatted}%";
    }

    public function getCefrBadgeClassAttribute(): string
    {
        return match ($this->cefr_level) {
            'C2', 'C1' => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
            'B2' => 'bg-blue-100 text-blue-800 border border-blue-300',
            'B1' => 'bg-amber-100 text-amber-800 border border-amber-300',
            'A2', 'A1' => 'bg-purple-100 text-purple-800 border border-purple-300',
            default => 'bg-gray-100 text-gray-700 border border-gray-200',
        };
    }

    public function getCompletionPercentageAttribute(): int
    {
        if ($this->status === 'completed') {
            return 100;
        }

        $answered = 0;
        $total = 4;

        if ($this->reading_score !== null || data_get($this->answers_data, 'reading')) $answered++;
        if ($this->listening_score !== null || data_get($this->answers_data, 'listening')) $answered++;
        if ($this->writing_score !== null || data_get($this->answers_data, 'writing')) $answered++;
        if ($this->speaking_score !== null || data_get($this->answers_data, 'speaking')) $answered++;

        return (int) round(($answered / $total) * 100);
    }

    public function getCompletionDisplayAttribute(): string
    {
        if ($this->status === 'completed') {
            return '100% (4 Skill Lengkap)';
        }

        $answered = 0;
        if ($this->reading_score !== null || data_get($this->answers_data, 'reading')) $answered++;
        if ($this->listening_score !== null || data_get($this->answers_data, 'listening')) $answered++;
        if ($this->writing_score !== null || data_get($this->answers_data, 'writing')) $answered++;
        if ($this->speaking_score !== null || data_get($this->answers_data, 'speaking')) $answered++;

        $pct = (int) round(($answered / 4) * 100);
        return "{$pct}% ({$answered}/4 Skill)";
    }

    public function getDurationDisplayAttribute(): ?string
    {
        if ($this->started_at && $this->completed_at) {
            $seconds = $this->completed_at->diffInSeconds($this->started_at);
            if ($seconds > 0) {
                $mins = floor($seconds / 60);
                $secs = $seconds % 60;
                if ($mins > 0) {
                    return sprintf('%d mnt %02d dtk', $mins, $secs);
                }
                return sprintf('%d detik', $secs);
            }
        }

        if ($this->status === 'completed') {
            return '~35 mnt';
        }

        if ($this->status === 'in_progress') {
            return 'Sedang Berjalan';
        }

        return '—';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'completed' => 'bg-green-100 text-green-800 border border-green-200',
            'in_progress' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
            'failed' => 'bg-red-100 text-red-800 border border-red-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };
    }

    public function getTargetProgramDisplayAttribute(): string
    {
        $target = data_get($this->answers_data, 'target_program');
        if (!empty($target)) {
            return $target;
        }

        if ($this->package && !empty($this->package->title)) {
            return $this->package->title;
        }

        return 'General English / Persiapan Tes';
    }

    public function getAiRecommendedProgramDisplayAttribute(): string
    {
        $cefr = $this->cefr_level ?? 'B1';
        $target = strtolower($this->target_program_display ?? '');

        // 1. If Target is IELTS
        if (str_contains($target, 'ielts')) {
            if (in_array($cefr, ['C1', 'C2'])) {
                return 'IELTS Academic FULL PACKAGE • Proficiency Grammar for Writing';
            }
            if ($cefr === 'B2') {
                return 'IELTS Academic FULL PACKAGE • Complexity Grammar for Writing';
            }
            if ($cefr === 'B1') {
                return 'Fast Track Grammar for Writing • IELTS Academic Writing';
            }
            return 'Introductory Grammar for Writing • Introductory Speaking';
        }

        // 2. If Target is TOEFL
        if (str_contains($target, 'toefl')) {
            if (str_contains($target, 'ibt')) {
                if (in_array($cefr, ['C1', 'C2', 'B2'])) {
                    return 'TOEFL Ibt • Complexity Grammar for Writing';
                }
                return 'Fast Track Grammar for Writing • TOEFL Ibt';
            }
            // TOEFL ITP
            if (in_array($cefr, ['C1', 'C2', 'B2'])) {
                return 'TOEFL ITP • Complexity Grammar for Writing';
            }
            if ($cefr === 'B1') {
                return 'TOEFL ITP • Fast Track Grammar for Writing';
            }
            return 'Introductory Grammar for Writing • TOEFL ITP';
        }

        // 3. If Target is PTE
        if (str_contains($target, 'pte')) {
            if (in_array($cefr, ['C1', 'C2', 'B2'])) {
                return 'PTE Academic • Complexity Grammar for Writing';
            }
            return 'Fast Track Grammar for Writing • PTE Academic';
        }

        // 4. If Target is Speaking / Conversation
        if (str_contains($target, 'speaking') || str_contains($target, 'conversation')) {
            if (in_array($cefr, ['C1', 'C2'])) {
                return 'Advanced Speaking • Proficiency Grammar for Writing';
            }
            if ($cefr === 'B2') {
                return 'Intermediate Speaking • Complexity Grammar for Writing';
            }
            if ($cefr === 'B1') {
                return 'Intermediate Speaking • Fast Track Grammar for Writing';
            }
            return 'Introductory Speaking • Introductory Grammar for Writing';
        }

        // 5. If Target is Grammar
        if (str_contains($target, 'grammar')) {
            if (in_array($cefr, ['C1', 'C2'])) {
                return 'Proficiency Grammar for Writing • Advanced Speaking';
            }
            if ($cefr === 'B2') {
                return 'Complexity Grammar for Writing • Intermediate Speaking';
            }
            if ($cefr === 'B1') {
                return 'Fast Track Grammar for Writing • Intermediate Speaking';
            }
            return 'Introductory Grammar for Writing • Introductory Speaking';
        }

        // 6. Default by CEFR Level (General English / Tes Kompetensi Lengkap)
        return match ($cefr) {
            'C2' => 'IELTS Academic FULL PACKAGE • Proficiency Grammar for Writing',
            'C1' => 'IELTS Academic FULL PACKAGE • Advanced Speaking',
            'B2' => 'IELTS Academic FULL PACKAGE • Complexity Grammar for Writing',
            'B1' => 'Fast Track Grammar for Writing • Intermediate Speaking',
            'A2' => 'Introductory Grammar for Writing • Introductory Speaking',
            'A1' => 'Introductory Grammar for Writing • Introductory Speaking',
            default => 'IELTS Academic FULL PACKAGE • Complexity Grammar for Writing',
        };
    }
}
