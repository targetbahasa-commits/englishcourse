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
        
        \App\Models\EmailLog::create([
            'to_email' => $toEmail,
            'subject' => $subject,
            'body' => $body,
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }
}
