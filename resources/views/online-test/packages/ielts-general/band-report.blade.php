<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS General Band Report - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .certificate-preview {
            --ielts-blue: #062a55;
            --ielts-line: #d7dde7;
            --ielts-muted: #697489;
            width: 100%;
            max-width: 980px;
            margin: 32px auto 0;
            padding: 64px 72px 52px;
            overflow: hidden;
            border: 1px solid #d7dde7;
            border-radius: 12px;
            background:
                repeating-radial-gradient(ellipse at 92% -4%, rgba(6, 42, 85, 0.08) 0 1px, transparent 1px 9px),
                #fffdfa;
            color: #101a2f;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        }

        .cert-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 32px;
        }

        .cert-title-lockup {
            display: flex;
            align-items: flex-start;
            min-width: 0;
        }

        .cert-right-lockup {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 22px;
            min-width: 260px;
        }

        .cert-logo {
            width: 220px;
            height: auto;
            flex: 0 0 auto;
            object-fit: contain;
        }

        .cert-brand {
            font-size: 84px;
            font-weight: 900;
            line-height: 0.9;
            letter-spacing: 0;
            color: var(--ielts-blue);
        }

        .cert-subtitle {
            margin-top: 14px;
            font-size: 30px;
            font-weight: 800;
            line-height: 1.1;
        }

        .cert-redline {
            width: 134px;
            height: 4px;
            margin-top: 22px;
            background: #d91f3d;
        }

        .cert-badge {
            margin-top: 0;
            min-width: 246px;
            border-radius: 7px;
            background: var(--ielts-blue);
            padding: 13px 26px;
            text-align: center;
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
            color: #fff;
        }

        .cert-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            margin-top: 36px;
            border-top: 1px solid var(--ielts-line);
            border-bottom: 1px solid var(--ielts-line);
            padding: 18px 0;
            text-align: center;
        }

        .cert-meta-item + .cert-meta-item {
            border-left: 1px solid var(--ielts-line);
        }

        .cert-meta-label {
            color: var(--ielts-muted);
            font-size: 16px;
        }

        .cert-meta-value {
            margin-top: 10px;
            font-size: 20px;
            font-weight: 800;
            color: #101a2f;
        }

        .cert-section {
            position: relative;
            margin-top: 30px;
            border: 1px solid var(--ielts-line);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.72);
        }

        .cert-section::before {
            content: "";
            position: absolute;
            top: 34px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--ielts-blue);
        }

        .cert-tab {
            position: relative;
            display: inline-block;
            min-width: 220px;
            margin: -1px 0 0 -1px;
            border-radius: 8px 8px 0 0;
            background: var(--ielts-blue);
            padding: 10px 30px;
            color: #fff;
            font-size: 19px;
            font-weight: 800;
            line-height: 1;
            text-transform: uppercase;
            z-index: 1;
        }

        .cert-tab::after {
            content: "";
            position: absolute;
            right: -24px;
            top: 0;
            width: 48px;
            height: 100%;
            transform: skewX(28deg);
            transform-origin: left bottom;
            background: var(--ielts-blue);
            z-index: -1;
        }

        .cert-info {
            padding: 26px 30px 10px;
        }

        .cert-info-row {
            display: grid;
            grid-template-columns: 245px 24px 1fr;
            align-items: baseline;
            gap: 8px;
            border-bottom: 1px solid #e3e7ee;
            padding: 12px 0;
            font-size: 19px;
        }

        .cert-info-label {
            color: #1f2b43;
        }

        .cert-info-colon,
        .cert-info-value {
            font-weight: 800;
            color: #101a2f;
        }

        .cert-results {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            padding-top: 34px;
        }

        .cert-score {
            min-height: 160px;
            padding: 24px 16px 20px;
            text-align: center;
        }

        .cert-score + .cert-score {
            border-left: 1px solid var(--ielts-line);
        }

        .cert-score-label {
            font-size: 20px;
            font-weight: 800;
        }

        .cert-score-value {
            margin-top: 18px;
            font-size: 56px;
            font-weight: 900;
            line-height: 0.9;
            color: var(--ielts-blue);
        }

        .cert-score-denominator {
            margin-top: 8px;
            font-size: 22px;
        }

        .cert-summary {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            align-items: center;
            margin-top: 24px;
            border: 1px solid #bfcada;
            border-radius: 8px;
            background: #f3f6fa;
        }

        .cert-summary-cell {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 22px;
            min-height: 84px;
            padding: 16px;
        }

        .cert-summary-cell + .cert-summary-cell {
            border-left: 1px solid #bfcada;
        }

        .cert-summary-label {
            font-size: 18px;
            font-weight: 700;
        }

        .cert-summary-value {
            font-size: 44px;
            font-weight: 900;
            line-height: 1;
            color: var(--ielts-blue);
        }

        .cert-summary-denominator {
            font-size: 20px;
        }

        .cert-notes {
            width: min(620px, 100%);
            margin-top: 24px;
            border: 1px solid var(--ielts-line);
            border-radius: 8px;
            background: #fff;
            padding: 16px 20px;
            font-size: 15px;
            line-height: 1.55;
        }

        .cert-notes-title {
            margin-bottom: 4px;
            font-weight: 800;
        }

        @media (max-width: 820px) {
            .certificate-preview {
                padding: 28px 18px;
            }

            .cert-header,
            .cert-meta,
            .cert-results,
            .cert-summary {
                grid-template-columns: 1fr;
                display: grid;
            }

            .cert-title-lockup {
                display: block;
            }

            .cert-right-lockup {
                align-items: flex-start;
                min-width: 0;
            }

            .cert-logo {
                width: 190px;
            }

            .cert-brand {
                font-size: 58px;
            }

            .cert-badge {
                width: fit-content;
                min-width: 0;
                margin-top: 0;
                font-size: 20px;
            }

            .cert-meta-item + .cert-meta-item,
            .cert-score + .cert-score,
            .cert-summary-cell + .cert-summary-cell {
                border-left: 0;
                border-top: 1px solid var(--ielts-line);
            }

            .cert-info-row {
                grid-template-columns: 1fr;
                gap: 4px;
            }
        }

        @media print {
            nav,
            .sidebar-admin,
            .no-print {
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
            }

            .screen-only {
                display: none !important;
            }

            .certificate-preview {
                box-shadow: none !important;
                border: 0 !important;
                margin: 0 !important;
                max-width: none !important;
                padding: 42px 52px !important;
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
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-600 to-amber-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">TB</div>
                    <span class="text-xl font-bold bg-gradient-to-r from-orange-700 to-amber-700 bg-clip-text text-transparent">Target Bahasa</span>
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
                    <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">IELTS General Paket {{ $package }}</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">Band Score Report</h1>
                    <p class="mt-2 text-slate-600">Nilai di bawah ini merupakan rekap skor section package yang tersimpan terakhir.</p>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-4 screen-only">
                    @foreach (['listening' => 'Listening', 'reading' => 'Reading', 'writing' => 'Writing', 'speaking' => 'Speaking'] as $key => $label)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-wide text-slate-500">{{ $label }}</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $bands[$key] !== null ? number_format((float) $bands[$key], 1) : '-' }}</p>
                            @php
                                $sectionResult = $latestBySection[$key] ?? null;
                                $evaluation = is_object($sectionResult) && is_array($sectionResult->evaluation_data ?? null) ? $sectionResult->evaluation_data : [];
                            @endphp
                            <p class="mt-1 text-xs text-slate-500">
                                @if(!empty($evaluation) && isset($evaluation['score_correct'], $evaluation['score_total']))
                                    Benar {{ $evaluation['score_correct'] }}/{{ $evaluation['score_total'] }}
                                @elseif($bands[$key] !== null)
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
                        <p class="text-sm font-semibold text-emerald-700">Overall IELTS General Band Score</p>
                        <p class="mt-2 text-4xl font-bold text-emerald-800">{{ number_format((float) $overallBand, 1) }}</p>
                    @else
                        <p class="text-sm font-semibold text-amber-700">Overall band belum tersedia</p>
                        <p class="mt-2 text-sm text-amber-700">Selesaikan keempat section (Listening, Reading, Writing, Speaking) agar overall band bisa dihitung.</p>
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
                    $scoreText = $overallBand !== null ? number_format((float) $overallBand, 1) : '-';
                    $dateOfBirth = ($reportUser->date_of_birth ?? null)
                        ? \Illuminate\Support\Carbon::parse($reportUser->date_of_birth)->format('d M Y')
                        : '-';
                    $cefrLevel = '-';

                    if ($overallBand !== null) {
                        $cefrLevel = match (true) {
                            $overallBand >= 8.5 => 'C2',
                            $overallBand >= 7.0 => 'C1',
                            $overallBand >= 5.5 => 'B2',
                            $overallBand >= 4.0 => 'B1',
                            default => 'A2',
                        };
                    }
                @endphp

                <div class="certificate-preview">
                    <div class="cert-header">
                        <div class="cert-title-lockup">
                            <div>
                                <div class="cert-brand">IELTS</div>
                                <div class="cert-subtitle">Practice Test Result</div>
                                <div class="cert-redline"></div>
                            </div>
                        </div>
                        <div class="cert-right-lockup">
                            <img class="cert-logo" src="{{ asset('images/brand/target-bahasa-logo.png') }}" alt="Target Bahasa">
                            <div class="cert-badge">GENERAL</div>
                        </div>
                    </div>

                    <div class="cert-meta">
                        <div class="cert-meta-item">
                            <div class="cert-meta-label">Test Date</div>
                            <div class="cert-meta-value">{{ $completionDate }}</div>
                        </div>
                        <div class="cert-meta-item">
                            <div class="cert-meta-label">Centre Number</div>
                            <div class="cert-meta-value">{{ $centreNumber }}</div>
                        </div>
                        <div class="cert-meta-item">
                            <div class="cert-meta-label">Candidate Number</div>
                            <div class="cert-meta-value">{{ $candidateNumber }}</div>
                        </div>
                    </div>

                    <section class="cert-section">
                        <div class="cert-tab">Candidate Information</div>
                        <div class="cert-info">
                            @foreach([
                                'Full Name' => $candidateName,
                                'Candidate ID' => $candidateId,
                                'Email' => $candidateEmail !== '' ? $candidateEmail : '-',
                                'Date of Birth' => $dateOfBirth,
                                'Sex (M/F)' => $reportUser->sex ?? ($reportUser->gender ?? '-'),
                                'Country of Origin' => $reportUser->country_of_origin ?? ($reportUser->country ?? '-'),
                                'Country of Nationality' => $reportUser->country_of_nationality ?? ($reportUser->nationality ?? '-'),
                                'First Language' => $reportUser->first_language ?? '-',
                                'Test Type' => $reportUser->test_type ?? 'General',
                            ] as $label => $value)
                                <div class="cert-info-row">
                                    <div class="cert-info-label">{{ $label }}</div>
                                    <div class="cert-info-colon">:</div>
                                    <div class="cert-info-value">{{ filled($value) ? $value : '-' }}</div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="cert-section">
                        <div class="cert-tab">Test Results</div>
                        <div class="cert-results">
                            @foreach (['listening' => 'Listening', 'reading' => 'Reading', 'writing' => 'Writing', 'speaking' => 'Speaking'] as $key => $label)
                                <div class="cert-score">
                                    <div class="cert-score-label">{{ $label }}</div>
                                    <div class="cert-score-value">{{ $bands[$key] !== null ? number_format((float) $bands[$key], 1) : '-' }}</div>
                                    <div class="cert-score-denominator">/ 9</div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="cert-summary">
                        <div class="cert-summary-cell">
                            <span class="cert-summary-label">Overall Band Score</span>
                            <span class="cert-summary-value">{{ $scoreText }}</span>
                            <span class="cert-summary-denominator">/ 9</span>
                        </div>
                        <div class="cert-summary-cell">
                            <span class="cert-summary-label">CEFR Level</span>
                            <span class="cert-summary-value">{{ $cefrLevel }}</span>
                        </div>
                    </section>

                    <section class="cert-notes">
                        <div class="cert-notes-title">Notes</div>
                        <p>This is a mock IELTS General test result for practice purposes only.</p>
                        <p>It is not an official IELTS result and cannot be used for official purposes.</p>
                    </section>
                </div>

                <div class="mt-6 flex flex-wrap gap-3 no-print">
                    <form action="{{ route('online-test.end-session', ['slug' => 'ielts_general']) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 rounded-xl border border-red-200 text-red-600 bg-red-50 hover:bg-red-100 font-semibold" onclick="return confirm('Apakah Anda yakin ingin mengakhiri sesi? Progress ujian yang sedang berjalan mungkin akan hilang.')">Selesai & Keluar</button>
                    </form>
                    <button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-semibold">Save PDF</button>
                </div>
            </div>
        </div>
    </main>
</div>
</body>

</html>
