<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-23: Sentence Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-23</h4>
    <p class="mb-2 text-gray-700">Complete the sentences below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <div class="space-y-6 max-w-2xl text-gray-700 mb-12">

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>People domesticate bees for honey and</span>
            <strong class="text-blue-600">21</strong>
            <input type="text" name="answers[21]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>Commercial crops such as almond, cherry,</span>
            <strong class="text-blue-600">22</strong>
            <input type="text" name="answers[22]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>, water melon, cucumber, depend on pollination.</span>
        </div>

        {{-- Note: Question 23 was not present in the provided text snippet, but space is kept if needed later --}}
        <!-- 
        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <strong class="text-blue-600">23</strong>
            <input type="text" name="answers[23]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div> 
        -->

    </div>

    {{-- Questions 24-25: Choose TWO --}}
    <h4 class="text-lg font-bold mb-2">Questions 24-25</h4>
    <p class="mb-2 text-gray-700 italic">Choose <strong>TWO</strong> letters, <strong>A-D</strong>.</p>
    <p class="mb-6 text-gray-700">According to the professor, what factors have affected pollinator populations?</p>

    <div class="mb-12 space-y-2 pl-2">
        @foreach(['A' => 'Parasites.', 'B' => 'Air pollution.', 'C' => 'Hunting.', 'D' => 'Farm chemicals.'] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
            <input type="checkbox" name="answers_multi[24_25][]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer rounded">
            <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
        </label>
        @endforeach
        <p class="text-xs text-gray-400 mt-2 italic">Select exactly 2 answers for Q24-25.</p>
    </div>

    {{-- Questions 26-29: Matching Features A-F --}}
    <h4 class="text-lg font-bold mb-2">Questions 26-29</h4>
    <p class="mb-2 text-gray-700">What are the features of each pollinator?</p>
    <p class="mb-4 text-gray-700 italic">Choose the correct letter, <strong>A-F</strong>.</p>

    <div class="mb-6">
        <div class="grid grid-cols-1 gap-y-2 pl-4 text-gray-700 max-w-lg">
            <p><strong>A</strong>&nbsp;&nbsp; It pollinates four out of live food crops in North America.</p>
            <p><strong>B</strong>&nbsp;&nbsp; It has been mistaken for a similar animal.</p>
            <p><strong>C</strong>&nbsp;&nbsp; It feeds on the nectar of lavender.</p>
            <p><strong>D</strong>&nbsp;&nbsp; It has been affected by environmental alteration.</p>
            <p><strong>E</strong>&nbsp;&nbsp; It has been smuggling traded.</p>
            <p><strong>F</strong>&nbsp;&nbsp; It returns to the specific site every year.</p>
        </div>
    </div>

    @php
        $items = [
            26 => 'Monarch butterfly',
            27 => 'Indian subcontinent butterflies',
            28 => 'Spectacular tropical butterflies',
            29 => 'Long-nosed bat',
        ];
    @endphp

    <div class="mb-12" style="display: grid; grid-template-columns: 240px auto; gap: 0.75rem 1rem; align-items: center; max-width: 440px;">
        @foreach($items as $q => $label)
            <span class="font-medium text-gray-700"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
            <select name="answers[{{ $q }}]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-2 bg-white cursor-pointer rounded text-gray-700 w-36">
                <option value="" disabled selected>Select...</option>
                @foreach(['A','B','C','D','E','F'] as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        @endforeach
    </div>

    {{-- Question 30: Multiple Choice A/B/C --}}
    <h4 class="text-lg font-bold mb-2">Question 30</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div>
        <p class="text-lg font-medium mb-3"><strong class="text-blue-600">30</strong>&nbsp; What can be done to protect pollinators?</p>
        <div class="space-y-2 pl-6">
            @foreach(['A' => 'Beekeeping needs to focus on honey production.', 'B' => 'People should use more organic approach of cultivation.', 'C' => 'Scientists should exploit more wild plants.'] as $letter => $option)
            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                <input type="radio" name="answers[30]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
            </label>
            @endforeach
        </div>
    </div>

</div>
