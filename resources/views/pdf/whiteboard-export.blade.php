<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        .meta {
            font-size: 10px;
            color: #6b7280;
            @if($width && $height)
            height: {{ $headerHeightPx }}px;
            box-sizing: border-box;
            @else
            margin-bottom: 8px;
            @endif
            padding: 12px;
            margin: 0;
        }
        img {
            display: block;
            @if($width && $height)
            width: {{ $width }}px;
            height: {{ $height }}px;
            @else
            width: 100%;
            height: auto;
            border: 1px solid #e5e7eb;
            @endif
        }
    </style>
</head>
<body>
    {{-- No whitespace between these two tags - even whitespace-only text
         between them lays out as its own phantom inline line in dompdf,
         which was just enough extra height to push the image entirely
         onto a near-empty page 2. --}}
    <div class="meta">Catatan Whiteboard &bull; {{ now()->format('d F Y, H:i') }} WIB</div><img src="{{ $image }}" alt="Catatan Whiteboard">
</body>
</html>
