<?php

namespace App\Application\ToeflListeningPractice;

use App\Domain\ToeflListeningPractice\Repositories\ListeningPracticeRepository;

class BuildListeningPracticePartAIndexData
{
    public function __construct(
        private readonly ListeningPracticeRepository $repository,
    ) {}

    public function handle(): array
    {
        $questionNumbers = collect($this->repository->getListeningPartAQuestionNumbers());

        $ranges = collect(range(1, 27))
            ->map(function ($index) use ($questionNumbers) {
                $start = (($index - 1) * 10) + 1;
                $end = $start + 9;
                $count = $questionNumbers->filter(fn ($number) => $number >= $start && $number <= $end)->count();

                return [
                    'start' => $start,
                    'end' => $end,
                    'label' => $start . '-' . $end,
                    'question_count' => $count,
                ];
            })
            ->values();

        return ['ranges' => $ranges];
    }
}