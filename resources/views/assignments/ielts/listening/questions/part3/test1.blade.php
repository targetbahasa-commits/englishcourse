<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-24: Table Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-24</h4>
    <p class="mb-2 text-gray-700">Complete the timetable.</p>
    <p class="mb-6 text-gray-700 italic">Write the correct letter, <strong>A-H</strong>, for each answer.</p>

    <div class="mb-8 overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300 text-gray-700">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border border-gray-300 px-4 py-3 text-left w-1/3"></th>
                    <th class="border border-gray-300 px-4 py-3 text-center font-bold">Morning</th>
                    <th class="border border-gray-300 px-4 py-3 text-center font-bold">Afternoon</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-4 py-3 font-bold">Monday</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">Opening Lecture</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <strong class="text-blue-600">21</strong>
                            <select name="answers[21]" class="border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white cursor-pointer w-20">
                                <option value="" disabled selected>___</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $letter)
                                    <option value="{{ $letter }}">{{ $letter }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="border border-gray-300 px-4 py-3 font-bold">Tuesday</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <strong class="text-blue-600">22</strong>
                            <select name="answers[22]" class="border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white cursor-pointer w-20">
                                <option value="" disabled selected>___</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $letter)
                                    <option value="{{ $letter }}">{{ $letter }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td class="border border-gray-300 px-4 py-3 text-center">Study Skills</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-3 font-bold">Wednesday</td>
                    <td class="border border-gray-300 px-4 py-3 text-center text-gray-400">x</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <strong class="text-blue-600">23</strong>
                            <select name="answers[23]" class="border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white cursor-pointer w-20">
                                <option value="" disabled selected>___</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $letter)
                                    <option value="{{ $letter }}">{{ $letter }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="border border-gray-300 px-4 py-3 font-bold">Thursday</td>
                    <td class="border border-gray-300 px-4 py-3 text-center text-gray-400">x</td>
                    <td class="border border-gray-300 px-4 py-3 text-center text-gray-400">x</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-3 font-bold">Friday</td>
                    <td class="border border-gray-300 px-4 py-3 text-center text-gray-400">x</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <strong class="text-blue-600">24</strong>
                            <select name="answers[24]" class="border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white cursor-pointer w-20">
                                <option value="" disabled selected>___</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $letter)
                                    <option value="{{ $letter }}">{{ $letter }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Options A-H --}}
    <div class="mb-12 space-y-2 pl-4 text-gray-700">
        <p><strong>A</strong>&nbsp; BBQ</p>
        <p><strong>B</strong>&nbsp; Careers lecture</p>
        <p><strong>C</strong>&nbsp; Computer lab visit</p>
        <p><strong>D</strong>&nbsp; Dance</p>
        <p><strong>E</strong>&nbsp; Library tour</p>
        <p><strong>F</strong>&nbsp; Student Union induction</p>
        <p><strong>G</strong>&nbsp; University tour</p>
        <p><strong>H</strong>&nbsp; Legal rights lecture</p>
    </div>

    {{-- Questions 25-30: Label Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 25-30</h4>
    <p class="mb-2 text-gray-700">Complete the labels.</p>
    <p class="mb-6 text-gray-700">Write <strong>ONE WORD OR A NUMBER</strong> for each answer.</p>

    {{-- Diagram image placeholder --}}
    <div class="mb-8 text-center">
        <div class="inline-block p-4 border-2 border-dashed border-gray-300 bg-gray-50 rounded-lg w-full max-w-xl">
            <p class="text-gray-500 mb-2 font-medium">University Style Guide Diagram</p>
            <p class="text-sm text-gray-400 mb-4">Please upload the diagram image to: <code>public/images/assignments/ielts/listening/part3/test1-diagram.png</code></p>
            <img src="{{ asset('images/assignments/ielts/listening/part3/test1-diagram.png') }}" onerror="this.style.display='none'" class="max-w-full h-auto mx-auto" alt="University Style Guide Diagram">
        </div>
    </div>

    {{-- Q25-30 input list --}}
    <div class="space-y-4 max-w-sm">
        @foreach([25, 26, 27, 28, 29, 30] as $q)
        <div class="flex items-center gap-4">
            <strong class="text-blue-600 w-6">{{ $q }}</strong>
            <input type="text" name="answers[{{ $q }}]"
                class="w-48 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors"
                placeholder="............."
                autocomplete="off" />
        </div>
        @endforeach
    </div>
</div>
