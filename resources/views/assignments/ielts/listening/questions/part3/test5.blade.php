<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-26: Table Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-26</h4>
    <p class="mb-2 text-gray-700">Complete the table.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for each answer.</p>

    <div class="overflow-x-auto mb-12">
        <table class="w-full border-collapse border border-gray-300 text-gray-700">
            <thead>
                <tr class="bg-white">
                    <th class="border border-gray-300 px-4 py-3 text-left font-bold w-1/4">Subject</th>
                    <th class="border border-gray-300 px-4 py-3 text-left font-bold w-1/3">Textbook Used</th>
                    <th class="border border-gray-300 px-4 py-3 text-left font-bold">Criticism of this book</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-4 py-3">Social History</td>
                    <td class="border border-gray-300 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <strong class="text-blue-600">21</strong>
                            <input type="text" name="answers[21]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>It is</span>
                            <strong class="text-blue-600">22</strong>
                            <input type="text" name="answers[22]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr class="bg-white">
                    <td class="border border-gray-300 px-4 py-3">Cultural Studies</td>
                    <td class="border border-gray-300 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <strong class="text-blue-600">23</strong>
                            <input type="text" name="answers[23]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>It</span>
                            <strong class="text-blue-600">24</strong>
                            <input type="text" name="answers[24]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <strong class="text-blue-600">25</strong>
                            <input type="text" name="answers[25]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                    <td class="border border-gray-300 px-4 py-3">Government in Action</td>
                    <td class="border border-gray-300 px-4 py-3">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>It is</span>
                            <strong class="text-blue-600">26</strong>
                            <input type="text" name="answers[26]" class="w-28 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent text-sm" placeholder="..........." autocomplete="off" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Questions 27-30: Matching MCQ (S, C, P) --}}
    <h4 class="text-lg font-bold mb-2">Questions 27-30</h4>
    <p class="mb-2 text-gray-700">Choose the correct letter, <strong>S</strong>, <strong>C</strong>, or <strong>P</strong>.</p>
    <p class="mb-4 text-gray-700"><em><strong>NB</strong> You may use a letter more than once.</em></p>

    <div class="mb-4 space-y-1 pl-4 text-gray-700">
        <p><strong>S</strong>&nbsp;&nbsp; Social History</p>
        <p><strong>C</strong>&nbsp;&nbsp; Cultural Studies</p>
        <p><strong>P</strong>&nbsp;&nbsp; Political Theory</p>
    </div>

    <p class="mb-6 font-bold text-gray-800">What are the speakers' favorite subjects?</p>

    <div class="space-y-6">
        @foreach([27 => 'Steve', 28 => 'David', 29 => 'Susan', 30 => 'Olive'] as $q => $name)
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $name }}</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[{{ $q }}]" value="S" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">S</span><span>Social History</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[{{ $q }}]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>Cultural Studies</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[{{ $q }}]" value="P" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">P</span><span>Political Theory</span>
                </label>
            </div>
        </div>
        @endforeach
    </div>
</div>
