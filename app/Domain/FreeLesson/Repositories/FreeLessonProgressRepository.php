<?php

namespace App\Domain\FreeLesson\Repositories;

interface FreeLessonProgressRepository
{
    public function saveProgress(int $userId, string $lessonSlug, float $score, int $totalQuestions): mixed;

    public function findProgress(int $userId, string $lessonSlug): mixed;
}
