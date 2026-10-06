<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 1</h3>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <h4 class="text-xl font-bold text-gray-800">Questions 1-4</h4>
        <p class="text-gray-600 font-medium">Complete the form below.</p>
        <p class="text-gray-600 font-medium">Write ONE WORD ONLY for each answer.</p>
        <h5 class="text-lg font-bold text-gray-800 mt-4 mb-2">HOUSE SERVICE INFORMATION</h5>
        <h5 class="text-lg font-bold text-gray-800 mt-4 mb-2">Example</h5>
        <p class="text-gray-800 text-base leading-relaxed">Name:</p>
        <h5 class="text-lg font-bold text-gray-800 mt-4 mb-2">Answer</h5>
        <h5 class="text-lg font-bold text-gray-800 mt-4 mb-2">Barbara Hill</h5>
        <p class="text-gray-800 text-base leading-relaxed">Location:</p>
        <p class="text-gray-800 text-base leading-relaxed"><strong class="text-gray-900 font-bold ml-1 mr-1">1</strong><input type="text" name="answers[1]" value="{{ old('answers.1') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> London</p>
        <p class="text-gray-800 text-base leading-relaxed">Postcode:</p>
        <h5 class="text-lg font-bold text-gray-800 mt-4 mb-2">SW105</h5>
        <p class="text-gray-800 text-base leading-relaxed">Rooms:</p>
        <p class="text-gray-800 text-base leading-relaxed">two <strong class="text-gray-900 font-bold ml-1 mr-1">2</strong><input type="text" name="answers[2]" value="{{ old('answers.2') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> bedrooms</p>
        <p class="text-gray-800 text-base leading-relaxed">The other room used as:</p>
        <p class="text-gray-800 text-base leading-relaxed">an <strong class="text-gray-900 font-bold ml-1 mr-1">3</strong><input type="text" name="answers[3]" value="{{ old('answers.3') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"></p>
        <p class="text-gray-800 text-base leading-relaxed">Downstairs:</p>
        <p class="text-gray-800 text-base leading-relaxed">kitchen-diner, conservatory, and <strong class="text-gray-900 font-bold ml-1 mr-1">4</strong><input type="text" name="answers[4]" value="{{ old('answers.4') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"></p>
        <p class="text-gray-800 text-base leading-relaxed">Pets:</p>
        <div class="flex items-center gap-3 my-2">
            <strong class="text-gray-900 font-bold">2</strong>
            <span class="text-gray-800">dogs and 3 cats</span>
            <input type="text" name="answers[2]" value="{{ old('answers.2') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <h4 class="text-xl font-bold text-gray-800">Questions 5-7</h4>
        <p class="text-gray-600 font-medium">Choose the correct letter, A, B, or C.</p>
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 my-4">
            <p class="font-semibold text-gray-900 text-lg mb-3"><span class="text-gray-900 font-bold mr-2">5</span> Which of these extra services does the customer agree to do?</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[5]" value="A" class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">Change the bed linen</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[5]" value="B" class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">Do some gardening work</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[5]" value="C" class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">Clean the glass</span>
                </label>
            </div>
        </div>
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 my-4">
            <p class="font-semibold text-gray-900 text-lg mb-3"><span class="text-gray-900 font-bold mr-2">6</span> What does the customer want cleaned every three months?</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[6]" value="A" class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">Curtains</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[6]" value="B" class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">Carpets</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[6]" value="C" class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">Mats</span>
                </label>
            </div>
        </div>
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 my-4">
            <p class="font-semibold text-gray-900 text-lg mb-3"><span class="text-gray-900 font-bold mr-2">7</span> What does the customer want done with clothes?</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[7]" value="A" class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">Wash and iron the clothes</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[7]" value="B" class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">Iron the clothes</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[7]" value="C" class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">Clean and dry the clothes</span>
                </label>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <h4 class="text-xl font-bold text-gray-800">Questions 8-10</h4>
        <p class="text-gray-600 font-medium">Complete the sentences below.</p>
        <p class="text-gray-600 font-medium">Write ONE WORD AND/OR A NUMBER for each answer.</p>
        <p class="text-gray-800 text-base leading-relaxed">The agent’s address is 12 <strong class="text-gray-900 font-bold ml-1 mr-1">8</strong><input type="text" name="answers[8]" value="{{ old('answers.8') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> Road.</p>
        <p class="text-gray-800 text-base leading-relaxed">Her house will get cleaned next <strong class="text-gray-900 font-bold ml-1 mr-1">9</strong><input type="text" name="answers[9]" value="{{ old('answers.9') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"></p>
        <p class="text-gray-800 text-base leading-relaxed">The maximum time of cleaning service is <strong class="text-gray-900 font-bold ml-1 mr-1">10</strong><input type="text" name="answers[10]" value="{{ old('answers.10') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> hours</p>
    </div>
</div>