<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-26: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-26</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, or <strong>C</strong>.</p>

    <div class="bg-white p-4 rounded mb-6 w-fit mx-auto border border-gray-300">
        <p class="font-bold text-gray-800 tracking-wide text-center uppercase">General Course Details</p>
    </div>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; What is the defining characteristic of a specialised course?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'Taking a proficiency exam', 'B' => 'Attending the class frequently', 'C' => 'Compulsory and regular'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; The Microbiology courses are available for</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'full-time and flexible-time students.', 'B' => 'Microbiology students only.', 'C' => 'students on a flexible schedule.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; The Biology courses are available for</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'all students.', 'B' => 'full-time students only.', 'C' => 'freshmen only.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; Who are interested in Microbiology courses?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'People who need work experience', 'B' => 'People from off-campus', 'C' => 'People who work at hospital'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; A Medical Science course will be opened next year because</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'there are no experimental facilities.', 'B' => 'the lab equipment is too expensive.', 'C' => 'the building is damaged.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q26 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">26</strong>&nbsp; Which is the quickest increasing subject in enrolment?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'Medical Science', 'B' => 'Statistics', 'C' => 'Environmental Science'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[26]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 27-29: Choose THREE --}}
    <h4 class="text-lg font-bold mb-2">Questions 27-29</h4>
    <p class="mb-2 text-gray-700 italic">Choose <strong>THREE</strong> letters, <strong>A-G</strong>, and write each next to questions <strong>27-29</strong>.</p>
    <p class="mb-6 text-gray-700">Which <strong>THREE</strong> compulsory courses must be taken?</p>

    <div class="mb-12 space-y-2 pl-2">
        @foreach(['A' => 'Medical Science', 'B' => 'Computing', 'C' => 'Mathematics', 'D' => 'Laboratory Techniques', 'E' => 'Statistics', 'F' => 'Medicine', 'G' => 'Environmental Science'] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
            <input type="checkbox" name="answers_multi[27_29][]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer rounded">
            <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
        </label>
        @endforeach
        <p class="text-xs text-gray-400 mt-2 italic">Select exactly 3 answers for Q27-29.</p>
    </div>

    {{-- Question 30: Sentence Completion --}}
    <h4 class="text-lg font-bold mb-2">Question 30</h4>
    <p class="mb-2 text-gray-700">Complete the sentence below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for the answer.</p>

    <div class="max-w-2xl text-gray-700">
        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>There are three full scholarships that cover tuition and provide $1,500 cash as a</span>
            <strong class="text-blue-600">30</strong>
            <input type="text" name="answers[30]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>
    </div>
</div>
