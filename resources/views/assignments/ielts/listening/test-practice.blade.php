@extends('layouts.admin')

@section('title', 'IELTS Listening Test Practice')

@section('content')
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 pb-32">

        @php
            $eval = session('evaluation_results');
            if (!$eval && isset($existingResult) && $existingResult) {
                $eval = [
                    'set' => $set,
                    'testId' => $testId,
                    'score_percentage' => $existingResult->score_percentage,
                    'band_score' => number_format($existingResult->band_score, 1),
                    'correct_count' => $existingResult->correct_count,
                    'total_questions' => $existingResult->total_questions,
                    'results' => $existingResult->results_data ?? [],
                    'submitted_at' => $existingResult->created_at ? $existingResult->created_at->format('d M Y, H:i') : '-',
                ];
            }
            if ($eval && !isset($eval['band_score'])) {
                $scaled = (int) round((($eval['correct_count'] ?? 0) / max(1, $eval['total_questions'] ?? 10)) * 40);
                if ($scaled >= 39) $eval['band_score'] = '9.0';
                else if ($scaled >= 37) $eval['band_score'] = '8.5';
                else if ($scaled >= 35) $eval['band_score'] = '8.0';
                else if ($scaled >= 32) $eval['band_score'] = '7.5';
                else if ($scaled >= 30) $eval['band_score'] = '7.0';
                else if ($scaled >= 26) $eval['band_score'] = '6.5';
                else if ($scaled >= 23) $eval['band_score'] = '6.0';
                else if ($scaled >= 18) $eval['band_score'] = '5.5';
                else if ($scaled >= 16) $eval['band_score'] = '5.0';
                else if ($scaled >= 13) $eval['band_score'] = '4.5';
                else if ($scaled >= 10) $eval['band_score'] = '4.0';
                else if ($scaled >= 6)  $eval['band_score'] = '3.5';
                else if ($scaled >= 4)  $eval['band_score'] = '3.0';
                else $eval['band_score'] = '2.5';
            }
            $backUrl = (isset($meeting) && $meeting)
                ? route('assignments.ielts-academic.listening.part1.practice', ['meeting' => $meeting->id ?? $meeting, 'set' => $set])
                : route('assignments.ielts-academic.listening.practice-index.part', ['set' => $set]);
        @endphp

        {{-- Header --}}
        <div class="mb-0 flex flex-wrap justify-between items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Part {{ $set }} - Test {{ $testId }}</h1>
                <p class="text-gray-500 mt-1">IELTS Listening Practice</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Autosave Status Indicator -->
                <div id="autosave-status" class="{{ $eval ? 'hidden' : 'flex' }} items-center gap-1.5 text-xs text-gray-500 font-medium px-2.5 py-1 rounded-full bg-gray-50 border border-gray-200">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Autosave Aktif</span>
                </div>

                <!-- Header Score Badge -->
                <div id="header-score-badge" class="{{ $eval ? 'flex' : 'hidden' }} items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-full font-bold text-xs shadow-sm">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span id="header-score-text">
                        @if($eval)
                            ✓ Band {{ $eval['band_score'] }} ({{ $eval['correct_count'] }}/{{ $eval['total_questions'] }})
                        @endif
                    </span>
                </div>

                <!-- Header Kerjakan Ulang Button -->
                <button type="button" id="header-retry-btn" onclick="confirmResetPractice()" class="{{ $eval ? 'inline-flex' : 'hidden' }} items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-rose-50 text-rose-600 hover:text-rose-700 border border-rose-200 rounded-lg text-xs font-bold transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Kerjakan Ulang</span>
                </button>

                <a href="{{ $backUrl }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Tests
                </a>
            </div>
        </div>

        {{-- Session Status --}}
        @if(session('success'))
            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 font-medium">
                {{ session('error') }}
            </div>
        @endif

        {{-- Evaluation Results Box --}}
        @if($eval)
            <div class="mt-6 mb-8 bg-white rounded-2xl p-6 sm:p-8 shadow-xl border-2 border-indigo-200">
                
                {{-- Header Summary --}}
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-200 pb-6 mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-3 py-1 bg-white text-indigo-800 rounded-full text-xs font-extrabold uppercase tracking-wider border border-indigo-300">
                                Hasil Penilaian & Evaluasi
                            </span>
                            <span class="text-xs text-gray-500 font-medium">• {{ $eval['submitted_at'] }}</span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-black text-gray-900">Part {{ $eval['set'] }} — Test {{ $eval['testId'] }}</h3>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                        {{-- Band Score Badge --}}
                        <div class="bg-gradient-to-br from-purple-700 to-indigo-700 border-2 border-purple-300 px-5 py-3 rounded-2xl text-center min-w-[135px] text-white shadow-md">
                            <span class="text-xs text-purple-200 font-bold block uppercase tracking-wider">Estimasi Band</span>
                            <span class="text-3xl font-black text-amber-300">Band {{ $eval['band_score'] }}</span>
                        </div>

                        {{-- Score Badge --}}
                        <div class="bg-white border-2 border-indigo-200 px-5 py-3 rounded-2xl text-center min-w-[125px] shadow-sm">
                            <span class="text-xs text-indigo-700 font-bold block uppercase tracking-wider">Skor Akhir</span>
                            <span class="text-3xl font-black text-indigo-700">{{ $eval['score_percentage'] }}%</span>
                        </div>
                        {{-- Correct Count Badge --}}
                        <div class="bg-white border-2 border-emerald-200 px-5 py-3 rounded-2xl text-center min-w-[125px] shadow-sm">
                            <span class="text-xs text-emerald-700 font-bold block uppercase tracking-wider">Jawaban Benar</span>
                            <span class="text-3xl font-black text-emerald-700">{{ $eval['correct_count'] }} <span class="text-base text-gray-500 font-normal">/ {{ $eval['total_questions'] }}</span></span>
                        </div>
                    </div>
                </div>

                {{-- Detail Per Soal Grid --}}
                <h4 class="font-bold text-lg text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Evaluasi Detail Jawaban
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($eval['results'] as $qNum => $item)
                        <div class="p-4 rounded-xl border-2 {{ $item['is_correct'] ? 'bg-white border-emerald-300 text-gray-900' : 'bg-red-50 border-red-300 text-gray-900' }} flex items-start justify-between gap-3 shadow-xs">
                            <div class="space-y-1.5 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-sm px-2.5 py-0.5 rounded-md {{ $item['is_correct'] ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white' }}">Soal {{ $qNum }}</span>
                                    <span class="text-xs font-black uppercase tracking-wider {{ $item['is_correct'] ? 'text-emerald-700' : 'text-red-700' }}">
                                        {{ $item['is_correct'] ? '✓ Benar' : '✕ Salah' }}
                                    </span>
                                </div>
                                <div class="text-sm pt-1">
                                    <span class="text-gray-500 text-xs font-bold block">Jawaban Anda:</span>
                                    <span class="font-bold {{ $item['is_correct'] ? 'text-emerald-900' : 'text-red-900' }}">{{ $item['user_answer'] ?: '(Kosong / Tidak diisi)' }}</span>
                                </div>
                                @if(!$item['is_correct'])
                                    <div class="text-sm pt-1 border-t border-red-200 mt-1">
                                        <span class="text-gray-500 text-xs font-bold block">Kunci Jawaban Benar:</span>
                                        <span class="font-extrabold text-emerald-800 bg-white border border-emerald-300 px-2 py-0.5 rounded inline-block mt-0.5">{{ $item['correct_answer'] }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="shrink-0">
                                @if($item['is_correct'])
                                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-black text-base shadow-sm">✓</div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center font-black text-base shadow-sm">✕</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Key & Explanations Included --}}
                @if(view()->exists('assignments.ielts.listening.answers.part' . $eval['set'] . '.test' . $eval['testId']))
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-bold text-lg text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Kunci Jawaban & Penjelasan Resmi
                        </h4>
                        <div class="bg-white text-gray-800 rounded-xl p-4 border border-gray-200">
                            @include('assignments.ielts.listening.answers.part' . $eval['set'] . '.test' . $eval['testId'])
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex flex-wrap gap-3 pt-6 border-t border-gray-200">
                    <button type="button" onclick="toggleTranscriptDrawer()" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-all shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Lihat Transkrip & Terjemahan Pembahasan
                    </button>
                    <button type="button" onclick="confirmResetPractice()" class="px-5 py-2.5 bg-white hover:bg-rose-50 text-rose-600 hover:text-rose-700 border border-rose-300 rounded-xl font-bold text-sm transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Kerjakan Ulang
                    </button>
                </div>

            </div>
        @endif

        @php
            $section = (isset($meeting) && $meeting && isset($meeting->ieltsSections)) 
                ? $meeting->ieltsSections->where('section_number', $set)->first() 
                : null;
        @endphp

        {{-- Colored Audio Player (Indigo/Purple theme) --}}
        @include('assignments.ielts.listening.partials.audio-player-practice', [
            'section' => $section,
            'meeting' => $meeting ?? null,
            'set'     => $set,
            'testId'  => $testId ?? null,
            'fixed'   => true,
        ])

        <form method="POST" id="questionsForm" action="{{ route('assignment.ielts.listening.submit', ['meeting' => $meeting->id ?? 0, 'set' => $set, 'test' => $testId]) }}" class="-mt-16 relative z-10">
            @csrf
            
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300 mb-6">
                <div class="flex justify-center mb-6">
                    <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                </div>

                @if(view()->exists('assignments.ielts.listening.questions.part' . $set . '.test' . $testId))
                    @include('assignments.ielts.listening.questions.part' . $set . '.test' . $testId)
                @else
                    <div class="flex flex-col items-center justify-center h-48 text-gray-400">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"></path></svg>
                        <p class="text-lg font-medium">Question content not available yet.</p>
                        <p class="text-sm mt-2 text-center text-gray-500">The text for this specific test has not been added to the system.</p>
                    </div>
                @endif
            </div>

            <div class="max-w-4xl mx-auto mt-8 flex justify-between items-center gap-4">
                <a href="{{ $backUrl }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl transition-all">
                    Back to Tests
                </a>
                @if($eval)
                    <button type="button" onclick="confirmResetPractice()" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span>Kerjakan Ulang ↺</span>
                    </button>
                @else
                    <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Submit Answers
                    </button>
                @endif
            </div>
        </form>

    </div>

    {{-- (Audio player scripts included in audio-player-practice partial) --}}

    <script>
    const SET = {{ $set }};
    const TEST_ID = {{ $testId }};
    const CSRF_TOKEN = document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}';
    const EVAL_DATA = @json($eval ?? null);
    const DRAFT_ANSWERS = @json($draftAnswers ?? null);
    const RETRY_URL = window.location.pathname + '?retry=1';
    const DRAFT_URL = "{{ route('assignments.ielts-academic.listening.practice-draft') }}";
    const STORAGE_KEY = `ielts_listening_draft_p${SET}_t${TEST_ID}_{{ auth()->id() ?? 'guest' }}`;

    function confirmResetPractice() {
        if (confirm('Apakah Anda yakin ingin mengulang latihan ini? Jawaban dan skor Anda sebelumnya akan direset sehingga Anda dapat mengerjakan ulang dari awal.')) {
            try {
                localStorage.removeItem(STORAGE_KEY);
            } catch (e) {}
            window.location.href = RETRY_URL;
        }
    }

    function toggleTranscriptDrawer() {
        const drawer = document.getElementById('transcriptDrawer');
        if (drawer) {
            drawer.classList.toggle('hidden');
        }
    }

    function collectCurrentAnswers() {
        const answers = {};
        const answersMulti = {};

        // Single answers
        document.querySelectorAll('input[name^="answers["], select[name^="answers["]').forEach(input => {
            const match = input.name.match(/^answers\[(\d+)\]$/);
            if (!match) return;
            const qid = match[1];

            if (input.type === 'radio') {
                if (input.checked) {
                    answers[qid] = input.value;
                }
            } else if (input.type === 'checkbox') {
                if (input.checked) {
                    if (!answers[qid]) answers[qid] = [];
                    answers[qid].push(input.value);
                }
            } else {
                if (input.value !== undefined && input.value !== '') {
                    answers[qid] = input.value;
                }
            }
        });

        // Multi answers (e.g. answers_multi[24_25][])
        document.querySelectorAll('input[name^="answers_multi["]').forEach(input => {
            const match = input.name.match(/^answers_multi\[([^\]]+)\]/);
            if (!match) return;
            const rangeKey = match[1];
            if (input.checked) {
                if (!answersMulti[rangeKey]) answersMulti[rangeKey] = [];
                answersMulti[rangeKey].push(input.value);
            }
        });

        return { answers, answers_multi: answersMulti };
    }

    function restoreAnswers(draftData) {
        if (!draftData || typeof draftData !== 'object') return;

        const answers = draftData.answers || (draftData.answers_multi ? {} : draftData);
        const multi = draftData.answers_multi || {};

        if (answers && typeof answers === 'object') {
            Object.keys(answers).forEach(qid => {
                const val = answers[qid];
                if (val === null || val === undefined) return;

                const inputs = document.querySelectorAll(`[name="answers[${qid}]"]`);
                inputs.forEach(input => {
                    if (input.type === 'radio') {
                        if (String(input.value).trim().toLowerCase() === String(val).trim().toLowerCase()) {
                            input.checked = true;
                        }
                    } else if (input.type === 'checkbox') {
                        const arr = Array.isArray(val) ? val : [val];
                        if (arr.map(x => String(x).trim().toLowerCase()).includes(String(input.value).trim().toLowerCase())) {
                            input.checked = true;
                        }
                    } else {
                        input.value = val;
                    }
                });
            });
        }

        if (multi && typeof multi === 'object') {
            Object.keys(multi).forEach(rangeKey => {
                const arr = Array.isArray(multi[rangeKey]) ? multi[rangeKey] : [multi[rangeKey]];
                const checkboxes = document.querySelectorAll(`[name="answers_multi[${rangeKey}][]"]`);
                checkboxes.forEach(cb => {
                    if (arr.map(x => String(x).trim().toLowerCase()).includes(String(cb.value).trim().toLowerCase())) {
                        cb.checked = true;
                    }
                });
            });
        }
    }

    let autosaveTimer = null;
    function scheduleAutosave() {
        if (EVAL_DATA) return;

        const statusEl = document.getElementById('autosave-status');
        if (statusEl) {
            statusEl.innerHTML = `<svg class="w-3.5 h-3.5 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="text-amber-600 font-semibold">Menyimpan...</span>`;
        }

        const draftData = collectCurrentAnswers();
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(draftData));
        } catch (e) {}

        clearTimeout(autosaveTimer);
        autosaveTimer = setTimeout(async () => {
            try {
                const res = await fetch(DRAFT_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        set: SET,
                        test: TEST_ID,
                        answers: draftData
                    })
                });
                if (res.ok && statusEl) {
                    statusEl.innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg><span class="text-emerald-700 font-semibold">Tersimpan</span>`;
                }
            } catch (err) {
                console.warn('Draft save error:', err);
                if (statusEl) {
                    statusEl.innerHTML = `<span class="text-gray-400">Tersimpan lokal</span>`;
                }
            }
        }, 1000);
    }

    function applyEvaluationMode(evalData) {
        if (!evalData || !evalData.results) return;

        const results = evalData.results;

        // Disable all inputs
        document.querySelectorAll('input[name^="answers["], input[name^="answers_multi["], select[name^="answers["]').forEach(input => {
            input.disabled = true;
            input.classList.add('cursor-not-allowed');
        });

        // Loop over each evaluated question result
        Object.keys(results).forEach(qNum => {
            const item = results[qNum];
            const qid = item.question_number || qNum;
            const isCorrect = item.is_correct;
            const userAns = (item.user_answer !== null && item.user_answer !== undefined) ? String(item.user_answer).trim() : '';
            const correctAns = (item.correct_answer !== null && item.correct_answer !== undefined) ? String(item.correct_answer).trim() : '';

            // Check single inputs
            const singleInputs = document.querySelectorAll(`[name="answers[${qid}]"]`);
            singleInputs.forEach(input => {
                if (input.type === 'radio') {
                    if (userAns && input.value.trim().toLowerCase() === userAns.toLowerCase()) {
                        input.checked = true;
                    }
                    const label = input.closest('label');
                    if (label) {
                        label.classList.add('pointer-events-none');
                        if (correctAns && input.value.trim().toLowerCase() === correctAns.toLowerCase()) {
                            label.classList.add('border', 'border-emerald-500', 'bg-emerald-50/70', 'ring-1', 'ring-emerald-500');
                        } else if (input.checked && !isCorrect) {
                            label.classList.add('border', 'border-rose-500', 'bg-rose-50/70', 'ring-1', 'ring-rose-500');
                        }
                    }
                } else if (input.tagName === 'SELECT') {
                    if (userAns) input.value = userAns;
                    if (isCorrect) {
                        input.classList.remove('border-gray-400', 'border-gray-700');
                        input.classList.add('border-emerald-500', 'bg-emerald-50', 'text-emerald-900', 'ring-1', 'ring-emerald-500');
                    } else {
                        input.classList.remove('border-gray-400', 'border-gray-700');
                        input.classList.add('border-rose-500', 'bg-rose-50', 'text-rose-900', 'ring-1', 'ring-rose-500');
                    }
                } else {
                    // Text input
                    if (userAns) input.value = userAns;
                    if (isCorrect) {
                        input.classList.remove('border-gray-700', 'border-gray-400');
                        input.classList.add('!border-emerald-500', 'bg-emerald-50/60', 'text-emerald-900', 'font-bold');
                    } else {
                        input.classList.remove('border-gray-700', 'border-gray-400');
                        input.classList.add('!border-rose-500', 'bg-rose-50/60', 'text-rose-900', 'font-bold');
                    }
                }
            });

            // Also check if question belongs to multi-answer checkboxes (answers_multi[start_end][])
            document.querySelectorAll('input[name^="answers_multi["]').forEach(cb => {
                const match = cb.name.match(/^answers_multi\[(\d+)_(\d+)\]/);
                if (match) {
                    const startQ = parseInt(match[1], 10);
                    const endQ = parseInt(match[2], 10);
                    const curQ = parseInt(qid, 10);
                    if (curQ >= startQ && curQ <= endQ) {
                        if (userAns && cb.value.trim().toLowerCase() === userAns.toLowerCase()) {
                            cb.checked = true;
                        }
                        const label = cb.closest('label');
                        if (label) {
                            label.classList.add('pointer-events-none');
                            if (correctAns && cb.value.trim().toLowerCase() === correctAns.toLowerCase()) {
                                label.classList.add('border', 'border-emerald-500', 'bg-emerald-50/70', 'ring-1', 'ring-emerald-500');
                            } else if (cb.checked && !isCorrect) {
                                label.classList.add('border', 'border-rose-500', 'bg-rose-50/70', 'ring-1', 'ring-rose-500');
                            }
                        }
                    }
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (EVAL_DATA) {
            applyEvaluationMode(EVAL_DATA);
            return;
        }

        // Restore from server draft or localStorage
        let restored = false;
        if (DRAFT_ANSWERS && (Object.keys(DRAFT_ANSWERS.answers || {}).length > 0 || Object.keys(DRAFT_ANSWERS).length > 0)) {
            restoreAnswers(DRAFT_ANSWERS);
            restored = true;
        } else {
            try {
                const localDraft = localStorage.getItem(STORAGE_KEY);
                if (localDraft) {
                    const parsed = JSON.parse(localDraft);
                    restoreAnswers(parsed);
                    restored = true;
                }
            } catch (e) {}
        }

        if (restored) {
            const statusEl = document.getElementById('autosave-status');
            if (statusEl) {
                statusEl.innerHTML = `<svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span class="text-blue-700 font-semibold">Draft dipulihkan</span>`;
                setTimeout(() => {
                    statusEl.innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Autosave Aktif</span>`;
                }, 3000);
            }
        }

        // Attach autosave listeners
        const form = document.getElementById('questionsForm');
        if (form) {
            form.addEventListener('input', scheduleAutosave);
            form.addEventListener('change', scheduleAutosave);
            form.addEventListener('submit', function() {
                try {
                    localStorage.removeItem(STORAGE_KEY);
                } catch (e) {}
            });
        }

        // Checkbox queuing for Choose TWO / THREE
        const selectionQueues = {};
        function getMaxAllowed(name) {
            const match = name.match(/\[(\d+)_(\d+)\]/);
            if (match) {
                return parseInt(match[2], 10) - parseInt(match[1], 10) + 1;
            }
            return 2;
        }

        const multiCheckboxes = document.querySelectorAll('input[type="checkbox"][name^="answers_multi["]');
        multiCheckboxes.forEach(function(checkbox) {
            const name = checkbox.name;
            if (!selectionQueues[name]) selectionQueues[name] = [];
            if (checkbox.checked) selectionQueues[name].push(checkbox);

            checkbox.addEventListener('change', function() {
                const maxAllowed = getMaxAllowed(name);
                const queue = selectionQueues[name];
                if (this.checked) {
                    queue.push(this);
                    if (queue.length > maxAllowed) {
                        const oldest = queue.shift();
                        oldest.checked = false;
                    }
                } else {
                    const index = queue.indexOf(this);
                    if (index !== -1) queue.splice(index, 1);
                }
            });
        });
    });
    </script>
@endsection
