<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 13</title>
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
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('assignments.grammar-writing') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium">
                &laquo; Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bold text-center text-violet-600 mb-8">Adjective Clause in Relative Pronoun as Object (Pertemuan 13)</h1>
        
        <!-- Tips Box -->
        <div class="bg-violet-50 border border-violet-200 text-violet-900 p-6 rounded-xl mb-8">
            <strong class="block mb-2 text-lg">💡 Tips:</strong>
            <p class="text-sm">Tentukan dahulu <strong>Subject Main Clause</strong> dan <strong>Verb Main Clause</strong> sebelum menerjemahkan!</p>
            <!--
            <div class="mt-3 text-xs space-y-1">
                <p>• Adjective Clause dalam passive: objek menjadi subjek klausa</p>
                <p>• Contoh: "Buku <strong>yang peneliti cari</strong>" = "The book <strong>that the researcher looked for</strong>"</p>
                <p>• Atau dalam passive: "The book <strong>that was looked for by the researcher</strong>"</p>
                <p>• Perhatikan posisi objek yang dipindahkan ke depan dalam bahasa Indonesia</p>
            </div> -->
        </div>

        @if($submitted)
            <div class="bg-violet-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-violet-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('assignments.grammar-writing.meeting13.submit') }}">
            @csrf
            
            <!-- Section 1: Sentence Translation -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">A. Translate Kalimat dengan Adjective Clause</h3>
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
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-violet-500 shadow-sm">
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
                                </div>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <div class="flex gap-2 ml-4">
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
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[{{ $idx }}]"
                                       value="{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-violet-500 focus:ring-1 focus:ring-violet-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
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
                    @endforeach
                </div>
            </div>

            <!-- Section 2: Paragraph Translation -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">B. Translate Paragraf</h3>
                
                <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-violet-500 shadow-sm">
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
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded shadow-sm transition-colors">
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
                                        <strong class="text-violet-600">{{ $en }}</strong>: {{ $id }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                        <textarea
                            name="userParagraphAnswer"
                            rows="8"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-violet-500 focus:ring-1 focus:ring-violet-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
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
                    <button type="submit" class="w-full py-4 bg-violet-600 text-white rounded-xl font-bold text-lg hover:bg-violet-700 transition-colors shadow-lg">
                        Cek Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($submitted)
            <form method="POST" action="{{ route('assignments.grammar-writing.meeting13.reset') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
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
    </style>
    <x-irregular-verbs-button />

    <!-- Lesson Chart Button -->
    <div x-data="{ openLesson: false }" class="fixed bottom-48 right-8 z-50">
       <!-- Floating Button -->
       <button @click="openLesson = true"
               class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2">
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
                class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">
              
               <!-- Header -->
               <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-violet-50">
                   <h3 class="text-xl font-bold text-gray-800">Lesson Chart</h3>
                   <button @click="openLesson = false" class="text-gray-400 hover:text-gray-600">
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                   </button>
               </div>

               <!-- Content Container -->
               <div class="overflow-y-auto p-6">
                    <h3 class="font-bold text-xl text-violet-800 mb-6 border-b pb-2">Relative Pronoun as Object (RPO)</h3>
                    
                    <div class="space-y-6">
                        <div class="bg-violet-50 p-5 rounded-xl border border-violet-100">
                            <p class="font-bold text-gray-700 mb-2">Pola:</p>
                            <div class="bg-white p-3 rounded-lg border border-violet-200 text-center shadow-sm">
                                <span class="text-xl text-violet-700 font-bold font-mono">Conjunction + Subject + Verb</span>
                            </div>
                        </div>

                        <div>
                            <p class="font-bold text-gray-700 mb-3 text-lg">Conjunctions:</p>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="w-32 font-bold text-violet-600 text-lg">Who / Whom</span>
                                    <span class="text-gray-600">(person)</span>
                                </div>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="w-32 font-bold text-violet-600 text-lg">Which</span>
                                    <span class="text-gray-600">(non-person)</span>
                                </div>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="w-32 font-bold text-violet-600 text-lg">That</span>
                                    <span class="text-gray-600">(all)</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-5 rounded-xl border border-yellow-200 flex items-center gap-4">
                            <div class="bg-yellow-100 p-2 rounded-full text-yellow-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">Bermakna:</p>
                                <p class="text-2xl text-gray-800 font-bold">“YANG”</p>
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
                   <img src="{{ asset('images/tenses-chart.png') }}" 
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
            const draftEndpoint = '/assignments/grammar-writing/meeting' + meetingNumber + '/draft';
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
                indicator.className = 'fixed bottom-4 left-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
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

    // Initialize auto-save for meeting 13
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId) {
            AutoSave.init('13', userId);
        }
    });
    </script>

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this content?')) {
                const form = document.getElementById('delete-question-form');
                form.action = `/admin/grammar/question/${id}`;
                form.submit();
            }
        }

        function openEditModal(el) {
            try {
                const data = JSON.parse(el.dataset.payload);
                window.dispatchEvent(new CustomEvent('open-meeting13-edit-modal', { detail: data }));
            } catch (e) {
                console.error('Error parsing edit data', e);
                alert('Error opening edit modal. See console.');
            }
        }
        
        function openParagraphEditModal(el) {
            try {
                const data = JSON.parse(el.dataset.payload);
                window.dispatchEvent(new CustomEvent('open-meeting13-paragraph-modal', { detail: data }));
            } catch (e) {
                console.error('Error parsing paragraph edit data', e);
                alert('Error opening paragraph edit modal. See console.');
            }
        }
    </script>
    
    <!-- Hidden Delete Form -->
    <form id="delete-question-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    
    <!-- ADD QUESTION MODAL -->
    <div x-data="{ open: false }" 
         @open-add-modal.window="open = true" 
         class="relative z-[100]" 
         style="display: none;"
         x-show="open">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form action="{{ route('admin.grammar.question.store') }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="meeting_number" value="13">
                        <input type="hidden" name="question_number" value="{{ count($questions) + 1 }}">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Add New Question</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Question (Indonesian)</label>
                            <textarea name="question_text" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Answer (English)</label>
                            <textarea name="correct_answer" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div><label class="block text-sm font-bold text-gray-900 mb-2">Example ID</label><input type="text" name="example_id" class="w-full p-2 border rounded"></div>
                            <div><label class="block text-sm font-bold text-gray-900 mb-2">Example EN</label><input type="text" name="example_en" class="w-full p-2 border rounded"></div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Vocab JSON</label>
                            <textarea name="vocab" rows="3" class="w-full p-2 border rounded font-mono text-xs"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: {"Word": {"id": "Trans", "pos": "(n)"}}</p>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-violet-600 rounded text-white hover:bg-violet-700">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT QUESTION MODAL -->
    <div x-data="{ open: false, data: {} }" 
         @open-meeting13-edit-modal.window="open = true; data = $event.detail" 
         class="relative z-[100]" 
         style="display: none;"
         x-show="open">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form :action="'/admin/grammar/question/' + data.id" method="POST" class="p-6">
                        @csrf @method('PUT')
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Edit Question</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Question (Indonesian)</label>
                            <textarea name="question_text" x-model="data.question_text" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Answer (English)</label>
                            <textarea name="correct_answer" x-model="data.correct_answer" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div><label class="block text-sm font-bold text-gray-900 mb-2">Example ID</label><input type="text" name="example_id" x-model="data.example_id" class="w-full p-2 border rounded"></div>
                            <div><label class="block text-sm font-bold text-gray-900 mb-2">Example EN</label><input type="text" name="example_en" x-model="data.example_en" class="w-full p-2 border rounded"></div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Vocab JSON</label>
                            <textarea name="vocab" x-model="data.vocab" rows="3" class="w-full p-2 border rounded font-mono text-xs"></textarea>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-violet-600 rounded text-white hover:bg-violet-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD PARAGRAPH MODAL -->
    <div x-data="{ open: false }" 
         @open-add-paragraph-modal.window="open = true" 
         class="relative z-[100]" 
         style="display: none;"
         x-show="open">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                    <form action="{{ route('admin.grammar.question.store') }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="meeting_number" value="13">
                        <input type="hidden" name="question_number" value="100">
                        <input type="hidden" name="section" value="paragraph">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Add Paragraph</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Paragraph (Indonesian)</label>
                            <textarea name="question_text" rows="6" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Paragraph (English)</label>
                            <textarea name="correct_answer" rows="6" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Vocab JSON</label>
                            <textarea name="vocab" rows="4" class="w-full p-2 border rounded font-mono text-xs"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: {"Word": "Trans"}</p>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-violet-600 rounded text-white hover:bg-violet-700">Save Paragraph</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT PARAGRAPH MODAL -->
    <div x-data="{ open: false, data: {} }" 
         @open-meeting13-paragraph-modal.window="open = true; data = $event.detail" 
         class="relative z-[100]" 
         style="display: none;"
         x-show="open">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                    <form :action="'/admin/grammar/question/' + data.id" method="POST" class="p-6">
                        @csrf @method('PUT')
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Edit Paragraph</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Paragraph (Indonesian)</label>
                            <textarea name="question_text" x-model="data.question_text" rows="6" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Paragraph (English)</label>
                            <textarea name="correct_answer" x-model="data.correct_answer" rows="6" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Vocab JSON</label>
                            <textarea name="vocab" x-model="data.vocab" rows="4" class="w-full p-2 border rounded font-mono text-xs"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: {"Word": "Trans"}</p>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-violet-600 rounded text-white hover:bg-violet-700">Update Paragraph</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>