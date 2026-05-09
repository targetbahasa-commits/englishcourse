<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentConvertedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $payment;
    public $tempPassword;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, ?Payment $payment, string $tempPassword, ?string $pdfPath = null)
    {
        $this->user = $user;
        $this->payment = $payment;
        $this->tempPassword = $tempPassword;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Target Bahasa! Your Registration is Confirmed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.student-converted',
            with: [
                'user' => $this->user,
                'payment' => $this->payment,
                'tempPassword' => $this->tempPassword,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->pdfPath && file_exists($this->pdfPath)) {
            $attachments[] = Attachment::fromPath($this->pdfPath)
                ->as('Invoice-' . ($this->payment ? $this->payment->invoice_number : 'TB') . '.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
