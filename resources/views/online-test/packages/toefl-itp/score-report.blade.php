<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TOEFL ITP Score Report - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
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
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-fuchsia-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">TB</div>
                    <span class="text-xl font-bold bg-gradient-to-r from-purple-700 to-fuchsia-700 bg-clip-text text-transparent">Target Bahasa</span>
                </div>
            </div>
        </div>
    </nav>
@endif

<div class="flex min-h-screen {{ !Auth::user()->isAdmin() ? 'max-w-7xl mx-auto w-full' : '' }}">
    @if(Auth::user()->isAdmin())
        @include('components.sidebar-admin')
    @endif

    <main class="flex-1 {{ Auth::user()->isAdmin() ? 'md:ml-64' : 'w-full' }} p-4 md:p-8">
        <div class="max-w-5xl mx-auto space-y-6">
            <div class="print-page rounded-2xl bg-white border border-slate-200 shadow-sm p-6 md:p-8">
                <div class="screen-only">
                    <p class="text-xs font-semibold uppercase tracking-wider text-purple-600">TOEFL ITP Paket {{ $package }}</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">Score Report</h1>
                    <p class="mt-2 text-slate-600">Nilai di bawah ini merupakan rekap skor section package yang tersimpan terakhir.</p>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-3 screen-only">
                    @foreach (['listening' => 'Listening Comprehension', 'structure' => 'Structure & Written Expression', 'reading' => 'Reading Comprehension'] as $key => $label)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-wide text-slate-500">{{ $label }}</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $scores[$key] !== null ? $scores[$key] : '-' }}</p>
                            @php
                                $sectionResult = $latestBySection[$key] ?? null;
                                $evaluation = is_object($sectionResult) && is_array($sectionResult->evaluation_data ?? null) ? $sectionResult->evaluation_data : [];
                            @endphp
                            <p class="mt-1 text-xs text-slate-500">
                                @if(!empty($evaluation) && isset($evaluation['score_correct'], $evaluation['score_total']))
                                    Benar {{ $evaluation['score_correct'] }}/{{ $evaluation['score_total'] }}
                                @elseif($scores[$key] !== null)
                                    Estimasi otomatis
                                @else
                                    Belum ada hasil
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 rounded-2xl border p-5 screen-only {{ $allSectionsComplete ? 'border-emerald-200 bg-emerald-50' : 'border-amber-200 bg-amber-50' }}">
                    @if($allSectionsComplete)
                        <p class="text-sm font-semibold text-emerald-700">Total TOEFL ITP Score</p>
                        <p class="mt-2 text-4xl font-bold text-emerald-800">{{ $totalScore }}</p>
                    @else
                        <p class="text-sm font-semibold text-amber-700">Total score belum tersedia</p>
                        <p class="mt-2 text-sm text-amber-700">Selesaikan ketiga section (Listening, Structure, Reading) agar total score bisa dihitung.</p>
                    @endif
                </div>

                @php
                    $reportUser = $taker ?? Auth::user();
                    $candidateName = trim((string) ($reportUser->name ?? 'Test Taker'));
                    $candidateEmail = trim((string) ($reportUser->email ?? ''));
                    $candidateNumber = str_pad((string) ($reportUser->id ?? 0), 8, '0', STR_PAD_LEFT);
                    $candidateId = trim((string) ($reportUser->candidate_id ?? ('OTK-' . $candidateNumber)));
                    $centreNumber = 'TB' . now()->format('ymd') . str_pad((string) $package, 3, '0', STR_PAD_LEFT);
                    $completedAt = collect($latestBySection ?? [])
                        ->filter()
                        ->map(fn ($result) => $result->completed_at)
                        ->filter()
                        ->sortDesc()
                        ->first();
                    $completionDate = $completedAt ? $completedAt->format('d M Y') : now()->format('d M Y');
                    $scoreText = $totalScore !== null ? $totalScore : '-';
                    $dateOfBirth = ($reportUser->date_of_birth ?? null)
                        ? \Illuminate\Support\Carbon::parse($reportUser->date_of_birth)->format('d M Y')
                        : '-';
                @endphp

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
                        
                        <h1 class="font-bold text-gray-900 uppercase tracking-wide leading-none text-center mb-6" style="font-size: 48px; font-family: Georgia, 'Times New Roman', serif;">{{ $candidateName }}</h1>
                        
                        <p class="italic text-gray-700 mb-6" style="font-size: 22px; font-family: Georgia, 'Times New Roman', serif;">achieved the following scores on the</p>
                        
                        <h3 class="font-bold text-gray-900 tracking-wide mb-2" style="font-size: 32px; font-family: Georgia, 'Times New Roman', serif;">TOEFL ITP<span style="font-size: 16px; vertical-align: top;">®</span> Prediction Test</h3>

                        <div class="mt-4 mb-14 text-left w-full max-w-[540px] mx-auto bg-white/70 p-6 md:px-10 md:py-8 rounded-2xl border border-white shadow-sm backdrop-blur-md">
                            <table class="w-full text-[16px] md:text-[18px] text-gray-700 font-medium">
                                <tbody>
                                    <tr class="border-b border-gray-200/70">
                                        <td class="pr-6 py-3.5">Listening Comprehension:</td>
                                        <td class="text-right py-3.5 font-bold text-xl text-gray-900">{{ $scores['listening'] !== null ? $scores['listening'] : '-' }}</td>
                                    </tr>
                                    <tr class="border-b border-gray-200/70">
                                        <td class="pr-6 py-3.5">Structure & Written Expression:</td>
                                        <td class="text-right py-3.5 font-bold text-xl text-gray-900">{{ $scores['structure'] !== null ? $scores['structure'] : '-' }}</td>
                                    </tr>
                                    <tr class="border-b border-gray-200/70">
                                        <td class="pr-6 py-3.5">Reading Comprehension:</td>
                                        <td class="text-right py-3.5 font-bold text-xl text-gray-900">{{ $scores['reading'] !== null ? $scores['reading'] : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-6 py-3.5 pt-5 font-bold text-[18px] md:text-[20px]" style="color: var(--toefl-purple);">Total:</td>
                                        <td class="text-right py-3.5 pt-5 font-black text-[24px] md:text-[28px]" style="color: var(--toefl-purple);">{{ $scoreText }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="relative z-10 mt-auto flex flex-col md:flex-row justify-between items-start md:items-end pb-2 pt-6 border-t" style="border-color: var(--toefl-line);">
                        <div class="text-[13px] leading-[1.6] text-gray-500">
                            <p>Under the auspices of:</p>
                            <p class="font-bold uppercase tracking-wide text-gray-800">TARGET BAHASA</p>
                            <p class="font-bold text-gray-800">Date: {{ $completionDate }}</p>
                        </div>
                        <div class="text-[20px] md:text-[24px] italic text-gray-500 font-serif pb-1 border-b border-gray-300 w-full md:w-auto text-center md:text-right px-4 mt-6 md:mt-0">
                            The TOEFL<span class="text-xs align-top">®</span> Program
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3 no-print">
                    <form action="{{ route('online-test.end-session', ['slug' => 'toefl_itp']) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 rounded-xl border border-red-200 text-red-600 bg-red-50 hover:bg-red-100 font-semibold" onclick="return confirm('Apakah Anda yakin ingin mengakhiri sesi? Progress ujian yang sedang berjalan mungkin akan hilang.')">Selesai & Keluar</button>
                    </form>
                    <button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold">Save PDF</button>
                </div>
            </div>
        </div>
    </main>
</div>
</body>

</html>
