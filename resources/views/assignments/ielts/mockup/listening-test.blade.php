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

            <div x-data="{ step: 1 }">
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
                            <h2 class="text-2xl font-bold text-center mb-6">Children’s Engineering Workshops</h2>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Tiny Engineers (ages 4–5)</h4>
                                <p class="mb-2">Activities</p>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        Create a cover for an <span class="font-bold">1</span> 
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        so they can drop it from a height without breaking it.
                                    </li>
                                    <li class="pl-2">
                                        Take part in a competition to build the tallest <span class="font-bold">2</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">.
                                    </li>
                                    <li class="pl-2">
                                        Make a <span class="font-bold">3</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        powered by a balloon.
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Junior Engineers (ages 6–8)</h4>
                                <p class="mb-2">Activities:</p>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        Build model cars, trucks and <span class="font-bold">4</span> 
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        and learn how to program them so they can move.
                                    </li>
                                    <li class="pl-2">
                                        Take part in a competition to build the longest <span class="font-bold">5</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        using card and wood.
                                    </li>
                                    <li class="pl-2">
                                        Create a short <span class="font-bold">6</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        with special software.
                                    </li>
                                    <li class="pl-2">
                                        Build, <span class="font-bold">7</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        and program a humanoid robot.
                                    </li>
                                </ul>
                            </div>

                            <div class="space-y-3">
                                <p>Cost for a five-week block: £50</p>
                                <div class="flex items-center flex-wrap gap-2">
                                    <span>Held on</span>
                                    <span class="font-bold">8</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    from 10 am to 11 am
                                </div>
                                
                                <div class="mt-4">
                                    <h5 class="font-bold mb-2">Location</h5>
                                    <div class="flex items-center flex-wrap gap-2 mb-2">
                                        <span>Building 10A,</span>
                                        <span class="font-bold">9</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        Industrial Estate, Grasford
                                    </div>
                                    <div class="flex items-center flex-wrap gap-2">
                                        <span>Plenty of</span>
                                        <span class="font-bold">10</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        is available.
                                    </div>
                                </div>
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
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">11</span> Stevenson's was founded in</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">1923.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">1924.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">1926.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 12 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">12</span> Originally, Stevenson's manufactured goods for</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">the healthcare industry.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">the automotive industry.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">the machine tools industry.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 13 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">13</span> What does the speaker say about the company premises?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">The company has recently moved.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">The company has no plans to move.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">The company is going to move shortly.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 14 -->
                            <div>
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">14</span> The programme for the work experience group includes</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">time to do research.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">meetings with a teacher.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">talks by staff.</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h4 class="font-bold text-md mb-2">Questions 15–20</h4>
                            <p class="italic mb-2">Label the map below.</p>
                            <p class="italic mb-6">Write the correct letter, <span class="font-bold">A–J</span>, next to Questions 15–20.</p>

                            <h2 class="text-xl font-bold text-center mb-6">Plan of Stevenson's site</h2>

                            <div class="mb-8 flex justify-center">
                                <img src="{{ asset('images/ielts-listening-map.jpg') }}" alt="Plan of Stevenson's site" class="max-w-full h-auto shadow-md rounded-lg">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 max-w-2xl mx-auto">
                                <div class="flex items-center gap-4">
                                    <span class="font-bold w-6">15</span>
                                    <span class="flex-1">coffee room</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-J">
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="font-bold w-6">16</span>
                                    <span class="flex-1">warehouse</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-J">
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="font-bold w-6">17</span>
                                    <span class="flex-1">staff canteen</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-J">
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="font-bold w-6">18</span>
                                    <span class="flex-1">meeting room</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-J">
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="font-bold w-6">19</span>
                                    <span class="flex-1">human resources</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-J">
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="font-bold w-6">20</span>
                                    <span class="flex-1">boardroom</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-J">
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
                            <h4 class="font-bold text-md mb-2">Questions 21 and 22</h4>
                            <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        </div>

                        <div class="pl-4 space-y-8">
                            <!-- Questions 21-22 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> parts of the introductory stage to their art projects do Jess and Tom agree were useful?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q21_22[]" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">the Bird Park visit</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q21_22[]" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">the workshop sessions</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q21_22[]" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">the Natural History Museum visit</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q21_22[]" value="D" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">D</span>
                                        <span class="group-hover:text-blue-600 transition">the projects done in previous years</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q21_22[]" value="E" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">E</span>
                                        <span class="group-hover:text-blue-600 transition">the handouts with research sources</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Questions 23-24 -->
                            <div>
                                <h4 class="font-bold text-md mb-2">Questions 23 and 24</h4>
                                <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                                <p class="font-semibold mb-3">In which <span class="font-bold">TWO</span> ways do both Jess and Tom decide to change their proposals?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q23_24[]" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">by giving a rationale for their action plans</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q23_24[]" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">by being less specific about the outcome</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q23_24[]" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">by adding a video diary presentation</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q23_24[]" value="D" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">D</span>
                                        <span class="group-hover:text-blue-600 transition">by providing a timeline and a mind map</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q23_24[]" value="E" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">E</span>
                                        <span class="group-hover:text-blue-600 transition">by making their notes more evaluative</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Questions 25-30 -->
                            <div class="mt-8 border-t border-gray-200 pt-8">
                                <h4 class="font-bold text-md mb-2">Questions 25–30</h4>
                                <p class="italic mb-4">Which personal meaning do the students decide to give to each of the following pictures?</p>
                                <p class="italic mb-6">Choose <span class="font-bold">SIX</span> answers from the box and write the correct letter, <span class="font-bold">A–H</span>, next to Questions 25–30.</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="border border-gray-400 p-6 rounded-lg bg-gray-50">
                                        <h5 class="font-bold text-center mb-4 text-lg border-b border-gray-300 pb-2">Personal meanings</h5>
                                        <div class="space-y-2">
                                            <div class="flex gap-4"><span class="font-bold w-4">A</span> <span>a childhood memory</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">B</span> <span>hope for the future</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">C</span> <span>fast movement</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">D</span> <span>a potential threat</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">E</span> <span>the power of colour</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">F</span> <span>the continuity of life</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">G</span> <span>protection of nature</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-4">H</span> <span>a confused attitude to nature</span></div>
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="font-bold mb-4 text-lg">Pictures</h5>
                                        <div class="space-y-4">
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">25</span>
                                                <span class="flex-1">Falcon (Landseer)</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-H">
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">26</span>
                                                <span class="flex-1">Fish hawk (Audubon)</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-H">
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">27</span>
                                                <span class="flex-1">Kingfisher (van Gogh)</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-H">
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">28</span>
                                                <span class="flex-1">Portrait of William Wells</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-H">
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">29</span>
                                                <span class="flex-1">Vairumati (Gauguin)</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-H">
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-bold w-6">30</span>
                                                <span class="flex-1">Portrait of Giovanni de Medici</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center uppercase font-bold" maxlength="1" placeholder="A-H">
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
                            <h2 class="text-2xl font-bold text-center mb-6">Stoicism</h2>
                            
                            <p class="mb-6">
                                Stoicism is still relevant today because of its <span class="font-bold">31</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                appeal.
                            </p>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Ancient Stoics</h4>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        Stoicism was founded over 2,000 years ago in Greece.
                                    </li>
                                    <li class="pl-2">
                                        The Stoics' ideas are surprisingly well known, despite not being intended for <span class="font-bold">32</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">.
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Stoic principles</h4>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        Happiness could be achieved by leading a virtuous life.
                                    </li>
                                    <li class="pl-2">
                                        Controlling emotions was essential.
                                    </li>
                                    <li class="pl-2">
                                        Epictetus said that external events cannot be controlled but the <span class="font-bold">33</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        people make in response can be controlled.
                                    </li>
                                    <li class="pl-2">
                                        A Stoic is someone who has a different view on experiences which others would consider as <span class="font-bold">34</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">.
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">The influence of Stoicism</h4>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        George Washington organised a <span class="font-bold">35</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        about Cato to motivate his men.
                                    </li>
                                    <li class="pl-2">
                                        The French artist Delacroix was a Stoic.
                                    </li>
                                    <li class="pl-2">
                                        Adam Smith's ideas on <span class="font-bold">36</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        were influenced by Stoicism.
                                    </li>
                                    <li class="pl-2">
                                        Some of today's political leaders are inspired by the Stoics.
                                    </li>
                                    <li class="pl-2">
                                        Cognitive Behaviour Therapy (CBT)
                                        <ul class="list-disc ml-5 mt-2 space-y-2">
                                            <li>
                                                the treatment for <span class="font-bold">37</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                                is based on ideas from Stoicism
                                            </li>
                                            <li>
                                                people learn to base their thinking on <span class="font-bold">38</span>
                                                <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">.
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pl-2">
                                        In business, people benefit from Stoicism by identifying obstacles as <span class="font-bold">39</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">.
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h4 class="font-bold text-lg mb-2">Relevance of Stoicism</h4>
                                <ul class="list-disc ml-5 space-y-3">
                                    <li class="pl-2">
                                        It requires a lot of <span class="font-bold">40</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        but Stoicism can help people to lead a good life.
                                    </li>
                                    <li class="pl-2">
                                        It teaches people that having a strong character is more important than anything else.
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
                        <textarea name="answer_key" rows="6" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-teal-500 focus:outline-none placeholder-gray-400 text-sm font-mono" placeholder="1. A\n2. B..."></textarea>
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
