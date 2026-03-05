<?php

$filePath = __DIR__ . '/resources/views/assignments/ielts/mockup/reading-test-2.blade.php';

if (!file_exists($filePath)) {
    die("File not found: " . $filePath . "\n");
}

$content = file_get_contents($filePath);

$passage3_html = <<<'EOT'
                {{-- ── PASSAGE 3 ── --}}
                <div class="mt-12 mb-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">How to make wise decisions</h3>

                        {{-- Passage text --}}
                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                             @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                             @click="if(eraserMode) window.removeHighlight($event);">
                            <p>Across cultures, wisdom has been considered one of the most revered human qualities. Although the truly wise may seem few and far between, empirical research examining wisdom suggests that it isn’t an exceptional trait possessed by a small handful of bearded philosophers after all – in fact, the latest studies suggest that most of us have the ability to make wise decisions, given the right context.</p>
                            <p>‘It appears that experiential, situational, and cultural factors are even more powerful in shaping wisdom than previously imagined,’ says Associate Professor Igor Grossmann of the University of Waterloo in Ontario, Canada. ‘Recent empirical findings from cognitive, developmental, social, and personality psychology cumulatively suggest that people’s ability to reason wisely varies dramatically across experiential and situational contexts. Understanding the role of such contextual factors offers unique insights into understanding wisdom in daily life, as well as how it can be enhanced and taught.’</p>
                            <p>It seems that it’s not so much that some people simply possess wisdom and others lack it, but that our ability to reason wisely depends on a variety of external factors. ‘It is impossible to characterize thought processes attributed to wisdom without considering the role of contextual factors,’ explains Grossmann. ‘In other words, wisdom is not solely an “inner quality” but rather unfolds as a function of situations people happen to be in. Some situations are more likely to promote wisdom than others.’</p>
                            <p>Coming up with a definition of wisdom is challenging, but Grossmann and his colleagues have identified four key characteristics as part of a framework of wise reasoning. One is intellectual humility or recognition of the limits of our own knowledge, and another is appreciation of perspectives wider than the issue at hand. Sensitivity to the possibility of change in social relations is also key, along with compromise or integration of different attitudes and beliefs.</p>
                            <p>Grossmann and his colleagues have also found that one of the most reliable ways to support wisdom in our own day-to-day decisions is to look at scenarios from a third-party perspective, as though giving advice to a friend. Research suggests that when adopting a first-person viewpoint we focus on ‘the focal features of the environment’ and when we adopt a third-person, ‘observer’ viewpoint we reason more broadly and focus more on interpersonal and moral ideals such as justice and impartiality. Looking at problems from this more expansive viewpoint appears to foster cognitive processes related to wise decisions.</p>
                            <p>What are we to do, then, when confronted with situations like a disagreement with a spouse or negotiating a contract at work, that require us to take a personal stake? Grossmann argues that even when we aren’t able to change the situation, we can still evaluate these experiences from different perspectives.</p>
                            <p>For example, in one experiment that took place during the peak of a recent economic recession, graduating college seniors were asked to reflect on their job prospects. The students were instructed to imagine their career either ‘as if you were a distant observer’ or ‘before your own eyes as if you were right there’. Participants in the group assigned to the ‘distant observer’ role displayed more wisdom-related reasoning (intellectual humility and recognition of change) than did participants in the control group.</p>
                            <p>In another study, couples in long-term romantic relationships were instructed to visualize an unresolved relationship conflict either through the eyes of an outsider or from their own perspective. Participants then discussed the incident with their partner for 10 minutes, after which they wrote down their thoughts about it. Couples in the ‘other’s eyes’ condition were significantly more likely to rely on wise reasoning – recognizing others’ perspectives and searching for a compromise – compared to the couples in the egocentric condition.</p>
                            <p>‘Ego-decentering promotes greater focus on others and enables a bigger picture, conceptual view of the experience, affording recognition of intellectual humility and change,’ says Grossmann.</p>
                            <p>We might associate wisdom with intelligence or particular personality traits, but research shows only a small positive relationship between wise thinking and crystallized intelligence and the personality traits of openness and agreeableness. ‘It is remarkable how much people can vary in their wisdom from one situation to the next, and how much stronger such contextual effects are for understanding the relationship between wise judgment and its social and affective outcomes as compared to the generalized “traits”,’ Grossmann explains. ‘That is, knowing how wisely a person behaves in a given situation is more informative for understanding their emotions or likelihood to forgive [or] retaliate as compared to knowing whether the person may be wise “in general”.’</p>
                        </div>
                </div>
EOT;

$questions3_html = <<<'EOT'
                {{-- Q27-30: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–30</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 27–30 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [27, 'What point does the writer make in the first paragraph?', [
                                'A' => 'Wisdom appears to be unique to the human race.',
                                'B' => 'A basic assumption about wisdom may be wrong.',
                                'C' => 'Concepts of wisdom may depend on the society we belong to.',
                                'D' => 'There is still much to be discovered about the nature of wisdom.',
                            ]],
                            [28, 'What does Igor Grossmann suggest about the ability to make wise decisions?', [
                                'A' => 'It can vary greatly from one person to another.',
                                'B' => 'Earlier research into it was based on unreliable data.',
                                'C' => 'The importance of certain influences on it was underestimated.',
                                'D' => 'Various branches of psychology define it according to their own criteria.',
                            ]],
                            [29, 'According to the third paragraph, Grossmann claims that the level of wisdom an individual shows', [
                                'A' => 'can be greater than they think it is.',
                                'B' => 'will be different in different circumstances.',
                                'C' => 'may be determined by particular aspects of their personality.',
                                'D' => 'should develop over time as a result of their life experiences.',
                            ]],
                            [30, 'What is described in the fifth paragraph?', [
                                'A' => 'a difficulty encountered when attempting to reason wisely',
                                'B' => 'an example of the type of person who is likely to reason wisely',
                                'C' => 'a controversial view about the benefits of reasoning wisely',
                                'D' => 'a recommended strategy that can help people to reason wisely',
                            ]],
                        ] as [$num, $question, $opts])
                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-2"><span class="text-blue-600 font-bold mr-1">{{ $num }}</span> {{ $question }}</p>
                            <div class="space-y-2 ml-4">
                                @foreach($opts as $letter => $text)
                                <label class="flex items-start gap-4 cursor-pointer group">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}"
                                           class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                    <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                        <strong class="inline-block min-w-[1rem]">{{ $letter }}</strong>&nbsp; {{ $text }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Q31-35: Summary Completion (Word Bank) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 31–35</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Complete the summary using the list of words, <strong>A–J</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–J</strong>, in boxes 31–35 on your answer sheet.</p>

                    <div class="border border-gray-300 rounded-lg p-5 bg-gray-50 text-sm mb-5">
                        <h4 class="text-lg font-bold text-center mb-6">The characteristics of wise reasoning</h4>

                        <p class="text-gray-800 leading-[2.5] mb-4">
                            Igor Grossmann and colleagues have established four characteristics which enable us to make wise decisions. It is important to have a certain degree of
                            <strong>31</strong>
                            <select name="q31" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            regarding the extent of our knowledge, and to take into account
                            <strong>32</strong>
                            <select name="q32" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            which may not be the same as our own. We should also be able to take a broad
                            <strong>33</strong>
                            <select name="q33" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            of any situation. Another key characteristic is being aware of the likelihood of alterations in the way that people relate to each other.
                        </p>
                        <p class="text-gray-800 leading-[2.5] mb-4">
                            Grossmann also believes that it is better to regard scenarios with
                            <strong>34</strong>
                            <select name="q34" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            . By avoiding the first-person perspective, we focus more on
                            <strong>35</strong>
                            <select name="q35" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            and on other moral ideals, which in turn leads to wiser decision-making.
                        </p>
                    </div>

                    {{-- Word bank --}}
                    <div class="border border-gray-400 p-5 bg-white text-[15px] mx-auto w-full mb-2">
                        <div class="grid gap-x-6 gap-y-4 font-sans" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
                            @foreach([
                                'A' => 'opinions', 'B' => 'confidence', 'C' => 'view',
                                'D' => 'modesty', 'E' => 'problems', 'F' => 'objectivity',
                                'G' => 'fairness', 'H' => 'experiences', 'I' => 'range', 'J' => 'reasons'
                            ] as $l => $w)
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4">{{ $l }}</span> <span class="text-gray-800">{{ $w }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Questions 36–40: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 36–40</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 36–40 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                            <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
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
                                    [36, "Students participating in the job prospects experiment could choose one of two perspectives to take."],
                                    [37, "Participants in the couples experiment were aware that they were taking part in a study about wise reasoning."],
                                    [38, "In the couples experiments, the length of the couples’ relationships had an impact on the results."],
                                    [39, "In both experiments, the participants who looked at the situation from a more detached viewpoint tended to make wiser decisions."],
                                    [40, "Grossmann believes that a person’s wisdom is determined by their intelligence to only a very limited extent."],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                <option value="TRUE">TRUE</option>
                                                <option value="FALSE">FALSE</option>
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
EOT;

// Find insertion point for left pane (reading passage)
$left_insert_point = "                <div class=\"sticky bottom-6 w-full flex flex-col items-center pointer-events-none z-30 mt-4 mb-2\">";
if (($pos = strpos($content, $left_insert_point)) !== false) {
    if (strpos($content, 'READING PASSAGE 3') === false) {
        $content = substr_replace($content, $passage3_html . "\n" . $left_insert_point, $pos, strlen($left_insert_point));
    }
}

// Find insertion point for right pane (questions)
$right_insert_point = "                <div class=\"flex justify-center mt-8 mb-8\">";
// Start searching ONLY after Questions 21-26 to guarantee we're in the right pane
$offset = strpos($content, 'Questions 21–26');
if ($offset !== false && ($pos = strpos($content, $right_insert_point, $offset)) !== false) {
    if (strpos($content, 'The characteristics of wise reasoning') === false) {
        $content = substr_replace($content, $questions3_html . "\n" . $right_insert_point, $pos, strlen($right_insert_point));
    }
}

file_put_contents($filePath, $content);
echo "Passage 3 and Questions 27-40 inserted.\n";

?>
