<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>
    <h4 class="text-lg font-bold mb-2">Questions 1-10</h4>
    <p class="mb-1 text-gray-700">Complete the notes below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-2xl font-bold mb-6 text-center uppercase tracking-wide">House Rental</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Header --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 font-bold italic text-gray-600">Example</div>
            <div class="p-3 font-bold italic text-gray-600">Answer</div>
        </div>

        {{-- Example: Name --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50">
            <div class="p-3 font-bold italic text-gray-500 text-sm">• Name:</div>
            <div class="p-3 font-bold italic text-gray-500 text-sm">Mary Collins</div>
        </div>

        {{-- Q1: Factility available --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-gray-700">• Factility available:</div>
            <div class="p-3">
                <strong>1</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q2: General layout --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 text-gray-700">• General layout:</div>
            <div class="p-3 space-y-2">
                <p class="text-gray-700 text-sm">upstairs: living room bedrooms downstairs:</p>
                <p class="flex items-center gap-1">
                    <strong>2</strong>
                    <span class="inline-block w-36 ml-1">
                        <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
            </div>
        </div>

        {{-- Q3: Car park --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-gray-700">• Car park:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">availability of a large</span>
                <strong class="mx-1">3</strong>
                <span class="inline-block w-28">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q4: Shopping --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 text-gray-700">• Shopping:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">at the</span>
                <strong class="mx-1">4</strong>
                <span class="inline-block w-32">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q5: Place for children playing --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-gray-700">• Place for children playing:</div>
            <div class="p-3">
                <strong>5</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q6: Education resources --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 text-gray-700">• Education resources:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">a</span>
                <strong class="mx-1">6</strong>
                <span class="inline-block w-28">
                    <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">in the community</span>
            </div>
        </div>

        {{-- Q7: Rent --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-gray-700">• Rent:</div>
            <div class="p-3 space-y-2 text-gray-700">
                <p>$980 a month</p>
                <p class="flex items-center flex-wrap gap-1">
                    (including the maintenance lees of the
                    <strong class="mx-1">7</strong>
                    <span class="inline-block w-28">
                        <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>)
                </p>
            </div>
        </div>

        {{-- Q8: Date of house available --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 text-gray-700">• Date of house available:</div>
            <div class="p-3">
                <strong>8</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q9: Viewing arrangement --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-gray-700">• Viewing arrangement (time):</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">meet at</span>
                <strong class="mx-1">9</strong>
                <span class="inline-block w-32">
                    <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Postcode (given) --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50">
            <div class="p-3 text-gray-700">• Postcode:</div>
            <div class="p-3 text-gray-700">GA58ER</div>
        </div>

        {{-- Q10: Address --}}
        <div class="grid grid-cols-2 hover:bg-gray-50 transition-colors">
            <div class="p-3 text-gray-700">• Address:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">8</span>
                <strong class="mx-1">10</strong>
                <span class="inline-block w-32">
                    <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>
</div>
