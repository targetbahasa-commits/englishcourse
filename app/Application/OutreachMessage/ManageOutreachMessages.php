<?php

namespace App\Application\OutreachMessage;

use App\Domain\OutreachMessage\Repositories\OutreachMessageRepository;

class ManageOutreachMessages
{
    public function __construct(
        private readonly OutreachMessageRepository $repository
    ) {}

    public function listAll(int $perPage = 15): mixed
    {
        return $this->repository->listAll($perPage);
    }

    public function create(array $data): void
    {
        $this->repository->create($data);
    }

    public function update(mixed $message, array $data): void
    {
        $this->repository->update($message, $data);
    }

    public function delete(mixed $message): void
    {
        $this->repository->delete($message);
    }

    public function getActiveProgramOptions(): array
    {
        return $this->repository->getActiveProgramOptions();
    }
}
