<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 1</title>
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
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('assignments.grammar-writing') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium">
                &laquo; Kembali
            </a>
        </div>

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

        <form method="POST" action="{{ route('assignments.grammar-writing.meeting1.submit') }}">
            @csrf
            @foreach($questions as $index => $data)
                <div class="bg-gray-50 p-6 rounded-xl mb-6 border-l-4 border-yellow-400 shadow-sm">
                    <div class="flex items-start mb-3">
                        <label class="block font-bold text-gray-800 text-lg flex-1">
                            {{ $index }}. {{ $data['id'] }}
                        </label>
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
           
            <!-- Paragraph Section -->
            <div class="bg-sky-50 p-6 rounded-xl mb-8 border-l-4 border-sky-500 shadow-sm">
                <h3 class="text-xl font-bold text-sky-700 mb-4">Latihan Paragraf</h3>
               
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg mb-4 text-sm">
                    <strong class="block mb-2 text-yellow-900">Kosa Kata Bantuan :</strong>
                    <div class="flex flex-wrap gap-2">
                        @foreach($vocabList as $en => $vocabData)
                            <span class="bg-white px-3 py-1 rounded-full border border-yellow-200 shadow-sm">
                                <strong>{{ $en }}</strong> <span class="text-gray-500 text-xs">{{ $vocabData['pos'] }}</span>: {{ $vocabData['id'] }}
                            </span>
                        @endforeach
                    </div>
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
                <a href="{{ route('assignments.grammar-writing.meeting1') }}" class="block w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg text-center">
                    Coba Lagi
                </a>
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
</body>
</html>
