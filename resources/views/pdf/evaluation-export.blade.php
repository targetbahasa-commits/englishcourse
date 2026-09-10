<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Evaluasi &amp; Coretan Pengajar</title>
    <style>
        @page {
            margin: 20px 25px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .brand-title {
            font-size: 18px;
            font-weight: 800;
            color: #4f46e5;
            letter-spacing: -0.5px;
        }
        .brand-subtitle {
            font-size: 10px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 15px;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 3px 6px;
            vertical-align: top;
        }
        .meta-label {
            font-size: 10px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            width: 120px;
        }
        .meta-value {
            font-size: 12px;
            color: #0f172a;
            font-weight: 600;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            background-color: #e0e7ff;
            color: #3730a3;
        }
        .score-pill {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 800;
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .canvas-container {
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }
        .canvas-img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
        }
        .footer {
            margin-top: 15px;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                <div class="brand-title">TARGET BAHASA</div>
                <div class="brand-subtitle">Lembar Hasil Evaluasi &amp; Catatan Pengajar</div>
            </td>
            <td style="text-align: right; vertical-align: middle;">
                <span class="badge">{{ $trackLabel ?? 'Grammar for Writing' }} &bull; Meeting {{ $meetingScore->meeting_number ?? ($meetingNumber ?? '-') }}</span>
            </td>
        </tr>
    </table>

    <!-- Student & Review Meta -->
    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td class="meta-label">Nama Siswa:</td>
                <td class="meta-value">{{ $meetingScore->user->name ?? ($studentName ?? 'Siswa') }}</td>
                <td class="meta-label">Tanggal Review:</td>
                <td class="meta-value">{{ now()->translatedFormat('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="meta-label">Email:</td>
                <td class="meta-value">{{ $meetingScore->user->email ?? ($studentEmail ?? '-') }}</td>
                <td class="meta-label">Pengajar / Reviewer:</td>
                <td class="meta-value">{{ $meetingScore->reviewer->name ?? 'Tim Pengajar Target Bahasa' }}</td>
            </tr>
            @if(isset($meetingScore) && $meetingScore->teacher_score !== null)
            <tr>
                <td class="meta-label">Nilai Pengajar:</td>
                <td class="meta-value" colspan="3">
                    <span class="score-pill">{{ number_format($meetingScore->teacher_score, 1) }}</span>
                    @if($meetingScore->teacher_feedback)
                        <span style="margin-left: 10px; font-size: 11px; color: #475569;">"{{ $meetingScore->teacher_feedback }}"</span>
                    @endif
                </td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Annotated Work / Drawing Canvas Image -->
    <div class="canvas-container">
        <img src="{{ $image }}" class="canvas-img" alt="Lembar Evaluasi dan Coretan Pengajar">
    </div>

    <!-- Footer -->
    <div class="footer">
        Dokumen ini diterbitkan secara otomatis oleh Target Bahasa Course Platform &bull; www.targetbahasa.com
    </div>

</body>
</html>
