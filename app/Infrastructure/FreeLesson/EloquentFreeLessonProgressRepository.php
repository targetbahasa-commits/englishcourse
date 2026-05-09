<?php

namespace App\Infrastructure\FreeLesson;

use App\Domain\FreeLesson\Repositories\FreeLessonProgressRepository;
use App\Models\FreeLessonProgress;

class EloquentFreeLessonProgressRepository implements FreeLessonProgressRepository
{
    public function saveProgress(int $userId, string $lessonSlug, float $score, int $totalQuestions): mixed
    {
        return FreeLessonProgress::updateOrCreate(
            [
                'user_id'     => $userId,
                'lesson_slug' => $lessonSlug,
            ],
            [
                'score'           => $score,
                'total_questions' => $totalQuestions,
                'completed_at'    => now(),
            ]
        );
    }

    public function findProgress(int $userId, string $lessonSlug): mixed
    {
        return FreeLessonProgress::where('user_id', $userId)
            ->where('lesson_slug', $lessonSlug)
            ->first();
    }
}
