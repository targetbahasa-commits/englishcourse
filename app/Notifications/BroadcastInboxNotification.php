<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BroadcastInboxNotification extends Notification
{
    use Queueable;

    public $broadcastMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\BroadcastMessage $broadcastMessage)
    {
        $this->broadcastMessage = $broadcastMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = [];
        if ($this->broadcastMessage->send_via_inbox) {
            $channels[] = 'database';
        }
        if ($this->broadcastMessage->send_via_email) {
            $channels[] = 'mail';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject($this->broadcastMessage->title)
                    ->line(strip_tags($this->broadcastMessage->content));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'broadcast_id' => $this->broadcastMessage->id,
            'title' => $this->broadcastMessage->title,
            'content' => $this->broadcastMessage->content,
        ];
    }
}
