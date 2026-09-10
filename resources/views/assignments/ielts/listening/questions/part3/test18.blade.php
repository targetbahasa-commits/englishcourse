<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-27: Notes Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-27</h4>
    <p class="mb-2 text-gray-700">Complete the notes below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN THREE WORDS OR A NUMBER</strong> for each answer.</p>

    <div class="border border-gray-300 rounded-lg p-5 max-w-2xl bg-white mb-12 text-gray-700 space-y-5">

        <h5 class="text-center font-bold text-gray-800 text-base">Computer Labs</h5>
        <p>The 4 labs below can be used by undergraduates.</p>
        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.6rem;">
            <span>Other computer labs can only be used by postgraduates and</span>
            <strong class="text-blue-600">21</strong>
            <input type="text" name="answers[21]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

        {{-- Lab Locations Table --}}
        <div>
            <table class="w-full border-collapse border border-gray-300 text-sm mt-2">
                <thead>
                    <tr class="bg-white">
                        <th class="border border-gray-300 px-3 py-2 text-left font-bold">Lab</th>
                        <th class="border border-gray-300 px-3 py-2 text-left font-bold">Locations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 px-3 py-2">Wimborne</td>
                        <td class="border border-gray-300 px-3 py-2">Johnson Building</td>
                    </tr>
                    <tr class="bg-white">
                        <td class="border border-gray-300 px-3 py-2">Franklin</td>
                        <td class="border border-gray-300 px-3 py-2">Computer Sciences Building</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-3 py-2">Salisbury</td>
                        <td class="border border-gray-300 px-3 py-2">
                            <div class="flex items-center gap-2">
                                <strong class="text-blue-600">22</strong>
                                <input type="text" name="answers[22]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent" placeholder="............" autocomplete="off" />
                            </div>
                        </td>
                    </tr>
                    <tr class="bg-white">
                        <td class="border border-gray-300 px-3 py-2">Court</td>
                        <td class="border border-gray-300 px-3 py-2">Johnson Building</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Reservations --}}
        <div class="space-y-2">
            <p class="font-semibold text-gray-800">Reservations</p>
            <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.6rem;">
                <strong class="text-blue-600">23</strong>
                <input type="text" name="answers[23]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
                <span>a day unless computers are free</span>
            </div>
            <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.6rem;">
                <span>Write reservation in book</span>
                <strong class="text-blue-600">24</strong>
                <input type="text" name="answers[24]" class="w-32 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            </div>
            <p class="text-xs text-gray-500 italic">(Penalty for erasing someone else's reservation – 1 year ban)</p>
        </div>

        {{-- Login Info --}}
        <div class="space-y-1">
            <p><span class="font-semibold">User Name</span>&nbsp;&nbsp; jamessmith2</p>
            <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.6rem;">
                <span class="font-semibold">Password</span>
                <strong class="text-blue-600">25</strong>
                <input type="text" name="answers[25]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            </div>
        </div>

        {{-- Printing --}}
        <div>
            <p class="font-semibold text-gray-800 mb-1">Printing</p>
            <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.6rem;">
                <span>Pick up print outs from</span>
                <strong class="text-blue-600">26</strong>
                <input type="text" name="answers[26]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
                <span>in Franklin</span>
            </div>
        </div>

        {{-- Costs --}}
        <div>
            <p class="font-semibold text-gray-800 mb-1">Costs</p>
            <div class="flex items-baseline gap-2">
                <strong class="text-blue-600">27</strong>
                <input type="text" name="answers[27]" class="w-48 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            </div>
        </div>

    </div>

    {{-- Questions 28-30: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 28-30</h4>
    <p class="mb-6 text-gray-700">Choose the correct letters <strong>A</strong>, <strong>B</strong>, <strong>C</strong>.</p>

    <div class="space-y-8">

        {{-- Q28 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">28</strong>&nbsp; The introductory computer course that James decides to take is…</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'beginner', 'B' => 'intermediate', 'C' => 'advanced'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[28]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q29 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">29</strong>&nbsp; The computer laboratory for James' introductory computer course is in…</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'Wimborne', 'B' => 'Franklin', 'C' => 'Court'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[29]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q30 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">30</strong>&nbsp; James will take his introductory computer course…</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'on Thursday at 2.00pm', 'B' => 'on Tuesday at 4.30pm.', 'C' => 'on Tuesday at 5.00pm'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[30]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>
</div>
