<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>
    <h4 class="text-lg font-bold mb-2">Questions 1-10</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-2xl font-bold mb-6 text-center">Phone interview</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Name (example top) --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 text-gray-500 italic">Name:</div>
            <div class="p-3 text-gray-500 italic">John Murphy</div>
        </div>

        {{-- Example / Answer header --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 font-bold italic">Example</div>
            <div class="p-3 font-bold italic">Answer</div>
        </div>

        {{-- Example row --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 text-gray-600 italic">Position applying for:</div>
            <div class="p-3 text-gray-600 italic">lifeguard</div>
        </div>

        {{-- Q1: Street Address --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Street Address:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">45</span>
                <strong>1</strong>
                <span class="inline-block w-32 mx-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">Court</span>
            </div>
        </div>

        {{-- Q2: Contact phone number --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Contact phone number:</div>
            <div class="p-3">
                <strong>2</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q3: Current part-time job --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Current part-time job:</div>
            <div class="p-3">
                <strong>3</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q4: Previous job at Ridgemont --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Previous job at Ridgemont High School:</div>
            <div class="p-3">
                <strong>4</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q5: Additional relevant work experience --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Additional relevant work experience:</div>
            <div class="p-3">
                <strong>5</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q6: Relevant skills/qualifications --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Relevant skills/qualifications:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">CPR certification &amp;</span>
                <strong>6</strong>
                <span class="inline-block w-32 ml-1">
                    <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q7: CPR certification expiration date --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">CPR certification expiration date:</div>
            <div class="p-3">
                <strong>7</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q8: Preferred weekly shift --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Preferred weekly shift:</div>
            <div class="p-3">
                <strong>8</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q9: Time available to start work --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Time available to start work:</div>
            <div class="p-3">
                <strong>9</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q10: Advertisement source --}}
        <div class="grid grid-cols-2 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Advertisement source:</div>
            <div class="p-3">
                <strong>10</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>
    </div>
</div>
