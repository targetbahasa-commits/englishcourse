<?php

namespace App\Application\FinalTest;

use App\Models\Enrollment;
use App\Models\MeetingScore;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Collection;

class StudentFinalTestAccess
{
    private const PRIMARY_SLUGS = [
        'toefl-itp',
        'ielts-academic',
        'ielts-general',
        'pte-academic',
    ];

    private const GRAMMAR_TRACK_SLUGS = [
        'introductory-grammar-for-writing',
        'complexity-grammar-for-writing',
        'proficiency-grammar-for-writing',
        'fast-track-grammar-for-writing',
    ];

    private const SPEAKING_TRACK_SLUGS = [
        'introductory-speaking',
        'intermediate-speaking',
        'advanced-speaking',
    ];

    public function canAccessMenu(?User $user): bool
    {
        if (!$user?->isStudent()) {
            return false;
        }

        foreach ($this->enrolledPrograms($user) as $program) {
            if ($this->hasCompletedAllMeetings($user, (int) $program->id)) {
                return true;
            }
        }

        return false;
    }

    public function enrolledPrograms(User $user): Collection
    {
        $programs = collect();

        $user->loadMissing('program');

        if ($user->program) {
            $programs->push($user->program);
        }

        Enrollment::query()
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->with('program')
            ->get()
            ->each(function (Enrollment $enrollment) use ($programs) {
                if ($enrollment->program) {
                    $programs->push($enrollment->program);
                }
            });

        return $programs->unique('id')->values();
    }

    public function hasCompletedAllMeetings(User $user, int $programId): bool
    {
        $totalMeetings = (int) Program::query()
            ->whereKey($programId)
            ->withCount('meetings')
            ->value('meetings_count');

        $completedMeetings = (int) MeetingScore::query()
            ->where('user_id', $user->id)
            ->where('program_id', $programId)
            ->distinct()
            ->count('meeting_number');

        if ($totalMeetings <= 0) {
            return $completedMeetings > 0;
        }

        return $completedMeetings >= $totalMeetings;
    }

    /**
     * @return list<string>
     */
    public function resolveEnrolledFinalTestSlugs(User $user): array
    {
        $slugs = [];

        foreach ($this->enrolledPrograms($user) as $program) {
            $slug = (string) $program->slug;

            if (in_array($slug, self::GRAMMAR_TRACK_SLUGS, true) || in_array($slug, self::SPEAKING_TRACK_SLUGS, true)) {
                $slugs[] = $slug;
                continue;
            }

            $primarySlug = $this->mapToPrimaryFinalTestSlug($slug);
            if ($primarySlug !== null) {
                $slugs[] = $primarySlug;
            }
        }

        return array_values(array_unique($slugs));
    }

    public function mapToPrimaryFinalTestSlug(?string $slug): ?string
    {
        if ($slug === null || $slug === '') {
            return null;
        }

        if ($slug === 'pte') {
            return 'pte-academic';
        }

        if (in_array($slug, ['ielts-academic-listening', 'ielts-academic-reading', 'ielts-academic-full-package', 'ielts-academic-all-sections', 'ielts-academic-writing', 'ielts-academic-speaking'], true)) {
            return 'ielts-academic';
        }

        if (in_array($slug, self::PRIMARY_SLUGS, true)) {
            return $slug;
        }

        return null;
    }

    public function isPrimaryFinalTestSlug(string $slug): bool
    {
        return in_array($slug, self::PRIMARY_SLUGS, true);
    }

    public function isGrammarTrackSlug(string $slug): bool
    {
        return in_array($slug, self::GRAMMAR_TRACK_SLUGS, true);
    }

    public function isSpeakingTrackSlug(string $slug): bool
    {
        return in_array($slug, self::SPEAKING_TRACK_SLUGS, true);
    }
}
