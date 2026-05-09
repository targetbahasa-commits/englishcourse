<?php

namespace App\Domain\Announcement\Repositories;

interface AnnouncementRepository
{
    public function listVisibleTo(mixed $user, int $perPage): mixed;

    public function getUnreadIdsIn(mixed $user, array $ids): array;

    public function getAllUnreadIds(mixed $user): array;

    public function markAllRead(mixed $user, array $ids): void;

    // Admin CRUD
    public function listAll(int $perPage): mixed;

    public function create(array $data): void;

    public function update(mixed $announcement, array $data): void;

    public function delete(mixed $announcement): void;
}
