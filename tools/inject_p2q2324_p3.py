file_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/ielts/mockup/c20-reading-test-2.blade.php"

with open(file_path, 'r') as f:
    content = f.read()

# -------------------------------------------------------------------
# 1. Replace Passage 3 placeholder with full text
# -------------------------------------------------------------------
old_p3 = """                {{-- Passage 3 --}}
                <div class="mb-6 mt-16 pt-8 border-t border-gray-200">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">Coming Soon</p>
                </div>"""

new_p3 = """                {{-- Passage 3 --}}
                <div class="mb-6 mt-16 pt-8 border-t border-gray-200">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-8 mt-4">Invasion of the Robot Umpires</h3>

                    <div class="passage-content text-[16px] leading-[1.8] text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>A few years ago, Fred DeJesus from Brooklyn, New York became the first umpire in a minor league baseball game to use something called the Automated Ball-Strike System (ABS), often referred to as the 'robo-umpire'. Instead of making any judgments himself about a strike*, DeJesus had decisions fed to him through an earpiece, connected to a modified missile-tracking system. The contraption looked like a large black pizza box with one glowing green eye; it was mounted above the press stand.</p>

                        <p>Major League Baseball (MLB), who had commissioned the system, wanted human umpires to announce the calls, just as they would have done in the past. When the first pitch came in, a recorded voice told DeJesus it was a strike. Previously, calling a strike was a judgment call on the part of the umpire. Even if the batter does not hit the ball, a pitch that passes through the 'strike zone' (an imaginary zone about seventeen inches wide, stretching from the batter's knees to the middle of his chest) is considered a strike. During that first game, when DeJesus announced calls, there was no heckling and no shouted disagreement. Nobody said a word.</p>

                        <p>For a hundred and fifty years or so, the strike zone has been the game's animating force—countless arguments between a team's manager and the umpire have taken place over its boundaries and whether a ball had crossed through it. The rules of play have evolved in various stages. Today, everyone knows that you may scream your disagreement in an umpire's face, but you must never shout personal abuse at them or touch them. That's a no-no. When the robo-umpires came, however, the arguments stopped.</p>

                        <p>During the first robo-umpire season, players complained about some strange calls. In response, MLB decided to tweak the dimensions of the zone, and the following year the consensus was that ABS is profoundly consistent. MLB says the device is near-perfect, precise to within fractions of an inch. "It'll reduce controversy in the game, and be good for the game," says Rob Manfred, who is Commissioner for MLB. But the question is whether controversy is worth reducing, or whether it is the sign of a human hand.</p>

                        <p>A human, at least, yells back. When I spoke with Frank Viola, a coach for a North Carolina team, he said that ABS works as designed, but that it was also unforgiving and pedantic, almost legalistic. "Manfred is a lawyer," Viola noted. Some pitchers have complained that, compared with a human's, the robot's strike zone seems too precise. Viola was once a major-league player himself. When he was pitching, he explained, umpires rewarded skill. "Throw it where you aimed, and it would be a strike, even if it was an inch or two outside. There was a dialogue between pitcher and umpire."</p>

                        <p>The executive tasked with running the experiment for MLB is Morgan Sword, who's in charge of baseball operations. According to Sword, ABS was part of a larger project to make baseball more exciting since executives are terrified of losing younger fans, as has been the case with horse racing and boxing. He explains how they began the process by asking fans what version of baseball they found most exciting. The results showed that everyone wanted more action: more hits, more defense, more baserunning. This type of baseball essentially hasn't existed since the 1960s, when the hundred-mile-an-hour fastball, which is difficult to hit and control, entered the game. It flattened the game into strikeouts, walks, and home runs—a type of play lacking much action.</p>

                        <p>Sword's team brainstormed potential fixes. Any rule that existed, they talked about changing—from changing the bats to changing the geometry of the field. But while all of these were ruled out as potential fixes, ABS was seen as a perfect vehicle for change. According to Sword, once you get the technology right, you can load any strike zone you want into the system. "It might be a triangle, or a blob, or something shaped like Texas. Over time, as baseball evolves, ABS can allow the zone to change with it."</p>

                        <p>"In the past twenty years, sports have moved away from judgment calls. Soccer has Video Assistant Referees (for offside decisions, for example). Tennis has Hawk-Eye (for line calls, for example). For almost a decade, baseball has used instant replay on the base paths. This is widely liked, even if the precision can sometimes cause problems. But these applications deal with something physical: bases, lines, goals. The boundaries of action are precise, delineated like the keys of a piano. This is not the case with ABS and the strike zone. Historically, a certain discretion has been appreciated."</p>

                        <p>I decided to email Alva Noë, a professor at Berkeley University and a baseball fan, for his opinion. "Hardly a day goes by that I don't wake up and run through the reasons that this [robo-umpires] is such a terrible idea," he replied. He later told me, "This is part of a movement to use algorithms to take the hard choices of living out of life." Perhaps he's right. We watch baseball to kill time, not to maximize it. Some players I have met take a dissenting stance toward the robots too, believing that accuracy is not the answer. According to Joe Russo, who plays for a New Jersey team, "With technology, people just want everything to be perfect. That's not reality. I think perfect would be weird. Your teams are always winning, work is always just great, there's always money in your pocket, your car never breaks down. What is there to talk about?"</p>

                        <p class="text-sm italic text-gray-600 mt-4 border-t border-gray-100 pt-4">* <em>strike: a strike is when the batter swings at a ball and misses or when the batter does not swing at a ball that passes through the strike zone.</em></p>
                    </div>
                </div>"""

content = content.replace(old_p3, new_p3)

# -------------------------------------------------------------------
# 2. Add Q23-26 before the Final Submit button
# -------------------------------------------------------------------
q23_26_html = """
                {{-- Q23-24: Choose TWO letters --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23 and 24</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>

                    <p class="text-sm font-semibold text-gray-900 mb-4">Which <strong>TWO</strong> comparisons between employees who often procrastinate and those who do not are mentioned in the text?</p>

                    <div class="space-y-3 mb-8" id="q23-24-group">
                        @foreach([
                            'A' => 'Their salaries are lower.',
                            'B' => 'The quality of their work is inferior.',
                            'C' => 'They don\'t keep their jobs for as long.',
                            'D' => 'They don\'t enjoy their working lives as much.',
                            'E' => 'They have poorer relationships with colleagues.',
                        ] as $letter => $text)
                        <label class="flex items-center gap-3 cursor-pointer group p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-200 transition-all">
                            <input type="checkbox" name="q23_24[]" value="{{ $letter }}"
                                   class="multi-select-2 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none"
                                   data-group="q23-24-group">
                            <span class="text-sm text-gray-800"><strong class="mr-2">{{ $letter }}</strong>{{ $text }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Q25-26: Choose TWO letters --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 25 and 26</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>

                    <p class="text-sm font-semibold text-gray-900 mb-4">Which <strong>TWO</strong> recommendations for getting out of a cycle of procrastination does the writer give?</p>

                    <div class="space-y-3" id="q25-26-group">
                        @foreach([
                            'A' => 'not judging ourselves harshly',
                            'B' => 'setting ourselves manageable aims',
                            'C' => 'rewarding ourselves for tasks achieved',
                            'D' => 'prioritising tasks according to their importance',
                            'E' => 'avoiding things that stop us concentrating on our tasks',
                        ] as $letter => $text)
                        <label class="flex items-center gap-3 cursor-pointer group p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-200 transition-all">
                            <input type="checkbox" name="q25_26[]" value="{{ $letter }}"
                                   class="multi-select-2 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none"
                                   data-group="q25-26-group">
                            <span class="text-sm text-gray-800"><strong class="mr-2">{{ $letter }}</strong>{{ $text }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

"""

# Inject Q23-26 before the Passage 3 header divider
p3_header_token = """                {{-- ── PASSAGE 3 Questions ── --}}"""
if p3_header_token in content:
    content = content.replace(p3_header_token, q23_26_html + "\n" + p3_header_token)
else:
    # fallback: inject before final submit
    final_submit_token = "                {{-- Final Submit --}}"
    content = content.replace(final_submit_token, q23_26_html + "\n" + final_submit_token)

# -------------------------------------------------------------------
# 3. Add JS for max-2 checkbox enforcement (if not already there)
# -------------------------------------------------------------------
max2_js = """
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.multi-select-2').forEach(function(cb) {
            cb.addEventListener('change', function() {
                var groupId = this.dataset.group;
                var group = document.getElementById(groupId);
                if (!group) return;
                var checked = group.querySelectorAll('.multi-select-2:checked');
                if (checked.length > 2) {
                    // Uncheck the first one
                    checked[0].checked = false;
                }
            });
        });
    });
    </script>
"""

if 'multi-select-2' in content and 'max-2' not in content:
    # Append just before </body>
    content = content.replace('</body>', max2_js + '\n</body>')

with open(file_path, 'w') as f:
    f.write(content)

print("Done: Passage 3 text + Q23-26 injected.")
