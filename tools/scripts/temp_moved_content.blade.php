    <div class="bg-white rounded-3xl shadow-xl border-t-4 border-indigo-500 overflow-hidden mb-8">
        <div class="p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Part 5: Questions 26-30</h2>
            <p class="text-gray-700 mb-6 font-medium leading-relaxed">
                Based on the dialogue you hear, choose the letters from the box, <span class="font-bold text-indigo-600">A-K</span>, that represent the information to complete sentences 26-30.
                <br>
                <span class="font-bold text-red-600">NO LETTER IS USED MORE THAN ONCE.</span> There are more options than are required. The recording is played once only.
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <!-- Options Column -->
                <div class="lg:sticky lg:top-8">
                    <div class="bg-indigo-50 rounded-2xl p-6 shadow-inner border border-indigo-100">
                        <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Options (A-K)
                        </h3>
                        <ul class="space-y-2 text-sm">
                            @foreach([
                                'A' => 'French',
                                'B' => 'electronic dictionary',
                                'C' => 'book dictionary',
                                'D' => '1 month',
                                'E' => '3 months',
                                'F' => '3 years',
                                'G' => '5 years',
                                'H' => 'more examples visible',
                                'I' => 'fewer examples visible',
                                'J' => 'slower',
                                'K' => 'faster'
                            ] as $key => $value)
                            <li class="flex items-start gap-2 bg-white p-2 rounded-lg border border-indigo-100 shadow-sm">
                                <span class="flex-none flex items-center justify-center w-5 h-5 rounded bg-indigo-100 text-indigo-700 font-bold text-xs">{{ $key }}</span>
                                <span class="text-gray-800">{{ $value }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Questions Column -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <h3 class="text-lg font-bold text-gray-800">Sentences</h3>
                    </div>
                    
                    <!-- Example -->
                    <div class="mb-4 p-3 bg-gray-100 rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-600 text-sm">Example: The language of dictionary the customer wants is</span>
                            <span class="font-bold text-indigo-600 bg-white border border-indigo-200 px-2 py-1 rounded text-sm">A</span>
                        </div>
                    </div>

                    @foreach([
                        26 => 'The daughter has been studying the language for',
                        27 => 'The shop assistant recommends',
                        28 => 'The daughter has been on exchanges for a total of',
                        29 => 'An electronic dictionary has',
                        30 => 'For advanced learners, an electronic dictionary is'
                    ] as $qNum => $qText)
                    <div class="group flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-indigo-400 hover:bg-white hover:shadow-md transition-all duration-200">
                        <div class="flex items-center gap-4 flex-1">
                            <span class="flex-none w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-300 text-gray-600 font-bold text-sm shadow-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 group-hover:border-indigo-200 transition-colors">{{ $qNum }}.</span>
                            <span class="font-medium text-gray-800 group-hover:text-indigo-900 transition-colors">{{ $qText }}</span>
                        </div>
                        <div class="relative ml-4">
                            <select name="part5_q{{ $qNum }}" class="appearance-none bg-white block w-20 pl-3 pr-8 py-2 border border-gray-300 text-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-bold text-center cursor-pointer hover:border-gray-400 transition-colors">
                                <option value="" disabled selected>-</option>
                                @foreach(range('A', 'K') as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
             <!-- Audio Player (Part 5) -->
             @include('assignments.ielts.listening.partials.audio-player', [
                 'audio_url' => asset('assets/audio/ielts/listening/material_2_part5.mp3'),
                 'title' => 'Audio - Dictionary Dialogue',
                 'fixed' => false
             ])
        </div>
    </div>


    <!-- Part 6: Dictionary Comparison -->
    <div class="bg-white rounded-3xl shadow-xl border-t-4 border-rose-500 overflow-hidden mb-8">
        <div class="p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Part 6: Questions 31-38</h2>
            <p class="text-gray-700 mb-6 font-medium leading-relaxed">
                Based on the dialogue you hear, choose letters from the box, <span class="font-bold text-rose-600">A-J</span>, that represent the descriptions of the two dictionaries below. 
                <br>
                <span class="font-bold text-red-600">NO LETTER IS USED MORE THAN ONCE.</span> There are more options than are required. The recording is played once only.
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <!-- Options Column -->
                <div class="lg:sticky lg:top-8">
                    <div class="bg-rose-50 rounded-2xl p-6 shadow-inner border border-rose-100">
                        <h3 class="text-lg font-bold text-rose-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Descriptions (A-J)
                        </h3>
                        <ul class="space-y-2 text-sm">
                            @foreach([
                                'A' => 'black and green',
                                'B' => 'red and blue',
                                'C' => 'a CD with a pronunciation guide',
                                'D' => 'clearer definitions',
                                'E' => 'clearer type - easier to read',
                                'F' => 'free annual updates',
                                'G' => 'more academic examples',
                                'H' => 'more academic tone',
                                'I' => 'more up-to-date examples',
                                'J' => 'a wider range of word forms given'
                            ] as $key => $value)
                            <li class="flex items-start gap-2 bg-white p-2 rounded-lg border border-rose-100 shadow-sm">
                                <span class="flex-none flex items-center justify-center w-5 h-5 rounded bg-rose-100 text-rose-700 font-bold text-xs">{{ $key }}</span>
                                <span class="text-gray-800">{{ $value }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Questions Column -->
                <div class="space-y-6">
                    <!-- Webster's Dictionary -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-4 border-b border-gray-200 pb-2">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-rose-600 shadow-sm border border-gray-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Webster's Dictionary</h3>
                        </div>
                        
                        <div class="space-y-3">
                        @foreach(range(31, 34) as $qNum)
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-100 hover:border-rose-300 transition-colors">
                            <span class="font-bold text-gray-500 w-8">{{ $qNum }}.</span>
                            <div class="relative">
                                <select name="part6_q{{ $qNum }}" class="appearance-none bg-gray-50 block w-20 pl-3 pr-8 py-2 border border-gray-300 text-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 font-bold text-center cursor-pointer hover:bg-white transition-colors">
                                    <option value="" disabled selected>-</option>
                                    @foreach(range('A', 'J') as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                    </div>

                    <!-- Branston's Dictionary -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-4 border-b border-gray-200 pb-2">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-indigo-600 shadow-sm border border-gray-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Branston's Dictionary</h3>
                        </div>
                        
                        <div class="space-y-3">
                        @foreach(range(35, 38) as $qNum)
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-100 hover:border-indigo-300 transition-colors">
                            <span class="font-bold text-gray-500 w-8">{{ $qNum }}.</span>
                            <div class="relative">
                                <select name="part6_q{{ $qNum }}" class="appearance-none bg-gray-50 block w-20 pl-3 pr-8 py-2 border border-gray-300 text-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-bold text-center cursor-pointer hover:bg-white transition-colors">
                                    <option value="" disabled selected>-</option>
                                    @foreach(range('A', 'J') as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
             <!-- Audio Player (Part 6) -->
             @include('assignments.ielts.listening.partials.audio-player', [
                 'audio_url' => asset('assets/audio/ielts/listening/material_2_part6.mp3'),
                 'title' => 'Audio - Dictionary Comparison',
                 'fixed' => false
             ])
        </div>
    </div>

    <!-- Part 7: Food Descriptions -->
    <div class="bg-white rounded-3xl shadow-xl border-t-4 border-amber-500 overflow-hidden mb-8">
        <div class="p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Part 7: Questions 39-45</h2>
            <p class="text-gray-700 mb-6 font-medium leading-relaxed">
                Based on the dialogue you hear, match the descriptions from the box, <span class="font-bold text-amber-600">A-I</span>, with the foods, 39-45.
                <br>
                <span class="font-bold text-red-600">NO LETTER IS USED MORE THAN ONCE.</span> There are more options than are required. The recording is played once only.
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <!-- Options Column -->
                <div class="lg:sticky lg:top-8 order-2 lg:order-1">
                    <div class="bg-amber-50 rounded-2xl p-6 shadow-inner border border-amber-100">
                        <h3 class="text-lg font-bold text-amber-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Descriptions (A-I)
                        </h3>
                        <ul class="space-y-2 text-sm">
                            @foreach([
                                'A' => 'long and thick',
                                'B' => 'mild with coconut',
                                'C' => 'unusual with potatoes',
                                'D' => 'round and flat',
                                'E' => 'slice with pineapple',
                                'F' => 'slightly spicy',
                                'G' => 'lamb curry',
                                'H' => 'thin and crispy',
                                'I' => 'vegetables in flour, fried'
                            ] as $key => $value)
                            <li class="flex items-start gap-2 bg-white p-2 rounded-lg border border-amber-100 shadow-sm">
                                <span class="flex-none flex items-center justify-center w-5 h-5 rounded bg-amber-100 text-amber-700 font-bold text-xs">{{ $key }}</span>
                                <span class="text-gray-800">{{ $value }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Questions Column -->
                <div class="space-y-4 order-1 lg:order-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <h3 class="text-lg font-bold text-gray-800">Foods</h3>
                    </div>

                    @foreach([
                        39 => 'Chapatti',
                        40 => 'Naan bread',
                        41 => 'Poppadom',
                        42 => 'Chicken korma',
                        43 => 'Rogan josh',
                        44 => 'Thai seafood curry',
                        45 => 'Bhaji'
                    ] as $qNum => $foodName)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-amber-400 hover:bg-white hover:shadow-md transition-all duration-200">
                        <div class="flex items-center gap-4 flex-1">
                            <span class="flex-none w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-300 text-gray-600 font-bold text-sm shadow-sm">{{ $qNum }}.</span>
                            <span class="font-medium text-gray-800">{{ $foodName }}</span>
                        </div>
                        <div class="relative ml-4">
                            <select name="part7_q{{ $qNum }}" class="appearance-none bg-white block w-20 pl-3 pr-8 py-2 border border-gray-300 text-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 font-bold text-center cursor-pointer hover:border-gray-400 transition-colors">
                                <option value="" disabled selected>-</option>
                                @foreach(range('A', 'I') as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
             <!-- Audio Player (Part 7) -->
             @include('assignments.ielts.listening.partials.audio-player', [
                 'audio_url' => asset('assets/audio/ielts/listening/material_2_part7.mp3'),
                 'title' => 'Audio - Food Descriptions',
                 'fixed' => false
             ])
        </div>
    </div>

    <!-- Part 8: Hotel Services -->
    <div class="bg-white rounded-3xl shadow-xl border-t-4 border-emerald-500 overflow-hidden mb-8">
        <div class="p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Part 8: Questions 46-51</h2>
            <p class="text-gray-700 mb-6 font-medium leading-relaxed">
                You will hear a talk about hotels. Based on the information you hear, match the hotels from the box, <span class="font-bold text-emerald-600">A-C</span>, with the descriptions, 46-51.
                <br>
                You may use some of the letters more than once. The recording is played once only.
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <!-- Options Column -->
                <div class="lg:sticky lg:top-8 order-2 lg:order-1">
                    <div class="bg-emerald-50 rounded-2xl p-6 shadow-inner border border-emerald-100">
                        <h3 class="text-lg font-bold text-emerald-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Hotels (A-C)
                        </h3>
                        <ul class="space-y-3">
                            @foreach([
                                'A' => 'Swan Hotel',
                                'B' => 'Sunrise Hotel',
                                'C' => 'Backpacker Hotel'
                            ] as $key => $value)
                            <li class="flex items-center gap-3 bg-white p-3 rounded-lg border border-emerald-100 shadow-sm">
                                <span class="flex-none flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-lg">{{ $key }}</span>
                                <span class="text-gray-800 font-semibold text-lg">{{ $value }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Questions Column -->
                <div class="space-y-4 order-1 lg:order-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <h3 class="text-lg font-bold text-gray-800">Descriptions</h3>
                    </div>

                    @foreach([
                        46 => 'Close to airport',
                        47 => 'Close to city centre',
                        48 => 'En suite bathroom',
                        49 => 'Satellite TV',
                        50 => 'Internet in room',
                        51 => 'Credit cards accepted'
                    ] as $qNum => $qText)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-emerald-400 hover:bg-white hover:shadow-md transition-all duration-200">
                        <div class="flex items-center gap-4 flex-1">
                            <span class="flex-none w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-300 text-gray-600 font-bold text-sm shadow-sm">{{ $qNum }}.</span>
                            <span class="font-medium text-gray-800">{{ $qText }}</span>
                        </div>
                        <div class="relative ml-4">
                            <select name="part8_q{{ $qNum }}" class="appearance-none bg-white block w-20 pl-3 pr-8 py-2 border border-gray-300 text-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-bold text-center cursor-pointer hover:border-gray-400 transition-colors">
                                <option value="" disabled selected>-</option>
                                @foreach(range('A', 'C') as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
             <!-- Audio Player (Part 8) -->
             @include('assignments.ielts.listening.partials.audio-player', [
                 'audio_url' => asset('assets/audio/ielts/listening/material_2_part8.mp3'),
                 'title' => 'Audio - Hotel Services',
                 'fixed' => false
             ])
        </div>
    </div>
</div>

<!-- Bottom Spacer for Audio Player -->
<div class="h-24"></div>
