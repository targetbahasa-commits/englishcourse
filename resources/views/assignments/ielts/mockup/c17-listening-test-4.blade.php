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
<body class="font-sans antialiased bg-gray-50">
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
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 4]) }}"
                   class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
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
                        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1–10</span></h3>
                        <p class="italic mb-2">Complete the notes below.</p>
                        <p class="italic mb-6">Write <strong>ONE WORD</strong> for each answer.</p>
                    </div>

                    {{-- Note completion box --}}
                    <div class="border border-black p-6 mb-8 text-[15px]">
                        <h2 class="text-xl font-bold text-center mb-6">Easy Life Cleaning Services</h2>

                        {{-- Basic cleaning package --}}
                        <h4 class="font-bold mb-3">Basic cleaning package offered</h4>
                        <ul class="list-disc ml-6 space-y-2 mb-6">
                            <li>Cleaning all surfaces</li>
                            <li>Cleaning the <strong>1</strong> <input type="text" name="q1" class="ans" placeholder="Answer"> throughout the apartment</li>
                            <li>Cleaning shower, sinks, toilet etc.</li>
                        </ul>

                        {{-- Additional services agreed --}}
                        <h4 class="font-bold mb-3">Additional services agreed</h4>
                        <ul class="list-disc ml-6 space-y-2 mb-6">
                            <li>
                                Every week
                                <ul class="list-none ml-4 mt-2 space-y-2">
                                    <li>– Cleaning the <strong>2</strong> <input type="text" name="q2" class="ans" placeholder="Answer"></li>
                                    <li>– Ironing clothes – <strong>3</strong> <input type="text" name="q3" class="ans" placeholder="Answer"> only</li>
                                </ul>
                            </li>
                            <li>
                                Every month
                                <ul class="list-none ml-4 mt-2 space-y-2">
                                    <li>– Cleaning all the <strong>4</strong> <input type="text" name="q4" class="ans" placeholder="Answer"> from the inside</li>
                                    <li>– Washing down the <strong>5</strong> <input type="text" name="q5" class="ans" placeholder="Answer"></li>
                                </ul>
                            </li>
                        </ul>

                        {{-- Other possibilities --}}
                        <h4 class="font-bold mb-3">Other possibilities</h4>
                        <ul class="list-disc ml-6 space-y-2 mb-6">
                            <li>They can organise a plumber or an <strong>6</strong> <input type="text" name="q6" class="ans" placeholder="Answer"> if necessary.</li>
                            <li>A special cleaning service is available for customers who are allergic to <strong>7</strong> <input type="text" name="q7" class="ans" placeholder="Answer"></li>
                        </ul>

                        {{-- Information on the cleaners --}}
                        <h4 class="font-bold mb-3">Information on the cleaners</h4>
                        <ul class="list-disc ml-6 space-y-2">
                            <li>Before being hired, all cleaners have a background check carried out by the <strong>8</strong> <input type="text" name="q8" class="ans" placeholder="Answer"></li>
                            <li>References are required.</li>
                            <li>All cleaners are given <strong>9</strong> <input type="text" name="q9" class="ans" placeholder="Answer"> for two weeks.</li>
                            <li>Customers send a <strong>10</strong> <input type="text" name="q10" class="ans" placeholder="Answer"> after each visit.</li>
                            <li>Usually, each customer has one regular cleaner.</li>
                        </ul>
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

                    {{-- Q11-14: MCQ A, B, C --}}
                    <div class="mb-10">
                        <p class="italic mb-1">Questions 11–14</p>
                        <p class="italic mb-4">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

                        <div class="space-y-7 text-[15px]">
                            {{-- Q11 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">11</span>Many hotel managers are unaware that their staff often leave because of</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach(['A' => 'a lack of training.', 'B' => 'long hours.', 'C' => 'low pay.'] as $l => $t)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="{{ $l }}" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Q12 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">12</span>What is the impact of high staff turnover on managers?</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach(['A' => 'an increased workload', 'B' => 'low morale', 'C' => 'an inability to meet targets'] as $l => $t)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="{{ $l }}" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Q13 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">13</span>What mistake should managers always avoid?</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach([
                                        'A' => 'failing to treat staff equally',
                                        'B' => 'reorganising shifts without warning',
                                        'C' => 'neglecting to have enough staff during busy periods',
                                    ] as $l => $t)
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="{{ $l }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Q14 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">14</span>What unexpected benefit did Dunwich Hotel notice after improving staff retention rates?</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach([
                                        'A' => 'a fall in customer complaints',
                                        'B' => 'an increase in loyalty club membership',
                                        'C' => 'a rise in spending per customer',
                                    ] as $l => $t)
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="{{ $l }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Q15-20: Matching hotels --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 15–20</p>
                        <p class="mb-3 text-[15px]">Which way of reducing staff turnover was used in each of the following hotels?</p>
                        <p class="italic mb-5 text-[15px]">Write the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>, next to Questions 15–20.</p>

                        {{-- Ways box --}}
                        <div class="border border-black p-5 max-w-sm mx-auto mb-6 text-[15px]">
                            <p class="font-bold text-center mb-3">Ways of reducing staff turnover</p>
                            @foreach([
                                'A' => 'improving relationships and teamwork',
                                'B' => 'offering incentives and financial benefits',
                                'C' => 'providing career opportunities',
                            ] as $l => $desc)
                            <div class="flex gap-4 mb-1.5"><span class="font-bold w-5">{{ $l }}</span><span>{{ $desc }}</span></div>
                            @endforeach
                        </div>

                        {{-- Hotels list --}}
                        <p class="font-bold mb-3 text-[15px]">Hotels</p>
                        <div class="space-y-3 text-[15px]">
                            @foreach([
                                15 => 'The Sun Club',
                                16 => 'The Portland',
                                17 => 'Bluewater Hotels',
                                18 => 'Pentlow Hotels',
                                19 => 'Green Planet',
                                20 => 'The Amesbury',
                            ] as $num => $hotel)
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-blue-600 w-6 flex-none">{{ $num }}</span>
                                <span class="w-48 flex-none">{{ $hotel }}</span>
                                <select name="q{{ $num }}" class="border border-gray-400 rounded px-3 py-1 bg-white focus:outline-none focus:border-blue-500 cursor-pointer w-20">
                                    <option value="" disabled selected>..........</option>
                                    @foreach(['A','B','C'] as $l)
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

                    {{-- Q21-22: Choose TWO A-E (sporting activities at school) --}}
                    <div class="mb-10">
                        <p class="italic mb-1">Questions 21 and 22</p>
                        <p class="italic mb-3">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                        <p class="mb-4 text-[15px]">Which <strong>TWO</strong> points do Thomas and Jeanne make about Thomas's sporting activities at school?</p>

                        <div class="space-y-2 ml-4 text-[15px]">
                            @foreach([
                                ['A', 'He should have felt more positive about them.'],
                                ['B', 'The training was too challenging for him.'],
                                ['C', 'He could have worked harder at them.'],
                                ['D', 'His parents were disappointed in him.'],
                                ['E', 'His fellow students admired him.'],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="q21_22[]" value="{{ $letter }}" class="mt-1 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                                <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $letter }}</strong>&nbsp; {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-2 italic ml-4">Select exactly two options.</p>
                    </div>

                    {{-- Q23-24: Choose TWO A-E (feelings in Kenya) --}}
                    <div class="mb-10">
                        <p class="italic mb-1">Questions 23 and 24</p>
                        <p class="italic mb-3">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                        <p class="mb-4 text-[15px]">Which <strong>TWO</strong> feelings did Thomas experience when he was in Kenya?</p>

                        <div class="space-y-2 ml-4 text-[15px]">
                            @foreach([
                                ['A', 'disbelief'],
                                ['B', 'relief'],
                                ['C', 'stress'],
                                ['D', 'gratitude'],
                                ['E', 'homesickness'],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="q23_24[]" value="{{ $letter }}" class="mt-1 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                                <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $letter }}</strong>&nbsp; {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-2 italic ml-4">Select exactly two options.</p>
                    </div>

                    {{-- Q25-30: Matching sporting equipment --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 25–30</p>
                        <p class="mb-3 text-[15px]">What comment do the students make about the development of each of the following items of sporting equipment?</p>
                        <p class="italic mb-5 text-[15px]">Choose <strong>SIX</strong> answers from the box and write the correct letter, <strong>A–H</strong>, next to Questions 25–30.</p>

                        {{-- Comments box --}}
                        <div class="border border-black p-5 max-w-lg mx-auto mb-6 text-[15px]">
                            <p class="font-bold text-center mb-3">Comments about the development of the equipment</p>
                            @foreach([
                                'A' => 'It could cause excessive sweating.',
                                'B' => 'The material was being mass produced for another purpose.',
                                'C' => 'People often needed to make their own.',
                                'D' => 'It often had to be replaced.',
                                'E' => 'The material was expensive.',
                                'F' => 'It was unpopular among spectators.',
                                'G' => 'It caused injuries.',
                                'H' => 'No one using it liked it at first.',
                            ] as $l => $desc)
                            <div class="flex gap-4 mb-1.5"><span class="font-bold w-5">{{ $l }}</span><span>{{ $desc }}</span></div>
                            @endforeach
                        </div>

                        {{-- Sporting equipment list --}}
                        <p class="font-bold mb-3 text-[15px]">Items of sporting equipment</p>
                        <div class="space-y-3 text-[15px]">
                            @foreach([
                                25 => 'the table tennis bat',
                                26 => 'the cricket helmet',
                                27 => 'the cycle helmet',
                                28 => 'the golf club',
                                29 => 'the hockey stick',
                                30 => 'the football',
                            ] as $num => $item)
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-blue-600" style="width:28px; flex-shrink:0;">{{ $num }}</span>
                                <span style="width:200px; flex-shrink:0;">{{ $item }}</span>
                                <select name="q{{ $num }}" style="width:90px;" class="border border-gray-400 rounded px-2 py-1 bg-white focus:outline-none focus:border-blue-500 cursor-pointer">
                                    <option value="" disabled selected>..........</option>
                                    @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                    <option value="{{ $l }}">{{ $l }}</option>
                                    @endforeach
                                </select>
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
                        <p class="italic mb-6">Write <strong>ONE WORD ONLY</strong> for each answer.</p>
                    </div>

                    {{-- Note completion box --}}
                    <div class="border border-black p-6 mb-8 text-[15px]">
                        <h2 class="text-xl font-bold text-center mb-6">Maple syrup</h2>

                        {{-- What is maple syrup? --}}
                        <h4 class="font-bold mb-3">What is maple syrup?</h4>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.5rem 2rem;" class="mb-5">
                            <ul class="list-disc ml-5 space-y-2">
                                <li>made from the sap of the maple tree</li>
                                <li>added to food or used in cooking</li>
                            </ul>
                            <ul class="list-disc ml-5 space-y-2">
                                <li>colour described as <strong>31</strong> <input type="text" name="q31" class="ans" style="width:110px" placeholder="Answer"></li>
                                <li>very <strong>32</strong> <input type="text" name="q32" class="ans" style="width:110px" placeholder="Answer"> compared to refined sugar</li>
                            </ul>
                        </div>

                        <hr class="border-dashed border-gray-400 my-4">

                        {{-- The maple tree --}}
                        <h4 class="font-bold mb-3">The maple tree</h4>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.5rem 2rem;" class="mb-5">
                            <ul class="list-disc ml-5 space-y-2">
                                <li>has many species</li>
                                <li>needs sunny days and cool nights</li>
                                <li>maple leaf has been on the Canadian flag since 1964</li>
                            </ul>
                            <ul class="list-disc ml-5 space-y-2">
                                <li>needs moist soil but does not need fertiliser as well</li>
                                <li>best growing conditions and <strong>33</strong> <input type="text" name="q33" class="ans" style="width:110px" placeholder="Answer"> are in Canada and North America</li>
                            </ul>
                        </div>

                        <hr class="border-dashed border-gray-400 my-4">

                        {{-- Early maple sugar producers --}}
                        <h4 class="font-bold mb-3">Early maple sugar producers</h4>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.5rem 2rem;" class="mb-5">
                            <ul class="list-disc ml-5 space-y-2">
                                <li>made holes in the tree trunks</li>
                                <li>used hot <strong>34</strong> <input type="text" name="q34" class="ans" style="width:110px" placeholder="Answer"> to heat the sap</li>
                            </ul>
                            <ul class="list-disc ml-5 space-y-2">
                                <li>used tree bark to make containers for collection</li>
                                <li>sweetened food and drink with sugar</li>
                            </ul>
                        </div>

                        <hr class="border-dashed border-gray-400 my-4">

                        {{-- Today's maple syrup --}}
                        <h4 class="font-bold mb-3">Today's maple syrup</h4>

                        <p class="italic mb-2 ml-1">The trees</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li>Tree trunks may not have the correct <strong>35</strong> <input type="text" name="q35" class="ans" style="width:110px" placeholder="Answer"> until they have been growing for 40 years.</li>
                            <li>The changing temperature and movement of water within the tree produces the sap.</li>
                        </ul>

                        <p class="italic mb-2 ml-1">The production</p>
                        <ul class="list-disc ml-5 space-y-2">
                            <li>A tap is drilled into the trunk and a <strong>36</strong> <input type="text" name="q36" class="ans" style="width:110px" placeholder="Answer"> carries the sap into a bucket.</li>
                            <li>Large pans of sap called evaporators are heated by means of a <strong>37</strong> <input type="text" name="q37" class="ans" style="width:110px" placeholder="Answer">.</li>
                            <li>A lot of <strong>38</strong> <input type="text" name="q38" class="ans" style="width:110px" placeholder="Answer"> is produced during the evaporation process.</li>
                            <li>'Sugar sand' is removed because it makes the syrup look <strong>39</strong> <input type="text" name="q39" class="ans" style="width:110px" placeholder="Answer"> and affects the taste.</li>
                            <li>The syrup is ready for use.</li>
                            <li>A huge quantity of sap is needed to make a <strong>40</strong> <input type="text" name="q40" class="ans" style="width:110px" placeholder="Answer"> of maple syrup.</li>
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

        </div>
    </main>
</div>
</body>
</html>
