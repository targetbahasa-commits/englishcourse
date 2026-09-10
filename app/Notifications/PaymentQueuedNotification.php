<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentQueuedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Payment $payment
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $studentName = $this->payment->user->name ?? 'Student';
        $programName = $this->payment->program->name ?? '-';
        $netAmount = max(0, $this->payment->amount - $this->payment->discount_amount);

        return [
            'title' => 'Pendaftaran Baru: ' . $this->payment->invoice_number,
            'content' => "{$studentName} mendaftar program {$programName} - Rp" . number_format($netAmount, 0, ',', '.'),
            'source' => 'Sistem Pembayaran',
            'action_url' => route('admin.payments.queue', ['q' => $this->payment->invoice_number]),
            'action_label' => 'Lihat Payment Queue',
        ];
    }
}
