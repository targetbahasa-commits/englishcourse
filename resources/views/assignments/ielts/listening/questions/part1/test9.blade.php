<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>
    <h4 class="text-lg font-bold mb-2">Questions 1-10</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-2xl font-bold mb-6 text-center">Registration Form</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Example / Answer header --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 font-bold italic">Example</div>
            <div class="p-3 font-bold italic">Answer</div>
        </div>

        {{-- Example row --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 text-gray-600 italic font-semibold">Type of crime reported:</div>
            <div class="p-3 text-gray-600 italic">robbery</div>
        </div>

        {{-- Q1: Name --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Name:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">Anna</span>
                <strong>1</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q2: Date of Birth --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Date of Birth (<strong>dd/mm/yyyy</strong>):</div>
            <div class="p-3">
                <strong>2</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q3: Address --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Address:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">4</span>
                <strong>3</strong>
                <span class="inline-block w-32 mx-1">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">St.</span>
            </div>
        </div>

        {{-- Q4: Post code --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Post code:</div>
            <div class="p-3">
                <strong>4</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Nationality (given, no input) --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Nationality:</div>
            <div class="p-3 text-gray-700">Grenadian</div>
        </div>

        {{-- Q5: Number of previous burglaries --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Number of previous burglaries:</div>
            <div class="p-3">
                <strong>5</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q6: Time of apartment tenancy --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Time of apartment tenancy:</div>
            <div class="p-3">
                <strong>6</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q7: Number of occupants --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Number of occupants:</div>
            <div class="p-3">
                <strong>7</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q8: Entry point of burglar --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Entry point of burglar:</div>
            <div class="p-3">
                <strong>8</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Details of lost property (sub-header) --}}
        <div class="border-b border-gray-200 bg-white px-3 py-2">
            <p class="text-gray-700">Details of lost property:</p>
        </div>

        {{-- Q9: Serial number of lost computer --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 text-gray-700 pl-6">• Serial number of lost computer:</div>
            <div class="p-3">
                <strong>9</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q10: Material of stolen purse --}}
        <div class="grid grid-cols-2 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700 pl-6">• Material of stolen purse:</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <strong>10</strong>
                <span class="inline-block w-32 mx-1">
                    <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">Cloth</span>
            </div>
        </div>
    </div>
</div>
