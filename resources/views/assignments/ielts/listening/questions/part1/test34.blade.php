<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">SECTION 1</h3>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 1 - 5</h4>
            <p class="text-gray-600 font-medium mt-1">Complete the table below.</p>
            <p class="text-gray-600 font-medium">Write <strong class="text-gray-900">ONE WORD AND/OR NUMBERS</strong> for each answer.</p>
        </div>

        <div class="border border-gray-300 rounded-xl overflow-hidden shadow-sm my-4">
            <div class="bg-gray-100 text-gray-900 font-bold text-base px-4 py-3 border-b border-gray-300 tracking-wide uppercase">
                Job Hunting
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-800">
                    <thead class="bg-gray-50 text-gray-800 font-bold border-b border-gray-300 uppercase text-xs">
                        <tr>
                            <th class="p-3 w-1/4">Company’s name</th>
                            <th class="p-3 w-5/12">Job details</th>
                            <th class="p-3 w-1/6">Reference Number</th>
                            <th class="p-3 w-1/6">Contact</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Row 1: POWER --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                <span class="block text-gray-900 font-bold">POWER</span>
                                <span class="text-gray-600 font-normal">(manufacturing company) <em class="text-gray-500">(Example)</em></span>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                • work in a
                                <strong class="font-bold text-gray-900 ml-1">1</strong>
                                <input type="text" name="answers[1]" value="{{ old('answers.1') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                section
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700 font-medium">
                                SW35FT
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                Jane
                                <strong class="font-bold text-gray-900 ml-1">2</strong>
                                <input type="text" name="answers[2]" value="{{ old('answers.2') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>

                        {{-- Row 2: COTTON --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-top">
                                <span class="block text-gray-900 font-bold">COTTON</span>
                                <span class="text-gray-600 font-normal">(grocery company)</span>
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-800">
                                <ul class="space-y-1">
                                    <li>• good pay</li>
                                    <li>• work
                                        <div class="pl-3 mt-1 space-y-1">
                                            <div>
                                                - in
                                                <strong class="font-bold text-gray-900 ml-1">3</strong>
                                                <input type="text" name="answers[3]" value="{{ old('answers.3') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                                office
                                            </div>
                                            <div>
                                                - in a
                                                <strong class="font-bold text-gray-900 ml-1">4</strong>
                                                <input type="text" name="answers[4]" value="{{ old('answers.4') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                                            </div>
                                        </div>
                                    </li>
                                    <li>• chance of promotion</li>
                                </ul>
                            </td>
                            <td class="p-3 align-top leading-relaxed">
                                <strong class="font-bold text-gray-900 mr-1">5</strong>
                                <input type="text" name="answers[5]" value="{{ old('answers.5') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            </td>
                            <td class="p-3 align-top leading-relaxed text-gray-700">
                                go to office
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div>
            <h4 class="text-xl font-bold text-gray-800">Questions 6 - 10</h4>
            <p class="text-gray-600 font-medium mt-1">Complete the notes below.</p>
            <p class="text-gray-600 font-medium">Write <strong class="text-gray-900">ONE WORD ONLY</strong> for each answer.</p>
        </div>

        <div class="border border-gray-300 rounded-xl overflow-hidden shadow-sm p-6 bg-white space-y-4">
            <h5 class="text-lg font-bold text-gray-900 border-b border-gray-300 pb-2 uppercase tracking-wide">
                Notes on Jobs
            </h5>

            <ul class="space-y-3 text-base text-gray-800 leading-relaxed">
                <li>
                    • Local jobs can be found in the
                    <strong class="font-bold text-gray-900 ml-1">6</strong>
                    <input type="text" name="answers[6]" value="{{ old('answers.6') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                </li>
                <li>
                    • Buy the
                    <strong class="font-bold text-gray-900 ml-1">7</strong>
                    <input type="text" name="answers[7]" value="{{ old('answers.7') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                    to get one free magazine (Job Plus)
                </li>
                <li>
                    • Feel stress and spend a lot of time looking for jobs
                </li>
                <li>
                    • Advisable to go to an
                    <strong class="font-bold text-gray-900 ml-1">8</strong>
                    <input type="text" name="answers[8]" value="{{ old('answers.8') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                    instead of the recruitment seminar
                </li>
                <li>
                    • Bring a student card (10% discount)
                </li>
                <li>
                    • Referee:
                    <ul class="pl-4 mt-1 space-y-1">
                        <li>- former boss (once had a job)</li>
                        <li>
                            - one of the
                            <strong class="font-bold text-gray-900 ml-1">9</strong>
                            <input type="text" name="answers[9]" value="{{ old('answers.9') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                            (if not)
                        </li>
                    </ul>
                </li>
                <li>
                    • Intend to take the art course
                </li>
                <li>
                    • Fill out a
                    <strong class="font-bold text-gray-900 ml-1">10</strong>
                    <input type="text" name="answers[10]" value="{{ old('answers.10') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400" placeholder="Answer" autocomplete="off">
                    form at the end of the course
                </li>
            </ul>
        </div>
    </div>
</div>