<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pemberitahuan Booking Kelas Baru</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #333333; }
        .card { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: #2563eb; color: #ffffff; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 800; }
        .header p { margin: 6px 0 0 0; font-size: 13px; opacity: 0.9; }
        .body { padding: 24px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #edf2f7; font-size: 14px; }
        .table th { background: #f8fafc; color: #64748b; font-weight: 600; width: 35%; }
        .table td { color: #1e293b; font-weight: 500; }
        .footer { background: #f8fafc; padding: 16px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; background: #dbeafe; color: #1e40af; font-weight: 700; font-size: 12px; }
        .btn { display: inline-block; margin-top: 20px; padding: 12px 24px; background-color: #2563eb; color: #ffffff; text-decoration: none; border-radius: 30px; font-weight: 700; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>Pendaftaran Booking Kelas Baru</h1>
            <p>Sistem Target Bahasa Course & Certification</p>
        </div>
        <div class="body">
            <p style="font-size: 15px; margin-top: 0;">Halo Admin Target Bahasa,</p>
            <p style="font-size: 14px; color: #475569;">Seorang pendaftar baru saja melakukan booking kelas secara mandiri lewat formulir Booking Class. Berikut detail data pendaftaran:</p>

            <table class="table">
                <tr>
                    <th>Nama Peserta</th>
                    <td><strong>{{ $bookingData['student_name'] ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><a href="mailto:{{ $bookingData['student_email'] ?? '' }}">{{ $bookingData['student_email'] ?? '-' }}</a></td>
                </tr>
                <tr>
                    <th>Nomor WhatsApp</th>
                    <td><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bookingData['student_phone'] ?? '') }}">{{ $bookingData['student_phone'] ?? '-' }}</a></td>
                </tr>
                <tr>
                    <th>Program Kursus</th>
                    <td><span class="badge">{{ $bookingData['program_name'] ?? '-' }}</span></td>
                </tr>
                <tr>
                    <th>Periode Belajar</th>
                    <td>{{ $bookingData['batch_name'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tipe Kelas</th>
                    <td>{{ $bookingData['batch_type'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Moda Belajar</th>
                    <td>{{ $bookingData['learning_mode'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tutor / Pengajar</th>
                    <td>{{ $bookingData['teacher_name'] ?? 'Akan dikonfirmasi Admin' }}</td>
                </tr>
                <tr>
                    <th>Waktu Booking</th>
                    <td>{{ $bookingData['booked_at'] ?? now()->format('d M Y, H:i') . ' WIB' }}</td>
                </tr>
                @if(!empty($bookingData['notes']))
                <tr>
                    <th>Catatan Tambahan</th>
                    <td style="white-space: pre-wrap; font-style: italic; color: #334155;">{{ $bookingData['notes'] }}</td>
                </tr>
                @endif
            </table>

            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ url('/admin/bookings') }}" class="btn">Buka Dashboard Booking Admin</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Target Bahasa Course. Email otomatis dari sistem.
        </div>
    </div>
</body>
</html>
