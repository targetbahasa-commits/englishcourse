file_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/ielts/mockup/c20-reading-test-2.blade.php"

with open(file_path, 'r') as f:
    content = f.read()

q27_40_html = """
                {{-- ── PASSAGE 3 Questions ── --}}
                <div class="mt-12 mb-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Q27-32: YES/NO/NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–32</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 27–32 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">YES</span></div><div class="italic">if the statement agrees with the claims of the writer</div>
                            <div><span class="font-bold italic">NO</span></div><div class="italic">if the statement contradicts the claims of the writer</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if it is impossible to say what the writer thinks about this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-2">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [27, 'When DeJesus first used ABS, he shared decision-making about strikes with it.'],
                                    [28, 'MLB considered it necessary to amend the size of the strike zone when criticisms were received from players.'],
                                    [29, 'MLB is keen to justify the money spent on improving the accuracy of ABS\'s calculations.'],
                                    [30, 'The hundred-mile-an-hour fastball led to a more exciting style of play.'],
                                    [31, 'The differing proposals for alterations to the baseball bat led to fierce debate on Sword\'s team.'],
                                    [32, 'ABS makes changes to the shape of the strike zone feasible.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                                <option value="NOT GIVEN">NOT GIVEN</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Q33-37: Summary Completion from list A-H --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 33–37</strong></p>
                    <p class="text-sm text-gray-800 mb-5">Complete the summary using the list of phrases, <strong>A–H</strong>, below.</p>

                    {{-- Phrase list --}}
                    <div class="border border-gray-200 rounded-xl bg-gray-50 p-5 mb-6 text-sm">
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2">
                            @foreach(['A' => 'pitch boundary', 'B' => 'numerous disputes', 'C' => 'team tactics', 'D' => 'subjective assessment', 'E' => 'widespread approval', 'F' => 'former roles', 'G' => 'total silence', 'H' => 'perceived area'] as $letter => $phrase)
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-700 w-5 flex-none">{{ $letter }}.</span>
                                <span class="bg-blue-50 border border-blue-200 text-blue-800 rounded-lg px-3 py-1.5 font-medium text-sm">{{ $phrase }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="border border-blue-200 bg-[#f8fafc] rounded-lg p-6 text-sm">
                        <h4 class="text-lg font-bold text-center mb-6 text-gray-900 border-b border-gray-200 pb-3">Calls by the umpire</h4>
                        <div class="text-gray-800 leading-[2.8] space-y-2">
                            <p>
                                Even after ABS was developed, MLB still wanted human umpires to shout out decisions as they had in their
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">33</span>
                                <div class="relative inline-block w-40 align-middle">
                                    <select name="q33" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>.
                                The umpire's job had, at one time, required a
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">34</span>
                                <div class="relative inline-block w-44 align-middle">
                                    <select name="q34" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>
                                about whether a ball was a strike.
                            </p>
                            <p>
                                A ball is considered a strike when the batter does not hit it and it crosses through a
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">35</span>
                                <div class="relative inline-block w-36 align-middle">
                                    <select name="q35" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>
                                extending approximately from the batter's knee to his chest.
                            </p>
                            <p>
                                In the past,
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">36</span>
                                <div class="relative inline-block w-44 align-middle">
                                    <select name="q36" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>
                                over strike calls were not uncommon, but today everyone accepts the complete ban on pushing or shoving the umpire. One difference, however, is that during the first game DeJesus used ABS, strike calls were met with
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">37</span>
                                <div class="relative inline-block w-36 align-middle">
                                    <select name="q37" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Q38-40: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 38–40</strong></p>
                    <p class="text-sm text-gray-800 mb-5">Choose the correct letter, <strong>A, B, C or D</strong>.</p>

                    <div class="space-y-7">
                        @foreach([
                            [38, 'What does the writer suggest about ABS in the fifth paragraph?', [
                                'A' => 'It is bound to make key decisions that are wrong.',
                                'B' => 'It may reduce some of the appeal of the game.',
                                'C' => 'It will lead to the disappearance of human umpires.',
                                'D' => 'It may increase calls for the rules of baseball to be changed.',
                            ]],
                            [39, 'Morgan Sword says that the introduction of ABS', [
                                'A' => 'was regarded as an experiment without a guaranteed outcome.',
                                'B' => 'was intended to keep up with developments in other sports.',
                                'C' => 'was a response to changing attitudes about the role of sport.',
                                'D' => 'was an attempt to ensure baseball retained a young audience.',
                            ]],
                            [40, 'Why does the writer include the views of Noë and Russo?', [
                                'A' => 'to show that attitudes to technology vary widely',
                                'B' => 'to argue that people have unrealistic expectations of sport',
                                'C' => 'to indicate that accuracy is not the same thing as enjoyment',
                                'D' => 'to suggest that the number of baseball fans needs to increase',
                            ]],
                        ] as [$num, $question, $options])
                        <div>
                            <p class="font-semibold text-gray-900 mb-3 text-sm"><span class="font-bold">{{ $num }}.</span> {{ $question }}</p>
                            <div class="space-y-2 pl-5">
                                @foreach($options as $letter => $text)
                                <label class="flex items-start gap-3 cursor-pointer group p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 flex-none text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                                    <span class="text-sm text-gray-800 group-hover:text-black"><strong class="mr-1.5">{{ $letter }}.</strong>{{ $text }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

"""

final_submit = "                {{-- Final Submit --}}"
content = content.replace(final_submit, q27_40_html + "\n" + final_submit)

with open(file_path, 'w') as f:
    f.write(content)

print("Done: Q27-40 for Passage 3 injected.")
