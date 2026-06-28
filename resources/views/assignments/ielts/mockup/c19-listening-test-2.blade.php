<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Up - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        <div x-data="{ step: 1 }" x-init="$watch('step', value => $dispatch('part-changed', value))">

            {{-- PART 1 --}}
            <div x-show="step === 1">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1–10</span></h3>
                        <h4 class="font-bold text-md mb-2">Questions 1–6</h4>
                        <p class="italic mb-2">Complete the form below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>
                    </div>
                    
                    <div class="border border-black p-6 mb-8">
                        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Guitar Group</h2>
                        <div class="space-y-4 px-4 md:px-12">
                            <div class="flex flex-col md:flex-row md:items-center gap-2">
                                <span class="md:w-1/3 text-gray-800">Coordinator:</span>
                                <div class="flex-1 flex flex-wrap items-center gap-2">
                                    <span>Gary <span class="font-bold">1</span></span>
                                    <input type="text" name="q1" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center gap-2">
                                <span class="md:w-1/3 text-gray-800">Level:</span>
                                <div class="flex-1 flex flex-wrap items-center gap-2">
                                    <span class="font-bold">2</span>
                                    <input type="text" name="q2" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row gap-2">
                                <span class="md:w-1/3 text-gray-800 mt-1">Place:</span>
                                <div class="flex-1 space-y-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span>the <span class="font-bold">3</span></span>
                                        <input type="text" name="q3" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-bold">4</span>
                                        <input type="text" name="q4" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        <span>Street</span>
                                    </div>
                                    <div class="text-gray-800">First floor, Room T347</div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center gap-2">
                                <span class="md:w-1/3 text-gray-800">Time:</span>
                                <div class="flex-1 flex flex-wrap items-center gap-2">
                                    <span>Thursday morning at <span class="font-bold">5</span></span>
                                    <input type="text" name="q5" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center gap-2">
                                <span class="md:w-1/3 text-gray-800">Recommended website:</span>
                                <div class="flex-1 flex flex-wrap items-center gap-2">
                                    <span>'The perfect <span class="font-bold">6</span></span>
                                    <input type="text" name="q6" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    <span>'</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold text-md mb-2">Questions 7–10</h4>
                        <p class="italic mb-2">Complete the table below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                    </div>

                    <div class="border border-black">
                        <h3 class="text-xl font-bold text-center py-4 bg-gray-100 border-b border-black text-gray-700">A typical 45-minute guitar lesson</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr>
                                        <th class="border-b border-r border-black font-bold p-3 w-1/4 text-center">Time</th>
                                        <th class="border-b border-r border-black font-bold p-3 w-2/5 text-center">Activity</th>
                                        <th class="border-b border-black font-bold p-3 w-auto text-center">Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border-b border-r border-black p-3 text-center align-top">5 minutes</td>
                                        <td class="border-b border-r border-black p-3 align-top">tuning guitars</td>
                                        <td class="border-b border-black p-3 align-top">
                                            using an app or by<br>
                                            <span class="font-bold mr-1">7</span>
                                            <input type="text" name="q7" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-b border-r border-black p-3 text-center align-top">10 minutes</td>
                                        <td class="border-b border-r border-black p-3 align-top">strumming chords using our thumbs</td>
                                        <td class="border-b border-black p-3 align-top">
                                            keeping time while the teacher is<br>
                                            <span class="font-bold mr-1">8</span>
                                            <input type="text" name="q8" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-b border-r border-black p-3 text-center align-top">15 minutes</td>
                                        <td class="border-b border-r border-black p-3 align-top">playing songs</td>
                                        <td class="border-b border-black p-3 align-top">
                                            often listening to a<br>
                                            <span class="font-bold mr-1">9</span>
                                            <input type="text" name="q9" class="border-b border-black outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                            of a song
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-b border-r border-black p-3 text-center align-top">10 minutes</td>
                                        <td class="border-b border-r border-black p-3 align-top">playing single notes and simple tunes</td>
                                        <td class="border-b border-black p-3 align-top">
                                            playing together, then<br>
                                            <span class="font-bold mr-1">10</span>
                                            <input type="text" name="q10" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-r border-black p-3 text-center align-top">5 minutes</td>
                                        <td class="border-r border-black p-3 align-top">noting things to practise at home</td>
                                        <td class="p-3 align-top"></td>
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
                        <h4 class="font-bold text-md mb-2">Questions 11–16</h4>
                        <p class="italic">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                    </div>
                    <h2 class="text-xl font-bold text-center mb-6 text-gray-800">Working as a lifeboat volunteer</h2>
                    <div class="pl-4 space-y-6">
                        @foreach([
                            [11, 'What made David leave London and move to Northsea?', ['He was eager to develop a hobby.', 'He wanted to work shorter hours.', 'He found his job in website design unsatisfying.']],
                            [12, 'The Lifeboat Institution in Northsea was built with money provided by', ['a local organisation.', 'a local resident.', 'the local council.']],
                            [13, 'In his health assessment, the doctor was concerned about the fact that David', ['might be colour blind.', 'was rather short-sighted.', 'had undergone eye surgery.']],
                            [14, 'After arriving at the lifeboat station, they aim to launch the boat within', ['five minutes.', 'six to eight minutes.', 'eight and a half minutes.']],
                            [15, 'As a \'helmsman\', David has the responsibility of deciding', ['who will be the members of his crew.', 'what equipment it will be necessary to take.', 'if the lifeboat should be launched.']],
                            [16, 'As well as going out on the lifeboat, David', ['gives talks on safety at sea.', 'helps with fundraising.', 'recruits new volunteers.']],
                        ] as [$num, $question, $options])
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">{{ $num }}</span> {{ $question }}</p>
                            <div class="space-y-2 ml-8">
                                @foreach(['A', 'B', 'C'] as $i => $letter)
                                <label class="flex items-start gap-3 cursor-pointer group mb-1">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-5 h-5 text-blue-600 mt-0.5">
                                    <span class="font-bold w-4 mt-0.5">{{ $letter }}</span>
                                    <span class="group-hover:text-blue-600 transition">{{ $options[$i] }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="pt-4" x-data="{ selected17_18: [] }" x-effect="if (selected17_18.length > 2) selected17_18.shift()">
                            <h4 class="font-bold text-md mb-2">Questions 17 and 18</h4>
                            <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                            
                            <p class="font-semibold mb-4">Which <span class="font-bold">TWO</span> things does David say about the lifeboat volunteer training?</p>
                            
                            <div class="space-y-2 ml-4">
                                @foreach([
                                    'A' => 'The residential course developed his leadership skills.',
                                    'B' => 'The training in use of ropes and knots was quite brief.',
                                    'C' => 'The training exercises have built up his mental strength.',
                                    'D' => 'The casualty care activities were particularly challenging for him.',
                                    'E' => 'The wave tank activities provided practice in survival techniques.'
                                ] as $letter => $option)
                                <label class="flex items-start gap-3 cursor-pointer group mb-2">
                                    <input type="checkbox" name="q17_18[]" value="{{ $letter }}" x-model="selected17_18" class="w-5 h-5 mt-1 text-blue-600 rounded border-gray-300">
                                    <span class="font-bold w-4 mt-0.5">{{ $letter }}</span>
                                    <span class="group-hover:text-blue-600 transition">{{ $option }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6 mt-6" x-data="{ selected19_20: [] }" x-effect="if (selected19_20.length > 2) selected19_20.shift()">
                            <h4 class="font-bold text-md mb-2">Questions 19 and 20</h4>
                            <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                            
                            <p class="font-semibold mb-4">Which <span class="font-bold">TWO</span> things does David find most motivating about the work he does?</p>
                            
                            <div class="space-y-2 ml-4">
                                @foreach([
                                    'A' => 'working as part of a team',
                                    'B' => 'experiences when working in winter',
                                    'C' => 'being thanked by those he has helped',
                                    'D' => 'the fact that it keeps him fit',
                                    'E' => 'the chance to develop new equipment'
                                ] as $letter => $option)
                                <label class="flex items-start gap-3 cursor-pointer group mb-2">
                                    <input type="checkbox" name="q19_20[]" value="{{ $letter }}" x-model="selected19_20" class="w-5 h-5 mt-1 text-blue-600 rounded border-gray-300">
                                    <span class="font-bold w-4 mt-0.5">{{ $letter }}</span>
                                    <span class="group-hover:text-blue-600 transition">{{ $option }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 1" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                    <button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
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
                    <div class="pl-4 space-y-6 mt-8">
                        <h4 class="font-bold text-md mb-2">Questions 21–24</h4>
                        <p class="italic mb-6">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                        
                        @foreach([
                            [21, 'At first, Don thought the topic of recycling footwear might be too', ['limited in scope.', 'hard to research.', 'boring for listeners.']],
                            [22, 'When discussing trainers, Bella and Don disagree about', ['how popular they are among young people.', 'how suitable they are for school.', 'how quickly they wear out.']],
                            [23, 'Bella says that she sometimes recycles shoes because', ['they no longer fit.', 'she no longer likes them.', 'they are no longer in fashion.']],
                            [24, 'What did the article say that confused Don?', ['Public consumption of footwear has risen.', 'Less footwear is recycled now than in the past.', 'People dispose of more footwear than they used to.']],
                        ] as [$num, $question, $options])
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">{{ $num }}</span> {{ $question }}</p>
                            <div class="space-y-2 ml-8">
                                @foreach(['A', 'B', 'C'] as $i => $letter)
                                <label class="flex items-start gap-3 cursor-pointer group mb-1">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-5 h-5 text-blue-600 mt-0.5">
                                    <span class="font-bold w-4 mt-0.5">{{ $letter }}</span>
                                    <span class="group-hover:text-blue-600 transition">{{ $options[$i] }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="font-bold text-md mb-1">Questions 25–28</h4>
                            <p class="font-semibold mb-1">What reasons did the recycling manager give for rejecting footwear, according to the students?</p>
                            <p class="italic mb-6">Choose <span class="font-bold">FOUR</span> answers from the box and write the correct letter, <span class="font-bold">A–F</span>, next to Questions 25–28.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="border border-gray-400 p-5 rounded-lg bg-gray-50">
                                    <h5 class="font-bold text-center mb-4 text-base border-b border-gray-300 pb-2">Reasons</h5>
                                    <div class="space-y-3 text-sm">
                                        @foreach([
                                            'A' => 'one shoe was missing',
                                            'B' => 'the colour of one shoe had faded',
                                            'C' => 'one shoe had a hole in it',
                                            'D' => 'the shoes were brand new',
                                            'E' => 'the shoes were too dirty',
                                            'F' => 'the stitching on the shoes was broken'
                                        ] as $l => $t)
                                        <div class="flex items-start gap-3"><span class="font-bold">{{ $l }}</span><span class="leading-tight">{{ $t }}</span></div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <h5 class="font-bold mb-4 text-base">Footwear</h5>
                                    <div class="space-y-4">
                                        @foreach([
                                            25 => 'the high-heeled shoes',
                                            26 => 'the ankle boots',
                                            27 => 'the baby shoes',
                                            28 => 'the trainers'
                                        ] as $num => $item)
                                        <div class="flex items-center gap-4 mb-4 pb-4 border-b border-gray-100 last:border-0">
                                            <span class="font-bold w-6">{{ $num }}</span>
                                            <span class="flex-1 leading-tight">{{ $item }}</span>
                                            <select name="q{{ $num }}" class="border border-black outline-none w-20 h-10 bg-transparent focus:border-blue-500 font-bold text-lg flex-none cursor-pointer pl-4">
                                                <option value="" disabled selected></option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                            </select>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="font-bold text-md mb-2">Questions 29–30</h4>
                            <p class="italic mb-6">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                            
                            @foreach([
                                [29, 'Why did the project to make \'new\' shoes out of old shoes fail?', ['People believed the \'new\' pairs of shoes were unhygienic.', 'There were not enough good parts to use in the old shoes.', 'The shoes in the \'new\' pairs were not completely alike.']],
                                [30, 'Bella and Don agree that they can present their topic', ['from a new angle.', 'with relevant images.', 'in a straightforward way.']],
                            ] as [$num, $question, $options])
                            <div class="border-b border-gray-200 pb-5 mb-5">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">{{ $num }}</span> {{ $question }}</p>
                                <div class="space-y-2 ml-8">
                                    @foreach(['A', 'B', 'C'] as $i => $letter)
                                    <label class="flex items-start gap-3 cursor-pointer group mb-1">
                                        <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-5 h-5 text-blue-600 mt-0.5">
                                        <span class="font-bold w-4 mt-0.5">{{ $letter }}</span>
                                        <span class="group-hover:text-blue-600 transition">{{ $options[$i] }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 2" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                    <button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
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
                    </div>
                    
                    <div class="border border-black p-6 mb-8">
                        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Tardigrades</h2>
                        <ul class="list-disc ml-8 space-y-3 mb-8 text-lg">
                            <li>more than 1,000 species, 0.05–1.2 millimetres long</li>
                            <li class="flex flex-wrap gap-2 items-center">
                                also known as water 'bears' (due to how they <span class="font-bold ml-1 mr-1">31</span>
                                <input type="text" name="q31" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                ) and 'moss piglets'
                            </li>
                        </ul>
                        
                        <div class="mb-8">
                            <h4 class="font-bold text-lg mb-4">Physical appearance</h4>
                            <ul class="list-disc ml-8 space-y-4 text-base">
                                <li class="flex flex-wrap gap-2 items-center">
                                    a <span class="font-bold ml-1 mr-1">32</span>
                                    <input type="text" name="q32" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    round body and four pairs of legs
                                </li>
                                <li class="flex flex-wrap gap-2 items-center">
                                    claws or <span class="font-bold ml-1 mr-1">33</span>
                                    <input type="text" name="q33" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    for gripping
                                </li>
                                <li>absence of respiratory organs</li>
                                <li class="flex flex-wrap gap-2 items-center">
                                    body filled with a liquid that carries both <span class="font-bold ml-1 mr-1">34</span>
                                    <input type="text" name="q34" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    and blood
                                </li>
                                <li class="flex flex-wrap gap-2 items-center">
                                    mouth shaped like a <span class="font-bold ml-1 mr-1">35</span>
                                    <input type="text" name="q35" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    with teeth called stylets
                                </li>
                            </ul>
                        </div>

                        <div class="mb-8">
                            <h4 class="font-bold text-lg mb-4">Habitat</h4>
                            <ul class="list-disc ml-8 space-y-4 text-base">
                                <li>often found at the bottom of a lake or on plants</li>
                                <li class="flex flex-wrap gap-2 items-center">
                                    very resilient and can exist in very low or high <span class="font-bold ml-1 mr-1">36</span>
                                    <input type="text" name="q36" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                </li>
                            </ul>
                        </div>

                        <div class="mb-8">
                            <h4 class="font-bold text-lg mb-4">Cryptobiosis</h4>
                            <ul class="list-disc ml-8 space-y-4 text-base">
                                <li>In dry conditions, they roll into a ball called a 'tun'.</li>
                                <li>They stay alive with a much lower metabolism than usual.</li>
                                <li class="flex flex-wrap gap-2 items-center">
                                    A type of <span class="font-bold ml-1 mr-1">37</span>
                                    <input type="text" name="q37" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    ensures their DNA is not damaged.
                                </li>
                                <li class="flex flex-wrap gap-2 items-center">
                                    Research is underway to find out how many days they can stay alive in <span class="font-bold ml-1 mr-1">38</span>
                                    <input type="text" name="q38" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    .
                                </li>
                            </ul>
                        </div>

                        <div class="mb-8">
                            <h4 class="font-bold text-lg mb-4">Feeding</h4>
                            <ul class="list-disc ml-8 space-y-4 text-base">
                                <li class="flex flex-wrap gap-2 items-center">
                                    consume liquids, e.g., those found in moss or <span class="font-bold ml-1 mr-1">39</span>
                                    <input type="text" name="q39" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                </li>
                                <li>may eat other tardigrades</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-bold text-lg mb-4">Conservation status</h4>
                            <ul class="list-disc ml-8 space-y-4 text-base">
                                <li class="flex flex-wrap gap-2 items-center">
                                    They are not considered to be <span class="font-bold ml-1 mr-1">40</span>
                                    <input type="text" name="q40" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    .
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 3" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Submit Answers</button>
                </div>
            </div>

        </div>
    </main>
</div>

@include('assignments.ielts.listening.partials.audio-player', ['set' => 'Mock Up ' . $testId, 'section' => $material])

<script>
document.addEventListener('DOMContentLoaded', function() {});
</script>
<style>main{padding-bottom:250px!important;}</style>
</body>
</html>
