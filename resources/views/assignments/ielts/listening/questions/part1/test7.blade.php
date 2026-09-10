<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>
    <h4 class="text-lg font-bold mb-2">Questions 1-10</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-2xl font-bold mb-6 text-center">Tourism Survey</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Header --}}
        <div class="grid grid-cols-2 bg-white border-b border-gray-200">
            <div class="p-3 font-bold italic">Example</div>
            <div class="p-3 font-bold italic">Answer</div>
        </div>

        {{-- Name (example) --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 text-gray-600 italic">Name:</div>
            <div class="p-3 text-gray-600 italic">Robert Goddard</div>
        </div>

        {{-- Destination --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Destination:</div>
            <div class="p-3 text-gray-700">Melbourne</div>
        </div>

        {{-- Q1: First time visited --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">First time visited Melbourne?</div>
            <div class="p-3">
                <strong>1</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q2: Best thing about city --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Best thing about the city:</div>
            <div class="p-3">
                <strong>2</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q3: Favourite attraction --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Favourite attraction:</div>
            <div class="p-3">
                <strong>3</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Best thing about (header row) --}}
        <div class="border-b border-gray-200 bg-white px-3 py-2">
            <p class="font-bold text-gray-800">Best thing about</p>
        </div>

        {{-- Q4: dining options --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">the destination's dining options:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <strong>4</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="ml-1 text-gray-700">of food</span>
            </div>
        </div>

        {{-- Method of transport (header row) --}}
        <div class="border-b border-gray-200 bg-white px-3 py-2">
            <p class="font-bold text-gray-800">Method of transport</p>
        </div>

        {{-- Q5: to destination --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">to destination:</div>
            <div class="p-3 flex items-center gap-1 flex-wrap">
                <span class="text-gray-700">by</span>
                <strong>5</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q6: Age group --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Age group:</div>
            <div class="p-3">
                <strong>6</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q7: Income level --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Income level:</div>
            <div class="p-3">
                <strong>7</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q8, Q9: Purpose of visit --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Purpose of visit:</div>
            <div class="p-3 space-y-2">
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">•</span>
                    <span class="text-gray-700">on business</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">•</span>
                    <strong>8</strong>
                    <span class="inline-block w-32">
                        <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                </div>
            </div>
        </div>

        {{-- Q9, Occupation --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Occupation:</div>
            <div class="p-3 space-y-2">
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">•</span>
                    <strong>9</strong>
                    <span class="inline-block w-32">
                        <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">•</span>
                    <span class="text-gray-700">writer for a travel magazine</span>
                </div>
            </div>
        </div>

        {{-- Q10: Opinion about accommodation --}}
        <div class="grid grid-cols-2 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Opinion about accommodation:</div>
            <div class="p-3">
                <strong>10</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>
</div>
