<?php

namespace App\Mail;

use App\Models\FreeTestSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class FreeTestReevaluatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $resultUrl;
    public $testName;
    public $overallComment;

    public function __construct(FreeTestSubmission $submission)
    {
        $this->submission = $submission;
        $this->testName = strtoupper(str_replace('_', ' ', $submission->test_type));
        $this->resultUrl = url("/promo/test/result/{$submission->test_type}/0/{$submission->id}");

        $feedback = is_array($submission->ai_raw_json_feedback)
            ? $submission->ai_raw_json_feedback
            : (json_decode($submission->ai_raw_json_feedback, true) ?? []);

        $this->overallComment = $feedback['overall_comment'] ?? null;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Hasil Evaluasi AI Tes {$this->testName} Anda - Target Bahasa",
        );
    }

    public function headers(): Headers
    {
        return new Headers(text: [
            'X-Related-Type' => 'free_test_submission',
            'X-Related-Id' => (string) $this->submission->id,
        ]);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.free-test-reevaluated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
