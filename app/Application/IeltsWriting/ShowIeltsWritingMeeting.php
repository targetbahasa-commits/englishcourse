<?php

namespace App\Application\IeltsWriting;

use App\Domain\IeltsWriting\Repositories\IeltsWritingRepository;

class ShowIeltsWritingMeeting
{
    public function __construct(
        private readonly IeltsWritingRepository $repository
    ) {
    }

    public function handle(int $id): mixed
    {
        return $this->repository->findMeetingOrFail($id);
    }

    public function getPracticeItemsInRange(int $min, int $max): array
    {
        return $this->repository->getPracticeItemsInRange($min, $max);
    }
}
