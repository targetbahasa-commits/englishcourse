<?php

namespace App\Infrastructure\Broadcast;

use App\Domain\Broadcast\Repositories\BroadcastRepository;
use App\Models\BroadcastMessage;

class EloquentBroadcastRepository implements BroadcastRepository
{
    public function listAll(int $perPage): mixed
    {
        return BroadcastMessage::latest()->paginate($perPage);
    }

    public function create(array $data): mixed
    {
        return BroadcastMessage::create($data);
    }

    public function updateStatus(mixed $broadcast, string $status): void
    {
        $broadcast->update(['status' => $status]);
    }

    public function updateRecipientsCount(mixed $broadcast, int $count): void
    {
        $broadcast->update(['recipients_count' => $count]);
    }
}
