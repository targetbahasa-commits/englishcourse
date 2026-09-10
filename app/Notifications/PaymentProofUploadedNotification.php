<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentProofUploadedNotification extends Notification
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

        return [
            'title' => 'Bukti Transfer Baru: ' . $this->payment->invoice_number,
            'content' => "{$studentName} mengunggah bukti transfer, menunggu verifikasi.",
            'source' => 'Sistem Pembayaran',
            'action_url' => route('admin.payments.proofs'),
            'action_label' => 'Lihat Bukti Transfer',
        ];
    }
}
