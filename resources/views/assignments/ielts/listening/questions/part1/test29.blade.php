<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>

    {{-- Questions 1-3 --}}
    <h4 class="text-lg font-bold mb-2">Questions 1-3</h4>
    <p class="mb-6 text-gray-700">Complete the notes below write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <h4 class="text-xl font-bold mb-6 text-center uppercase tracking-wide">Notes of Customer Information</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden mb-10">
        {{-- Header / Example --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50">
            <div class="p-3 font-bold text-gray-800">example</div>
            <div class="p-3 font-bold text-gray-800">answer</div>
        </div>
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 italic text-gray-700">information source:</div>
            <div class="p-3 font-bold italic text-gray-800">found in the brochure</div>
        </div>

        {{-- Q1: Included services --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-gray-700">Included services</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <strong>1</strong>
                <span class="inline-block w-36 mx-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">and accommodation</span>
            </div>
        </div>

        {{-- Q2: Sydney arrival date --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 text-gray-700">Sydney arrival date:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">15th of</span>
                <strong class="mx-1">2</strong>
                <span class="inline-block w-36">
                    <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q3: Accommodation criteria --}}
        <div class="grid grid-cols-2 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Accommodation criteria:</div>
            <div class="p-3">
                <strong>3</strong>
                <span class="inline-block w-40 ml-1">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>

    {{-- Questions 4-6 --}}
    <h4 class="text-lg font-bold mb-2">Questions 4-6</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN THREE WORDS OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-xl font-bold mb-6 text-center uppercase tracking-wide">Booking Information</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden mb-10">
        {{-- Q4: Room type --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-gray-700">Room type:</div>
            <div class="p-3 text-right pr-6">
                <strong>4</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q5: Credit card holder --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 text-gray-700">Credit card holder:</div>
            <div class="p-3 text-right pr-6">
                <strong>5</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q6: Total cost for one night --}}
        <div class="grid grid-cols-2 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-gray-700">Total cost for one night:</div>
            <div class="p-3 text-right pr-6">
                <strong>6</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>

    {{-- Questions 7-10 --}}
    <h4 class="text-lg font-bold mb-2">Questions 7-10</h4>
    <p class="mb-1 text-gray-700">Complete the sentence below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for answer.</p>

    <div class="space-y-6 text-lg text-gray-800">
        <p class="flex items-center flex-wrap gap-1">
            The
            <strong class="mx-1">7</strong>
            <span class="inline-block w-40">
                <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            is within walking distance of the accommodation
        </p>

        <p class="flex items-center flex-wrap gap-1">
            The customer books
            <strong class="mx-1">8</strong>
            <span class="inline-block w-40">
                <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>

        <p class="flex items-center flex-wrap gap-1">
            Aboriginals stone carvings are in the
            <strong class="mx-1">9</strong>
            <span class="inline-block w-40">
                <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>

        <p class="flex items-center flex-wrap gap-1">
            The Dreamtime can be experienced beneath the
            <strong class="mx-1">10</strong>
            <span class="inline-block w-40">
                <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>
    </div>
</div>
