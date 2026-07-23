<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0; }
        body {
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', sans-serif;
            color: {{ $certificate->text_color }};
        }
        .page {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .background {
            position: absolute;
            inset: 0;
            @if($certificate->background_image)
                background-image: url('{{ storage_path('app/public/' . $certificate->background_image) }}');
                background-size: cover;
                background-position: center;
            @else
                background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            @endif
        }
        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.73);
            backdrop-filter: blur(3px);
        }
        .border-frame {
            position: absolute;
            inset: 30px;
            border: 10px solid rgba(15, 23, 42, 0.09);
            pointer-events: none;
        }
        .badge {
            position: absolute;
            top: 40px;
            left: 40px;
            padding: 12px 18px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.08);
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 700;
        }
        .content {
            position: relative;
            z-index: 2;
            width: calc(100% - 160px);
            margin: 0 auto;
            padding: 80px 70px;
            text-align: center;
            min-height: calc(100% - 160px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .title {
            margin: 0;
            font-size: 60px;
            letter-spacing: 8px;
            font-weight: 800;
            line-height: 1;
            text-transform: uppercase;
        }
        .label {
            margin-top: 10px;
            font-size: 18px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(15, 23, 42, 0.7);
        }
        .presented {
            margin-top: 50px;
            font-size: 18px;
            color: rgba(15, 23, 42, 0.8);
        }
        .name {
            margin: 24px auto 0;
            font-size: 42px;
            font-weight: 700;
            letter-spacing: 0.6px;
            max-width: 860px;
            color: rgba(15, 23, 42, 0.95);
        }
        .achievement {
            margin-top: 24px;
            font-size: 22px;
            line-height: 1.75;
            max-width: 760px;
            margin-left: auto;
            margin-right: auto;
        }
        .achievement strong {
            font-size: 28px;
            letter-spacing: 1px;
        }
        .details {
            margin-top: 24px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 28px;
            border: 2px solid {{ $certificate->text_color }};
            border-radius: 999px;
            font-size: 18px;
            font-weight: 700;
            color: {{ $certificate->text_color }};
            background: rgba(255, 255, 255, 0.8);
        }
        .description {
            margin-top: 20px;
            font-size: 16px;
            color: rgba(15, 23, 42, 0.7);
            font-style: italic;
            max-width: 760px;
            margin-left: auto;
            margin-right: auto;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-top: 50px;
            flex-wrap: wrap;
        }
        .footer-item {
            width: calc(50% - 10px);
            min-width: 240px;
            text-align: left;
        }
        .footer-title {
            margin: 0 0 12px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(15, 23, 42, 0.6);
        }
        .footer-line {
            display: block;
            width: 230px;
            height: 1px;
            background: rgba(15, 23, 42, 0.15);
            margin-bottom: 12px;
        }
        .footer-value {
            font-size: 16px;
            font-weight: 700;
            color: rgba(15, 23, 42, 0.9);
        }
        .footer-note {
            margin-top: 6px;
            font-size: 12px;
            color: rgba(15, 23, 42, 0.6);
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="background"></div>
        <div class="overlay"></div>
        <div class="border-frame"></div>
        <div class="badge">Certificate of Achievement</div>

        <div class="content">
            <div>
                <h1 class="title">Certificate</h1>
                <div class="label">Final Test Completion</div>
            </div>

            <div>
                <div class="presented">Presented to</div>
                <div class="name">{{ $user->name }}</div>

                <div class="achievement">
                    has successfully completed the <strong>{{ $testName }}</strong> Final Test with a score of
                </div>

                <div class="details">{{ is_numeric($result->score) ? number_format((float) $result->score, 1) : $result->score }}</div>

                @if($certificate->description)
                    <div class="description">"{{ $certificate->description }}"</div>
                @endif
            </div>

            <div class="footer">
                <div class="footer-item">
                    <span class="footer-title">Date Completed</span>
                    <span class="footer-line"></span>
                    <div class="footer-value">{{ $date }}</div>
                    <div class="footer-note">Final test completion date</div>
                </div>

                <div class="footer-item">
                    <span class="footer-title">Authorized Signature</span>
                    <span class="footer-line"></span>
                    <div class="footer-value">Target Bahasa Team</div>
                    <div class="footer-note">Official certificate issuer</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
