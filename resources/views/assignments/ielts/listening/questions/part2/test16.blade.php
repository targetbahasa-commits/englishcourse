<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-16 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-16</h4>
    <p class="mb-2 text-gray-700">Complete the flow-chart below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <div class="mb-12">
        <h4 class="text-xl font-bold mb-8 text-center text-gray-800">Harvesting and Processing Cocoa Beans</h4>

        <div class="flex flex-col items-center space-y-4 max-w-xl mx-auto text-center text-gray-700">
            {{-- Step 1 --}}
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span>Chocolate beans are</span>
                <strong class="text-blue-600">11</strong>
                <input type="text" name="answers[11]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                <span>and then bags are shipped.</span>
            </div>

            {{-- Arrow --}}
            <div class="text-gray-500 text-2xl font-light">&darr;</div>

            {{-- Step 2 --}}
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span>Bags are then</span>
                <strong class="text-blue-600">12</strong>
                <input type="text" name="answers[12]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                <span>and weighed by machines.</span>
            </div>

            {{-- Arrow --}}
            <div class="text-gray-500 text-2xl font-light">&darr;</div>

            {{-- Step 3 --}}
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span>Next chocolate beans are</span>
                <strong class="text-blue-600">13</strong>
                <input type="text" name="answers[13]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                <span>in a hopper.</span>
            </div>

            {{-- Arrow --}}
            <div class="text-gray-500 text-2xl font-light">&darr;</div>

            {{-- Step 4 --}}
            <div>
                <span>After being roasted at a high temperature</span>
            </div>

            {{-- Arrow --}}
            <div class="text-gray-500 text-2xl font-light">&darr;</div>

            {{-- Step 5 --}}
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span>Boiled chocolate beans are</span>
                <strong class="text-blue-600">14</strong>
                <input type="text" name="answers[14]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                <span>and cracked.</span>
            </div>

            {{-- Arrow --}}
            <div class="text-gray-500 text-2xl font-light">&darr;</div>

            {{-- Step 6 --}}
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span>Roasted beans needs to be</span>
                <strong class="text-blue-600">15</strong>
                <input type="text" name="answers[15]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </div>

            {{-- Arrow --}}
            <div class="text-gray-500 text-2xl font-light">&darr;</div>

            {{-- Step 7 --}}
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span>Roasted beans are</span>
                <strong class="text-blue-600">16</strong>
                <input type="text" name="answers[16]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                <span>in the pocket.</span>
            </div>
        </div>
    </div>


    {{-- Questions 17-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 17-20</h4>
    <p class="mb-4 text-gray-700">What does each type of coffee taste like?</p>
    <p class="mb-6 text-gray-700 italic">Write the correct letter, <strong>A-D</strong>, next to Questions <strong>17-20</strong>.</p>

    <div class="mb-8 pl-4 space-y-3">
        @foreach(['A' => 'intense', 'B' => 'mild', 'C' => 'chocolaty', 'D' => 'smoky'] as $letter => $option)
            <div class="flex gap-4">
                <strong class="font-bold w-4 text-gray-800">{{ $letter }}</strong>
                <span class="text-gray-800">{{ $option }}</span>
            </div>
        @endforeach
    </div>

    <h5 class="font-bold text-gray-800 mb-4">Types of coffee</h5>
    <div class="space-y-4 max-w-sm ml-0">
        @foreach([
            17 => 'First Crack',
            18 => 'Green Beans',
            19 => 'French Roast',
            20 => 'Espresso Smoky'
        ] as $q => $label)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2 hover:bg-white transition-colors">
            <div class="flex items-center gap-3">
                <strong class="text-blue-600">{{ $q }}</strong>
                <span class="text-gray-700">{{ $label }}</span>
            </div>
            <div class="w-24">
                <select name="answers[{{ $q }}]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234B5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:10px_10px] bg-no-repeat bg-[position:right_10px_center]">
                    <option value="" disabled selected>___</option>
                    @foreach(['A','B','C','D'] as $letter)
                        <option value="{{ $letter }}">{{ $letter }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
    </div>
</div>
