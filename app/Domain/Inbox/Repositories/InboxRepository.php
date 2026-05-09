<?php

namespace App\Domain\Inbox\Repositories;

use Illuminate\Support\Collection;

interface InboxRepository
{
    public function getAdminInboxMessages(int $userId): Collection;

    public function getAdminSentMessages(int $userId): Collection;

    public function getUserInboxMessages(int $userId): Collection;

    public function getUserSentMessages(int $userId): Collection;

    public function createMessage(array $data): void;

    public function findMessage(mixed $id): mixed;

    public function markMessageAsRead(int $id): void;
}
