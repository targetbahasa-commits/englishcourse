<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-23: Table Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-23</h4>
    <p class="mb-2 text-gray-700">Complete the table below.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD ONLY</strong> for each answer.</p>

    <div class="overflow-x-auto mb-12">
        <table class="w-full border-collapse border border-gray-300 text-gray-700">
            <thead>
                <tr class="bg-white">
                    <th class="border border-gray-300 px-4 py-3 text-center font-bold" colspan="2">
                        Research about different energy-saving innovations
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-4 py-4 w-1/3">Kites in Germany</td>
                    <td class="border border-gray-300 px-4 py-4">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>used in different</span>
                            <strong class="text-blue-600">21</strong>
                            <input type="text" name="answers[21]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                            <span>conditions to reduce the emission of toxic gas</span>
                        </div>
                    </td>
                </tr>
                <tr class="bg-white">
                    <td class="border border-gray-300 px-4 py-4">Vehicles in America</td>
                    <td class="border border-gray-300 px-4 py-4">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>powered by</span>
                            <strong class="text-blue-600">22</strong>
                            <input type="text" name="answers[22]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-4">Gas canister in South Africa</td>
                    <td class="border border-gray-300 px-4 py-4">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>invented to reduce its chances to</span>
                            <strong class="text-blue-600">23</strong>
                            <input type="text" name="answers[23]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Questions 24-25: Choose TWO letters A-E --}}
    <h4 class="text-lg font-bold mb-2">Questions 24-25</h4>
    <p class="mb-2 text-gray-700 italic">Choose <strong>TWO</strong> letters, <strong>A-E</strong>.</p>
    <p class="mb-6 text-gray-700">Which <strong>TWO</strong> types of interviewees do Greg and Syria choose to do the survey?</p>

    <div class="mb-12 space-y-2 pl-2">
        @foreach(['A' => 'staff on campus', 'B' => 'professors', 'C' => 'local residents', 'D' => 'companies', 'E' => 'university students'] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
            <input type="checkbox" name="answers_multi[24_25][]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer rounded">
            <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
        </label>
        @endforeach
        <p class="text-xs text-gray-400 mt-2 italic">Select exactly 2 answers for Q24-25.</p>
    </div>

    {{-- Questions 26-30: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 26-30</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, or <strong>C</strong>.</p>

    <div class="space-y-8">

        {{-- Q26 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">26</strong>&nbsp; What does Syria think about renewable energy?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'Most people know very little about renewable energy.', 'B' => 'The general public can distinguish different kinds of renewable energy.', 'C' => 'The majority of people feel the need to replace fossil fuels with renewable energy.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[26]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q27 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">27</strong>&nbsp; What do the speakers say about modern windmills?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'They can be used to pump water from wells.', 'B' => 'The location to build them should be carefully chosen.', 'C' => 'Farmers use them to grind grain.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[27]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q28 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">28</strong>&nbsp; What aspect of traditional fuels are they going to address?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'how to avoid fossil fuels from being depleted', 'B' => 'the possible future of traditional resources', 'C' => 'how to prevent pollution of traditional resources'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[28]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q29 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">29</strong>&nbsp; What does Greg say about nuclear plants?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'They are cleaner and less expensive than fossil fuel.', 'B' => 'It is the best way to fight climate change.', 'C' => 'Few people think they are safe.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[29]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q30 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">30</strong>&nbsp; What does Syria think of hydrogen fuel?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'The price of it will drop eventually.', 'B' => 'It entails environmental problems.', 'C' => 'The benefits of it overweigh its high cost.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[30]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>
</div>
