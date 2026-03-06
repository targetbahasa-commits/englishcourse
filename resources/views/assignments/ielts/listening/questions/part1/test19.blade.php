<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>

    {{-- Questions 1-4 --}}
    <h4 class="text-lg font-bold mb-2">Questions 1-4</h4>
    <p class="mb-1 text-gray-700">Complete the notes below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-xl font-bold mb-4 text-center uppercase tracking-wide">Notes on Island Hotel</h4>

    {{-- Example table --}}
    <div class="border border-gray-200 rounded-lg overflow-hidden mb-6">
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 italic text-gray-500 text-sm">Example</div>
            <div class="p-3 italic text-gray-500 text-sm">Answer</div>
        </div>
        <div class="grid grid-cols-2 bg-gray-50">
            <div class="p-3 italic text-gray-600 text-sm">Type of room required:</div>
            <div class="p-3 italic text-gray-600 text-sm">double room</div>
        </div>
    </div>

    <div class="space-y-4 text-lg text-gray-800 mb-10">
        {{-- Time sub-header --}}
        <p class="font-bold text-gray-900">Time</p>
        <p class="pl-2 text-gray-600">• The length of stay: approx 2 weeks</p>
        <p class="pl-2 text-gray-600">• Starting date: 25th April</p>

        {{-- Temperature sub-header --}}
        <p class="font-bold text-gray-900 mt-3">Temperature</p>

        {{-- Q1 --}}
        <p class="pl-2 flex items-center flex-wrap gap-1">
            • Daytime: up to
            <strong class="mx-1">1</strong>
            <span class="inline-block w-32">
                <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            °C
        </p>
        <p class="pl-2 text-gray-600">• Erratic weather</p>

        {{-- Transport sub-header --}}
        <p class="font-bold text-gray-900 mt-3">Transport</p>
        <p class="pl-2 text-gray-600">• Pick-up service is provided.</p>

        {{-- Q2 --}}
        <p class="pl-2 flex items-center flex-wrap gap-1">
            • Normally transferring to the airport takes about
            <strong class="mx-1">2</strong>
            <span class="inline-block w-32">
                <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>

        {{-- Facilities sub-header --}}
        <p class="font-bold text-gray-900 mt-3">Facilities</p>

        {{-- Q3 --}}
        <p class="pl-2 flex items-center flex-wrap gap-1">
            • en-suite facilities and a
            <strong class="mx-1">3</strong>
            <span class="inline-block w-32">
                <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>
        <p class="pl-2 text-gray-600">• gym and spa facilities</p>
        <p class="pl-2 text-gray-600">• a large outdoor swimming pool</p>

        {{-- Q4 --}}
        <p class="pl-2 flex items-center flex-wrap gap-1">
            • three standard
            <strong class="mx-1">4</strong>
            <span class="inline-block w-32">
                <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>
    </div>

    {{-- Questions 5-10 --}}
    <h4 class="text-lg font-bold mb-2">Questions 5-10</h4>
    <p class="mb-1 text-gray-700">Complete the table below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for each answer.</p>

    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Table header --}}
        <div class="grid grid-cols-3 bg-gray-100 border-b border-gray-200">
            <div class="p-3 font-bold text-center text-gray-800">Day</div>
            <div class="p-3 font-bold text-center text-gray-800">Entertainment activities</div>
            <div class="p-3 font-bold text-center text-gray-800">Transportation</div>
        </div>

        {{-- Tuesdays --}}
        <div class="grid grid-cols-3 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-center text-gray-700 font-medium">Tuesdays</div>
            <div class="p-3 space-y-2 text-gray-700">
                <p class="flex items-center flex-wrap gap-1">
                    • learning to make
                    <strong class="mx-1">5</strong>
                    <span class="inline-block w-28">
                        <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
                <p class="flex items-center flex-wrap gap-1">
                    • having a
                    <strong class="mx-1">6</strong>
                    <span class="inline-block w-24">
                        <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                    in-house concert
                </p>
            </div>
            <div class="p-3 text-gray-700">• mini bus</div>
        </div>

        {{-- Wednesdays --}}
        <div class="grid grid-cols-3 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 text-center text-gray-700 font-medium">Wednesdays</div>
            <div class="p-3 space-y-2 text-gray-700">
                <p>• enjoying mountain view</p>
                <p class="flex items-center flex-wrap gap-1">
                    • exploring a tropical
                    <strong class="mx-1">7</strong>
                    <span class="inline-block w-24">
                        <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
            </div>
            <div class="p-3 space-y-2 text-gray-700">
                <p class="flex items-center flex-wrap gap-1">
                    •
                    <strong>8</strong>
                    <span class="inline-block w-24 ml-1">
                        <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
                <p>• shuttle bus</p>
            </div>
        </div>

        {{-- Thursdays --}}
        <div class="grid grid-cols-3 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-center text-gray-700 font-medium">Thursdays</div>
            <div class="p-3 space-y-2 text-gray-700">
                <p>• having a fancy dinner</p>
                <p class="flex items-center flex-wrap gap-1">
                    • watching a spectacular display of
                    <strong class="mx-1">9</strong>
                    <span class="inline-block w-24">
                        <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
            </div>
            <div class="p-3 text-gray-700">
                <strong>10</strong>
                <span class="inline-block w-24 ml-1">
                    <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>
</div>
