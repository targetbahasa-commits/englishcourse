<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>

    {{-- Question 1 --}}
    <h4 class="text-lg font-bold mb-2">Question 1</h4>
    <p class="mb-4 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    {{-- Example --}}
    <div class="mb-6 bg-white border border-gray-200 rounded-lg p-4">
        <p class="font-bold text-gray-700 mb-2">Example</p>
        <p class="text-gray-700 mb-2">What's the name of the accommodation house?</p>
        <p class="ml-4 text-gray-500">A &nbsp; Jerry House</p>
        <p class="ml-4 font-bold text-gray-700">B &nbsp; Thomas House</p>
        <p class="ml-4 text-gray-500">C &nbsp; Student House</p>
    </div>

    <div class="mb-10">
        <p class="text-lg font-medium mb-3"><strong>1</strong>&nbsp; The accommodation was originally built as</p>
        <div class="space-y-2 pl-6">
            <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                <input type="radio" name="answers[1]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                <span class="font-bold">A</span><span>student flat.</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                <input type="radio" name="answers[1]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                <span class="font-bold">B</span><span>local museum.</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors">
                <input type="radio" name="answers[1]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                <span class="font-bold">C</span><span>private house.</span>
            </label>
        </div>
    </div>

    {{-- Questions 2-3 --}}
    <h4 class="text-lg font-bold mb-2">Questions 2-3</h4>
    <p class="mb-1 text-gray-700 italic">Choose <strong>TWO</strong> letters, <strong>A-E</strong>.</p>
    <p class="mb-4 text-gray-700">Which of the following <strong>TWO</strong> facilities are <strong>NOT</strong> in the house?</p>

    <div class="bg-white p-6 rounded-2xl inline-block mb-10 min-w-[280px]" id="checkbox-group-facilities">
        <div class="space-y-3 font-medium text-lg">
            @foreach([
                ['A', 'bathroom'],
                ['B', 'balcony'],
                ['C', 'computer room'],
                ['D', 'garden'],
                ['E', 'garage'],
            ] as [$letter, $label])
            <label class="flex items-center gap-4 cursor-pointer hover:bg-white p-2 rounded transition-colors group">
                <input type="checkbox" name="answers[2_3][]" value="{{ $letter }}" class="facility-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                <span class="font-bold w-6 group-hover:text-blue-600">{{ $letter }}</span>
                <span>{{ $label }}</span>
            </label>
            @endforeach
        </div>
    </div>

    {{-- Questions 4-7 --}}
    <h4 class="text-lg font-bold mb-2">Questions 4-7</h4>
    <p class="mb-1 text-gray-700">Complete the table below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <div class="border border-gray-200 rounded-lg overflow-hidden">
        {{-- Table header --}}
        <div class="grid grid-cols-2 bg-white border-b border-gray-200">
            <div class="p-3 text-gray-700"></div>
            <div class="p-3 font-bold text-center text-gray-800 uppercase tracking-wide">Rule</div>
        </div>

        {{-- Q4: Bedroom and bathroom --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Bedroom and bathroom</div>
            <div class="p-3">
                <strong>4</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q5: ___ room --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-white hover:bg-white transition-colors">
            <div class="p-3 flex items-center gap-1">
                <strong>5</strong>
                <span class="inline-block w-28 ml-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700 ml-1">room</span>
            </div>
            <div class="p-3 text-gray-700">Use before 11 p.m.</div>
        </div>

        {{-- Q6: Lounge --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Lounge</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <strong>6</strong>
                <span class="inline-block w-28 mx-1">
                    <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">after 11 p.m</span>
            </div>
        </div>

        {{-- Q7: Yard --}}
        <div class="grid grid-cols-2 hover:bg-white transition-colors">
            <div class="p-3 text-gray-700">Yard</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">No</span>
                <strong class="mx-1">7</strong>
                <span class="inline-block w-28">
                    <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">is allowed</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const group = document.getElementById('checkbox-group-facilities');
        const checkboxes = Array.from(group.querySelectorAll('.facility-checkbox'));
        const MAX = 2;
        let queue = [];
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (this.checked) {
                    queue.push(this);
                    if (queue.length > MAX) { const old = queue.shift(); old.checked = false; }
                } else {
                    const i = queue.indexOf(this);
                    if (i > -1) queue.splice(i, 1);
                }
            });
        });
    });
</script>
