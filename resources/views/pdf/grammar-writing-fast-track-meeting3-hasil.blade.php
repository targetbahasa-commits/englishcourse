<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Penilaian - Fast Track Meeting 3</title>
    <style>
        @page {
            margin: 22px 26px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
            font-size: 10.5px;
            line-height: 1.45;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
            margin-bottom: 14px;
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
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            background-color: #e0e7ff;
            color: #3730a3;
        }
        .meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 12px;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 2px 6px;
            vertical-align: top;
        }
        .meta-label {
            font-size: 9px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            width: 110px;
        }
        .meta-value {
            font-size: 10.5px;
            color: #0f172a;
            font-weight: 600;
        }
        .score-banner {
            background-color: #4f46e5;
            color: #ffffff;
            border-radius: 8px;
            padding: 10px 16px;
            text-align: center;
            margin-bottom: 14px;
        }
        .score-banner .score {
            font-size: 20px;
            font-weight: 800;
        }
        .score-banner .caption {
            font-size: 9.5px;
            color: #e0e7ff;
        }
        h2.section-title {
            font-size: 12px;
            font-weight: 800;
            color: #1e293b;
            margin: 14px 0 8px 0;
        }
        .q-block {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 10px;
            margin-bottom: 8px;
        }
        .q-number {
            display: inline-block;
            width: 16px;
            height: 16px;
            background: #e0e7ff;
            color: #3730a3;
            border-radius: 3px;
            text-align: center;
            font-size: 8.5px;
            font-weight: 800;
            line-height: 16px;
            margin-right: 5px;
        }
        .q-text {
            font-size: 9.5px;
            color: #334155;
            margin-bottom: 5px;
        }
        .q-answer-row {
            font-size: 9px;
            color: #475569;
            margin-bottom: 3px;
        }
        .q-answer-row strong {
            color: #1e293b;
        }
        .result-ok {
            font-size: 9px;
            font-weight: 700;
            color: #15803d;
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 4px;
            padding: 4px 7px;
        }
        .result-wrong {
            font-size: 9px;
            color: #b91c1c;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 4px;
            padding: 4px 7px;
        }
        .result-skip {
            font-size: 9px;
            font-weight: 600;
            color: #64748b;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 4px 7px;
        }
        .word-correct { color: #15803d; font-weight: bold; }
        .word-extra { color: #2563eb; font-weight: bold; text-decoration: line-through; }
        .word-missing { color: #b45309; font-weight: bold; }
        .word-wrong { color: #b91c1c; font-weight: bold; text-decoration: underline; }
        .paragraph-box {
            border: 1px solid #dcfce7;
            border-radius: 6px;
            padding: 10px 12px;
        }
        .paragraph-source {
            font-size: 9.5px;
            color: #334155;
            margin-bottom: 8px;
        }
        .diff-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 8px 10px;
            font-size: 9px;
            margin-top: 6px;
        }
        .full-answer {
            margin-top: 8px;
            font-size: 9px;
            color: #475569;
            font-style: italic;
        }
        .footer {
            margin-top: 14px;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
            font-size: 8px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                <div class="brand-title">TARGET BAHASA</div>
                <div class="brand-subtitle">Lembar Hasil Penilaian Latihan</div>
            </td>
            <td style="text-align: right; vertical-align: middle;">
                <span class="badge">Fast-Track Grammar for Writing &bull; Meeting 3</span>
            </td>
        </tr>
    </table>

    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td class="meta-label">Nama Siswa:</td>
                <td class="meta-value">{{ $studentName }}</td>
                <td class="meta-label">Tanggal Unduh:</td>
                <td class="meta-value">{{ now()->translatedFormat('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="meta-label">Email:</td>
                <td class="meta-value" colspan="3">{{ $studentEmail }}</td>
            </tr>
        </table>
    </div>

    <div class="score-banner">
        <div class="score">{{ $finalScore }} / 100</div>
        <div class="caption">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }} &bull; Soal yang belum dikerjakan tidak ikut dinilai.</div>
    </div>

    <h2 class="section-title">A. Translate Kalimat</h2>
    @foreach($questions as $qNum => $data)
        @php $result = $results[$qNum] ?? []; @endphp
        <div class="q-block">
            <div class="q-text"><span class="q-number">{{ $qNum }}</span>{{ $data['id'] }}</div>
            <div class="q-answer-row"><strong>Jawaban Anda:</strong> {{ $userAnswers[$qNum]['trans'] ?? '(kosong)' }}</div>

            @if(($result['answered'] ?? true) === false)
                <div class="result-skip">Belum dikerjakan - tidak dinilai.</div>
            @elseif(($result['trans_score'] ?? 0) == 10)
                <div class="result-ok">Terjemahan Sempurna! (10/10)</div>
            @else
                <div class="result-wrong">
                    <strong>Nilai Terjemahan: {{ $result['trans_score'] ?? 0 }}/10</strong><br>
                    Koreksi: {!! $result['formatted_answer'] ?? '' !!}<br>
                    Jawaban Benar: {{ $data['en'] }}
                </div>
            @endif
        </div>
    @endforeach

    <h2 class="section-title">B. Latihan Paragraf</h2>
    <div class="paragraph-box">
        <div class="paragraph-source">{{ $fullParagraphId }}</div>
        <div class="q-answer-row"><strong>Jawaban Anda:</strong> {{ $userParagraphAnswer ?: '(kosong)' }}</div>

        @if(($paragraphResult['answered'] ?? true) === false)
            <div class="result-skip">Belum dikerjakan - tidak dinilai.</div>
        @else
            @if(($paragraphResult['score'] ?? 0) >= ($paragraphResult['max_score'] ?? 20) * 0.8)
                <div class="result-ok">Luar Biasa! Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}</div>
            @else
                <div class="result-wrong">Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}</div>
            @endif

            <div class="diff-box">
                <strong>Analisis Perbedaan:</strong><br>
                {!! $paragraphResult['formatted_answer'] ?? '' !!}
            </div>

            <div class="full-answer">
                <strong>Jawaban Lengkap:</strong> {{ $fullParagraphEn }}
            </div>
        @endif
    </div>

    <div class="footer">
        Dokumen ini diterbitkan secara otomatis oleh Target Bahasa Course Platform &bull; www.targetbahasa.com
    </div>

</body>
</html>
