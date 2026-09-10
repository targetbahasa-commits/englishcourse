<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>
    <h4 class="text-lg font-bold mb-2">Questions 1-6</h4>
    <p class="mb-1 text-gray-700">Which hotels have the following facilities?</p>
    <p class="mb-4 text-gray-700 italic">Write the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong>, or <strong>D</strong> next to questions <strong>1-6</strong>.</p>

    <div class="bg-white inline-block rounded-xl p-5 mb-6 space-y-2 min-w-[260px]">
        <div class="flex gap-4 text-lg font-medium">
            <span class="font-bold w-6">A</span>
            <span>Royal Hotel</span>
        </div>
        <div class="flex gap-4 text-lg font-medium">
            <span class="font-bold w-6">B</span>
            <span>Star Hotel</span>
        </div>
        <div class="flex gap-4 text-lg font-medium">
            <span class="font-bold w-6">C</span>
            <span>Winchester Hotel</span>
        </div>
        <div class="flex gap-4 text-lg font-medium">
            <span class="font-bold w-6">D</span>
            <span>All Three Hotels</span>
        </div>
    </div>

    {{-- Example --}}
    <p class="mb-4 text-gray-700 italic"><strong>Example: Online booking</strong> &nbsp; <strong>B</strong></p>

    <div class="space-y-4 max-w-lg">
        @foreach([
            [1, 'Sea view'],
            [2, 'Handicap accessibility'],
            [3, 'Multiple meal options'],
            [4, 'Private dining'],
            [5, 'Group discount'],
            [6, "Children's play area"],
        ] as [$num, $label])
        <div class="flex items-center gap-4 text-lg">
            <span class="font-bold text-gray-800 w-6">{{ $num }}</span>
            <span class="flex-1 text-gray-700">{{ $label }}</span>
            <select name="answers[{{ $num }}]"
                class="w-20 h-10 border border-gray-400 focus:border-blue-600 outline-none text-center font-bold text-lg bg-white transition-colors rounded cursor-pointer">
                <option value="">—</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>
        @endforeach
    </div>
</div>

<div class="mb-8">
    <h4 class="text-lg font-bold mb-2">Questions 7-10</h4>
    <p class="mb-1 text-gray-700">Complete the sentences below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <div class="space-y-5 text-lg text-gray-800">
        <p class="flex items-center flex-wrap gap-1">
            The man needs to send his
            <strong class="mx-1">7</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            to the hotel.
        </p>
        <p class="flex items-center flex-wrap gap-1">
            He also needs to make
            <strong class="mx-1">8</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            immediately.
        </p>
        <p class="flex items-center flex-wrap gap-1">
            The hotel must be alerted in advance if guests will need help with
            <strong class="mx-1">9</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>
        <p class="flex items-center flex-wrap gap-1">
            There is no need to prepare
            <strong class="mx-1">10</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            for hotel drivers.
        </p>
    </div>
</div>
