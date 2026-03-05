<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice14Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 14;

        // Clean up any existing records for this material
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // --- PASSAGE 1 ---
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Dirty river but clean water',
            'content' => '
<p>Floods can occur in rivers when the flow rate exceeds the capacity of the river channel, particularly at bends or meanders in the waterway. Floods often cause damage to homes and businesses if they are in the natural flood plains of rivers. While riverine flood damage can be eliminated by moving away from rivers and other bodies of water, people have traditionally lived and worked by rivers because the land is usually flat and fertile and because rivers provide easy travel and access to commerce and industry.</p>

<p><strong>A</strong></p>
<p>FIRE and flood are two of humanity’s worst nightmares. People have, therefore, always sought to control them. Forest fires are snuffed out quickly. The flow of rivers is regulated by weirs and dams. At least, that is how it used to be. But foresters have learned that forests need fires to clear out the brush and even to get seeds to germinate. And a similar revelation is now dawning on hydrologists. Rivers – and the ecosystems they support – need floods. That is why a man-made torrent has been surging down the Grand Canyon. By Thursday, March 6th it was running at full throttle, which was expected to be sustained for 60 hours.</p>

<p><strong>B</strong></p>
<p>Floods once raged through the canyon every year. Spring Snow from as far away as Wyoming would melt and swell the Colorado river to a flow that averaged around 1,500 cubic metres (50,000 cubic feet) a second. Every eight years or so, that figure rose to almost 3,000 cubic metres. These floods infused the river with sediment, carved its beaches and built its sandbars.</p>

<p><strong>C</strong></p>
<p>However, in the four decades since the building of the Glen Canyon dam, just upstream of the Grand Canyon, the only sediment that it has collected has come from tiny, undammed tributaries. Even that has not been much use as those tributaries are not powerful enough to distribute the sediment in an ecologically valuable way.</p>

<p><strong>D</strong></p>
<p>This lack of flooding has harmed local wildlife. The humpback chub, for example, thrived in the rust-red waters of Colorado. Recently, though, its population has crashed. At first sight, it looked as if the reason was that the chub were being eaten by trout introduced for sport fishing in the mid-20th century. But trout and chub co-existed until the Glen Canyon dam was built, so something else is going on. Steve Gloss, of the United States Geological Survey (USGS), reckons that the chub’s decline is the result of their losing their most valuable natural defense, Colorado’s rusty sediment. The chub were well adapted to the poor visibility created by the chick, red water which gave the river its name and depended on it to hide from predators. Without the cloudy water, the chub became vulnerable.</p>

<p><strong>E</strong></p>
<p>And the chub are not alone. In the years since the Glen Canyon dam was built, several species have vanished altogether. These include the Colorado pike-minnow, the razorback sucker and the roundtail chub. Meanwhile, aliens including fathead minnows, channel catfish and common carp, which would have been hard, put to survive in the savage waters of the undammed canyon, have moved in.</p>

<p><strong>F</strong></p>
<p>So flooding is the obvious answer. Unfortunately, it is easier said than done. Floods were sent down the Grand Canyon in 1996 and 2004 and the results were mixed. In 1996 the flood was allowed to go on too long. To start with, all seemed well. The floodwaters built up sandbanks and infused the river with sediment. Eventually, however, the continued flow washed most of the sediment out of the canyon. This problem was avoided in 2004, but unfortunately, on that occasion, the volume of sand available behind the dam was too low to rebuild the sandbanks. This time, the USGS is convinced that things will be better. The amount of sediment available is three times greater than it was in 2004. So if a flood is going to do some good, this is the time to unleash one.</p>

<p><strong>G</strong></p>
<p>Even so, it may turn out to be an empty gesture. At less than 1,200 cubic metres a second, this flood is smaller than even an average spring flood, let alone one of the mightier deluges of the past. Those glorious inundations moved massive quantities of sediment through the Grand Canyon, wiping the slate dirty, and making a muddy mess of silt and muck that would make modern river rafters cringe.</p>',
            'order' => 1,
        ]);

        // Questions 1-7: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 1?<br>In boxes 1-7 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'Damage caused by a fire is worse than that caused by the flood.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '2', 'label' => 'The flood peaks at almost 1500 cubic meters every eight years.', 'correct_answer' => 'FALSE'],
                    ['id' => '3', 'label' => 'Contribution of sediments delivered by tributaries has little impact.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '4', 'label' => 'The decreasing number of chubs is always caused by introducing of trout since the mid 20th century.', 'correct_answer' => 'FALSE'],
                    ['id' => '5', 'label' => 'It seemed that the artificial flood in 1996 had achieved success partly at the very beginning.', 'correct_answer' => 'TRUE'],
                    ['id' => '6', 'label' => 'In fact, the yield of artificial flood water is smaller than an average natural flood at present.', 'correct_answer' => 'TRUE'],
                    ['id' => '7', 'label' => 'Mighty floods drove fast-moving flows with clean and high-quality water.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 8-13 (Summary completion)
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 8,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '8' => 'spring',
                '9' => 'sediment',
                '10' => 'razorback sucker',
                '11' => 'common carp',
                '12' => 'visibility',
                '13' => 'sand',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 7,
                'instruction' => 'Complete the summary below.<br>Choose <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.<br>Write your answers in boxes 8-13 on your answer sheet.',
                'summary_text' => '<strong>The eco-impact of the Canyon Dam</strong><br><br>Floods are people’s nightmare. In the past, the canyon was raged by flood every year. The snow from far Wyoming would melt in the season of <strong>[8]</strong> and caused a flood flow peak in Colorado river. In the four decades after people built the Glen Canyon Dam, it only could gather <strong>[9]</strong> together from tiny, undammed tributaries.<br><br><strong>humpback chub population reduced, why?</strong><br><br>Then several species disappeared including Colorado pike-minnow, <strong>[10]</strong> and the round-tail chub. Meanwhile, some moved in such as fathead minnows, channel catfish and <strong>[11]</strong>. The non-stopped flow led to the washing away of the sediment out of the canyon, which poses a great threat to the chubs because it has poor <strong>[12]</strong> away from predators. In addition, the volume of <strong>[13]</strong> available behind the dam was too low to rebuild the bars and flooding became more serious.',
                'placeholders' => [
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                    '11' => 11,
                    '12' => 12,
                    '13' => 13
                ],
            ],
            'order' => 2,
        ]);


        // --- PASSAGE 2 ---
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Seed Hunting',
            'content' => '
<p><strong>A</strong></p>
<p>With a quarter of the world’s plants set to vanish within the next 50 years, Dough Alexander reports on the scientists working against the clock the preserve the Earth’s botanical heritage. They travel the four corners of the globe, scouring jungles, forests and savannas. But they’re not looking for ancient artefacts, lost treasure or undiscovered tombs. Just pods. It may lack the romantic allure of archaeology or the whiff of danger that accompanies going after a big game, but seed hunting is an increasingly serious business. Some seek seeds for profit-hunters in the employ of biotechnology firms, pharmaceutical companies and private corporations on the lookout for species that will yield the drugs or crops of the future. Others collect to conserve, working to halt the sad slide into extinction facing so many plant species.</p>

<p><strong>B</strong></p>
<p>Among the pioneers of this botanical treasure hunt was John Tradescant, an English royal gardener who brought back plants and seeds from his journeys abroad in the early 1600s. Later, the English botanist Sir Joseph Banks – who was the first director of the Royal Botanic Gardens at Kew and travelled with Captain James Cook on his voyages near the end of the 18th century – was so driven to expand his collections that he sent botanists around the world at his own expense.</p>

<p><strong>C</strong></p>
<p>Those heady days of exploration and discovery may be over, but they have been replaced by a pressing need to preserve our natural history for the future. This modern mission drives hunters such as Dr Michiel van Slageren, a good-natured Dutchman who often sports a wide-brimmed hat in the field – he could easily be mistaken for the cinematic hero Indiana Jones. He and three other seed hunters work at the Millennium Seed Bank, an 80 million [pounds sterling] international conservation project that aims to protect the world’s most endangered wild plant species.</p>

<p><strong>D</strong></p>
<p>The group’s headquarters are in a modern glass-and-concrete structure on a 200-hectare Estate at Wakehurst Place in the West Sussex countryside. Within its underground vaults are 260 million dried seeds from 122 countries, all stored at -20 Celsius to survive for centuries. Among the 5,100 species represented are virtually all of Britain’s 1,400 native seed-bearing plants, the most complete such collection of any country’s flora.</p>

<p><strong>E</strong></p>
<p>Overseen by the Royal botanic gardens, the Millennium Seed Bank is the world’s largest wild-plant depository. It aims to collect 24,000 species by 2010. The reason is simple: thanks to humanity’s effort, an estimated 25 per cent of the world’s plants are on the verge of extinction and may vanish within 50 years. We’re currently responsible for habitat destruction on an unprecedented scale, and during the past 400 years, plant species extinction rates have been about 70 times greater than those indicated by the geological record as being ‘normal’. Experts predict that during the next 50 years further one billion hectares of wilderness will be converted to farmland in developing countries alone.</p>

<p><strong>F</strong></p>
<p>The implications of this loss are enormous. Besides providing staple food crops, plants are a source of many machines and the principal supply of fuel and building materials in many parts of the world. They also protect soil and help regulate the climate. Yet, across the globe, plant species are being driven to extinction before their potential benefits are discovered.</p>

<p><strong>G</strong></p>
<p>The world Conservation Union has listed 5,714 threatened species is sure to be much higher. In the UK alone, 300 wild plant species are classified as endangered. The Millennium Seed Bank aims to ensure that even if a plant becomes extinct in the wild, it won’t be lost forever. Stored seeds can be used the help restore damaged or destroyed the environment or in scientific research to find new benefits for society- in medicine, agriculture or local industry- that would otherwise be lost.</p>

<p><strong>H</strong></p>
<p>Seed banks are an insurance policy to protect the world’s plant heritage for the future, explains Dr Paul Smith, another Kew seed hunter. “Seed conservation techniques were originally developed by farmers,” he says. “Storage is the basis what we do, conserving seeds until you can use them just as in farming,” Smith says there’s no reason why any plant species should become extinct, given today’s technology. But he admits that the biggest challenge is finding, naming and categorizing all the world’s plants. And someone has to gather these seeds before it’s too late. “There aren’t a lot of people out there doing this,” he says. “The key is to know the flora from a particular area, and that knowledge takes years to acquire.”</p>

<p><strong>I</strong></p>
<p>There are about 1,470 seedbanks scattered around the globe, with a combined total of 5.4 million samples, of which perhaps two million are distinct non-duplicates. Most preserve genetic material for agriculture use in order to ensure crop diversity; others aim to conserve wild species, although only 15 per cent of all banked plants is wild.</p>

<p><strong>J</strong></p>
<p>Many seed banks are themselves under threat due to a lack of funds. Last year, Imperial College, London, examined crop collections from 151 countries and found that while the number of plant samples had increased in two-thirds of the countries, the budget had been cut in a quarter and remained static in another 35 per cent. The UN’s Food and Agriculture Organization and the Consultative Group on International Agricultural Research has since set up the Global Conservation Trust, which aims to raise the US $260 million to protect seed banks in perpetuity.</p>',
            'order' => 2,
        ]);

        // Questions 14-19: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 2?<br>In boxes 14-19 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 13,
                'sub_questions' => [
                    ['id' => '14', 'label' => 'The purpose of collecting seeds now is different from the past.', 'correct_answer' => 'TRUE'],
                    ['id' => '15', 'label' => 'The millennium seed bank is the earliest seed bank.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '16', 'label' => 'One of the major threats for plant species extinction is farmland expansion into wildness.', 'correct_answer' => 'TRUE'],
                    ['id' => '17', 'label' => 'The approach that scientists apply to store seeds is similar to that used by farmers.', 'correct_answer' => 'TRUE'],
                    ['id' => '18', 'label' => 'technological development is the only hope to save plant species.', 'correct_answer' => 'FALSE'],
                    ['id' => '19', 'label' => 'The works of seed conservation are often limited by financial problems.', 'correct_answer' => 'TRUE'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 20-24 (Summary completion)
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 20,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '20' => 'extinction',
                '21' => 'drugs, crops',
                '22' => 'pioneers',
                '23' => 'Sir Joseph Banks',
                '24' => 'underground vaults',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 19,
                'instruction' => '<strong>Summary</strong><br>Complete the following summary of the paragraphs of Reading Passage 2,<br>Using <strong>NO MORE THAN THREE WORDS</strong> from the Reading Passage for each answer.<br>Write your answers in boxes 20-24 on your answer sheet.',
                'summary_text' => 'Some people collect seeds for the purpose of protecting certain species from <strong>[20]</strong>; others collect seeds for their ability to produce <strong>[21]</strong>. They are called seed hunters. The <strong>[22]</strong> Of them included both gardeners and botanists, such as <strong>[23]</strong>, who financially supported collectors out of his own pocket. The seeds collected are usually stored in seed banks, one of which is the famous millennium seed bank, where seeds are all stored in the <strong>[24]</strong> at a low temperature.',
                'placeholders' => [
                    '20' => 20,
                    '21' => 21,
                    '22' => 22,
                    '23' => 23,
                    '24' => 24
                ],
            ],
            'order' => 2,
        ]);

        // Questions 25-26: Multiple Choice Multiple
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 25,
            'type' => 'multiple_choice_multiple',
            'question_text' => 'Choose the correct letter, A-E.<br>Write your answers in boxes 25, 26 on your answer sheet.<br><br>Which TWO of the following are provided by plants to the human?',
            'options' => [
                'A' => 'food',
                'B' => 'fuels',
                'C' => 'clothes',
                'D' => 'energy',
                'E' => 'commercial products'
            ],
            'correct_answer' => null, // Managed in sub_questions
            'explanation' => null,
            'data' => [
                'start_number' => 24,
                'sub_questions' => [
                   ['id' => '25', 'label' => 'Question 25', 'correct_answer' => 'A'],
                   ['id' => '26', 'label' => 'Question 26', 'correct_answer' => 'B']
                ]
            ],
            'order' => 3,
        ]);


        // --- PASSAGE 3 ---
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The significant role of mother tongue language in education',
            'content' => '
<p><strong>A</strong></p>
<p>One consequence of population mobility is increasing diversity within schools. To illustrate, in the city of Toronto in Canada, 58% of kindergarten pupils come from homes where English is not a language of communication. Schools in Europe and North America have experienced this diversity for years, but educational policies and practices vary widely between countries and even within countries. Some political parties and groups search for ways to solve the problem of diverse communities and their integration in schools and society. They see few positive consequences for the host society and worry that diversity threatens the identity of the host society. Consequently, they promote unfortunate educational policies that will make the “problem” disappear. If students retain their culture and language, they are viewed as less capable of identifying with the mainstream culture and learning the mainstream language of society.</p>

<p><strong>B</strong></p>
<p>The challenge for educators and policy-makers is to shape the evolution of national identity in such a way that the rights of all citizens (including school children) are respected, and the cultural, linguistic, and economic resources of the nation are maximized. To waste the resources of the nation by discouraging children from developing their mother tongues is quite simply unintelligent from the point of view of national self-interest. A first step in providing an appropriate education for culturally and linguistically diverse children is to examine what the existing research says about the role of children’s mother tongues in their educational development.</p>

<p><strong>C</strong></p>
<p>In fact, the research is very clear. When children continue to develop their abilities in two or more languages throughout their primary school, they gain a deeper understanding of language and how to use it effectively. They have more practice in processing language, especially when they develop literacy in both. More than 150 research studies conducted during the past 35 years strongly support what Goethe, the famous only one language does not truly know that language. Research suggests that bilingual children may also develop more flexibility in their thinking as a result of processing information through two different languages.</p>

<p><strong>D</strong></p>
<p>The level of development of children’s mother tongue is a strong predictor of their second language development. Children who come to school with a solid foundation in their mother tongue develop stronger literacy abilities in the school language. When parents and other caregivers (e.g. grandparents) are able to spend time with their children and tell stories or discuss issues with them in a way that develops their mother tongue, children come to school well-prepared to learn the school language and succeed educationally. Children’s knowledge and skills transfer across languages from the mother tongue to the school language. Transfer across languages can be two-way: both languages nurture each other when the educational environment permits children to access to both languages.</p>

<p><strong>E</strong></p>
<p>Some educators and parents are suspicious of mother tongue-based teaching programs because they worry that they take time away from the majority language. For example, in a bilingual program where 50% of the time is spent teaching through children’s home language and 50% through the majority language, surely children’s won’t progress as far in the letter? One of the most strongly established findings of educational research, however, is that well-implemented bilingual programs can promote literacy and subject-matter knowledge in a minority language without any negative effects on children’s development in the majority language. Within Europe, the Foyer program in Belgium, which develops children’s speaking and literacy abilities in three languages (their mother tongue, Dutch and French), most clearly illustrates the benefits of bilingual and trilingual education (see Cummins, 2000)/</p>

<p><strong>F</strong></p>
<p>It is easy to understand how this happens. When children are learning through a minority language, they are learning concepts and intellectual skills too. Pupils who know how to tell the time in their mother tongue understand the concept of telling time. In order to tell the time in the majority language, they do not need to re-learn the concept. Similarly, at more advanced stages, there is transfer across languages in other skills such as knowing how to distinguish the main idea from the supporting details of a written passage or story and distinguishing fact from opinion. Studies of secondary school pupils are providing interesting findings in this area, and it would be worth extending this research.</p>

<p><strong>G</strong></p>
<p>Many people marvel at how quickly bilingual children seem to “pick up” conversational skills in the majority language at school (although it takes much longer for them to catch up to native speakers in academic language skills). However, educators are often much less aware of how quickly children can lose their ability to use their mother tongue, even in the home context. The extent and rapidity of language loss will vary according to the concentration of families from a particular linguistic group in the neighborhood. Where the mother tongue is used extensively in the community, then language loss among young children will be less. However, where language communities are not concentrated in particular neighborhoods, children can lose their ability to communicate in their mother tongue within 2-3 years of starting school. They may retain receptive skills in the language but they will use the majority language in speaking with their peers and siblings and in responding to their parents. By the time children become an adolescent chasm. Pupils frequently become alienated from the cultures of both home and school with predictable results.</p>',
            'order' => 3,
        ]);

        // Questions 27-30: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter A, B, C or D.<br>Write the correct letter in boxes 27-30 on your answer sheet.',
            'options' => [
                'A' => 'Some present studies on children’s mother tongues are misleading',
                'B' => 'A culturally rich education programme benefits some children more than others.',
                'C' => 'bilingual children can make a valuable contribution to the wealth of a country',
                'D' => 'The law on mother tongue use at school should be strengthened.'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => 'What point is the writer making in the second paragraph?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 1,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 28,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'to lend weight his argument',
                'B' => 'to contradict some research',
                'C' => 'to introduce a new concept',
                'D' => 'to update current thinking'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 27,
                'sub_questions' => [
                    ['id' => '28', 'label' => 'Why does the writer refer to something that Goethe said?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 2,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 29,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'they can teach older family members what they learn at school',
                'B' => 'they go on to do much better throughout their time at school',
                'C' => 'they can read stories about their cultural background',
                'D' => 'they develop stronger relationships with their family than with their peers.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 28,
                'sub_questions' => [
                    ['id' => '29', 'label' => 'The writer believes that when young children have a firm grasp of their mother tongue', 'correct_answer' => 'B']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 30,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'They worry that children will be slow to learn to read in either language',
                'B' => 'They think that children will confuse words in the two languages.',
                'C' => 'They believe that the programmes will make children less interested in their lessons',
                'D' => 'they fear that the programmes will use up valuable time in the school day.'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 29,
                'sub_questions' => [
                    ['id' => '30', 'label' => 'Why are some people suspicious about mother tongue-based teaching programmes?', 'correct_answer' => 'D']
                ]
            ],
            'order' => 4,
        ]);

        // Questions 31-35: Summary Completion (Box)
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 31,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '31' => 'I',
                '32' => 'D',
                '33' => 'J',
                '34' => 'F',
                '35' => 'C',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 30,
                'instruction' => 'Complete the summary using the list of words A-J below<br>Write the correct letter, A-J, in boxes 31-35 on your answer sheet.',
                'summary_text' => '<strong>Bilingual children</strong><br><br>It was often recorded that Bilingual Children acquire the <strong>[31]</strong> to converse in the majority language remarkably quickly. The fact that the mother tongue can disappear at a similar <strong>[32]</strong> is less well understood. This phenomenon depends to a certain extent, on the proposition of people with the same linguistic background that have settled in a particular <strong>[33]</strong>; If this is limited, children are likely to lose the active use of their mother tongue. And thus no longer employ it even with <strong>[34]</strong>, although they may still understand it. It follows that teenager children in these circumstances experience a sense of <strong>[35]</strong> in relation to all aspects of their lives.',
                'placeholders' => [
                    '31' => 31,
                    '32' => 32,
                    '33' => 33,
                    '34' => 34,
                    '35' => 35
                ],
                'box_options' => [
                    'A' => 'Teachers', 'B' => 'school', 'C' => 'dislocation', 'D' => 'rate',
                    'E' => 'time', 'F' => 'family', 'G' => 'communication', 'H' => 'type',
                    'I' => 'ability', 'J' => 'area'
                ]
            ],
            'order' => 5,
        ]);

        // Questions 36-40: Yes/No/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 36,
            'type' => 'yes_no_not_given',
            'question_text' => 'Do the following statements agree with the views of the writer in Reading Passage 3?<br>In boxes 36-40 on your answer sheet, write',
            'options' => [
                'YES' => 'YES',
                'NO' => 'NO',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 35,
                'sub_questions' => [
                    ['id' => '36', 'label' => 'Less than half the children who attend kindergarten in Toronto have English as their Mother tongue.', 'correct_answer' => 'YES'],
                    ['id' => '37', 'label' => 'Research proves that learning the host country language at school can have an adverse effect on a child’s mother tongue.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '38', 'label' => 'the foyer Program is to be accepted by the French education system.', 'correct_answer' => 'NO'],
                    ['id' => '39', 'label' => 'Bilingual children are taught to tell the time earlier than monolingual children.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '40', 'label' => 'Bilingual children can eventually apply comprehension strategies acquired in one language when reading in the other.', 'correct_answer' => 'YES'],
                ]
            ],
            'order' => 6,
        ]);
        
    }
}
