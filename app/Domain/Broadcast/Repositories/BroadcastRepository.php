<?php

namespace App\Domain\Broadcast\Repositories;

interface BroadcastRepository
{
    public function listAll(int $perPage): mixed;

    public function create(array $data): mixed;

    public function updateStatus(mixed $broadcast, string $status): void;

    public function updateRecipientsCount(mixed $broadcast, int $count): void;
}
