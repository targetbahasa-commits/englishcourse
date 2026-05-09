<?php

namespace App\Domain\Broadcast\Contracts;

interface BroadcastAudienceGateway
{
    public function countRecipients(string $targetRole): int;

    public function deliver(
        mixed $broadcast,
        string $targetRole,
        bool $sendViaEmail,
        bool $sendViaWhatsapp,
        bool $sendViaInbox,
    ): void;
}
