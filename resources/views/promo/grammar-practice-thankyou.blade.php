<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Latihan Grammar | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-brand {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 50%, #4f46e5 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-sky-50/40 to-indigo-50/30 text-slate-800 min-h-screen antialiased selection:bg-sky-500 selection:text-white py-8 sm:py-12 px-4 sm:px-6">

    <div class="max-w-2xl mx-auto">
        
        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden">
            
            <!-- Hero Header -->
            <div class="bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 p-8 text-white text-center relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -left-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded-full mb-3 shadow-2xs">
                    ✨ Evaluasi Grammar AI Selesai
                </span>
                
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-1">
                    Terima Kasih, {{ $submission->name }}!
                </h1>
                <p class="text-sky-100 text-sm font-medium">
                    Jawaban latihan grammar Anda telah berhasil dianalisis.
                </p>
            </div>

            <!-- Score Section -->
            <div class="p-6 sm:p-8 text-center border-b border-slate-100 bg-slate-50/50">
                @if(!is_null($submission->estimated_band_score))
                    @php
                        $score = (float) $submission->estimated_band_score;
                        $badgeLabel = match(true) {
                            $score >= 80 => 'Sangat Baik (Advanced)',
                            $score >= 65 => 'Bagus (Intermediate)',
                            $score >= 50 => 'Cukup (Pre-Intermediate)',
                            default => 'Perlu Peningkatan Dasar (Elementary)',
                        };
                        $badgeColor = match(true) {
                            $score >= 80 => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                            $score >= 65 => 'bg-sky-100 text-sky-800 border-sky-300',
                            $score >= 50 => 'bg-amber-100 text-amber-800 border-amber-300',
                            default => 'bg-rose-100 text-rose-800 border-rose-300',
                        };
                    @endphp

                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Estimasi Skor Akurasi Grammar</p>
                    <div class="inline-flex items-baseline justify-center gap-1 text-5xl sm:text-6xl font-black gradient-text mb-3">
                        <span>{{ rtrim(rtrim(number_format($score, 1), '0'), '.') }}</span>
                        <span class="text-2xl font-bold text-slate-400">/100</span>
                    </div>
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold border {{ $badgeColor }} shadow-2xs">
                            {{ $badgeLabel }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Detailed Breakdown (if available) -->
            @php
                $feedbackData = is_array($submission->ai_raw_json_feedback) 
                    ? $submission->ai_raw_json_feedback 
                    : (json_decode($submission->ai_raw_json_feedback, true) ?? []);
                $results = $feedbackData['results'] ?? [];
            @endphp

            @if(!empty($results))
            <div class="p-6 sm:p-8 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Detail Review Jawaban:
                </h3>
                <div class="space-y-4">
                    @foreach($results as $idx => $res)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <span class="text-xs font-extrabold text-slate-500">Soal #{{ $idx + 1 }}</span>
                            @if(isset($res['accuracy_score']))
                                <span class="text-xs font-extrabold {{ $res['accuracy_score'] >= 70 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    Akurasi: {{ $res['accuracy_score'] }}%
                                </span>
                            @endif
                        </div>
                        <p class="text-sm font-bold text-slate-900 mb-1">{!! $res['prompt'] ?? '' !!}</p>
                        <div class="text-xs text-slate-600 bg-white p-2.5 rounded-xl border border-slate-200 mb-2">
                            <span class="font-bold text-slate-400">Jawaban Kamu:</span> 
                            <span class="font-medium text-slate-800">{{ !empty($res['submitted']) ? $res['submitted'] : '(kosong)' }}</span>
                        </div>
                        @if(!empty($res['feedback']))
                            <p class="text-xs text-sky-700 font-medium bg-sky-50/70 p-2.5 rounded-xl border border-sky-100">
                                💡 {{ $res['feedback'] }}
                            </p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Next Steps & Call to Actions -->
            <div class="p-6 sm:p-8 space-y-4">
                <div class="bg-sky-50/60 rounded-2xl p-4 border border-sky-100 text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
                    🎯 Ingin menguasai grammar untuk penulisan esai formal, IELTS, atau akademis secara terstruktur dengan bimbingan mentor berpengalaman?
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <a href="https://wa.me/6285706615607?text=Halo%20Admin%20Target%20Bahasa,%20saya%20sudah%20mencoba%20latihan%20grammar%20dan%20ingin%20konsultasi%20kelas." target="_blank" class="w-full py-3.5 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Konsultasi via WhatsApp</span>
                    </a>

                    <a href="{{ url('/brochure/online') }}" target="_blank" class="w-full py-3.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Lihat Brosur Kelas</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
