<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pembayaran Dikonfirmasi - Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f9fafb; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #15803d; margin: 0; }
        .content { margin-bottom: 30px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #2563eb; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
        .box { background-color: #f3f4f6; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .box dt { font-weight: bold; color: #4b5563; font-size: 12px; text-transform: uppercase; margin-top: 10px; }
        .box dt:first-child { margin-top: 0; }
        .box dd { margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pembayaran Dikonfirmasi!</h1>
        </div>

        <div class="content">
            <p>Hi {{ $payment->user->name ?? 'Student' }},</p>

            <p>Pembayaran Anda telah kami verifikasi dan enrollment Anda untuk program <strong>{{ $payment->program->name ?? 'program' }}</strong> sekarang sudah <strong>aktif</strong>.</p>

            <div class="box">
                <dl>
                    <dt>Invoice</dt>
                    <dd>{{ $payment->invoice_number }}</dd>
                    <dt>Program</dt>
                    <dd>{{ $payment->program->name ?? '-' }}</dd>
                    <dt>Jumlah Dibayar</dt>
                    <dd>Rp{{ number_format($payment->paid_amount ?? $payment->amount, 0, ',', '.') }}</dd>
                </dl>
            </div>

            <p>Anda sudah bisa login ke Student Dashboard untuk mengakses materi kelas dan jadwal Anda.</p>

            <div style="text-align: center;">
                <a href="{{ route('student.payments.show', $payment) }}" class="btn">Lihat Detail Pembayaran</a>
            </div>
        </div>

        <div class="footer">
            <p>Jika ada pertanyaan, balas email ini atau hubungi kami via WhatsApp.</p>
            <p>&copy; {{ date('Y') }} Target Bahasa. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
