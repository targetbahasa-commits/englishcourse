<?php

namespace App\Mail;

use App\Models\OfflineTestResult;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OfflineTestCertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public OfflineTestResult $result,
        private readonly string $pdfContent,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Certificate of Achievement - Target Bahasa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.offline-test-certificate',
        );
    }

    public function attachments(): array
    {
        $testName = str_replace(' ', '_', str($this->result->test_type)->title());
        $fileName = 'Certificate_' . $testName . '.pdf';

        return [
            Attachment::fromData(fn () => $this->pdfContent, $fileName)
                ->withMime('application/pdf'),
        ];
    }
}
