<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digital SAT Estimasi Skor Latihan - {{ $user->name ?? 'Candidate' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 18mm 16mm 18mm 16mm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            font-size: 11px;
            line-height: 1.4;
        }

        /* Header Table */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .brand-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            text-transform: uppercase;
        }

        .brand-subtitle {
            font-size: 9px;
            color: #64748b;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .badge-official {
            display: inline-block;
            background-color: #0284c7;
            color: #ffffff;
            font-size: 8.5px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 4px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-align: right;
        }

        .doc-title {
            font-size: 10px;
            font-weight: 700;
            color: #475569;
            margin-top: 3px;
            text-align: right;
        }

        .divider-blue {
            height: 3px;
            background-color: #0284c7;
            width: 100%;
            margin-bottom: 12px;
        }

        /* Student Metadata Card */
        .meta-card {
            width: 100%;
            border-collapse: collapse;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 14px;
        }

        .meta-card td {
            padding: 7px 12px;
            vertical-align: top;
            font-size: 10px;
        }

        .meta-label {
            color: #64748b;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .meta-value {
            color: #0f172a;
            font-weight: 700;
            font-size: 11px;
        }

        /* Total Score Big Banner */
        .score-banner {
            width: 100%;
            border-collapse: collapse;
            background-color: #0284c7;
            color: #ffffff;
            border-radius: 6px;
            margin-bottom: 14px;
        }

        .score-banner td {
            padding: 14px 16px;
            vertical-align: middle;
        }

        .banner-left-title {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: #ffffff;
        }

        .banner-left-sub {
            font-size: 9.5px;
            color: #e0f2fe;
            margin-top: 3px;
            font-weight: 500;
        }

        .total-box {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 6px;
            padding: 8px 18px;
            display: inline-block;
            min-width: 140px;
        }

        .total-num {
            font-size: 38px;
            font-weight: 900;
            line-height: 1;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .total-scale {
            font-size: 8.5px;
            color: #e0f2fe;
            font-weight: 600;
            margin-top: 3px;
            letter-spacing: 0.03em;
        }

        /* Section Breakdown */
        .section-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin-bottom: 14px;
        }

        .section-col {
            width: 50%;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 12px;
            vertical-align: top;
            background-color: #ffffff;
        }

        .sec-tag {
            font-size: 8px;
            font-weight: 800;
            color: #0284c7;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .sec-title {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            margin-top: 2px;
            margin-bottom: 6px;
        }

        .sec-score-row {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .sec-score-num {
            font-size: 24px;
            font-weight: 900;
            color: #0f172a;
            line-height: 1;
            text-align: right;
        }

        .sec-score-scale {
            font-size: 8px;
            color: #64748b;
            font-weight: 600;
            text-align: right;
            margin-top: 2px;
        }

        /* Progress Bar in PDF */
        .bar-outer {
            width: 100%;
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
            margin: 6px 0 3px 0;
        }

        .bar-inner {
            height: 6px;
            background-color: #0284c7;
            border-radius: 3px;
        }

        .scale-ticks {
            width: 100%;
            font-size: 7.5px;
            color: #94a3b8;
            font-family: monospace;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .detail-row {
            width: 100%;
            border-collapse: collapse;
            border-top: 1px solid #f1f5f9;
            padding-top: 6px;
            font-size: 9px;
        }

        .detail-row td {
            padding: 2.5px 0;
        }

        /* Domains Table */
        .domain-section-title {
            font-size: 11px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .domain-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            margin-bottom: 14px;
            font-size: 9px;
        }

        .domain-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 6px 8px;
            text-align: left;
            border-bottom: 1px solid #cbd5e1;
        }

        .domain-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .band-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 800;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .band-advanced {
            background-color: #e0f2fe;
            color: #0284c7;
            border: 1px solid #bae6fd;
        }

        .band-proficient {
            background-color: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .band-developing {
            background-color: #fefce8;
            color: #ca8a04;
            border: 1px solid #fef08a;
        }

        /* Footer & Signature Table */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
            border-top: 1px solid #cbd5e1;
            padding-top: 10px;
        }

        .footer-table td {
            vertical-align: bottom;
        }

        .sig-container {
            width: 180px;
            text-align: center;
        }

        .sig-line {
            border-bottom: 1.5px solid #475569;
            margin-bottom: 3px;
        }

        .sig-name {
            font-size: 10px;
            font-weight: 800;
            color: #0f172a;
        }

        .sig-title {
            font-size: 8px;
            color: #64748b;
            font-weight: 600;
        }

        .legal-note {
            font-size: 7.5px;
            color: #94a3b8;
            line-height: 1.35;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td style="width: 55px;">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo" style="height: 44px; width: auto; object-fit: contain;">
                @else
                    <div style="width: 44px; height: 44px; background-color: #0284c7; color: #fff; font-weight: 900; font-size: 18px; line-height: 44px; text-align: center; border-radius: 8px;">TB</div>
                @endif
            </td>
            <td style="padding-left: 10px;">
                <div class="brand-title">TARGET BAHASA COURSE</div>
                <div class="brand-subtitle">Digital SAT Standardized Assessment Program</div>
            </td>
            <td style="text-align: right;">
                <div class="badge-official">Estimasi Skor Latihan</div>
                <div class="doc-title">Digital SAT Practice Test &mdash; Bukan Skor Resmi College Board</div>
            </td>
        </tr>
    </table>

    <div class="divider-blue"></div>

    <!-- Student Metadata -->
    <table class="meta-card">
        <tr>
            <td style="width: 32%;">
                <div class="meta-label">Test Taker Name</div>
                <div class="meta-value">{{ strtoupper($user->name ?? 'Admin User') }}</div>
            </td>
            <td style="width: 25%;">
                <div class="meta-label">Registration / Report ID</div>
                <div class="meta-value" style="font-family: monospace;">{{ $registrationId ?? 'TB-SAT-2026-0001' }}</div>
            </td>
            <td style="width: 23%;">
                <div class="meta-label">Test Completed Date</div>
                <div class="meta-value">{{ $testDate ?? now()->translatedFormat('d F Y, H:i') }}</div>
            </td>
            <td style="width: 20%;">
                <div class="meta-label">Assessment Format</div>
                <div class="meta-value">Multistage Adaptive</div>
            </td>
        </tr>
    </table>

    <!-- Total Score Executive Banner -->
    <table class="score-banner">
        <tr>
            <td>
                <div class="banner-left-title">Your Total Score</div>
                <div class="banner-left-sub">
                    Cumulative performance across Reading, Writing, and Mathematics sections.
                </div>

                @php
                    $totalPct = max(2, min(100, (($totalSatScore - 400) / (1600 - 400)) * 100));
                @endphp
                <div style="margin-top: 10px; width: 85%;">
                    <div style="background-color: rgba(0,0,0,0.25); height: 6px; border-radius: 3px; overflow: hidden; padding: 1px;">
                        <div style="background-color: #fde047; height: 6px; width: {{ $totalPct }}%; border-radius: 3px;"></div>
                    </div>
                    <table style="width: 100%; font-size: 7.5px; color: #e0f2fe; margin-top: 2px;">
                        <tr>
                            <td style="text-align: left;">400</td>
                            <td style="text-align: center; font-weight: 700; color: #fde047;">Current Score: {{ $totalSatScore }}</td>
                            <td style="text-align: right;">1600</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="width: 180px; text-align: right;">
                <div class="total-box">
                    <div style="font-size: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #e0f2fe; margin-bottom: 2px;">Total SAT Score</div>
                    <div class="total-num">{{ $totalSatScore }}</div>
                    <div class="total-scale">Scale: 400 &ndash; 1600</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Section Scores Side-by-Side -->
    <table class="section-table">
        <tr>
            <!-- Section 1: Reading and Writing -->
            <td class="section-col">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="vertical-align: top;">
                            <div class="sec-tag">Section 1</div>
                            <div class="sec-title">Reading and Writing</div>
                        </td>
                        <td style="vertical-align: top; text-align: right;">
                            <div class="sec-score-num">{{ $rwScaledScore }}</div>
                            <div class="sec-score-scale">200 &ndash; 800</div>
                        </td>
                    </tr>
                </table>

                @php
                    $rwPct = max(2, min(100, (($rwScaledScore - 200) / (800 - 200)) * 100));
                @endphp
                <div class="bar-outer">
                    <div class="bar-inner" style="width: {{ $rwPct }}%;"></div>
                </div>
                <table class="scale-ticks">
                    <tr>
                        <td style="text-align: left;">200</td>
                        <td style="text-align: center;">500</td>
                        <td style="text-align: right;">800</td>
                    </tr>
                </table>

                <table class="detail-row">
                    <tr>
                        <td style="color: #64748b;">Module 1 Correct:</td>
                        <td style="text-align: right; font-weight: 700; color: #0f172a;">{{ $rwM1Correct }} / {{ $rwM1Total }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Module 2 Correct:</td>
                        <td style="text-align: right; font-weight: 700; color: #0f172a;">{{ $rwM2Correct }} / {{ $rwM2Total }}</td>
                    </tr>
                    <tr>
                        <td style="color: #0284c7; font-weight: 700;">Section Accuracy:</td>
                        <td style="text-align: right; font-weight: 800; color: #0284c7;">
                            {{ $rwTotalQuestions > 0 ? round(($rwTotalCorrect / $rwTotalQuestions) * 100) : 0 }}% ({{ $rwTotalCorrect }}/{{ $rwTotalQuestions }})
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Section 2: Mathematics -->
            <td class="section-col">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="vertical-align: top;">
                            <div class="sec-tag">Section 2</div>
                            <div class="sec-title">Mathematics</div>
                        </td>
                        <td style="vertical-align: top; text-align: right;">
                            <div class="sec-score-num">{{ $mathScaledScore }}</div>
                            <div class="sec-score-scale">200 &ndash; 800</div>
                        </td>
                    </tr>
                </table>

                @php
                    $mathPct = max(2, min(100, (($mathScaledScore - 200) / (800 - 200)) * 100));
                @endphp
                <div class="bar-outer">
                    <div class="bar-inner" style="width: {{ $mathPct }}%;"></div>
                </div>
                <table class="scale-ticks">
                    <tr>
                        <td style="text-align: left;">200</td>
                        <td style="text-align: center;">500</td>
                        <td style="text-align: right;">800</td>
                    </tr>
                </table>

                <table class="detail-row">
                    <tr>
                        <td style="color: #64748b;">Module 1 Correct:</td>
                        <td style="text-align: right; font-weight: 700; color: #0f172a;">{{ $mathM1Correct }} / {{ $mathM1Total }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b;">Module 2 Correct:</td>
                        <td style="text-align: right; font-weight: 700; color: #0f172a;">{{ $mathM2Correct }} / {{ $mathM2Total }}</td>
                    </tr>
                    <tr>
                        <td style="color: #0284c7; font-weight: 700;">Section Accuracy:</td>
                        <td style="text-align: right; font-weight: 800; color: #0284c7;">
                            {{ $mathTotalQuestions > 0 ? round(($mathTotalCorrect / $mathTotalQuestions) * 100) : 0 }}% ({{ $mathTotalCorrect }}/{{ $mathTotalQuestions }})
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Knowledge and Skills Domains Table -->
    <div class="domain-section-title">Knowledge and Skills Content Domains</div>
    <table class="domain-table">
        <thead>
            <tr>
                <th style="width: 25%;">Section</th>
                <th style="width: 45%;">Academic Domain</th>
                <th style="width: 30%; text-align: right;">Performance Band</th>
            </tr>
        </thead>
        <tbody>
            @php
                $rwBand1 = $rwScaledScore >= 600 ? 'Advanced' : ($rwScaledScore >= 450 ? 'Proficient' : 'Developing');
                $rwBand2 = $rwScaledScore >= 550 ? 'Proficient' : 'Developing';
                $mathBand1 = $mathScaledScore >= 600 ? 'Advanced' : ($mathScaledScore >= 450 ? 'Proficient' : 'Developing');
                $mathBand2 = $mathScaledScore >= 550 ? 'Proficient' : 'Developing';
            @endphp
            <tr>
                <td style="font-weight: 700; color: #0284c7;">Reading and Writing</td>
                <td>Craft and Structure / Information and Ideas</td>
                <td style="text-align: right;">
                    <span class="band-badge band-{{ strtolower($rwBand1) }}">{{ $rwBand1 }}</span>
                </td>
            </tr>
            <tr>
                <td style="font-weight: 700; color: #0284c7;">Reading and Writing</td>
                <td>Standard English Conventions &amp; Expression of Ideas</td>
                <td style="text-align: right;">
                    <span class="band-badge band-{{ strtolower($rwBand2) }}">{{ $rwBand2 }}</span>
                </td>
            </tr>
            <tr>
                <td style="font-weight: 700; color: #0284c7;">Mathematics</td>
                <td>Algebra &amp; Advanced Mathematics</td>
                <td style="text-align: right;">
                    <span class="band-badge band-{{ strtolower($mathBand1) }}">{{ $mathBand1 }}</span>
                </td>
            </tr>
            <tr>
                <td style="font-weight: 700; color: #0284c7;">Mathematics</td>
                <td>Problem-Solving, Data Analysis &amp; Geometry</td>
                <td style="text-align: right;">
                    <span class="band-badge band-{{ strtolower($mathBand2) }}">{{ $mathBand2 }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Footer Verification & Institutional Signature -->
    <table class="footer-table">
        <tr>
            <td style="width: 60%; padding-right: 20px;">
                <div class="legal-note">
                    <strong style="color: #475569;">Catatan Penting:</strong><br>
                    Dokumen ini adalah estimasi skor latihan internal yang dihasilkan oleh Target Bahasa Course berdasarkan performa kandidat pada simulasi Digital SAT ini, menggunakan algoritma multistage adaptive yang terinspirasi dari parameter penilaian publik College Board. Dokumen ini <strong>bukan skor resmi</strong>, tidak diterbitkan oleh College Board, dan tidak dapat digunakan sebagai pengganti skor resmi untuk keperluan pendaftaran universitas.
                </div>
                <div style="font-size: 8px; color: #64748b; margin-top: 6px; font-weight: 600;">
                    Target Bahasa Course &bull; Laporan Estimasi Internal &bull; ID: {{ $registrationId }}
                </div>
            </td>
            <td style="width: 40%; text-align: right;">
                <div class="sig-container" style="float: right;">
                    <div style="height: 52px; position: relative; display: flex; align-items: center; justify-content: center; margin-bottom: 2px;">
                        {{-- Certification-style stamp intentionally removed: this is a self-generated
                             practice estimate, not an official/certified document, so it should not
                             carry a seal that implies institutional authentication. --}}
                        @if(!empty($signatureBase64))
                            <img src="{{ $signatureBase64 }}" alt="Signature" style="position: relative; height: 42px; max-width: 140px; object-fit: contain;">
                        @endif
                    </div>
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $certificate->template_config['signature_name'] ?? 'Target Bahasa Academic Board' }}</div>
                    <div class="sig-title">{{ $certificate->template_config['signature_title'] ?? 'Academic Director & Assessment Coordinator' }}</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
