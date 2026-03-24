<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Up - {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .paper-shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); }
        .dotted-line { border-bottom: 1px dotted #000; display: inline-block; width: 150px; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

    <div class="flex min-h-screen">
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
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Listening – Mock Test {{ $testId ?? 3 }}</h1>
                            <p class="text-gray-600 mt-1">Cambridge {{ $edition ?? 20 }} Listening Practice</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition ?? 20, 'id' => $testId ?? 3]) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2 border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div x-data="{ step: 1 }">

<!-- ================================================================ -->
<!-- PART 1 -->
<!-- ================================================================ -->
<div x-show="step === 1">
<div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
    <div class="flex justify-center mb-6">
        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
    </div>

    <div class="mb-6">
        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1–10</span></h3>
        <p class="italic mb-1">Complete the table below.</p>
        <p class="italic">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>
    </div>

    <div class="p-4 border border-gray-300 overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th colspan="3" class="border border-gray-400 px-3 py-2 text-center font-bold">Furniture Rental Companies</th>
                </tr>
                <tr class="bg-gray-50">
                    <th class="border border-gray-400 px-3 py-2 font-bold text-left w-1/4">Name of company</th>
                    <th class="border border-gray-400 px-3 py-2 font-bold text-left w-2/5">Information about costs</th>
                    <th class="border border-gray-400 px-3 py-2 font-bold text-left">Additional notes</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1: Peak Rentals -->
                <tr>
                    <td class="border border-gray-400 px-3 py-3 align-top font-medium">Peak Rentals</td>
                    <td class="border border-gray-400 px-3 py-3 align-top leading-loose">
                        Prices range from $105 to $
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">1</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span>
                        per room per month
                    </td>
                    <td class="border border-gray-400 px-3 py-3 align-top leading-loose">
                        The furniture is very
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">2</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span><br>
                        Delivers in 1–2 days<br>
                        Special offer: free
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">3</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span>
                        with every living room set
                    </td>
                </tr>
                <!-- Row 2: [4] and Oliver -->
                <tr>
                    <td class="border border-gray-400 px-3 py-3 align-top leading-loose">
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">4</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span>
                        and Oliver
                    </td>
                    <td class="border border-gray-400 px-3 py-3 align-top leading-loose">
                        Mid-range prices<br>
                        12% monthly fee for
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">5</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span>
                    </td>
                    <td class="border border-gray-400 px-3 py-3 align-top">Also offers a cleaning service</td>
                </tr>
                <!-- Row 3: Larch Furniture -->
                <tr>
                    <td class="border border-gray-400 px-3 py-3 align-top font-medium">Larch Furniture</td>
                    <td class="border border-gray-400 px-3 py-3 align-top leading-loose">
                        Offers cheapest prices for renting furniture and
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">6</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span>
                        items
                    </td>
                    <td class="border border-gray-400 px-3 py-3 align-top leading-loose">
                        Must have own
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">7</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span><br>
                        Minimum contract length: six months
                    </td>
                </tr>
                <!-- Row 4: [8] Rentals -->
                <tr>
                    <td class="border border-gray-400 px-3 py-3 align-top leading-loose">
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">8</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span>
                        Rentals
                    </td>
                    <td class="border border-gray-400 px-3 py-3 align-top leading-loose">
                        See the
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">9</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span>
                        for the most up-to-date prices
                    </td>
                    <td class="border border-gray-400 px-3 py-3 align-top leading-loose">
                        <span class="inline-flex items-center align-bottom whitespace-nowrap">
                            <span class="font-bold text-blue-700 mx-1">10</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-24 bg-transparent focus:border-blue-500 text-center">
                        </span>
                        are allowed within 7 days of delivery
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="max-w-5xl mx-auto mt-8 flex justify-end">
    <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
</div>
</div>

<!-- ================================================================ -->
<!-- PART 2 -->
<!-- ================================================================ -->
<div x-show="step === 2" x-cloak>
<div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
    <div class="flex justify-center mb-6">
        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
    </div>

    <div class="mb-6">
        <h3 class="font-bold text-lg mb-4">PART 2 <span class="ml-8">Questions 11–20</span></h3>
        <h4 class="font-bold text-md mb-2">Questions 11–16</h4>
        <p class="italic mb-4">Choose the correct letter, <strong>A, B</strong> or <strong>C</strong>.</p>
    </div>

    <div class="pl-4 space-y-8 mb-12">
        @foreach([
            [11, 'Who was responsible for starting the community project?', ['A' => 'the castle owners', 'B' => 'a national charity', 'C' => 'the local council']],
            [12, 'How was the gold coin found?', ['A' => 'Heavy rain had removed some of the soil.', 'B' => 'The ground was dug up by wild rabbits.', 'C' => 'A person with a metal detector searched the area.']],
            [13, 'What led the archaeologists to believe there was an ancient village on this site?', ['A' => 'the lucky discovery of old records', 'B' => 'the bases of several structures visible in the grass', 'C' => 'the unusual stones found near the castle']],
            [14, 'What are the team still hoping to find?', ['A' => 'everyday pottery', 'B' => 'animal bones', 'C' => 'pieces of jewellery']],
            [15, 'What was found on the other side of the river to the castle?', ['A' => 'the remains of a large palace', 'B' => 'the outline of fields', 'C' => 'a number of small huts']],
            [16, 'What do the team plan to do after work ends this summer?', ['A' => 'prepare a display for a museum', 'B' => 'take part in a television programme', 'C' => 'start to organise school visits']],
        ] as [$num, $question, $options])
        <div class="border-b border-gray-200 pb-6">
            <p class="font-semibold mb-3"><span class="font-bold mr-2">{{ $num }}</span>{{ $question }}</p>
            <div class="space-y-2 ml-8">
                @foreach($options as $letter => $text)
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="font-bold w-4">{{ $letter }}</span>
                    <span class="group-hover:text-blue-600 transition">{{ $text }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- Q17-20: Map Labeling --}}
    <div class="mt-10">
        <h4 class="font-bold text-md mb-2">Questions 17–20</h4>
        <p class="italic mb-1">Label the map below.</p>
        <p class="italic mb-6">Drag the correct letter, <strong>A–G</strong>, next to Questions 17–20.</p>

        {{-- Map SVG: Bidcaster Archaeological Dig --}}
        <h3 class="text-xl font-bold text-center mb-4">Bidcaster Archaeological Dig</h3>
        <div class="border border-gray-300 bg-white mb-8 overflow-hidden max-w-2xl mx-auto">
            <svg viewBox="0 0 480 380" xmlns="http://www.w3.org/2000/svg" class="w-full" style="font-family: Arial, sans-serif; font-size: 12px;">
                <!-- Background -->
                <rect width="480" height="380" fill="#f9f9f0"/>

                <!-- River top-left -->
                <path d="M 60 0 Q 90 30 80 60 Q 70 90 100 100 Q 200 110 260 80 Q 330 50 380 0" stroke="#99bbdd" stroke-width="18" fill="none"/>
                <text x="90" y="55" fill="#558" font-size="11" font-style="italic">River</text>

                <!-- River right side -->
                <path d="M 440 0 Q 460 80 450 150 Q 440 220 460 300 Q 470 350 460 380" stroke="#99bbdd" stroke-width="18" fill="none"/>
                <text x="448" y="120" fill="#558" font-size="11" font-style="italic" transform="rotate(80 448 120)">River</text>

                <!-- Castle walls oval -->
                <ellipse cx="220" cy="220" rx="140" ry="120" fill="#e8e8d8" stroke="#888" stroke-width="2.5"/>
                <text x="55" y="215" fill="#555" font-size="11" font-weight="bold">Castle</text>
                <text x="60" y="228" fill="#555" font-size="11" font-weight="bold">walls</text>

                <!-- Internal castle structures (buildings) -->
                <rect x="155" y="165" width="40" height="30" fill="white" stroke="#666" stroke-width="1.5"/>
                <rect x="205" y="185" width="35" height="28" fill="white" stroke="#666" stroke-width="1.5"/>

                <!-- Site of current dig -->
                <rect x="170" y="225" width="70" height="55" fill="#f0e8c0" stroke="#888" stroke-width="1.5"/>
                <text x="185" y="248" fill="#555" font-size="10">Site of</text>
                <text x="182" y="262" fill="#555" font-size="10">current</text>
                <text x="193" y="276" fill="#555" font-size="10">dig</text>

                <!-- Small square near bottom of castle -->
                <rect x="260" y="270" width="22" height="22" fill="white" stroke="#666" stroke-width="1.5"/>

                <!-- Tree icons scattered -->
                {{-- Top-left trees --}}
                <circle cx="65" cy="170" r="14" fill="#7a9e5a" opacity="0.7"/>
                <circle cx="50" cy="190" r="12" fill="#7a9e5a" opacity="0.7"/>
                {{-- Top-right trees (between castle and right river) --}}
                <circle cx="370" cy="170" r="13" fill="#7a9e5a" opacity="0.7"/>
                <circle cx="395" cy="195" r="14" fill="#7a9e5a" opacity="0.7"/>
                <circle cx="375" cy="215" r="12" fill="#7a9e5a" opacity="0.7"/>
                <circle cx="400" cy="240" r="14" fill="#7a9e5a" opacity="0.7"/>
                <circle cx="370" cy="255" r="12" fill="#7a9e5a" opacity="0.7"/>

                <!-- Location boxes A-G -->
                <!-- A: top left of castle entrance -->
                <rect x="90" y="150" width="20" height="20" fill="white" stroke="#333" stroke-width="1.5"/>
                <text x="95" y="164" fill="#333" font-weight="bold" font-size="13">A</text>

                <!-- B: top of castle oval (bridge/river) -->
                <rect x="195" y="90" width="20" height="20" fill="white" stroke="#333" stroke-width="1.5"/>
                <text x="200" y="104" fill="#333" font-weight="bold" font-size="13">B</text>

                <!-- C: right of B (near right river) -->
                <rect x="300" y="90" width="20" height="20" fill="white" stroke="#333" stroke-width="1.5"/>
                <text x="305" y="104" fill="#333" font-weight="bold" font-size="13">C</text>

                <!-- D: center of castle -->
                <rect x="218" y="193" width="20" height="20" fill="white" stroke="#333" stroke-width="1.5"/>
                <text x="223" y="207" fill="#333" font-weight="bold" font-size="13">D</text>

                <!-- E: right of castle (between castle wall and right river) -->
                <rect x="345" y="210" width="20" height="20" fill="white" stroke="#333" stroke-width="1.5"/>
                <text x="350" y="224" fill="#333" font-weight="bold" font-size="13">E</text>

                <!-- F: bottom-left of castle -->
                <rect x="95" y="305" width="20" height="20" fill="white" stroke="#333" stroke-width="1.5"/>
                <text x="100" y="319" fill="#333" font-weight="bold" font-size="13">F</text>

                <!-- G: inside castle, left of dig -->
                <rect x="147" y="240" width="20" height="20" fill="white" stroke="#333" stroke-width="1.5"/>
                <text x="152" y="254" fill="#333" font-weight="bold" font-size="13">G</text>

                <!-- Info boards legend -->
                <rect x="10" y="345" width="16" height="14" fill="none" stroke="#333" stroke-width="1.5"/>
                <line x1="10" y1="345" x2="26" y2="359" stroke="#333" stroke-width="0.5"/>
                <line x1="26" y1="345" x2="10" y2="359" stroke="#333" stroke-width="0.5"/>
                <text x="32" y="357" fill="#333" font-size="10">Information</text>
                <text x="32" y="369" fill="#333" font-size="10">boards</text>

                <!-- You are here marker -->
                <rect x="222" y="335" width="16" height="14" fill="black"/>
                <line x1="222" y1="335" x2="238" y2="349" stroke="white" stroke-width="0.5"/>
                <line x1="238" y1="335" x2="222" y2="349" stroke="white" stroke-width="0.5"/>
                <text x="215" y="368" fill="#333" font-size="10" text-anchor="middle">You are</text>
                <text x="215" y="380" fill="#333" font-size="10" text-anchor="middle">here</text>

                <!-- Compass -->
                <text x="395" y="328" fill="#333" font-size="10" text-anchor="middle">N</text>
                <text x="395" y="355" fill="#333" font-size="10" text-anchor="middle">S</text>
                <text x="382" y="345" fill="#333" font-size="10" text-anchor="middle">W</text>
                <text x="408" y="345" fill="#333" font-size="10" text-anchor="middle">E</text>
                <line x1="395" y1="333" x2="395" y2="352" stroke="#333" stroke-width="1"/>
                <line x1="384" y1="342" x2="406" y2="342" stroke="#333" stroke-width="1"/>
                <polygon points="395,333 392,340 398,340" fill="#333"/>
            </svg>
        </div>

        {{-- Q17-20 Answer dropdowns --}}
        <div class="ml-4 md:ml-12 space-y-4">
            @foreach([17 => 'bridge foundations', 18 => 'rubbish pit', 19 => 'meeting hall', 20 => 'fish pond'] as $num => $label)
            <div class="flex items-center">
                <span class="font-bold text-blue-700 text-xl w-12">{{ $num }}</span>
                <span class="w-56 font-medium text-lg">{{ $label }}</span>
                <select class="border border-gray-300 outline-none px-3 py-2 w-20 bg-white focus:border-blue-500 font-bold uppercase shadow-sm rounded-md cursor-pointer appearance-none text-center text-lg bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236b7280%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:18px_18px] bg-[right_8px_center] bg-no-repeat pr-5">
                    <option value=""></option>
                    @foreach(['A','B','C','D','E','F','G'] as $l)
                    <option value="{{ $l }}">{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto mt-8 flex justify-between">
    <button @click="step = 1" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-xl transition-all">Previous Part</button>
    <button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
</div>
</div>

<!-- ================================================================ -->
<!-- PART 3 -->
<!-- ================================================================ -->
<div x-show="step === 3" x-cloak>
<div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
    <div class="flex justify-center mb-6">
        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
    </div>

    <div class="mb-6">
        <h3 class="font-bold text-lg mb-4">PART 3 <span class="ml-8">Questions 21–30</span></h3>
        <h4 class="font-bold text-md mb-2">Questions 21–26</h4>
        <p class="italic mb-4">Choose the correct letter, <strong>A, B</strong> or <strong>C</strong>.</p>
    </div>

    <div class="pl-4 space-y-8 mb-12">
        @foreach([
            [21, 'Finn was pleased to discover that their topic', ['A' => 'was not familiar to their module leader.', 'B' => 'had not been chosen by other students.', 'C' => 'did not prove to be difficult to research.']],
            [22, "Maya says a mistaken belief about theatre programmes is that", ['A' => 'theatres pay companies to produce them.', 'B' => 'few theatre-goers buy them nowadays.', 'C' => 'they contain far more adverts than previously.']],
            [23, 'Finn was surprised that, in early British theatre, programmes', ['A' => 'were difficult for audiences to obtain.', 'B' => 'were given out free of charge.', 'C' => 'were seen as a kind of contract.']],
            [24, 'Maya feels their project should include an explanation of why companies of actors', ['A' => 'promoted their own plays.', 'B' => 'performed plays outdoors.', 'C' => 'had to tour with their plays.']],
            [25, 'Finn and Maya both think that, compared to nineteenth-century programmes, those from the eighteenth century', ['A' => 'were more original.', 'B' => 'were more colourful.', 'C' => 'were more informative.']],
            [26, "Maya doesn't fully understand why, in the twentieth century,", ['A' => 'very few theatre programmes were printed in the USA.', 'B' => 'British theatre programmes failed to develop for so long.', 'C' => 'theatre programmes in Britain copied fashions from the USA.']],
        ] as [$num, $question, $options])
        <div class="border-b border-gray-200 pb-6">
            <p class="font-semibold mb-3"><span class="font-bold mr-2">{{ $num }}</span>{{ $question }}</p>
            <div class="space-y-2 ml-8">
                @foreach($options as $letter => $text)
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="font-bold w-4">{{ $letter }}</span>
                    <span class="group-hover:text-blue-600 transition">{{ $text }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- Q27-30: Matching --}}
    <div class="mt-12">
        <h4 class="font-bold text-md mb-2">Questions 27–30</h4>
        <p class="mb-1">What comment is made about the programme for each of the following shows?</p>
        <p class="mb-6">Choose <strong>FOUR</strong> answers from the box and write the correct letter, <strong>A–F</strong>, next to Questions 27–30.</p>

        <div class="flex flex-col md:flex-row gap-8">
            {{-- Comment options --}}
            <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg md:w-1/2 self-start shadow-sm">
                <p class="font-bold mb-3">Comments about programme</p>
                <ul class="space-y-3 font-medium">
                    <li class="flex gap-3"><span class="font-bold">A</span><span>Its origin is somewhat controversial.</span></li>
                    <li class="flex gap-3"><span class="font-bold">B</span><span>It is historically significant for a country.</span></li>
                    <li class="flex gap-3"><span class="font-bold">C</span><span>It was effective at attracting audiences.</span></li>
                    <li class="flex gap-3"><span class="font-bold">D</span><span>It is included in a recent project.</span></li>
                    <li class="flex gap-3"><span class="font-bold">E</span><span>It contains insights into the show.</span></li>
                    <li class="flex gap-3"><span class="font-bold">F</span><span>It resembles an artwork.</span></li>
                </ul>
            </div>

            {{-- Shows with inputs --}}
            <div class="md:w-1/2 space-y-5">
                <p class="font-bold mb-2">show</p>
                @foreach([27 => 'Ruy Blas', 28 => 'Man of La Mancha', 29 => 'The Tragedy of Jane Shore', 30 => "The Sailors' Festival"] as $num => $show)
                <div class="flex items-center gap-3">
                    <span class="font-bold text-blue-700 text-lg w-6">{{ $num }}</span>
                    <span class="min-w-48 font-medium">{{ $show }}</span>
                    <select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        @foreach(['A','B','C','D','E','F'] as $l)
                        <option value="{{ $l }}">{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto mt-8 flex justify-between">
    <button @click="step = 2" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-xl transition-all">Previous Part</button>
    <button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
</div>
</div>

<!-- ================================================================ -->
<!-- PART 4 -->
<!-- ================================================================ -->
<div x-show="step === 4" x-cloak>
<div class="max-w-5xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
    <div class="flex justify-center mb-6">
        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
    </div>

    <div class="mb-6">
        <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
        <p class="italic mb-1">Complete the notes below.</p>
        <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
    </div>

    <div class="p-8 border border-gray-300 bg-gray-50 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-center mb-8">Inclusive design</h2>

        <p class="font-bold text-lg mb-4">Definition</p>
        <ul class="list-disc list-outside ml-6 space-y-4 mb-8 text-base">
            <li class="leading-loose pl-1">
                Designing products that can be accessed by a diverse range of people without the need for any
                <span class="inline-flex items-center align-bottom whitespace-nowrap">
                    <span class="font-bold text-blue-700 mx-1 text-lg">31</span>
                    <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-white focus:border-blue-500 text-center shadow-sm">
                </span>
            </li>
            <li class="leading-loose pl-1">
                Not the same as universal design: that is design for everyone, including catering for people with
                <span class="inline-flex items-center align-bottom whitespace-nowrap">
                    <span class="font-bold text-blue-700 mx-1 text-lg">32</span>
                    <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-white focus:border-blue-500 text-center shadow-sm">
                </span>
                problems.
            </li>
        </ul>

        <p class="font-bold text-lg mb-4">Examples of inclusive design</p>
        <ul class="list-disc list-outside ml-6 space-y-4 mb-8 text-base">
            <li class="leading-loose pl-1">
                <span class="inline-flex items-center align-bottom whitespace-nowrap">
                    <span class="font-bold text-blue-700 mr-1 text-lg">33</span>
                    <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-white focus:border-blue-500 text-center shadow-sm">
                </span>
                which are adjustable, avoiding back or neck problems
            </li>
            <li class="leading-loose pl-1">
                <span class="inline-flex items-center align-bottom whitespace-nowrap">
                    <span class="font-bold text-blue-700 mr-1 text-lg">34</span>
                    <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-white focus:border-blue-500 text-center shadow-sm">
                </span>
                in public toilets which are easier to use
            </li>
            <li class="pl-1">To assist the elderly:
                <ul class="list-none ml-4 space-y-3 mt-3">
                    <li class="flex items-center leading-loose">
                        <span class="mr-2">-</span>
                        designers avoid using
                        <span class="inline-flex items-center align-bottom whitespace-nowrap mx-1">
                            <span class="font-bold text-blue-700 mx-1 text-lg">35</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-white focus:border-blue-500 text-center shadow-sm">
                        </span>
                        in interfaces
                    </li>
                    <li class="flex items-center leading-loose">
                        <span class="mr-2">-</span>
                        people can make commands using a mouse, keyboard or their
                        <span class="inline-flex items-center align-bottom whitespace-nowrap mx-1">
                            <span class="font-bold text-blue-700 mx-1 text-lg">36</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-32 bg-white focus:border-blue-500 text-center shadow-sm">
                        </span>
                    </li>
                </ul>
            </li>
        </ul>

        <p class="font-bold text-lg mb-4">Impact of non-inclusive designs</p>
        <ul class="list-none ml-2 space-y-4 text-base">
            <li class="pl-1">
                <span class="font-semibold">· Access</span>
                <ul class="list-none ml-4 mt-2">
                    <li class="flex items-center">- Loss of independence for disabled people.</li>
                </ul>
            </li>
            <li class="pl-1">
                <span class="font-semibold">· Safety</span>
                <ul class="list-none ml-4 space-y-3 mt-2">
                    <li class="flex items-center leading-loose">
                        - Seatbelts are especially problematic for
                        <span class="inline-flex items-center align-bottom whitespace-nowrap mx-1">
                            <span class="font-bold text-blue-700 mx-1 text-lg">37</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-28 bg-white focus:border-blue-500 text-center shadow-sm">
                        </span>
                        women.
                    </li>
                    <li class="flex items-center leading-loose">
                        - PPE jackets are often unsuitable because of the size of women's
                        <span class="inline-flex items-center align-bottom whitespace-nowrap mx-1">
                            <span class="font-bold text-blue-700 mx-1 text-lg">38</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-28 bg-white focus:border-blue-500 text-center shadow-sm">
                        </span>
                    </li>
                    <li class="flex items-center leading-loose">
                        - PPE for female
                        <span class="inline-flex items-center align-bottom whitespace-nowrap mx-1">
                            <span class="font-bold text-blue-700 mx-1 text-lg">39</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-28 bg-white focus:border-blue-500 text-center shadow-sm">
                        </span>
                        officers dealing with emergencies is the worst.
                    </li>
                </ul>
            </li>
            <li class="pl-1">
                <span class="font-semibold">· Comfort in the workplace</span>
                <ul class="list-none ml-4 space-y-3 mt-2">
                    <li class="flex items-center leading-loose">
                        - The
                        <span class="inline-flex items-center align-bottom whitespace-nowrap mx-1">
                            <span class="font-bold text-blue-700 mx-1 text-lg">40</span>
                            <input type="text" class="border border-gray-300 outline-none px-2 py-1 w-28 bg-white focus:border-blue-500 text-center shadow-sm">
                        </span>
                        in offices is often too low for women.
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="max-w-5xl mx-auto mt-8 flex justify-between">
    <button @click="step = 3" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl transition-all">Previous Part</button>
    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Submit Answers</button>
</div>
</div>

            </div>
        </main>
    </div>

    {{-- Audio Player --}}
    @include('assignments.ielts.listening.partials.audio-player', ['set' => 'Mock Up ' . ($testId ?? 3), 'section' => $material ?? null])

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
