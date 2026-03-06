<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-15 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-15</h4>
    <p class="mb-2 text-gray-700">Complete the sentences below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD AND/OR A NUMBER</strong> for each answer.</p>

    <h5 class="text-center font-bold text-gray-800 mb-6 text-xl">Mount Rushmore</h5>

    <div class="space-y-6 mb-12 text-gray-700 max-w-2xl">
        <div class="flex items-start gap-1 flex-wrap">
            <span>The government finally paid $</span>
            <strong class="text-blue-600">11</strong>
            <span class="inline-block mx-1">
                <input type="text" name="answers[11]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </span>
            <span>to complete the heads of four United States Presidents.</span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span>The purpose of the construction of the president's heads is to develop</span>
            <strong class="text-blue-600">12</strong>
            <span class="inline-block mx-1">
                <input type="text" name="answers[12]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span>The carvings face</span>
            <strong class="text-blue-600">13</strong>
            <span class="inline-block mx-1">
                <input type="text" name="answers[13]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </span>
            <span>to experience maximum exposure to sunlight.</span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span>In 1885, the mountain was renamed after a</span>
            <strong class="text-blue-600">14</strong>
            <span class="inline-block mx-1">
                <input type="text" name="answers[14]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span>It took</span>
            <strong class="text-blue-600">15</strong>
            <span class="inline-block mx-1">
                <input type="text" name="answers[15]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </span>
            <span>years to finish the project.</span>
        </div>
    </div>


    {{-- Questions 16-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 16-20</h4>
    <p class="mb-2 text-gray-700">Label the map below.</p>
    <p class="mb-6 text-gray-700 italic">Write the correct letter, <strong>A-E</strong>, next to questions <strong>16-20</strong>.</p>

    {{-- Map Image Placeholder --}}
    <div class="mb-8 text-center">
        <div class="inline-block p-4 border-2 border-dashed border-gray-300 bg-gray-50 rounded-lg w-full max-w-2xl relative">
            <p class="text-gray-500 mb-2 font-medium">Map / Plan Insert</p>
            <p class="text-sm text-gray-400 mb-4">Please upload the map image to: <code>public/images/assignments/ielts/listening/part2/test20-map.png</code></p>
            <img src="{{ asset('images/assignments/ielts/listening/part2/test20-map.png') }}" onerror="this.style.display='none'" class="max-w-full h-auto mx-auto" alt="Mount Rushmore Map">
        </div>
    </div>

    <div class="space-y-4 max-w-sm ml-0">
        @foreach([
            16 => 'information centre',
            17 => 'refreshment centre',
            18 => 'gift shop',
            19 => 'workshop',
            20 => 'visitor centre'
        ] as $q => $label)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2 hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3">
                <strong class="text-blue-600">{{ $q }}</strong>
                <span class="text-gray-700">{{ $label }}</span>
            </div>
            <div class="w-24">
                <select name="answers[{{ $q }}]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234B5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:10px_10px] bg-no-repeat bg-[position:right_10px_center]">
                    <option value="" disabled selected>___</option>
                    @foreach(['A','B','C','D','E'] as $letter)
                        <option value="{{ $letter }}">{{ $letter }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
    </div>
</div>
