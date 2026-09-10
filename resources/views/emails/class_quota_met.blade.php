<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kuota Minimum Kelas Tercapai</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #333333; }
        .card { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { background: #16a34a; color: #ffffff; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 800; }
        .header p { margin: 6px 0 0 0; font-size: 13px; opacity: 0.9; }
        .body { padding: 24px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #edf2f7; font-size: 14px; }
        .table th { background: #f8fafc; color: #64748b; font-weight: 600; width: 35%; }
        .table td { color: #1e293b; font-weight: 500; }
        .footer { background: #f8fafc; padding: 16px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; background: #dcfce7; color: #166534; font-weight: 700; font-size: 12px; }
        .btn { display: inline-block; margin-top: 20px; padding: 12px 24px; background-color: #16a34a; color: #ffffff; text-decoration: none; border-radius: 30px; font-weight: 700; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>Kuota Minimum Kelas Tercapai!</h1>
            <p>Sistem Target Bahasa Course & Certification</p>
        </div>
        <div class="body">
            @if($quotaData['is_admin'] ?? false)
                <p style="font-size: 15px; margin-top: 0;">Halo Admin Target Bahasa,</p>
                <p style="font-size: 14px; color: #475569;">Sebuah batch kelas baru saja mencapai jumlah peserta minimum dan kini dipastikan akan berjalan sesuai jadwal.</p>
            @else
                <p style="font-size: 15px; margin-top: 0;">Halo {{ $quotaData['recipient_name'] ?? 'Peserta' }},</p>
                <p style="font-size: 14px; color: #475569;">Kabar baik! Kelas yang kamu booking sudah mencapai jumlah peserta minimum dan <strong>dipastikan akan berjalan</strong> sesuai jadwal. Sampai jumpa di kelas!</p>
            @endif

            <table class="table">
                <tr>
                    <th>Program Kursus</th>
                    <td><span class="badge">{{ $quotaData['program_name'] ?? '-' }}</span></td>
                </tr>
                <tr>
                    <th>Batch</th>
                    <td>{{ $quotaData['batch_name'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Moda Belajar</th>
                    <td>{{ $quotaData['learning_mode'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tutor / Pengajar</th>
                    <td>{{ $quotaData['teacher_name'] ?? 'Akan dikonfirmasi Admin' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Peserta</th>
                    <td>{{ $quotaData['student_count'] ?? '-' }} / {{ $quotaData['min_capacity'] ?? '-' }} (kuota minimum)</td>
                </tr>
            </table>

            @if($quotaData['is_admin'] ?? false)
            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ url('/admin/bookings') }}" class="btn">Buka Dashboard Booking Admin</a>
            </div>
            @endif
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Target Bahasa Course. Email otomatis dari sistem.
        </div>
    </div>
</body>
</html>
