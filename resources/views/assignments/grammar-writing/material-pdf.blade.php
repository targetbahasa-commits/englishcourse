<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Modul {{ $trackTitle }} - Meeting {{ $meetingNumber }}</title>
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.45;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h1 {
            font-size: 16pt;
            color: #1e40af;
            margin: 0 0 2px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header h2 {
            font-size: 12pt;
            color: #374151;
            margin: 0;
            font-weight: 600;
        }
        .header p {
            font-size: 8.5pt;
            color: #6b7280;
            margin: 2px 0 0 0;
        }
        .meta-box {
            background-color: #f8fafc;
            border-left: 4px solid #2563eb;
            padding: 8px 12px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .meta-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-box td {
            font-size: 9.5pt;
            padding: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 12px;
            font-size: 9pt;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: bold;
            font-size: 8.5pt;
            text-transform: uppercase;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .bg-white\/80, .bg-white {
            background-color: #eff6ff !important;
            border: 1px solid #bfdbfe !important;
            padding: 10px !important;
            border-radius: 6px !important;
            margin-bottom: 12px !important;
        }
        .bg-white\/90, .bg-white {
            background-color: #fffbeb !important;
            border: 1px solid #fde68a !important;
            padding: 10px !important;
            border-radius: 6px !important;
            margin-bottom: 12px !important;
        }
        .bg-white\/90, .bg-white {
            background-color: #eef2ff !important;
            border: 1px solid #c7d2fe !important;
            padding: 10px !important;
            border-radius: 6px !important;
            margin-bottom: 12px !important;
        }
        .bg-white\/70, .bg-white {
            background-color: #faf5ff !important;
            border: 1px solid #e9d5ff !important;
            padding: 10px !important;
            border-radius: 6px !important;
            margin-bottom: 12px !important;
        }
        h5 {
            font-size: 10.5pt;
            color: #0f172a;
            margin-top: 12px;
            margin-bottom: 6px;
        }
        ul, ol {
            margin-top: 4px;
            margin-bottom: 6px;
            padding-left: 18px;
        }
        li {
            margin-bottom: 2px;
        }
        .font-mono {
            font-family: 'Courier New', Courier, monospace;
        }
        .footer {
            margin-top: 25px;
            padding-top: 8px;
            font-size: 8pt;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Target Bahasa Course</h1>
        <h2>{{ $trackTitle }} &mdash; Meeting {{ $meetingNumber }}</h2>
        <p>Modul Penjelasan Materi & Panduan Tata Bahasa Sesuai Modul Resmi</p>
    </div>

    <div class="meta-box">
        <table>
            <tr>
                <td width="60%"><strong>Topik Pembahasan:</strong> {{ $meetingTitle }}</td>
                <td width="40%" align="right"><strong>Pertemuan:</strong> Meeting {{ $meetingNumber }}</td>
            </tr>
        </table>
    </div>

    <div class="content">
        {!! $cheatSheetHtml !!}
    </div>

    <div class="footer">
        Hak Cipta &copy; Target Bahasa Course &mdash; Modul Basic Writing. Seluruh Hak Cipta Dilindungi Undang-Undang.
    </div>
</body>
</html>
