<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 7</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .word-correct { color: #2ecc71; font-weight: bold; }
        .word-extra { color: #3498db; font-weight: bold; text-decoration: line-through; }
        .word-missing { color: #f1c40f; font-weight: bold; }
        .word-wrong { color: #e74c3c; font-weight: bold; text-decoration: underline; }
    </style>
    <style>
        /* Style for noun phrases (strong tags) in Meeting 7 */
        label strong {
            color: #1e40af;
            font-weight: 700;
        }
        .bg-white strong {
            color: #1e40af;
            font-weight: 700;
        }
        /* Keep instruction text black */
        .bg-gray-50 > div > strong {
            color: #1f2937 !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('assignments.grammar-writing') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
        </div>

        <h1 class="text-3xl font-bold text-center text-orange-600 mb-8">Noun Phrase (Pertemuan 7)</h1>
        <p class="text-center text-gray-600 mb-8">Translate kalimat berikut ke dalam bahasa Inggris.</p>

        @if($submitted)
            <div class="bg-orange-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-orange-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('assignments.grammar-writing.meeting7.submit') }}">
            @csrf
            
            <!-- Section 1: Sentence Translation -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">A. Translate Kalimat</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <button type="button" onclick="openMeeting7AddModal('noun_phrases')" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            + Add Question
                        </button>
                    @endif
                </div>
                <div class="space-y-6">
                    @php
    $posMap = [
        // Question 1 vocab
        'Archipelago' => '(n)',
        'Tropical' => '(adj)',
        'Natural resources' => '(n)',
        'Biodiversity' => '(n)',
        'Extraordinary' => '(adj)',
        // Question 2 vocab
        'Institution' => '(n)',
        'Research' => '(n)',
        'Independent' => '(adj)',
        'Famous' => '(adj)',
        'Release' => '(v)',
        'Annual report' => '(n)',
        'Market growth' => '(n)',
        // Question 3 vocab
        'Museum' => '(n)',
        'Magnificent' => '(adj)',
        'Historical' => '(adj)',
        'Store' => '(v)',
        'Artifact' => '(n)',
        'Valuable' => '(adj)',
        'Era' => '(n)',
        // Question 4 vocab
        'Geographer' => '(n)',
        'Map' => '(v)',
        'Border area' => '(n)',
        'Vast' => '(adj)',
        'Remote' => '(adj)',
        'In detail' => '(adv)',
        // Question 5 vocab
        'Conference' => '(n)',
        'Environmental' => '(adj)',
        'Global' => '(adj)',
        'Held' => '(v)',
        'Every year' => '(adv)',
        'Geneva' => '(n)',
        // Question 6 vocab
        'Reference book' => '(n)',
        'Scientific' => '(adj)',
        'Thick' => '(adj)',
        'Classic' => '(adj)',
        'Expensive' => '(adj)',
        'Linguistics' => '(n)',
        'Available' => '(adj)',
        'Library' => '(n)',
        // Question 7 vocab
        'Scientist' => '(n)',
        'Discover' => '(v)',
        'Mineral' => '(n)',
        'Rare' => '(adj)',
        'Shiny' => '(adj)',
        'Bottom' => '(n)',
        'Ocean' => '(n)',
        'Indian Ocean' => '(n)',
        // Question 8 vocab
        'Early childhood education' => '(n)',
        'Inclusive' => '(adj)',
        'Innovative' => '(adj)',
        'Develop' => '(v)',
        'Rapidly' => '(adv)',
        'Rural area' => '(n)',
        // Question 9 vocab
        'Indigenous community' => '(n)',
        'Mountain' => '(n)',
        'High' => '(adj)',
        'Multiethnic' => '(adj)',
        'Belief system' => '(n)',
        'Unique' => '(adj)',
        // Question 10 vocab
        'Astronomy' => '(n)',
        'Observe' => '(v)',
        'Phenomenon/Phenomena' => '(n)',
        'Cosmic' => '(adj)',
        'Rare' => '(adj)',
        'Complex' => '(adj)',
        'Mysterious' => '(adj)',
        'Edge' => '(n)',
        'Galaxy' => '(n)',
        // ... add other vocab mappings as needed
    ];
@endphp

@foreach($questions as $idx => $data)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-orange-500 shadow-sm">
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <div class="flex justify-end gap-2 mb-2">
                                    <button type="button" 
                                        onclick="openMeeting7EditModal({{ $data['db_id'] }}, '{{ addslashes($data['id']) }}', '{{ addslashes($data['en']) }}', 'noun_phrases')"
                                        class="w-8 h-8 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="{{ route('admin.grammar.question.destroy', $data['db_id']) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <div class="flex items-start mb-4">
                                <label class="block font-bold text-lg text-gray-800 flex-1">{{ $idx }}. {!! $data['id'] !!}</label>
                                <div class="flex gap-2 ml-3 shrink-0">
                                    @if(isset($data['example']))
                                        <div x-data="{ open: false }" class="relative inline-block">
                                            <button type="button" 
                                                    @click="open = !open" 
                                                    @click.outside="open = false" 
                                                    class="text-yellow-600 hover:text-yellow-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-yellow-50 px-2 py-0.5 rounded border border-yellow-100 w-6 h-6 flex items-center justify-center shadow-sm"
                                                    title="Lihat Referensi">
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
                                                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-96 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                                <strong class="block mb-2 text-yellow-300 border-b border-gray-600 pb-1">Contoh Struktur Serupa:</strong>
                                                <div class="mb-2 text-gray-300 italic">"{{ $data['example']['id'] }}"</div>
                                                <div class="font-bold text-white bg-gray-700 py-1 px-2 rounded">{{ $data['example']['en'] }}</div>
                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(isset($data['vocab']))
                                        <div x-data="{ open: false }" class="relative inline-block">
                                            <button type="button" 
                                                    @click="open = !open" 
                                                    @click.outside="open = false" 
                                                    class="text-green-600 hover:text-green-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-green-50 px-2 py-0.5 rounded border border-green-100 w-6 h-6 flex items-center justify-center shadow-sm">
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
                                                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-96 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                <strong class="block mb-2 text-yellow-300 border-b border-gray-600 pb-1">Kosa Kata Bantuan:</strong>
                                                <ul class="space-y-1">
                                                    @foreach($data['vocab'] as $en => $id)
                                                        <li class="flex justify-between">
                                                            <span class="text-yellow-300 font-mono">{{ $en }}</span> <span class="text-gray-400 text-xs">{{ $id['pos'] ?? $posMap[$en] ?? '' }}</span>
                                                            <span>{{ $id['id'] ?? $id }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[{{ $idx }}]"
                                       value="{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
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
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">B. Translate Paragraf</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="flex gap-2">
                        <button type="button" 
                            onclick="openMeeting7EditModal(
                                {{ $paragraph['db_id'] ?? 0 }}, 
                                '{{ addslashes($paragraph['id'] ?? '') }}', 
                                '{{ addslashes($paragraph['en'] ?? '') }}', 
                                'paragraph'
                            )"
                            class="w-10 h-10 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        @if(isset($paragraph['db_id']))
                        <form action="{{ route('admin.grammar.question.destroy', $paragraph['db_id']) }}" method="POST" onsubmit="return confirm('Hapus paragraf ini?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-green-500 shadow-sm">
                    <div class="mb-4">
                        <strong class="block text-lg text-gray-800 mb-2">Terjemahkan paragraf berikut ke dalam Bahasa Inggris:</strong>
                        <p class="text-gray-700 leading-relaxed p-4 bg-white rounded border border-gray-200">
                            {!! $fullParagraphId !!}
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                        <textarea
                            name="userParagraphAnswer"
                            rows="8"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
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

                    <!-- Vocabulary Button -->
                    <div class="mt-6 mb-4" x-data="{ showVocab: false }">
                        <button 
                            type="button"
                            @click="showVocab = !showVocab"
                            class="w-full px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg transition-colors flex items-center justify-between shadow-sm">
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
                            <div class="flex flex-wrap gap-2">
                                @forelse($paragraphVocab ?? [] as $en => $vocabData)
                                    <span class="bg-white px-3 py-1.5 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                        <strong class="text-indigo-600">{{ $en }}</strong>: {{ $vocabData['id'] ?? '' }}
                                    </span>
                                @empty
                                    <p class="text-sm text-gray-500">Tidak ada kosa kata</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                @if(!$submitted)
                    <button type="submit" class="w-full py-4 bg-orange-600 text-white rounded-xl font-bold text-lg hover:bg-orange-700 transition-colors shadow-lg">
                        Cek Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($submitted)
            <form method="POST" action="{{ route('assignments.grammar-writing.meeting7.reset') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>
    <x-irregular-verbs-button />

    <!-- Lesson Chart Button -->
    <div x-data="{ openLesson: false }" class="fixed bottom-48 right-8 z-50">
       <!-- Floating Button -->
       <button @click="openLesson = true"
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2">
           <span>📖</span> Lesson Chart
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
                class="bg-white rounded-xl shadow-2xl w-full max-w-6xl max-h-[90vh] flex flex-col overflow-hidden">
              
               <!-- Header -->
               <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-indigo-50">
                   <h3 class="text-xl font-bold text-gray-800">Materi Meeting 7: Noun Phrase</h3>
                   <button @click="openLesson = false" class="text-gray-400 hover:text-gray-600">
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                   </button>
               </div>

               <!-- Content Container -->
               <div class="overflow-y-auto p-8 space-y-8" style="max-height: 75vh;">
                   
                   <!-- Table 1: Limiting Adjective -->
                   <div>
                       <h4 class="text-lg font-bold text-indigo-700 mb-4">1. Limiting Adjective (LA)</h4>
                       <div class="overflow-x-auto">
                           <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                               <thead class="bg-indigo-100">
                                   <tr>
                                       <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Jenis LA</th>
                                       <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Definisi</th>
                                       <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Anggota & Aturan</th>
                                       <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Contoh (English)</th>
                                   </tr>
                               </thead>
                               <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                   <tr>
                                       <td class="px-6 py-4 font-medium text-gray-900">1. Article</td>
                                       <td class="px-6 py-4 text-gray-600">Kata sandang.</td>
                                       <td class="px-6 py-4 text-gray-600">
                                           <strong>Definite (The):</strong> + Nc/Nu (sing/pl).<br>
                                           <strong>Indefinite (A/An):</strong> + Nc (sing).<br>
                                           <em>A sebelum bunyi konsonan, An sebelum bunyi vokal.</em>
                                       </td>
                                       <td class="px-6 py-4 text-gray-600 italic">The book, The money. A man, An apple, An hour.</td>
                                   </tr>
                                   <tr class="bg-gray-50">
                                       <td class="px-6 py-4 font-medium text-gray-900">2. Demonstrative</td>
                                       <td class="px-6 py-4 text-gray-600">Kata tunjuk.</td>
                                       <td class="px-6 py-4 text-gray-600">
                                           <strong>Singular:</strong> This, That (+ Nc sing/Nu).<br>
                                           <strong>Plural:</strong> These, Those (+ Nc plural).
                                       </td>
                                       <td class="px-6 py-4 text-gray-600 italic">This book is big. Those books are big.</td>
                                   </tr>
                                   <tr>
                                       <td class="px-6 py-4 font-medium text-gray-900">3. Possessive Adjective</td>
                                       <td class="px-6 py-4 text-gray-600">Kepemilikan dari pronoun.</td>
                                       <td class="px-6 py-4 text-gray-600">My, Your, Our, Their, Her, His, Its (+ Nc/Nu).</td>
                                       <td class="px-6 py-4 text-gray-600 italic">My dream, Our home.</td>
                                   </tr>
                                   <tr class="bg-gray-50">
                                       <td class="px-6 py-4 font-medium text-gray-900">4. Possessive Genitive</td>
                                       <td class="px-6 py-4 text-gray-600">Kepemilikan dari noun.</td>
                                       <td class="px-6 py-4 text-gray-600">
                                           <strong>Benda Hidup:</strong> Tambah 's (Adi's shoes).<br>
                                           <strong>Benda Mati:</strong> Pola N + N atau Np of Np.
                                       </td>
                                       <td class="px-6 py-4 text-gray-600 italic">Andi's shoes, Teachers' car. The car door, The door of the car.</td>
                                   </tr>
                                   <tr>
                                       <td class="px-6 py-4 font-medium text-gray-900">5. Indefinite Quantity</td>
                                       <td class="px-6 py-4 text-gray-600">Jumlah yang tidak jelas.</td>
                                       <td class="px-6 py-4 text-gray-600">Many (+ Nc pl), Much (+ Nu), Some (+ Nc pl/Nu), Every (+ Nc sing), dll.</td>
                                       <td class="px-6 py-4 text-gray-600 italic">Many people, Much money. Little water, Every day.</td>
                                   </tr>
                                   <tr class="bg-gray-50">
                                       <td class="px-6 py-4 font-medium text-gray-900">6. Numeral</td>
                                       <td class="px-6 py-4 text-gray-600">Bilangan/angka.</td>
                                       <td class="px-6 py-4 text-gray-600">
                                           <strong>Ordinal:</strong> First, Second, Third (bilangan bertingkat).<br>
                                           <strong>Cardinal:</strong> One, Two, Three (bilangan pokok).
                                       </td>
                                       <td class="px-6 py-4 text-gray-600 italic">The second winner. Two winners.</td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>
                   </div>

                   <!-- Table 2: Adjective Order -->
                   <div>
                       <h4 class="text-lg font-bold text-indigo-700 mb-4">2. Adjective Order</h4>
                       <div class="overflow-x-auto">
                           <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                               <thead class="bg-indigo-100">
                                   <tr>
                                       <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider w-16">No.</th>
                                       <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Kategori</th>
                                       <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Fokus Deskripsi</th>
                                       <th class="px-6 py-3 text-left text-xs font-bold text-indigo-800 uppercase tracking-wider">Contoh Kata</th>
                                   </tr>
                               </thead>
                               <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                   <tr>
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">1</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Quality</td>
                                       <td class="px-6 py-3 text-gray-600">Kualitas/Penampilan luar.</td>
                                       <td class="px-6 py-3 text-gray-600 italic">Beautiful, Handsome, Ugly, Pretty.</td>
                                   </tr>
                                   <tr class="bg-gray-50">
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">2</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Size</td>
                                       <td class="px-6 py-3 text-gray-600">Ukuran.</td>
                                       <td class="px-6 py-3 text-gray-600 italic">Big, Small, Huge, Tall, Short.</td>
                                   </tr>
                                   <tr>
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">3</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Age</td>
                                       <td class="px-6 py-3 text-gray-600">Usia.</td>
                                       <td class="px-6 py-3 text-gray-600 italic">Old, Young, Classic, Ancient, New.</td>
                                   </tr>
                                   <tr class="bg-gray-50">
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">4</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Temperature</td>
                                       <td class="px-6 py-3 text-gray-600">Suhu.</td>
                                       <td class="px-6 py-3 text-gray-600 italic">Hot, Cold, Warm, Freeze, Cool.</td>
                                   </tr>
                                   <tr>
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">5</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Shape</td>
                                       <td class="px-6 py-3 text-gray-600">Bentuk.</td>
                                       <td class="px-6 py-3 text-gray-600 italic">Circle, Square, Cube, Round.</td>
                                   </tr>
                                   <tr class="bg-gray-50">
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">6</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Color</td>
                                       <td class="px-6 py-3 text-gray-600">Warna.</td>
                                       <td class="px-6 py-3 text-gray-600 italic">Red, Yellow, Green, Black, White.</td>
                                   </tr>
                                   <tr>
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">7</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Character</td>
                                       <td class="px-6 py-3 text-gray-600">Sifat (karakter dalam diri).</td>
                                       <td class="px-6 py-3 text-gray-600 italic">Kind, Evil, Honest, Sincere.</td>
                                   </tr>
                                   <tr class="bg-gray-50">
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">8</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Nationality/Origin</td>
                                       <td class="px-6 py-3 text-gray-600">Negara atau asal.</td>
                                       <td class="px-6 py-3 text-gray-600 italic">American, Javanese, Indian, European.</td>
                                   </tr>
                                   <tr>
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">9</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Material</td>
                                       <td class="px-6 py-3 text-gray-600">Bahan pembentuk.</td>
                                       <td class="px-6 py-3 text-gray-600 italic">Wooden, Iron, Silk, Plastic.</td>
                                   </tr>
                                   <tr class="bg-gray-50">
                                       <td class="px-6 py-3 font-medium text-gray-900 text-center">10</td>
                                       <td class="px-6 py-3 font-bold text-gray-800">Purpose</td>
                                       <td class="px-6 py-3 text-gray-600">Fungsi/Tujuan Nomina.</td>
                                       <td class="px-6 py-3 text-gray-600 italic">Swimming (pool), Football (field).</td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>
                   </div>

               </div>

               <!-- Footer Note -->
               <div class="p-4 bg-indigo-50 border-t border-indigo-100 text-center">
                   <p class="text-sm text-gray-700 font-medium">
                       💡 Pelajari tabel ini untuk memahami struktur Noun Phrase dengan lebih baik.
                   </p>
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

    // Initialize auto-save for meeting 7
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId) {
            AutoSave.init('7', userId);
        }
    });
    </script>

    <!-- Global Dispatch Scripts -->
    <script>
        window.openMeeting7EditModal = function(id, question, answer, section) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m7', { 
                detail: { type: 'edit_question', id, question, answer, section } 
            }));
        };
        window.openMeeting7AddModal = function(section) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m7', { 
                detail: { type: 'add_question', section } 
            }));
        };
    </script>

    <!-- Modals -->
    <div x-data="{ 
            mode: '', 
            isOpen: false,
            // Question Fields
            qId: null, qText: '', qAns: '', qSection: ''
         }"
         @open-edit-modal-m7.window="
            isOpen = true;
            mode = $event.detail.type;
            if (mode === 'edit_question') {
                qId = $event.detail.id;
                qText = $event.detail.question;
                qAns = $event.detail.answer;
                qSection = $event.detail.section;
            } else if (mode === 'add_question') {
                qSection = $event.detail.section;
                qText = ''; qAns = '';
            }
         "
         x-show="isOpen" 
         x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 p-4"
    >
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6" @click.outside="isOpen = false">
            
            <!-- ADD/EDIT QUESTION FORM -->
            <form :action="mode === 'edit_question' ? '/admin/grammar/question/' + qId : '/admin/grammar/question'" method="POST">
                @csrf
                <template x-if="mode === 'edit_question'">
                    @method('PUT')
                </template>
                
                <h3 class="text-lg font-bold mb-4" x-text="mode === 'edit_question' ? 'Edit Question' : 'Add Question'"></h3>
                
                <input type="hidden" name="meeting_number" value="7">
                <input type="hidden" name="section" x-model="qSection">
                
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Question (Indonesian)</label>
                    <textarea name="question_text" x-model="qText" class="w-full border rounded p-2" rows="5" required></textarea>
                    <p class="text-xs text-gray-500 mt-1">Gunakan tag HTML untuk bold/warna: &lt;strong&gt;, &lt;span class="text-green-500"&gt;</p>
                </div>
                
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Answer (English)</label>
                    <textarea name="correct_answer" x-model="qAns" class="w-full border rounded p-2" rows="3" required></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="isOpen = false" class="px-4 py-2 text-gray-600">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>


    <x-live-drawing />
</body>
</html>