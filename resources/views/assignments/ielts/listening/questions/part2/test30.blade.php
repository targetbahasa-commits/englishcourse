<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-15 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-15</h4>
    <p class="mb-2 text-gray-700">Listen to the directions and match the places in questions <strong>11-15</strong> to the appropriate place among <strong>A-E</strong> on the map.</p>

    {{-- Map Image Placeholder --}}
    <div class="mb-8 mt-6 text-center">
        <div class="inline-block p-4 border-2 border-dashed border-gray-300 bg-gray-50 rounded-lg w-full max-w-2xl">
            <p class="text-gray-500 mb-2 font-medium">Map / Plan Insert</p>
            <p class="text-sm text-gray-400 mb-4">Please upload the map image to: <code>public/images/assignments/ielts/listening/part2/test30-map.png</code></p>
            <img src="{{ asset('images/assignments/ielts/listening/part2/test30-map.png') }}" onerror="this.style.display='none'" class="max-w-full h-auto mx-auto" alt="Campus Map">
        </div>
    </div>

    <div class="space-y-4 max-w-sm mb-12">
        @foreach([
            11 => 'Student Centre',
            12 => 'Health Centre',
            13 => 'Internet Unit1',
            14 => 'Complaint Office',
            15 => 'Cafe'
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

    {{-- Questions 16-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 16-20</h4>
    <p class="mb-2 text-gray-700">Complete the sentences below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <div class="space-y-6 text-gray-700 max-w-2xl">
        <div class="flex items-center gap-2 flex-wrap">
            <span>Students in a room don’t need to share a</span>
            <strong class="text-blue-600">16</strong>
            <input type="text" name="answers[16]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            <span>with ones in other rooms.</span>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <span>Everyone has to write down his name on the</span>
            <strong class="text-blue-600">17</strong>
            <input type="text" name="answers[17]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <span>All the students use a</span>
            <strong class="text-blue-600">18</strong>
            <input type="text" name="answers[18]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            <span>to enter the dorm’s front door.</span>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <span>If you want to wash your clothes, go to the laundry room which is located in the</span>
            <strong class="text-blue-600">19</strong>
            <input type="text" name="answers[19]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <span>The dormitory closes at</span>
            <strong class="text-blue-600">20</strong>
            <input type="text" name="answers[20]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            <span>every night.</span>
        </div>
    </div>
</div>
