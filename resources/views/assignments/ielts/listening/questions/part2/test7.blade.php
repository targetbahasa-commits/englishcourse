<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-15 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-15</h4>
    <p class="mb-2 text-gray-700">Label the map below.</p>
    <p class="mb-6 text-gray-700 italic">Write the correct letter, <strong>A-E</strong>, next to questions <strong>11-15</strong>.</p>

    {{-- Map Image Placeholder --}}
    <div class="mb-8 text-center">
        <div class="p-3 border border-gray-200 bg-white rounded-xl shadow-sm max-w-2xl mx-auto"><img src="{{ asset('images/assignments/ielts/listening/part2/test7-map.png') }}" class="w-full h-auto rounded-lg" alt="Map"></div>
    </div>

    <div class="space-y-4 max-w-sm ml-0 mb-12">
        @foreach([
            11 => 'Science Museum',
            12 => 'National History Museum',
            13 => 'Car Park',
            14 => 'Shopping Mall',
            15 => 'Primary School'
        ] as $q => $label)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2 hover:bg-white transition-colors">
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
    <p class="mb-4 text-gray-700">What is the improvement of each main point of interest in the area?</p>
    <p class="mb-6 text-gray-700 italic">Choose <strong>FIVE</strong> answers from the box and write the correct letter, <strong>A-G</strong>, next to questions <strong>16-20</strong>.</p>

    <div class="mb-6 bg-white p-6 rounded-2xl inline-block min-w-[300px]">
        <div class="space-y-3">
            @foreach([
                'A' => 'New entrance',
                'B' => 'Free lunch provided',
                'C' => 'Free information provided',
                'D' => 'Increase in size',
                'E' => 'Additional signs',
                'F' => 'New exhibitions',
                'G' => 'New structure'
            ] as $letter => $option)
                <div class="flex gap-4">
                    <strong class="font-bold w-4 text-gray-800">{{ $letter }}</strong>
                    <span class="text-gray-800">{{ $option }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="space-y-4 max-w-sm ml-0">
        @foreach([
            16 => 'CarPark',
            17 => 'Primary School',
            18 => 'Science Museum',
            19 => 'National History Museum',
            20 => 'Shopping Mall'
        ] as $q => $label)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2 hover:bg-white transition-colors">
            <div class="flex items-center gap-3">
                <strong class="text-blue-600">{{ $q }}</strong>
                <span class="text-gray-700">{{ $label }}</span>
            </div>
            <div class="w-24">
                <select name="answers[{{ $q }}]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234B5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:10px_10px] bg-no-repeat bg-[position:right_10px_center]">
                    <option value="" disabled selected>___</option>
                    @foreach(['A','B','C','D','E','F','G'] as $letter)
                        <option value="{{ $letter }}">{{ $letter }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
    </div>
</div>
