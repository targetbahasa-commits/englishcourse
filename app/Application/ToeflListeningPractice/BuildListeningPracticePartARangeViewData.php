<?php

namespace App\Application\ToeflListeningPractice;

use App\Domain\ToeflListeningPractice\Repositories\ListeningPracticeRepository;

class BuildListeningPracticePartARangeViewData
{
    public function __construct(
        private readonly ListeningPracticeRepository $repository,
    ) {}

    public function handle(int $start, int $end): array
    {
        $isValidBoundary = $start >= 1 && $end <= 270 && (($start - 1) % 10 === 0) && ($end === $start + 9);
        if (!$isValidBoundary) {
            abort(404);
        }

        $questions = $this->repository->getListeningPartAQuestionsByRange($start, $end);

        return [
            'questions' => $questions,
            'start' => $start,
            'end' => $end,
        ];
    }
}