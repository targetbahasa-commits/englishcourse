<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $topic->title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-teal-50 via-cyan-50 to-emerald-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                                {{ $topic->title }}
                            </h1>
                            <p class="text-gray-600 mt-1">{{ $topic->desc ?? 'Latihan untuk materi ini sedang disiapkan.' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.grammar-writing.practice') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </a>
                </div>

                <!-- Tips Section -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded-r-xl shadow-sm">
                    <h3 class="font-bold text-blue-800 text-lg mb-2">💡 Tips Mengerjakan:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-blue-700">
                        <li>Cari semua <span class="font-semibold">Verb</span> dalam kalimat.</li>
                        <li>Tentukan mana <span class="font-semibold">Verb Asli</span> (yang menggunakan tenses).</li>
                        <li>Verb lainnya adalah <span class="font-semibold">Verb Palsu</span>.</li>
                        <li>Gunakan <strong>Vocabulary Helper (v)</strong> jika menemukan kesulitan mencari kata.</li>
                    </ol>
                </div>

                @if($submitted)
                    <div class="bg-teal-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                        <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                        <p class="text-teal-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
                    </div>
                @endif

                @if($sentences->isEmpty() && !$paragraph)
                    <!-- Empty State -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-teal-100 p-12 flex flex-col items-center justify-center min-h-[400px]">
                        <div class="w-24 h-24 bg-teal-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada latihan</h3>
                        <p class="text-gray-500 text-center max-w-md">Latihan untuk topik ini sedang dalam tahap persiapan. Silakan kembali lagi nanti.</p>
                        @if(Auth::user()->isAdmin())
                            <button onclick="openQuestionModal('sentence')" class="mt-6 px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
                                + Tambah Soal
                            </button>
                        @endif
                    </div>
                @else
                    <form method="POST" action="{{ route('assignments.grammar-writing.practice.topic.submit', $topic->id) }}">
                        @csrf
                        
                        <!-- Section 1: Sentences -->
                        @if($sentences->isNotEmpty() || Auth::user()->isAdmin())
                        <div class="mb-12">
                            <div class="flex justify-between items-center mb-6 border-b pb-2">
                                <h3 class="text-2xl font-bold text-gray-800">A. Translate the Sentences</h3>
                                @if(Auth::user()->isAdmin())
                                    <button type="button" onclick="openQuestionModal('sentence')" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                        + Add Question
                                    </button>
                                @endif
                            </div>
                            <div class="space-y-6">
                                @foreach($sentences as $idx => $q)
                                    <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-teal-500 shadow-sm">
                                        <div class="flex items-center gap-2 mb-4">
                                            <label class="font-bold text-lg text-gray-800">{{ $idx + 1 }}. {!! $q->question_id !!}</label>
                                            
                                            <!-- Example Helper -->
                                            @if($q->example)
                                            <div x-data="{ open: false }" class="relative inline-block">
                                                <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-sm font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                    ?
                                                </button>
                                                <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed" style="display: none;">
                                                    <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                    {{ $q->example['id'] ?? '' }}<br>
                                                    <em class="text-gray-300">{{ $q->example['en'] ?? '' }}</em>
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Vocabulary Helper -->
                                            @if($q->vocab_helper)
                                            <div x-data="{ open: false }" class="relative inline-block">
                                                <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-sm font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                                    v
                                                </button>
                                                <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                    <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                    <ul class="space-y-1">
                                                        @foreach($q->vocab_helper as $word => $info)
                                                            <li class="flex justify-between gap-4">
                                                                <span class="text-green-300 font-mono break-all">{{ $word }} <span class="text-gray-400 text-xs">{{ $info['pos'] ?? '' }}</span></span>
                                                                <span class="text-right">{{ is_array($info) ? ($info['id'] ?? '') : $info }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        @if(Auth::user()->isAdmin())
                                            <div class="flex justify-end gap-2 mb-2">
                                                <button type="button" 
                                                    onclick="openQuestionModal('sentence', {{ $q->id }}, '{{ addslashes($q->question_id) }}', '{{ addslashes($q->answer_en) }}', '{{ $q->vocab_helper ? addslashes(json_encode($q->vocab_helper)) : '' }}', '{{ $q->example ? addslashes(json_encode($q->example)) : '' }}')"
                                                    class="w-8 h-8 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                <button type="button" onclick="confirmDeleteQuestion({{ $q->id }})" class="w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        @endif
                                        
                                        <div class="mb-2">
                                            <input type="text"
                                                   name="userAnswers[sentences][{{ $idx }}]"
                                                   value="{{ old('userAnswers.sentences.'.$idx, $userAnswers['sentences'][$idx] ?? '') }}"
                                                   class="w-full p-3 border border-gray-300 rounded-lg focus:border-teal-500 focus:ring-1 focus:ring-teal-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   {{ $submitted ? 'readonly' : '' }}
                                                   autocomplete="off">
                                            
                                            @if($submitted && isset($results['sentences'][$idx]))
                                                @if($results['sentences'][$idx]['score'] == 100)
                                                    <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                                        ✓ Sempurna!
                                                    </div>
                                                @else
                                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                                        <strong>Nilai: {{ $results['sentences'][$idx]['score'] }}</strong><br>
                                                        Koreksi: {!! $results['sentences'][$idx]['formatted_answer'] !!}<br>
                                                        <small class="text-gray-600">Jawaban Benar: {{ $q->answer_en }}</small>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Section 2: Paragraph -->
                        @if($paragraph || Auth::user()->isAdmin())
                        <div class="mb-12">
                            <div class="flex justify-between items-center mb-6 border-b pb-2">
                                <h3 class="text-2xl font-bold text-gray-800">B. Paragraph Translation</h3>
                                @if(Auth::user()->isAdmin())
                                    @if(!$paragraph)
                                    <button type="button" onclick="openQuestionModal('paragraph')" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                        + Add Paragraph
                                    </button>
                                    @else
                                    <div class="flex gap-2">
                                        <button type="button" 
                                            onclick="openQuestionModal('paragraph', {{ $paragraph->id }}, '{{ addslashes($paragraph->question_id) }}', '{{ addslashes($paragraph->answer_en) }}', '{{ $paragraph->vocab_helper ? addslashes(json_encode($paragraph->vocab_helper)) : '' }}')"
                                            class="w-8 h-8 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button type="button" onclick="confirmDeleteQuestion({{ $paragraph->id }})" class="w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                    @endif
                                @endif
                            </div>

                            @if($paragraph)
                            <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-orange-500 shadow-sm">
                                <!-- Vocabulary Helper -->
                                @if($paragraph->vocab_helper)
                                <div class="flex items-center gap-2 mb-4">
                                    <div x-data="{ open: false }" class="relative inline-block">
                                        <button @click="open = !open" type="button" class="w-8 h-8 rounded-lg bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-sm font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                            v
                                        </button>
                                        <div x-show="open" @click.outside="open = false" class="absolute bottom-full left-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                            <ul class="space-y-1">
                                                @foreach($paragraph->vocab_helper as $word => $info)
                                                    <li class="flex justify-between gap-4 border-b border-gray-700 pb-1">
                                                        <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ $info['pos'] ?? '' }}</span></span>
                                                        <span class="text-right">{{ is_array($info) ? ($info['id'] ?? '') : $info }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="absolute top-full left-4 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Indonesian Paragraph -->
                                <div class="mb-4 p-4 bg-white rounded-lg border border-gray-200">
                                    <p class="text-gray-800 leading-relaxed">{!! $paragraph->question_id !!}</p>
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
                                                <small class="text-gray-600">Jawaban Benar: {{ $paragraph->answer_en }}</small>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        <div class="mt-8">
                            @if(!$submitted)
                                <button type="submit" class="w-full py-4 bg-teal-600 text-white rounded-xl font-bold text-lg hover:bg-teal-700 transition-colors shadow-lg">
                                    Cek Jawaban
                                </button>
                            @endif
                        </div>
                    </form>
                    
                    @if($submitted)
                        <form method="POST" action="{{ route('assignments.grammar-writing.practice.topic.reset', $topic->id) }}" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                                Coba Lagi
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </main>
    </div>

    @if(Auth::user()->isAdmin())
    <!-- Question Modal -->
    <div id="questionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 shrink-0">
                <h3 id="questionModalTitle" class="text-xl font-bold text-gray-800">Add Question</h3>
                <button onclick="closeQuestionModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto">
                <form id="questionForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="_method" id="questionMethod" value="POST">
                    <input type="hidden" name="type" id="questionType" value="sentence">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan (Indonesian)</label>
                            <textarea name="question_id" id="questionId" rows="3" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Gunakan tag &lt;strong&gt;teks&lt;/strong&gt; untuk menebalkan kata.</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kunci Jawaban (English)</label>
                            <textarea name="answer_en" id="questionEn" rows="3" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vocabulary Helper (JSON)</label>
                            <textarea name="vocab_helper" id="questionVocab" rows="4" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 font-mono text-sm" placeholder='{"word": {"pos": "v", "id": "arti"}}'></textarea>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada.</p>
                        </div>

                        <div id="exampleField" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Example Helper (JSON)</label>
                            <input type="text" name="example" id="questionExample" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 font-mono text-sm" placeholder='{"id": "contoh", "en": "example"}'>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeQuestionModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="deleteQuestionForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function openQuestionModal(type, id = null, idText = '', enText = '', vocab = '', example = '') {
            const modal = document.getElementById('questionModal');
            const form = document.getElementById('questionForm');
            const method = document.getElementById('questionMethod');
            const title = document.getElementById('questionModalTitle');
            const typeInput = document.getElementById('questionType');
            const exampleField = document.getElementById('exampleField');
            
            document.getElementById('questionId').value = idText;
            document.getElementById('questionEn').value = enText;
            document.getElementById('questionVocab').value = vocab;
            document.getElementById('questionExample').value = example;
            typeInput.value = type;

            if (type === 'sentence') {
                exampleField.classList.remove('hidden');
            } else {
                exampleField.classList.add('hidden');
                document.getElementById('questionExample').value = '';
            }

            if (id) {
                title.textContent = 'Edit Question';
                form.action = `/assignments/grammar-writing/practice/question/${id}`;
                method.value = 'PUT';
            } else {
                title.textContent = `Add ${type === 'sentence' ? 'Question' : 'Paragraph'}`;
                form.action = `{{ route('assignments.grammar-writing.practice.question.store', $topic->id) }}`;
                method.value = 'POST';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeQuestionModal() {
            const modal = document.getElementById('questionModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function confirmDeleteQuestion(id) {
            if (confirm('Yakin ingin menghapus pertanyaan ini?')) {
                const form = document.getElementById('deleteQuestionForm');
                form.action = `/assignments/grammar-writing/practice/question/${id}`;
                form.submit();
            }
        }
    </script>
    @endif

    @include('components.student-broadcaster')
</body>
</html>
