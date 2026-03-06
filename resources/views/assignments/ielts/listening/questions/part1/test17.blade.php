<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>

    {{-- Questions 1-5 --}}
    <h4 class="text-lg font-bold mb-2">Questions 1-5</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN ONE WORD OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-xl font-bold mb-4 text-center">Oakham Surgery New Patient Form</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden mb-10">
        {{-- Header --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white">
            <div class="p-3 italic text-gray-500 text-sm">Example</div>
            <div class="p-3 italic text-gray-500 text-sm">Answer</div>
        </div>

        {{-- Example row --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50">
            <div class="p-3 font-bold text-gray-600 uppercase text-sm">New Patient's Road</div>
            <div class="p-3 font-bold text-gray-600 italic">Dawson Road</div>
        </div>

        {{-- Q1: Full name --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 uppercase text-sm font-medium text-gray-700">Full Name</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">Mike</span>
                <strong>1</strong>
                <span class="inline-block w-32 ml-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Wife's name (given) --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50">
            <div class="p-3 uppercase text-sm font-medium text-gray-700">Wife's First Name</div>
            <div class="p-3 text-gray-700">Janet</div>
        </div>

        {{-- Q2: Children's first names --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 uppercase text-sm font-medium text-gray-700">Childrens' First Names</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">1st</span>
                <strong>2</strong>
                <span class="inline-block w-28 mx-1">
                    <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">2nd 3rd 4th</span>
            </div>
        </div>

        {{-- Q3: Address --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 uppercase text-sm font-medium text-gray-700">Address</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">52 Dawson Road</span>
                <strong>3</strong>
                <span class="inline-block w-28 mx-1">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">Melbourne</span>
            </div>
        </div>

        {{-- Q4: Health card number --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 uppercase text-sm font-medium text-gray-700">Health Card Number</div>
            <div class="p-3">
                <strong>4</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Wife's health card (given) --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50">
            <div class="p-3 uppercase text-sm font-medium text-gray-700">Wife's Health Card Number</div>
            <div class="p-3 text-gray-600 italic">will give later</div>
        </div>

        {{-- Q5: Preferred doctor --}}
        <div class="grid grid-cols-2 hover:bg-gray-50 transition-colors">
            <div class="p-3 uppercase text-sm font-medium text-gray-700">Preferred Doctor Selected</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <strong>5</strong>
                <span class="inline-block w-32 mx-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">White</span>
            </div>
        </div>
    </div>

    {{-- Questions 6-10 --}}
    <h4 class="text-lg font-bold mb-2">Questions 6-10</h4>
    <p class="mb-6 text-gray-700">Circle the correct letters <strong>A</strong>, <strong>B</strong>, or <strong>C</strong>.</p>

    <div class="space-y-8">
        {{-- Q6 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong>6</strong>&nbsp; When is Mike's wife's first appointment?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[6]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>Friday 21st at 2.00pm.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[6]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>Friday 21st at 2.30pm.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[6]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>Friday 21st at 3.30pm.</span>
                </label>
            </div>
        </div>

        {{-- Q7 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong>7</strong>&nbsp; What is the surgery's phone number?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[7]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>7253 9819</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[7]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>7253 9829</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[7]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>7523 9829</span>
                </label>
            </div>
        </div>

        {{-- Q8 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong>8</strong>&nbsp; What is the name of the girl with whom Mike is speaking at the surgery?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[8]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>Rachel</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[8]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>Elizabeth</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[8]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>Angela</span>
                </label>
            </div>
        </div>

        {{-- Q9 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong>9</strong>&nbsp; What's the night doctor's mobile number?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[9]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>0506 759 3856</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[9]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>0506 759 3857</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[9]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>0506 758 3856</span>
                </label>
            </div>
        </div>

        {{-- Q10 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong>10</strong>&nbsp; Which of the following does the surgery NOT make a charge for?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[10]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>Travel vaccinations</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[10]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>Consultations</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                    <input type="radio" name="answers[10]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>Insurance reports</span>
                </label>
            </div>
        </div>
    </div>
</div>
