<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-16 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11 &ndash; 16</h4>
    <p class="mb-1 text-gray-700">Complete the table.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for each answer.</p>

    <p class="mb-4 text-gray-800">Advantages of Stanfield Childcare Centre</p>

    <div class="border border-gray-200 rounded-lg overflow-hidden mb-12">
        {{-- Table Header --}}
        <div class="grid grid-cols-2 bg-gray-50 border-b border-gray-200">
            <div class="p-3 font-bold text-center text-gray-800">Detail</div>
            <div class="p-3 font-bold text-center text-gray-800">Another Detail</div>
        </div>

        {{-- Row 1 --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors">
            <div class="p-4 flex gap-4 border-r border-gray-200">
                <strong class="text-gray-800 mt-1">1</strong>
                <div class="flex items-center gap-1 flex-wrap">
                    <span class="text-gray-700">Walls are</span>
                    <strong class="text-blue-600">11</strong>
                    <span class="inline-block w-32 md:w-40">
                        <input type="text" name="answers[11]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                </div>
            </div>
            <div class="p-4 flex items-center justify-center gap-1 flex-wrap text-center">
                <span class="text-gray-700">includes the</span>
                <strong class="text-blue-600">12</strong>
                <span class="inline-block w-32 md:w-40">
                    <input type="text" name="answers[12]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Row 2 --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-4 flex gap-4 border-r border-gray-200">
                <strong class="text-gray-800 mt-1">2</strong>
                <div class="flex flex-col">
                    <span class="text-gray-700 mb-1">Teachers are able to teach a</span>
                    <div class="flex items-center gap-1">
                        <strong class="text-blue-600">13</strong>
                        <span class="inline-block w-32 md:w-40 mx-1">
                            <input type="text" name="answers[13]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                        </span>
                    </div>
                </div>
            </div>
            <div class="p-4 flex flex-col items-center justify-center text-center">
                <span class="text-gray-700 mb-1">There are many special</span>
                <div class="flex items-center gap-1">
                    <strong class="text-blue-600">14</strong>
                    <span class="inline-block w-32 md:w-40 mx-1">
                        <input type="text" name="answers[14]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                </div>
            </div>
        </div>

        {{-- Row 3 --}}
        <div class="grid grid-cols-2 bg-white hover:bg-gray-50 transition-colors">
            <div class="p-4 flex gap-4 border-r border-gray-200">
                <strong class="text-gray-800 mt-1">3</strong>
                <div class="flex items-center gap-1 flex-wrap">
                    <span class="text-gray-700">They</span>
                    <strong class="text-blue-600">15</strong>
                    <span class="inline-block w-32 md:w-40 mx-1">
                        <input type="text" name="answers[15]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                    <span class="text-gray-700">Surfaces daily.</span>
                </div>
            </div>
            <div class="p-4 flex flex-col items-center justify-center text-center">
                <span class="text-gray-700 mb-1">procedures to limit the spread of</span>
                <div class="flex items-center gap-1">
                    <strong class="text-[#2b3954]">16</strong>
                    <span class="inline-block w-32 md:w-40 mx-1">
                        <input type="text" name="answers[16]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Questions 17-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 17-20</h4>
    <p class="mb-4 text-gray-700">Choose the correct letter, <strong>A, B</strong>, or <strong>C</strong>.</p>
    
    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg inline-block min-w-[300px]">
        <p class="font-bold text-gray-800 mb-3 text-sm">NB <span class="italic font-normal">You may use a letter more than once.</span></p>
        <div class="space-y-2 text-gray-800 font-medium ml-4">
            <p><strong>A</strong> &nbsp; Andrea</p>
            <p><strong>B</strong> &nbsp; Bella</p>
            <p><strong>C</strong> &nbsp; Cathy</p>
        </div>
    </div>

    <h5 class="font-bold text-gray-800 mb-4">Which childcare worker:</h5>

    <div class="space-y-4 max-w-sm ml-0">
        @foreach([
            17 => 'has her own children?',
            18 => 'often sleeps at the center?',
            19 => 'is good with shy children?',
            20 => 'is a good cook?'
        ] as $q => $label)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2">
            <div class="flex items-center gap-3">
                <strong class="text-gray-800">{{ $q }}</strong>
                <span class="text-gray-700">{{ $label }}</span>
            </div>
            <div class="w-24">
                <select name="answers[{{ $q }}]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234B5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:10px_10px] bg-no-repeat bg-[position:right_10px_center]">
                    <option value="" disabled selected>___</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>
            </div>
        </div>
        @endforeach
    </div>
</div>
