<?php

namespace App\Application\Inbox;

use App\Domain\Inbox\Repositories\InboxRepository;

class ManageInbox
{
    public function __construct(
        private readonly InboxRepository $repository
    ) {
    }

    public function getMessagesForUser(mixed $user): array
    {
        if ($user->role === 'admin') {
            return [
                'inboxMessages' => $this->repository->getAdminInboxMessages($user->id),
                'sentMessages'  => $this->repository->getAdminSentMessages($user->id),
            ];
        }

        return [
            'inboxMessages' => $this->repository->getUserInboxMessages($user->id),
            'sentMessages'  => $this->repository->getUserSentMessages($user->id),
        ];
    }

    public function send(mixed $user, array $data): void
    {
        $receiverId = $data['receiver_id'] ?? null;

        if ($user->role !== 'admin') {
            $receiverId = null;
        }

        $this->repository->createMessage([
            'sender_id'   => $user->id,
            'receiver_id' => $receiverId,
            'subject'     => $data['subject'],
            'content'     => $data['content'],
        ]);
    }

    public function markDirectMessageAsRead(int $messageId, mixed $user): void
    {
        $message = $this->repository->findMessage($messageId);

        if ($message && (
            $message->receiver_id == $user->id ||
            ($user->role === 'admin' && is_null($message->receiver_id))
        )) {
            $this->repository->markMessageAsRead($messageId);
        }
    }
}
