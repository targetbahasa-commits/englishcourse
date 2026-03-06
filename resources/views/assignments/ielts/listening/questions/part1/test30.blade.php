<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>

    {{-- Questions 1-4 --}}
    <h4 class="text-lg font-bold mb-2">Questions 1-4</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-2xl font-bold mb-6 text-center text-gray-800 tracking-wide">Product Incident Report</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden mb-10">
        {{-- Header / Example --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50">
            <div class="p-3 font-bold italic text-gray-700">Example</div>
            <div class="p-3 font-bold italic text-gray-700">Answer</div>
        </div>
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 italic text-gray-600">Product:</div>
            <div class="p-3 italic text-gray-600">rice cooker</div>
        </div>

        {{-- Q1: Model Number --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Model Number:</div>
            <div class="p-3 text-right pr-6">
                <strong>1</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q2: Price --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold text-gray-800">Price of the Product:</div>
            <div class="p-3 text-right pr-6 flex items-center justify-end">
                <span class="text-gray-700 mr-1">£</span>
                <strong>2</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q3: Branch Name --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Name of the Branch:</div>
            <div class="p-3 text-right pr-6">
                <strong>3</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q4: Problem --}}
        <div class="grid grid-cols-2 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Problem:</div>
            <div class="p-3 text-right pr-6">
                <strong>4</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>

    {{-- Questions 5-10 --}}
    <h4 class="text-lg font-bold mb-2">Questions 5-10</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN THREE WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-xl font-bold mb-6 text-center text-gray-800 tracking-wide uppercase">Customer's Information Details</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Given Name --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Name:</div>
            <div class="p-3 text-right pr-6 text-gray-700">
                Herbert Hewitt
            </div>
        </div>

        {{-- Q5: Address --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold text-gray-800">Address:</div>
            <div class="p-3 text-right pr-6">
                <strong>5</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q6: Postcode --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Postcode:</div>
            <div class="p-3 text-right pr-6">
                <strong>6</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q7: Method of payment --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold text-gray-800">Method of payment:</div>
            <div class="p-3 text-right pr-6">
                <strong>7</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q8: Card's Expiry Date --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Card's Expiry Date:</div>
            <div class="p-3 text-right pr-6">
                <strong>8</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q9: Method of Compensation --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold text-gray-800">Method of Compensation:</div>
            <div class="p-3 text-right pr-6">
                <strong>9</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q10: Shopping Frequency --}}
        <div class="grid grid-cols-2 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold text-gray-800">Shopping Frequency:</div>
            <div class="p-3 text-right pr-6">
                <strong>10</strong>
                <span class="inline-block w-48 ml-1">
                    <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>
</div>
