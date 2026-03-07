<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-25: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-25</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; Nicole received the best information from the</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'staff.', 'B' => 'students.', 'C' => 'cleaners.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; The product used most wastefully was</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'copying paper.', 'B' => 'plastic.', 'C' => 'paper plates and cups.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; The proportion of interviewed people who expressed concern over waste was</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => '30%.', 'B' => '45%.', 'C' => '55%.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; The proportion who claim they take action over this problem was</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => '10%.', 'B' => 'one third', 'C' => 'one half.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; Nicole thinks many people do nothing because they are</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'lazy.', 'B' => 'uncaring.', 'C' => 'uninformed.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 26-30: Flowchart Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 26-30</h4>
    <p class="mb-2 text-gray-700">Complete the flowchart.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <div class="max-w-xl mx-auto">
        <h5 class="text-center text-lg font-bold mb-6">Procedure to Reduce Copying Waste</h5>

        {{-- Step 26 --}}
        <div class="text-center mb-2 text-gray-700">
            <strong class="text-blue-600">26</strong>
            <input type="text" name="answers[26]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors text-center" placeholder="............" autocomplete="off" />
            that the staff do double-sided copying.
        </div>
        <div class="text-center text-2xl text-gray-500 mb-2">↓</div>

        {{-- Step 27 --}}
        <div class="text-center mb-2 text-gray-700">
            Unwanted copies are
            <strong class="text-blue-600">27</strong>
            <input type="text" name="answers[27]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors text-center" placeholder="............" autocomplete="off" />
            into a special recycling tray.
        </div>
        <div class="text-center text-2xl text-gray-500 mb-2">↓</div>

        {{-- Step 28 --}}
        <div class="text-center mb-2 text-gray-700">
            <strong class="text-blue-600">28</strong>
            <input type="text" name="answers[28]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors text-center" placeholder="............" autocomplete="off" />
            these clearly, for easy reuse.
        </div>
        <div class="text-center text-2xl text-gray-500 mb-2">↓</div>

        {{-- Static step --}}
        <div class="text-center mb-2 text-gray-600">
            Stack them in a special copying tray each morning.
        </div>
        <div class="text-center text-2xl text-gray-500 mb-2">↓</div>

        {{-- Step 29 --}}
        <div class="text-center mb-2 text-gray-700">
            <strong class="text-blue-600">29</strong>
            <input type="text" name="answers[29]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors text-center" placeholder="............" autocomplete="off" />
            codes which allow each user to access this tray.
        </div>
        <div class="text-center text-2xl text-gray-500 mb-2">↓</div>

        {{-- Step 30 --}}
        <div class="text-center mb-2 text-gray-700">
            Give highest users a
            <strong class="text-blue-600">30</strong>
            <input type="text" name="answers[30]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors text-center" placeholder="............" autocomplete="off" />
            (e.g. cinema tickets).
        </div>
    </div>
</div>
