<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 1</h3>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 1-10</h4>
            <p class="text-gray-600 font-medium mt-1">Complete the table below.</p>
            <p class="text-gray-600 font-medium">Write <strong class="text-gray-900">ONE WORD AND/OR A NUMBER</strong> for each answer.</p>
        </div>

        <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <div class="bg-gray-100 text-gray-900 font-bold text-base px-4 py-3 border-b border-gray-300 tracking-wide uppercase">
                HOSTELS
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-800">
                    <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-200 uppercase text-xs">
                        <tr>
                            <th class="p-3 w-1/4">Name</th>
                            <th class="p-3 w-1/4">Location</th>
                            <th class="p-3 w-1/4">Cost of double room</th>
                            <th class="p-3 w-1/4">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Hostelling International West End --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Hostelling International West End
                            </td>
                            <td class="p-3 align-top">
                                <span class="italic text-gray-500 block mb-1">Example:</span>
                                10 minutes from downtown by <span class="font-bold underline ">bus</span>
                            </td>
                            <td class="p-3 align-top">
                                $50 per night but only $<strong class="text-gray-900 font-bold ml-1 mr-1">1</strong>
                                <input type="text" name="answers[1]" value="{{ old('answers.1') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> for members
                            </td>
                            <td class="p-3 align-top space-y-2">
                                <div>
                                    Membership card offers discount on entry to <strong class="text-gray-900 font-bold ml-1 mr-1">2</strong>
                                    <input type="text" name="answers[2]" value="{{ old('answers.2') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                </div>
                                <div>
                                    Internet access costs $3 per <strong class="text-gray-900 font-bold ml-1 mr-1">3</strong>
                                    <input type="text" name="answers[3]" value="{{ old('answers.3') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                </div>
                            </td>
                        </tr>

                        {{-- Elliscoat Hostel --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                <strong class="text-gray-900 font-bold mr-1">4</strong>
                                <input type="text" name="answers[4]" value="{{ old('answers.4') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                <span class="block text-gray-600 font-normal">Hostel</span>
                            </td>
                            <td class="p-3 align-top">
                                Near beach.<br>Two-minute walk to <strong class="text-gray-900 font-bold ml-1 mr-1">5</strong>
                                <input type="text" name="answers[5]" value="{{ old('answers.5') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top">
                                $62.<br>Meals extra but only available in <strong class="text-gray-900 font-bold ml-1 mr-1">6</strong>
                                <input type="text" name="answers[6]" value="{{ old('answers.6') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top space-y-2">
                                <div>
                                    Was built as a hotel in <strong class="text-gray-900 font-bold ml-1 mr-1">7</strong>
                                    <input type="text" name="answers[7]" value="{{ old('answers.7') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                </div>
                                <div>
                                    Can hire <strong class="text-gray-900 font-bold ml-1 mr-1">8</strong>
                                    <input type="text" name="answers[8]" value="{{ old('answers.8') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> from hostel
                                </div>
                            </td>
                        </tr>

                        {{-- Backpackers Hostel --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Backpackers Hostel
                            </td>
                            <td class="p-3 align-top">
                                In <strong class="text-gray-900 font-bold ml-1 mr-1">9</strong>
                                <input type="text" name="answers[9]" value="{{ old('answers.9') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> district
                            </td>
                            <td class="p-3 align-top">
                                $45 plus $5 for breakfast
                            </td>
                            <td class="p-3 align-top">
                                A <strong class="text-gray-900 font-bold ml-1 mr-1">10</strong>
                                <input type="text" name="answers[10]" value="{{ old('answers.10') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off"> on every floor for guests to use
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>