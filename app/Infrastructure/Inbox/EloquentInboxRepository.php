<?php

namespace App\Infrastructure\Inbox;

use App\Domain\Inbox\Repositories\InboxRepository;
use App\Models\DirectMessage;
use Illuminate\Support\Collection;

class EloquentInboxRepository implements InboxRepository
{
    public function getAdminInboxMessages(int $userId): Collection
    {
        return DirectMessage::with('sender')
            ->whereNull('receiver_id')
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get();
    }

    public function getAdminSentMessages(int $userId): Collection
    {
        return DirectMessage::with('receiver')
            ->where('sender_id', $userId)
            ->latest()
            ->get();
    }

    public function getUserInboxMessages(int $userId): Collection
    {
        return DirectMessage::with('sender')
            ->where('receiver_id', $userId)
            ->latest()
            ->get();
    }

    public function getUserSentMessages(int $userId): Collection
    {
        return DirectMessage::with('receiver')
            ->where('sender_id', $userId)
            ->latest()
            ->get();
    }

    public function createMessage(array $data): void
    {
        DirectMessage::create($data);
    }

    public function findMessage(mixed $id): mixed
    {
        return DirectMessage::find($id);
    }

    public function markMessageAsRead(int $id): void
    {
        DirectMessage::where('id', $id)->update(['read_at' => now()]);
    }
}
