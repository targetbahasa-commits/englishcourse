<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 2</title>
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
    <div x-data="{ editMode: false, editId: null, editSection: '', editQ: '', editA: '', editTense: '', editStructure: '' }" class="max-w-7xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ $backRoute ?? route('assignments.grammar-writing') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium">
                &laquo; Kembali
            </a>
        </div>

        @if($stage === 3)
            <div class="bg-yellow-500 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Akhir: {{ $totalScore }} / 100</h2>
                <p class="text-lg opacity-90">
                    {{ $totalScore >= 80 ? 'Luar biasa!' : ($totalScore >= 60 ? 'Bagus, terus berlatih!' : 'Jangan menyerah, coba lagi!') }}
                </p>
                <div class="mt-4 flex justify-center gap-4 text-sm">
                    <span class="bg-white/20 px-3 py-1 rounded">Part 1: {{ $scorePart1 }}/50</span>
                    <span class="bg-white/20 px-3 py-1 rounded">Part 2: {{ $scorePart2 }}/50</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('assignments.grammar-writing.meeting2.submit') }}">
            @csrf
            
            <!-- Part 1: Tenses Matrix -->
            @if($stage >= 1)
            <h1 class="text-3xl font-bold text-center text-yellow-500 mb-8">Latihan Rumus Tenses Matrix</h1>
            <h3 class="text-3xl font-bold text-center text-yellow-500 mb-8">Pertemuan 2 - Tenses (Rumus)</h3>
               

                
                <div class="mb-8 text-center">
                    <!-- Panduan Rumus Tenses Image -->
                    <img src="{{ asset('images/tenses_guide.png') }}" alt="Panduan Rumus Tenses" class="max-w-full h-auto mx-auto border border-gray-200 rounded-lg shadow-sm mb-6" style="max-height: 400px;">
                    
                    <div class="inline-block p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <p class="text-gray-600 text-sm">Panduan: Isi kotak dengan rumus yang tepat. Gunakan format standar seperti "S + V1 + O".</p>
                    </div>
                </div>
                <div class="overflow-x-auto mb-8">
                    <table class="w-full border-collapse text-sm" style="min-width: 800px;">
                        <thead>
                            <tr class="bg-yellow-500 text-white">
                                <th class="p-5 border border-yellow-600 text-left w-1/4"></th>
                                <th class="p-5 border border-yellow-600 text-left w-1/4">Verbal / Aktif</th>
                                <th class="p-5 border border-yellow-600 text-left w-1/4">Nominal</th>
                                <th class="p-5 border border-yellow-600 text-left w-1/4">Passive</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tenses as $tenseName => $formulas)
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                    <td class="p-5 border border-gray-200 font-bold text-gray-700">{{ $tenseName }}</td>
                                    @foreach(['verbal', 'nominal', 'passive'] as $type)
                                        <td class="p-5 border border-gray-200 align-top">
                                            @php
                                                $key = str_replace(' ', '_', strtolower($tenseName)) . '_' . $type;
                                            @endphp
                                            <input type="text"
                                                   name="tenses[{{ $key }}]"
                                                   value="{{ old('tenses.'.$key, isset($results[$tenseName][$type]['user_answer']) ? $results[$tenseName][$type]['user_answer'] : '') }}"
                                                   class="w-full p-2 border border-gray-300 rounded focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 font-mono text-sm {{ $stage > 1 ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   {{ $stage > 1 ? 'readonly' : '' }}
                                                   autocomplete="off">

                                            <div class="mt-2 flex justify-end">
                                                <div class="flex flex-col gap-1">
                                                @if(isset($tenseExamples[$tenseName][$type]))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="text-yellow-600 hover:text-yellow-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-yellow-50 px-1.5 py-0.5 rounded border border-yellow-100 w-6 h-6 flex items-center justify-center">
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
                                                             class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                                            <strong class="block mb-1 text-yellow-300">Contoh ({{ $tenseName }} - {{ ucfirst($type) }}):</strong>
                                                            {{ $tenseExamples[$tenseName][$type]['id'] }}<br>
                                                            <em class="text-gray-300">{{ $tenseExamples[$tenseName][$type]['en'] }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(isset($vocabularies[$tenseName][$type]))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="text-green-600 hover:text-green-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-green-50 px-1.5 py-0.5 rounded border border-green-100 w-6 h-6 flex items-center justify-center">
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
                                                                @foreach($vocabularies[$tenseName][$type] as $en => $vocabData)
                                                                    <li class="flex justify-between gap-2">
                                                                        <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ $vocabData['pos'] }}</span></span>
                                                                        <span>{{ $vocabData['id'] }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                           
                                            @if($stage > 1 && isset($results[$tenseName][$type]))
                                                @php
                                                    $res = $results[$tenseName][$type];
                                                @endphp
                                                @if($res['is_correct'])
                                                    <div class="mt-1 text-xs font-bold text-green-600">✓ Benar</div>
                                                @else
                                                    <div class="mt-1 text-xs text-red-600 bg-red-50 p-1 rounded border border-red-100">
                                                        <strong>Salah.</strong><br>
                                                        Rumus: <span class="font-mono">{{ $res['correct_answer'] }}</span>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($stage === 2 || $stage === 3)
                <h2 class="text-2xl font-bold text-yellow-500 mb-6">Translate setiap kalimat berdasarkan tensesnya</h2>
               
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-6 rounded-xl mb-8">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-bold mb-2 flex items-center">
                                <span class="bg-yellow-200 text-yellow-800 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">1</span>
                                Identifikasi Tenses
                            </h3>
                            <p class="text-sm text-yellow-700">Lihat kolom "Tenses" untuk mengetahui pola kalimat yang harus digunakan.</p>
                        </div>
                        <div>
                            <h3 class="font-bold mb-2 flex items-center">
                                <span class="bg-yellow-200 text-yellow-800 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">2</span>
                                Terjemahkan
                            </h3>
                            <p class="text-sm text-yellow-700">Tulis terjemahan bahasa Inggris yang sesuai dengan rumus tenses tersebut.</p>
                        </div>
                    </div>
                </div>

                <!-- Grammar Cheat Sheet -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Simple Present Verbal -->
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 text-sm">
                        <h4 class="font-bold text-yellow-800 mb-2">Simple Present Verbal</h4>
                        <ul class="space-y-1 text-gray-700">
                            <li>I/ You/ We/ They/ Benda Jamak + <span class="font-bold">Verb 1</span></li>
                            <li>He/ She/ It/ Benda Tunggal + <span class="font-bold">Verb s/es</span></li>
                        </ul>
                    </div>

                    <!-- Simple Present Nominal -->
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 text-sm">
                        <h4 class="font-bold text-yellow-800 mb-2">Simple Present Nominal</h4>
                        <ul class="space-y-1 text-gray-700">
                            <li>I + <span class="font-bold">am</span></li>
                            <li>You/ We/ They/ Benda Jamak + <span class="font-bold">are</span></li>
                            <li>He/ She/ It/ Benda Tunggal + <span class="font-bold">is</span></li>
                        </ul>
                    </div>

                    <!-- Present Perfect -->
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 text-sm">
                        <h4 class="font-bold text-yellow-800 mb-2">Present Perfect</h4>
                        <ul class="space-y-1 text-gray-700">
                            <li>I/ You/ We/ They/ Benda Jamak + <span class="font-bold">have + V3</span></li>
                            <li>He/ She/ It/ Benda Tunggal + <span class="font-bold">has + V3</span></li>
                        </ul>
                    </div>

                    <!-- Simple Past Nominal -->
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 text-sm">
                        <h4 class="font-bold text-yellow-800 mb-2">Simple Past Nominal</h4>
                        <ul class="space-y-1 text-gray-700">
                            <li>You/ We/ They/ Benda Jamak + <span class="font-bold">were</span></li>
                            <li>I/ He/ She/ It/ Benda Tunggal + <span class="font-bold">was</span></li>
                        </ul>
                    </div>
                </div>

                <!-- Translation Sentences -->
                <div class="space-y-6 mb-8">
                    @foreach($translationSentences as $idx => $item)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex items-center mb-1">
                                <label class="block font-bold text-gray-800 mr-2">
                                    {{ $idx }}. {{ $item['id'] }}
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <div class="inline-flex gap-2 ml-2 text-xs font-normal">
                                            <button type="button" @click="editMode = true; editSection = 'sentences'; editId = {{ $item['original_id'] ?? 0 }}; editQ = '{{ addslashes($item['id']) }}'; editA = '{{ addslashes($item['en']) }}'; editTense = '{{ $item['tense'] }}'; editStructure = '{{ $item['type'] }}'" class="text-blue-600 hover:text-blue-800 underline">Edit</button>
                                            <form action="{{ route('admin.grammar.question.destroy', $item['original_id'] ?? 0) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 underline">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </label>
                                <div class="flex flex-col gap-1">
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
                                            <strong class="block mb-1 text-yellow-300">Contoh ({{ $item['tense'] }} - {{ ucfirst($item['type']) }}):</strong>
                                            {{ $tenseExamples[$item['tense']][$item['type']]['id'] }}<br>
                                            <em class="text-gray-300">{{ $tenseExamples[$item['tense']][$item['type']]['en'] }}</em>
                                            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                        </div>
                                    </div>

                                    <!-- Vocabulary Helper -->
                                    @if(isset($vocabularies[$item['tense']][$item['type']]))
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
                                             class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                            <ul class="space-y-1">
                                                @foreach($vocabularies[$item['tense']][$item['type']] as $en => $vocabData)
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
                            <div class="text-xs text-sky-600 font-mono mb-2 bg-sky-50 inline-block px-2 py-1 rounded border border-sky-100">
                                Rumus: {{ $tenses[$item['tense']][$item['type']] }}
                            </div>
                            <input type="text"
                                   name="trans_sent[{{ $idx }}]"
                                   value="{{ old('trans_sent.'.$idx, isset($transResults['sentences'][$idx]['user_answer']) ? $transResults['sentences'][$idx]['user_answer'] : '') }}"
                                   class="w-full p-2 border border-gray-300 rounded focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 {{ $stage === 3 ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                   placeholder="Translate to English..."
                                   {{ $stage === 3 ? 'readonly' : '' }}
                                   autocomplete="off">
                           
                            @if($stage === 3 && isset($transResults['sentences'][$idx]))
                                @php
                                    $res = $transResults['sentences'][$idx];
                                @endphp
                                @if($res['is_correct'])
                                    <div class="mt-2 text-sm font-bold text-green-600">✓ Benar</div>
                                @else
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                        <strong>Salah.</strong><br>
                                        Jawaban: {{ $res['correct_answer'] }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>

                @if(auth()->check() && auth()->user()->isAdmin())
                    <!-- ADD QUESTION FORM (SENTENCES) -->
                    <div class="bg-blue-50 p-6 rounded-xl mb-8 border-l-4 border-blue-500 shadow-sm">
                        <h3 class="text-lg font-bold text-blue-700 mb-4">Admin: Tambah Soal Baru (Kalimat)</h3>
                        <form action="{{ route('admin.grammar.question.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="meeting_number" value="2">
                            <input type="hidden" name="section" value="sentences">
                            <input type="hidden" name="question_number" value="{{ count($translationSentences) + 1 }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-bold mb-1">Soal (Ind)</label>
                                    <input type="text" name="question_text" class="w-full p-2 border rounded" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-1">Jawaban (Eng)</label>
                                    <input type="text" name="correct_answer" class="w-full p-2 border rounded" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-1">Tenses</label>
                                    <input type="text" name="tense" class="w-full p-2 border rounded" placeholder="e.g. Simple Present" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-1">Structure (Type)</label>
                                    <select name="structure" class="w-full p-2 border rounded" required>
                                        <option value="verbal">Verbal</option>
                                        <option value="nominal">Nominal</option>
                                        <option value="passive">Passive</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Soal</button>
                        </form>
                    </div>
                @endif

                <!-- Translation Matrix -->
                <div class="overflow-x-auto mb-8">
                    <table class="w-full border-collapse text-sm" style="min-width: 800px;">
                        <thead>
                            <tr class="bg-yellow-500 text-white">
                                <th class="p-5 border border-yellow-600 text-left w-1/4">Tenses</th>
                                <th class="p-5 border border-yellow-600 text-left w-1/4">Verbal / Aktif</th>
                                <th class="p-5 border border-yellow-600 text-left w-1/4">Nominal</th>
                                <th class="p-5 border border-yellow-600 text-left w-1/4">Passive</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($translationMatrix as $tenseName => $items)
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                    <td class="p-5 border border-gray-200 font-bold text-gray-700">{{ $tenseName }}</td>
                                    @foreach(['verbal', 'nominal', 'passive'] as $type)
                                        <td class="p-5 border border-gray-200 align-top">
                                            <div class="mb-1 text-sm font-medium text-gray-800 flex items-center gap-2">
                                                {{ $items[$type]['id'] }}
                                                @if(auth()->check() && auth()->user()->isAdmin())
                                                    <button type="button" 
                                                        @click="editMode = true; editSection = 'matrix'; editId = {{ $items[$type]['original_id'] ?? 0 }}; editQ = '{{ addslashes($items[$type]['id']) }}'; editA = '{{ addslashes($items[$type]['en']) }}'; editTense = '{{ $tenseName }}'; editStructure = '{{ $type }}'"
                                                        class="text-blue-600 hover:text-blue-800 text-xs ml-2 cursor-pointer font-normal">
                                                        [Edit]
                                                    </button>
                                                @endif
                                                <div class="flex flex-col gap-1">
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="text-yellow-600 hover:text-yellow-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-yellow-50 px-1.5 py-0.5 rounded border border-yellow-100 w-6 h-6 flex items-center justify-center">
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
                                                            <strong class="block mb-1 text-yellow-300">Contoh ({{ $tenseName }} - {{ ucfirst($type) }}):</strong>
                                                            {{ $tenseExamples[$tenseName][$type]['id'] }}<br>
                                                            <em class="text-gray-300">{{ $tenseExamples[$tenseName][$type]['en'] }}</em>
                                                            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Vocabulary Helper -->
                                                    @if(isset($vocabularies[$tenseName][$type]))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="text-green-600 hover:text-green-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-green-50 px-1.5 py-0.5 rounded border border-green-100 w-6 h-6 flex items-center justify-center">
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
                                                             class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                             <ul class="space-y-1">
                                                                @foreach($vocabularies[$tenseName][$type] as $en => $vocabData)
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
                                            <div class="mb-2 text-xs text-sky-600 font-mono bg-sky-50 inline-block px-2 py-1 rounded border border-sky-100">
                                                {{ $tenses[$tenseName][$type] }}
                                            </div>
                                            @php
                                                $key = str_replace(' ', '_', strtolower($tenseName)) . '_' . $type;
                                            @endphp
                                            <input type="text"
                                                   name="trans_matrix[{{ $key }}]"
                                                   value="{{ old('trans_matrix.'.$key, isset($transResults['matrix'][$tenseName][$type]['user_answer']) ? $transResults['matrix'][$tenseName][$type]['user_answer'] : '') }}"
                                                   class="w-full p-2 border border-gray-300 rounded focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 text-sm {{ $stage === 3 ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate..."
                                                   {{ $stage === 3 ? 'readonly' : '' }}
                                                   autocomplete="off">
                                           
                                            @if($stage === 3 && isset($transResults['matrix'][$tenseName][$type]))
                                                @php
                                                    $res = $transResults['matrix'][$tenseName][$type];
                                                @endphp
                                                @if($res['is_correct'])
                                                    <div class="mt-1 text-xs font-bold text-green-600">✓ Benar</div>
                                                @else
                                                    <div class="mt-1 text-xs text-red-600 bg-red-50 p-1 rounded border border-red-100">
                                                        <strong>Salah.</strong><br>
                                                        Jawaban: {{ $res['correct_answer'] }}
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-8">
                @if($stage === 1)
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition-colors shadow-lg">
                        Cek Jawaban & Lanjut &raquo;
                    </button>
                @elseif($stage === 2)
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition-colors shadow-lg">
                        Cek Semua Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($stage === 3)
            <form method="POST" action="{{ route('assignments.grammar-writing.meeting2.reset') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Ulangi Latihan
                </button>
            </form>
        @endif

        <!-- EDIT QUESTION MODAL -->
        <div x-show="editMode" 
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
             style="display: none;">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Edit Soal</h3>
                <form :action="'{{ route('admin.grammar.question.update', '0') }}'.slice(0, -1) + editId" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="meeting_number" value="2">
                    <input type="hidden" name="section" :value="editSection">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Soal (Ind)</label>
                        <input type="text" name="question_text" x-model="editQ" class="w-full p-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Jawaban (Eng)</label>
                        <input type="text" name="correct_answer" x-model="editA" class="w-full p-2 border rounded">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                         <div>
                            <label class="block text-xs text-gray-500">Tense</label>
                            <input type="text" name="tense" x-model="editTense" class="w-full p-2 border rounded bg-gray-100 text-sm" readonly>
                         </div>
                         <div>
                            <label class="block text-xs text-gray-500">Structure</label>
                            <input type="text" name="structure" x-model="editStructure" class="w-full p-2 border rounded bg-gray-100 text-sm" readonly>
                         </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="editMode = false" class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Irregular Verbs Button -->
    <x-irregular-verbs-button />



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

    // Initialize auto-save for meeting 2
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId) {
            AutoSave.init('2', userId);
        }
    });
    </script>


</body>
</html>