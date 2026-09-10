<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>

    {{-- Questions 1-3 --}}
    <h4 class="text-lg font-bold mb-2">Questions 1-3</h4>
    <p class="mb-1 text-gray-700">Complete the notes below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-xl font-bold mb-4">Complaint to the airport</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden mb-10">
        {{-- Header --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 font-bold italic text-gray-600">Example</div>
            <div class="p-3 font-bold italic text-gray-600">Answer</div>
        </div>

        {{-- Example: Name --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 italic text-gray-500 text-sm">Name:</div>
            <div class="p-3 italic text-gray-500 text-sm">Jack Dawson</div>
        </div>

        {{-- Q1: Address --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Address:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <strong>1</strong>
                <span class="inline-block w-28 mx-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">Road, Exeter</span>
            </div>
        </div>

        {{-- Q2: Postcode --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Postcode:</div>
            <div class="p-3">
                <strong>2</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q3: Telephone --}}
        <div class="grid grid-cols-2 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Telephone:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">work:</span>
                <strong>3</strong>
                <span class="inline-block w-28 mx-1">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">home: 798662</span>
            </div>
        </div>
    </div>

    {{-- Questions 4-6 --}}
    <h4 class="text-lg font-bold mb-2">Questions 4-6</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-10">
        {{-- Q4 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong>4</strong>&nbsp; What aspect of the flight does the man complain about?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                    <input type="radio" name="answers[4]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>punctuality</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                    <input type="radio" name="answers[4]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>legroom</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                    <input type="radio" name="answers[4]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>temperature</span>
                </label>
            </div>
        </div>

        {{-- Q5 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong>5</strong>&nbsp; What does the man think about the food served during the flight?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                    <input type="radio" name="answers[5]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>It is not enough to eat.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                    <input type="radio" name="answers[5]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>It is expensive.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                    <input type="radio" name="answers[5]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>It has a bad taste.</span>
                </label>
            </div>
        </div>

        {{-- Q6 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong>6</strong>&nbsp; What does the man think of the service of the staff?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                    <input type="radio" name="answers[6]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>satisfied</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                    <input type="radio" name="answers[6]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>long wait</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                    <input type="radio" name="answers[6]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>bad attitude</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Questions 7-10 --}}
    <h4 class="text-lg font-bold mb-2">Questions 7-10</h4>
    <p class="mb-1 text-gray-700">Complete the sentences below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for each answer.</p>

    <div class="space-y-5 text-lg text-gray-800">
        <p class="flex items-center flex-wrap gap-1">
            The man felt satisfied with
            <strong class="mx-1">7</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            because it was quick.
        </p>
        <p class="flex items-center flex-wrap gap-1">
            During the flight,
            <strong class="mx-1">8</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            facilities helped him distract from other poor quality of the service.
        </p>
        <p class="flex items-center flex-wrap gap-1">
            As a gift, a 20% discount on the
            <strong class="mx-1">9</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            fees will be offered.
        </p>
        <p class="flex items-center flex-wrap gap-1">
            The flight company also offers the man a
            <strong class="mx-1">10</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            worth £20.
        </p>
    </div>
</div>
