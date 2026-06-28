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
        {{-- Main Content --}}
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
                             <p class="text-gray-600 mt-1">Full Listening Test</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 1]) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div x-data="{ step: 1 }" x-init="$watch('step', value => $dispatch('part-changed', value))">
                <!-- Part 1 -->
                <div x-show="step === 1">
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1–10</span></h3>
                            <p class="italic mb-4">Complete the notes below.</p>
                            <p class="italic">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>
                        </div>

                        <div class="border border-black p-6">
                            <h2 class="text-2xl font-bold text-center mb-6">Buckworth Conservation Group</h2>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Regular activities</h4>
                                <p class="mb-2 font-semibold">Beach</p>
                                <ul class="list-disc ml-5 space-y-3 mb-4">
                                    <li class="pl-2">
                                        making sure the beach does not have <span class="font-bold">1</span> 
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        on it
                                    </li>
                                    <li class="pl-2">
                                        no <span class="font-bold">2</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    </li>
                                </ul>

                                <p class="mb-2 font-semibold mt-6">Nature reserve</p>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">maintaining paths</li>
                                    <li class="pl-2">nesting boxes for birds installed</li>
                                    <li class="pl-2">
                                        next task is taking action to attract <span class="font-bold">3</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        to the place
                                    </li>
                                    <li class="pl-2">
                                        identifying types of <span class="font-bold">4</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    </li>
                                    <li class="pl-2">
                                        building a new <span class="font-bold">5</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2 mt-8">Forthcoming events</h4>
                                <p class="mb-2 font-semibold">Saturday</p>
                                <ul class="list-disc ml-5 space-y-3 mb-4">
                                    <li class="pl-2">meet at Dunsmore Beach car park</li>
                                    <li class="pl-2 flex flex-wrap items-center gap-2">
                                        <div>walk across the sands and reach the</div>
                                        <span class="font-bold">6</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    </li>
                                    <li class="pl-2">take a picnic</li>
                                    <li class="pl-2">
                                        wear appropriate <span class="font-bold">7</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    </li>
                                </ul>

                                <p class="mb-2 font-semibold mt-6">Woodwork session</p>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2 flex flex-wrap items-center gap-2">
                                        <div>suitable for</div>
                                        <span class="font-bold">8</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        <div>to participate in</div>
                                    </li>
                                    <li class="pl-2 flex flex-wrap items-center gap-2">
                                        <div>making</div>
                                        <span class="font-bold">9</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        <div>out of wood</div>
                                    </li>
                                    <li class="pl-2">17th, from 10 a.m. to 3 p.m.</li>
                                    <li class="pl-2 flex flex-wrap items-center gap-2">
                                        <div>cost of session (no camping):</div>
                                        <span class="font-bold">10</span>
                                        <div>£</div>
                                        <input type="text" class="border-b border-black outline-none px-2 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                
                    <div class="max-w-4xl mx-auto mt-8 flex justify-end">
                        <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Next Part
                        </button>
                    </div>
                </div>

                <!-- Part 2 -->
                <div x-show="step === 2" x-cloak>
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
                            <h4 class="font-bold text-md mb-2">Questions 11–14</h4>
                            <p class="italic">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                        </div>

                        <div class="pl-4 space-y-8">
                            <!-- Question 11 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">11</span> What is the maximum number of people who can stand on each side of the boat?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">9</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">15</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">18</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 12 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">12</span> What colour are the tour boats?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">dark red</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">jet black</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">light green</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 13 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">13</span> Which lunchbox is suitable for someone who doesn't eat meat or fish?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">Lunchbox 1</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">Lunchbox 2</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">Lunchbox 3</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 14 -->
                            <div>
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">14</span> What should people do with their litter?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">take it home</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">hand it to a member of staff</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">put it in the bins provided on the boat</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-200 pt-8 space-y-8">

                            {{-- Questions 15 and 16 --}}
                            <div>
                                <h4 class="font-bold text-md mb-1">Questions 15 and 16</h4>
                                <p class="italic mb-1">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                                <p class="mb-3">Which <span class="font-bold">TWO</span> features of the lighthouse does Lou mention?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q15_16[]" value="A" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">why it was built</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q15_16[]" value="B" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">who built it</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q15_16[]" value="C" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">how long it took to build</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q15_16[]" value="D" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">D</span>
                                        <span class="group-hover:text-blue-600 transition">who staffed it</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q15_16[]" value="E" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">E</span>
                                        <span class="group-hover:text-blue-600 transition">what it was built with</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Questions 17 and 18 --}}
                            <div>
                                <h4 class="font-bold text-md mb-1">Questions 17 and 18</h4>
                                <p class="italic mb-1">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                                <p class="mb-3">Which <span class="font-bold">TWO</span> types of creature might come close to the boat?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q17_18[]" value="A" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">sea eagles</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q17_18[]" value="B" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">fur seals</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q17_18[]" value="C" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">dolphins</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q17_18[]" value="D" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">D</span>
                                        <span class="group-hover:text-blue-600 transition">whales</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q17_18[]" value="E" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">E</span>
                                        <span class="group-hover:text-blue-600 transition">penguins</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Questions 19 and 20 --}}
                            <div>
                                <h4 class="font-bold text-md mb-1">Questions 19 and 20</h4>
                                <p class="italic mb-1">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                                <p class="mb-3">Which <span class="font-bold">TWO</span> points does Lou make about the caves?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q19_20[]" value="A" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">Only large tourist boats can visit them.</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q19_20[]" value="B" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">The entrances to them are often blocked.</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q19_20[]" value="C" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">It is too dangerous for individuals to go near them.</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q19_20[]" value="D" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">D</span>
                                        <span class="group-hover:text-blue-600 transition">Someone will explain what is inside them.</span>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q19_20[]" value="E" class="mt-1 w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">E</span>
                                        <span class="group-hover:text-blue-600 transition">They cannot be reached on foot.</span>
                                    </label>
                                </div>
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

                <!-- Part 3 -->
                <div x-show="step === 3" x-cloak>
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
                            <h4 class="font-bold text-md mb-2">Questions 21–26</h4>
                            <p class="italic mb-4">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                        </div>

                        <div class="pl-4 space-y-8">
                            <!-- Question 21 -->
                            <div class="border-b border-gray-200 pb-6">
                                <h4 class="text-lg font-bold mb-4 text-center">Work experience for veterinary science students</h4>
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">21</span> What problem did both Diana and Tim have when arranging their work experience?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q21" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">making initial contact with suitable farms</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q21" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">organising transport to and from the farm</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q21" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">finding a placement for the required length of time</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 22 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">22</span> Tim was pleased to be able to help</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q22" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">a lamb that had a broken leg.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q22" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">a sheep that was having difficulty giving birth.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q22" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">a newly born lamb that was having trouble feeding.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 23 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">23</span> Diana says the sheep on her farm</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q23" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">were of various different varieties.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q23" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">were mainly reared for their meat.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q23" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">had better quality wool than sheep on the hills.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 24 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">24</span> What did the students learn about adding supplements to chicken feed?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q24" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">These should only be given if specially needed.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q24" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">It is worth paying extra for the most effective ones.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q24" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">The amount given at one time should be limited.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 25 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">25</span> What happened when Diana was working with dairy cows?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q25" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">She identified some cows incorrectly.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q25" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">She accidentally threw some milk away.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q25" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">She made a mistake when storing milk.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 26 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">26</span> What did both farmers mention about vets and farming?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q26" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">Vets are failing to cope with some aspects of animal health.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q26" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">There needs to be a fundamental change in the training of vets.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q26" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">Some jobs could be done by the farmer rather than by a vet.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Questions 27-30 -->
                            <div class="mt-8 border-t border-gray-200 pt-8">
                                <h4 class="font-bold text-md mb-2">Questions 27–30</h4>
                                <p class="mb-4">What opinion do the students give about each of the following modules on their veterinary science course?</p>
                                <p class="italic mb-6">Choose <span class="font-bold">FOUR</span> answers from the box and write the correct letter, <span class="font-bold">A–F</span>, next to questions 27–30.</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="border border-gray-400 p-6 rounded-lg bg-gray-50">
                                        <h5 class="font-bold text-center mb-4 text-lg border-b border-gray-300 pb-2">Opinions</h5>
                                        <div class="space-y-3">
                                            <div class="flex gap-4"><span class="font-bold w-4">A</span> <span>Tim found this easier than expected.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">B</span> <span>Tim thought this was not very clearly organised.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">C</span> <span>Diana may do some further study on this.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">D</span> <span>They both found the reading required for this was difficult.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">E</span> <span>Tim was shocked at something he learned on this module.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">F</span> <span>They were both surprised how little is known about some aspects of this.</span></div>
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="font-bold mb-4 text-lg">Modules on Veterinary Science course</h5>
                                        <div class="space-y-4">
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">27</span>
                                                <span class="flex-1">Medical terminology</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-F">
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">28</span>
                                                <span class="flex-1">Diet and nutrition</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-F">
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">29</span>
                                                <span class="flex-1">Animal disease</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-F">
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">30</span>
                                                <span class="flex-1">Wildlife medication</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-F">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

                <!-- Part 4 -->
                <div x-show="step === 4" x-cloak>
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
                            <p class="italic mb-4">Complete the notes below.</p>
                            <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                        </div>

                        <div class="border border-black p-6">
                            <h2 class="text-2xl font-bold text-center mb-6">Labyrinths</h2>

                            <p class="mb-6">
                                <span class="font-bold">Definition</span>
                                <br>
                                • A winding spiral path leading to a central area
                            </p>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Labyrinths compared with mazes</h4>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        Mazes are a type of <span class="font-bold">31</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        <br>– <span class="font-bold">32</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        is needed to navigate through a maze
                                        <br>– the word 'maze' is derived from a word meaning a feeling of <span class="font-bold">33</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    </li>
                                    <li class="pl-2">
                                        Labyrinths represent a journey through life
                                        <br>– they have frequently been used in <span class="font-bold">34</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        and prayer
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Early examples of the labyrinth spiral</h4>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        Ancient carvings on <span class="font-bold">35</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        have been found across many cultures
                                    </li>
                                    <li class="pl-2">
                                        The Pima, a Native American tribe, wove the symbol on baskets
                                    </li>
                                    <li class="pl-2">
                                        Ancient Greeks used the symbol on <span class="font-bold">36</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Walking labyrinths</h4>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        The largest surviving example of a turf labyrinth once had a large <span class="font-bold">37</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        at its centre
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Labyrinths nowadays</h4>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        Believed to have a beneficial impact on mental and physical health, e.g., walking a maze can reduce a person's <span class="font-bold">38</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        rate
                                    </li>
                                    <li class="pl-2">
                                        Used in medical and health and fitness settings and also prisons
                                    </li>
                                    <li class="pl-2">
                                        Popular with patients, visitors and staff in hospitals
                                        <br>– patients who can't walk can use 'finger labyrinths' made from <span class="font-bold">39</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        <br>– research has shown that Alzheimer's sufferers experience less <span class="font-bold">40</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
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
        document.addEventListener('DOMContentLoaded', function() {        });
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
