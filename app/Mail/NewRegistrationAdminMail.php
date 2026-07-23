<?php

namespace App\Mail;

use App\Models\RegistrationLead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewRegistrationAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly RegistrationLead $lead
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Baru: ' . $this->lead->full_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new_registration_admin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
