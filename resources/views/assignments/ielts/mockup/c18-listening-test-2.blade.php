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
        .paper-shadow {
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        }
        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            width: 150px;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
<div class="flex min-h-screen">
    <main class="flex-1 w-full max-w-6xl mx-auto p-8">
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
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 1]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
            </div>
        </div>

        <div x-data="{ step: 1 }" x-init="$watch('step', value => $dispatch('part-changed', value))">

            {{-- PART 1 --}}
            <div x-show="step === 1">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1–10</span></h3>
                    </div>

                    {{-- Questions 1–5 --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 1–5</p>
                        <p class="italic mb-1">Complete the notes below.</p>
                        <p class="italic mb-4">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>

                        <div class="border border-black p-6">
                            <h2 class="text-2xl font-bold text-center mb-6">Working at Milo's Restaurants</h2>

                            <p class="font-bold mb-3">Benefits</p>
                            <ul class="space-y-3 ml-4 list-disc">
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold">1</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>provided for all staff</span>
                                </li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold">2</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>during weekdays at all Milo's Restaurants</span>
                                </li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold">3</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>provided after midnight</span>
                                </li>
                            </ul>

                            <p class="font-bold mb-3 mt-6">Person specification</p>
                            <ul class="space-y-3 ml-4 list-disc">
                                <li>must be prepared to work well in a team</li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>must care about maintaining a high standard of</span>
                                    <span class="font-bold">4</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                </li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>must have a qualification in</span>
                                    <span class="font-bold">5</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Questions 6–10 --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Questions 6–10</p>
                        <p class="italic mb-1">Complete the table below.</p>
                        <p class="italic mb-4">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-400">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-400 p-3 text-left font-bold">Location</th>
                                        <th class="border border-gray-400 p-3 text-left font-bold">Job title</th>
                                        <th class="border border-gray-400 p-3 text-left font-bold">Responsibilities include</th>
                                        <th class="border border-gray-400 p-3 text-left font-bold">Pay and conditions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-400 p-3">
                                            <div class="flex items-center gap-1 flex-wrap">
                                                <span class="font-bold">6</span>
                                                <input type="text" class="border-b border-black outline-none px-1 w-24 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                                <span>Street</span>
                                            </div>
                                        </td>
                                        <td class="border border-gray-400 p-3">Breakfast supervisor</td>
                                        <td class="border border-gray-400 p-3">
                                            <p>Checking portions, etc. are correct</p>
                                            <p class="mt-2">Making sure
                                                <span class="font-bold">7</span>
                                                <input type="text" class="border-b border-black outline-none px-1 w-24 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                                is clean
                                            </p>
                                        </td>
                                        <td class="border border-gray-400 p-3">
                                            <p>Starting salary
                                                <span class="font-bold">8</span>
                                                £<input type="text" class="border-b border-black outline-none px-1 w-16 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                                per hour
                                            </p>
                                            <p class="mt-2">Start work at 5.30 a.m.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-3">City Road</td>
                                        <td class="border border-gray-400 p-3">Junior chef</td>
                                        <td class="border border-gray-400 p-3">
                                            <p>Supporting senior chefs</p>
                                            <p class="mt-2">Maintaining stock and organising
                                                <span class="font-bold">9</span>
                                                <input type="text" class="border-b border-black outline-none px-1 w-24 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                            </p>
                                        </td>
                                        <td class="border border-gray-400 p-3">
                                            <p>Annual salary £23,000</p>
                                            <p class="mt-2">No work on a
                                                <span class="font-bold">10</span>
                                                <input type="text" class="border-b border-black outline-none px-1 w-24 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                                once a month
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-end">
                    <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
                </div>
            </div>

            {{-- PART 2 --}}
            <div x-show="step === 2" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
                    </div>

                    {{-- Questions 11–12: Choose TWO --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 11 and 12</p>
                        <p class="italic mb-1">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        <p class="mb-4">What are the <strong>TWO</strong> main reasons why this site has been chosen for the housing development?</p>

                        <div class="space-y-2 ml-4" data-max-checks="2">
                            @foreach([
                                ['A', 'It has suitable geographical features.'],
                                ['B', 'There is easy access to local facilities.'],
                                ['C', 'It has good connections with the airport.'],
                                ['D', 'The land is of little agricultural value.'],
                                ['E', 'It will be convenient for workers.'],
                            ] as [$letter, $text])
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="q11_12[]" value="{{ $letter }}" class="w-4 h-4 text-purple-600 rounded checkbox-limit">
                                <span class="font-bold">{{ $letter }}</span>
                                <span>{{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 13–14: Choose TWO --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 13 and 14</p>
                        <p class="italic mb-1">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        <p class="mb-4">Which <strong>TWO</strong> aspects of the planned housing development have people given positive feedback about?</p>

                        <div class="space-y-2 ml-4" data-max-checks="2">
                            @foreach([
                                ['A', 'the facilities for cyclists'],
                                ['B', 'the impact on the environment'],
                                ['C', 'the encouragement of good relations between residents'],
                                ['D', 'the low cost of all the accommodation'],
                                ['E', 'the rural location'],
                            ] as [$letter, $text])
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="q13_14[]" value="{{ $letter }}" class="w-4 h-4 text-purple-600 rounded checkbox-limit">
                                <span class="font-bold">{{ $letter }}</span>
                                <span>{{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 15–20: Map labelling --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Questions 15–20</p>
                        <p class="italic mb-1">Label the map below.</p>
                        <p class="italic mb-4">Write the correct letter, <span class="font-bold">A–I</span>, next to Questions 15–20.</p>

                        {{-- Map --}}
                        <div class="mb-6">
                            <img src="{{ asset('images/cambridge/c18-t2-housing-map.png') }}" alt="Housing Development Plan Map" class="w-full max-w-2xl mx-auto border border-gray-300 rounded">
                        </div>

                        {{-- Map answers --}}
                        <div class="space-y-3">
                            @foreach([
                                [15, 'School'],
                                [16, 'Sports centre'],
                                [17, 'Clinic'],
                                [18, 'Community centre'],
                                [19, 'Supermarket'],
                                [20, 'Playground'],
                            ] as [$num, $label])
                            <div class="flex items-center gap-4">
                                <span class="font-bold w-8">{{ $num }}</span>
                                <span class="w-40">{{ $label }}</span>
                                <select name="q{{ $num }}" class="border border-gray-300 rounded px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="" disabled selected>-</option>
                                    @foreach(['A','B','C','D','E','F','G','H','I'] as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                     <button @click="step = 1" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Previous Part
                    </button>
                    <button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Next Part
                    </button>
                </div>
            </div>

            {{-- PART 3 --}}
            <div x-show="step === 3" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
                    </div>

                    {{-- Questions 21–24: MCQ --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 21–24</p>
                        <p class="italic mb-4">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>

                        @foreach([
                            [21, 'Why do the students think the Laki eruption of 1783 is so important?', [
                                ['A', 'It was the most severe eruption in modern times.'],
                                ['B', 'It led to the formal study of volcanoes.'],
                                ['C', 'It had a profound effect on society.'],
                            ]],
                            [22, 'What surprised Adam about observations made at the time?', [
                                ['A', 'the number of places producing them'],
                                ['B', 'the contradictions in them'],
                                ['C', 'the lack of scientific data to support them'],
                            ]],
                            [23, 'According to Michelle, what did the contemporary sources say about the Laki haze?', [
                                ['A', 'People thought it was similar to ordinary fog.'],
                                ['B', 'It was associated with health issues.'],
                                ['C', 'It completely blocked out the sun for weeks.'],
                            ]],
                            [24, 'Adam corrects Michelle when she claims that Benjamin Franklin', [
                                ['A', 'came to the wrong conclusion about the cause of the haze.'],
                                ['B', 'was the first to identify the reason for the haze.'],
                                ['C', 'supported the opinions of other observers about the haze.'],
                            ]],
                        ] as [$num, $question, $options])
                        <div class="mb-6">
                            <p class="mb-3"><span class="font-bold">{{ $num }}</span> {{ $question }}</p>
                            <div class="space-y-2 ml-6">
                                @foreach($options as [$letter, $text])
                                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-1.5 rounded">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-4 h-4 text-purple-600">
                                    <span class="font-bold">{{ $letter }}</span>
                                    <span>{{ $text }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Questions 25–26: Choose TWO --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 25 and 26</p>
                        <p class="italic mb-1">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        <p class="mb-4">Which <strong>TWO</strong> issues following the Laki eruption surprised the students?</p>

                        <div class="space-y-2 ml-4" data-max-checks="2">
                            @foreach([
                                ['A', 'how widespread the effects were'],
                                ['B', 'how long-lasting the effects were'],
                                ['C', 'the number of deaths it caused'],
                                ['D', 'the speed at which the volcanic ash cloud spread'],
                                ['E', 'how people ignored the warning signs'],
                            ] as [$letter, $text])
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="q25_26[]" value="{{ $letter }}" class="w-4 h-4 text-purple-600 rounded checkbox-limit">
                                <span class="font-bold">{{ $letter }}</span>
                                <span>{{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 27–30: Matching --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Questions 27–30</p>
                        <p class="mb-2">What comment do the students make about the impact of the Laki eruption on the following countries?</p>
                        <p class="italic mb-4">Choose <span class="font-bold">FOUR</span> answers from the box and write the correct letter, <span class="font-bold">A–F</span>, next to Questions 27–30.</p>

                        <div class="border border-black p-5 mb-6">
                            <p class="font-bold text-center mb-3">Comments</p>
                            <div class="space-y-2 ml-4">
                                <p><span class="font-bold">A</span> &nbsp; This country suffered the most severe loss of life.</p>
                                <p><span class="font-bold">B</span> &nbsp; The impact on agriculture was predictable.</p>
                                <p><span class="font-bold">C</span> &nbsp; There was a significant increase in deaths of young people.</p>
                                <p><span class="font-bold">D</span> &nbsp; Animals suffered from a sickness.</p>
                                <p><span class="font-bold">E</span> &nbsp; This country saw the highest rise in food prices in the world.</p>
                                <p><span class="font-bold">F</span> &nbsp; It caused a particularly harsh winter.</p>
                            </div>
                        </div>

                        <p class="font-bold mb-3">Countries</p>
                        <div class="space-y-3">
                            @foreach([
                                [27, 'Iceland'],
                                [28, 'Egypt'],
                                [29, 'UK'],
                                [30, 'USA'],
                            ] as [$num, $country])
                            <div class="flex items-center gap-4">
                                <span class="font-bold w-8">{{ $num }}</span>
                                <span class="w-32">{{ $country }}</span>
                                <select name="q{{ $num }}" class="border border-gray-300 rounded px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="" disabled selected>-</option>
                                    @foreach(['A','B','C','D','E','F'] as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                     <button @click="step = 2" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Previous Part
                    </button>
                    <button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Next Part
                    </button>
                </div>
            </div>

            {{-- PART 4 --}}
            <div x-show="step === 4" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
                        <p class="italic mb-1">Complete the notes below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                    </div>

                    <div class="border border-black p-6">
                        <h2 class="text-2xl font-bold text-center mb-6">Pockets</h2>

                        <p class="font-bold mb-3">Reason for choice of subject</p>
                        <ul class="space-y-3 ml-4 list-disc mb-6">
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>They are</span>
                                <span class="font-bold">31</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>but can be overlooked by consumers and designers.</span>
                            </li>
                        </ul>

                        <p class="font-bold mb-3">Pockets in men's clothes</p>
                        <ul class="space-y-3 ml-4 list-disc mb-6">
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>Men started to wear</span>
                                <span class="font-bold">32</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>in the 18th century.</span>
                            </li>
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>A</span>
                                <span class="font-bold">33</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>sewed pockets into the lining of the garments.</span>
                            </li>
                            <li>The wearer could use the pockets for small items.</li>
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>Bigger pockets might be made for men who belonged to a certain type of</span>
                                <span class="font-bold">34</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>.</span>
                            </li>
                        </ul>

                        <p class="font-bold mb-3">Pockets in women's clothes</p>
                        <ul class="space-y-3 ml-4 list-disc">
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>Women's pockets were less</span>
                                <span class="font-bold">35</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>than men's.</span>
                            </li>
                            <li>Women were very concerned about pickpockets.</li>
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>Pockets were produced in pairs using</span>
                                <span class="font-bold">36</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>to link them together.</span>
                            </li>
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>Pockets hung from the women's</span>
                                <span class="font-bold">37</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>under skirts and petticoats.</span>
                            </li>
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>Items such as</span>
                                <span class="font-bold">38</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>could be reached through a gap in the material.</span>
                            </li>
                            <li>Pockets, of various sizes, stayed inside clothing for many decades.</li>
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>When dresses changed shape, hidden pockets had a negative effect on the</span>
                                <span class="font-bold">39</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>of women.</span>
                            </li>
                            <li class="flex items-center gap-2 flex-wrap">
                                <span>Bags called 'pouches' became popular, before women carried a</span>
                                <span class="font-bold">40</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>.</span>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                     <button @click="step = 3" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Previous Part
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Submit Answers
                    </button>
                </div>
            </div>

        </div>
    </main>
</div>

    {{-- Audio Player Partial --}}
    @include('assignments.ielts.listening.partials.audio-player', ['set' => 'Mock Up ' . $testId, 'section' => $material])

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Choose TWO checkbox limiter (FIFO)
            document.querySelectorAll('[data-max-checks]').forEach(group => {
                const max = parseInt(group.dataset.maxChecks);
                const checkboxes = group.querySelectorAll('input[type="checkbox"]');
                let checkedOrder = [];

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        if (this.checked) {
                            checkedOrder.push(this);
                            if (checkedOrder.length > max) {
                                const oldest = checkedOrder.shift();
                                oldest.checked = false;
                            }
                        } else {
                            checkedOrder = checkedOrder.filter(item => item !== this);
                        }
                    });
                });
            });

            // Audio player controls        });
    </script>
    <style>
        main { padding-bottom: 250px !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a0aec0; }
    </style>
</body>
</html>
