<?php

namespace App\Application\FreeLesson;

use App\Domain\FreeLesson\Repositories\FreeLessonProgressRepository;

class SaveLessonProgress
{
    public function __construct(
        private readonly FreeLessonProgressRepository $progressRepository,
    ) {}

    /**
     * Save (or update) a user's progress for a lesson.
     *
     * @return mixed The persisted FreeLessonProgress model instance.
     */
    public function handle(int $userId, string $lessonSlug, float $score, int $totalQuestions): mixed
    {
        return $this->progressRepository->saveProgress($userId, $lessonSlug, $score, $totalQuestions);
    }
}
