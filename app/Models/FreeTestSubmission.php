<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeTestSubmission extends Model
{
    use HasFactory;

    protected $table = 'free_test_submissions';
    protected $guarded = [];

    protected $casts = [
        'ai_raw_json_feedback' => 'array',
    ];

    public function isIelts(): bool
    {
        $type = strtolower($this->test_type ?? '');
        return in_array($type, ['writing_t1', 'writing_t2', 'speaking'], true)
            || str_contains($type, 'ielts');
    }

    public function isToeflIbt(): bool
    {
        $type = strtolower($this->test_type ?? '');
        return str_contains($type, 'toefl_ibt') || str_contains($type, 'toeflibt') || str_contains($type, 'ibt');
    }

    public function isToeflItp(): bool
    {
        if ($this->isToeflIbt()) {
            return false;
        }
        $type = strtolower($this->test_type ?? '');
        return str_contains($type, 'toefl') || str_contains($type, 'toeflitp');
    }

    public function isPte(): bool
    {
        $type = strtolower($this->test_type ?? '');
        return str_contains($type, 'pte');
    }

    public function isCambridge(): bool
    {
        $type = strtolower($this->test_type ?? '');
        return str_contains($type, 'cambridge');
    }

    public function isGrammar(): bool
    {
        $type = strtolower($this->test_type ?? '');
        return str_contains($type, 'grammar');
    }

    public function getFormattedTestTypeAttribute(): string
    {
        $type = strtolower($this->test_type ?? '');
        if ($type === 'writing_t1') return 'IELTS Writing Task 1';
        if ($type === 'writing_t2') return 'IELTS Writing Task 2';
        if ($type === 'speaking') return 'IELTS Speaking';
        if (str_starts_with($type, 'ielts_listening')) return 'IELTS Listening';
        if (str_starts_with($type, 'ielts_reading')) return 'IELTS Reading';
        
        if (str_starts_with($type, 'grammar_practice_')) {
            $num = str_replace('grammar_practice_', '', $type);
            return "Grammar Practice #{$num}";
        }
        if (str_starts_with($type, 'grammar_')) {
            return 'Grammar & Writing Test';
        }

        if (str_contains($type, 'toefl_ibt') || str_contains($type, 'toeflibt')) {
            if (str_contains($type, 'reading')) return 'TOEFL iBT Reading';
            if (str_contains($type, 'listening')) return 'TOEFL iBT Listening';
            if (str_contains($type, 'speaking')) return 'TOEFL iBT Speaking';
            if (str_contains($type, 'writing')) return 'TOEFL iBT Writing';
            return 'TOEFL iBT Test';
        }

        if (str_contains($type, 'toeflitplistening') || $type === 'toefl_listening') return 'TOEFL ITP Listening';
        if (str_contains($type, 'toeflitpstructure') || $type === 'toefl_structure') return 'TOEFL ITP Structure';
        if (str_contains($type, 'toeflitpreading') || $type === 'toefl_reading') return 'TOEFL ITP Reading';
        if ($type === 'toefl_itp' || $type === 'toefl') return 'TOEFL ITP Test';

        if (str_starts_with($type, 'pte_')) {
            if (str_contains($type, 'speaking_writing')) return 'PTE Speaking & Writing';
            if (str_contains($type, 'reading')) return 'PTE Reading';
            if (str_contains($type, 'listening')) return 'PTE Listening';
            return 'PTE Academic Test';
        }

        if (str_starts_with($type, 'cambridge_')) {
            return 'Cambridge English Test';
        }

        return strtoupper(str_replace('_', ' ', $type));
    }

    public function getScoreDisplayAttribute(): ?string
    {
        if ($this->estimated_band_score === null) {
            return null;
        }

        $score = (float) $this->estimated_band_score;
        $formattedNum = ((int) $score == $score) ? (string) (int) $score : number_format($score, 1);

        if ($this->isIelts()) {
            return 'Band ' . number_format($score, 1);
        }

        if ($this->isToeflIbt()) {
            if ($score <= 30) {
                return "iBT {$formattedNum} / 30";
            }
            return "iBT {$formattedNum} / 120";
        }

        if ($this->isToeflItp()) {
            if ($score > 100) {
                return "ITP {$formattedNum}";
            }
            return "ITP {$formattedNum} / 68";
        }

        if ($this->isPte()) {
            return "PTE {$formattedNum}";
        }

        if ($this->isCambridge()) {
            return "Cambridge {$formattedNum}";
        }

        // Default: Grammar or other percentage tests
        return "Skor {$formattedNum}%";
    }

    public function getCefrLevelAttribute(): ?string
    {
        if ($this->estimated_band_score === null) {
            return null;
        }

        $score = (float) $this->estimated_band_score;

        // 1. IELTS (Scale 0.0 - 9.0)
        if ($this->isIelts()) {
            if ($score >= 8.0) return 'C2';
            if ($score >= 7.0) return 'C1';
            if ($score >= 5.5) return 'B2';
            if ($score >= 4.0) return 'B1';
            if ($score >= 3.0) return 'A2';
            return 'A1';
        }

        // 2. TOEFL iBT
        if ($this->isToeflIbt()) {
            if ($score <= 30) {
                if ($score >= 29) return 'C2';
                if ($score >= 24) return 'C1';
                if ($score >= 18) return 'B2';
                if ($score >= 10) return 'B1';
                if ($score >= 6)  return 'A2';
                return 'A1';
            }
            if ($score >= 114) return 'C2';
            if ($score >= 95)  return 'C1';
            if ($score >= 72)  return 'B2';
            if ($score >= 42)  return 'B1';
            if ($score >= 30)  return 'A2';
            return 'A1';
        }

        // 3. TOEFL ITP
        if ($this->isToeflItp()) {
            if ($score > 100) {
                if ($score >= 627) return 'C1';
                if ($score >= 543) return 'B2';
                if ($score >= 460) return 'B1';
                if ($score >= 337) return 'A2';
                return 'A1';
            }
            if ($score >= 63) return 'C1';
            if ($score >= 54) return 'B2';
            if ($score >= 46) return 'B1';
            if ($score >= 34) return 'A2';
            return 'A1';
        }

        // 4. PTE Academic (Scale 10 - 90, Pearson Official)
        if ($this->isPte()) {
            if ($score >= 85) return 'C2';
            if ($score >= 76) return 'C1';
            if ($score >= 59) return 'B2';
            if ($score >= 43) return 'B1';
            if ($score >= 30) return 'A2';
            return 'A1';
        }

        // 5. Cambridge (Scale 80 - 230)
        if ($this->isCambridge()) {
            if ($score >= 200) return 'C2';
            if ($score >= 180) return 'C1';
            if ($score >= 160) return 'B2';
            if ($score >= 140) return 'B1';
            if ($score >= 120) return 'A2';
            return 'A1';
        }

        // 6. Grammar & Percentage-based Practice (0 - 100)
        if ($score >= 90) return 'C2';
        if ($score >= 80) return 'C1';
        if ($score >= 65) return 'B2';
        if ($score >= 50) return 'B1';
        if ($score >= 35) return 'A2';
        return 'A1';
    }

    public function getCompletionPercentageAttribute(): int
    {
        $raw = $this->ai_raw_json_feedback;
        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }

        if (isset($raw['completion_percentage']) && is_numeric($raw['completion_percentage'])) {
            return (int) $raw['completion_percentage'];
        }

        if ($this->isGrammar() && !empty($raw['results']) && is_array($raw['results'])) {
            $total = count($raw['results']);
            $answered = count(array_filter($raw['results'], function($r) {
                return !empty(trim($r['submitted'] ?? ''));
            }));
            return $total > 0 ? (int) round(($answered / $total) * 100) : 100;
        }

        if (str_contains($this->test_type ?? '', 'writing')) {
            if (!empty($this->answer_text)) {
                $wordCount = str_word_count(strip_tags($this->answer_text));
                $target = str_contains($this->test_type ?? '', 't1') ? 150 : 250;
                return min(100, max(10, (int) round(($wordCount / $target) * 100)));
            }
            return 100;
        }

        if (str_contains($this->test_type ?? '', 'speaking')) {
            if (!empty($this->audio_paths)) {
                $audios = is_array($this->audio_paths) ? $this->audio_paths : json_decode($this->audio_paths, true);
                if (is_array($audios)) {
                    return min(100, (int) round((count($audios) / 3) * 100));
                }
            }
            if (!empty($raw['recordings']) && is_array($raw['recordings'])) {
                return min(100, (int) round((count($raw['recordings']) / 3) * 100));
            }
            return 100;
        }

        if ($this->isPte() && !empty($raw['tasks']) && is_array($raw['tasks'])) {
            return 100;
        }

        return 100;
    }

    public function getCompletionDisplayAttribute(): string
    {
        $raw = $this->ai_raw_json_feedback;
        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }

        $pct = $this->completion_percentage;

        if ($this->isGrammar() && !empty($raw['results']) && is_array($raw['results'])) {
            $total = count($raw['results']);
            $answered = count(array_filter($raw['results'], function($r) {
                return !empty(trim($r['submitted'] ?? ''));
            }));
            return "{$pct}% ({$answered}/{$total} Soal)";
        }

        if (str_contains($this->test_type ?? '', 'writing')) {
            if (!empty($this->answer_text)) {
                $wordCount = str_word_count(strip_tags($this->answer_text));
                return "{$pct}% ({$wordCount} Kata)";
            }
            return "100% Selesai";
        }

        if (str_contains($this->test_type ?? '', 'speaking')) {
            $count = 0;
            if (!empty($this->audio_paths)) {
                $audios = is_array($this->audio_paths) ? $this->audio_paths : json_decode($this->audio_paths, true);
                if (is_array($audios)) $count = count($audios);
            } elseif (!empty($raw['recordings']) && is_array($raw['recordings'])) {
                $count = count($raw['recordings']);
            }
            if ($count > 0) {
                return "{$pct}% ({$count}/3 Audio)";
            }
            return "100% Selesai";
        }

        if ($this->isPte() && !empty($raw['tasks']) && is_array($raw['tasks'])) {
            $count = count($raw['tasks']);
            return "{$pct}% ({$count} Bagian)";
        }

        if ($this->isToeflItp() || $this->isToeflIbt()) {
            if (!empty($raw['answers']) && is_array($raw['answers'])) {
                $count = count($raw['answers']);
                return "{$pct}% ({$count} Soal)";
            }
            return "100% Selesai";
        }

        return "{$pct}% Selesai";
    }

    public function getDurationSecondsAttribute(): ?int
    {
        $raw = $this->ai_raw_json_feedback;
        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }

        if (isset($raw['duration_seconds']) && is_numeric($raw['duration_seconds']) && $raw['duration_seconds'] > 0) {
            return (int) $raw['duration_seconds'];
        }
        if (isset($raw['time_taken_seconds']) && is_numeric($raw['time_taken_seconds']) && $raw['time_taken_seconds'] > 0) {
            return (int) $raw['time_taken_seconds'];
        }
        if (isset($raw['time_spent']) && is_numeric($raw['time_spent']) && $raw['time_spent'] > 0) {
            return (int) $raw['time_spent'];
        }

        if ($this->created_at && $this->updated_at) {
            $diff = $this->updated_at->diffInSeconds($this->created_at);
            if ($diff >= 15 && $diff <= 10800) {
                return $diff;
            }
        }

        return null;
    }

    public function getDurationDisplayAttribute(): ?string
    {
        $seconds = $this->duration_seconds;

        if ($seconds !== null && $seconds > 0) {
            $mins = floor($seconds / 60);
            $secs = $seconds % 60;
            if ($mins > 0) {
                return sprintf('%d mnt %02d dtk', $mins, $secs);
            }
            return sprintf('%d detik', $secs);
        }

        if ($this->isGrammar()) {
            $raw = $this->ai_raw_json_feedback;
            if (is_string($raw)) $raw = json_decode($raw, true);
            $count = isset($raw['results']) && is_array($raw['results']) ? count($raw['results']) : 10;
            $estMins = max(2, round($count * 0.6));
            return "~{$estMins} mnt";
        }

        if (str_contains($this->test_type ?? '', 'writing')) {
            if (!empty($this->answer_text)) {
                $wordCount = str_word_count(strip_tags($this->answer_text));
                $estMins = max(5, round($wordCount / 15));
                return "~{$estMins} mnt";
            }
            return str_contains($this->test_type ?? '', 't1') ? '~20 mnt' : '~40 mnt';
        }

        if (str_contains($this->test_type ?? '', 'speaking')) {
            return '~12 mnt';
        }

        if ($this->isToeflItp()) {
            return '~35 mnt';
        }

        if ($this->isPte()) {
            return '~15 mnt';
        }

        return null;
    }

    public function getTestTypeBadgeClassAttribute(): string
    {
        if ($this->isIelts()) {
            return 'bg-rose-50 text-rose-700 border border-rose-200';
        }
        if ($this->isToeflIbt() || $this->isToeflItp()) {
            return 'bg-indigo-50 text-indigo-700 border border-indigo-200';
        }
        if ($this->isPte()) {
            return 'bg-teal-50 text-teal-700 border border-teal-200';
        }
        if ($this->isCambridge()) {
            return 'bg-amber-50 text-amber-800 border border-amber-200';
        }
        return 'bg-slate-100 text-slate-700 border border-slate-200';
    }

    public function getScoreBadgeClassAttribute(): string
    {
        if ($this->isIelts()) {
            return 'bg-blue-50 text-blue-900 border border-blue-200';
        }
        if ($this->isToeflIbt() || $this->isToeflItp()) {
            return 'bg-indigo-50 text-indigo-900 border border-indigo-200';
        }
        if ($this->isPte()) {
            return 'bg-teal-50 text-teal-900 border border-teal-200';
        }
        if ($this->isCambridge()) {
            return 'bg-amber-50 text-amber-900 border border-amber-200';
        }
        return 'bg-slate-100 text-slate-900 border border-slate-200';
    }

    public function getCefrBadgeClassAttribute(): string
    {
        $level = $this->cefr_level;
        return match ($level) {
            'C2', 'C1' => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
            'B2' => 'bg-blue-100 text-blue-800 border border-blue-300',
            'B1' => 'bg-amber-100 text-amber-800 border border-amber-300',
            'A2', 'A1' => 'bg-purple-100 text-purple-800 border border-purple-300',
            default => 'bg-gray-100 text-gray-700 border border-gray-200',
        };
    }

    public function getTargetProgramDisplayAttribute(): string
    {
        $type = strtolower($this->test_type ?? '');
        if ($type === 'writing_t1' || $type === 'writing_t2') return 'IELTS Academic Writing';
        if ($type === 'speaking') return 'IELTS Speaking';
        if (str_starts_with($type, 'ielts_')) return 'IELTS Preparation';
        if (str_starts_with($type, 'grammar_practice_')) {
            $raw = $this->ai_raw_json_feedback;
            if (is_string($raw)) $raw = json_decode($raw, true);
            $topic = $raw['topic'] ?? '';
            return $topic ? "Grammar: {$topic}" : 'Grammar for Writing';
        }
        if (str_starts_with($type, 'grammar_')) return 'Grammar for Writing';
        if (str_contains($type, 'toefl_ibt') || str_contains($type, 'toeflibt')) return 'TOEFL Ibt';
        if (str_contains($type, 'toefl')) return 'TOEFL ITP';
        if (str_contains($type, 'pte')) return 'PTE Academic';
        if (str_contains($type, 'cambridge')) return 'Cambridge English Prep';

        return 'Target Bahasa Course';
    }

    public function getAiRecommendedProgramDisplayAttribute(): string
    {
        $cefr = $this->cefr_level ?? 'B1';
        $target = strtolower($this->target_program_display ?? '');

        if ($this->isIelts()) {
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

        if ($this->isToeflItp() || $this->isToeflIbt()) {
            if ($this->isToeflIbt()) {
                if (in_array($cefr, ['C1', 'C2', 'B2'])) {
                    return 'TOEFL Ibt • Complexity Grammar for Writing';
                }
                return 'Fast Track Grammar for Writing • TOEFL Ibt';
            }
            if (in_array($cefr, ['C1', 'C2', 'B2'])) {
                return 'TOEFL ITP • Complexity Grammar for Writing';
            }
            if ($cefr === 'B1') {
                return 'TOEFL ITP • Fast Track Grammar for Writing';
            }
            return 'Introductory Grammar for Writing • TOEFL ITP';
        }

        if ($this->isPte()) {
            if (in_array($cefr, ['C1', 'C2', 'B2'])) {
                return 'PTE Academic • Complexity Grammar for Writing';
            }
            return 'Fast Track Grammar for Writing • PTE Academic';
        }

        // Grammar & general
        return match ($cefr) {
            'C2' => 'Proficiency Grammar for Writing • Advanced Speaking',
            'C1' => 'Proficiency Grammar for Writing • Advanced Speaking',
            'B2' => 'Complexity Grammar for Writing • Intermediate Speaking',
            'B1' => 'Fast Track Grammar for Writing • Intermediate Speaking',
            default => 'Introductory Grammar for Writing • Introductory Speaking',
        };
    }
}
