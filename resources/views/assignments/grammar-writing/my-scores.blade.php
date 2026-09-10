<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Nilai & Koreksi Guru</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Nilai &amp; Koreksi Guru
                        </h1>
                        <p class="text-gray-600 mt-1">Hasil pengerjaan tugas kamu dan koreksi dari pengajar.</p>
                    </div>
                    <a href="{{ route('assignments.grammar-writing.classes') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    @if($scores->isEmpty())
                        <div class="p-12 text-center text-gray-500">
                            <p class="font-bold text-gray-700">Belum ada tugas yang kamu submit.</p>
                        </div>
                    @else
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Track</th>
                                    <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Meeting</th>
                                    <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-center">Skor</th>
                                    <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                                    <th class="p-4 font-bold text-gray-600 text-xs uppercase tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($scores as $meetingScore)
                                    <tr class="hover:bg-white transition-colors">
                                        <td class="p-4">
                                            <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold bg-white text-slate-700">
                                                {{ \App\Http\Controllers\GrammarWritingScoreController::TRACK_LABELS[$meetingScore->program->slug ?? ''] ?? ($meetingScore->program->name ?? '-') }}
                                            </span>
                                        </td>
                                        <td class="p-4 font-semibold text-gray-800">Meeting {{ $meetingScore->meeting_number }}</td>
                                        <td class="p-4 text-center">
                                            <span class="inline-block px-2.5 py-1 rounded-lg text-sm font-extrabold bg-white text-amber-900 border border-amber-200">
                                                {{ $meetingScore->score }}
                                            </span>
                                        </td>
                                        <td class="p-4">
                                            @if($meetingScore->reviewed_at)
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded bg-white text-purple-800">
                                                    ✓ Sudah Dikoreksi Guru
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[11px] font-medium px-2 py-0.5 rounded bg-white text-gray-600">
                                                    Menunggu Koreksi Guru
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-right space-x-2">
                                            @php
                                                $evalImg1 = storage_path('app/public/evaluations/eval_' . $meetingScore->id . '.png');
                                                $evalImg2 = storage_path('app/public/evaluations/eval_' . $meetingScore->user_id . '_' . $meetingScore->program_id . '_' . $meetingScore->meeting_number . '.png');
                                                $evalImg3 = storage_path('app/public/evaluations/eval_user_' . $meetingScore->user_id . '_m_' . $meetingScore->meeting_number . '.png');
                                                $hasEvalPdf = file_exists($evalImg1) || file_exists($evalImg2) || file_exists($evalImg3);
                                            @endphp
                                            @if($hasEvalPdf)
                                                <a href="{{ route('assignments.grammar-writing.download-evaluation-pdf', $meetingScore->id) }}"
                                                   class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-colors inline-flex items-center gap-1 shadow-xs">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M7 10l5 5 5-5M12 15V3"></path></svg>
                                                    <span>Unduh PDF</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('assignments.grammar-writing.my-scores.show', $meetingScore->id) }}"
                                               class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors inline-flex items-center gap-1 shadow-xs">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
