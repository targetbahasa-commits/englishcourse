<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Up - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .paper-shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); }
        .dotted-line { border-bottom: 1px dotted #000; display: inline-block; width: 150px; }
        input[type=text].ans { border: none; border-bottom: 1px solid #000; outline: none; padding: 2px 8px; width: 140px; background: transparent; text-align: center; }
        input[type=text].ans:focus { border-bottom-color: #3b82f6; }
    </style>
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
<div class="flex min-h-screen">
    <main class="flex-1 w-full max-w-6xl mx-auto p-8">

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">IELTS Listening Mock Up</h1>
                        <p class="text-gray-600 mt-1">Cambridge {{ $edition }} Test {{ $testId }}</p>
                    </div>
                </div>
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 2]) }}"
                   class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </a>
            </div>
        </div>

        <div x-data="{ step: 1 }" x-init="$watch('step', value => $dispatch('part-changed', value))">

            {{-- ────────────────── PART 1 ────────────────── --}}
            <div x-show="step === 1">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8 italic">Questions 1–10</span></h3>
                        <p class="italic mb-2">Questions 1–7</p>
                        <p class="italic mb-2">Complete the notes below.</p>
                        <p class="italic">Write <strong>ONE WORD ONLY</strong> for each answer.</p>
                    </div>

                    {{-- Q1-7 Notes --}}
                    <div class="border border-black p-6 mb-8">
                        <h2 class="text-xl font-bold text-center mb-5">Opportunities for voluntary work in Southoe village</h2>

                        {{-- Library --}}
                        <h4 class="font-bold mb-3">Library</h4>
                        <ul class="list-disc ml-6 space-y-3 mb-5 text-[15px]">
                            <li>Help with <strong>1</strong> <input type="text" class="ans" placeholder="Answer"> books (times to be arranged)</li>
                            <li>Help needed to keep <strong>2</strong> <input type="text" class="ans" placeholder="Answer"> of books up to date</li>
                            <li>Library is in the <strong>3</strong> <input type="text" class="ans" placeholder="Answer"> Room in the village hall</li>
                        </ul>

                        {{-- Lunch club --}}
                        <h4 class="font-bold mb-3">Lunch club</h4>
                        <ul class="list-disc ml-6 space-y-3 mb-5 text-[15px]">
                            <li>Help by providing <strong>4</strong> <input type="text" class="ans" placeholder="Answer"></li>
                            <li>Help with hobbies such as <strong>5</strong> <input type="text" class="ans" placeholder="Answer"></li>
                        </ul>

                        {{-- Help for individuals --}}
                        <h4 class="font-bold mb-3">Help for individuals needed next week</h4>
                        <ul class="list-disc ml-6 space-y-3 text-[15px]">
                            <li>Taking Mrs Carroll to <strong>6</strong> <input type="text" class="ans" placeholder="Answer"></li>
                            <li>Work in the <strong>7</strong> <input type="text" class="ans" placeholder="Answer"> at Mr Selsbury's house</li>
                        </ul>
                    </div>

                    {{-- Q8-10 Table --}}
                    <div class="mb-4">
                        <p class="italic mb-2">Questions 8–10</p>
                        <p class="italic mb-2">Complete the table below.</p>
                        <p class="italic mb-5">Write <strong>ONE WORD ONLY</strong> for each answer.</p>
                    </div>

                    <div class="border border-black overflow-hidden mb-6">
                        <table class="w-full text-[15px] border-collapse">
                            <thead>
                                <tr class="bg-white">
                                    <th colspan="4" class="border border-black px-4 py-2 text-center font-bold">Village social events</th>
                                </tr>
                                <tr>
                                    <th class="border border-black px-4 py-2 font-bold text-left w-20">Date</th>
                                    <th class="border border-black px-4 py-2 font-bold text-left">Event</th>
                                    <th class="border border-black px-4 py-2 font-bold text-left">Location</th>
                                    <th class="border border-black px-4 py-2 font-bold text-left">Help needed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-black px-4 py-3">19 Oct</td>
                                    <td class="border border-black px-4 py-3"><strong>8</strong> <input type="text" class="ans" placeholder="Answer"></td>
                                    <td class="border border-black px-4 py-3">Village hall</td>
                                    <td class="border border-black px-4 py-3">providing refreshments</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-4 py-3">18 Nov</td>
                                    <td class="border border-black px-4 py-3">dance</td>
                                    <td class="border border-black px-4 py-3">Village hall</td>
                                    <td class="border border-black px-4 py-3">checking <strong>9</strong> <input type="text" class="ans" placeholder="Answer"></td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-4 py-3">31 Dec</td>
                                    <td class="border border-black px-4 py-3">New Year's Eve party</td>
                                    <td class="border border-black px-4 py-3">Mountfort Hotel</td>
                                    <td class="border border-black px-4 py-3">designing the <strong>10</strong> <input type="text" class="ans" placeholder="Answer"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Next Part
                        </button>
                    </div>
                </div>
            </div>

            {{-- ────────────────── PART 2 ────────────────── --}}
            <div x-show="step === 2">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
                    </div>

                    {{-- Q11-14 MCQ --}}
                    <div class="mb-8">
                        <p class="italic mb-2">Questions 11–14</p>
                        <p class="italic mb-6">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

                        <h2 class="text-2xl font-bold text-center mb-8">Oniton Hall</h2>

                        <div class="space-y-7 text-[15px]">
                            @foreach([
                                [11, 'Many past owners made changes to', ['A' => 'the gardens.', 'B' => 'the house.', 'C' => 'the farm.']],
                                [12, 'Sir Edward Downes built Oniton Hall because he wanted', ['A' => 'a place for discussing politics.', 'B' => 'a place to display his wealth.', 'C' => 'a place for artists and writers.']],
                                [13, 'Visitors can learn about the work of servants in the past from', ['A' => 'audio guides.', 'B' => 'photographs.', 'C' => 'people in costume.']],
                                [14, 'What is new for children at Oniton Hall?', ['A' => 'clothes for dressing up', 'B' => 'mini tractors', 'C' => 'the adventure playground']],
                            ] as [$num, $question, $opts])
                            <div>
                                <p class="font-semibold mb-2"><span class="font-bold mr-2">{{ $num }}</span>{{ $question }}</p>
                                <div class="space-y-1 ml-6">
                                    @foreach($opts as $letter => $text)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-4 h-4 text-purple-600 cursor-pointer">
                                        <span><strong>{{ $letter }}</strong>&nbsp; {{ $text }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-gray-300 my-8">

                    {{-- Q15-20 Matching --}}
                    <div class="mb-6">
                        <p class="italic mb-2">Questions 15–20</p>
                        <p class="mb-2 text-[15px]">Which activity is offered at each of the following locations on the farm?</p>
                        <p class="italic mb-5 text-[15px]">Choose <strong>SIX</strong> answers from the box and write the correct letter, <strong>A–H</strong>, next to Questions 15–20.</p>

                        {{-- Activities box --}}
                        <div class="border border-gray-400 p-5 max-w-sm mx-auto mb-8 text-[15px]">
                            <p class="font-bold text-center mb-3">Activities</p>
                            @foreach(['A' => 'shopping', 'B' => 'watching cows being milked', 'C' => 'seeing old farming equipment', 'D' => 'eating and drinking', 'E' => 'starting a trip', 'F' => 'seeing rare breeds of animals', 'G' => 'helping to look after animals', 'H' => 'using farming tools'] as $l => $act)
                            <div class="flex gap-3 mb-1"><span class="font-bold w-5">{{ $l }}</span><span>{{ $act }}</span></div>
                            @endforeach
                        </div>

                        {{-- Matching pairs --}}
                        <p class="font-bold mb-3 text-[15px]">Locations on the farm</p>
                        <div class="space-y-3 text-[15px]">
                            @foreach([15 => 'dairy', 16 => 'large barn', 17 => 'small barn', 18 => 'stables', 19 => 'shed', 20 => 'parkland'] as $num => $location)
                            <div class="flex items-center gap-4">
                                <span class="font-bold w-6">{{ $num }}</span>
                                <span class="w-32">{{ $location }}</span>
                                <select name="q{{ $num }}" class="border border-gray-400 rounded px-3 py-1.5 text-sm font-semibold bg-white focus:outline-none focus:border-purple-500 cursor-pointer">
                                    <option value="" disabled selected>........</option>
                                    @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                    <option value="{{ $l }}">{{ $l }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button @click="step = 1" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Previous Part
                        </button>
                        <button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Next Part
                        </button>
                    </div>
                </div>
            </div>

            {{-- ────────────────── PART 3 ────────────────── --}}
            <div x-show="step === 3">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
                    </div>

                    {{-- Q21-22 Choose TWO --}}
                    <div class="mb-8">
                        <p class="italic mb-2">Questions 21 and 22</p>
                        <p class="italic mb-4">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                        <p class="mb-5 text-[15px]">Which <strong>TWO</strong> things do the students agree they need to include in their reviews of <em>Romeo and Juliet</em>?</p>

                        <div class="space-y-2 ml-2 text-[15px]">
                            @foreach(['A' => 'analysis of the text', 'B' => 'a summary of the plot', 'C' => 'a description of the theatre', 'D' => 'a personal reaction', 'E' => 'a reference to particular scenes'] as $letter => $text)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="q21_22[]" value="{{ $letter }}" class="w-4 h-4 text-purple-600 rounded cursor-pointer">
                                <span><strong>{{ $letter }}</strong>&nbsp; {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-3 italic">Select exactly two options.</p>
                    </div>

                    <hr class="border-gray-300 my-6">

                    {{-- Q23-27 Matching opinions --}}
                    <div class="mb-8">
                        <p class="italic mb-2">Questions 23–27</p>
                        <p class="mb-4 text-[15px]">Which opinion do the speakers give about each of the following aspects of The Emporium's production of <em>Romeo and Juliet</em>?</p>
                        <p class="italic mb-5 text-[15px]">Choose <strong>FIVE</strong> answers from the box and write the correct letter, <strong>A–G</strong>, next to Questions 23–27.</p>

                        {{-- Opinions box --}}
                        <div class="border border-gray-400 p-5 max-w-lg mx-auto mb-8 text-[15px]">
                            <p class="font-bold text-center mb-3">Opinions</p>
                            @foreach([
                                'A' => 'They both expected this to be more traditional.',
                                'B' => 'They both thought this was original.',
                                'C' => 'They agree this created the right atmosphere.',
                                'D' => 'They agree this was a major strength.',
                                'E' => 'They were both disappointed by this.',
                                'F' => 'They disagree about why this was an issue.',
                                'G' => 'They disagree about how this could be improved.',
                            ] as $l => $op)
                            <div class="flex gap-3 mb-1"><span class="font-bold w-5">{{ $l }}</span><span>{{ $op }}</span></div>
                            @endforeach
                        </div>

                        <p class="font-bold mb-3 text-[15px]">Aspects of the production</p>
                        <div class="space-y-3 text-[15px]">
                            @foreach([23 => 'the set', 24 => 'the lighting', 25 => 'the costume design', 26 => 'the music', 27 => "the actors' delivery"] as $num => $aspect)
                            <div class="flex items-center gap-4">
                                <span class="font-bold w-6">{{ $num }}</span>
                                <span class="w-44">{{ $aspect }}</span>
                                <select name="q{{ $num }}" class="border border-gray-400 rounded px-3 py-1.5 text-sm font-semibold bg-white focus:outline-none focus:border-purple-500 cursor-pointer">
                                    <option value="" disabled selected>........</option>
                                    @foreach(['A','B','C','D','E','F','G'] as $l)
                                    <option value="{{ $l }}">{{ $l }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-gray-300 my-6">

                    {{-- Q28-30 MCQ --}}
                    <div class="mb-8">
                        <p class="italic mb-4">Questions 28–30</p>
                        <p class="italic mb-6">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

                        <div class="space-y-7 text-[15px]">
                            @foreach([
                                [28, 'The students think the story of <em>Romeo and Juliet</em> is still relevant for young people today because', [
                                    'A' => 'it illustrates how easily conflict can start.',
                                    'B' => 'it deals with problems that families experience.',
                                    'C' => 'it teaches them about relationships.',
                                ]],
                                [29, 'The students found watching <em>Romeo and Juliet</em> in another language', [
                                    'A' => 'frustrating.',
                                    'B' => 'demanding.',
                                    'C' => 'moving.',
                                ]],
                                [30, "Why do the students think Shakespeare's plays have such international appeal?", [
                                    'A' => 'The stories are exciting.',
                                    'B' => 'There are recognisable characters.',
                                    'C' => 'They can be interpreted in many ways.',
                                ]],
                            ] as [$num, $question, $opts])
                            <div>
                                <p class="font-semibold mb-2"><span class="font-bold mr-2">{{ $num }}</span>{!! $question !!}</p>
                                <div class="space-y-1 ml-6">
                                    @foreach($opts as $letter => $text)
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-4 h-4 text-purple-600 cursor-pointer">
                                        <span><strong>{{ $letter }}</strong>&nbsp; {{ $text }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button @click="step = 2" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Previous Part
                        </button>
                        <button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Next Part
                        </button>
                    </div>
                </div>
            </div>

            {{-- ────────────────── PART 4 ────────────────── --}}
            <div x-show="step === 4">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
                        <p class="italic mb-2">Complete the notes below.</p>
                        <p class="italic mb-6">Write <strong>ONE WORD AND/OR A NUMBER</strong> for each answer.</p>
                    </div>

                    {{-- Q31-40 Notes --}}
                    <div class="border border-black p-8 mb-8">
                        <h2 class="text-2xl font-bold text-center mb-6">The impact of digital technology on the Icelandic language</h2>

                        {{-- Section 1 --}}
                        <h4 class="font-bold text-lg mb-4 text-gray-800">The Icelandic language</h4>
                        <ul class="list-disc ml-8 space-y-4 mb-8 text-[15px] leading-relaxed">
                            <li>has approximately <strong>31</strong> <input type="text" class="ans" placeholder="Answer"> speakers</li>
                            <li>has a <strong>32</strong> <input type="text" class="ans" placeholder="Answer"> that is still growing</li>
                            <li>has not changed a lot over the last thousand years</li>
                            <li>has its own words for computer-based concepts, such as web browser and <strong>33</strong> <input type="text" class="ans" placeholder="Answer"></li>
                        </ul>

                        {{-- Section 2 --}}
                        <h4 class="font-bold text-lg mb-4 text-gray-800">Young speakers</h4>
                        <ul class="list-disc ml-8 space-y-4 mb-8 text-[15px] leading-relaxed">
                            <li>are big users of digital technology, such as <strong>34</strong> <input type="text" class="ans" placeholder="Answer"></li>
                            <li>are becoming <strong>35</strong> <input type="text" class="ans" placeholder="Answer"> very quickly</li>
                            <li>are having discussions using only English while they are in the <strong>36</strong> <input type="text" class="ans" placeholder="Answer"> at school</li>
                            <li>are better able to identify the content of a <strong>37</strong> <input type="text" class="ans" placeholder="Answer"> in English than Icelandic</li>
                        </ul>

                        {{-- Section 3 --}}
                        <h4 class="font-bold text-lg mb-4 text-gray-800">Technology and internet companies</h4>
                        <ul class="list-disc ml-8 space-y-4 mb-8 text-[15px] leading-relaxed">
                            <li>write very little in Icelandic because of the small number of speakers and because of how complicated its <strong>38</strong> <input type="text" class="ans" placeholder="Answer"> is</li>
                        </ul>

                        {{-- Section 4 --}}
                        <h4 class="font-bold text-lg mb-4 text-gray-800">The Icelandic government</h4>
                        <ul class="list-disc ml-8 space-y-4 text-[15px] leading-relaxed">
                            <li>has set up a fund to support the production of more digital content in the language</li>
                            <li>believes that Icelandic has a secure future</li>
                            <li>is worried that young Icelanders may lose their <strong>39</strong> <input type="text" class="ans" placeholder="Answer"> as Icelanders</li>
                            <li>is worried about the consequences of children not being <strong>40</strong> <input type="text" class="ans" placeholder="Answer"> in either Icelandic or English</li>
                        </ul>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button @click="step = 3" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Previous Part
                        </button>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Submit All Answers
                        </button>
                    </div>
                </div>
            </div>

        </div>{{-- end x-data --}}
    </main>
</div>

<script>
/* Choose TWO enforcement (FIFO) */
(function () {
    const queues = {};
    document.addEventListener('change', function (e) {
        const cb = e.target;
        if (cb.type !== 'checkbox') return;
        const name = cb.name;
        if (!queues[name]) queues[name] = [];
        const q = queues[name];
        if (cb.checked) {
            q.push(cb);
            if (q.length > 2) { const old = q.shift(); old.checked = false; }
        } else {
            const idx = q.indexOf(cb);
            if (idx !== -1) q.splice(idx, 1);
        }
    });
})();
</script>

</body>
</html>
