<?php

namespace App\Infrastructure\Broadcast;

use App\Domain\Broadcast\Contracts\BroadcastAudienceGateway;
use App\Domain\Notification\Contracts\WhatsAppGateway;
use App\Models\User;
use App\Notifications\BroadcastInboxNotification;

class EloquentBroadcastAudienceGateway implements BroadcastAudienceGateway
{
    public function __construct(
        private readonly WhatsAppGateway $whatsapp,
    ) {}

    public function countRecipients(string $targetRole): int
    {
        return $this->recipientQuery($targetRole)->count();
    }

    public function deliver(
        mixed $broadcast,
        string $targetRole,
        bool $sendViaEmail,
        bool $sendViaWhatsapp,
        bool $sendViaInbox,
    ): void {
        $users = $this->recipientQuery($targetRole)->get();

        foreach ($users as $user) {
            if ($sendViaInbox || $sendViaEmail) {
                $user->notify(new BroadcastInboxNotification($broadcast));
            }

            if ($sendViaWhatsapp && !empty($user->phone_number)) {
                $this->whatsapp->sendMessage(
                    $user->phone_number,
                    '*' . $broadcast->title . "*\n\n" . $broadcast->content
                );
            }
        }
    }

    private function recipientQuery(string $targetRole): mixed
    {
        $query = User::query();

        if ($targetRole !== 'all') {
            $query->where('role', $targetRole);
        }

        return $query;
    }
}
