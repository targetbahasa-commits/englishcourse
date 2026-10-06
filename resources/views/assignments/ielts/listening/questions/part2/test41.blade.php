<div class="space-y-8">
    <h3 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-300">SECTION 2</h3>

    {{-- Questions 11-14: Matching --}}
    <div class="bg-white p-6 rounded-xl border border-gray-300 space-y-4 shadow-sm">
        <div>
            <h4 class="text-lg font-bold text-gray-900">Questions 11-14</h4>
            <p class="text-gray-700 font-medium mt-1">Which counsellor should you see?</p>
            <p class="text-gray-700 font-medium">Write the correct letter, <strong class="text-gray-900">A, B or C</strong>, next to questions 11-14.</p>
        </div>

        {{-- Options Box --}}
        <div class="p-4 bg-gray-50 rounded-lg border border-gray-300 max-w-md">
            <h5 class="font-bold text-gray-700 mb-2 text-xs uppercase tracking-wide">Counsellors</h5>
            <div class="space-y-1.5 text-sm text-gray-800 pl-2">
                <div class="flex items-center gap-2"><span class="font-bold text-gray-900 w-5">A</span> Louise Bagshaw</div>
                <div class="flex items-center gap-2"><span class="font-bold text-gray-900 w-5">B</span> Tony Denby</div>
                <div class="flex items-center gap-2"><span class="font-bold text-gray-900 w-5">C</span> Naomi Flynn</div>
            </div>
        </div>

        {{-- Questions 11-14 items --}}
        <div class="space-y-3 pt-2">
            <div class="flex items-center justify-between border-b border-gray-200 pb-2.5 hover:bg-gray-50 p-2 rounded transition-colors max-w-xl">
                <div class="flex items-center gap-3">
                    <strong class="font-bold text-gray-900 text-base">11</strong>
                    <span class="text-gray-800 font-medium">If it is your first time seeing a counsellor.</span>
                </div>
                <div class="w-24">
                    <select name="answers[11]" class="w-full border border-gray-300 focus:border-black outline-none px-3 py-1.5 rounded text-center font-bold bg-white text-gray-900 transition-colors cursor-pointer">
                        <option value="" disabled selected>___</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between border-b border-gray-200 pb-2.5 hover:bg-gray-50 p-2 rounded transition-colors max-w-xl">
                <div class="flex items-center gap-3">
                    <strong class="font-bold text-gray-900 text-base">12</strong>
                    <span class="text-gray-800 font-medium">If you are unable to see a counsellor during normal office hours.</span>
                </div>
                <div class="w-24">
                    <select name="answers[12]" class="w-full border border-gray-300 focus:border-black outline-none px-3 py-1.5 rounded text-center font-bold bg-white text-gray-900 transition-colors cursor-pointer">
                        <option value="" disabled selected>___</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between border-b border-gray-200 pb-2.5 hover:bg-gray-50 p-2 rounded transition-colors max-w-xl">
                <div class="flex items-center gap-3">
                    <strong class="font-bold text-gray-900 text-base">13</strong>
                    <span class="text-gray-800 font-medium">If you do not have an appointment.</span>
                </div>
                <div class="w-24">
                    <select name="answers[13]" class="w-full border border-gray-300 focus:border-black outline-none px-3 py-1.5 rounded text-center font-bold bg-white text-gray-900 transition-colors cursor-pointer">
                        <option value="" disabled selected>___</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between border-b border-gray-200 pb-2.5 hover:bg-gray-50 p-2 rounded transition-colors max-w-xl">
                <div class="flex items-center gap-3">
                    <strong class="font-bold text-gray-900 text-base">14</strong>
                    <span class="text-gray-800 font-medium">If your concerns are related to anxiety.</span>
                </div>
                <div class="w-24">
                    <select name="answers[14]" class="w-full border border-gray-300 focus:border-black outline-none px-3 py-1.5 rounded text-center font-bold bg-white text-gray-900 transition-colors cursor-pointer">
                        <option value="" disabled selected>___</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Questions 15-20: Table Completion --}}
    <div class="bg-white p-6 rounded-xl border border-gray-300 space-y-4 shadow-sm">
        <div>
            <h4 class="text-lg font-bold text-gray-900">Questions 15-20</h4>
            <p class="text-gray-700 font-medium mt-1">Complete the table below.</p>
            <p class="text-gray-700 font-medium">Write <strong class="text-gray-900">NO MORE THAN TWO WORDS</strong> for each answer.</p>
        </div>

        <div class="border border-gray-300 rounded-lg overflow-hidden my-4">
            <div class="bg-gray-100 text-gray-900 font-bold text-base px-4 py-2.5 text-center border-b border-gray-300 tracking-wide uppercase">
                Student Support Workshops
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-800">
                    <thead class="bg-gray-50 text-gray-900 font-bold border-b border-gray-300 uppercase text-xs">
                        <tr>
                            <th class="p-3 w-1/4 border-r border-gray-200">Workshop</th>
                            <th class="p-3 w-1/2 border-r border-gray-200">Content</th>
                            <th class="p-3 w-1/4">Target Group</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                Adjusting
                            </td>
                            <td class="p-3 align-middle text-gray-700 border-r border-gray-200">
                                what you need to succeed academically
                            </td>
                            <td class="p-3 align-middle">
                                <strong class="font-bold text-gray-900 mr-1">15</strong>
                                <input type="text" name="answers[15]" value="{{ old('answers.15') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-28 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mr-1" placeholder="Answer" autocomplete="off"> students
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                Getting Organised
                            </td>
                            <td class="p-3 align-middle text-gray-700 border-r border-gray-200">
                                use time effectively, find <strong class="font-bold text-gray-900 ml-1">16</strong>
                                <input type="text" name="answers[16]" value="{{ old('answers.16') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mx-1" placeholder="Answer" autocomplete="off"> between study and leisure
                            </td>
                            <td class="p-3 align-middle text-gray-700">
                                all students
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                Communicating
                            </td>
                            <td class="p-3 align-middle text-gray-700 border-r border-gray-200">
                                talking with staff, communicating across cultures
                            </td>
                            <td class="p-3 align-middle text-gray-700">
                                all students, especially <strong class="font-bold text-gray-900 ml-1">17</strong>
                                <input type="text" name="answers[17]" value="{{ old('answers.17') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 ml-1" placeholder="Answer" autocomplete="off">
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                Anxiety
                            </td>
                            <td class="p-3 align-middle text-gray-700 border-r border-gray-200">
                                <strong class="font-bold text-gray-900 mr-1">18</strong>
                                <input type="text" name="answers[18]" value="{{ old('answers.18') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mr-1" placeholder="Answer" autocomplete="off">, breathing techniques, meditation, etc.
                            </td>
                            <td class="p-3 align-middle text-gray-700">
                                students about to sit exams
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900 align-middle border-r border-gray-200">
                                <strong class="font-bold text-gray-900 mr-1">19</strong>
                                <input type="text" name="answers[19]" value="{{ old('answers.19') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-36 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mr-1" placeholder="Workshop" autocomplete="off">
                            </td>
                            <td class="p-3 align-middle text-gray-700 border-r border-gray-200">
                                staying on track for long periods
                            </td>
                            <td class="p-3 align-middle text-gray-700">
                                <strong class="font-bold text-gray-900 mr-1">20</strong>
                                <input type="text" name="answers[20]" value="{{ old('answers.20') }}" class="border-0 border-b-2 border-gray-700 focus:border-black outline-none px-2 py-0.5 w-32 bg-transparent text-center font-bold text-gray-900 transition-colors placeholder-gray-400 mr-1" placeholder="Target" autocomplete="off"> students only
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>