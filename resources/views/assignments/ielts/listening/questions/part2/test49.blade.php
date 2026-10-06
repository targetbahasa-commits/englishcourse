<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 2</h3>

    {{-- Questions 11-15: Map Labeling --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 11-15</h4>
            <p class="text-gray-600 font-medium mt-1">Label the map below.</p>
            <p class="text-gray-600 font-medium">Choose <strong class="text-gray-900">FIVE</strong> answers from the box and write the correct letter, <strong class="text-gray-900">A-H</strong>, next to questions 11-15.</p>
        </div>

        {{-- Options Box --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 max-w-lg mx-auto">
            <h5 class="font-bold text-gray-800 mb-2 text-center text-sm uppercase tracking-wide">Options</h5>
            <div class="grid grid-cols-2 gap-2 text-sm text-gray-800 pl-4">
                <div><span class="font-bold text-gray-900 mr-2">A</span> biography</div>
                <div><span class="font-bold text-gray-900 mr-2">B</span> fiction</div>
                <div><span class="font-bold text-gray-900 mr-2">C</span> magazines</div>
                <div><span class="font-bold text-gray-900 mr-2">D</span> newspapers</div>
                <div><span class="font-bold text-gray-900 mr-2">E</span> non-fiction</div>
                <div><span class="font-bold text-gray-900 mr-2">F</span> photocopiers</div>
                <div><span class="font-bold text-gray-900 mr-2">G</span> reference books</div>
                <div><span class="font-bold text-gray-900 mr-2">H</span> study area</div>
            </div>
        </div>

        {{-- Map Image --}}
        <div class="my-6 text-center">
            <img src="{{ asset('assets/images/ielts/listening/practice/part2/test49.jpeg') }}" class="max-w-full h-auto mx-auto rounded-xl border border-gray-200 shadow-sm" alt="Selmore Public Library Map">
        </div>

        {{-- Inputs for 11-15 --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 pt-2">
            @for($q = 11; $q <= 15; $q++)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200">
                    <span class="font-bold text-gray-900 text-lg">Question {{ $q }}</span>
                    <select name="answers[{{ $q }}]" class="border border-gray-300 focus:border-black outline-none px-4 py-1.5 rounded-lg font-bold bg-white text-gray-800 transition-colors cursor-pointer">
                        <option value="" disabled {{ old("answers.$q") ? '' : 'selected' }}>Select</option>
                        @foreach(['A','B','C','D','E','F','G','H'] as $letter)
                            <option value="{{ $letter }}" {{ old("answers.$q") == $letter ? 'selected' : '' }}>{{ $letter }}</option>
                        @endforeach
                    </select>
                </div>
            @endfor
        </div>
    </div>

    {{-- Questions 16-20: Multiple Choice --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 16-20</h4>
            <p class="text-gray-600 font-medium mt-1">Choose the correct letter, <strong class="text-gray-900">A</strong>, <strong class="text-gray-900">B</strong> or <strong class="text-gray-900">C</strong>.</p>
        </div>

        {{-- Q16 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">16</span> After two years, library members have to</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[16]" value="A" {{ old('answers.16') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">show proof of their current address.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[16]" value="B" {{ old('answers.16') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">pay for a new membership card.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[16]" value="C" {{ old('answers.16') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">bring a passport or identity card into the library.</span>
                </label>
            </div>
        </div>

        {{-- Q17 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">17</span> What happens if you reserve a book?</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[17]" value="A" {{ old('answers.17') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">It will be available after five days.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[17]" value="B" {{ old('answers.17') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">You can collect It a week later.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[17]" value="C" {{ old('answers.17') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">You will be contacted when it is available.</span>
                </label>
            </div>
        </div>

        {{-- Q18 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">18</span> Which materials can be borrowed for one week only?</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[18]" value="A" {{ old('answers.18') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">some reference books</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[18]" value="B" {{ old('answers.18') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">CD-ROMs</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[18]" value="C" {{ old('answers.18') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">children’s DVDs</span>
                </label>
            </div>
        </div>

        {{-- Q19 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">19</span> On which day does the library stay open later than it used to?</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="A" {{ old('answers.19') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">Wednesday</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="B" {{ old('answers.19') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">Saturday</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="C" {{ old('answers.19') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">Sunday</span>
                </label>
            </div>
        </div>

        {{-- Q20 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-semibold text-gray-900 text-base mb-3"><span class="text-gray-900 font-bold mr-2">20</span> Large bags should be left on the</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="A" {{ old('answers.20') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">first floor.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="B" {{ old('answers.20') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">second floor.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="C" {{ old('answers.20') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">third floor.</span>
                </label>
            </div>
        </div>
    </div>
</div>