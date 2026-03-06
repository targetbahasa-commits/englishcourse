<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-16 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-16</h4>
    <p class="mb-2 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <div class="mb-12">
        <h4 class="text-xl font-bold mb-6 text-center text-gray-800">Durham County Car Show</h4>
        
        <div class="overflow-hidden border border-gray-300 rounded-lg max-w-2xl mx-auto">
            <table class="w-full text-left border-collapse">
                <tbody>
                    <tr class="border-b border-gray-300">
                        <td class="p-4 border-r border-gray-300 w-1/2 text-gray-700">Public grand opening date:</td>
                        <td class="p-4 w-1/2">
                            <span class="flex items-center gap-2">
                                <strong class="text-blue-600">11</strong>
                                <input type="text" name="answers[11]" class="w-full max-w-[150px] border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-300 bg-gray-50">
                        <td class="p-4 border-r border-gray-300 w-1/2 text-gray-700">Number of viewers:</td>
                        <td class="p-4 w-1/2">
                            <span class="flex items-center gap-2">
                                <strong class="text-blue-600">12</strong>
                                <input type="text" name="answers[12]" class="w-full max-w-[150px] border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-4 border-r border-gray-300 w-1/2 text-gray-700 align-top">Off-peak day price:</td>
                        <td class="p-4 w-1/2">
                            <ul class="space-y-3 text-gray-700">
                                <li>&bull; &pound;10 for adults</li>
                                <li>
                                    <span class="flex items-center gap-2">
                                        &bull; &pound; <strong class="text-blue-600">13</strong>
                                        <input type="text" name="answers[13]" class="w-full max-w-[120px] border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                                        for children
                                    </span>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-300 bg-gray-50">
                        <td class="p-4 border-r border-gray-300 w-1/2 text-gray-700">Best day to visit:</td>
                        <td class="p-4 w-1/2">
                            <span class="flex items-center gap-2">
                                <strong class="text-blue-600">14</strong>
                                <input type="text" name="answers[14]" class="w-full max-w-[150px] border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-300">
                        <td class="p-4 border-r border-gray-300 w-1/2 text-gray-700">New car category:</td>
                        <td class="p-4 w-1/2">
                            <span class="flex items-center gap-2">
                                <strong class="text-blue-600">15</strong>
                                <input type="text" name="answers[15]" class="w-full max-w-[150px] border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                            </span>
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="p-4 border-r border-gray-300 w-1/2 text-gray-700">Entertainment included:</td>
                        <td class="p-4 w-1/2">
                            <span class="flex items-center gap-2">
                                <strong class="text-blue-600">16</strong>
                                <input type="text" name="answers[16]" class="w-full max-w-[150px] border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    {{-- Questions 17-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 17-20</h4>
    <p class="mb-4 text-gray-700">When were the following features included in an auto show?</p>
    <p class="mb-6 text-gray-700 italic">Write the correct letter, <strong>A, B,</strong> or <strong>C</strong> next to questions <strong class="text-blue-600">17-20</strong>.</p>

    <div class="mb-8 pl-4 space-y-3">
        <div class="flex gap-4">
            <strong class="font-bold w-4 text-gray-800">A</strong>
            <span class="text-gray-800">last year</span>
        </div>
        <div class="flex gap-4">
            <strong class="font-bold w-4 text-gray-800">B</strong>
            <span class="text-gray-800">this year</span>
        </div>
        <div class="flex gap-4">
            <strong class="font-bold w-4 text-gray-800">C</strong>
            <span class="text-gray-800">both</span>
        </div>
    </div>

    <div class="space-y-4 max-w-sm ml-0">
        @foreach([
            17 => 'Higher number of seats',
            18 => 'Fun for children',
            19 => '4x4 test drive',
            20 => 'Lucky draw for car'
        ] as $q => $label)
        <div class="flex items-center justify-between border-b border-gray-200 pb-2 hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3">
                <strong class="text-blue-600">{{ $q }}</strong>
                <span class="text-gray-700">{{ $label }}</span>
            </div>
            <div class="w-24">
                <select name="answers[{{ $q }}]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234B5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:10px_10px] bg-no-repeat bg-[position:right_10px_center]">
                    <option value="" disabled selected>___</option>
                    @foreach(['A','B','C'] as $letter)
                        <option value="{{ $letter }}">{{ $letter }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
    </div>
</div>
