<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 5</title>
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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div class="max-w-7xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('assignments.grammar-writing') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium">
                &laquo; Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bold text-center text-red-600 mb-8">Negative Sentence (Pertemuan 5)</h1>
        <p class="text-center text-gray-600 mb-8">Translate setiap kalimat berdasarkan tensesnya!</p>

        @if($submitted)
            <div class="bg-red-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-red-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('assignments.grammar-writing.meeting5.submit') }}">
            @csrf
            
            <!-- Section 1: Simple Sentences -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-xl font-bold text-gray-800">A. Simple Sentences</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <button type="button" onclick="openMeeting5AddModal('sentences')" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            + Add Question
                        </button>
                    @endif
                </div>
                <div class="space-y-6">
                    @foreach($questions as $idx => $data)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-red-500 shadow-sm">
                            <div class="flex justify-between items-start gap-4 mb-2">
                                <label class="block font-bold text-lg text-gray-800">{{ $idx }}. {{ $data['id'] }}</label>
                                
                                <div class="flex flex-col gap-1 shrink-0">
                                    <!-- Example Button -->
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
                                             class="absolute right-full top-0 mr-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                            <strong class="block mb-1 text-yellow-300">Contoh ({{ $data['tense'] }}):</strong>
                                            {{ $tenseExamples[$data['tense']]['verbal']['id'] ?? '-' }}<br>
                                            <em class="text-gray-300">{{ $tenseExamples[$data['tense']]['verbal']['en'] ?? '-' }}</em>
                                            <div class="absolute top-2 -right-1 w-2 h-2 bg-gray-800 rotate-45"></div>
                                        </div>
                                    </div>

                                    <!-- Vocabulary Button -->
                                    @if(isset($vocabularies[$data['tense']]['verbal']))
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
                                             class="absolute right-full top-0 mr-2 w-64 bg-white text-gray-800 text-xs rounded-lg p-3 shadow-xl border border-gray-200 z-10 text-left">
                                            <strong class="block mb-2 text-green-600 border-b border-gray-100 pb-1">Kosa Kata:</strong>
                                            <ul class="space-y-1">
                                                @foreach($vocabularies[$data['tense']]['verbal'] ?? [] as $vocabItem)
                                                    <li class="flex justify-between items-center">
                                                        <span><span class="font-medium">{{ $vocabItem['ind'] }}</span>: {{ $vocabItem['en'] }}</span>
                                                        @if(auth()->check() && auth()->user()->isAdmin())
                                                            <div class="flex gap-1">
                                                                <button type="button" 
                                                                    onclick="openMeeting5VocabEditModal({{ $vocabItem['db_id'] }}, '{{ addslashes($vocabItem['ind']) }}', '{{ addslashes($vocabItem['en']) }}')"
                                                                    class="text-blue-500 hover:text-blue-700 text-[10px] font-bold">E</button>
                                                                <form action="{{ route('admin.grammar.vocab.destroy', $vocabItem['db_id']) }}" method="POST" onsubmit="return confirm('Hapus vocab?')" class="inline">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-[10px] font-bold">X</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                                @if(auth()->check() && auth()->user()->isAdmin())
                                                    <li class="mt-2 text-center border-t pt-2">
                                                        <button type="button" onclick="openMeeting5AddVocabModal('{{ $data['tense'] }} - verbal')" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200 w-full">+ Add Vocab</button>
                                                    </li>
                                                @endif
                                            </ul>
                                            <div class="absolute top-8 -right-1 w-2 h-2 bg-white border-t border-r border-gray-200 rotate-45"></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-mono text-red-600 bg-red-50 px-2 py-1 rounded border border-red-100">{{ $data['tense'] }}</span>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <div class="flex gap-2">
                                        <button type="button" 
                                            onclick="openMeeting5EditModal(
                                                {{ $data['db_id'] }}, 
                                                '{{ addslashes($data['id']) }}', 
                                                '{{ addslashes($data['en']) }}', 
                                                '{{ $data['tense'] }}'
                                            )"
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
                            </div>
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[sentences][{{ $idx }}]"
                                       value="{{ old('userAnswers.sentences.'.$idx, $userAnswers['sentences'][$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
                                @if($submitted)
                                    @if($results['sentences'][$idx]['score'] == 100)
                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                            ✓ Sempurna!
                                        </div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Nilai: {{ $results['sentences'][$idx]['score'] }}</strong><br>
                                            Koreksi: {!! $results['sentences'][$idx]['formatted_answer'] !!}<br>
                                            <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section 2: Matrix -->
            <div class="mb-12">
            <!-- Section 2: Matrix -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-xl font-bold text-gray-800">B. Tenses Matrix (Negative)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm" style="min-width: 900px;">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="p-4 border border-gray-700 text-left w-1/6">Tenses</th>
                                <th class="p-4 border border-gray-700 text-left w-1/4">Verbal / Aktif</th>
                                <th class="p-4 border border-gray-700 text-left w-1/4">Nominal</th>
                                <th class="p-4 border border-gray-700 text-left w-1/4">Passive</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matrix as $tense => $types)
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                    <td class="p-4 border border-gray-200 font-bold text-gray-700 align-top">{{ $tense }}</td>
                                    @foreach(['verbal', 'nominal', 'passive'] as $type)
                                        <td class="p-4 border border-gray-200 align-top relative group">
                                            @if(isset($types[$type]) && $types[$type] !== null)
                                                <div class="mb-2 text-sm text-gray-800 font-medium italic flex justify-between items-start gap-2">
                                                    <span>{{ $types[$type]['id'] }}</span>
                                                    
                                                    <div class="flex flex-col gap-1 shrink-0">
                                                        <!-- Example Button -->
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
                                                                 class="absolute right-full top-0 mr-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                                                <strong class="block mb-1 text-yellow-300">Contoh ({{ $tense }} - {{ ucfirst($type) }}):</strong>
                                                                {{ $tenseExamples[$tense][$type]['id'] ?? '-' }}<br>
                                                                <em class="text-gray-300">{{ $tenseExamples[$tense][$type]['en'] ?? '-' }}</em>
                                                                <div class="absolute top-2 -right-1 w-2 h-2 bg-gray-800 rotate-45"></div>
                                                            </div>
                                                        </div>

                                                        <!-- Vocabulary Button -->
                                                        @if(isset($vocabularies[$tense][$type]))
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
                                                                 class="absolute right-full top-0 mr-2 w-64 bg-white text-gray-800 text-xs rounded-lg p-3 shadow-xl border border-gray-200 z-10 text-left">
                                                                <strong class="block mb-2 text-green-600 border-b border-gray-100 pb-1">Kosa Kata:</strong>
                                                                <ul class="space-y-1">
                                                                    @foreach($vocabularies[$tense][$type] ?? [] as $vocabItem)
                                                                        <li class="flex justify-between items-center gap-2">
                                                                            <span><span class="font-medium">{{ $vocabItem['ind'] }}</span>: {{ $vocabItem['en'] }}</span>
                                                                            @if(auth()->check() && auth()->user()->isAdmin())
                                                                                <div class="flex gap-1 shrink-0">
                                                                                    <button type="button" 
                                                                                        onclick="openMeeting5VocabEditModal({{ $vocabItem['db_id'] }}, '{{ addslashes($vocabItem['ind']) }}', '{{ addslashes($vocabItem['en']) }}')"
                                                                                        class="text-blue-500 hover:text-blue-700 text-[10px] font-bold">E</button>
                                                                                    <form action="{{ route('admin.grammar.vocab.destroy', $vocabItem['db_id']) }}" method="POST" onsubmit="return confirm('Hapus vocab?')" class="inline">
                                                                                        @csrf @method('DELETE')
                                                                                        <button type="submit" class="text-red-500 hover:text-red-700 text-[10px] font-bold">X</button>
                                                                                    </form>
                                                                                </div>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                    @if(auth()->check() && auth()->user()->isAdmin())
                                                                        <li class="mt-2 text-center border-t pt-2">
                                                                            <button type="button" onclick="openMeeting5AddVocabModal('{{ $tense }} - {{ $type }}')" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200 w-full">+ Add Vocab</button>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                                <div class="absolute top-8 -right-1 w-2 h-2 bg-white border-t border-r border-gray-200 rotate-45"></div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if(auth()->check() && auth()->user()->isAdmin())
                                                    <div class="absolute top-1 right-1 hidden group-hover:flex gap-1 bg-white shadow rounded p-1 z-10">
                                                        <button type="button" 
                                                            onclick="openMeeting5EditModal(
                                                                {{ $types[$type]['db_id'] }}, 
                                                                '{{ addslashes($types[$type]['id']) }}', 
                                                                '{{ addslashes($types[$type]['en']) }}', 
                                                                '{{ $tense }}',
                                                                '{{ $type }}'
                                                            )"
                                                            class="w-6 h-6 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded transition-colors">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                        </button>
                                                    </div>
                                                @endif
                                                
                                                @php
                                                    $key = str_replace(' ', '_', strtolower($tense)) . '_' . $type;
                                                @endphp
                                                
                                                <input type="text"
                                                       name="userAnswers[matrix][{{ $key }}]"
                                                       value="{{ old('userAnswers.matrix.'.$key, $userAnswers['matrix'][$key] ?? '') }}"
                                                       class="w-full p-2 border border-gray-300 rounded focus:border-red-400 focus:ring-1 focus:ring-red-400 text-sm {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                       placeholder="Translate..."
                                                       {{ $submitted ? 'readonly' : '' }}
                                                       autocomplete="off">

                                                @if($submitted)
                                                    @php
                                                        $res = $results['matrix'][$tense][$type];
                                                    @endphp
                                                    @if($res['score'] == 100)
                                                        <div class="mt-1 text-xs font-bold text-green-600">✓ Benar</div>
                                                    @else
                                                        <div class="mt-1 text-xs text-red-600 bg-red-50 p-1 rounded border border-red-100">
                                                            {!! $res['formatted_answer'] !!}<br>
                                                            <span class="text-gray-500 text-[10px]">{{ $res['correct_answer'] }}</span>
                                                        </div>
                                                    @endif
                                                @endif
                                            @else
                                                <div class="h-full flex flex-col justify-center items-center text-center">
                                                    <span class="text-gray-400 text-xs">-</span>
                                                    @if(auth()->check() && auth()->user()->isAdmin())
                                                        <button type="button" onclick="openMeeting5AddQuestionModal('matrix', '{{ $tense }}', '{{ $type }}')" class="mt-2 text-[10px] bg-blue-100 text-blue-600 px-2 py-1 rounded hover:bg-blue-200">+ Add</button>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 3: PR (Passive Reporting) -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-xl font-bold text-gray-800">C. Translate Kalimat</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <button type="button" onclick="openMeeting5AddModal('pr')" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            + Add Question
                        </button>
                    @endif
                </div>
                <div class="space-y-6">
                    @foreach($prQuestions as $idx => $data)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-purple-500 shadow-sm">
                            <div class="flex justify-between items-start gap-4 mb-2">
                                <div class="flex items-center gap-2">
                                    <label class="block font-bold text-lg text-gray-800">{{ $loop->iteration }}. {{ $data['id'] }}</label>
                                    
                                    <!-- Example Button (?) -->
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
                                             class="absolute right-full top-0 mr-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                            <strong class="block mb-1 text-yellow-300">Contoh ({{ $data['tense'] }}):</strong>
                                            {{ $data['example']['id'] }}<br>
                                            <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                            <div class="absolute top-2 -right-1 w-2 h-2 bg-gray-800 rotate-45"></div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Vocabulary Button (V) -->
                                    @if(isset($data['vocabulary']) && count($data['vocabulary']) > 0)
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
                                             class="absolute right-full top-0 mr-2 w-64 bg-white text-gray-800 text-xs rounded-lg p-3 shadow-xl border border-gray-200 z-10 text-left">
                                            <strong class="block mb-2 text-green-600 border-b border-gray-100 pb-1">Kosa Kata:</strong>
                                            <ul class="space-y-1">
                                                @foreach($data['vocabulary'] as $ind => $en)
                                                    <li class="flex justify-between items-center">
                                                        <span><span class="font-medium">{{ $ind }}</span>: {{ $en }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="absolute top-8 -right-1 w-2 h-2 bg-white border-t border-r border-gray-200 rotate-45"></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <div class="flex gap-2 shrink-0">
                                        <button type="button" 
                                            onclick="openMeeting5EditModal(
                                                {{ $data['db_id'] }}, 
                                                '{{ addslashes($data['id']) }}', 
                                                '{{ addslashes($data['en']) }}', 
                                                'PR'
                                            )"
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
                            </div>
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[pr][{{ $idx }}]"
                                       value="{{ old('userAnswers.pr.'.$idx, $userAnswers['pr'][$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-1 focus:ring-purple-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
                                @if($submitted && isset($results['pr'][$idx]))
                                    @if($results['pr'][$idx]['score'] == 100)
                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                            ✓ Sempurna!
                                        </div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Nilai: {{ $results['pr'][$idx]['score'] }}</strong><br>
                                            Koreksi: {!! $results['pr'][$idx]['formatted_answer'] !!}<br>
                                            <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8">
                @if(!$submitted)
                    <button type="submit" class="w-full py-4 bg-red-600 text-white rounded-xl font-bold text-lg hover:bg-red-700 transition-colors shadow-lg">
                        Cek Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($submitted)
            <form method="POST" action="{{ route('assignments.grammar-writing.meeting5.reset') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>

    <!-- Global Dispatch Scripts -->
    <script>
        window.openMeeting5EditModal = function(id, question, answer, tense, structure = null) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m5', { 
                detail: { type: 'edit_question', id, question, answer, tense, structure } 
            }));
        };
        window.openMeeting5AddModal = function(section) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m5', { 
                detail: { type: 'add_question', section } 
            }));
        };
        window.openMeeting5AddQuestionModal = function(section, tense, structure) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m5', { 
                detail: { type: 'add_question', section, tense, structure } 
            }));
        };
        window.openMeeting5VocabEditModal = function(id, word, trans) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m5', { 
                detail: { type: 'edit_vocab', id, word, trans } 
            }));
        };
        window.openMeeting5AddVocabModal = function(sectionKey) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m5', { 
                detail: { type: 'add_vocab', sectionKey } 
            }));
        };
    </script>

    <!-- Modals -->
    <div x-data="{ 
            mode: '', 
            isOpen: false,
            // Question Fields
            qId: null, qText: '', qAns: '', qTense: '', qStructure: '', qSection: '',
            // Vocab Fields
            vId: null, vWord: '', vTrans: '', vSectionKey: ''
         }"
         @open-edit-modal-m5.window="
            isOpen = true;
            mode = $event.detail.type;
            if (mode === 'edit_question') {
                qId = $event.detail.id;
                qText = $event.detail.question;
                qAns = $event.detail.answer;
                qTense = $event.detail.tense;
                qStructure = $event.detail.structure;
            } else if (mode === 'add_question') {
                qSection = $event.detail.section;
                qTense = $event.detail.tense || '';
                qStructure = $event.detail.structure || '';
                qText = ''; qAns = '';
            } else if (mode === 'edit_vocab') {
                vId = $event.detail.id;
                vWord = $event.detail.word;
                vTrans = $event.detail.trans;
            } else if (mode === 'add_vocab') {
                vSectionKey = $event.detail.sectionKey;
                vWord = ''; vTrans = '';
            }
         "
         x-show="isOpen" 
         x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 p-4"
    >
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6" @click.outside="isOpen = false">
            
            <!-- ADD/EDIT QUESTION FORM -->
            <template x-if="mode === 'edit_question' || mode === 'add_question'">
                <form :action="mode === 'edit_question' ? '/admin/grammar/question/' + qId : '/admin/grammar/question'" method="POST">
                    @csrf
                    <template x-if="mode === 'edit_question'">
                        @method('PUT')
                    </template>
                    
                    <h3 class="text-lg font-bold mb-4" x-text="mode === 'edit_question' ? 'Edit Question' : 'Add Question'"></h3>
                    
                    <input type="hidden" name="meeting_number" value="5">
                    <input type="hidden" name="section" x-model="qSection" x-if="mode === 'add_question'">
                    
                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Question (Indonesian)</label>
                        <input type="text" name="question_text" x-model="qText" class="w-full border rounded p-2" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Answer (English)</label>
                        <input type="text" name="correct_answer" x-model="qAns" class="w-full border rounded p-2" required>
                        <small class="text-gray-500">Use | for multiple answers</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Tense</label>
                        <input type="text" name="tense" x-model="qTense" class="w-full border rounded p-2" :readonly="mode === 'add_question' && qSection === 'matrix'">
                    </div>
                    
                    <template x-if="qStructure !== null && (qSection === 'matrix' || mode === 'edit_question')">
                        <div class="mb-3">
                            <label class="block text-sm font-bold mb-1">Structure (verbal/nominal/passive)</label>
                            <input type="text" name="structure" x-model="qStructure" class="w-full border rounded p-2" :readonly="mode === 'add_question' && qSection === 'matrix'">
                        </div>
                    </template>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="isOpen = false" class="px-4 py-2 text-gray-600">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                    </div>
                </form>
            </template>

            <!-- ADD/EDIT VOCAB FORM -->
            <template x-if="mode === 'edit_vocab' || mode === 'add_vocab'">
                <form :action="mode === 'edit_vocab' ? '/admin/grammar/vocab/' + vId : '/admin/grammar/vocab'" method="POST">
                    @csrf
                    <template x-if="mode === 'edit_vocab'">
                        @method('PUT')
                    </template>

                    <h3 class="text-lg font-bold mb-4" x-text="mode === 'edit_vocab' ? 'Edit Vocab' : 'Add Vocab'"></h3>
                    
                    <input type="hidden" name="meeting_number" value="5">
                    <input type="hidden" name="pos" value="general">
                    <template x-if="mode === 'add_vocab'">
                        <input type="hidden" name="section" x-model="vSectionKey">
                    </template>

                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Word (Indonesian)</label>
                        <input type="text" name="word" x-model="vWord" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Translation (English)</label>
                        <input type="text" name="translation" x-model="vTrans" class="w-full border rounded p-2" required>
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="isOpen = false" class="px-4 py-2 text-gray-600">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
                    </div>
                </form>
            </template>
        
        </div>
    </div>

    <!-- Irregular Verbs Floating Button -->
    
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

    // Initialize auto-save for meeting 5
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId) {
            AutoSave.init('5', userId);
        }
    });
    </script>

</body>
</html>
