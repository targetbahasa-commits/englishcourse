<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-26: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-26</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; What is the thing that makes the Moa similar to dinosaur?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'Both are of interest to the public.', 'B' => 'Both are extinct at similar time.', 'C' => 'Both left lots of fossil remains.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; What is the difference between Moa and other birds?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'no wing bones', 'B' => 'a long tail', 'C' => 'a smaller head'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; What's the special feature of their chicks?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'They never return to the nests.', 'B' => 'Most of them die within two months after birth.', 'C' => 'They can find food by themselves.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; What is the tutor's opinion on male hatching the eggs?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'He doubts whether it is true or possible.', 'B' => 'He thinks it may be true.', 'C' => 'He can say with certainty that it is true.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; What is the male student's response after hearing some people see a Moa recently?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'He is surprised.', 'B' => 'He is worried.', 'C' => 'He is amused.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q26 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">26</strong>&nbsp; Why did the Moa become extinct?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'climate change', 'B' => 'human interference', 'C' => 'competitions with other animals'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[26]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 27-30: Matching Features (A-F) --}}
    <h4 class="text-lg font-bold mb-2">Questions 27-30</h4>
    <p class="mb-4 text-gray-700 italic">Choose <strong>FOUR</strong> answers from the box and write the correct letter, <strong>A-F</strong>, next to Questions <strong>27-30</strong>.</p>

    <div class="mb-6 grid grid-cols-2 gap-x-8 gap-y-1 pl-4 text-gray-700 max-w-md">
        <p><strong>A</strong>&nbsp;&nbsp; the much taller female</p>
        <p><strong>D</strong>&nbsp;&nbsp; feeding at night</p>
        <p><strong>B</strong>&nbsp;&nbsp; less fossils left</p>
        <p><strong>E</strong>&nbsp;&nbsp; better vocal sound</p>
        <p><strong>C</strong>&nbsp;&nbsp; the biggest eggs</p>
        <p><strong>F</strong>&nbsp;&nbsp; poor eyesight</p>
    </div>

    @php
        $items = [
            27 => 'the North Island Giant Moa',
            28 => 'the Crested Moa',
            29 => 'the Stout-legged Moa',
            30 => 'the Eastern Moa',
        ];
    @endphp

    <div style="display: grid; grid-template-columns: 280px auto; gap: 0.75rem 1rem; align-items: center; max-width: 500px;">
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
</div>
