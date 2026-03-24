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
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Listening – Mock Test {{ $testId ?? 2 }}</h1>
                             <p class="text-gray-600 mt-1">Cambridge {{ $edition ?? 20 }} Listening Practice</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition ?? 20, 'id' => $testId ?? 2]) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2 border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div x-data="{ step: 1 }">
                <!-- Part 1 -->
<div x-show="step === 1">

<div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
    <div class="flex justify-center mb-6">
        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
    </div>

    <div class="mb-6">
        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1–10</span></h3>
        <p class="italic mb-2">Complete the notes below.</p>
        <p class="italic">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>
    </div>

    <div class="p-6 border border-gray-300">
        <p class="mb-4">Local councils can arrange practical support to help those caring for elderly people at home.</p>
        <p class="mb-2 mt-4 font-semibold">This can give the carer:</p>
        <ul class="list-disc list-outside ml-6 space-y-4 mb-8">
            <li>time for other responsibilities</li>
            <li class="leading-loose pl-1">
                a <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">1</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span>
            </li>
        </ul>

        <h4 class="font-bold text-md mt-8 mb-4">Assessment of mother’s needs</h4>
        <p class="mb-2">This may include discussion of:</p>
        <ul class="list-disc list-outside ml-6 space-y-4">
            <li class="leading-loose pl-1">how much <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">2</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> the caring involves</li>
            <li>what types of tasks are involved, e.g.
                <ul class="list-none ml-2 space-y-3 mt-3">
                    <li class="flex items-center"><span class="mr-2">-</span> help with dressing</li>
                    <li class="flex items-center leading-loose"><span class="mr-2">-</span> helping her have a <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">3</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span></li>
                    <li class="flex items-center"><span class="mr-2">-</span> shopping</li>
                    <li class="flex items-center"><span class="mr-2">-</span> helping with meals</li>
                    <li class="flex items-center leading-loose"><span class="mr-2">-</span> dealing with <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">4</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span></li>
                </ul>
            </li>
            <li>any aspects of caring that are especially difficult, e.g.
                <ul class="list-none ml-2 space-y-3 mt-3">
                    <li class="flex items-center leading-loose"><span class="mr-2">-</span> loss of <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">5</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span></li>
                    <li class="flex items-center leading-loose"><span class="mr-2">-</span> <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mr-1 text-lg">6</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> her</li>
                    <li class="flex items-center leading-loose"><span class="mr-2">-</span> preventing a <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">7</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span></li>
                </ul>
            </li>
        </ul>

        <h4 class="font-bold text-md mt-8 mb-4">Types of support that may be offered to carers</h4>
        <ul class="list-disc list-outside ml-6 space-y-4">
            <li class="leading-loose pl-1">transport costs, e.g. cost of a <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">8</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span></li>
            <li class="leading-loose pl-1">car-related costs, e.g. fuel and <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">9</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span></li>
            <li>help with housework</li>
            <li class="leading-loose pl-1">help to reduce <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">10</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span></li>
        </ul>
    </div>
</div>

<div class="max-w-5xl mx-auto mt-8 flex justify-end">
<button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
</div>
</div>

<!-- Part 2 -->
<div x-show="step === 2" x-cloak>

<div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
    <div class="flex justify-center mb-6">
        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
    </div>
    
    <div class="mb-6">
        <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
        <h4 class="font-bold text-md mb-2 mt-4">Questions 11–16</h4>
        <p class="italic mb-4">What is the role of the volunteers in each of the following activities?</p>
        <p class="mb-4">Choose <span class="font-bold">SIX</span> answers from the box and write the correct letter, <span class="font-bold">A-I</span>, next to Questions 11-16.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8 mb-12">
        <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg md:w-1/2 order-2 md:order-1 self-start shadow-sm">
            <ul class="space-y-3 font-medium">
                <li class="flex gap-4"><span class="font-bold">A</span> <span>providing entertainment</span></li>
                <li class="flex gap-4"><span class="font-bold">B</span> <span>providing publicity about a council service</span></li>
                <li class="flex gap-4"><span class="font-bold">C</span> <span>contacting local businesses</span></li>
                <li class="flex gap-4"><span class="font-bold">D</span> <span>giving advice to visitors</span></li>
                <li class="flex gap-4"><span class="font-bold">E</span> <span>collecting feedback on events</span></li>
                <li class="flex gap-4"><span class="font-bold">F</span> <span>selling tickets</span></li>
                <li class="flex gap-4"><span class="font-bold">G</span> <span>introducing guest speakers at an event</span></li>
                <li class="flex gap-4"><span class="font-bold">H</span> <span>encouraging cooperation between local organisations</span></li>
                <li class="flex gap-4"><span class="font-bold">I</span> <span>helping people find their seats</span></li>
            </ul>
        </div>
        <div class="md:w-1/2 order-1 md:order-2">
            <div class="space-y-5">
                <div class="flex items-center gap-3">
                    <span class="font-bold text-blue-700 text-lg w-6">11</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                    </select>
                    <span>walking around the town centre</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-bold text-blue-700 text-lg w-6">12</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                    </select>
                    <span>helping at concerts</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-bold text-blue-700 text-lg w-6">13</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                    </select>
                    <span>getting involved with community groups</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-bold text-blue-700 text-lg w-6">14</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                    </select>
                    <span>helping with a magazine</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-bold text-blue-700 text-lg w-6">15</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                    </select>
                    <span>participating at lunches for retired people</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-bold text-blue-700 text-lg w-6">16</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                    </select>
                    <span>helping with the website</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-12">
        <h4 class="font-bold text-md mb-2">Questions 17–20</h4>
        <p class="italic mb-6">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
        
        <div class="pl-4 space-y-8">
            <!-- Question 17 -->
            <div class="border-b border-gray-200 pb-6">
                <p class="font-semibold mb-3"><span class="font-bold mr-2">17</span> Which event requires the largest number of volunteers?</p>
                <div class="space-y-2 ml-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q17" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">A</span>
                        <span class="group-hover:text-blue-600 transition">the music festival</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q17" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">B</span>
                        <span class="group-hover:text-blue-600 transition">the science festival</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q17" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">C</span>
                        <span class="group-hover:text-blue-600 transition">the book festival</span>
                    </label>
                </div>
            </div>
            
            <!-- Question 18 -->
            <div class="border-b border-gray-200 pb-6">
                <p class="font-semibold mb-3"><span class="font-bold mr-2">18</span> What is the most important requirement for volunteers at the festivals?</p>
                <div class="space-y-2 ml-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q18" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">A</span>
                        <span class="group-hover:text-blue-600 transition">interpersonal skills</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q18" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">B</span>
                        <span class="group-hover:text-blue-600 transition">personal interest in the event</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q18" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">C</span>
                        <span class="group-hover:text-blue-600 transition">flexibility</span>
                    </label>
                </div>
            </div>
            
            <!-- Question 19 -->
            <div class="border-b border-gray-200 pb-6">
                <p class="font-semibold mb-3"><span class="font-bold mr-2">19</span> New volunteers will start working in the week beginning</p>
                <div class="space-y-2 ml-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q19" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">A</span>
                        <span class="group-hover:text-blue-600 transition">2 September.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q19" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">B</span>
                        <span class="group-hover:text-blue-600 transition">9 September.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q19" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">C</span>
                        <span class="group-hover:text-blue-600 transition">23 September.</span>
                    </label>
                </div>
            </div>

            <!-- Question 20 -->
            <div class="border-b border-gray-200 pb-6">
                <p class="font-semibold mb-3"><span class="font-bold mr-2">20</span> What is the next annual event for volunteers?</p>
                <div class="space-y-2 ml-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q20" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">A</span>
                        <span class="group-hover:text-blue-600 transition">a boat trip</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q20" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">B</span>
                        <span class="group-hover:text-blue-600 transition">a barbecue</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q20" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">C</span>
                        <span class="group-hover:text-blue-600 transition">a party</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto mt-8 flex justify-between">
<button @click="step = 1" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-xl transition-all">Previous Part</button>
<button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
</div>
</div>

<!-- Part 3 -->
<div x-show="step === 3" x-cloak>

<div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
    <div class="flex justify-center mb-6">
        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
    </div>
    
    <div class="mb-6">
        <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
        <h4 class="font-bold text-md mb-2 mt-4">Questions 21–25</h4>
        <p class="italic mb-4">What is Rosie and Colin's opinion about each of the following aspects of human geography?</p>
        <p class="mb-4">Choose <span class="font-bold">FIVE</span> answers from the box and write the correct letter, <span class="font-bold">A-G</span>, next to Questions 21-25.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8 mb-12">
        <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg md:w-1/2 order-2 md:order-1 self-start shadow-sm">
            <ul class="space-y-3 font-medium">
                <li class="flex gap-4"><span class="font-bold">A</span> <span>The information given about this was too vague.</span></li>
                <li class="flex gap-4"><span class="font-bold">B</span> <span>This may not be relevant to their course.</span></li>
                <li class="flex gap-4"><span class="font-bold">C</span> <span>This will involve only a small number of statistics.</span></li>
                <li class="flex gap-4"><span class="font-bold">D</span> <span>It will be easy to find facts about this.</span></li>
                <li class="flex gap-4"><span class="font-bold">E</span> <span>The facts about this may not be reliable.</span></li>
                <li class="flex gap-4"><span class="font-bold">F</span> <span>No useful research has been done on this.</span></li>
                <li class="flex gap-4"><span class="font-bold">G</span> <span>The information provided about this was interesting.</span></li>
            </ul>
        </div>
        <div class="md:w-1/2 order-1 md:order-2">
            <p class="font-bold mb-4">Aspects of human geography</p>
            <div class="space-y-5">
                <div class="flex items-center gap-4">
                    <span class="font-bold text-blue-700 text-lg w-6 text-right">21</span>
                    <span class="w-24 font-medium">Population</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span class="font-bold text-blue-700 text-lg w-6 text-right">22</span>
                    <span class="w-24 font-medium">Health</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span class="font-bold text-blue-700 text-lg w-6 text-right">23</span>
                    <span class="w-24 font-medium">Economies</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span class="font-bold text-blue-700 text-lg w-6 text-right">24</span>
                    <span class="w-24 font-medium">Culture</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span class="font-bold text-blue-700 text-lg w-6 text-right">25</span>
                    <span class="w-24 font-medium">Poverty</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-12">
        <h4 class="font-bold text-md mb-2">Questions 26–30</h4>
        <p class="italic mb-6">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
        
        <div class="pl-4 space-y-8">
            <!-- Question 26 -->
            <div class="border-b border-gray-200 pb-6">
                <p class="font-semibold mb-3"><span class="font-bold mr-2">26</span> Rosie says that in her own city the main problem is</p>
                <div class="space-y-2 ml-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q26" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">A</span>
                        <span class="group-hover:text-blue-600 transition">crime.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q26" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">B</span>
                        <span class="group-hover:text-blue-600 transition">housing.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q26" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">C</span>
                        <span class="group-hover:text-blue-600 transition">unemployment.</span>
                    </label>
                </div>
            </div>
            
            <!-- Question 27 -->
            <div class="border-b border-gray-200 pb-6">
                <p class="font-semibold mb-3"><span class="font-bold mr-2">27</span> What recent additions to the outskirts of their cities are both students happy about?</p>
                <div class="space-y-2 ml-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q27" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">A</span>
                        <span class="group-hover:text-blue-600 transition">conference centres</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q27" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">B</span>
                        <span class="group-hover:text-blue-600 transition">sports centres</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q27" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">C</span>
                        <span class="group-hover:text-blue-600 transition">retail centres</span>
                    </label>
                </div>
            </div>
            
            <!-- Question 28 -->
            <div class="border-b border-gray-200 pb-6">
                <p class="font-semibold mb-3"><span class="font-bold mr-2">28</span> The students agree that developing disused industrial sites may</p>
                <div class="space-y-2 ml-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q28" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">A</span>
                        <span class="group-hover:text-blue-600 transition">have unexpected costs.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q28" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">B</span>
                        <span class="group-hover:text-blue-600 transition">damage the urban environment.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q28" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">C</span>
                        <span class="group-hover:text-blue-600 transition">destroy valuable historical buildings.</span>
                    </label>
                </div>
            </div>

            <!-- Question 29 -->
            <div class="border-b border-gray-200 pb-6">
                <p class="font-semibold mb-3"><span class="font-bold mr-2">29</span> The students will mention Masdar City as an example of an attempt to achieve</p>
                <div class="space-y-2 ml-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q29" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">A</span>
                        <span class="group-hover:text-blue-600 transition">daily collections for waste recycling.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q29" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">B</span>
                        <span class="group-hover:text-blue-600 transition">sustainable energy use.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q29" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">C</span>
                        <span class="group-hover:text-blue-600 transition">free transport for everyone.</span>
                    </label>
                </div>
            </div>

            <!-- Question 30 -->
            <div class="border-b border-gray-200 pb-6">
                <p class="font-semibold mb-3"><span class="font-bold mr-2">30</span> When discussing the ecotown of Greenhill Abbots, Colin is uncertain about</p>
                <div class="space-y-2 ml-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q30" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">A</span>
                        <span class="group-hover:text-blue-600 transition">what its objectives were.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q30" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">B</span>
                        <span class="group-hover:text-blue-600 transition">why there was opposition to it.</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="q30" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="font-bold w-4">C</span>
                        <span class="group-hover:text-blue-600 transition">how much of it has actually been built.</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto mt-8 flex justify-between">
<button @click="step = 2" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-xl transition-all">Previous Part</button>
<button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
</div>
</div>

<!-- Part 4 -->
<div x-show="step === 4" x-cloak>

<div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
    <div class="flex justify-center mb-6">
        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
    </div>

    <div class="mb-6">
        <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
        <p class="italic mb-2">Complete the notes below.</p>
        <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
    </div>

    <div class="p-8 border border-gray-300 bg-gray-50 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-center mb-8">Developing food trends</h2>
        
        <ul class="list-disc list-outside ml-6 space-y-5 mb-8 text-lg">
            <li class="leading-loose pl-1">
                The growth in interest in food fashions started with <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-xl">31</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span> of food being shared on social media.
            </li>
            <li class="pl-1">The UK food industry is constantly developing products which are new or different.</li>
            <li class="pl-1">Influencers on social media become 'ambassadors' for a brand.
                <ul class="list-none ml-2 space-y-4 mt-4">
                    <li class="flex items-center leading-loose"><span class="mr-2 text-gray-500">-</span> Sales of <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-xl">32</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span> food brands have grown rapidly this way.</li>
                </ul>
            </li>
            <li class="pl-1">Supermarkets track demand for ingredients on social media.
                <ul class="list-none ml-2 space-y-4 mt-4">
                    <li class="flex items-center leading-loose"><span class="mr-2 text-gray-500">-</span> Famous <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-xl">33</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span> are influential.</li>
                </ul>
            </li>
        </ul>
        
        <p class="font-bold text-xl mt-12 mb-6">Marketing campaigns</p>
        <ul class="list-disc list-outside ml-6 space-y-5 mb-8 text-lg">
            <li class="pl-1">The avocado:
                <ul class="list-none ml-2 space-y-4 mt-4">
                    <li class="flex items-center leading-loose"><span class="mr-2 text-gray-500">-</span> <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mr-1 text-xl">34</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span> were invited to visit growers in South Africa.</li>
                    <li class="flex items-center leading-loose"><span class="mr-2 text-gray-500">-</span> Advertising focused on its <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-xl">35</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span> benefits.</li>
                </ul>
            </li>
            <li class="pl-1">Oat milk:
                <ul class="list-none ml-2 space-y-4 mt-4">
                    <li class="flex items-center"><span class="mr-2 text-gray-500">-</span> A Swedish brand's media campaign received publicity by upsetting competitors.</li>
                    <li class="flex items-center leading-loose"><span class="mr-2 text-gray-500">-</span> Promotion in the USA through <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-xl">36</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span> shops reduced the need for advertising.</li>
                    <li class="flex items-center leading-loose"><span class="mr-2 text-gray-500">-</span> It appealed to consumers who are concerned about the <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-xl">37</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span></li>
                </ul>
            </li>
            <li class="pl-1">Norwegian skrei:
                <ul class="list-none ml-2 space-y-4 mt-4">
                    <li class="flex items-center leading-loose"><span class="mr-2 text-gray-500">-</span> has helped strengthen the <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-xl">38</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span> of Norwegian seafood.</li>
                </ul>
            </li>
        </ul>

        <p class="font-bold text-xl mt-12 mb-6">Ethical concerns</p>
        <ul class="list-disc list-outside ml-6 space-y-5 text-lg">
            <li class="pl-1">Quinoa:
                <ul class="list-none ml-2 space-y-4 mt-4">
                    <li class="flex items-center leading-loose"><span class="mr-2 text-gray-500">-</span> Its success led to an increase in its <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-xl">39</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span></li>
                    <li class="flex items-center leading-loose"><span class="mr-2 text-gray-500">-</span> Overuse of resources resulted in poor quality <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-xl">40</span><input type="text" class="border border-gray-300 outline-none px-3 py-1 w-40 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1 shadow-sm"></span></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="max-w-5xl mx-auto mt-8 flex justify-between">
<button @click="step = 3" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
<button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Submit Answers</button>
</div>
</div>

        </main>
    </div>

    {{-- Audio Player Partial --}}
    @include('assignments.ielts.listening.partials.audio-player', ['set' => 'Mock Up ' . ($testId ?? 1), 'section' => $material ?? null])

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
