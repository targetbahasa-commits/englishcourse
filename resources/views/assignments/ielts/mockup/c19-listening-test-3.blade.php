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
<body class="font-sans antialiased bg-gray-50">
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
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 3]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
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
                        <h4 class="font-bold text-md mb-2">Questions 1–6</h4>
                        <p class="italic mb-2">Complete the notes below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>
                    </div>
                    
                    <div class="border border-black p-6 mb-8">
                        <h2 class="text-2xl font-bold text-center mb-6">Local food shops</h2>
                        
                        <div class="mb-5">
                            <p class="font-bold mb-3">Where to go</p>
                            <ul class="list-disc ml-8 space-y-3">
                                <li class="pl-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        Kite Place – near the <span class="font-bold">1</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mb-5">
                            <p class="font-bold mb-3">Fish market</p>
                            <ul class="list-disc ml-8 space-y-3">
                                <li class="pl-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        cross the <span class="font-bold">2</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        and turn right
                                    </div>
                                </li>
                                <li class="pl-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        best to go before <span class="font-bold">3</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        pm, earlier than closing time
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mb-5">
                            <p class="font-bold mb-3">Organic shop</p>
                            <ul class="list-disc ml-8 space-y-3">
                                <li class="pl-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        called 4 '<input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">'
                                    </div>
                                </li>
                                <li class="pl-2">
                                    below a restaurant in the large, grey building
                                </li>
                                <li class="pl-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        look for the large <span class="font-bold">5</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        outside
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mb-5">
                            <p class="font-bold mb-3">Supermarket</p>
                            <ul class="list-disc ml-8 space-y-3">
                                <li class="pl-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        take a <span class="font-bold">6</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        minibus, number 289
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-bold text-md mb-2">Questions 7–10</h4>
                        <p class="italic mb-2">Complete the table below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                    </div>

                    <div class="overflow-x-auto w-full">
                        <table class="w-full border-collapse border border-black min-w-[600px] text-sm md:text-base">
                            <thead>
                                <tr>
                                    <th colspan="3" class="border border-black p-3 text-center bg-gray-100 font-bold">Shopping</th>
                                </tr>
                                <tr>
                                    <th class="border border-black p-3 bg-white w-1/4"></th>
                                    <th class="border border-black p-3 bg-white w-2/5 font-bold">To buy</th>
                                    <th class="border border-black p-3 bg-white w-2/5 font-bold">Other ideas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-black p-4 font-bold align-top">Fish market</td>
                                    <td class="border border-black p-4 align-top">a dozen prawns</td>
                                    <td class="border border-black p-4 align-top">
                                        <div class="flex flex-wrap items-center gap-2">
                                            a handful of <span class="font-bold">7</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-32 bg-transparent focus:border-blue-500 border-dotted border-b-2" placeholder="">
                                            <br><span class="inline-block mt-1">(type of seaweed)</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border border-black p-4 font-bold align-top">Organic shop</td>
                                    <td class="border border-black p-4 align-top">
                                        <div class="flex flex-wrap items-center gap-2">
                                            beans and a <span class="font-bold">8</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-32 bg-transparent focus:border-blue-500 border-dotted border-b-2" placeholder="">
                                            <br><span class="inline-block mt-1">for dessert</span>
                                        </div>
                                    </td>
                                    <td class="border border-black p-4 align-top">
                                        <div class="flex flex-wrap items-center gap-2">
                                            spices and <span class="font-bold">9</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-32 bg-transparent focus:border-blue-500 border-dotted border-b-2" placeholder="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border border-black p-4 font-bold align-top">Bakery</td>
                                    <td class="border border-black p-4 align-top">a brown loaf</td>
                                    <td class="border border-black p-4 align-top">
                                        <div class="flex flex-wrap items-center gap-2">
                                            a <span class="font-bold">10</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-32 bg-transparent focus:border-blue-500 border-dotted border-b-2" placeholder="">
                                            tart
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                        <h4 class="font-bold text-md mb-2">Questions 11–16</h4>
                        <p class="font-semibold mb-2">What information is given about each of the following festival workshops?</p>
                        <p class="italic mb-4">Choose <span class="font-bold">SIX</span> answers from the box and write the correct letter, <span class="font-bold">A–H</span>, next to Questions 11–16.</p>
                    </div>
                    
                    <div class="flex flex-col md:flex-row gap-8 mb-8">
                        <div class="border border-black p-6 bg-white flex-1 max-w-sm">
                            <h4 class="font-bold text-center mb-4 border-b border-gray-200 pb-2">Information</h4>
                            <ul class="space-y-3 list-none">
                                @foreach([
                                    'A' => 'involves painting and drawing',
                                    'B' => 'will be led by a prize-winning author',
                                    'C' => 'is aimed at children with a disability',
                                    'D' => 'involves a drama activity',
                                    'E' => 'focuses on new relationships',
                                    'F' => 'is aimed at a specific age group',
                                    'G' => 'explores an unhappy feeling',
                                    'H' => 'raises awareness of a particular culture'
                                ] as $letter => $val)
                                <li class="flex gap-4">
                                    <span class="font-bold w-4">{{ $letter }}</span> <span>{{ $val }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="flex-1">
                            <h4 class="font-bold mb-4">Festival workshops</h4>
                            <div class="space-y-4 max-w-sm">
                                @foreach([
                                    11 => 'Superheroes',
                                    12 => 'Just do it',
                                    13 => 'Count on me',
                                    14 => 'Speak up',
                                    15 => 'Jump for joy',
                                    16 => 'Sticks and stones'
                                ] as $num => $workshop)
                                <div class="flex items-center gap-4 border-b border-gray-100 py-3">
                                    <span class="font-bold w-6 text-lg">{{ $num }}</span>
                                    <span class="flex-1 text-base">{{ $workshop }}</span>
                                    <select class="appearance-none border border-black rounded-lg bg-white w-20 py-1.5 px-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 font-bold text-lg cursor-pointer hover:bg-gray-50 transition-colors" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2024%2024%22%20stroke-width%3D%222%22%20stroke%3D%22%234b5563%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20d%3D%22M19.5%208.25l-7.5%207.5-7.5-7.5%22%20%2F%3E%3C%2Fsvg%3E'); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1.25rem; padding-right: 1.5rem; text-align: left;">
                                        <option value=""></option>
                                        @foreach(['A','B','C','D','E','F','G','H'] as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-10" x-data="{ selected17_18: [] }" x-effect="if (selected17_18.length > 2) selected17_18.shift()">
                        <h4 class="font-bold text-md mb-1">Questions 17 and 18</h4>
                        <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        
                        <p class="font-semibold mb-4">Which <span class="font-bold">TWO</span> reasons does the speaker give for recommending <span class="italic">Alive and Kicking</span>?</p>
                        
                        <div class="space-y-3 ml-4">
                            @foreach([
                                'A' => 'It will appeal to both boys and girls.',
                                'B' => 'The author is well known.',
                                'C' => 'It has colourful illustrations.',
                                'D' => 'It is funny.',
                                'E' => 'It deals with an important topic.'
                            ] as $letter => $option)
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="q17_18[]" value="{{ $letter }}" x-model="selected17_18" class="w-5 h-5 mt-0.5 text-blue-600 rounded border-gray-400">
                                <span class="font-bold w-4 mt-0">{{ $letter }}</span>
                                <span class="group-hover:text-blue-600 transition">{{ $option }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6 mt-8" x-data="{ selected19_20: [] }" x-effect="if (selected19_20.length > 2) selected19_20.shift()">
                        <h4 class="font-bold text-md mb-1">Questions 19 and 20</h4>
                        <p class="italic mb-4">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                        
                        <p class="font-semibold mb-4">Which <span class="font-bold">TWO</span> pieces of advice does the speaker give to parents about reading?</p>
                        
                        <div class="space-y-3 ml-4">
                            @foreach([
                                'A' => 'Encourage children to write down new vocabulary.',
                                'B' => 'Allow children to listen to audio books.',
                                'C' => 'Get recommendations from librarians.',
                                'D' => 'Give children a choice about what they read.',
                                'E' => 'Only read aloud to children until they can read independently.'
                            ] as $letter => $option)
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="q19_20[]" value="{{ $letter }}" x-model="selected19_20" class="w-5 h-5 mt-0.5 text-blue-600 rounded border-gray-400">
                                <span class="font-bold w-4 mt-0">{{ $letter }}</span>
                                <span class="group-hover:text-blue-600 transition">{{ $option }}</span>
                            </label>
                            @endforeach
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
                    
                    <div class="mb-8">
                        <h4 class="font-bold text-md mb-2">Questions 21–25</h4>
                        <p class="italic mb-6">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                        
                        <h2 class="text-2xl font-bold text-center mb-8">Science experiment for Year 12 students</h2>
                        
                        <div class="pl-4 space-y-8">
                            @foreach([
                                [21, 'How does Clare feel about the students in her Year 12 science class?', ['worried that they are not making progress', 'challenged by their poor behaviour in class', 'frustrated at their lack of interest in the subject']],
                                [22, 'How does Jake react to Clare\'s suggestion about an experiment based on children\'s diet?', ['He is concerned that the results might not be meaningful.', 'He feels some of the data might be difficult to obtain.', 'He suspects that the conclusions might be upsetting.']],
                                [23, 'What problem do they agree may be involved in an experiment involving animals?', ['Any results may not apply to humans.', 'It may be complicated to get permission.', 'Students may not be happy about animal experiments.']],
                                [24, 'What question do they decide the experiment should address?', ['Are mice capable of controlling their food intake?', 'Does an increase in sugar lead to health problems?', 'How much do supplements of different kinds affect health?']],
                                [25, 'Clare might also consider doing another experiment involving', ['other types of food supplement.', 'different genetic strains of mice.', 'varying amounts of exercise.']],
                            ] as [$num, $question, $options])
                            <div class="border-b border-gray-100 pb-5">
                                <p class="font-semibold mb-4"><span class="font-bold mr-2">{{ $num }}</span> {{ $question }}</p>
                                <div class="space-y-3 ml-8">
                                    @foreach(['A', 'B', 'C'] as $i => $letter)
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="w-5 h-5 mt-0.5 text-blue-600 rounded-full border-gray-400">
                                        <span class="font-bold w-4 mt-0">{{ $letter }}</span>
                                        <span class="group-hover:text-blue-600 transition pt-0">{{ $options[$i] }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mt-10 border-t border-gray-200 pt-8">
                        <h4 class="font-bold text-md mb-2">Questions 26–30</h4>
                        <p class="italic mb-2">Complete the flowchart below.</p>
                        <p class="italic mb-6">Choose <span class="font-bold">FIVE</span> answers from the box and write the correct letter, <span class="font-bold">A–H</span>, next to Questions 26–30.</p>
                        
                        <div class="flex justify-center mb-8">
                            <div class="border border-black p-6 bg-white max-w-sm w-full">
                                <ul class="grid grid-cols-2 gap-y-3 text-sm md:text-base">
                                    @foreach([
                                        'A' => 'size',     'E' => 'cereal',
                                        'B' => 'escape',   'F' => 'calculations',
                                        'C' => 'age',      'G' => 'changes',
                                        'D' => 'water',    'H' => 'colour'
                                    ] as $letter => $val)
                                    <li class="flex gap-3">
                                        <span class="font-bold">{{ $letter }}</span> <span>{{ $val }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="max-w-3xl mx-auto flex flex-col items-center">
                            
                            <!-- Step 26 -->
                            <div class="border border-gray-400 p-6 bg-white w-full text-center">
                                <span class="inline-flex items-center gap-2 text-base md:text-lg">
                                    Choose mice which are all the same <span class="font-bold ml-1">26</span>
                                    <select class="appearance-none border-2 border-blue-500 rounded-lg bg-white px-3 py-1 font-bold outline-none cursor-pointer hover:border-blue-600 transition-colors" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2024%2024%22%20stroke-width%3D%222%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20d%3D%22M19.5%208.25l-7.5%207.5-7.5-7.5%22%20%2F%3E%3C%2Fsvg%3E'); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1rem; padding-right: 2rem;">
                                        <option value=""></option>
                                        @foreach(['A','B','C','D','E','F','G','H'] as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    .
                                </span>
                            </div>
                            
                            <div class="flex justify-center my-3">
                                <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m0 0l-5-5m5 5l5-5"></path></svg>
                            </div>
                            
                            <!-- Step 27 -->
                            <div class="border border-gray-400 p-6 bg-white w-full text-center">
                                <span class="inline-flex flex-wrap items-center justify-center gap-2 text-base md:text-lg">
                                    Divide the mice into two groups, each with a different <span class="font-bold ml-1">27</span>
                                    <select class="appearance-none border-2 border-blue-500 rounded-lg bg-white px-3 py-1 font-bold outline-none cursor-pointer hover:border-blue-600 transition-colors" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2024%2024%22%20stroke-width%3D%222%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20d%3D%22M19.5%208.25l-7.5%207.5-7.5-7.5%22%20%2F%3E%3C%2Fsvg%3E'); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1rem; padding-right: 2rem;">
                                        <option value=""></option>
                                        @foreach(['A','B','C','D','E','F','G','H'] as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    .
                                </span>
                            </div>
                            
                            <div class="flex justify-center my-3">
                                <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m0 0l-5-5m5 5l5-5"></path></svg>
                            </div>
                            
                            <!-- Step 28 -->
                            <div class="border border-gray-400 p-6 bg-white w-full flex flex-col items-center md:items-start md:pl-16">
                                <div class="space-y-3 text-base md:text-lg">
                                    <p class="text-center md:text-left">Put each group in a separate cage.</p>
                                    <p class="text-center md:text-left">Feed group A commercial mouse food.</p>
                                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
                                        Feed group B the same, but also sugar contained in <span class="font-bold ml-1">28</span>
                                        <select class="appearance-none border-2 border-blue-500 rounded-lg bg-white px-3 py-1 font-bold outline-none cursor-pointer hover:border-blue-600 transition-colors" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2024%2024%22%20stroke-width%3D%222%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20d%3D%22M19.5%208.25l-7.5%207.5-7.5-7.5%22%20%2F%3E%3C%2Fsvg%3E'); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1rem; padding-right: 2rem;">
                                            <option value=""></option>
                                            @foreach(['A','B','C','D','E','F','G','H'] as $opt)
                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                        .
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-center my-3">
                                <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m0 0l-5-5m5 5l5-5"></path></svg>
                            </div>
                            
                            <!-- Step 29 -->
                            <div class="border border-gray-400 p-6 bg-white w-full flex flex-col items-center md:items-start md:pl-16">
                                <div class="space-y-3 text-base md:text-lg">
                                    <p class="text-center md:text-left">Take measurements using an electronic scale.</p>
                                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
                                        Place them in a weighing chamber to prevent <span class="font-bold ml-1">29</span>
                                        <select class="appearance-none border-2 border-blue-500 rounded-lg bg-white px-3 py-1 font-bold outline-none cursor-pointer hover:border-blue-600 transition-colors" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2024%2024%22%20stroke-width%3D%222%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20d%3D%22M19.5%208.25l-7.5%207.5-7.5-7.5%22%20%2F%3E%3C%2Fsvg%3E'); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1rem; padding-right: 2rem;">
                                            <option value=""></option>
                                            @foreach(['A','B','C','D','E','F','G','H'] as $opt)
                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                        .
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-center my-3">
                                <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m0 0l-5-5m5 5l5-5"></path></svg>
                            </div>

                            <!-- Step 30 -->
                            <div class="border border-gray-400 p-6 bg-white w-full text-center">
                                <span class="inline-flex items-center justify-center gap-2 text-base md:text-lg">
                                    Do all necessary <span class="font-bold ml-1">30</span>
                                    <select class="appearance-none border-2 border-blue-500 rounded-lg bg-white px-3 py-1 font-bold outline-none cursor-pointer hover:border-blue-600 transition-colors" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2024%2024%22%20stroke-width%3D%222%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20d%3D%22M19.5%208.25l-7.5%207.5-7.5-7.5%22%20%2F%3E%3C%2Fsvg%3E'); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1rem; padding-right: 2rem;">
                                        <option value=""></option>
                                        @foreach(['A','B','C','D','E','F','G','H'] as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    .
                                </span>
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
                        <h2 class="text-2xl font-bold text-center mb-8">Microplastics</h2>
                        
                        <div class="mb-8">
                            <h4 class="font-bold text-lg mb-4">Where microplastics come from</h4>
                            <ul class="list-disc ml-8 space-y-4 text-base">
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        fibres from some <span class="font-bold ml-1">31</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        during washing
                                    </div>
                                </li>
                                <li class="pl-2">the breakdown of large pieces of plastic</li>
                                <li class="pl-2">waste from industry</li>
                                <li class="pl-2">the action of vehicle tyres on roads</li>
                            </ul>
                        </div>

                        <div class="mb-8 mt-10">
                            <h4 class="font-bold text-lg mb-4">Effects of microplastics</h4>
                            <ul class="list-disc ml-8 space-y-4 text-base">
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        They cause injuries to the <span class="font-bold ml-1">32</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        of wildlife and affect their
                                        <br class="hidden md:block"> digestive systems.
                                    </div>
                                </li>
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                        They enter the food chain, e.g., in bottled and tap water, <span class="font-bold ml-1">33</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                    </div>
                                    and seafood.
                                </li>
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        They may not affect human health, but they are already banned in skin cleaning
                                        <br class="hidden md:block"> products and <span class="font-bold ml-1">34</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        in some countries.
                                    </div>
                                </li>
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        Microplastics enter the soil through the air, rain and <span class="font-bold ml-1">35</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        .
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mb-5 mt-10">
                            <h4 class="font-bold text-lg mb-4">Microplastics in the soil – a study by Anglia Ruskin University</h4>
                            <ul class="list-disc ml-8 space-y-4 text-base">
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        Earthworms are important because they add <span class="font-bold ml-1">36</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        to the soil.
                                    </div>
                                </li>
                                <li class="pl-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        The study aimed to find whether microplastics in earthworms affect the 
                                        <br class="hidden md:block"> <span class="font-bold ml-1">37</span>
                                        <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                        of plants.
                                    </div>
                                </li>
                                <li class="pl-2">
                                    <div class="mb-3">The study found that microplastics caused:</div>
                                    <ul class="list-none ml-2 space-y-3 relative">
                                        <li class="relative pl-5 flex items-center gap-2 flex-wrap before:content-['–'] before:absolute before:left-0 before:text-gray-800">
                                            <span class="font-bold ml-1">38</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                            loss in earthworms
                                        </li>
                                        <li class="relative pl-5 flex items-center gap-2 flex-wrap before:content-['–'] before:absolute before:left-0 before:text-gray-800">
                                            fewer seeds to germinate
                                        </li>
                                        <li class="relative pl-5 flex items-center gap-2 flex-wrap before:content-['–'] before:absolute before:left-0 before:text-gray-800">
                                            a rise in the level of <span class="font-bold ml-1">39</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                            in the soil.
                                        </li>
                                    </ul>
                                </li>
                                <li class="pl-2 mt-4">
                                    <div class="mb-3">The study concluded:</div>
                                    <ul class="list-none ml-2 space-y-3 relative">
                                        <li class="relative pl-5 flex items-center gap-2 flex-wrap before:content-['–'] before:absolute before:left-0 before:text-gray-800">
                                            soil should be seen as an important natural process.
                                        </li>
                                        <li class="relative pl-5 flex items-center gap-2 flex-wrap before:content-['–'] before:absolute before:left-0 before:text-gray-800">
                                            changes to soil damage both ecosystems and <span class="font-bold ml-1">40</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400 border-dotted border-b-2" placeholder="">
                                            .
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 3" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                    <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Submit Answers</button>
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
