<?php

namespace App\Mail;

use App\Models\OfflineTestResult;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
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

    public function headers(): Headers
    {
        return new Headers(text: [
            'X-Related-Type' => 'offline_test_result',
            'X-Related-Id' => (string) $this->result->id,
            'X-User-Id' => (string) $this->result->user_id,
        ]);
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
