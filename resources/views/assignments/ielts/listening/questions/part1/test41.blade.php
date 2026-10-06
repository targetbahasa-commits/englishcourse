<div class="space-y-8">
    <h3 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-300">SECTION 1</h3>

    {{-- Questions 1-5 --}}
    <div class="bg-white p-6 rounded-xl border border-gray-300 space-y-4 shadow-sm">
        <div>
            <h4 class="text-lg font-bold text-gray-900">Questions 1-5</h4>
            <p class="text-gray-700 font-medium mt-1">Complete the notes below.</p>
            <p class="text-gray-700 font-medium">Write <strong class="text-gray-900">NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>
        </div>

        <div class="border border-gray-300 rounded-lg p-3 bg-gray-50 max-w-md text-sm">
            <span class="font-bold text-gray-700 uppercase tracking-wider text-xs block mb-1">Example</span>
            <div class="flex justify-between items-center text-gray-800 font-medium">
                <span>Destination:</span>
                <span class="font-bold underline">Harbour City</span>
            </div>
        </div>

        <h5 class="text-base font-bold text-gray-900 tracking-wide uppercase">Transport from Bayswater</h5>

        <div class="space-y-3 pl-2 text-base text-gray-800">
            <div class="flex items-center flex-wrap gap-2">
                <span>• Express train leaves at</span>
                <strong class="font-bold text-gray-900 ml-1">1</strong>
                <input type="text" name="answers[1]" value="{{ old('answers.1') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
            </div>

            <div class="flex items-center flex-wrap gap-2">
                <span>• Nearest station is</span>
                <strong class="font-bold text-gray-900 ml-1">2</strong>
                <input type="text" name="answers[2]" value="{{ old('answers.2') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
            </div>

            <div class="flex items-center flex-wrap gap-2">
                <span>• Number 706 bus goes to</span>
                <strong class="font-bold text-gray-900 ml-1">3</strong>
                <input type="text" name="answers[3]" value="{{ old('answers.3') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-40 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
            </div>

            <div class="flex items-center flex-wrap gap-2">
                <span>• Number</span>
                <strong class="font-bold text-gray-900 ml-1">4</strong>
                <input type="text" name="answers[4]" value="{{ old('answers.4') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                <span>bus goes to station</span>
            </div>

            <div class="flex items-center flex-wrap gap-2">
                <span>• Earlier bus leaves at</span>
                <strong class="font-bold text-gray-900 ml-1">5</strong>
                <input type="text" name="answers[5]" value="{{ old('answers.5') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
            </div>
        </div>
    </div>

    {{-- Questions 6-10: Table Completion --}}
    <div class="bg-white p-6 rounded-xl border border-gray-300 space-y-4 shadow-sm">
        <div>
            <h4 class="text-lg font-bold text-gray-900">Questions 6-10</h4>
            <p class="text-gray-700 font-medium mt-1">Complete the table below.</p>
            <p class="text-gray-700 font-medium">Write <strong class="text-gray-900">ONE WORD AND/OR A NUMBER</strong> for each answer.</p>
        </div>

        <div class="border border-gray-300 rounded-lg overflow-hidden my-4">
            <div class="bg-gray-100 text-gray-900 font-bold text-base px-4 py-2.5 text-center border-b border-gray-300 tracking-wide uppercase">
                Transport Options &amp; Fares
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-800">
                    <thead class="bg-gray-50 text-gray-900 font-bold border-b border-gray-300 uppercase text-xs">
                        <tr>
                            <th class="p-3 w-1/3 border-r border-gray-200">Transport</th>
                            <th class="p-3 w-1/3 border-r border-gray-200">Cash Fare</th>
                            <th class="p-3 w-1/3">Card Fare</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                Bus
                            </td>
                            <td class="p-3 align-middle border-r border-gray-200">
                                $<strong class="font-bold text-gray-900 ml-1">6</strong>
                                <input type="text" name="answers[6]" value="{{ old('answers.6') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 ml-1" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 font-medium align-middle">
                                $1.50
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                Train (peak)
                            </td>
                            <td class="p-3 font-medium align-middle border-r border-gray-200">
                                $10
                            </td>
                            <td class="p-3 font-medium align-middle">
                                $10
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                <div>Train (off-peak)</div>
                                <div class="text-xs text-gray-600 font-normal mt-0.5">
                                    — before 5 p.m. or after (<strong class="font-bold text-gray-900">7</strong>
                                    <input type="text" name="answers[7]" value="{{ old('answers.7') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mx-1" placeholder="Time" autocomplete="off"> p.m.)
                                </div>
                            </td>
                            <td class="p-3 font-medium align-middle border-r border-gray-200">
                                $10
                            </td>
                            <td class="p-3 align-middle">
                                $<strong class="font-bold text-gray-900 ml-1">8</strong>
                                <input type="text" name="answers[8]" value="{{ old('answers.8') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 ml-1" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                <strong class="font-bold text-gray-900 mr-1">9</strong>
                                <input type="text" name="answers[9]" value="{{ old('answers.9') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mr-1" placeholder="Type" autocomplete="off"> ferry
                            </td>
                            <td class="p-3 font-medium align-middle border-r border-gray-200">
                                $4.50
                            </td>
                            <td class="p-3 font-medium align-middle">
                                $3.55
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                Tourist ferry (<strong class="font-bold text-gray-900">10</strong>
                                <input type="text" name="answers[10]" value="{{ old('answers.10') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mx-1" placeholder="Tour" autocomplete="off">)
                            </td>
                            <td class="p-3 font-medium align-middle">
                                $35
                            </td>
                            <td class="p-3 text-gray-400 align-middle">
                                —
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                Tourist ferry (whole day)
                            </td>
                            <td class="p-3 font-medium align-middle border-r border-gray-200">
                                $65
                            </td>
                            <td class="p-3 text-gray-400 align-middle">
                                —
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>