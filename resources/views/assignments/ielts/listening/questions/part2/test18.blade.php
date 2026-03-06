<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-14 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-14</h4>
    <p class="mb-2 text-gray-700">List <strong>FOUR</strong> reasons given for people needing blood transfusions.</p>
    <p class="mb-2 text-gray-700">Write <strong>NO MORE THAN THREE WORDS OR A NUMBER</strong> for each answer.</p>
    <p class="mb-6 text-gray-700 italic">Write your answers in boxes <strong>11-14</strong> on your answer sheet.</p>

    <div class="space-y-4 mb-12">
        @foreach([11, 12, 13, 14] as $q)
        <div class="flex items-center gap-3">
            <strong class="text-blue-600 w-6">{{ $q }}</strong>
            <input type="text" name="answers[{{ $q }}]" class="w-64 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
        </div>
        @endforeach
    </div>


    {{-- Questions 15-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 15-20</h4>
    <p class="mb-2 text-gray-700">Complete the 2 sets of notes below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN THREE WORDS OR A NUMBER</strong> for each answer.</p>

    <h5 class="font-bold text-gray-800 mb-3">Blood</h5>
    <p class="text-gray-700 mb-4">Types of Blood &nbsp;&nbsp;&nbsp; O, A, B + AB</p>

    <h5 class="font-bold text-gray-800 mb-4">Component Parts</h5>
    <div class="overflow-x-auto w-full max-w-2xl mb-8">
        <table class="w-full text-left border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-50">
                    <th class="p-3 border border-gray-300 font-bold w-1/3">PART</th>
                    <th class="p-3 border border-gray-300 font-bold">USED FOR</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <tr>
                    <td class="p-3 border border-gray-300">red blood cells</td>
                    <td class="p-3 border border-gray-300">
                        <div class="flex items-center gap-2">
                            <strong class="text-blue-600">15</strong>
                            <input type="text" name="answers[15]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                            <span>to cells</span>
                        </div>
                    </td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="p-3 border border-gray-300">white blood cells</td>
                    <td class="p-3 border border-gray-300">
                        <div class="flex items-center gap-2">
                            <span>help patients'</span>
                            <strong class="text-blue-600">16</strong>
                            <input type="text" name="answers[16]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="p-3 border border-gray-300">platelets</td>
                    <td class="p-3 border border-gray-300">blood clotting</td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="p-3 border border-gray-300">plasma</td>
                    <td class="p-3 border border-gray-300">
                        <div class="flex items-center gap-2">
                            <strong class="text-blue-600">17</strong>
                            <input type="text" name="answers[17]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                            <span>the other blood parts</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="p-3 border border-gray-300 font-semibold">GIVING BLOOD DAYS</td>
                    <td class="p-3 border border-gray-300">Wednesday + next 2 days</td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="p-3 border border-gray-300 font-semibold">WHERE</td>
                    <td class="p-3 border border-gray-300">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>Westley General Hospital.</span>
                            <strong class="text-blue-600">18</strong>
                            <input type="text" name="answers[18]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                            <span>Department</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="p-3 border border-gray-300 font-semibold">WHEN</td>
                    <td class="p-3 border border-gray-300">
                        <div class="flex items-center gap-2">
                            <span>Between 9.00am and</span>
                            <strong class="text-blue-600">19</strong>
                            <input type="text" name="answers[19]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="space-y-2 text-gray-700 max-w-md pl-4">
        <p>&ndash; MUST be healthy</p>
        <div class="flex items-center gap-2">
            <span>&ndash; be</span>
            <strong class="text-blue-600">20</strong>
            <input type="text" name="answers[20]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
            <span>or over</span>
        </div>
        <p>&ndash; weigh more than 110 pounds</p>
        <p>&ndash; have had no tattoos this year</p>
        <p>&ndash; not have donated blood within past 56 days</p>
    </div>
</div>
