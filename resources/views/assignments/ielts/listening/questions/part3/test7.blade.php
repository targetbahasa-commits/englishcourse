<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-23: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-23</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; The proposal will</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'be reviewed by two examiners.', 'B' => 'be added to the final grade.', 'C' => 'be returned with feedback.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; The proposal will consist mostly of</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'topics', 'B' => 'methods', 'C' => 'results'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; For the practice paper, the tutor has directed the students to make sure to</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'pay attention to time limits.', 'B' => 'write at least 6,000 words.', 'C' => 'keep on topic.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 24-30: Sentence Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 24-30</h4>
    <p class="mb-2 text-gray-700">Complete the sentences below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD AND/OR A NUMBER</strong> for each answer.</p>

    <div class="space-y-6 max-w-2xl text-gray-700">

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>There is no need to</span>
            <strong class="text-blue-600">24</strong>
            <input type="text" name="answers[24]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>lots of people.</span>
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>Pay attention to the</span>
            <strong class="text-blue-600">25</strong>
            <input type="text" name="answers[25]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>of the final report.</span>
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>Prepare two</span>
            <strong class="text-blue-600">26</strong>
            <input type="text" name="answers[26]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>, one for the teacher, another for the students themselves.</span>
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>The deadline of the final paper is</span>
            <strong class="text-blue-600">27</strong>
            <input type="text" name="answers[27]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>The students can</span>
            <strong class="text-blue-600">28</strong>
            <input type="text" name="answers[28]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>their topics before the beginning of April.</span>
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>Students deciding to change topics must deliver a</span>
            <strong class="text-blue-600">29</strong>
            <input type="text" name="answers[29]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>to the teacher in advance.</span>
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>At the beginning of the report, the hypothesis and an outline of the</span>
            <strong class="text-blue-600">30</strong>
            <input type="text" name="answers[30]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>are needed.</span>
        </div>

    </div>
</div>
