<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 1</h3>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 1 - 10</h4>
            <p class="text-gray-600 font-medium mt-1">Complete the table below.</p>
            <p class="text-gray-600 font-medium">Write <strong class="text-gray-900">NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>
        </div>

        <div class="border border-gray-300 rounded-xl overflow-hidden shadow-sm my-4">
            <div class="bg-gray-100 text-gray-900 font-bold text-base px-4 py-3 border-b border-gray-300 tracking-wide uppercase">
                Student Accommodation
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-800">
                    <thead class="bg-gray-50 text-gray-800 font-bold border-b border-gray-300 uppercase text-xs">
                        <tr>
                            <th class="p-3 w-1/4">Type</th>
                            <th class="p-3 w-5/12">Cost</th>
                            <th class="p-3 w-1/3">Contract</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Row 1: College --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                <span class="block text-gray-900 font-bold">College:</span>
                                <span class="text-gray-700">Single room <em class="text-gray-500 font-normal">(Example)</em></span>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                <div>• Standard: £3,276 per year</div>
                                <div class="mt-1">
                                    • Ensuite:
                                    <strong class="font-bold text-gray-900 ml-1">1</strong>
                                    £<input type="text" name="answers[1]" value="{{ old('answers.1') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                    per year (meals are not included)
                                </div>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                <div>• 36 weeks</div>
                                <div class="mt-1">
                                    (Rooms not available during the
                                    <strong class="font-bold text-gray-900 ml-1">2</strong>
                                    <input type="text" name="answers[2]" value="{{ old('answers.2') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">)
                                </div>
                            </td>
                        </tr>

                        {{-- Row 2: Home Welcome --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                <strong class="font-bold text-gray-900 mr-1">3</strong>
                                <input type="text" name="answers[3]" value="{{ old('answers.3') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                <span class="block text-gray-700 font-normal mt-1">Room with a family</span>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800 font-medium">
                                £150 per week — all inclusive
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                Arrangements are
                                <strong class="font-bold text-gray-900 ml-1">4</strong>
                                <input type="text" name="answers[4]" value="{{ old('answers.4') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>

                        {{-- Row 3: Private Renting --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                <span class="block text-gray-900 font-bold">Private renting:</span>
                                <span class="text-gray-700 font-normal block mt-1">
                                    Room in a shared house or a
                                    <strong class="font-bold text-gray-900 ml-1">5</strong>
                                    <input type="text" name="answers[5]" value="{{ old('answers.5') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                </span>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                <div>From £275 to £490 per month</div>
                                <div class="mt-2 text-gray-700 font-medium">Additional costs (for this year):</div>
                                <ul class="space-y-1 mt-1 pl-2 text-gray-700">
                                    <li>
                                        • gas and electricity approx. £
                                        <strong class="font-bold text-gray-900 ml-1">6</strong>
                                        <input type="text" name="answers[6]" value="{{ old('answers.6') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-20 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                        per month
                                    </li>
                                    <li>
                                        • <strong class="font-bold text-gray-900 mr-1">7</strong>
                                        <input type="text" name="answers[7]" value="{{ old('answers.7') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                        approx. £9
                                    </li>
                                    <li>
                                        • <strong class="font-bold text-gray-900 mr-1">8</strong>
                                        <input type="text" name="answers[8]" value="{{ old('answers.8') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                    </li>
                                </ul>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                <div>• 6 months</div>
                                <div class="mt-2 text-gray-700 font-medium">Need:</div>
                                <ul class="space-y-1 mt-1 pl-2 text-gray-700">
                                    <li>
                                        • <strong class="font-bold text-gray-900 mr-1">9</strong>
                                        <input type="text" name="answers[9]" value="{{ old('answers.9') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                    </li>
                                    <li>
                                        • two
                                        <strong class="font-bold text-gray-900 ml-1">10</strong>
                                        <input type="text" name="answers[10]" value="{{ old('answers.10') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>