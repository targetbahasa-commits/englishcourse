<x-mail::message>
# Bukti Transfer Baru Diunggah

Halo Admin,

Student **{{ $payment->user->name ?? 'Student' }}** telah mengunggah bukti transfer untuk pembayaran dengan nomor invoice **{{ $payment->invoice_number }}**.

**Detail Pembayaran:**
- Program: {{ $payment->program->name ?? '-' }}
- Net Amount: Rp{{ number_format(max(0, $payment->amount - $payment->discount_amount), 0, ',', '.') }}
- Channel: {{ $payment->payment_channel }}

Silakan cek dashboard admin untuk melakukan verifikasi.

<x-mail::button :url="route('admin.payments.index', ['q' => $payment->invoice_number])">
Verifikasi Pembayaran
</x-mail::button>

Terima kasih,<br>
Sistem Target Bahasa
</x-mail::message>
