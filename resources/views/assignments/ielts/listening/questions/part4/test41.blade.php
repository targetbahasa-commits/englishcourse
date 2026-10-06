<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 4</h3>

    {{-- Questions 31-35: Table Completion --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 31-35</h4>
            <p class="text-gray-600 font-medium mt-1">Complete the table below.</p>
            <p class="text-gray-600 font-medium">Write <strong class="text-gray-900">ONE WORD ONLY</strong> for each answer.</p>
        </div>

        <div class="border border-gray-300 rounded-xl overflow-hidden shadow-sm my-4">
            <div class="bg-gray-100 text-gray-900 font-bold text-base px-4 py-3 border-b border-gray-300 tracking-wide uppercase">
                Time Perspectives
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-800">
                    <thead class="bg-gray-50 text-gray-800 font-bold border-b border-gray-300 uppercase text-xs">
                        <tr>
                            <th class="p-3 w-1/4">Time Zone</th>
                            <th class="p-3 w-1/4">Outlook</th>
                            <th class="p-3 w-1/2">Features &amp; Consequences</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Past Positive --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle">
                                Past
                            </td>
                            <td class="p-3 font-medium text-gray-800 align-middle">
                                Positive
                            </td>
                            <td class="p-3 text-gray-700 align-middle">
                                Remember good times, e.g. birthdays. Keep family records, photo albums, etc.
                            </td>
                        </tr>

                        {{-- Past Negative --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle">
                                Past
                            </td>
                            <td class="p-3 align-middle">
                                <strong class="font-bold text-gray-900 mr-1">31</strong>
                                <input type="text" name="answers[31]" value="{{ old('answers.31') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mr-1" placeholder="Outlook" autocomplete="off">
                            </td>
                            <td class="p-3 text-gray-700 align-middle">
                                Focus on disappointments, failures, bad decisions.
                            </td>
                        </tr>

                        {{-- Present Hedonistic --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle">
                                Present
                            </td>
                            <td class="p-3 font-medium text-gray-800 align-middle">
                                Hedonistic
                            </td>
                            <td class="p-3 text-gray-700 align-middle">
                                Live for <strong class="font-bold text-gray-900 ml-1">32</strong>
                                <input type="text" name="answers[32]" value="{{ old('answers.32') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mx-1" placeholder="Answer" autocomplete="off">; seek sensation; avoid pain.
                            </td>
                        </tr>

                        {{-- Present Fatalistic --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle">
                                Present
                            </td>
                            <td class="p-3 font-medium text-gray-800 align-middle">
                                Fatalistic
                            </td>
                            <td class="p-3 text-gray-700 align-middle">
                                Life is governed by <strong class="font-bold text-gray-900 ml-1">33</strong>
                                <input type="text" name="answers[33]" value="{{ old('answers.33') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mx-1" placeholder="Answer" autocomplete="off">, religious beliefs, social conditions. Life's path can't be changed.
                            </td>
                        </tr>

                        {{-- Future Active --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle">
                                Future
                            </td>
                            <td class="p-3 align-middle">
                                <strong class="font-bold text-gray-900 mr-1">34</strong>
                                <input type="text" name="answers[34]" value="{{ old('answers.34') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mr-1" placeholder="Outlook" autocomplete="off">
                            </td>
                            <td class="p-3 text-gray-700 align-middle">
                                Prefer work to play. Don't give in to temptation.
                            </td>
                        </tr>

                        {{-- Future Fatalistic --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle">
                                Future
                            </td>
                            <td class="p-3 font-medium text-gray-800 align-middle">
                                Fatalistic
                            </td>
                            <td class="p-3 text-gray-700 align-middle">
                                Have a strong belief in life after death and importance of <strong class="font-bold text-gray-900 ml-1">35</strong>
                                <input type="text" name="answers[35]" value="{{ old('answers.35') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mx-1" placeholder="Answer" autocomplete="off"> in life.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Questions 36-40: Multiple Choice --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 36-40</h4>
            <p class="text-gray-600 font-medium mt-1">Choose the correct letter, <strong class="text-gray-900">A, B or C</strong>.</p>
        </div>

        {{-- Q36 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="font-semibold text-gray-900 text-base mb-3"><strong class="font-bold text-gray-900 mr-2">36</strong> We are all present hedonists</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[36]" value="A" {{ old('answers.36') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">at school.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[36]" value="B" {{ old('answers.36') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">at birth.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[36]" value="C" {{ old('answers.36') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">while eating and drinking.</span>
                </label>
            </div>
        </div>

        {{-- Q37 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="font-semibold text-gray-900 text-base mb-3"><strong class="font-bold text-gray-900 mr-2">37</strong> American boys drop out of school at a higher rate than girls because</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[37]" value="A" {{ old('answers.37') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">they need to be in control of the way they learn.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[37]" value="B" {{ old('answers.37') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">they play video games instead of doing school work.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[37]" value="C" {{ old('answers.37') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">they are not as intelligent as girls.</span>
                </label>
            </div>
        </div>

        {{-- Q38 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="font-semibold text-gray-900 text-base mb-3"><strong class="font-bold text-gray-900 mr-2">38</strong> Present-orientated children</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[38]" value="A" {{ old('answers.38') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">do not could be taught future orientation.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[38]" value="B" {{ old('answers.38') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">find it hard to delay gratification.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[38]" value="C" {{ old('answers.38') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">are more likely to succeed at school.</span>
                </label>
            </div>
        </div>

        {{-- Q39 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="font-semibold text-gray-900 text-base mb-3"><strong class="font-bold text-gray-900 mr-2">39</strong> If you ask someone who is future-oriented what they are doing tomorrow</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[39]" value="A" {{ old('answers.39') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">they will have a clear idea.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[39]" value="B" {{ old('answers.39') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">they will not know.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[39]" value="C" {{ old('answers.39') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">they will be uncertain.</span>
                </label>
            </div>
        </div>

        {{-- Q40 --}}
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="font-semibold text-gray-900 text-base mb-3"><strong class="font-bold text-gray-900 mr-2">40</strong> We can change people's time perspective by</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[40]" value="A" {{ old('answers.40') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">psychological therapy.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[40]" value="B" {{ old('answers.40') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">education.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition-colors w-fit">
                    <input type="radio" name="answers[40]" value="C" {{ old('answers.40') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">giving them money.</span>
                </label>
            </div>
        </div>
    </div>
</div>