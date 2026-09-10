<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-14 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-14</h4>
    <p class="mb-4 text-gray-700">Choose the correct letter, <strong>A, B</strong> or <strong>C</strong>.</p>
    <h5 class="text-center font-bold text-gray-800 mb-6">Online Exchange Business</h5>

    <div class="space-y-8 mb-12">
        {{-- Q11 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">11</strong>&nbsp; The website is organised by</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[11]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>family members.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[11]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>friends</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[11]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>businessmen</span>
                </label>
            </div>
        </div>

        {{-- Q12 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">12</strong>&nbsp; How long has the website been operated?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[12]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>about 3 weeks</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[12]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>about 3 months</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[12]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>about 6 months</span>
                </label>
            </div>
        </div>

        {{-- Q13 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">13</strong>&nbsp; How many registered users are there in the website?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[13]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>1,000</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[13]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>1,500</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[13]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>2,000</span>
                </label>
            </div>
        </div>

        {{-- Q14 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">14</strong>&nbsp; Which country has the most users in the website?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[14]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>Ireland</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[14]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>UK</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[14]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>Canada</span>
                </label>
            </div>
        </div>
    </div>


    {{-- Questions 15-16 --}}
    <h4 class="text-lg font-bold mb-2">Questions 15-16</h4>
    <p class="mb-2 text-gray-700 italic">Choose <strong>TWO</strong> letters, <strong>A-E</strong>.</p>
    <p class="mb-6 text-gray-700">Which <strong>TWO</strong> things are most popular among users?</p>

    <div class="space-y-3 mb-12 pl-2" id="mcma-group-15-16">
        @foreach([
            'A' => "children's books",
            'B' => 'textbooks',
            'C' => 'computer games',
            'D' => 'toys',
            'E' => 'tools'
        ] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit mcma-option-15-16">
            <input type="checkbox" name="answers[15_16][]" value="{{ $letter }}"
                class="w-4 h-4 text-blue-600 border-gray-400 rounded focus:ring-blue-500 cursor-pointer mcma-checkbox-15-16"
                onchange="handleMcmaLimit('mcma-checkbox-15-16', 2)">
            <span class="font-bold text-gray-800">{{ $letter }}</span>
            <span class="text-gray-700">{{ $option }}</span>
        </label>
        @endforeach
    </div>

    <script>
    function handleMcmaLimit(className, max) {
        const checkboxes = document.querySelectorAll('.' + className);
        const checked = Array.from(checkboxes).filter(cb => cb.checked);
        if (checked.length > max) {
            checkboxes.forEach(cb => {
                if (!cb.checked) {
                    cb.disabled = true;
                    cb.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                }
            });
        } else {
            checkboxes.forEach(cb => {
                cb.disabled = false;
                cb.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
            });
        }
    }
    </script>


    {{-- Questions 17-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 17-20</h4>
    <p class="mb-2 text-gray-700">Complete the sentences below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <div class="space-y-6 mb-8">
        <div class="flex items-center gap-1 flex-wrap text-gray-700">
            <span>The website will sort out</span>
            <strong class="text-blue-600">17</strong>
            <span class="inline-block mx-1">
                <input type="text" name="answers[17]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </span>
            <span>items to help those who can't decide what to exchange.</span>
        </div>

        <div class="flex items-center gap-1 flex-wrap text-gray-700">
            <span>Do not bother because people's</span>
            <strong class="text-blue-600">18</strong>
            <span class="inline-block mx-1">
                <input type="text" name="answers[18]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </span>
            <span>are different.</span>
        </div>

        <div class="flex items-center gap-1 flex-wrap text-gray-700">
            <span>Users will give</span>
            <strong class="text-blue-600">19</strong>
            <span class="inline-block mx-1">
                <input type="text" name="answers[19]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </span>
            <span>on the completion of exchanges.</span>
        </div>
    </div>

    <p class="font-bold text-gray-800 mb-3">Criteria</p>
    <div class="space-y-3 text-gray-700 pl-2">
        <p>&bull; the quality of the item</p>
        <p>&bull; the ease of communication</p>
        <div class="flex items-center gap-1 flex-wrap">
            <span>&bull; the</span>
            <strong class="text-blue-600">20</strong>
            <span class="inline-block mx-1">
                <input type="text" name="answers[20]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            </span>
            <span>of delivering</span>
        </div>
    </div>
</div>
