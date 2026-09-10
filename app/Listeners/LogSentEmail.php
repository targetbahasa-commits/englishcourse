<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSentEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(\Illuminate\Mail\Events\MessageSent $event): void
    {
        $message = $event->message;
        
        $toAddresses = [];
        foreach ($message->getTo() as $address) {
            $toAddresses[] = $address->getAddress();
        }
        
        $toEmail = implode(', ', $toAddresses);
        $subject = $message->getSubject();
        $body = $message->getHtmlBody() ?: $message->getTextBody();

        $headers = $message->getHeaders();
        $relatedType = $headers->has('X-Related-Type') ? $headers->get('X-Related-Type')->getBodyAsString() : null;
        $relatedId = $headers->has('X-Related-Id') ? $headers->get('X-Related-Id')->getBodyAsString() : null;
        $userId = $headers->has('X-User-Id') ? $headers->get('X-User-Id')->getBodyAsString() : null;

        \App\Models\EmailLog::create([
            'to_email' => $toEmail,
            'subject' => $subject,
            'body' => $body,
            'status' => 'sent',
            'sent_at' => now(),
            'related_type' => $relatedType,
            'related_id' => ($relatedId !== null && $relatedId !== '') ? $relatedId : null,
            'user_id' => ($userId !== null && $userId !== '' && $userId !== '0') ? $userId : null,
        ]);
    }
}
