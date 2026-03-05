<?php
/**
 * Seed script: IELTS Reading Practice Test 3
 * Passage 1: "Bondi Beach"                   → Q1-13
 * Passage 2: "Antarctica – in from the cold?" → Q14-26
 * Passage 3: "Talc Powder"                   → Q27-40
 *
 * material_id = 3
 * Run: /Applications/MAMP/bin/php/php8.4.1/bin/php seed_reading_practice_test3.php
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$materialId = 3;

// Clear existing passages for material_id = 3
$existing = DB::table('ielts_reading_passages')->where('material_id', $materialId)->pluck('id');
if ($existing->count()) {
    DB::table('ielts_reading_questions')->whereIn('passage_id', $existing)->delete();
    DB::table('ielts_reading_passages')->whereIn('id', $existing)->delete();
    echo "Cleared " . $existing->count() . " existing passage(s) for material_id={$materialId}.\n";
}

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 1 — "Bondi Beach"
// ════════════════════════════════════════════════════════════════════════════
$p1id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Bondi Beach',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong> which are based on Reading Passage 1 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Bondi Beach</h2>

<p><strong>A</strong> &nbsp;Bondi Beach, Australia's most famous beach, is located in the suburb of Bondi, in the Local Government Area of Waverley, seven kilometers from the centre of Sydney. "Bondi" or "Boondi" is an Aboriginal word meaning water breaking over rocks or the sound of breaking waves. The Australian Museum records that Bondi means a place where a flight of nullas took place. There are Aboriginal Rock carvings on the northern end of the beach at Ben Buckler and south of Bondi Beach near McKenzies Beach on the coastal walk.</p>

<p><strong>B</strong> &nbsp;The indigenous people of the area at the time of European settlement have generally been referred to as the Sydney people or the Eora (Eora means "the people"). One theory describes the Eora as a sub-group of the Darug language group which occupied the Cumberland Plain west to the Blue Mountains. However, another theory suggests that they were a distinct language group of their own. There is no clear evidence for the name or names of the particular band(s) of the Eora that roamed what is now the Waverley area. A number of place names within Waverley, most famously Bondi, have been based on words derived from Aboriginal languages of the Sydney region.</p>

<p><strong>C</strong> &nbsp;From the mid-1800s Bondi Beach was a favourite location for family outings and picnics. The beginnings of the suburb go back to 1809, when the early road builder, William Roberts, received from Governor Bligh a grant of 81 hectares of what is now most of the business and residential area of Bondi Beach. In 1851, Edward Smith Hall and Francis O'Brien purchased 200 acres of the Bondi area that embraced almost the whole frontage of Bondi Beach, and it was named "The Bondi Estate." Between 1855 and 1877 O'Brien purchased Hall's share of the land, renamed the land the "O'Brien Estate," and made the beach and the surrounding land available to the public as a picnic ground and amusement resort. As the beach became increasingly popular, O'Brien threatened to stop public beach access. However, the Municipal Council believed that the Government needed to intervene to make the beach a public reserve.</p>

<p><strong>D</strong> &nbsp;During the 1900s the beach became associated with health, leisure and democracy – a playground everyone could enjoy equally. Bondi Beach was a working-class suburb throughout most of the twentieth century with migrant people from New Zealand comprising the majority of the local population. The first tramway reached the beach in 1884. Following this, the tram became the first public transportation in Bondi. As an alternative, this action changed the rule that only rich people could enjoy the beach. By the 1930s Bondi was drawing not only local visitors but also people from elsewhere in Australia and overseas. Advertising at the time referred to Bondi Beach as the "Playground of the Pacific".</p>

<p><strong>E</strong> &nbsp;There is a growing trend that people prefer having to relax near a seaside instead of living unhealthily in cities. The increasing popularity of sea bathing during the late 1800s and early 1900s raised concerns about public safety and how to prevent people from drowning. In response, the world's first formally documented surf lifesaving club, the Bondi Surf Bathers' Life Saving Club, was formed in 1907. This was powerfully reinforced by the dramatic events of "Black Sunday" at Bondi in 1938. Some 35,000 people were on the beach and a large group of lifesavers were about to start a surf race when three freak waves hit the beach, sweeping hundreds of people out to sea. Lifesavers rescued 300 people. The largest mass rescue in the history of surf bathing, it confirmed the place of the lifesaver in the national imagination.</p>

<p><strong>F</strong> &nbsp;Bondi Beach is the endpoint of the City to Surf Fun Run which is held each year in August. Australian surf carnivals further instilled this image. A Royal Surf Carnival was held at Bondi Beach for Queen Elizabeth II during her first visit to Australia in 1954. Since 1867, there have been over fifty visits by a member of the British Royal Family to Australia. In addition to many activities, the Bondi Beach Markets is open every Sunday. Many wealthy people spend Christmas Day at the beach. However, the shortage of houses occurs when lots of people crowd to the seaside. Manly is the seashore town which solved this problem. However, people still choose Bondi as their preferred destination rather than Manly.</p>

<p><strong>G</strong> &nbsp;Bondi Beach has a commercial area along Campbell Parade and adjacent side streets, featuring many popular cafes, restaurants, and hotels, with views of the contemporary beach. It is depicted as wholly modern and European. In the last decade, Bondi Beach's unique position has seen a dramatic rise in svelte houses and apartments to take advantage of the views and scent of the sea. The valley running down to the beach is famous the world over for its view of distinctive red-tiled roofs. Those architectures are deeply influenced by British coastal towns.</p>

<p><strong>H</strong> &nbsp;Bondi Beach hosted the beach volleyball competition at the 2000 Summer Olympics. A temporary 10,000-seat stadium, a much smaller stadium, 2 warm-up courts, and 3 training courts were set up to host the tournament. The Bondi Beach Volleyball Stadium was constructed for it and stood for just six weeks. Campaigners opposed both the social and environmental consequences of the development. The stadium would divide the beach in two and seriously restrict public access for swimming, walking, and other forms of outdoor recreation. People protested for their human rights to have a pure seaside and argued for a healthy life in Bondi.</p>

<p><strong>I</strong> &nbsp;"They're prepared to risk lives and risk the Bondi beach environment for the sake of eight days of volleyball", said Stephen Uniacke, a construction lawyer involved in the campaign. Other environmental concerns include the possibility that soil dredged up from below the sand will acidify when brought to the surface.</p>
HTML,
    'order'       => 1,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 1 (Bondi Beach), ID: $p1id\n";

// ── Q1-5: TRUE / FALSE / NOT GIVEN ───────────────────────────────────────────
$tfng1 = [
    'sub_questions' => [
        ['id' => 'q1', 'label' => 'The name of Bondi beach was first used by British settlers.'],
        ['id' => 'q2', 'label' => 'The Aboriginal culture in Australia is different when compared with European culture.'],
        ['id' => 'q3', 'label' => 'Bondi beach area holds many contemporary hotels.'],
        ['id' => 'q4', 'label' => 'The seaside town in Bondi is affected by British culture for its characteristic red color.'],
        ['id' => 'q5', 'label' => 'Living near Bondi seashore is not beneficial for health.'],
    ],
    'options'        => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
    'correct_answer' => ['q1' => 'FALSE', 'q2' => 'NOT GIVEN', 'q3' => 'NOT GIVEN', 'q4' => 'TRUE', 'q5' => 'FALSE'],
    'start_number'   => 0,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 1,
    'type'            => 'true_false',
    'question_text'   => 'Do the following statements agree with the information given in Reading Passage 1? Write <strong>TRUE</strong> if the statement agrees with the information, <strong>FALSE</strong> if the statement contradicts the information, or <strong>NOT GIVEN</strong> if there is no information on this.',
    'options'         => json_encode(['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN']),
    'correct_answer'  => json_encode(['q1' => 'FALSE', 'q2' => 'NOT GIVEN', 'q3' => 'NOT GIVEN', 'q4' => 'TRUE', 'q5' => 'FALSE']),
    'explanation'     => null,
    'data'            => json_encode($tfng1),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q1-5 (TRUE/FALSE/NOT GIVEN).\n";

// ── Q6-9: Short Answer Group ──────────────────────────────────────────────────
$sa1 = [
    'instruction'  => 'Answer the questions below using NO MORE THAN TWO WORDS AND/OR NUMBERS from the passage for each answer.',
    'sub_questions' => [
        ['id' => 'q6', 'label' => 'At the end of the 19th century, which public transport did people use to go to Bondi?'],
        ['id' => 'q7', 'label' => 'When did the British Royalty first visit Bondi?'],
        ['id' => 'q8', 'label' => 'Which Olympic event did Bondi host in the 2000 Sydney Olympic games?'],
        ['id' => 'q9', 'label' => 'What would be damaged if the stadium was built for that Olympic event?'],
    ],
    'correct_answer' => ['q6' => 'tram', 'q7' => '1954', 'q8' => 'beach volleyball', 'q9' => 'environment'],
    'start_number'   => 5,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 6,
    'type'            => 'short_answer_group',
    'question_text'   => 'Answer the questions below using <strong>NO MORE THAN TWO WORDS AND/OR NUMBERS</strong> from the passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q6' => 'tram', 'q7' => '1954', 'q8' => 'beach volleyball', 'q9' => 'environment']),
    'explanation'     => null,
    'data'            => json_encode($sa1),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q6-9 (Short Answer).\n";

// ── Q10-13: Summary Completion ────────────────────────────────────────────────
$sum1 = [
    'box_title'    => 'Summary',
    'instruction'  => 'Complete the following summary using NO MORE THAN TWO WORDS from the Reading Passage for each answer.',
    'summary_text' => 'Bondi beach holds feature sports activities every year, which attracts a lot of [10] choosing to live at this place during the holidays. But local accommodation cannot meet the expanding population, and a nearby town of [11] is the first suburb site to support the solution, yet people prefer [12] as their best choice. Its seaside buildings are well-known in the world for the special scenic colored [13] on buildings and the joyful smell from the sea.',
    'blanks' => [
        ['id' => 'q10', 'blank_number' => 10],
        ['id' => 'q11', 'blank_number' => 11],
        ['id' => 'q12', 'blank_number' => 12],
        ['id' => 'q13', 'blank_number' => 13],
    ],
    'correct_answer' => ['q10' => 'wealthy people', 'q11' => 'Manly', 'q12' => 'Bondi', 'q13' => 'tiled roofs'],
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p1id,
    'question_number' => 10,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the following summary using <strong>NO MORE THAN TWO WORDS</strong> from the Reading Passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q10' => 'wealthy people', 'q11' => 'Manly', 'q12' => 'Bondi', 'q13' => 'tiled roofs']),
    'explanation'     => null,
    'data'            => json_encode($sum1),
    'order'           => 3,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q10-13 (Summary Completion).\n";

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 2 — "Antarctica – in from the cold?"
// ════════════════════════════════════════════════════════════════════════════
$p2id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Antarctica – in from the cold?',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong> which are based on Reading Passage 2 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Antarctica – in from the cold?</h2>

<p><strong>A</strong> &nbsp;A little over a century ago, men of the ilk of Scott, Shackleton and Mawson battled against Antarctica's blizzards, cold and deprivation. In the name of Empire and in an age of heroic deeds they created an image of Antarctica that was to last well into the 20th century – an image of remoteness, hardship, bleakness and isolation that was the province of only the most courageous of men. The image was one of a place removed from everyday reality, of a place with no apparent value to anyone.</p>

<p><strong>B</strong> &nbsp;As we enter the 21st century, our perception of Antarctica has changed. Although physically Antarctica is no closer and probably no warmer, and to spend time there still demands a dedication not seen in ordinary life, the continent and its surrounding ocean are increasingly seen to be an integral part of Planet Earth, and a key component in the Earth System. Is this because the world seems a little smaller these days, shrunk by TV and tourism, or is it because Antarctica really does occupy a central spot on Earth's mantle? Scientific research during the past half-century has revealed – and continues to reveal – that Antarctica's great mass and low temperature exert a major influence on climate and ocean circulation, factors which influence the lives of millions of people all over the globe.</p>

<p><strong>C</strong> &nbsp;Antarctica was not always cold. The slow break-up of the super-continent Gondwana with the northward movements of Africa, South America, India and Australia eventually created enough space around Antarctica for the development of an Antarctic Circumpolar Current (ACC), that flowed from west to east under the influence of the prevailing westerly winds. Antarctica cooled, its vegetation perished, glaciation began and the continent took on its present-day appearance. Today the ice that overlies the bedrock is up to 4km thick, and surface temperatures as low as –89.2°C have been recorded. The icy blast that howls over the ice cap and out to sea – the so-called katabatic wind – can reach 300 km/hr, creating fearsome wind-chill effects.</p>

<p><strong>D</strong> &nbsp;Out of this extreme environment come some powerful forces that reverberate around the world. The Earth's rotation, coupled to the generation of cells of low pressure off the Antarctic coast, would allow Astronauts a view of Antarctica that is as beautiful as it is awesome. Spinning away to the northeast, the cells grow and deepen, whipping up the Southern Ocean into the mountainous seas so respected by mariners. Recent work is showing that the temperature of the ocean may be a better predictor of rainfall in Australia than is the pressure difference between Darwin and Tahiti – the Southern Oscillation Index. By receiving more accurate predictions, graziers in northern Queensland are able to avoid overstocking in years when rainfall will be poor. Not only does this limit their losses but it prevents serious pasture degradation that may take decades to repair. CSIRO is developing this as a prototype forecasting system, but we can confidently predict that as we know more about the Antarctic and the Southern Ocean we will be able to enhance and extend our predictive ability.</p>

<p><strong>E</strong> &nbsp;The ocean's surface temperature results from the interplay between deep-water temperature, air temperature and ice. Each winter between 4 and 19 million square km of sea ice form, locking up huge quantities of heat close to the continent. Only now can we start to unravel the influence of sea ice on the weather that is experienced in southern Australia. But in another way, the extent of sea ice extends its influence far beyond Antarctica. Antarctic krill – the small shrimp-like crustaceans that are the staple diet for baleen whales, penguins, some seals, flighted sea birds and many fish – breed well in years when sea ice is extensive and poorly when it is not. Many species of baleen whales and flighted sea birds migrate between the hemispheres and when the krill are less abundant they do not thrive.</p>

<p><strong>F</strong> &nbsp;The circulatory system of the world's oceans is like a huge conveyor belt, moving water and dissolved minerals and nutrients from one hemisphere to the other, and from the ocean's abyssal depths to the surface. The ACC is the longest current in the world and has the largest flow. Through it, the deep flows of the Atlantic, Indian and Pacific Oceans are joined to form part of single global thermohaline circulation. During winter, the howling katabatics sometimes scour the ice off patches of the sea's surface leaving large ice-locked lagoons, or 'polynyas'. Recent research has shown that as fresh sea ice forms, it is continuously stripped away by the wind and may be blown up to 90km in a single day. Since only freshwater freezes into ice, the water that remains becomes increasingly salty and dense, sinking until it spills over the continental shelf. Cold water carries more oxygen than warm water, so when it rises, well into the northern hemisphere, it reoxygenates and revitalises the ocean. The state of the northern oceans and their biological productivity owe much to what happens in the Antarctic.</p>
HTML,
    'order'       => 2,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 2 (Antarctica), ID: $p2id\n";

// ── Q14-18: Matching Paragraph Information ────────────────────────────────────
$matchPara = [
    'sub_questions' => [
        ['id' => 'q14', 'label' => 'The example of research on weather prediction in agriculture'],
        ['id' => 'q15', 'label' => 'Antarctic sea ice brings life back to the world oceans\' vitality'],
        ['id' => 'q16', 'label' => 'A food chain that influences the animals\' living patterns based on Antarctic fresh sea ice'],
        ['id' => 'q17', 'label' => 'The explanation of how atmosphere and pressure above Antarctica can impose an effect on global climate change'],
        ['id' => 'q18', 'label' => 'Antarctica was once thought to be a forgotten and insignificant continent'],
    ],
    'options' => [
        'A' => 'Paragraph A',
        'B' => 'Paragraph B',
        'C' => 'Paragraph C',
        'D' => 'Paragraph D',
        'E' => 'Paragraph E',
        'F' => 'Paragraph F',
    ],
    'correct_answer' => ['q14' => 'D', 'q15' => 'F', 'q16' => 'E', 'q17' => 'C', 'q18' => 'A'],
    'start_number'   => 13,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 14,
    'type'            => 'matching_paragraph_information',
    'question_text'   => 'Reading Passage 2 has <strong>7 paragraphs (A–F)</strong>. Which paragraph contains the following information? Write the correct letter <strong>A–F</strong> in boxes 14–18 on your answer sheet.',
    'options'         => json_encode($matchPara['options']),
    'correct_answer'  => json_encode($matchPara['correct_answer']),
    'explanation'     => null,
    'data'            => json_encode($matchPara),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q14-18 (Matching Paragraph).\n";

// ── Q19-21: Summary Matching with Box Options ─────────────────────────────────
$matchBox = [
    'sub_questions' => [
        ['id' => 'q19', 'label' => 'Globally, Antarctica\'s size and __________ influence climate change.'],
        ['id' => 'q20', 'label' => '__________ is contributory to the westerly wind.'],
        ['id' => 'q21', 'label' => 'Southern Oscillation Index based on air pressure can predict __________ in Australia.'],
    ],
    'options' => [
        'A' => 'A – Antarctic Circumpolar Current (ACC)',
        'B' => 'B – katabatic winds',
        'C' => 'C – rainfall',
        'D' => 'D – temperature',
        'E' => 'E – glaciers',
        'F' => 'F – pressure',
    ],
    'correct_answer' => ['q19' => 'D', 'q20' => 'A', 'q21' => 'C'],
    'start_number'   => 18,
    'box_title'      => 'Choose the correct answer (A–F)',
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p2id,
    'question_number' => 19,
    'type'            => 'matching_sentence_endings',
    'question_text'   => 'Please match the natural phenomenon with the correct determining factor. Choose the correct answer from the box (A–F) and write the letters in boxes 19–21 on your answer sheet.',
    'options'         => json_encode($matchBox['options']),
    'correct_answer'  => json_encode(['q19' => 'D', 'q20' => 'A', 'q21' => 'C']),
    'explanation'     => null,
    'data'            => json_encode($matchBox),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q19-21 (Matching with Box).\n";

// ── Q22-26: Multiple Choice ───────────────────────────────────────────────────
$mcqs = [
    [22, 'In paragraph B, the author wants to tell which of the following truths about Antarctica?',
     ['A' => 'To show Antarctica has been a central topic of global warming in mass media',
      'B' => 'To illustrate how its huge sea ice brings food to millions of lives around the world',
      'C' => 'To show it is central and significant to the global climate and ocean current',
      'D' => 'To illustrate that it is located in the central spot on Earth geographically'],
     'C', 3],
    [23, 'Why do Australian farmers keep an eye on the Antarctic ocean temperature?',
     ['A' => 'To help farmers reduce their economic or ecological losses',
      'B' => 'To retrieve grassland decreased in the overgrazing process',
      'C' => 'To prevent animals from dying',
      'D' => 'A cell provides fertilizer for the grassland'],
     'A', 4],
    [24, 'What is the final effect of katabatic winds?',
     ['A' => 'Increase the moving speed of ocean currents',
      'B' => 'Increase the salt level near the ocean floor',
      'C' => 'Bring fresh ice into northern oceans for reoxygenation',
      'D' => 'Pile up mountainous ice caps respected by mariners'],
     'C', 5],
    [25, 'The spilling over of water at the continental shelf is due to the',
     ['A' => 'Salt and density increase causing sinking water',
      'B' => 'Salt and density decrease',
      'C' => 'Global warming resulting in a rising temperature',
      'D' => 'Fresh ice melting into ocean water'],
     'A', 6],
    [26, 'The decrease in the number of whales and seabirds is due to',
     ['A' => 'Killer whales being more active around the area',
      'B' => 'Sea birds being affected by high sea-level salinity',
      'C' => 'Less sea ice reducing the productivity of their food source (krill)',
      'D' => 'Seals failing to reproduce'],
     'C', 7],
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
echo "Inserted Q22-26 (Multiple Choice).\n";

// ════════════════════════════════════════════════════════════════════════════
// PASSAGE 3 — "Talc Powder"
// ════════════════════════════════════════════════════════════════════════════
$p3id = DB::table('ielts_reading_passages')->insertGetId([
    'material_id' => $materialId,
    'title'       => 'Talc Powder',
    'content'     => <<<HTML
<p class="text-xs text-gray-500 italic mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong> which are based on Reading Passage 3 below.</p>

<h2 class="text-xl font-bold text-gray-900 mb-1">Talc Powder</h2>

<p><strong>A</strong> &nbsp;Peter Brigg discovers how talc from Luzenac's Trimouns in France finds its way into food and agricultural products – from chewing gum to olive oil. High in the French Pyrenees, some 1,700m above sea level, lies Trimouns, a huge deposit of hydrated magnesium silicate – talc to you and me. Talc from Trimouns, and from ten other Luzenac mines across the globe, is used in the manufacture of a vast array of everyday products extending from paper, paint and plaster to cosmetics, plastics and car tyres. And of course, there is always talc's best-known end use: talcum powder for babies' bottoms. But the true versatility of this remarkable mineral is nowhere better displayed than in its sometimes surprising use in certain niche markets in the food and agriculture industries.</p>

<p><strong>B</strong> &nbsp;Take, for example, the chewing gum business. Every year, Talc de Luzenac France – which owns and operates the Trimouns mine and is a member of the international Luzenac Group (part of Rio Tinto minerals) – supplies about 6,000 tonnes of talc to chewing gum manufacturers in Europe. "We've been selling to this sector of the market since the 1960s," says Laurent Fournier, a sales manager in Luzenac's Specialties business unit in Toulouse. "Admittedly, in terms of our total annual sales of talc, the amount we supply to chewing gum manufacturers is relatively small, but we see it as a valuable niche market: one where customers place a premium on securing supplies from a reliable, high-quality source. Because of this, long-term allegiance to a proven supplier is very much a feature of this sector of the talc market." Switching sources – in the way that you might choose to buy, say, paperclips from Supplier A rather than from Supplier B – is not an easy option for chewing gum manufacturers. "The cost of reformulating is high, so when customers are using a talc grade that works, even if it's expensive, they are understandably reluctant to switch."</p>

<p><strong>C</strong> &nbsp;But how is talc actually used in the manufacture of chewing gum? Patrick Delord, an engineer with a degree in agronomics, who has been with Luzenac for 22 years and is now senior market development manager, Agriculture and Food, in Europe, explains that chewing gum has four main components. "The most important of them is the gum base," he says. "It's the gum base that puts the chew into chewing gum. It binds all the ingredients together, creating a soft, smooth texture. To this the manufacturer then adds sweeteners, softeners and flavourings. Our talc is used as a <strong>filler</strong> in the gum base. The amount varies between, say, ten and 35 per cent, depending on the type of gum. Fruit flavoured chewing gum, for example, is slightly acidic and would react with the calcium carbonate that the manufacturer might otherwise use as a filler. Talc, on the other hand, makes an ideal filler because it's non-reactive chemically. In the factory, talc is also used to dust the gum base pellets and to stop the chewing gum sticking during the <strong>lamination and packing</strong> process," Delord adds.</p>

<p><strong>D</strong> &nbsp;The chewing gum business is, however, just one example of talc's use in the food sector. For the past 20 years or so, olive oil processors in Spain have been taking advantage of talc's unique characteristics to help them boost the amount of oil they extract from crushed olives. According to Patrick Delord, talc is especially useful for treating what he calls "difficult" olives. After the olives are harvested – preferably early in the morning because their taste is better if they are gathered in the cool of the day – they are taken to the processing plant. There they are crushed and then stirred for 30-45 minutes. In the old days, the resulting paste was passed through an olive press but nowadays it's more common to add water and centrifuge the mixture to separate the water and oil from the solid matter. The oil and water are then allowed to settle so that the olive oil layer can be decanted off and bottled. "Difficult" olives are those that are more reluctant than the norm to yield up their full oil content. This may be attributable to the particular species of olive, or to its water content and the time of year the olives are collected – at the beginning and the end of the season their water content is often either too high or too low. These olives are easy to recognize because they produce a lot of extra <strong>foam</strong> during the stirring process, a consequence of an excess of a fine solid that acts as a natural emulsifier. The oil in this emulsion is lost when the water is disposed of. Not only that, if the wastewater is disposed of directly into local fields – often the case in many smaller processing operations – the emulsified oil may take some time to biodegrade and so be harmful to the environment.</p>

<p><strong>E</strong> &nbsp;"If you add between a half and two per cent of talc by weight during the stirring process, it absorbs the natural emulsifier in the olives and so boosts the amount of oil you can extract," says Delord. "In addition, talc's flat, 'platey' structure helps increase the size of the <strong>oil droplets</strong> liberated during stirring, which again improves the yield. However, because talc is chemically inert, it doesn't affect the colour, taste, appearance or composition of the resulting olive oil."</p>

<p><strong>F</strong> &nbsp;If the use of talc in olive oil processing and in chewing gum is long-established, new applications in the food and agriculture industries are also constantly being sought by Luzenac. One such promising new market is fruit crop protection, being pioneered in the US. Just like people, fruit can get sunburned. In fact, in very sunny regions up to 45 per cent of a typical crop can be affected by heat stress and sunburn. However, in the case of fruit, it's not so much the ultraviolet rays which harm the crop as the high surface temperature that the sun's rays create.</p>

<p><strong>G</strong> &nbsp;To combat this, farmers normally use either chemicals or spray a continuous fine canopy of mist above the fruit trees or bushes. The trouble is, this uses a lot of water – normally a precious commodity in hot, sunny areas – and it is therefore expensive. What's more, the ground can quickly become waterlogged. "So our idea was to coat the fruit with talc to protect it from the sun," says Greg Hunter, a marketing specialist who has been with Luzenac for ten years. "But to do this, several technical challenges had first to be overcome. Talc is very hydrophobic: it doesn't like water. So in order to have a viable product we needed a wettable powder – something that would go readily into suspension so that it could be sprayed onto the fruit. It also had to break the surface tension of the cutin (the natural waxy, waterproof layer on the fruit) and of course, it had to wash off easily when the fruit was harvested. No-one's going to want an apple that's covered in talc."</p>

<p><strong>H</strong> &nbsp;Initial trials in the state of Washington in 2003 showed that when the product was sprayed onto Granny Smith apples, it reduced their surface temperature and lowered the incidence of sunburn by up to 60 per cent. Today the new product, known as Envelop Maximum SPF, is in its second commercial year on the US market. Apple growers are the primary target although Hunter believes <strong>grape growers</strong> represent another sector with long-term potential. He is also hopeful of extending sales to overseas markets such as Australia, South America and southern Europe.</p>
HTML,
    'order'       => 3,
    'created_at'  => now(),
    'updated_at'  => now(),
]);
echo "Created Passage 3 (Talc Powder), ID: $p3id\n";

// ── Q27-32: Category Matching (A=Fruit, B=Chewing gum, C=Olive oil) ───────────
$catOpts = [
    'A' => 'A – Fruit protection',
    'B' => 'B – Chewing gum business',
    'C' => 'C – Olive oil extraction',
];

$catSubs = [
    ['id' => 'q27', 'label' => 'Talc is used to increase the size of drops.'],
    ['id' => 'q28', 'label' => 'Talc is applied to reduce foaming.'],
    ['id' => 'q29', 'label' => 'Talc is employed as a filler of base.'],
    ['id' => 'q30', 'label' => 'Talc is modified and prevents sunburn.'],
    ['id' => 'q31', 'label' => 'Talc is added to stop stickiness.'],
    ['id' => 'q32', 'label' => 'Talc is used to increase production.'],
];

$catData = [
    'sub_questions'  => $catSubs,
    'options'        => $catOpts,
    'correct_answer' => ['q27' => 'C', 'q28' => 'C', 'q29' => 'B', 'q30' => 'A', 'q31' => 'B', 'q32' => 'C'],
    'start_number'   => 26,
    'box_title'      => 'Uses of Talc Powder',
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 27,
    'type'            => 'matching_sentence_endings',
    'question_text'   => 'Use the information in the passage to match each use of talc powder with the current application from A, B or C. Write the appropriate letters <strong>A–C</strong> in boxes 27–32.<br><br><em>NB You may use any letter more than once.</em>',
    'options'         => json_encode($catOpts),
    'correct_answer'  => json_encode(['q27' => 'C', 'q28' => 'C', 'q29' => 'B', 'q30' => 'A', 'q31' => 'B', 'q32' => 'C']),
    'explanation'     => null,
    'data'            => json_encode($catData),
    'order'           => 1,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q27-32 (Category Matching).\n";

// ── Q33-38: Summary Completion ────────────────────────────────────────────────
$sum2 = [
    'box_title'    => 'Summary',
    'instruction'  => 'Complete the following summary using NO MORE THAN TWO WORDS from the Reading Passage for each answer.',
    'summary_text' => 'Spanish olive oil industry has been using talc in the oil extraction process for about [33] years. It is useful in dealing with difficult olives which often produce a high amount of [34] because of the high content of solid materials. When smaller factories release [35], it could be [36] to the environment because it is hard to [37] and usually takes time as it contains emulsified oil. However, talc powder added in the process is able to absorb the emulsifier. It improves oil extraction production because with the aid of talc powder, size of oil [38] is increased.',
    'blanks' => [
        ['id' => 'q33', 'blank_number' => 33],
        ['id' => 'q34', 'blank_number' => 34],
        ['id' => 'q35', 'blank_number' => 35],
        ['id' => 'q36', 'blank_number' => 36],
        ['id' => 'q37', 'blank_number' => 37],
        ['id' => 'q38', 'blank_number' => 38],
    ],
    'correct_answer' => ['q33' => '20', 'q34' => 'foam', 'q35' => 'waste water', 'q36' => 'harmful', 'q37' => 'biodegrade', 'q38' => 'droplets'],
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 33,
    'type'            => 'summary_completion',
    'question_text'   => 'Complete the following summary using <strong>NO MORE THAN TWO WORDS</strong> from the Reading Passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q33' => '20', 'q34' => 'foam', 'q35' => 'waste water', 'q36' => 'harmful', 'q37' => 'biodegrade', 'q38' => 'droplets']),
    'explanation'     => null,
    'data'            => json_encode($sum2),
    'order'           => 2,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q33-38 (Summary Completion).\n";

// ── Q39-40: Short Answer Group ────────────────────────────────────────────────
$sa2 = [
    'instruction'  => 'Answer the questions below using NO MORE THAN THREE WORDS from the passage for each answer.',
    'sub_questions' => [
        ['id' => 'q39', 'label' => 'In which process is talc used to clear the stickiness of chewing gum?'],
        ['id' => 'q40', 'label' => 'Which group of farmers does Envelop intend to target in the long term?'],
    ],
    'correct_answer' => ['q39' => 'lamination and packing', 'q40' => 'grape growers'],
    'start_number'   => 38,
];

DB::table('ielts_reading_questions')->insert([
    'passage_id'      => $p3id,
    'question_number' => 39,
    'type'            => 'short_answer_group',
    'question_text'   => 'Answer the questions below using <strong>NO MORE THAN THREE WORDS</strong> from the passage for each answer.',
    'options'         => json_encode([]),
    'correct_answer'  => json_encode(['q39' => 'lamination and packing', 'q40' => 'grape growers']),
    'explanation'     => null,
    'data'            => json_encode($sa2),
    'order'           => 3,
    'created_at'      => now(),
    'updated_at'      => now(),
]);
echo "Inserted Q39-40 (Short Answer).\n";

echo "\nDone! Practice Test 3 seeded with material_id={$materialId}.\n";
echo "Passage 1 ID: {$p1id} | Passage 2 ID: {$p2id} | Passage 3 ID: {$p3id}\n";
echo "Visit /assignments/ielts-academic/reading/material/3 to verify.\n";
