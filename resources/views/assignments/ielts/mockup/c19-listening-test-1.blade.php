<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Up - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                        <p class="text-gray-600 mt-1">Cambridge {{ $edition }} Test {{ $testId }}</p>
                    </div>
                </div>
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 1]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-white border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
            </div>
        </div>

        <div x-data="{ step: 1 }" x-init="$watch('step', value => $dispatch('part-changed', value))">

            {{-- PART 1 --}}
            <div x-show="step === 1">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1–10</span></h3>
                        <p class="italic mb-2">Complete the notes below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>
                    </div>
                    <div class="border border-black p-6">
                        <h2 class="text-2xl font-bold text-center mb-6">Hinchingbrooke Country Park</h2>
                        <div class="mb-5">
                            <p class="font-bold mb-3">The park</p>
                            <div class="space-y-3 ml-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="w-20">Area: <span class="font-bold">1</span></span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    <span>hectares</span>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Habitats: wetland, grassland and woodland</span>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Wetland: lakes, ponds and a <span class="font-bold">2</span></span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Wildlife includes birds, insects and animals</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <p class="font-bold mb-3">Subjects studied in educational visits include</p>
                            <div class="space-y-3 ml-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Science: Children look at <span class="font-bold">3</span></span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    <span>about plants, etc.</span>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Geography: includes learning to use a <span class="font-bold">4</span></span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    <span>and compass</span>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>History: changes in land use</span>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Leisure and tourism: mostly concentrates on the park's <span class="font-bold">5</span></span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                </div>
                                <div class="flex gap-2">
                                    <span class="whitespace-nowrap">Music: Children make <span class="font-bold">6</span></span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2 flex-none" placeholder="">
                                    <span class="inline">with natural materials, and experiment with rhythm and speed.</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <p class="font-bold mb-3">Benefits of outdoor educational visits</p>
                            <div class="space-y-3 ml-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>They give children a feeling of <span class="font-bold">7</span></span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    <span>that they may not have elsewhere.</span>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Children learn new <span class="font-bold">8</span></span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    <span>and gain self-confidence.</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="font-bold mb-3">Practical issues</p>
                            <div class="space-y-3 ml-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Cost per child: <span class="font-bold">9</span> £</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Adults, such as <span class="font-bold">10</span></span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    <span>, free</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-end">
                    <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
                </div>
            </div>

            {{-- PART 2 --}}
            <div x-show="step === 2" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
                        <h4 class="font-bold text-md mb-2">Questions 11–15</h4>
                        <p class="italic">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                    </div>
                    <h2 class="text-xl font-bold text-center mb-6">Stanthorpe Twinning Association</h2>
                    <div class="pl-4 space-y-6">
                        @foreach([
                            [11, 'During the visit to Malatte, in France, members especially enjoyed', ['going to a theme park.', 'experiencing a river trip.', 'visiting a cheese factory.']],
                            [12, 'What will happen in Stanthorpe to mark the 25th anniversary of the Twinning Association?', ['A tree will be planted.', 'A garden seat will be bought.', 'A footbridge will be built.']],
                            [13, 'Which event raised most funds this year?', ['the film show', 'the pancake evening', 'the cookery demonstration']],
                            [14, 'For the first evening with the French visitors host families are advised to', ['take them for a walk round the town.', 'go to a local restaurant.', 'have a meal at home.']],
                            [15, 'On Saturday evening there will be the chance to', ['listen to a concert.', 'watch a match.', 'take part in a competition.']],
                        ] as [$num, $question, $options])
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">{{ $num }}</span> {{ $question }}</p>
                            <div class="space-y-2 ml-8">
                                @foreach(['A', 'B', 'C'] as $i => $letter)
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">{{ $letter }}</span><span class="group-hover:text-blue-600 transition">{{ $options[$i] }}</span></label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        <div>
                            <h4 class="font-bold text-md mb-1 mt-6">Questions 16–20</h4>
                            <p class="italic mb-2">Label the map below.</p>
                            <p class="italic mb-6">Write the correct letter, <span class="font-bold">A–H</span>, next to Questions 16–20.</p>
                            
                            <h2 class="text-2xl font-bold text-center mb-4">Farley House</h2>
                            
                            <div class="flex justify-center mb-8">
                                <div class="w-full max-w-2xl h-80 bg-gray-200 flex items-center justify-center text-gray-400 font-bold border-2 border-dashed border-gray-400 overflow-hidden relative">
                                    <span class="z-10 bg-white px-4 py-2 rounded-lg opacity-80">Placeholder for Map Image of Farley House</span>
                                </div>
                            </div>

                            <div class="max-w-md mx-auto space-y-4">
                                @foreach([16 => 'Farm shop', 17 => 'Disabled entry', 18 => 'Adventure playground', 19 => 'Kitchen gardens', 20 => 'The Temple of the Four Winds'] as $num => $place)
                                <div class="flex items-center gap-4 border-b border-gray-100 pb-2">
                                    <span class="font-bold w-6">{{ $num }}</span>
                                    <span class="flex-1">{{ $place }}</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-16 bg-transparent focus:border-blue-500 text-center uppercase font-bold text-lg" maxlength="1" placeholder="">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 1" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                    <button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
                </div>
            </div>

            {{-- PART 3 --}}
            <div x-show="step === 3" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
                    </div>
                    <div class="pl-4 space-y-6 mt-8">
                        <div x-data="{ selected21_22: [] }" x-effect="if (selected21_22.length > 2) selected21_22.shift()">
                            <h4 class="font-bold text-md mb-1">Questions 21 and 22</h4>
                            <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                            
                            <p class="font-semibold mb-4">Which <span class="font-bold">TWO</span> things did Colin find most satisfying about his bread reuse project?</p>
                            
                            <div class="space-y-2 ml-4">
                                @foreach([
                                    'A' => 'receiving support from local restaurants',
                                    'B' => 'finding a good way to prevent waste',
                                    'C' => 'overcoming problems in a basic process',
                                    'D' => 'experimenting with designs and colours',
                                    'E' => 'learning how to apply 3-D printing'
                                ] as $letter => $option)
                                <label class="flex items-start gap-3 cursor-pointer group mb-2">
                                    <input type="checkbox" name="q21_22[]" value="{{ $letter }}" x-model="selected21_22" class="w-5 h-5 mt-1 text-blue-600 rounded border-gray-300">
                                    <span class="font-bold w-4 mt-0.5">{{ $letter }}</span>
                                    <span class="group-hover:text-blue-600 transition">{{ $option }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6 mt-6" x-data="{ selected23_24: [] }" x-effect="if (selected23_24.length > 2) selected23_24.shift()">
                            <h4 class="font-bold text-md mb-1">Questions 23 and 24</h4>
                            <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                            
                            <p class="font-semibold mb-4">Which <span class="font-bold">TWO</span> ways do the students agree that touch-sensitive sensors for food labels could be developed in future?</p>
                            
                            <div class="space-y-2 ml-4">
                                @foreach([
                                    'A' => 'for use on medical products',
                                    'B' => 'to show that food is no longer fit to eat',
                                    'C' => 'for use with drinks as well as foods',
                                    'D' => 'to provide applications for blind people',
                                    'E' => 'to indicate the weight of certain foods'
                                ] as $letter => $option)
                                <label class="flex items-start gap-3 cursor-pointer group mb-2">
                                    <input type="checkbox" name="q23_24[]" value="{{ $letter }}" x-model="selected23_24" class="w-5 h-5 mt-1 text-blue-600 rounded border-gray-300">
                                    <span class="font-bold w-4 mt-0.5">{{ $letter }}</span>
                                    <span class="group-hover:text-blue-600 transition">{{ $option }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="font-bold text-md mb-1">Questions 25–30</h4>
                            <p class="font-semibold mb-1">What is the students' opinion about each of the following food trends?</p>
                            <p class="italic mb-6">Choose <span class="font-bold">SIX</span> answers from the box and write the correct letter, <span class="font-bold">A–H</span>, next to Questions 25–30.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="border border-gray-400 p-5 rounded-lg bg-white">
                                    <h5 class="font-bold text-center mb-4 text-base border-b border-gray-300 pb-2">Opinions</h5>
                                    <div class="space-y-3 text-sm">
                                        @foreach([
                                            'A' => 'This is only relevant to young people.',
                                            'B' => 'This may have disappointing results.',
                                            'C' => 'This already seems to be widespread.',
                                            'D' => 'Retailers should do more to encourage this.',
                                            'E' => 'More financial support is needed for this.',
                                            'F' => 'Most people know little about this.',
                                            'G' => 'There should be stricter regulations about this.',
                                            'H' => 'This could be dangerous.'
                                        ] as $l => $t)
                                        <div class="flex items-start gap-3"><span class="font-bold">{{ $l }}</span><span class="leading-tight">{{ $t }}</span></div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <h5 class="font-bold mb-4 text-base">Food trends</h5>
                                    <div class="space-y-4">
                                        @foreach([
                                            25 => 'Use of local products',
                                            26 => 'Reduction in unnecessary packaging',
                                            27 => 'Gluten-free and lactose-free food',
                                            28 => 'Use of branded products related to celebrity chefs',
                                            29 => "Development of 'ghost kitchens' for takeaway food",
                                            30 => 'Use of mushrooms for common health concerns'
                                        ] as $num => $trend)
                                        <div class="flex items-start gap-4 mb-2 border-b border-gray-100 pb-2">
                                            <span class="font-bold w-6 mt-1">{{ $num }}</span>
                                            <span class="flex-1 leading-tight mt-1">{{ $trend }}</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-16 bg-transparent focus:border-blue-500 text-center uppercase font-bold text-lg flex-none" maxlength="1" placeholder="">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 2" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                    <button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
                </div>
            </div>

            {{-- PART 4 --}}
            <div x-show="step === 4" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
                        <p class="italic mb-2">Complete the notes below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                    </div>
                    <div class="border border-black p-6">
                        <h2 class="text-2xl font-bold text-center mb-6">Céide Fields</h2>
                        <ul class="list-disc ml-8 space-y-2 mb-8 text-lg">
                            <li>an important Neolithic archaeological site in the northwest of Ireland</li>
                        </ul>
                        
                        <div class="mb-8">
                            <h4 class="font-bold text-lg mb-4">Discovery</h4>
                            <ul class="list-disc ml-8 space-y-5 text-base">
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        In the 1930s, a local teacher realised that stones beneath the bog surface were once <span class="font-bold ml-1">31</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        .
                                    </div>
                                </li>
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap mb-3">
                                        His <span class="font-bold ml-1">32</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        became an archaeologist and undertook an investigation of the site:
                                    </div>
                                    <ul class="list-none ml-2 space-y-3 relative">
                                        <li class="relative pl-5 flex items-center gap-2 flex-wrap before:content-['–'] before:absolute before:left-0 before:text-gray-800">
                                            a traditional method used by local people to dig for <span class="font-bold ml-1">33</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                            was used to identify where stones were located
                                        </li>
                                        <li class="relative pl-5 flex items-center gap-2 flex-wrap before:content-['–'] before:absolute before:left-0 before:text-gray-800">
                                            carbon dating later proved the site was Neolithic.
                                        </li>
                                    </ul>
                                </li>
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        Items are well preserved in the bog because of a lack of <span class="font-bold ml-1">34</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        .
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-8 mt-10">
                            <h4 class="font-bold text-lg mb-4">Neolithic farmers</h4>
                            <ul class="list-disc ml-8 space-y-5 text-base">
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        Houses were <span class="font-bold ml-1">35</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        in shape and had a hole in the roof.
                                    </div>
                                </li>
                                <li class="pl-2">
                                    <div class="mb-3">Neolithic innovations include:</div>
                                    <ul class="list-none ml-2 space-y-3 relative">
                                        <li class="relative pl-5 flex items-center gap-2 flex-wrap before:content-['–'] before:absolute before:left-0 before:text-gray-800">
                                            cooking indoors
                                        </li>
                                        <li class="relative pl-5 flex items-center gap-2 flex-wrap before:content-['–'] before:absolute before:left-0 before:text-gray-800">
                                            pots used for storage and to make <span class="font-bold ml-1">36</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                            .
                                        </li>
                                    </ul>
                                </li>
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        Each field at Céide was large enough to support a big <span class="font-bold ml-1">37</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        .
                                    </div>
                                </li>
                                <li class="pl-2">
                                    <div class="flex flex-wrap gap-2 items-center">
                                        The fields were probably used to restrict the grazing of animals – no evidence of structures to house them during <span class="font-bold ml-1">38</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        .
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mb-5 mt-10">
                            <h4 class="font-bold text-lg mb-4">Reasons for the decline in farming</h4>
                            <ul class="list-disc ml-8 space-y-5 text-base">
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        a decline in <span class="font-bold ml-1">39</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        quality
                                    </div>
                                </li>
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        an increase in <span class="font-bold ml-1">40</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    </div>
                                </li>
                            </ul>
                        </div>
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

@include('assignments.ielts.listening.partials.audio-player', ['set' => 'Mock Up ' . $testId, 'section' => $material])

<script>
document.addEventListener('DOMContentLoaded', function() {});
</script>
<style>main{padding-bottom:250px!important;}</style>
</body>
</html>
