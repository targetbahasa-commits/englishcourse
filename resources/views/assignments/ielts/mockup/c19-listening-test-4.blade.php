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
        .audio-player-container {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 50;
            display: flex;
            justify-content: center;
            padding: 1rem;
        }
        main { padding-bottom: 6rem; }
        .cambridge-part-title {
            font-size: 1.25rem;
            font-weight: bold;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }
        [x-cloak] { display: none !important; }
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
                        <p class="text-gray-600 mt-1">Cambridge {{ $edition ?? '19' }} Test {{ $testId ?? '4' }}</p>
                    </div>
                </div>
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition ?? '19', 'id' => $testId ?? '4']) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition flex items-center gap-2 border border-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </a>
            </div>
        </div>

        <div x-data="listeningTest()">

            {{-- PART 1 --}}
            <div x-show="step === 1" x-transition.opacity>
                <div class="max-w-4xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-200">
                    <div class="flex justify-center mb-8">
                        <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">Listening</span>
                    </div>

                    <div class="mb-10 text-gray-800">
                        <h3 class="cambridge-part-title text-gray-900 border-b-2 border-gray-900 inline-block pb-1">PART 1</h3>
                        <span class="ml-6 font-bold text-lg text-gray-700">Questions 1–10</span>
                    </div>

                    {{-- Questions 1-6 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200">
                        <p class="font-bold mb-2 text-gray-800 text-lg">Questions 1–6</p>
                        <p class="italic mb-2 text-gray-700">Complete the notes below.</p>
                        <p class="italic mb-6 text-gray-700">Write <span class="font-bold text-black">ONE WORD AND/OR A NUMBER</span> for each answer.</p>
                        
                        <div class="border-2 border-gray-800 p-8 bg-white shadow-sm font-serif max-w-2xl mx-auto">
                            <h2 class="text-2xl font-bold text-center mb-8 text-gray-900 tracking-wide">First day at work</h2>
                            
                            <div class="space-y-6 text-[15px] max-w-xl mx-auto">
                                <ul class="list-disc pl-5 space-y-5 text-gray-800">
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="w-64">Name of supervisor:</span>
                                            <span class="font-bold">1</span>
                                            <input type="text" x-model="answers.q1" class="border-b border-gray-400 outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors">
                                        </div>
                                    </li>
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="w-64">Where to leave coat and bag:</span>
                                            <span>use <span class="font-bold">2</span></span>
                                            <input type="text" x-model="answers.q2" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center">
                                            <span>in staffroom</span>
                                        </div>
                                    </li>
                                    <li class="pl-2">
                                        <div class="flex items-start gap-2 flex-wrap">
                                            <span class="w-64">See Tiffany in HR:</span>
                                            <div class="flex flex-col space-y-4">
                                                <div class="flex items-center gap-2">
                                                    <span>to give <span class="font-bold">3</span></span>
                                                    <input type="text" x-model="answers.q3" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center">
                                                    <span>number</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span>to collect <span class="font-bold">4</span></span>
                                                    <input type="text" x-model="answers.q4" class="border-b border-gray-400 outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="w-64">Location of HR office:</span>
                                            <span>on <span class="font-bold">5</span></span>
                                            <input type="text" x-model="answers.q5" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center">
                                            <span>floor</span>
                                        </div>
                                    </li>
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="w-64">Supervisor's mobile number:</span>
                                            <span class="font-bold">6</span>
                                            <input type="text" x-model="answers.q6" class="border-b border-gray-400 outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Questions 7-10 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200">
                        <p class="font-bold mb-2 text-gray-800 text-lg">Questions 7–10</p>
                        <p class="italic mb-2 text-gray-700">Complete the table below.</p>
                        <p class="italic mb-6 text-gray-700">Write <span class="font-bold text-black">ONE WORD ONLY</span> for each answer.</p>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse border border-gray-800 bg-white shadow-sm font-serif">
                                <thead>
                                    <tr class="bg-white">
                                        <th class="border border-gray-800 p-4 font-bold text-center text-gray-900 tracking-wide text-lg" colspan="4">Responsibilities</th>
                                    </tr>
                                    <tr class="bg-white text-gray-800">
                                        <th class="border border-gray-800 p-3 w-1/4"></th>
                                        <th class="border border-gray-800 p-3 text-center font-bold">Task 1</th>
                                        <th class="border border-gray-800 p-3 text-center font-bold">Task 2</th>
                                        <th class="border border-gray-800 p-3 text-center font-bold">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 leading-relaxed text-[15px]">
                                    <tr>
                                        <td class="border border-gray-800 p-4 font-bold">Bakery section</td>
                                        <td class="border border-gray-800 p-4">Check sell-by dates</td>
                                        <td class="border border-gray-800 p-4">Change price labels</td>
                                        <td class="border border-gray-800 p-4">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span>Use <span class="font-bold">7</span></span>
                                                <input type="text" x-model="answers.q7" class="border-b border-gray-400 outline-none px-2 w-24 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center">
                                                <span>labels</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="bg-white">
                                        <td class="border border-gray-800 p-4 font-bold">Sushi takeaway counter</td>
                                        <td class="border border-gray-800 p-4">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span>Re-stock with <span class="font-bold">8</span></span>
                                                <input type="text" x-model="answers.q8" class="border-b border-gray-400 outline-none px-2 w-24 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center">
                                                <span>boxes if needed</span>
                                            </div>
                                        </td>
                                        <td class="border border-gray-800 p-4">Wipe preparation area and clean the sink</td>
                                        <td class="border border-gray-800 p-4">Do not clean any knives</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-800 p-4 font-bold">Meat and fish counters</td>
                                        <td class="border border-gray-800 p-4">Clean the serving area, including the weighing scales</td>
                                        <td class="border border-gray-800 p-4">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span>Collect <span class="font-bold">9</span></span>
                                                <input type="text" x-model="answers.q9" class="border-b border-gray-400 outline-none px-2 w-24 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center">
                                                <span>for the fish from the cold-room</span>
                                            </div>
                                        </td>
                                        <td class="border border-gray-800 p-4">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span>Must wear special <span class="font-bold">10</span></span>
                                                <input type="text" x-model="answers.q10" class="border-b border-gray-400 outline-none px-2 w-24 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button @click="step = 2" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 font-bold transition flex items-center gap-2 group">
                            Next Part
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- PART 2 --}}
            <div x-show="step === 2" x-cloak x-transition.opacity>
                <div class="max-w-4xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-200">
                    <div class="flex justify-center mb-8">
                        <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">Listening</span>
                    </div>

                    <div class="mb-10 text-gray-800">
                        <h3 class="cambridge-part-title text-gray-900 border-b-2 border-gray-900 inline-block pb-1">PART 2</h3>
                        <span class="ml-6 font-bold text-lg text-gray-700">Questions 11–20</span>
                    </div>

                    {{-- Questions 11-12 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200">
                        <p class="font-bold mb-2 text-gray-800 text-lg">Questions 11 and 12</p>
                        <p class="italic mb-4 text-gray-700">Choose <span class="font-bold text-black">TWO</span> letters, <span class="font-bold text-black">A–E</span>.</p>
                        <p class="mb-4 text-gray-800 text-[15px] font-bold">Which <span class="uppercase tracking-wide">TWO</span> problems with some training programmes for new runners does Liz mention?</p>
                        
                        <div class="space-y-3 ml-4 max-w-xl text-[15px]">
                            @foreach([
                                'A' => 'There is a risk of serious injury.',
                                'B' => 'They are unsuitable for certain age groups.',
                                'C' => 'They are unsuitable for people with health issues.',
                                'D' => 'It is difficult to stay motivated.',
                                'E' => 'There is a lack of individual support.'
                            ] as $val => $text)
                            <label class="flex gap-4 items-start cursor-pointer hover:bg-white p-3 rounded-lg border border-transparent hover:border-gray-200 hover:shadow-sm transition-all">
                                <input type="checkbox" x-model="answers.q11_12" value="{{ $val }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="font-bold text-gray-800 w-6 flex-none mt-0.5">{{ $val }}</span>
                                <span class="text-gray-700 leading-snug">{{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 13-14 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200">
                        <p class="font-bold mb-2 text-gray-800 text-lg">Questions 13 and 14</p>
                        <p class="italic mb-4 text-gray-700">Choose <span class="font-bold text-black">TWO</span> letters, <span class="font-bold text-black">A–E</span>.</p>
                        <p class="mb-4 text-gray-800 text-[15px] font-bold">Which <span class="uppercase tracking-wide">TWO</span> tips does Liz recommend for new runners?</p>
                        
                        <div class="space-y-3 ml-4 max-w-xl text-[15px]">
                            @foreach([
                                'A' => 'doing two runs a week',
                                'B' => 'running in the evening',
                                'C' => 'going on runs with a friend',
                                'D' => 'listening to music during runs',
                                'E' => 'running very slowly'
                            ] as $val => $text)
                            <label class="flex gap-4 items-start cursor-pointer hover:bg-white p-3 rounded-lg border border-transparent hover:border-gray-200 hover:shadow-sm transition-all">
                                <input type="checkbox" x-model="answers.q13_14" value="{{ $val }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="font-bold text-gray-800 w-6 flex-none mt-0.5">{{ $val }}</span>
                                <span class="text-gray-700 leading-snug">{{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 15-18 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200">
                        <p class="font-bold mb-2 text-gray-800 text-lg">Questions 15–18</p>
                        <p class="mb-4 text-gray-800 text-[15px]">What reason prevented each of the following members of the Compton Park Runners Club from joining until recently?</p>
                        <p class="italic mb-8 text-gray-700">Write the correct letter, <span class="font-bold text-black">A, B, or C</span> next to Questions 15–18.</p>

                        <div class="flex flex-col md:flex-row gap-12 items-start justify-center max-w-3xl mx-auto">
                            <!-- Box Options -->
                            <div class="border border-gray-300 p-8 bg-white shadow-sm font-serif w-full md:w-auto min-w-[300px]">
                                <p class="font-bold mb-6 text-center text-gray-900 border-b border-gray-200 pb-2">Reasons</p>
                                <div class="space-y-4 max-w-xs mx-auto text-[15px] text-gray-800">
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">A</span><span>a lack of confidence</span></div>
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">B</span><span>a dislike of running</span></div>
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">C</span><span>a lack of time</span></div>
                                </div>
                            </div>
                            
                            <!-- Questions List -->
                            <div class="w-full md:w-auto text-[15px]">
                                <table class="w-full">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-left font-bold pb-4 text-gray-800 font-serif">Club members</th>
                                        </tr>
                                    </thead>
                                    <tbody class="space-y-4 font-serif text-gray-800">
                                        @foreach([
                                            15 => 'Ceri',
                                            16 => 'James',
                                            17 => 'Leo',
                                            18 => 'Mark'
                                        ] as $qNum => $person)
                                        <tr class="h-12 border-b border-gray-100 last:border-none">
                                            <td class="font-bold w-12">{{ $qNum }}</td>
                                            <td class="w-32">{{ $person }}</td>
                                            <td>
                                                <select x-model="answers.q{{ $qNum }}" class="border border-gray-300 rounded-md px-3 py-1.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-white font-sans text-sm shadow-sm cursor-pointer w-20">
                                                    <option value="" disabled selected>-</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Questions 19-20 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200">
                        <p class="font-bold mb-2 text-gray-800 text-lg">Questions 19 and 20</p>
                        <p class="italic mb-6 text-gray-700">Choose the correct letter, <span class="font-bold text-black">A, B or C</span>.</p>
                        
                        <div class="space-y-8 ml-4 max-w-2xl text-[15px]">
                            @foreach([
                                19 => [
                                    'q' => 'What does Liz say about running her first marathon?',
                                    'opts' => [
                                        'A' => 'It had always been her ambition.',
                                        'B' => 'Her husband persuaded her to do it.',
                                        'C' => 'She nearly gave up before the end.'
                                    ]
                                ],
                                20 => [
                                    'q' => 'Liz says new runners should sign up for a race',
                                    'opts' => [
                                        'A' => 'every six months.',
                                        'B' => 'within a few weeks of taking up running.',
                                        'C' => 'after completing several practice runs.'
                                    ]
                                ]
                            ] as $qNum => $item)
                            <div class="space-y-4">
                                <div class="flex gap-4">
                                    <span class="font-bold text-gray-900 mt-0.5">{{ $qNum }}</span>
                                    <span class="text-gray-800 font-bold">{{ $item['q'] }}</span>
                                </div>
                                <div class="ml-8 space-y-3">
                                    @foreach($item['opts'] as $val => $text)
                                    <label class="flex gap-4 items-start cursor-pointer hover:bg-white p-2.5 rounded-lg border border-transparent hover:border-gray-200 hover:shadow-sm transition-all">
                                        <input type="radio" x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" value="{{ $val }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="font-bold text-gray-800 w-6 flex-none">{{ $val }}</span>
                                        <span class="text-gray-700">{{ $text }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button @click="step = 1" class="px-6 py-2.5 bg-white text-gray-700 hover:bg-gray-200 rounded-xl shadow-sm font-medium transition flex items-center gap-2 group border border-gray-300">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Previous Part
                        </button>
                        <button @click="step = 3" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 font-bold transition flex items-center gap-2 group">
                            Next Part
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- PART 3 --}}
            <div x-show="step === 3" x-cloak x-transition.opacity>
                <div class="max-w-4xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-200">
                    <div class="flex justify-center mb-8">
                        <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">Listening</span>
                    </div>

                    <div class="mb-10 text-gray-800">
                        <h3 class="cambridge-part-title text-gray-900 border-b-2 border-gray-900 inline-block pb-1">PART 3</h3>
                        <span class="ml-6 font-bold text-lg text-gray-700">Questions 21–30</span>
                    </div>

                    {{-- Questions 21-25 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200">
                        <p class="font-bold mb-2 text-gray-800 text-lg">Questions 21–25</p>
                        <p class="italic mb-6 text-gray-700">Choose the correct letter, <span class="font-bold text-black">A, B or C</span>.</p>
                        
                        <div class="space-y-8 ml-4 max-w-2xl text-[15px]">
                            @foreach([
                                21 => [
                                    'q' => 'Kieran thinks the packing advice given by Jane\'s grandfather is',
                                    'opts' => [
                                        'A' => 'common sense.',
                                        'B' => 'hard to follow.',
                                        'C' => 'over-protective.'
                                    ]
                                ],
                                22 => [
                                    'q' => 'How does Jane feel about the books her grandfather has given her?',
                                    'opts' => [
                                        'A' => 'They are not worth keeping.',
                                        'B' => 'They should go to a collector.',
                                        'C' => 'They have sentimental value for her.'
                                    ]
                                ],
                                23 => [
                                    'q' => 'Jane and Kieran agree that hardback books should be',
                                    'opts' => [
                                        'A' => 'put out on display.',
                                        'B' => 'given as gifts to visitors.',
                                        'C' => 'more attractively designed.'
                                    ]
                                ],
                                24 => [
                                    'q' => 'While talking about taking a book from a shelf, Jane',
                                    'opts' => [
                                        'A' => 'describes the mistakes other people make doing it.',
                                        'B' => 'reflects on a significant childhood experience.',
                                        'C' => 'explains why some books are easier to remove than others.'
                                    ]
                                ],
                                25 => [
                                    'q' => 'What do Jane and Kieran suggest about new books?',
                                    'opts' => [
                                        'A' => 'Their parents liked buying them as presents.',
                                        'B' => 'They would like to buy more of them.',
                                        'C' => 'Not everyone can afford them.'
                                    ]
                                ]
                            ] as $qNum => $item)
                            <div class="space-y-4">
                                <div class="flex gap-4">
                                    <span class="font-bold text-gray-900 mt-0.5">{{ $qNum }}</span>
                                    <span class="text-gray-800 font-bold">{{ $item['q'] }}</span>
                                </div>
                                <div class="ml-8 space-y-3">
                                    @foreach($item['opts'] as $val => $text)
                                    <label class="flex gap-4 items-start cursor-pointer hover:bg-white p-2.5 rounded-lg border border-transparent hover:border-gray-200 hover:shadow-sm transition-all">
                                        <input type="radio" x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" value="{{ $val }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="font-bold text-gray-800 w-6 flex-none">{{ $val }}</span>
                                        <span class="text-gray-700">{{ $text }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 26-30 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200">
                        <p class="font-bold mb-2 text-gray-800 text-lg">Questions 26–30</p>
                        <p class="mb-4 text-gray-800 text-[15px]">Where does Jane's grandfather keep each of the following types of books in his shop?</p>
                        <p class="italic mb-8 text-gray-700">Choose <span class="font-bold text-black uppercase">FIVE</span> answers from the box and write the correct letter, <span class="font-bold text-black">A–G</span>, next to Questions 26–30.</p>

                        <div class="flex flex-col md:flex-row gap-12 items-start justify-center max-w-4xl mx-auto">
                            <!-- Box Options -->
                            <div class="border border-gray-300 p-8 bg-white shadow-sm font-serif w-full md:w-auto min-w-[320px]">
                                <p class="font-bold mb-6 text-center text-gray-900 border-b border-gray-200 pb-2">Location of books</p>
                                <div class="space-y-4 max-w-[240px] mx-auto text-[15px] text-gray-800">
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">A</span><span>near the entrance</span></div>
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">B</span><span>in the attic</span></div>
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">C</span><span>at the back of the shop</span></div>
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">D</span><span>on a high shelf</span></div>
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">E</span><span>near the stairs</span></div>
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">F</span><span>in a specially designed space</span></div>
                                    <div class="flex gap-4"><span class="font-bold w-6 flex-none">G</span><span>within the café</span></div>
                                </div>
                            </div>
                            
                            <!-- Questions List -->
                            <div class="w-full md:w-auto text-[15px]">
                                <table class="w-full">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-left font-bold pb-4 text-gray-800 font-serif">Types of books</th>
                                        </tr>
                                    </thead>
                                    <tbody class="space-y-4 font-serif text-gray-800">
                                        @foreach([
                                            26 => 'rare books',
                                            27 => 'children\'s books',
                                            28 => 'unwanted books',
                                            29 => 'requested books',
                                            30 => 'coursebooks'
                                        ] as $qNum => $item)
                                        <tr class="h-12 border-b border-gray-100 last:border-none">
                                            <td class="font-bold w-12">{{ $qNum }}</td>
                                            <td class="w-40">{{ $item }}</td>
                                            <td>
                                                <select x-model="answers.q{{ $qNum }}" class="border border-gray-300 rounded-md px-3 py-1.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-white font-sans text-sm shadow-sm cursor-pointer w-20">
                                                    <option value="" disabled selected>-</option>
                                                    @foreach(['A','B','C','D','E','F','G'] as $opt)
                                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button @click="step = 2" class="px-6 py-2.5 bg-white text-gray-700 hover:bg-gray-200 rounded-xl shadow-sm font-medium transition flex items-center gap-2 group border border-gray-300">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Previous Part
                        </button>
                        <button @click="step = 4" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 font-bold transition flex items-center gap-2 group">
                            Next Part
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- PART 4 (Placeholder) --}}
            <div x-show="step === 4" x-cloak x-transition.opacity>
                <div class="max-w-4xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-200">
                    <div class="flex justify-center mb-8">
                        <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">Listening</span>
                    </div>

                    <div class="mb-10 text-gray-800">
                        <h3 class="cambridge-part-title text-gray-900 border-b-2 border-gray-900 inline-block pb-1">PART 4</h3>
                        <span class="ml-6 font-bold text-lg text-gray-700">Questions 31–40</span>
                    </div>
                    
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200">
                        <p class="italic mb-6 text-gray-700">Complete the notes below.</p>
                        <p class="italic mb-6 text-gray-700">Write <span class="font-bold text-black">ONE WORD ONLY</span> for each answer.</p>
                        
                        <div class="border-2 border-gray-800 p-8 bg-white shadow-sm font-serif max-w-3xl mx-auto">
                            <h2 class="text-3xl font-bold text-center mb-8 text-gray-900 tracking-wide">Tree planting</h2>
                            
                            <div class="space-y-6 text-[15px] max-w-2xl mx-auto text-gray-800 leading-relaxed">
                                <p class="font-bold text-lg">Reforestation projects should:</p>
                                <ul class="list-disc pl-5 space-y-4">
                                    <li class="pl-2">include a range of tree species</li>
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap inline-flex">
                                            <span>not include invasive species because of possible <span class="font-bold">31</span></span>
                                            <input type="text" x-model="answers.q31" class="border-b border-gray-400 outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            <span>with native species</span>
                                        </div>
                                    </li>
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap inline-flex">
                                            <span>aim to capture carbon, protect the environment and provide sustainable sources of <span class="font-bold">32</span></span>
                                            <input type="text" x-model="answers.q32" class="border-b border-gray-400 outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            <span>for local people</span>
                                        </div>
                                    </li>
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap inline-flex">
                                            <span>use tree seeds with a high genetic diversity to increase resistance to <span class="font-bold">33</span></span>
                                            <input type="text" x-model="answers.q33" class="border-b border-gray-400 outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            <span>and climate change</span>
                                        </div>
                                    </li>
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap inline-flex">
                                            <span>plant trees on previously forested land which is in a bad condition, not select land which is being used for <span class="font-bold">34</span></span>
                                            <input type="text" x-model="answers.q34" class="border-b border-gray-400 outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                        </div>
                                    </li>
                                </ul>

                                <p class="font-bold text-lg mt-8">Large-scale reforestation projects</p>
                                <ul class="list-disc pl-5 space-y-4">
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap inline-flex">
                                            <span>Base planning decisions on information from accurate <span class="font-bold">35</span></span>
                                            <input type="text" x-model="answers.q35" class="border-b border-gray-400 outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            <span>.</span>
                                        </div>
                                    </li>
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap inline-flex">
                                            <span>Drones are useful for identifying areas in Brazil which are endangered by keeping <span class="font-bold">36</span></span>
                                            <input type="text" x-model="answers.q36" class="border-b border-gray-400 outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            <span>and illegal logging.</span>
                                        </div>
                                    </li>
                                </ul>

                                <p class="font-bold text-lg mt-8">Lampang Province, Northern Thailand</p>
                                <ul class="list-disc pl-5 space-y-4">
                                    <li class="pl-2">A forest was restored in an area damaged by mining.</li>
                                    <li class="pl-2">
                                        <p>A variety of native fig trees were planted, which are important for</p>
                                        <ul class="list-none pl-6 space-y-4 mt-4">
                                            <li class="pl-2 flex items-start rel">&ndash;&nbsp;&nbsp;supporting many wildlife species</li>
                                            <li class="pl-2 flex items-start flex-wrap gap-2">
                                                <span>&ndash;&nbsp;&nbsp;increasing the <span class="font-bold">37</span></span>
                                                <input type="text" x-model="answers.q37" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                                <span>of recovery by attracting animals and birds, e.g., <span class="font-bold">38</span></span>
                                                <input type="text" x-model="answers.q38" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                                <span>were soon attracted to the area.</span>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                                <p class="font-bold text-lg mt-8">Involving local communities</p>
                                <ul class="list-disc pl-5 space-y-4">
                                    <li class="pl-2">
                                        <div class="flex items-center gap-2 flex-wrap inline-flex">
                                            <span>Destruction of mangrove forests in Madagascar made it difficult for people to make a living from <span class="font-bold">39</span></span>
                                            <input type="text" x-model="answers.q39" class="border-b border-gray-400 outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            <span>.</span>
                                        </div>
                                    </li>
                                    <li class="pl-2">
                                        <p>The mangrove reforestation project:</p>
                                        <ul class="list-none pl-6 space-y-3 mt-4">
                                            <li class="pl-2">&ndash;&nbsp;&nbsp;provided employment for local people</li>
                                            <li class="pl-2">&ndash;&nbsp;&nbsp;restored a healthy ecosystem</li>
                                            <li class="pl-2 flex items-center flex-wrap gap-2">
                                                <span>&ndash;&nbsp;&nbsp;protects against the higher risk of <span class="font-bold">40</span></span>
                                                <input type="text" x-model="answers.q40" class="border-b border-gray-400 outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                                <span>.</span>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-12">
                        <button @click="step = 3" class="px-6 py-2.5 bg-white text-gray-700 hover:bg-gray-200 rounded-xl shadow-sm font-medium transition flex items-center gap-2 group border border-gray-300">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Previous Part
                        </button>
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-md flex items-center gap-2" onclick="alert('Submission handled by backend.')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Submit Answers
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>

    {{-- Audio Player Footer --}}
    <div class="audio-player-container">
        <div class="w-full max-w-4xl flex items-center gap-6">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center flex-none">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
            </div>
            <div class="flex-1 w-full">
                <p class="text-sm font-bold text-gray-800 mb-1">C19 Test {{ $testId ?? '4' }} Audio</p>
                <audio controls class="w-full h-10 outline-none">
                    <source src="#" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('listeningTest', () => ({
            step: 1,
            answers: {
                q1: '', q2: '', q3: '', q4: '', q5: '', q6: '',
                q7: '', q8: '', q9: '', q10: '',
                q11_12: [], q13_14: [],
                q15: '', q16: '', q17: '', q18: '',
                q19: '', q20: '',
                q21: '', q22: '', q23: '', q24: '', q25: '',
                q26: '', q27: '', q28: '', q29: '', q30: '',
                q31: '', q32: '', q33: '', q34: '', q35: '',
                q36: '', q37: '', q38: '', q39: '', q40: ''
            }
        }));
    });
</script>

</body>
</html>
