<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-26: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-26</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; The subjects in questionnaire are</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'tourists in the hotel in this area.', 'B' => 'local residents.', 'C' => 'people who are living in this area.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; The results of the questionnaire should be</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'directly entered into the computer.', 'B' => 'scored by hand.', 'C' => 'submitted directly to Professor Curran.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; Why should John give a copy of plans to the professor?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'to receive a good grade', 'B' => 'to get advice', 'C' => 'to earn high praise'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; How will the instructions be presented?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'given by a group representative', 'B' => 'given by all members of the group', 'C' => 'given by the professor'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; What does Dani suggest to John when those subjects receive the questionnaire?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'divide into 2 parts to argue', 'B' => 'focus on the opinion of the interviewees', 'C' => 'take consideration of both sides'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q26 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">26</strong>&nbsp; Why is this project particularly important to John?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'to earn respect from professors in the department', 'B' => 'to raise his grade', 'C' => 'to impress his professor'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[26]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 27-30: Matching Features (A-F) --}}
    <h4 class="text-lg font-bold mb-2">Questions 27-30</h4>
    <p class="mb-2 text-gray-700">What is the source of each one below in this survey?</p>
    <p class="mb-4 text-gray-700 italic">Choose <strong>FOUR</strong> answers from the box and write the correct letter, <strong>A-F</strong>, next to questions <strong>27-30</strong>.</p>

    <div class="mb-6 grid grid-cols-2 gap-x-8 gap-y-1 pl-4 text-gray-700 max-w-sm">
        <p><strong>A</strong>&nbsp;&nbsp; radio</p>
        <p><strong>D</strong>&nbsp;&nbsp; newspaper</p>
        <p><strong>B</strong>&nbsp;&nbsp; council meeting</p>
        <p><strong>E</strong>&nbsp;&nbsp; journal</p>
        <p><strong>C</strong>&nbsp;&nbsp; the television</p>
        <p><strong>F</strong>&nbsp;&nbsp; the Internet</p>
    </div>

    @php
        $items = [
            27 => 'Map',
            28 => 'Photo',
            29 => 'Budget',
            30 => 'Comment',
        ];
    @endphp

    <div class="space-y-4">
        @foreach($items as $q => $label)
        <div class="flex items-center gap-4">
            <span class="font-medium text-gray-700 w-40"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
            <select name="answers[{{ $q }}]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-2 bg-white cursor-pointer rounded text-gray-700 w-36">
                <option value="" disabled selected>Select...</option>
                @foreach(['A','B','C','D','E','F'] as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        </div>
        @endforeach
    </div>
</div>
