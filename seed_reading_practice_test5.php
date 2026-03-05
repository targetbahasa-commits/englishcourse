<?php
/**
 * Seed script: IELTS Reading Practice Test 5
 * Passage 1: "World Ecotourism in the developing countries" → Q1-13
 * Passage 2: "Smell and Memory"                             → Q14-26
 * Passage 3: "The Persuaders"                              → Q27-40
 *
 * material_id = 5
 * Run: /Applications/MAMP/bin/php/php8.4.1/bin/php seed_reading_practice_test5.php
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$materialId = 5;

// Clear existing passages for material_id = 5
$existing = DB::table('ielts_reading_passages')->where('material_id', $materialId)->pluck('id');
if ($existing->count()) {
    DB::table('ielts_reading_questions')->whereIn('passage_id', $existing)->delete();
    DB::table('ielts_reading_passages')->whereIn('id', $existing)->delete();
    echo "Cleared " . $existing->count() . " existing passage(s) for material_id={$materialId}.\n";
}

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 1 — "World Ecotourism in the developing countries"
// ════════════════════════════════════════════════════════════════════════════
$p1id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'World Ecotourism in the developing countries',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong> which are based on Reading Passage 1 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">World Ecotourism in the developing countries</h2>

<p><strong>A</strong> &nbsp;The Ecotourism Society defines ecotourism as "a responsible travel to natural areas which conserves the environment and improves the welfare of local people". It is recognised as being particularly conducive to enriching and enhancing the standing of tourism, on the basis that this form of tourism respects the natural heritage and local populations and are in keeping with the carrying capacity of the sites.</p>

<p><strong>B</strong> &nbsp;Cuba is undoubtedly an obvious site for ecotourism, with its picturesque beaches, underwater beauty, countryside landscapes, and ecological reserves. An educated population and improved infrastructure of roads and communications add to the mix. In the Caribbean region, Cuba is now the second most popular tourist destination.</p>

<p>Ecotourism is also seen as an environmental education opportunity to heighten both visitors' and residents' awareness of environmental and conservation issues, and even to inspire conservation action.</p>

<p>Ecotourism has also been credited with promoting peace, by providing opportunities for educational and cultural exchange. Tourists' safety and health are guaranteed.</p>

<p>Raul Castro, brother of the Cuban president, started this initiative to rescue the Cuban tradition of herbal medicine and provide natural medicines for its healthcare system. The school at Las Terrazas Eco-Tourism Community teaches herbal healthcare and children learn not only how to use medicinal herbs, but also to grow them in the school garden for teas, tinctures, ointments and creams.</p>

<p>In Cuba, ecotourism has the potential to alleviate poverty by bringing money into the economy and creating jobs. In addition to the environmental impacts of these efforts, the area works on developing community employment opportunities for locals, in conjunction with ecotourism.</p>

<p><strong>C</strong> &nbsp;In terms of South America, it might be the place which shows the shortcoming of ecotourism. Histoplasma capsulatum (see chapter "Histoplasmosis and HIV"), a dimorphic fungus, is the most common endemic mycosis in the United States, and is associated with exposure to bat or bird droppings. Most recently, outbreaks have been reported in healthy travelers who returned from Central and South America after engaging in recreational activities associated with spelunking, adventure tourism, and ecotourism. It is quite often to see tourists neglect sanitation while travelling. After engaging in high-risk activities, boots should be hosed off and clothing placed in airtight plastic bags for laundering. HIV-infected travelers should avoid risky behaviors or environments, such as exploring caves, particularly those that contain bat droppings.</p>

<p><strong>D</strong> &nbsp;Nowhere is the keen eye and intimate knowledge of ecotourism more amidst this fantastic biodiversity, as we explore remote realms rich in wildlife rather than a nature adventure. A sustainable tour is significant for ecotourism, one in which we can grow hand in hand with nature and our community, respecting everything that makes us privileged. Travelers get great joy from every step that takes forward on this endless but exciting journey towards sustainability. The primary threats to South American's tropical forests are deforestation caused by agricultural expansion, cattle ranching, logging, oil extraction and spills, mining, illegal coca farming, and colonization initiatives. Deforestation has shrunk territories belonging to indigenous peoples and wiped out more than 90% of the population. Many are taking leading roles in sustainable tourism even as they introduce protected regions to more travelers.</p>

<p><strong>E</strong> &nbsp;In East Africa, significantly reducing such illegal hunting and allowing wildlife populations to recover would allow the generation of significant economic benefits through trophy hunting and potentially ecotourism. "Illegal hunting is an extremely inefficient use of wildlife resources because it fails to capture the value of wildlife achievable through alternative forms of use such as trophy hunting and ecotourism," said Peter Lindsey, author of the new study. Most residents believed that ecotourism could solve this circumstance. They have passion for local community empowerment, loves photography and writes to laud current local conservation efforts, create environmental awareness and promote ecotourism.</p>

<p><strong>F</strong> &nbsp;In Indonesia, ecotourism started to become an important concept from 1995, in order to strengthen the domestic travelling movement, the local government targeting the right markets is a prerequisite for successful ecotourism. The market segment for Indonesian ecotourism consists of: (i) "The silent generation", 55-64 year-old people who are wealthy enough, generally well-educated and have no dependent children, and can travel for four weeks; (ii) "The baby boom generation", junior successful executives aged 35-54 years, who are likely to be travelling with their family and children (spending 2-3 weeks on travel) – travelling for them is a stress reliever; and (iii) the "X generation", aged 18-29 years, who love to do ecotours as backpackers – they are generally students who can travel for 3-12 months with monthly expenditure of US$300-500. It is suggested that the promotion of Indonesian ecotourism products should aim to reach these various cohorts of tourists. The country welcomes diverse levels of travelers.</p>

<p><strong>G</strong> &nbsp;On the other hand, ecotourism provides as many services as traditional tourism. Nestled between Mexico, Guatemala and the Caribbean Sea is the country of Belize. It is the wonderful place for Hamanasi honeymoon, a bottle of champagne upon arrival, three meals daily, private service on one night of your stay and a choice of adventures depending on the length of your stay. It also offers six-night and seven-night honeymoon packages. A variety of specially tailored tours, including the Brimstone Hill Fortress, and a trip to a neighboring island. Guided tours include rainforest, volcano and off-road plantation tours. Gregory Pereira, an extremely knowledgeable and outgoing hiking and tour guide, says the following about his tours: "All of our tours on St. Kitts include transportation by specially modified Land Rovers, a picnic of island pastries and local fruit, fresh tropical juices, CSR, a qualified island guide and a full liability insurance coverage for participants.</p>

<p><strong>H</strong> &nbsp;Kodai is an ultimate splendor spot for those who love being close to mother nature. They say every bird must sing its own throat while we say every traveler should find his own way out of variegated and unblemished paths of deep valleys and steep mountains. The cheese factory here exports a great quantity of cheese to various countries across the globe. It is located in the center of the forest. Many travelers are attracted by the delicious cheese. The ecotourism is very famous for this different eating experience.</p>
HTML,
    'order'       => 1,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 1 (World Ecotourism), ID: $p1id\n";

// ── Q1-5: Matching Places (A=Cuba, B=East Africa, C=South America, D=Indonesia)
$matchPlaces = [
    'sub_questions' => [
        ['id' => 'q1', 'label' => 'a place to improve local education to help tourists'],
        ['id' => 'q2', 'label' => 'a place suitable for both rich and poor travelers'],
        ['id' => 'q3', 'label' => 'a place where could easily get fungus'],
        ['id' => 'q4', 'label' => 'a place taking a method to stop unlawful poaching'],
        ['id' => 'q5', 'label' => 'a place where the healthcare system is developed'],
    ],
    'options' => [
        'A' => 'A – Cuba',
        'B' => 'B – East Africa',
        'C' => 'C – South America',
        'D' => 'D – Indonesia',
    ],
    'correct_answer' => ['q1' => 'A', 'q2' => 'D', 'q3' => 'C', 'q4' => 'B', 'q5' => 'A'],
    'start_number'   => 0,
    'box_title'      => 'Match the place (A–D) with opinions or deeds below',
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 1,
    'type'            => 'matching_sentence_endings',
    'question_text'   => 'Use the information in the passage to match the place (listed A–D) with opinions or deeds below. Write the appropriate letters <strong>A–D</strong> in boxes 1–5 on your answer sheet. <em>NB You may use any letter more than once.</em><br><br>A &nbsp;Cuba<br>B &nbsp;East Africa<br>C &nbsp;South America<br>D &nbsp;Indonesia',
    'options'         => json_encode($matchPlaces['options']),
    'correct_answer'  => json_encode(['q1' => 'A', 'q2' => 'D', 'q3' => 'C', 'q4' => 'B', 'q5' => 'A']),
    'explanation'     => null,
    'data'            => json_encode($matchPlaces),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q1-5 (Matching Places).\n";

// ── Q6-9: Matching Options (A=eating local fruits, B=job community, C=heart of jungle, D=private service)
$matchOptions = [
    'sub_questions' => [
        ['id' => 'q6', 'label' => 'Visiting the cheese factory'],
        ['id' => 'q7', 'label' => 'Enjoying the honeymoon'],
        ['id' => 'q8', 'label' => 'Having the picnic while'],
        ['id' => 'q9', 'label' => 'The residents in Cuba could'],
    ],
    'options' => [
        'A' => 'A – eating the local fruits at the same time',
        'B' => 'B – find job opportunities in the community',
        'C' => 'C – which is situated in the heart of the jungle',
        'D' => 'D – with private and comfortable service',
    ],
    'correct_answer' => ['q6' => 'C', 'q7' => 'D', 'q8' => 'A', 'q9' => 'B'],
    'start_number'   => 5,
    'box_title'      => 'Match the activity (A–D) with opinions or deeds below',
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 6,
    'type'            => 'matching_sentence_endings',
    'question_text'   => 'Use the information in the passage to match the companies (listed A–D) with opinions or deeds below. Write the appropriate letters <strong>A–D</strong> in boxes 6–9 on your answer sheet.<br><br>A &nbsp;eating the local fruits at the same time<br>B &nbsp;find job opportunities in the community<br>C &nbsp;which is situated in the heart of the jungle<br>D &nbsp;with private and comfortable service',
    'options'         => json_encode($matchOptions['options']),
    'correct_answer'  => json_encode(['q6' => 'C', 'q7' => 'D', 'q8' => 'A', 'q9' => 'B']),
    'explanation'     => null,
    'data'            => json_encode($matchOptions),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q6-9 (Matching Options).\n";

// ── Q10-13: Summary Completion ────────────────────────────────────────────────
$sum1 = [
    'box_title'    => 'Summary',
    'instruction'  => 'Complete the following summary using NO MORE THAN TWO WORDS from the Reading Passage for each answer.',
    'summary_text' => 'Ecotourism is not a nature [10] but a [11] tour. The reason why South America promotes ecotourism is due to the destruction of [12]. In addition, East Africa also encourages this kind of tourism for cutting the [13] in order to save wild animals.',
    'blanks' => [
        ['id' => 'q10', 'blank_number' => 10],
        ['id' => 'q11', 'blank_number' => 11],
        ['id' => 'q12', 'blank_number' => 12],
        ['id' => 'q13', 'blank_number' => 13],
    ],
    'correct_answer' => [
        'q10' => 'adventure',
        'q11' => 'sustainable',
        'q12' => 'tropical forests',
        'q13' => 'illegal killing',
    ],
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 10,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the following summary of the paragraphs of Reading Passage using <strong>NO MORE THAN TWO WORDS</strong> from the Reading Passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q10' => 'adventure', 'q11' => 'sustainable', 'q12' => 'tropical forests', 'q13' => 'illegal killing']),
    'explanation'     => null,
    'data'            => json_encode($sum1),
    'order'           => 3,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q10-13 (Summary Completion).\n";

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 2 — "Smell and Memory"
// ════════════════════════════════════════════════════════════════════════════
$p2id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Smell and Memory',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong> which are based on Reading Passage 2 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Smell and Memory</h2>
<h3 class="text-lg font-semibold text-gray-700 mb-4">SMELLS LIKE YESTERDAY</h3>
<p class="text-sm text-gray-500 italic mb-4">Why does the scent of a fragrance or the mustiness of an old trunk trigger such powerful memories of childhood? New research has the answer, writes Alexandra Witze.</p>

<p><strong>A</strong> &nbsp;You probably pay more attention to a newspaper with your eyes than with your nose. But lift the paper to your nostrils and inhale. The smell of newsprint might carry you back to your childhood when your parents perused the paper on Sunday mornings. Or maybe some other smell takes you back – the scent of your mother's perfume, the pungency of a driftwood campfire. Specific odours can spark a flood of reminiscences. Psychologists call it the "Proustian phenomenon", after French novelist Marcel Proust. Near the beginning of the masterpiece <em>In Search of Lost Time</em>, Proust's narrator dips a madeleine cookie into a cup of tea – and the scent and taste unleash a torrent of childhood memories for 3,000 pages.</p>

<p><strong>B</strong> &nbsp;Now, this phenomenon is getting scientific treatment. Neuroscientists Rachel Herz, a cognitive neuroscientist at Brown University in Providence, Rhode Island, have discovered, for instance, how sensory memories are shared across the brain, with different brain regions remembering the sights, smells, tastes and sounds of a particular experience. Meanwhile, psychologists have demonstrated that memories triggered by smells can be more emotional, as well as more detailed, than memories not related to smells. When you inhale, odour molecules set brain cells dancing within a region known as the amygdala, a part of the brain that helps control emotion. In contrast, the other senses, such as taste or touch, get routed through other parts of the brain before reaching the amygdala. The direct link between odours and the amygdala may help explain the emotional potency of smells. "There is this unique connection between the sense of smell and the part of the brain that processes emotion," says Rachel Herz.</p>

<p><strong>C</strong> &nbsp;But the links don't stop there. Like an octopus reaching its tentacles outward, the memory of smells affects other brain regions as well. In recent experiments, neuroscientists at University College London (UCL) asked 15 volunteers to look at pictures while smelling unrelated odours. For instance, the subjects might see a photo of a duck paired with the scent of a rose, and then be asked to create a story linking the two. Brain scans taken at the time revealed that the volunteers' brains were particularly active in a region known as the olfactory cortex, which is known to be involved in processing smells. Five minutes later, the volunteers were shown the duck photo again, but without the rose smell. And in their brains, the olfactory cortex lit up again, the scientists reported recently. The fact that the olfactory cortex became active in the absence of the odour suggests that people's sensory memory of events is spread across different brain regions. Imagine going on a seaside holiday, says UCL team leader, Jay Gottfried. The sight of the waves becomes stored in one area, whereas the crash of the surf goes elsewhere, and the smell of seaweed in yet another place. There could be advantages to having memories spread around the brain. "You can reawaken that memory from any one of the sensory triggers," says Gottfried. "Maybe the smell of the sun lotion, or a particular sound from that day, or the sight of a rock formation." Or – in the case of an early hunter and gatherer out on a plain – the sight of a lion might be enough to trigger the urge to flee, rather than having to wait for the sound of its roar and the stench of its hide to kick in as well.</p>

<p><strong>D</strong> &nbsp;Remembered smells may also carry extra emotional baggage, says Herz. Her research suggests that memories triggered by odours are more emotional than memories triggered by other cues. In one recent study, Herz recruited five volunteers who had vivid memories associated with a particular perfume, such as Opium for Women and Juniper Breeze from Bath and Body Works. She took images of the volunteers' brains as they sniffed that perfume and an unrelated perfume bottle. Smelling the specified perfume activated the volunteers' brains the most, particularly in the amygdala, and in a region called the hippocampus, which helps in memory formation. Herz published the work earlier this year in the journal <em>Neuropsychologia</em>.</p>

<p><strong>E</strong> &nbsp;But she couldn't be sure that the other senses wouldn't also elicit a strong response. So in another study Herz compared smells with sounds and pictures. She had 70 people describe an emotional memory involving three items – popcorn, fresh-cut grass and a campfire. Then they compared the items through sights, sounds and smells. For instance, the person might see a picture of a lawnmower, then sniff the scent of grass and finally listen to the lawnmower's sound. Memories triggered by smell were more evocative than memories triggered by either sights or sounds.</p>

<p><strong>F</strong> &nbsp;Odour-evoked memories may be not only more emotional but more detailed as well. Working with colleague John Downes, psychologist Simon Chu of the University of Liverpool started researching odour and memory partly because of his grandmother's stories about Chinese culture. As generations gathered to share oral histories, they would pass a small pot of spice or incense around; later, when they wanted to remember the story in as much detail as possible, they would pass the same smell around again. "It kind of fits with a lot of anecdotal evidence on how smells can be really good reminders of past experiences," Chu says. And scientific research seems to bear out the anecdotes. In one experiment, Chu and Downes asked 42 volunteers to tell a life story, then tested to see whether odours such as coffee and cinnamon could help them remember more detail in the story. They could.</p>

<p><strong>G</strong> &nbsp;Despite such studies, not everyone is convinced that Proust can be scientifically analysed. In the June issue of <em>Chemical Senses</em>, Chu and Downes exchanged critiques with renowned perfumer and chemist J. Stephan Jellinek. Jellinek chided the Liverpool researchers for, among other things, presenting the smells and asking the volunteers to think of memories, rather than seeing what memories were spontaneously evoked by the odours. But there's only so much science can do to test a phenomenon that's inherently different for each person, Chu says. Meanwhile, Jellinek has also been collecting anecdotal accounts of Proustian experiences, hoping to find some common links between the experiences. "I think there is a case to be made that surprise may be a major aspect of the Proust phenomenon," he says. "That's why people are so struck by these memories." No one knows whether Proust ever experienced such a transcendental moment. But his notions of memory, written as fiction nearly a century ago, continue to inspire scientists of today.</p>
HTML,
    'order'       => 2,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 2 (Smell and Memory), ID: $p2id\n";

// ── Q14-18: Matching People (A=Rachel Herz, B=Simon Chu, C=Jay Gottfried) ────
$matchPeople2 = [
    'sub_questions' => [
        ['id' => 'q14', 'label' => 'The found pattern of different sensory memories stored in various zones of the brain.'],
        ['id' => 'q15', 'label' => 'The smell brings detailed event under the smell of a certain substance.'],
        ['id' => 'q16', 'label' => 'Connection of smell and certain zones of the brain is different from that of other senses.'],
        ['id' => 'q17', 'label' => 'Diverse locations of stored information help us keep away the hazard.'],
        ['id' => 'q18', 'label' => 'There is no necessary correlation between smell and processing zone of the brain.'],
    ],
    'options' => [
        'A' => 'A – Rachel Herz',
        'B' => 'B – Simon Chu',
        'C' => 'C – Jay Gottfried',
    ],
    'correct_answer' => ['q14' => 'A', 'q15' => 'B', 'q16' => 'A', 'q17' => 'C', 'q18' => 'C'],
    'start_number'   => 13,
    'box_title'      => 'Match the person (A–C) with opinions or deeds below',
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 14,
    'type'            => 'matching_sentence_endings',
    'question_text'   => 'Use the information in the passage to match the people (listed A–C) with opinions or deeds below. Write the appropriate letters <strong>A–C</strong> in boxes 14–18 on your answer sheet. <em>NB You may use any letter more than once.</em><br><br>A &nbsp;Rachel Herz<br>B &nbsp;Simon Chu<br>C &nbsp;Jay Gottfried',
    'options'         => json_encode($matchPeople2['options']),
    'correct_answer'  => json_encode(['q14' => 'A', 'q15' => 'B', 'q16' => 'A', 'q17' => 'C', 'q18' => 'C']),
    'explanation'     => null,
    'data'            => json_encode($matchPeople2),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q14-18 (Matching People).\n";

// ── Q19-22: Multiple Choice ───────────────────────────────────────────────────
$mcqs2 = [
    [19, 'In paragraph B, what do the experiments conducted by Herz and other scientists show?',
     ['A' => 'Women are more easily addicted to opium medicine',
      'B' => 'Smell is superior to other senses in connection to the brain',
      'C' => 'Smell is more important than other senses',
      'D' => 'Certain part of the brain relates the emotion to the sense of smell'],
     'D', 2],
    [20, 'What does the second experiment conducted by Herz suggest?',
     ['A' => 'Result directly conflicts with the first one',
      'B' => 'Result of her first experiment is correct',
      'C' => 'Sights and sounds trigger memories at an equal level',
      'D' => 'Lawnmower is a perfect example in the experiment'],
     'B', 3],
    [21, 'What is the outcome of an experiment conducted by Chu and Downes?',
     ['A' => 'Smell is the only functional under Chinese tradition',
      'B' => 'Half of the volunteers told detailed stories',
      'C' => 'Smells of certain odours assist storytellers',
      'D' => 'Odours of cinnamon are stronger than that of coffee'],
     'C', 4],
    [22, 'What is the comment of Jellinek to Chu and Downes in the issue of Chemical Senses?',
     ['A' => 'Jellinek accused their experiment of being unscientific',
      'B' => 'Jellinek thought Liverpool is not a suitable place for experiment',
      'C' => 'Jellinek suggested that there was no further clue of what specific memories aroused',
      'D' => 'Jellinek stated that the experiment could be remedied'],
     'C', 5],
];

foreach ($mcqs2 as [$qNum, $qText, $opts, $ans, $ord]) {
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
echo "Inserted Q19-22 (Multiple Choice).\n";

// ── Q23-26: Summary Completion ────────────────────────────────────────────────
$sum2 = [
    'box_title'    => 'Summary',
    'instruction'  => 'Complete the following summary using NO MORE THAN THREE WORDS from the Reading Passage for each answer.',
    'summary_text' => 'In the experiments conducted by UCL, participants were asked to look at a picture with the scent of a flower, then in the next stage, everyone would have to [23] for a connection. A method called [24] suggested that specific area of the brain named [25] were quite active. Then in another paralleled experiment about Chinese elders, storytellers could recall detailed anecdotes when smelling a bowl of [26] or incense around.',
    'blanks' => [
        ['id' => 'q23', 'blank_number' => 23],
        ['id' => 'q24', 'blank_number' => 24],
        ['id' => 'q25', 'blank_number' => 25],
        ['id' => 'q26', 'blank_number' => 26],
    ],
    'correct_answer' => [
        'q23' => 'create a story',
        'q24' => 'brain scans',
        'q25' => 'olfactory cortex',
        'q26' => 'spice',
    ],
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 23,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the following summary of the paragraphs of Reading Passage using <strong>NO MORE THAN THREE WORDS</strong> from the Reading Passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q23' => 'create a story', 'q24' => 'brain scans', 'q25' => 'olfactory cortex', 'q26' => 'spice']),
    'explanation'     => null,
    'data'            => json_encode($sum2),
    'order'           => 6,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q23-26 (Summary Completion).\n";

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 3 — "The Persuaders"
// ════════════════════════════════════════════════════════════════════════════
$p3id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'The Persuaders',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong> which are based on Reading Passage 3 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">The Persuaders</h2>

<p><strong>A</strong> &nbsp;We have long lived in an age where powerful images, catchy soundbites and too-good-to-miss offers bombard us from every quarter. All around us the persuaders are at work. Occasionally their methods are unsubtle – the planting kiss on a baby's head by a wannabe political leader, or a liquidation sale in a shop that has been "closing down" for well over a year, but generally the persuaders know what they are about and are highly capable. Be they politicians, supermarket chains, salespeople or advertisers, they know exactly what to do to sell us their images, ideas or produce. When it comes to persuasion, these giants rule supreme. They employ the most skilled image-makers and use the best psychological tricks to guarantee that even the most cautious among us are open to manipulation.</p>

<p><strong>B</strong> &nbsp;We spend more time in them than we mean to, we buy 75 percent of our food from them and end up with products that we did not realise we wanted. Right from the start, supermarkets have been ahead of the game. For example, when Sainsbury introduced shopping baskets into its 1950s stores, it was a stroke of marketing genius. Now shoppers could browse and pick up items they previously would have ignored. Soon after came trolleys, and just as new roads attract more traffic, the same applied to trolley space. Professor Merlin Stone, IBM Professor of Relationship Marketing at Bristol Business School, says aisles are laid out to maximise profits. Stores pander to our money-rich, time-poor lifestyle. Low turnover products – clothes and electrical goods – are stocked at the back while high-turnover items command position at the front.</p>

<p><strong>C</strong> &nbsp;Stone believes supermarkets work hard to "stall" us because the more time we spend in them, the more we buy. Thus, great efforts are made to make the environment pleasant. Stores play music to relax us and some even pipe air from the in-store bakery around the shop. In the USA, fake aromas are sometimes used. The smell is both the most evocative and subliminal sense. In experiments, pleasant smells are effective in increasing our spending. A casino that fragranced only half its premises saw profit soar in the aroma-filled areas. The other success story from the supermarkets' perspective is the loyalty card. Punters may assume that they are being rewarded for their fidelity, but all the while they are trading information about their shopping habits. Loyal shoppers could be paying 30% more by sticking to their favourite shops for essential cosmetics.</p>

<p><strong>D</strong> &nbsp;Research has shown that 75 percent of profit comes from just 30 percent of customers. Ultimately, reward cards could be used to identify and better accommodate these "elite" shoppers. It could also be used to make adverts more relevant to individual consumers – rather like Spielberg's futuristic thriller Minority Report, in which Tom Cruise's character is bombarded with interactive personalised ads. If this sounds far-fetched, the data-gathering revolution has already seen the introduction of radio-frequency identification – a way to electronically tag products to see who is buying what. RFID means they can follow the product into people's homes.</p>

<p><strong>E</strong> &nbsp;No matter how savvy we think we are to their ploys, the ad industry still wins. Adverts focus on what products do or on how they make us feel. Researcher Laurette Dube, in the <em>Journal of Advertising Research</em>, says when attitudes are based on "cognitive foundations" (logical reasoning), advertisers use informative appeals. This works for products with a little emotional draw but high functionality, such as bleach. Where attitude is based on effect (i.e. emotions), ad teams try to tap into our feelings. Researchers at the University of Florida recently concluded that our emotional responses to adverts dominate over "cognition".</p>

<p><strong>F</strong> &nbsp;Advertisers play on our need to be safe (commercials for insurance), to belong (make a customer feel they are in the group in fashion ads) and for self-esteem (aspirational adverts). With time and space at a premium, celebrities are often used as a quick way of meeting these needs – either because the celeb epitomises success or because they seem familiar and so make the product seem "safe". A survey of 4,000 campaigns found ads with celebs were 10 percent more effective than without. Humour also stimulates a rapid emotional response. Heiman Chung, writing in the <em>International Journal of Advertising</em>, found that funny ads were remembered for longer than straight ones. Combine humour with sexual imagery – as in Wonderbra's "Hello Boys" ads – and you are on to a winner.</p>

<p><strong>G</strong> &nbsp;Slice-of-life ads are another tried and tested method – they paint a picture of life as you would like it, but still one that feels familiar. Abhilasha Mehta, in the <em>Journal of Advertising Research</em>, noted that the more one's self-image tallies with the brand being advertised, the stronger the commercial. Ad makers also use behaviourist theories, recognising that the more sensation we receive from an object, the better we know it. If an advert for a chocolate bar fails to cause salivation, it has probably failed. No wonder advertisements have been dubbed the "nervous system of the business world".</p>

<p><strong>H</strong> &nbsp;Probably all of us could make a sale if the product was something we truly believed in, but professional salespeople are in a different league – the best of them can always sell different items to suitable customers in the best time. They do this by using very basic psychological techniques. Stripped to its simplest level, selling works by heightening the buyer's perception of how much they need a product or service. Buyers normally have certain requirements by which they will judge the suitability of a product. The seller, therefore, attempts to tease out what these conditions are and then explains how their products' benefits can meet these requirements.</p>

<p><strong>I</strong> &nbsp;Richard Hession, author of <em>Be a Great Salesperson</em> says it is human nature to prefer to speak rather than listen, and good salespeople pander to this. They ask punters about their needs and offer to work with them to achieve their objectives. As a result, the buyer feels they are receiving a "consultation" rather than a sales pitch. All the while, the salesperson presents with a demeanour that takes it for granted that the sale will be made. Never will the words "if you buy" be used, but rather "when you buy".</p>

<p><strong>J</strong> &nbsp;Dr Rob Yeung, a senior consultant at business psychologists Kiddy and Partners, says most salespeople will build up a level of rapport by asking questions about hobbies, family and lifestyle. This has the double benefit of making the salesperson likeable while furnishing him or her with more information about the client's wants. Yeung says effective salespeople try as far as possible to match their style of presenting themselves to how the buyer comes across. If the buyer cracks jokes, the salesperson will respond in kind. If the buyer wants detail, the seller provides it; if they are more interested in the feel of the product, the seller will focus on this. At its most extreme, appearing empathetic can even include the salesperson attempting to "mirror" the body language of the buyer.</p>

<p><strong>K</strong> &nbsp;Whatever the method used, all salespeople work towards one aim: "closing the deal". In fact, they will be looking for "closing signals" through their dealings with potential clients. Once again the process works by assuming success. The buyer is not asked "are you interested?" as this can invite a negative response. Instead, the seller takes it for granted that the deal is effectively done: when the salesman asks you for a convenient delivery date or asks what colour you want, you will probably respond accordingly. Only afterwards might you wonder why you proved such a pushover.</p>
HTML,
    'order'       => 3,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 3 (The Persuaders), ID: $p3id\n";

// ── Q27-29: Multiple Choice ───────────────────────────────────────────────────
$mcqs3 = [
    [27, "What is the supermarket's purpose of using \"basket\" in paragraph B?",
     ['A' => 'Create a convenient atmosphere of supermarket',
      'B' => 'Make customers spend more time on shopping',
      'C' => "Relieve pressure on the supermarket's traffic",
      'D' => 'More than half items bought need to be carried'],
     'B', 1],
    [28, 'What is the quality of the best salesman possessed according to this passage?',
     ['A' => 'Sell the right product to the right person',
      'B' => 'Clearly state the instruction of one product',
      'C' => 'Show professional background of one product',
      'D' => 'Persuade customers to buy the product they sell'],
     'A', 2],
    [29, "What's the opinion of Richard Hession?",
     ['A' => 'Pretend to be nice instead of selling goods',
      'B' => 'Prefer to speak a lot to customers',
      'C' => "Help buyers to conclude their demands for ideal items",
      'D' => 'Show great interpersonal skill'],
     'D', 3],
];

foreach ($mcqs3 as [$qNum, $qText, $opts, $ans, $ord]) {
    DB::table('ielts_reading_questions')->insert([
        'passage_id'      => $p3id,
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
echo "Inserted Q27-29 (Multiple Choice).\n";

// ── Q30-35: Matching Paragraph Information (A-K) ──────────────────────────────
$matchPara3 = [
    'sub_questions' => [
        ['id' => 'q30', 'label' => 'How do supermarkets distract consumers'],
        ['id' => 'q31', 'label' => 'How to build a close relationship between salespeople and buyer'],
        ['id' => 'q32', 'label' => 'People would be impressed by the humor advertisement'],
        ['id' => 'q33', 'label' => 'Methods for salespeople to get the order'],
        ['id' => 'q34', 'label' => 'How questions work for salespeople'],
        ['id' => 'q35', 'label' => 'Different customer groups bring different profits'],
    ],
    'options' => [
        'A' => 'Paragraph A', 'B' => 'Paragraph B', 'C' => 'Paragraph C',
        'D' => 'Paragraph D', 'E' => 'Paragraph E', 'F' => 'Paragraph F',
        'G' => 'Paragraph G', 'H' => 'Paragraph H', 'I' => 'Paragraph I',
        'J' => 'Paragraph J', 'K' => 'Paragraph K',
    ],
    'correct_answer' => ['q30' => 'C', 'q31' => 'J', 'q32' => 'F', 'q33' => 'K', 'q34' => 'K', 'q35' => 'D'],
    'start_number'   => 29,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 30,
    'type'            => 'matching_paragraph_information',
    'question_text'   => 'Reading Passage 3 has 11 paragraphs <strong>A–K</strong>. Which paragraph contains the following information? Write the correct letter <strong>A–K</strong> in boxes 30–35 on your answer sheet. <em>NB You may use any letter more than once.</em>',
    'options'         => json_encode($matchPara3['options']),
    'correct_answer'  => json_encode($matchPara3['correct_answer']),
    'explanation'     => null,
    'data'            => json_encode($matchPara3),
    'order'           => 4,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q30-35 (Matching Paragraph).\n";

// ── Q36-40: Short Answer / Note Completion ────────────────────────────────────
$notes = [
    'box_title'    => 'Notes',
    'instruction'  => 'Complete the notes below using NO MORE THAN TWO WORDS from the passage.',
    'summary_text' => 'Trolleys are born for the increasing traffic in the supermarket. The width of [36] in supermarkets is broadened in order to generate the most profits. Research from [37], satisfying aromas can motivate people to buy more products. Except for the effort of creating a comfortable surrounding, [38] is another card that supermarkets play to reward their regular customers. For example, loyal customers spend 30% more in their loved shops for everyday necessary [39]. Clothes shops use advertisements to make the buyer think they are belonging to part of a [40]; research from 4,000 campaigns reflect that humor advertisement received more emotional respect.',
    'blanks' => [
        ['id' => 'q36', 'blank_number' => 36],
        ['id' => 'q37', 'blank_number' => 37],
        ['id' => 'q38', 'blank_number' => 38],
        ['id' => 'q39', 'blank_number' => 39],
        ['id' => 'q40', 'blank_number' => 40],
    ],
    'correct_answer' => [
        'q36' => 'aisles',
        'q37' => 'experiments',
        'q38' => 'loyalty card',
        'q39' => 'cosmetics',
        'q40' => 'group',
    ],
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 36,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the notes below using <strong>NO MORE THAN TWO WORDS</strong> from the passage.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q36' => 'aisles', 'q37' => 'experiments', 'q38' => 'loyalty card', 'q39' => 'cosmetics', 'q40' => 'group']),
    'explanation'     => null,
    'data'            => json_encode($notes),
    'order'           => 5,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q36-40 (Note Completion).\n";

echo "\nDone! Practice Test 5 seeded with material_id={$materialId}.\n";
echo "Passage 1 ID: {$p1id} | Passage 2 ID: {$p2id} | Passage 3 ID: {$p3id}\n";
echo "Visit /assignments/ielts-academic/reading/material/5 to verify.\n";
