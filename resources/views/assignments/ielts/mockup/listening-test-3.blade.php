<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Up 3 - {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .paper-shadow {
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div class="flex min-h-screen">
         {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-md fixed h-full z-10 hidden md:block">
            <div class="p-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
                <span class="text-xl font-bold text-gray-800">Target Bahasa</span>
            </div>
            
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <div class="px-6 py-4">
                    <p class="text-xs font-semibold text-gray-400 mb-4">MAIN MENU</p>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-medium border-l-4 border-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Assignments
                        </a>
                    </nav>
                </div>
            @else
                 <div class="px-6 py-4">
                    <p class="text-xs font-semibold text-gray-400 mb-4">MENU UTAMA</p>
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-medium border-l-4 border-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Assignments
                        </a>
                    </nav>
                </div>
            @endif
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-8">
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
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Listening Mock Up 3</h1>
                             <p class="text-gray-600 mt-1">Full Listening Test</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge.edition', ['edition' => $edition]) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div x-data="{ step: 1 }">
                <!-- Part 1: Junior Cycle Camp -->
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

                        <div class="bg-white border-2 border-gray-800 p-0 rounded-none shadow-none text-gray-900">
                            <!-- Header -->
                            <div class="border-b-2 border-gray-800 p-4 text-center bg-gray-100">
                                <h4 class="text-2xl font-bold uppercase tracking-wide">JUNIOR CYCLE CAMP</h4>
                            </div>
                            
                            <!-- Sub-header -->
                            <div class="border-b-2 border-gray-800 p-2 pl-6 bg-white">
                                <p class="font-medium text-gray-800">The course focuses on skills and safety.</p>
                            </div>

                            <div class="p-6 space-y-8">
                                <!-- Intro -->
                                <ul class="list-disc pl-5 space-y-3">
                                    <li>Charlie would be placed in Level 5.</li>
                                    <li>
                                        First of all, children at this level are taken to practise in a 
                                        <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                            <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">1</span>
                                            <input type="text" name="q1" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                        </span>
                                        .
                                    </li>
                                </ul>

                                <!-- Instructors -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg">Instructors</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>
                                            Instructors wear 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">2</span>
                                                <input type="text" name="q2" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            shirts.
                                        </li>
                                        <li>
                                            A 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">3</span>
                                                <input type="text" name="q3" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            is required and training is given.
                                        </li>
                                    </ul>
                                </div>

                                <!-- Classes -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg">Classes</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>The size of the classes is limited.</li>
                                        <li>
                                            There are quiet times during the morning for a 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">4</span>
                                                <input type="text" name="q4" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            or a game.
                                        </li>
                                        <li>
                                            Classes are held even if there is 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">5</span>
                                                <input type="text" name="q5" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            .
                                        </li>
                                    </ul>
                                </div>

                                <!-- What to bring -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg">What to bring</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>a change of clothing</li>
                                        <li>
                                            a 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">6</span>
                                                <input type="text" name="q6" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                        </li>
                                        <li>shoes (not sandals)</li>
                                        <li>
                                            Charlie's 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">7</span>
                                                <input type="text" name="q7" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Day 1 -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg">Day 1</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>Charlie should arrive at 9.20 am on the first day.</li>
                                        <li>
                                            Before the class, his 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">8</span>
                                                <input type="text" name="q8" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            will be checked.
                                        </li>
                                        <li>
                                            He should then go to the 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">9</span>
                                                <input type="text" name="q9" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            to meet his class instructor.
                                        </li>
                                    </ul>
                                </div>

                                <!-- Cost -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg">Cost</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>
                                            The course costs 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">10</span>
                                                <span class="font-bold text-xl mr-1">$</span>
                                                <input type="text" name="q10" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            per week.
                                        </li>
                                    </ul>
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

                <!-- Part 2: Megan -->
                <div x-show="step === 2" x-cloak>
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
                        </div>
                        
                         <div class="space-y-12">
                            <!-- Questions 11-12: Multiple Select -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 11 and 12: Choose TWO letters, A–E.</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <p class="font-medium text-gray-900 mb-4">According to Megan, what are the <span class="font-bold">TWO</span> main advantages of working in the agriculture and horticulture sectors?</p>
                                    <div class="space-y-2">
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q11_12[]" value="A" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">A</strong> the active lifestyle</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q11_12[]" value="B" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">B</strong> the above-average salaries</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q11_12[]" value="C" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">C</strong> the flexible working opportunities</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q11_12[]" value="D" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">D</strong> the opportunities for overseas travel</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q11_12[]" value="E" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">E</strong> the chance to be in a natural environment</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Questions 13-14: Multiple Select -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 13 and 14: Choose TWO letters, A–E.</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <p class="font-medium text-gray-900 mb-4">Which <span class="font-bold">TWO</span> of the following are likely to be disadvantages for people working outdoors?</p>
                                    <div class="space-y-2">
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q13_14[]" value="A" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">A</strong> the increasing risk of accidents</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q13_14[]" value="B" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">B</strong> being in a very quiet location</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q13_14[]" value="C" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">C</strong> difficult weather conditions at times</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q13_14[]" value="D" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">D</strong> the cost of housing</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q13_14[]" value="E" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">E</strong> the level of physical fitness required</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Questions 15-20: Matching -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 15–20: What information does Megan give about each of the following job opportunities?</h3>
                                <p class="text-gray-600 ml-4">Choose <strong>SIX</strong> answers from the box and write the correct letter, <strong>A–H</strong>, next to Questions 15–20.</p>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                                    <!-- Options Box -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                                        <h4 class="font-bold text-center text-xl text-gray-800 mb-6 border-b pb-4">Information</h4>
                                        <div class="space-y-4 text-lg text-gray-700 font-medium">
                                            <div class="flex gap-4"><span class="font-bold w-8 text-gray-900">A</span> <span>not a permanent job</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-8 text-gray-900">B</span> <span>involves leading a team</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-8 text-gray-900">C</span> <span>experience not essential</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-8 text-gray-900">D</span> <span>intensive work but also fun</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-8 text-gray-900">E</span> <span>chance to earn more through overtime</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-8 text-gray-900">F</span> <span>chance for rapid promotion</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-8 text-gray-900">G</span> <span>accommodation available</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-8 text-gray-900">H</span> <span>local travel involved</span></div>
                                        </div>
                                    </div>
 
                                    <!-- Questions -->
                                    <div class="space-y-4">
                                        <h4 class="font-bold text-gray-800 mb-2">Job opportunities</h4>
                                        
                                        <!-- Q15 -->
                                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                            <div class="flex gap-3">
                                                <span class="font-bold text-gray-800">15</span>
                                                <span class="text-gray-700">Fresh food commercial manager</span>
                                            </div>
                                            <input type="text" name="q15" class="w-16 border-2 border-gray-300 rounded-lg text-center font-bold text-blue-800 focus:border-blue-500 focus:ring-blue-200 uppercase" maxlength="1">
                                        </div>

                                        <!-- Q16 -->
                                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                            <div class="flex gap-3">
                                                <span class="font-bold text-gray-800">16</span>
                                                <span class="text-gray-700">Agronomist</span>
                                            </div>
                                            <input type="text" name="q16" class="w-16 border-2 border-gray-300 rounded-lg text-center font-bold text-blue-800 focus:border-blue-500 focus:ring-blue-200 uppercase" maxlength="1">
                                        </div>

                                        <!-- Q17 -->
                                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                            <div class="flex gap-3">
                                                <span class="font-bold text-gray-800">17</span>
                                                <span class="text-gray-700">Fresh produce buyer</span>
                                            </div>
                                            <input type="text" name="q17" class="w-16 border-2 border-gray-300 rounded-lg text-center font-bold text-blue-800 focus:border-blue-500 focus:ring-blue-200 uppercase" maxlength="1">
                                        </div>

                                        <!-- Q18 -->
                                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                            <div class="flex gap-3">
                                                <span class="font-bold text-gray-800">18</span>
                                                <span class="text-gray-700">Garden centre sales manager</span>
                                            </div>
                                            <input type="text" name="q18" class="w-16 border-2 border-gray-300 rounded-lg text-center font-bold text-blue-800 focus:border-blue-500 focus:ring-blue-200 uppercase" maxlength="1">
                                        </div>

                                        <!-- Q19 -->
                                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                            <div class="flex gap-3">
                                                <span class="font-bold text-gray-800">19</span>
                                                <span class="text-gray-700">Tree technician</span>
                                            </div>
                                            <input type="text" name="q19" class="w-16 border-2 border-gray-300 rounded-lg text-center font-bold text-blue-800 focus:border-blue-500 focus:ring-blue-200 uppercase" maxlength="1">
                                        </div>

                                        <!-- Q20 -->
                                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                            <div class="flex gap-3">
                                                <span class="font-bold text-gray-800">20</span>
                                                <span class="text-gray-700">Farm worker</span>
                                            </div>
                                            <input type="text" name="q20" class="w-16 border-2 border-gray-300 rounded-lg text-center font-bold text-blue-800 focus:border-blue-500 focus:ring-blue-200 uppercase" maxlength="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                         <button @click="step = 1" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Previous Part
                        </button>
                        <button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Next Part
                        </button>
                    </div>
                </div>

                <!-- Part 3: Adam -->
                <div x-show="step === 3" x-cloak>
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
                        </div>

                         <div class="space-y-12">
                            <!-- Questions 21-22: Multiple Select -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 21 and 22: Choose TWO letters, A–E.</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <p class="font-medium text-gray-900 mb-4">Which <span class="font-bold">TWO</span> points does Adam make about his experiment on artificial sweeteners?</p>
                                    <div class="space-y-2">
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q21_22[]" value="A" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">A</strong> The results were what he had predicted.</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q21_22[]" value="B" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">B</strong> The experiment was simple to set up.</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q21_22[]" value="C" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">C</strong> A large sample of people was tested.</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q21_22[]" value="D" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">D</strong> The subjects were unaware of what they were drinking.</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q21_22[]" value="E" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">E</strong> The test was repeated several times for each person.</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Questions 23-24: Multiple Select -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 23 and 24: Choose TWO letters, A–E.</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <p class="font-medium text-gray-900 mb-4">Which <span class="font-bold">TWO</span> problems did Rosie have when measuring the fat content of nuts?</p>
                                    <div class="space-y-2">
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q23_24[]" value="A" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">A</strong> She used the wrong sort of nuts.</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q23_24[]" value="B" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">B</strong> She used an unsuitable chemical.</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q23_24[]" value="C" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">C</strong> She did not grind the nuts finely enough.</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q23_24[]" value="D" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">D</strong> The information on the nut package was incorrect.</span>
                                        </label>
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q23_24[]" value="E" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700"><strong class="mr-2">E</strong> The weighing scales may have been unsuitable.</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Questions 25-30: Multiple Choice -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 25–30: Choose the correct letter, A, B or C.</h3>
                                
                                <div class="space-y-6">
                                    <!-- Q25 -->
                                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4"><span class="font-bold mr-2">25</span> Adam suggests that restaurants could reduce obesity if their menus</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q25" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> offered fewer options.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q25" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> had more low-calorie foods.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q25" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> were organised in a particular way.</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Q26 -->
                                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4"><span class="font-bold mr-2">26</span> The students agree that food manufacturers deliberately</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q26" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> make calorie counts hard to understand.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q26" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> fail to provide accurate calorie counts.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q26" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> use ineffective methods to reduce calories.</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Q27 -->
                                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4"><span class="font-bold mr-2">27</span> What does Rosie say about levels of exercise in England?</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q27" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> The amount recommended is much too low.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q27" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> Most people overestimate how much they do.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q27" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> Women now exercise more than they used to.</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Q28 -->
                                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4"><span class="font-bold mr-2">28</span> Adam refers to the location and width of stairs in a train station to illustrate</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q28" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> practical changes that can influence people’s behaviour.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q28" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> methods of helping people who have mobility problems.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q28" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> ways of preventing accidents by controlling crowd movement.</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Q29 -->
                                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4"><span class="font-bold mr-2">29</span> What do the students agree about including reference to exercise in their presentation?</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q29" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> They should probably leave it out.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q29" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> They need to do more research on it.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q29" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> They should discuss this with their tutor.</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Q30 -->
                                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4"><span class="font-bold mr-2">30</span> What are the students going to do next for their presentation?</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q30" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> prepare some slides for it</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q30" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> find out how long they have for it</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q30" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> decide on its content and organisation</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                         <button @click="step = 2" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Previous Part
                        </button>
                        <button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Next Part
                        </button>
                    </div>
                 </div>

                 <!-- Part 4: Hand knitting -->
                 <div x-show="step === 4" x-cloak>
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
                            <p class="italic">Complete the notes below.</p>
                            <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                        </div>
                        
                         <div class="bg-white border-2 border-gray-800 p-0 rounded-none shadow-none text-gray-900">
                            <!-- Header -->
                            <div class="border-b-2 border-gray-800 p-4 text-center">
                                <h4 class="text-2xl font-bold uppercase tracking-wide">Hand knitting</h4>
                            </div>
                            
                            <div class="p-6 space-y-8">
                                <div class="space-y-6">
                                    <!-- Interest in knitting -->
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-2">Interest in knitting</h4>
                                        <ul class="list-disc pl-5 space-y-3 text-gray-700 leading-relaxed">
                                            <li>Knitting has a long history around the world.</li>
                                            <li>
                                                We imagine someone like a <span class="font-bold">31</span>
                                                <input type="text" name="q31" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                knitting.
                                            </li>
                                            <li>
                                                A <span class="font-bold">32</span>
                                                <input type="text" name="q32" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                ago, knitting was expected to disappear.
                                            </li>
                                            <li>The number of knitting classes is now increasing.</li>
                                            <li>
                                                People are buying more <span class="font-bold">33</span>
                                                <input type="text" name="q33" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                for knitting nowadays.
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Benefits of knitting -->
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-2">Benefits of knitting</h4>
                                        <ul class="list-disc pl-5 space-y-3 text-gray-700 leading-relaxed">
                                            <li>
                                                gives support in times of <span class="font-bold">34</span>
                                                <input type="text" name="q34" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                difficulty
                                            </li>
                                            <li>
                                                requires only <span class="font-bold">35</span>
                                                <input type="text" name="q35" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                skills and little money to start
                                            </li>
                                            <li>reduces stress in a busy life</li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Early knitting -->
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-2">Early knitting</h4>
                                        <ul class="list-disc pl-5 space-y-3 text-gray-700 leading-relaxed">
                                            <li>The origins are not known.</li>
                                            <li>
                                                Findings show early knitted items to be <span class="font-bold">36</span>
                                                <input type="text" name="q36" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                in shape.
                                            </li>
                                            <li>
                                                The first needles were made of natural materials such as wood and <span class="font-bold">37</span>
                                                <input type="text" name="q37" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                .
                                            </li>
                                            <li>
                                                Early yarns felt <span class="font-bold">38</span>
                                                <input type="text" name="q38" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                to touch.
                                            </li>
                                            <li>Wool became the most popular yarn for spinning.</li>
                                            <li>
                                                Geographical areas had their own <span class="font-bold">39</span>
                                                <input type="text" name="q39" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                of knitting.
                                            </li>
                                            <li>
                                                Everyday tasks like looking after <span class="font-bold">40</span>
                                                <input type="text" name="q40" class="w-48 border-b-2 border-gray-400 bg-transparent text-center font-bold text-blue-800 focus:border-blue-600 focus:outline-none mx-2">
                                                were done while knitting.
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                         <button @click="step = 3" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Previous Part
                        </button>
                        <button onclick="alert('Submission logic implementation pending.')" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Submit Test
                        </button>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
