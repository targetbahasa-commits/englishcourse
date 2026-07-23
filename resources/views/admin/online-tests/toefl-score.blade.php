<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit TOEFL ITP Score - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .certificate-preview {
            --toefl-purple: #4b2671;
            --toefl-line: #d7dde7;
            --toefl-muted: #697489;
            width: 100%;
            max-width: 980px;
            margin: 32px auto 0;
            padding: 54px 72px 52px;
            overflow: hidden;
            border: 1px solid #d7dde7;
            border-radius: 12px;
            background:
                repeating-radial-gradient(ellipse at 92% -4%, rgba(75, 38, 113, 0.08) 0 1px, transparent 1px 9px),
                #fffdfa;
            color: #101a2f;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
            position: relative;
        }

        @media (max-width: 820px) {
            .certificate-preview {
                padding: 32px 24px;
            }
        }

        @media print {
            nav,
            .sidebar-admin,
            .no-print,
            .screen-only {
                display: none !important;
            }

            body {
                background: #ffffff !important;
            }

            main {
                margin: 0 !important;
                padding: 0 !important;
            }

            .print-page {
                box-shadow: none !important;
                border: 0 !important;
                padding: 0 !important;
            }

            .certificate-preview {
                box-shadow: none !important;
                margin: 0 !important;
                max-width: 100% !important;
                padding: 20px !important;
                background: #ffffff !important;
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-100">
@include('components.impersonation-banner')
@if(!Auth::user()->isAdmin())
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">TB</div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-700 to-cyan-700 bg-clip-text text-transparent">Target Bahasa</span>
                </div>
            </div>
        </div>
    </nav>
@endif

@php
    $scoreTables = json_decode($scoreTablesJson, true) ?: [];
    $sections = [
        'listening' => 'Listening',
        'structure' => 'Structure & Written Expression',
        'reading' => 'Reading Comprehension',
    ];

    $previewRows = [];
    foreach ($sections as $sectionKey => $sectionLabel) {
        $table = is_array($scoreTables[$sectionKey] ?? null) ? $scoreTables[$sectionKey] : [];
        $rawScores = array_keys($table);
        $rawScores = array_values(array_filter($rawScores, static fn ($value) => is_numeric($value)));
        rsort($rawScores, SORT_NUMERIC);

        $topRaw = $rawScores[0] ?? null;
        $topScaled = ($topRaw !== null && isset($table[$topRaw])) ? $table[$topRaw] : null;

        $previewRows[$sectionKey] = [
            'label' => $sectionLabel,
            'rows' => count($table),
            'topRaw' => $topRaw,
            'topScaled' => $topScaled,
            'bottomRaw' => !empty($rawScores) ? min($rawScores) : null,
            'bottomScaled' => !empty($rawScores) ? ($table[min($rawScores)] ?? null) : null,
        ];
    }

    $updatedAt = now()->format('d M Y, H:i');
@endphp

<div class="flex min-h-screen {{ !Auth::user()->isAdmin() ? 'max-w-7xl mx-auto w-full' : '' }}">
    @if(Auth::user()->isAdmin())
        @include('components.sidebar-admin')
    @endif

    <main class="flex-1 {{ Auth::user()->isAdmin() ? 'md:ml-64' : 'w-full' }} p-4 md:p-8">
        <div class="max-w-5xl mx-auto space-y-6">
            <div class="screen-only flex items-center gap-3">
                <a href="{{ route('admin.online-tests.index') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-gray-600 hover:text-blue-600 hover:border-blue-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Kelola Online Test
                </a>
            </div>

            <div class="print-page rounded-2xl bg-white border border-slate-200 shadow-sm p-6 md:p-8">
                <div class="screen-only">
                    <p class="text-xs font-semibold uppercase tracking-wider text-cyan-600">TOEFL ITP Paket 1</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">Edit Tabel Konversi TOEFL ITP</h1>
                    <p class="mt-2 text-slate-600">Kelola konversi raw score ke scaled score untuk Listening Comprehension, Structure & Written Expression, dan Reading Comprehension.</p>
                </div>

                @if(session('success'))
                    <div class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 screen-only">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 screen-only">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="certificate-preview relative">
                    <!-- Background watermark -->
                    <div class="absolute bottom-12 left-16 opacity-5 select-none font-bold italic" style="color: var(--toefl-purple); font-size: 380px; line-height: 1; z-index: 0; font-family: serif; letter-spacing: -20px;">T</div>
                    
                    <!-- Logo - Positioned to the left -->
                    <div class="absolute top-8 left-8 md:top-14 md:left-14 z-20">
                        <img src="{{ asset('images/brand/target-bahasa-logo.png') }}" alt="Target Bahasa" style="height: 170px; width: auto; object-fit: contain;">
                    </div>
                    
                    <div class="relative z-10 text-center flex flex-col items-center px-4 md:px-12 pt-8 md:pt-12 w-full">
                        <h2 class="font-bold text-gray-900 tracking-widest uppercase mb-6" style="font-size: 42px; line-height: 1.2; font-family: Georgia, 'Times New Roman', serif;">Certificate of Achievement</h2>
                        
                        <p class="italic text-gray-700 mb-6" style="font-size: 22px; font-family: Georgia, 'Times New Roman', serif;">This is to certify that</p>
                        
                        <h1 class="font-bold text-gray-900 uppercase tracking-wide leading-none text-center mb-6" style="font-size: 48px; font-family: Georgia, 'Times New Roman', serif;">John Doe (Preview)</h1>
                        
                        <p class="italic text-gray-700 mb-6" style="font-size: 22px; font-family: Georgia, 'Times New Roman', serif;">achieved the following scores on the</p>
                        
                        <h3 class="font-bold text-gray-900 tracking-wide mb-2" style="font-size: 32px; font-family: Georgia, 'Times New Roman', serif;">TOEFL ITP<span style="font-size: 16px; vertical-align: top;">®</span> Prediction Test</h3>

                        <div class="mt-4 mb-14 text-left w-full max-w-[540px] mx-auto bg-white/70 p-6 md:px-10 md:py-8 rounded-2xl border border-white shadow-sm backdrop-blur-md">
                            <table class="w-full text-[16px] md:text-[18px] text-gray-700 font-medium">
                                <tbody>
                                    <tr class="border-b border-gray-200/70">
                                        <td class="pr-6 py-3.5">Listening Comprehension:</td>
                                        <td class="text-right py-3.5 font-bold text-xl text-gray-900">-</td>
                                    </tr>
                                    <tr class="border-b border-gray-200/70">
                                        <td class="pr-6 py-3.5">Structure & Written Expression:</td>
                                        <td class="text-right py-3.5 font-bold text-xl text-gray-900">-</td>
                                    </tr>
                                    <tr class="border-b border-gray-200/70">
                                        <td class="pr-6 py-3.5">Reading Comprehension:</td>
                                        <td class="text-right py-3.5 font-bold text-xl text-gray-900">-</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-6 py-3.5 pt-5 font-bold text-[18px] md:text-[20px]" style="color: var(--toefl-purple);">Total:</td>
                                        <td class="text-right py-3.5 pt-5 font-black text-[24px] md:text-[28px]" style="color: var(--toefl-purple);">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="relative z-10 mt-auto flex flex-col md:flex-row justify-between items-start md:items-end pb-2 pt-6 border-t" style="border-color: var(--toefl-line);">
                        <div class="text-[13px] leading-[1.6] text-gray-500">
                            <p>Under the auspices of:</p>
                            <p class="font-bold uppercase tracking-wide text-gray-800">TARGET BAHASA</p>
                            <p class="font-bold text-gray-800">Date: {{ now()->format('d M Y') }}</p>
                        </div>
                        <div class="text-[20px] md:text-[24px] italic text-gray-500 font-serif pb-1 border-b border-gray-300 w-full md:w-auto text-center md:text-right px-4 mt-6 md:mt-0">
                            The TOEFL<span class="text-xs align-top">®</span> Program
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-5">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">TOEFL ITP Score Tables JSON</h2>
                                <p class="text-sm text-slate-500">Edit langsung tabel konversi raw score ke scaled score.</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.online-tests.toefl-score.update') }}" class="space-y-4">
                            @csrf
                            <textarea name="score_tables_json" rows="24" class="w-full rounded-xl border-slate-300 text-sm font-mono focus:border-cyan-500 focus:ring-cyan-500">{{ old('score_tables_json', $scoreTablesJson) }}</textarea>
                            <p class="text-xs text-slate-500">Format wajib: {"listening":{"50":68},"structure":{"40":68},"reading":{"50":67}}. Boleh juga pakai format x10 (contoh 680), sistem akan otomatis konversi ke 68.</p>
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold transition-colors">
                                    Simpan TOEFL ITP Score
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 shadow-sm p-5">
                        <h2 class="text-lg font-semibold text-slate-900">Quick Preview</h2>
                        <p class="mt-1 text-sm text-slate-500">Ringkasan isi tabel yang sedang aktif.</p>

                        <div class="mt-4 space-y-3">
                            @foreach($previewRows as $row)
                                <div class="rounded-xl border border-slate-200 bg-white p-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">{{ $row['label'] }}</p>
                                            <p class="text-xs text-slate-500">{{ $row['rows'] }} row konversi</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-slate-900">
                                                @if($row['topRaw'] !== null && $row['topScaled'] !== null)
                                                    {{ $row['topRaw'] }} → {{ $row['topScaled'] }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                            <p class="text-xs text-slate-500">Top conversion</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>

</html>
