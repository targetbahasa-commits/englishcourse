<?php
$filePath = __DIR__ . '/resources/views/assignments/ielts/mockup/reading-test-2.blade.php';
$content = file_get_contents($filePath);

$passage2_html = <<<EOT

                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-12 mb-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Passage 2 --}}
                <div class="mb-6">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">I contain multitudes</h3>
                    <p class="text-center italic text-gray-700 mb-8">Wendy Moore reviews Ed Yong's book about microbes</p>

                        {{-- Passage text --}}
                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                             @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                             @click="if(eraserMode) window.removeHighlight(\$event);">
                            <p>Microbes, most of them bacteria, have populated this planet since long before animal life developed and they will outlive us. Invisible to the naked eye, they are ubiquitous. They inhabit the soil, air, rocks and water and are present within every form of life, from seaweed and coral to dogs and humans. And, as Yong explains in his utterly absorbing and hugely important book, we mess with them at our peril.</p>
                            <p>Every species has its own colony of microbes, called a 'microbiome', and these microbes vary not only between species but also between individuals and within different parts of each individual. What is amazing is that while the number of human cells in the average person is about 30 trillion, the number of microbial ones is higher &ndash; about 39 trillion. At best, Yong informs us, we are only 50 per cent human. Indeed, some scientists even suggest we should think of each species and its microbes as a single unit, dubbed a 'holobiont'.</p>
                            <p>In each human there are microbes that live only in the stomach, the mouth or the armpit and by and large they do so peacefully. So 'bad' microbes are just microbes out of context. Microbes that sit contentedly in the human gut (where there are more microbes than there are stars in the galaxy) can become deadly if they find their way into the bloodstream. These communities are constantly changing too. The right hand shares just one sixth of its microbes with the left hand. And, of course, we are surrounded by microbes. Every time we eat, we swallow a million microbes in each gram of food; we are continually swapping microbes with other humans, pets and the world at large.</p>
                            <p>It's a fascinating topic and Yong, a young British science journalist, is an extraordinarily adept guide. Writing with lightness and panache, he has a knack of explaining complex science in terms that are both easy to understand and totally enthralling. Yong is on a mission. Leading us gently by the hand, he takes us into the world of microbes &ndash; a bizarre, alien planet &ndash; in a bid to persuade us to love them as much as he does. By the end, we do.</p>
                            <p>For most of human history we had no idea that microbes existed. The first man to see these extraordinarily potent creatures was a Dutch lens-maker called Antony van Leeuwenhoek in the 1670s. Using microscopes of his own design that could magnify up to 270 times, he examined a drop of water from a nearby lake and found it teeming with tiny creatures he called 'animalcules'. It wasn't until nearly two hundred years later that the research of French biologist Louis Pasteur indicated that some microbes caused disease. It was Pasteur's 'germ theory' that gave bacteria the poor image that endures today.</p>
                            <p>Yong's book is in many ways a plea for microbial tolerance, pointing out that while fewer than one hundred species of bacteria bring disease, many thousands more play a vital role in maintaining our health. The book also acknowledges that our attitude towards bacteria is not a simple one. We tend to see the dangers posed by bacteria, yet at the same time we are sold yoghurts and drinks that supposedly nurture 'friendly' bacteria. In reality, says Yong, bacteria should not be viewed as either friends or foes, villains or heroes. Instead we should realise we have a symbiotic relationship, that can be mutually beneficial or mutually destructive.</p>
                            <p>What then do these millions of organisms do? The answer is pretty much everything. New research is now unravelling the ways in which bacteria aid digestion, regulate our immune systems, eliminate toxins, produce vitamins, affect our behaviour and even combat obesity. 'They actually help us become who we are,' says Yong. But we are facing a growing problem. Our obsession with hygiene, our overuse of antibiotics and our unhealthy, low-fibre diets are disrupting the bacterial balance and may be responsible for soaring rates of allergies and immune problems, such as inflammatory bowel disease (IBD).</p>
                            <p>The most recent research actually turns accepted norms upside down. For example, there are studies indicating that the excessive use of household detergents and antibacterial products actually destroys the microbes that normally keep the more dangerous germs at bay. Other studies show that keeping a dog as a pet gives children early exposure to a diverse range of bacteria, which may help protect them against allergies later.</p>
                            <p>The readers of Yong's book must be prepared for a decidedly unglamorous world. Among the less appealing case studies is one about a fungus that is wiping out entire populations of frogs and that can be halted by a rare microbial bacterium. Another is about squid that carry luminescent bacteria that protect them against predators. However, if you can overcome your distaste for some of the investigations, the reasons for Yong's enthusiasm become clear. The microbial world is a place of wonder. Already, in an attempt to stop mosquitoes spreading dengue fever &ndash; a disease that infects 400 million people a year &ndash; mosquitoes are being loaded with a bacterium to block the disease. In the future, our ability to manipulate microbes means we could construct buildings with useful microbes built into their walls to fight off infections. Just imagine a neonatal hospital ward coated in a specially mixed cocktail of microbes so that babies get the best start in life.</p>
                        </div>
                </div>

                <div class="flex justify-center mt-8 mb-8">
                    <!-- Placeholder to mark the end of Passage 2 in left pane -->
                </div>
EOT;

$questions2_html = <<<EOT

                {{-- Q14-16: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–16</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 14–16 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [14, 'What point does the writer make about microbes in the first paragraph?', [
                                'A' => 'They adapt quickly to their environment.',
                                'B' => 'The risk they pose has been exaggerated.',
                                'C' => 'They are more plentiful in animal life than plant life.',
                                'D' => 'They will continue to exist for longer than the human race.',
                            ]],
                            [15, 'In the second paragraph, the writer is impressed by the fact that', [
                                'A' => 'each species tends to have vastly different microbes.',
                                'B' => 'some parts of the body contain relatively few microbes.',
                                'C' => 'the average individual has more microbial cells than human ones.',
                                'D' => 'scientists have limited understanding of how microbial cells behave.',
                            ]],
                            [16, 'What is the writer doing in the fifth paragraph?', [
                                'A' => 'explaining how a discovery was made',
                                'B' => 'comparing scientists\' theories about microbes',
                                'C' => 'describing confusion among scientists',
                                'D' => 'giving details of how microbes cause disease',
                            ]],
                        ] as [\$num, \$question, \$opts])
                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-2"><span class="text-blue-600 font-bold mr-1">{{ \$num }}</span> {{ \$question }}</p>
                            <div class="space-y-2 ml-4">
                                @foreach(\$opts as \$letter => \$text)
                                <label class="flex items-start gap-4 cursor-pointer group">
                                    <input type="radio" name="q{{ \$num }}" value="{{ \$letter }}"
                                           class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                    <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                        <strong class="inline-block min-w-[1rem]">{{ \$letter }}</strong>&nbsp; {{ \$text }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Q17-20: Summary Completion (Word Bank) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 17–20</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Complete the summary using the list of words, <strong>A–H</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–H</strong>, in boxes 17–20 on your answer sheet.</p>

                    <div class="border border-gray-300 rounded-lg p-5 bg-gray-50 text-sm mb-5">
                        <h4 class="text-lg font-bold text-center mb-6">We should be more tolerant of microbes</h4>

                        <p class="text-gray-800 leading-[2.5] mb-4">
                            Yong's book argues that we should be more tolerant of microbes. Many have a beneficial effect, and only a relatively small number lead to
                            <strong>17</strong>
                            <select name="q17" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as \$l)
                                <option value="{{ \$l }}">{{ \$l }}</option>
                                @endforeach
                            </select>
                            . And although it is misleading to think of microbes as 'friendly', we should also stop thinking of them as the enemy. In fact, we should accept that our relationship with microbes is one based on
                            <strong>18</strong>
                            <select name="q18" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as \$l)
                                <option value="{{ \$l }}">{{ \$l }}</option>
                                @endforeach
                            </select>
                            .
                        </p>
                        <p class="text-gray-800 leading-[2.5] mb-4">
                            New research shows that microbes have numerous benefits for humans. Amongst other things, they aid digestion, remove poisons, produce vitamins and may even help reduce obesity. However, there is a growing problem. Our poor
                            <strong>19</strong>
                            <select name="q19" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as \$l)
                                <option value="{{ \$l }}">{{ \$l }}</option>
                                @endforeach
                            </select>
                            , our overuse of antibiotics, and our excessive focus on
                            <strong>20</strong>
                            <select name="q20" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as \$l)
                                <option value="{{ \$l }}">{{ \$l }}</option>
                                @endforeach
                            </select>
                            are upsetting the bacterial balance and may be contributing to the huge increase in allergies and immune system problems.
                        </p>
                    </div>

                    {{-- Word bank --}}
                    <div class="border border-gray-400 p-5 bg-white text-[15px] mx-auto w-full mb-2">
                        <div class="grid gap-x-6 gap-y-4 font-sans" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
                            @foreach([
                                'A' => 'solution', 'B' => 'partnership', 'C' => 'destruction',
                                'D' => 'exaggeration', 'E' => 'cleanliness', 'F' => 'regulations',
                                'G' => 'illness', 'H' => 'nutrition'
                            ] as \$l => \$w)
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4">{{ \$l }}</span> <span class="text-gray-800">{{ \$w }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Questions 21–26: Yes/No/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 21–26</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 2?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 21–26 on your answer sheet, write</p>

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
                                    [21, "It is possible that using antibacterial products in the home fails to have the desired effect."],
                                    [22, "It is a good idea to ensure that children come into contact with as few bacteria as possible."],
                                    [23, "Yong's book contains more case studies than are necessary."],
                                    [24, "The case study about bacteria that prevent squid from being attacked may have limited appeal."],
                                    [25, "Efforts to control dengue fever have been surprisingly successful."],
                                    [26, "Microbes that reduce the risk of infection have already been put inside the walls of some hospital wards."],
                                ] as [\$num, \$statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ \$num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ \$statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ \$num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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

EOT;

// Find insertion point for left pane (reading passage)
$left_insert_point = "                <div class=\"sticky bottom-6 w-full flex flex-col items-center pointer-events-none z-30 mt-4 mb-2\">";
if (($pos = strpos($content, $left_insert_point)) !== false) {
    if (strpos($content, 'READING PASSAGE 2') === false) {
        $content = substr_replace($content, $passage2_html . "\n" . $left_insert_point, $pos, strlen($left_insert_point));
    }
}

// Find insertion point for right pane (questions)
$right_insert_point = "                <div class=\"flex justify-center mt-8 mb-8\">";
// We want the SECOND occurrence of this, which is at the end of the right pane before submit
$parts = explode($right_insert_point, $content);
if (count($parts) >= 3) {
    // Reconstruct with questions inserted before the last "Submit Reading Answers" button
    $content = $parts[0] . $right_insert_point . $parts[1] . $questions2_html . "\n" . $right_insert_point . $parts[2];
}

file_put_contents($filePath, $content);
echo "Passage 2 and Questions 14-26 inserted.\n";
?>
