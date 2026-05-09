<?php
/**
 * Seed script: IELTS Reading Practice Test 2
 * Passage 1: "The Cacao: a Sweet History"           → Q1-14
 * Passage 2: "Cosmetics in Ancient Past"            → Q15-27
 * Passage 3: "The Secrets of Persuasion"            → Q28-40
 *
 * material_id = 2
 * Run: /Applications/MAMP/bin/php/php8.4.1/bin/php seed_reading_practice_test2.php
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$materialId = 2;

// ── Clear existing passages for material_id = 2 ──────────────────────────────
$existing = DB::table('ielts_reading_passages')->where('material_id', $materialId)->pluck('id');
if ($existing->count()) {
    DB::table('ielts_reading_questions')->whereIn('passage_id', $existing)->delete();
    DB::table('ielts_reading_passages')->whereIn('id', $existing)->delete();
    echo "Cleared " . $existing->count() . " existing passage(s) for material_id={$materialId}.\n";
}

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 1 — "The Cacao: a Sweet History"
// ════════════════════════════════════════════════════════════════════════════
$p1id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'The Cacao: a Sweet History',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 1–14</strong> which are based on Reading Passage 1 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">The Cacao: a Sweet History</h2>

<p><strong>A</strong> &nbsp;<em>Chapter 1</em><br>Most people today think of chocolate as something sweet to eat or drink that can be easily found in stores around the world. It might surprise you that chocolate was once highly treasured. The tasty secret of the cacao (Kah Kow) tree was discovered 2,000 years ago in the tropical rainforests of the Americas. The story of how chocolate grew from a local Mesoamerican beverage into a global sweet encompasses many cultures and continents.</p>

<p><strong>B</strong> &nbsp;<em>Chapter 2</em><br>Historians believe the Maya people of Central America first learned to farm cacao plants around two thousand years ago. The Maya took cacao trees from the rainforests and grew them in their gardens. They cooked cacao seeds, then crushed them into a soft paste. They mixed the paste with water and flavorful spices to make an unsweetened chocolate drink. The Maya poured the chocolate drink back and forth between two containers so that the liquid would have a layer of bubbles or foam.</p>
<p>Cacao and chocolate were an important part of Maya culture. There are often images of cacao plants on Maya buildings and art objects. Ruling families drank chocolate at special ceremonies. And, even poorer members of society could enjoy the drink once in a while. Historians believe that cacao seeds were also used in marriage ceremonies as a sign of the union between a husband and a wife.</p>
<p>The Aztec culture in current-day Mexico also prized chocolate. But, cacao plants could not grow in the area where the Aztecs lived. So, they traded to get cacao. They even used cacao seeds as a form of money to pay taxes. Chocolate also played a special role in both Maya and Aztec royal and religious events. Priests presented cacao seeds and offerings to the gods and served chocolate drinks during sacred ceremonies. Only the very wealthy in Aztec societies could afford to drink chocolate because cacao was so valuable. The Aztec ruler Montezuma was believed to drink fifty cups of chocolate every day. Some experts believe the word for chocolate came from the Aztec word "xocolatl" which in the Nahuatl language means "bitter water." Others believe the word "chocolate" was created by combining Mayan and Nahuatl words.</p>

<p><strong>C</strong> &nbsp;<em>Chapter 3</em><br>The explorer Christopher Columbus brought cacao seeds to Spain after his trip to Central America in 1502. But it was the Spanish explorer Hernando Cortes who understood that chocolate could be a valuable investment. In 1519, Cortes arrived in current-day Mexico. He believed the chocolate drink would become popular with Spaniards. After the Spanish soldiers defeated the Aztec empire, they were able to seize the supplies of cacao and send them home. Spain later began planting cacao in its colonies in the Americas in order to satisfy the large demand for chocolate. The wealthy people of Spain first enjoyed a sweetened version of chocolate drink. Later, the popularity of the drink spread throughout Europe. The English, Dutch and French began to plant cacao trees in their own colonies. Chocolate remained a drink that only wealthy people could afford to drink until the eighteenth century. During the period known as the Industrial Revolution, new technologies helped make chocolate less costly to produce.</p>

<p><strong>D</strong> &nbsp;<em>Chapter 4</em><br>Farmers grow cacao trees in many countries in Africa, Central and South America. The trees grow in the shady areas of the rainforests near the Earth's equator. But these trees can be difficult to grow. They require an exact amount of water, warmth, soil and protection. After about five years, cacao trees start producing large fruits called pods, which grow near the trunk of the tree. The seeds inside the pods are harvested to make chocolate. There are several kinds of cacao trees. Most of the world's chocolate is made from the seed of the forastero tree. But farmers can also grow criollo or trinitario cacao plants. Cacao trees grown on farms are much more easily threatened by diseases and insects than wild trees. Growing cacao is very hard work for farmers. They sell their harvest on a futures market. This means that economic conditions beyond their control can affect the amount of money they will earn. Today, chocolate industry officials, activists, and scientists are working with farmers. They are trying to make sure that cacao can be grown in a way that is fair to the farmers and safe for the environment.</p>

<p><strong>E</strong> &nbsp;<em>Chapter 5</em><br>To become chocolate, cacao seeds go through a long production process in a factory. Workers must sort, clean and cook the seeds. Then they break off the covering of the seeds so that only the inside fruit, or nibs, remain. Workers crush the nibs into a soft substance called chocolate liquor. This gets separated into cocoa solids and fat called cocoa butter. Chocolate makers have their own special recipes in which they combine chocolate liquor with exact amounts of sugar, milk and cocoa fat. They finely crush this "crumb" mixture in order to make it smooth. The mixture then goes through two more processes before it is shaped into a mold form.</p>
<p>Chocolate making is big business. The market value of the yearly cacao crop around the world is more than five billion dollars. Chocolate is especially popular in Europe and the United States. For example, in 2005, the United States bought 1.4 billion dollars worth of cocoa products. Each year, Americans eat an average of more than five kilograms of chocolate per person. Speciality shops that sell costly chocolates are also very popular. Many offer chocolate lovers the chance to taste chocolates grown in different areas of the world.</p>
HTML,
    'order'       => 1,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 1, ID: $p1id\n";

// ── Q1-5: Matching Paragraph/Chapter Information ─────────────────────────────
$matchParaData = [
    'sub_questions' => [
        ['id' => 'q1', 'label' => 'the part of cacao trees used to produce chocolate'],
        ['id' => 'q2', 'label' => 'average chocolate consumption by people in the US per person per year'],
        ['id' => 'q3', 'label' => 'risks faced by farmers in the cacao business'],
        ['id' => 'q4', 'label' => 'where the first sweetened chocolate drink appeared'],
        ['id' => 'q5', 'label' => 'how ancient American civilizations obtained cacao'],
    ],
    'options' => [
        'A' => 'Chapter 1',
        'B' => 'Chapter 2',
        'C' => 'Chapter 3',
        'D' => 'Chapter 4',
        'E' => 'Chapter 5',
    ],
    'correct_answer' => ['q1' => 'D', 'q2' => 'E', 'q3' => 'D', 'q4' => 'C', 'q5' => 'B'],
    'start_number' => 0,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 1,
    'type'            => 'matching_paragraph_information',
    'question_text'   => 'Reading Passage 1 has <strong>5 chapters (A–E)</strong>. Which chapter contains the following information? Write the correct letter <strong>A–E</strong> in boxes 1–5 on your answer sheet. <em>NB You may use any letter more than once.</em>',
    'options'         => json_encode($matchParaData['options']),
    'correct_answer'  => json_encode($matchParaData['correct_answer']),
    'explanation'     => null,
    'data'            => json_encode($matchParaData),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q1-5 (Matching Paragraph).\n";

// ── Q6-10: TRUE / FALSE / NOT GIVEN ──────────────────────────────────────────
$tfngData = [
    'sub_questions' => [
        ['id' => 'q6',  'label' => 'Use of cacao and chocolate in ceremonies was restricted to Maya royal families.'],
        ['id' => 'q7',  'label' => 'The Spanish explorer Hernando Cortes invested in chocolate and chocolate drinks.'],
        ['id' => 'q8',  'label' => 'The forastero tree produces the best chocolate.'],
        ['id' => 'q9',  'label' => 'Some parts of the cacao seed are discarded during the chocolate production process.'],
        ['id' => 'q10', 'label' => 'Chocolate is more popular in some countries or continents than in others.'],
    ],
    'options'        => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
    'correct_answer' => ['q6' => 'FALSE', 'q7' => 'TRUE', 'q8' => 'NOT GIVEN', 'q9' => 'TRUE', 'q10' => 'TRUE'],
    'start_number'   => 5,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 6,
    'type'            => 'true_false',
    'question_text'   => 'Do the following statements agree with the information given in Reading Passage 1? Write <strong>TRUE</strong> if the statement is true, <strong>FALSE</strong> if the statement is false, or <strong>NOT GIVEN</strong> if the information is not given in the passage.',
    'options'         => json_encode(['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN']),
    'correct_answer'  => json_encode(['q6' => 'FALSE', 'q7' => 'TRUE', 'q8' => 'NOT GIVEN', 'q9' => 'TRUE', 'q10' => 'TRUE']),
    'explanation'     => null,
    'data'            => json_encode($tfngData),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q6-10 (TRUE/FALSE/NOT GIVEN).\n";

// ── Q11-14: Flow Chart Completion (≤ 3 words) ─────────────────────────────────
$flowData = [
    'box_title'    => 'Questions 11-14',
    'instruction'  => 'The flow chart below shows the steps in chocolate making. Complete the flow chart using NO MORE THAN THREE WORDS from the passage for each blank. Write your answers in boxes 11-14 on your answer sheet.',
    'summary_text' => '<div class="flex flex-col items-center justify-center space-y-1 pt-1 pb-1 text-gray-800 font-normal text-base text-center">
    <div class="font-bold text-lg">Cacao seeds</div>
    
    <div class="text-gray-400 text-xl font-bold">↓</div>
    
    <div class="max-w-md">sorting, cleaning and cooking; ridding seeds of their <br> <div class="flex justify-center mt-1">[11]</div></div>
    
    <div class="text-gray-400 text-xl font-bold">↓</div>
    
    <div class="font-bold text-lg">Nibs</div>
    
    <div class="text-gray-400 text-xl font-bold">↓</div>
    
    <div>crushing</div>
    
    <div class="text-gray-400 text-xl font-bold">↓</div>
    
    <div class="flex justify-center">[12]</div>
    
    <div class="text-gray-400 text-xl font-bold">↓</div>
    
    <div>Add sugar, milk and <br> <div class="flex justify-center mt-1">[13]</div></div>
    
    <div class="text-gray-400 text-xl font-bold">↓</div>
    
    <div class="font-bold text-lg">Crumb mixture</div>
    
    <div class="text-gray-400 text-xl font-bold">↓</div>
    
    <div class="max-w-md">Crush finely then come into a shape in a <br> <div class="flex justify-center mt-1">[14]</div></div>
    
    <div class="text-gray-400 text-xl font-bold">↓</div>
    
    <div class="font-bold text-lg">Chocolate</div>
</div>',
    'blanks' => [
        ['id' => 'q11', 'blank_number' => 11],
        ['id' => 'q12', 'blank_number' => 12],
        ['id' => 'q13', 'blank_number' => 13],
        ['id' => 'q14', 'blank_number' => 14],
    ],
    'correct_answer' => [
        'q11' => 'covering',
        'q12' => 'chocolate liquor',
        'q13' => 'cocoa fat',
        'q14' => 'mold form',
    ],
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 11,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the flow chart below using <strong>NO MORE THAN THREE WORDS</strong> from the passage for each blank.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q11' => 'covering', 'q12' => 'chocolate liquor', 'q13' => 'cocoa fat', 'q14' => 'mold form']),
    'explanation'     => null,
    'data'            => json_encode($flowData),
    'order'           => 3,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q11-14 (Flow Chart Completion).\n";

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 2 — "Cosmetics in Ancient Past"
// ════════════════════════════════════════════════════════════════════════════
$p2id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Cosmetics in Ancient Past',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 15–27</strong> which are based on Reading Passage 2 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Cosmetics in Ancient Past</h2>

<p><strong>A</strong> &nbsp;Since cosmetics and perfumes are still in wide use today, it is interesting to compare the attitudes, customs and beliefs related to them in ancient times to those of our own day and age. Cosmetics and perfumes have been popular since the dawn of civilization; it is shown by the discovery of a great deal of pertinent archaeological material, dating from the third millennium BC. Mosaics, glass perfume flasks, stone vessels, ovens, cooking-pots, clay jars, etc., some inscribed by the hand of the artisan. Evidence also appears in the Bible and other classical writings, where it is written that spices and perfumes were prestigious products known throughout the ancient world and coveted by kings and princes. The written and pictorial descriptions, as well as archaeological findings, all show how important body care and aesthetic appearance were in the lives of the ancient people. The chain of evidence spans many centuries, detailing the usage of cosmetics in various cultures from the earliest period of recorded history.</p>

<p><strong>B</strong> &nbsp;In antiquity, however, at least in the onset, cosmetics served in religious ceremonies and for healing purposes. Cosmetics were also connected with cultic worship and witchcraft: to appease the various gods, fragrant ointments were applied to the statuary images and even to their attendants. From this, in the course of time, developed the custom of personal use, to enhance the beauty of the face and the body, and to conceal defects.</p>

<p><strong>C</strong> &nbsp;Perfumes and fragrant spices were precious commodities in antiquity, very much in demand, and at times even exceeded silver and gold in value. Therefore they were luxury products, used mainly in the temples and in the homes of the noble and wealthy. The Judean kings kept them in treasure houses (2 Kings 20:13). And the Queen of Sheba brought to Solomon "camels laden with spices, gold in great quantity and precious stones." (1 Kings 10:2, 10). However, within time, the use of cosmetics became the custom of that period. The use of cosmetics became widespread among the lower classes as well as among the wealthy; in the same way, they washed the body, so they used to care for the body with substances that softened the skin and anoint it with fragrant oils and ointments.</p>

<p><strong>D</strong> &nbsp;Facial treatment was highly developed and women devoted many hours to it. They used to spread various scented creams on the face and to apply makeup in vivid and contrasting colors. An Egyptian papyrus from the 16th century BC contains detailed recipes to remove blemishes, wrinkles, and other signs of age. Greek and Roman women would cover their faces in the evening with a "beauty mask" to remove blemishes, which consisted mainly of flour mixed with fragrant spices, leaving it on their face all night. The next morning they would wash it off with asses' milk. The very common creams used by women in the ancient Far East, particularly important in the hot climate and prevalent in that area of the globe, were made up of oils and aromatic scents. Sometimes the oil in these creams was extracted from olives, almonds, gourds, sesame, or from trees and plants; but, for those of limited means, scented animal and fish fats were commonly used.</p>

<p><strong>E</strong> &nbsp;Women in the ancient past commonly put colors around their eyes. Besides beautification, its purpose was also medicinal as covering the sensitive skin of the lids with colored ointments that prevented dryness and eye diseases: the eye-paint repelled the little flies that transmitted eye inflammations. Egyptian women colored the upper eyelid black and the lower one green and painted the space between the upper lid and the eyebrow gray and blue. The women of Mesopotamia favored yellows and reds. The use of kohl for painting the eyes is mentioned three times in the Bible, always with disapproval by the sages (2 Kings, 9:30; Jeremiah 4:30; Ezekiel 23:40). In contrast, Job named one of his daughters "Keren Happukh"— "horn of eye paint" (Job 42:14)</p>

<p><strong>F</strong> &nbsp;Great importance was attached to the care for hair in ancient times. Long hair was always considered a symbol of beauty, and kings, nobles and dignitaries grew their hair long and kept it well-groomed and cared for. Women devoted much time to the style of the hair; while no cutting, they would apply much care to it by arranging it skillfully in plaits and "building it up" sometimes with the help of wigs. Egyptian women generally wore their hair flowing down to their shoulders or even longer. In Mesopotamia, women cherished long hair as a part of their beauty, and hair flowing down their backs in a thick plait and tied with a ribbon is seen in art. Assyrian women wore their hair shorter, braiding and binding it in a bun at the back. In Ancient Israel, brides would wear their hair long on the wedding day as a sign of their virginity. Ordinary people and slaves, however, usually wore their hair short, mainly for hygienic reasons, since they could not afford to invest in the kind of treatment that long hair required.</p>

<p><strong>G</strong> &nbsp;From the Bible and Egyptian and Assyrian sources, as well as the words of classical authors, it appears that the centers of the trade in aromatic resins and incense were located in the kingdoms of southern Arabia, and even as far as India, where some of these precious aromatic plants were grown. "Dealers from Sheba and Rammah dealt with you, offering the choicest spices…" (Ezekiel 27:22). The Nabateans functioned as the important middlemen in this trade; Palestine also served as a very important component, as the trade routes crisscrossed the country. It is known that the Egyptian Queen Hatsheput (15th century BC) sent a royal expedition to the Land of Punt (Somalia) in order to bring back myrrh seedlings to plant in her temple. In Assyrian records of tribute and spoils of war, perfumes and resins are mentioned; the text from the time of Tukulti-Ninurta II (890-884 BC) refers to balls of myrrh as a part of the tribute brought to the Assyrian king by the Aramaean kings. The trade in spices and perfumes are also mentioned in the Bible as written in Genesis (37:25-26), "Camels carrying gum tragacanth and balm and myrrh".</p>
HTML,
    'order'       => 2,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 2, ID: $p2id\n";

// ── Q15-21: Matching Paragraph Information ────────────────────────────────────
$matchPara2Data = [
    'sub_questions' => [
        ['id' => 'q15', 'label' => 'recipes to conceal facial defects caused by aging'],
        ['id' => 'q16', 'label' => 'perfumes were presented to conquerors in war'],
        ['id' => 'q17', 'label' => 'long hair of girls had special meanings in marriage'],
        ['id' => 'q18', 'label' => 'evidence exists in abundance showing cosmetics use in ancient times'],
        ['id' => 'q19', 'label' => 'protecting eyes from fly-transmitted diseases'],
        ['id' => 'q20', 'label' => 'from witchcraft to beautification'],
        ['id' => 'q21', 'label' => 'more expensive than gold'],
    ],
    'options' => [
        'A' => 'Paragraph A',
        'B' => 'Paragraph B',
        'C' => 'Paragraph C',
        'D' => 'Paragraph D',
        'E' => 'Paragraph E',
        'F' => 'Paragraph F',
        'G' => 'Paragraph G',
    ],
    'correct_answer' => ['q15' => 'D', 'q16' => 'G', 'q17' => 'F', 'q18' => 'A', 'q19' => 'E', 'q20' => 'B', 'q21' => 'C'],
    'start_number' => 14,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 15,
    'type'            => 'matching_paragraph_information',
    'question_text'   => 'Reading Passage 2 has <strong>7 paragraphs (A–G)</strong>. Which paragraph contains the following information? Write the correct letter <strong>A–G</strong> in boxes 15–21 on your answer sheet.',
    'options'         => json_encode($matchPara2Data['options']),
    'correct_answer'  => json_encode($matchPara2Data['correct_answer']),
    'explanation'     => null,
    'data'            => json_encode($matchPara2Data),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q15-21 (Matching Paragraph).\n";

// ── Q22-27: TRUE / FALSE / NOT GIVEN ─────────────────────────────────────────
$tfng2Data = [
    'sub_questions' => [
        ['id' => 'q22', 'label' => 'The written record for cosmetics and perfumes dates back to the third millennium BC.'],
        ['id' => 'q23', 'label' => 'Since perfumes and spices were luxury products, their use was exclusive to the noble and the wealthy.'],
        ['id' => 'q24', 'label' => 'In the ancient Far East, fish fats were used as a cream by women from poor households.'],
        ['id' => 'q25', 'label' => 'The teachings in the Bible were repeatedly against the use of kohl for painting the eyes.'],
        ['id' => 'q26', 'label' => 'Long hair as a symbol of beauty was worn solely by women of ancient cultures.'],
        ['id' => 'q27', 'label' => 'The Egyptian Queen Hatsheput sent a royal expedition to Punt to establish a trade route for myrrh.'],
    ],
    'options'        => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
    'correct_answer' => ['q22' => 'TRUE', 'q23' => 'FALSE', 'q24' => 'TRUE', 'q25' => 'TRUE', 'q26' => 'FALSE', 'q27' => 'FALSE'],
    'start_number'   => 21,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 22,
    'type'            => 'true_false',
    'question_text'   => 'Do the following statements agree with the information given in Reading Passage 2? Write <strong>TRUE</strong> if the statement is true, <strong>FALSE</strong> if the statement is false, or <strong>NOT GIVEN</strong> if the information is not given in the passage.',
    'options'         => json_encode(['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN']),
    'correct_answer'  => json_encode(['q22' => 'TRUE', 'q23' => 'FALSE', 'q24' => 'TRUE', 'q25' => 'TRUE', 'q26' => 'FALSE', 'q27' => 'FALSE']),
    'explanation'     => null,
    'data'            => json_encode($tfng2Data),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q22-27 (TRUE/FALSE/NOT GIVEN).\n";

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 3 — "The Secrets of Persuasion"
// ════════════════════════════════════════════════════════════════════════════
$p3id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'The Secrets of Persuasion',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 28–40</strong> which are based on Reading Passage 3 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">The Secrets of Persuasion</h2>

<p><strong>A</strong> &nbsp;Our mother may have told you the secret to getting what you ask for was to say please. The reality is rather more surprising. Adam Dudding talks to a psychologist who has made a life's work from the science of persuasion. Some scientists peer at things through high-powered microscopes. Others goad rats through mazes or mix bubbling fluids in glass beakers. Robert Cialdini, for his part, does curious things with towels and believes that by doing so he is discovering important insights into how society works.</p>

<p><strong>B</strong> &nbsp;Cialdini's towel experiments (more of them later), are part of his research into how we persuade others to say yes. He wants to know why some people have a knack for bending the will of others, be it a telephone cold-caller talking to you about timeshares, or a parent whose children are compliant even without threats of extreme violence. While he's anxious not to be seen as the man who's written the bible for snake-oil salesmen, for decades the Arizona State University social psychology professor has been creating systems for the principles and methods of persuasion and writing bestsellers about them. Some people seem to be born with the skills; Cialdini's claim is that by applying a little science, even those of us who aren't should be able to get our own way more often. "All my life I've been an easy mark for the blandishment of salespeople and fundraisers and I'd always wondered why they could get me to buy things I didn't want and give to causes I hadn't heard of," says Cialdini on the phone from London, where he is plugging his latest book.</p>

<p><strong>C</strong> &nbsp;He found that laboratory experiments on the psychology of persuasion were telling only part of the story, so he began to research influence in the real world, enrolling in sales-training programmes: "I learnt how to sell automobiles from a lot, how to sell insurance from an office, how to sell encyclopedias door to door." He concluded there were six general "principles of influence" and has since put them to the test under slightly more scientific conditions. Most recently, that has meant messing about with towels. Many hotels leave a little card in each bathroom asking guests to reuse towels and thus conserve water and electricity and reduce pollution. Cialdini and his colleagues wanted to test the relative effectiveness of different words on those cards. Would guests be motivated to co-operate simply because it would help save the planet, or were other factors more compelling? To test this, the researchers changed the card's message from an environmental one to the simple (and truthful) statement that the majority of guests at the hotel had reused their towel at least once. Guests given this message were 26% more likely to reuse their towels than those given the old message. In Cialdini's book "Yes! 50 Secrets from the Science of Persuasion", co-written with another social scientist and a business consultant, he explains that guests were responding to the persuasive force of "social proof", the idea that our decisions are strongly influenced by what we believe other people like us are doing.</p>

<p><strong>D</strong> &nbsp;So much for towels. Cialdini has also learnt a lot from confectionery. <em>Yes!</em> cites the work of New Jersey behavioural scientist David Strohmetz, who wanted to see how restaurant patrons would respond to a ridiculously small favour from their food server, in the form of after-dinner chocolate for each diner. The secret, it seems, is in how you give the chocolate. When the chocolates arrived in a heap with the bill, tips went up a miserly 3% compared to when no chocolate was given. But when the chocolates were dropped individually in front of each diner, tips went up 14%. The scientific breakthrough, though, came when the waitress gave each diner one chocolate, headed away from the table then doubled back to give them one more each as if such generosity had only just occurred to her. Tips went up 23%. This is "reciprocity" in action: we want to return favours done to us, often without bothering to calculate the relative value of what is being received and given.</p>

<p><strong>E</strong> &nbsp;Geeling Ng, operations manager at Auckland's Soul Bar, says she's never heard of Kiwi waiting staff using such a cynical trick, not least because New Zealand tipping culture is so different from that of the US: "If you did that in New Zealand, as diners were leaving they'd say 'can we have some more?'" But she certainly understands the general principle of reciprocity. The way to a diner's heart is "to give them something they're not expecting in the way of service. It might be something as small as leaving a mint on their plate, or it might be remembering that last time they were in they wanted their water with no ice and no lemon. In America, it would translate into an instant tip. In New Zealand, it translates into a huge smile and thanks to you." And no doubt, return visits.</p>

<h3 class="font-bold text-gray-800 mt-4 mb-2">THE FIVE PRINCIPLES OF PERSUASION</h3>

<p><strong>F</strong> &nbsp;<strong>Reciprocity:</strong> People want to give back to those who have given to them. The trick here is to get in first. That's why charities put a crummy pen inside a mailout, and why smiling women in supermarkets hand out dollops of free food. <strong>Scarcity:</strong> People want more of things they can have less of. Advertisers ruthlessly exploit scarcity ("limit four per customer", "sale must end soon"), and Cialdini suggests parents do too: "Kids want things that are less available, so say 'this is an unusual opportunity; you can only have this for a certain time'."</p>

<p><strong>G</strong> &nbsp;<strong>Authority:</strong> We trust people who know what they're talking about. So inform people honestly of your credentials before you set out to influence them. "You'd be surprised how many people fail to do that," says Cialdini. "They feel it's impolite to talk about their expertise." In one study, therapists whose patients wouldn't do their exercises were advised to display their qualification certificates prominently. They did and experienced an immediate leap in patient compliance.</p>

<p><strong>H</strong> &nbsp;<strong>Commitment/consistency:</strong> We want to act in a way that is consistent with the commitments we have already made. Exploit this to get a higher sign-up rate when soliciting charitable donations. First, ask workmates if they think they will sponsor you on your egg-and-spoon marathon. Later, return with the sponsorship form to those who said yes and remind them of their earlier commitment.</p>

<p><strong>I</strong> &nbsp;<strong>Liking:</strong> We say yes more often to people we like. Obvious enough, but reasons for "liking" can be weird. In one study, people were sent survey forms and asked to return them to a named researcher. When the researcher gave a fake name resembling that of the subject (eg, Cynthia Johnson is sent a survey by "Cindy Johansen"), surveys were twice as likely to be completed. We favour people who resemble us, even if the resemblance is as minor as the sound of their name.</p>

<p><strong>J</strong> &nbsp;<strong>Social proof:</strong> We decide what to do by looking around to see what others just like us are doing. Useful for parents, says Cialdini. "Find groups of children who are behaving in a way that you would like your child to, because the child looks to the side, rather than at you." More perniciously, social proof is the force underpinning the competitive materialism of "keeping up with the Joneses".</p>
HTML,
    'order'       => 3,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 3, ID: $p3id\n";

// ── Q28-31: Multiple Choice ───────────────────────────────────────────────────
$mcqQuestions = [
    [28, 'The main purpose of Cialdini\'s research and writing is to',
     ['A' => 'explain the reason why researchers should investigate in person',
      'B' => 'explore the secret of why some people become famous salespeople',
      'C' => 'help people to sell products more easily',
      'D' => 'prove that there is a science in the psychology of persuasion'],
     'D', 1],
    [29, 'Which statement is CORRECT according to Cialdini\'s research methodology?',
     ['A' => 'He checked data in a lot of latest books',
      'B' => 'He conducted this experiment only in the laboratory',
      'C' => 'He enrolled in sales programmes and worked with many salespeople',
      'D' => 'He made a lot of phone calls to collect what he wanted to know'],
     'C', 2],
    [30, 'Which of the following is CORRECT according to the towel experiment in the passage?',
     ['A' => 'Different hotel guests act in different responses',
      'B' => 'Most guests act based on the idea of environmental preservation',
      'C' => 'More customers tended to cooperate when told others had done so than when given an environmental message',
      'D' => 'People tend to follow the hotel\'s original environmental message more'],
     'C', 3],
    [31, 'Which of the following is CORRECT according to the chocolate experiment in the passage?',
     ['A' => 'The way chocolate is presented affects the amount of tips diners give',
      'B' => 'Regular customers give tips more than irregular ones',
      'C' => 'People only give tips when offered chocolate',
      'D' => 'Chocolate given with the bill got higher tips than individual presentation'],
     'A', 4],
];

foreach ($mcqQuestions as [$qNum, $qText, $opts, $ans, $ord]) {
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
echo "Inserted Q28-31 (Multiple Choice).\n";

// ── Q32-35: TRUE / FALSE / NOT GIVEN ─────────────────────────────────────────
$tfng3Data = [
    'sub_questions' => [
        ['id' => 'q32', 'label' => 'Robert Cialdini experienced "principles of influence" himself in real life.'],
        ['id' => 'q33', 'label' => 'The principle of persuasion has different types in different countries.'],
        ['id' => 'q34', 'label' => 'In New Zealand, people tend to give tips to attendants after being served chocolate.'],
        ['id' => 'q35', 'label' => 'The elder generation of New Zealand is easily attracted by the extra service of restaurants based on the principle of reciprocity.'],
    ],
    'options'        => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
    'correct_answer' => ['q32' => 'TRUE', 'q33' => 'NOT GIVEN', 'q34' => 'FALSE', 'q35' => 'NOT GIVEN'],
    'start_number'   => 31,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 32,
    'type'            => 'true_false',
    'question_text'   => 'Do the following statements agree with the information given in Reading Passage 3? Write <strong>TRUE</strong> if the statement is true, <strong>FALSE</strong> if the statement is false, or <strong>NOT GIVEN</strong> if the information is not given in the passage.',
    'options'         => json_encode(['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN']),
    'correct_answer'  => json_encode(['q32' => 'TRUE', 'q33' => 'NOT GIVEN', 'q34' => 'FALSE', 'q35' => 'NOT GIVEN']),
    'explanation'     => null,
    'data'            => json_encode($tfng3Data),
    'order'           => 5,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q32-35 (TRUE/FALSE/NOT GIVEN).\n";

// ── Q36-40: Category Matching (using matching_sentence_endings renderer) ──────
$catOptions = [
    'A' => 'Reciprocity / Scarcity',
    'B' => 'Authority',
    'C' => 'Commitment / Consistency',
    'D' => 'Liking',
    'E' => 'Social Proof',
];

$catSentences = [
    ['id' => 'q36', 'label' => 'Some experts may reveal their qualifications in front of clients.'],
    ['id' => 'q37', 'label' => 'Parents tell their child about what other kids of the same age are doing.'],
    ['id' => 'q38', 'label' => 'Advertisers ruthlessly exploit the limitation of chances.'],
    ['id' => 'q39', 'label' => 'Using a familiar name in a survey to get a higher response rate.'],
    ['id' => 'q40', 'label' => 'Asking colleagues in advance whether they will offer a helping hand.'],
];

$catData = [
    'sub_questions'  => $catSentences,
    'options'        => $catOptions,
    'correct_answer' => ['q36' => 'B', 'q37' => 'E', 'q38' => 'A', 'q39' => 'D', 'q40' => 'C'],
    'start_number'   => 35,
    'box_title'      => 'Principles of Persuasion',
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 36,
    'type'            => 'matching_sentence_endings',
    'question_text'   => 'Use the information in the passage to match the principle of persuasion (<strong>A–E</strong>) with the correct description below. Write the appropriate letter <strong>A–E</strong> in boxes 36–40. <em>NB You may use any letter more than once.</em>',
    'options'         => json_encode($catOptions),
    'correct_answer'  => json_encode(['q36' => 'B', 'q37' => 'E', 'q38' => 'A', 'q39' => 'D', 'q40' => 'C']),
    'explanation'     => null,
    'data'            => json_encode($catData),
    'order'           => 6,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q36-40 (Category Matching).\n";

echo "\nDone! Practice Test 2 seeded with material_id={$materialId}.\n";
echo "Passage 1 ID: {$p1id} | Passage 2 ID: {$p2id} | Passage 3 ID: {$p3id}\n";
echo "Visit /assignments/ielts-academic/reading/material/2 to verify.\n";
