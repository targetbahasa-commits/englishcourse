<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Grammar Practice: {{ $topic->title }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        window.cfTurnstileToken = null;
        function onTurnstileVerified(token) { window.cfTurnstileToken = token; }
        function onTurnstileExpired() { window.cfTurnstileToken = null; }
    </script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>

<body
    class="font-sans antialiased bg-gradient-to-br from-teal-50 via-cyan-50 to-emerald-50 text-gray-800 min-h-screen pb-20">

    <div class="max-w-4xl mx-auto p-4 md:p-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/brand/icon.png') }}" class="w-10 h-10 md:w-12 md:h-12"
                        alt="Target Bahasa">
                    <div>
                        <span class="font-extrabold text-base md:text-lg text-gray-900 leading-tight block">Target
                            Bahasa</span>
                        <span class="text-xs font-semibold text-teal-600 tracking-wide uppercase">Grammar for
                            Writing</span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ url('/brochure/online') }}" target="_blank"
                        class="text-xs md:text-sm font-semibold text-teal-700 hover:text-teal-900 bg-white/80 hover:bg-white px-3.5 py-2 rounded-xl border border-teal-200/80 shadow-2xs transition">
                        Lihat Program
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="p-2.5 sm:p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl shadow-md shrink-0">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h1
                        class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent break-words">
                        Grammar Practice: {{ $topic->title }}
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-600 mt-0.5">Free Grammar for Writing Practice &mdash; Target
                        Bahasa</p>
                </div>
            </div>
        </div>

        @if($topic->desc)
            <div
                class="bg-teal-50/80 border border-teal-200/80 rounded-2xl p-4 mb-6 text-sm text-teal-950 flex items-start gap-3 shadow-2xs">
                <svg class="w-5 h-5 text-teal-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="leading-relaxed">
                    <strong class="font-bold text-teal-900">Fokus & Konsep Materi:</strong> {{ $topic->desc }}
                </div>
            </div>
        @endif

        {{-- Main Alpine Component matching IELTS Grammar Practice --}}
        <div x-data="promoGrammarPractice()" class="space-y-6">

            <!-- Top Action Buttons -->
            <div
                class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white/70 backdrop-blur-sm p-3.5 sm:p-4 rounded-2xl border border-teal-100 shadow-2xs">
                <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 sm:gap-3">
                    <button @click="resetAll()" type="button"
                        class="px-3.5 py-2.5 bg-white text-gray-700 text-xs sm:text-sm font-medium rounded-xl border border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition flex items-center justify-center gap-1.5 shadow-2xs">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        <span>Refresh Ulang</span>
                    </button>

                    <button @click="submitAllQuestions()" type="button"
                        class="px-3.5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white text-xs sm:text-sm font-medium rounded-xl shadow-2xs transition flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Submit Semua</span>
                    </button>
                </div>

                <!-- Progress Indicator -->
                <div
                    class="text-xs font-semibold text-gray-500 flex items-center justify-between sm:justify-start gap-2 pt-1 sm:pt-0 border-t sm:border-t-0 border-teal-100">
                    <span>Progress Pengerjaan:</span>
                    <span class="px-2.5 py-1 bg-teal-100 text-teal-800 rounded-lg font-bold"
                        x-text="`${submittedCount()} / ${questions.length} Terjawab`"></span>
                </div>
            </div>

            <!-- Questions List -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-3">{{ count($questions) }} Soal Terjemahan
                </h3>
                <div class="space-y-3.5 sm:space-y-4">
                    <template x-for="(sentence, index) in questions" :key="'q-' + sentence.id">
                        <div class="group rounded-2xl border border-gray-200 bg-white p-3.5 sm:p-5 transition hover:shadow-md hover:border-teal-200 space-y-3 overflow-visible shadow-2xs"
                            :class="{'border-purple-200 bg-purple-50/20': sentence.type === 'paragraph'}">

                            <!-- Question Header & Prompt -->
                            <div class="flex items-start gap-2.5 sm:gap-4">
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl flex items-center justify-center text-xs sm:text-sm font-bold shrink-0 mt-0.5"
                                    :class="sentence.type === 'paragraph' ? 'bg-purple-100 text-purple-700' : 'bg-teal-100 text-teal-700'"
                                    x-text="index + 1">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1" x-show="sentence.type === 'paragraph'">
                                        <span
                                            class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-purple-100 text-purple-700 border border-purple-200">Paragraf
                                            Latihan</span>
                                    </div>
                                    <div class="inline items-baseline">
                                        <span
                                            class="text-gray-800 text-sm sm:text-base md:text-lg leading-relaxed font-medium"
                                            x-html="sentence.prompt"></span>
                                        <span x-show="sentence.cefr_level"
                                            class="inline-flex items-center align-middle ml-1.5 px-2 py-0.5 rounded text-[10px] sm:text-[11px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200 shadow-2xs"
                                            x-text="sentence.cefr_level"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Vocabulary Helper Chips (if any) -->
                            <template x-if="sentence.vocab_helper && Object.keys(sentence.vocab_helper).length > 0">
                                <div class="sm:ml-12 flex flex-wrap gap-1 sm:gap-1.5 pt-0.5">
                                    <template x-for="(helper, word) in sentence.vocab_helper" :key="word">
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 bg-slate-50 hover:bg-teal-50/70 text-slate-700 text-[11px] sm:text-xs font-medium rounded-lg border border-slate-200/80 transition-colors">
                                            <strong class="text-teal-700" x-text="word"></strong>
                                            <span class="text-slate-400">=</span>
                                            <span x-text="helper.id || ''"></span>
                                            <template x-if="helper.pos">
                                                <span
                                                    class="text-[9px] sm:text-[10px] px-1 py-0.2 bg-slate-200/80 text-slate-600 rounded font-mono"
                                                    x-text="helper.pos"></span>
                                            </template>
                                        </span>
                                    </template>
                                </div>
                            </template>

                            <!-- Input Row with Embedded Subtle Gray Refresh & Submit Symbol Button -->
                            <div class="sm:ml-12">
                                <div class="flex gap-2 items-center">
                                    <div class="flex-1 min-w-0 relative">
                                        <template x-if="sentence.type === 'paragraph'">
                                            <textarea x-model="sentence.answer" rows="4" :disabled="sentence.submitted"
                                                placeholder="Tulis terjemahan paragraf dalam bahasa Inggris..."
                                                class="w-full p-2.5 sm:p-3.5 pr-9 sm:pr-10 border border-gray-300 rounded-xl text-xs sm:text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-white hover:border-gray-400 disabled:bg-gray-100 disabled:text-gray-600 leading-relaxed"></textarea>
                                        </template>
                                        <template x-if="sentence.type !== 'paragraph'">
                                            <input type="text" x-model="sentence.answer"
                                                @keydown.enter.prevent="if(!sentence.submitted) submitSingle(sentence)"
                                                :disabled="sentence.submitted"
                                                placeholder="Tulis bahasa Inggrisnya di sini..."
                                                class="w-full px-3.5 py-2.5 pr-9 sm:pr-10 border border-gray-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-white hover:border-gray-400 disabled:bg-gray-100 disabled:text-gray-600">
                                        </template>

                                        <!-- Embedded Subtle Gray Refresh Button -->
                                        <button type="button" @click.prevent="resetSingle(sentence)"
                                            title="Hapus / Ulangi Soal Ini"
                                            :class="sentence.type === 'paragraph' ? 'top-3' : 'top-1/2 -translate-y-1/2'"
                                            class="absolute right-2 p-1 text-gray-400 hover:text-teal-600 transition focus:outline-none bg-transparent active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Submit Button: Symbol icon on mobile, "Submit" text on web/desktop -->
                                    <button type="button" @click.prevent="submitSingle(sentence)"
                                        x-show="!sentence.submitted" title="Kirim / Submit Jawaban"
                                        :class="sentence.type === 'paragraph' ? 'self-start mt-1' : ''"
                                        class="w-9 h-9 sm:w-auto sm:h-10 sm:px-4 flex items-center justify-center rounded-xl bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-medium text-xs sm:text-sm transition focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-teal-500 shadow-2xs shrink-0 active:scale-95">
                                        <span class="hidden sm:inline">Submit</span>
                                        <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Real-time Evaluation Result Box (shown upon Submit) -->
                                <div x-show="sentence.submitted" x-transition
                                    class="mt-2.5 p-3 sm:p-3.5 bg-teal-50/60 border border-teal-200 rounded-xl space-y-2 text-xs sm:text-sm">
                                    <div>
                                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Evaluasi
                                            Jawaban</p>
                                        <p class="text-xs sm:text-sm mt-0.5 leading-relaxed"
                                            x-html="sentence.evaluation"></p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Kunci
                                            Jawaban</p>
                                        <p class="text-teal-800 text-xs sm:text-sm mt-0.5 font-semibold"
                                            x-text="sentence.en"></p>
                                    </div>

                                    <!-- AI Explanation Box -->
                                    <div class="mt-2.5 pt-2.5 border-t border-teal-200/60">
                                        <p
                                            class="text-[11px] font-bold text-teal-700 uppercase tracking-wider flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            Penjelasan
                                        </p>

                                        <div x-show="sentence.isExplaining"
                                            class="mt-1.5 flex items-center gap-2 text-xs font-semibold text-teal-600">
                                            <svg class="animate-spin h-3.5 w-3.5 text-teal-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            <span>Sedang menganalisis jawaban...</span>
                                        </div>

                                        <div x-show="!sentence.isExplaining && sentence.ai_explanation"
                                            class="text-xs sm:text-sm text-gray-700 mt-1.5 leading-relaxed bg-white/90 p-3 sm:p-3.5 rounded-xl border border-teal-200/80 shadow-2xs whitespace-pre-line font-normal"
                                            x-text="cleanAiExplanation(sentence.ai_explanation)"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Bottom Complete Evaluation / Lead Capture Trigger Area -->
            <div class="mt-8 pt-4 pb-12">
                <div class="bg-white rounded-2xl border border-teal-200/80 p-6 shadow-sm text-center">
                    <h4 class="text-base font-bold text-gray-900 mb-1">Simpan & Dapatkan Laporan Evaluasi Lengkap</h4>
                    <p class="text-xs sm:text-sm text-gray-600 max-w-lg mx-auto mb-4 leading-relaxed">
                        Dapatkan penilaian komprehensif akurasi grammar Anda dan konsultasi rekomendasi materi kelas
                        penulisan (writing).
                    </p>
                    <button type="button" @click="openLeadModal()"
                        class="px-8 py-3.5 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-bold text-sm sm:text-base rounded-xl shadow-md transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mx-auto">
                        <span>Buka Hasil & Laporan Skor Saya</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Lead Capture Modal -->
            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="display:none;" @keydown.escape.window="showModal = false">
                <div class="absolute inset-0 bg-black/50 backdrop-blur-xs" @click="showModal = false"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden z-10 border border-teal-100"
                    x-transition>

                    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 p-6 text-white text-center">
                        <h3 class="text-xl font-bold mb-1">Latihan Selesai! 🎉</h3>
                        <p class="text-teal-100 text-xs sm:text-sm">Lengkapi data Anda untuk membuka laporan hasil skor
                            grammar.</p>
                    </div>

                    <form @submit.prevent="submitLeadAndSave()" class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama
                                Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" x-model="lead.name" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm py-2.5"
                                placeholder="Contoh: Budi Pratama">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat
                                Email <span class="text-red-500">*</span></label>
                            <input type="email" x-model="lead.email" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm py-2.5"
                                placeholder="nama@email.com">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nomor
                                WhatsApp <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <input type="tel" x-model="lead.whatsapp"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm py-2.5"
                                placeholder="08123456789">
                        </div>

                        <div class="pt-2 flex justify-center">
                            <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}"
                                data-action="submit" data-callback="onTurnstileVerified"
                                data-expired-callback="onTurnstileExpired"></div>
                        </div>

                        <div x-show="errorMessage" x-text="errorMessage"
                            class="p-3 bg-red-50 text-red-600 text-xs rounded-xl font-semibold text-center"></div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" @click="showModal = false"
                                class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">Batal</button>
                            <button type="submit" :disabled="isSubmitting"
                                class="px-6 py-2.5 rounded-xl bg-teal-600 text-white text-sm font-bold hover:bg-teal-700 transition shadow-sm disabled:opacity-50 flex items-center gap-2">
                                <span x-show="!isSubmitting">Buka Hasil Saya</span>
                                <span x-show="isSubmitting">Menganalisis...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

    {{-- Floating Practice Toolbar matching IELTS Writing/Grammar --}}
    @include('assignments.ielts.writing.practice_toolbar', [
        'meeting' => (object) [
            'task_type' => 3,
            'prompt' => 'Grammar Practice: ' . $topic->title . ' — ' . ($topic->desc ?? '')
        ],
        'grammarLevel' => 'all',
        // Public/no-auth endpoint, so the toolbar works for guests here -
        // the default (assignments.grammar-writing.explain-lesson) requires
        // login and would break this page for anonymous promo visitors.
        'lessonExplainUrl' => route('promo.test.grammar-practice.explain-lesson'),
    ])

    <script>
        function promoGrammarPractice() {
            var rawQuestions = {!! json_encode($questions->map(function ($q) {
    return [
        'id' => $q->id,
        'type' => $q->type ?? 'sentence',
        'cefr_level' => $q->cefr_level ?? null,
        'prompt' => $q->question_id,
        'en' => $q->answer_en,
        'vocab_helper' => $q->vocab_helper ?? [],
        'answer' => '',
        'submitted' => false,
        'evaluation' => '',
        'isExplaining' => false,
        'ai_explanation' => ''
    ];
})) !!};

            return {
                questions: rawQuestions,
                showModal: false,
                isSubmitting: false,
                errorMessage: '',
                lead: {
                    name: '',
                    email: '',
                    whatsapp: ''
                },

                submittedCount() {
                    return this.questions.filter(function (q) { return q.submitted; }).length;
                },

                cleanAiExplanation(text) {
                    if (!text) return '';
                    var trimmed = String(text).trim();
                    if (trimmed.startsWith('```')) {
                        trimmed = trimmed.replace(/^```(?:json)?\s*/i, '').replace(/\s*```$/, '').trim();
                    }
                    if ((trimmed.startsWith('{') && trimmed.endsWith('}')) || (trimmed.startsWith('[') && trimmed.endsWith(']'))) {
                        try {
                            var obj = JSON.parse(trimmed);
                            if (typeof obj === 'object' && obj !== null) {
                                var parts = [];
                                if (obj.feedback) parts.push(obj.feedback);
                                if (obj.explanation) parts.push(obj.explanation);
                                if (obj.suggestion) parts.push('💡 Saran perbaikan: ' + obj.suggestion);
                                if (obj.correction) parts.push('💡 Koreksi: ' + obj.correction);
                                if (parts.length > 0) return parts.join('\n\n');

                                var vals = Object.values(obj).filter(function (v) { return typeof v === 'string'; });
                                if (vals.length > 0) return vals.join('\n\n');
                            }
                        } catch (e) { }
                    }
                    return trimmed;
                },

                submitSingle(sentence) {
                    if (!sentence.answer || sentence.answer.trim() === '') {
                        alert('Silakan ketik terjemahan bahasa Inggris Anda terlebih dahulu.');
                        return;
                    }

                    sentence.evaluation = this.evaluateAnswer(sentence.answer, sentence.en);
                    sentence.submitted = true;
                    sentence.isExplaining = true;
                    sentence.ai_explanation = '';

                    fetch('{{ route('promo.test.grammar-practice.explain') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            topic: '{{ addslashes($topic->title) }}',
                            prompt: (sentence.prompt || '').replace(/<[^>]*>?/gm, ''),
                            correct_answer: sentence.en,
                            submitted_answer: sentence.answer
                        })
                    }).then(function (r) { return r.json(); }).then(function (data) {
                        sentence.isExplaining = false;
                        if (data.success && data.explanation) {
                            sentence.ai_explanation = data.explanation;
                        }
                    }).catch(function () {
                        sentence.isExplaining = false;
                    });
                },

                resetSingle(sentence) {
                    if (sentence.answer.trim() !== '' || sentence.submitted) {
                        if (!confirm('Apakah Anda yakin ingin menghapus jawaban dan mengulangi soal ini?')) {
                            return;
                        }
                    }
                    sentence.answer = '';
                    sentence.submitted = false;
                    sentence.evaluation = '';
                    sentence.isExplaining = false;
                    sentence.ai_explanation = '';
                },

                resetAll() {
                    if (confirm('Apakah Anda yakin ingin me-refresh dan mengulangi semua soal latihan?')) {
                        this.questions.forEach(function (q) {
                            q.answer = '';
                            q.submitted = false;
                            q.evaluation = '';
                            q.isExplaining = false;
                            q.ai_explanation = '';
                        });
                    }
                },

                submitAllQuestions() {
                    var unsubmitted = this.questions.filter(function (q) { return !q.submitted && q.answer.trim().length > 0; });
                    if (unsubmitted.length === 0) {
                        // Check if none answered at all
                        var answeredAny = this.questions.some(function (q) { return q.answer.trim().length > 0; });
                        if (!answeredAny) {
                            alert('Silakan isi kolom jawaban terlebih dahulu.');
                            return;
                        }
                    }

                    var self = this;
                    this.questions.forEach(function (q) {
                        if (q.answer.trim().length > 0) {
                            q.evaluation = self.evaluateAnswer(q.answer, q.en);
                            q.submitted = true;
                        }
                    });

                    this.openLeadModal();
                },

                openLeadModal() {
                    this.errorMessage = '';
                    this.showModal = true;
                },

                escapeHtml(str) {
                    return (str || '')
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                },

                evaluateAnswer(userTranslation, correctAnswer) {
                    if (!userTranslation) userTranslation = '';
                    var normalizeWord = function (w) { return w.toLowerCase().replace(/[.!,?]+$/, ''); };
                    var userWords = userTranslation.trim().split(/\s+/).filter(function (w) { return w; });
                    var correctWords = (correctAnswer || '').trim().split(/\s+/).filter(function (w) { return w; });

                    var matrix = [];
                    var userWordCount = userWords.length;
                    var correctWordCount = correctWords.length;

                    for (var i = 0; i <= userWordCount; i++) {
                        matrix[i] = [];
                        matrix[i][0] = 0;
                    }
                    for (var j = 0; j <= correctWordCount; j++) {
                        matrix[0][j] = 0;
                    }

                    for (var i = 1; i <= userWordCount; i++) {
                        for (var j = 1; j <= correctWordCount; j++) {
                            var uWord = normalizeWord(userWords[i - 1]);
                            var cWord = normalizeWord(correctWords[j - 1]);
                            if (uWord === cWord) {
                                matrix[i][j] = matrix[i - 1][j - 1] + 1;
                            } else {
                                matrix[i][j] = Math.max(matrix[i - 1][j], matrix[i][j - 1]);
                            }
                        }
                    }

                    var diff = [];
                    var i = userWordCount;
                    var j = correctWordCount;

                    while (i > 0 || j > 0) {
                        if (i > 0 && j > 0) {
                            var uWord = normalizeWord(userWords[i - 1]);
                            var cWord = normalizeWord(correctWords[j - 1]);
                            if (uWord === cWord) {
                                diff.unshift({ type: 'match', word: userWords[i - 1] });
                                i--; j--;
                                continue;
                            }
                        }

                        if (j > 0 && (i === 0 || matrix[i][j - 1] >= matrix[i - 1][j])) {
                            diff.unshift({ type: 'missing', word: correctWords[j - 1] });
                            j--;
                        } else if (i > 0 && (j === 0 || matrix[i][j - 1] < matrix[i - 1][j])) {
                            diff.unshift({ type: 'extra', word: userWords[i - 1] });
                            i--;
                        }
                    }

                    var finalOutput = [];
                    for (var k = 0; k < diff.length; k++) {
                        var current = diff[k];
                        var next = (k + 1 < diff.length) ? diff[k + 1] : null;

                        if (current.type === 'extra' && next && next.type === 'missing') {
                            finalOutput.push('<span class="text-red-500 line-through">' + this.escapeHtml(current.word) + '</span>');
                            finalOutput.push('<span class="text-green-600 font-bold">' + this.escapeHtml(next.word) + '</span>');
                            k++;
                        } else if (current.type === 'match') {
                            finalOutput.push('<span class="text-green-600">' + this.escapeHtml(current.word) + '</span>');
                        } else if (current.type === 'extra') {
                            finalOutput.push('<span class="text-red-500 line-through">' + this.escapeHtml(current.word) + '</span>');
                        } else if (current.type === 'missing') {
                            finalOutput.push('<span class="text-green-600 font-bold">' + this.escapeHtml(current.word) + '</span>');
                        }
                    }

                    return finalOutput.join(' ');
                },

                submitLeadAndSave() {
                    this.errorMessage = '';

                    if (!window.cfTurnstileToken) {
                        this.errorMessage = 'Mohon selesaikan verifikasi captcha keamanan.';
                        return;
                    }

                    this.isSubmitting = true;

                    var formData = new FormData();
                    formData.append('name', this.lead.name);
                    formData.append('email', this.lead.email);
                    formData.append('whatsapp_number', this.lead.whatsapp);
                    formData.append('cf-turnstile-response', window.cfTurnstileToken);

                    var self = this;
                    this.questions.forEach(function (q) {
                        formData.append('answers[' + q.id + ']', q.answer || '');
                    });

                    fetch('{{ route('promo.test.grammar-practice.submit', $topic->id) }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    }).then(function (r) { return r.json(); }).then(function (data) {
                        if (data.success) {
                            window.location.href = '{{ url('/promo/test/grammar-practice/thank-you') }}/' + data.submission_id;
                        } else {
                            self.errorMessage = data.message || 'Terjadi kesalahan. Silakan periksa kembali data Anda.';
                            self.isSubmitting = false;
                        }
                    }).catch(function () {
                        self.errorMessage = 'Terjadi gangguan koneksi. Silakan coba lagi.';
                        self.isSubmitting = false;
                    });
                }
            };
        }
    </script>
</body>

</html>