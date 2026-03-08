<?php

namespace App\Mail;

use App\Models\OutreachMessage;
use App\Models\FreeTestResult;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OutreachFollowUpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $testResult;
    public $outreachMessage;
    public $recommendedProgram;

    /**
     * Create a new message instance.
     */
    public function __construct(FreeTestResult $testResult, OutreachMessage $outreachMessage)
    {
        $this->testResult = $testResult;
        $this->outreachMessage = $outreachMessage;
        $this->recommendedProgram = $outreachMessage->program;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $testName = strtoupper(str_replace('_', ' ', $this->testResult->test_type));
        return new Envelope(
            subject: "Hasil Tes {$testName} Anda & Rekomendasi Belajar - Target Bahasa",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.outreach-follow-up',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
