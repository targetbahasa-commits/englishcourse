<?php

namespace App\Application\IeltsShared;

use App\Domain\IeltsShared\Repositories\IeltsSharedRepository;

class ManageIeltsMeetings
{
    public function __construct(
        private readonly IeltsSharedRepository $repository,
    ) {
    }

    public function update(int $id, array $attributes): void
    {
        $this->repository->updateMeeting($id, [
            'title' => $attributes['title'],
            'meeting_number' => $attributes['meeting_number'],
        ]);
    }

    public function destroy(int $id): void
    {
        $this->repository->deleteMeeting($id);
    }

    public function toggleLock(int $id): void
    {
        $this->repository->toggleMeetingLock($id);
    }
}