<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-25: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-25</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; Which part has the tutor already read?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'the introductory chapter', 'B' => 'the procedure section', 'C' => 'the results and discussion section'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; Which part of the paper did the tutor like?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'introduction', 'B' => 'layout', 'C' => 'background information'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; Kathy and the tutor both agree to continue to</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'refer a lot to the example received in class.', 'B' => 'copy the information.', 'C' => 'conduct further research in the library.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; Kathy asks the tutor for help with the ………….. section.</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'abstract', 'B' => 'bibliography', 'C' => 'appendix'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; What will Kathy do next?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'try out software', 'B' => 'work on the bibliography', 'C' => 'make an animation'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 26-30: Matching Features (A-F) --}}
    <h4 class="text-lg font-bold mb-2">Questions 26-30</h4>
    <p class="mb-2 text-gray-700">What is the desired outcome to each of the following course of action?</p>
    <p class="mb-4 text-gray-700 italic">Choose <strong>FIVE</strong> answers from the box and write the correct letter, <strong>A-F</strong>, next to questions <strong>26-30</strong>.</p>

    <div class="mb-6">
        <p class="font-bold text-gray-800 mb-3">Desired outcomes</p>
        <div class="grid grid-cols-2 gap-x-8 gap-y-1 pl-4 text-gray-700 max-w-md">
            <p><strong>A</strong>&nbsp;&nbsp; practical experience</p>
            <p><strong>D</strong>&nbsp;&nbsp; give suggestions</p>
            <p><strong>B</strong>&nbsp;&nbsp; publish the work</p>
            <p><strong>E</strong>&nbsp;&nbsp; stay up to date</p>
            <p><strong>C</strong>&nbsp;&nbsp; join Machine Engineer Society</p>
            <p><strong>F</strong>&nbsp;&nbsp; make important contacts</p>
        </div>
    </div>

    @php
        $items = [
            26 => 'Make a good grade',
            27 => 'Meet engineering professionals',
            28 => 'Visit the factory',
            29 => 'Seek summer internships',
            30 => 'Present dissertation',
        ];
    @endphp

    <div class="space-y-4">
        @foreach($items as $q => $label)
        <div class="flex items-center gap-4">
            <span class="font-medium text-gray-700 w-60"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
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
