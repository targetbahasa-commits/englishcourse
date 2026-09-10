<?php

namespace App\Application\IeltsListening;

use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;

class PrepareIeltsListeningPracticeData
{
    public function __construct(
        private readonly IeltsListeningRepository $repository,
    ) {}

    public function createPracticeIndexTestMeeting(int $set): array
    {
        $practiceParts = [
            1 => ['meeting_title' => 'IELTS Listening Practice Set 1'],
            2 => ['meeting_title' => 'IELTS Listening Practice Set 2'],
            3 => ['meeting_title' => 'IELTS Listening Practice Set 3'],
            4 => ['meeting_title' => 'IELTS Listening Practice Set 4'],
        ];

        if (!array_key_exists($set, $practiceParts)) {
            abort(404);
        }

        $program = $this->repository->findProgramBySlugWithMeetings('ielts-academic-listening');
        if (!$program) {
            $program = \App\Models\Program::firstOrCreate(
                ['slug' => 'ielts-academic-listening'],
                ['name' => 'IELTS Academic Listening']
            );
        }
        $meeting = $this->repository->findOrCreateMeeting($program->id, $set, [
            'title' => $practiceParts[$set]['meeting_title'],
        ]);

        return [
            'meeting' => $meeting,
            'set' => $set,
        ];
    }

    public function ensurePracticeMeetingIsAccessible(int $meetingId, int $set, ?int $partNumber, $user): array
    {
        $meeting = $this->repository->findMeetingOrFail($meetingId);

        $resolvedSet = $partNumber ?? $set;

        if (!$this->repository->meetingHasSections($meetingId)) {
            $parts = [
                1 => 'Conversation (Social Context)',
                2 => 'Monologue (Social Context)',
                3 => 'Conversation (Educational)',
                4 => 'Monologue (Academic Subject)',
            ];

            foreach ($parts as $number => $title) {
                $this->repository->createSection([
                    'meeting_id' => $meeting->id,
                    'section_number' => $number,
                    'title' => $title,
                ]);
            }

            $meeting = $this->repository->findMeetingOrFail($meetingId);
        }

        return [
            'meeting' => $meeting,
            'set' => $resolvedSet,
            'isLocked' => $meeting->is_locked,
        ];
    }

    public function ensurePracticeTestIsAccessible(int $meetingId, int $set, int $testId, ?int $partNumber, $user): array
    {
        $meeting = $this->repository->findMeetingOrFail($meetingId);

        return [
            'meeting' => $meeting,
            'set' => $partNumber ?? $set,
            'testId' => $testId,
            'isLocked' => $meeting->is_locked,
        ];
    }
}
