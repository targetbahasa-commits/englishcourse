<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Up 2 - {{ config('app.name', 'Target Bahasa') }}</title>
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
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Listening Mock Up 2</h1>
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
                <!-- Part 1: Copying photos to digital format (From Meeting 119) -->
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
                            <div class="border-b-2 border-gray-800 p-4 text-center">
                                <h4 class="text-2xl font-bold uppercase tracking-wide">Copying photos to digital format</h4>
                            </div>
                            
                            <!-- Company Name -->
                            <div class="border-b border-gray-300 p-4 bg-gray-50 font-bold">
                                Name of company: Picturerep
                            </div>

                            <div class="p-6 space-y-8">
                                <!-- Requirements -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg underline">Requirements</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>Maximum size of photos is 30 cm, minimum size 4 cm.</li>
                                        <li>
                                            Photos must not be in a 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">1</span>
                                                <input type="text" name="q1" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            or an album.
                                        </li>
                                    </ul>
                                </div>

                                <!-- Cost -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg underline">Cost</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>
                                            The cost for 360 photos is 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <strong class="text-lg">£</strong>
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">2</span>
                                                <input type="text" name="q2" class="w-32 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            (including one disk).
                                        </li>
                                        <li>
                                            Before the completed order is sent, 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">3</span>
                                                <input type="text" name="q3" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            is required.
                                        </li>
                                    </ul>
                                </div>

                                <!-- Services included -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg underline">Services included in the price</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>
                                            Photos can be placed in a folder, e.g. with the name 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">4</span>
                                                <input type="text" name="q4" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            .
                                        </li>
                                        <li>
                                            The 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">5</span>
                                                <input type="text" name="q5" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            and contrast can be improved if necessary.
                                        </li>
                                        <li>
                                            Photos which are very fragile will be scanned by 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">6</span>
                                                <input type="text" name="q6" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            .
                                        </li>
                                    </ul>
                                </div>

                                <!-- Special restore service -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg underline">Special restore service (costs extra)</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>
                                            It may be possible to remove an object from a photo, or change the 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">7</span>
                                                <input type="text" name="q7" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            .
                                        </li>
                                        <li>
                                            A photo which is not correctly in 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">8</span>
                                                <input type="text" name="q8" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            cannot be fixed.
                                        </li>
                                    </ul>
                                </div>

                                <!-- Other info -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg underline">Other information</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>
                                            Orders are completed within 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">9</span>
                                                <input type="text" name="q9" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            .
                                        </li>
                                        <li>
                                            Send the photos in a box (not 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">10</span>
                                                <input type="text" name="q10" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            ).
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

                <!-- END PART 1: To be continued... -->
                <!-- CONTENT PLACEHOLDERS FOR PARTS 2, 3, 4 -->
                <div x-show="step === 2" x-cloak>
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
                            <p class="italic">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                        </div>
                        
                         <!-- Dartfield House School -->
                        <div class="space-y-6">
                            <!-- Q11 -->
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <div class="flex gap-4">
                                    <span class="font-bold text-lg text-gray-800 flex-shrink-0">11</span>
                                    <div class="space-y-4 flex-1">
                                        <p class="font-medium text-gray-900">Dartfield House school used to be</p>
                                        <div class="space-y-2">
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q11" value="A" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> a tourist information centre.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q11" value="B" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> a private home.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q11" value="C" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> a local council building.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Q12 -->
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <div class="flex gap-4">
                                    <span class="font-bold text-lg text-gray-800 flex-shrink-0">12</span>
                                    <div class="space-y-4 flex-1">
                                        <p class="font-medium text-gray-900">What is planned with regard to the lower school?</p>
                                        <div class="space-y-2">
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q12" value="A" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> All buildings on the main site will be improved.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q12" value="B" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> The lower school site will be used for new homes.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q12" value="C" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> Additional school buildings will be constructed on the lower school site.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Q13 -->
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <div class="flex gap-4">
                                    <span class="font-bold text-lg text-gray-800 flex-shrink-0">13</span>
                                    <div class="space-y-4 flex-1">
                                        <p class="font-medium text-gray-900">The catering has been changed because of</p>
                                        <div class="space-y-2">
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q13" value="A" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> long queuing times.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q13" value="B" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> changes to the school timetable.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q13" value="C" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> dissatisfaction with the menus.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Q14 -->
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <div class="flex gap-4">
                                    <span class="font-bold text-lg text-gray-800 flex-shrink-0">14</span>
                                    <div class="space-y-4 flex-1">
                                        <p class="font-medium text-gray-900">Parents are asked to</p>
                                        <div class="space-y-2">
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q14" value="A" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> help their children to decide in advance which serving point to use.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q14" value="B" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> make sure their children have enough money for food.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q14" value="C" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> advise their children on healthy food to eat.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Q15 -->
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <div class="flex gap-4">
                                    <span class="font-bold text-lg text-gray-800 flex-shrink-0">15</span>
                                    <div class="space-y-4 flex-1">
                                        <p class="font-medium text-gray-900">What does the speaker say about the existing canteen?</p>
                                        <div class="space-y-2">
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q15" value="A" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> Food will still be served there.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q15" value="B" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> Only staff will have access to it.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q15" value="C" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> Pupils can take their food into it.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Questions 16-18 -->
                        <div class="space-y-6 mt-8">
                             <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 16–18: What comment does the speaker make about each of the following serving points in the Food Hall? Choose THREE answers from the box.</h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                                <!-- Options Box -->
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                                    <h4 class="font-bold text-xl text-center text-gray-800 mb-4 border-b pb-2">Comments</h4>
                                    <div class="space-y-3 text-lg text-gray-700 font-medium">
                                        <div class="flex gap-3"><span class="font-bold w-6">A</span> pupils help to plan menus</div>
                                        <div class="flex gap-3"><span class="font-bold w-6">B</span> only vegetarian food</div>
                                        <div class="flex gap-3"><span class="font-bold w-6">C</span> different food every week</div>
                                        <div class="flex gap-3"><span class="font-bold w-6">D</span> daily change in menu</div>
                                    </div>
                                </div>

                                <!-- Questions -->
                                <div class="space-y-4">
                                    <h4 class="font-bold text-gray-800 mb-2">Food available at serving points in Food Hall</h4>
                                    <!-- Q16 -->
                                    <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                        <div class="flex gap-3">
                                            <span class="font-bold text-gray-800">16</span>
                                            <span class="text-gray-700">World Adventures</span>
                                        </div>
                                        <input type="text" name="q16" class="w-16 text-center border-b-2 border-gray-300 focus:border-red-500 outline-none uppercase font-bold" maxlength="1">
                                    </div>
                                    
                                    <!-- Q17 -->
                                    <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                        <div class="flex gap-3">
                                            <span class="font-bold text-gray-800">17</span>
                                            <span class="text-gray-700">Street Life</span>
                                        </div>
                                        <input type="text" name="q17" class="w-16 text-center border-b-2 border-gray-300 focus:border-red-500 outline-none uppercase font-bold" maxlength="1">
                                    </div>

                                    <!-- Q18 -->
                                    <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                        <div class="flex gap-3">
                                            <span class="font-bold text-gray-800">18</span>
                                            <span class="text-gray-700">Speedy Italian</span>
                                        </div>
                                        <input type="text" name="q18" class="w-16 text-center border-b-2 border-gray-300 focus:border-red-500 outline-none uppercase font-bold" maxlength="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Questions 19-20 -->
                        <div class="space-y-6 mt-8">
                            <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 19 and 20: Choose TWO letters, A–E.</h3>
                            
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <p class="font-bold text-gray-900 mb-4 h4">Which TWO optional after-school lessons are new?</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-300 cursor-pointer shadow-sm">
                                        <input type="checkbox" name="q19_20[]" value="A" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                        <span class="font-medium text-gray-700"><span class="font-bold mr-1">A</span> swimming</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-300 cursor-pointer shadow-sm">
                                        <input type="checkbox" name="q19_20[]" value="B" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                        <span class="font-medium text-gray-700"><span class="font-bold mr-1">B</span> piano</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-300 cursor-pointer shadow-sm">
                                        <input type="checkbox" name="q19_20[]" value="C" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                        <span class="font-medium text-gray-700"><span class="font-bold mr-1">C</span> acting</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-300 cursor-pointer shadow-sm">
                                        <input type="checkbox" name="q19_20[]" value="D" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                        <span class="font-medium text-gray-700"><span class="font-bold mr-1">D</span> cycling</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-300 cursor-pointer shadow-sm">
                                        <input type="checkbox" name="q19_20[]" value="E" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                        <span class="font-medium text-gray-700"><span class="font-bold mr-1">E</span> theatre sound and lighting</span>
                                    </label>
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
                <div x-show="step === 3" x-cloak>
                    <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
                            <p class="italic">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                        </div>
                        
                        <!-- Assignment on sleep and dreams -->
                        <div class="space-y-6">
                            <h4 class="text-xl font-bold text-center text-gray-800 mb-6">Assignment on sleep and dreams</h4>

                            <!-- Q21 -->
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <div class="flex gap-4">
                                    <span class="font-bold text-lg text-gray-800 flex-shrink-0">21</span>
                                    <div class="space-y-4 flex-1">
                                        <p class="font-medium text-gray-900">Luke read that one reason why we often forget dreams is that</p>
                                        <div class="space-y-2">
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q21" value="A" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> our memories cannot cope with too much information.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q21" value="B" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> we might otherwise be confused about what is real.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q21" value="C" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> we do not think they are important.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Q22 -->
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <div class="flex gap-4">
                                    <span class="font-bold text-lg text-gray-800 flex-shrink-0">22</span>
                                    <div class="space-y-4 flex-1">
                                        <p class="font-medium text-gray-900">What do Luke and Susie agree about dreams predicting the future?</p>
                                        <div class="space-y-2">
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q22" value="A" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> It may just be due to chance.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q22" value="B" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> It only happens with certain types of event.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q22" value="C" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> It happens more often than some people think.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Q23 -->
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <div class="flex gap-4">
                                    <span class="font-bold text-lg text-gray-800 flex-shrink-0">23</span>
                                    <div class="space-y-4 flex-1">
                                        <p class="font-medium text-gray-900">Susie says that a study on pre-school children having a short nap in the day</p>
                                        <div class="space-y-2">
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q23" value="A" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> had controversial results.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q23" value="B" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> used faulty research methodology.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q23" value="C" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> failed to reach any clear conclusions.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Q24 -->
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <div class="flex gap-4">
                                    <span class="font-bold text-lg text-gray-800 flex-shrink-0">24</span>
                                    <div class="space-y-4 flex-1">
                                        <p class="font-medium text-gray-900">In their last assignment, both students had problems with</p>
                                        <div class="space-y-2">
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q24" value="A" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">A</strong> statistical analysis.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q24" value="B" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">B</strong> making an action plan.</span>
                                            </label>
                                            <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <input type="radio" name="q24" value="C" class="mt-1 text-red-600 focus:ring-red-500">
                                                <span class="text-gray-700"><strong class="mr-2">C</strong> self-assessment.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Questions 25-30: Flow Chart -->
                        <div class="space-y-6 mt-8">
                            <h3 class="font-bold text-lg text-gray-700 italic border-l-4 border-blue-500 pl-3">Questions 25–30: Complete the flow chart below. Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</h3>
                            
                            <div class="bg-white border-2 border-gray-800 p-8 rounded-lg">
                                <h4 class="text-xl font-bold text-center text-gray-900 mb-8 uppercase">Assignment Plan</h4>
                                
                                <div class="space-y-4 max-w-3xl mx-auto">
                                    <!-- Step 1 -->
                                    <div class="border-2 border-gray-800 p-4 text-center bg-white relative">
                                        <p class="font-bold mb-2">Decide on research question:</p>
                                        <p class="text-gray-700">Is there a relationship between hours of sleep and number of dreams?</p>
                                        <!-- Arrow -->
                                        <div class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 text-gray-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        </div>
                                    </div>
                                    <div class="h-4"></div>

                                    <!-- Step 2 -->
                                    <div class="border-2 border-gray-800 p-4 text-center bg-white relative">
                                        <p class="font-bold mb-2">Decide on sample:</p>
                                        <p class="text-gray-700 flex justify-center items-center gap-2">
                                            Twelve students from the 
                                            <span class="inline-flex items-center gap-2">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm">25</span>
                                                <input type="text" name="q25" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none text-center font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            department
                                        </p>
                                        <!-- Arrow -->
                                        <div class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 text-gray-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        </div>
                                    </div>
                                    <div class="h-4"></div>

                                    <!-- Step 3 -->
                                    <div class="border-2 border-gray-800 p-4 text-center bg-white relative">
                                        <p class="font-bold mb-2">Decide on methodology:</p>
                                        <p class="text-gray-700">Self-reporting</p>
                                        <!-- Arrow -->
                                        <div class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 text-gray-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        </div>
                                    </div>
                                    <div class="h-4"></div>

                                    <!-- Step 4 -->
                                    <div class="border-2 border-gray-800 p-4 text-center bg-white relative">
                                        <p class="font-bold mb-2">Decide on procedure:</p>
                                        <p class="text-gray-700 flex justify-center items-center gap-2">
                                            Answers on 
                                            <span class="inline-flex items-center gap-2">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm">26</span>
                                                <input type="text" name="q26" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none text-center font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                        </p>
                                        <!-- Arrow -->
                                        <div class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 text-gray-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        </div>
                                    </div>
                                    <div class="h-4"></div>

                                    <!-- Step 5 -->
                                    <div class="border-2 border-gray-800 p-4 text-center bg-white relative">
                                        <p class="font-bold mb-2 flex justify-center items-center gap-2">
                                            Check ethical guidelines for working with 
                                            <span class="inline-flex items-center gap-2">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm">27</span>
                                                <input type="text" name="q27" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none text-center font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                        </p>
                                        <div class="h-px bg-gray-300 w-1/2 mx-auto my-2"></div>
                                        <p class="text-gray-700 flex justify-center items-center gap-2">
                                            Ensure that risk is assessed and 
                                            <span class="inline-flex items-center gap-2">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm">28</span>
                                                <input type="text" name="q28" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none text-center font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            is kept to a minimum
                                        </p>
                                        <!-- Arrow -->
                                        <div class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 text-gray-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        </div>
                                    </div>
                                    <div class="h-4"></div>

                                    <!-- Step 6 -->
                                    <div class="border-2 border-gray-800 p-4 text-center bg-white relative">
                                        <p class="font-bold mb-2">Analyse the results</p>
                                        <p class="text-gray-700 flex justify-center items-center gap-2">
                                            Calculate the correlation and make a 
                                            <span class="inline-flex items-center gap-2">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm">29</span>
                                                <input type="text" name="q29" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none text-center font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                        </p>
                                        <!-- Arrow -->
                                        <div class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 text-gray-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        </div>
                                    </div>
                                    <div class="h-4"></div>

                                    <!-- Step 7 -->
                                    <div class="border-2 border-gray-800 p-4 text-center bg-white">
                                        <p class="text-gray-700 flex justify-center items-center gap-2">
                                            <span class="inline-flex items-center gap-2">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm">30</span>
                                                <input type="text" name="q30" class="w-40 border-b-2 border-dotted border-gray-400 focus:border-red-600 focus:outline-none text-center font-bold text-blue-900 placeholder-transparent transition-colors">
                                            </span>
                                            the research
                                        </p>
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
                        
                         <!-- Health benefits of dance -->
                         <div class="bg-white border-2 border-gray-800 p-0 rounded-none shadow-none text-gray-900">
                            <!-- Header -->
                            <div class="border-b-2 border-gray-800 p-4 text-center">
                                <h4 class="text-2xl font-bold uppercase tracking-wide">Health benefits of dance</h4>
                            </div>
                            
                            <div class="p-6 space-y-8">
                                <!-- Recent findings -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg underline">Recent findings</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>All forms of dance produce various hormones associated with feelings of happiness.</li>
                                        <li>Dancing with others has a more positive impact than dancing alone.</li>
                                        <li>
                                            An experiment on university students suggested that dance increases 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">31</span>
                                                <input type="text" name="q31" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            .
                                        </li>
                                        <li>
                                            For those with mental illness, dance could be used as a form of 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">32</span>
                                                <input type="text" name="q32" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            .
                                        </li>
                                    </ul>
                                </div>

                                <!-- Benefits of dance for older people -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg underline">Benefits of dance for older people</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>
                                            accessible for people with low levels of 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">33</span>
                                                <input type="text" name="q33" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                        </li>
                                        <li>reduces the risk of heart disease</li>
                                        <li>
                                            better 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">34</span>
                                                <input type="text" name="q34" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            reduces the risk of accidents
                                        </li>
                                        <li>
                                            improves 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">35</span>
                                                <input type="text" name="q35" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            function by making it work faster
                                        </li>
                                        <li>improves participants' general well-being</li>
                                        <li>
                                            gives people more 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">36</span>
                                                <input type="text" name="q36" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            to take exercise
                                        </li>
                                        <li>
                                            can lessen the feeling of 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">37</span>
                                                <input type="text" name="q37" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            , very common in older people
                                        </li>
                                    </ul>
                                </div>

                                <!-- Benefits of Zumba -->
                                <div class="space-y-3">
                                    <h5 class="font-bold text-lg underline">Benefits of Zumba</h5>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li>
                                            A study at The University of Wisconsin showed that doing Zumba for 40 minutes uses up as many 
                                            <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">38</span>
                                                <input type="text" name="q38" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                            </span>
                                            as other quite intense forms of exercise.
                                        </li>
                                        <li>
                                            The <em>American Journal of Health Behavior</em> study showed that:
                                            <ul class="list-[circle] pl-5 mt-2 space-y-2">
                                                <li>
                                                    women suffering from 
                                                    <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                        <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">39</span>
                                                        <input type="text" name="q39" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                                    </span>
                                                    benefited from doing Zumba.
                                                </li>
                                                <li>
                                                    Zumba became a 
                                                    <span class="inline-flex items-center gap-2 mx-1 align-baseline relative top-1">
                                                        <span class="bg-gray-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">40</span>
                                                        <input type="text" name="q40" class="w-48 border-b-2 border-gray-400 focus:border-red-600 focus:outline-none bg-yellow-50 px-2 py-0.5 font-bold text-blue-900 placeholder-gray-400 transition-colors" placeholder="Answer">
                                                    </span>
                                                    for the participants.
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                         <button @click="step = 3" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Previous Part
                        </button>
                         <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all" onclick="alert('Submission logic implementation pending.')">
                            Submit Test
                        </button>
                    </div>
                 </div>

            </div>
        </main>
    </div>

    {{-- Floating Audio Player --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-50 md:pl-64 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">Track 1</p>
                    <p class="text-xs text-gray-500">IELTS Listening Mock Up</p>
                </div>
            </div>
            
            <div class="flex flex-1 items-center justify-center gap-4 max-w-3xl">
                <!-- Rewind 10s -->
                <button onclick="document.getElementById('audioPlayer').currentTime -= 10" class="flex flex-col items-center text-gray-500 hover:text-purple-600 transition group" title="Rewind 10 seconds">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path></svg>
                    <span class="text-[10px] font-bold">-10s</span>
                </button>

                <audio id="audioPlayer" controls class="w-full">
                    <source src="#" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>

                <!-- Forward 10s -->
                <button onclick="document.getElementById('audioPlayer').currentTime += 10" class="flex flex-col items-center text-gray-500 hover:text-purple-600 transition group" title="Forward 10 seconds">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path></svg>
                    <span class="text-[10px] font-bold">+10s</span>
                </button>
            </div>

            <button class="p-2 text-gray-400 hover:text-gray-600 transition" title="Close Player" onclick="this.parentElement.parentElement.style.display='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
    
    <!-- Add padding to bottom of main content to prevent overlap -->
    <style>
        main { padding-bottom: 100px !important; }
    </style>
</body>
</html>
