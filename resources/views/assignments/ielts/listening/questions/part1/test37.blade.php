<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 1</h3>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 1 - 10</h4>
            <p class="text-gray-600 font-medium mt-1">Complete the table below.</p>
            <p class="text-gray-600 font-medium">Write <strong class="text-gray-900">ONE WORD AND/OR A NUMBER</strong> for each answer.</p>
        </div>

        <div class="border border-gray-300 rounded-xl overflow-hidden shadow-sm my-4">
            <div class="bg-gray-100 text-gray-900 font-bold text-base px-4 py-3 border-b border-gray-300 tracking-wide uppercase">
                Notes on Concerts
            </div>

            <div class="p-3 bg-gray-50 border-b border-gray-300 text-sm text-gray-700 italic">
                Example: What to order start: <span class="font-bold text-gray-900 underline">coffee</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-800">
                    <thead class="bg-gray-50 text-gray-800 font-bold border-b border-gray-300 uppercase text-xs">
                        <tr>
                            <th class="p-3 w-1/4">Type of Concerts</th>
                            <th class="p-3 w-1/5">Time</th>
                            <th class="p-3 w-1/4">Cost</th>
                            <th class="p-3 w-1/3">Additional Information</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Row 1 --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                <strong class="font-bold text-gray-900 mr-1">1</strong>
                                <input type="text" name="answers[1]" value="{{ old('answers.1') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                concert
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                Every afternoon
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                $<strong class="font-bold text-gray-900 ml-1">2</strong>
                                <input type="text" name="answers[2]" value="{{ old('answers.2') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-20 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                for students
                                <div class="text-gray-500 text-xs mt-1">($6.50 for adults)</div>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                <ul class="space-y-1">
                                    <li>• Organise a press tent</li>
                                    <li>
                                        • Broadcast on the local
                                        <strong class="font-bold text-gray-900 ml-1">3</strong>
                                        <input type="text" name="answers[3]" value="{{ old('answers.3') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                        station
                                    </li>
                                </ul>
                            </td>
                        </tr>

                        {{-- Row 2 --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                <strong class="font-bold text-gray-900 mr-1">4</strong>
                                <input type="text" name="answers[4]" value="{{ old('answers.4') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                concert
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                Friday
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                Entrance fee: approx $40
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                Decorate with
                                <strong class="font-bold text-gray-900 ml-1">5</strong>
                                <input type="text" name="answers[5]" value="{{ old('answers.5') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>

                        {{-- Row 3 --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Opera show
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                <strong class="font-bold text-gray-900 mr-1">6</strong>
                                <input type="text" name="answers[6]" value="{{ old('answers.6') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                Charged by
                                <strong class="font-bold text-gray-900 ml-1">7</strong>
                                <input type="text" name="answers[7]" value="{{ old('answers.7') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                There will be
                                <strong class="font-bold text-gray-900 ml-1">8</strong>
                                <input type="text" name="answers[8]" value="{{ old('answers.8') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                performance
                            </td>
                        </tr>

                        {{-- Row 4 --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Karaoke night
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                Saturday
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                No group
                                <strong class="font-bold text-gray-900 ml-1">9</strong>
                                <input type="text" name="answers[9]" value="{{ old('answers.9') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                To end the show, a popular
                                <strong class="font-bold text-gray-900 ml-1">10</strong>
                                <input type="text" name="answers[10]" value="{{ old('answers.10') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                will perform
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>