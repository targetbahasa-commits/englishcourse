<?php

namespace App\Domain\ToeflStructurePractice\Repositories;

interface ToeflStructurePracticeRepository
{
    public function getActivePracticeExercises(int $limit): array;

    public function countQuestionsByMeeting(int $meetingId): int;
}
