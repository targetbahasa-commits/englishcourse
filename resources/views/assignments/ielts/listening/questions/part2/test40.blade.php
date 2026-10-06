<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 2</h3>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 11 - 18</h4>
            <p class="text-gray-600 font-medium mt-1">Complete the table below.</p>
            <p class="text-gray-600 font-medium">Write <strong class="text-gray-900">NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>
        </div>

        <div class="border border-gray-300 rounded-xl overflow-hidden shadow-sm my-4">
            <div class="bg-gray-100 text-gray-900 font-bold text-base px-4 py-3 border-b border-gray-300 tracking-wide uppercase">
                Spring Festival
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-800">
                    <thead class="bg-gray-50 text-gray-800 font-bold border-b border-gray-300 uppercase text-xs">
                        <tr>
                            <th class="p-3 w-1/4">Event</th>
                            <th class="p-3 w-1/4">Location</th>
                            <th class="p-3 w-1/4">Date and Time</th>
                            <th class="p-3 w-1/4">Other Information</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Row 1: Firework display --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Firework display
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                Near the
                                <strong class="font-bold text-gray-900 ml-1">11</strong>
                                <input type="text" name="answers[11]" value="{{ old('answers.11') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                4 September 9 p.m.
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                Pack a
                                <strong class="font-bold text-gray-900 ml-1">12</strong>
                                <input type="text" name="answers[12]" value="{{ old('answers.12') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                and blanket
                            </td>
                        </tr>

                        {{-- Row 2: Central Park --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Display of
                                <strong class="font-bold text-gray-900 ml-1">13</strong>
                                <input type="text" name="answers[13]" value="{{ old('answers.13') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                Central Park
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                Daily
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                Buses run from the town centre every
                                <strong class="font-bold text-gray-900 ml-1">14</strong>
                                <input type="text" name="answers[14]" value="{{ old('answers.14') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                minutes
                            </td>
                        </tr>

                        {{-- Row 3: Exhibition Centre --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                The
                                <strong class="font-bold text-gray-900 ml-1">15</strong>
                                <input type="text" name="answers[15]" value="{{ old('answers.15') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                Show
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                Exhibition Centre
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                10—15 September<br>9 a.m.—10 p.m.
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                “Grow Your Imagination” in the
                                <strong class="font-bold text-gray-900 ml-1">16</strong>
                                <input type="text" name="answers[16]" value="{{ old('answers.16') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>

                        {{-- Row 4: Swing in Spring --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                “Swing in Spring”
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                in the
                                <strong class="font-bold text-gray-900 ml-1">17</strong>
                                <input type="text" name="answers[17]" value="{{ old('answers.17') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                11—19 September<br>
                                <span class="text-xs text-gray-500">(17 &amp; 18 September)</span>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                Saturday matinee Performance at
                                <strong class="font-bold text-gray-900 ml-1">18</strong>
                                <input type="text" name="answers[18]" value="{{ old('answers.18') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Questions 19 and 20: Multiple Choice --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 19 and 20</h4>
            <p class="text-gray-600 font-medium mt-1">Choose the correct letter, <strong class="text-gray-900">A, B or C</strong>.</p>
        </div>

        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 my-4">
            <p class="font-semibold text-gray-900 text-base mb-3"><strong class="font-bold text-gray-900 mr-2">19</strong> In the Spring Festival competition, you can win</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="A" {{ old('answers.19') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">a family pass to “Balloons Down Under”.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="B" {{ old('answers.19') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">a cheque for $200.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[19]" value="C" {{ old('answers.19') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">a flight in a hot air balloon.</span>
                </label>
            </div>
        </div>

        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 my-4">
            <p class="font-semibold text-gray-900 text-base mb-3"><strong class="font-bold text-gray-900 mr-2">20</strong> You can get an entry form for the competition from</p>
            <div class="space-y-2 pl-4">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="A" {{ old('answers.20') == 'A' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">A</span>
                    <span class="text-gray-700">the radio station.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="B" {{ old('answers.20') == 'B' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">B</span>
                    <span class="text-gray-700">the town hall.</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[20]" value="C" {{ old('answers.20') == 'C' ? 'checked' : '' }} class="w-4 h-4 text-gray-800 border-gray-400 focus:ring-black cursor-pointer">
                    <span class="font-bold text-gray-700">C</span>
                    <span class="text-gray-700">the tourist information office.</span>
                </label>
            </div>
        </div>
    </div>
</div>