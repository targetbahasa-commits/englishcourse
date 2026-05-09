@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 pb-32" x-data="{ 
    currentView: 'section1', 
    currentSection: 'instructions', 
    currentPageIndex: 0,
    currentStructureIndex: 0,
    currentReadingSection: 'instructions',
    currentReadingPassageIndex: 0,
    showWrittenDir: false,
    activeDirectionTab: 'structure',
    submitListeningSection() {
        // Jika mode Mock Up penuh, tidak perlu submit parsial. Simpan sementara di DOM dan lanjut ke sesi 2.
        const isFullMockTest = {{ ($isFullMockTest ?? false) ? 'true' : 'false' }};
        if (isFullMockTest) {
            this.currentView = 'section2';
            this.currentSection = 'instructions';
            window.scrollTo(0,0);
            return;
        }

        const form = document.querySelector('#listeningForm');
        let formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                this.currentView = 'section2';
                this.currentSection = 'instructions';
                window.scrollTo(0,0);
            } else {
                alert('Terdapat kesalahan saat menyimpan jawaban.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menyambung ke server.');
        });
    },
    submitFullMockup() {
        // Konfigurasi route target berdasar mode Mockup (Full vs Partial)
        const isFullMockTest = {{ ($isFullMockTest ?? false) ? 'true' : 'false' }};
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = isFullMockTest 
                      ? '{{ route("assignments.toefl-itp.mockup.submit", ["package" => $packageNumber ?? 1]) }}'
                      : '{{ $listeningSubmitRoute ?? "" }}';
        
        // Token CSRF
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        // Ekstrak ID dan Jawaban dari format name: question_12, structure_34, written_56
        document.querySelectorAll('input[type=radio]:checked').forEach(r => {
            const parts = r.name.split('_');
            if (parts.length >= 2) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `answers[${parts[parts.length - 1]}]`;
                input.value = r.value;
                form.appendChild(input);
            }
        });
        
        document.body.appendChild(form);
        form.submit();
    },
    countdown: 12,
    timer: null,
    structureCountdown: 1500, // 25 minutes
    structureTimer: null,
    startTimer() {
        if(this.timer) clearInterval(this.timer);
        this.countdown = 12;
        this.timer = setInterval(() => {
            if(this.countdown > 0) {
                this.countdown--;
            } else {
                clearInterval(this.timer);
            }
        }, 1000);
    },
    startStructureTimer() {
        if (this.structureTimer) return; // already started
        this.structureTimer = setInterval(() => {
            if (this.structureCountdown > 0) {
                this.structureCountdown--;
            } else {
                clearInterval(this.structureTimer);
            }
        }, 1000);
    },
    formatStructureTime() {
        const m = Math.floor(this.structureCountdown / 60).toString().padStart(2, '0');
        const s = (this.structureCountdown % 60).toString().padStart(2, '0');
        return `${m}:${s}`;
    },
    goToReadingPassage(index) {
        const maxIndex = Math.max({{ max(((isset($readingPassages) ? count($readingPassages) : 1) - 1), 0) }}, 0);
        this.currentReadingSection = 'questions';
        this.currentReadingPassageIndex = Math.min(Math.max(index, 0), maxIndex);
        window.scrollTo(0,0);
        this.$nextTick(() => {
            document.querySelectorAll('[data-reading-scroll]').forEach((panel) => {
                panel.scrollTop = 0;
            });
        });
    }
}" x-init="
    startTimer(); 
    $watch('currentPageIndex', value => startTimer());
    $watch('currentView', value => { if(value === 'section2' && currentSection === 'questions') startStructureTimer() });
    $watch('currentSection', value => { if(currentView === 'section2' && value === 'questions') startStructureTimer() });
">
    <style>
        body {
            background-color: white !important;
        }
        .instruction-box {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
            border-left: 6px solid #f59e0b;
        }
        .part-header {
            color: #0f766e;
            font-weight: 700;
        }
        .listening-answer-sheet .divide-y > .group {
            padding-top: 0.125rem;
            padding-bottom: 0.125rem;
        }
        .listening-answer-sheet .group .mb-2.text-sm {
            font-size: 1.05rem;
            line-height: 1.35;
            margin-bottom: 0.2rem;
        }
        .listening-answer-sheet .group .space-y-2 > :not([hidden]) ~ :not([hidden]) {
            margin-top: 0.2rem;
        }
        .listening-answer-sheet .group .space-y-2 .p-2 {
            padding: 0.4rem 0.62rem;
        }
        .listening-answer-sheet .group .space-y-2 span.text-sm {
            font-size: 1.08rem;
            line-height: 1.32;
        }
        .listening-answer-sheet .bg-white.rounded-lg.border.border-gray-200.shadow-sm.p-4 {
            padding: 0.7rem;
        }
        .listening-answer-sheet .grid.grid-cols-1.md\:grid-cols-2.gap-4.md\:gap-6 {
            gap: 0.5rem;
        }
        .listening-answer-sheet .listening-option-card {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            min-height: 3.35rem;
            transition: border-color 0.16s ease, background-color 0.16s ease, box-shadow 0.16s ease, transform 0.12s ease;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card {
            transform: translateY(-1px);
            box-shadow: 0 3px 12px rgba(220, 38, 38, 0.16);
        }
        .listening-answer-sheet .listening-option-card::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 2.1rem;
            width: 6px;
            height: 6px;
            border-radius: 9999px;
            background: rgba(220, 38, 38, 0.22);
            transform: translate(-50%, -50%) scale(0);
            pointer-events: none;
            opacity: 0;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card::after {
            animation: listeningOptionRipple 0.34s ease-out;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card span.text-sm {
            color: #b91c1c;
        }
        .listening-answer-sheet .listening-option-badge {
            width: 2.32rem;
            height: 2.32rem;
            transform-origin: center;
            will-change: transform, box-shadow;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge {
            border-color: #dc2626;
            background-color: #dc2626;
            color: #ffffff;
            animation: listeningBadgePop 0.18s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge span {
            color: #ffffff;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card {
            border-color: #e02424;
            background-color: #fff7f7;
            box-shadow: 0 0 0 1px rgba(224, 36, 36, 0.36), 0 3px 12px rgba(224, 36, 36, 0.14);
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card span.text-sm {
            font-weight: 700;
            letter-spacing: 0.005em;
        }
        .listening-answer-sheet .listening-option-card .mr-3 {
            margin-right: 0.78rem;
        }
        .listening-answer-sheet .listening-option-card span.text-sm {
            padding-left: 0.1rem;
        }
        @keyframes listeningBadgePop {
            0% {
                transform: scale(0.82);
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.45);
            }
            65% {
                transform: scale(1.1);
                box-shadow: 0 0 0 8px rgba(220, 38, 38, 0.12);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
            }
        }
        @keyframes listeningOptionRipple {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 0.5;
            }
            100% {
                transform: translate(-50%, -50%) scale(42);
                opacity: 0;
            }
        }
        @media (max-width: 768px) {
            .listening-answer-sheet .group .space-y-2 .p-2 {
                padding: 0.32rem 0.5rem;
            }
            .listening-answer-sheet .group .space-y-2 span.text-sm {
                font-size: 1rem;
                line-height: 1.28;
            }
            .listening-answer-sheet .listening-option-card {
                min-height: 3rem;
            }
            .listening-answer-sheet .listening-option-badge {
                width: 2.05rem;
                height: 2.05rem;
            }
            .listening-answer-sheet .listening-option-card .mr-3 {
                margin-right: 0.58rem;
            }
            .listening-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge {
                animation-duration: 0.14s;
            }
            .listening-answer-sheet input[type="radio"]:checked + .listening-option-card::after {
                animation-duration: 0.24s;
            }
            .listening-answer-sheet .listening-option-card {
                transition-duration: 0.11s;
            }
        }
        @media (min-width: 769px) and (max-width: 1199px) {
            .listening-answer-sheet .group .space-y-2 .p-2 {
                padding: 0.36rem 0.58rem;
            }
            .listening-answer-sheet .group .space-y-2 span.text-sm {
                font-size: 1.04rem;
                line-height: 1.3;
            }
            .listening-answer-sheet .listening-option-card {
                min-height: 3.22rem;
            }
            .listening-answer-sheet .listening-option-badge {
                width: 2.2rem;
                height: 2.2rem;
            }
            .listening-answer-sheet .listening-option-card .mr-3 {
                margin-right: 0.68rem;
            }
        }
        @media (min-width: 1200px) {
            .listening-answer-sheet .group .space-y-2 span.text-sm {
                font-size: 1.12rem;
            }
            .listening-answer-sheet .listening-option-card {
                min-height: 3.45rem;
            }
            .listening-answer-sheet .listening-option-badge {
                width: 2.38rem;
                height: 2.38rem;
            }
        }
        .listening-option-ellipse {
            width: 26px;
            height: 18px;
            border: 2px solid #333;
            border-radius: 50%;
            display: inline-block;
            margin-right: 12px;
            flex-shrink: 0;
            transition: all 0.2s;
            position: relative;
        }

        input[type="radio"]:checked + div .listening-option-ellipse {
            background-color: #111;
            border-color: #111;
        }

        /* Paginated question option styles */
        .mockup-option-label input[type="radio"]:checked ~ .mockup-option-card {
            border-color: #ef4444;
            background-color: #fef2f2;
        }
        .mockup-option-label input[type="radio"]:checked ~ .mockup-option-card .mockup-option-badge {
            background-color: #dc2626;
            border-color: #dc2626;
            color: #ffffff;
        }
        .mockup-option-label input[type="radio"]:checked ~ .mockup-option-card .mockup-option-text {
            color: #b91c1c;
            font-weight: 700;
        }
        .mockup-option-label:hover .mockup-option-card {
            border-color: #d1d5db;
            background-color: #f9fafb;
        }
        .mockup-option-badge {
            transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }
        .mockup-option-card {
            transition: border-color 0.15s ease, background-color 0.15s ease;
        }
    </style>



    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    @if(($packageMode ?? false) && session('listeningPackageReview'))
        @php
            $review = session('listeningPackageReview');
        @endphp
        <div class="mb-6 rounded-2xl border border-blue-200 bg-white shadow-sm overflow-hidden" x-data="{ reviewFilter: 'all' }">
            <div class="px-5 py-4 bg-blue-50 border-b border-blue-100">
                <h3 class="text-lg font-bold text-blue-900">Review Jawaban Paket {{ $packageNumber ?? 1 }}</h3>
                <p class="text-sm text-blue-800 mt-1">Skor {{ $review['score'] }} - Benar {{ $review['correct'] }}/{{ $review['total'] }}</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <button type="button" @click="reviewFilter = 'all'" :class="reviewFilter === 'all' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-blue-700 border-blue-200'" class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition">
                        Semua
                    </button>
                    <button type="button" @click="reviewFilter = 'wrong'" :class="reviewFilter === 'wrong' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-red-700 border-red-200'" class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition">
                        Salah
                    </button>
                    <button type="button" @click="reviewFilter = 'unanswered'" :class="reviewFilter === 'unanswered' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-amber-700 border-amber-200'" class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition">
                        Kosong
                    </button>
                </div>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-2">
                    @foreach(($review['rows'] ?? []) as $row)
                        @php
                            $statusClass = $row['is_correct']
                                ? 'bg-emerald-50 border-emerald-200 text-emerald-800'
                                : ($row['is_unanswered'] ? 'bg-amber-50 border-amber-200 text-amber-800' : 'bg-red-50 border-red-200 text-red-800');
                            $statusText = $row['is_correct'] ? 'Benar' : ($row['is_unanswered'] ? 'Kosong' : 'Salah');
                        @endphp
                        <div x-show="reviewFilter === 'all' || (reviewFilter === 'wrong' && {{ $row['is_correct'] ? 'false' : ($row['is_unanswered'] ? 'false' : 'true') }}) || (reviewFilter === 'unanswered' && {{ $row['is_unanswered'] ? 'true' : 'false' }})" class="rounded-lg border px-3 py-2 text-sm {{ $statusClass }}">
                            <div class="font-bold">{{ $row['question_number'] }} ({{ $row['part'] }})</div>
                            <div>Jawaban: {{ $row['user_answer'] }}</div>
                            <div>Kunci: {{ $row['correct_answer'] }}</div>
                            <div class="font-semibold mt-1">{{ $statusText }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ ($packageMode ?? false) ? ('Listening Practice - Paket ' . $packageNumber) : 'TOEFL ITP Mock Up Test' }}</h1>
                    <p class="text-gray-600 mt-1">Section 1: Listening Comprehension</p>
                </div>
            </div>
            
            <a href="{{ ($isFullMockTest ?? false) ? route('assignments.toefl-itp.mockup') : (($packageMode ?? false) ? route('assignments.toefl-itp.listening.practice') : route('assignments.toefl-itp')) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ ($isFullMockTest ?? false) ? 'Back to Mock Test Selection' : (($packageMode ?? false) ? 'Back to Listening Practice' : 'Back to TOEFL ITP') }}
            </a>
        </div>
    </div>

    @php
        $listeningPages = [];
        $globalIndex = 0;
        $listeningPages[] = ['type' => 'instruction_main', 'part' => 'A', 'index' => $globalIndex++];
        foreach(($listeningPartA ?? collect()) as $q) {
            $listeningPages[] = ['type' => 'question', 'part' => 'A', 'index' => $globalIndex++, 'data' => $q];
        }
        if (($listeningPartB ?? collect())->count() > 0) {
            $listeningPages[] = ['type' => 'instruction_b', 'part' => 'B', 'index' => $globalIndex++];
            foreach($listeningPartB as $q) {
                $listeningPages[] = ['type' => 'question', 'part' => 'B', 'index' => $globalIndex++, 'data' => $q];
            }
        }
        if (($listeningPartC ?? collect())->count() > 0) {
            $listeningPages[] = ['type' => 'instruction_c', 'part' => 'C', 'index' => $globalIndex++];
            foreach($listeningPartC as $q) {
                $listeningPages[] = ['type' => 'question', 'part' => 'C', 'index' => $globalIndex++, 'data' => $q];
            }
        }
        $totalListeningPages = count($listeningPages);
    @endphp

    @if(auth()->check() && auth()->user()->isAdmin())
    {{-- Admin Dev Toolbar --}}
    <div class="mb-6 rounded-xl border border-amber-300 bg-amber-50 p-3" x-data="{ devOpen: true }">
        <div class="flex items-center gap-2 mb-2 cursor-pointer select-none" @click="devOpen = !devOpen">
            <span class="text-xs font-bold text-amber-700 uppercase tracking-widest">🛠 Dev Nav</span>
            <span class="ml-auto text-amber-500 text-xs" x-text="devOpen ? '▲ hide' : '▼ show'"></span>
        </div>
        <div x-show="devOpen" class="space-y-3">
            {{-- Section switcher --}}
            <div class="flex flex-wrap gap-2 items-center">
                <span class="text-xs font-semibold text-amber-700 w-20 flex-shrink-0">Section:</span>
                <button type="button" @click="currentView = 'section1'; currentPageIndex = 0; startTimer()"
                    :class="currentView === 'section1' ? 'bg-red-600 text-white' : 'bg-white text-red-700 border-red-300'"
                    class="px-3 py-1 text-xs font-bold rounded-lg border transition">
                    1 · Listening
                </button>
                <button type="button" @click="currentView = 'section2'; currentSection = 'instructions'; currentStructureIndex = 0"
                    :class="currentView === 'section2' ? 'bg-indigo-600 text-white' : 'bg-white text-indigo-700 border-indigo-300'"
                    class="px-3 py-1 text-xs font-bold rounded-lg border transition">
                    2 · Structure
                </button>
                <button type="button" @click="currentView = 'section3'; currentReadingSection = 'instructions'; window.scrollTo(0,0)"
                    :class="currentView === 'section3' ? 'bg-emerald-600 text-white' : 'bg-white text-emerald-700 border-emerald-300'"
                    class="px-3 py-1 text-xs font-bold rounded-lg border transition">
                    3 · Reading
                </button>
            </div>

            {{-- Listening question shortcuts --}}
            <div x-show="currentView === 'section1'" class="flex flex-wrap gap-1 items-center">
                <span class="text-xs font-semibold text-amber-700 w-20 flex-shrink-0">Listening:</span>
                @foreach($listeningPages ?? [] as $lp)
                    @if($lp['type'] === 'question')
                        <button type="button"
                            @click="currentPageIndex = {{ $lp['index'] }}; startTimer(); window.scrollTo(0,0)"
                            :class="currentPageIndex === {{ $lp['index'] }} ? 'bg-red-600 text-white ring-2 ring-red-300' : 'bg-white text-gray-600 hover:bg-red-50 hover:text-red-700'"
                            class="w-8 h-8 rounded-lg border border-gray-200 text-xs font-bold transition flex items-center justify-center">
                            {{ $lp['data']->question_number }}
                        </button>
                    @elseif(str_starts_with($lp['type'], 'instruction'))
                        <span class="px-2 py-1 text-xs font-semibold bg-amber-200 text-amber-800 rounded-md">Part {{ $lp['part'] }}</span>
                    @endif
                @endforeach
            </div>

            {{-- Structure question shortcuts --}}
            <div x-show="currentView === 'section2'" class="flex flex-wrap gap-1 items-center">
                <span class="text-xs font-semibold text-amber-700 w-20 flex-shrink-0">Structure:</span>
                @foreach(array_merge($structureQuestions->all() ?? [], $writtenQuestions->all() ?? []) as $idx => $sq)
                    @if($idx === 0)
                        <button type="button" @click="currentView = 'section2'; currentSection = 'instructions'; window.scrollTo(0,0)" class="px-2 py-1 text-xs font-semibold bg-amber-200 text-amber-800 rounded-md transition hover:bg-amber-300">Part A</button>
                    @elseif($idx === count($structureQuestions))
                        <button type="button" @click="currentView = 'section2'; currentSection = 'questions'; currentStructureIndex = 15; showWrittenDir = true; window.scrollTo(0,0)" class="px-2 py-1 text-xs font-semibold bg-amber-200 text-amber-800 rounded-md transition hover:bg-amber-300">Part B</button>
                    @endif
                    <button type="button"
                        @click="currentView = 'section2'; currentSection = 'questions'; currentStructureIndex = {{ $idx }}; showWrittenDir = false; window.scrollTo(0,0)"
                        :class="currentView === 'section2' && currentStructureIndex === {{ $idx }} && !showWrittenDir ? 'bg-indigo-600 text-white ring-2 ring-indigo-300' : 'bg-white text-gray-600 hover:bg-indigo-50 hover:text-indigo-700'"
                        class="w-8 h-8 rounded-lg border border-gray-200 text-xs font-bold transition flex items-center justify-center">
                        {{ $sq->question_number }}
                    </button>
                @endforeach
            </div>

            {{-- Reading passage shortcuts --}}
            <div x-show="currentView === 'section3'" class="flex flex-wrap gap-1 items-center">
                <span class="text-xs font-semibold text-amber-700 w-20 flex-shrink-0">Reading:</span>
                @foreach(($readingPassages ?? []) as $idx => $passage)
                    @php
                        $passageQs = collect($passage['questions'] ?? []);
                        $firstQ = $passageQs->first()['question_number'] ?? null;
                        $lastQ = $passageQs->last()['question_number'] ?? null;
                    @endphp
                    @if($idx === 0)
                        <button type="button"
                            @click="currentView = 'section3'; currentReadingSection = 'instructions'; window.scrollTo(0,0)"
                            class="px-2 py-1 text-xs font-semibold bg-amber-200 text-amber-800 rounded-md transition hover:bg-amber-300">
                            Part A
                        </button>
                    @endif
                    <button type="button"
                        @click="currentView = 'section3'; goToReadingPassage({{ $idx }})"
                        :class="currentView === 'section3' && currentReadingSection === 'questions' && currentReadingPassageIndex === {{ $idx }} ? 'bg-emerald-600 text-white ring-2 ring-emerald-300' : 'bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-700'"
                        class="px-3 h-8 rounded-lg border border-gray-200 text-xs font-bold transition flex items-center justify-center">
                        {{ $firstQ && $lastQ ? ($firstQ . '-' . $lastQ) : ('P' . ($idx + 1)) }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Listening Section Wrapper -->
    <div x-show="currentView === 'section1'" class="w-full relative pb-12">
        <form id="listeningForm" method="POST" action="{{ $listeningSubmitRoute ?? '' }}" class="w-full">
            @csrf

            @foreach($listeningPages as $p)
                <div x-show="currentPageIndex === {{ $p['index'] }}" style="display: none;" class="w-full flex justify-center">
                    @if($p['type'] === 'instruction_main')
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden pb-8 font-sans border border-gray-200 flex justify-center w-full">
                            <div style="max-width: 900px; width: 100%; padding: 32px 20px;">
                                <!-- Main header -->
                                <div style="background-color: #d1a82e; border-radius: 9999px; padding: 14px 36px; margin-bottom: 32px; width: 100%; box-sizing: border-box;">
                                    <h2 style="font-size: 2rem; font-weight: 800; color: #111; margin: 0; letter-spacing: -0.02em; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Section 1: Listening Comprehension</h2>
                                </div>

                                <!-- Introduction text -->
                                <div style="padding-left: 36px; padding-right: 36px; margin-bottom: 40px;">
                                    <p style="font-size: 1.05rem; color: #222; line-height: 1.6; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0;">
                                        In this section of the test, you will have an opportunity to demonstrate your ability to understand conversations and talks in English. There are three parts to this section, with special instructions for each part. Answer all the questions on the basis of what is stated or implied by the speakers. When you take an actual ITP test, you will not be allowed to take notes or write in your testbook. Try to work on this Practice Test in the same way.
                                    </p>
                                </div>

                                <!-- Section 1, Part A -->
                                <div style="padding-left: 36px; padding-right: 36px; margin-bottom: 40px;">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 style="font-size: 1.3rem; font-weight: 800; color: #111; margin: 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.01em;">Section 1, Part A</h3>
                                        @if(auth()->check() && auth()->user()->isAdmin())
                                            <form action="{{ route('assignments.toefl-itp.mockup.package.upload-audio', ['package' => $packageNumber ?? 1]) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-1" title="Upload audio directions for Part A">
                                                @csrf
                                                <input type="hidden" name="listening_direction_part" value="A">
                                                <label class="flex items-center gap-1 cursor-pointer px-2 py-1 rounded-lg border border-dashed border-gray-300 hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-400 hover:text-indigo-600" title="{{ ($listeningDirectionAudio->audio_part_a ?? null) ? 'Audio: '.basename($listeningDirectionAudio->audio_part_a) : 'No audio — click to upload' }}">
                                                    <svg class="w-4 h-4 flex-shrink-0 {{ ($listeningDirectionAudio->audio_part_a ?? null) ? 'text-emerald-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6v6m0 0l-2-2m2 2l2-2M9 19H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 11.414V17a2 2 0 01-2 2h-2"></path></svg>
                                                    <span class="hidden sm:inline">{{ ($listeningDirectionAudio->audio_part_a ?? null) ? 'Re-upload Audio (A)' : 'Add Audio (A)' }}</span>
                                                    <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,.m4a" class="sr-only" onchange="this.closest('form').submit()">
                                                </label>
                                            </form>
                                        @endif
                                    </div>
                                    <p style="font-size: 1.05rem; color: #222; line-height: 1.6; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0;">
                                        <strong style="font-weight: bold; color: #000;">Directions:</strong> in Part A, you will hear short conversations between two people. After each conversation, you will hear a question about the conversation. The conversations and questions will not be repeated. After you hear a question, read the four possible answers in this booklet and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.
                                    </p>
                                </div>

                                <!-- Example -->
                                <div style="padding-left: 36px; padding-right: 36px;">
                                    <h4 style="font-size: 1.05rem; font-weight: 800; color: #111; margin: 0 0 20px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Here is an example:</h4>
                                    
                                    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                                        <p style="font-size: 1.05rem; color: #222; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0 0 12px 0; min-width: 200px;">On the recording, you hear:</p>
                                        <div style="text-align: center; margin-right: 16px;">
                                            <p style="font-weight: 800; color: #111; font-size: 0.9rem; margin: 0 0 8px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.01em;">Sample Answer</p>
                                            <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                                <div style="width: 24px; height: 16px; background-color: #111; border-radius: 50%;"></div>
                                                <div style="width: 24px; height: 24px; border-radius: 50%; border: 1.5px solid #333; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600; font-family: sans-serif; color: #111; box-sizing: border-box;">B</div>
                                                <div style="width: 24px; height: 24px; border-radius: 50%; border: 1.5px solid #333; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600; font-family: sans-serif; color: #111; box-sizing: border-box;">C</div>
                                                <div style="width: 24px; height: 24px; border-radius: 50%; border: 1.5px solid #333; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600; font-family: sans-serif; color: #111; box-sizing: border-box;">D</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: 20px; margin-bottom: 28px; flex-wrap: wrap;">
                                        <div style="font-size: 1.05rem; color: #222; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; white-space: nowrap; margin-top: 0; min-width: 180px;">In your booklet, you read:</div>
                                        <div style="font-size: 1.05rem; color: #222; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif;">
                                            <div style="display: flex; gap: 12px; margin-bottom: 4px;"><span style="width: 28px; flex-shrink: 0;">(A)</span><span style="font-weight:600;">He doesn't like the painting either.</span></div>
                                            <div style="display: flex; gap: 12px; margin-bottom: 4px;"><span style="width: 28px; flex-shrink: 0;">(B)</span><span>He doesn't know how to paint.</span></div>
                                            <div style="display: flex; gap: 12px; margin-bottom: 4px;"><span style="width: 28px; flex-shrink: 0;">(C)</span><span>He doesn't have any paintings.</span></div>
                                            <div style="display: flex; gap: 12px; margin-bottom: 4px;"><span style="width: 28px; flex-shrink: 0;">(D)</span><span>He doesn't know what to do.</span></div>
                                        </div>
                                    </div>

                                    <p style="font-size: 1.05rem; color: #222; line-height: 1.6; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0;">
                                        You learn from the conversation that neither the man nor the woman likes the painting. The best answer to the question "What does the man mean?" is (A), "He doesn't like the painting either." Therefore, the correct choice is (A).
                                    </p>
                                </div>

                                <!-- Ready Button -->
                                <div style="display: flex; justify-content: center; margin-top: 48px;">
                                    <button type="button" @click="currentPageIndex++; window.scrollTo(0,0)" style="padding: 14px 32px; background-color: #d1a82e; color: #111; font-weight: bold; font-size: 1.1rem; border-radius: 12px; border: none; cursor: pointer; display: flex; align-items: center; gap: 10px; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                        Now Begin Work on the Questions
                                    </button>
                                </div>
                            </div>
                        </div>

                    @elseif($p['type'] === 'instruction_b')
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden pb-8 font-sans border border-gray-200 flex justify-center w-full">
                            <div style="max-width: 900px; width: 100%; padding: 40px 48px;">
                                <div class="flex items-center justify-between" style="margin: 0 0 24px 0;">
                                    <h2 style="font-size: 1.5rem; font-weight: 900; color: #111; margin: 0; font-family: 'Arial Narrow', Arial, sans-serif; letter-spacing: -0.01em;">Section 1, Part B</h2>
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <form action="{{ route('assignments.toefl-itp.mockup.package.upload-audio', ['package' => $packageNumber ?? 1]) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-1" title="Upload audio directions for Part B">
                                            @csrf
                                            <input type="hidden" name="listening_direction_part" value="B">
                                            <label class="flex items-center gap-1 cursor-pointer px-2 py-1 rounded-lg border border-dashed border-gray-300 hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-400 hover:text-indigo-600" title="{{ ($listeningDirectionAudio->audio_part_b ?? null) ? 'Audio: '.basename($listeningDirectionAudio->audio_part_b) : 'No audio — click to upload' }}">
                                                <svg class="w-4 h-4 flex-shrink-0 {{ ($listeningDirectionAudio->audio_part_b ?? null) ? 'text-emerald-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6v6m0 0l-2-2m2 2l2-2M9 19H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 11.414V17a2 2 0 01-2 2h-2"></path></svg>
                                                <span class="hidden sm:inline">{{ ($listeningDirectionAudio->audio_part_b ?? null) ? 'Re-upload Audio (B)' : 'Add Audio (B)' }}</span>
                                                <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,.m4a" class="sr-only" onchange="this.closest('form').submit()">
                                            </label>
                                        </form>
                                    @endif
                                </div>
                                <div style="padding-left: 24px;">
                                    <p style="font-size: 1.05rem; color: #222; line-height: 1.7; font-family: -apple-system, Arial, sans-serif; margin: 0 0 18px 0;">
                                        <strong style="font-weight: 700;">Directions:</strong> In this part of the test, you will hear longer conversations. After each conversation, you will hear several questions. The conversations and questions will not be repeated.
                                    </p>
                                    <p style="font-size: 1.05rem; color: #222; line-height: 1.7; font-family: -apple-system, Arial, sans-serif; margin: 0 0 18px 0;">
                                        After you hear a question, read the four possible answers in your book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.
                                    </p>
                                    <p style="font-size: 1.05rem; color: #222; line-height: 1.7; font-family: -apple-system, Arial, sans-serif; margin: 0;">
                                        Remember, you are <strong style="font-weight: 700;">not</strong> allowed to take notes or write in your test book.
                                    </p>
                                </div>
                                <div style="display: flex; justify-content: center; margin-top: 48px; gap: 16px;">
                                    <button type="button" @click="currentPageIndex--; window.scrollTo(0,0)" style="padding: 12px 24px; background-color: #fff; border: 2px solid #e5e7eb; color: #374151; font-weight: bold; font-size: 1rem; border-radius: 12px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                                        Back
                                    </button>
                                    <button type="button" @click="currentPageIndex++; window.scrollTo(0,0)" style="padding: 12px 28px; background-color: #111; color: white; font-weight: bold; font-size: 1rem; border-radius: 12px; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.15); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                        Proceed to Part B Questions
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                     @elseif($p['type'] === 'instruction_c')
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden pb-8 font-sans border border-gray-200 flex justify-center w-full">
                            <div style="max-width: 900px; width: 100%; padding: 40px 48px;">
                                <div class="flex items-center justify-between" style="margin: 0 0 24px 0;">
                                    <h2 style="font-size: 1.5rem; font-weight: 900; color: #111; margin: 0; font-family: 'Arial Narrow', Arial, sans-serif; letter-spacing: -0.01em;">Section 1, Part C</h2>
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <form action="{{ route('assignments.toefl-itp.mockup.package.upload-audio', ['package' => $packageNumber ?? 1]) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-1" title="Upload audio directions for Part C">
                                            @csrf
                                            <input type="hidden" name="listening_direction_part" value="C">
                                            <label class="flex items-center gap-1 cursor-pointer px-2 py-1 rounded-lg border border-dashed border-gray-300 hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-400 hover:text-indigo-600" title="{{ ($listeningDirectionAudio->audio_part_c ?? null) ? 'Audio: '.basename($listeningDirectionAudio->audio_part_c) : 'No audio — click to upload' }}">
                                                <svg class="w-4 h-4 flex-shrink-0 {{ ($listeningDirectionAudio->audio_part_c ?? null) ? 'text-emerald-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6v6m0 0l-2-2m2 2l2-2M9 19H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 11.414V17a2 2 0 01-2 2h-2"></path></svg>
                                                <span class="hidden sm:inline">{{ ($listeningDirectionAudio->audio_part_c ?? null) ? 'Re-upload Audio (C)' : 'Add Audio (C)' }}</span>
                                                <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,.m4a" class="sr-only" onchange="this.closest('form').submit()">
                                            </label>
                                        </form>
                                    @endif
                                </div>
                                <div style="padding-left: 24px; font-size: 1.05rem; color: #222; line-height: 1.7; font-family: -apple-system, Arial, sans-serif;">
                                    <p style="margin: 0 0 18px 0;">
                                        <strong style="font-weight: 700;">Directions:</strong> In this part of the test, you will hear several short talks. After each talk, you will hear some questions. The talks and questions will not be repeated.
                                    </p>
                                    <p style="margin: 0 0 24px 0;">
                                        After you hear a question, read the four possible answers in your book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.
                                    </p>
                                    <p style="margin: 0 0 18px 0;">Here is an example:</p>

                                    {{-- Sample 1 --}}
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; gap: 24px;">
                                        <p style="margin: 0;">On the recording, you hear:</p>
                                        <div style="text-align: center; flex-shrink: 0;">
                                            <p style="font-weight: 700; font-size: 0.9rem; margin: 0 0 4px 0;">Sample Answer</p>
                                            <div style="display: flex; gap: 4px; align-items: center; font-size: 0.85rem;">
                                                <span style="width: 22px; height: 22px; border-radius: 50%; border: 1.5px solid #555; display: flex; align-items: center; justify-content: center;">A</span>
                                                <span style="width: 22px; height: 22px; border-radius: 50%; border: 1.5px solid #555; display: flex; align-items: center; justify-content: center;">B</span>
                                                <span style="width: 22px; height: 22px; border-radius: 50%; background: #111; display: flex; align-items: center; justify-content: center;">&nbsp;</span>
                                                <span style="width: 22px; height: 22px; border-radius: 50%; border: 1.5px solid #555; display: flex; align-items: center; justify-content: center;">D</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p style="margin: 0 0 10px 0;">Now listen to a sample question:</p>
                                    <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                                        <span style="white-space: nowrap; flex-shrink: 0;">In your book, you read:</span>
                                        <div>
                                            <p style="margin: 0 0 4px 0;">(A) &nbsp;To demonstrate the latest use of computer graphics.</p>
                                            <p style="margin: 0 0 4px 0;">(B) &nbsp;To discuss the possibility of an economic depression.</p>
                                            <p style="margin: 0 0 4px 0;">(C) &nbsp;To explain the workings of the brain.</p>
                                            <p style="margin: 0;">(D) &nbsp;To dramatize a famous mystery story.</p>
                                        </div>
                                    </div>
                                    <p style="margin: 0 0 24px 0;">The best answer to the question, "What is the main purpose of the program?" is (C), "To explain the workings of the brain." Therefore, the correct answer is (C).</p>

                                    {{-- Sample 2 --}}
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; gap: 24px;">
                                        <p style="margin: 0;">Now listen to another sample question:</p>
                                        <div style="text-align: center; flex-shrink: 0;">
                                            <p style="font-weight: 700; font-size: 0.9rem; margin: 0 0 4px 0;">Sample Answer</p>
                                            <div style="display: flex; gap: 4px; align-items: center; font-size: 0.85rem;">
                                                <span style="width: 22px; height: 22px; border-radius: 50%; border: 1.5px solid #555; display: flex; align-items: center; justify-content: center;">A</span>
                                                <span style="width: 22px; height: 22px; border-radius: 50%; border: 1.5px solid #555; display: flex; align-items: center; justify-content: center;">B</span>
                                                <span style="width: 22px; height: 22px; border-radius: 50%; border: 1.5px solid #555; display: flex; align-items: center; justify-content: center;">C</span>
                                                <span style="width: 22px; height: 22px; border-radius: 50%; background: #111; display: flex; align-items: center; justify-content: center;">&nbsp;</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                                        <span style="white-space: nowrap; flex-shrink: 0;">In your book, you read:</span>
                                        <div>
                                            <p style="margin: 0 0 4px 0;">(A) &nbsp;It is required of all science majors.</p>
                                            <p style="margin: 0 0 4px 0;">(B) &nbsp;It will never be shown again.</p>
                                            <p style="margin: 0 0 4px 0;">(C) &nbsp;It can help viewers improve their memory skills.</p>
                                            <p style="margin: 0;">(D) &nbsp;It will help with course work.</p>
                                        </div>
                                    </div>
                                    <p style="margin: 0 0 18px 0;">The best answer to the question "Why does the speaker recommend watching the program?" is (D), "It will help with course work." Therefore, the correct choice is (D).</p>
                                    <p style="margin: 0;">Remember, you are <strong style="font-weight: 700;">not</strong> allowed to take notes or write in the test book.</p>
                                </div>
                                <div style="display: flex; justify-content: center; margin-top: 48px; gap: 16px;">
                                    <button type="button" @click="currentPageIndex--; window.scrollTo(0,0)" style="padding: 12px 24px; background-color: #fff; border: 2px solid #e5e7eb; color: #374151; font-weight: bold; font-size: 1rem; border-radius: 12px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                                        Back
                                    </button>
                                    <button type="button" @click="currentPageIndex++; window.scrollTo(0,0)" style="padding: 12px 28px; background-color: #111; color: white; font-weight: bold; font-size: 1rem; border-radius: 12px; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.15); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                        Proceed to Part C Questions
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    @elseif($p['type'] === 'question')
                        @php
                            $q = $p['data'];
                        @endphp
                        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-10 max-w-4xl mx-auto border border-gray-200" style="width: 100%;">
                            <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-4">
                                <div class="bg-red-50 p-2.5 rounded-full border border-red-100 flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10v4a3 3 0 003 3h4a1 1 0 001-1v-4a1 1 0 00-1-1H6a1 1 0 01-1-1 7 7 0 1114 0 1 1 0 01-1 1h-4a1 1 0 00-1 1v4a1 1 0 001 1h4a3 3 0 003-3v-4m-5 9"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800" style="margin: 0;">Question {{ $q->question_number }}</h3>
                                
                                <div class="ml-4 px-3 py-1 rounded-lg border-2 font-bold select-none transition-colors duration-300"
                                     x-show="currentPageIndex === {{ $p['index'] }}"
                                     :class="{
                                         'border-green-500 text-green-600 bg-green-50': countdown > 6,
                                         'border-yellow-500 text-yellow-600 bg-yellow-50': countdown <= 6 && countdown > 3,
                                         'border-red-500 text-red-600 bg-red-50': countdown <= 3
                                     }"
                                >
                                    00:<span x-text="countdown.toString().padStart(2, '0')"></span>
                                </div>

                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <form action="{{ route('assignments.toefl-itp.mockup.package.question.upload-audio', ['package' => $packageNumber ?? 1, 'question_id' => $q->id]) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-1 ml-2" title="Upload audio for this question">
                                        @csrf
                                        <label class="flex items-center gap-1 cursor-pointer px-2 py-1 rounded-lg border border-dashed border-gray-300 hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-400 hover:text-indigo-600" title="{{ $q->audio_file ? 'Audio: '.basename($q->audio_file) : 'No audio — click to upload' }}">
                                            <svg class="w-4 h-4 flex-shrink-0 {{ $q->audio_file ? 'text-emerald-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6v6m0 0l-2-2m2 2l2-2M9 19H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 11.414V17a2 2 0 01-2 2h-2"></path></svg>
                                            <span class="hidden sm:inline">{{ $q->audio_file ? 'Re-upload' : 'Audio' }}</span>
                                            <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,.m4a" class="sr-only" onchange="this.closest('form').submit()">
                                        </label>
                                    </form>
                                @endif

                                <span class="ml-auto text-sm text-gray-600 font-semibold bg-gray-100 px-4 py-1.5 rounded-full border border-gray-200">Part {{ $p['part'] }}</span>
                            </div>

                            <div class="space-y-4 max-w-2xl pl-2">
                                @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $option => $text)
                                    <label class="mockup-option-label block w-full cursor-pointer" style="margin-bottom: 12px;">
                                        <input type="radio"
                                               name="question_{{ $q->id }}"
                                               value="{{ $option }}"
                                               class="sr-only"
                                               required>
                                        <div class="mockup-option-card flex items-center p-4 bg-white border border-gray-200 rounded-2xl" style="border-width: 1.5px;">
                                            <div class="mockup-option-badge flex-shrink-0 flex items-center justify-center w-9 h-9 rounded-full border-2 border-gray-300 text-gray-500 font-bold text-sm mr-4">
                                                {{ $option }}
                                            </div>
                                            <span class="mockup-option-text text-gray-700 text-lg select-none leading-snug" style="line-height: 1.4;">{{ $text }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            
                            <div class="mt-12 pt-6 border-t border-gray-100 flex justify-between items-center">
                                <button type="button" @click="currentPageIndex--; window.scrollTo(0,0)" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition flex items-center gap-2 shadow-sm bg-white" style="border-width: 2px;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    Prev
                                </button>
                                
                                @if($p['index'] < $totalListeningPages - 1)
                                    <button type="button" @click="currentPageIndex++; window.scrollTo(0,0)" class="px-8 py-3 rounded-xl bg-gray-800 text-white font-bold hover:bg-gray-900 transition shadow-lg flex items-center gap-2">
                                        Next
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                @else
                                    <button type="button" @click.prevent="submitListeningSection" class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
                                        Lanjut ke Structure
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </form>
    </div>
    
    <!-- ============================================ -->
    <!-- SECTION 2: STRUCTURE AND WRITTEN EXPRESSION -->
    <!-- ============================================ -->

    <!-- Section 2 Instructions -->
    @if(($isFullMockTest ?? false))
    <div x-show="currentView === 'section2' && currentSection === 'instructions'" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden pb-8 font-sans flex justify-center w-full">
        <div style="max-width: 900px; width: 100%; padding: 32px 20px;">
            <!-- Main header -->
            <div style="background-color: #d1a82e; border-radius: 9999px; padding: 14px 36px; margin-bottom: 32px; width: 100%; box-sizing: border-box;">
                <h2 style="font-size: 2rem; font-weight: 800; color: #111; margin: 0; letter-spacing: -0.02em; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Section 2: Structure and Written Expression</h2>
            </div>
            
            <div style="padding-left: 36px; padding-right: 36px; margin-bottom: 40px;">
                <p style="font-size: 1.05rem; color: #111; line-height: 1.6; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0 0 16px 0;">
                    <strong style="font-weight: 800;">Time: 25 minutes, including the reading of directions</strong><br>
                    Now set your clock for 25 minutes.
                </p>
                <p style="font-size: 1.05rem; color: #222; line-height: 1.6; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0;">
                    This section is designed to measure your ability to recognize language that is appropriate for standard written English. There are two types of questions in this section, with special directions for each type.
                </p>
            </div>

            <div style="padding-left: 36px; padding-right: 36px; margin-bottom: 48px;">
                <h3 style="font-size: 2.2rem; font-weight: 800; color: #111; margin: 0 0 24px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.04em; transform: scaleX(0.95); transform-origin: left;">Section 2, Part A</h3>
                
                <div style="padding-left: 36px;">
                    <p style="font-size: 1.15rem; color: #222; line-height: 1.6; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0 0 24px 0;">
                        <strong style="font-weight: 800;">Directions:</strong> Questions 1-15 are incomplete sentences. Beneath each sentence you will see four words or phrases, marked (A), (B), (C) and (D). Choose the <strong style="font-weight: 800;">one</strong> word or phrase that best completes the sentence. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.
                    </p>
                    
                    <!-- Example I -->
                    <div style="margin-bottom: 32px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                            <h4 style="font-size: 1.05rem; font-weight: 800; color: #111; margin: 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Example I</h4>
                            <div style="text-align: center; margin-right: 16px;">
                                <p style="font-weight: 800; color: #111; font-size: 0.9rem; margin: 0 0 8px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.01em;">Sample Answer</p>
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <div style="width: 24px; height: 16px; border-radius: 50%; border: 1.5px solid #333; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 600; font-family: sans-serif; color: #111; box-sizing: border-box;">A</div>
                                    <div style="width: 28px; height: 16px; background-color: #111; border-radius: 50%;"></div>
                                    <div style="width: 24px; height: 16px; border-radius: 50%; border: 1.5px solid #333; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 600; font-family: sans-serif; color: #111; box-sizing: border-box;">C</div>
                                    <div style="width: 24px; height: 16px; border-radius: 50%; border: 1.5px solid #333; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 600; font-family: sans-serif; color: #111; box-sizing: border-box;">D</div>
                                </div>
                            </div>
                        </div>

                        <p style="font-size: 1.1rem; color: #222; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0 0 12px 0;">Geysers have often been compared to volcanoes ________ they both emit hot liquids from below the Earth's surface.</p>
                        
                        <div style="font-size: 1.1rem; color: #222; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; padding-left: 28px; margin-bottom: 20px;">
                            <div style="margin-bottom: 4px;">(A) due to</div>
                            <div style="margin-bottom: 4px;">(B) because</div>
                            <div style="margin-bottom: 4px;">(C) in spite of</div>
                            <div style="margin-bottom: 4px;">(D) regardless of</div>
                        </div>
                        
                        <p style="font-size: 1.1rem; color: #222; line-height: 1.6; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0;">
                            The sentence should read, "Geysers have often been compared to volcanoes because they both emit hot liquids from beneath the Earth's surface." Therefore, the correct choice is (B).
                        </p>
                    </div>

                    <!-- Example II -->
                    <div style="margin-bottom: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                            <h4 style="font-size: 1.05rem; font-weight: 800; color: #111; margin: 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Example II</h4>
                            <div style="text-align: center; margin-right: 16px;">
                                <p style="font-weight: 800; color: #111; font-size: 0.9rem; margin: 0 0 8px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.01em;">Sample Answer</p>
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <div style="width: 24px; height: 16px; border-radius: 50%; border: 1.5px solid #333; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 600; font-family: sans-serif; color: #111; box-sizing: border-box;">A</div>
                                    <div style="width: 24px; height: 16px; border-radius: 50%; border: 1.5px solid #333; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 600; font-family: sans-serif; color: #111; box-sizing: border-box;">B</div>
                                    <div style="width: 24px; height: 16px; border-radius: 50%; border: 1.5px solid #333; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 600; font-family: sans-serif; color: #111; box-sizing: border-box;">C</div>
                                    <div style="width: 28px; height: 16px; background-color: #111; border-radius: 50%;"></div>
                                </div>
                            </div>
                        </div>

                        <p style="font-size: 1.1rem; color: #222; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; margin: 0 0 12px 0;">During the early period of ocean navigation, ________ any need for sophisticated instruments and techniques.</p>
                        
                        <div style="font-size: 1.1rem; color: #222; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif; padding-left: 28px;">
                            <div style="margin-bottom: 4px;">(A) so that hardly</div>
                            <div style="margin-bottom: 4px;">(B) when there hardly was</div>
                            <div style="margin-bottom: 4px;">(C) hardly was</div>
                            <div style="margin-bottom: 4px;">(D) there was hardly</div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Ready Button -->
            <div style="display: flex; justify-content: center; margin-top: 48px;">
                <button type="button" @click="currentSection = 'questions'; window.scrollTo(0,0)" style="padding: 14px 32px; background-color: #d1a82e; color: #111; font-weight: bold; font-size: 1.1rem; border-radius: 12px; border: none; cursor: pointer; display: flex; align-items: center; gap: 10px; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    Now Begin Work on the Questions
                </button>
            </div>
        </div>
    </div>

    <!-- Section 2 Questions -->
    <div x-show="currentView === 'section2' && currentSection === 'questions'">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-teal-700 mb-2">Section 2: Structure and Written Expression</h2>
            <p class="text-gray-600">Questions 1-40</p>
        </div>

        <!-- Floating Global Timer for Section 2 -->
        <div class="fixed top-24 right-8 z-50 bg-white border-2 px-5 py-3 rounded-2xl shadow-xl flex items-center gap-3 transition-colors duration-300 pointer-events-none"
             :class="{
                 'border-teal-500 text-teal-700': structureCountdown > 300,
                 'border-orange-400 text-orange-700 bg-orange-50': structureCountdown <= 300 && structureCountdown > 60,
                 'border-red-500 text-red-700 bg-red-50 animate-pulse': structureCountdown <= 60
             }">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="font-bold text-2xl font-mono tracking-wider" x-text="formatStructureTime()"></div>
        </div>

        <form method="POST" action="#" class="space-y-0 relative">
            @csrf
            @php
                $allSection2Qs = array_merge($structureQuestions->all() ?? [], $writtenQuestions->all() ?? []);
                $totalSection2Pages = count($allSection2Qs);
                
                if (!function_exists('renderWrittenExpression')) {
                    function renderWrittenExpression($q) {
                        $text = $q->question_text;
                        $questionId = $q->id;
                        $optionLetters = ['A', 'B', 'C', 'D'];
                        $count = 0;

                        // Split into plain text + **marked** tokens
                        $parts = preg_split('/(\*\*.*?\*\*)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

                        $html = '';
                        foreach ($parts as $part) {
                            if (preg_match('/^\*\*(.*?)\*\*$/', $part, $m)) {
                                $letter = $optionLetters[$count] ?? 'X';
                                $count++;
                                $word = htmlspecialchars(trim($m[1]), ENT_QUOTES);
                                // Circle badge style for letter
                                $circleBadge = '<span class="we-badge" style="'
                                    . 'display:inline-flex; align-items:center; justify-content:center;'
                                    . 'width:22px; height:22px; border-radius:50%;'
                                    . 'border:2px solid #9ca3af; background:#fff;'
                                    . 'font-size:0.72rem; font-weight:700; font-family:monospace;'
                                    . 'color:#6b7280; margin-top:3px;'
                                    . 'transition:background 0.15s, border-color 0.15s, color 0.15s;">'
                                    . $letter
                                    . '</span>';
                                $html .= '<label data-qid="' . $questionId . '" data-opt="' . $letter . '" style="'
                                    . 'display:inline-flex; flex-direction:column; align-items:center;'
                                    . 'cursor:pointer; margin:0 3px; vertical-align:top; line-height:1.3;">'
                                    . '<input type="radio" name="written_' . $questionId . '" value="' . $letter . '" '
                                    . 'style="position:absolute;opacity:0;width:1px;height:1px;" required>'
                                    . '<span class="we-word" style="'
                                    . 'border-bottom:2.5px solid #1f2937; padding:0 3px 1px; display:block;'
                                    . 'transition:border-color 0.15s, background 0.15s;">'
                                    . $word
                                    . '</span>'
                                    . $circleBadge
                                    . '</label>';
                            } else {
                                $html .= '<span style="vertical-align:top; line-height:1.3; display:inline-block;">'
                                    . htmlspecialchars($part, ENT_QUOTES)
                                    . '</span>';
                            }
                        }

                        // JS: on radio change → reset all, highlight selected (red circle + red underline)
                        $html .= '<script>
(function(){
    var labels = document.querySelectorAll("label[data-qid=\"' . $questionId . '\"]");
    labels.forEach(function(lbl){
        lbl.addEventListener("change", function(){
            labels.forEach(function(l){
                l.querySelector(".we-word").style.borderBottomColor = "#1f2937";
                l.querySelector(".we-word").style.background = "";
                var b = l.querySelector(".we-badge");
                b.style.background = "#fff";
                b.style.borderColor = "#9ca3af";
                b.style.color = "#6b7280";
            });
            var selWord = lbl.querySelector(".we-word");
            selWord.style.borderBottomColor = "#dc2626";
            selWord.style.background = "#fef2f2";
            var selBadge = lbl.querySelector(".we-badge");
            selBadge.style.background = "#dc2626";
            selBadge.style.borderColor = "#dc2626";
            selBadge.style.color = "#fff";
        });
    });
})();
</script>';

                        return $html;
                    }
                }
            @endphp
            
            @foreach($allSection2Qs as $idx => $q)
                <div x-cloak x-show="currentStructureIndex === {{ $idx }} && !showWrittenDir" class="bg-white rounded-2xl shadow-lg p-6 md:p-10 max-w-4xl mx-auto border border-gray-200" style="width: 100%;">
                    
                    <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="bg-teal-50 p-2.5 rounded-full border border-teal-100 flex-shrink-0">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800" style="margin: 0;">Question {{ $q->question_number }}</h3>

                        <span class="ml-auto text-sm text-gray-600 font-semibold bg-gray-100 px-4 py-1.5 rounded-full border border-gray-200">
                            {{ $q->part === 'Structure' ? 'Structure' : 'Written Expression' }}
                        </span>
                    </div>

                    @if($q->part === 'Structure')
                        <div class="mb-6 text-gray-800 text-lg md:text-xl leading-relaxed" style="line-height: 1.6;">
                            {!! nl2br(e($q->question_text)) !!}
                        </div>

                        <div class="space-y-4 max-w-2xl pl-2">
                            @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $option => $text)
                                <label class="mockup-option-label block w-full cursor-pointer" style="margin-bottom: 12px;">
                                    <input type="radio"
                                           name="structure_{{ $q->id }}"
                                           value="{{ $option }}"
                                           class="sr-only"
                                           required>
                                    <div class="mockup-option-card flex items-center p-4 bg-white border border-gray-200 rounded-2xl" style="border-width: 1.5px;">
                                        <div class="mockup-option-badge flex-shrink-0 flex items-center justify-center w-9 h-9 rounded-full border-2 border-gray-300 text-gray-500 font-bold text-sm mr-4">
                                            {{ $option }}
                                        </div>
                                        <span class="mockup-option-text text-gray-700 text-lg select-none leading-snug" style="line-height: 1.4;">{{ $text }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        {{-- Written Expression: kalimat dengan kata bergaris bawah + (A)(B)(C)(D) di bawahnya --}}
                        <div style="font-size:1.1rem; line-height:3; word-spacing:3px; padding-bottom:8px;">
                            {!! renderWrittenExpression($q) !!}
                        </div>
                    @endif

                    <div class="mt-12 pt-6 border-t border-gray-100 flex justify-between items-center">
                        <button type="button" @click="currentStructureIndex--; window.scrollTo(0,0)" 
                                :disabled="currentStructureIndex === 0"
                                :class="currentStructureIndex === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 text-gray-700 shadow-sm bg-white'"
                                class="px-6 py-3 rounded-xl border border-gray-300 font-bold transition flex items-center gap-2" style="border-width: 2px;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Prev
                        </button>
                        
                        @if($idx === count($structureQuestions) - 1)
                            {{-- Last Structure question → show WE direction before going to Q16 --}}
                            <button type="button" @click="showWrittenDir = true; window.scrollTo(0,0)" class="px-8 py-3 rounded-xl bg-teal-800 text-white font-bold hover:bg-teal-900 transition shadow-lg flex items-center gap-2">
                                Next
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        @elseif($idx < $totalSection2Pages - 1)
                            <button type="button" @click="currentStructureIndex++; window.scrollTo(0,0)" class="px-8 py-3 rounded-xl bg-teal-800 text-white font-bold hover:bg-teal-900 transition shadow-lg flex items-center gap-2">
                                Next
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        @elseif($isFullMockTest ?? false)
                            <button type="button" @click="currentView = 'section3'; currentReadingSection = 'instructions'; window.scrollTo(0,0)" class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
                                Lanjut ke Reading
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        @else
                            <button type="button" @click="submitFullMockup" class="px-8 py-3 rounded-xl bg-teal-600 text-white font-bold hover:bg-teal-700 transition shadow-lg flex items-center gap-2">
                                Submit Answers
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </form>

        {{-- Written Expression Direction Card (between Q15 and Q16) --}}
        <div x-cloak x-show="showWrittenDir" class="bg-white rounded-2xl shadow-lg p-8 md:p-12 max-w-4xl mx-auto border border-gray-200" style="width:100%;">
            <h3 style="font-size: 2.2rem; font-weight: 800; color: #111; margin: 0 0 24px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.04em; transform: scaleX(0.95); transform-origin: left;">Section 2, Part B</h3>
            
            <div style="padding-left: 36px;">
                <p style="font-size:1.15rem; color:#222; line-height:1.7; margin:0 0 24px 0; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif;">
                    <strong style="font-weight:800;">Directions:</strong> In questions 16&ndash;40, each sentence has four underlined words or phrases. The four underlined parts are marked (A), (B), (C) and (D). Identify the <strong style="font-weight:800;">one</strong> underlined word or phrase that must be changed for the sentence to be correct.
                </p>
                <div style="margin-bottom:28px; border:1px solid #e5e7eb; border-radius:12px; padding:20px 24px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                        <h4 style="font-size:1rem; font-weight:800; color:#111; margin:0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Example I</h4>
                        <div style="text-align:center;">
                            <p style="font-weight:800; color:#111; font-size:0.85rem; margin:0 0 6px 0;">Sample Answer</p>
                            <div style="display:flex; align-items:center; gap:5px; justify-content:center;">
                                <div style="width:22px;height:22px;border-radius:50%;background:#dc2626;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:#fff;">A</div>
                                <div style="width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:#374151;">B</div>
                                <div style="width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:#374151;">C</div>
                                <div style="width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:#374151;">D</div>
                            </div>
                        </div>
                    </div>
                    <p style="font-size:1.1rem; line-height:3.2; color:#222; margin:0 0 8px 0; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif;">
                        Guppies are sometimes
                        <span style="display:inline-flex;flex-direction:column;align-items:center;margin:0 4px;vertical-align:top;line-height:1.3;"><span style="border-bottom:2px solid #1f2937;padding:0 3px 1px;">call</span><span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;background:#dc2626;font-size:0.7rem;font-weight:700;color:#fff;margin-top:2px;">A</span></span>
                        rainbow
                        <span style="display:inline-flex;flex-direction:column;align-items:center;margin:0 4px;vertical-align:top;line-height:1.3;"><span style="border-bottom:2px solid #1f2937;padding:0 3px 1px;">fish</span><span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;font-size:0.7rem;font-weight:700;color:#374151;margin-top:2px;">B</span></span>
                        <span style="display:inline-flex;flex-direction:column;align-items:center;margin:0 4px;vertical-align:top;line-height:1.3;"><span style="border-bottom:2px solid #1f2937;padding:0 3px 1px;">because of</span><span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;font-size:0.7rem;font-weight:700;color:#374151;margin-top:2px;">C</span></span>
                        the males'
                        <span style="display:inline-flex;flex-direction:column;align-items:center;margin:0 4px;vertical-align:top;line-height:1.3;"><span style="border-bottom:2px solid #1f2937;padding:0 3px 1px;">bright</span><span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;font-size:0.7rem;font-weight:700;color:#374151;margin-top:2px;">D</span></span>
                        colors.
                    </p>
                    <p style="font-size:1.05rem; color:#374151; line-height:1.6; margin:0; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif;">
                        The sentence should read, &ldquo;Guppies are sometimes <em>called</em> rainbow fish because of the males&rsquo; bright colors.&rdquo; Therefore, you should choose (A).
                    </p>
                </div>
            </div>
            <p style="font-size:1.1rem; font-weight:800; color:#d1a82e; text-align:center; margin:0 0 28px 0;">Now begin work on the questions.</p>
            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #e5e7eb; padding-top:20px;">
                <button type="button" @click="showWrittenDir = false; window.scrollTo(0,0)" class="px-6 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition flex items-center gap-2 bg-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Q15
                </button>
                <button type="button" @click="showWrittenDir = false; currentStructureIndex = 15; window.scrollTo(0,0)" class="px-8 py-3 rounded-xl bg-teal-800 text-white font-bold hover:bg-teal-900 transition shadow-lg flex items-center gap-2">
                    Start Written Expression
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <style>
        .split-screen-wrapper {
            height: calc(100vh - 8rem);
            min-height: 760px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .split-screen-section {
            min-height: 760px;
            flex: 1 1 0%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .split-screen-panels {
            min-height: 0;
            flex: 1 1 0%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        @media (min-width: 1024px) {
            .split-screen-panels {
                flex-direction: row;
            }
        }
        .split-screen-left, .split-screen-right {
            min-height: 0;
            flex: 1 1 0%;
            overflow-y: auto;
        }
        .split-screen-left {
            border-right: 1px solid #e5e7eb;
        }
        .split-screen-custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .split-screen-custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .split-screen-custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 9999px;
            border: 2px solid transparent;
            background-clip: content-box;
        }
        .split-screen-custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #94a3b8;
        }

        /* ── Reading passage gutter (line markers) ── */
        .mockup-passage-shell {
            --toefl-passage-font-size: 15px;
            --toefl-passage-leading: 1.65;
            --toefl-line-step: calc(var(--toefl-passage-font-size) * var(--toefl-passage-leading));
        }
        .mockup-passage-shell.with-gutter {
            display: grid;
            grid-template-columns: 2.9rem minmax(0, 1fr);
            column-gap: 0.45rem;
            align-items: stretch;
        }
        .mockup-passage-gutter {
            position: relative;
            padding-top: 0.25rem;
        }
        .mockup-gutter-marker {
            position: absolute;
            right: 0;
            text-align: right;
            font-style: italic;
            font-weight: 500;
            color: #374151;
            font-size: 13px;
            line-height: 1;
            white-space: nowrap;
            transform: translateY(-50%);
        }
        .mockup-passage-text {
            color: #111827;
            font-size: var(--toefl-passage-font-size);
            line-height: var(--toefl-passage-leading);
        }
        .mockup-passage-paragraph {
            margin: 0;
        }
        .mockup-passage-paragraph + .mockup-passage-paragraph {
            text-indent: 1.25em;
        }
    </style>
    <!-- ============================================ -->
    <!-- SECTION 3: READING COMPREHENSION -->
    <!-- ============================================ -->
    <div x-show="currentView === 'section3' && currentReadingSection === 'instructions'" class="w-full flex justify-center">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden pb-8 font-sans border border-gray-200 flex justify-center w-full">
            <div style="max-width: 1100px; width: 100%; padding: 32px 20px 48px;">
                <div style="background-color: #d1a82e; border-radius: 9999px; padding: 14px 36px; margin-bottom: 32px; width: 100%; box-sizing: border-box;">
                    <h2 style="font-size: 2rem; font-weight: 800; color: #111; margin: 0; letter-spacing: -0.02em; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Section 3: Reading Comprehension</h2>
                </div>

                <div style="padding-left: 36px; padding-right: 36px; font-size: 1.05rem; color: #222; line-height: 1.6; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif;">
                    <p style="margin: 0 0 18px 0;">Time: 55 minutes, including the reading of the directions</p>
                    <p style="margin: 0 0 24px 0;">Now set your clock for 55 minutes.</p>
                    <p style="margin: 0 0 24px 0;"><strong style="font-weight: 800; color: #111;">Directions:</strong> In this section you will read several passages. Each passage is followed by several questions about it. For questions 1-50, you are to choose the <strong style="font-weight: 800; color: #111;">one</strong> best answer, (A), (B), (C) or (D), to each question. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</p>
                    <p style="margin: 0 0 34px 0;">Answer all questions following a passage on the basis of what is <strong style="font-weight: 800; color: #111;">stated</strong> or <strong style="font-weight: 800; color: #111;">implied</strong> in the passage.</p>

                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #111; margin: 0 0 24px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Read the following sample passage:</h3>

                    <div style="display: grid; grid-template-columns: 68px minmax(0, 1fr); column-gap: 22px; align-items: start; margin-bottom: 42px;">
                        <div style="text-align: right; font-style: italic; color: #374151; line-height: 1.5; padding-top: 104px;">
                            <div>Line</div>
                            <div style="margin-top: 24px;">5</div>
                        </div>
                        <div style="font-size: 1.05rem; color: #222; line-height: 1.65;">
                            <p style="margin: 0; text-indent: 0;">The railroad was not the first institution to impose regularity on society, or to draw attention to the importance of precise timekeeping. For as long as merchants have set out their wares at daybreak and communal festivities have been celebrated, people have been in rough agreement with their neighbors as to the time of day. The value of this tradition is today more apparent than ever. Were it not for public acceptance of a single yardstick of time, social life would be unbearably chaotic: the massive daily transfers of goods, services, and information would proceed in fits and starts; the very fabric of modern society would begin to unravel.</p>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; margin-bottom: 18px; flex-wrap: wrap;">
                        <h4 style="font-size: 1.05rem; font-weight: 800; color: #111; margin: 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Example I</h4>
                        <div style="text-align: center; min-width: 180px;">
                            <p style="font-weight: 800; color: #111; font-size: 0.9rem; margin: 0 0 8px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.01em;">Sample Answer</p>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">A</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">B</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; background-color: #111; display: inline-flex;"></span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">D</span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 32px;">
                        <p style="font-size: 1.05rem; margin: 0 0 14px 0;">What is the main idea of the passage?</p>
                        <div style="padding-left: 58px; line-height: 1.6;">
                            <p style="margin: 0 0 4px 0;">(A) In modern society, we must take more time for our neighbors.</p>
                            <p style="margin: 0 0 4px 0;">(B) The traditions of society are timeless.</p>
                            <p style="margin: 0 0 4px 0;">(C) An accepted way of measuring time is essential for the smooth functioning of society.</p>
                            <p style="margin: 0 0 14px 0;">(D) Society judges people by the times at which they conduct certain activities.</p>
                        </div>
                        <p style="margin: 0;">The main idea of the passage is that societies need to agree about how time is to be measured in order to function smoothly. Therefore, you should choose (C).</p>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; margin-bottom: 18px; flex-wrap: wrap;">
                        <h4 style="font-size: 1.05rem; font-weight: 800; color: #111; margin: 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Example II</h4>
                        <div style="text-align: center; min-width: 180px;">
                            <p style="font-weight: 800; color: #111; font-size: 0.9rem; margin: 0 0 8px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.01em;">Sample Answer</p>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">A</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">B</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">C</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; background-color: #111; display: inline-flex;"></span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 34px;">
                        <p style="font-size: 1.05rem; margin: 0 0 14px 0;">In line 5, the phrase “this tradition” refers to</p>
                        <div style="padding-left: 58px; line-height: 1.6;">
                            <p style="margin: 0 0 4px 0;">(A) the practice of starting the business day at dawn</p>
                            <p style="margin: 0 0 4px 0;">(B) friendly relations between neighbors</p>
                            <p style="margin: 0 0 4px 0;">(C) the railroad’s reliance on time schedules</p>
                            <p style="margin: 0 0 14px 0;">(D) people’s agreement on the measurement of time</p>
                        </div>
                        <p style="margin: 0;">The phrase “this tradition” refers to the preceding clause, “people have been in rough agreement with their neighbors as to the time of day.” Therefore you should choose (D).</p>
                    </div>

                    <p style="font-size: 1.3rem; font-weight: 800; color: #d1a82e; text-align: center; margin: 0 0 28px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Now begin work on the questions.</p>
                </div>

                <div style="display: flex; justify-content: center; margin-top: 24px;">
                    <button type="button" @click="goToReadingPassage(0)" style="padding: 14px 32px; background-color: #d1a82e; color: #111; font-weight: bold; font-size: 1.1rem; border-radius: 12px; border: none; cursor: pointer; display: flex; align-items: center; gap: 10px; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                        Now Begin Work on the Questions
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="currentView === 'section3' && currentReadingSection === 'questions'" class="split-screen-wrapper">
        <div style="flex-shrink: 0; margin-bottom: 1rem;">
            <h2 class="text-2xl font-bold text-emerald-700 mb-1">Section 3: Reading Comprehension</h2>
            <p class="text-gray-600">Questions 1-50</p>
        </div>

        @foreach(($readingPassages ?? []) as $passageIndex => $passage)
            @php
                $passageQuestions = collect($passage['questions'] ?? [])->values();
                $questionNumbers = $passageQuestions->pluck('question_number')->filter()->values();
                $firstQuestion = $questionNumbers->first();
                $lastQuestion = $questionNumbers->last();
            @endphp
            <section
                x-cloak
                x-show="currentReadingPassageIndex === {{ $passageIndex }}"
                class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden split-screen-section"
            >
                <div class="px-6 md:px-8 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50" style="flex-shrink: 0;">
                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-[2.5rem] font-bold leading-none text-gray-900">{{ $passage['section_title'] ?? ('Passage ' . ($passageIndex + 1)) }}</h3>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-bold text-emerald-700 border border-emerald-200">
                            Passage {{ $passage['passage_number'] ?? ($passageIndex + 1) }}
                        </span>
                    </div>
                </div>

                <div class="split-screen-panels">
                    <div data-reading-scroll class="p-4 md:p-6 bg-white split-screen-left split-screen-custom-scrollbar">
                        <div class="mockup-passage-shell with-gutter mockup-passage-text">
                            {{-- Gutter: Line number markers --}}
                            <div class="mockup-passage-gutter" aria-hidden="true">
                                @if(isset($passage['line_markers']) && count($passage['line_markers']) > 0)
                                    @foreach($passage['line_markers'] as $marker)
                                        @php
                                            $defaultLine = $loop->index === 0 ? 1 : $loop->index * 5;
                                            $markerLabel = is_array($marker) ? ($marker['label'] ?? '') : $marker;
                                            $lineNumber  = is_array($marker) ? (int) ($marker['line'] ?? $defaultLine) : $defaultLine;
                                            $lineCenter  = $lineNumber - 0.5;
                                        @endphp
                                        <div class="mockup-gutter-marker" style="top: calc({{ $lineCenter }} * var(--toefl-line-step));">{{ $markerLabel }}</div>
                                    @endforeach
                                @endif
                            </div>
                            {{-- Content --}}
                            <div class="mockup-passage-frame">
                                {!! $passage['content'] ?? '' !!}
                            </div>
                        </div>
                    </div>

                    <div data-reading-scroll class="bg-gray-50/60 split-screen-right split-screen-custom-scrollbar">
                        <div class="p-4 md:p-6 space-y-6 flex-1 pb-28">
                            @foreach($passageQuestions as $question)
                                <article
                                    id="reading-question-{{ $question['id'] ?? $question['question_number'] }}"
                                    class="bg-white rounded-xl border border-gray-200 shadow-sm p-3 md:p-4"
                                >
                                    <div class="flex items-start gap-2 border-b border-gray-100 pb-3 mb-3">
                                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 font-extrabold text-xs flex items-center justify-center border border-emerald-200 shrink-0">
                                            {{ $question['question_number'] }}
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900 leading-6">{{ $question['question_text'] }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @foreach(['A' => $question['option_a'], 'B' => $question['option_b'], 'C' => $question['option_c'], 'D' => $question['option_d']] as $option => $text)
                                            <label class="mockup-option-label relative block w-full cursor-pointer">
                                                <input
                                                    type="radio"
                                                    name="question_{{ $question['id'] }}"
                                                    value="{{ $option }}"
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer m-0 p-0 z-10"
                                                    required
                                                >
                                                <div class="mockup-option-card flex items-center p-2.5 bg-white border border-gray-200 rounded-xl" style="border-width: 1.5px;">
                                                    <div class="mockup-option-badge flex-shrink-0 flex items-center justify-center w-7 h-7 rounded-full border-2 border-gray-300 text-gray-500 font-bold text-xs mr-3">
                                                        {{ $option }}
                                                    </div>
                                                    <span class="mockup-option-text text-gray-700 text-sm select-none" style="line-height: 1.45;">{{ $text }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>

                                </article>
                            @endforeach
                        </div>

                        <div class="sticky bottom-0 z-30 border-t border-gray-200 bg-gray-50/95 p-4 backdrop-blur w-full mt-auto">
                            <div class="flex justify-between items-center gap-4">
                                <button
                                    type="button"
                                    @click="goToReadingPassage(currentReadingPassageIndex - 1)"
                                    :disabled="currentReadingPassageIndex === 0"
                                    :class="currentReadingPassageIndex === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 text-gray-700 shadow-sm bg-white'"
                                    class="px-5 py-2.5 rounded-xl border border-gray-300 font-bold transition flex items-center gap-2"
                                    style="border-width: 2px;"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    Prev Passage
                                </button>

                                @if($passageIndex < (count($readingPassages ?? []) - 1))
                                    <button
                                        type="button"
                                        @click="goToReadingPassage(currentReadingPassageIndex + 1)"
                                        class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition shadow-lg flex items-center gap-2"
                                    >
                                        Next Passage
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                @else
                                    <button
                                        type="button"
                                        @click="submitFullMockup"
                                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition shadow-lg flex items-center gap-2"
                                    >
                                        Submit Full Test
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    </div>

    <!-- Section Navigation -->
    <div class="fixed bottom-8 right-8 flex gap-3 z-50">
        <button @click="currentView = 'section1'; currentSection = 'instructions'" 
                :class="currentView === 'section1' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600'"
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
            Section 1: Listening
        </button>
        <button @click="currentView = 'section2'; currentSection = 'instructions'" 
                :class="currentView === 'section2' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600'"
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
            Section 2: Structure
        </button>
        <button @click="currentView = 'section3'; currentReadingSection = 'instructions'; window.scrollTo(0,0)" 
                :class="currentView === 'section3' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600'"
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
            Section 3: Reading
        </button>
    </div>
    @endif
</div>

@include('assignments.toefl-itp.listening.partials.admin-modals')
@endsection
