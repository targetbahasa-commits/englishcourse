<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice7Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materialId = 7;

        // Cleanup existing Material 7
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $p) {
            $p->questions()->delete();
            $p->delete(); 
        }

        // Passage 1: New Agriculture in Oregon, US
        $p1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'New Agriculture in Oregon, US',
            'content' => '<p><strong>A</strong> Onion growers in eastern Oregon are adopting a system that saves water and keeps topsoil in place while producing the highest quality “super-colossal” onions. Pear growers in southern Oregon have reduced their use of some of the most toxic pesticides by up to two-thirds, and are still producing top-quality pear. Range managers throughout the state have controlled the poisonous weed tansy ragwort with insect predators and saved the Oregon livestock industry up to $4.8 million a year.</p>
            <p><strong>B</strong> These are some of the results Oregon growers have achieved in collaboration with Oregon State University (OSU) researchers as they test new farming methods including integrated pest management (IPM). Nationwide, however, IPM has not delivered results comparable to those in Oregon. A recent U.S General Accounting Office (GAO) report indicates that while integrated pest management can result in dramatically reduced pesticide use, the federal government has been lacking in effectively promoting that goal and implementing IPM. Farmers also blame the government for not making the new options of pest management attractive. “Wholesale changes in the way that farmers control the pests on their farms is an expensive business.” Tony Brown, of the National Farmers Association, says. “If the farmers are given tax breaks to offset the expenditure, then they would willingly accept the new practices.” The report goes on to note that even though the use of the riskiest pesticides has declined nationwide, they still make up more than 40 percent of all pesticides used today; and national pesticide use has risen by 40 million kilograms since 1992. “Our food supply remains the safest and highest quality on Earth but we continue to overdose our farmland with powerful and toxic pesticides and to under-use the safe and effective alternatives,” charged Patrick Leahy, who commissioned the report. Green action groups disagree about the safety issue. “There is no way that habitual consumption of foodstuffs grown using toxic chemical of the nature found on today’s farms can be healthy for consumers,” noted Bill Bowler, spokesman for Green Action, one of many lobbyists interested in this issue.</p>
            <p><strong>C</strong> The GAO report singles out Oregon’s apple and pear producers who have used the new IPM techniques with growing success. Although Oregon is clearly ahead of the nation, scientists at OSU are taking the Government Accounting Office criticisms seriously. “We must continue to develop effective alternative practices that will reduce environmental hazards and produce high-quality products,” said Paul Jepson, a professor of entomology at OSU and new director of</p>
            <p><strong>D</strong> OSU’s Integrated Plant Protection Centre (IPPC). The IPPC brings together scientists from OSU’s Agricultural Experiment Station, OSU Extension service, the U.S. Department of Agriculture and Oregon farmers to help develop agricultural systems that will save water and soil, and reduce pesticides. In response to the GAO report, the Centre is putting even more emphasis on integrating research and farming practices to improve Oregon agriculture environmentally and economically.</p>
            <p><strong>E</strong> “The GAO report criticizes agencies for not clearly communicating the goals of IPM,” said Jepson. “Our challenge is to greatly improve the communication to and from growers, to learn what works and what doesn’t. the work coming from OSU researchers must be adopted in the field and not simply languish in scientific journals.”</p>
            <p><strong>F</strong> In Oregon, growers and scientists are working together to instigate new practices. For example, a few years ago scientists at OSU’s Malheur Experiment Station began testing a new drip irrigation system to replace old ditches that wasted water and washed soil and fertilizer into streams. The new system cut water and fertilizer use by half kept topsoil in place and protected water quality.</p>
            <p><strong>G</strong> In addition, the new system produced crops of very large onions, rated “super-colossal” and highly valued by the restaurant industry and food processors. Art Pimms, one of the researchers at Malheur comments: “Growers are finding that when they adopt more environmentally benign practices, they can have excellent results. The new practices benefit the environment and give the growers their success.”</p>
            <p><strong>H</strong> OSU researcher in Malheur next tested straw mulch and found that it successfully held soil in place and kept the ground moist with less irrigation. In addition, and unexpectedly, the scientists found that the mulched soil created a home for beneficial beetles and spiders that prey on onion thrips – a notorious pest in commercial onion fields – a discovery that could reduce the need for pesticides. “I would never have believed that we could replace the artificial pest controls that we had before and still keep our good results,” commented Steve Black, a commercial onion farmer in Oregon, “but instead we have actually surpassed expectations.”</p>
            <p><strong>I</strong> OSU researchers throughout the state have been working to reduce dependence on broad-spectrum chemical spays that are toxic to many kinds of organisms, including humans. “Consumers are rightly putting more and more pressure on the industry to change its reliance on chemical pesticides, but they still want a picture-perfect product,” said Rick Hilton, an entomologist at OSU’s Southern Oregon Research and Extension Centre, where researches help pear growers reduce the need for highly toxic pesticides. Picture perfect pears are an important product in Oregon and traditionally they have required lots of chemicals. In recent years, the industry has faced stiff competition from overseas producers, so any new methods that growers adopt must make sense economically as well as environmentally. Hilton is testing a growth regulator that interferes with the molting of codling moth larvae. Another study used pheromone dispensers to disrupt codling moth mating. These and other methods of integrated pest management have allowed pear growers to reduce their use of organophosphates by two-thirds and reduce all other synthetic pesticides by even more and still produce top-quality pears. These and other studies around the state are part of the effort of the IPPC to find alternative farming practices that benefit both the economy and the environment.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p1->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–8<br>Use the information in the passage to match the people (listed A-G) with opinions or deeds below.<br>Write the appropriate letters A-G in boxes 1-8 on your answer sheet.<br>NB  You may use any letter more than once',
            'type' => 'matching_features',
            'options' => [
                'A' => 'Tony Brown',
                'B' => 'Patrick Leahy',
                'C' => 'Bill Bowler',
                'D' => 'Paul Jepson',
                'E' => 'Art Pimms',
                'F' => 'Steve Black',
                'G' => 'Rick Hilton'
            ],
            'correct_answer' => ['1' => 'E', '2' => 'D', '3' => 'C', '4' => 'A', '5' => 'F', '6' => 'D', '7' => 'B', '8' => 'G'],
            'explanation' => '1: E (Art Pimms "The new practices benefit the environment and give the growers their success."), 2: D (Paul Jepson "We must continue to develop effective alternative practices..."), 3: C (Bill Bowler "There is no way that habitual consumption of foodstuffs grown using toxic chemical... can be healthy"), 4: A (Tony Brown "Wholesale changes... is an expensive business."), 5: F (Steve Black "we have actually surpassed expectations."), 6: D (Paul Jepson "the work coming from OSU researchers must be adopted in the field and not simply languish in scientific journals."), 7: B (Patrick Leahy "Our food supply remains the safest and highest quality on Earth"), 8: G (Rick Hilton "Consumers are rightly putting more and more pressure... but they still want a picture-perfect product")',
            'data' => [
                'start_number' => 1,
                'box_title' => 'List of People',
                'sub_questions' => [
                    ['id' => '1', 'label' => '1 There is a double-advantage to the new techniques.'],
                    ['id' => '2', 'label' => '2 The work on developing these alternative techniques is not finished.'],
                    ['id' => '3', 'label' => '3 Eating food that has had chemicals used in its production is dangerous to our health.'],
                    ['id' => '4', 'label' => '4 Changing current farming methods into a new one is not a cheap process.'],
                    ['id' => '5', 'label' => '5 Results have exceeded the anticipated goal.'],
                    ['id' => '6', 'label' => '6 The research done should be translated into practical projects.'],
                    ['id' => '7', 'label' => '7 The U.S. produces the best food in the world nowadays.'],
                    ['id' => '8', 'label' => '8 Expectations of end-users of agricultural products affect the products.']
                ]
            ],
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p1->id,
            'question_number' => 2,
            'question_text' => 'Questions 9–13<br>Do the following statements agree with the information given in Reading Passage 1?<br>In boxes 9-13 on your answer sheet, write:<br><b>YES</b> if the statement is true<br><b>NO</b> if the statement is false<br><b>NOT GIVEN</b> if the information is not given in the passage',
            'type' => 'yes_no_not_given',
            'options' => ['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN'],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 9,
                'sub_questions' => [
                    ['id' => '9', 'label' => '9 Integrated Pest Management has generally been regarded as a success in across the US.', 'correct_answer' => 'NO'],
                    ['id' => '10', 'label' => '10 Oregon farmers of apples and pears have been promoted as successful examples of Integrated Pest Management.', 'correct_answer' => 'YES'],
                    ['id' => '11', 'label' => '11 The IPPC uses scientists from different organisations globally', 'correct_answer' => 'NO'],
                    ['id' => '12', 'label' => '12 Straw mulch experiments produced unplanned benefits.', 'correct_answer' => 'YES'],
                    ['id' => '13', 'label' => '13 The apple industry is now facing a lot of competition from abroad.', 'correct_answer' => 'NOT GIVEN']
                ]
            ],
            'order' => 2
        ]);

        // Passage 2: WHAT COOKBOOKS REALLY TEACH US
        $p2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'WHAT COOKBOOKS REALLY TEACH US',
            'content' => '<p><strong>A</strong> Shelves bend under their weight of cookery books. Even a medium-sized bookshop contains many more recipes than one person could hope to cook in a lifetime. Although the recipes in one book are often similar to those in another, their presentation varies wildly, from an array of vegetarian cookbooks to instructions on cooking the food that historical figures might have eaten. The reason for this abundance is that cookbooks promise to bring about a kind of domestic transformation for the user. The daily routine can be put to one side and they liberate the user, if only temporarily. To follow their instructions is to turn a task which has to be performed every day into an engaging, romantic process. Cookbooks also provide an opportunity to delve into distant cultures without having to turn up at an airport to get there.</p>
            <p><strong>B</strong> The first Western cookbook appeared just over 1,600 years ago. De re coquinara (it means concerning cookery’) is attributed to a Roman gourmet named Apicius. It is probably a compilation of Roman and Greek recipes, some or all of them drawn from manuscripts that were later lost. The editor was sloppy, allowing several duplicated recipes to sneak in. Yet Apicius’s book set the tone of cookery advice in Europe for more than a thousand years. As a cookbook, it is unsatisfactory with very basic instructions. Joseph Vehling, a chef who translated Apicius in the 1930s, suggested the author had been obscure on purpose, in case his secrets leaked out.</p>
            <p><strong>C</strong> But a more likely reason is that Apicius’s recipes were written by and for professional cooks, who could follow their shorthand. This situation continued for hundreds of years. There was no order to cookbooks: a cake recipe might be followed by a mutton one. But then, they were not written for careful study. Before the 19th century, few educated people cooked for themselves.</p>
            <p><strong>D</strong> The wealthiest employed literate chefs; others presumably read recipes to their servants. Such cooks would have been capable of creating dishes from the vaguest of instructions. The invention of printing might have been expected to lead to greater clarity but at first, the reverse was true. As words acquired commercial value, plagiarism exploded. Recipes were distorted through reproduction. A recipe for boiled capon in The Good Huswives Jewell, printed in 1596, advised the cook to add three or four dates. By 1653, when the recipe was given by a different author in A Book of Fruits & Flowers, the cook was told to set the dish aside for three or four days.</p>
            <p><strong>E</strong> The dominant theme in 16th and 17th-century cookbooks was ordered. Books combined recipes and household advice, on the assumption that a well-made dish, a well-ordered larder and well-disciplined children were equally important. Cookbooks thus became a symbol of dependability in chaotic times. They hardly seem to have been affected by the English civil war or the revolutions in America and France.</p>
            <p><strong>F</strong> In the 1850s Isabella Beeton published The Book of Household Management. Like earlier cookery writers she plagiarized freely, lifting not just recipes but philosophical observations from other books. If Beeton’s recipes were not wholly new, though, the way in which she presented them certainly was. She explains when she chief ingredients are most likely to be in season, how long the dish will take to prepare and even how much it is likely to cost. Beetons recipes were well suited to her times. Two centuries earlier, an understanding of rural ways had been so widespread that one writer could advise cooks to heat water until it was a little hotter than milk comes from a cow. By the 1850s Britain was industrialising. The growing urban middle class needed details, and Beeton provided them in full.</p>
            <p><strong>G</strong> In France, cookbooks were fast becoming even more systematic. Compared with Britain, France had produced few books written for the ordinary householder by the end of the 19th century. The most celebrated French cookbooks were written by superstar chefs who had a clear sense of codifying a unified approach to sophisticated French cooking. The 5,000 recipes in Auguste Escoffier’s Le Guide Culinaire (The Culinary Guide), published in 1902, might as well have been written in stone, given the book’s reputation among French chefs, many of whom still consider it the definitive reference book.</p>
            <p><strong>H</strong> What Escoffier did for French cooking, Fannie Farmer did for American home cooking. She not only synthesised American cuisine; she elevated it to the status of science. ‘Progress in civilisation has been accompanied by progress in cookery,’ she breezily announced in The Boston Cooking-School Cook Book, before launching into a collection of recipes that sometimes resembles a book of chemistry experiments. She was occasionally over-fussy. She explained that currants should be picked between June 28th and July 3rd, but not when it is raining. But in the main, her book is reassuringly authoritative. Its recipes are short, with no unnecessary chat and no unnecessary spices.</p>
            <p><strong>I</strong> In 1950 Mediterranean Food by Elizabeth David launched a revolution in cooking advice in Britain. In some ways, Mediterranean Food recalled even older cookbooks but the smells and noises that filled David’s books were not a mere decoration for her recipes. They were the point of her books. When she began to write, many ingredients were not widely available or affordable. She understood this, acknowledging in a letter edition of one of her books that even if people could not very often make the dishes here described, it was stimulating to think about them. David’s books were not so much cooking manuals as guides to the kind of food people might well wish to eat.</p>',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p2->id,
            'question_number' => 3,
            'question_text' => 'Questions 14–16<br>Complete the summary below. Choose NO MORE THAN TWO WORDS from the passage for each answer.',
            'type' => 'summary_completion',
            'options' => null,
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'summary_text' => 'Why are there so many cookery books?<br>There are a great number more cookery books published than is really necessary and it is their [14] which makes them differ from each other. There are such large numbers because they offer people an escape from their [15] and some give the user the chance to inform themselves about other [16].',
                'blanks' => [
                    ['id' => '14', 'blank_number' => 14, 'correct_answer' => 'presentation'],
                    ['id' => '15', 'blank_number' => 15, 'correct_answer' => 'daily routine'],
                    ['id' => '16', 'blank_number' => 16, 'correct_answer' => 'cultures']
                ]
            ],
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p2->id,
            'question_number' => 4,
            'question_text' => 'Questions 17–21<br>Reading Passage has nine paragraphs, A-I. Which paragraph contains the following information?<br>NB You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H', 'I' => 'I'],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 17,
                'sub_questions' => [
                    ['id' => '17', 'label' => '17 cookery books providing a sense of stability during periods of unrest', 'correct_answer' => 'E'],
                    ['id' => '18', 'label' => '18 details in recipes being altered as they were passed on', 'correct_answer' => 'D'],
                    ['id' => '19', 'label' => '19 knowledge which was in danger of disappearing', 'correct_answer' => 'F'],
                    ['id' => '20', 'label' => '20 the negative effect on cookery books of a new development', 'correct_answer' => 'D'],
                    ['id' => '21', 'label' => '21 a period when there was no need for cookery books to be precise', 'correct_answer' => 'C']
                ]
            ],
            'order' => 4
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p2->id,
            'question_number' => 5,
            'question_text' => 'Questions 22–26<br>Look at the following statements (Questions 22-26) and list of books (A-E) below. Match each statement with the correct book.',
            'type' => 'matching_features',
            'options' => [
                'A' => 'De re coquinara', 
                'B' => 'The Book of Household Management', 
                'C' => 'Le Guide Culinaire', 
                'D' => 'The Boston Cooking-School Cook Book', 
                'E' => 'Mediterranean Food'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 22,
                'box_title' => 'List of cookery books',
                'sub_questions' => [
                    ['id' => '22', 'label' => '22 Its recipes were easy to follow despite the writer’s attention to detail.', 'correct_answer' => 'D'],
                    ['id' => '23', 'label' => '23 Its writer may have deliberately avoided passing on details.', 'correct_answer' => 'A'],
                    ['id' => '24', 'label' => '24 It appealed to ambitious ideas people have about cooking.', 'correct_answer' => 'E'],
                    ['id' => '25', 'label' => '25 Its writer used ideas from other books but added additional related information.', 'correct_answer' => 'B'],
                    ['id' => '26', 'label' => '26 It put into print ideas which are still respected today.', 'correct_answer' => 'C']
                ]
            ],
            'order' => 5
        ]);

        // Passage 3: Learning lessons from the past
        $p3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Learning lessons from the past',
            'content' => '<p><strong>A</strong> Many past societies collapsed or vanished, leaving behind monumental ruins such as those that the poet Shelley imagined in his sonnet, Ozymandias. By collapse, I mean a drastic decrease in human population size and/or political/economic/social complexity, over a considerable, for an extended time. By those standards, most people would consider the following past societies to have been famous victims of full-fledged collapses rather than of just minor declines: the Anasazi and Cahokia within the boundaries of the modem US, the Maya cities in Central American, Moche and Tiwanaku societies in South America, Norse Greenland, Mycenean Greece and Minoan Crete in Europe, Great Zimbabwe in Africa, Angkor Wat and the Harappan Indus Valley cities in Asia, and Easter Island in the Pacific Ocean.</p>
            <p><strong>B</strong> The monumental ruins left behind by those past societies hold a fascination for all of us. We marvel at them when as children we first learn of them through pictures. When we grow up, many of us plan vacations in order to experience them at first hand. We feel drawn to their often spectacular and haunting beauty, and also to the mysteries that they pose. The scales of the ruins testify to the former wealth and power of their builders. Yet these builders vanished, abandoning the great structures that they had created at such effort. How could a society that was once so mighty end up collapsing?</p>
            <p><strong>C</strong> It has long been suspected that many of those mysterious abandonments were at least partly triggered by ecological problems: people inadvertently destroying the environmental resources on which their societies depended. This suspicion of unintended ecological suicide (ecocide) has been confirmed by discoveries made in recent decades by archaeologists, climatologists, historians, palaeontologists, and palynologists (pollen scientists). The processes through which past societies have undermined themselves by damaging their environments fall into eight categories, whose relative importance differs from case to case: deforestation and habitat destruction, soil problems, water management problems, overhunting, overfishing, effects of introduced species on native species, human population growth, and increased impact of people.</p>
            <p><strong>D</strong> Those past collapses tended to follow somewhat similar courses constituting variations on a theme. Writers find it tempting to draw analogies between the course of human societies and the course of individual human lives – to talk of a society’s birth, growth, peak, old age and eventual death. But that metaphor proves erroneous for many past societies: they declined rapidly after reaching peak numbers and power, and those rapid declines must have come as a surprise and shock to their citizens. Obviously, too, this trajectory is not one that all past societies followed unvaryingly to completion: different societies collapsed to different degrees and in somewhat different ways, while many societies did not collapse at all.</p>
            <p><strong>E</strong> Today many people feel that environmental problems overshadow all the other threats to global civilisation. These environmental problems include the same eight that undermined past societies, plus four new ones: human-caused climate change, the build-up of toxic chemicals in the environment, energy shortages, and full human utilisation of the Earth’s photosynthetic capacity. But the seriousness of these current environmental problems is vigorously debated. Are the risks greatly exaggerated, or conversely are they underestimated? Will modem technology solve our problems, or is it creating new problems faster than it solves old ones? When we deplete one resource (eg wood, oil, or ocean fish), can we count on being able to substitute some new resource (eg plastics, wind and solar energy, or farmed fish)? Isn’t the rate of human population growth declining, such that we’re already on course for the world’s population to level off at home manageable number of people?</p>
            <p><strong>F</strong> Questions like this illustrate why those famous collapses of past civilisations have taken on more meaning than just that of a romantic mystery. Perhaps there are some practical lessons that we could learn from all those past collapses. But there are also differences between the modem world and its problems, and those past societies and their problems. We shouldn’t be so naive as to think that the study of the past will yield simple solutions, directly transferable to our societies today. We differ from past societies in some respects that put us at lower risk than them; some of those respects often mentioned include our powerful technology (ie its beneficial effects), globalisation, modem medicine, and greater knowledge of past societies and of distant modem societies. We also differ from past societies in some respects that put us at greater risk than them: again, our potent technology (ie its unintended destructive effects), globalisation (such that now a problem in one part of the world affects all the rest), the dependence of millions of us on modern medicine for our survival, and our much larger human population. Perhaps we can still learn from the past, but only if we think carefully about its lessons.</p>',
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 27,
            'question_text' => 'When the writer describes the impact of monumental ruins today, he emphasizes',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'the income they generate from tourism.',
                'B' => 'the area of land they occupy.',
                'C' => 'their archaeological value.',
                'D' => 'their romantic appeal.'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 26,
            ],
            'order' => 6
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 28,
            'question_text' => 'Recent findings concerning vanished civilisations',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'have overturned long-held beliefs.',
                'B' => 'caused controversy amongst scientists.',
                'C' => 'come from a variety of disciplines.',
                'D' => 'identified one main cause of environmental damage.'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 27,
            ],
            'order' => 7
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 29,
            'question_text' => 'What does the writer say about ways in which former societies collapsed?',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'The pace of decline was usually similar.',
                'B' => 'The likelihood of collapse would have been foreseeable.',
                'C' => 'Deterioration invariably led to total collapse.',
                'D' => 'Individual citizens could sometimes influence the course of events.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 28,
            ],
            'order' => 8
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 30,
            'question_text' => 'Questions 30–34<br>Do the following statements agree with the views of the writer in Reading Passage?<br>Write:<br><b>YES</b> if the statement agrees with the claims of the writer<br><b>NO</b> if the statement contradicts the claims of the writer<br><b>NOT GIVEN</b> if it is impossible to say what the writer thinks about this',
            'type' => 'yes_no_not_given',
            'options' => ['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN'],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 29,
                'sub_questions' => [
                    ['id' => '30', 'label' => '30 It is widely believed that environmental problems represent the main danger faced by the modern world.', 'correct_answer' => 'YES'],
                    ['id' => '31', 'label' => '31 The accumulation of poisonous substances is a relatively modern problem.', 'correct_answer' => 'YES'],
                    ['id' => '32', 'label' => '32 There is general agreement that the threats posed by environmental problems are very serious.', 'correct_answer' => 'NO'],
                    ['id' => '33', 'label' => '33 Some past societies resembled present-day societies more closely than others.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '34', 'label' => '34 We should be careful when drawing comparisons between past and present.', 'correct_answer' => 'YES']
                ]
            ],
            'order' => 9
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 35,
            'question_text' => 'Questions 35–39<br>Complete each sentence with the correct ending, A-F, below.',
            'type' => 'matching_sentence_endings',
            'options' => [
                'A' => 'is not necessarily valid.', 
                'B' => 'provides grounds for an optimistic outlook.', 
                'C' => 'exists in the form of physical structures.', 
                'D' => 'is potentially both positive and negative.', 
                'E' => 'will not provide direct solutions for present problems.', 
                'F' => 'is greater now than in the past.'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 34,
                'sub_questions' => [
                    ['id' => '35', 'label' => '35 Evidence of the greatness of some former civilisations', 'correct_answer' => 'C'],
                    ['id' => '36', 'label' => '36 The parallel between an individual’s life and the life of a society', 'correct_answer' => 'A'],
                    ['id' => '37', 'label' => '37 The number of environmental problems that societies face', 'correct_answer' => 'F'],
                    ['id' => '38', 'label' => '38 The power of technology', 'correct_answer' => 'D'],
                    ['id' => '39', 'label' => '39 A consideration of historical events and trends', 'correct_answer' => 'E']
                ]
            ],
            'order' => 10
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 40,
            'question_text' => 'What is the main argument of Reading Passage 3?',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'There are differences as well as similarities between past and present societies.', 
                'B' => 'More should be done to preserve the physical remains of earlies civilisations.', 
                'C' => 'Some historical accounts of great civilisations are inaccurate.', 
                'D' => 'Modern societies are dependent on each other for their continuing survival.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 39,
            ],
            'order' => 11
        ]);
    }
}
