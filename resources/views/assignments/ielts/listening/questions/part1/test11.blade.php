<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>
    <h4 class="text-lg font-bold mb-2">Questions 1-10</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-2xl font-bold mb-6 text-center">Home Insurance Quotation Form</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Example / Answer header --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 font-bold italic text-gray-600">Example</div>
            <div class="p-3 font-bold italic text-gray-600">Answer</div>
        </div>

        {{-- Example row: Name --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 font-bold text-gray-600 italic">Name:</div>
            <div class="p-3 font-bold text-gray-600 italic">Janet Evans</div>
        </div>

        {{-- Q1: Address --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Address:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">49</span>
                <strong>1</strong>
                <span class="inline-block w-32 mx-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">Court</span>
            </div>
        </div>

        {{-- Q2: Email --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Email:</div>
            <div class="p-3">
                <strong>2</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Telephone (given) --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Telephone number:</div>
            <div class="p-3 text-gray-700">(020) 4251-9443</div>
        </div>

        {{-- Q3: Best time to contact --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Best time to contact:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <strong>3</strong>
                <span class="inline-block w-28 mx-1">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">pm</span>
            </div>
        </div>

        {{-- Property Information sub-header --}}
        <div class="border-b border-gray-200 bg-white px-3 py-2">
            <p class="font-semibold text-gray-800">Property Information</p>
        </div>

        {{-- Q4: Property size --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Property size:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <strong>4</strong>
                <span class="inline-block w-28 mx-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">m2</span>
            </div>
        </div>

        {{-- Q5: Material(s) --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Material(s):</div>
            <div class="p-3">
                <strong>5</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q6: Security measures --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Security measures (if any):</div>
            <div class="p-3">
                <strong>6</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Coverage sub-header --}}
        <div class="border-b border-gray-200 bg-white px-3 py-2">
            <p class="font-semibold text-gray-800">Coverage</p>
        </div>

        {{-- Q7: Items to cover --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Items to cover:</div>
            <div class="p-3 space-y-2 text-gray-700">
                <p>• building</p>
                <p>• contents</p>
                <p class="flex items-center gap-1">
                    • <strong>7</strong>
                    <span class="inline-block w-32 ml-1">
                        <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                    </span>
                </p>
            </div>
        </div>

        {{-- Q8: Quotation --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Quotation:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">£</span>
                <strong>8</strong>
                <span class="inline-block w-32 ml-1">
                    <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q9: Coverage start date --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Coverage start date:</div>
            <div class="p-3">
                <strong>9</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q10: Reference number --}}
        <div class="grid grid-cols-2 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Reference number:</div>
            <div class="p-3">
                <strong>10</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>
</div>
