<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-23: Choose THREE letters A-G --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-23</h4>
    <p class="mb-2 text-gray-700">Choose <strong>THREE</strong> letters, <strong>A-G</strong>.</p>
    <p class="mb-6 text-gray-700">Which THREE factors should the student consider while selecting courses?</p>

    <div class="mb-12 space-y-2 pl-2">
        @foreach(['A' => 'class time', 'B' => 'course topic', 'C' => 'amount of homework', 'D' => 'ease of course', 'E' => 'relevant to future career', 'F' => 'course structure', 'G' => 'professor reputation'] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
            <input type="checkbox" name="answers_multi[21_23][]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer rounded">
            <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
        </label>
        @endforeach
        <p class="text-xs text-gray-400 mt-2 italic">Select exactly 3 answers for Q21-23.</p>
    </div>

    {{-- Questions 24-27: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 24-27</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; The tutor recommends against taking Human Physiology because it would not be the best</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'time management.', 'B' => 'chance at earning an A.', 'C' => 'topic for a research paper.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; The student decides to do a dissertation because</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'he takes it to boost his GPA.', 'B' => 'he likes to develop more supportive details.', 'C' => 'he wants to conduct more interviews.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q26 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">26</strong>&nbsp; The student thought the research paper was</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'already completed.', 'B' => 'worth finishing.', 'C' => 'too complicated.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[26]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q27 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">27</strong>&nbsp; The method of data collection was</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'interviews', 'B' => 'lab studies.', 'C' => 'questionnaires'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[27]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 28-30: Sentence Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 28-30</h4>
    <p class="mb-2 text-gray-700">Complete the sentences below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <div class="space-y-6 max-w-2xl text-gray-700">

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>First draft should be finished by the end of</span>
            <strong class="text-blue-600">28</strong>
            <input type="text" name="answers[28]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>Dissertation should be registered with the</span>
            <strong class="text-blue-600">29</strong>
            <input type="text" name="answers[29]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>in the Department Office.</span>
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>The student can get the relevant database from the</span>
            <strong class="text-blue-600">30</strong>
            <input type="text" name="answers[30]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>Office.</span>
        </div>

    </div>
</div>
