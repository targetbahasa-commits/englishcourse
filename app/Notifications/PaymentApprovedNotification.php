<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentApprovedNotification extends Notification
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
        $programName = $this->payment->program->name ?? 'program';

        return [
            'title' => 'Pembayaran Disetujui: ' . $this->payment->invoice_number,
            'content' => "Pembayaran Anda untuk {$programName} telah diverifikasi dan enrollment Anda sudah aktif.",
            'source' => 'Sistem Pembayaran',
            'action_url' => route('student.payments.show', $this->payment),
            'action_label' => 'Lihat Detail Pembayaran',
        ];
    }
}
