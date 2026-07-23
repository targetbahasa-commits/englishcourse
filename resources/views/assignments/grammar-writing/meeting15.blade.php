<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 15</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('assignments.grammar-writing') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
        </div>

        <h1 class="text-3xl font-bold text-center text-rose-600 mb-8">Adjective Clause RPP & Relative Adverb (Pertemuan 15)</h1>
        
        <!-- Tips Box -->
        <div class="bg-rose-50 border border-rose-200 text-rose-900 p-6 rounded-xl mb-8">
            <strong class="block mb-2 text-lg">💡 Tips:</strong>
            <p class="text-sm">Tentukan dahulu <strong>Subject Main Clause</strong> dan <strong>Verb Main Clause</strong> sebelum menerjemahkan!</p>
            <div class="mt-3 text-xs space-y-1">
                <p>• <strong>Relative Pronoun Possessive (whose)</strong>: menunjukkan kepemilikan</p>
                <p>• Contoh: "Tanaman <strong>yang reproduksinya</strong>..." = "Plants <strong>whose reproduction</strong>..."</p>
                <p>• <strong>Relative Adverb</strong>: where (tempat), when (waktu), why (alasan), how (cara)</p>
                <p>• Contoh: "Ekologi <strong>dimana</strong> makhluk hidup..." = "Ecology <strong>where</strong> living creatures..."</p>
            </div>
        </div>

        @if($submitted)
            <div class="bg-rose-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-rose-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('assignments.grammar-writing.meeting15.submit') }}">
            @csrf
            
            <!-- Section 1: Adjective Clause RPP (whose) -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">A. Adjective Clause RPP (whose) - Soal 1-11</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <button type="button"
                                @click="$dispatch('open-add-modal')"
                                class="bg-violet-600 hover:bg-violet-700 text-white text-sm font-bold py-2 px-4 rounded shadow-sm transition-colors">
                            + Add Question
                        </button>
                    @endif
                </div>
                <div class="space-y-6">
                    @foreach($questions as $idx => $data)
                        @if($idx <= 11)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-rose-500 shadow-sm">
                            <div class="flex justify-between items-start mb-4">
                                <label class="block font-bold text-lg text-gray-800">{{ $idx }}. {{ $data['id'] }}</label>
                                <div class="flex gap-2 ml-2">
                                    <!-- Example Button -->
                                    @if(isset($data['example']))
                                    <div x-data="{ open: false }" class="relative inline-block">
                                        <button type="button" @click="open = !open" @click.outside="open = false" class="text-yellow-600 hover:text-yellow-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-yellow-50 px-2 py-0.5 rounded border border-yellow-100 w-6 h-6 flex items-center justify-center">
                                            ?
                                        </button>
                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 translate-y-0"
                                             x-transition:leave-end="opacity-0 translate-y-2"
                                             style="display: none;"
                                             class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                            <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                            {{ $data['example']['id'] }}<br>
                                            <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Vocabulary Helper Button -->
                                    @if(isset($data['vocab']) && count($data['vocab']) > 0)
                                    <div x-data="{ open: false }" class="relative inline-block">
                                        <button type="button" @click="open = !open" @click.outside="open = false" class="text-green-600 hover:text-green-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-green-50 px-2 py-0.5 rounded border border-green-100 w-6 h-6 flex items-center justify-center">
                                            v
                                        </button>
                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 translate-y-0"
                                             x-transition:leave-end="opacity-0 translate-y-2"
                                             style="display: none;"
                                             class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                            <ul class="space-y-1">
                                                @foreach($data['vocab'] as $en => $vocabItem)
                                                    <li class="flex justify-between">
                                                        <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ $vocabItem['pos'] }}</span></span>
                                                        <span>{{ $vocabItem['id'] }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- Admin Buttons -->
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <div class="flex gap-2 ml-2 border-l pl-2 border-gray-200">
                                            <button type="button" 
                                                    data-payload="{{ json_encode([
                                                        'id' => $data['db_id'], 
                                                        'question_text' => $data['id'], 
                                                        'correct_answer' => $data['en'],
                                                        'example_id' => $data['example']['id'] ?? '',
                                                        'example_en' => $data['example']['en'] ?? '',
                                                        'vocab' => json_encode($data['vocab'] ?? [])
                                                    ]) }}"
                                                    onclick="openEditModal(this)"
                                                    class="w-8 h-8 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button type="button" 
                                                    onclick="confirmDelete('{{ $data['db_id'] }}')"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[{{ $idx }}]"
                                       value="{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-rose-500 focus:ring-1 focus:ring-rose-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
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
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Section 2: Relative Adverb -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">B. Relative Adverb (where, when, why, how) - Soal 12-26</h3>
                <div class="space-y-6">
                    @foreach($questions as $idx => $data)
                        @if($idx >= 12)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-blue-500 shadow-sm">
                            <div class="flex justify-between items-start mb-4">
                                <label class="block font-bold text-lg text-gray-800">{{ $idx }}. {{ $data['id'] }}</label>
                                <div class="flex gap-2 ml-2">
                                    <!-- Example Button -->
                                    @if(isset($data['example']))
                                    <div x-data="{ open: false }" class="relative inline-block">
                                        <button type="button" @click="open = !open" @click.outside="open = false" class="text-yellow-600 hover:text-yellow-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-yellow-50 px-2 py-0.5 rounded border border-yellow-100 w-6 h-6 flex items-center justify-center">
                                            ?
                                        </button>
                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 translate-y-0"
                                             x-transition:leave-end="opacity-0 translate-y-2"
                                             style="display: none;"
                                             class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                            <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                            {{ $data['example']['id'] }}<br>
                                            <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Vocabulary Helper Button -->
                                    @if(isset($data['vocab']) && count($data['vocab']) > 0)
                                    <div x-data="{ open: false }" class="relative inline-block">
                                        <button type="button" @click="open = !open" @click.outside="open = false" class="text-green-600 hover:text-green-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-green-50 px-2 py-0.5 rounded border border-green-100 w-6 h-6 flex items-center justify-center">
                                            v
                                        </button>
                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 translate-y-0"
                                             x-transition:leave-end="opacity-0 translate-y-2"
                                             style="display: none;"
                                             class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                            <ul class="space-y-1">
                                                @foreach($data['vocab'] as $en => $vocabItem)
                                                    <li class="flex justify-between">
                                                        <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ $vocabItem['pos'] }}</span></span>
                                                        <span>{{ $vocabItem['id'] }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- Admin Buttons -->
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <div class="flex gap-2 ml-2 border-l pl-2 border-gray-200">
                                            <button type="button" 
                                                    data-payload="{{ json_encode([
                                                        'id' => $data['db_id'], 
                                                        'question_text' => $data['id'], 
                                                        'correct_answer' => $data['en'],
                                                        'example_id' => $data['example']['id'] ?? '',
                                                        'example_en' => $data['example']['en'] ?? '',
                                                        'vocab' => json_encode($data['vocab'] ?? [])
                                                    ]) }}"
                                                    onclick="openEditModal(this)"
                                                    class="w-8 h-8 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button type="button" 
                                                    onclick="confirmDelete('{{ $data['db_id'] }}')"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[{{ $idx }}]"
                                       value="{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
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
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Section 3: Paragraph Translation -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">C. Translate Paragraf</h3>
                
                <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-rose-500 shadow-sm">
                    <div class="mb-4">
                        <div class="flex justify-between items-start mb-2">
                             <strong class="block text-lg text-gray-800">Terjemahkan paragraf berikut ke dalam Bahasa Inggris:</strong>
                             @if(auth()->check() && auth()->user()->isAdmin())
                                @if(isset($paragraphDbId) && $paragraphDbId)
                                    <div class="flex gap-2">
                                        <button type="button" 
                                                data-payload="{{ json_encode([
                                                    'id' => $paragraphDbId, 
                                                    'question_text' => $fullParagraphId, 
                                                    'correct_answer' => $fullParagraphEn,
                                                    'vocab' => is_array($paragraphVocab) ? json_encode($paragraphVocab) : $paragraphVocab
                                                ]) }}"
                                                onclick="openParagraphEditModal(this)"
                                                class="w-10 h-10 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button type="button" 
                                                onclick="confirmDelete('{{ $paragraphDbId }}')"
                                                class="w-10 h-10 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                @else
                                    <button type="button"
                                            @click="$dispatch('open-add-paragraph-modal')"
                                            class="bg-violet-600 hover:bg-violet-700 text-white text-xs font-bold py-1 px-3 rounded shadow-sm transition-colors">
                                        + Add Paragraph
                                    </button>
                                @endif
                             @endif
                        </div>
                        <p class="text-gray-700 leading-relaxed p-4 bg-white rounded border border-gray-200">
                            {{ $fullParagraphId }}
                        </p>
                    </div>

                    <!-- Vocabulary Button -->
                    <div class="mb-4" x-data="{ showVocab: false }">
                        <button 
                            type="button"
                            @click="showVocab = !showVocab"
                            class="w-full px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg transition-colors flex items-center justify-between">
                            <span>📚 Vocabulary Bantuan</span>
                            <svg 
                                :class="showVocab ? 'rotate-180' : ''" 
                                class="w-5 h-5 transition-transform" 
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div 
                            x-show="showVocab" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="mt-3 bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($paragraphVocab as $en => $id)
                                    <span class="bg-white px-3 py-1.5 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                        <strong class="text-rose-600">{{ $en }}</strong>: {{ $id }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                        <textarea
                            name="userParagraphAnswer"
                            rows="6"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-rose-500 focus:ring-1 focus:ring-rose-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            placeholder="Tulis terjemahan paragraf di sini..."
                            {{ $submitted ? 'readonly' : '' }}>{{ old('userParagraphAnswer', $userParagraphAnswer) }}</textarea>
                    </div>

                    @if($submitted)
                        <div class="mt-4">
                            @if($paragraphResult['score'] >= $paragraphResult['max_score'] * 0.8)
                                <div class="text-sm font-bold text-green-600 bg-green-50 p-3 rounded border border-green-100 mb-2">
                                    ✓ Luar Biasa! Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}
                                </div>
                            @else
                                <div class="text-sm font-bold text-red-600 bg-red-50 p-3 rounded border border-red-100 mb-2">
                                    Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}
                                </div>
                            @endif

                            <div class="bg-white p-4 rounded border border-gray-200 text-sm leading-relaxed">
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

            <div class="mt-8">
                @if(!$submitted)
                    <button type="submit" class="w-full py-4 bg-rose-600 text-white rounded-xl font-bold text-lg hover:bg-rose-700 transition-colors shadow-lg">
                        Cek Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($submitted)
            <form method="POST" action="{{ route('assignments.grammar-writing.meeting15.reset') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>

    <!-- Admin Modals -->
    @if(auth()->check() && auth()->user()->isAdmin())
        <!-- Edit Question Modal -->
        <div x-data="{ open: false }"
             x-on:open-edit-modal.window="open = true"
             x-on:close-modal.window="open = false"
             x-show="open"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="open" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <form id="editQuestionForm" method="POST" action="#" class="p-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_id">
                        <input type="hidden" name="meeting_number" value="15">
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Question</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Question (Indonesian)</label>
                                <textarea name="question_text" id="edit_question_text" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Correct Answer (English)</label>
                                <textarea name="correct_answer" id="edit_correct_answer" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vocabulary (JSON: {"Word": "Meaning"})</label>
                                <textarea name="vocab" id="edit_vocab" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono"></textarea>
                                <p class="mt-1 text-xs text-gray-500">Format: {"Word": {"id": "Meaning", "pos": "(n)"}}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Example (Indo)</label>
                                    <input type="text" name="example_id" id="edit_example_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Example (Eng)</label>
                                    <input type="text" name="example_en" id="edit_example_en" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 flex justify-end gap-2">
                            <button type="button" @click="open = false" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:text-sm">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:text-sm">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Question Modal -->
        <div x-data="{ open: false }"
             x-on:open-add-modal.window="open = true"
             x-on:close-modal.window="open = false"
             x-show="open"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form method="POST" action="{{ route('admin.grammar.question.store') }}" class="p-6">
                        @csrf
                        <input type="hidden" name="meeting_number" value="15">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Question</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Question Number</label>
                                <input type="number" name="question_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Question (ID)</label>
                                <textarea name="question_text" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Answer (EN)</label>
                                <textarea name="correct_answer" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vocabulary (JSON)</label>
                                <textarea name="vocab" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder='{"Word": {"id": "Meaning", "pos": "(n)"}}'></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium text-gray-700">Ex (ID)</label><input type="text" name="example_id" class="mt-1 block w-full rounded-md border-gray-300"></div>
                                <div><label class="block text-sm font-medium text-gray-700">Ex (EN)</label><input type="text" name="example_en" class="mt-1 block w-full rounded-md border-gray-300"></div>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 flex justify-end gap-2">
                             <button type="button" @click="open = false" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:text-sm">Cancel</button>
                             <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-violet-600 text-base font-medium text-white hover:bg-violet-700 focus:outline-none sm:text-sm">Add Question</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Paragraph Modal -->
        <div x-data="{ open: false }"
             x-on:open-paragraph-edit-modal.window="open = true"
             x-on:close-modal.window="open = false"
             x-show="open"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form id="editParagraphForm" method="POST" action="#" class="p-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_paragraph_db_id">
                        <input type="hidden" name="meeting_number" value="15">
                        <input type="hidden" name="section" value="paragraph">
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Paragraph</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Paragraph (Indonesian)</label>
                                <textarea name="question_text" id="edit_paragraph_id" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Correct Answer (English)</label>
                                <textarea name="correct_answer" id="edit_paragraph_en" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vocabulary (JSON)</label>
                                <textarea name="vocab" id="edit_paragraph_vocab" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono"></textarea>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 flex justify-end gap-2">
                            <button type="button" @click="open = false" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:text-sm">Cancel</button>
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:text-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Paragraph Modal -->
        <div x-data="{ open: false }"
             x-on:open-add-paragraph-modal.window="open = true"
             x-on:close-modal.window="open = false"
             x-show="open"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form method="POST" action="{{ route('admin.grammar.question.store') }}" class="p-6">
                        @csrf
                        <input type="hidden" name="meeting_number" value="15">
                        <input type="hidden" name="section" value="paragraph">
                        <input type="hidden" name="question_number" value="100">
                        <input type="hidden" name="question_type" value="paragraph">
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Add Paragraph</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Paragraph (Indonesian)</label>
                                <textarea name="question_text" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Answer (English)</label>
                                <textarea name="correct_answer" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vocab (JSON)</label>
                                <textarea name="vocab" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 flex justify-end gap-2">
                             <button type="button" @click="open = false" class="btn-secondary">Cancel</button>
                             <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-violet-600 text-base font-medium text-white hover:bg-violet-700 focus:outline-none sm:text-sm">Add Paragraph</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openEditModal(button) {
                const payload = JSON.parse(button.dataset.payload);
                document.getElementById('edit_id').value = payload.id;
                document.getElementById('edit_question_text').value = payload.question_text;
                document.getElementById('edit_correct_answer').value = payload.correct_answer;
                document.getElementById('edit_example_id').value = payload.example_id;
                document.getElementById('edit_example_en').value = payload.example_en;
                document.getElementById('edit_vocab').value = payload.vocab;
                
                // Set Form Action Dynamically
                document.getElementById('editQuestionForm').action = '/admin/grammar/question/' + payload.id;
                
                window.dispatchEvent(new CustomEvent('open-edit-modal'));
            }

            function openParagraphEditModal(button) {
                const payload = JSON.parse(button.dataset.payload);
                document.getElementById('edit_paragraph_db_id').value = payload.id;
                document.getElementById('edit_paragraph_id').value = payload.question_text;
                document.getElementById('edit_paragraph_en').value = payload.correct_answer;
                document.getElementById('edit_paragraph_vocab').value = payload.vocab;
                
                // Set Form Action Dynamically
                document.getElementById('editParagraphForm').action = '/admin/grammar/question/' + payload.id;
                
                window.dispatchEvent(new CustomEvent('open-paragraph-edit-modal'));
            }

            function confirmDelete(id) {
                if(confirm('Are you sure you want to delete this item?')) {
                    // Create a hidden form and submit it
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/grammar/question/' + id;
                    
                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrf);
                    
                    let method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>
    @endif

    <style>
        .word-correct { color: #10b981; }
        .word-wrong { color: #ef4444; text-decoration: line-through; }
        .word-missing { color: #3b82f6; font-weight: bold; }
        .word-extra { color: #f59e0b; text-decoration: line-through; }
    </style>
    <x-irregular-verbs-button />

    <!-- Lesson Chart Button -->
    <div x-data="{ openLesson: false }" class="fixed bottom-48 right-8 z-50">
       <!-- Floating Button -->
       <button @click="openLesson = true"
               class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2">
           <span>📊</span> Lesson Chart
       </button>

       <!-- Modal Backdrop -->
       <div x-show="openLesson"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
            style="display: none;">
          
           <!-- Modal Content -->
           <div @click.outside="openLesson = false"
                class="bg-white rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden">
              
               <!-- Header -->
               <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-rose-50">
                   <h3 class="text-xl font-bold text-gray-800">Lesson Chart</h3>
                   <button @click="openLesson = false" class="text-gray-400 hover:text-gray-600">
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                   </button>
               </div>

               <!-- Content Container -->
               <div class="overflow-y-auto p-6">
                    <!-- RPP Section -->
                    <div class="mb-8">
                        <h3 class="font-bold text-xl text-rose-800 mb-4 border-b pb-2">Relative Pronoun as Possesive (RPP)</h3>
                        <div class="space-y-4">
                             <div class="bg-rose-50 p-4 rounded-lg border border-rose-100">
                                <p class="font-bold text-gray-700 mb-2">Conjunction:</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-lg text-rose-700 font-bold">Whose</span>
                                    <span class="text-gray-600 text-sm">[ yang ]</span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-rose-200 shadow-sm">
                                    <p class="font-bold text-gray-700 mb-2 text-sm">Pola 1:</p>
                                    <p class="text-rose-600 font-mono font-medium">Whose + Noun + Subject + Verb</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-rose-200 shadow-sm">
                                    <p class="font-bold text-gray-700 mb-2 text-sm">Pola 2:</p>
                                    <p class="text-rose-600 font-mono font-medium">Whose + Noun + Verb</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RA Section -->
                    <div>
                        <h3 class="font-bold text-xl text-blue-800 mb-4 border-b pb-2">Relative Adverb (RA)</h3>
                        <div class="space-y-4">
                             <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <p class="font-bold text-gray-700 mb-2">Conjunctions:</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="px-3 py-1 bg-white rounded border border-blue-200 text-blue-700 font-bold">Where</span>
                                    <span class="px-3 py-1 bg-white rounded border border-blue-200 text-blue-700 font-bold">When</span>
                                    <span class="px-3 py-1 bg-white rounded border border-blue-200 text-blue-700 font-bold">Why</span>
                                    <span class="text-gray-500 self-center mx-2">//</span>
                                    <span class="px-3 py-1 bg-white rounded border border-blue-200 text-blue-700 font-bold">Preposition + which/whom</span>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-lg border border-blue-200 shadow-sm">
                                <p class="font-bold text-gray-700 mb-2 text-sm">Pola:</p>
                                <div class="space-y-2">
                                    <p class="text-blue-600 font-mono font-medium">Conjunction + Subject + Verb</p>
                                    <p class="text-gray-400 text-xs italic">-- atau --</p>
                                    <p class="text-blue-600 font-mono font-medium">Preposition + which/whom + Subject + Verb</p>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
           </div>
       </div>
    </div>

    <!-- Tenses Chart Button -->
    <div x-data="{ openTenses: false }" class="fixed bottom-28 right-8 z-50">
       <!-- Floating Button -->
       <button @click="openTenses = true"
               class="bg-cyan-400 hover:bg-cyan-500 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2">
           <span>💡</span> Tenses
       </button>

       <!-- Modal Backdrop -->
       <div x-show="openTenses"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
            style="display: none;">
          
           <!-- Modal Content -->
           <div @click.outside="openTenses = false"
                class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">
              
               <!-- Header -->
               <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-cyan-50">
                   <h3 class="text-xl font-bold text-gray-800">Tenses Chart</h3>
                   <button @click="openTenses = false" class="text-gray-400 hover:text-gray-600">
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                   </button>
               </div>

               <!-- Image Container -->
               <div class="overflow-y-auto p-6" style="max-height: 75vh;">
                   <img src="{{ asset('images/materials/grammar/tenses-chart.png') }}" 
                        alt="Tenses Chart" 
                        class="w-full h-auto rounded-lg shadow-md">
               </div>

               <!-- Footer Note -->
               <div class="p-4 bg-cyan-50 border-t border-cyan-100 text-center">
                   <p class="text-sm text-gray-700 font-medium">
                       💡 Gunakan chart ini sebagai panduan untuk menentukan tenses yang tepat
                   </p>
               </div>
           </div>
       </div>
    </div>
    
    
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
            const isReadonly = document.querySelector('input[type="text"][readonly]');
            
            return !!isReadonly;
        },

        /**
         * Set up auto-save listeners on all input fields
         */
        setupAutoSave() {
            // Find all input and textarea elements in the form
            const form = document.querySelector('form[action*="/assignments/grammar-writing/meeting"][method="POST"]');
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

            const form = document.querySelector('form[action*="/assignments/grammar-writing/meeting"][method="POST"]');
            if (!form) {
                console.log('No form found');
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};

            inputs.forEach(input => {
                if (input.name && input.value) {
                    answers[input.name] = input.value;
                }
            });

            try {
                localStorage.setItem(this.storageKey, JSON.stringify(answers));
                this.showSaveIndicator();
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
                return;
            }

            const action = form.getAttribute('action') || '';
            const match = action.match(/\/assignments\/grammar-writing\/meeting(\d+)/);
            if (!match) {
                return;
            }

            const meetingNumber = match[1];
            const draftEndpoint = '/assignments/grammar-writing/fast-track/meeting' + meetingNumber + '/draft';
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
                await fetch(draftEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                    keepalive: true,
                });
            } catch (e) {
                console.error('Failed to sync draft to server:', e);
            }
        },

        /**
         * Restore saved answers from localStorage
         */
        restoreAnswers() {
            try {
                const savedData = localStorage.getItem(this.storageKey);
                
                if (!savedData) {
                    console.log('No saved data to restore');
                    return;
                }

                const answers = JSON.parse(savedData);
                let restoredCount = 0;

                Object.keys(answers).forEach(name => {
                    const input = document.querySelector(`input[name="${name}"], textarea[name="${name}"]`);
                    
                    if (input && !input.value && !input.readOnly) {
                        input.value = answers[name];
                        restoredCount++;
                    }
                });

                if (restoredCount > 0) {
                    console.log(`✓ Restored ${restoredCount} saved answers from localStorage`);
                    this.showRestoreIndicator(restoredCount);
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
                indicator.className = 'fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
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

    // Initialize auto-save for meeting 15
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId) {
            AutoSave.init('15', userId);
        }
    });
    </script>


    <x-live-drawing />
</body>
</html>