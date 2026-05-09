<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentProofUploadedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Payment $payment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Transfer Diunggah - Invoice ' . $this->payment->invoice_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment-proof-uploaded',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
