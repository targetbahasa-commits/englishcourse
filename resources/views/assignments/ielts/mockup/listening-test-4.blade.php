<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Up 4 - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .paper-shadow {
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        }
    </style>
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div class="flex min-h-screen">
         {{-- Sidebar --}}
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

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
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Listening Mock Up 4</h1>
                             <p class="text-gray-600 mt-1">Full Listening Test</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge.edition', ['edition' => $edition]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-white border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
                </div>
            </div>

            <div x-data="{ step: 1 }" x-init="$watch('step', value => $dispatch('part-changed', value))">
                <!-- Part 1: Holiday rental -->
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
                            <div class="border-b-2 border-gray-800 p-4 text-center bg-white">
                                <h3 class="text-xl font-bold text-center text-gray-800">Holiday rental</h3>
                            </div>
                            
                            <!-- Sub-header -->
                            <div class="border-b-2 border-gray-800 p-2 pl-6 bg-white">
                                <p class="text-gray-700 text-center"><span class="font-bold">Owners' names:</span> Jack Fitzgerald and Shirley Fitzgerald</p>
                            </div>

                            <div class="p-6 space-y-8">
                                <!-- Granary Cottage -->
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg mb-2">Granary Cottage</h4>
                                    <ul class="list-disc pl-5 space-y-3 text-gray-700 leading-relaxed text-lg">
                                        <li>
                                            available for week beginning 1
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <input type="text" name="q1" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            May
                                        </li>
                                        <li>
                                            cost for the week: 2
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="font-bold text-xl mr-1">£</span>
                                                <input type="text" name="q2" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Second Cottage -->
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                            <input type="text" name="q3" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                        </span>
                                        <h4 class="font-bold text-gray-800 text-lg">Cottage</h4>
                                    </div>
                                    <ul class="list-disc pl-5 space-y-3 text-gray-700 leading-relaxed text-lg">
                                        <li>cost for the week: £480</li>
                                        <li>
                                            building was originally a 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <input type="text" name="q4" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                        </li>
                                        <li>
                                            walk through doors from living room into a 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <input type="text" name="q5" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                        </li>
                                        <li>
                                            several 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <input type="text" name="q6" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            spaces at the front
                                        </li>
                                        <li>bathroom has a shower</li>
                                        <li>
                                            central heating and stove that burns 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <input type="text" name="q7" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                        </li>
                                        <li>
                                            views of old 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <input type="text" name="q8" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            from living room
                                        </li>
                                        <li>
                                            view of hilltop 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <input type="text" name="q9" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            from the bedroom
                                        </li>
                                    </ul>
                                </div>
                                
                                <!-- Payment -->
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg mb-2">Payment</h4>
                                    <ul class="list-disc pl-5 space-y-3 text-gray-700 leading-relaxed text-lg">
                                        <li>deposit: £144</li>
                                        <li>
                                            deadline for final payment: end of 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <input type="text" name="q10" class="w-48 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
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

                <!-- Part 2: Local Council -->
                <div x-show="step === 2" x-cloak>
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
                        </div>
                        
                         <div class="space-y-12">
                            <!-- Questions 11-14: Multiple Choice -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 11–14: Choose the correct letter, A, B or C.</h3>
                                
                                <div class="bg-white p-6 rounded-xl border border-blue-100">
                                     <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Local council report on traffic and highways</h2>
                                </div>

                                <div class="space-y-6">
                                    <!-- Q11 -->
                                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4 text-lg"><span class="font-bold mr-2">11</span> A survey found people's main concern about traffic in the area was</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q11" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">A</strong> cuts to public transport.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q11" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">B</strong> poor maintenance of roads.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q11" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">C</strong> changes in the type of traffic.</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Q12 -->
                                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4 text-lg"><span class="font-bold mr-2">12</span> Which change will shortly be made to the cycle path next to the river?</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q12" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">A</strong> It will be widened.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q12" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">B</strong> It will be extended.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q12" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">C</strong> It will be resurfaced.</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Q13 -->
                                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4 text-lg"><span class="font-bold mr-2">13</span> Plans for a pedestrian crossing have been postponed because</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q13" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">A</strong> the Post Office has moved.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q13" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">B</strong> the proposed location is unsafe.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q13" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">C</strong> funding is not available at present.</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Q14 -->
                                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                                        <p class="font-medium text-gray-900 mb-4 text-lg"><span class="font-bold mr-2">14</span> On Station Road, notices have been erected</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q14" value="A" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">A</strong> telling cyclists not to leave their bikes outside the station ticket office.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q14" value="B" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">B</strong> asking motorists to switch off engines when waiting at the level crossing.</span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q14" value="C" class="text-blue-600 focus:ring-blue-500">
                                                <span class="text-gray-700 text-lg"><strong class="mr-2">C</strong> warning pedestrians to leave enough time when crossing the railway line.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Questions 15-20: Label Map -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 15–20: Label the map below.</h3>
                                <p class="text-gray-600 ml-4">Write the correct letter, <strong>A–I</strong>, next to Questions 15–20.</p>
                                
                                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                                    <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Recreation ground after proposed changes</h2>
                                    
                                     <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                        <!-- Map Image -->
                                        <div class="lg:col-span-2 relative rounded-xl overflow-hidden border border-gray-200">
                                            <img src="{{ asset('images/ielts/listening/recreation-ground-map.png') }}" alt="Recreation ground map" class="w-full h-auto">
                                        </div>

                                        <!-- Questions -->
                                        <div class="space-y-4">
                                            @foreach([
                                                15 => 'New car park',
                                                16 => 'New cricket pitch',
                                                17 => 'Children’s playground',
                                                18 => 'Skateboard ramp',
                                                19 => 'Pavilion',
                                                20 => 'Notice board'
                                            ] as $num => $label)
                                                <div class="flex items-center justify-between p-3 bg-white rounded-lg hover:bg-white transition border border-gray-100">
                                                    <div class="flex items-center gap-4">
                                                        <span class="font-bold text-gray-700 w-8">{{ $num }}</span>
                                                        <span class="text-base font-medium text-gray-800">{{ $label }}</span>
                                                    </div>
                                                    <input type="text" 
                                                           name="q{{ $num }}" 
                                                           maxlength="1"
                                                           class="w-12 text-center font-bold text-blue-800 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-200 uppercase">
                                                </div>
                                            @endforeach
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

                <!-- Part 3: Bike-sharing schemes -->
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
                                
                                <div class="bg-white rounded-lg p-6 border border-gray-200">
                                    <p class="font-medium text-gray-900 mb-4 text-lg">Which <span class="font-bold">TWO</span> benefits of city bike-sharing schemes do the students agree are the most important?</p>
                                    <div class="space-y-2">
                                        @foreach(['A' => 'reducing noise pollution', 'B' => 'reducing traffic congestion', 'C' => 'improving air quality', 'D' => 'encouraging health and fitness', 'E' => 'making cycling affordable'] as $key => $option)
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q21_22[]" value="{{ $key }}" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700 text-lg"><strong class="mr-2">{{ $key }}</strong> {{ $option }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Questions 23-24: Multiple Select -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 23 and 24: Choose TWO letters, A–E.</h3>
                                
                                <div class="bg-white rounded-lg p-6 border border-gray-200">
                                    <p class="font-medium text-gray-900 mb-4 text-lg">Which <span class="font-bold">TWO</span> things do the students think are necessary for successful bike-sharing schemes?</p>
                                    <div class="space-y-2">
                                        @foreach(['A' => 'Bikes should have a GPS system.', 'B' => 'The app should be easy to use.', 'C' => 'Public awareness should be raised.', 'D' => 'Only one scheme should be available.', 'E' => 'There should be a large network of cycle lanes.'] as $key => $option)
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="q23_24[]" value="{{ $key }}" class="mt-1 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-gray-700 text-lg"><strong class="mr-2">{{ $key }}</strong> {{ $option }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Questions 25-30: Matching -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 25–30: What is the speakers’ opinion of the bike-sharing schemes in each of the following cities?</h3>
                                <p class="text-gray-600 ml-4">Choose <strong>SIX</strong> answers from the box and write the correct letter, <strong>A–G</strong>, next to Questions 25–30.</p>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                                    <!-- Options Box -->
                                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                                        <h4 class="font-bold text-center text-xl text-gray-800 mb-6 border-b pb-4">Opinion of bike-sharing scheme</h4>
                                        <div class="space-y-4 text-lg text-gray-700 font-medium">
                                            <div class="flex gap-4"><span class="font-bold w-6 text-gray-900">A</span> <span>They agree it has been disappointing.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-6 text-gray-900">B</span> <span>They think it should be cheaper.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-6 text-gray-900">C</span> <span>They are surprised it has been so successful.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-6 text-gray-900">D</span> <span>They agree that more investment is required.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-6 text-gray-900">E</span> <span>They think the system has been well designed.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-6 text-gray-900">F</span> <span>They disagree about the reasons for its success.</span></div>
                                            <div class="flex gap-4"><span class="font-bold w-6 text-gray-900">G</span> <span>They think it has expanded too quickly.</span></div>
                                        </div>
                                    </div>
 
                                    <!-- Questions -->
                                    <div class="space-y-4">
                                        <h4 class="font-bold text-gray-800 mb-2">Cities</h4>
                                        
                                        @foreach([
                                            25 => 'Amsterdam',
                                            26 => 'Dublin',
                                            27 => 'London',
                                            28 => 'Buenos Aires',
                                            29 => 'New York',
                                            30 => 'Sydney'
                                        ] as $num => $city)
                                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                            <div class="flex gap-3">
                                                <span class="font-bold text-gray-800">{{ $num }}</span>
                                                <span class="text-gray-700">{{ $city }}</span>
                                            </div>
                                            <input type="text" name="q{{ $num }}" class="w-16 border-2 border-gray-300 rounded-lg text-center font-bold text-blue-800 focus:border-blue-500 focus:ring-blue-200 uppercase" maxlength="1">
                                        </div>
                                        @endforeach
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

                 <!-- Part 4: The extinction of the Dodo Bird -->
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
                                <h4 class="text-2xl font-bold uppercase tracking-wide">THE EXTINCTION OF THE DODO BIRD</h4>
                            </div>
                            
                            <div class="p-6 space-y-8">
                                <p class="text-gray-600 mb-4 text-center italic">The dodo was a large flightless bird which used to inhabit the island of Mauritius.</p>
                                
                                <div class="space-y-6">
                                    <!-- History -->
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-2 border-b pb-1">History</h4>
                                        <ul class="list-disc pl-5 space-y-3 text-gray-700 leading-relaxed text-lg">
                                            <li>
                                                1507 – Portuguese ships transporting 
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">31</span>
                                                    <input type="text" name="q31" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>
                                                stopped at the island to collect food and water.
                                            </li>
                                            <li>
                                                1638 – The Dutch established a 
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">32</span>
                                                    <input type="text" name="q32" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>
                                                on the island.
                                            </li>
                                            <li>They killed the dodo birds for their meat.</li>
                                            <li>The last one was killed in 1681.</li>
                                        </ul>
                                    </div>

                                    <!-- Description -->
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-2 border-b pb-1">Description</h4>
                                        <ul class="list-disc pl-5 space-y-3 text-gray-700 leading-relaxed text-lg">
                                            <li>The only record we have is written descriptions and pictures (possibly unreliable).</li>
                                            <li>
                                                A Dutch painting suggests the dodo was very 
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">33</span>
                                                    <input type="text" name="q33" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>.
                                            </li>
                                            <li>
                                                The only remaining soft tissue is a dried 
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">34</span>
                                                    <input type="text" name="q34" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>.
                                            </li>
                                            <li>
                                                Recent studies of a dodo skeleton suggest the birds were capable of rapid 
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">35</span>
                                                    <input type="text" name="q35" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>.
                                            </li>
                                            <li>
                                                It’s thought they were able to use their small wings to maintain 
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">36</span>
                                                    <input type="text" name="q36" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>.
                                            </li>
                                            <li>
                                                Their 
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">37</span>
                                                    <input type="text" name="q37" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>
                                                was of average size.
                                            </li>
                                            <li>
                                                Their sense of 
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">38</span>
                                                    <input type="text" name="q38" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>
                                                enabled them to find food.
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Reasons for extinction -->
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-2 border-b pb-1">Reasons for extinction</h4>
                                        <ul class="list-disc pl-5 space-y-3 text-gray-700 leading-relaxed text-lg">
                                            <li>Hunting was probably not the main cause.</li>
                                            <li>Sailors brought dogs and monkeys.</li>
                                            <li>
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">39</span>
                                                    <input type="text" name="q39" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>
                                                also escaped onto the island and ate the birds’ eggs.
                                            </li>
                                            <li>
                                                The arrival of farming meant the 
                                                <span class="inline-flex items-center gap-2 mx-1 align-middle">
                                                    <span class="font-bold text-gray-700">40</span>
                                                    <input type="text" name="q40" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none bg-white px-2 py-0.5 font-bold text-blue-900 placeholder-transparent transition-colors">
                                                </span>
                                                was destroyed.
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
