<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-24: Notes Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-24</h4>
    <p class="mb-2 text-gray-700">Complete the notes below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN THREE WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <div class="space-y-6 max-w-2xl text-gray-700 mb-12">

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>The tutor's new room number is</span>
            <strong class="text-blue-600">21</strong>
            <input type="text" name="answers[21]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>The tutorial time is at</span>
            <strong class="text-blue-600">22</strong>
            <input type="text" name="answers[22]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>The reason for the student to see his tutor is to</span>
            <strong class="text-blue-600">23</strong>
            <input type="text" name="answers[23]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>The student's trouble is to have many</span>
            <strong class="text-blue-600">24</strong>
            <input type="text" name="answers[24]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>to read.</span>
        </div>

    </div>

    {{-- Questions 25-28: Matching Reference Books (A-F) --}}
    <h4 class="text-lg font-bold mb-2">Questions 25-28</h4>
    <p class="mb-2 text-gray-700">What recommendations does the tutor make about the reference books?</p>
    <p class="mb-4 text-gray-700 italic">Choose your answer below and write the letters, <strong>A-F</strong>, next to Questions <strong>25-28</strong>.</p>

    <div class="mb-6 grid grid-cols-2 gap-x-8 gap-y-1 pl-4 text-gray-700 max-w-sm">
        <p><strong>A</strong>&nbsp;&nbsp; All</p>
        <p><strong>D</strong>&nbsp;&nbsp; Conclusion</p>
        <p><strong>B</strong>&nbsp;&nbsp; Research method</p>
        <p><strong>E</strong>&nbsp;&nbsp; Avoid</p>
        <p><strong>C</strong>&nbsp;&nbsp; Main Body</p>
        <p><strong>F</strong>&nbsp;&nbsp; Argument</p>
    </div>

    @php
        $items = [
            25 => 'Bayer:',
            26 => 'Oliver:',
            27 => 'Billy:',
            28 => 'Andrew:',
        ];
    @endphp

    <div class="mb-12" style="display: grid; grid-template-columns: 80px auto; gap: 0.75rem 1rem; align-items: center; max-width: 250px;">
        @foreach($items as $q => $label)
            <span class="font-medium text-gray-700"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
            <select name="answers[{{ $q }}]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-2 bg-white cursor-pointer rounded text-gray-700 w-32 justify-self-end">
                <option value="" disabled selected>Select...</option>
                @foreach(['A','B','C','D','E','F'] as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        @endforeach
    </div>

    {{-- Questions 29-30: Choose TWO --}}
    <h4 class="text-lg font-bold mb-2">Questions 29-30</h4>
    <p class="mb-2 text-gray-700 italic">Choose <strong>TWO</strong> letters, <strong>A-E</strong>.</p>
    <p class="mb-6 text-gray-700">Which <strong>TWO</strong> of the following points does the tutor warn student’s research work?</p>

    <div class="mb-4 space-y-2 pl-2">
        @foreach(['A' => 'interviewees', 'B' => 'make data clearly', 'C' => 'time arrangement', 'D' => 'reference books', 'E' => 'questionnaire design'] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
            <input type="checkbox" name="answers_multi[29_30][]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer rounded">
            <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
        </label>
        @endforeach
        <p class="text-xs text-gray-400 mt-2 italic">Select exactly 2 answers for Q29-30.</p>
    </div>
</div>
