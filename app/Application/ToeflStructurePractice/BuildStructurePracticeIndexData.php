<?php

namespace App\Application\ToeflStructurePractice;

use App\Domain\ToeflStructurePractice\Repositories\ToeflStructurePracticeRepository;

class BuildStructurePracticeIndexData
{
    public function __construct(
        private readonly ToeflStructurePracticeRepository $repository,
    ) {}

    public function handle(): array
    {
        $activeMeetings = $this->repository->getActivePracticeExercises(3);

        $practicePackages = collect(range(1, 70))->map(function ($number) use ($activeMeetings) {
            $activeMeeting = $activeMeetings[$number - 1] ?? null;

            if ($activeMeeting) {
                return [
                    'package_number' => $number,
                    'status' => 'available',
                    'title' => (string) $activeMeeting->title,
                    'meeting_number' => (int) $activeMeeting->meeting_number,
                    'question_count' => $this->repository->countQuestionsByMeeting($activeMeeting->id),
                ];
            }

            return [
                'package_number' => $number,
                'title' => 'Coming Soon',
                'status' => 'coming_soon',
            ];
        });

        return [
            'practicePackages' => $practicePackages,
        ];
    }
}