<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $payment->invoice_number }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 14px;
        }
        .header {
            width: 100%;
            margin-bottom: 30px;
        }
        .header td {
            vertical-align: top;
        }
        .logo {
            max-width: 150px;
        }
        .company-info {
            text-align: right;
            color: #666;
            font-size: 12px;
        }
        h1 {
            color: #1e3a8a;
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        .invoice-details {
            width: 100%;
            margin-bottom: 40px;
            border-collapse: collapse;
        }
        .invoice-details th {
            text-align: left;
            padding: 5px 0;
            color: #666;
            font-weight: normal;
        }
        .invoice-details td {
            padding: 5px 0;
            font-weight: bold;
        }
        .status-badge {
            background-color: #d1fae5;
            color: #065f46;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            text-transform: uppercase;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items th {
            background-color: #f3f4f6;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
        }
        table.items td {
            padding: 15px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .total-row td {
            font-weight: bold;
            font-size: 16px;
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td width="50%">
                @php
                    $logoPath = public_path('images/company/logo.png');
                    $logoSrc = '';
                    if(file_exists($logoPath)) {
                        $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                        $data = file_get_contents($logoPath);
                        $logoSrc = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    }
                @endphp
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" class="logo" alt="Target Bahasa">
                @else
                    <h2 style="color: #1e3a8a; margin: 0;">Target Bahasa</h2>
                @endif
            </td>
            <td class="company-info" width="50%">
                <strong>Target Bahasa</strong><br>
                info@targetbahasa.com<br>
                +62 812-3456-7890<br>
                Indonesia
            </td>
        </tr>
    </table>

    <table class="header">
        <tr>
            <td width="50%">
                <h1>INVOICE</h1>
                <table class="invoice-details">
                    <tr>
                        <th width="40%">Invoice No:</th>
                        <td>{{ $payment->invoice_number }}</td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="status-badge">{{ strtoupper($payment->status) }}</span></td>
                    </tr>
                </table>
            </td>
            <td width="50%" style="text-align: right;">
                <h3 style="margin-top: 0; color: #666;">Billed To:</h3>
                <strong>{{ $user->name }}</strong><br>
                {{ $user->email }}<br>
                {{ $user->phone_number ? '+' . $user->phone_number : '' }}
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $payment->program->name ?? 'Course Registration' }}</strong><br>
                    <span style="color: #666; font-size: 12px;">
                        {{ $payment->enrollment && $payment->enrollment->classPeriod ? 'Batch: ' . $payment->enrollment->classPeriod->name : '' }}
                    </span>
                </td>
                <td style="text-align: right;">
                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="total-row">
                <td style="text-align: right;">Total</td>
                <td style="text-align: right;">Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <h4 style="margin-bottom: 5px;">Payment Details:</h4>
        <p style="margin-top: 0; color: #666;">
            Payment Method: Manual Transfer<br>
            Paid On: {{ $payment->paid_at ? $payment->paid_at->format('M d, Y H:i') : '-' }}<br>
            <em>Thank you for learning with Target Bahasa.</em>
        </p>
    </div>

    <div class="footer">
        This is a computer-generated document. No signature is required.
    </div>

</body>
</html>
