<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Listening Practice Paket {{ $package }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
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
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-2v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-transparent">Listening Practice - Paket {{ $package }}</h1>
                            <p class="text-gray-600 mt-1">Diagnostic Pre-Test (Section 1 Listening Comprehension)</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.toefl-itp.listening.practice') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Section 1 Directions -->
                <section class="bg-white rounded-2xl border border-blue-200 shadow-sm p-6">
                    <h2 class="text-xl font-bold text-blue-700 mb-2">SECTION 1<br>LISTENING COMPREHENSION</h2>
                    <p class="text-sm text-gray-700 mb-2">Time—approximately 35 minutes<br><span class="italic">(including the reading of the directions for each part)</span></p>
                    <div class="mb-4 text-gray-800 text-sm leading-relaxed">
                        In this section of the test, you will have an opportunity to demonstrate your ability to understand conversations and talks in English. There are three parts to this section. Answer all the questions on the basis of what is <b>stated or implied</b> by the speakers you hear. <b>Do not</b> take notes or write in your test book at any time. <b>Do not</b> turn the pages until you are told to do so.
                    </div>
                </section>

                <!-- Part A Directions & Questions -->
                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-2xl font-bold text-blue-800 mb-2">Part A</h2>
                    <div class="mb-4 text-gray-800 text-sm leading-relaxed">
                        <b><u>Directions:</u></b> In Part A you will hear short conversations between two people. After each conversation, you will hear a question about the conversation. The conversations and questions will not be repeated.<br>
                        After you hear a question, read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Questions 1-30. Short conversations between two speakers.</p>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        @foreach($partAQuestions as $question)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <p class="font-bold text-gray-900 mb-3">{{ $question->question_number }}. {{ $question->question_text }}</p>
                                <div class="space-y-2 text-sm text-gray-700">
                                    <div>(A) {{ $question->option_a }}</div>
                                    <div>(B) {{ $question->option_b }}</div>
                                    <div>(C) {{ $question->option_c }}</div>
                                    <div>(D) {{ $question->option_d }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-end mt-8">
                        <button type="button" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition-colors duration-200" style="font-size:1.25rem;" id="lanjut-ke-structure-btn">
                            Lanjut ke Structure
                        </button>
                    </div>
                </section>

                <!-- Part B Directions & Questions -->
                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-2xl font-bold text-purple-800 mb-2">Part B</h2>
                    <p class="text-sm text-gray-600 mb-4">Questions 31-38. Longer conversations.</p>
                    <div class="mb-4 text-gray-800 text-sm leading-relaxed">
                        <b><u>Directions:</u></b> In this part of the test, you will hear longer conversations. After each conversation, you will hear several questions. The conversations and questions will not be repeated.<br><br>
                        After you hear a question, read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.<br><br>
                        Remember, you are <b><u>not</u></b> allowed to take notes or write in your test book.
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        @foreach($partBQuestions as $question)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <p class="font-bold text-gray-900 mb-3">{{ $question->question_number }}. {{ $question->question_text }}</p>
                                <div class="space-y-2 text-sm text-gray-700">
                                    <div>(A) {{ $question->option_a }}</div>
                                    <div>(B) {{ $question->option_b }}</div>
                                    <div>(C) {{ $question->option_c }}</div>
                                    <div>(D) {{ $question->option_d }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Part C Directions & Questions -->
                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <div class="mb-4 text-gray-800 text-base leading-relaxed">
                        <div class="text-center mb-2">
                            <span class="text-2xl font-bold">Part C</span>
                        </div>
                        <div class="mb-2"><b><u>Directions:</u></b> In Part C of this section, you will hear several talks. After each talk, you will hear some questions. The talks and questions will not be repeated.</div>
                        <div class="mb-4">After you hear a question, you will read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</div>
                        <div class="border border-gray-300 rounded bg-white p-4 mb-4">
                            <div class="mb-2"><b>Here is an example.</b></div>
                            <div class="ml-4 mb-2">On the recording, you will hear:</div>
                            <div class="ml-6 text-gray-700"><i>(narrator)</i> <span class="italic">Listen to an instructor talk to his class about painting.</span></div>
                            <div class="ml-6 text-gray-700"><i>(man)</i> <span class="italic">Artist Grant Wood was a guiding force in the school of painting known as American regionalist, a style reflecting the distinctive characteristics of art from rural areas of the United States. Wood began drawing animals on the family farm at the age of three, and when he was thirty-eight, one of his paintings received a remarkable amount of public notice and acclaim. This painting, called American Gothic, is a starkly simple depiction of a serious couple staring directly out at the viewer.</span></div>
                            <div class="ml-4 mt-4 mb-2">Now listen to a sample question.</div>
                            <div class="ml-6 text-gray-700"><i>(narrator)</i> <span class="italic">What style of painting is known as American regionalist?</span></div>
                            <div class="ml-6">In your test book, you will read:</div>
                            <div class="ml-8">
                                (A) Art from America's inner cities.<br>
                                (B) Art from the central region of the United States.<br>
                                (C) Art from various urban areas in the United States.<br>
                                (D) Art from rural sections of America.
                            </div>
                            <div class="ml-6 mt-2">The best answer to the question, "What style of painting is known as American regionalist?" is (D), "Art from rural sections of America." Therefore, the correct choice is (D).</div>
                            <div class="ml-4 mt-4 mb-2">Now listen to another sample question.</div>
                            <div class="ml-6 text-gray-700"><i>(narrator)</i> <span class="italic">What is the name of Wood's most successful painting?</span></div>
                            <div class="ml-6">In your test book, you will read:</div>
                            <div class="ml-8">
                                (A) <span class="italic">American Regionalist.</span><br>
                                (B) <span class="italic">The Family Farm in Iowa.</span><br>
                                (C) <span class="italic">American Gothic.</span><br>
                                (D) <span class="italic">A Serious Couple.</span>
                            </div>
                            <div class="ml-6 mt-2">The best answer to the question, "What is the name of Wood's most successful painting?" is (C), <span class="italic">American Gothic.</span> Therefore, the correct choice is (C).</div>
                        </div>
                        <div class="mt-2"><b>Remember, you are <u>not</u> allowed to take notes or write in your test book.</b></div>
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                            {{-- Soal 16-40, tampilan dan interaksi modern ala structure/meeting --}}
                            @php
                            $questions16_40 = [
                                [16, 'Polar winters are <u>length, dark, and cold enough to kill most plants</u>.', 'length', 'dark', 'cold enough', 'to kill', 'A'],
                                [17, 'The remains of very ancient wood <u>have turn into coal</u>.', 'remains', 'very', 'have turn', 'into', 'C'],
                                [18, 'In 1893, Henry Ford built his first car engine in <u>he home workshop in Detroit</u>.', 'he', 'home', 'workshop', 'in Detroit', 'A'],
                                [19, 'Armies of laborers toiled for eight year to <u>build the Erie Canal</u>.', 'toiled', 'for', 'eight year', 'to build', 'C'],
                                [20, 'Some of the stars in the closing stages of their lives <u>becomes white dwarfs</u>.', 'Some', 'closing', 'becomes', 'white dwarfs', 'C'],
                                [21, 'The normally force of gravity at the Earth’s surface is <u>called 1g</u>.', 'normally', 'force', 'at', 'called', 'A'],
                                [22, 'Edward McDowell is remember as the composer of such perennial favorites as <u>"To a Wild Rose."</u>', 'is', 'remember', 'as', 'the composer', 'B'],
                                [23, 'Because he is gravitationally bound to the Milky Way, the Andromeda galaxy is <u>currently approaching Earth</u>.', 'he', 'gravitationally', 'bound', 'currently', 'A'],
                                [24, 'CAT scanners are used not only for detecting conditions but also for <u>observation the effects of therapy</u>.', 'for', 'detecting', 'observation', 'effects', 'C'],
                                [25, 'The chain of rider stations along the way were <u>crucial to the success of the Pony Express</u>.', 'chain', 'rider', 'stations', 'crucial', 'D'],
                                [26, 'The functional relationship between the brain’s two hemispheres has been a major focus of much <u>studies in neuropsychology</u>.', 'relationship', 'hemispheres', 'focus', 'studies', 'D'],
                                [27, 'The Great Salt Lake is the remnant of a <u>vast inland seas</u>.', 'Great', 'remnant', 'vast', 'seas', 'D'],
                                [28, 'A desire to eradicate irregular spellings in English can <u>being traced back to the sixteenth century</u>.', 'desire', 'irregular', 'being', 'to', 'C'],
                                [29, 'Jade can actually refer to either the less common and more valuable jadeite and the more common and <u>less valuable nephrite</u>.', 'either', 'and', 'less', 'valuable', 'B'],
                                [30, 'The musicians came to Harlem in New York City, <u>creating a cultural center there</u>.', 'came', 'to', 'creating', 'center', 'C'],
                                [31, 'In Concord, Massachusetts, there is a museum commemorating the life of Louisa May Alcott, the author the <u>nineteenth-century novel Little Women</u>.', 'museum', 'commemorating', 'author', 'novel', 'C'],
                                [32, 'Lactose, a sugar present in milk, is one of simple <u>sugars used in food preparations for infants</u>.', 'sugar', 'present', 'simple', 'used', 'C'],
                                [33, 'Jackson, Michigan, a city who was settled in 1829, was <u>named for Andrew Jackson</u>, the seventh President of the United States.', 'city', 'who', 'settled', 'named', 'B'],
                                [34, 'Boulder, Colorado, is only city in the United States that <u>derives its water supply from a glacier</u>.', 'only', 'city', 'derives', 'glacier', 'A'],
                                [35, 'Construction of first skyscraper began in Chicago in 1883 with the <u>ten-story Home Insurance Building</u>.', 'Construction', 'first', 'began', 'ten-story', 'B'],
                                [36, 'The remains of the ancient city of Troy <u>were discovered by Heinrich Schliemann in 1870</u>.', 'remains', 'ancient', 'were', 'by', 'D'],
                                [37, 'The first successful cotton mill in the United States was <u>built in Pawtucket, Rhode Island</u>.', 'first', 'cotton', 'built', 'Pawtucket', 'D'],
                                [38, 'The first American novelist to achieve international fame was James Fenimore Cooper, <u>who wrote The Last of the Mohicans</u>.', 'novelist', 'fame', 'wrote', 'Mohicans', 'C'],
                                [39, 'The first American dictionary was published by Noah Webster in 1828, <u>who was a teacher and journalist</u>.', 'dictionary', 'published', 'who', 'journalist', 'C'],
                                [40, 'The first American college to admit women was Oberlin College in Ohio, <u>which was founded in 1833</u>.', 'college', 'admit', 'which', '1833', 'C'],
                            ];
                            @endphp
                            @foreach($questions16_40 as $q)
                            <div class="rounded-xl border border-gray-200 p-6 mb-4 group relative" x-data="{ selected: '' }">
                                <div class="flex gap-4 items-start">
                                    <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 font-bold rounded-lg text-sm mt-4">{{ $q[0] }}</span>
                                    <div class="flex-1">
                                        <p class="text-gray-800 font-medium mb-4 text-lg select-none">{!! $q[1] !!}</p>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach(['A','B','C','D'] as $idx => $opt)
                                            <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition group relative border-gray-200 hover:bg-gray-50"
                                                :class="selected === '{{ $opt }}' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : ''">
                                                <input type="radio" name="answers[{{ $q[0] }}]" value="{{ $opt }}" class="peer sr-only" x-model="selected">
                                                <div class="flex items-center gap-3 w-full p-1">
                                                    <span class="w-8 h-8 min-w-[2rem] shrink-0 flex items-center justify-center rounded-full text-sm font-bold transition-colors border aspect-square"
                                                        :class="selected === '{{ $opt }}' ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-50 text-gray-500 border-gray-200 group-hover:bg-gray-100'">
                                                        {{ $opt }}
                                                    </span>
                                                    <span class="font-medium transition-colors select-none text-gray-600 group-hover:text-gray-900">{{ $q[$idx+2] }}</span>
                                                </div>
                                                <span x-show="selected === '{{ $opt }}'" class="absolute right-3 text-blue-500">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </span>
                                            </label>
                                            @endforeach
                                        </div>
                                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                        <div class="flex gap-2 mt-3">
                                            <button class="p-2 bg-yellow-100 text-yellow-600 rounded hover:bg-yellow-200" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>

<!-- Script untuk handle klik tombol Structure -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cari tombol Section 2: Structure di bagian bawah
    const structureBtn = Array.from(document.querySelectorAll('button, a')).find(el => el.textContent.trim() === 'Lanjut ke Structure');
    if (structureBtn) {
        structureBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Ambil jawaban dari Alpine.js readingPracticePage
            let answers = {};
            try {
                if (window.Alpine && Alpine && Alpine.raw && Alpine.raw(document.body)) {
                    // Cari komponen Alpine readingPracticePage
                    const comps = document.querySelectorAll('[x-data]');
                    for (let comp of comps) {
                        if (comp.__x && comp.__x.$data && comp.__x.$data.answers) {
                            answers = comp.__x.$data.answers;
                            break;
                        }
                    }
                }
            } catch (err) {}
            fetch('/assignments/toefl-itp/listening/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(answers)
            }).then(function(response) {
                window.location.href = '/assignments/toefl-itp/structure';
            }).catch(function() {
                window.location.href = '/assignments/toefl-itp/structure';
            });
        });
    }
});
</script>
</html>
