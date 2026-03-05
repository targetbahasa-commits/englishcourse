<?php
/**
 * Seed script: IELTS Reading Material 1 – Passages 2 & 3
 * Passage 2: "The future never dies?"   → Q14-26
 * Passage 3: "Pottery production in ancient Akrotiri" → Q27-40
 *
 * Run via: php seed_reading_passages_2_3.php
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$materialId = 1;

// ─── Clear existing Passages 2 & 3 for material 1 (keep Passage 1) ───────────
$existing = DB::table('ielts_reading_passages')
    ->where('material_id', $materialId)
    ->where('order', '>', 1)
    ->pluck('id');

if ($existing->count()) {
    DB::table('ielts_reading_questions')->whereIn('passage_id', $existing)->delete();
    DB::table('ielts_reading_passages')->whereIn('id', $existing)->delete();
    echo "Cleared " . $existing->count() . " existing passage(s) (order > 1).\n";
}

// ════════════════════════════════════════════════════════════════════════════════
// PASSAGE 2 — "The future never dies?"
// ════════════════════════════════════════════════════════════════════════════════
$p2id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'The future never dies?',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong> which are based on Reading Passage 2 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">The future never dies?</h2>
<p class="font-bold text-gray-700 mb-6">The prospects for humanity and for the world as a whole are somewhere between glorious and dire. It is hard to be much more precise.</p>

<p><strong>A</strong> &nbsp;By 'glorious', I mean that our descendants – all who are born on to this Earth – could live very comfortably and securely, and could continue to do so for as long as the Earth can support life, which should be for a very long time indeed. We should at least be thinking in terms of the next million years. Furthermore, our descendants could continue to enjoy the company of other species – establishing a much better relationship with them than we have now. Other animals need not live in constant fear of us. Many of those fellow species now seem bound to become extinct, but a significant proportion could and should continue to live alongside us. Such a future may seem ideal, and so it is. Yet I do not believe it is fanciful. There is nothing in the physical fabric of the Earth or in our own biology to suggest that this is not possible.</p>

<p><strong>B</strong> &nbsp;'Dire' means that we human beings could be in deep trouble within the next few centuries, living but also dying in large numbers in political terror and from starvation, while huge numbers of our fellow creatures would simply disappear, leaving only the ones that we find convenient – chickens, cattle – or that we can't shake off, like flies and mice. I'm taking it to be self-evident that glory is preferable.</p>

<p><strong>C</strong> &nbsp;Our future is not entirely in our own hands because the Earth has its own rules, is part of the solar system and is neither stable nor innately safe. Other planets in the solar system are quite beyond habitation, because their temperature is far too high or too low to be endured, and ours, too, in principle could tip either way. Even relatively unspectacular changes in the atmosphere could do the trick. The core of the Earth is hot, which in many ways is good for living creatures, but every now and again, the molten rock bursts through volcanoes on the surface. Among the biggest volcanic eruptions in recent memory was Mount St Helens, in the USA, which threw out a cubic kilometre of ash – fortunately, in an area where very few people live. In 1815, Tambora (in present-day Indonesia) expelled so much ash into the upper atmosphere that climatic effects seriously harmed food production around the world for the season after season. Entire civilisations have been destroyed by volcanoes.</p>

<p><strong>D</strong> &nbsp;Yet nothing we have so far experienced shows what volcanoes can really do. Yellowstone National Park in the USA occupies the caldera (the crater formed when a volcano collapses) of an exceedingly ancient volcano of extraordinary magnitude. Modern surveys show that its centre is now rising. Sometime in the next 200 million years, Yellowstone could erupt again, and when it does, the whole world will be transformed. Yellowstone could erupt tomorrow. But there's a very good chance that it will give us another million years, and that surely is enough to be going on with. It seems sensible to assume that this will be the case.</p>

<p><strong>E</strong> &nbsp;The universe at large is dangerous, too: in particular, we share the sky with vast numbers of asteroids, and now and again, they come into our planet's atmosphere. An asteroid the size of a small island, hitting the Earth at 15,000 kilometres an hour (a relatively modest speed by the standards of heavenly bodies), would strike the ocean bed like a rock in a puddle, send a tidal wave around the world as high as a small mountain and as fast as a jumbo jet, and propel us into an ice age that could last for centuries. There are plans to head off such disasters (including rockets to push approaching asteroids into new trajectories), but in truth, it's down to luck.</p>

<p><strong>F</strong> &nbsp;On the other hand, the archaeological and the fossil evidence shows that no truly devastating asteroid has struck since the one that seems to have accounted for the extinction of the dinosaurs 65 million years ago. So again, there seems no immediate reason for despair. The Earth is indeed an uncertain place, in an uncertain universe, but with average luck, it should do us well enough. If the world does become inhospitable in the next few thousand or million years, then it will probably be our own fault. In short, despite the underlying uncertainty, our own future and that of our fellow creatures are very much in our own hands.</p>

<p><strong>G</strong> &nbsp;Given average luck on the geological and the cosmic scale, the difference between glory and disaster will be made and is being made, by politics. Certain kinds of political systems and strategies would predispose us to long-term survival (and indeed to comfort and security and pleasure of being alive), while others would take us more and more frenetically towards collapse. The broad point is, though, that we need to look at ourselves – humanity – and at the world in general in a quite new light. Our material problems are fundamentally those of biology. We need to think, and we need our politicians to think, biologically. Do that, and take the ideas seriously, and we are in with a chance. Ignore biology and we and our fellow creatures haven't a hope.</p>
HTML,
    'order'       => 2,
    'created_at'  => now(),
    'updated_at'  => now(),
]);

echo "Created Passage 2, ID: $p2id\n";

// ── Q14-19: YES / NO / NOT GIVEN ─────────────────────────────────────────────
$yngData = [
    'sub_questions' => [
        ['id' => 'q14', 'label' => 'It seems predictable that some species will disappear.'],
        ['id' => 'q15', 'label' => 'The nature of the Earth and human biology make it impossible for human beings to survive another million years.'],
        ['id' => 'q16', 'label' => 'An eruption by Yellowstone is likely to be more destructive than previous volcanic eruptions.'],
        ['id' => 'q17', 'label' => 'There is a greater chance of the Earth being hit by small asteroids than large ones.'],
        ['id' => 'q18', 'label' => 'If the world becomes uninhabitable, it is most likely to be as a result of a natural disaster.'],
        ['id' => 'q19', 'label' => 'Politicians currently in power seem unlikely to change their way of thinking.'],
    ],
    'options'        => ['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN'],
    'correct_answer' => ['q14' => 'YES', 'q15' => 'NO', 'q16' => 'YES', 'q17' => 'NOT GIVEN', 'q18' => 'NO', 'q19' => 'NOT GIVEN'],
    'start_number'   => 13,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 14,
    'type'            => 'yes_no_not_given',
    'question_text'   => 'Do the following statements reflect the <strong>claims</strong> of the writer in Reading Passage 2? Write <strong>YES</strong> if the statement is true, <strong>NO</strong> if the statement is false, or <strong>NOT GIVEN</strong> if the information is not given in the passage.',
    'options'         => json_encode(['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN']),
    'correct_answer'  => json_encode(['q14' => 'YES', 'q15' => 'NO', 'q16' => 'YES', 'q17' => 'NOT GIVEN', 'q18' => 'NO', 'q19' => 'NOT GIVEN']),
    'explanation'     => null,
    'data'            => json_encode($yngData),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

echo "Inserted Q14-19 (YES/NO/NOT GIVEN).\n";

// ── Q20-25: Summary Completion (≤ 2 words) ───────────────────────────────────
$summaryBlanks = [
    ['id' => 'q20', 'blank_number' => 20],
    ['id' => 'q21', 'blank_number' => 21],
    ['id' => 'q22', 'blank_number' => 22],
    ['id' => 'q23', 'blank_number' => 23],
    ['id' => 'q24', 'blank_number' => 24],
    ['id' => 'q25', 'blank_number' => 25],
];

$summaryText = 'The Earth could become uninhabitable, like other planets, through a major change in the [20]. Volcanic eruptions of [21] can lead to shortages of [22] in a wide area. An asteroid hitting the Earth could create a [23] that would result in a new [24]. Plans are being made to use [25] to deflect asteroids heading for the Earth.';

$summaryData = [
    'summary_text'   => $summaryText,
    'blanks'         => $summaryBlanks,
    'correct_answer' => [
        'q20' => 'atmosphere',
        'q21' => 'extraordinary magnitude',
        'q22' => 'food production',
        'q23' => 'tidal wave',
        'q24' => 'ice age',
        'q25' => 'rockets',
    ],
    'instruction' => 'Choose NO MORE THAN TWO WORDS from the passage for each answer.',
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 20,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the summary below. Choose <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q20' => 'atmosphere', 'q21' => 'extraordinary magnitude', 'q22' => 'food production', 'q23' => 'tidal wave', 'q24' => 'ice age', 'q25' => 'rockets']),
    'explanation'     => null,
    'data'            => json_encode($summaryData),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

echo "Inserted Q20-25 (Summary Completion).\n";

// ── Q26: Multiple Choice ──────────────────────────────────────────────────────
DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 26,
    'type'            => 'multiple_choice',
    'question_text'   => 'What is the writer\'s purpose in Reading Passage 2?',
    'options'         => json_encode([
        'A' => 'To propose a new theory about the causes of natural disasters',
        'B' => 'To prove that generally held beliefs about the future are all mistaken',
        'C' => 'To present a range of opinions currently held by scientists',
        'D' => 'To argue the need for a general change in behaviour',
    ]),
    'correct_answer'  => json_encode('D'),
    'explanation'     => null,
    'data'            => json_encode(['question_number' => 26]),
    'order'           => 3,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

echo "Inserted Q26 (Multiple Choice).\n";

// ════════════════════════════════════════════════════════════════════════════════
// PASSAGE 3 — "Pottery production in ancient Akrotiri"
// ════════════════════════════════════════════════════════════════════════════════
$p3id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Pottery production in ancient Akrotiri',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong> which are based on Reading Passage 3 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Pottery production in ancient Akrotiri</h2>

<p><strong>A</strong> &nbsp;Excavations at the site of prehistoric Akrotiri, on the coast of the Aegean Sea, have revealed much about the technical aspects of pottery manufacture, indisputably one of the basic industries of this Greek city. However, considerably less is known about the socio-economic context and the way production was organised.</p>

<p><strong>B</strong> &nbsp;The bulk of pottery found at Akrotiri is locally made and dates from the late fifteenth century BC. It clearly fulfilled a vast range of the settlement's requirements: more than fifty different types of pots can be distinguished. The pottery found includes a wide variety of functional types like storage jars, smaller containers, pouring vessels, cooking pots, drinking vessels and so on, which all relate to specific activities and which would have been made and distributed with those activities in mind. Given a large number of shapes produced and the relatively high degree of standardisation, it has generally been assumed that most, if not all, of Akrotiri pottery, was produced by specialised craftsmen in a non-domestic context. Unfortunately, neither the potters' workshops nor kilns have been found within the excavated area. The reason may be that the ceramic workshops were located on the periphery of the site, which has not yet been excavated. In any event, the ubiquity of the pottery, and the consistent repetition of the same types in different sizes suggest production on an industrial scale.</p>

<p><strong>C</strong> &nbsp;The Akrotirian potters seem to have responded to pressures beyond their households, namely to the increasing complexity of regional distribution and exchange systems. We can imagine them as full-time craftsmen working permanently in a high production-rate craft such as pottery manufacture, and supporting themselves entirely from the proceeds of their craft. In view of the above, one can begin to speak in terms of mass-produced pottery and the existence of organised workshops of craftsmen during the period 1550–1500 BC. Yet, how pottery production was organised at Akrotiri remains an open question, as there is no real documentary evidence. Our entire knowledge comes from the ceramic material itself, and the tentative conclusions which can be drawn from it.</p>

<p><strong>D</strong> &nbsp;The invention of units of quantity and of a numerical system to count them was of capital importance for an exchange-geared society such as that of Akrotiri. In spite of the absence of any written records, the archaeological evidence reveals that concepts of measurements, both weight and number, had been formulated. Standard measures may already have been in operation, such as those evidenced by a graduated series of lead weights – made in disc form – found at the site. The existence of units of capacity in Late Bronze Age times is also evidenced, by the notation of units of a liquid measure for wine on excavated containers.</p>

<p><strong>E</strong> &nbsp;It must be recognised that the function of pottery vessels plays a very important role in determining their characteristics. The intended function affects the choice of clay, the production technique, and the shape and the size of the pots. For example, large storage jars would be needed to store commodities, whereas smaller containers would be used for transport. In fact, the length of a man's arm limits the size of a smaller pot to a capacity of about twenty litres; that is also the maximum a man can comfortably carry.</p>

<p><strong>F</strong> &nbsp;The various sizes of container would thus represent standard quantities of a commodity, which is a fundamental element in the function of exchange. Akrotirian merchants handling a commodity such as wine would have been able to determine easily the amount of wine they were transporting from the number of containers they carried in their ships since the capacity of each container was known to be 14–18 litres. (We could draw a parallel here with the current practice in Greece of selling oil in 17-kilogram tins.)</p>

<p><strong>G</strong> &nbsp;We may, therefore, assume that the shape, capacity, and, sometimes decoration of vessels are indicative of the commodity contained by them. Since individual transactions would normally involve different quantities of a given commodity, a range of 'standardised' types of the vessel would be needed to meet traders' requirements.</p>

<p><strong>H</strong> &nbsp;In trying to reconstruct systems of capacity by measuring the volume of excavated pottery, a rather generous range of tolerances must be allowed. It seems possible that the potters of that time had specific sizes of the vessel in mind, and tried to reproduce them using a specific type and amount of clay. However, it would be quite difficult for them to achieve the exact size required every time, without any mechanical means of regulating symmetry and wall thickness, and some potters would be more skilled than others. In addition, variations in the repetition of types and size may also occur because of unforeseen circumstances during the throwing process. For instance, instead of destroying the entire pot if the clay in the rim contained a piece of grit, a potter might produce a smaller pot by simply cutting off the rim. Even where there is no noticeable external difference between pots meant to contain the same quantity of a commodity, differences in their capacity can actually reach one or two litres. In one case the deviation from the required size appears to be as much as 10–20 per cent.</p>

<p><strong>I</strong> &nbsp;The establishment of regular trade routes within the Aegean led to increased movement of goods; consequently, a regular exchange of local, luxury and surplus goods, including metals, would have become feasible as a result of the advances in transport technology. The increased demand for standardised exchanges, inextricably linked to commercial transactions, might have been one of the main factors which led to the standardisation of pottery production. Thus, the whole network of ceramic production and exchange would have depended on specific regional economic conditions and would reflect the socio-economic structure of prehistoric Akrotiri.</p>
HTML,
    'order'       => 3,
    'created_at'  => now(),
    'updated_at'  => now(),
]);

echo "Created Passage 3, ID: $p3id\n";

// ── Q27-28: Multiple Choice ───────────────────────────────────────────────────
DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 27,
    'type'            => 'multiple_choice',
    'question_text'   => 'What does the writer say about pottery excavated at Akrotiri?',
    'options'         => json_encode([
        'A' => 'There was very little duplication.',
        'B' => 'They would have met a big variety of needs.',
        'C' => 'Most of them had been imported from other places.',
        'D' => 'The intended purpose of each piece was unclear.',
    ]),
    'correct_answer'  => json_encode('B'),
    'explanation'     => null,
    'data'            => json_encode(['question_number' => 27]),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 28,
    'type'            => 'multiple_choice',
    'question_text'   => 'The assumption that pottery from Akrotiri was produced by specialists is partly based on',
    'options'         => json_encode([
        'A' => 'The discovery of kilns.',
        'B' => 'The central location of workshops.',
        'C' => 'The sophistication of decorative patterns.',
        'D' => 'The wide range of shapes represented.',
    ]),
    'correct_answer'  => json_encode('D'),
    'explanation'     => null,
    'data'            => json_encode(['question_number' => 28]),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

echo "Inserted Q27-28 (Multiple Choice).\n";

// ── Q29-32: Sentence Completion (Match Ending A-F) ────────────────────────────
$sentenceEndingOptions = [
    'A' => 'The discovery of a collection of metal discs.',
    'B' => 'The size and type of sailing ships in use.',
    'C' => 'Variations in the exact shape and thickness of similar containers.',
    'D' => 'The physical characteristics of workmen.',
    'E' => 'Marks found on wine containers.',
    'F' => 'The variety of commodities for which they would have been used.',
];

$matchSentences = [
    ['id' => 'q29', 'label' => 'The assumption that standard units of weight were in use could be based on'],
    ['id' => 'q30', 'label' => 'Evidence of the use of standard units of the volume is provided by'],
    ['id' => 'q31', 'label' => 'The size of certain types of containers would have been restricted by'],
    ['id' => 'q32', 'label' => 'Attempts to identify the intended capacity of containers are complicated by'],
];

$matchData = [
    'sub_questions'  => $matchSentences,
    'options'        => $sentenceEndingOptions,
    'correct_answer' => ['q29' => 'A', 'q30' => 'E', 'q31' => 'D', 'q32' => 'C'],
    'start_number'   => 28,
    'box_title'      => null,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 29,
    'type'            => 'matching_sentence_endings',
    'question_text'   => 'Complete each sentence with the correct ending, <strong>A–F</strong>, below.',
    'options'         => json_encode($sentenceEndingOptions),
    'correct_answer'  => json_encode(['q29' => 'A', 'q30' => 'E', 'q31' => 'D', 'q32' => 'C']),
    'explanation'     => null,
    'data'            => json_encode($matchData),
    'order'           => 3,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

echo "Inserted Q29-32 (Matching Sentence Endings).\n";

// ── Q33-38: YES / NO / NOT GIVEN ─────────────────────────────────────────────
$yngData2 = [
    'sub_questions' => [
        ['id' => 'q33', 'label' => 'There are plans to excavate new areas of the archaeological site in the near future.'],
        ['id' => 'q34', 'label' => 'Some of the evidence concerning pottery production in ancient Akrotiri comes from written records.'],
        ['id' => 'q35', 'label' => 'Pots for transporting liquids would have held no more than about 20 litres.'],
        ['id' => 'q36', 'label' => 'It would have been hard for merchants to calculate how much wine was on their ships.'],
        ['id' => 'q37', 'label' => 'The capacity of containers intended to hold the same amounts differed by up to 20 per cent.'],
        ['id' => 'q38', 'label' => 'Regular trading of goods around the Aegean would have led to the general standardisation of quantities.'],
    ],
    'options'        => ['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN'],
    'correct_answer' => ['q33' => 'NOT GIVEN', 'q34' => 'NO', 'q35' => 'YES', 'q36' => 'NO', 'q37' => 'YES', 'q38' => 'YES'],
    'start_number'   => 32,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 33,
    'type'            => 'yes_no_not_given',
    'question_text'   => 'Do the following statements agree with the <strong>views</strong> of the writer in Reading Passage 3? Write <strong>YES</strong> if the statement agrees with the claims of the writer, <strong>NO</strong> if the statement contradicts the claims, or <strong>NOT GIVEN</strong> if it is impossible to say what the writer thinks.',
    'options'         => json_encode(['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN']),
    'correct_answer'  => json_encode(['q33' => 'NOT GIVEN', 'q34' => 'NO', 'q35' => 'YES', 'q36' => 'NO', 'q37' => 'YES', 'q38' => 'YES']),
    'explanation'     => null,
    'data'            => json_encode($yngData2),
    'order'           => 4,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

echo "Inserted Q33-38 (YES/NO/NOT GIVEN).\n";

// ── Q39-40: Multiple Choice ───────────────────────────────────────────────────
DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 39,
    'type'            => 'multiple_choice',
    'question_text'   => 'What does the writer say about the standardisation of container sizes?',
    'options'         => json_encode([
        'A' => 'Containers which looked the same from the outside often varied in capacity.',
        'B' => 'The instruments used to control container size were unreliable.',
        'C' => 'The unsystematic use of different types of clay resulted in size variations.',
        'D' => 'Potters usually discarded containers which were of a non-standard size.',
    ]),
    'correct_answer'  => json_encode('A'),
    'explanation'     => null,
    'data'            => json_encode(['question_number' => 39]),
    'order'           => 5,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 40,
    'type'            => 'multiple_choice',
    'question_text'   => 'What is probably the main purpose of Reading Passage 3?',
    'options'         => json_encode([
        'A' => 'To evaluate the quality of pottery containers found in prehistoric Akrotiri.',
        'B' => 'To suggest how features of pottery production at Akrotiri reflected other developments in the region.',
        'C' => 'To outline the development of pottery-making skills in ancient Greece.',
        'D' => 'To describe methods for storing and transporting household goods in prehistoric societies.',
    ]),
    'correct_answer'  => json_encode('B'),
    'explanation'     => null,
    'data'            => json_encode(['question_number' => 40]),
    'order'           => 6,
    'created_at'      => now(),
    'updated_at'      => now(),
]);

echo "Inserted Q39-40 (Multiple Choice).\n";
echo "\nDone! All 3 passages are now seeded for material 1.\n";
echo "Visit /assignments/ielts-academic/reading/material/1 to view the full test.\n";
