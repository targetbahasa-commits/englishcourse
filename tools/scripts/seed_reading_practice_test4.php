<?php
/**
 * Seed script: IELTS Reading Practice Test 4
 * Passage 1: "Voyage of Going: beyond the blue line"  → Q1-13
 * Passage 2: "Memory and Age"                          → Q14-27
 * Passage 3: "Facial expression 1"                    → Q28-40
 *
 * material_id = 4
 * Run: /Applications/MAMP/bin/php/php8.4.1/bin/php seed_reading_practice_test4.php
 */

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$materialId = 4;

// Clear existing passages for material_id = 4
$existing = DB::table('ielts_reading_passages')->where('material_id', $materialId)->pluck('id');
if ($existing->count()) {
    DB::table('ielts_reading_questions')->whereIn('passage_id', $existing)->delete();
    DB::table('ielts_reading_passages')->whereIn('id', $existing)->delete();
    echo "Cleared " . $existing->count() . " existing passage(s) for material_id={$materialId}.\n";
}

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 1 — "Voyage of Going: beyond the blue line"
// ════════════════════════════════════════════════════════════════════════════
$p1id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Voyage of Going: beyond the blue line',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong> which are based on Reading Passage 1 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Voyage of Going: beyond the blue line</h2>

<p><strong>A</strong> &nbsp;One feels a certain sympathy for Captain James Cook on the day in 1778 that he "discovered" Hawaii. Then on his third expedition to the Pacific, the British navigator had explored scores of islands across the breadth of the sea, from lush New Zealand to the lonely wastes of Easter Island. This latest voyage had taken him thousands of miles north from the Society Islands to an archipelago so remote that even the old Polynesians back on Tahiti knew nothing about it. Imagine Cook's surprise, then, when the natives of Hawaii came paddling out in their canoes and greeted him in a familiar tongue, one he had heard on virtually every mote of inhabited land he had visited. Marvelling at the ubiquity of this Pacific language and culture, he later wondered in his journal: "How shall we account for this Nation spreading itself so far over this Vast ocean?"</p>

<p><strong>B</strong> &nbsp;Answers have been slow in coming. But now a startling archaeological find on the island of Éfaté, in the Pacific nation of Vanuatu, has revealed an ancient seafaring people, the distant ancestors of today's Polynesians, taking their first steps into the unknown. The discoveries there have also opened a window into the shadowy world of those early voyagers. At the same time, other pieces of this human puzzle are turning up in unlikely places. Climate data gleaned from slow-growing corals around the Pacific and from sediments in alpine lakes in South America may help explain how, more than a thousand years later, the second wave of seafarers beat their way across the entire Pacific.</p>

<p><strong>C</strong> &nbsp;"What we have is a first- or second-generation site containing the graves of some of the Pacific's first explorers," says Spriggs, professor of archaeology at the Australian National University and co-leader of an international team excavating the site. It came to light only by luck. A backhoe operator, digging up topsoil on the grounds of a derelict coconut plantation, scraped open a grave – the first of dozens in a burial ground some 3,000 years old. It is the oldest cemetery ever found in the Pacific islands, and it harbors the bones of an ancient people archaeologists call the Lapita, a label that derives from a beach in New Caledonia where a landmark cache of their pottery was found in the 1950s. They were daring blue-water adventurers who roved the sea not just as explorers but also as pioneers, bringing along everything they would need to build new lives – their families and livestock, taro seedlings and stone tools.</p>

<p><strong>D</strong> &nbsp;Within the span of few centuries, the Lapita stretched the boundaries of their world from the jungle-clad volcanoes of Papua New Guinea to the loneliest coral outliers of Tonga, at least 2,000 miles eastward in the Pacific. Along the way they explored millions of square miles of an unknown sea, discovering and colonizing scores of tropical islands never before seen by human eyes: Vanuatu, New Caledonia, Fiji, Samoa.</p>

<p><strong>E</strong> &nbsp;What little is known or surmised about them has been pieced together from fragments of pottery, animal bones, obsidian flakes, and such oblique sources as comparative linguistics and geochemistry. Although their voyages can be traced back to the northern islands of Papua New Guinea, their language – variants of which are still spoken across the Pacific – came from Taiwan. And their peculiar style of pottery decoration, created by pressing a carved stamp into the clay, probably had its roots in the northern Philippines. With the discovery of the Lapita cemetery on Éfaté, the volume of data available to researchers has expanded dramatically. The bones of at least 62 individuals have been uncovered so far – including old men, young women, even babies – and more skeletons are known to be in the ground. Archaeologists were also thrilled to discover six complete Lapita pots. It's an important find, Spriggs says, for it conclusively identifies the remains as Lapita. "It would be hard for anyone to argue that these aren't Lapita when you have human bones enshrined inside what is unmistakably a Lapita urn."</p>

<p><strong>F</strong> &nbsp;Several lines of evidence also undergird Spriggs's conclusion that this was a community of pioneers making their first voyages into the remote reaches of Oceania. For one thing, the radiocarbon dating of bones and charcoal places them early in the Lapita expansion. For another, the chemical makeup of the obsidian flakes littering the site indicates that the rock wasn't local; instead, it was imported from a large island in Papua New Guinea's the Bismarck Archipelago, the springboard for the Lapita's thrust into the Pacific. A particularly intriguing clue comes from chemical tests on the teeth of several skeletons. DNA teased from these ancient bones may also help answer one of the most puzzling questions in Pacific anthropology: Did all Pacific islanders spring from one source or many? Was there only one outward migration from a single point in Asia, or several from different points? "This represents the best opportunity we've had yet," says Spriggs, "to find out who the Lapita actually were, where they came from, and who their closest descendants are today."</p>

<p><strong>G</strong> &nbsp;"There is one stubborn question for which archaeology has yet to provide any answers: How did the Lapita accomplish the ancient equivalent of a moon landing, many times over? No one has found one of their canoes or any rigging, which could reveal how the canoes were sailed. Nor do the oral histories and traditions of later Polynesians offer any insights, for they segue into myth long before they reach as far back in time as the Lapita." All we can say for certain is that the Lapita had canoes that were capable of ocean voyages, and they had the ability to sail them," says Geoff Irwin, a professor of archaeology at the University of Auckland and an avid yachtsman. Those sailing skills, he says, were developed and passed down over thousands of years by earlier mariners who worked their way through the archipelagoes of the western Pacific making short crossings to islands within sight of each other. Reaching Fiji, as they did a century or so later, meant crossing more than 500 miles of ocean, pressing on day after day into the great blue void of the Pacific. What gave them the courage to lunch out on such a risky voyage?</p>

<p><strong>H</strong> &nbsp;The Lapita's thrust into the Pacific was eastward, against the prevailing trade winds, Irwin notes. Those nagging headwinds, he argues, may have been the key to their success. "They could sail out for days into the unknown and reconnoiter, secure in the knowledge that if they didn't find anything, they could turn about and catch a swift ride home on the trade winds. It's what made the whole thing work." Once out there, skilled seafarers would detect abundant leads to follow to land: seabirds and turtles, coconuts and twigs carried out to sea by the tides and the afternoon pileup of clouds on the horizon that often betokens an island in the distance. Some islands may have broadcast their presence with far less subtlety than a cloud bank. Some of the most violent eruptions anywhere on the planet during the past 10,000 years occurred in Melanesia, which sits nervously in one of the most explosive volcanic regions on Earth. Even less spectacular eruptions would have sent plumes of smoke billowing into the stratosphere and rained ash for hundreds of miles. It's possible that the Lapita saw these signs of distant islands and later sailed off in their direction, knowing they would find land. For returning explorers, successful or not, the geography of their own archipelagoes provided a safety net to keep them from overshooting their home ports and sailing off into eternity.</p>

<p><strong>I</strong> &nbsp;However they did it, the Lapita spread themselves a third of the way across the Pacific, then called it quits for reasons known only to them. Ahead lay the vast emptiness of the central Pacific, and perhaps they were too thinly stretched to venture farther. They probably never numbered more than a few thousand in total, and in their rapid migration eastward they encountered hundreds of islands – more than 300 in Fiji alone. Still, more than a millennium would pass before the Lapita's descendants, a people we now call the Polynesians, struck out in search of new territory.</p>
HTML,
    'order'       => 1,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 1 (Voyage of Going), ID: $p1id\n";

// ── Q1-7: TRUE / FALSE / NOT GIVEN ───────────────────────────────────────────
$tfng1 = [
    'sub_questions' => [
        ['id' => 'q1', 'label' => 'Captain Cook once expected Hawaii might speak another language of people from other Pacific islands.'],
        ['id' => 'q2', 'label' => 'Captain Cook depicted a number of cultural aspects of Polynesians in his journal.'],
        ['id' => 'q3', 'label' => 'Professor Spriggs and his research team went to the Efate to try to find the site of the ancient cemetery.'],
        ['id' => 'q4', 'label' => 'The Lapita completed a journey of around 2,000 miles in a period less than a centenary.'],
        ['id' => 'q5', 'label' => 'The Lapita were the first inhabitants in many Pacific islands.'],
        ['id' => 'q6', 'label' => 'The unknown pots discovered in Efate had once been used for cooking.'],
        ['id' => 'q7', 'label' => 'The urn buried in Efate site was plain as it was without any decoration.'],
    ],
    'options'        => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
    'correct_answer' => ['q1' => 'TRUE', 'q2' => 'FALSE', 'q3' => 'FALSE', 'q4' => 'NOT GIVEN', 'q5' => 'TRUE', 'q6' => 'NOT GIVEN', 'q7' => 'FALSE'],
    'start_number'   => 0,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 1,
    'type'            => 'true_false',
    'question_text'   => 'Do the following statements agree with the information given in Reading Passage 1? Write <strong>TRUE</strong> if the statement agrees with the information, <strong>FALSE</strong> if the statement contradicts the information, or <strong>NOT GIVEN</strong> if there is no information on this.',
    'options'         => json_encode(['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN']),
    'correct_answer'  => json_encode(['q1' => 'TRUE', 'q2' => 'FALSE', 'q3' => 'FALSE', 'q4' => 'NOT GIVEN', 'q5' => 'TRUE', 'q6' => 'NOT GIVEN', 'q7' => 'FALSE']),
    'explanation'     => null,
    'data'            => json_encode($tfng1),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q1-7 (TRUE/FALSE/NOT GIVEN).\n";

// ── Q8-10: Summary Completion ─────────────────────────────────────────────────
$sum1 = [
    'box_title'    => 'Scientific Evidence found in Efate site',
    'instruction'  => 'Complete the following summary using NO MORE THAN TWO WORDS from the Reading Passage for each answer.',
    'summary_text' => 'Tests show the human remains and the charcoal found in the buried urn are from the start of the Lapita period. Yet the [8] covering many of the Efate sites did not come from that area. Then examinations carried out on the [9] discovered at Efate site reveal that not everyone buried there was a native living in the area. In fact, DNA could identify the Lapita\'s nearest [10] present-days.',
    'blanks' => [
        ['id' => 'q8', 'blank_number' => 8],
        ['id' => 'q9', 'blank_number' => 9],
        ['id' => 'q10', 'blank_number' => 10],
    ],
    'correct_answer' => ['q8' => 'obsidian flakes', 'q9' => 'teeth', 'q10' => 'descendants'],
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 8,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the following summary using <strong>NO MORE THAN TWO WORDS</strong> from the Reading Passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q8' => 'obsidian flakes', 'q9' => 'teeth', 'q10' => 'descendants']),
    'explanation'     => null,
    'data'            => json_encode($sum1),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q8-10 (Summary Completion).\n";

// ── Q11-13: Short Answer ──────────────────────────────────────────────────────
$sa1 = [
    'instruction'   => 'Answer the questions below. Choose NO MORE THAN THREE WORDS AND/OR A NUMBER from the passage for each answer.',
    'sub_questions' => [
        ['id' => 'q11', 'label' => 'What did the Lapita travel in when they crossed the oceans?'],
        ['id' => 'q12', 'label' => 'In Irwin\'s view, what would the Lapita have relied on to bring them fast back to the base?'],
        ['id' => 'q13', 'label' => 'Which sea creatures would have been an indication to the Lapita of where to find land?'],
    ],
    'correct_answer' => ['q11' => 'canoes', 'q12' => 'trade winds', 'q13' => 'seabirds and turtles'],
    'start_number'   => 10,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 11,
    'type'            => 'short_answer_group',
    'question_text'   => 'Answer the questions below. Choose <strong>NO MORE THAN THREE WORDS AND/OR A NUMBER</strong> from the passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q11' => 'canoes', 'q12' => 'trade winds', 'q13' => 'seabirds and turtles']),
    'explanation'     => null,
    'data'            => json_encode($sa1),
    'order'           => 3,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q11-13 (Short Answer).\n";

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 2 — "Memory and Age"
// ════════════════════════════════════════════════════════════════════════════
$p2id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Memory and Age',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 14–27</strong> which are based on Reading Passage 2 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Memory and Age</h2>

<p><strong>A</strong> &nbsp;Aging, it is now clear, is part of an ongoing maturation process that all our organs go through. "In a sense, aging is keyed to the level of the vigor of the body and the continuous interaction between levels of body activity and levels of mental activity," reports Arnold B. Scheibel, M.D., whose very academic title reflects how once far-flung domains now converge on the mind and the brain. Scheibel is a professor of anatomy, cell biology, psychiatry, and behavioral sciences at the University of California at Los Angeles, and director of university's Brain Research Institute. Experimental evidence has backed up popular assumptions that the aging mind undergoes decay analogous to that of the aging body. Younger monkeys, chimps, and lower animals consistently outperform their older colleagues on memory tests. In humans, psychologists concluded, memory and other mental functions deteriorate over time because of inevitable organic changes in the brain as neurons die off. The mental decline after young adulthood appeared inevitable.</p>

<p><strong>B</strong> &nbsp;Equipped with imaging techniques that capture the brain in action, Stanley Rapoport, Ph.D., at the National Institutes of Health, measured the flow of blood in the brains of old and young people as they went through the task of matching photos of faces. Since blood flow reflects neuronal activity, Rapoport could compare which networks of neurons were being used by different subjects. "Even when the reaction times of older and younger subjects were the same, the neural networks they used were significantly different. The older subjects were using different internal strategies to accomplish the same result in the same time," Rapoport says. Either the task required greater effort on the part of the older subjects or the work of neurons originally involved in tasks of that type had been taken over by other neurons, creating different networks.</p>

<p><strong>C</strong> &nbsp;At the Georgia Institute of Technology, psychologist Timothy Salthouse, Ph.D., compared a group of very fast and accurate typists of college-age with another group in their 60s. Since reaction time is faster in younger people and most people's fingers grow less nimble with age, younger typists might be expected to tap right along while the older ones fumble. But both typed 60 words a minute. The older typists, it turned out, achieved their speed with cunning little strategies that made them far more efficient than their younger counterparts: They made fewer finger movements, saving a fraction of a second here and there. They also read ahead in the text. The neural networks involved in typing appear to have been reshaped to compensate for losses in motor skills or other age changes.</p>

<p><strong>D</strong> &nbsp;"When a rat is kept in isolation without playmates or objects to interact with, the animal's brain shrinks, but if we put that rat with 11 other rats in a large cage and give them an assortment of wheels, ladders, and other toys, we can show—after four days—significant differences in its brain," says Diamond, professor of integrative biology. Proliferating dendrites first appear in the visual association areas. After a month in the enriched environment, the whole cerebral cortex has expanded, as has its blood supply. Even in the enriched environment, rats get bored unless the toys are varied. "Animals are just like we are. They need stimulation," says Diamond.</p>

<p>One of the most profoundly important mental functions is memory—notorious for its failure with age. So important is memory that the Charles A. Dana Foundation recently spent $8.4 million to set up a consortium of leading medical centers to measure memory loss and aging through brain-imaging technology, neurochemical experiment, and cognitive and psychological tests. One thing, however, is already fairly clear—many aspects of memory are not a function of age at all but of education. Memory exists in more than one form. What we call knowledge—facts—is what psychologists such as Harry P. Bahrick, Ph.D., of Ohio Wesleyan University call semantic memory. Events, conversations, and occurrences in time and space, on the other hand, make up episodic or event memory, which is triggered by cues from the context. If you were around in 1963 you don't need to be reminded of the circumstances surrounding the moment you heard that JFK had been assassinated. That event is etched into your episodic memory.</p>

<p><strong>E</strong> &nbsp;When you forget a less vivid item, like buying a roll of paper towels at the supermarket, you may blame it on your aging memory. It's true that episodic memory begins to decline when most people are in their 50s, but it's never perfect at any age. "Every memory begins as an event," says Bahrick. "Through repetition, certain events leave behind a residue of knowledge or semantic memory. On a specific day in the past, somebody taught you that two and two are four, but you've been over that information so often you don't remember where you learned it. What started as an episodic memory has become a permanent part of your knowledge base." You remember the content, not the context. Our language knowledge, our knowledge of the world and of people, is largely that permanent or semi-permanent residue.</p>

<p><strong>F</strong> &nbsp;Probing the longevity of knowledge, Bahrick tested 1,000 high school graduates to see how well they recalled their algebra. Some had completed the course as recently as a month before, others as long as 50 years earlier. He also determined how long each person had studied algebra, the grade received, and how much the skill was used over the course of adulthood. Surprisingly, a person's grasp of algebra at the time of testing did not depend on how long ago he'd taken the course—the determining factor was the duration of instruction. Those who had spent only a few months learning algebra forgot most of it within two or three years.</p>

<p><strong>G</strong> &nbsp;In another study, Bahrick discovered that people who had taken several courses in Spanish, spread out over a couple of years, could recall, decades later, 60 per cent or more of the vocabulary they learned. Those who took just one course retained only a trace after three years. "This long-term residue of knowledge remains stable over the decades, independent of the age of the person and the age of the memory. No serious deficit appears until people get to their 50s and 60s, probably due to the degenerative processes of aging rather than a cognitive loss."</p>

<p><strong>H</strong> &nbsp;"You could say metamemory is a byproduct of going to school," says psychologist Robert Kail, Ph.D., of Purdue University, who studies children from birth to 20 years, the time of life when mental development is most rapid. "The question-and-answer process, especially exam-taking, helps children learn—and also teaches them how their memory works. This may be one reason why, according to a broad range of studies in people over 60, the better educated a person is, the more likely they are to perform better in life and on psychological tests. A group of adult novice chess players were compared with a group of child experts at the game. In tests of their ability to remember a random series of numbers, the adults, as expected, outscored the children. But when asked to remember the patterns of chess pieces arranged on a board, the children won. "Because they'd played a lot of chess, their knowledge of chess was better organized than that of the adults, and their existing knowledge of chess served as a framework for new memory," explains Kail.</p>

<p><strong>I</strong> &nbsp;Specialized knowledge is a mental resource that only improves with time. Crystallized intelligence about one's occupation apparently does not decline at all until at least age 75, and if there is no disease or dementia, may remain even longer. Special knowledge is often organized by a process called "chunking." If procedure A and procedure B are always done together, for example, the mind may merge them into a single command. When you apply yourself to a specific interest—say, cooking—you build increasingly elaborate knowledge structures that let you do more and do it better. This ability, which is tied to experience, is the essence of expertise. Vocabulary is one such specialized form of accrued knowledge. Research clearly shows that vocabulary improves with time. Retired professionals, especially teachers and journalists, consistently score higher on tests of vocabulary and general information than college students, who are supposed to be in their mental prime.</p>
HTML,
    'order'       => 2,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 2 (Memory and Age), ID: $p2id\n";

// ── Q14-17: Multiple Choice ───────────────────────────────────────────────────
$mcqs = [
    [14, 'What does the experiment of typist show in the passage?',
     ['A' => 'Old people reading ability is superior',
      'B' => 'Losses of age is irreversible',
      'C' => 'Seasoned tactics made elders more efficient',
      'D' => 'Old people performed poorly in the driving test'],
     'C', 1],
    [15, 'Which is correct about the rat experiment?',
     ['A' => 'Different toys have a different effect on rats',
      'B' => "Rat's brain weight increased in both cages",
      'C' => "Isolated rat's brain grows new connections",
      'D' => 'Boring and complicated surroundings affect brain development'],
     'D', 2],
    [16, 'What can be concluded in a chess game of the children group?',
     ['A' => 'They won a game with adults.',
      'B' => 'Their organization of chess knowledge is better',
      'C' => 'Their image memory is better than adults',
      'D' => 'They used a different part of the brain when playing chess'],
     'B', 3],
    [17, 'What is the author\'s purpose of using "vocabulary study" at the end of the passage?',
     ['A' => 'Certain people are sensitive to vocabularies while others aren\'t',
      'B' => 'Teachers and professionals won by their experience',
      'C' => 'Vocabulary memory as a crystallized intelligence is hard to decline',
      'D' => 'Old people use their special zone of the brain when they study'],
     'C', 4],
];

foreach ($mcqs as [$qNum, $qText, $opts, $ans, $ord]) {
    DB::table('ielts_reading_questions')->insert([
        'passage_id'      => $p2id,
        'question_number' => $qNum,
        'type'            => 'multiple_choice',
        'question_text'   => $qText,
        'options'         => json_encode($opts),
        'correct_answer'  => json_encode($ans),
        'explanation'     => null,
        'data'            => json_encode(['question_number' => $qNum]),
        'order'           => $ord,
        'created_at'      => now(),
        'updated_at'      => now(),
    ]);
}
echo "Inserted Q14-17 (Multiple Choice).\n";

// ── Q18-23: Summary Completion ────────────────────────────────────────────────
$sum2 = [
    'box_title'    => 'Summary',
    'instruction'  => 'Complete the following summary using NO MORE THAN TWO WORDS from the Reading Passage for each answer.',
    'summary_text' => "It's long been known that as one significant mental function, [18] deteriorates with age. Charles A. Dana Foundation invested millions of dollars to test memory decline. They used advanced technology, neurochemical experiments and ran several cognitive and [19] experiments. Bahrick called one form \"[20]\", which describes factual knowledge. Another one called \"[21]\" contains events in time and space format. He conducted two experiments toward knowledge memory's longevity; he asked 1,000 candidates some knowledge of [22], some could even remember it decades ago. A second research of Spanish course found that multiple courses participants could remember more than half of [23] they learned after decades, whereas single course takers only remembered for as short as 3 years.",
    'blanks' => [
        ['id' => 'q18', 'blank_number' => 18],
        ['id' => 'q19', 'blank_number' => 19],
        ['id' => 'q20', 'blank_number' => 20],
        ['id' => 'q21', 'blank_number' => 21],
        ['id' => 'q22', 'blank_number' => 22],
        ['id' => 'q23', 'blank_number' => 23],
    ],
    'correct_answer' => [
        'q18' => 'memory',
        'q19' => 'psychological',
        'q20' => 'semantic memory',
        'q21' => 'episodic memory',
        'q22' => 'algebra',
        'q23' => 'vocabulary',
    ],
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 18,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the following summary using <strong>NO MORE THAN TWO WORDS</strong> from the Reading Passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q18' => 'memory', 'q19' => 'psychological', 'q20' => 'semantic memory', 'q21' => 'episodic memory', 'q22' => 'algebra', 'q23' => 'vocabulary']),
    'explanation'     => null,
    'data'            => json_encode($sum2),
    'order'           => 5,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q18-23 (Summary Completion).\n";

// ── Q24-27: Matching People to Opinions ──────────────────────────────────────
$matchPeople = [
    'sub_questions' => [
        ['id' => 'q24', 'label' => 'Examined both young and old\'s blood circulation of the brain while testing.'],
        ['id' => 'q25', 'label' => 'Aging is a significant link between physical and mental activity.'],
        ['id' => 'q26', 'label' => 'Some semantic memory of an event would not fade away after repetition.'],
        ['id' => 'q27', 'label' => 'Rat\'s brain developed when putting in a diverse environment.'],
    ],
    'options' => [
        'A' => 'A – Harry P. Bahrick',
        'B' => 'B – Arnold B. Scheibel',
        'C' => 'C – Marion Diamond',
        'D' => 'D – Timothy Salthouse',
        'E' => 'E – Stanley Rapoport',
        'F' => 'F – Robert Kail',
    ],
    'correct_answer' => ['q24' => 'E', 'q25' => 'B', 'q26' => 'A', 'q27' => 'C'],
    'start_number'   => 23,
    'box_title'      => 'Match the researcher (A–F) with their opinion or deed',
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 24,
    'type'            => 'matching_sentence_endings',
    'question_text'   => 'Use the information in the passage to match the people (listed A–F) with opinions or deeds below. Write the appropriate letters <strong>A–F</strong> in boxes 24–27 on your answer sheet.',
    'options'         => json_encode($matchPeople['options']),
    'correct_answer'  => json_encode(['q24' => 'E', 'q25' => 'B', 'q26' => 'A', 'q27' => 'C']),
    'explanation'     => null,
    'data'            => json_encode($matchPeople),
    'order'           => 6,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q24-27 (Matching People).\n";

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 3 — "Facial expression 1"
// ════════════════════════════════════════════════════════════════════════════
$p3id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Facial expression 1',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 28–40</strong> which are based on Reading Passage 3 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Facial expression 1</h2>

<p><strong>A</strong> &nbsp;A facial expression is one or more motions or positions of the muscles in the skin. These movements convey the emotional state of the individual to observers. Facial expressions are a form of nonverbal communication. They are a primary means of conveying social information among humans, but also occur in most other mammals and some other animal species. Facial expressions and their significance in the perceiver can, to some extent, vary between cultures with evidence from descriptions in the works of Charles Darwin.</p>

<p><strong>B</strong> &nbsp;Humans can adopt a facial expression to read as a voluntary action. However, because expressions are closely tied to emotion, they are more often involuntary. It can be nearly impossible to avoid expressions for certain emotions, even when it would be strongly desirable to do so; a person who is trying to avoid insulting an individual he or she finds highly unattractive might, nevertheless, show a brief expression of disgust before being able to reassume a neutral expression. Microexpressions are one example of this phenomenon. The close link between emotion and expression can also work in the other direction; it has been observed that voluntarily assuming an expression can actually cause the associated emotion.</p>

<p><strong>C</strong> &nbsp;Some expressions can be accurately interpreted even between members of different species – anger and extreme contentment being the primary examples. Others, however, are difficult to interpret even in familiar individuals. For instance, disgust and fear can be tough to tell apart. Because faces have only a limited range of movement, expressions rely upon fairly minuscule differences in the proportion and relative position of facial features, and reading them requires considerable sensitivity to the same. Some faces are often falsely read as expressing some emotion, even when they are neutral because their proportions naturally resemble those another face would temporarily assume when emoting.</p>

<p><strong>D</strong> &nbsp;Also, a person's eyes reveal much about how they are feeling, or what they are thinking. Blink rate can reveal how nervous or at ease a person may be. Research by Boston College professor Joe Tecce suggests that stress levels are revealed by blink rates. He supports his data with statistics on the relation between the blink rates of presidential candidates and their success in their races. Tecce claims that the faster blinker in the presidential debates has lost every election since 1980. Though Tecce's data is interesting, it is important to recognize that non-verbal communication is multi-channelled, and focusing on only one aspect is reckless. Nervousness can also be measured by examining each candidate's perspiration, eye contact and stiffness.</p>

<p><strong>E</strong> &nbsp;As Charles Darwin noted in his book <em>The Expression of the Emotions in Man and Animals</em>: the young and the old of widely different races, both with man and animals, express the same state of mind by the same movements. Still, up to the mid-20th century, most anthropologists believed that facial expressions were entirely learned and could, therefore, differ among cultures. Studies conducted in the 1960s by Paul Ekman eventually supported Darwin's belief to a large degree.</p>

<p><strong>F</strong> &nbsp;Ekman's work on facial expressions had its starting point in the work of psychologist Silvan Tomkins. Ekman showed that contrary to the belief of some anthropologists including Margaret Mead, facial expressions of emotion are not culturally determined, but universal across human cultures. The South Fore people of New Guinea were chosen as subjects for one such survey. The study consisted of 189 adults and 130 children from among a very isolated population, as well as twenty-three members of the culture who lived a less isolated lifestyle as a control group. Participants were told a story that described one particular emotion; they were then shown three pictures (two for children) of facial expressions and asked to match the picture which expressed the story's emotion.</p>

<p><strong>G</strong> &nbsp;While the isolated South Fore people could identify emotions with the same accuracy as the non-isolated control group, problems associated with the study include the fact that both fear and surprise were constantly misidentified. The study concluded that certain facial expressions correspond to particular emotions and cannot be covered, regardless of cultural background, and regardless of whether or not the culture has been isolated or exposed to the mainstream.</p>

<p><strong>H</strong> &nbsp;Expressions Ekman found to be universal included those indicating anger, disgust, fear, joy, sadness, and surprise (note that none of these emotions has a definitive social component, such as shame, pride, or schadenfreude). Findings on contempt (which is social) are less clear, though there is at least some preliminary evidence that this emotion and its expression are universally recognized. This may suggest that the facial expressions are largely related to the mind and each part on the face can express specific emotion.</p>
HTML,
    'order'       => 3,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 3 (Facial Expression), ID: $p3id\n";

// ── Q28-32: Summary Completion ────────────────────────────────────────────────
$sum3 = [
    'box_title'    => "Summary of Ekman's Study",
    'instruction'  => 'Complete the Summary paragraph below using NO MORE THAN TWO WORDS from the Reading Passage for each answer.',
    'summary_text' => "The result of Ekman's study demonstrates that fear and surprise are persistently [28] and made a conclusion that some facial expressions have something to do with certain [29] which is impossible to cover, despite of [30] and whether the culture has been [31] or [32] to the mainstream.",
    'blanks' => [
        ['id' => 'q28', 'blank_number' => 28],
        ['id' => 'q29', 'blank_number' => 29],
        ['id' => 'q30', 'blank_number' => 30],
        ['id' => 'q31', 'blank_number' => 31],
        ['id' => 'q32', 'blank_number' => 32],
    ],
    'correct_answer' => [
        'q28' => 'misidentified',
        'q29' => 'emotions',
        'q30' => 'cultural background',
        'q31' => 'isolated',
        'q32' => 'exposed',
    ],
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 28,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the Summary paragraph below. Write the correct answer with <strong>NO MORE THAN TWO WORDS</strong> from the passage.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q28' => 'misidentified', 'q29' => 'emotions', 'q30' => 'cultural background', 'q31' => 'isolated', 'q32' => 'exposed']),
    'explanation'     => null,
    'data'            => json_encode($sum3),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q28-32 (Summary Completion).\n";

// ── Q33-38: Matching Paragraph Information (A-H) ──────────────────────────────
$matchPara = [
    'sub_questions' => [
        ['id' => 'q33', 'label' => 'The difficulty identifying the actual meaning of facial expressions.'],
        ['id' => 'q34', 'label' => 'The importance of culture on facial expressions is initially described.'],
        ['id' => 'q35', 'label' => 'Collected data for the research on the relation between blink and the success in elections.'],
        ['id' => 'q36', 'label' => 'The features on the sociality of several facial expressions.'],
        ['id' => 'q37', 'label' => 'An indicator to reflect one\'s extent of nervousness.'],
        ['id' => 'q38', 'label' => 'The relation between emotion and facial expressions.'],
    ],
    'options' => [
        'A' => 'Paragraph A', 'B' => 'Paragraph B', 'C' => 'Paragraph C',
        'D' => 'Paragraph D', 'E' => 'Paragraph E', 'F' => 'Paragraph F',
        'G' => 'Paragraph G', 'H' => 'Paragraph H',
    ],
    'correct_answer' => ['q33' => 'C', 'q34' => 'A', 'q35' => 'D', 'q36' => 'H', 'q37' => 'D', 'q38' => 'B'],
    'start_number'   => 32,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 33,
    'type'            => 'matching_paragraph_information',
    'question_text'   => 'The reading passage has seven paragraphs <strong>A–H</strong>. Which paragraph contains the following information? Write the correct letter <strong>A–H</strong> in boxes 33–38 on your answer sheet. <em>NB You may use any letter more than once.</em>',
    'options'         => json_encode($matchPara['options']),
    'correct_answer'  => json_encode($matchPara['correct_answer']),
    'explanation'     => null,
    'data'            => json_encode($matchPara),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q33-38 (Matching Paragraph).\n";

// ── Q39-40: Multiple Choice (Choose two — seeded as two separate MCQs) ─────────
$opts3940 = [
    'A' => 'No evidence shows animals have their own facial expressions.',
    'B' => 'The potential relationship between facial expression and state of mind exists.',
    'C' => 'Facial expressions are concerning different cultures.',
    'D' => 'Different areas on face convey a certain state of mind.',
    'E' => "Mind controls men's facial expressions more obvious than women's.",
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 39,
    'type'            => 'multiple_choice',
    'question_text'   => 'Choose <strong>TWO</strong> letters from A–E. Which two of the following statements are true according to Ekman\'s theory? (Q39)',
    'options'         => json_encode($opts3940),
    'correct_answer'  => json_encode('B'),
    'explanation'     => null,
    'data'            => json_encode(['question_number' => 39]),
    'order'           => 3,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 40,
    'type'            => 'multiple_choice',
    'question_text'   => 'Choose <strong>TWO</strong> letters from A–E. Which two of the following statements are true according to Ekman\'s theory? (Q40)',
    'options'         => json_encode($opts3940),
    'correct_answer'  => json_encode('D'),
    'explanation'     => null,
    'data'            => json_encode(['question_number' => 40]),
    'order'           => 4,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q39-40 (Multiple Choice – choose two).\n";

echo "\nDone! Practice Test 4 seeded with material_id={$materialId}.\n";
echo "Passage 1 ID: {$p1id} | Passage 2 ID: {$p2id} | Passage 3 ID: {$p3id}\n";
echo "Visit /assignments/ielts-academic/reading/material/4 to verify.\n";
