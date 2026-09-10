<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class PaymentQueuedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Payment $payment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Baru - Invoice ' . $this->payment->invoice_number,
        );
    }

    public function headers(): Headers
    {
        return new Headers(text: [
            'X-Related-Type' => 'payment',
            'X-Related-Id' => (string) $this->payment->id,
            'X-User-Id' => (string) $this->payment->user_id,
        ]);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment-queued',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
