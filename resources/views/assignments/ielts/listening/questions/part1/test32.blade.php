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
                Accommodation Options
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-800">
                    <thead class="bg-gray-50 text-gray-800 font-bold border-b border-gray-300 uppercase text-xs">
                        <tr>
                            <th class="p-3 w-1/6">Address</th>
                            <th class="p-3 w-1/5">Rooms</th>
                            <th class="p-3 w-1/5">Facilities</th>
                            <th class="p-3 w-1/6">Provided stuff</th>
                            <th class="p-3 w-1/6">Rental fee</th>
                            <th class="p-3 w-1/5">Drawback</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Row 1: Beatle Road --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Beatle Road
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                3 bedrooms, a bathroom, a
                                <strong class="font-bold text-gray-900 ml-1">1</strong>
                                <input type="text" name="answers[1]" value="{{ old('answers.1') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                a nearby restaurant <span class="italic text-gray-500">(Example)</span>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                Internet and utilities
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                $<strong class="font-bold text-gray-900 ml-1">2</strong>
                                <input type="text" name="answers[2]" value="{{ old('answers.2') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-20 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                The garden is too big to be cleaned up.
                            </td>
                        </tr>

                        {{-- Row 2: Oakington Avenue --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Oakington Avenue
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                3 bedrooms, a kitchen, a living room
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                Shared living room, bathroom, kitchen and
                                <strong class="font-bold text-gray-900 ml-1">3</strong>
                                <input type="text" name="answers[3]" value="{{ old('answers.3') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                Living room furniture
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700 font-medium">
                                $340 - $400
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                Due to some shared facilities, it seems
                                <strong class="font-bold text-gray-900 ml-1">4</strong>
                                <input type="text" name="answers[4]" value="{{ old('answers.4') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>

                        {{-- Row 3: Mead Street --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Mead Street
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                2 bedrooms, a living room,
                                <strong class="font-bold text-gray-900 ml-1">5</strong>
                                <input type="text" name="answers[5]" value="{{ old('answers.5') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                TV and VCR
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                a <strong class="font-bold text-gray-900 ml-1">6</strong>
                                <input type="text" name="answers[6]" value="{{ old('answers.6') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700 font-medium">
                                $600
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                Sometimes it is quite
                                <strong class="font-bold text-gray-900 ml-1">7</strong>
                                <input type="text" name="answers[7]" value="{{ old('answers.7') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>

                        {{-- Row 4: Devon Close complex --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                Devon Close complex
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                1 bedroom, a living room, a study
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                a lamp with
                                <strong class="font-bold text-gray-900 ml-1">8</strong>
                                <input type="text" name="answers[8]" value="{{ old('answers.8') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">;
                                <br>a dining hall
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                free
                                <strong class="font-bold text-gray-900 ml-1">9</strong>
                                <input type="text" name="answers[9]" value="{{ old('answers.9') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700 font-medium">
                                $500
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                Not including
                                <strong class="font-bold text-gray-900 ml-1">10</strong>
                                <input type="text" name="answers[10]" value="{{ old('answers.10') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-24 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>