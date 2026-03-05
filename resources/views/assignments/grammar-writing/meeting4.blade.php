<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 4</title>
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
            <a href="{{ route('assignments.grammar-writing') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium">
                &laquo; Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">Latihan Modal & Translation (Pertemuan 4)</h1>
        <p class="text-center text-gray-600 mb-8">Translate kalimat berikut ke dalam bahasa Inggris.</p>

        <!-- Modal Summary Chart -->
        <div class="mb-12">
            <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">Summary Chart of Modals and Phrasal Modals</h3>

            <!-- PURE MODALS -->
            <h5 class="text-lg font-bold text-blue-600 mb-4 flex items-center gap-2">
                <span class="bg-blue-100 text-blue-600 w-8 h-8 flex items-center justify-center rounded-full text-sm">1</span>
                Pure Modals (Modal Dasar)
            </h5>
            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse bg-white">
                        <thead>
                            <tr class="bg-gray-800 text-white text-sm uppercase tracking-wider">
                                <th class="p-4 font-semibold border-b border-gray-700 whitespace-nowrap">Modal</th>
                                <th class="p-4 font-semibold border-b border-gray-700 min-w-[200px]">Meaning (English)</th>
                                <th class="p-4 font-semibold border-b border-gray-700 min-w-[200px]">Makna (Indonesia)</th>
                                <th class="p-4 font-semibold border-b border-gray-700 min-w-[200px]">Example</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">can</td>
                                <td class="p-4">ability, possibility, permission</td>
                                <td class="p-4">bisa; kemungkinan; izin</td>
                                <td class="p-4 italic text-gray-600">She can swim.</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">could</td>
                                <td class="p-4">past ability, polite request, possibility</td>
                                <td class="p-4">bisa (dulu); permintaan sopan; kemungkinan</td>
                                <td class="p-4 italic text-gray-600">Could you help me?</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">may</td>
                                <td class="p-4">permission, possibility</td>
                                <td class="p-4">boleh; kemungkinan</td>
                                <td class="p-4 italic text-gray-600">You may leave.</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">might</td>
                                <td class="p-4">weaker possibility</td>
                                <td class="p-4">mungkin (lebih lemah)</td>
                                <td class="p-4 italic text-gray-600">It might rain.</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">will</td>
                                <td class="p-4">future, willingness</td>
                                <td class="p-4">akan; kesediaan</td>
                                <td class="p-4 italic text-gray-600">I will call you.</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">would</td>
                                <td class="p-4">polite request, unreal situations</td>
                                <td class="p-4">akan (lebih sopan); situasi tidak nyata</td>
                                <td class="p-4 italic text-gray-600">I would go if I had time.</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">shall</td>
                                <td class="p-4">suggestion, future (BrE)</td>
                                <td class="p-4">sebaiknya; akan (BrE)</td>
                                <td class="p-4 italic text-gray-600">Shall we start?</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">should</td>
                                <td class="p-4">advice, recommendation</td>
                                <td class="p-4">sebaiknya; saran</td>
                                <td class="p-4 italic text-gray-600">You should rest.</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">must</td>
                                <td class="p-4">strong necessity</td>
                                <td class="p-4">harus; keharusan kuat</td>
                                <td class="p-4 italic text-gray-600">You must wear a helmet.</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">ought to</td>
                                <td class="p-4">advice, moral duty</td>
                                <td class="p-4">seharusnya (secara moral)</td>
                                <td class="p-4 italic text-gray-600">You ought to be careful.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PHRASAL MODALS -->
            <h5 class="text-lg font-bold text-blue-600 mb-4 flex items-center gap-2">
                <span class="bg-blue-100 text-blue-600 w-8 h-8 flex items-center justify-center rounded-full text-sm">2</span>
                Phrasal Modals (Modal Frasa)
            </h5>
            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse bg-white">
                        <thead>
                            <tr class="bg-gray-800 text-white text-sm uppercase tracking-wider">
                                <th class="p-4 font-semibold border-b border-gray-700 whitespace-nowrap">Phrasal Modal</th>
                                <th class="p-4 font-semibold border-b border-gray-700 min-w-[200px]">Meaning (English)</th>
                                <th class="p-4 font-semibold border-b border-gray-700 min-w-[200px]">Makna (Indonesia)</th>
                                <th class="p-4 font-semibold border-b border-gray-700 min-w-[200px]">Example</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">be able to</td>
                                <td class="p-4">ability (all tenses)</td>
                                <td class="p-4">dapat; mampu</td>
                                <td class="p-4 italic text-gray-600">I will be able to finish it.</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">be going to</td>
                                <td class="p-4">future plan/intention</td>
                                <td class="p-4">akan; rencana</td>
                                <td class="p-4 italic text-gray-600">She is going to travel.</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">have to</td>
                                <td class="p-4">necessity, external obligation</td>
                                <td class="p-4">harus (keharusan dari luar)</td>
                                <td class="p-4 italic text-gray-600">I have to work tomorrow.</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">have got to</td>
                                <td class="p-4">strong necessity (informal)</td>
                                <td class="p-4">harus banget; terpaksa</td>
                                <td class="p-4 italic text-gray-600">I've got to go now.</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">be supposed to</td>
                                <td class="p-4">expectation, rule</td>
                                <td class="p-4">seharusnya; sesuai aturan</td>
                                <td class="p-4 italic text-gray-600">Students are supposed to attend.</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">be allowed to</td>
                                <td class="p-4">permission</td>
                                <td class="p-4">diizinkan</td>
                                <td class="p-4 italic text-gray-600">They are allowed to enter.</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">be required to</td>
                                <td class="p-4">official requirement</td>
                                <td class="p-4">diwajibkan</td>
                                <td class="p-4 italic text-gray-600">Staff are required to sign in.</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">be going to have to</td>
                                <td class="p-4">future necessity</td>
                                <td class="p-4">akan harus</td>
                                <td class="p-4 italic text-gray-600">You're going to have to study harder.</td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="p-4 font-bold text-gray-900">used to</td>
                                <td class="p-4">past habits/states</td>
                                <td class="p-4">dulu biasa; dulu sering</td>
                                <td class="p-4 italic text-gray-600">I used to live there.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tips Box -->
        <div class="bg-blue-50 border border-blue-100 text-blue-900 p-6 rounded-xl mb-8">
            <strong class="block mb-2 text-lg">Tips menentukan tenses:</strong>
            <ol class="list-decimal list-inside space-y-1 ml-2">
                <li>Tentukan apakah kalimatnya verbal (awalan me-, ber-, tanpa awalan), nominal(awalan di-,ter-), atau passive(di-, ter-)dahulu.</li>
                <li>Kemudian tentukan modalnya (harus[must], seharusnya[should], mungkin[may, might, could], bisa/mampu[can]).</li>
                <li>Kemudian tentukan waktunya apakah present, past, atau future -> jika tidak ada waktu maka anggap saja present</li>
            </ol>
            <em class="block mt-4 text-sm text-blue-700">Catatan: adalah, merupakan, ada, berupa, berada, yaitu = nominal</em>
        </div>

        <!-- Aturan Modal Box -->
        <div class="bg-yellow-50 border border-yellow-100 text-yellow-900 p-6 rounded-xl mb-8">
            <strong class="block mb-2 text-lg">Aturan Modal:</strong>
            <ol class="list-decimal list-inside space-y-1 ml-2">
                <li>Modal diikuti oleh Bare Infinitive (V1)</li>
                <li>Modal tidak boleh diikuti oleh modal lainnya (gunakan Phrasal Modal di modal ke-dua)</li>
            </ol>
        </div>

        @if($submitted)
            <div class="bg-blue-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-blue-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        @if(auth()->check() && auth()->user()->isAdmin())
            <div class="mb-8 p-6 bg-white border border-blue-200 rounded-xl shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Admin: Add New Question</h3>
                <form action="{{ route('admin.grammar.question.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="meeting_number" value="4">
                    <input type="hidden" name="section" value="sentences">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Question Text (ID)</label>
                            <input type="text" name="question_text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correct Answer (EN)</label>
                            <input type="text" name="correct_answer" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Question Number</label>
                            <input type="number" name="question_number" value="{{ count($questions) + 1 }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Add Question</button>
                </form>
            </div>
        @endif

        <form method="POST" action="{{ route('assignments.grammar-writing.meeting4.submit') }}">
            @csrf
            <div class="space-y-6">

                @foreach($questions as $idx => $data)
                     <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-blue-500 shadow-sm relative group">
                         @if(auth()->check() && auth()->user()->isAdmin())
                            <div class="absolute top-4 right-4 flex space-x-2 z-10">
                                <button type="button" 
                                        onclick="openMeeting4EditModal(
                                            '{{ $data['original_id'] ?? 0 }}', 
                                            {{ \Illuminate\Support\Js::from($data['id']) }}, 
                                            {{ \Illuminate\Support\Js::from($data['en']) }}
                                        )"
                                        class="p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 cursor-pointer relative z-20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('admin.grammar.question.destroy', $data['original_id'] ?? 0) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 cursor-pointer relative z-20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        @endif

                        <label class="block font-bold text-lg text-gray-800 mb-4">{{ $idx }}. {{ $data['id'] }}</label>
                       
                        <!-- Translation Input -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Terjemahan:</label>
                            <input type="text"
                                   name="userAnswers[{{ $idx }}][trans]"
                                   value="{{ old('userAnswers.'.$idx.'.trans', $userAnswers[$idx]['trans'] ?? '') }}"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                   placeholder="Translate to English..."
                                   {{ $submitted ? 'readonly' : '' }}
                                   autocomplete="off">
                           
                            @if($submitted)
                                @if($results[$idx]['trans_score'] == 10)
                                    <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                        ✓ Terjemahan Sempurna! (10/10)
                                    </div>
                                @else
                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                        <strong>Nilai Terjemahan: {{ $results[$idx]['trans_score'] }}/10</strong><br>
                                        Koreksi: {!! $results[$idx]['formatted_answer'] !!}<br>
                                        <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Vocab Box -->
                        @if(isset($data['vocab']) && !empty($data['vocab']))
                            <div class="mt-4 bg-yellow-50 border border-yellow-100 p-3 rounded-lg">
                                <strong class="text-yellow-800 text-sm block mb-2">Kosa Kata:</strong>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($data['vocab'] as $id => $en)
                                        <span class="bg-white px-2 py-1 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                            <strong>{{ $id }}</strong>: {{ $en }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-12 space-y-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Latihan Paragraf</h3>
               
                <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-green-500 shadow-sm">
                    <div class="mb-4 relative group">
                        <div class="flex justify-between items-center mb-2">
                            <strong class="block text-lg text-gray-800">Terjemahkan paragraf berikut ke dalam Bahasa Inggris:</strong>
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <button type="button" 
                                        onclick="openMeeting4EditModal(
                                            '{{ $paragraphId ?? 0 }}', 
                                            {{ \Illuminate\Support\Js::from($fullParagraphId ?? '') }}, 
                                            {{ \Illuminate\Support\Js::from($fullParagraphEn ?? '') }}
                                        )"
                                        class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 text-sm font-medium cursor-pointer relative z-20">
                                    Edit Paragraph
                                </button>
                            @endif
                        </div>
                        <p class="text-gray-700 leading-relaxed p-4 bg-white rounded border border-gray-200">
                            {{ $fullParagraphId }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                        <textarea
                            name="userParagraphAnswer"
                            rows="6"
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

                    <!-- Vocab Summary -->
                    <div class="mt-6 bg-yellow-50 border border-yellow-100 p-4 rounded-lg">
                        <strong class="text-yellow-800 text-sm block mb-2">Kosa Kata Bantuan:</strong>
                        <div class="flex flex-wrap gap-2">
                            @forelse($paragraphVocab ?? [] as $en => $vocabData)
                                <span class="bg-white px-2 py-1 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                    <strong>{{ $en }}</strong> <span class="text-gray-500 text-xs">{{ $vocabData['pos'] ?? '' }}</span>: {{ $vocabData['id'] ?? '' }}
                                </span>
                            @empty
                                <p class="text-sm text-gray-500">Tidak ada kosa kata</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                @if(!$submitted)
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition-colors shadow-lg">
                        Cek Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($submitted)
            <form method="POST" action="{{ route('assignments.grammar-writing.meeting4.reset') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Coba Lagi
                </button>
            </form>
        @endif
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
    
    <x-irregular-verbs-button />
    
    <!-- Edit Question Modal -->
    <div x-data="{ open: false, id: '', question: '', answer: '' }"
         @open-edit-modal.window="open = true; id = $event.detail.id; question = $event.detail.question; answer = $event.detail.answer"
         x-show="open"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" x-transition
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form :action="`{{ route('admin.grammar.question.update', '0') }}`.slice(0, -1) + id" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Edit Item</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Question / Text (ID)</label>
                                <textarea name="question_text" x-model="question" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Answer / Translation (EN)</label>
                                <textarea name="correct_answer" x-model="answer" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save Changes
                        </button>
                        <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Auto-Save Script -->

    <!-- Global helper for opening edit modal to avoid inline JSON escaping issues -->
    <script>
        window.openMeeting4EditModal = function(id, question, answer, tense = '') {
            // Dispatch event to window so Alpine component can catch it
            window.dispatchEvent(new CustomEvent('open-edit-modal', {
                detail: {
                    id: id,
                    question: question,
                    answer: answer,
                    tense: tense
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
            const form = document.querySelector('form[method="POST"]');
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

            const form = document.querySelector('form[method="POST"]');
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

    // Initialize auto-save for meeting 4
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId) {
            AutoSave.init('4', userId);
        }
    });
    </script>


</body>
</html>