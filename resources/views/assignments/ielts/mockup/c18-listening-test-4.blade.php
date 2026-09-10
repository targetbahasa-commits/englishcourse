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
<body class="font-sans antialiased bg-white">
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
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 1]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-white border border-gray-200 transition-all font-medium text-sm shadow-sm group">
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

                    {{-- Questions 1–10: Note completion --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Complete the notes below.</p>
                        <p class="italic mb-4">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>

                        <div class="border border-black p-6">
                            <h2 class="text-xl font-bold text-center mb-6">Job details from employment agency</h2>

                            {{-- Role --}}
                            <div class="mb-4">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold w-24">Role</span>
                                    <span class="font-bold">1</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-44 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                </div>
                            </div>

                            {{-- Location --}}
                            <div class="mb-5">
                                <div class="flex items-center gap-2 flex-wrap mb-2">
                                    <span class="font-bold w-24">Location</span>
                                    <span>Fordham</span>
                                    <span class="font-bold">2</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>Centre</span>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap ml-28">
                                    <span class="font-bold">3</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>Road, Fordham</span>
                                </div>
                            </div>

                            {{-- Work involves --}}
                            <div class="mb-5">
                                <p class="font-bold mb-2">Work involves</p>
                                <ul class="space-y-3 ml-6 list-disc">
                                    <li>dealing with enquiries</li>
                                    <li class="flex items-center gap-1 flex-wrap">
                                        <span>making</span>
                                        <span class="font-bold">4</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                        <span>and reorganising them</span>
                                    </li>
                                    <li class="flex items-center gap-1 flex-wrap">
                                        <span>maintaining the internal</span>
                                        <span class="font-bold">5</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    </li>
                                    <li>general administration</li>
                                </ul>
                            </div>

                            {{-- Requirements --}}
                            <div class="mb-5">
                                <p class="font-bold mb-2">Requirements</p>
                                <ul class="space-y-3 ml-6 list-disc">
                                    <li class="flex items-center gap-1 flex-wrap">
                                        <span class="font-bold">6</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                        <span>(essential)</span>
                                    </li>
                                    <li class="flex items-center gap-1 flex-wrap">
                                        <span>a calm and</span>
                                        <span class="font-bold">7</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                        <span>manner</span>
                                    </li>
                                    <li>good IT skills</li>
                                </ul>
                            </div>

                            {{-- Other information --}}
                            <div>
                                <p class="font-bold mb-2">Other information</p>
                                <ul class="space-y-3 ml-6 list-disc">
                                    <li class="flex items-center gap-1 flex-wrap">
                                        <span>a</span>
                                        <span class="font-bold">8</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                        <span>job – further opportunities may be available</span>
                                    </li>
                                    <li class="flex items-center gap-1 flex-wrap">
                                        <span>hours: 7.45 a.m. to</span>
                                        <span class="font-bold">9</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-28 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                        <span>p.m. Monday to Friday</span>
                                    </li>
                                    <li class="flex items-center gap-1 flex-wrap">
                                        <span class="font-bold">10</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                        <span>is available onsite</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-end">
                    <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Next Part →
                    </button>
                </div>
            </div>

            {{-- PART 2 --}}
            <div x-show="step === 2" style="display:none">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
                    </div>

                    {{-- Questions 11–14: MCQ --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 11–14</p>
                        <p class="italic mb-4">Choose the correct letter, <span class="font-bold">A, B or C</span>.</p>

                        @foreach([
                            [11, 'The museum building was originally', ['A' => 'a factory.', 'B' => 'a private home.', 'C' => 'a hall of residence.']],
                            [12, 'The university uses part of the museum building as', ['A' => 'teaching rooms.', 'B' => 'a research library.', 'C' => 'administration offices.']],
                            [13, 'What does the guide say about the entrance fee?', ['A' => 'Visitors decide whether or not they wish to pay.', 'B' => 'Only children and students receive a discount.', 'C' => 'The museum charges extra for special exhibitions.']],
                            [14, 'What are visitors advised to leave in the cloakroom?', ['A' => 'cameras', 'B' => 'coats', 'C' => 'bags']],
                        ] as [$num, $question, $options])
                        <div class="mb-6 p-4 {{ $loop->even ? 'bg-white' : '' }} rounded-lg">
                            <p class="mb-3"><strong>{{ $num }}</strong> {{ $question }}</p>
                            <div class="space-y-2 ml-6">
                                @foreach($options as $letter => $text)
                                <label class="flex items-start gap-3 cursor-pointer hover:bg-white p-1.5 rounded">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span><strong>{{ $letter }}</strong> {{ $text }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Questions 15–20: Matching --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Questions 15–20</p>
                        <p class="mb-1">What information does the speaker give about each of the following areas of the museum?</p>
                        <p class="italic mb-4">Choose <span class="font-bold">SIX</span> answers from the box and write the correct letter, <span class="font-bold">A–H</span>, next to Questions 15–20.</p>

                        <div class="border border-gray-400 p-5 mb-6 bg-white">
                            <p class="text-center font-bold mb-4">Information</p>
                            <div class="space-y-2">
                                @foreach([
                                    ['A', 'Parents must supervise their children.'],
                                    ['B', 'There are new things to see.'],
                                    ['C', 'It is closed today.'],
                                    ['D', 'This is only for school groups.'],
                                    ['E', 'There is a quiz for visitors.'],
                                    ['F', 'It features something created by students.'],
                                    ['G', 'An expert is here today.'],
                                    ['H', 'There is a one-way system.'],
                                ] as [$letter, $text])
                                <div><strong>{{ $letter }}</strong> {{ $text }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-4">
                            <p class="font-bold">Areas of museum</p>
                            @foreach([
                                [15, 'Four Seasons'],
                                [16, 'Farmhouse Kitchen'],
                                [17, 'A Year on the Farm'],
                                [18, 'Wagon Walk'],
                                [19, 'Bees are Magic'],
                                [20, 'The Pond'],
                            ] as [$num, $area])
                            <div class="flex items-center gap-4 py-2 {{ $loop->even ? 'bg-white' : '' }} px-3 rounded">
                                <span class="font-bold w-8">{{ $num }}</span>
                                <span class="w-48">{{ $area }}</span>
                                <select name="q{{ $num }}" class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer w-16">
                                    <option value="" disabled selected>–</option>
                                    <option value="A">A</option><option value="B">B</option><option value="C">C</option>
                                    <option value="D">D</option><option value="E">E</option><option value="F">F</option>
                                    <option value="G">G</option><option value="H">H</option>
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
                        Next Part →
                    </button>
                </div>
            </div>

            {{-- PART 3 --}}
            <div x-show="step === 3" style="display:none">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
                    </div>

                    {{-- Questions 21 and 22: Choose TWO --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 21 and 22</p>
                        <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        <p class="mb-4">Which <strong>TWO</strong> educational skills were shown in the video of children doing origami?</p>

                        <div class="space-y-3 ml-4" data-max-checks="2">
                            @foreach([
                                ['A', 'solving problems'],
                                ['B', 'following instructions'],
                                ['C', 'working cooperatively'],
                                ['D', 'learning through play'],
                                ['E', 'developing hand-eye coordination'],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-white p-2 rounded">
                                <input type="checkbox" name="q21_22[]" value="{{ $letter }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span><strong>{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 23–27: Matching children with comments --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 23–27</p>
                        <p class="mb-1">Which comment do the students make about each of the following children in the video?</p>
                        <p class="italic mb-4">Choose <span class="font-bold">FIVE</span> answers from the box and write the correct letter, <span class="font-bold">A–G</span>, next to Questions 23–27.</p>

                        <div class="border border-gray-400 p-5 mb-6 bg-white">
                            <p class="text-center font-bold mb-4">Comments</p>
                            <div class="space-y-2">
                                @foreach([
                                    ['A', 'demonstrated independence'],
                                    ['B', 'asked for teacher support'],
                                    ['C', 'developed a competitive attitude'],
                                    ['D', 'seemed to find the activity calming'],
                                    ['E', 'seemed pleased with the results'],
                                    ['F', 'seemed confused'],
                                    ['G', 'seemed to find the activity easy'],
                                ] as [$letter, $text])
                                <div><strong>{{ $letter }}</strong> {{ $text }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-4">
                            <p class="font-bold">Children</p>
                            @foreach([
                                [23, 'Sid'],
                                [24, 'Jack'],
                                [25, 'Naomi'],
                                [26, 'Anya'],
                                [27, 'Zara'],
                            ] as [$num, $child])
                            <div class="flex items-center gap-4 py-2 {{ $loop->even ? 'bg-white' : '' }} px-3 rounded">
                                <span class="font-bold w-8">{{ $num }}</span>
                                <span class="w-48">{{ $child }}</span>
                                <select name="q{{ $num }}" class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer w-16">
                                    <option value="" disabled selected>–</option>
                                    <option value="A">A</option><option value="B">B</option><option value="C">C</option>
                                    <option value="D">D</option><option value="E">E</option><option value="F">F</option>
                                    <option value="G">G</option>
                                </select>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 28–30: MCQ --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Questions 28–30</p>
                        <p class="italic mb-4">Choose the correct letter, <span class="font-bold">A, B or C</span>.</p>

                        @foreach([
                            [28, 'Before starting an origami activity in class, the students think it is important for the teacher to', ['A' => 'make models that demonstrate the different stages.', 'B' => 'check children understand the terminology involved.', 'C' => 'tell children not to worry if they find the activity difficult.']],
                            [29, 'The students agree that some teachers might be unwilling to use origami in class because', ['A' => 'they may not think that crafts are important.', 'B' => 'they may not have the necessary skills.', 'C' => 'they may worry that it will take up too much time.']],
                            [30, 'Why do the students decide to use origami in their maths teaching practice?', ['A' => 'to correct a particular misunderstanding', 'B' => 'to set a challenge', 'C' => 'to introduce a new concept']],
                        ] as [$num, $question, $options])
                        <div class="mb-6 p-4 {{ $loop->even ? 'bg-white' : '' }} rounded-lg">
                            <p class="mb-3"><strong>{{ $num }}</strong> {{ $question }}</p>
                            <div class="space-y-2 ml-6">
                                @foreach($options as $letter => $text)
                                <label class="flex items-start gap-3 cursor-pointer hover:bg-white p-1.5 rounded">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span><strong>{{ $letter }}</strong> {{ $text }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 2" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Previous Part
                    </button>
                    <button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Next Part →
                    </button>
                </div>
            </div>

            {{-- PART 4 --}}
            <div x-show="step === 4" style="display:none">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
                    </div>

                    <div class="mb-6">
                        <p class="italic mb-1">Complete the notes below.</p>
                        <p class="italic mb-4">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>

                        <div class="border border-black p-6">
                            <h2 class="text-2xl font-bold text-center mb-6">Victor Hugo</h2>

                            {{-- His novel, Les Misérables --}}
                            <p class="font-bold mb-3">His novel, <em>Les Misérables</em></p>
                            <ul class="space-y-3 ml-6 list-disc mb-6">
                                <li>It has been adapted for theatre and cinema.</li>
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>We know more about its overall</span>
                                    <span class="font-bold">31</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>than about its author.</span>
                                </li>
                            </ul>

                            {{-- His early career --}}
                            <p class="font-bold mb-3">His early career</p>
                            <ul class="space-y-3 ml-6 list-disc mb-6">
                                <li>In Paris, his career was successful and he led the Romantic movement.</li>
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>He spoke publicly about social issues, such as</span>
                                    <span class="font-bold">32</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>and education.</span>
                                </li>
                                <li>Napoleon III disliked his views and exiled him.</li>
                            </ul>

                            {{-- His exile from France --}}
                            <p class="font-bold mb-3">His exile from France</p>
                            <ul class="space-y-3 ml-6 list-disc mb-6">
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>Victor Hugo had to live elsewhere in</span>
                                    <span class="font-bold">33</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>.</span>
                                </li>
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>He used his income from the sale of some</span>
                                    <span class="font-bold">34</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>he had written to buy a house on Guernsey.</span>
                                </li>
                            </ul>

                            {{-- His house on Guernsey --}}
                            <p class="font-bold mb-3">His house on Guernsey</p>
                            <ul class="space-y-3 ml-6 list-disc">
                                <li>Victor Hugo lived in this house until the end of the Empire in France.</li>
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>The ground floor contains portraits,</span>
                                    <span class="font-bold">35</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>and tapestries that he valued.</span>
                                </li>
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>He bought cheap</span>
                                    <span class="font-bold">36</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>made of wood and turned this into beautiful wall carvings.</span>
                                </li>
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>The first floor consists of furnished areas with wallpaper and</span>
                                    <span class="font-bold">37</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>that have a Chinese design.</span>
                                </li>
                                <li>The library still contains many of his favourite books.</li>
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>He wrote in a room at the top of the house that had a view of the</span>
                                    <span class="font-bold">38</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>.</span>
                                </li>
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>He entertained other writers as well as poor</span>
                                    <span class="font-bold">39</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>in his house.</span>
                                </li>
                                <li class="flex items-center gap-1 flex-wrap">
                                    <span>Victor Hugo's</span>
                                    <span class="font-bold">40</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>gave ownership of the house to the city of Paris in 1927.</span>
                                </li>
                            </ul>
                        </div>
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
