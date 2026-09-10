<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-22: Graph Labeling --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-22</h4>
    <p class="mb-2 text-gray-700 italic">Choose the correct letters, <strong>A-C</strong>, and write each next to questions <strong>21</strong> and <strong>22</strong>.</p>
    <p class="mb-6 text-gray-700">According to Betty, which lines describe the sales of both <strong>cheese and oil</strong> in <strong>New Zealand</strong> and <strong>Colombia</strong>?</p>

    <!-- Placeholder for the graph image -->
    <div class="mb-8 p-4 bg-white border border-gray-300 rounded max-w-2xl mx-auto flex flex-col items-center justify-center min-h-[300px]">
        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <span class="text-gray-500 font-medium">Sales Volume Graph (Lines A, B, C) Placeholder</span>
    </div>

    <div class="mb-12 space-y-4 max-w-xs pl-2">
        <div class="flex items-center gap-4">
            <span class="font-bold text-blue-600 w-6">21</span>
            <select name="answers[21]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-1 bg-white cursor-pointer rounded text-gray-700 flex-1">
                <option value="" disabled selected>Select...</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>
        <div class="flex items-center gap-4">
            <span class="font-bold text-blue-600 w-6">22</span>
            <select name="answers[22]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-1 bg-white cursor-pointer rounded text-gray-700 flex-1">
                <option value="" disabled selected>Select...</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>
    </div>

    {{-- Questions 23-24: Choose TWO Strategy --}}
    <h4 class="text-lg font-bold mb-2">Questions 23-24</h4>
    <p class="mb-4 text-gray-700 italic">Write the correct letters, <strong>A-E</strong>, next to questions <strong>23-24</strong>.</p>
    <p class="mb-6 text-gray-700">Which <strong>TWO</strong> of the following are sales strategies for chocolate in Italy and Germany?</p>

    <div class="mb-12 space-y-2 pl-2">
        @foreach(['A' => 'Locate near a children’s school', 'B' => 'Change the location of the product on shelves', 'C' => 'Give a free gift', 'D' => 'Make it the cheapest brand', 'E' => 'Make Schmutzig the second cheapest brand'] as $letter => $option)
        <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
            <input type="checkbox" name="answers_multi[23_24][]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer rounded">
            <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
        </label>
        @endforeach
        <p class="text-xs text-gray-400 mt-2 italic">Select exactly 2 answers for Q23-24.</p>
    </div>

    {{-- Questions 25-30: Table/Notes Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 25-30</h4>
    <p class="mb-2 text-gray-700">Complete the table below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for each answer.</p>

    <div class="max-w-4xl text-gray-700 bg-white border border-gray-300 rounded-lg p-6 mb-12">
        <h5 class="text-xl font-bold text-center mb-8 text-gray-800">Research plan</h5>

        <div class="space-y-8">

            <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
                <span>Betty is interested in how</span>
                <strong class="text-blue-600">25</strong>
                <input type="text" name="answers[25]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
                <span>affects the sales of cosmetics and</span>
                <strong class="text-blue-600">26</strong>
                <input type="text" name="answers[26]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            </div>

            <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
                <span>Bruce is going to be concerned with how</span>
                <strong class="text-blue-600">27</strong>
                <input type="text" name="answers[27]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
                <span>may impact on sales of cookies and the relationships among</span>
                <strong class="text-blue-600">28</strong>
                <input type="text" name="answers[28]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
                <span>,</span>
                <strong class="text-blue-600">29</strong>
                <input type="text" name="answers[29]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
                <span>, and sales.</span>
            </div>

            <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
                <span>The professor advised the students to bear in mind the extensions of</span>
                <strong class="text-blue-600">30</strong>
                <input type="text" name="answers[30]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            </div>

        </div>
    </div>
</div>
