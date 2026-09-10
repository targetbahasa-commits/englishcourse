<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-17 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-17</h4>
    <p class="mb-1 text-gray-700">Complete the sentences.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <div class="space-y-6 mb-12">
        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">It is important for everyone to know simple first aid</span>
            <strong class="text-blue-600">11</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[11]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">After an accident, one must firstly be aware of</span>
            <strong class="text-blue-600">12</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[12]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">After that, the first-aider must</span>
            <strong class="text-blue-600">13</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[13]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">Clearing of airways may not happen when patients are</span>
            <strong class="text-blue-600">14</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[14]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">The mouth must be checked for</span>
            <strong class="text-blue-600">15</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[15]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">CPR must be done if breathing is absent or</span>
            <strong class="text-blue-600">16</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[16]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">CPR must be done up to the arrival of</span>
            <strong class="text-blue-600">17</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[17]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>
    </div>

    {{-- Questions 18-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 18-20</h4>
    <p class="mb-6 text-gray-700 italic">Choose <strong>THREE</strong> answers from the list and write the correct letter, <strong>A-G</strong>, next to the questions <strong class="text-blue-600">18-20</strong>.</p>

    <div class="mb-4">
        <p class="text-lg text-gray-800">Which <strong>THREE</strong> pieces of advice does the first-aid officer say are most important?</p>
    </div>

    <div class="bg-white p-6 rounded-2xl inline-block mt-2 min-w-[300px]">
        <div class="space-y-3" id="checkbox-group-1">
            @foreach([
                'A' => 'Have proper equipment',
                'B' => 'Give regular first-aid training',
                'C' => 'Have a safety officer',
                'D' => 'Instil safe behaviour',
                'E' => 'Put posters on walls',
                'F' => 'Have safety meetings',
                'G' => 'Have first-aid boxes'
            ] as $letter => $option)
            <label class="flex items-center gap-4 cursor-pointer hover:bg-white p-1 rounded transition-colors group">
                <input type="checkbox" name="answers[18_19_20][]" value="{{ $letter }}" class="answer-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                <strong class="font-bold w-4 text-gray-800 group-hover:text-blue-600">{{ $letter }}</strong>
                <span class="text-gray-800">{{ $option }}</span>
            </label>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find all checkboxes in this group
        const groupContainer = document.getElementById('checkbox-group-1');
        if (groupContainer) {
            const checkboxes = Array.from(groupContainer.querySelectorAll('.answer-checkbox'));
            const MAX_SELECTIONS = 3;
            
            // Keep track of the order selections were made
            let selectionQueue = [];

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Add to queue
                        selectionQueue.push(this);
                        
                        // If we exceed max, remove the oldest one
                        if (selectionQueue.length > MAX_SELECTIONS) {
                            const oldestCheckbox = selectionQueue.shift(); // Remove first element (oldest)
                            oldestCheckbox.checked = false;
                        }
                    } else {
                        // If unchecked manually, remove it from our queue
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
