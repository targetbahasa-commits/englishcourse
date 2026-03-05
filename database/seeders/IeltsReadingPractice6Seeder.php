<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IeltsReadingPractice6Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cleanup existing Material 6
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', 6)->get();
        foreach ($existingPassages as $p) {
            $p->questions()->delete();
            $p->delete(); 
        }

        $materialId = 6;

        // Passage 1: Rainwater Harvesting
        $p1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Rainwater Harvesting',
            'content' => '<p>For two years southern Sri Lanka suffered a prolonged drought, described by locals as “the worst in 50 years”. Some areas didn’t see a successful crop for four or five consecutive seasons. Livestock died, water in wells dropped to dangerously low levels, children were increasingly malnourished and school attendance has fallen. An estimated 1.6 million people were affected.</p>' .
            '<p><strong>A</strong><br>Muthukandiya is a village in Moneragala district, one of the drought-stricken areas in the “dry zone” of southern Sri Lanka, where half the country’s population of 18 million lives. Rainfall in the area varies greatly from year to year, often bringing extreme dry spells in between monsoons. But this drought was much worse than usual. Despite some rain in November, only half of Moneragala’s 1,400 tube wells were in working order by March. The drought devastated supplies of rice and freshwater fish, the staple diet of inland villages. Many local industries closed down and villagers headed for the towns in search of work.</p>' .
            '<p><strong>B</strong><br>The villagers of muthukandiya arrived in the 1970s as part of a government resettlement scheme. Each family was given six acres of land, with no irrigation system. Because crop production, which relies entirely on rainfall, is insufficient to support most families, the village economy relies on men and women working as day-labourers in nearby sugar-cane plantations. Three wells have been dug to provide domestic water, but these run dry for much of the year. Women and children may spend several hours each day walking up to three miles (five kilometres) to fetch water for drinking, washing and cooking.</p>' .
            '<p><strong>C</strong><br>In 1998, communities in the district discussed water problems with Practical Action South Asia. What followed was a drought mitigation initiative based on a low-cost “rainwater harvesting” technology already used in Sri Lanka and elsewhere in the region. It uses tanks to collect and store rain channeled by gutters and pipes as it runs off the roofs of houses.</p>' .
            '<p><strong>D</strong><br>Despite an indigenous tradition of rain-water harvesting and irrigation systems going back to the third century BC, policy-makers in modern times have often overlooked the value of such technologies, and it is only recently that officials have taken much interest in household-level structures. Government and other programmes have, however, been top-down in their conception and application, installing tanks free of charge without providing training in the skills needed to build and maintain them properly. Practical Action South Asia’s project deliberately took a different approach, aiming to build up a local skills base among builders and users of the tanks, and to create structures and systems so that communities can manage their own rainwater harvesting schemes.</p>' .
            '<p><strong>E</strong><br>The community of Muthukandiya was involved throughout. Two meetings were held where villagers analysed their water problems, developed a mitigation plan and selected the rainwater harvesting technology. Two local masons received several days’ on-the-job training in building the 5,000-litre household storage tanks: surface tanks out of Ferro-cement and underground tanks out of brick. Each system, including tank, pipes, gutters and filters, cost US$195 – equivalent to a month’s income for an average village family. Just over half the cost was provided by the community, in the form of materials and unskilled labour. Practical Action South Asia contributed the rest, including cement, transport and payment for the skilled labour. Households learned how to use and maintain the tanks, and the whole community was trained to keep domestic water supplies clean. A village rainwater harvesting society was set up to run the project. To date, 37 families in and around Muthukandiya have storage tanks. Evaluations show clearly that households with rainwater storage tanks have considerably more water for domestic needs than households relying entirely on wells and ponds. During the driest months, households with tanks may have up to twice as much water available. Their water is much cleaner, too.</p>' .
            '<p><strong>F</strong><br>Nandawathie, a widow in the village, has taken full advantage of the opportunities that rainwater harvesting has brought her family. With a better water supply now close at hand, she began by growing a few vegetables. The income from selling these helped her to open a small shop on her doorstep. This increased her earnings still further, enabling her to apply for a loan to install solar power in her house. She is now thinking of building another tank in her garden so that she can grow more vegetables. Nandawathie also feels safer now that she no longer has to fetch water from the village well in the early morning or late evening. She says that her children no longer complain so much of diarrhoea. And her daughter Sandamalee has more time for school work.</p>' .
            '<p><strong>G</strong><br>In the short term, and on a small scale, the project has clearly been a success. The challenge lies in making such initiatives sustainable and expanding their coverage. At a purely technical level, rainwater harvesting is evidently sustainable. In Muthukandiya, the skills required to build and maintain storage tanks were taught fairly easily and can be shared by the two trained masons, who are now finding work with other development agencies in the district.</p>' .
            '<p><strong>H</strong><br>The non-structural elements of the work, especially it’s financial and organizational, present a bigger challenge. A revolving fund was set up, with households that had already benefited agreeing to contribute a small monthly amount to pay for maintenance, repairs and new tanks. However, it appears that the revolving fund concept was not fully understood and it has proved difficult to get households to contribute. Recovering costs from interventions that do not generate income directly will always be a difficult proposition, although this can be overcome if the process is explained more fully at the outset.</p>' .
            '<p><strong>I</strong><br>The Muthkandiya initiative was planned as a demonstration project, to show that community-based drought mitigation through rainwater harvesting was feasible. Several other organizations have begun their own projects using the same approach. The feasibility of introducing larger tanks is being investigated.</p>' .
            '<p><strong>J</strong><br>However, a lot of effort and patience are needed to generate the interest, develop the skills and organize the management structures needed to implement sustainable community-based projects. It will probably be some time before rainwater harvesting technologies can spread rapidly and spontaneously across the district’s villages, without external support.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p1->id,
            'question_number' => 1,
            'question_text' => 'Questions 1-6<br>Answer the questions below. Choose NO MORE THAN THREE WORDS AND/OR A NUMBER from the passage for each answer.',
            'type' => 'sentence_completion',
            'data' => [
                'summary_text' => '<div class="space-y-6">
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">1.</span> <div>What is the major way for local people make barely support of living in Muthukandiya village? [1]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">2.</span> <div>Where can adult workers make extra money from in daytime? [2]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">3.</span> <div>What has been dug to supply water for daily household life? [3]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">4.</span> <div>In which year did the plan of a new project to lessen the effect of drought begins? [4]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">5.</span> <div>Where do the gutters and pipes collect rainwater from? [5]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">6.</span> <div>What helps the family obtain more water for domestic needs than those relying on only wells and ponds? [6]</div></div>
                </div>',
                'placeholders' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
            ],
            'correct_answer' => [
                '1' => 'Crop production',
                '2' => 'sugar-cane plantations',
                '3' => 'three wells',
                '4' => '1998',
                '5' => 'roofs of houses',
                '6' => 'rainwater storage tanks'
            ],
            'explanation' => '1: Crop production, 2: sugar-cane plantations, 3: three wells, 4: 1998, 5: roofs of houses, 6: rainwater storage tanks',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p1->id,
            'question_number' => 2,
            'question_text' => 'Questions 7-13<br>Do the following statements agree with the information given in Reading Passage 1?<br>Write YES if the statement is true, NO if the statement is false, NOT GIVEN if the information is not given in the passage.',
            'type' => 'true_false_not_given',
            'options' => [
                'YES' => 'YES',
                'NO' => 'NO',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'data' => [
                'start_number' => 7,
                'sub_questions' => [
                    ['id' => '7', 'label' => '7. Most of the government\'s actions and other programmes have somewhat failed.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '8', 'label' => '8. Masons were trained for the constructing parts of the rainwater harvesting system.', 'correct_answer' => 'YES'],
                    ['id' => '9', 'label' => '9. The cost of rainwater harvesting systems was shared by local villagers and the local government.', 'correct_answer' => 'NO'],
                    ['id' => '10', 'label' => '10. Tanks increase both the amount and quality of the water for domestic use.', 'correct_answer' => 'YES'],
                    ['id' => '11', 'label' => '11. To send her daughter to school, a widow had to work for a job in a rainwater harvesting scheme.', 'correct_answer' => 'NO'],
                    ['id' => '12', 'label' => '12. Households benefited began to pay part of the maintenance or repairs.', 'correct_answer' => 'YES'],
                    ['id' => '13', 'label' => '13. Training two masons at the same time is much more preferable to training a single one.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ],
            'correct_answer' => [
                '7' => 'NOT GIVEN',
                '8' => 'YES',
                '9' => 'NO',
                '10' => 'YES',
                '11' => 'NO',
                '12' => 'YES',
                '13' => 'NOT GIVEN'
            ],
            'explanation' => '7: NOT GIVEN, 8: YES, 9: NO, 10: YES, 11: NO, 12: YES, 13: NOT GIVEN',
            'order' => 2
        ]);

        // Passage 2: Mammoth kill 2
        $p2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Mammoth kill 2',
            'content' => '<p>Mammoth is any species of the extinct genus Mammuthus, proboscideans commonly equipped with long, curved tusks and, in northern species, a covering of long hair. They lived from the Pliocene epoch from around 5 million years ago, into the Holocene at about 4,500 years ago and were members of the family Elephantidae, which contains, along with mammoths, the two genera of modern elephants and their ancestors.</p>' .
            '<p><strong>A</strong><br>Like their modern relatives, mammoths were quite large. The largest known species reached heights in the region of 4 m at the shoulder and weighs up to 8 tonnes, while exceptionally large males may have exceeded 12 tonnes. However, most species of mammoth were only about as large as a modern Asian elephant. Both sexes bore tusks. A first, small set appeared at about the age of six months and these were replaced at about 18 months by the permanent set. Growth of the permanent set was at a rate of about 1 to 6 inches per year. Based on studies of their close relatives, the modern elephants, mammoths probably had a gestation period of 22 months, resulting in a single calf being born. Their social structure was probably the same as that of African and Asian elephants, with females living in herds headed by a matriarch, whilst bulls lived solitary lives or formed loose groups after sexual maturity.</p>' .
            '<p><strong>B</strong><br>MEXICO CITY – Although it’s hard to imagine in this age of urban sprawl and automobiles, North America once belonged to mammoths, camels, ground sloths as large as cows, bear-sized beavers and other formidable beasts. Some 11,000 years ago, however, these large-bodied mammals and others – about 70 species in all – disappeared. Their demise coincided roughly with the arrival of humans in the New World and dramatic climatic change – factors that have inspired several theories about the die-off. Yet despite decades of scientific investigation, the exact cause remains a mystery. Now new findings offer support to one of these controversial hypotheses: that human hunting drove this megafaunal menagerie to extinction. The overkill model emerged in the 1960s when it was put forth by Paul S. Martin of the University of Arizona. Since then, critics have charged that no evidence exists to support the idea that the first Americans hunted to the extent necessary to cause these extinctions. But at the annual meeting of the Society of Vertebrate Paleontology in Mexico City last October, paleoecologist John Alroy of the University of California at Santa Barbara argued that, in fact, hunting-driven extinction is not only plausible, but it was only unavoidable. He has determined, using a computer simulation, that even a very modest amount of hunting would have wiped these animals out.</p>' .
            '<p><strong>C</strong><br>Assuming an initial human population of 100 people that grew no more than 2 percent annually, Alroy determined that if each band of, say, 50 people killed 15 to 20 large mammals a year, humans could have eliminated the animal populations within 1,000 years. Large mammals, in particular, would have been vulnerable to the pressure because they have longer gestation periods than smaller mammals and they’re young require extended care.</p>' .
            '<p><strong>D</strong><br>Not everyone agrees with Alroy’s assessment. For one, the results depend in part on population-size estimates for the extinct animals – figures that are not necessarily reliable. But a more specific criticism comes from mammalogist Ross D. E. MacPhee of the American Museum of Natural History in New York City, who points out that the relevant archaeological record contains barely a dozen examples of stone points embedded in mammoth bones (and none, it should be noted, are known from other megafaunal remains) – hardly what one might expect if hunting drove these animals to extinction. Furthermore, some of these species had huge ranges – the giant Jefferson’s ground sloth, for example, lived as far north as the Yukon and as far south as Mexico – which would have made slaughtering them in numbers sufficient to cause their extinction rather implausible, he says.</p>' .
            '<p><strong>E</strong><br>Macphee agrees that humans most likely brought about these extinctions (as well as others around the world that coincided with human arrival), but not directly. Rather he suggests that people may have introduced hyper lethal disease, perhaps through their dogs or hitchhiking vermin, which then spread wildly among the immunologically naive species of the New World. As in the overkill model, populations of large mammals would have a harder time recovering. Repeated outbreaks of a hyper disease could thus quickly drive them to the point of no return. So far MacPhee does not have empirical evidence for the hyper disease hypotheses, and it won’t be easy to come by hyper lethal disease would kill far too quickly to leave its signature on the bones themselves. But he hopes that analyses of tissue and DNA from the last mammoths to perish will eventually reveal murderous microbes.</p>' .
            '<p><strong>F</strong><br>The third explanation for what brought on this North American extinction does not involve human beings. Instead, its proponents blame the loss on the water. The Pleistocene epoch witnessed considerable climatic instability, explains palaeontologist Russell W. Graham of the Denver Museum of Nature and Science. As a result, certain habitats disappeared, and species that had once formed communities split apart. For some animals, this change brought opportunity. For much of the megafauna, however, the increasingly homogeneous environment left them with shrinking geographical ranges – a death sentence for large animals, which need large ranges. Although these creatures managed to maintain viable populations through most of the Pleistocene, the final major fluctuation – the so-called Younger Dryas event – pushed them over the edge, Graham says. For his part, Alroy is convinced that human hunters demolished the titans of the Ice Age. The overkill model explains everything the disease and climate scenarios explain, he asserts, and makes accurate predictions about which species would eventually go extinct. “Personally, I’m a vegetarian,” he remarks, “and I find all of this kind of gross – but believable.”</p>',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p2->id,
            'question_number' => 3,
            'question_text' => 'Questions 14-20<br>Complete the following summary of the paragraphs of Reading Passage. Using NO MORE THAN THREE WORDS from the Reading Passage for each answer.',
            'type' => 'sentence_completion',
            'data' => [
                'summary_text' => 'The reason why dead big size mammals become extinct 11,000 years ago is under hot debate. The first explanation is that [14] of human-made it happen. This so-called [15] began from the 1960s suggested by an expert, who however received criticism of lack of further information. Another assumption promoted by MacPhee is that deadly [16] from human causes their demises. However, his hypothesis required more [17] to testify its validity. Graham proposed a third hypothesis that [18] in Pleistocene epoch drove some species disappear, reduced [19] posed a dangerous signal to these giants, and [20] finally wiped them out.',
                'placeholders' => [
                    '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18, '19' => 19, '20' => 20
                ]
            ],
            'correct_answer' => [
                '14' => 'hunting',
                '15' => 'overkill model',
                '16' => 'disease/hyperdisease',
                '17' => 'empirical evidence',
                '18' => 'climatic instability',
                '19' => 'geographical ranges',
                '20' => 'Younger Dryas event'
            ],
            'explanation' => '14: hunting, 15: overkill model, 16: disease/hyperdisease, 17: empirical evidence, 18: climatic instability, 19: geographical ranges, 20: Younger Dryas event',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p2->id,
            'question_number' => 4,
            'question_text' => 'Questions 21-26<br>Use the information in the passage to match the people (listed A-C) with opinions or deeds below.<br>NB You may use any letter more than once.',
            'type' => 'matching_features',
            'options' => [
                'A' => 'John Alroy',
                'B' => 'Ross D. E. MacPhee',
                'C' => 'Russell W. Graham'
            ],
            'data' => [
                'box_title' => 'List of Researchers',
                'start_number' => 21,
                'sub_questions' => [
                    ['id' => '21', 'label' => '21. Human hunting well explained which species would finally disappear.', 'correct_answer' => 'A'],
                    ['id' => '22', 'label' => '22. Further grounded proof needed to explain human’s indirect impact on mammals.', 'correct_answer' => 'B'],
                    ['id' => '23', 'label' => '23. Overhunting situation has caused die-out of large mammals.', 'correct_answer' => 'A'],
                    ['id' => '24', 'label' => '24. Illness rather than hunting caused extensive extinction.', 'correct_answer' => 'B'],
                    ['id' => '25', 'label' => '25. Doubt raised through the study of several fossil records.', 'correct_answer' => 'B'],
                    ['id' => '26', 'label' => '26. Climate shift is the main reason for extinction.', 'correct_answer' => 'C'],
                ]
            ],
            'correct_answer' => [
                '21' => 'A',
                '22' => 'B',
                '23' => 'A',
                '24' => 'B',
                '25' => 'B',
                '26' => 'C'
            ],
            'explanation' => '21: A, 22: B, 23: A, 24: B, 25: B, 26: C',
            'order' => 2
        ]);

        // Passage 3: Language Strategy in Multinational Company
        $p3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Language Strategy in Multinational Company',
            'content' => '<p><strong>A</strong> The importance of language management in multinational companies has never been greater than today. Multinationals are becoming ever more conscious of the importance of global coordination as a source of competitive advantage and language remains the ultimate barrier to aspirations of international harmonization. Before attempting to consider language management strategies, companies will have to evaluate the magnitude of the language barrier confronting them and in doing so they will need to examine it in three dimensions: the Language Diversity, the Language Penetration and the Language Sophistication.</p>' .
            '<p><strong>B</strong> The simplest answer, though realistic only for English-speaking companies, is to rely on one\'s native tongue. As recently as 1991 a survey of British exporting companies found that over a third used English exclusively in dealings with foreign customers. This attitude that “one language fits all” has also been carried through into the Internet age. A survey of the websites of top American companies confirmed that over half made no provision for foreign language access. Widespread though it is, however, reliance on a single language is a strategy that is fatally flawed. It makes no allowance for the growing trend in Linguistic Nationalism whereby buyers in Asia, South America and the Middle East are asserting their right to “work in the language of the customer!”.</p>' .
            '<p><strong>C</strong> Another improvised approach to language is to rely on what has been termed "Functional Multilingualism". Essentially what this means is to muddle through, relying on a mix of languages, pidgins and gestures to communicate by whatever means the parties have at their disposal. This approach can be seen in everyday situations where different nationalities interact and manage to communicate, often with humor, despite not sharing a common language. However, in a business context, particularly one involving complex negotiations, contracts, or technical details, this informal approach is fraught with risk. Ambiguity and misunderstandings can easily arise, leading to costly errors and damaged relationships.</p>' .
            '<p><strong>D</strong> A more rational and obvious response to the language barrier is to employ external resources such as translators and interpreters. However, such a response is by no means an end to the language barrier. For a start, these services can be very expensive with a top Simultaneous Interpreter commanding daily rates as high as a partner in an international consulting company. Secondly, any good translator or interpreter will insist that to be fully effective they must understand the context of the subject matter. Furthermore, in situations requiring negotiation, persuasion, humor, etc., the use of an interpreter is a poor substitute for direct communication.</p>' .
            '<p><strong>E</strong> The immediate and understandable reaction to any skills shortage in a business is to consider personnel development, and certainly the language training industry is well developed. However, without doubting the value of language training, no company should be deluded into believing this to be assured of success. Training in most companies is geared to the economic cycle. When times are good, money is invested in training. When times are bad, training budgets are often the first to be cut, essentially becoming the first luxury to go. Furthermore, language training can be a long and arduous process.</p>' .
            '<p><strong>F</strong> Some companies, like the Volkswagen Group, have developed or set a comprehensive language strategy over many years and can be regarded as a model of how to manage language professionally. The Volkswagen approach underlines that language training has to be considered a strategic solution rather than a tactical solution. This involves a long-term commitment to language development, integrating it into overall business strategy. The language program is substantial, consisting of 6 stages. It typically takes 90 hours for one single stage, and usually requires up to three years for employees to complete thoroughly.</p>',
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 5,
            'question_text' => 'Questions 27-32<br>Complete the summary below using the list of words, A-L.',
            'type' => 'summary_completion',
            'data' => [
                'box_title' => 'Options',
                'summary_text' => 'Multinational companies often rely on [27] as a primary lingua franca. However, this strategy is [28] due to the rise of linguistic nationalism. Another approach is functional multilingualism, which might work for social interactions but is less effective for [29] operations. In this approach, companies use a mix of languages and [30]. External resources like translators are sometimes used but they can be [31]. Moreover, they are a poor substitute for direct communication, making [32] less effective in complex meetings.',
                'placeholders' => [
                    '27' => 27, '28' => 28, '29' => 29, '30' => 30, '31' => 31, '32' => 32
                ],
                'box_options' => [
                    'A' => 'business',
                    'B' => 'English',
                    'C' => 'gestures',
                    'D' => 'interpreters',
                    'E' => 'contracts',
                    'F' => 'flawed',
                    'G' => 'native',
                    'H' => 'customers',
                    'I' => 'costs',
                    'J' => 'development',
                    'K' => 'complexity',
                    'L' => 'expensive'
                ]
            ],
            'correct_answer' => [
                '27' => 'B',
                '28' => 'F',
                '29' => 'A',
                '30' => 'C',
                '31' => 'L',
                '32' => 'D'
            ],
            'explanation' => '27: B, 28: F, 29: A, 30: C, 31: L, 32: D',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 6,
            'question_text' => 'Questions 33-39<br>Answer the questions below. Choose NO MORE THAN THREE WORDS AND/OR A NUMBER from the passage for each answer.',
            'type' => 'sentence_completion',
            'data' => [
                'summary_text' => '<div class="space-y-6">
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">33.</span> <div>What is the immediate reaction to skills shortage in a business? [33]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">34.</span> <div>What is often discarded when economic times are bad? [34]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">35.</span> <div>What has the Volkswagen Group done regarding a comprehensive language strategy? [35]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">36.</span> <div>How does Volkswagen view language training? [36]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">37.</span> <div>How many phases are in Volkswagen\'s training program? [37]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">38.</span> <div>How long does a single phase take? [38]</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">39.</span> <div>How long does the entire Volkswagen program usually take? [39]</div></div>
                </div>',
                'placeholders' => [
                    '33' => 33, '34' => 34, '35' => 35, '36' => 36, '37' => 37, '38' => 38, '39' => 39
                ]
            ],
            'correct_answer' => [
                '33' => 'personnel development',
                '34' => '(the first) luxury',
                '35' => 'developed/set',
                '36' => 'strategic solution',
                '37' => '6 stages',
                '38' => '90 hours (for one single stage)',
                '39' => 'three years'
            ],
            'explanation' => '33: personnel development, 34: (the first) luxury, 35: developed/set, 36: strategic solution, 37: 6 stages, 38: 90 hours (for one single stage), 39: three years',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 7,
            'question_text' => 'Question 40<br>Choose the correct letter, A, B, C or D.',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'Companies should only use English globally.',
                'B' => 'Translators are the best way to solve language barriers.',
                'C' => 'Multinationals need a well-planned, long-term language strategy.',
                'D' => 'Functional multilingualism is the most secure method for contracts.'
            ],
            'data' => [
                'start_number' => 40,
                'sub_questions' => [
                    ['id' => '40', 'label' => '40. What is the main idea of the passage?', 'correct_answer' => 'C']
                ]
            ],
            'correct_answer' => [
                '40' => 'C'
            ],
            'explanation' => '40: C (The entire passage outlines different strategies and points toward Volkswagen as a successful model of long-term planning).',
            'order' => 3
        ]);
    }
}
