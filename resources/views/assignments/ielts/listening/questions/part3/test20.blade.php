<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-25: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-25</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; Why does the student want to study Tourism?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'good future', 'B' => 'good pay', 'C' => "parents' will"] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; What kind of skill will the student gain in the course?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'time-management', 'B' => 'financial planning', 'C' => 'note-taking'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; The student has the ability of</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'independence.', 'B' => 'communication', 'C' => 'coping well with statistics.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; The teacher believes that the industry of tourism is</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'shrinking', 'B' => 'seeing a bright future.', 'C' => 'growing popular.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; How does the student compare the university course with polytechnics?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'There are summer schools.', 'B' => 'The course is structured in modules.', 'C' => 'The price is reasonable.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 26-30: Matching Features (A-G) --}}
    <h4 class="text-lg font-bold mb-2">Questions 26-30</h4>
    <p class="mb-2 text-gray-700">What feature do the speakers identify for each of the following courses?</p>
    <p class="mb-4 text-gray-700 italic">Choose <strong>FIVE</strong> answers from the box and write the correct letters, <strong>A-G</strong>, next to questions <strong>26-30</strong>.</p>

    <div class="mb-6">
        <p class="font-bold text-gray-800 mb-3">Features</p>
        <div class="grid grid-cols-2 gap-x-8 gap-y-1 pl-4 text-gray-700 max-w-lg">
            <p><strong>A</strong>&nbsp;&nbsp; limited value</p>
            <p><strong>E</strong>&nbsp;&nbsp; intensive</p>
            <p><strong>B</strong>&nbsp;&nbsp; useful</p>
            <p><strong>F</strong>&nbsp;&nbsp; improving leadership</p>
            <p><strong>C</strong>&nbsp;&nbsp; relevant to career</p>
            <p><strong>G</strong>&nbsp;&nbsp; self-control and time management</p>
            <p><strong>D</strong>&nbsp;&nbsp; flexible admission</p>
        </div>
    </div>

    <p class="font-bold text-gray-800 mb-4">Courses</p>

    @php
        $items = [
            26 => 'Travel and Business',
            27 => 'Japanese',
            28 => 'Medical Care',
            29 => 'Computer',
            30 => 'Public Relations',
        ];
    @endphp

    <div style="display: grid; grid-template-columns: 220px auto; gap: 0.75rem 1rem; align-items: center; max-width: 440px;">
        @foreach($items as $q => $label)
            <span class="font-medium text-gray-700"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
            <select name="answers[{{ $q }}]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-2 bg-white cursor-pointer rounded text-gray-700 w-36">
                <option value="" disabled selected>Select...</option>
                @foreach(['A','B','C','D','E','F','G'] as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        @endforeach
    </div>
</div>
