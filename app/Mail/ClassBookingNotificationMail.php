<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClassBookingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly array $bookingData
    ) {}

    public function envelope(): Envelope
    {
        $name = $this->bookingData['student_name'] ?? 'Siswa';
        $program = $this->bookingData['program_name'] ?? 'Kursus';

        return new Envelope(
            subject: "[Booking Kelas Baru] {$name} - {$program}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.class_booking_notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
