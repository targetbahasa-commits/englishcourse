<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Online Test — {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .code-display {
            letter-spacing: 0.25em;
            font-variant-numeric: tabular-nums;
        }
        .badge-active {
            background: linear-gradient(135deg, #dcfce7 0%, #d1fae5 100%);
        }
        .card-glow-red    { box-shadow: 0 0 0 1px #fee2e2, 0 4px 20px -4px rgba(239,68,68,0.08); }
        .card-glow-blue   { box-shadow: 0 0 0 1px #dbeafe, 0 4px 20px -4px rgba(59,130,246,0.08); }
        .card-glow-orange { box-shadow: 0 0 0 1px #ffedd5, 0 4px 20px -4px rgba(249,115,22,0.08); }
        .card-glow-teal   { box-shadow: 0 0 0 1px #ccfbf1, 0 4px 20px -4px rgba(20,184,166,0.08); }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="font-sans antialiased" style="background: #f1f5f9;">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @include('components.sidebar-admin')

        <main class="flex-1 md:ml-64">

            {{-- Top Bar --}}
            <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-200 px-6 lg:px-10 py-4 flex items-center gap-4">
                <a href="{{ route('online-test.index') }}" class="flex items-center justify-center w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-lg font-bold text-gray-900">Kelola Online Test</h1>
                    <p class="text-xs text-gray-400 hidden sm:block">Atur kode akses, batch, dan akses per peserta.</p>
                </div>
                <a href="{{ route('online-test.index') }}" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Lihat Portal
                </a>
            </div>

            <div class="px-6 lg:px-10 py-8 max-w-6xl">

                {{-- Flash --}}
                @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl shadow-sm">
                    <span class="flex-shrink-0 w-8 h-8 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </span>
                    <p class="text-sm font-medium flex-1">{{ session('success') }}</p>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                @endif

                {{-- ===== PER-TEST CARDS ===== --}}
                @php
                    $themeMap = [
                        'ielts_academic' => ['glow' => 'card-glow-red',    'bar' => 'bg-red-500',    'badge' => 'bg-red-50 text-red-600 border-red-100',    'icon' => 'text-red-500',    'btn' => 'bg-red-600 hover:bg-red-700',    'initials' => 'IE', 'light' => 'bg-red-50'],
                        'ielts_general'  => ['glow' => 'card-glow-orange',  'bar' => 'bg-orange-500', 'badge' => 'bg-orange-50 text-orange-600 border-orange-100', 'icon' => 'text-orange-500', 'btn' => 'bg-orange-600 hover:bg-orange-700', 'initials' => 'IG', 'light' => 'bg-orange-50'],
                        'toefl_itp'      => ['glow' => 'card-glow-blue',    'bar' => 'bg-blue-500',   'badge' => 'bg-blue-50 text-blue-600 border-blue-100',    'icon' => 'text-blue-500',   'btn' => 'bg-blue-600 hover:bg-blue-700',   'initials' => 'TF', 'light' => 'bg-blue-50'],
                        'pte_academic'   => ['glow' => 'card-glow-teal',    'bar' => 'bg-teal-500',   'badge' => 'bg-teal-50 text-teal-700 border-teal-100',    'icon' => 'text-teal-500',   'btn' => 'bg-teal-600 hover:bg-teal-700',   'initials' => 'PT', 'light' => 'bg-teal-50'],
                    ];
                @endphp

                <div class="space-y-6 mb-10">
                    @foreach($tests as $test)
                    @php $th = $themeMap[$test['slug']] ?? $themeMap['toefl_itp']; @endphp

                    <div class="bg-white rounded-2xl overflow-hidden {{ $th['glow'] }}" x-data="{
                        historyOpen: false,
                        genLabel: '',
                        selectedPackage: {{ (int) ($test['package_number'] ?? 1) }},
                        answerKeyTestSlug: '{{ $test['slug'] }}',
                        answerKeyModalOpen: false,
                        answerKeyModalTitle: '',
                        answerKeyModalSection: '',
                        answerKeyModalLoading: false,
                        answerKeyModalSaving: false,
                        answerKeyError: '',
                        answerKeySuccess: '',
                        answerKeyRows: [],
                        answerKeyOriginalPayloadJson: '{}',
                        _pendingEditAnswer: '',
                        expectedQuestionCount(sectionKey) {
                            if (this.answerKeyTestSlug !== 'toefl_itp') {
                                return 40;
                            }

                            if (sectionKey === 'listening' || sectionKey === 'reading') {
                                return 50;
                            }

                            if (sectionKey === 'structure') {
                                return 40;
                            }

                            return 40;
                        },
                        usesFixedQuestionSet(sectionKey) {
                            return this.answerKeyTestSlug === 'toefl_itp' && ['listening', 'structure', 'reading'].includes(sectionKey);
                        },
                        allowDynamicAnswerRows() {
                            return !['toefl_itp', 'ielts_academic', 'ielts_general'].includes(this.answerKeyTestSlug);
                        },
                        isStrictToeflChoiceSection(sectionKey) {
                            return this.answerKeyTestSlug === 'toefl_itp' && ['listening', 'structure', 'reading'].includes(sectionKey);
                        },
                        answerInputPlaceholder(sectionKey) {
                            if (this.isStrictToeflChoiceSection(sectionKey)) {
                                return 'Contoh: A atau A|B';
                            }

                            return 'Contoh: A atau TRUE|FALSE';
                        },
                        normalizeChoiceToken(token) {
                            return String(token ?? '').trim().toUpperCase();
                        },
                        normalizeRowAnswerForSection(rawValue, sectionKey) {
                            const cleanValue = String(rawValue ?? '').trim();

                            if (cleanValue === '') {
                                return '';
                            }

                            if (!this.isStrictToeflChoiceSection(sectionKey)) {
                                return cleanValue;
                            }

                            const normalizedTokens = cleanValue
                                .split('|')
                                .map((item) => this.normalizeChoiceToken(item))
                                .filter((item) => item !== '');

                            if (normalizedTokens.length === 0) {
                                return '';
                            }

                            return Array.from(new Set(normalizedTokens)).join('|');
                        },
                        isValidRowAnswerForSection(answerText, sectionKey) {
                            if (!this.isStrictToeflChoiceSection(sectionKey)) {
                                return true;
                            }

                            const tokens = String(answerText ?? '')
                                .split('|')
                                .map((item) => this.normalizeChoiceToken(item))
                                .filter((item) => item !== '');

                            if (tokens.length === 0) {
                                return true;
                            }

                            return tokens.every((token) => ['A', 'B', 'C', 'D'].includes(token));
                        },
                        buildRowsFromAnswerKey(answerKey, sectionKey) {
                            const count = this.expectedQuestionCount(sectionKey);
                            const fixedRows = [];

                            for (let questionNumber = 1; questionNumber <= count; questionNumber += 1) {
                                const rawKey = 'q' + questionNumber;
                                const rawValue = Object.prototype.hasOwnProperty.call(answerKey, rawKey)
                                    ? answerKey[rawKey]
                                    : '';

                                const rowAnswer = Array.isArray(rawValue)
                                    ? rawValue.join('|')
                                    : String(rawValue ?? '');

                                fixedRows.push({
                                    question: questionNumber,
                                    answer: this.normalizeRowAnswerForSection(rowAnswer, sectionKey),
                                });
                            }

                            return fixedRows;
                        },
                        buildAnswerKeyPayload() {
                            const payload = {};

                            this.answerKeyRows.forEach((row) => {
                                const questionNumber = Number(row.question);

                                if (!Number.isFinite(questionNumber) || questionNumber < 1) {
                                    return;
                                }

                                const normalized = this.normalizeAnswerValue(row.answer);
                                if (Array.isArray(normalized) && normalized.length === 0) {
                                    return;
                                }

                                if (!Array.isArray(normalized) && normalized === '') {
                                    return;
                                }

                                payload['q' + Math.trunc(questionNumber)] = normalized;
                            });

                            return payload;
                        },
                        serializePayload(payload) {
                            const orderedPayload = {};
                            const keys = Object.keys(payload).sort((left, right) => {
                                const leftNumber = Number(String(left).replace('q', ''));
                                const rightNumber = Number(String(right).replace('q', ''));

                                if (!Number.isFinite(leftNumber) || !Number.isFinite(rightNumber)) {
                                    return String(left).localeCompare(String(right));
                                }

                                return leftNumber - rightNumber;
                            });

                            keys.forEach((key) => {
                                const value = payload[key];

                                if (Array.isArray(value)) {
                                    orderedPayload[key] = value.map((item) => String(item));
                                    return;
                                }

                                orderedPayload[key] = String(value);
                            });

                            return JSON.stringify(orderedPayload);
                        },
                        hasAnswerKeyChanges() {
                            return this.serializePayload(this.buildAnswerKeyPayload()) !== this.answerKeyOriginalPayloadJson;
                        },
                        closeAnswerKeyModal() {
                            if (this.answerKeyModalSaving) {
                                return;
                            }

                            if (this.hasAnswerKeyChanges()) {
                                const shouldClose = window.confirm('Ada perubahan jawaban yang belum disimpan. Tutup popup tanpa menyimpan?');

                                if (!shouldClose) {
                                    return;
                                }
                            }

                            this.answerKeyModalOpen = false;
                        },
                        answerKeyJsonEndpoint(sectionKey) {
                            return '{{ url('/admin/online-tests') }}/' + this.answerKeyTestSlug + '/paket' + this.selectedPackage + '/' + sectionKey + '/answer-key/json';
                        },
                        answerKeyPageEndpoint(sectionKey) {
                            return '{{ url('/admin/online-tests') }}/' + this.answerKeyTestSlug + '/paket' + this.selectedPackage + '/' + sectionKey + '/answer-key';
                        },
                        openAnswerKeyModal(sectionLabel, sectionKey) {
                            this.answerKeyModalTitle = 'Edit Answer Key ' + sectionLabel + ' (Paket ' + this.selectedPackage + ')';
                            this.answerKeyModalSection = sectionKey;
                            this.answerKeyModalOpen = true;
                            this.answerKeyModalLoading = true;
                            this.answerKeyError = '';
                            this.answerKeySuccess = '';
                            this.answerKeyRows = [];

                            const fallbackRows = this.buildRowsFromAnswerKey({}, sectionKey);

                            const endpoint = this.answerKeyJsonEndpoint(sectionKey);

                            fetch(endpoint, {
                                method: 'GET',
                                headers: {
                                    'Accept': 'application/json',
                                },
                            })
                                .then(async (response) => {
                                    if (!response.ok) {
                                        throw new Error('Gagal memuat answer key.');
                                    }

                                    return response.json();
                                })
                                .then((payload) => {
                                    const answerKey = payload.answer_key && typeof payload.answer_key === 'object'
                                        ? payload.answer_key
                                        : {};

                                    const rows = this.buildRowsFromAnswerKey(answerKey, sectionKey);
                                    this.answerKeyRows = rows.length > 0 ? rows : fallbackRows;
                                    this.answerKeyOriginalPayloadJson = this.serializePayload(this.buildAnswerKeyPayload());
                                })
                                .catch(() => {
                                    this.answerKeyRows = fallbackRows;
                                    this.answerKeyError = 'Gagal memuat answer key, menampilkan tabel kosong.';
                                    this.answerKeyOriginalPayloadJson = this.serializePayload(this.buildAnswerKeyPayload());
                                })
                                .finally(() => {
                                    this.answerKeyModalLoading = false;
                                });
                        },
                        addAnswerKeyRow() {
                            if (!this.allowDynamicAnswerRows()) {
                                this.answerKeyError = 'Section ini memakai jumlah soal tetap dan tidak bisa ditambah.';
                                return;
                            }

                            if (this.usesFixedQuestionSet(this.answerKeyModalSection)) {
                                this.answerKeyError = 'Jumlah soal untuk section ini sudah tetap dan tidak bisa ditambah.';
                                return;
                            }

                            const maxQuestion = this.answerKeyRows.reduce((currentMax, row) => {
                                const question = Number(row.question);
                                return Number.isFinite(question) && question > currentMax ? question : currentMax;
                            }, 0);

                            this.answerKeyRows.push({ question: maxQuestion + 1, answer: '' });
                            this.answerKeyRows.sort((left, right) => Number(left.question) - Number(right.question));
                        },
                        removeAnswerKeyRow(index) {
                            if (this.usesFixedQuestionSet(this.answerKeyModalSection)) {
                                if (!this.answerKeyRows[index]) {
                                    return;
                                }

                                this.answerKeyRows[index].answer = '';
                                return;
                            }

                            if (this.answerKeyRows.length <= 1) {
                                this.answerKeyRows[0] = { question: 1, answer: '' };
                                return;
                            }

                            this.answerKeyRows.splice(index, 1);
                        },
                        onAnswerFocus(row) {
                            this._pendingEditAnswer = String(row.answer ?? '');
                        },
                        onAnswerChange(row) {
                            const oldVal = this._pendingEditAnswer;
                            const newVal = this.normalizeRowAnswerForSection(row.answer, this.answerKeyModalSection);

                            if (!this.isValidRowAnswerForSection(newVal, this.answerKeyModalSection)) {
                                row.answer = oldVal;
                                this.answerKeyError = 'Section ini hanya menerima jawaban pilihan A, B, C, atau D (pisahkan multi jawaban dengan |).';
                                return;
                            }

                            row.answer = newVal;

                            if (oldVal === newVal) {
                                return;
                            }

                            if (oldVal.trim() === '') {
                                return;
                            }

                            const confirmed = window.confirm(
                                'Ubah jawaban soal no ' + row.question + '?\n\nDari: ' + oldVal + '\nMenjadi: ' + newVal
                            );

                            if (!confirmed) {
                                row.answer = oldVal;
                            }
                        },
                        normalizeAnswerValue(rawValue) {
                            const cleanValue = String(rawValue ?? '').trim();

                            if (cleanValue === '') {
                                return '';
                            }

                            if (cleanValue.includes('|')) {
                                return cleanValue
                                    .split('|')
                                    .map((item) => item.trim())
                                    .filter((item) => item !== '');
                            }

                            return cleanValue;
                        },
                        saveAnswerKeyModal() {
                            if (this.answerKeyModalSaving) {
                                return;
                            }

                            const payload = this.buildAnswerKeyPayload();

                            if (!this.hasAnswerKeyChanges()) {
                                this.answerKeyError = '';
                                this.answerKeySuccess = 'Tidak ada perubahan jawaban untuk disimpan.';
                                return;
                            }

                            const shouldSave = window.confirm('Yakin ingin menyimpan perubahan kunci jawaban ini?');
                            if (!shouldSave) {
                                return;
                            }

                            this.answerKeyModalSaving = true;
                            this.answerKeyError = '';
                            this.answerKeySuccess = '';

                            const endpoint = this.answerKeyJsonEndpoint(this.answerKeyModalSection);

                            fetch(endpoint, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                },
                                body: JSON.stringify({ answer_key: payload }),
                            })
                                .then(async (response) => {
                                    const data = await response.json().catch(() => ({}));

                                    if (!response.ok) {
                                        throw new Error(data.message || 'Gagal menyimpan answer key.');
                                    }

                                    return data;
                                })
                                .then((data) => {
                                    this.answerKeySuccess = data.message || 'Answer key berhasil disimpan.';
                                    this.answerKeyOriginalPayloadJson = this.serializePayload(payload);
                                })
                                .catch((error) => {
                                    this.answerKeyError = error.message || 'Gagal menyimpan answer key.';
                                })
                                .finally(() => {
                                    this.answerKeyModalSaving = false;
                                });
                        },
                    }">

                        {{-- Card Top Bar --}}
                        <div class="h-1 {{ $th['bar'] }}"></div>

                        {{-- Card Header --}}
                        <div class="px-6 pt-5 pb-4 flex items-center justify-between border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $th['light'] }} flex items-center justify-center text-xs font-black {{ $th['icon'] }}">
                                    {{ $th['initials'] }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h2 class="font-bold text-gray-900 text-base leading-tight">{{ $test['label'] }}</h2>
                                        @if(in_array($test['slug'], ['ielts_academic', 'toefl_itp'], true))
                                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-100">
                                                Paket {{ $test['package_number'] ?? 1 }}
                                            </span>
                                        @elseif($test['slug'] === 'ielts_general')
                                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-orange-50 text-orange-600 border border-orange-100">
                                                Paket {{ $test['package_number'] ?? 1 }}
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] font-mono text-gray-400">{{ $test['slug'] }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- Active / Inactive Badge --}}
                                @if($test['active_batch'])
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full border
                                        {{ $test['active_batch']->code_access_enabled
                                            ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                            : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                                        {{ $test['active_batch']->code_access_enabled ? '🔒 Kode Aktif' : '🔓 Kode Dinonaktifkan' }}
                                    </span>
                                @else
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200">Belum Ada Batch</span>
                                @endif

                                {{-- Enable / Disable Test Toggle --}}
                                <form method="POST" action="{{ route('admin.online-tests.update') }}" id="toggle-form-{{ $test['slug'] }}">
                                    @csrf
                                    @foreach($tests as $t)
                                        @if($t['slug'] !== $test['slug'])
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][enabled]" value="{{ $t['enabled'] ? '1' : '' }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][description]" value="{{ $t['description'] }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][package_number]" value="{{ $t['package_number'] ?? 1 }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][reference_test_id]" value="1">
                                        @endif
                                    @endforeach
                                    <input type="hidden" name="tests[{{ $test['slug'] }}][description]" value="{{ $test['description'] }}">
                                    <input type="hidden" name="tests[{{ $test['slug'] }}][package_number]" value="{{ $test['package_number'] ?? 1 }}">
                                    <input type="hidden" name="tests[{{ $test['slug'] }}][reference_test_id]" value="1">
                                    <label class="relative inline-flex items-center cursor-pointer group">
                                        <input type="checkbox" name="tests[{{ $test['slug'] }}][enabled]" value="1" {{ $test['enabled'] ? 'checked' : '' }} onchange="this.form.submit()" class="sr-only peer">
                                        <div class="w-10 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        <span class="ml-2 text-xs font-medium text-gray-500 group-hover:text-gray-700">{{ $test['enabled'] ? 'Aktif' : 'Nonaktif' }}</span>
                                    </label>
                                </form>
                            </div>
                        </div>

                        <div class="px-6 py-5 space-y-5">

                            {{-- Active Batch Code Box --}}
                            @if($test['active_batch'])
                            <div class="rounded-2xl border {{ $test['active_batch']->code_access_enabled ? 'border-emerald-100 bg-gradient-to-br from-emerald-50 to-green-50' : 'border-amber-100 bg-amber-50/50' }} p-4">
                                <div class="flex items-start justify-between gap-4 flex-wrap">
                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-widest {{ $test['active_batch']->code_access_enabled ? 'text-emerald-500' : 'text-amber-500' }} mb-1">
                                            Batch Aktif — {{ $test['active_batch']->label }}
                                        </p>
                                        <div class="code-display text-3xl font-black tracking-[0.3em] text-gray-900 my-1">
                                            {{ $test['active_batch']->code }}
                                        </div>
                                        <p class="text-[11px] text-gray-400 mt-1">Dibuat {{ $test['active_batch']->created_at->format('d M Y, H:i') }}</p>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2 mt-1">
                                        {{-- Copy Code Button --}}
                                        <div x-data="{ copied: false }">
                                            <button @click="navigator.clipboard.writeText('{{ $test['active_batch']->code }}'); copied = true; setTimeout(() => copied = false, 2500)"
                                                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 border
                                                    {{ $test['active_batch']->code_access_enabled
                                                        ? 'bg-emerald-600 hover:bg-emerald-700 text-white border-emerald-600 shadow-sm shadow-emerald-100'
                                                        : 'bg-white hover:bg-gray-50 text-gray-700 border-gray-200' }}">
                                                <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                <svg x-show="copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                <span x-text="copied ? 'Tersalin!' : 'Salin Kode'"></span>
                                            </button>
                                        </div>

                                        {{-- Copy Link Button --}}
                                        @php
                                            $testShareUrl = url('/online-test');
                                        @endphp
                                        <div x-data="{ copiedLink: false }">
                                            <button @click="navigator.clipboard.writeText('{{ $testShareUrl }}'); copiedLink = true; setTimeout(() => copiedLink = false, 2500)"
                                                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 border bg-white hover:bg-indigo-50 text-indigo-600 border-indigo-200">
                                                <svg x-show="!copiedLink" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                <svg x-show="copiedLink" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                <span x-text="copiedLink ? 'Link Tersalin!' : 'Salin Link'"></span>
                                            </button>
                                        </div>

                                        {{-- Toggle Code Required --}}
                                        <form method="POST" action="{{ route('admin.online-tests.toggle-code-access', $test['slug']) }}">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border transition-colors
                                                {{ $test['active_batch']->code_access_enabled
                                                    ? 'bg-white hover:bg-amber-50 border-gray-200 text-amber-600'
                                                    : 'bg-white hover:bg-emerald-50 border-gray-200 text-emerald-600' }}">
                                                @if($test['active_batch']->code_access_enabled)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                                    Nonaktifkan Kode
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zM10 7a2 2 0 114 0v3H10V7z"></path></svg>
                                                    Aktifkan Kode
                                                @endif
                                            </button>
                                        </form>

                                        {{-- Archive --}}
                                        <form method="POST" action="{{ route('admin.online-tests.batch.archive', $test['active_batch']->id) }}">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Arsipkan batch ini dan nonaktifkan kode?')"
                                                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border bg-white hover:bg-gray-50 border-gray-200 text-gray-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                                Arsipkan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 p-6 text-center">
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                <p class="text-sm font-medium text-gray-400">Belum ada kode batch aktif</p>
                                <p class="text-xs text-gray-400 mt-1">Generate batch baru di bawah untuk mengaktifkan kode akses.</p>
                            </div>
                            @endif

                            {{-- Generate New Batch --}}
                            <div class="flex gap-3">
                                <input x-model="genLabel" type="text" placeholder="Nama batch baru (misal: Batch Juni 2026)" required
                                    class="flex-1 border-gray-200 rounded-xl text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 placeholder-gray-400">
                                <form method="POST" action="{{ route('admin.online-tests.generate-code', $test['slug']) }}" @submit.prevent="if(genLabel.trim()) $el.submit()">
                                    @csrf
                                    <input type="hidden" name="label" :value="genLabel">
                                    <button type="submit"
                                        class="flex items-center gap-2 px-5 py-2.5 {{ $th['btn'] }} text-white text-sm font-bold rounded-xl shadow-sm transition-colors whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Generate & Aktifkan
                                    </button>
                                </form>
                            </div>

                            @if($test['slug'] === 'ielts_academic')
                            <div class="mt-4 rounded-2xl border border-red-100 bg-red-50/60 p-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                                    <p class="text-sm font-semibold text-red-700">Pilih Paket Soal IELTS Academic</p>
                                    <a href="{{ route('admin.online-tests.package-bank', ['slug' => 'ielts_academic']) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-red-100 text-red-700 text-xs font-semibold hover:bg-red-50 transition-colors">
                                        Kelola Bank Soal
                                    </a>
                                </div>
                                <form x-ref="ieltsReferenceSettingsForm" method="POST" action="{{ route('admin.online-tests.update') }}" class="flex flex-col sm:flex-row gap-3 sm:items-end">
                                    @csrf
                                    @foreach($tests as $t)
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][enabled]" value="{{ $t['enabled'] ? '1' : '' }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][description]" value="{{ $t['description'] }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][package_number]" value="{{ $t['package_number'] ?? 1 }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][reference_test_id]" value="1">
                                    @endforeach
                                    <div class="w-full sm:w-56">
                                        <label class="block text-xs font-semibold text-red-600 mb-1.5">Paket aktif</label>
                                        <select x-model="selectedPackage" name="tests[ielts_academic][package_number]" class="w-full border-red-200 rounded-xl text-sm focus:ring-red-500 focus:border-red-500 bg-white">
                                            @php $currentPackage = (int) ($test['package_number'] ?? 1); @endphp
                                            @for($number = 1; $number <= 16; $number++)
                                                <option value="{{ $number }}" {{ $currentPackage === $number ? 'selected' : '' }}>
                                                    Paket {{ $number }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-sm transition-colors">
                                        Simpan Paket
                                    </button>
                                </form>

                                <div class="mt-3 p-3 rounded-xl border border-red-100 bg-white">
                                    <p class="text-xs font-semibold text-red-700 mb-2">Referensi Style dan Format Section</p>
                                    <p class="text-[11px] text-red-500 mb-2">Tautan ini hanya untuk melihat layout dan format. Isi soal tiap paket tetap Anda input manual satu per satu.</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-academic') }}/paket' + selectedPackage + '/listening'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-red-100 bg-red-50 hover:bg-red-100 text-red-700 transition-colors">
                                            <span>Lihat format Listening</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-red-500">Referensi</span>
                                        </a>
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-academic') }}/paket' + selectedPackage + '/reading'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-red-100 bg-red-50 hover:bg-red-100 text-red-700 transition-colors">
                                            <span>Lihat format Reading</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-red-500">Referensi</span>
                                        </a>
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-academic') }}/paket' + selectedPackage + '/writing'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-red-100 bg-red-50 hover:bg-red-100 text-red-700 transition-colors">
                                            <span>Lihat format Writing</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-red-500">Referensi</span>
                                        </a>
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-academic') }}/paket' + selectedPackage + '/speaking'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-red-100 bg-red-50 hover:bg-red-100 text-red-700 transition-colors">
                                            <span>Lihat format Speaking</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-red-500">Referensi</span>
                                        </a>
                                    </div>

                                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                                        <button type="button" @click="openAnswerKeyModal('Listening', 'listening')" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-emerald-100 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors text-left">
                                            <span>Edit Answer Key Listening</span>
                                        </button>
                                        <button type="button" @click="openAnswerKeyModal('Reading', 'reading')" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-emerald-100 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors text-left">
                                            <span>Edit Answer Key Reading</span>
                                        </button>
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-academic/paket') }}' + selectedPackage + '/band-report'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-indigo-100 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 transition-colors">
                                            <span>Lihat Band Score Report</span>
                                        </a>
                                    </div>

                                    <div x-cloak x-show="answerKeyModalOpen" x-transition.opacity x-on:keydown.escape.window="closeAnswerKeyModal()" class="fixed inset-0 z-[70] flex items-center justify-center p-3 sm:p-6" style="overscroll-behavior: contain;">
                                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeAnswerKeyModal()"></div>
                                        <div class="relative w-full max-w-[94vw] sm:max-w-xl md:max-w-2xl bg-white rounded-2xl shadow-[0_25px_60px_-12px_rgba(0,0,0,0.25)] border border-gray-200/80 overflow-hidden flex flex-col" style="max-height: 88vh;" @click.stop>

                                            {{-- Modal Header --}}
                                            <div class="relative px-5 sm:px-6 py-4 border-b border-emerald-100" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 50%, #a7f3d0 100%);">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-600 shadow-sm shadow-emerald-200">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h3 class="text-sm sm:text-base font-bold text-emerald-900 truncate" x-text="answerKeyModalTitle"></h3>
                                                        <p class="text-[11px] text-emerald-600/80 mt-0.5">Kelola kunci jawaban untuk setiap nomor soal</p>
                                                    </div>
                                                </div>
                                                <button type="button" @click="closeAnswerKeyModal()" class="absolute top-3 right-3 inline-flex items-center justify-center w-8 h-8 rounded-xl bg-white/70 hover:bg-white text-emerald-700 hover:text-red-500 transition-all duration-200 shadow-sm" aria-label="Tutup popup edit answer key">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>

                                            {{-- Modal Body --}}
                                            <div class="flex-1 min-h-0 overflow-y-auto bg-gray-50/50 overscroll-contain" style="min-height: 0; overflow-y: auto; -webkit-overflow-scrolling: touch; overscroll-behavior: contain;">
                                                <template x-if="answerKeyModalLoading">
                                                    <div class="h-full min-h-64 flex flex-col items-center justify-center gap-3 px-6">
                                                        <div class="w-8 h-8 border-3 border-emerald-200 border-t-emerald-600 rounded-full animate-spin"></div>
                                                        <p class="text-sm font-medium text-gray-500">Memuat answer key...</p>
                                                    </div>
                                                </template>

                                                <template x-if="!answerKeyModalLoading">
                                                    <div class="p-4 sm:p-5 space-y-4">
                                                        {{-- Hint --}}
                                                        <div class="flex items-start gap-2.5 px-3.5 py-2.5 rounded-xl bg-blue-50 border border-blue-100">
                                                            <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            <p class="text-xs text-blue-700 leading-relaxed">Gunakan pemisah <strong class="font-bold">|</strong> untuk lebih dari satu jawaban pada nomor yang sama. Contoh: <code class="px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 font-mono text-[11px]">A|B</code></p>
                                                        </div>

                                                        {{-- Error/Success alerts --}}
                                                        <template x-if="answerKeyError">
                                                            <div class="flex items-center gap-2.5 rounded-xl border border-red-200 bg-red-50 px-3.5 py-2.5">
                                                                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <p class="text-xs text-red-700 font-medium" x-text="answerKeyError"></p>
                                                            </div>
                                                        </template>
                                                        <template x-if="answerKeySuccess">
                                                            <div class="flex items-center gap-2.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3.5 py-2.5">
                                                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                                <p class="text-xs text-emerald-700 font-medium" x-text="answerKeySuccess"></p>
                                                            </div>
                                                        </template>

                                                        {{-- Table --}}
                                                        <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                                            <table class="w-full text-xs sm:text-sm">
                                                                <thead>
                                                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100/80">
                                                                        <th class="w-20 sm:w-24 px-3 sm:px-4 py-2.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">No</th>
                                                                        <th class="px-3 sm:px-4 py-2.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Jawaban</th>
                                                                        <th class="w-14 sm:w-16 px-2 py-2.5 text-center text-[11px] font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <template x-for="(row, index) in answerKeyRows" :key="index">
                                                                        <tr class="border-t border-gray-100 transition-colors duration-150 hover:bg-emerald-50/40" :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50'">
                                                                            <td class="px-3 sm:px-4 py-1.5">
                                                                                <input type="number" min="1" x-model.number="row.question" :readonly="usesFixedQuestionSet(answerKeyModalSection)" :disabled="usesFixedQuestionSet(answerKeyModalSection)" class="w-full rounded-lg border-gray-200 bg-white text-xs sm:text-sm text-center font-semibold text-gray-700 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm py-1.5 disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed">
                                                                            </td>
                                                                            <td class="px-3 sm:px-4 py-1.5">
                                                                                <template x-if="isStrictToeflChoiceSection(answerKeyModalSection)">
                                                                                    <select x-model="row.answer" @focus="onAnswerFocus(row)" @change="onAnswerChange(row)" class="w-full rounded-lg border-gray-200 bg-white text-xs sm:text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm py-1.5">
                                                                                        <option value="">Pilih</option>
                                                                                        <option value="A">A</option>
                                                                                        <option value="B">B</option>
                                                                                        <option value="C">C</option>
                                                                                        <option value="D">D</option>
                                                                                    </select>
                                                                                </template>
                                                                                <template x-if="!isStrictToeflChoiceSection(answerKeyModalSection)">
                                                                                    <input type="text" x-model="row.answer" @focus="onAnswerFocus(row)" @change="onAnswerChange(row)" :placeholder="answerInputPlaceholder(answerKeyModalSection)" class="w-full rounded-lg border-gray-200 bg-white text-xs sm:text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm py-1.5">
                                                                                </template>
                                                                            </td>
                                                                            <td class="px-2 py-1.5 text-center">
                                                                                <button type="button" @click="removeAnswerKeyRow(index)" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all duration-200" title="Hapus baris">
                                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        {{-- Add Row --}}
                                                        <button x-show="allowDynamicAnswerRows() && !usesFixedQuestionSet(answerKeyModalSection)" type="button" @click="addAnswerKeyRow()" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-dashed border-gray-300 bg-white hover:bg-emerald-50 hover:border-emerald-300 text-xs font-semibold text-gray-600 hover:text-emerald-700 transition-all duration-200 w-full justify-center">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                            Tambah Baris
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>

                                            {{-- Modal Footer --}}
                                            <div class="px-5 sm:px-6 py-3.5 border-t border-gray-200 bg-white flex items-center justify-between gap-3">
                                                <a :href="answerKeyPageEndpoint(answerKeyModalSection)" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    Buka editor halaman penuh
                                                </a>
                                                <div class="flex items-center gap-2">
                                                    <button type="button" @click="closeAnswerKeyModal()" class="px-4 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-xs font-semibold text-gray-600 transition-colors">Tutup</button>
                                                    <button type="button" @click="saveAnswerKeyModal()" :disabled="answerKeyModalSaving" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-300 text-white text-xs font-bold shadow-sm shadow-emerald-100 transition-all duration-200 flex items-center gap-1.5">
                                                        <svg x-show="!answerKeyModalSaving" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                        <svg x-show="answerKeyModalSaving" class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                        <span x-text="answerKeyModalSaving ? 'Menyimpan...' : 'Simpan Answer Key'"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif($test['slug'] === 'ielts_general')
                            <div class="mt-4 rounded-2xl border border-orange-100 bg-orange-50/60 p-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                                    <p class="text-sm font-semibold text-orange-700">Pilih Paket Soal IELTS General</p>
                                    <a href="{{ route('admin.online-tests.package-bank', ['slug' => 'ielts_general']) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-orange-100 text-orange-700 text-xs font-semibold hover:bg-orange-50 transition-colors">
                                        Kelola Bank Soal
                                    </a>
                                </div>
                                <form x-ref="ieltsGeneralSettingsForm" method="POST" action="{{ route('admin.online-tests.update') }}" class="flex flex-col sm:flex-row gap-3 sm:items-end">
                                    @csrf
                                    @foreach($tests as $t)
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][enabled]" value="{{ $t['enabled'] ? '1' : '' }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][description]" value="{{ $t['description'] }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][package_number]" value="{{ $t['package_number'] ?? 1 }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][reference_test_id]" value="1">
                                    @endforeach
                                    <div class="w-full sm:w-56">
                                        <label class="block text-xs font-semibold text-orange-600 mb-1.5">Paket aktif</label>
                                        <select x-model="selectedPackage" name="tests[ielts_general][package_number]" class="w-full border-orange-200 rounded-xl text-sm focus:ring-orange-500 focus:border-orange-500 bg-white">
                                            @php $currentPackage = (int) ($test['package_number'] ?? 1); @endphp
                                            @for($number = 1; $number <= 16; $number++)
                                                <option value="{{ $number }}" {{ $currentPackage === $number ? 'selected' : '' }}>
                                                    Paket {{ $number }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl shadow-sm transition-colors">
                                        Simpan Paket
                                    </button>
                                </form>

                                <div class="mt-3 p-3 rounded-xl border border-orange-100 bg-white">
                                    <p class="text-xs font-semibold text-orange-700 mb-2">Referensi Style dan Format Section</p>
                                    <p class="text-[11px] text-orange-500 mb-2">Tautan ini hanya untuk melihat layout dan format. Isi soal tiap paket tetap Anda input manual satu per satu.</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-general') }}/paket' + selectedPackage + '/listening'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-orange-100 bg-orange-50 hover:bg-orange-100 text-orange-700 transition-colors">
                                            <span>Lihat format Listening</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-orange-500">Referensi</span>
                                        </a>
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-general') }}/paket' + selectedPackage + '/reading'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-orange-100 bg-orange-50 hover:bg-orange-100 text-orange-700 transition-colors">
                                            <span>Lihat format Reading</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-orange-500">Referensi</span>
                                        </a>
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-general') }}/paket' + selectedPackage + '/writing'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-orange-100 bg-orange-50 hover:bg-orange-100 text-orange-700 transition-colors">
                                            <span>Lihat format Writing</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-orange-500">Referensi</span>
                                        </a>
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-general') }}/paket' + selectedPackage + '/speaking'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-orange-100 bg-orange-50 hover:bg-orange-100 text-orange-700 transition-colors">
                                            <span>Lihat format Speaking</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-orange-500">Referensi</span>
                                        </a>
                                    </div>

                                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                                        <button type="button" @click="openAnswerKeyModal('Listening', 'listening')" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-emerald-100 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors text-left">
                                            <span>Edit Answer Key Listening</span>
                                        </button>
                                        <button type="button" @click="openAnswerKeyModal('Reading', 'reading')" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-emerald-100 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors text-left">
                                            <span>Edit Answer Key Reading</span>
                                        </button>
                                        <a target="_blank" :href="'{{ url('/online-test/ielts-general/paket') }}' + selectedPackage + '/band-report'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-indigo-100 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 transition-colors">
                                            <span>Lihat Band Score Report</span>
                                        </a>
                                    </div>

                                    <div x-cloak x-show="answerKeyModalOpen" x-transition.opacity x-on:keydown.escape.window="closeAnswerKeyModal()" class="fixed inset-0 z-[70] flex items-center justify-center p-3 sm:p-6" style="overscroll-behavior: contain;">
                                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeAnswerKeyModal()"></div>
                                        <div class="relative w-full max-w-[94vw] sm:max-w-xl md:max-w-2xl bg-white rounded-2xl shadow-[0_25px_60px_-12px_rgba(0,0,0,0.25)] border border-gray-200/80 overflow-hidden flex flex-col" style="max-height: 88vh;" @click.stop>

                                            <div class="relative px-5 sm:px-6 py-4 border-b border-emerald-100" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 50%, #a7f3d0 100%);">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-600 shadow-sm shadow-emerald-200">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h3 class="text-sm sm:text-base font-bold text-emerald-900 truncate" x-text="answerKeyModalTitle"></h3>
                                                        <p class="text-[11px] text-emerald-600/80 mt-0.5">Kelola kunci jawaban untuk setiap nomor soal</p>
                                                    </div>
                                                </div>
                                                <button type="button" @click="closeAnswerKeyModal()" class="absolute top-3 right-3 inline-flex items-center justify-center w-8 h-8 rounded-xl bg-white/70 hover:bg-white text-emerald-700 hover:text-red-500 transition-all duration-200 shadow-sm" aria-label="Tutup popup edit answer key">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>

                                            <div class="flex-1 min-h-0 overflow-y-auto bg-gray-50/50 overscroll-contain" style="min-height: 0; overflow-y: auto; -webkit-overflow-scrolling: touch; overscroll-behavior: contain;">
                                                <template x-if="answerKeyModalLoading">
                                                    <div class="h-full min-h-64 flex flex-col items-center justify-center gap-3 px-6">
                                                        <div class="w-8 h-8 border-3 border-emerald-200 border-t-emerald-600 rounded-full animate-spin"></div>
                                                        <p class="text-sm font-medium text-gray-500">Memuat answer key...</p>
                                                    </div>
                                                </template>

                                                <template x-if="!answerKeyModalLoading">
                                                    <div class="p-4 sm:p-5 space-y-4">
                                                        <div class="flex items-start gap-2.5 px-3.5 py-2.5 rounded-xl bg-blue-50 border border-blue-100">
                                                            <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            <p class="text-xs text-blue-700 leading-relaxed">Gunakan pemisah <strong class="font-bold">|</strong> untuk lebih dari satu jawaban pada nomor yang sama. Contoh: <code class="px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 font-mono text-[11px]">A|B</code></p>
                                                        </div>

                                                        <template x-if="answerKeyError">
                                                            <div class="flex items-center gap-2.5 rounded-xl border border-red-200 bg-red-50 px-3.5 py-2.5">
                                                                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <p class="text-xs text-red-700 font-medium" x-text="answerKeyError"></p>
                                                            </div>
                                                        </template>
                                                        <template x-if="answerKeySuccess">
                                                            <div class="flex items-center gap-2.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3.5 py-2.5">
                                                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                                <p class="text-xs text-emerald-700 font-medium" x-text="answerKeySuccess"></p>
                                                            </div>
                                                        </template>

                                                        <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                                            <table class="w-full text-xs sm:text-sm">
                                                                <thead>
                                                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100/80">
                                                                        <th class="w-20 sm:w-24 px-3 sm:px-4 py-2.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">No</th>
                                                                        <th class="px-3 sm:px-4 py-2.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Jawaban</th>
                                                                        <th class="w-14 sm:w-16 px-2 py-2.5 text-center text-[11px] font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <template x-for="(row, index) in answerKeyRows" :key="index">
                                                                        <tr class="border-t border-gray-100 transition-colors duration-150 hover:bg-emerald-50/40" :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50'">
                                                                            <td class="px-3 sm:px-4 py-1.5">
                                                                                <input type="number" min="1" x-model.number="row.question" :readonly="usesFixedQuestionSet(answerKeyModalSection)" :disabled="usesFixedQuestionSet(answerKeyModalSection)" class="w-full rounded-lg border-gray-200 bg-white text-xs sm:text-sm text-center font-semibold text-gray-700 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm py-1.5 disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed">
                                                                            </td>
                                                                            <td class="px-3 sm:px-4 py-1.5">
                                                                                <template x-if="isStrictToeflChoiceSection(answerKeyModalSection)">
                                                                                    <select x-model="row.answer" @focus="onAnswerFocus(row)" @change="onAnswerChange(row)" class="w-full rounded-lg border-gray-200 bg-white text-xs sm:text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm py-1.5">
                                                                                        <option value="">Pilih</option>
                                                                                        <option value="A">A</option>
                                                                                        <option value="B">B</option>
                                                                                        <option value="C">C</option>
                                                                                        <option value="D">D</option>
                                                                                    </select>
                                                                                </template>
                                                                                <template x-if="!isStrictToeflChoiceSection(answerKeyModalSection)">
                                                                                    <input type="text" x-model="row.answer" @focus="onAnswerFocus(row)" @change="onAnswerChange(row)" :placeholder="answerInputPlaceholder(answerKeyModalSection)" class="w-full rounded-lg border-gray-200 bg-white text-xs sm:text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm py-1.5">
                                                                                </template>
                                                                            </td>
                                                                            <td class="px-2 py-1.5 text-center">
                                                                                <button type="button" @click="removeAnswerKeyRow(index)" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all duration-200" title="Hapus baris">
                                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <button x-show="allowDynamicAnswerRows() && !usesFixedQuestionSet(answerKeyModalSection)" type="button" @click="addAnswerKeyRow()" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-dashed border-gray-300 bg-white hover:bg-emerald-50 hover:border-emerald-300 text-xs font-semibold text-gray-600 hover:text-emerald-700 transition-all duration-200 w-full justify-center">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                            Tambah Baris
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>

                                            <div class="px-5 sm:px-6 py-3.5 border-t border-gray-200 bg-white flex items-center justify-between gap-3">
                                                <a :href="answerKeyPageEndpoint(answerKeyModalSection)" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    Buka editor halaman penuh
                                                </a>
                                                <div class="flex items-center gap-2">
                                                    <button type="button" @click="closeAnswerKeyModal()" class="px-4 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-xs font-semibold text-gray-600 transition-colors">Tutup</button>
                                                    <button type="button" @click="saveAnswerKeyModal()" :disabled="answerKeyModalSaving" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-300 text-white text-xs font-bold shadow-sm shadow-emerald-100 transition-all duration-200 flex items-center gap-1.5">
                                                        <svg x-show="!answerKeyModalSaving" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                        <svg x-show="answerKeyModalSaving" class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                        <span x-text="answerKeyModalSaving ? 'Menyimpan...' : 'Simpan Answer Key'"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif($test['slug'] === 'toefl_itp')
                            <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50/60 p-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                                    <p class="text-sm font-semibold text-blue-700">Pilih Paket Soal TOEFL ITP</p>
                                    <a href="{{ route('admin.online-tests.package-bank', ['slug' => 'toefl_itp']) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-blue-100 text-blue-700 text-xs font-semibold hover:bg-blue-50 transition-colors">
                                        Kelola Bank Soal
                                    </a>
                                </div>
                                <form x-ref="toeflItpSettingsForm" method="POST" action="{{ route('admin.online-tests.update') }}" class="flex flex-col sm:flex-row gap-3 sm:items-end">
                                    @csrf
                                    @foreach($tests as $t)
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][enabled]" value="{{ $t['enabled'] ? '1' : '' }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][description]" value="{{ $t['description'] }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][package_number]" value="{{ $t['package_number'] ?? 1 }}">
                                        <input type="hidden" name="tests[{{ $t['slug'] }}][reference_test_id]" value="1">
                                    @endforeach
                                    <div class="w-full sm:w-56">
                                        <label class="block text-xs font-semibold text-blue-600 mb-1.5">Paket aktif</label>
                                        <select x-model="selectedPackage" name="tests[toefl_itp][package_number]" class="w-full border-blue-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                                            @php $currentPackage = (int) ($test['package_number'] ?? 1); @endphp
                                            @for($number = 1; $number <= 16; $number++)
                                                <option value="{{ $number }}" {{ $currentPackage === $number ? 'selected' : '' }}>
                                                    Paket {{ $number }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-sm transition-colors">
                                        Simpan Paket
                                    </button>
                                </form>

                                <div class="mt-3 p-3 rounded-xl border border-blue-100 bg-white">
                                    <p class="text-xs font-semibold text-blue-700 mb-2">Referensi Style dan Format Section</p>
                                    <p class="text-[11px] text-blue-500 mb-2">Tautan ini hanya untuk melihat layout dan format. Isi soal tiap paket tetap Anda input manual satu per satu.</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                                        <a target="_blank" :href="'{{ url('/online-test/toefl-itp') }}/paket' + selectedPackage + '/listening'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-blue-100 bg-blue-50 hover:bg-blue-100 text-blue-700 transition-colors">
                                            <span>Lihat format Listening</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-blue-500">Referensi</span>
                                        </a>
                                        <a target="_blank" :href="'{{ url('/online-test/toefl-itp') }}/paket' + selectedPackage + '/structure'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-blue-100 bg-blue-50 hover:bg-blue-100 text-blue-700 transition-colors">
                                            <span>Lihat format Structure</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-blue-500">Referensi</span>
                                        </a>
                                        <a target="_blank" :href="'{{ url('/online-test/toefl-itp') }}/paket' + selectedPackage + '/reading'" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-blue-100 bg-blue-50 hover:bg-blue-100 text-blue-700 transition-colors">
                                            <span>Lihat format Reading</span>
                                            <span class="ml-2 text-[10px] font-semibold uppercase tracking-wide text-blue-500">Referensi</span>
                                        </a>
                                    </div>

                                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-2 text-xs">
                                        <button type="button" @click="openAnswerKeyModal('Listening', 'listening')" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-emerald-100 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors text-left">
                                            <span>Edit Answer Key Listening</span>
                                        </button>
                                        <button type="button" @click="openAnswerKeyModal('Structure', 'structure')" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-emerald-100 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors text-left">
                                            <span>Edit Answer Key Structure</span>
                                        </button>
                                        <button type="button" @click="openAnswerKeyModal('Reading', 'reading')" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-emerald-100 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors text-left">
                                            <span>Edit Answer Key Reading</span>
                                        </button>
                                        <a href="{{ route('admin.online-tests.toefl-score.edit') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-between px-3 py-2 rounded-lg border border-indigo-100 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 transition-colors text-left">
                                            <span>Edit TOEFL ITP Score</span>
                                        </a>
                                    </div>

                                    <div x-cloak x-show="answerKeyModalOpen" x-transition.opacity x-on:keydown.escape.window="closeAnswerKeyModal()" class="fixed inset-0 z-[70] flex items-center justify-center p-3 sm:p-6" style="overscroll-behavior: contain;">
                                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeAnswerKeyModal()"></div>
                                        <div class="relative w-full max-w-[94vw] sm:max-w-xl md:max-w-2xl bg-white rounded-2xl shadow-[0_25px_60px_-12px_rgba(0,0,0,0.25)] border border-gray-200/80 overflow-hidden flex flex-col" style="max-height: 88vh;" @click.stop>
                                            <div class="relative px-5 sm:px-6 py-4 border-b border-emerald-100" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 50%, #a7f3d0 100%);">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-600 shadow-sm shadow-emerald-200">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h3 class="text-sm sm:text-base font-bold text-emerald-900 truncate" x-text="answerKeyModalTitle"></h3>
                                                        <p class="text-[11px] text-emerald-600/80 mt-0.5">Kelola kunci jawaban untuk setiap nomor soal</p>
                                                    </div>
                                                </div>
                                                <button type="button" @click="closeAnswerKeyModal()" class="absolute top-3 right-3 inline-flex items-center justify-center w-8 h-8 rounded-xl bg-white/70 hover:bg-white text-emerald-700 hover:text-red-500 transition-all duration-200 shadow-sm" aria-label="Tutup popup edit answer key">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>

                                            <div class="flex-1 min-h-0 overflow-y-auto bg-gray-50/50 overscroll-contain" style="min-height: 0; overflow-y: auto; -webkit-overflow-scrolling: touch; overscroll-behavior: contain;">
                                                <template x-if="answerKeyModalLoading">
                                                    <div class="h-full min-h-64 flex flex-col items-center justify-center gap-3 px-6">
                                                        <div class="w-8 h-8 border-3 border-emerald-200 border-t-emerald-600 rounded-full animate-spin"></div>
                                                        <p class="text-sm font-medium text-gray-500">Memuat answer key...</p>
                                                    </div>
                                                </template>

                                                <template x-if="!answerKeyModalLoading">
                                                    <div class="p-4 sm:p-5 space-y-4">
                                                        <div class="flex items-start gap-2.5 px-3.5 py-2.5 rounded-xl bg-blue-50 border border-blue-100">
                                                            <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            <p class="text-xs text-blue-700 leading-relaxed">Gunakan pemisah <strong class="font-bold">|</strong> untuk lebih dari satu jawaban pada nomor yang sama. Contoh: <code class="px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 font-mono text-[11px]">A|B</code></p>
                                                        </div>

                                                        <template x-if="answerKeyError">
                                                            <div class="flex items-center gap-2.5 rounded-xl border border-red-200 bg-red-50 px-3.5 py-2.5">
                                                                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <p class="text-xs text-red-700 font-medium" x-text="answerKeyError"></p>
                                                            </div>
                                                        </template>
                                                        <template x-if="answerKeySuccess">
                                                            <div class="flex items-center gap-2.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3.5 py-2.5">
                                                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                                <p class="text-xs text-emerald-700 font-medium" x-text="answerKeySuccess"></p>
                                                            </div>
                                                        </template>

                                                        <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                                            <table class="w-full text-xs sm:text-sm">
                                                                <thead>
                                                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100/80">
                                                                        <th class="w-20 sm:w-24 px-3 sm:px-4 py-2.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">No</th>
                                                                        <th class="px-3 sm:px-4 py-2.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Jawaban</th>
                                                                        <th class="w-14 sm:w-16 px-2 py-2.5 text-center text-[11px] font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <template x-for="(row, index) in answerKeyRows" :key="index">
                                                                        <tr class="border-t border-gray-100 transition-colors duration-150 hover:bg-emerald-50/40" :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50'">
                                                                            <td class="px-3 sm:px-4 py-1.5">
                                                                                <input type="number" min="1" x-model.number="row.question" :readonly="usesFixedQuestionSet(answerKeyModalSection)" :disabled="usesFixedQuestionSet(answerKeyModalSection)" class="w-full rounded-lg border-gray-200 bg-white text-xs sm:text-sm text-center font-semibold text-gray-700 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm py-1.5 disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed">
                                                                            </td>
                                                                            <td class="px-3 sm:px-4 py-1.5">
                                                                                <template x-if="isStrictToeflChoiceSection(answerKeyModalSection)">
                                                                                    <select x-model="row.answer" @focus="onAnswerFocus(row)" @change="onAnswerChange(row)" class="w-full rounded-lg border-gray-200 bg-white text-xs sm:text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm py-1.5">
                                                                                        <option value="">Pilih</option>
                                                                                        <option value="A">A</option>
                                                                                        <option value="B">B</option>
                                                                                        <option value="C">C</option>
                                                                                        <option value="D">D</option>
                                                                                    </select>
                                                                                </template>
                                                                                <template x-if="!isStrictToeflChoiceSection(answerKeyModalSection)">
                                                                                    <input type="text" x-model="row.answer" @focus="onAnswerFocus(row)" @change="onAnswerChange(row)" :placeholder="answerInputPlaceholder(answerKeyModalSection)" class="w-full rounded-lg border-gray-200 bg-white text-xs sm:text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm py-1.5">
                                                                                </template>
                                                                            </td>
                                                                            <td class="px-2 py-1.5 text-center">
                                                                                <button type="button" @click="removeAnswerKeyRow(index)" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all duration-200" title="Hapus baris">
                                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <button x-show="allowDynamicAnswerRows() && !usesFixedQuestionSet(answerKeyModalSection)" type="button" @click="addAnswerKeyRow()" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-dashed border-gray-300 bg-white hover:bg-emerald-50 hover:border-emerald-300 text-xs font-semibold text-gray-600 hover:text-emerald-700 transition-all duration-200 w-full justify-center">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                            Tambah Baris
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>

                                            <div class="px-5 sm:px-6 py-3.5 border-t border-gray-200 bg-white flex items-center justify-between gap-3">
                                                <a :href="answerKeyPageEndpoint(answerKeyModalSection)" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    Buka editor halaman penuh
                                                </a>
                                                <div class="flex items-center gap-2">
                                                    <button type="button" @click="closeAnswerKeyModal()" class="px-4 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-xs font-semibold text-gray-600 transition-colors">Tutup</button>
                                                    <button type="button" @click="saveAnswerKeyModal()" :disabled="answerKeyModalSaving" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-300 text-white text-xs font-bold shadow-sm shadow-emerald-100 transition-all duration-200 flex items-center gap-1.5">
                                                        <svg x-show="!answerKeyModalSaving" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                        <svg x-show="answerKeyModalSaving" class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                        <span x-text="answerKeyModalSaving ? 'Menyimpan...' : 'Simpan Answer Key'"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Batch History --}}
                            @php $archived = $test['batches']->where('is_active', false); @endphp
                            @if($archived->count() > 0)
                            <div>
                                <button @click="historyOpen = !historyOpen"
                                    class="flex items-center gap-2 text-xs font-semibold text-gray-400 hover:text-gray-600 uppercase tracking-wide transition-colors">
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="historyOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    Riwayat Batch ({{ $archived->count() }})
                                </button>
                                <div x-show="historyOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="mt-3 rounded-xl border border-gray-100 overflow-hidden">
                                    <table class="w-full text-xs">
                                        <thead>
                                            <tr class="bg-gray-50 text-gray-400 uppercase tracking-wide">
                                                <th class="px-4 py-2.5 text-left font-semibold">Nama Batch</th>
                                                <th class="px-4 py-2.5 text-left font-semibold">Kode</th>
                                                <th class="px-4 py-2.5 text-left font-semibold hidden sm:table-cell">Dibuat</th>
                                                <th class="px-4 py-2.5 text-right font-semibold">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            @foreach($archived as $batch)
                                            <tr class="hover:bg-gray-50/50 text-gray-600">
                                                <td class="px-4 py-2.5 font-medium">{{ $batch->label }}</td>
                                                <td class="px-4 py-2.5"><span class="font-mono bg-gray-100 px-2 py-0.5 rounded-md text-gray-500">{{ $batch->code }}</span></td>
                                                <td class="px-4 py-2.5 text-gray-400 hidden sm:table-cell">{{ $batch->created_at->format('d M Y') }}</td>
                                                <td class="px-4 py-2.5 text-right">
                                                    <form method="POST" action="{{ route('admin.online-tests.batch.destroy', $batch->id) }}" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Hapus riwayat batch ini?')" class="text-red-400 hover:text-red-600 font-semibold transition-colors">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            {{-- Description (collapsible) --}}
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1 transition-colors">
                                    <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    Edit Deskripsi
                                </button>
                                <div x-show="open" x-transition class="mt-2">
                                    <form method="POST" action="{{ route('admin.online-tests.update') }}" class="flex gap-2">
                                        @csrf
                                        @foreach($tests as $t)
                                            <input type="hidden" name="tests[{{ $t['slug'] }}][enabled]" value="{{ $t['enabled'] ? '1' : '' }}">
                                            <input type="hidden" name="tests[{{ $t['slug'] }}][package_number]" value="{{ $t['package_number'] ?? 1 }}">
                                            <input type="hidden" name="tests[{{ $t['slug'] }}][reference_test_id]" value="1">
                                            @if($t['slug'] === $test['slug'])
                                                <textarea name="tests[{{ $t['slug'] }}][description]" rows="2" class="flex-1 text-xs border-gray-200 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50">{{ $t['description'] }}</textarea>
                                            @else
                                                <input type="hidden" name="tests[{{ $t['slug'] }}][description]" value="{{ $t['description'] }}">
                                            @endif
                                        @endforeach
                                        <button type="submit" class="self-end px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold rounded-xl transition-colors">Simpan</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- ===== PER-USER ACCESS TABLE ===== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ search: '' }">
                    <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h2 class="font-bold text-gray-900">Kontrol Akses Per Siswa</h2>
                            <p class="text-xs text-gray-400 mt-0.5">Grant atau cabut akses siswa secara manual — tidak perlu kode.</p>
                        </div>
                        <div class="relative w-full sm:w-64">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input x-model="search" type="text" placeholder="Cari nama atau email..." class="w-full pl-8 pr-4 py-2 text-sm border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
                        </div>
                    </div>

                    {{-- Legend --}}
                    <div class="px-6 py-2.5 bg-gray-50 border-b border-gray-100 flex flex-wrap gap-4 text-xs text-gray-500">
                        <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-md bg-emerald-100 flex items-center justify-center"><svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg></span> Akses Diberikan</span>
                        <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-md bg-red-100 flex items-center justify-center"><svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></span> Akses Dicabut</span>
                        <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-md bg-gray-100"></span> Default (via kode)</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-xs text-gray-400 uppercase tracking-wide border-b border-gray-100">
                                    <th class="px-6 py-3 text-left font-semibold bg-gray-50/50 sticky left-0">Siswa</th>
                                    @foreach($tests as $test)
                                    @php $th = $themeMap[$test['slug']] ?? $themeMap['toefl_itp']; @endphp
                                    <th class="px-4 py-3 text-center font-semibold whitespace-nowrap bg-gray-50/50">
                                        <span class="inline-flex items-center gap-1 {{ $th['icon'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $th['bar'] }}"></span>
                                            {{ $test['label'] }}
                                        </span>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($users as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors" x-show="search === '' || '{{ strtolower($user->name . ' ' . $user->email) }}'.includes(search.toLowerCase())">
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-xs font-bold text-slate-600 shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm leading-tight">{{ $user->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach($tests as $test)
                                    @php
                                        $record = $userAccessRecords->get($user->id)?->firstWhere('test_slug', $test['slug']);
                                        $granted = $record?->access_granted;
                                    @endphp
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            {{-- Grant --}}
                                            <button onclick="toggleAccess({{ $user->id }}, '{{ $test['slug'] }}', true)"
                                                title="Beri Akses"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                                                    {{ $granted === true ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-50 text-gray-300 hover:bg-emerald-50 hover:text-emerald-500' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ $granted === true ? '2.5' : '2' }}" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                            {{-- Revoke --}}
                                            <button onclick="toggleAccess({{ $user->id }}, '{{ $test['slug'] }}', false)"
                                                title="Cabut Akses"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                                                    {{ $granted === false ? 'bg-red-100 text-red-500' : 'bg-gray-50 text-gray-300 hover:bg-red-50 hover:text-red-400' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ count($tests) + 1 }}" class="px-6 py-12 text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <p class="text-sm font-medium">Tidak ada siswa terdaftar</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        function toggleAccess(userId, testSlug, grant) {
            fetch('{{ route('admin.online-tests.user-access.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ user_id: userId, test_slug: testSlug, grant: grant }),
            })
            .then(r => r.json())
            .then(() => location.reload())
            .catch(() => alert('Gagal mengubah akses. Silakan coba lagi.'));
        }
    </script>

</body>
</html>
