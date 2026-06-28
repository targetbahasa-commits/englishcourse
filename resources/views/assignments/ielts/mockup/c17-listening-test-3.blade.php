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
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 3]) }}"
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
                        <p class="italic mb-6">Write <strong>ONE WORD AND/OR A NUMBER</strong> for each answer.</p>
                    </div>

                    {{-- Note completion box --}}
                    <div class="border border-black p-6 mb-8 text-[15px]">
                        <h2 class="text-xl font-bold text-center mb-6">Advice on surfing holidays</h2>

                        {{-- Jack's advice --}}
                        <h4 class="font-bold mb-3">Jack's advice</h4>
                        <ul class="list-disc ml-6 space-y-3 mb-6">
                            <li>Recommends surfing for <strong>1</strong> <input type="text" name="q1" class="ans" placeholder="Answer"> holidays in the summer</li>
                            <li>Need to be quite <strong>2</strong> <input type="text" name="q2" class="ans" placeholder="Answer"></li>
                        </ul>

                        {{-- Irish surfing locations --}}
                        <h4 class="font-bold mb-3">Irish surfing locations</h4>
                        <ul class="list-disc ml-6 space-y-3 mb-5">
                            <li>
                                County Clare
                                <ul class="list-none ml-4 mt-2 space-y-2">
                                    <li>– Lahinch has some good quality <strong>3</strong> <input type="text" name="q3" class="ans" placeholder="Answer"> and surf schools</li>
                                    <li>– There are famous cliffs nearby</li>
                                </ul>
                            </li>
                            <li>
                                County Mayo
                                <ul class="list-none ml-4 mt-2 space-y-2">
                                    <li>– Good surf school at <strong>4</strong> <input type="text" name="q4" class="ans" placeholder="Answer"> beach</li>
                                    <li>– Surf camp lasts for one <strong>5</strong> <input type="text" name="q5" class="ans" placeholder="Answer"></li>
                                    <li>– Can also explore the local <strong>6</strong> <input type="text" name="q6" class="ans" placeholder="Answer"> by kayak</li>
                                </ul>
                            </li>
                        </ul>

                        {{-- Weather --}}
                        <h4 class="font-bold mb-3">Weather</h4>
                        <ul class="list-disc ml-6 space-y-3 mb-5">
                            <li>Best month to go: <strong>7</strong> <input type="text" name="q7" class="ans" placeholder="Answer"></li>
                            <li>Average temperature in summer: approx. <strong>8</strong> <input type="text" name="q8" class="ans" placeholder="Answer"> degrees</li>
                        </ul>

                        {{-- Costs --}}
                        <h4 class="font-bold mb-3">Costs</h4>
                        <ul class="list-disc ml-6 space-y-3">
                            <li>
                                Equipment
                                <ul class="list-none ml-4 mt-2 space-y-2">
                                    <li>– Wetsuit and surfboard: <strong>9</strong> <input type="text" name="q9" class="ans" placeholder="Answer"> euros per day</li>
                                    <li>– Also advisable to hire <strong>10</strong> <input type="text" name="q10" class="ans" placeholder="Answer"> for warmth</li>
                                </ul>
                            </li>
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

                    {{-- Q11-12: Choose TWO --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 11 and 12</p>
                        <p class="italic mb-3">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                        <p class="mb-4 text-[15px]">Which <strong>TWO</strong> facts are given about the school's extended hours childcare service?</p>

                        <div class="space-y-2 ml-4 text-[15px]">
                            @foreach([
                                ['A', 'It started recently.'],
                                ['B', 'More children attend after school than before school.'],
                                ['C', 'An average of 50 children attend in the mornings.'],
                                ['D', 'A child cannot attend both the before and after school sessions.'],
                                ['E', 'The maximum number of children who can attend is 70.'],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="q11_12[]" value="{{ $letter }}" class="mt-1 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                                <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $letter }}</strong>&nbsp; {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-2 italic ml-4">Select exactly two options.</p>
                    </div>

                    {{-- Q13-15: MCQ A, B, C --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 13–15</p>
                        <p class="italic mb-4">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

                        <div class="space-y-6 text-[15px]">
                            {{-- Q13 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">13</span>How much does childcare cost for a complete afternoon session per child?</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach(['A' => '£3.50', 'B' => '£5.70', 'C' => '£7.20'] as $l => $t)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="{{ $l }}" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Q14 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">14</span>What does the manager say about food?</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach([
                                        'A' => 'Children with allergies should bring their own food.',
                                        'B' => 'Children may bring healthy snacks with them.',
                                        'C' => 'Children are given a proper meal at 5 p.m.',
                                    ] as $l => $t)
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="{{ $l }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Q15 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">15</span>What is different about arrangements in the school holidays?</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach([
                                        'A' => 'Children from other schools can attend.',
                                        'B' => 'Older children can attend.',
                                        'C' => 'A greater number of children can attend.',
                                    ] as $l => $t)
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="radio" name="q15" value="{{ $l }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Q16-20: Matching activities --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 16–20</p>
                        <p class="mb-3 text-[15px]">What information is given about each of the following activities on offer?</p>
                        <p class="italic mb-5 text-[15px]">Choose <strong>FIVE</strong> answers from the box and write the correct letter, <strong>A–G</strong>, next to Questions 16–20.</p>

                        {{-- Information box --}}
                        <div class="border border-black p-5 max-w-sm mx-auto mb-6 text-[15px]">
                            <p class="font-bold text-center mb-3">Information</p>
                            @foreach([
                                'A' => 'has limited availability',
                                'B' => 'is no longer available',
                                'C' => 'is for over 8s only',
                                'D' => 'requires help from parents',
                                'E' => 'involves an additional fee',
                                'F' => 'is a new activity',
                                'G' => 'was requested by children',
                            ] as $l => $desc)
                            <div class="flex gap-4 mb-1.5"><span class="font-bold w-5">{{ $l }}</span><span>{{ $desc }}</span></div>
                            @endforeach
                        </div>

                        {{-- Activities list --}}
                        <p class="font-bold mb-3 text-[15px]">Activities</p>
                        <div class="space-y-3 text-[15px]">
                            @foreach([16 => 'Spanish', 17 => 'Music', 18 => 'Painting', 19 => 'Yoga', 20 => 'Cooking'] as $num => $activity)
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-blue-600 w-6 flex-none">{{ $num }}</span>
                                <span class="w-32 flex-none">{{ $activity }}</span>
                                <select name="q{{ $num }}" class="border border-gray-400 rounded px-3 py-1 bg-white focus:outline-none focus:border-blue-500 cursor-pointer w-20">
                                    <option value="" disabled selected>..........</option>
                                    @foreach(['A','B','C','D','E','F','G'] as $l)
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

                    {{-- Q21-24: MCQ --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 21–24</p>
                        <p class="italic mb-4">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

                        <h3 class="text-xl font-bold text-center mb-6">Holly's Work Placement Tutorial</h3>

                        <div class="space-y-6 text-[15px]">
                            {{-- Q21 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">21</span>Holly has chosen the Orion Stadium placement because</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach(['A' => 'it involves children.', 'B' => 'it is outdoors.', 'C' => 'it sounds like fun.'] as $l => $t)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q21" value="{{ $l }}" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Q22 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">22</span>Which aspect of safety does Dr Green emphasise most?</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach([
                                        'A' => 'ensuring children stay in the stadium',
                                        'B' => 'checking the equipment children will use',
                                        'C' => 'removing obstacles in changing rooms',
                                    ] as $l => $t)
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="radio" name="q22" value="{{ $l }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Q23 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">23</span>What does Dr Green say about the spectators?</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach([
                                        'A' => 'They can be hard to manage.',
                                        'B' => 'They make useful volunteers.',
                                        'C' => "They shouldn't take photographs.",
                                    ] as $l => $t)
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="radio" name="q23" value="{{ $l }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Q24 --}}
                            <div>
                                <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">24</span>What has affected the schedule in the past?</p>
                                <div class="space-y-1.5 ml-6">
                                    @foreach([
                                        'A' => 'bad weather',
                                        'B' => 'an injury',
                                        'C' => 'extra time',
                                    ] as $l => $t)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q24" value="{{ $l }}" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer">
                                        <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Q25-30: Matching events management skills --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 25–30</p>
                        <p class="mb-3 text-[15px]">What do Holly and her tutor agree is an important aspect of each of the following events management skills?</p>
                        <p class="italic mb-5 text-[15px]">Choose <strong>SIX</strong> answers from the box and write the correct letter, <strong>A–H</strong>, next to Questions 25–30.</p>

                        {{-- Important aspects box --}}
                        <div class="border border-black p-5 max-w-sm mx-auto mb-6 text-[15px]">
                            <p class="font-bold text-center mb-3">Important aspects</p>
                            @foreach([
                                'A' => 'being flexible',
                                'B' => 'focusing on details',
                                'C' => 'having a smart appearance',
                                'D' => 'hiding your emotions',
                                'E' => 'relying on experts',
                                'F' => 'trusting your own views',
                                'G' => 'doing one thing at a time',
                                'H' => 'thinking of the future',
                            ] as $l => $desc)
                            <div class="flex gap-4 mb-1.5"><span class="font-bold w-5">{{ $l }}</span><span>{{ $desc }}</span></div>
                            @endforeach
                        </div>

                        {{-- Skills list --}}
                        <p class="font-bold mb-3 text-[15px]">Events management skills</p>
                        <div class="space-y-3 text-[15px]">
                            @foreach([
                                25 => 'Communication',
                                26 => 'Organisation',
                                27 => 'Time management',
                                28 => 'Creativity',
                                29 => 'Leadership',
                                30 => 'Networking',
                            ] as $num => $skill)
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-blue-600 w-6 flex-none">{{ $num }}</span>
                                <span class="w-36 flex-none">{{ $skill }}</span>
                                <select name="q{{ $num }}" class="border border-gray-400 rounded px-3 py-1 bg-white focus:outline-none focus:border-blue-500 cursor-pointer w-20">
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
                        <p class="italic mb-6">Write <strong>ONE WORD AND/OR A NUMBER</strong> for each answer.</p>
                    </div>

                    {{-- Note completion box --}}
                    <div class="border border-black p-6 mb-8 text-[15px]">
                        <h2 class="text-xl font-bold text-center mb-4">Bird Migration Theory</h2>
                        <p class="mb-5">Most birds are believed to migrate seasonally.</p>

                        {{-- Hibernation theory --}}
                        <h4 class="font-bold mb-3">Hibernation theory</h4>
                        <ul class="list-disc ml-6 space-y-3 mb-6">
                            <li>It was believed that birds hibernated underwater or buried themselves in <strong>31</strong> <input type="text" name="q31" class="ans" placeholder="Answer">.</li>
                            <li>This theory was later disproved by experiments on caged birds.</li>
                        </ul>

                        {{-- Transmutation theory --}}
                        <h4 class="font-bold mb-3">Transmutation theory</h4>
                        <ul class="list-disc ml-6 space-y-3 mb-6">
                            <li>
                                Aristotle believed birds changed from one species into another in summer and winter.
                                <ul class="list-none ml-4 mt-2 space-y-2">
                                    <li>– In autumn he observed that redstarts experience the loss of <strong>32</strong> <input type="text" name="q32" class="ans" placeholder="Answer"> and thought they then turned into robins.</li>
                                    <li>– Aristotle's assumptions were logical because the two species of birds had a similar <strong>33</strong> <input type="text" name="q33" class="ans" placeholder="Answer">.</li>
                                </ul>
                            </li>
                        </ul>

                        {{-- 17th century --}}
                        <h4 class="font-bold mb-3">17th century</h4>
                        <ul class="list-disc ml-6 space-y-3 mb-6">
                            <li>Charles Morton popularised the idea that birds fly to the <strong>34</strong> <input type="text" name="q34" class="ans" placeholder="Answer"> in winter.</li>
                        </ul>

                        {{-- Scientific developments --}}
                        <h4 class="font-bold mb-3">Scientific developments</h4>
                        <ul class="list-disc ml-6 space-y-3">
                            <li>
                                In 1822, a stork was killed in Germany which had an African spear in its <strong>35</strong> <input type="text" name="q35" class="ans" placeholder="Answer">.
                                <ul class="list-none ml-4 mt-2">
                                    <li>– previously there had been no <strong>36</strong> <input type="text" name="q36" class="ans" placeholder="Answer"> that storks migrate to Africa</li>
                                </ul>
                            </li>
                            <li>
                                Little was known about the <strong>37</strong> <input type="text" name="q37" class="ans" placeholder="Answer"> and journeys of migrating birds until the practice of ringing was established.
                                <ul class="list-none ml-4 mt-2 space-y-2">
                                    <li>– It was thought large birds carried small birds on some journeys because they were considered incapable of travelling across huge <strong>38</strong> <input type="text" name="q38" class="ans" placeholder="Answer">.</li>
                                    <li>– Ringing depended on what is called the <strong>39</strong> '<input type="text" name="q39" class="ans" placeholder="Answer">' of dead birds.</li>
                                </ul>
                            </li>
                            <li>In 1931, the first <strong>40</strong> <input type="text" name="q40" class="ans" placeholder="Answer"> to show the migration of European birds was printed.</li>
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
