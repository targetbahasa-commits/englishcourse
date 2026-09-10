<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 4</h3>

    {{-- Questions 31-32: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 31-32</h4>
    <p class="mb-2 text-gray-700">Choose the correct letter, <strong>A, B,</strong> or <strong>C</strong>.</p>

    <div class="space-y-6 mb-8 text-gray-700">
        {{-- Question 31 --}}
        <div>
            <div class="flex gap-2">
                <strong class="text-blue-600">31</strong>
                <span>Originally, country</span>
            </div>
            <div class="mt-3 space-y-2 ml-6">
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="radio" name="answers[31]" value="A" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="group-hover:text-blue-600 transition-colors"><strong class="font-medium mr-1">A</strong> required fewer workers.</span>
                </label>
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="radio" name="answers[31]" value="B" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="group-hover:text-blue-600 transition-colors"><strong class="font-medium mr-1">B</strong> had lots of animals.</span>
                </label>
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="radio" name="answers[31]" value="C" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="group-hover:text-blue-600 transition-colors"><strong class="font-medium mr-1">C</strong> were more interesting places.</span>
                </label>
            </div>
        </div>

        {{-- Question 32 --}}
        <div>
            <div class="flex gap-2">
                <strong class="text-blue-600">32</strong>
                <span>Now, the problems there</span>
            </div>
            <div class="mt-3 space-y-2 ml-6">
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="radio" name="answers[32]" value="A" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="group-hover:text-blue-600 transition-colors"><strong class="font-medium mr-1">A</strong> can be solved.</span>
                </label>
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="radio" name="answers[32]" value="B" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="group-hover:text-blue-600 transition-colors"><strong class="font-medium mr-1">B</strong> are numerous.</span>
                </label>
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="radio" name="answers[32]" value="C" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="group-hover:text-blue-600 transition-colors"><strong class="font-medium mr-1">C</strong> are expected.</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Questions 33-35: Multiple Choice (Choose 3) --}}
    <h4 class="text-lg font-bold mb-2">Questions 33-35</h4>
    <p class="mb-6 text-gray-700 italic">Choose <strong>THREE</strong> answers from the list and write the correct letter, <strong>A-F</strong>, next to the questions <strong class="text-blue-600">33-35</strong>.</p>

    <div class="mb-4">
        <p class="text-lg text-gray-800">Which <strong>THREE</strong> factors are typical of modern farming?</p>
    </div>

    <div class="bg-white p-6 rounded-2xl inline-block mt-2 min-w-[300px] mb-12">
        <div class="space-y-3" id="checkbox-group-t5">
            @foreach([
                'A' => 'Many overheads',
                'B' => 'More machines',
                'C' => 'Fewer types of products',
                'D' => 'More frequent feeding',
                'E' => 'Greater numbers of products',
                'F' => 'More factories'
            ] as $letter => $option)
            <label class="flex items-center gap-4 cursor-pointer hover:bg-white p-1 rounded transition-colors group">
                <input type="checkbox" name="answers[33_34_35][]" value="{{ $letter }}" class="answer-checkbox-t5 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                <strong class="font-bold w-4 text-gray-800 group-hover:text-blue-600">{{ $letter }}</strong>
                <span class="text-gray-800">{{ $option }}</span>
            </label>
            @endforeach
        </div>
    </div>

    {{-- Questions 36-40: Table Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 36-40</h4>
    <p class="mb-2 text-gray-700">Complete the table.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for each answer.</p>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300 text-gray-700">
            <thead>
                <tr class="bg-white">
                    <th class="border border-gray-300 px-5 py-3 font-bold text-center w-1/4">Possible Solution</th>
                    <th class="border border-gray-300 px-5 py-3 font-bold text-center w-5/12">Important Factor</th>
                    <th class="border border-gray-300 px-5 py-3 font-bold text-center w-1/3">Examples</th>
                </tr>
            </thead>
            <tbody>
                {{-- Row 1: tourism --}}
                <tr>
                    <td class="border border-gray-300 px-5 py-4 align-top">
                        tourism
                    </td>
                    <td class="border border-gray-300 px-5 py-4 align-top">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>Locals must</span>
                            <strong class="text-blue-600">36</strong>
                            <input type="text" name="answers[36]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                    <td class="border border-gray-300 px-5 py-4 align-top">
                        <div class="flex items-center gap-2 flex-wrap mb-2">
                            <span>Daylesford area uses its</span>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <strong class="text-blue-600">37</strong>
                            <input type="text" name="answers[37]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                </tr>
                {{-- Row 2: using the... --}}
                <tr class="bg-white">
                    <td class="border border-gray-300 px-5 py-4 align-top">
                        <div class="flex items-center gap-2 flex-wrap mb-2">
                            <span>using the</span>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <strong class="text-blue-600">38</strong>
                            <input type="text" name="answers[38]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                    <td class="border border-gray-300 px-5 py-4 align-top space-y-4">
                        <div class="flex items-start gap-2 flex-wrap">
                            <span>&ndash; is</span>
                            <strong class="text-blue-600">39</strong>
                            <input type="text" name="answers[39]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                            <span>by its distinctive product</span>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>&ndash; must market the idea effectively</span>
                        </div>
                    </td>
                    <td class="border border-gray-300 px-5 py-4 align-top">
                        <div class="flex items-center gap-2 flex-wrap mb-2">
                            <span>Shepparton is known for its</span>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <strong class="text-blue-600">40</strong>
                            <input type="text" name="answers[40]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groupContainer = document.getElementById('checkbox-group-t5');
        if (groupContainer) {
            const checkboxes = Array.from(groupContainer.querySelectorAll('.answer-checkbox-t5'));
            const MAX_SELECTIONS = 3;
            let selectionQueue = [];

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        selectionQueue.push(this);
                        if (selectionQueue.length > MAX_SELECTIONS) {
                            const oldest = selectionQueue.shift();
                            oldest.checked = false;
                        }
                    } else {
                        const index = selectionQueue.indexOf(this);
                        if (index > -1) {
                            selectionQueue.splice(index, 1);
                        }
                    }
                });
            });
        }
    });
</script>
