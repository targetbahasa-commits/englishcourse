<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Final Test Certificate</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <p>Hi {{ $result->name ?? 'Student' }},</p>

    <p>Congratulations, you have completed the <strong>{{ $result->test_label ?? 'Final Test' }}</strong>.</p>

    <p>
        Your score is <strong>{{ is_numeric($result->score) ? number_format((float) $result->score, 1) : ($result->score ?? '-') }}</strong>.
        Your certificate is attached to this email as a PDF.
    </p>

    <p>Best regards,<br>Target Bahasa Team</p>
</body>
</html>
