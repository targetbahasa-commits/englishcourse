<x-mail::message>
# Pendaftaran / Pembayaran Baru

Halo Admin,

Student **{{ $payment->user->name ?? 'Student' }}** ({{ $payment->user->email ?? '-' }}) baru saja mendaftar dan membuat invoice pembayaran baru dengan nomor **{{ $payment->invoice_number }}**.

**Detail Pembayaran:**
- Program: {{ $payment->program->name ?? '-' }}
- Net Amount: Rp{{ number_format(max(0, $payment->amount - $payment->discount_amount), 0, ',', '.') }}
- Channel: {{ $payment->payment_channel }}
- Status: {{ strtoupper($payment->status) }}

Silakan cek Payment Queue di dashboard admin untuk meninjau pendaftaran ini.

<x-mail::button :url="route('admin.payments.queue', ['q' => $payment->invoice_number])">
Lihat Payment Queue
</x-mail::button>

Terima kasih,<br>
Sistem Target Bahasa
</x-mail::message>
