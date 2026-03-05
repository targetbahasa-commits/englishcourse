<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Up - {{ config('app.name', 'Target Bahasa') }}</title>
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
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 1]) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </a>
            </div>
        </div>

        <div x-data="{ step: 1 }">

            {{-- PART 1 --}}
            <div x-show="step === 1">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1–10</span></h3>
                    </div>

                    {{-- Questions 1–4 --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 1–4</p>
                        <p class="italic mb-1">Complete the form below.</p>
                        <p class="italic mb-4">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>

                        <div class="border border-black p-6">
                            <h2 class="text-xl font-bold text-center mb-2">Wayside Camera Club</h2>
                            <p class="text-center font-bold mb-6">membership form</p>

                            <table class="w-full">
                                <tbody>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 pr-4 font-medium w-1/3">Name:</td>
                                        <td class="py-2">Dan Green</td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 pr-4 font-medium">Email address:</td>
                                        <td class="py-2">dan1068@market.com</td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 pr-4 font-medium">Home address:</td>
                                        <td class="py-2 flex items-center gap-1 flex-wrap">
                                            <span>52</span>
                                            <span class="font-bold">1</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                            <span>Street, Peacetown</span>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 pr-4 font-medium">Heard about us:</td>
                                        <td class="py-2 flex items-center gap-1 flex-wrap">
                                            <span>from a</span>
                                            <span class="font-bold">2</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 pr-4 font-medium">Reasons for joining:</td>
                                        <td class="py-2">
                                            <div>to enter competitions</div>
                                            <div class="flex items-center gap-1 flex-wrap mt-1">
                                                <span>to</span>
                                                <span class="font-bold">3</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4 font-medium">Type of membership:</td>
                                        <td class="py-2 flex items-center gap-1 flex-wrap">
                                            <span class="font-bold">4</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                            <span>membership (£30)</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Questions 5–10 --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Questions 5–10</p>
                        <p class="italic mb-1">Complete the table below.</p>
                        <p class="italic mb-4">Write <span class="font-bold">NO MORE THAN TWO WORDS</span> for each answer.</p>

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-400">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="border border-gray-400 p-3 text-center font-bold bg-gray-100">Photography competitions</th>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-400 p-3 text-left font-bold">Title of competition</th>
                                        <th class="border border-gray-400 p-3 text-left font-bold">Instructions</th>
                                        <th class="border border-gray-400 p-3 text-left font-bold">Feedback to Dan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-400 p-3">
                                            <div class="flex items-center gap-1 flex-wrap">
                                                <span class="font-bold">5</span>
                                                <span>'</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                                <span>'</span>
                                            </div>
                                        </td>
                                        <td class="border border-gray-400 p-3">A scene in the home</td>
                                        <td class="border border-gray-400 p-3">The picture's composition was not good.</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-3">'Beautiful Sunsets'</td>
                                        <td class="border border-gray-400 p-3">
                                            <div class="flex items-center gap-1 flex-wrap">
                                                <span>Scene must show some</span>
                                                <span class="font-bold">6</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-28 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                            </div>
                                        </td>
                                        <td class="border border-gray-400 p-3">
                                            <div class="flex items-center gap-1 flex-wrap">
                                                <span>The</span>
                                                <span class="font-bold">7</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-28 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                                <span>was wrong.</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-3">
                                            <div class="flex items-center gap-1 flex-wrap">
                                                <span class="font-bold">8</span>
                                                <span>'</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                                <span>'</span>
                                            </div>
                                        </td>
                                        <td class="border border-gray-400 p-3">
                                            <div class="flex items-center gap-1 flex-wrap">
                                                <span>Scene must show</span>
                                                <span class="font-bold">9</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-28 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                            </div>
                                        </td>
                                        <td class="border border-gray-400 p-3">
                                            <div class="flex items-center gap-1 flex-wrap">
                                                <span>The photograph was too</span>
                                                <span class="font-bold">10</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-28 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                                <span>.</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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

                    {{-- Questions 11 and 12 --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 11 and 12</p>
                        <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        <p class="mb-4">Which <strong>TWO</strong> warnings does Dan give about picking mushrooms?</p>

                        <div class="space-y-3 ml-4" data-max-checks="2">
                            @foreach([
                                ['A', "Don't pick more than one variety of mushroom at a time."],
                                ['B', "Don't pick mushrooms near busy roads."],
                                ['C', "Don't eat mushrooms given to you."],
                                ['D', "Don't eat mushrooms while picking them."],
                                ['E', "Don't pick old mushrooms."],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="q11_12[]" value="{{ $letter }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span><strong>{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 13 and 14 --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 13 and 14</p>
                        <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        <p class="mb-4">Which <strong>TWO</strong> ideas about wild mushrooms does Dan say are correct?</p>

                        <div class="space-y-3 ml-4" data-max-checks="2">
                            @foreach([
                                ['A', 'Mushrooms should always be peeled before eating.'],
                                ['B', 'Mushrooms eaten by animals may be unsafe.'],
                                ['C', 'Cooking destroys toxins in mushrooms.'],
                                ['D', 'Brightly coloured mushrooms can be edible.'],
                                ['E', 'All poisonous mushrooms have a bad smell.'],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="q13_14[]" value="{{ $letter }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span><strong>{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 15–20 --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Questions 15–20</p>
                        <p class="italic mb-4">Choose the correct letter, <span class="font-bold">A, B or C</span>.</p>

                        @foreach([
                            [15, 'What advice does Dan give about picking mushrooms in parks?', ['A' => 'Choose wooded areas.', 'B' => "Don't disturb wildlife.", 'C' => 'Get there early.']],
                            [16, 'Dan says it is a good idea for beginners to', ['A' => 'use a mushroom app.', 'B' => 'join a group.', 'C' => 'take a reference book.']],
                            [17, 'What does Dan say is important for conservation?', ['A' => 'selecting only fully grown mushrooms', 'B' => 'picking a limited amount of mushrooms', 'C' => 'avoiding areas where rare mushroom species grow']],
                            [18, 'According to Dan, some varieties of wild mushrooms are in decline because there is', ['A' => 'a huge demand for them from restaurants.', 'B' => 'a lack of rain in this part of the country.', 'C' => 'a rise in building developments locally.']],
                            [19, 'Dan says that when storing mushrooms, people should', ['A' => 'keep them in the fridge for no more than two days.', 'B' => 'keep them in a brown bag in a dark room.', 'C' => 'leave them for a period after washing them.']],
                            [20, 'What does Dan say about trying new varieties of mushrooms?', ['A' => 'Experiment with different recipes.', 'B' => 'Expect some to have a strong taste.', 'C' => 'Cook them for a long time.']],
                        ] as [$num, $question, $options])
                        <div class="mb-6 p-4 {{ $loop->even ? 'bg-gray-50' : '' }} rounded-lg">
                            <p class="mb-3"><strong>{{ $num }}</strong> {{ $question }}</p>
                            <div class="space-y-2 ml-6">
                                @foreach($options as $letter => $text)
                                <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-100 p-1.5 rounded">
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

                    {{-- Questions 21 and 22 --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 21 and 22</p>
                        <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        <p class="mb-4">Which <strong>TWO</strong> opinions about the Luddites do the students express?</p>

                        <div class="space-y-3 ml-4" data-max-checks="2">
                            @foreach([
                                ['A', 'Their actions were ineffective.'],
                                ['B', 'They are still influential today.'],
                                ['C', 'They have received unfair criticism.'],
                                ['D', 'They were proved right.'],
                                ['E', 'Their attitude is understandable.'],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="q21_22[]" value="{{ $letter }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span><strong>{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 23 and 24 --}}
                    <div class="mb-8">
                        <p class="italic mb-1">Questions 23 and 24</p>
                        <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        <p class="mb-4">Which <strong>TWO</strong> predictions about the future of work are the students doubtful about?</p>

                        <div class="space-y-3 ml-4" data-max-checks="2">
                            @foreach([
                                ['A', 'Work will be more rewarding.'],
                                ['B', 'Unemployment will fall.'],
                                ['C', 'People will want to delay retiring.'],
                                ['D', 'Working hours will be shorter.'],
                                ['E', 'People will change jobs more frequently.'],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="q23_24[]" value="{{ $letter }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span><strong>{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 25–30: Matching --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Questions 25–30</p>
                        <p class="mb-1">What comment do the students make about each of the following jobs?</p>
                        <p class="italic mb-4">Choose <span class="font-bold">SIX</span> answers from the box and write the correct letter, <span class="font-bold">A–G</span>, next to Questions 25–30.</p>

                        <div class="border border-gray-400 p-5 mb-6 bg-gray-50">
                            <p class="text-center font-bold mb-4">Comments</p>
                            <div class="space-y-2">
                                @foreach([
                                    ['A', 'These jobs are likely to be at risk.'],
                                    ['B', 'Their role has become more interesting in recent years.'],
                                    ['C', 'The number of people working in this sector has fallen dramatically.'],
                                    ['D', 'This job will require more qualifications.'],
                                    ['E', 'Higher disposable income has led to a huge increase in jobs.'],
                                    ['F', 'There is likely to be a significant rise in demand for this service.'],
                                    ['G', 'Both employment and productivity have risen.'],
                                ] as [$letter, $text])
                                <div><strong>{{ $letter }}</strong> {{ $text }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-4">
                            <p class="font-bold">Jobs</p>
                            @foreach([
                                [25, 'Accountants'],
                                [26, 'Hairdressers'],
                                [27, 'Administrative staff'],
                                [28, 'Agricultural workers'],
                                [29, 'Care workers'],
                                [30, 'Bank clerks'],
                            ] as [$num, $job])
                            <div class="flex items-center gap-4 py-2 {{ $loop->even ? 'bg-gray-50' : '' }} px-3 rounded">
                                <span class="font-bold w-8">{{ $num }}</span>
                                <span class="w-48">{{ $job }}</span>
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

                    {{-- Questions 31–40 --}}
                    <div class="mb-6">
                        <p class="italic mb-1">Complete the notes below.</p>
                        <p class="italic mb-4">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>

                        <div class="border border-black p-6">
                            <h2 class="text-2xl font-bold text-center mb-6">Space Traffic Management</h2>

                            <p class="font-bold mb-3">A Space Traffic Management system</p>
                            <ul class="space-y-3 ml-4 list-disc">
                                <li>is a concept similar to Air Traffic Control, but for satellites rather than planes.</li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>would aim to set up legal and</span>
                                    <span class="font-bold">31</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>ways of improving safety.</span>
                                </li>
                                <li>does not actually exist at present.</li>
                            </ul>

                            <p class="font-bold mb-3 mt-6">Problems in developing effective Space Traffic Management</p>
                            <ul class="space-y-3 ml-4 list-disc">
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>Satellites are now quite</span>
                                    <span class="font-bold">32</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>and therefore more widespread (e.g. there are constellations made up of</span>
                                    <span class="font-bold">33</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>of satellites).</span>
                                </li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>At present, satellites are not required to transmit information to help with their</span>
                                    <span class="font-bold">34</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>.</span>
                                </li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>There are few systems for</span>
                                    <span class="font-bold">35</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>satellites.</span>
                                </li>
                                <li>Small pieces of debris may be difficult to identify.</li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>Operators may be unwilling to share details of satellites used for</span>
                                    <span class="font-bold">36</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>or commercial reasons.</span>
                                </li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>It may be hard to collect details of the object's</span>
                                    <span class="font-bold">37</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>at a given time.</span>
                                </li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>Scientists can only make a</span>
                                    <span class="font-bold">38</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>about where the satellite will go.</span>
                                </li>
                            </ul>

                            <p class="font-bold mb-3 mt-6">Solutions</p>
                            <ul class="space-y-3 ml-4 list-disc">
                                <li>Common standards should be agreed on for the presentation of information.</li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>The information should be combined in one</span>
                                    <span class="font-bold">39</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>.</span>
                                </li>
                                <li class="flex items-center gap-2 flex-wrap">
                                    <span>A coordinated system must be designed to create</span>
                                    <span class="font-bold">40</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>in its users.</span>
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

    {{-- Admin Upload Modals --}}
    @if(Auth::check() && Auth::user()->isAdmin())
        {{-- Upload SRT Modal --}}
        <div id="uploadSrtModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4 transition-opacity" onclick="if(event.target === this) this.classList.add('hidden')">
            <div class="bg-white rounded-xl shadow-2xl p-6 md:p-8 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900">Upload SRT Transcript</h3>
                    <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-srt', ['edition' => $edition, 'id' => $testId]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="language" value="en" class="text-indigo-600 focus:ring-indigo-500" checked>
                                <span class="text-gray-700">English 🇺🇸</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="language" value="id" class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-gray-700">Indonesian 🇮🇩</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">SRT File (.srt - Max 2MB)</label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-indigo-500 transition-colors text-center cursor-pointer" onclick="document.getElementById('srtFileInput').click()">
                            <input type="file" id="srtFileInput" name="srt_file" accept=".srt" class="hidden" onchange="document.getElementById('srtFileName').textContent = this.files[0] ? this.files[0].name : 'Click to select file'">
                            <svg class="w-8 h-8 md:w-10 md:h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-sm text-gray-500" id="srtFileName">Click to select file</span>
                        </div>
                    </div>
                    <div class="relative py-2 hidden md:block">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                        <div class="relative flex justify-center"><span class="px-2 bg-white text-xs text-gray-500 font-semibold uppercase">Or Paste Text</span></div>
                    </div>
                    <div class="hidden md:block">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Paste SRT Content</label>
                        <textarea name="srt_content" rows="3" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none placeholder-gray-400 text-sm font-mono" placeholder="1
00:00:10,000 --> 00:00:15,000
Start translating here..."></textarea>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors shadow-sm">Upload & Parse</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Upload Audio Modal --}}
        <div id="uploadAudioModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4 transition-opacity" onclick="if(event.target === this) this.classList.add('hidden')">
            <div class="bg-white rounded-xl shadow-2xl p-6 md:p-8 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900">Upload Audio File</h3>
                    <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-audio', ['edition' => $edition, 'id' => $testId]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Audio File (MP3, WAV, OGG - Max 50MB)</label>
                        <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,audio/*" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>
                    @if(isset($material) && $material->audio_file)
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-sm text-blue-800 break-all"><span class="font-semibold">Current file:</span> {{ basename($material->audio_file) }}</p>
                        </div>
                    @endif
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">Upload</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Upload Answer Key Modal --}}
        <div id="uploadAnswerKeyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4 transition-opacity" onclick="if(event.target === this) this.classList.add('hidden')">
            <div class="bg-white rounded-xl shadow-2xl p-6 md:p-8 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900">Upload Answer Key</h3>
                    <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-answer-key', ['edition' => $edition, 'id' => $testId]) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Answer Key Content</label>
                        <textarea name="answer_key" rows="6" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-teal-500 focus:outline-none placeholder-gray-400 text-sm font-mono" placeholder="1. A
2. B..."></textarea>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors shadow-sm">Save Key</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

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

            // Audio player controls
            const audio = document.getElementById('mainAudio');
            const playIcon = document.getElementById('playIcon');
            const pauseIcon = document.getElementById('pauseIcon');
            const progressBar = document.getElementById('progressBar');
            const progressHandle = document.getElementById('progressHandle');
            const progressContainer = document.getElementById('progressContainer');
            const currentTimeDisplay = document.getElementById('currentTime');
            const durationDisplay = document.getElementById('duration');

            if (!audio || !progressContainer) return;

            let isDragging = false;

            function formatTime(seconds) {
                if (isNaN(seconds)) return '0:00';
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${mins}:${secs.toString().padStart(2, '0')}`;
            }

            window.togglePlayPause = function() {
                if (audio.paused) {
                    audio.play();
                    playIcon.classList.add('hidden');
                    pauseIcon.classList.remove('hidden');
                } else {
                    audio.pause();
                    playIcon.classList.remove('hidden');
                    pauseIcon.classList.add('hidden');
                }
            };

            window.skipAudio = function(seconds) {
                if (audio && audio.duration) {
                    audio.currentTime = Math.max(0, Math.min(audio.duration, audio.currentTime + seconds));
                }
            };

            function seekAudio(event) {
                if (!audio.duration) return;
                const rect = progressContainer.getBoundingClientRect();
                const clientX = event.clientX || (event.touches ? event.touches[0].clientX : 0);
                const percentage = Math.max(0, Math.min(1, (clientX - rect.left) / rect.width));
                audio.currentTime = percentage * audio.duration;
            }

            progressContainer.addEventListener('mousedown', (e) => { isDragging = true; seekAudio(e); e.preventDefault(); });
            document.addEventListener('mousemove', (e) => { if (isDragging) seekAudio(e); });
            document.addEventListener('mouseup', () => { isDragging = false; });
            
            progressContainer.addEventListener('touchstart', (e) => { isDragging = true; seekAudio(e.touches[0]); e.preventDefault(); });
            document.addEventListener('touchmove', (e) => { if (isDragging) seekAudio(e.touches[0]); });
            document.addEventListener('touchend', () => { isDragging = false; });

            audio.addEventListener('timeupdate', () => {
                if (audio.duration && !isDragging) {
                    const percentage = (audio.currentTime / audio.duration) * 100;
                    progressBar.style.width = percentage + '%';
                    progressHandle.style.left = percentage + '%';
                    currentTimeDisplay.textContent = formatTime(audio.currentTime);
                }
            });

            audio.addEventListener('loadedmetadata', () => { durationDisplay.textContent = formatTime(audio.duration); });
            audio.addEventListener('ended', () => { playIcon.classList.remove('hidden'); pauseIcon.classList.add('hidden'); });
            
            window.toggleTranscriptDrawer = function() {
                const transcriptDrawer = document.getElementById('transcriptDrawer');
                if (transcriptDrawer) transcriptDrawer.classList.toggle('hidden');
            };
        });
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
