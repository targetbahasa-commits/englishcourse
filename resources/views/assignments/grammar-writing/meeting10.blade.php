<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 10</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-4 sm:p-6 lg:p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar', ['programSidebarAlwaysVisible' => true])
    <div class="w-full max-w-[1920px] mx-auto flex flex-col min-h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="text-sm font-semibold text-indigo-600 tracking-wider uppercase">{{ ($displayMeetingNumber ?? 10) == 6 ? 'Fast-track Grammar for Writing' : 'Grammar for Writing' }}</span>
                <h1 class="text-2xl font-bold text-gray-800">{{ ($displayMeetingNumber ?? 10) == 6 ? 'Noun Phrase, Comparative, Superlative, & Positive Degree (Pertemuan 6)' : 'Noun Phrase, Comparative, Superlative, & Positive Degree (Pertemuan 10)' }}</h1>
            </div>
            <x-grammar-meeting-actions :meetingNumber="$displayMeetingNumber ?? 10" track="fast-track" />
        </div>

        @if($submitted)
            <div class="bg-indigo-600 text-white p-6 rounded-xl text-center mb-6 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-indigo-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ ($displayMeetingNumber ?? 10) == 6 ? parse_url(route('assignments.grammar-writing.meeting6.submit'), PHP_URL_PATH) : parse_url(route('assignments.grammar-writing.meeting10.submit'), PHP_URL_PATH) }}" id="meetingAnswerForm" x-data="{ mobileTab: 'soal' }">
            @csrf

            @if(!empty($cheatSheet['__html__']))
            <!-- Mobile View Switcher (< lg) -->
            <div class="flex lg:hidden mb-4 p-1.5 bg-white rounded-2xl border border-indigo-200 shadow-sm sticky top-3 z-30">
                <button type="button" @click="mobileTab = 'soal'"
                        :class="mobileTab === 'soal' ? 'bg-indigo-600 text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="flex-1 py-2.5 px-3 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition cursor-pointer">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Soal Latihan ({{ count($questions) }})</span>
                </button>
                <button type="button" @click="mobileTab = 'materi'"
                        :class="mobileTab === 'materi' ? 'bg-indigo-600 text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="flex-1 py-2.5 px-3 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition cursor-pointer">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Materi &amp; Rumus</span>
                </button>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-8">
                <!-- Left Column: Materi (Sticky on Desktop, Tab on Mobile) -->
                @if(!empty($cheatSheet['__html__']))
                <div id="materi-sticky-panel"
                     class="lg:col-span-5 lg:sticky lg:top-6 lg:self-start lg:max-h-[calc(100vh-2rem)] lg:overflow-y-auto pr-0 lg:pr-2"
                     :class="mobileTab === 'materi' ? 'block' : 'hidden lg:block'">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">
                        {!! $cheatSheet['__html__'] !!}
                    </div>
                </div>
                @endif

                <!-- Right Column: Exercise (Always on Desktop, Tab on Mobile) -->
                <div class="{{ !empty($cheatSheet['__html__']) ? 'lg:col-span-7' : 'lg:col-span-12' }}"
                     @if(!empty($cheatSheet['__html__'])) :class="mobileTab === 'soal' ? 'block' : 'hidden lg:block'" @endif>
                    <div class="bg-white rounded-3xl shadow-sm border border-indigo-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-indigo-100">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">A. Translate Kalimat</h3>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center justify-center rounded-full bg-indigo-600 text-white text-xs font-bold px-3 py-1.5 w-fit">
                                        {{ count($questions) }} Soal
                                    </span>
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <button type="button" @click="$dispatch('open-add-modal')" class="text-xs text-indigo-700 hover:text-indigo-900 underline font-semibold">+ Add Question</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($questions as $idx => $data)
                                    <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-indigo-200 space-y-3 overflow-visible">
                                        <div class="flex items-start gap-3 sm:gap-4">
                                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                {{ $loop->iteration }}
                                            </div>
                                            <div class="pt-1 flex-1">
                                                <p class="text-gray-800 leading-relaxed">{{ $data['id'] }}</p>
                                                <span class="inline-block mt-2 px-3 py-1 text-xs font-bold rounded-full
                                                    {{ $data['type'] == 'Superlative' ? 'bg-red-100 text-red-700' : ($data['type'] == 'Comparative' ? 'bg-blue-100 text-blue-700' : ($data['type'] == 'Positive' || $data['type'] == 'Positive Degree' ? 'bg-emerald-100 text-emerald-700' : 'bg-purple-100 text-purple-700')) }}">
                                                    {{ $data['type'] }}
                                                </span>
                                            </div>
                                            <div class="flex flex-row items-center gap-1 ml-2">
                                                @if(isset($data['example']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                            ?
                                                        </button>
                                                        <div x-show="open" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-1 text-yellow-300">Contoh ({{ $data['type'] }}):</strong>
                                                            {{ $data['example']['id'] }}<br>
                                                            <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @elseif(isset($examples[$data['type']]))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                            ?
                                                        </button>
                                                        <div x-show="open" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-1 text-yellow-300">Contoh ({{ $data['type'] }}):</strong>
                                                            {{ $examples[$data['type']]['id'] }}<br>
                                                            <em class="text-gray-300">{{ $examples[$data['type']]['en'] }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(isset($data['vocab']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                                            v
                                                        </button>
                                                        <div x-show="open" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                            <ul class="space-y-1">
                                                                @foreach($data['vocab'] as $en => $vocabData)
                                                                    <li class="flex justify-between gap-3">
                                                                        <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ $vocabData['pos'] }}</span></span>
                                                                        <span>{{ $vocabData['id'] }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(auth()->check() && auth()->user()->isAdmin())
                                                    <button type="button"
                                                            data-payload="{{ json_encode([
                                                                'id' => $data['db_id'],
                                                                'question_text' => $data['id'],
                                                                'correct_answer' => $data['en'],
                                                                'type' => $data['type'],
                                                                'example_id' => $data['example']['id'] ?? '',
                                                                'example_en' => $data['example']['en'] ?? '',
                                                                'vocab' => json_encode($data['vocab'] ?? [])
                                                            ]) }}"
                                                            onclick="openEditModal(this)"
                                                            class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm" title="Edit soal">
                                                        e
                                                    </button>
                                                    <button type="button"
                                                            onclick="confirmDelete('{{ $data['db_id'] }}')"
                                                            class="w-6 h-6 rounded-md bg-red-50 border border-red-200 text-red-600 flex items-center justify-center text-xs font-bold hover:bg-red-100 transition-colors focus:outline-none shadow-sm" title="Hapus">
                                                        x
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ml-11 sm:ml-13">
                                            <textarea rows="1"
                                                   name="userAnswers[{{ $idx }}]"
                                                   style="field-sizing: content;"
                                                   class="auto-expand-answer resize-none overflow-hidden w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   {{ $submitted ? 'readonly' : '' }}
                                                   autocomplete="off">{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}</textarea>

                                            @if($submitted)
                                                @if($results[$idx]['score'] == 10)
                                                    <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                                        ✓ Sempurna! (10/10)
                                                    </div>
                                                @else
                                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                                        <strong>Nilai: {{ $results[$idx]['score'] }}/10</strong><br>
                                                        Koreksi: {!! $results[$idx]['formatted_answer'] !!}<br>
                                                        <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <!-- Section B: Paragraph -->
                    <div class="bg-white rounded-3xl shadow-sm border border-indigo-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-indigo-100">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">B. Translate Paragraf</h3>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <div class="flex gap-2 shrink-0">
                                        <button type="button"
                                            onclick="openMeeting10ParagraphEditModal(
                                                {{ $paragraph['db_id'] ?? 0 }},
                                                '{{ addslashes($paragraph['id'] ?? '') }}',
                                                '{{ addslashes($paragraph['en'] ?? '') }}'
                                            )"
                                            class="text-xs text-indigo-700 hover:text-indigo-900 underline font-semibold">Edit</button>
                                        @if(isset($paragraph['db_id']))
                                            <button type="button"
                                                    onclick="confirmDelete('{{ $paragraph['db_id'] }}')"
                                                    class="text-xs text-red-600 hover:text-red-800 underline font-semibold">Hapus</button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4">
                            <p class="text-gray-700 leading-relaxed">{{ $fullParagraphId }}</p>

                            <div x-data="{ showVocab: false }">
                                <button type="button" @click="showVocab = !showVocab" class="w-full px-4 py-3 bg-yellow-50 border border-yellow-200 hover:bg-yellow-100 text-yellow-800 font-bold rounded-lg transition-colors flex items-center justify-between text-sm">
                                    <span>📚 Vocabulary Bantuan</span>
                                    <svg :class="showVocab ? 'rotate-180' : ''" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="showVocab" x-transition style="display:none;" class="mt-3 bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @foreach($paragraphVocab as $en => $data)
                                            <span class="bg-white px-3 py-1.5 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                                <strong class="text-indigo-600">{{ $en }}</strong>:
                                                @if(is_array($data))
                                                    {{ $data['id'] }} <span class="text-gray-400 text-[10px]">{{ $data['pos'] ?? '' }}</span>
                                                @else
                                                    {{ $data }}
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                                <textarea
                                    name="userParagraphAnswer"
                                    rows="10"
                                    style="field-sizing: content;"
                                    class="auto-expand-answer resize-none overflow-hidden w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    placeholder="Tulis terjemahan paragraf di sini..."
                                    {{ $submitted ? 'readonly' : '' }}>{{ old('userParagraphAnswer', $userParagraphAnswer) }}</textarea>
                            </div>

                            @if($submitted)
                                <div>
                                    @if($paragraphResult['score'] >= $paragraphResult['max_score'] * 0.8)
                                        <div class="text-sm font-bold text-green-600 bg-green-50 p-3 rounded border border-green-100 mb-2">
                                            ✓ Luar Biasa! Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}
                                        </div>
                                    @else
                                        <div class="text-sm font-bold text-red-600 bg-red-50 p-3 rounded border border-red-100 mb-2">
                                            Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}
                                        </div>
                                    @endif

                                    <div class="bg-gray-50 p-4 rounded border border-gray-200 text-sm leading-relaxed">
                                        <strong class="block mb-2 text-gray-700">Analisis Perbedaan:</strong>
                                        <div class="prose max-w-none">
                                            {!! $paragraphResult['formatted_answer'] !!}
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <strong class="block mb-1 text-gray-700">Jawaban Lengkap:</strong>
                                        <p class="text-gray-600 italic">{{ $fullParagraphEn }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        @if(!$submitted)
                            <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-md">
                                Cek Jawaban
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if($submitted)
            <form method="POST" action="{{ ($displayMeetingNumber ?? 10) == 6 ? parse_url(route('assignments.grammar-writing.meeting6.reset'), PHP_URL_PATH) : parse_url(route('assignments.grammar-writing.meeting10.reset'), PHP_URL_PATH) }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gray-500 text-white rounded-xl font-bold hover:bg-gray-600 transition-colors shadow-md">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>

    <style>
        .word-correct { color: #10b981; }
        .word-wrong { color: #ef4444; text-decoration: line-through; }
        .word-missing { color: #3b82f6; font-weight: bold; }
        .word-extra { color: #f59e0b; text-decoration: line-through; }

        /* lg:top-6, lg:max-h-[calc(100vh-2rem)] and lg:self-start aren't in the
           compiled Tailwind bundle on this deploy (the utility combo was never
           used elsewhere, so it was never generated) - lg:sticky and
           lg:overflow-y-auto DO exist and work, but without a top offset or a
           max-height, sticky has nothing to stick to and overflow-y has no
           constrained height to scroll within, so the left panel just grows to
           full content height instead of staying pinned with its own scrollbar.
           Plain CSS here matches Tailwind's own lg breakpoint (min-width: 1024px)
           exactly, so it stays in sync with the lg:sticky / lg:block toggling
           that already works. */
        @media (min-width: 1024px) {
            #materi-sticky-panel {
                top: 1.5rem;
                align-self: start;
                max-height: calc(100vh - 2rem);
            }
        }
    </style>

    <!-- Auto-Save Script -->

    <!-- INLINE AUTO-SAVE SCRIPT -->
    <script>
    /**
     * Auto-Save Module for Grammar Writing Assignments
     * Automatically saves student progress to localStorage
     * Supports multiple input naming patterns across different meetings
     */
    const AutoSave = {
        debounceTimer: null,
        debounceDelay: 500, // milliseconds
        userId: null,
        draftSyncTimer: null,

        /**
         * Initialize auto-save for a specific meeting
         * @param {string} meetingNumber - Meeting number (e.g., '1', '2', '10')
         * @param {number} userId - Current user ID
         */
        init(meetingNumber, userId = null) {
            console.log('=== AUTO-SAVE INITIALIZATION START ===');
            console.log('Meeting Number:', meetingNumber);
            console.log('User ID:', userId);
            
            this.meetingNumber = meetingNumber;
            this.userId = userId || window.userId || 'guest';
            this.storageKey = `grammar_writing_meeting${meetingNumber}_user_${this.userId}`;
            
            console.log('Storage Key:', this.storageKey);
            console.log('LocalStorage available:', typeof localStorage !== 'undefined');

            // Check if form was submitted
            this.isSubmitted = this.checkIfSubmitted();
            console.log('Form submitted:', this.isSubmitted);

            if (this.isSubmitted) {
                // Clear localStorage after submission
                this.clearSaved();
                console.log('LocalStorage cleared after submission');
                console.log('=== AUTO-SAVE INITIALIZATION END (SUBMITTED) ===');
                return;
            }

            // Restore saved data on page load
            console.log('Attempting to restore answers...');
            this.restoreAnswers();

            // Set up auto-save listeners
            console.log('Setting up auto-save listeners...');
            this.setupAutoSave();

            console.log(`✓ Auto-save initialized successfully for meeting ${meetingNumber}`);
            console.log('=== AUTO-SAVE INITIALIZATION END ===');
        },

        /**
         * Check if form has been submitted
         */
        checkIfSubmitted() {
            // Check if inputs are readonly (server renders them readonly when submitted)
            // We strictly check for readonly attribute on text inputs to avoid false positives
            const isReadonly = document.querySelector('#meetingAnswerForm input[type="text"][readonly], #meetingAnswerForm textarea[readonly]');
            
            return !!isReadonly;
        },

        /**
         * Set up auto-save listeners on all input fields
         */
        setupAutoSave() {
            // Find all input and textarea elements in the form
            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
                console.log('No form found for auto-save');
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            console.log(`Found ${inputs.length} input fields`);

            inputs.forEach(input => {
                // Skip if readonly (already submitted)
                if (input.readOnly || input.disabled) {
                    return;
                }

                // Save immediately on every keystroke (input event)
                input.addEventListener('input', () => {
                    this.saveAnswers();
                });

                // Also save on blur (when moving to next field)
                input.addEventListener('blur', () => {
                    this.saveAnswers();
                });

                // Save on keyup as backup
                input.addEventListener('keyup', () => {
                    this.saveAnswers();
                });
            });

            // Flush pending drafts immediately on tab close, hide, or app switch
            const flushSync = () => {
                const form = document.getElementById('meetingAnswerForm');
                if (form) {
                    clearTimeout(this.draftSyncTimer);
                    this.syncDraftToServer(form);
                }
            };

            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'hidden') {
                    flushSync();
                }
            });

            window.addEventListener('beforeunload', flushSync);
            window.addEventListener('pagehide', flushSync);

            // Auto re-sync when network connection is restored
            window.addEventListener('online', () => {
                console.log('Internet reconnected. Re-syncing draft to server...');
                const form = document.getElementById('meetingAnswerForm');
                if (form) {
                    this.saveAnswers();
                }
            });

            // Session keep-alive heartbeat every 10 minutes to prevent CSRF / session expiration (419)
            setInterval(() => {
                if (!this.isSubmitted) {
                    fetch(window.location.href, { method: 'HEAD', cache: 'no-store' }).catch(() => {});
                }
            }, 10 * 60 * 1000);

            console.log(`Auto-save listeners attached to ${inputs.length} fields`);
        },

        /**
         * Save all answers to localStorage
         */
        saveAnswers() {
            if (this.isSubmitted) {
                console.log('Skipping save - form already submitted');
                return;
            }

            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
                console.log('No form found');
                return;
            }

            // Read existing localStorage data to prevent accidental blank overwrites (multi-tab protection)
            let existingAnswers = {};
            try {
                const stored = localStorage.getItem(this.storageKey);
                if (stored) {
                    existingAnswers = JSON.parse(stored) || {};
                }
            } catch (e) {}

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};

            inputs.forEach(input => {
                if (input.name) {
                    if (input.value && input.value.trim() !== '') {
                        answers[input.name] = input.value;
                    } else if (existingAnswers[input.name] && document.activeElement !== input) {
                        // Preserve previous answer if this field wasn't actively cleared by user
                        answers[input.name] = existingAnswers[input.name];
                    }
                }
            });

            try {
                localStorage.setItem(this.storageKey, JSON.stringify(answers));
                this.showSaveIndicator();
                this.queueDraftSync(form);
            } catch (e) {
                console.error('Failed to save to localStorage:', e);
            }
        },

        queueDraftSync(form) {
            clearTimeout(this.draftSyncTimer);
            this.draftSyncTimer = setTimeout(() => {
                this.syncDraftToServer(form);
            }, this.debounceDelay);
        },

        async syncDraftToServer(form) {
            if (!form) {
                return false;
            }

            const action = form.getAttribute('action') || '';
            const isFastTrack = action.includes('/fast-track/');
            const match = action.match(/meeting(\d+)/);
            if (!match) {
                return false;
            }

            const meetingNumber = match[1];
            const draftEndpoint = isFastTrack
                ? '/assignments/grammar-writing/fast-track/meeting' + meetingNumber + '/draft'
                : '/assignments/grammar-writing/meeting' + meetingNumber + '/draft';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const payload = {};
            const assignNestedValue = (obj, key, value) => {
                const parts = String(key).replace(/\]/g, '').split('[');
                let ref = obj;

                for (let i = 0; i < parts.length; i++) {
                    const part = parts[i];
                    const isLast = i === parts.length - 1;

                    if (isLast) {
                        ref[part] = value;
                        return;
                    }

                    if (typeof ref[part] !== 'object' || ref[part] === null) {
                        ref[part] = {};
                    }

                    ref = ref[part];
                }
            };

            new FormData(form).forEach((value, key) => {
                if (key === '_token') {
                    return;
                }

                assignNestedValue(payload, key, value);
            });

            try {
                const res = await fetch(draftEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                    keepalive: true,
                });

                if (!res.ok) {
                    if (res.status === 419) {
                        console.warn('Session expired (HTTP 419). Answers safely kept in localStorage.');
                    }
                    return false;
                }
                return true;
            } catch (e) {
                console.error('Failed to sync draft to server:', e);
                return false;
            }
        },

        /**
         * Restore saved answers from localStorage
         */
        restoreAnswers() {
            try {
                let savedData = localStorage.getItem(this.storageKey);
                if (!savedData && this.userId) {
                    savedData = localStorage.getItem(`grammar_writing_meeting10_user_${this.userId}`)
                        || localStorage.getItem(`grammar_writing_meeting6_user_${this.userId}`)
                        || localStorage.getItem(`grammar_writing_meeting_10_user_${this.userId}`)
                        || localStorage.getItem(`grammar_writing_meeting_6_user_${this.userId}`);
                }
                
                if (!savedData) {
                    console.log('No saved data to restore');
                    return;
                }

                const answers = JSON.parse(savedData);
                let restoredCount = 0;

                Object.keys(answers).forEach(name => {
                    let input = document.querySelector(`input[name="${name}"], textarea[name="${name}"]`);
                    if (!input) {
                        input = document.querySelector(`input[name="userAnswers[${name}]"], textarea[name="userAnswers[${name}]"]`);
                    }
                    
                    if (input && !input.value && !input.readOnly) {
                        input.value = answers[name];
                        restoredCount++;
                    }
                });

                if (restoredCount > 0) {
                    console.log(`✓ Restored ${restoredCount} saved answers from localStorage`);
                    this.showRestoreIndicator(restoredCount);

                    // Sync restored answers to server immediately
                    const form = document.getElementById('meetingAnswerForm');
                    if (form) {
                        this.queueDraftSync(form);
                    }
                }
            } catch (e) {
                console.error('Failed to restore from localStorage:', e);
            }
        },

        /**
         * Show a brief restore indicator
         */
        showRestoreIndicator(count) {
            const indicator = document.createElement('div');
            indicator.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
            indicator.innerHTML = `✓ ${count} jawaban dipulihkan`;
            document.body.appendChild(indicator);

            setTimeout(() => {
                indicator.style.opacity = '0';
                indicator.style.transition = 'opacity 0.3s';
                setTimeout(() => indicator.remove(), 300);
            }, 3000);
        },

        /**
         * Show a brief save indicator
         */
        showSaveIndicator() {
            // Check if indicator already exists
            let indicator = document.getElementById('auto-save-indicator');

            if (!indicator) {
                indicator = document.createElement('div');
                indicator.id = 'auto-save-indicator';
                indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                indicator.style.transition = 'opacity 0.3s';
                indicator.innerHTML = '✓ Tersimpan otomatis';
                document.body.appendChild(indicator);
            }

            // Show indicator with animation
            indicator.style.opacity = '1';
            indicator.style.backgroundColor = '#10b981'; // green
            
            // Update text to show it's actively saving
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            indicator.innerHTML = `✓ Tersimpan ${timeStr}`;

            // Keep visible for 3 seconds
            clearTimeout(this.saveIndicatorTimeout);
            this.saveIndicatorTimeout = setTimeout(() => {
                indicator.style.opacity = '0.7'; // Semi-transparent when idle
            }, 3000);
        },

        /**
         * Clear saved data for this meeting
         */
        clearSaved() {
            try {
                localStorage.removeItem(this.storageKey);
                console.log('Cleared saved data');
            } catch (e) {
                console.error('Failed to clear localStorage:', e);
            }
        }
    };

    // Make AutoSave available globally
    window.AutoSave = AutoSave;
    AutoSave.showSaveErrorIndicator = function () {
        const indicator = document.createElement('div');
        indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
        indicator.style.transition = 'opacity 0.3s';
        indicator.innerHTML = '✗ Gagal menyimpan, coba lagi';
        document.body.appendChild(indicator);
        setTimeout(() => {
            indicator.style.opacity = '0';
            setTimeout(() => indicator.remove(), 300);
        }, 3000);
    };

    AutoSave.manualSave = async function () {
        const form = document.getElementById('meetingAnswerForm');
        if (!form) {
            return;
        }

        const btn = document.getElementById('manual-save-btn');
        if (btn) {
            btn.dataset.originalText = btn.dataset.originalText || btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';
        }

        try {
            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};
            inputs.forEach((input) => {
                if (input.name && input.value) {
                    answers[input.name] = input.value;
                }
            });
            localStorage.setItem(this.storageKey, JSON.stringify(answers));
        } catch (e) {
            console.error('[ManualSave] Failed to update localStorage:', e);
        }

        const ok = await this.syncDraftToServer(form);

        if (btn) {
            btn.disabled = false;
            btn.innerHTML = btn.dataset.originalText;
        }

        if (ok) {
            this.showSaveIndicator();
        } else {
            this.showSaveErrorIndicator();
        }
    };


    // Initialize auto-save for meeting
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('{{ $displayMeetingNumber ?? 10 }}', userId);
        }
    });
    </script>

    <!-- Add Question Modal -->
    <div x-data="{ open: false }" 
         @open-add-modal.window="open = true" 
         class="relative z-500" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true"
         style="display: none;"
         x-show="open">
        
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="meeting_number" value="10">
                        <!-- Use max ID + 1 logic or just auto-increment if DB handles it. DB has question_number, we should probably let user input it or auto-calc? 
                             Generic store controller doesn't seem to calculate question_number. I'll add a field for it or hidden.
                             Wait, storeGrammarQuestion validates question_number required.
                             I'll add a field for it, defaulting to next number if possible, or just user input.
                        -->
                        <input type="hidden" name="question_number" value="{{ count($questions) + 1 }}">

                        <h3 class="text-xl font-bold text-gray-900 mb-6">Add New Question</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Type / Structure</label>
                            <select name="structure" class="w-full p-2 border rounded" required>
                                <option value="Superlative">Superlative</option>
                                <option value="Comparative">Comparative</option>
                                <option value="Positive">Positive Degree</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Question (Indonesian)</label>
                            <textarea name="question_text" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Answer (English)</label>
                            <textarea name="correct_answer" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Example ID</label>
                                <input type="text" name="example_id" class="w-full p-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Example EN</label>
                                <input type="text" name="example_en" class="w-full p-2 border rounded">
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 rounded text-white hover:bg-indigo-700">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Question Modal -->
    <div x-data="{ open: false, data: {} }" 
         @open-meeting10-edit-modal.window="open = true; data = $event.detail" 
         class="relative z-500" 
         style="display: none;"
         x-show="open">
        
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form :action="'/admin/assignments/grammar-writing/questions/' + data.id" method="POST" class="p-6">
                        @csrf
                        @method('PUT')
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Edit Question</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Type / Structure</label>
                            <select name="structure" x-model="data.type" class="w-full p-2 border rounded" required>
                                <option value="Superlative">Superlative</option>
                                <option value="Comparative">Comparative</option>
                                <option value="Positive">Positive Degree</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Question (Indonesian)</label>
                            <textarea name="question_text" x-model="data.question_text" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Answer (English)</label>
                            <textarea name="correct_answer" x-model="data.correct_answer" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Example ID</label>
                                <input type="text" name="example_id" x-model="data.example_id" class="w-full p-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Example EN</label>
                                <input type="text" name="example_en" x-model="data.example_en" class="w-full p-2 border rounded">
                            </div>
                        </div>

                        <!-- Full Vocab JSON Edit (Advanced) -->
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Vocab JSON (Advanced)</label>
                            <textarea name="vocab" x-model="data.vocab" rows="3" class="w-full p-2 border rounded font-mono text-xs"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: {"Word": {"id": "Translation", "pos": "(v)"}}</p>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 rounded text-white hover:bg-indigo-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="delete-question-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this content?')) {
                const form = document.getElementById('delete-question-form');
                form.action = `/admin/assignments/grammar-writing/questions/${id}`;
                form.submit();
            }
        }

        function openEditModal(el) {
            try {
                const data = JSON.parse(el.dataset.payload);
                window.dispatchEvent(new CustomEvent('open-meeting10-edit-modal', { detail: data }));
            } catch (e) {
                console.error('Error parsing edit data', e);
                alert('Error opening edit modal. See console.');
            }
        }

        window.openMeeting10ParagraphEditModal = function(id, question, answer) {
            window.dispatchEvent(new CustomEvent('open-paragraph-edit-modal', { 
                detail: { id, question, answer } 
            }));
        };
    </script>
    
    <!-- Paragraph Edit Modal -->
    <div x-data="{ 
            isOpen: false,
            pId: null, pText: '', pAns: ''
         }"
         @open-paragraph-edit-modal.window="
            isOpen = true;
            pId = $event.detail.id;
            pText = $event.detail.question;
            pAns = $event.detail.answer;
         "
         x-show="isOpen" 
         x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 p-4"
    >
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6" @click.outside="isOpen = false">
            <form :action="'/admin/assignments/grammar-writing/questions/' + pId" method="POST">
                @csrf
                @method('PUT')
                
                <h3 class="text-lg font-bold mb-4">Edit Paragraph</h3>
                
                <input type="hidden" name="meeting_number" value="10">
                <input type="hidden" name="section" value="paragraph">
                
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Paragraph (Indonesian)</label>
                    <textarea name="question_text" x-model="pText" class="w-full border rounded p-2" rows="8" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Translation (English)</label>
                    <textarea name="correct_answer" x-model="pAns" class="w-full border rounded p-2" rows="8" required></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="isOpen = false" class="px-4 py-2 text-gray-600">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>


    <x-live-drawing />
    @include('components.student-broadcaster')

    {{-- Consolidated Floating Helper Buttons (hidden during admin Live
         Preview - these are student-only interactive tools, not relevant
         to the admin's read-only observation view) --}}
    @if(!request()->filled('live_preview_for'))
    <div class="fixed bottom-4 right-8 z-50 flex flex-col gap-2 items-end">
        <x-dictionary-button />
        <x-conjunction-button />
        <x-preposition-button />
        <x-pronouns-button />
        <x-verb-patterns-button />
        <x-modal-button />
        <x-tenses-button />
        <x-irregular-verbs-button />
    </div>
    @endif

    @if(!$submitted)
        <div class="fixed bottom-4 z-50" style="left: 50%; transform: translateX(-50%);">
            <button type="button" id="manual-save-btn" onclick="AutoSave.manualSave()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-sm font-semibold shadow-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3M8 7h8"></path></svg>
                Save
            </button>
        </div>
    @endif

</body>
</html>