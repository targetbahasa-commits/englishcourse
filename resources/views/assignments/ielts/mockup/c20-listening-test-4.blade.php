<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Test 4 - {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .paper-shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); }
        .dotted-line { border-bottom: 1px dotted #000; display: inline-block; width: 150px; }
        main { padding-bottom: 250px !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a0aec0; }
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
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Listening Mock Test 4</h1>
                             <p class="text-gray-600 mt-1">Cambridge IELTS 20</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => 20, 'id' => 4]) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
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
                            <h2 class="text-2xl font-bold text-center mb-6">Advice on family visit</h2>
                            
                            <h4 class="font-bold text-lg mb-4">Accommodation</h4>
                            <ul class="list-disc ml-5 space-y-3 mb-6">
                                <li class="pl-2">
                                    <span class="font-bold">1</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    Hotel on George Street
                                </li>
                                <li class="pl-2">
                                    cost of family room per night: £<span class="font-bold">2</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    (approx.)
                                </li>
                            </ul>

                            <h4 class="font-bold text-lg mb-4">Recommended trips</h4>
                            <ul class="list-disc ml-5 space-y-3 mb-6">
                                <li class="pl-2">
                                    a <span class="font-bold">3</span> 
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    tour of the city centre (starts in Carlton Square)
                                </li>
                                <li class="pl-2">
                                    a trip by <span class="font-bold">4</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    to the old fort
                                </li>
                            </ul>

                            <h4 class="font-bold text-lg mb-4">Science Museum</h4>
                            <ul class="list-disc ml-5 space-y-3 mb-6">
                                <li class="pl-2">
                                    best day to visit: <span class="font-bold">5</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                </li>
                                <li class="pl-2">
                                    see the exhibition about <span class="font-bold">6</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">,
                                    which opens soon
                                </li>
                            </ul>

                            <h4 class="font-bold text-lg mb-4">Food</h4>
                            <ul class="list-disc ml-5 space-y-3 mb-6">
                                <li class="pl-2">
                                    Clacton Market:
                                    <ul class="ml-6 space-y-3 mt-2 list-none">
                                        <li>- good for <span class="font-bold">7</span> <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer"> food</li>
                                        <li>- need to have lunch before <span class="font-bold">8</span> <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer"> p.m.</li>
                                    </ul>
                                </li>
                            </ul>

                            <h4 class="font-bold text-lg mb-4">Theatre tickets</h4>
                            <ul class="list-disc ml-5 space-y-3 mb-6">
                                <li class="pl-2">
                                    save up to <span class="font-bold">9</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    % on ticket prices at bargaintickets.com
                                </li>
                            </ul>

                            <h4 class="font-bold text-lg mb-4">Free activities</h4>
                            <ul class="list-disc ml-5 space-y-3">
                                <li class="pl-2">
                                    Blakewell Gardens:
                                    <ul class="ml-6 space-y-3 mt-2 list-none">
                                        <li>- Roots Music Festival</li>
                                        <li>- climb Telegraph Hill to see a view of the <span class="font-bold">10</span> <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer"></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="max-w-4xl mx-auto mt-8 flex justify-end">
                        <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
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
                            <h4 class="font-bold text-md mb-2">Questions 11 and 12</h4>
                            <p class="italic">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        </div>

                        <div class="pl-4 space-y-8">
                            <div class="border-b border-gray-200 pb-6" x-data="{ selections: [] }" x-init="$watch('selections', val => { if(val.length > 2) selections.shift(); })">
                                <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> things does the speaker say about visiting the football stadium with children?</p>
                                <div class="space-y-2 ml-8">
                                    @php $q1112 = ["Children can get their photo taken with a football player.", "There is a competition for children today.", "Parents must stay with their children at all times.", "Children will need sunhats and drinks.", "The café has a special offer on meals for children."]; @endphp
                                    @foreach($q1112 as $idx => $opt)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q11_12[]" value="{{ chr(65 + $idx) }}" x-model="selections" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">{{ chr(65 + $idx) }}</span>
                                        <span class="group-hover:text-blue-600 transition">{{ $opt }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mb-6 mt-8">
                            <h4 class="font-bold text-md mb-2">Questions 13 and 14</h4>
                            <p class="italic">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        </div>
                        <div class="pl-4 space-y-8">
                            <div class="border-b border-gray-200 pb-6" x-data="{ selections: [] }" x-init="$watch('selections', val => { if(val.length > 2) selections.shift(); })">
                                <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> features of the stadium tour are new this year?</p>
                                <div class="space-y-2 ml-8">
                                    @php $q1314 = ["VIP tour", "360 cinema experience", "audio guide", "dressing room tour", "tours in other languages"]; @endphp
                                    @foreach($q1314 as $idx => $opt)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q13_14[]" value="{{ chr(65 + $idx) }}" x-model="selections" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">{{ chr(65 + $idx) }}</span>
                                        <span class="group-hover:text-blue-600 transition">{{ $opt }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-4">
                            <h4 class="font-bold text-md mb-2">Questions 15–20</h4>
                            <p class="italic mb-6">Which event in the history of football in the UK took place in each of the following years?<br>Choose <span class="font-bold">SIX</span> answers from the box and write the correct letter, <span class="font-bold">A–H</span>, next to Questions 15–20.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <div class="space-y-4">
                                        @foreach(['15' => '1870', '16' => '1874', '17' => '1875', '18' => '1877', '19' => '1878', '20' => '1880'] as $num => $year)
                                        <div class="flex items-center gap-4">
                                            <span class="font-bold w-6">{{ $num }}.</span>
                                            <span class="flex-1">{{ $year }}</span>
                                            <select class="border border-gray-500 outline-none px-2 py-2 w-24 bg-transparent focus:border-blue-500 transition-colors font-bold text-center text-gray-400 focus:text-gray-900 cursor-pointer">
                                                <option value="" disabled selected hidden>A-H</option>
                                                @foreach(range('A', 'H') as $letter)
                                                <option value="{{ $letter }}" class="text-gray-900">{{ $letter }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="border border-gray-400 p-6 rounded-lg bg-gray-50">
                                    <h5 class="font-bold text-center mb-4 text-sm border-b border-gray-300 pb-2">Events in the history of football</h5>
                                    <div class="space-y-3 text-sm">
                                        @php $events = ["the introduction of pay for the players", "a change to the design of the goal", "the first use of lights for matches", "the introduction of goalkeepers", "the first international match", "two changes to the rules of the game", "the introduction of a fee for spectators", "an agreement on the length of a game"]; @endphp
                                        @foreach($events as $idx => $ev)
                                        <div class="flex gap-4"><span class="font-bold w-4">{{ chr(65 + $idx) }}</span> <span>{{ $ev }}</span></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                         <button @click="step = 1" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                        <button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
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
                            <div class="border-b border-gray-200 pb-6" x-data="{ selections: [] }" x-init="$watch('selections', val => { if(val.length > 2) selections.shift(); })">
                                <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> benefits for children of learning to write did both students find surprising?</p>
                                <div class="space-y-2 ml-8">
                                    @php $q2122 = ["improved fine motor skills", "improved memory", "improved concentration", "improved imagination", "improved spatial awareness"]; @endphp
                                    @foreach($q2122 as $idx => $opt)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q21_22[]" value="{{ chr(65 + $idx) }}" x-model="selections" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">{{ chr(65 + $idx) }}</span>
                                        <span class="group-hover:text-blue-600 transition">{{ $opt }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mb-6 mt-8">
                            <h4 class="font-bold text-md mb-2">Questions 23 and 24</h4>
                            <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        </div>
                        <div class="pl-4 space-y-8">
                            <div class="border-b border-gray-200 pb-6" x-data="{ selections: [] }" x-init="$watch('selections', val => { if(val.length > 2) selections.shift(); })">
                                <p class="font-semibold mb-3">For children with dyspraxia, which <span class="font-bold">TWO</span> problems with handwriting do the students think are easiest to correct?</p>
                                <div class="space-y-2 ml-8">
                                    @php $q2324 = ["not spacing letters correctly", "not writing in a straight line", "applying too much pressure when writing", "confusing letter shapes", "writing very slowly"]; @endphp
                                    @foreach($q2324 as $idx => $opt)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="q23_24[]" value="{{ chr(65 + $idx) }}" x-model="selections" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="font-bold w-4">{{ chr(65 + $idx) }}</span>
                                        <span class="group-hover:text-blue-600 transition">{{ $opt }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-4">
                            <div class="text-center mb-6"><h4 class="font-bold text-lg">Teaching handwriting</h4></div>
                            <h4 class="font-bold text-md mb-2">Questions 25–30</h4>
                            <p class="italic mb-6">Choose the correct letter, <span class="font-bold">A, B</span> or <span class="font-bold">C</span>.</p>
                            
                            <div class="space-y-8 pl-4">
                                @php
                                $mcqs = [
                                    "25" => ["What does the woman say about using laptops to teach writing to children with dyslexia?", ["Children often lack motivation to learn that way.", "Children become fluent relatively quickly.", "Children react more positively if they make a mistake."]],
                                    "26" => ["When discussing whether to teach cursive or print writing, the woman thinks that", ["cursive writing disadvantages a certain group of children.", "print writing is associated with lower academic performance.", "most teachers in the UK prefer a traditional approach to handwriting."]],
                                    "27" => ["According to the students, what impact does poor handwriting have on exam performance?", ["There is evidence to suggest grades are affected by poor handwriting.", "Neat handwriting is less important now than it used to be.", "Candidates write more slowly and produce shorter answers."]],
                                    "28" => ["What prediction does the man make about the future of handwriting?", ["Touch typing will be taught before writing by hand.", "Children will continue to learn to write by hand.", "People will dislike handwriting on digital devices."]],
                                    "29" => ["The woman is concerned that relying on digital devices has made it difficult for her to", ["take detailed notes.", "spell and punctuate.", "read old documents."]],
                                    "30" => ["How do the students feel about their own handwriting?", ["concerned they are unable to write quickly", "embarrassed by comments made about it", "regretful that they have lost the habit"]]
                                ];
                                @endphp
                                @foreach($mcqs as $num => $data)
                                <div class="border-b border-gray-200 pb-6">
                                    <p class="font-semibold mb-3"><span class="font-bold mr-2">{{ $num }}</span> {{ $data[0] }}</p>
                                    <div class="space-y-2 ml-8">
                                        @foreach($data[1] as $idx => $opt)
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="q{{ $num }}" value="{{ chr(65 + $idx) }}" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                            <span class="font-bold w-4">{{ chr(65 + $idx) }}</span>
                                            <span class="group-hover:text-blue-600 transition">{{ $opt }}</span>
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
                            <h2 class="text-2xl font-bold text-center mb-6">Research in the area around the Chembe Bird Sanctuary</h2>
                            
                            <h4 class="font-bold text-lg mb-4">The importance of birds of prey to the local communities</h4>
                            <ul class="list-disc ml-5 space-y-3 mb-6">
                                <li class="pl-2">
                                    They destroy <span class="font-bold">31</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    and other rodents.
                                </li>
                                <li class="pl-2">
                                    They help to prevent farmers from being bitten by <span class="font-bold">32</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                </li>
                                <li class="pl-2">
                                    They have been an important part of the local culture for many years.
                                </li>
                                <li class="pl-2">
                                    They now support the economy by encouraging <span class="font-bold">33</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    in the area.
                                </li>
                            </ul>

                            <h4 class="font-bold text-lg mb-4">Falling numbers of birds of prey</h4>
                            <ul class="list-disc ml-5 space-y-3 mb-6">
                                <li class="pl-2">
                                    The birds may be accidentally killed
                                    <ul class="ml-6 mt-2 space-y-3 list-none">
                                        <li>
                                            - by <span class="font-bold">34</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                            when they are hunting or sleeping
                                        </li>
                                        <li>
                                            - by electrocution from contact with power lines, especially at times when there is a lot of <span class="font-bold">35</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                            .
                                        </li>
                                    </ul>
                                </li>
                                <li class="pl-2">
                                    Local farmers may illegally shoot them or <span class="font-bold">36</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    them.
                                </li>
                            </ul>

                            <h4 class="font-bold text-lg mb-4">Ways of protecting chickens from birds of prey</h4>
                            <ul class="list-disc ml-5 space-y-3">
                                <li class="pl-2">clearing away vegetation from the area (unhelpful)</li>
                                <li class="pl-2">
                                    providing a <span class="font-bold">37</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    for chickens (expensive)
                                </li>
                                <li class="pl-2">
                                    frightening birds of prey by
                                    <ul class="ml-6 space-y-3 mt-2 list-none">
                                        <li>
                                            - keeping a <span class="font-bold">38</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                        </li>
                                        <li>
                                            - making a <span class="font-bold">39</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                            - e.g. with metal objects
                                        </li>
                                    </ul>
                                </li>
                                <li class="pl-2 mt-4">
                                    A <span class="font-bold">40</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 transition-colors placeholder-gray-400 text-center" placeholder="Answer">
                                    of methods is usually most effective.
                                </li>
                            </ul>
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

    @include('assignments.ielts.listening.partials.audio-player', ['set' => 'Mock Up ' . ($testId ?? 4), 'section' => $material ?? null])
    
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
</body>
</html>
