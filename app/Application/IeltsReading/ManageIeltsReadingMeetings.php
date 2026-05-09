<?php

namespace App\Application\IeltsReading;

use App\Domain\IeltsReading\Repositories\IeltsReadingRepository;

class ManageIeltsReadingMeetings
{
    public function __construct(
        private readonly IeltsReadingRepository $repository,
    ) {}

    public function createMeeting(array $attributes): void
    {
        $program = $this->repository->findProgramBySlugWithMeetings('ielts-academic-reading');

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
