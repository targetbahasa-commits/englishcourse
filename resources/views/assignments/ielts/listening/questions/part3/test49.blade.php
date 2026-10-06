<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 3</h3>

    {{-- Questions 21-25: Multiple Choice --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 21-25</h4>
            <p class="text-gray-600 font-medium mt-1">Choose the correct letter, <strong class="text-gray-900">A</strong>, <strong class="text-gray-900">B</strong> or <strong class="text-gray-900">C</strong>.</p>
        </div>

        {{-- Q21 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">21</span> Why did Anita and Lee choose to talk about John Chapman?</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="A" {{ old('answers.21') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">He was Lee’s childhood hero.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="B" {{ old('answers.21') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">They wanted to talk about the USA.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="C" {{ old('answers.21') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">He was relevant to the topic of their studies.</span>
                </label>
            </div>
        </div>

        {{-- Q22 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">22</span> Where did the students record their sources of information?</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="A" {{ old('answers.22') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">on their laptops</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="B" {{ old('answers.22') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">on a handout</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="C" {{ old('answers.22') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">on a database</span>
                </label>
            </div>
        </div>

        {{-- Q23 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">23</span> The tutor claims she does not understand whether</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="A" {{ old('answers.23') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">apples grew in America before Europeans arrived.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="B" {{ old('answers.23') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">the Native Americans had always eaten apples.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="C" {{ old('answers.23') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">American apples were first bred in Europe.</span>
                </label>
            </div>
        </div>

        {{-- Q24 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">24</span> The tutor says the audience was particularly interested to hear about</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="A" {{ old('answers.24') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">grafting techniques in ancient China.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="B" {{ old('answers.24') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">the cultivation of apples in Kazakhstan.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="C" {{ old('answers.24') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">the spread of apples along the Silk Route.</span>
                </label>
            </div>
        </div>

        {{-- Q25 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">25</span> How will Anita and Lee present their follow-up work?</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="A" {{ old('answers.25') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">on the department website</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="B" {{ old('answers.25') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">as a paper</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="C" {{ old('answers.25') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">as a poster</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Questions 26-30: Matching --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 26-30</h4>
            <p class="text-gray-600 font-medium mt-1">What do Lee and Anita agree about their presentation skills with their tutor?</p>
            <p class="text-gray-600 font-medium">Write the correct letter, <strong class="text-gray-900">A</strong>, <strong class="text-gray-900">B</strong> or <strong class="text-gray-900">C</strong> next to questions 26-30.</p>
        </div>

        {{-- Options Box --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 max-w-sm mx-auto text-center">
            <h5 class="font-bold text-gray-800 mb-2 text-xs uppercase tracking-wide">Options</h5>
            <div class="flex justify-around text-sm font-semibold text-gray-800">
                <div><span class="font-bold text-gray-900 mr-1">A</span> excellent</div>
                <div><span class="font-bold text-gray-900 mr-1">B</span> acceptable</div>
                <div><span class="font-bold text-gray-900 mr-1">C</span> poor</div>
            </div>
        </div>

        <div class="space-y-3 max-w-xl mx-auto pt-2">
            <h5 class="font-bold text-gray-800 text-base mb-2">Presentation skills</h5>

            @php
                $skills = [
                    26 => 'use of equipment',
                    27 => 'handling software',
                    28 => 'timing of sections',
                    29 => 'design of handout',
                    30 => 'clarity of speech'
                ];
            @endphp

            @foreach($skills as $q => $label)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200 hover:bg-gray-100/70 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-gray-900 text-lg w-6">{{ $q }}</span>
                        <span class="text-gray-800 font-medium text-base">{{ $label }}</span>
                    </div>
                    <select name="answers[{{ $q }}]" class="border border-gray-300 focus:border-black outline-none px-4 py-1.5 rounded-lg font-bold bg-white text-gray-800 transition-colors cursor-pointer">
                        <option value="" disabled {{ old("answers.$q") ? '' : 'selected' }}>Select</option>
                        @foreach(['A','B','C'] as $opt)
                            <option value="{{ $opt }}" {{ old("answers.$q") == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
    </div>
</div>