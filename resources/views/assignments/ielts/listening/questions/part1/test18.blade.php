<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>

    {{-- Questions 1-5 --}}
    <h4 class="text-lg font-bold mb-2">Questions 1-5</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN ONE WORD OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-lg font-bold mb-4 text-center uppercase tracking-wide">Westley Public Library Membership Application Form</h4>

    <div class="border border-gray-200 rounded-lg overflow-hidden mb-10">
        {{-- Q1: Full Name --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold uppercase text-sm text-gray-700">Full Name</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">Peter Adrien</span>
                <strong>1</strong>
                <span class="inline-block w-32 ml-1">
                    <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q2: Address --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold uppercase text-sm text-gray-700">Address</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">Flat 5 53</span>
                <strong>2</strong>
                <span class="inline-block w-28 mx-1">
                    <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
                <span class="text-gray-700">Street Finsbury</span>
            </div>
        </div>

        {{-- Q3: Postcode --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold uppercase text-sm text-gray-700">Postcode</div>
            <div class="p-3">
                <strong>3</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Q4: Date of Birth --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold uppercase text-sm text-gray-700">Date of Birth</div>
            <div class="p-3 flex items-center flex-wrap gap-1">
                <span class="text-gray-700">8th July</span>
                <strong>4</strong>
                <span class="inline-block w-28 ml-1">
                    <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Home Tel (given) --}}
        <div class="grid grid-cols-2 border-b border-gray-200 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold uppercase text-sm text-gray-700">Home Tel</div>
            <div class="p-3 text-gray-600 italic">none</div>
        </div>

        {{-- Q5: Mobile Tel --}}
        <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="p-3 font-bold uppercase text-sm text-gray-700">Mobile Tel</div>
            <div class="p-3">
                <strong>5</strong>
                <span class="inline-block w-36 ml-1">
                    <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
                </span>
            </div>
        </div>

        {{-- Proof of Residence (given) --}}
        <div class="grid grid-cols-2 hover:bg-gray-50 transition-colors">
            <div class="p-3 font-bold uppercase text-sm text-gray-700">Proof of Residence Provided</div>
            <div class="p-3 text-gray-600 italic">a letter</div>
        </div>
    </div>

    {{-- Questions 6-8 --}}
    <h4 class="text-lg font-bold mb-2">Questions 6-8</h4>
    <p class="mb-1 text-gray-700 italic">Circle <strong>THREE</strong> letters <strong>A-F</strong>.</p>
    <p class="mb-4 text-gray-700">What type of books does Peter like?</p>

    <div class="bg-gray-50 p-6 rounded-2xl inline-block mt-2 min-w-[300px] mb-8">
        <div class="space-y-4 font-medium text-lg" id="checkbox-group-books">
            @foreach([
                ['A', 'Wildlife books'],
                ['B', 'Romance books'],
                ['C', 'Travel books'],
                ['D', 'Historical novels'],
                ['E', 'Science Fiction novels'],
                ['F', 'Mystery books'],
            ] as [$letter, $label])
            <label class="flex items-center gap-4 cursor-pointer hover:bg-gray-100 p-2 rounded transition-colors group">
                <input type="checkbox" name="answers[6_7_8][]" value="{{ $letter }}" class="books-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                <span class="font-bold w-6 group-hover:text-blue-600">{{ $letter }}</span>
                <span>{{ $label }}</span>
            </label>
            @endforeach
        </div>
    </div>

    {{-- Questions 9-10 --}}
    <h4 class="text-lg font-bold mb-2">Question 9-10</h4>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN THREE WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <div class="space-y-5 text-lg text-gray-800">
        <p class="flex items-center flex-wrap gap-1">
            How much does it cost to join the library?
            <strong class="mx-1">9</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>
        <p class="flex items-center flex-wrap gap-1">
            How much does it cost to rent a DVD?
            <strong class="mx-1">10</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groupContainer = document.getElementById('checkbox-group-books');
        const checkboxes = Array.from(groupContainer.querySelectorAll('.books-checkbox'));
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
                    if (index > -1) selectionQueue.splice(index, 1);
                }
            });
        });
    });
</script>
