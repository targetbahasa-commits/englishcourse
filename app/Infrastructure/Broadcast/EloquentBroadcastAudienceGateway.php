<?php

namespace App\Infrastructure\Broadcast;

use App\Domain\Broadcast\Contracts\BroadcastAudienceGateway;
use App\Domain\Notification\Contracts\WhatsAppGateway;
use App\Models\User;
use App\Models\RegistrationLead;
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
                // If it's a RegistrationLead, we only send email if they have an email address
                // Notifiable handles the email part automatically via the 'mail' channel if they have an 'email' attribute.
                if (!($user instanceof RegistrationLead) || !empty($user->email)) {
                    $user->notify(new BroadcastInboxNotification($broadcast));
                }
            }

            if ($sendViaWhatsapp) {
                $phone = $user instanceof RegistrationLead ? $user->whatsapp : $user->phone_number;
                if (!empty($phone)) {
                    $this->whatsapp->sendMessage(
                        $phone,
                        '*' . $broadcast->title . "*\n\n" . $broadcast->content
                    );
                }
            }
        }
    }

    private function recipientQuery(string $targetRole): mixed
    {
        if ($targetRole === 'lead') {
            return RegistrationLead::query();
        }

        $query = User::query();

        if ($targetRole !== 'all') {
            $query->where('role', $targetRole);
        }

        return $query;
    }
}
