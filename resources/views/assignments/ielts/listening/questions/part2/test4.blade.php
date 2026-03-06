<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-16 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11 &ndash; 16</h4>
    <div class="flex items-center gap-2 mb-6">
        <p class="text-gray-700">Label the floor plan.</p>
        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-bold text-white bg-blue-600 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
            </svg>
            English exercise platform
        </span>
    </div>

    <p class="mb-6 text-gray-700 italic">Write the correct letter, <strong>A-F</strong>, for each answer.</p>

    {{-- Map Image Placeholder --}}
    <div class="mb-8 text-center">
        <div class="inline-block p-4 border-2 border-dashed border-gray-300 bg-gray-50 rounded-lg w-full max-w-2xl bg-white relative">
            <p class="text-gray-500 mb-2 font-medium">The Independent Learning Centre Map Insert</p>
            <p class="text-sm text-gray-400 mb-4">Please upload the map image to: <code>public/images/assignments/ielts/listening/part2/test4-map.png</code></p>
            <img src="{{ asset('images/assignments/ielts/listening/part2/test4-map.png') }}" onerror="this.style.display='none'" class="max-w-full h-auto mx-auto" alt="The Independent Learning Centre Map">
        </div>
    </div>

    <div class="space-y-4 max-w-sm ml-0 mb-12">
        @foreach([
            11 => 'Quiet reading',
            12 => 'Computers',
            13 => 'Newspapers & magazines',
            14 => 'Reference books',
            15 => 'Audio section',
            16 => 'Main library'
        ] as $q => $label)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2 hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3">
                <strong class="text-blue-600">{{ $q }}</strong>
                <span class="text-gray-700">{{ $label }}</span>
            </div>
            <div class="w-24">
                <select name="answers[{{ $q }}]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234B5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:10px_10px] bg-no-repeat bg-[position:right_10px_center]">
                    <option value="" disabled selected>___</option>
                    @foreach(['A','B','C','D','E','F'] as $letter)
                        <option value="{{ $letter }}">{{ $letter }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Questions 17-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 17 &ndash; 20</h4>
    <div class="flex items-center gap-2 mb-6">
        <p class="text-gray-700">Complete the timetable.</p>
        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-bold text-white bg-blue-600 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                <path fill-rule="evenodd" d="M11.3 1.046A12.014 12.014 0 0010 1a12.015 12.015 0 00-1.3.046c-1.46.16-2.5 1.53-2.5 3.004V4h7v-.95c0-1.474-1.04-2.844-2.5-3.004zM5.5 5.5v2.859c0 2.227 1.258 4.218 3.23 5.099l1.27.564 1.27-.564c1.972-.881 3.23-2.872 3.23-5.099V5.5h-9zM10 16.5c-2.308 0-4.5-1.185-5.5-3.064v3.064c0 1.105.748 2 1.83 2h7.34c1.082 0 1.83-.895 1.83-2v-3.064A6.29 6.29 0 0110 16.5z" clip-rule="evenodd" />
            </svg>
            General training materials
        </span>
    </div>

    <p class="mb-6 text-gray-700 italic">Write the correct letter, <strong>A-J</strong>, for each answer.</p>

    {{-- Timetable Image Placeholder --}}
    <div class="mb-8 text-center">
        <div class="inline-block p-4 border-2 border-dashed border-gray-300 bg-gray-50 rounded-lg w-full max-w-2xl bg-white relative">
            <p class="text-gray-500 mb-2 font-medium">ILC Special Sessions Timetable Insert</p>
            <p class="text-sm text-gray-400 mb-4">Please upload the timetable image to: <code>public/images/assignments/ielts/listening/part2/test4-timetable.png</code></p>
            <img src="{{ asset('images/assignments/ielts/listening/part2/test4-timetable.png') }}" onerror="this.style.display='none'" class="max-w-full h-auto mx-auto" alt="ILC Special Sessions Timetable">
        </div>
    </div>

    <div class="space-y-4 max-w-sm ml-0">
        @foreach([
            17 => 'Teacher-led discussion',
            18 => 'Writing skills',
            19 => 'On-call teacher',
            20 => 'Language exchange'
        ] as $q => $label)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2 hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3">
                <strong class="text-blue-600">{{ $q }}</strong>
                <span class="text-gray-700">{{ $label }}</span>
            </div>
            <div class="w-24">
                <select name="answers[{{ $q }}]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234B5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:10px_10px] bg-no-repeat bg-[position:right_10px_center]">
                    <option value="" disabled selected>___</option>
                    @foreach(['A','B','C','D','E','F','G','H','I','J'] as $letter)
                        <option value="{{ $letter }}">{{ $letter }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
    </div>
</div>
