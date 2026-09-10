<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Evaluasi AI Tes Anda</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; }
        .header { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: #fff; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 22px; font-weight: 700; letter-spacing: 0.5px; }
        .content { padding: 30px 24px; }
        .score-box { background-color: #eff6ff; border: 2px dashed #93c5fd; border-radius: 12px; padding: 20px; text-align: center; margin: 20px 0; }
        .score-box .label { margin: 0; font-size: 13px; color: #1e40af; text-transform: uppercase; font-weight: 600; letter-spacing: 1px; }
        .score-box .score { margin: 8px 0 0 0; color: #1d4ed8; font-size: 42px; font-weight: 800; line-height: 1; }
        .comment-box { background-color: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 20px 0; border-radius: 0 8px 8px 0; }
        .btn { display: inline-block; padding: 14px 28px; background-color: #2563eb; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; margin-top: 15px; box-shadow: 0 2px 4px rgba(37,99,235,0.2); }
        .btn:hover { background-color: #1d4ed8; }
        .footer { background-color: #f8fafc; padding: 16px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #f1f5f9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>TARGET BAHASA</h1>
            <p style="margin: 4px 0 0 0; font-size: 13px; opacity: 0.9;">Laporan Evaluasi AI</p>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $submission->name }}</strong>,</p>
            
            <p>Terima kasih telah mengikuti evaluasi tes di <strong>Target Bahasa</strong>. Hasil tes <strong>{{ $testName }}</strong> Anda telah selesai dinilai oleh sistem AI kami!</p>
            
            <div class="score-box">
                <p class="label">Estimated Band Score</p>
                <div class="score">{{ $submission->estimated_band_score ?? 'N/A' }}</div>
            </div>

            @if($overallComment)
                <div class="comment-box">
                    <h4 style="margin-top: 0; color: #1e293b; font-size: 14px;">Catatan Evaluasi:</h4>
                    <p style="margin-bottom: 0; color: #475569; font-size: 14px;">{{ $overallComment }}</p>
                </div>
            @endif

            <p style="text-align: center; margin-top: 25px;">
                <a href="{{ $resultUrl }}" class="btn" target="_blank">Lihat Hasil & Koreksi Lengkap</a>
            </p>

            <p style="margin-top: 30px; font-size: 13px; color: #64748b;">
                Ingin meningkatkan skor Anda bersama tutor profesional? Balas email ini atau hubungi kami melalui WhatsApp untuk konsultasi program belajar.
            </p>
            
            <p style="margin-top: 20px; font-size: 14px;">
                Salam hangat,<br>
                <strong>Tim Akademik Target Bahasa</strong>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Target Bahasa Course. All rights reserved.<br>
            Email ini dikirim otomatis setelah proses evaluasi AI selesai.
        </div>
    </div>
</body>
</html>
