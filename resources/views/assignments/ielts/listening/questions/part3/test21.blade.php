<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-26: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-26</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; What kind of research method does the professor recommend?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'interview', 'B' => 'observation', 'C' => 'questionnaire'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; What is the project based on?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'a study they did before in Australia', 'B' => 'a similar angle someone has done before', 'C' => 'an Australian study'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; What does the professor advise Douglas to do about the formation of the focus groups?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'strengthen the group in size', 'B' => 'reduce the number of children in each group', 'C' => 'build more than 3 groups'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; To do the project best, the professor suggests the students</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'interview various people or sectors.', 'B' => 'not be too ambitious.', 'C' => 'work hard enough.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; To gather data, the professor asks Jane</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => "to replace other people's advice.", 'B' => 'to simplify the textbook.', 'C' => 'to practice using the date table.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q26 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">26</strong>&nbsp; The reason why Douglas hasn't read enough reference books is that</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => "he doesn't have enough time.", 'B' => 'he thinks there are too many books to read.', 'C' => "he hasn't spent time in the library."] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[26]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 27-30: Matching (A, B, C) --}}
    <h4 class="text-lg font-bold mb-2">Questions 27-30</h4>
    <p class="mb-2 text-gray-700">What do the students decide about the following parts of the project?</p>
    <p class="mb-4 text-gray-700 italic">Write the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>, next to questions <strong>27-30</strong>.</p>

    <div class="mb-6 grid grid-cols-1 gap-y-1 pl-4 text-gray-700 max-w-xs">
        <p><strong>A</strong>&nbsp;&nbsp; Jane will do</p>
        <p><strong>B</strong>&nbsp;&nbsp; Douglas will do</p>
        <p><strong>C</strong>&nbsp;&nbsp; They will do together</p>
    </div>

    @php
        $items = [
            27 => 'final report',
            28 => 'sheet preparation',
            29 => 'letter',
            30 => 'transcript',
        ];
    @endphp

    <div style="display: grid; grid-template-columns: 200px auto; gap: 0.75rem 1rem; align-items: center; max-width: 400px;">
        @foreach($items as $q => $label)
            <span class="font-medium text-gray-700"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
            <select name="answers[{{ $q }}]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-2 bg-white cursor-pointer rounded text-gray-700 w-36">
                <option value="" disabled selected>Select...</option>
                @foreach(['A','B','C'] as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        @endforeach
    </div>
</div>
