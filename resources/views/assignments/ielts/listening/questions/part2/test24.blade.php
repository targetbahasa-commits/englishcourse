<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-12 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-12</h4>
    <p class="mb-6 text-gray-700">Complete the notes on the Citizens Advice Bureau using <strong>NO MORE THAN TWO WORDS</strong> for each gap.</p>

    <div class="space-y-3 mb-12 text-gray-700 max-w-2xl">
        <div class="flex items-center gap-2 flex-wrap">
            <strong class="text-blue-600">11</strong>
            <input type="text" name="answers[11]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            <span>a solicitor</span>
        </div>
        <p>suggest where you can find free legal advice</p>
        <div class="flex items-center gap-2 flex-wrap">
            <span>inform you whether you can get</span>
            <strong class="text-blue-600">12</strong>
            <input type="text" name="answers[12]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            <span>to cover legal costs.</span>
        </div>
    </div>


    {{-- Questions 13-14 --}}
    <h4 class="text-lg font-bold mb-2">Questions 13-14</h4>
    <p class="mb-6 text-gray-700">Complete the notes on the police using <strong>NO MORE THAN THREE WORDS</strong> for each gap.</p>

    <div class="space-y-3 mb-12 text-gray-700 max-w-2xl">
        <p>don't be aggressive</p>
        <p>do not try to bribe police officers</p>
        <div class="flex items-center gap-2 flex-wrap">
            <span>ask plain-clothes police officers for</span>
            <strong class="text-blue-600">13</strong>
            <input type="text" name="answers[13]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
        </div>
        <p>give your true name and address if asked</p>
        <div class="flex items-center gap-2 flex-wrap">
            <span>do not sign anything without a solicitor's</span>
            <strong class="text-blue-600">14</strong>
            <input type="text" name="answers[14]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
        </div>
        <p>you can make one telephone call</p>
    </div>


    {{-- Questions 15-16 --}}
    <h4 class="text-lg font-bold mb-2">Questions 15-16</h4>
    <p class="mb-6 text-gray-700">Complete the following notes on illegal actions using <strong>NO MORE THAN THREE WORDS</strong> for each gap.</p>

    <div class="space-y-3 mb-12 text-gray-700 max-w-2xl">
        <p>The following three things are illegal:</p>
        <div class="flex items-center gap-2 flex-wrap">
            <span>the possession of</span>
            <strong class="text-blue-600">15</strong>
            <input type="text" name="answers[15]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <span>possess or</span>
            <strong class="text-blue-600">16</strong>
            <input type="text" name="answers[16]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            <span>drugs</span>
        </div>
        <p>disorderly conduct</p>
    </div>


    {{-- Questions 17-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 17-20</h4>
    <p class="mb-2 text-gray-700">Decide which <strong>FOUR</strong> of the following statements are true, according to the speaker.</p>
    <p class="mb-6 text-gray-700">Write the appropriate letters in any order on your answer sheet.</p>

    <div class="space-y-3 mb-8 pl-2" id="mcma-group-17-20">
        @foreach([
            'A' => 'It is socially acceptable to drink a lot of alcohol.',
            'B' => 'People often arrange to meet in bars.',
            'C' => 'Drinking non-alcoholic drinks in bars is socially acceptable.',
            'D' => 'You can drink a little and still drive a car.',
            'E' => 'You can drink in public.',
            'F' => 'Doctors can give patients otherwise illegal drugs.',
            'G' => 'You must be over 18 to buy alcohol.',
            'H' => 'Many people use illegal drugs.'
        ] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit mcma-option-17-20">
            <input type="checkbox" name="answers[17_20][]" value="{{ $letter }}"
                class="w-4 h-4 text-blue-600 border-gray-400 rounded focus:ring-blue-500 cursor-pointer mcma-checkbox-17-20"
                onchange="handleMcmaLimit('mcma-checkbox-17-20', 4)">
            <span class="font-bold text-gray-800">{{ $letter }}</span>
            <span class="text-gray-700">{{ $option }}</span>
        </label>
        @endforeach
    </div>

    @if(!function_exists('handleMcmaLimit'))
    <script>
    function handleMcmaLimit(className, max) {
        const checkboxes = document.querySelectorAll('.' + className);
        const checked = Array.from(checkboxes).filter(cb => cb.checked);
        if (checked.length >= max) {
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
    @endif
</div>
