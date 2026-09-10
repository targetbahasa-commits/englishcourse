<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-23: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-23</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; Information on the test is from</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'the teacher.', 'B' => 'a class.', 'C' => 'a handout.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; This assignment is important because</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'it will become a permanent record.', 'B' => 'it is a must for passing 11th grade English.', 'C' => 'it will affect the English level next year.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; Bobby chooses football as project topic because</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'he often plays football.', 'B' => 'his father loves football.', 'C' => 'he is interested in football.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Questions 24-30: Matching Features (A-H) --}}
    <h4 class="text-lg font-bold mb-2">Questions 24-30</h4>
    <p class="mb-2 text-gray-700">What problems do the speakers identify for this project?</p>
    <p class="mb-4 text-gray-700 italic">Choose <strong>SEVEN</strong> answers from the box and write the letters, <strong>A-H</strong>, next to questions <strong>24-30</strong>.</p>

    <div class="mb-6">
        <p class="font-bold text-gray-800 mb-3">Problems</p>
        <div class="grid grid-cols-2 gap-x-8 gap-y-1 pl-4 text-gray-700">
            <p><strong>A</strong>&nbsp;&nbsp; too vague</p>
            <p><strong>E</strong>&nbsp;&nbsp; too long</p>
            <p><strong>B</strong>&nbsp;&nbsp; too factual</p>
            <p><strong>F</strong>&nbsp;&nbsp; too short</p>
            <p><strong>C</strong>&nbsp;&nbsp; too unreliable</p>
            <p><strong>G</strong>&nbsp;&nbsp; too complicated</p>
            <p><strong>D</strong>&nbsp;&nbsp; too noisy</p>
            <p><strong>H</strong>&nbsp;&nbsp; too simple</p>
        </div>
    </div>

    @php
        $items = [
            24 => 'Background sounds',
            25 => 'Answers of questions',
            26 => 'One of the questions',
            27 => 'Time of answering',
            28 => 'Recording equipment',
            29 => 'Topic of project',
            30 => 'Report on project',
        ];
    @endphp

    <div class="space-y-4">
        @foreach($items as $q => $label)
        <div class="flex items-center gap-4 flex-wrap">
            <span class="font-medium text-gray-700 w-60"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
            <select name="answers[{{ $q }}]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-2 bg-white cursor-pointer rounded text-gray-700 w-36">
                <option value="" disabled selected>Select...</option>
                @foreach(['A','B','C','D','E','F','G','H'] as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        </div>
        @endforeach
    </div>
</div>
