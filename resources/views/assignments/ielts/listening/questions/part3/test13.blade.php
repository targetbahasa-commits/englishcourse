<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-24: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-24</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; How old are the students on the nursing program?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'They are teenagers.', 'B' => 'They are in their twenties.', 'C' => 'They belong to different age groups.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; What do the speakers say about the group project?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'It helps to improve relationship among different classmates.', 'B' => 'It helps to develop problem solving skills.', 'C' => 'It provides supportive learning environment.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; Which part of the program surprised Paul?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => "There's a number of essays to write.", 'B' => "There's a lot of practical work.", 'C' => "There's internship provided."] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; What do they feel about learning law?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'It is essential training.', 'B' => 'It is too theoretical.', 'C' => 'It takes up too much time.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 25-30: Matching Features (A-H) --}}
    <h4 class="text-lg font-bold mb-2">Questions 25-30</h4>
    <p class="mb-2 text-gray-700">What are the suggestions offered by the speakers?</p>
    <p class="mb-4 text-gray-700 italic">Choose <strong>SIX</strong> answers from the box and write the correct letter, <strong>A-H</strong>, next to Questions <strong>25-30</strong>.</p>

    <div class="mb-6">
        <div class="grid grid-cols-2 gap-x-8 gap-y-1 pl-4 text-gray-700 max-w-lg">
            <p><strong>A</strong>&nbsp;&nbsp; get feedback from teaching staff</p>
            <p><strong>E</strong>&nbsp;&nbsp; manage time properly</p>
            <p><strong>B</strong>&nbsp;&nbsp; do more reading</p>
            <p><strong>F</strong>&nbsp;&nbsp; be well prepared</p>
            <p><strong>C</strong>&nbsp;&nbsp; get help from school supporting staff</p>
            <p><strong>G</strong>&nbsp;&nbsp; review the notes regularly</p>
            <p><strong>D</strong>&nbsp;&nbsp; get help for nursing problems</p>
            <p><strong>H</strong>&nbsp;&nbsp; don't set unrealistic goals</p>
        </div>
    </div>

    @php
        $items = [
            25 => 'Essays',
            26 => 'Lectures',
            27 => 'Research',
            28 => 'Online forum',
            29 => 'Placement tests',
            30 => 'Freshmen',
        ];
    @endphp

    <div class="space-y-4">
        @foreach($items as $q => $label)
        <div class="flex items-center gap-4">
            <span class="font-medium text-gray-700 w-48"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
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
