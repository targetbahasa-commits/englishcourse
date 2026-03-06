<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-12 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-12</h4>
    <p class="mb-2 text-gray-700">Complete the sentences below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <div class="space-y-6 mb-12">
        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">The program is made for travelers to make</span>
            <strong class="text-blue-600">11</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[11]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">The program operates in cooperation with the</span>
            <strong class="text-blue-600">12</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[12]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>
    </div>

    {{-- Questions 13-16 --}}
    <h4 class="text-lg font-bold mb-2">Questions 13-16</h4>
    <p class="mb-4 text-gray-700">What is the internship stipulation of each country below?</p>
    <p class="mb-6 text-gray-700 italic">Choose <strong>FOUR</strong> answers from the box and write the correct letter, <strong>A-F</strong>, next to questions <strong>13-16</strong>.</p>

    <div class="mb-6 bg-gray-50 p-6 rounded-2xl inline-block min-w-[300px]">
        <h5 class="font-bold text-gray-800 mb-4">Internship Stipulation</h5>
        <div class="space-y-3">
            @foreach([
                'A' => 'home stay',
                'B' => 'no summer program',
                'C' => 'minimum time requirement',
                'D' => 'formal report required',
                'E' => 'specific time period',
                'F' => 'agriculture'
            ] as $letter => $option)
                <div class="flex gap-4">
                    <strong class="font-bold w-4 text-gray-800">{{ $letter }}</strong>
                    <span class="text-gray-800">{{ $option }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <h5 class="font-bold text-gray-800 mb-4">Country</h5>
    <div class="space-y-4 max-w-sm ml-0 mb-12">
        @foreach([
            13 => 'USA',
            14 => 'Australia',
            15 => 'South Africa',
            16 => 'India'
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
    <h4 class="text-lg font-bold mb-2">Questions 17-20</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A, B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12 flex-1">
        {{-- Q17 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">17</strong>&nbsp; What should you do to get the Global Traveling Certificate?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[17]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>record activity everyday</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[17]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>formal report</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[17]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>talk the experience with the assessor</span>
                </label>
            </div>
        </div>

        {{-- Q18 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">18</strong>&nbsp; You can apply for the certificate</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[18]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>only after you come back.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[18]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>while on the trip.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[18]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>before you leave.</span>
                </label>
            </div>
        </div>

        {{-- Q19 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">19</strong>&nbsp; When should you pay the final installment?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>the day before you leave</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>one month before you return</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>before you get your plane ticket</span>
                </label>
            </div>
        </div>

        {{-- Q20 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">20</strong>&nbsp; Before your application, you need</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>to take a health check.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>to attend the workshop.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>to meet people with whom you will work.</span>
                </label>
            </div>
        </div>
    </div>
</div>
