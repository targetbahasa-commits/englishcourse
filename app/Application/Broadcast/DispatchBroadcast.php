<?php

namespace App\Application\Broadcast;

use App\Domain\Broadcast\Contracts\BroadcastAudienceGateway;
use App\Domain\Broadcast\Repositories\BroadcastRepository;

class DispatchBroadcast
{
    public function __construct(
        private readonly BroadcastRepository $broadcasts,
        private readonly BroadcastAudienceGateway $audience,
    ) {}

    public function create(array $validated, bool $sendViaEmail, bool $sendViaWhatsapp, bool $sendViaInbox): mixed
    {
        $broadcast = $this->broadcasts->create([
            'title'              => $validated['title'],
            'content'            => $validated['content'],
            'target_role'        => $validated['target_role'],
            'send_via_email'     => $sendViaEmail,
            'send_via_whatsapp'  => $sendViaWhatsapp,
            'send_via_inbox'     => $sendViaInbox,
            'status'             => 'processing',
        ]);

        $recipientCount = $this->audience->countRecipients($validated['target_role']);
        $this->broadcasts->updateRecipientsCount($broadcast, $recipientCount);

        $this->audience->deliver(
            $broadcast,
            $validated['target_role'],
            $sendViaEmail,
            $sendViaWhatsapp,
            $sendViaInbox,
        );

        $this->broadcasts->updateStatus($broadcast, 'completed');

        return $broadcast;
    }

    public function listAll(int $perPage = 15): mixed
    {
        return $this->broadcasts->listAll($perPage);
    }
}
