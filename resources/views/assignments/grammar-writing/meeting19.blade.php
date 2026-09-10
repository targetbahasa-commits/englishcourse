<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 19</title>
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
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <x-grammar-meeting-actions :meetingNumber="19" track="fast-track" />

        <h1 class="text-3xl font-bold text-center text-purple-600 mb-8">Adverbs (Pertemuan 19)</h1>
        
        @if($submitted)
            <div class="bg-purple-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-purple-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting19.submit'), PHP_URL_PATH) }}" id="meetingAnswerForm">
            @csrf
            
            <!-- Individual Questions -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">A. Translate Kalimat dengan Adverbs</h3>
                
                @if(Auth::guard('web')->check() && Auth::guard('web')->user()->isAdmin())
                <div class="mb-4" x-data>
                    <button type="button" @click="$dispatch('open-add-modal')" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150 ease-in-out flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Soal
                    </button>
                </div>
                @endif
                
                <div class="space-y-6">
                @foreach($questions as $idx => $q)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border-l-4 border-purple-500" x-data="{ open: false }">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2 flex-1">
                                <p class="text-sm font-medium text-gray-700">{{ $idx }}. {{ $q['id'] }}</p>
                                
                                <!-- Admin Actions -->
                                @if(Auth::guard('web')->check() && Auth::guard('web')->user()->isAdmin())
                                    <div class="flex gap-1 ml-2">
                                        <button type="button" onclick="openEditModal(this)" 
                                            data-payload="{{ json_encode(array_merge($q, ['question_number' => $idx])) }}"
                                            class="text-yellow-600 hover:text-yellow-700 bg-yellow-100 hover:bg-yellow-200 p-1 rounded transition-colors" 
                                            title="Edit Soal">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button type="button" onclick="confirmDelete('{{ $q['db_id'] ?? '' }}', 'question')" 
                                            class="text-red-600 hover:text-red-700 bg-red-100 hover:bg-red-200 p-1 rounded transition-colors" 
                                            title="Hapus Soal">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif

                                <!-- Example Helper (?) -->
                                <div x-data="{ openExample: false }" class="relative inline-block ml-2">
                                    <button type="button" @click="openExample = !openExample" @click.outside="openExample = false" class="text-yellow-600 hover:text-yellow-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-yellow-50 px-2 py-0.5 rounded border border-yellow-100 w-6 h-6 flex items-center justify-center">
                                        ?
                                    </button>
                                    <div x-show="openExample"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 translate-y-2"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 translate-y-2"
                                         style="display: none;"
                                         class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                        <strong class="block mb-1 text-yellow-300">Contoh ({{ $q['adverb'] ?? 'Adverb' }}):</strong>
                                        {{ $q['example']['id'] }}<br>
                                        <em class="text-gray-300">{{ $q['example']['en'] }}</em>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>

                                <!-- Vocabulary Helper (v) -->
                                <div x-data="{ openVocab: false }" class="relative inline-block ml-1">
                                    <button type="button" @click="openVocab = !openVocab" @click.outside="openVocab = false" class="text-green-600 hover:text-green-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-green-50 px-2 py-0.5 rounded border border-green-100 w-6 h-6 flex items-center justify-center">
                                        v
                                    </button>
                                    <div x-show="openVocab"
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
                                            @foreach($q['vocab'] as $en => $vocabData)
                                                @if(str_starts_with($en, '_')) @continue @endif
                                                <li class="flex justify-between">
                                                    @if(is_array($vocabData))
                                                        <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ $vocabData['pos'] }}</span></span>
                                                        <span>{{ $vocabData['id'] }}</span>
                                                    @else
                                                        <span class="text-green-300 font-mono">{{ $en }}</span>
                                                        <span>{{ $vocabData }}</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($q['type']))
                                <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded ml-2 whitespace-nowrap">{{ $q['type'] }}</span>
                            @endif
                        </div>
                        
                        <input 
                            type="text" 
                            name="userAnswers[{{ $idx }}]" 
                            value="{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}"
                            class="w-full p-2 border border-gray-300 rounded focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            placeholder="Tulis terjemahan di sini..."
                            @if($submitted) readonly="readonly" @endif
                            autocomplete="off">
                        
                        @if($submitted && isset($results[$idx]))
                            <div class="mt-2">
                                @if($results[$idx]['score'] >= 8)
                                    <p class="text-xs font-bold text-green-600">✓ Benar ({{ $results[$idx]['score'] }}/10)</p>
                                @else
                                    <p class="text-xs font-bold text-red-600">Skor: {{ $results[$idx]['score'] }}/10</p>
                                @endif
                                <div class="text-xs mt-1">
                                    <span class="text-gray-600">Analisis:</span>
                                    <div class="mt-1">{!! $results[$idx]['formatted_answer'] !!}</div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1"><strong>Jawaban:</strong> {{ $results[$idx]['correct_answer'] }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
                </div>
            </div>

            <!-- Paragraph Translation -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">B. Translate Paragraf</h3>
                
                <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-purple-500 shadow-sm">
                    @if(Auth::guard('web')->check() && Auth::guard('web')->user()->isAdmin())
                        <div class="flex justify-end mb-4 gap-2">
                             @if(empty($fullParagraphId))
                                <button type="button" @click="$dispatch('open-add-paragraph-modal')" class="bg-green-500 hover:bg-green-600 text-white text-sm font-bold py-1 px-3 rounded shadow-md transition duration-150 ease-in-out">
                                    + Tambah Paragraf
                                </button>
                            @else
                                <button type="button" onclick="openParagraphEditModal('{{ $fullParagraphId }}', '{{ $fullParagraphEn }}', '{{ $paragraphDbId }}', {{ json_encode($paragraphVocab) }})" 
                                    class="text-yellow-600 hover:text-yellow-700 bg-yellow-100 hover:bg-yellow-200 p-1.5 rounded-md transition-colors" 
                                    title="Edit Paragraf">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" onclick="confirmDelete('{{ $paragraphDbId }}', 'paragraph')" 
                                    class="text-red-600 hover:text-red-700 bg-red-100 hover:bg-red-200 p-1.5 rounded-md transition-colors" 
                                    title="Hapus Paragraf">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    @endif

                    <div class="mb-4">
                        <strong class="block text-lg text-gray-800 mb-2">Terjemahkan paragraf berikut ke dalam Bahasa Inggris:</strong>
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
                                @if(is_array($paragraphVocab))
                                    @foreach($paragraphVocab as $en => $id)
                                        @if(str_starts_with($en, '_')) @continue @endif
                                        <span class="bg-white px-3 py-1.5 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                            <strong class="text-purple-600">{{ $en }}</strong>: 
                                            @if(is_array($id))
                                                {{ $id['id'] }}
                                            @else
                                                {{ $id }}
                                            @endif
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                        <textarea
                            name="userParagraphAnswer"
                            rows="10"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-1 focus:ring-purple-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            placeholder="Tulis terjemahan paragraf di sini..."
                            @if($submitted) readonly="readonly" @endif>{{ old('userParagraphAnswer', $userParagraphAnswer) }}</textarea>
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
                    <button type="submit" class="w-full py-4 bg-purple-600 text-white rounded-xl font-bold text-lg hover:bg-purple-700 transition-colors shadow-lg">
                        Cek Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($submitted)
            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting19.reset'), PHP_URL_PATH) }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>

    <!-- Admin Modals -->
    @if(Auth::guard('web')->check() && Auth::guard('web')->user()->isAdmin())
    
    <!-- Add Question Modal -->
    <div x-data="{ open: false }" @open-add-modal.window="open = true" class="relative z-50">
        <div x-show="open" class="fixed inset-0 bg-black/50" aria-hidden="true" style="display: none;"></div>
        <div x-show="open" @click.outside="open = false" class="fixed inset-0 flex items-center justify-center p-4" style="display: none;">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-xl font-bold">Tambah Soal Baru</h3>
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <form action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="meeting_number" value="19">
                    
                    <div>
                        <label class="block font-bold mb-1">Nomor Soal</label>
                        <input type="number" name="question_number" class="w-full border p-2 rounded" required>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Soal (Indonesian)</label>
                        <input type="text" name="question_text" class="w-full border p-2 rounded" required>
                    </div>
                    
                    <div>
                        <label class="block font-bold mb-1">Jawaban (English)</label>
                        <input type="text" name="correct_answer" class="w-full border p-2 rounded" required>
                    </div>

                    <!-- Example Section -->
                    <div class="border p-3 rounded bg-gray-50">
                        <h4 class="font-bold mb-2 text-sm text-gray-700">Contoh / Example</h4>
                        <div class="space-y-2">
                            <input type="text" name="example_id" placeholder="Contoh Indo" class="w-full border p-2 rounded text-sm">
                            <input type="text" name="example_en" placeholder="Example English" class="w-full border p-2 rounded text-sm">
                        </div>
                    </div>

                    <!-- Vocab Section -->
                    <div>
                        <label class="block font-bold mb-1">Vocabulary (Format: Key=Translation|POS)</label>
                        <small class="text-gray-500 block mb-2">Ex: Create=Membuat|(v), Art=Seni|(n)</small>
                        <textarea name="vocab_string" rows="3" class="w-full border p-2 rounded" placeholder="Create=Membuat|(v)"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="open = false" class="px-4 py-2 text-gray-600">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Question Modal -->
    <div id="edit-question-modal" x-data="{ open: false, data: {} }" @open-edit-modal.window="open = true; data = $event.detail" class="relative z-50">
        <div x-show="open" class="fixed inset-0 bg-black/50" aria-hidden="true" style="display: none;"></div>
        <div x-show="open" @click.outside="open = false" class="fixed inset-0 flex items-center justify-center p-4" style="display: none;">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-xl font-bold">Edit Soal <span x-text="data.question_number"></span></h3>
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <form :action="'/admin/assignments/grammar-writing/questions/' + data.db_id" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block font-bold mb-1">Soal (Indonesian)</label>
                        <input type="text" name="question_text" x-model="data.id" class="w-full border p-2 rounded" required>
                    </div>
                    
                    <div>
                        <label class="block font-bold mb-1">Jawaban (English)</label>
                        <input type="text" name="correct_answer" x-model="data.en" class="w-full border p-2 rounded" required>
                    </div>

                    <!-- Example Section -->
                    <div class="border p-3 rounded bg-gray-50">
                        <h4 class="font-bold mb-2 text-sm text-gray-700">Contoh / Example</h4>
                        <div class="space-y-2">
                            <input type="text" name="example_id" x-model="data.example ? data.example.id : ''" placeholder="Contoh Indo" class="w-full border p-2 rounded text-sm">
                            <input type="text" name="example_en" x-model="data.example ? data.example.en : ''" placeholder="Example English" class="w-full border p-2 rounded text-sm">
                        </div>
                    </div>

                    <!-- Vocab String -->
                    <div>
                        <label class="block font-bold mb-1">Vocabulary (Update via Text)</label>
                        <textarea name="vocab_string" rows="3" class="w-full border p-2 rounded"></textarea>
                        <small class="text-gray-500">Format: Key=Translation|POS. Use _type=Type for metadata.</small>
                    </div>

                    <div class="flex justify-end gap-2 mt-4 pt-4 border-t">
                        <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors shadow-sm font-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Paragraph Modal -->
    <div x-data="{ open: false }" @open-add-paragraph-modal.window="open = true" class="relative z-50">
        <div x-show="open" class="fixed inset-0 bg-black/50" aria-hidden="true" style="display: none;"></div>
        <div x-show="open" @click.outside="open = false" class="fixed inset-0 flex items-center justify-center p-4" style="display: none;">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-xl font-bold">Tambah Paragraf</h3>
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <form action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="meeting_number" value="19">
                    <input type="hidden" name="section" value="paragraph">
                    <input type="hidden" name="question_number" value="100">
                    <input type="hidden" name="question_type" value="paragraph">

                    <div>
                        <label class="block font-bold mb-1">Paragraf (Indonesian)</label>
                        <textarea name="question_text" rows="4" class="w-full border p-2 rounded" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block font-bold mb-1">Jawaban (English)</label>
                        <textarea name="correct_answer" rows="4" class="w-full border p-2 rounded" required></textarea>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Vocabulary (Format: Key=Translation|POS)</label>
                        <textarea name="vocab_string" rows="3" class="w-full border p-2 rounded"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="open = false" class="px-4 py-2 text-gray-600">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Paragraph Modal -->
    <div x-data="{ open: false, id: '', en: '', db_id: '', vocab: '' }" 
         @open-edit-paragraph-modal.window="open = true; id = $event.detail.id; en = $event.detail.en; db_id = $event.detail.db_id; vocab = $event.detail.vocab" 
         class="relative z-50">
        <div x-show="open" class="fixed inset-0 bg-black/50" aria-hidden="true" style="display: none;"></div>
        <div x-show="open" @click.outside="open = false" class="fixed inset-0 flex items-center justify-center p-4" style="display: none;">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-xl font-bold">Edit Paragraf</h3>
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <form :action="'/admin/assignments/grammar-writing/questions/' + db_id" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block font-bold mb-1">Paragraf (Indonesian)</label>
                        <textarea name="question_text" x-model="id" rows="4" class="w-full border p-2 rounded" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block font-bold mb-1">Jawaban (English)</label>
                        <textarea name="correct_answer" x-model="en" rows="4" class="w-full border p-2 rounded" required></textarea>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Vocabulary</label>
                        <textarea name="vocab_string" x-model="vocab" rows="3" class="w-full border p-2 rounded"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 mt-4 pt-4 border-t">
                        <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors shadow-sm font-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Expose functions to global window object
        window.openEditModal = function(el) {
            try {
                const data = JSON.parse(el.dataset.payload);
                const vocab = formatVocab(data.vocab);
                
                // Set value for textarea manually since x-model might not catch payload update immediately if complex
                const modal = document.getElementById('edit-question-modal');
                if(modal) {
                    const textarea = modal.querySelector('textarea[name="vocab_string"]');
                    if(textarea) textarea.value = vocab;
                }

                window.dispatchEvent(new CustomEvent('open-edit-modal', { detail: data }));
            } catch (e) {
                console.error('Error opening edit modal:', e);
                alert('Gagal membuka modal edit. Silakan coba lagi.');
            }
        };

        window.openParagraphEditModal = function(id, en, db_id, vocabObj) {
            try {
                const vocab = formatVocab(vocabObj);
                window.dispatchEvent(new CustomEvent('open-edit-paragraph-modal', { 
                    detail: { id, en, db_id, vocab } 
                }));
            } catch(e) {
                console.error('Error opening paragraph edit modal:', e);
            }
        };

        window.formatVocab = function(vocabObj) {
            if (!vocabObj) return '';
            if (typeof vocabObj === 'string') return vocabObj;
            
            return Object.entries(vocabObj).map(([key, val]) => {
                // Handle different vocab structures (simple vs complex)
                if (typeof val === 'string') return `${key}=${val}`;
                // Handle complex object
                if (val && typeof val === 'object' && val.id) {
                     return `${key}=${val.id}|${val.pos}`;
                }
                return `${key}=${JSON.stringify(val)}`;
            }).join('\n');
        };

        window.confirmDelete = function(id, type) {
            if (!confirm(`Apakah Anda yakin ingin menghapus ${type} ini?`)) return;
            
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/assignments/grammar-writing/questions/${id}`;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        };
    </script>
    @endif

    <!-- INLINE AUTO-SAVE SCRIPT -->
    <script>
    const AutoSave = {
        debounceTimer: null,
        debounceDelay: 500,
        userId: null,
        draftSyncTimer: null,

        init(meetingNumber, userId = null) {
            this.meetingNumber = meetingNumber;
            this.userId = userId || window.userId || 'guest';
            this.storageKey = `grammar_writing_meeting${meetingNumber}_user_${this.userId}`;

            this.isSubmitted = this.checkIfSubmitted();

            if (this.isSubmitted) {
                this.clearSaved();
                return;
            }

            this.restoreAnswers();
            this.setupAutoSave();
        },

        checkIfSubmitted() {
            const isReadonly = document.querySelector('#meetingAnswerForm input[type="text"][readonly]');
            return !!isReadonly;
        },

        setupAutoSave() {
            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');

            inputs.forEach(input => {
                if (input.readOnly || input.disabled) {
                    return;
                }

                input.addEventListener('input', () => {
                    this.saveAnswers();
                });

                input.addEventListener('blur', () => {
                    this.saveAnswers();
                });

                input.addEventListener('keyup', () => {
                    this.saveAnswers();
                });
            });
        },

        saveAnswers() {
            if (this.isSubmitted) {
                return;
            }

            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
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
                this.queueDraftSync(form);
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
            const match = action.match(/\/assignments\/grammar-writing\/fast-track\/meeting(\d+)/);
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

        restoreAnswers() {
            try {
                const savedData = localStorage.getItem(this.storageKey);

                if (!savedData) {
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
                    this.showRestoreIndicator(restoredCount);
                }
            } catch (e) {
                console.error('Failed to restore from localStorage:', e);
            }
        },

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

        showSaveIndicator() {
            let indicator = document.getElementById('auto-save-indicator');

            if (!indicator) {
                indicator = document.createElement('div');
                indicator.id = 'auto-save-indicator';
                indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                indicator.style.transition = 'opacity 0.3s';
                indicator.innerHTML = '✓ Tersimpan otomatis';
                document.body.appendChild(indicator);
            }

            indicator.style.opacity = '1';
            indicator.style.backgroundColor = '#10b981';

            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            indicator.innerHTML = `✓ Tersimpan ${timeStr}`;

            clearTimeout(this.saveIndicatorTimeout);
            this.saveIndicatorTimeout = setTimeout(() => {
                indicator.style.opacity = '0.7';
            }, 3000);
        },

        clearSaved() {
            try {
                localStorage.removeItem(this.storageKey);
            } catch (e) {
                console.error('Failed to clear localStorage:', e);
            }
        }
    };

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
        const form = document.getElementById('meetingAnswerForm');
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


    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('19', userId);
        }
    });
    </script>

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