<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-25: Sentence Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-25</h4>
    <p class="mb-2 text-gray-700">Complete the following sentences using <strong>NO MORE THAN TWO WORDS</strong> for each gap.</p>

    <div class="space-y-6 max-w-2xl text-gray-700 mb-12">

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>Melissa's first tip is not to</span>
            <strong class="text-blue-600">21</strong>
            <input type="text" name="answers[21]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>late</span>
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>Simona says that a presenter should not</span>
            <strong class="text-blue-600">22</strong>
            <input type="text" name="answers[22]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>David explains that the second "P" in PGP means</span>
            <strong class="text-blue-600">23</strong>
            <input type="text" name="answers[23]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>David says PGP will</span>
            <strong class="text-blue-600">24</strong>
            <input type="text" name="answers[24]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            <span>and promote retention.</span>
        </div>

        <div class="flex items-baseline gap-2 flex-wrap" style="line-height: 2.8rem;">
            <span>Carlos offers a general piece of advice for public speaking, which is know your</span>
            <strong class="text-blue-600">25</strong>
            <input type="text" name="answers[25]" class="w-40 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>

    </div>

    {{-- Questions 26-30: Identifying Speakers (A, B, C, D) --}}
    <h4 class="text-lg font-bold mb-2">Questions 26-30</h4>
    <p class="mb-2 text-gray-700">Identify which speaker is being referred to in each statement.</p>
    <p class="mb-4 text-gray-700 italic">Write the corresponding letter <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong> on your answer sheet.</p>

    <div class="mb-6 grid grid-cols-1 gap-y-1 pl-4 text-gray-700 max-w-xs">
        <p><strong>A</strong>&nbsp;&nbsp; Carlos</p>
        <p><strong>B</strong>&nbsp;&nbsp; David</p>
        <p><strong>C</strong>&nbsp;&nbsp; Melissa</p>
        <p><strong>D</strong>&nbsp;&nbsp; Simona</p>
    </div>

    @php
        $items = [
            26 => 'He/She thinks an overhead projector is usually needed.',
            27 => 'He/She mentions that jokes can be useful in context.',
            28 => 'He/She mentions that the question and answer part is very important.',
            29 => 'He/She says that finishing early might be a good idea.',
            30 => 'He/She says that you should drink enough.',
        ];
    @endphp

    <div style="display: grid; grid-template-columns: auto 120px; gap: 0.75rem 1rem; align-items: center; max-width: 600px;">
        @foreach($items as $q => $label)
            <span class="font-medium text-gray-700"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
            <select name="answers[{{ $q }}]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-2 bg-white cursor-pointer rounded text-gray-700 w-28 justify-self-end">
                <option value="" disabled selected>Select...</option>
                @foreach(['A','B','C','D'] as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        @endforeach
    </div>
</div>
