<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>

    {{-- Questions 1-6 --}}
    <h4 class="text-lg font-bold mb-2">Questions 1-6</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-xl font-bold mb-6 text-center">Moving Company Service Report</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden mb-10">
        {{-- Example row --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50">
            <div class="p-3 italic text-gray-600">Example</div>
            <div class="p-3 italic text-gray-600">Answer</div>
        </div>
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 italic text-gray-700">Full Name:</div>
            <div class="p-3 font-bold italic text-gray-800">Jane Bond</div>
        </div>

        {{-- Q1: Phone Number --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold text-gray-800">Phone Number:</div>
            <div class="p-3">
                <strong>1</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q2, Q3: USA Address --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">USA Address:</div>
            <div class="p-3 space-y-3">
                <p class="flex items-center flex-wrap gap-1">
                    <span class="text-gray-700">509</span>
                    <strong class="mx-1">2</strong>
                    <span class="inline-block w-36">
                        <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
                <p class="flex items-center flex-wrap gap-1">
                    <span class="text-gray-700">1137</span>
                    <strong class="mx-1">3</strong>
                    <span class="inline-block w-36">
                        <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                    <span class="text-gray-700">, Seattle</span>
                </p>
            </div>
        </div>

        {{-- Q4: Packing Day --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold text-gray-800">Packing Day:</div>
            <div class="p-3">
                <strong>4</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Date --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Date:</div>
            <div class="p-3 text-gray-700">11th March</div>
        </div>

        {{-- Clean-up by --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold text-gray-800">Clean-up by:</div>
            <div class="p-3 text-gray-700">5:00 p.m.</div>
        </div>

        {{-- Q5: Day --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Day:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <strong>5</strong>
                <span class="inline-block w-36 mx-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">14th</span>
            </div>
        </div>

        {{-- About the Price --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold text-gray-800">About the Price:</div>
            <div class="p-3 text-gray-700">Rather expensive</div>
        </div>

        {{-- Q6: Storage Time --}}
        <div class="grid grid-cols-2 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Storage Time:</div>
            <div class="p-3">
                <strong>6</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>

    {{-- Questions 7-10 --}}
    <h4 class="text-lg font-bold mb-2">Questions 7-10</h4>
    <p class="mb-1 text-gray-700">Where does the speaker decide to put items in?</p>
    <p class="mb-4 text-gray-700 italic">Write the correct letter, <strong>A, B,</strong> or <strong>C,</strong> next to questions <strong>7-10</strong>.</p>

    {{-- Options box --}}
    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg inline-block min-w-[300px]">
        <div class="space-y-2 text-gray-800 font-medium">
            <p><strong>A</strong> &nbsp; in emergency pack</p>
            <p><strong>B</strong> &nbsp; in personal package</p>
            <p><strong>C</strong> &nbsp; in storage with the furniture</p>
        </div>
    </div>

    <h5 class="font-bold text-gray-800 mb-4">Items</h5>

    <div class="space-y-4 max-w-sm">
        @foreach([
            7 => 'cutlery and dishes',
            8 => 'kettle',
            9 => 'alarm clock',
            10 => 'CD player'
        ] as $q => $item)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2">
            <div class="flex items-center gap-3">
                <strong class="text-gray-800">{{ $q }}</strong>
                <span class="text-gray-700">{{ $item }}</span>
            </div>
            <div class="w-32">
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
