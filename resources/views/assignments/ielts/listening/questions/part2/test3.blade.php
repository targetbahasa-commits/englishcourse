<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 2</h3>

    {{-- Questions 11-15: Notes Completion --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 11-15</h4>
            <p class="text-gray-600 font-medium mt-1">Complete the notes below.</p>
            <p class="text-gray-600 font-medium">Write <strong class="text-gray-900">ONE WORD ONLY</strong> for each answer.</p>
        </div>

        <div class="p-6 bg-gray-50 rounded-xl border border-gray-200 space-y-4 max-w-2xl mx-auto">
            <h5 class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-2 text-center uppercase tracking-wide">
                “Fit for Life” Health Centre
            </h5>

            <div class="space-y-4 text-base text-gray-800 leading-relaxed">
                <div>
                    <strong>•</strong> The initial step is a one-and-a-half-hour <strong class="text-gray-900 font-bold ml-1 mr-1">11</strong>
                    <input type="text" name="answers[11]" value="{{ old('answers.11') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> in which lifestyle and goals are analysed.
                </div>

                <div>
                    <strong>•</strong> It is important to control what you eat: you will need to show self-control and discipline in your <strong class="text-gray-900 font-bold ml-1 mr-1">12</strong>
                    <input type="text" name="answers[12]" value="{{ old('answers.12') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">.
                </div>

                <div>
                    <strong>•</strong> Your exercise regime involves a <strong class="text-gray-900 font-bold ml-1 mr-1">13</strong>
                    <input type="text" name="answers[13]" value="{{ old('answers.13') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> to measure heart rate and blood pressure to determine fitness level.
                </div>

                <div>
                    <strong>•</strong> Your exercise schedule and consultation will be reviewed <strong class="text-gray-900 font-bold ml-1 mr-1">14</strong>
                    <input type="text" name="answers[14]" value="{{ old('answers.14') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">.
                </div>

                <div>
                    <strong>•</strong> Members should think about which of <strong class="text-gray-900 font-bold ml-1 mr-1">15</strong>
                    <input type="text" name="answers[15]" value="{{ old('answers.15') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> areas they wish to target: muscle mass, stamina, or general fitness.
                </div>
            </div>
        </div>
    </div>

    {{-- Questions 16-20: Matching --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 16-20</h4>
            <p class="text-gray-600 font-medium mt-1">What is each facility best for?</p>
            <p class="text-gray-600 font-medium">Choose <strong class="text-gray-900">FIVE</strong> answers from the box and write the correct letter, <strong class="text-gray-900">A-G</strong>, next to questions 16-20.</p>
        </div>

        {{-- Options Box --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 max-w-md mx-auto">
            <h5 class="font-bold text-gray-800 mb-2 text-center text-sm uppercase tracking-wide">Facilities</h5>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-800 pl-4">
                <div><span class="font-bold text-gray-900 mr-2">A</span> Jogging machines</div>
                <div><span class="font-bold text-gray-900 mr-2">B</span> Yoga studio</div>
                <div><span class="font-bold text-gray-900 mr-2">C</span> Weight units</div>
                <div><span class="font-bold text-gray-900 mr-2">D</span> Front-desk area</div>
                <div><span class="font-bold text-gray-900 mr-2">E</span> Squash courts</div>
                <div><span class="font-bold text-gray-900 mr-2">F</span> Shower blocks</div>
                <div><span class="font-bold text-gray-900 mr-2">G</span> Swimming pool</div>
            </div>
        </div>

        <div class="space-y-3 max-w-xl mx-auto pt-2">
            @php
                $goals = [
                    16 => 'Developing confidence',
                    17 => 'Reducing stress',
                    18 => 'Building fitness',
                    19 => 'Meeting others',
                    20 => 'Finding information'
                ];
            @endphp

            @foreach($goals as $q => $label)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200 hover:bg-gray-100/70 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-gray-900 text-lg w-6">{{ $q }}</span>
                        <span class="text-gray-800 font-medium text-base">{{ $label }}</span>
                    </div>
                    <select name="answers[{{ $q }}]" class="border border-gray-300 focus:border-black outline-none px-4 py-1.5 rounded-lg font-bold bg-white text-gray-800 transition-colors cursor-pointer">
                        <option value="" disabled {{ old("answers.$q") ? '' : 'selected' }}>Select</option>
                        @foreach(['A','B','C','D','E','F','G'] as $opt)
                            <option value="{{ $opt }}" {{ old("answers.$q") == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
    </div>
</div>
