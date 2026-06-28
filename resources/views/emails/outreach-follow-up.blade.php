<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Tes & Rekomendasi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background-color: #4F46E5; color: #fff; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .score-box { background-color: #EEF2FF; border: 1px solid #C7D2FE; border-radius: 8px; padding: 15px; text-align: center; margin-bottom: 20px; }
        .score-box h2 { margin: 0; color: #4338CA; font-size: 36px; }
        .recommendation { background-color: #F8FAFC; border-left: 4px solid #10B981; padding: 15px; margin-top: 20px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #4F46E5; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
        .footer { background-color: #f1f5f9; padding: 15px; text-align: center; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Target Bahasa Course</h1>
        </div>
        <div class="content">
            <p>Halo {{ $testResult->user->name ?? 'Student' }},</p>
            
            <p>Terima kasih telah mengikuti evaluasi gratis kami. Berikut adalah hasil tes <strong>{{ strtoupper(str_replace('_', ' ', $testResult->test_type)) }}</strong> Anda:</p>
            
            <div class="score-box">
                <p style="margin:0; font-size:14px; color:#6b7280; text-transform:uppercase;">Skor Anda</p>
                <h2>{{ $testResult->score + 0 }}</h2>
            </div>

            <div class="recommendation">
                <h3 style="margin-top:0; color:#0f766e;">Rekomendasi Tutor</h3>
                <p>{{ nl2br(e($outreachMessage->message_content)) }}</p>
                
                @if($recommendedProgram)
                    <p style="margin-top: 15px;">
                        <strong>Program spesifik yang cocok untuk Anda:</strong><br>
                        {{ $recommendedProgram->name }}
                    </p>
                    <div style="text-align: center;">
                        <a href="{{ config('app.url') }}/assignments" class="btn">Lihat Detail Program</a>
                    </div>
                @endif
            </div>
            
            <p style="margin-top: 30px;">
                Jika Anda memiliki pertanyaan tentang program belajar kami, jangan ragu untuk membalas email ini. Tim akademik kami siap membantu Anda menyusun rencana belajar yang tepat.
            </p>
            
            <p>Salam hangat,<br>
            <strong>Tim Akademik Target Bahasa</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Target Bahasa Course. All rights reserved.<br>
            Email ini dibuat secara otomatis, namun Anda dapat membalasnya jika membutuhkan bantuan.
        </div>
    </div>
</body>
</html>
