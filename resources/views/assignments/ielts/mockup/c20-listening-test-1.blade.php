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
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Listening – Mock Test {{ $testId ?? 1 }}</h1>
                             <p class="text-gray-600 mt-1">Cambridge {{ $edition ?? 20 }} Listening Practice</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition ?? 20, 'id' => $testId ?? 1]) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2 border border-gray-200">
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
                            <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                        </div>

                        <div class="border border-gray-300">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-indigo-50/50">
                                        <th class="border border-gray-300 p-4 font-bold text-center w-1/4">Name of restaurant</th>
                                        <th class="border border-gray-300 p-4 font-bold text-center w-1/4">Location</th>
                                        <th class="border border-gray-300 p-4 font-bold text-center w-1/4">Reason for recommendation</th>
                                        <th class="border border-gray-300 p-4 font-bold text-center w-1/4">Other comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-300 p-4 align-top">
                                            The Junction
                                        </td>
                                        <td class="border border-gray-300 p-4 align-top">
                                            Greyson Street, near the station
                                        </td>
                                        <td class="border border-gray-300 p-4 align-top leading-loose">
                                            Good for people who are especially keen on<br>
                                            <span class="inline-flex items-center align-bottom whitespace-nowrap mt-2"><span class="font-bold text-blue-700 mr-2 text-lg">1</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center"></span>
                                        </td>
                                        <td class="border border-gray-300 p-4 align-top leading-loose">
                                            Quite expensive<br><br>
                                            The <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">2</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> is a good place for a drink
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 p-4 align-top">
                                            Paloma
                                        </td>
                                        <td class="border border-gray-300 p-4 align-top">
                                            In Bow Street next to the cinema
                                        </td>
                                        <td class="border border-gray-300 p-4 align-top leading-loose text-center">
                                            <span class="inline-flex items-center align-bottom whitespace-nowrap mb-2"><span class="font-bold text-blue-700 mr-2 text-lg">3</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center"></span><br>
                                            food, good for sharing
                                        </td>
                                        <td class="border border-gray-300 p-4 align-top leading-loose">
                                            Staff are very friendly<br>
                                            Need to pay £50 deposit<br>
                                            A limited selection of <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">4</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> food on the menu
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 p-4 align-top leading-loose">
                                            The <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">5</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span>
                                        </td>
                                        <td class="border border-gray-300 p-4 align-top leading-loose">
                                            At the top of a <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">6</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span>
                                        </td>
                                        <td class="border border-gray-300 p-4 align-top leading-loose">
                                            A famous chef<br><br>
                                            All the <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">7</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> are very good<br>
                                            Only uses <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">8</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> ingredients
                                        </td>
                                        <td class="border border-gray-300 p-4 align-top leading-loose">
                                            Set lunch costs £<span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">9</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-16 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> per person<br>
                                            Portions probably of <span class="inline-flex items-center align-bottom whitespace-nowrap"><span class="font-bold text-blue-700 mx-1 text-lg">10</span><input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> size
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                
                    <div class="max-w-5xl mx-auto mt-8 flex justify-end">
                        <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Next Part
                        </button>
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
                            <p class="italic mb-6">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                        </div>

                        <div class="pl-4 space-y-8">
                            <!-- Question 11 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">11</span> Heather says pottery differs from other art forms because</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">it lasts longer in the ground.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">it is practised by more people.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q11" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">it can be repaired more easily.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 12 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">12</span> Archaeologists sometimes identify the use of ancient pottery from</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">the clay it was made with.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">the marks that are on it.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q12" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">the basic shape of it.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 13 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">13</span> Some people join Heather's pottery class because they want to</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">create an item that looks very old.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">find something that they are good at.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q13" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">make something that will outlive them.</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 14 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">14</span> What does Heather value most about being a potter?</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">its calming effect</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">its messy nature</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q14" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">its physical benefits</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 15 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">15</span> Most of the visitors to Edelman Pottery</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q15" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">bring friends to join courses.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q15" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">have never made a pot before.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q15" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">try to learn techniques too quickly.</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Question 16 -->
                            <div>
                                <p class="font-semibold mb-3"><span class="font-bold mr-2">16</span> Heather reminds her visitors that they should</p>
                                <div class="space-y-2 ml-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q16" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">put on their aprons.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q16" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">change their clothes.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="q16" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">take off their jewellery.</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h4 class="font-bold text-md mb-2">Questions 17 and 18</h4>
                            <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                            
                            <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> things does Heather explain about kilns?</p>
                            <div class="space-y-2 ml-8 mb-8 pb-6 border-b border-gray-200" x-data="{ selections: [] }" @change="if (selections.length > 2) selections.shift()">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q17_18[]" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">A</span>
                                    <span class="group-hover:text-blue-600 transition">what their function is</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q17_18[]" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">B</span>
                                    <span class="group-hover:text-blue-600 transition">when they were invented</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q17_18[]" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">C</span>
                                    <span class="group-hover:text-blue-600 transition">ways of keeping them safe</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q17_18[]" value="D" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">D</span>
                                    <span class="group-hover:text-blue-600 transition">where to put one in your home</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q17_18[]" value="E" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">E</span>
                                    <span class="group-hover:text-blue-600 transition">what some people use instead of one</span>
                                </label>
                            </div>

                            <h4 class="font-bold text-md mb-2">Questions 19 and 20</h4>
                            <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                            
                            <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> points does Heather make about a potter's tools?</p>
                            <div class="space-y-2 ml-8" x-data="{ selections: [] }" @change="if (selections.length > 2) selections.shift()">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q19_20[]" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">A</span>
                                    <span class="group-hover:text-blue-600 transition">Some are hard to hold.</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q19_20[]" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">B</span>
                                    <span class="group-hover:text-blue-600 transition">Some are worth buying.</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q19_20[]" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">C</span>
                                    <span class="group-hover:text-blue-600 transition">Some are essential items.</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q19_20[]" value="D" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">D</span>
                                    <span class="group-hover:text-blue-600 transition">Some have memorable names.</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" x-model="selections" name="q19_20[]" value="E" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="font-bold w-4">E</span>
                                    <span class="group-hover:text-blue-600 transition">Some are available for use by participants.</span>
                                </label>
                            </div>
                        </div>

                    </div>
                    
                    <div class="max-w-5xl mx-auto mt-8 flex justify-between">
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
                    <div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
                            <h4 class="font-bold text-md mb-2 mt-4">Questions 21 and 22</h4>
                            <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        </div>

                        <div class="pl-4 space-y-8">
                            <!-- Questions 21-22 -->
                            <div class="border-b border-gray-200 pb-6">
                                <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> things do the students both believe are responsible for the increase in loneliness?</p>
                                <div class="space-y-2 ml-8" x-data="{ selections: [] }" @change="if (selections.length > 2) selections.shift()">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q21_22[]" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">social media</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q21_22[]" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">smaller nuclear families</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q21_22[]" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">urban design</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q21_22[]" value="D" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">D</span>
                                        <span class="group-hover:text-blue-600 transition">longer lifespans</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q21_22[]" value="E" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">E</span>
                                        <span class="group-hover:text-blue-600 transition">a mobile workforce</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Questions 23-24 -->
                            <div class="border-b border-gray-200 pb-6">
                                <h4 class="font-bold text-md mb-2">Questions 23 and 24</h4>
                                <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                                <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> health risks associated with loneliness do the students agree are based on solid evidence?</p>
                                <div class="space-y-2 ml-8" x-data="{ selections: [] }" @change="if (selections.length > 2) selections.shift()">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q23_24[]" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">a weakened immune system</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q23_24[]" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">dementia</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q23_24[]" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">cancer</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q23_24[]" value="D" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">D</span>
                                        <span class="group-hover:text-blue-600 transition">obesity</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q23_24[]" value="E" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">E</span>
                                        <span class="group-hover:text-blue-600 transition">cardiovascular disease</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Questions 25-26 -->
                            <div class="border-b border-gray-200 pb-6">
                                <h4 class="font-bold text-md mb-2">Questions 25 and 26</h4>
                                <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                                <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> opinions do both the students express about the evolutionary theory of loneliness?</p>
                                <div class="space-y-2 ml-8" x-data="{ selections: [] }" @change="if (selections.length > 2) selections.shift()">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q25_26[]" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">A</span>
                                        <span class="group-hover:text-blue-600 transition">It has little practical relevance.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q25_26[]" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">B</span>
                                        <span class="group-hover:text-blue-600 transition">It needs further investigation.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q25_26[]" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">C</span>
                                        <span class="group-hover:text-blue-600 transition">It is misleading.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q25_26[]" value="D" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">D</span>
                                        <span class="group-hover:text-blue-600 transition">It should be more widely accepted.</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" x-model="selections" name="q25_26[]" value="E" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">E</span>
                                        <span class="group-hover:text-blue-600 transition">It is difficult to understand.</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Questions 27-30 -->
                            <div class="pt-4">
                                <h4 class="font-bold text-md mb-2">Questions 27–30</h4>
                                <p class="italic mb-6">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                                
                                <h5 class="font-bold text-center text-lg mb-8">Loneliness and mental health</h5>

                                <!-- Question 27 -->
                                <div class="border-b border-gray-200 pb-6 mb-6">
                                    <p class="font-semibold mb-3"><span class="font-bold mr-2">27</span> When comparing loneliness to depression, the students</p>
                                    <div class="space-y-2 ml-8">
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q27" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">A</span>
                                            <span class="group-hover:text-blue-600 transition">doubt that there will ever be a medical cure for loneliness.</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q27" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">B</span>
                                            <span class="group-hover:text-blue-600 transition">claim that the link between loneliness and mental health is overstated.</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q27" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">C</span>
                                            <span class="group-hover:text-blue-600 transition">express frustration that loneliness is not taken more seriously.</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Question 28 -->
                                <div class="border-b border-gray-200 pb-6 mb-6">
                                    <p class="font-semibold mb-3"><span class="font-bold mr-2">28</span> Why do the students decide to start their presentation with an example from their own experience?</p>
                                    <div class="space-y-2 ml-8">
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q28" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">A</span>
                                            <span class="group-hover:text-blue-600 transition">to explain how difficult loneliness can be</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q28" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">B</span>
                                            <span class="group-hover:text-blue-600 transition">to highlight a situation that most students will recognise</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q28" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">C</span>
                                            <span class="group-hover:text-blue-600 transition">to emphasise that feeling lonely is more common for men than women</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Question 29 -->
                                <div class="border-b border-gray-200 pb-6 mb-6">
                                    <p class="font-semibold mb-3"><span class="font-bold mr-2">29</span> The students agree that talking to strangers is a good strategy for dealing with loneliness because</p>
                                    <div class="space-y-2 ml-8">
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q29" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">A</span>
                                            <span class="group-hover:text-blue-600 transition">it creates a sense of belonging.</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q29" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">B</span>
                                            <span class="group-hover:text-blue-600 transition">it builds self-confidence.</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q29" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">C</span>
                                            <span class="group-hover:text-blue-600 transition">it makes people feel more positive.</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Question 30 -->
                                <div>
                                    <p class="font-semibold mb-3"><span class="font-bold mr-2">30</span> The students find it difficult to understand why solitude is considered to be</p>
                                    <div class="space-y-2 ml-8">
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q30" value="A" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">A</span>
                                            <span class="group-hover:text-blue-600 transition">similar to loneliness.</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q30" value="B" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">B</span>
                                            <span class="group-hover:text-blue-600 transition">necessary for mental health.</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q30" value="C" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">C</span>
                                            <span class="group-hover:text-blue-600 transition">an enjoyable experience.</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-5xl mx-auto mt-8 flex justify-between">
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
                    <div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
                            <p class="italic mb-2">Complete the notes below.</p>
                            <p class="italic mb-6">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                            
                            <h4 class="font-bold text-xl text-center mb-6">The introduction of the London cycle network</h4>

                            <div class="space-y-6">
                                <div>
                                    <h5 class="font-bold text-lg mb-3">Historical background</h5>
                                    <ul class="list-disc pl-8 space-y-4">
                                        <li class="pl-2 leading-8">1899: the <span class="inline-flex items-center"><span class="font-bold text-blue-700 mx-2 text-lg">31</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> of the city asked for special roads for cyclists</li>
                                        <li class="pl-2 leading-8">1920s: the 'Bicycle <span class="inline-flex items-center"><span class="font-bold text-blue-700 mx-2 text-lg">32</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span>' group was formed</li>
                                        <li class="pl-2 leading-8">1934: an attempt to build cycle tracks next to a new <span class="inline-flex items-center"><span class="font-bold text-blue-700 mx-2 text-lg">33</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> in London was unsuccessful</li>
                                    </ul>
                                </div>

                                <div>
                                    <h5 class="font-bold text-lg mb-3">Recent improvements</h5>
                                    <ul class="list-disc pl-8 space-y-4">
                                        <li class="pl-2 leading-8">In the 2000s, 'Bicycle <span class="inline-flex items-center"><span class="font-bold text-blue-700 mx-2 text-lg">34</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span>' were introduced</li>
                                        <li class="pl-2 leading-8"><span class="inline-flex items-center"><span class="font-bold text-blue-700 mr-2 text-lg">35</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mr-1"></span> cycle routes were introduced to help people find their way</li>
                                        <li class="pl-2 leading-8 mb-2">The 'Cycle Vision' strategy included the creation of:
                                            <ul class="list-[circle] pl-8 space-y-3 mt-3">
                                                <li class="pl-2 leading-8">a 'Quietway' for cyclists who were less <span class="inline-flex items-center"><span class="font-bold text-blue-700 mx-2 text-lg">36</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span></li>
                                                <li class="pl-2 leading-8">a 'Superhighway' for cyclists commuting to work.</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>

                                <div>
                                    <h5 class="font-bold text-lg mb-3">Current improvements</h5>
                                    <ul class="list-disc pl-8 space-y-4">
                                        <li class="pl-2 leading-8">The 'Mini-Hollands' scheme is designed to create more <span class="inline-flex items-center"><span class="font-bold text-blue-700 mx-2 text-lg">37</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> cycle routes.</li>
                                        <li class="pl-2 leading-8 mb-2">Examples of changes include:
                                            <ul class="list-[circle] pl-8 space-y-3 mt-3">
                                                <li class="pl-2 leading-8">banning <span class="inline-flex items-center"><span class="font-bold text-blue-700 mx-2 text-lg">38</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> from certain roads</li>
                                                <li class="pl-2 leading-8">building more <span class="inline-flex items-center"><span class="font-bold text-blue-700 mx-2 text-lg">39</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> for bicycles</li>
                                                <li class="pl-2 leading-8">making physical changes to <span class="inline-flex items-center"><span class="font-bold text-blue-700 mx-2 text-lg">40</span><input type="text" class="border-b-2 border-dashed border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center mx-1"></span> to reduce accidents.</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="max-w-5xl mx-auto mt-8 flex justify-between">
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
