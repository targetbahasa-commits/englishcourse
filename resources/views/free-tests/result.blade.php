@extends('layouts.app')

@section('content')
{{-- Print Stylesheet --}}
<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .print-section { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
    .page-break { page-break-before: always; }
}
</style>

<div class="py-10 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-8 no-print">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 text-green-600 rounded-full mb-3 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900">Test Selesai!</h1>
            <p class="text-gray-500 mt-1 text-sm">Lihat hasil estimasi skor dan rekomendasi kelas Anda.</p>
        </div>

        <div class="space-y-6">

            {{-- ══════════════════════════════════════════════
                 SCORE REPORT CARD (ETS Style)
            ══════════════════════════════════════════════ --}}
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden print-section">
                {{-- Official Header --}}
                <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-widest font-semibold">Target Bahasa</p>
                            <h2 class="text-2xl font-black mt-1">Score Report</h2>
                            <p class="text-blue-200 text-sm mt-0.5">{{ strtoupper(str_replace('_', ' ', $result->test_type)) }} — Placement Test</p>
                        </div>
                        <div class="text-right text-blue-200 text-xs space-y-1">
                            <p><span class="font-semibold text-white">Nama:</span> {{ Auth::user()->name }}</p>
                            <p><span class="font-semibold text-white">Tanggal:</span> {{ $result->created_at->format('d M Y') }}</p>
                            <p><span class="font-semibold text-white">ID Tes:</span> #{{ str_pad($result->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Score + Level --}}
                <div class="px-8 py-8 text-center border-b border-gray-100">
                    @php
                        $score   = $result->score + 0;
                        $isIelts = str_starts_with($result->test_type, 'ielts_') || $result->test_type === 'pte_academic';

                        if ($isIelts) {
                            if ($score < 5.0) {
                                $level = 'Basic'; $levelColor = 'bg-red-100 text-red-700 border-red-200';
                            } elseif ($score < 6.5) {
                                $level = 'Intermediate'; $levelColor = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                            } elseif ($score < 7.5) {
                                $level = 'Upper Intermediate'; $levelColor = 'bg-blue-100 text-blue-700 border-blue-200';
                            } else {
                                $level = 'Advanced'; $levelColor = 'bg-green-100 text-green-700 border-green-200';
                            }
                        } else {
                            // TOEFL ITP / General (300-677)
                            if ($score <= 380) {
                                $level = 'Basic'; $levelColor = 'bg-red-100 text-red-700 border-red-200';
                            } elseif ($score <= 450) {
                                $level = 'Intermediate'; $levelColor = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                            } elseif ($score <= 500) {
                                $level = 'Upper Intermediate'; $levelColor = 'bg-blue-100 text-blue-700 border-blue-200';
                            } else {
                                $level = 'Advanced'; $levelColor = 'bg-green-100 text-green-700 border-green-200';
                            }
                        }
                    @endphp

                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Estimated Score</p>
                    <div class="text-7xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-br from-blue-700 to-indigo-600 mb-4">
                        {{ $score }}
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-bold border {{ $levelColor }}">
                        <span class="w-2 h-2 rounded-full {{ str_replace(['text-', 'border-', 'bg-100 ', 'bg-50 '], ['bg-', '', '', ''], explode(' ', $levelColor)[1]) }}"></span>
                        Level: {{ $level }}
                    </span>

                    {{-- Score Bar --}}
                    @if(!$isIelts)
                    <div class="mt-6 px-4">
                        <div class="flex justify-between text-xs text-gray-400 mb-1"><span>300</span><span>677</span></div>
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 transition-all"
                                style="width: {{ min(100, (($score - 300) / 377) * 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-center">Skor TOEFL ITP: 300–677</p>
                    </div>
                    @endif
                </div>

                {{-- Strengths & Weaknesses --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                    <div class="px-8 py-6">
                        <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                            Kelebihan
                        </h3>
                        <ul class="space-y-2">
                            @forelse($result->evaluation_data['strengths'] ?? [] as $s)
                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                {{ $s }}
                            </li>
                            @empty<li class="text-gray-400 text-sm italic">—</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="px-8 py-6">
                        <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Area yang Perlu Diperbaiki
                        </h3>
                        <ul class="space-y-2">
                            @forelse($result->evaluation_data['weaknesses'] ?? [] as $w)
                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                <div class="w-1.5 h-1.5 rounded-full bg-amber-400 mt-2 flex-shrink-0"></div>
                                {{ $w }}
                            </li>
                            @empty<li class="text-gray-400 text-sm italic">—</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════
                 ACTION BUTTONS
            ══════════════════════════════════════════════ --}}
            <div class="flex flex-wrap gap-3 justify-center no-print">
                {{-- Print / Download --}}
                <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Download / Cetak
                </button>

                {{-- Share / Copy Link --}}
                <button onclick="navigator.clipboard.writeText(window.location.href).then(() => { this.textContent = '✓ Link Tersalin!'; setTimeout(() => this.innerHTML = '<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z\'/></svg> Share Hasil', 2000); })"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    Share Hasil
                </button>
            </div>

            {{-- ══════════════════════════════════════════════
                 PROGRAM RECOMMENDATION (from OutreachMessage)
            ══════════════════════════════════════════════ --}}
            @if($outreachMessage)
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl shadow-xl overflow-hidden text-white relative">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                <div class="p-8 relative z-10">
                    <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-bold tracking-wider uppercase mb-4 backdrop-blur-sm">
                        🎯 Rekomendasi untuk Anda
                    </span>
                    <h2 class="text-xl font-bold mb-3">Langkah Selanjutnya</h2>
                    <p class="text-blue-100 text-sm leading-relaxed mb-6">
                        {!! nl2br(e($outreachMessage->message_content)) !!}
                    </p>
                    @if($recommendedProgram)
                    <a href="{{ route('assignments') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-700 font-bold rounded-xl shadow-md hover:shadow-xl hover:bg-gray-50 hover:scale-105 transition-all duration-200 text-sm">
                        Daftar Program: {{ $recommendedProgram->name }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @else
                    <a href="{{ route('assignments') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-700 font-bold rounded-xl shadow-md hover:shadow-xl hover:bg-gray-50 transition-all duration-200 text-sm">
                        Lihat Program Tersedia
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="text-4xl mb-3">📚</div>
                <p class="text-gray-600 mb-4 font-medium">Bagus! Tetap berlatih untuk meningkatkan skor Anda.</p>
                <a href="{{ route('assignments') }}"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition text-sm shadow-sm">
                    Lihat Program Belajar
                </a>
            </div>
            @endif

            <div class="text-center no-print">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-700 text-sm font-medium transition-colors">← Kembali ke Dashboard</a>
            </div>

        </div>
    </div>
</div>
@endsection
