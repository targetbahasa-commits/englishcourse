<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 6</title>
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
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ $backRoute ?? route('assignments.grammar-writing') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium">
                &laquo; Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bold text-center text-purple-600 mb-8">To Infinitive & Gerund (Pertemuan 6)</h1>
        <p class="text-center text-gray-600 mb-8">Translate kalimat berikut ke dalam bahasa Inggris.</p>

        <!-- Tips Section -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded-r-xl shadow-sm">
            <h3 class="font-bold text-blue-800 text-lg mb-2">💡 Tips Mengerjakan:</h3>
            <ol class="list-decimal list-inside space-y-2 text-blue-700">
                <li>Cari semua <span class="font-semibold">Verb</span> dalam kalimat.</li>
                <li>Tentukan mana <span class="font-semibold">Verb Asli</span> (yang menggunakan tenses).</li>
                <li>Verb lainnya adalah <span class="font-semibold">Verb Palsu</span>.</li>
                <li>Tentukan apakah Verb Palsu-nya menggunakan <span class="font-semibold">Gerund</span> atau <span class="font-semibold">To Infinitive</span> dengan melihat daftar di tombol <span class="bg-sky-400 text-white px-2 py-0.5 rounded text-xs font-bold">Verb Patterns</span>.</li>
            </ol>
        </div>

        @if($submitted)
            <div class="bg-purple-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-purple-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('assignments.grammar-writing.meeting6.submit') }}">
            @csrf
            
            <!-- Section 1: Verb Patterns -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">A. Verb Patterns (To Infinitive & Gerund)</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <button type="button" onclick="openMeeting6AddModal('verb_patterns')" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            + Add Question
                        </button>
                    @endif
                </div>
                <div class="space-y-6">
                    @foreach($verbPatterns as $idx => $data)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-purple-500 shadow-sm">
                            <div class="flex items-center gap-2 mb-4">
                                <label class="font-bold text-lg text-gray-800">{{ $idx }}. {{ $data['id'] }}</label>
                                
                                <!-- Example Helper -->
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-sm font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                        ?
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed" style="display: none;">
                                        <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                        {{ $data['example']['id'] }}<br>
                                        <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>

                                <!-- Vocabulary Helper -->
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-sm font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                        v
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                        <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                        <ul class="space-y-1">
                                            @foreach($data['vocab'] as $word => $info)
                                                <li class="flex justify-between">
                                                    <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ $info['pos'] }}</span></span>
                                                    <span>{{ $info['id'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>
                            </div>
                            
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <div class="flex justify-end gap-2 mb-2">
                                    <button type="button" 
                                        onclick="openMeeting6EditModal(
                                            {{ $data['db_id'] }}, 
                                            '{{ addslashes($data['id']) }}', 
                                            '{{ addslashes($data['en']) }}', 
                                            'verb_patterns'
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
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[verbPatterns][{{ $idx }}]"
                                       value="{{ old('userAnswers.verbPatterns.'.$idx, $userAnswers['verbPatterns'][$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-1 focus:ring-purple-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
                                @if($submitted)
                                    @if($results['verbPatterns'][$idx]['score'] == 100)
                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                            ✓ Sempurna!
                                        </div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Nilai: {{ $results['verbPatterns'][$idx]['score'] }}</strong><br>
                                            Koreksi: {!! $results['verbPatterns'][$idx]['formatted_answer'] !!}<br>
                                            <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section 2: To Infinitive -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">B. To Infinitive</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <button type="button" onclick="openMeeting6AddModal('to_infinitive')" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            + Add Question
                        </button>
                    @endif
                </div>
                <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-6">
                    <p class="text-sm text-blue-800"><strong>Contoh:</strong> Masyarakat perlu untuk mempertimbangkan perlindungan lingkungan.</p>
                    <p class="text-sm text-blue-600 italic">→ Society needs to consider nature protection.</p>
                </div>
                <div class="space-y-6">
                    @foreach($toInfinitive as $idx => $data)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-blue-500 shadow-sm">
                            <div class="flex items-center gap-2 mb-4">
                                <label class="font-bold text-lg text-gray-800">{{ $idx }}. {{ $data['id'] }}</label>
                                
                                <!-- Example Helper -->
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-sm font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                        ?
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed" style="display: none;">
                                        <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                        {{ $data['example']['id'] }}<br>
                                        <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>

                                <!-- Vocabulary Helper -->
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-sm font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                        v
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                        <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                        <ul class="space-y-1">
                                            @foreach($data['vocab'] as $word => $info)
                                                <li class="flex justify-between">
                                                    <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ $info['pos'] }}</span></span>
                                                    <span>{{ $info['id'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>
                            </div>

                            @if(auth()->check() && auth()->user()->isAdmin())
                                <div class="flex justify-end gap-2 mb-2">
                                    <button type="button" 
                                        onclick="openMeeting6EditModal(
                                            {{ $data['db_id'] }}, 
                                            '{{ addslashes($data['id']) }}', 
                                            '{{ addslashes($data['en']) }}', 
                                            'to_infinitive'
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
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[toInfinitive][{{ $idx }}]"
                                       value="{{ old('userAnswers.toInfinitive.'.$idx, $userAnswers['toInfinitive'][$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
                                @if($submitted)
                                    @if($results['toInfinitive'][$idx]['score'] == 100)
                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                            ✓ Sempurna!
                                        </div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Nilai: {{ $results['toInfinitive'][$idx]['score'] }}</strong><br>
                                            Koreksi: {!! $results['toInfinitive'][$idx]['formatted_answer'] !!}<br>
                                            <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section 3: Gerund -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">C. Gerund</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <button type="button" onclick="openMeeting6AddModal('gerund')" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            + Add Question
                        </button>
                    @endif
                </div>
                <div class="bg-green-50 border border-green-200 p-4 rounded-lg mb-6">
                    <p class="text-sm text-green-800"><strong>Contoh:</strong> Menciptakan lapangan pekerjaan adalah salah satu tugas utama pemerintah.</p>
                    <p class="text-sm text-green-600 italic">→ Creating job opportunities is one of the government's main tasks.</p>
                </div>
                <div class="space-y-6">
                    @foreach($gerund as $idx => $data)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-green-500 shadow-sm">
                            <div class="flex items-center gap-2 mb-4">
                                <label class="font-bold text-lg text-gray-800">{{ $idx }}. {{ $data['id'] }}</label>
                                
                                <!-- Example Helper -->
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-sm font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                        ?
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed" style="display: none;">
                                        <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                        {{ $data['example']['id'] }}<br>
                                        <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>

                                <!-- Vocabulary Helper -->
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-sm font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                        v
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                        <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                        <ul class="space-y-1">
                                            @foreach($data['vocab'] as $word => $info)
                                                <li class="flex justify-between">
                                                    <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ $info['pos'] }}</span></span>
                                                    <span>{{ $info['id'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>
                            </div>

                            @if(auth()->check() && auth()->user()->isAdmin())
                                <div class="flex justify-end gap-2 mb-2">
                                    <button type="button" 
                                        onclick="openMeeting6EditModal(
                                            {{ $data['db_id'] }}, 
                                            '{{ addslashes($data['id']) }}', 
                                            '{{ addslashes($data['en']) }}', 
                                            'gerund'
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
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[gerund][{{ $idx }}]"
                                       value="{{ old('userAnswers.gerund.'.$idx, $userAnswers['gerund'][$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
                                @if($submitted)
                                    @if($results['gerund'][$idx]['score'] == 100)
                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                            ✓ Sempurna!
                                        </div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Nilai: {{ $results['gerund'][$idx]['score'] }}</strong><br>
                                            Koreksi: {!! $results['gerund'][$idx]['formatted_answer'] !!}<br>
                                            <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section 4: Paragraph Translation -->
            @if(isset($paragraph))
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">D. Paragraph Translation</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="flex gap-2">
                        <button type="button" 
                            onclick="openMeeting6EditModal(
                                {{ $paragraph['db_id'] }}, 
                                '{{ addslashes($paragraph['id']) }}', 
                                '{{ addslashes($paragraph['en']) }}', 
                                'paragraph'
                            )"
                            class="w-10 h-10 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <form action="{{ route('admin.grammar.question.destroy', $paragraph['db_id']) }}" method="POST" onsubmit="return confirm('Hapus paragraf ini?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                <div class="bg-orange-50 border border-orange-200 p-4 rounded-lg mb-6">
                    <p class="text-sm text-orange-800"><strong>Petunjuk:</strong> Translate paragraf berikut ke dalam bahasa Inggris. Perhatikan kata-kata yang di-<strong>bold</strong>.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-orange-500 shadow-sm">
                    <!-- Vocabulary Helper -->
                    <div class="flex items-center gap-2 mb-4">
                        <div x-data="{ open: false }" class="relative inline-block">
                            <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-sm font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                v
                            </button>
                            <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                <ul class="space-y-1">
                                    @foreach($paragraph['vocab'] as $word => $info)
                                        <li class="flex justify-between">
                                            <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ $info['pos'] }}</span></span>
                                            <span>{{ $info['id'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Indonesian Paragraph with Bold Phrases -->
                    <div class="mb-4 p-4 bg-white rounded-lg border border-gray-200">
                        <p class="text-gray-800 leading-relaxed">{!! $paragraph['id'] !!}</p>
                    </div>

                    <!-- Translation Input -->
                    <div class="mb-2">
                        <textarea
                            name="userAnswers[paragraph]"
                            rows="8"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            placeholder="Translate the paragraph to English..."
                            {{ $submitted ? 'readonly' : '' }}
                            autocomplete="off">{{ old('userAnswers.paragraph', $userAnswers['paragraph'] ?? '') }}</textarea>
                        
                        @if($submitted && isset($results['paragraph']))
                            @if($results['paragraph']['score'] == 100)
                                <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                    ✓ Sempurna!
                                </div>
                            @else
                                <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                    <strong>Nilai: {{ $results['paragraph']['score'] }}</strong><br>
                                    Koreksi: {!! $results['paragraph']['formatted_answer'] !!}<br>
                                    <small class="text-gray-600">Jawaban Benar: {{ $paragraph['en'] }}</small>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="mt-8">
                @if(!$submitted)
                    <button type="submit" class="w-full py-4 bg-purple-600 text-white rounded-xl font-bold text-lg hover:bg-purple-700 transition-colors shadow-lg">
                        Cek Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($submitted)
            <form method="POST" action="{{ route('assignments.grammar-writing.meeting6.reset') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>

    <!-- Verb Patterns Floating Button -->
    <div x-data="{ verbPatternsOpen: false }" class="fixed bottom-24 right-8 z-40 flex flex-col gap-3">
        <!-- Verb Patterns Button -->
        <button @click="verbPatternsOpen = true"
                class="bg-sky-400 hover:bg-sky-500 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2">
            Verb Patterns
        </button>

        <!-- Verb Patterns Modal Backdrop -->
        <div x-show="verbPatternsOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
             style="display: none;">
          
            <!-- Modal Content -->
            <div @click.outside="verbPatternsOpen = false"
                 class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[80vh] flex flex-col overflow-hidden">
              
                <!-- Header -->
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-sky-50">
                    <h3 class="text-xl font-bold text-gray-800">Verb Patterns Guide</h3>
                    <button @click="verbPatternsOpen = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Content Container -->
                <div class="overflow-y-auto px-6 pb-6" style="max-height: 60vh;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                        <!-- Verb + Gerund Section -->
                        <div>
                            <h2 class="text-lg font-bold text-white bg-green-500 p-3 rounded-t-lg text-center shadow-md">Verb + Gerund (V-ing)</h2>
                            <div class="border border-green-200 rounded-b-lg overflow-hidden shadow-sm">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-green-50 text-green-800 font-semibold border-b border-green-200">
                                        <tr>
                                            <th class="p-3">Verb</th>
                                            <th class="p-3">Arti</th>
                                            <th class="p-3">Example</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-green-100">
                                        @php
                                            $gerunds = [
                                                ['admit', 'Mengakui', 'She admitted <strong class="text-green-600">stealing</strong> money.'],
                                                ['advise', 'Menyarankan', 'Doctor advised <strong class="text-green-600">resting</strong>.'],
                                                ['allow', 'Mengizinkan', 'Rules don\'t allow <strong class="text-green-600">smoking</strong>.'],
                                                ['anticipate', 'Mengantisipasi', 'We anticipate <strong class="text-green-600">meeting</strong> you.'],
                                                ['appreciate', 'Menghargai', 'I appreciate <strong class="text-green-600">helping</strong> me.'],
                                                ['avoid', 'Menghindari', 'They avoid <strong class="text-green-600">eating</strong> junk.'],
                                                ['consider', 'Mempertimbangkan', 'He considers <strong class="text-green-600">moving</strong>.'],
                                                ['can\'t stand', 'Tidak tahan', 'I can\'t stand <strong class="text-green-600">waiting</strong>.'],
                                                ['celebrate', 'Merayakan', 'They celebrated <strong class="text-green-600">winning</strong>.'],
                                                ['confess', 'Mengaku', 'He confessed <strong class="text-green-600">cheating</strong>.'],
                                                ['delay', 'Menunda', 'Don\'t delay <strong class="text-green-600">starting</strong>.'],
                                                ['deny', 'Menyangkal', 'He denied <strong class="text-green-600">breaking</strong> it.'],
                                                ['discuss', 'Membahas', 'We discussed <strong class="text-green-600">going</strong> there.'],
                                                ['dislike', 'Tidak suka', 'She dislikes <strong class="text-green-600">cooking</strong>.'],
                                                ['enjoy', 'Menikmati', 'I enjoy <strong class="text-green-600">reading</strong>.'],
                                                ['escape', 'Melarikan diri', 'He escaped <strong class="text-green-600">being caught</strong>.'],
                                                ['finish', 'Menyelesaikan', 'She finished <strong class="text-green-600">working</strong>.'],
                                                ['imagine', 'Membayangkan', 'Imagine <strong class="text-green-600">living</strong> there.'],
                                                ['involve', 'Melibatkan', 'Job involves <strong class="text-green-600">travelling</strong>.'],
                                                ['justify', 'Membenarkan', 'Can\'t justify <strong class="text-green-600">spending</strong> more.'],
                                                ['keep', 'Terus/Menjaga', 'Keep <strong class="text-green-600">learning</strong>!'],
                                                ['mention', 'Menyebutkan', 'He mentioned <strong class="text-green-600">helping</strong>.'],
                                                ['mind', 'Keberatan', 'Mind <strong class="text-green-600">opening</strong> the door?'],
                                                ['miss', 'Merindukan', 'I miss <strong class="text-green-600">talking</strong> to you.'],
                                                ['postpone', 'Menunda', 'Postponed <strong class="text-green-600">meeting</strong> us.'],
                                                ['practice', 'Berlatih', 'Practices <strong class="text-green-600">speaking</strong>.'],
                                                ['prevent', 'Mencegah', 'Rain prevented <strong class="text-green-600">playing</strong>.'],
                                                ['quit', 'Berhenti', 'She quit <strong class="text-green-600">smoking</strong>.'],
                                                ['recall', 'Mengingat', 'I don\'t recall <strong class="text-green-600">seeing</strong> him.'],
                                                ['recommend', 'Merekomendasikan', 'Recommend <strong class="text-green-600">studying</strong>.'],
                                                ['resist', 'Menahan diri', 'Can\'t resist <strong class="text-green-600">eating</strong>.'],
                                                ['resume', 'Melanjutkan', 'We resumed <strong class="text-green-600">working</strong>.'],
                                                ['risk', 'Berisiko', 'Risk <strong class="text-green-600">losing</strong> all.'],
                                                ['suggest', 'Menyarankan', 'Suggest <strong class="text-green-600">taking</strong> break.'],
                                                ['tolerate', 'Mentolerir', 'Don\'t tolerate <strong class="text-green-600">cheating</strong>.'],
                                                ['understand', 'Mengerti', 'Understand <strong class="text-green-600">not going</strong>.']
                                            ];
                                        @endphp
                                        @foreach($gerunds as $row)
                                            <tr class="odd:bg-white even:bg-green-50 hover:bg-green-100 transition-colors">
                                                <td class="p-2 font-medium text-gray-800 border-r border-green-100">{{ $row[0] }}</td>
                                                <td class="p-2 text-gray-600 border-r border-green-100">{{ $row[1] }}</td>
                                                <td class="p-2 text-gray-700">{!! $row[2] !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Verb + To-Infinitive Section -->
                        <div>
                            <h2 class="text-lg font-bold text-white bg-blue-500 p-3 rounded-t-lg text-center shadow-md">Verb + To-Infinitive (to + V1)</h2>
                            <div class="border border-blue-200 rounded-b-lg overflow-hidden shadow-sm">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-blue-50 text-blue-800 font-semibold border-b border-blue-200">
                                        <tr>
                                            <th class="p-3">Verb</th>
                                            <th class="p-3">Arti</th>
                                            <th class="p-3">Example</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-blue-100">
                                        @php
                                            $infinitives = [
                                                ['agree', 'Setuju', 'They agreed <strong class="text-blue-600">to cooperate</strong>.'],
                                                ['aim', 'Bertujuan', 'We aim <strong class="text-blue-600">to finish</strong> early.'],
                                                ['allow', 'Mengizinkan', 'Rules allow us <strong class="text-blue-600">to enter</strong>.'],
                                                ['appear', 'Tampak', 'He appears <strong class="text-blue-600">to be</strong> tired.'],
                                                ['arrange', 'Mengatur', 'We arranged <strong class="text-blue-600">to meet</strong>.'],
                                                ['ask', 'Meminta', 'I asked him <strong class="text-blue-600">to stay</strong>.'],
                                                ['attempt', 'Mencoba', 'He attempted <strong class="text-blue-600">to escape</strong>.'],
                                                ['cause', 'Menyebabkan', 'Rain caused us <strong class="text-blue-600">to delay</strong>.'],
                                                ['choose', 'Memilih', 'She chose <strong class="text-blue-600">to stay</strong> home.'],
                                                ['claim', 'Mengklaim', 'He claims <strong class="text-blue-600">to know</strong> her.'],
                                                ['convince', 'Meyakinkan', 'I convinced him <strong class="text-blue-600">to join</strong>.'],
                                                ['decide', 'Memutuskan', 'She decided <strong class="text-blue-600">to leave</strong>.'],
                                                ['deserve', 'Pantas', 'You deserve <strong class="text-blue-600">to win</strong>.'],
                                                ['desire', 'Menginginkan', 'I desire <strong class="text-blue-600">to know</strong> more.'],
                                                ['enable', 'Memungkinkan', 'This enables us <strong class="text-blue-600">to work</strong> faster.'],
                                                ['expect', 'Mengharapkan', 'I expect <strong class="text-blue-600">to receive</strong> it.'],
                                                ['fail', 'Gagal', 'He failed <strong class="text-blue-600">to pass</strong>.'],
                                                ['forget', 'Lupa', 'She forgot <strong class="text-blue-600">to lock</strong> it.'],
                                                ['hope', 'Berharap', 'We hope <strong class="text-blue-600">to win</strong>.'],
                                                ['instruct', 'Menginstruksikan', 'Teacher instructed us <strong class="text-blue-600">to read</strong>.'],
                                                ['intend', 'Berniat', 'I intend <strong class="text-blue-600">to start</strong>.'],
                                                ['know (how)', 'Tahu (cara)', 'I know <strong class="text-blue-600">how to drive</strong>.'],
                                                ['learn', 'Belajar', 'I am learning <strong class="text-blue-600">to drive</strong>.'],
                                                ['learn (how)', 'Belajar (cara)', 'Learn <strong class="text-blue-600">how to swim</strong>.'],
                                                ['manage', 'Berhasil', 'She managed <strong class="text-blue-600">to finish</strong>.'],
                                                ['need', 'Perlu', 'You need <strong class="text-blue-600">to study</strong>.'],
                                                ['offer', 'Menawarkan', 'He offered <strong class="text-blue-600">to help</strong>.'],
                                                ['permit', 'Mengizinkan', 'Law permits us <strong class="text-blue-600">to vote</strong>.'],
                                                ['persuade', 'Membujuk', 'She persuaded me <strong class="text-blue-600">to go</strong>.'],
                                                ['plan', 'Berencana', 'They plan <strong class="text-blue-600">to build</strong> it.'],
                                                ['prepare', 'Bersiap', 'We prepared <strong class="text-blue-600">to leave</strong>.'],
                                                ['pretend', 'Pura-pura', 'He pretended <strong class="text-blue-600">to sleep</strong>.'],
                                                ['promise', 'Berjanji', 'She promised <strong class="text-blue-600">to call</strong>.'],
                                                ['refuse', 'Menolak', 'She refused <strong class="text-blue-600">to answer</strong>.'],
                                                ['require', 'Memerlukan', 'Job requires you <strong class="text-blue-600">to travel</strong>.'],
                                                ['seem', 'Tampaknya', 'They seem <strong class="text-blue-600">to agree</strong>.'],
                                                ['swear', 'Bersumpah', 'He swore <strong class="text-blue-600">to tell</strong> truth.'],
                                                ['teach (how)', 'Mengajar (cara)', 'She taught me <strong class="text-blue-600">how to cook</strong>.'],
                                                ['tell', 'Memberitahu', 'I told him <strong class="text-blue-600">to wait</strong>.'],
                                                ['tend', 'Cenderung', 'Prices tend <strong class="text-blue-600">to rise</strong>.'],
                                                ['use', 'Menggunakan', 'We use tools <strong class="text-blue-600">to build</strong>.'],
                                                ['vote', 'Memilih (voting)', 'They voted <strong class="text-blue-600">to accept</strong> it.'],
                                                ['want', 'Ingin', 'I want <strong class="text-blue-600">to go</strong> home.'],
                                                ['warn', 'Memperingatkan', 'I warned him <strong class="text-blue-600">to be</strong> careful.'],
                                                ['wish', 'Berharap', 'I wish <strong class="text-blue-600">to speak</strong>.'],
                                                ['would like', 'Ingin', 'I would like <strong class="text-blue-600">to order</strong>.']
                                            ];
                                        @endphp
                                        @foreach($infinitives as $row)
                                            <tr class="odd:bg-white even:bg-blue-50 hover:bg-blue-100 transition-colors">
                                                <td class="p-2 font-medium text-gray-800 border-r border-blue-100">{{ $row[0] }}</td>
                                                <td class="p-2 text-gray-600 border-r border-blue-100">{{ $row[1] }}</td>
                                                <td class="p-2 text-gray-700">{!! $row[2] !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Complex Ditransitive Section -->
                    <div class="mt-8">
                        <h2 class="text-lg font-bold text-white bg-purple-500 p-3 rounded-t-lg text-center shadow-md">Complex Ditransitive Verbs</h2>
                        <div class="border border-purple-200 rounded-b-lg overflow-hidden shadow-sm">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-purple-50 text-purple-800 font-semibold border-b border-purple-200">
                                    <tr>
                                        <th class="p-3">Verb</th>
                                        <th class="p-3">Arti</th>
                                        <th class="p-3">Example</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-purple-100">
                                    @php
                                        $complex = [
                                            ['Call', 'Memanggil/Menyebut', 'They called him a liar.'],
                                            ['Consider', 'Menganggap', 'I consider him reliable.'],
                                            ['Elect', 'Memilih (jabatan)', 'We elected her leader.'],
                                            ['Find', 'Menemukan (keadaan)', 'I found the book boring.'],
                                            ['Keep', 'Menjaga (kondisi)', 'Please keep the door closed.'],
                                            ['Make', 'Membuat (menjadi)', 'The news made me sad.'],
                                            ['Name', 'Menamai', 'They named the baby Leo.'],
                                            ['Appoint', 'Menunjuk (jabatan)', 'The committee appointed her chair.'],
                                            ['Declare', 'Menyatakan', 'The judge declared him guilty.'],
                                            ['Paint', 'Mewarnai', 'She painted the wall blue.'],
                                            ['Leave', 'Meninggalkan (kondisi)', 'Don\'t leave the lights on.'],
                                            ['Believe', 'Percaya (menjadi)', 'I believe her innocent.'],
                                        ];
                                    @endphp
                                    @foreach($complex as $row)
                                        <tr class="odd:bg-white even:bg-purple-50 hover:bg-purple-100 transition-colors">
                                            <td class="p-2 font-medium text-gray-800 border-r border-purple-100">{{ $row[0] }}</td>
                                            <td class="p-2 text-gray-600 border-r border-purple-100">{{ $row[1] }}</td>
                                            <td class="p-2 text-gray-700 italic">{{ $row[2] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="p-4 bg-sky-50 border-t border-sky-100 text-center">
                    <p class="text-sm text-gray-700 font-medium">
                        💡 Gunakan tabel ini untuk menentukan apakah verb diikuti oleh Gerund atau To-Infinitive
                    </p>
                </div>
            </div>
        </div>
    </div>

    <x-irregular-verbs-button />

    <!-- Tenses Chart Button -->
    <div x-data="{ openTenses: false }" class="fixed bottom-40 right-8 z-50">
       <!-- Floating Button -->
       <button @click="openTenses = true"
               class="bg-cyan-400 hover:bg-cyan-500 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2">
           Tenses
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

    // Initialize auto-save for meeting 6
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId) {
            AutoSave.init('6', userId);
        }
    });
    </script>

    <!-- Global Dispatch Scripts -->
    <script>
        window.openMeeting6EditModal = function(id, question, answer, section) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m6', { 
                detail: { type: 'edit_question', id, question, answer, section } 
            }));
        };
        window.openMeeting6AddModal = function(section) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m6', { 
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
         @open-edit-modal-m6.window="
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
                
                <input type="hidden" name="meeting_number" value="6">
                <input type="hidden" name="section" x-model="qSection">
                
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Question (Indonesian)</label>
                    <textarea name="question_text" x-model="qText" class="w-full border rounded p-2" rows="3" required></textarea>
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


</body>
</html>