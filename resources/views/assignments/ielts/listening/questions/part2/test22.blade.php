<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-16 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-16</h4>
    <p class="mb-4 text-gray-700">What is customers' attitude towards the following services?</p>
    <p class="mb-6 text-gray-700 italic">Write the correct letter, <strong>A, B</strong> or <strong>C</strong>, next to questions <strong>11-16</strong>.</p>

    <div class="mb-6 pl-4 space-y-3">
        @foreach(['A' => 'They are very interested.', 'B' => 'They might be less interested.', 'C' => 'They are not interested.'] as $letter => $option)
            <div class="flex gap-4">
                <strong class="font-bold w-4 text-gray-800">{{ $letter }}</strong>
                <span class="text-gray-800">{{ $option }}</span>
            </div>
        @endforeach
    </div>

    <div class="space-y-4 max-w-sm ml-0 mb-12">
        @foreach([
            11 => 'a free gift',
            12 => 'a driver for an extra fee',
            13 => 'a package service',
            14 => 'updated car models',
            15 => 'a discount',
            16 => 'a new branch company'
        ] as $q => $label)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2 hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3">
                <strong class="text-blue-600">{{ $q }}</strong>
                <span class="text-gray-700">{{ $label }}</span>
            </div>
            <div class="w-24">
                <select name="answers[{{ $q }}]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234B5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:10px_10px] bg-no-repeat bg-[position:right_10px_center]">
                    <option value="" disabled selected>___</option>
                    @foreach(['A','B','C'] as $letter)
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

    <div class="space-y-8 mb-12">
        {{-- Q17 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">17</strong>&nbsp; What is the problem of the public transport?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[17]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>Traffic jams</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[17]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>Pedestrian safety</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[17]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>Low efficiency</span>
                </label>
            </div>
        </div>

        {{-- Q18 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">18</strong>&nbsp; According to the speaker, what is true about the transportation?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[18]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>Buses are easy to find.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[18]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>Taxis are punctual.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[18]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>Airplanes are unaffordable.</span>
                </label>
            </div>
        </div>

        {{-- Q19 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">19</strong>&nbsp; According to the speaker, what is true about the bus?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>Passengers occasionally spend more than half an hour waiting for it.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>It is sometimes overcrowded.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>It is often dirty.</span>
                </label>
            </div>
        </div>

        {{-- Q20 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">20</strong>&nbsp; What is the existing situation about the price of bus tickets?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>It is fluctuating severely.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>It is declining.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>It needs to be increased.</span>
                </label>
            </div>
        </div>
    </div>
</div>
