<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Target Bahasa - Certificate of Achievement</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <p>Dear {{ $result->name }},</p>
        
        <p>Congratulations! You have completed the <strong>{{ str($result->test_type)->title() }}</strong> offline test with Target Bahasa.</p>
        
        <p>We are pleased to present you with your Certificate of Achievement. Please find the certificate attached to this email as a PDF document.</p>
        
        <p><strong>Test Type:</strong> {{ str($result->test_type)->title() }}<br>
        <strong>Score:</strong> {{ $result->score }}</p>
        
        <p>If you have any questions or need further assistance, please do not hesitate to contact us.</p>
        
        <p>Best regards,<br>
        The Target Bahasa Team</p>
    </div>
</body>
</html>
