<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClassQuotaMetMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly array $quotaData
    ) {}

    public function envelope(): Envelope
    {
        $program = $this->quotaData['program_name'] ?? 'Kelas';
        $batch = $this->quotaData['batch_name'] ?? '';

        return new Envelope(
            subject: "[Kuota Minimum Tercapai] {$program} - {$batch}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.class_quota_met',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
