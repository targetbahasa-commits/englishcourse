<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>
    <h4 class="text-lg font-bold mb-2">Questions 1-10</h4>
    <p class="mb-1 text-gray-700">Complete the notes below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for each answer.</p>

    <h4 class="text-2xl font-bold mb-6 text-center uppercase tracking-wide">Job Enquiry</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Example / Answer header --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 font-bold italic text-gray-600">Example</div>
            <div class="p-3 font-bold italic text-gray-600">Answer</div>
        </div>

        {{-- Example row --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 italic text-gray-500 text-sm">•Type of job required:</div>
            <div class="p-3 italic text-gray-500 text-sm">part-time</div>
        </div>

        {{-- Column headers --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 font-semibold text-gray-700">Position Available</div>
            <div class="p-3 font-semibold text-gray-700">Details</div>
        </div>

        {{-- Row 1: Q1, Q2, Q3, Q4 --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 flex items-start">
                <strong>1</strong>
                <span class="inline-block w-32 ml-1 mt-0.5">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
            <div class="p-3 space-y-2 text-gray-700 text-sm">
                <p class="flex items-center flex-wrap gap-1">
                    Duty: to provide
                    <strong class="mx-1">2</strong>
                    <span class="inline-block w-28">
                        <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                    service
                </p>
                <p class="flex items-center flex-wrap gap-1">
                    Working hours:
                    <strong class="mx-1">3</strong>
                    <span class="inline-block w-28">
                        <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
                <p class="flex items-center flex-wrap gap-1">
                    Requirement: receive
                    <strong class="mx-1">4</strong>
                    <span class="inline-block w-28">
                        <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                    without pay
                </p>
                <p>Day off: one day a week (request in advance)</p>
            </div>
        </div>

        {{-- Row 2: Q5, Q6, Q7, Q8 --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 flex items-start">
                <strong>5</strong>
                <span class="inline-block w-32 ml-1 mt-0.5">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
            <div class="p-3 space-y-2 text-gray-700 text-sm">
                <p class="font-medium">Requirements:</p>
                <p class="pl-3">• clean and valid license</p>
                <p class="pl-3">• six-year experience</p>
                <p class="flex items-center flex-wrap gap-1">
                    Working hours:
                    <strong class="mx-1">6</strong>
                    <span class="inline-block w-28">
                        <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
                <p class="font-medium">Duty:</p>
                <p class="pl-3">• to take employers</p>
                <p class="pl-3">• to and from work</p>
                <p class="pl-3 flex items-center flex-wrap gap-1">
                    • to collect the
                    <strong class="mx-1">7</strong>
                    <span class="inline-block w-24">
                        <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
                <p class="pl-3">• to pick up the children</p>
                <p class="flex items-center flex-wrap gap-1">
                    Day off:
                    <strong class="mx-1">8</strong>
                    <span class="inline-block w-28">
                        <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
            </div>
        </div>

        {{-- Row 3: Q9, Q10 --}}
        <div class="grid grid-cols-2 hover:bg-white transition-colors">
            <div class="p-3 flex items-start flex-wrap gap-1 text-sm">
                <span class="text-gray-700">Cashier in a</span>
                <strong>9</strong>
                <span class="inline-block w-28 ml-1 mt-0.5">
                    <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
            <div class="p-3 space-y-2 text-gray-700 text-sm">
                <p>Working hours: 17.30-22.30</p>
                <p class="font-medium">Duty: to sell and dispense tickets</p>
                <p class="pl-3">• to provide refreshments</p>
                <p class="pl-3 flex items-center flex-wrap gap-1">
                    • to take
                    <strong class="mx-1">10</strong>
                    <span class="inline-block w-24">
                        <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors text-sm" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
                <p>Day off: Mondays</p>
            </div>
        </div>
    </div>
</div>
