<?php

namespace App\Application\Announcement;

use App\Domain\Announcement\Repositories\AnnouncementRepository;

class ManageAnnouncements
{
    public function __construct(
        private readonly AnnouncementRepository $repository
    ) {}

    public function listAll(int $perPage = 15): mixed
    {
        return $this->repository->listAll($perPage);
    }

    public function create(array $data): void
    {
        $this->repository->create($data);
    }

    public function update(mixed $announcement, array $data): void
    {
        $this->repository->update($announcement, $data);
    }

    public function delete(mixed $announcement): void
    {
        $this->repository->delete($announcement);
    }
}
