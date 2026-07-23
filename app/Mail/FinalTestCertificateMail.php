<?php

namespace App\Mail;

use App\Models\FinalTestResult;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FinalTestCertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FinalTestResult $result,
        private readonly string $pdfContent,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Final Test Certificate - Target Bahasa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.final-test-certificate',
            with: [
                'result' => $this->result,
            ],
        );
    }

    public function attachments(): array
    {
        $fileName = 'Certificate_' . str_replace(' ', '_', $this->result->test_label ?: 'Final_Test') . '.pdf';

        return [
            Attachment::fromData(fn () => $this->pdfContent, $fileName)
                ->withMime('application/pdf'),
        ];
    }
}
