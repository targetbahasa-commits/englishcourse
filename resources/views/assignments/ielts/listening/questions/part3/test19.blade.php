<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-26: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-26</h4>
    <p class="mb-3 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>
    <p class="mb-6 font-semibold text-gray-800">Reflective Journal Assignment</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; What should be firstly included in the reflective journal?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'topics he is going to talk about', 'B' => 'study aims for the module', 'C' => 'suggestions from others'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; The woman has got</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'a lot of friends to help her.', 'B' => 'several books that may be useful.', 'C' => 'sufficient resources showing that she is a good technology user.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; What was the man's biggest achievement in the past?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'He worked as a waiter in a restaurant.', 'B' => 'He got an offer to lead a team.', 'C' => 'He became the chairman of the Student Union.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; The man decides to</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'do it by himself.', 'B' => 'find a tutor.', 'C' => 'listen to others.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; What is the man's attitude after the discussion?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'He thinks it is useless.', 'B' => 'He is looking forward to doing the assignment.', 'C' => 'He feels uncertain about it.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q26 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">26</strong>&nbsp; What should be shown in the man's reflective journal?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'self-awareness', 'B' => 'mistakes', 'C' => 'achievements'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[26]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 27-30: Matching Features (A-E) --}}
    <h4 class="text-lg font-bold mb-2">Questions 27-30</h4>
    <p class="mb-2 text-gray-700">What is the woman's attitude toward each of the following activities of study?</p>
    <p class="mb-4 text-gray-700 italic">Choose <strong>FOUR</strong> answers from the box and write the correct letter, <strong>A-E</strong>, next to questions <strong>27-30</strong>.</p>

    <div class="mb-6">
        <p class="font-bold text-gray-800 mb-3">Attitude</p>
        <div class="grid grid-cols-2 gap-x-8 gap-y-1 pl-4 text-gray-700 max-w-sm">
            <p><strong>A</strong>&nbsp;&nbsp; define a problem</p>
            <p><strong>D</strong>&nbsp;&nbsp; gain confidence</p>
            <p><strong>B</strong>&nbsp;&nbsp; independent learning</p>
            <p><strong>E</strong>&nbsp;&nbsp; find it difficult</p>
            <p><strong>C</strong>&nbsp;&nbsp; develop study skills</p>
        </div>
    </div>

    @php
        $items = [
            27 => 'writing an essay',
            28 => 'taking exams',
            29 => 'making class notes',
            30 => 'taking presentation notes',
        ];
    @endphp

    <div style="display: grid; grid-template-columns: 240px auto; gap: 0.75rem 1rem; align-items: center; max-width: 460px;">
        @foreach($items as $q => $label)
            <span class="font-medium text-gray-700"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
            <select name="answers[{{ $q }}]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-2 bg-white cursor-pointer rounded text-gray-700 w-36">
                <option value="" disabled selected>Select...</option>
                @foreach(['A','B','C','D','E'] as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        @endforeach
    </div>
</div>
