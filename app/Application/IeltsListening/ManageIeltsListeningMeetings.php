<?php

namespace App\Application\IeltsListening;

use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;

class ManageIeltsListeningMeetings
{
    public function __construct(
        private readonly IeltsListeningRepository $repository,
    ) {}

    public function createMeeting(array $attributes): void
    {
        $program = $this->repository->findProgramBySlugWithMeetings('ielts-academic-listening');

        $this->repository->createMeeting($program->id, [
            'meeting_number' => $attributes['meeting_number'],
            'title' => $attributes['title'],
            'is_locked' => true,
        ]);
    }

    public function reorderMeetings(array $meetingIds): void
    {
        $this->repository->reorderMeetings($meetingIds);
    }
}
