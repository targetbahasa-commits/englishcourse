<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $trackTitle }} - Meeting {{ $meetingLabel ?? $meetingNumber }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .word-correct { color: #2ecc71; font-weight: 700; }
        .word-extra { color: #3498db; font-weight: 700; text-decoration: line-through; }
        .word-missing { color: #f1c40f; font-weight: 700; }
        .word-wrong { color: #e74c3c; font-weight: 700; text-decoration: underline; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-4 sm:p-6 md:p-8">
            <!-- Topbar -->
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-6 md:mb-8">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Search">
                </div>
                <div class="flex items-center gap-6">
                    @include('components.topbar-action-icons')
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $trackTitle }}</h2>
                    <p class="text-gray-500 text-sm">Meeting {{ $meetingLabel ?? $meetingNumber }} &mdash; {{ $topic }}</p>
                </div>
                <x-grammar-meeting-actions :meetingNumber="$meetingNumber ?? $meeting" track="introductory" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-8">
                @if(!empty($cheatSheet['__html__']))
                <div class="lg:col-span-5 sticky top-6 self-start max-h-[calc(100vh-2rem)] overflow-y-auto pr-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">
                        {!! $cheatSheet['__html__'] !!}
                    </div>
                </div>
                @endif

                <div class="{{ !empty($cheatSheet['__html__']) ? 'lg:col-span-7' : 'lg:col-span-12' }}">
                @if(isset($questions) && count($questions) > 0)
                <form method="POST" action="{{ route('assignments.grammar-writing.introductory.meeting.submit', ['meeting' => $meetingNumber]) }}" class="bg-white rounded-3xl shadow-sm border border-orange-100 overflow-visible">
                    @csrf
                    <div class="bg-gradient-to-r from-orange-50 via-amber-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-orange-100">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">Soal Meeting {{ $meetingLabel ?? $meetingNumber }}</h3>
                                <p class="text-gray-600 mt-1 text-sm sm:text-base">Terjemahkan dan isi jawaban untuk setiap soal di bawah ini.</p>
                            </div>
                            <div class="flex items-center gap-3">
                                @if(($submitted ?? false) === true)
                                    <span class="inline-flex items-center justify-center rounded-full bg-orange-600 text-white text-xs font-bold px-3 py-1.5 w-fit">
                                        Skor: {{ $score }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center rounded-full bg-orange-600 text-white text-xs font-bold px-3 py-1.5 w-fit">
                                        {{ count($questions) }} Soal
                                    </span>
                                @endif
                                @if(Auth::user()->isAdmin())
                                    <button type="button" onclick="openBulkIntroQuestionEditor({{ $meetingNumber }})" class="text-xs text-orange-700 hover:text-orange-900 underline font-semibold">Edit Massal</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tips Menerjemahkan Soal Box -->
                    <div class="mx-5 sm:mx-8 mt-5 p-4 sm:p-5 rounded-2xl bg-amber-50/90 border border-amber-200 text-amber-950 shadow-xs">
                        <div class="flex items-center gap-2 mb-2 font-bold text-amber-900 text-sm sm:text-base">
                            <span class="text-lg">💡</span> Tips & Panduan Menerjemahkan Soal
                        </div>
                        <ul class="list-disc list-inside space-y-1.5 text-xs sm:text-sm text-amber-900 leading-relaxed">
                            <li><strong>Langkah 1: Identifikasi Subjek & Predikat Utama</strong> — Cari kata benda utama sebagai subjek dan kata kerja/keadaan sebagai predikat.</li>
                            <li><strong>Langkah 2: Tentukan Jenis Predikat</strong> — Bedakan Verbal (aksi aktif), Nominal (keadaan/sifat), atau Pasif (di-/ter-).</li>
                            <li><strong>Langkah 3: Tentukan Tense & Aspek Waktu</strong> — Perhatikan kata penanda waktu: <em>sedang</em> (Continuous), <em>telah/sudah</em> (Perfect), <em>lalu/dulu</em> (Past), <em>rutin/fakta</em> (Present).</li>
                            <li><strong>Langkah 4: Susun Frasa Kata Benda (Noun Phrase)</strong> — Posisikan kata sifat (Adjective) sebelum Head Noun (misal: <em>buku baru → new book</em>).</li>
                        </ul>
                        <div class="mt-3 pt-2.5 border-t border-amber-200/70 text-xs font-semibold text-amber-800 flex items-center gap-1">
                            <span>📌 Note:</span> <span>adalah, ada, berada, berupa, merupakan = <strong>Nominal (Gunakan be)</strong></span>
                        </div>
                    </div>

                    <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                        <ol class="space-y-4 sm:space-y-5">
                            @foreach($questions as $i => $q)
                                @php
                                    $qNum = $i + 1;
                                    $helper = $questionHelpers[$qNum] ?? ['example' => null, 'vocab' => []];
                                    $qResult = $results[$qNum] ?? null;
                                    $editorEntry = $questionEditorData[$qNum] ?? null;
                                @endphp
                                <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-orange-200 space-y-3 overflow-visible">
                                    <div class="flex items-start gap-3 sm:gap-4">
                                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center text-sm font-bold shrink-0">
                                            {{ $qNum }}
                                        </div>
                                        <div class="pt-1 flex-1">
                                            <p class="text-gray-800 leading-relaxed">{{ $q }}</p>
                                        </div>
                                        <div class="flex flex-row items-center gap-1 ml-2">
                                            @if(!empty($helper['example']))
                                                <div x-data="{ open: false }" class="relative inline-block">
                                                    <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                        ?
                                                    </button>
                                                    <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed" style="display: none;">
                                                        <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                        {{ $helper['example']['id'] }}<br>
                                                        <em class="text-gray-300">{{ $helper['example']['en'] }}</em>
                                                        <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(!empty($helper['vocab']))
                                                <div x-data="{ open: false }" class="relative inline-block">
                                                    <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                                        v
                                                    </button>
                                                    <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                        <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                        <ul class="space-y-1">
                                                            @foreach($helper['vocab'] as $word => $info)
                                                                <li class="flex justify-between gap-3">
                                                                    <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ $info['pos'] }}</span></span>
                                                                    <span>{{ $info['id'] }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(Auth::user()->isAdmin() && $editorEntry)
                                                <button type="button" onclick="openIntroQuestionEditor({{ Js::from(['meetingNumber' => $meetingNumber, 'questionNumber' => $qNum, 'questionText' => $editorEntry['question_text'], 'correctAnswer' => $editorEntry['correct_answer'], 'dbId' => $editorEntry['db_id']]) }})" class="w-6 h-6 rounded-md bg-orange-50 border border-orange-200 text-orange-600 flex items-center justify-center text-xs font-bold hover:bg-orange-100 transition-colors focus:outline-none shadow-sm" title="Edit soal">
                                                    e
                                                </button>
                                                @if($editorEntry['db_id'])
                                                    <button type="button" onclick="deleteIntroQuestionOverride({{ $editorEntry['db_id'] }})" class="w-6 h-6 rounded-md bg-red-50 border border-red-200 text-red-600 flex items-center justify-center text-xs font-bold hover:bg-red-100 transition-colors focus:outline-none shadow-sm" title="Hapus override">
                                                        x
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    @if(($submitted ?? false) === true && $qResult)
                                        <div class="ml-11 sm:ml-13 space-y-2">
                                            <p class="text-sm text-gray-500">Jawaban kamu:</p>
                                            <p class="text-base leading-relaxed">{!! $qResult['formatted_answer'] !== '' ? $qResult['formatted_answer'] : '<em class="text-gray-400">(tidak dijawab)</em>' !!}</p>
                                            <p class="text-xs text-gray-500">Skor: <span class="font-semibold text-gray-700">{{ $qResult['score'] }}/10</span> &middot; Kunci: <span class="italic">{{ $qResult['correct_answer'] }}</span></p>
                                        </div>
                                    @elseif($meetingNumber === 11)
                                        <div class="ml-11 sm:ml-13 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <input type="text"
                                                   name="meeting11_answers[{{ $qNum }}][v2]"
                                                   class="grammar-draft-input w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition bg-white hover:border-gray-400"
                                                   placeholder="Verb 2 (Past)"
                                                   value="{{ $draftAnswers[$qNum . '_v2'] ?? '' }}"
                                                   data-draft-key="{{ $qNum }}_v2"
                                                   autocomplete="off">
                                            <input type="text"
                                                   name="meeting11_answers[{{ $qNum }}][v3]"
                                                   class="grammar-draft-input w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition bg-white hover:border-gray-400"
                                                   placeholder="Verb 3 (Past Participle)"
                                                   value="{{ $draftAnswers[$qNum . '_v3'] ?? '' }}"
                                                   data-draft-key="{{ $qNum }}_v3"
                                                   autocomplete="off">
                                        </div>
                                    @else
                                        <div class="ml-11 sm:ml-13">
                                            <input type="text"
                                                   name="answers[{{ $qNum }}]"
                                                   class="grammar-draft-input w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition bg-white hover:border-gray-400"
                                                   placeholder="Tulis bahasa Inggrisnya di sini..."
                                                   value="{{ $draftAnswers[$qNum] ?? '' }}"
                                                   data-draft-key="{{ $qNum }}"
                                                   autocomplete="off">
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ol>

                        @if($paragraphData)
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div>
                                        <h4 class="text-base font-bold text-gray-800">Paragraf</h4>
                                        <p class="text-gray-700 leading-relaxed mt-1">{{ $paragraphData['id'] }}</p>
                                    </div>
                                    @if(Auth::user()->isAdmin())
                                        <button type="button" onclick="openIntroParagraphEditor({{ Js::from(['meetingNumber' => $meetingNumber, 'paragraphId' => $paragraphEditorData['id'] ?? '', 'paragraphEn' => $paragraphEditorData['en'] ?? '', 'dbId' => $paragraphEditorData['db_id'] ?? null]) }})" class="text-xs text-orange-600 hover:text-orange-800 underline font-semibold shrink-0">Edit</button>
                                    @endif
                                </div>
                                @if(($submitted ?? false) === true && $paragraphResult)
                                    <p class="text-base leading-relaxed">{!! $paragraphResult['formatted_answer'] !== '' ? $paragraphResult['formatted_answer'] : '<em class="text-gray-400">(tidak dijawab)</em>' !!}</p>
                                    <p class="text-xs text-gray-500 mt-2">Skor: <span class="font-semibold text-gray-700">{{ $paragraphResult['score'] }}/{{ $paragraphResult['max_score'] }}</span> &middot; Kunci: <span class="italic">{{ $paragraphResult['correct_answer'] }}</span></p>
                                @else
                                    <textarea name="paragraph_answer" id="grammar-draft-paragraph" rows="4" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition bg-white hover:border-gray-400" placeholder="Tulis terjemahan paragraf dalam bahasa Inggris...">{{ $draftParagraphAnswer ?? '' }}</textarea>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="px-5 py-6 sm:px-8 border-t border-gray-100 bg-gray-50/60 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('assignments.grammar-writing.track', 'introductory') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
                        @if(($submitted ?? false) === true)
                            <button type="submit"
                                    formaction="{{ route('assignments.grammar-writing.introductory.meeting.reset', ['meeting' => $meetingNumber]) }}"
                                    formmethod="POST"
                                    class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-gray-600 text-white rounded-xl font-bold hover:bg-gray-700 transition shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 104.582 9m0 0H9"></path>
                                </svg>
                                Reset Jawaban
                            </button>
                        @else
                            <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-orange-500 text-white rounded-xl font-bold hover:bg-orange-600 transition shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Kirim Jawaban
                            </button>
                        @endif
                    </div>
                </form>
                @else
                <div class="flex flex-col items-center justify-center min-h-[60vh]">
                    <div class="bg-white rounded-3xl shadow-sm p-16 text-center max-w-lg w-full">
                        <div class="w-20 h-20 bg-orange-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Meeting {{ $meetingLabel ?? $meetingNumber }}</h3>
                        <p class="text-orange-500 font-semibold text-lg mb-4">{{ $topic }}</p>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Konten untuk meeting ini sedang disiapkan.<br>
                            Silakan tunggu update berikutnya.
                        </p>
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('assignments.grammar-writing.track', 'introductory') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
                        </div>
                    </div>
                </div>
                @endif
                </div>
            </div>
        </main>
    </div>

    <form id="intro-question-create-form" method="POST" action="{{ route('admin.grammar.question.store') }}" class="hidden">
        @csrf
        <input type="hidden" name="meeting_number" id="intro-create-meeting-number">
        <input type="hidden" name="question_number" id="intro-create-question-number">
        <input type="hidden" name="section" id="intro-create-section">
        <input type="hidden" name="question_text" id="intro-create-question-text">
        <input type="hidden" name="correct_answer" id="intro-create-correct-answer">
    </form>

    <form id="intro-question-update-form" method="POST" action="" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="section" id="intro-update-section">
        <input type="hidden" name="question_text" id="intro-update-question-text">
        <input type="hidden" name="correct_answer" id="intro-update-correct-answer">
    </form>

    <form id="intro-question-delete-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <form id="intro-paragraph-create-form" method="POST" action="{{ route('admin.grammar.question.store') }}" class="hidden">
        @csrf
        <input type="hidden" name="meeting_number" id="intro-paragraph-create-meeting-number">
        <input type="hidden" name="question_number" id="intro-paragraph-create-question-number" value="0">
        <input type="hidden" name="section" id="intro-paragraph-create-section">
        <input type="hidden" name="question_text" id="intro-paragraph-create-id-text">
        <input type="hidden" name="correct_answer" id="intro-paragraph-create-en-text">
    </form>

    <form id="intro-paragraph-update-form" method="POST" action="" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="section" id="intro-paragraph-update-section">
        <input type="hidden" name="question_text" id="intro-paragraph-update-id-text">
        <input type="hidden" name="correct_answer" id="intro-paragraph-update-en-text">
    </form>

    <form id="intro-paragraph-delete-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <div id="intro-question-editor-modal" class="fixed inset-0 z-[100] hidden" aria-hidden="true">
        <div id="intro-question-editor-overlay" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Editor Soal Introductory</h3>
                    <button type="button" id="intro-question-editor-close" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">Tutup</button>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nomor Soal</p>
                        <p id="intro-question-editor-number" class="text-sm font-semibold text-gray-700">-</p>
                    </div>
                    <div>
                        <label for="intro-question-editor-text" class="block text-sm font-semibold text-gray-700 mb-1">Teks Soal (Indonesia)</label>
                        <textarea id="intro-question-editor-text" rows="4" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                    </div>
                    <div>
                        <label for="intro-question-editor-answer" class="block text-sm font-semibold text-gray-700 mb-1">Kunci Jawaban (English)</label>
                        <textarea id="intro-question-editor-answer" rows="4" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                    </div>
                </div>
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2">
                    <button type="button" id="intro-question-editor-cancel" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50">Batal</button>
                    <button type="button" id="intro-question-editor-save" class="px-4 py-2 rounded-lg bg-orange-500 text-white text-sm font-semibold hover:bg-orange-600">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div id="intro-paragraph-editor-modal" class="fixed inset-0 z-[100] hidden" aria-hidden="true">
        <div id="intro-paragraph-editor-overlay" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Editor Paragraph Introductory</h3>
                    <button type="button" id="intro-paragraph-editor-close" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">Tutup</button>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label for="intro-paragraph-editor-id" class="block text-sm font-semibold text-gray-700 mb-1">Paragraf (Indonesia)</label>
                        <textarea id="intro-paragraph-editor-id" rows="7" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>
                    <div>
                        <label for="intro-paragraph-editor-en" class="block text-sm font-semibold text-gray-700 mb-1">Jawaban Referensi (English)</label>
                        <textarea id="intro-paragraph-editor-en" rows="7" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>
                </div>
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-2">
                    <button type="button" id="intro-paragraph-editor-delete" class="px-4 py-2 rounded-lg bg-red-50 text-red-700 border border-red-200 text-sm font-semibold hover:bg-red-100 hidden">Hapus Override</button>
                    <div class="flex items-center gap-2">
                        <button type="button" id="intro-paragraph-editor-cancel" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50">Batal</button>
                        <button type="button" id="intro-paragraph-editor-save" class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Edit Modal -->
    <div id="intro-bulk-editor-modal" class="fixed inset-0 z-[100] hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-black/50" onclick="closeBulkIntroQuestionEditor()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden relative z-10 flex flex-col max-h-full">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                    <h3 class="text-lg font-bold text-gray-800" id="intro-bulk-editor-title">Bulk Edit Soal</h3>
                    <button type="button" onclick="closeBulkIntroQuestionEditor()" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">Tutup</button>
                </div>
                <form id="intro-bulk-question-form" method="POST" action="{{ route('admin.grammar.question.bulk-introductory') }}" class="flex flex-col overflow-hidden min-h-[400px]">
                    @csrf
                    <input type="hidden" name="meeting_number" id="intro-bulk-meeting-number" value="">
                    <div class="p-5 flex-1 overflow-y-auto">
                        <div class="mb-2">
                            <label for="intro-bulk-editor-text" class="block text-sm font-semibold text-gray-700 mb-1">List Soal (1 baris per soal)</label>
                            <p class="text-xs text-gray-500 mb-2">Paste semua kalimat di sini. Setiap baris baru (enter) akan dianggap sebagai soal baru. Kunci jawaban (jika sudah ada) tidak akan terhapus.</p>
                            <textarea id="intro-bulk-editor-text" name="questions_text" rows="15" class="w-full h-full min-h-[300px] rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 font-mono whitespace-pre" required></textarea>
                        </div>
                    </div>
                    <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2 shrink-0">
                        <button type="button" onclick="closeBulkIntroQuestionEditor()" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Simpan Bulk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentIntroEditorPayload = null;
        let currentIntroParagraphPayload = null;

        function openBulkIntroQuestionEditor(meetingNumber) {
            document.getElementById('intro-bulk-meeting-number').value = meetingNumber;
            // Pre-fill with existing questions if possible
            const questionTexts = [];
            document.querySelectorAll('.group p.text-gray-800.leading-relaxed').forEach(p => {
                questionTexts.push(p.textContent.trim());
            });
            document.getElementById('intro-bulk-editor-text').value = questionTexts.join('\n');

            const modal = document.getElementById('intro-bulk-editor-modal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            setTimeout(() => document.getElementById('intro-bulk-editor-text').focus(), 0);
        }

        function closeBulkIntroQuestionEditor() {
            const modal = document.getElementById('intro-bulk-editor-modal');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
        }

        function openIntroQuestionEditor(payload) {
            currentIntroEditorPayload = payload;

            document.getElementById('intro-question-editor-number').textContent = `Meeting ${payload.meetingNumber} - Soal ${payload.questionNumber}`;
            document.getElementById('intro-question-editor-text').value = payload.questionText || '';
            document.getElementById('intro-question-editor-answer').value = payload.correctAnswer || '';

            const modal = document.getElementById('intro-question-editor-modal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');

            setTimeout(() => {
                document.getElementById('intro-question-editor-text').focus();
            }, 0);
        }

        function closeIntroQuestionEditor() {
            const modal = document.getElementById('intro-question-editor-modal');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            currentIntroEditorPayload = null;
        }

        function saveIntroQuestionEditor() {
            if (!currentIntroEditorPayload) {
                return;
            }

            const trimmedQuestionText = document.getElementById('intro-question-editor-text').value.trim();
            const trimmedCorrectAnswer = document.getElementById('intro-question-editor-answer').value.trim();

            if (!trimmedQuestionText || !trimmedCorrectAnswer) {
                window.alert('Soal dan kunci jawaban wajib diisi.');
                return;
            }

            if (currentIntroEditorPayload.dbId) {
                const updateForm = document.getElementById('intro-question-update-form');
                updateForm.action = `/admin/assignments/grammar-writing/questions/${currentIntroEditorPayload.dbId}`;
                document.getElementById('intro-update-section').value = `introductory_${currentIntroEditorPayload.meetingNumber}`;
                document.getElementById('intro-update-question-text').value = trimmedQuestionText;
                document.getElementById('intro-update-correct-answer').value = trimmedCorrectAnswer;
                updateForm.submit();
                return;
            }

            const createForm = document.getElementById('intro-question-create-form');
            document.getElementById('intro-create-meeting-number').value = currentIntroEditorPayload.meetingNumber;
            document.getElementById('intro-create-question-number').value = currentIntroEditorPayload.questionNumber;
            document.getElementById('intro-create-section').value = `introductory_${currentIntroEditorPayload.meetingNumber}`;
            document.getElementById('intro-create-question-text').value = trimmedQuestionText;
            document.getElementById('intro-create-correct-answer').value = trimmedCorrectAnswer;
            createForm.submit();
        }

        function deleteIntroQuestionOverride(dbId) {
            if (!window.confirm('Hapus override soal ini? Soal akan kembali ke default.')) {
                return;
            }

            const deleteForm = document.getElementById('intro-question-delete-form');
            deleteForm.action = `/admin/assignments/grammar-writing/questions/${dbId}`;
            deleteForm.submit();
        }

        function openIntroParagraphEditor(payload) {
            currentIntroParagraphPayload = payload;

            document.getElementById('intro-paragraph-editor-id').value = payload.paragraphId || '';
            document.getElementById('intro-paragraph-editor-en').value = payload.paragraphEn || '';

            const deleteButton = document.getElementById('intro-paragraph-editor-delete');
            if (payload.dbId) {
                deleteButton.classList.remove('hidden');
            } else {
                deleteButton.classList.add('hidden');
            }

            const modal = document.getElementById('intro-paragraph-editor-modal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');

            setTimeout(() => {
                document.getElementById('intro-paragraph-editor-id').focus();
            }, 0);
        }

        function closeIntroParagraphEditor() {
            const modal = document.getElementById('intro-paragraph-editor-modal');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            currentIntroParagraphPayload = null;
        }

        function saveIntroParagraphEditor() {
            if (!currentIntroParagraphPayload) {
                return;
            }

            const paragraphId = document.getElementById('intro-paragraph-editor-id').value.trim();
            const paragraphEn = document.getElementById('intro-paragraph-editor-en').value.trim();

            if (!paragraphId || !paragraphEn) {
                window.alert('Paragraf Indonesia dan jawaban English wajib diisi.');
                return;
            }

            if (currentIntroParagraphPayload.dbId) {
                const updateForm = document.getElementById('intro-paragraph-update-form');
                updateForm.action = `/admin/assignments/grammar-writing/questions/${currentIntroParagraphPayload.dbId}`;
                document.getElementById('intro-paragraph-update-section').value = `introductory_${currentIntroParagraphPayload.meetingNumber}_paragraph`;
                document.getElementById('intro-paragraph-update-id-text').value = paragraphId;
                document.getElementById('intro-paragraph-update-en-text').value = paragraphEn;
                updateForm.submit();
                return;
            }

            const createForm = document.getElementById('intro-paragraph-create-form');
            document.getElementById('intro-paragraph-create-meeting-number').value = currentIntroParagraphPayload.meetingNumber;
            document.getElementById('intro-paragraph-create-section').value = `introductory_${currentIntroParagraphPayload.meetingNumber}_paragraph`;
            document.getElementById('intro-paragraph-create-id-text').value = paragraphId;
            document.getElementById('intro-paragraph-create-en-text').value = paragraphEn;
            createForm.submit();
        }

        function deleteIntroParagraphOverride() {
            if (!currentIntroParagraphPayload || !currentIntroParagraphPayload.dbId) {
                return;
            }

            if (!window.confirm('Hapus override paragraf ini? Paragraf akan kembali ke default.')) {
                return;
            }

            const deleteForm = document.getElementById('intro-paragraph-delete-form');
            deleteForm.action = `/admin/assignments/grammar-writing/questions/${currentIntroParagraphPayload.dbId}`;
            deleteForm.submit();
        }

        document.getElementById('intro-question-editor-save')?.addEventListener('click', saveIntroQuestionEditor);
        document.getElementById('intro-question-editor-cancel')?.addEventListener('click', closeIntroQuestionEditor);
        document.getElementById('intro-question-editor-close')?.addEventListener('click', closeIntroQuestionEditor);
        document.getElementById('intro-question-editor-overlay')?.addEventListener('click', closeIntroQuestionEditor);

        document.getElementById('intro-paragraph-editor-save')?.addEventListener('click', saveIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-cancel')?.addEventListener('click', closeIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-close')?.addEventListener('click', closeIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-overlay')?.addEventListener('click', closeIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-delete')?.addEventListener('click', deleteIntroParagraphOverride);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                const modal = document.getElementById('intro-question-editor-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeIntroQuestionEditor();
                }

                const paragraphModal = document.getElementById('intro-paragraph-editor-modal');
                if (paragraphModal && !paragraphModal.classList.contains('hidden')) {
                    closeIntroParagraphEditor();
                }
            }
        });

        @if(($submitted ?? false) !== true)
        (function () {
            const draftUrl = {{ Js::from(route('assignments.grammar-writing.track-meeting.draft', ['track' => 'introductory', 'meeting' => $meetingNumber])) }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const storageKey = 'tb_gw_draft_introductory_m{{ $meetingNumber }}_{{ auth()->id() ?? "guest" }}';
            let draftTimer = null;

            function collectAnswers() {
                const answers = {};
                document.querySelectorAll('.grammar-draft-input').forEach((el) => {
                    if (el.dataset.draftKey) {
                        answers[el.dataset.draftKey] = el.value;
                    }
                });
                const paragraphEl = document.getElementById('grammar-draft-paragraph');
                const paragraphAnswer = paragraphEl ? paragraphEl.value : '';
                return { answers, paragraphAnswer };
            }

            function saveToLocalStorage(data) {
                try {
                    localStorage.setItem(storageKey, JSON.stringify({ ...data, savedAt: Date.now() }));
                } catch (e) {}
            }

            function restoreFromLocalStorage() {
                try {
                    const raw = localStorage.getItem(storageKey);
                    if (!raw) return;
                    const data = JSON.parse(raw);
                    if (!data) return;

                    let restoredAny = false;
                    if (data.answers) {
                        document.querySelectorAll('.grammar-draft-input').forEach((el) => {
                            const key = el.dataset.draftKey;
                            if (key && data.answers[key] && !el.value) {
                                el.value = data.answers[key];
                                restoredAny = true;
                            }
                        });
                    }
                    const paragraphEl = document.getElementById('grammar-draft-paragraph');
                    if (paragraphEl && data.paragraphAnswer && !paragraphEl.value) {
                        paragraphEl.value = data.paragraphAnswer;
                        restoredAny = true;
                    }

                    if (restoredAny) {
                        syncGrammarDraft();
                    }
                } catch (e) {}
            }

            let currentCsrf = csrfToken;

            async function refreshCsrfToken() {
                try {
                    const res = await fetch('/refresh-csrf');
                    if (res.ok) {
                        const json = await res.json();
                        if (json.token) {
                            currentCsrf = json.token;
                            const meta = document.querySelector('meta[name="csrf-token"]');
                            if (meta) meta.setAttribute('content', json.token);
                            return json.token;
                        }
                    }
                } catch (e) {}
                return null;
            }

            async function syncGrammarDraft() {
                const data = collectAnswers();
                saveToLocalStorage(data);

                if (!draftUrl) return false;

                try {
                    let response = await fetch(draftUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': currentCsrf,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            answers: data.answers,
                            paragraph_answer: data.paragraphAnswer,
                        }),
                        keepalive: true,
                    });

                    if (response.status === 419) {
                        const freshToken = await refreshCsrfToken();
                        if (freshToken) {
                            response = await fetch(draftUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': freshToken,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: JSON.stringify({
                                    answers: data.answers,
                                    paragraph_answer: data.paragraphAnswer,
                                }),
                                keepalive: true,
                            });
                        }
                    }

                    return response.ok;
                } catch (e) {
                    console.error('Failed to sync grammar draft:', e);
                    return false;
                }
            }

            function queueGrammarDraftSync() {
                const data = collectAnswers();
                saveToLocalStorage(data);
                clearTimeout(draftTimer);
                draftTimer = setTimeout(syncGrammarDraft, 600);
            }

            restoreFromLocalStorage();

            document.querySelectorAll('.grammar-draft-input').forEach((el) => {
                el.addEventListener('input', queueGrammarDraftSync);
                el.addEventListener('change', queueGrammarDraftSync);
                el.addEventListener('blur', queueGrammarDraftSync);
            });
            const paragraphEl = document.getElementById('grammar-draft-paragraph');
            if (paragraphEl) {
                paragraphEl.addEventListener('input', queueGrammarDraftSync);
                paragraphEl.addEventListener('change', queueGrammarDraftSync);
                paragraphEl.addEventListener('blur', queueGrammarDraftSync);
            }

            // Periodic heartbeat sync every 45 seconds
            setInterval(() => {
                const data = collectAnswers();
                if (Object.keys(data.answers).length > 0 || data.paragraphAnswer !== '') {
                    syncGrammarDraft();
                }
            }, 45000);

            // Lifecycle listeners for mobile / tab switching / reconnecting / focus
            document.addEventListener('visibilitychange', () => {
                syncGrammarDraft();
            });
            window.addEventListener('focus', () => {
                syncGrammarDraft();
            });
            window.addEventListener('online', () => {
                syncGrammarDraft();
            });
            window.addEventListener('pageshow', () => {
                restoreFromLocalStorage();
                syncGrammarDraft();
            });
            window.addEventListener('beforeunload', () => {
                syncGrammarDraft();
            });

            async function manualSaveGrammarDraft() {
                const btn = document.getElementById('manual-save-btn');
                if (btn) {
                    btn.dataset.originalText = btn.dataset.originalText || btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = 'Menyimpan...';
                }

                const ok = await syncGrammarDraft();

                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = btn.dataset.originalText;
                }

                const indicator = document.createElement('div');
                if (ok) {
                    indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                    indicator.innerHTML = '\u2713 Tersimpan';
                } else {
                    indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-amber-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                    indicator.innerHTML = '\u2713 Tersimpan di browser';
                }
                document.body.appendChild(indicator);
                setTimeout(() => {
                    indicator.style.transition = 'opacity 0.3s';
                    indicator.style.opacity = '0';
                    setTimeout(() => indicator.remove(), 300);
                }, 3000);
            }
            window.manualSaveGrammarDraft = manualSaveGrammarDraft;
        })();
        @endif
    </script>


    @if((int) ($meetingNumber ?? 0) === 10)
    @endif
    @include('components.student-broadcaster')

    <x-live-drawing />

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

    @if(($submitted ?? false) !== true)
        <div class="fixed bottom-4 z-50" style="left: 50%; transform: translateX(-50%);">
            <button type="button" id="manual-save-btn" onclick="manualSaveGrammarDraft()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-sm font-semibold shadow-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3M8 7h8"></path></svg>
                Save
            </button>
        </div>
    @endif

</body>
</html>
