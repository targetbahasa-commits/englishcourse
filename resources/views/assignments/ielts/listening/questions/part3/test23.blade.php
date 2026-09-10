<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-24: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-24</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; The course has improved the environment since</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'it was regulated by law.', 'B' => 'more students were involved.', 'C' => 'more species were brought from other places.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; What is the biggest reason why the organisation improved greatly?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'It was funded by a private investor', 'B' => 'It sold out its shares.', 'C' => 'It got the governmental fund in the first year.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; What is suggested from the reports?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'Resources still need management.', 'B' => 'Teachers and the students have benefitted from the field trips.', 'C' => 'The environment has been terribly damaged.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; Who did obtain the special experience from the field trip carried out by the organisation?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'students', 'B' => 'teachers', 'C' => 'researchers'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 25-26: Choose TWO --}}
    <h4 class="text-lg font-bold mb-2">Questions 25-26</h4>
    <p class="mb-2 text-gray-700 italic">Choose <strong>TWO</strong> letters, <strong>A-E</strong>.</p>
    <p class="mb-6 text-gray-700">What <strong>TWO</strong> problems does the report focus on?</p>

    <div class="mb-10 space-y-2 pl-2">
        @foreach(['A' => 'air pollution', 'B' => 'soil erosion', 'C' => 'overgrazing', 'D' => 'forest exploitation', 'E' => 'water pollution'] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
            <input type="checkbox" name="answers_multi[25_26][]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer rounded">
            <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
        </label>
        @endforeach
        <p class="text-xs text-gray-400 mt-2 italic">Select exactly 2 answers for Q25-26.</p>
    </div>

    {{-- Questions 27-28: Choose TWO --}}
    <h4 class="text-lg font-bold mb-2">Questions 27-28</h4>
    <p class="mb-2 text-gray-700 italic">Choose <strong>TWO</strong> letters, <strong>A-E</strong>.</p>
    <p class="mb-6 text-gray-700">Which <strong>TWO</strong> benefits of this activity to the students are mentioned by the professor?</p>

    <div class="mb-10 space-y-2 pl-2">
        @foreach(['A' => 'They become more punctual.', 'B' => 'They feel more confident.', 'C' => 'They get practical experience.', 'D' => 'They learn how to collect data.', 'E' => 'They know the importance of environment protection.'] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
            <input type="checkbox" name="answers_multi[27_28][]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer rounded">
            <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
        </label>
        @endforeach
        <p class="text-xs text-gray-400 mt-2 italic">Select exactly 2 answers for Q27-28.</p>
    </div>

    {{-- Questions 29-30: Choose TWO --}}
    <h4 class="text-lg font-bold mb-2">Questions 29-30</h4>
    <p class="mb-2 text-gray-700 italic">Choose <strong>TWO</strong> letters, <strong>A-E</strong>.</p>
    <p class="mb-6 text-gray-700">What <strong>TWO</strong> things will the woman do in the rest of the time when no activities are going on?</p>

    <div class="mb-4 space-y-2 pl-2">
        @foreach(['A' => 'read more reference books', 'B' => 'study in library', 'C' => 'interview some teachers', 'D' => 'participate in one of fun hobbies', 'E' => 'join in some tutorials'] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
            <input type="checkbox" name="answers_multi[29_30][]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer rounded">
            <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
        </label>
        @endforeach
        <p class="text-xs text-gray-400 mt-2 italic">Select exactly 2 answers for Q29-30.</p>
    </div>
</div>
