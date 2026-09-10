<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 1</title>
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
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <x-grammar-meeting-actions :meetingNumber="1" track="fast-track" />

        <h1 class="text-3xl font-bold text-center text-yellow-500 mb-8">Pertemuan 1 - PRONOUN (Kata Ganti)</h1>
        <h3 class="text-3xl font-bold text-center text-yellow-500 mb-8">Latihan Translate (Indo -> Inggris)</h3>

        @if($submitted)
            <div class="bg-yellow-500 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $score }} / 100</h2>
                <p class="text-lg opacity-90">
                    {{ $score >= 80 ? 'Luar biasa!' : ($score >= 60 ? 'Bagus, terus berlatih!' : 'Jangan menyerah, coba lagi!') }}
                </p>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Laporan Hasil</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="bg-yellow-500 text-white">
                                <th class="p-3 border border-yellow-600 text-left w-12">No</th>
                                <th class="p-3 border border-yellow-600 text-left">Pertanyaan</th>
                                <th class="p-3 border border-yellow-600 text-left">Jawaban Kamu</th>
                                <th class="p-3 border border-yellow-600 text-left">Jawaban Benar</th>
                                <th class="p-3 border border-yellow-600 text-left w-20">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $idx => $res)
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                    <td class="p-3 border border-gray-200">{{ $idx }}</td>
                                    <td class="p-3 border border-gray-200 font-medium">{{ $questions[$idx]['id'] }}</td>
                                    <td class="p-3 border border-gray-200">{!! $res['formatted_answer'] !!}</td>
                                    <td class="p-3 border border-gray-200 text-gray-600">{{ $res['correct_answer'] }}</td>
                                    <td class="p-3 border border-gray-200 font-bold text-center">{{ $res['score'] }}</td>
                                </tr>
                            @endforeach
                            <!-- Paragraph Result -->
                            <tr class="bg-sky-50">
                                <td class="p-3 border border-gray-200 font-bold text-sky-700">P</td>
                                <td class="p-3 border border-gray-200 text-sky-800">{{ Str::limit($paragraphData['id'], 50) }}</td>
                                <td class="p-3 border border-gray-200">{!! $paragraphResult['formatted_answer'] !!}</td>
                                <td class="p-3 border border-gray-200 text-gray-600">{{ $paragraphData['en'] }}</td>
                                <td class="p-3 border border-gray-200 font-bold text-center text-sky-700">{{ $paragraphResult['score'] }}/50</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting1.submit'), PHP_URL_PATH) }}">
            @csrf
            @foreach($questions as $index => $data)
                <div class="bg-gray-50 p-6 rounded-xl mb-6 border-l-4 border-yellow-400 shadow-sm">
                    <div class="flex items-start mb-3">
                        <div class="flex-1">
                            <label class="block font-bold text-gray-800 text-lg">
                                {{ $index }}. {{ $data['id'] }}
                            </label>
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <div class="flex gap-2 mt-1 text-sm">
                                    <button type="button" 
                                            onclick="openMeeting1EditModal(
                                                {{ $data['db_id'] ?? 0 }}, 
                                                {{ \Illuminate\Support\Js::from($data['id']) }}, 
                                                {{ \Illuminate\Support\Js::from($data['en']) }},
                                                {{ \Illuminate\Support\Js::from($data['vocab'] ?? []) }}
                                            )"
                                            class="text-blue-600 hover:text-blue-800 underline">Edit</button>
                                    <form action="{{ parse_url(route('admin.grammar.question.destroy', $data['db_id'] ?? 0), PHP_URL_PATH) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 underline">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col gap-1 ml-2">
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
                                         class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                        <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                        {{ $data['example']['id'] }}<br>
                                        <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>
                            @endif
                            
                            @if(isset($data['vocab']))
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
                                         class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-96 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                        <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Kosa Kata Bantuan:</strong>
                                        <ul class="space-y-1">
                                            @foreach($data['vocab'] as $en => $vocabData)
                                                <li class="flex justify-between">
                                                    <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ $vocabData['pos'] }}</span></span>
                                                    <span>{{ $vocabData['id'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                   
                    <input type="text"
                           name="q{{ $index }}"
                           value="{{ old('q'.$index, $results[$index]['user_answer'] ?? '') }}"
                           class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-0 transition-colors {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                           placeholder="Tulis bahasa Inggrisnya di sini..."
                           {{ $submitted ? 'readonly' : '' }}
                           autocomplete="off">

                    @if($submitted)
                        @if($results[$index]['score'] == 10)
                            <div class="mt-3 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-medium flex items-center">
                                <span class="mr-2">✓</span> Sempurna! (10/10)
                            </div>
                        @else
                            <div class="mt-3 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <div class="font-bold mb-1">Nilai: {{ $results[$index]['score'] }}/10</div>
                                Jawaban yang benar: <strong class="text-gray-800">{{ $data['en'] }}</strong>
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
           
            @if(auth()->check() && auth()->user()->isAdmin())
                <!-- ADD QUESTION FORM -->
                <div class="bg-blue-50 p-6 rounded-xl mb-8 border-l-4 border-blue-500 shadow-sm">
                    <h3 class="text-lg font-bold text-blue-700 mb-4">Admin: Tambah Soal Baru</h3>
                    <form action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" method="POST">
                        @csrf
                        <input type="hidden" name="meeting_number" value="1">
                        <input type="hidden" name="question_number" value="{{ count($questions) + 1 }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold mb-1">Soal (Ind)</label>
                                <input type="text" name="question_text" class="w-full p-2 border rounded" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-1">Jawaban (Eng)</label>
                                <input type="text" name="correct_answer" class="w-full p-2 border rounded" required>
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Soal</button>
                    </form>
                </div>
            @endif

            <!-- Paragraph Section -->
            <div class="bg-sky-50 p-6 rounded-xl mb-8 border-l-4 border-sky-500 shadow-sm">
                <h3 class="text-xl font-bold text-sky-700 mb-4">Latihan Paragraf</h3>
               
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg mb-4 text-sm">
                    <strong class="block mb-2 text-yellow-900">Kosa Kata Bantuan :</strong>
                    <div class="flex flex-wrap gap-2">
                        @foreach($vocabList as $en => $vocabData)
                            <div class="relative group inline-block">
                                <span class="bg-white px-3 py-1 rounded-full border border-yellow-200 shadow-sm inline-flex items-center gap-2">
                                    <strong>{{ $en }}</strong> <span class="text-gray-500 text-xs">{{ $vocabData['pos'] }}</span>: {{ $vocabData['id'] }}
                                </span>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <div class="absolute -top-2 -right-2 hidden group-hover:flex gap-1 bg-white rounded-full shadow p-1 border z-10">
                                        <button type="button" 
                                                onclick="openMeeting1VocabEditModal(
                                                    {{ $vocabData['db_id'] ?? 0 }}, 
                                                    {{ \Illuminate\Support\Js::from($en) }}, 
                                                    {{ \Illuminate\Support\Js::from($vocabData['id']) }}, 
                                                    {{ \Illuminate\Support\Js::from($vocabData['pos']) }}
                                                )"
                                                class="text-blue-500 hover:text-blue-700 text-xs px-1 font-bold">E</button>
                                        <form action="{{ parse_url(route('admin.grammar.vocab.destroy', $vocabData['db_id'] ?? 0), PHP_URL_PATH) }}" method="POST" onsubmit="return confirm('Hapus vocab ini?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs px-1 font-bold">X</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <div class="mt-4 pt-4 border-t border-yellow-200">
                            <h4 class="text-sm font-bold text-yellow-800 mb-2">Admin: Tambah Keyword</h4>
                            <form action="{{ parse_url(route('admin.grammar.vocab.store'), PHP_URL_PATH) }}" method="POST" class="flex gap-2 flex-wrap items-end">
                                @csrf
                                <input type="hidden" name="meeting_number" value="1">
                                <div>
                                    <label class="text-xs block text-yellow-800">Word</label>
                                    <input type="text" name="word" class="p-1 border rounded text-sm w-32" required>
                                </div>
                                <div>
                                    <label class="text-xs block text-yellow-800">Trans</label>
                                    <input type="text" name="translation" class="p-1 border rounded text-sm w-32" required>
                                </div>
                                <div>
                                    <label class="text-xs block text-yellow-800">POS</label>
                                    <input type="text" name="pos" class="p-1 border rounded text-sm w-20" placeholder="(n)">
                                </div>
                                <button type="submit" class="bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700">Add</button>
                            </form>
                        </div>
                    @endif
                </div>
               
                <label class="block font-medium text-gray-800 mb-3 leading-relaxed">
                    {{ $paragraphData['id'] }}
                </label>
               
                <textarea name="paragraph_ans"
                          class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-sky-500 focus:ring-0 transition-colors min-h-[120px] {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                          placeholder="Terjemahkan paragraf di atas..."
                          {{ $submitted ? 'readonly' : '' }}>{{ old('paragraph_ans', $paragraphResult['user_answer'] ?? '') }}</textarea>
               
                @if($submitted)
                    <div class="mt-3 p-4 rounded-lg border {{ $paragraphResult['score'] == 50 ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' }}">
                        <div class="font-bold mb-1">Nilai: {{ $paragraphResult['score'] }}/50</div>
                        <div class="text-sm">
                            Jawaban yang benar:<br>
                            <strong class="text-gray-800 mt-1 block">{{ $paragraphData['en'] }}</strong>
                        </div>
                    </div>
                @endif
            </div>

            @if(!$submitted)
                <button type="submit" class="w-full py-4 bg-yellow-500 text-white rounded-xl font-bold text-lg hover:bg-yellow-600 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Cek Jawaban
                </button>
            @else
                <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting1.reset'), PHP_URL_PATH) }}">
                    @csrf
                    <button type="submit" class="block w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg text-center">
                        Coba Lagi
                    </button>
                </form>
            @endif
        </form>
    </div>

    <!-- Floating Pronoun Button -->
    <div x-data="{ open: false }" class="fixed bottom-8 right-8 z-50">
        <!-- Floating Button -->
        <button @click="open = true" 
                class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-6 py-3 rounded-full shadow-2xl hover:shadow-yellow-500/50 hover:scale-110 transition-all duration-300 font-bold text-lg flex items-center gap-2 group">
            <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span>Pronoun</span>
        </button>

        <!-- Modal -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
             style="display: none;"
             class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50">
            
            <!-- Modal Content -->
            <div @click.stop 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-auto relative">
                
                <!-- Close Button -->
                <button @click="open = false" 
                        class="absolute top-4 right-4 bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Header -->
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-t-2xl">
                    <h2 class="text-2xl font-bold flex items-center gap-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Pronoun Reference Table
                    </h2>
                    <p class="text-yellow-100 mt-2">Personal Pronoun dapat berubah tergantung dari posisinya di dalam kalimat</p>
                </div>

                <!-- Table Content -->
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-sm">
                            <thead>
                                <tr class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white">
                                    <th class="p-4 border-2 border-yellow-700 text-left font-bold">Subject</th>
                                    <th class="p-4 border-2 border-yellow-700 text-left font-bold">Object</th>
                                    <th class="p-4 border-2 border-yellow-700 text-left font-bold">Possessive Adjective</th>
                                    <th class="p-4 border-2 border-yellow-700 text-left font-bold">Possessive Pronoun</th>
                                    <th class="p-4 border-2 border-yellow-700 text-left font-bold">Reflexive Pronoun</th>
                                    <th class="p-4 border-2 border-yellow-700 text-left font-bold">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- I Row -->
                                <tr class="bg-blue-50 hover:bg-blue-100 transition-colors">
                                    <td class="p-4 border-2 border-gray-300 font-bold text-blue-700 text-lg">I</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Me</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">My</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Mine</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Myself</td>
                                    <td class="p-4 border-2 border-gray-300 text-gray-600 italic">Singular</td>
                                </tr>
                                <!-- You Row -->
                                <tr class="bg-green-50 hover:bg-green-100 transition-colors">
                                    <td class="p-4 border-2 border-gray-300 font-bold text-green-700 text-lg">You</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">You</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Your</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Yours</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Yourself / Yourselves</td>
                                    <td class="p-4 border-2 border-gray-300 text-gray-600 italic">Singular / Plural</td>
                                </tr>
                                <!-- They Row -->
                                <tr class="bg-purple-50 hover:bg-purple-100 transition-colors">
                                    <td class="p-4 border-2 border-gray-300 font-bold text-purple-700 text-lg">They</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Them</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Their</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Theirs</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Themselves</td>
                                    <td class="p-4 border-2 border-gray-300 text-gray-600 italic">Plural</td>
                                </tr>
                                <!-- We Row -->
                                <tr class="bg-pink-50 hover:bg-pink-100 transition-colors">
                                    <td class="p-4 border-2 border-gray-300 font-bold text-pink-700 text-lg">We</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Us</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Our</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Ours</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Ourselves</td>
                                    <td class="p-4 border-2 border-gray-300 text-gray-600 italic">Plural</td>
                                </tr>
                                <!-- He Row -->
                                <tr class="bg-indigo-50 hover:bg-indigo-100 transition-colors">
                                    <td class="p-4 border-2 border-gray-300 font-bold text-indigo-700 text-lg">He</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Him</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">His</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">His</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Himself</td>
                                    <td class="p-4 border-2 border-gray-300 text-gray-600 italic">Singular</td>
                                </tr>
                                <!-- She Row -->
                                <tr class="bg-rose-50 hover:bg-rose-100 transition-colors">
                                    <td class="p-4 border-2 border-gray-300 font-bold text-rose-700 text-lg">She</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Her</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Her</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Hers</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Herself</td>
                                    <td class="p-4 border-2 border-gray-300 text-gray-600 italic">Singular</td>
                                </tr>
                                <!-- It Row -->
                                <tr class="bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <td class="p-4 border-2 border-gray-300 font-bold text-gray-700 text-lg">It</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">It</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Its</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Its</td>
                                    <td class="p-4 border-2 border-gray-300 font-semibold text-gray-800">Itself</td>
                                    <td class="p-4 border-2 border-gray-300 text-gray-600 italic">Singular</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Note Section -->
                    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-gray-700">
                                <p class="font-bold text-yellow-800 mb-2">Catatan Penting:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li><strong>Subject:</strong> Digunakan sebagai subjek kalimat (pelaku)</li>
                                    <li><strong>Object:</strong> Digunakan sebagai objek (penerima aksi)</li>
                                    <li><strong>Possessive Adjective:</strong> Menunjukkan kepemilikan + diikuti kata benda</li>
                                    <li><strong>Possessive Pronoun:</strong> Menunjukkan kepemilikan tanpa kata benda</li>
                                    <li><strong>Reflexive Pronoun:</strong> Menunjukkan aksi kembali ke subjek (diri sendiri)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Modal Dispatch Functions -->
    <script>
        window.openMeeting1EditModal = function(id, question, answer, vocab) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m1', { 
                detail: { 
                    type: 'question',
                    id: id, 
                    question: question, 
                    answer: answer,
                    vocab: vocab
                } 
            }));
        };

        window.openMeeting1VocabEditModal = function(id, word, trans, pos) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m1', { 
                detail: { 
                    type: 'vocab',
                    id: id, 
                    word: word, 
                    trans: trans,
                    pos: pos
                } 
            }));
        };
    </script>
    
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
                    console.log(`Skipping readonly/disabled input: ${input.name}`);
                    return;
                }

                // Save immediately on every keystroke (input event)
                input.addEventListener('input', () => {
                    console.log(`Input event on ${input.name}, saving immediately...`);
                    this.saveAnswers();
                });

                // Also save on blur (when moving to next field)
                input.addEventListener('blur', () => {
                    console.log(`Blur event on ${input.name}, saving...`);
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

            console.log('Saving to localStorage:', this.storageKey);
            console.log('Data to save:', answers);
            console.log('Number of fields:', Object.keys(answers).length);

            try {
                localStorage.setItem(this.storageKey, JSON.stringify(answers));
                this.showSaveIndicator();
                this.queueDraftSync(form);
                console.log('✓ Answers auto-saved to localStorage successfully');
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
            const match = action.match(/\/assignments\/grammar-writing\/meeting(\d+)/);
            if (!match) {
                return false;
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
                const savedData = localStorage.getItem(this.storageKey);
                console.log('Attempting to restore from key:', this.storageKey);
                console.log('Saved data found:', savedData ? 'Yes' : 'No');
                
                if (!savedData) {
                    console.log('No saved data to restore');
                    return;
                }

                const answers = JSON.parse(savedData);
                console.log('Parsed answers:', answers);
                let restoredCount = 0;

                Object.keys(answers).forEach(name => {
                    const input = document.querySelector(`input[name="${name}"], textarea[name="${name}"]`);
                    console.log(`Looking for input with name="${name}":`, input ? 'Found' : 'Not found');
                    
                    if (input && !input.value && !input.readOnly) {
                        input.value = answers[name];
                        restoredCount++;
                        console.log(`Restored value for ${name}:`, answers[name]);
                    }
                });

                if (restoredCount > 0) {
                    console.log(`✓ Restored ${restoredCount} saved answers from localStorage`);
                    this.showRestoreIndicator(restoredCount);
                } else {
                    console.log('No answers were restored (fields might already have values or are readonly)');
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
        const form = document.querySelector('form[action*="/assignments/grammar-writing/meeting"][method="POST"]');
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


    // Initialize auto-save for meeting 1
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('1', userId);
        }
    });
    </script>
    <!-- Edit Modal -->
    <div x-data="{ editMode: false, editId: null, editType: '', editQ: '', editA: '', editWord: '', editTrans: '', editPos: '', editVocabJSON: '' }" 
         @open-edit-modal-m1.window="
            editMode = true; 
            editType = $event.detail.type; 
            editId = $event.detail.id;
            if (editType === 'question') {
                editQ = $event.detail.question;
                editA = $event.detail.answer;
                editVocabJSON = JSON.stringify($event.detail.vocab, null, 2);
            } else {
                editWord = $event.detail.word;
                editTrans = $event.detail.trans;
                editPos = $event.detail.pos;
            }
         "
         x-show="editMode" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50">
        
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6" @click.outside="editMode = false">
            <h3 class="text-xl font-bold mb-4">Edit Item</h3>
            
            <!-- Question Edit Form -->
            <form x-show="editType === 'question'" :action="'/admin/assignments/grammar-writing/questions/' + editId" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Soal</label>
                    <input type="text" name="question_text" class="w-full p-2 border rounded" x-model="editQ">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Jawaban <br><small class="text-gray-500 font-normal">Use <b>|</b> for multiple answers</small></label>
                    <input type="text" name="correct_answer" class="w-full p-2 border rounded" x-model="editA">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Vocabulary (JSON)</label>
                    <textarea name="vocab" class="w-full p-2 border rounded font-mono text-xs" rows="4" x-model="editVocabJSON"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Format: {"Word": {"pos": "n", "id": "Kata"}}</p>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="editMode = false" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                </div>
            </form>

            <!-- Vocab Edit Form -->
            <form x-show="editType === 'vocab'" :action="'/admin/assignments/grammar-writing/vocab/' + editId" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Word</label>
                    <input type="text" name="word" class="w-full p-2 border rounded" x-model="editWord">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Translation</label>
                    <input type="text" name="translation" class="w-full p-2 border rounded" x-model="editTrans">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">POS</label>
                    <input type="text" name="pos" class="w-full p-2 border rounded" x-model="editPos">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="editMode = false" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update</button>
                </div>
            </form>
        </div>
    </div>


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
