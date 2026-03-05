<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice19Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 19;

        // Clean up any existing records for this material
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // --- PASSAGE 1 ---
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'What are you laughing at?',
            'content' => '
<p><strong>A</strong></p>
<p>We like to think that laughing is the height of human sophistication. Our big brains let us see the humour in a strategically positioned pun, an unexpected plot twist or a clever piece of wordplay. But while joking and wit are uniquely human inventions, laughter certainly is not. Other creatures, including chimpanzees, gorillas and even rats, chuckle. Obviously, they don’t crack up at Homer Simpson or titter at the boss’s dreadful jokes, but the fact that they laugh in the first place suggests that sniggers and chortles have been around for a lot longer than we have. It points the way to the origins of laughter, suggesting a much more practical purpose than you might think.</p>

<p><strong>B</strong></p>
<p>There is no doubt that laughing typical involves groups of people. ‘Laughter evolved as a signal to others – it almost disappears when we are alone,’ says Robert Provine, a neuroscientist at the University of Maryland. Provine found that most laughter comes as a polite reaction to everyday remarks such as ‘see you later’, rather than anything particularly funny. And the way we laugh depends on the company we’re keeping. Men tend to laugh longer and harder when they are with other men, perhaps as a way of bonding. Women tend to laugh more and at a higher pitch when men are present, possibly indicating flirtation or even submission.</p>

<p><strong>C</strong></p>
<p>To find the origins of laughter, Provine believes we need to look at the play. He points out that the masters of laughing are children, and nowhere is their talent more obvious than in the boisterous antics, and the original context plays,’ he says. Well-known primate watchers, including Dian Fossey and Jane Goodall, have long argued that chimps laugh while at play. The sound they produce is known as a panting laugh. It seems obvious when you watch their behavior – they even have the same ticklish spots as we do. But remove the context, and the parallel between human laughter and a chimp’s characteristic pant laugh is not so clear. When Provine played a tape of the pant laughs to 119 of his students, for example, only two guessed correctly what it was.</p>

<p><strong>D</strong></p>
<p>These findings underline how chimp and human laughter vary. When we laugh the sound is usually produced by chopping up a single exhalation into a series of shorter with one sound produced on each inward and outward breath. The question is: does this pant laughter have the same source as our own laughter? New research lends weight to the idea that it does. The findings come from Elke Zimmerman, head of the Institute for Zoology in Germany, who compared the sounds made by babies and chimpanzees in response to tickling during the first year of their life. Using sound spectrographs to reveal the pitch and intensity of vocalizations, she discovered that chimp and human baby laughter follow broadly the same pattern. Zimmerman believes the closeness of baby laughter to chimp laughter supports the idea that laughter was around long before humans arrived on the scene. What started simply as a modification of breathing associated with enjoyable and playful interactions has acquired a symbolic meaning as an indicator of pleasure.</p>

<p><strong>E</strong></p>
<p>Pinpointing when laughter developed is another matter. Humans and chimps share a common ancestor that lived perhaps 8 million years ago, but animals might have been laughing long before that. More distantly related primates, including gorillas, laugh, and anecdotal evidence suggests that other social mammals nay do too. Scientists are currently testing such stories with a comparative analysis of just how common laughter is among animals. So far, though, the most compelling evidence for laughter beyond primates comes from research done by Jaak Panksepp from Bowling Green State University, Ohio, into the ultrasonic chirps produced by rats during play and in response to tickling.</p>

<p><strong>F</strong></p>
<p>All this still doesn’t answer the question of why we laugh at all. One idea is that laughter and tickling originated as a way of sealing the relationship between mother and child. Another is that the reflex response to tickling is protective, alerting us to the presence of crawling creatures that might harm us or compelling us to defend the parts of our bodies that are most vulnerable in hand-to-hand combat. But the idea that has gained most popularity in recent years is that laughter in response to tickling is a way for two individuals to signal and test their trust in one another. This hypothesis starts from the observation that although a little tickle can be enjoyable if it goes on too long it can be torture. By engaging in a bout of tickling, we put ourselves at the mercy of another individual, and laughing is a signal that we laughter is what makes it a reliable signal of trust according to Tom Flamson, a laughter researcher at the University of California, Los Angels. ‘Even in rats, laughter, tickle, play and trust are linked. Rats chirp a lot when they play,’ says Flamson. ‘These chirps can be aroused by tickling. And they get bonded to us as a result, which certainly seems like a show of trust.’</p>

<p><strong>G</strong></p>
<p>We’ll never know which animal laughed the first laugh, or why. But we can be sure it wasn’t in response to a prehistoric joke. The funny thing is that while the origins of laughter are probably quite serious, we owe human laughter and our language-based humor to the same unique skill. While other animals pant, we alone can control our breath well enough to produce the sound of laughter. Without that control, there would also be no speech – and no jokes to endure.</p>',
            'order' => 1,
        ]);

        // Questions 1-6: Matching Features
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'type' => 'matching_features',
            'question_text' => 'Look at the following research findings (questions 1-6) and the list of people below.<br>Match each finding with the correct person A, B, C or D.<br>Write the correct letter, A, B, C or D, in boxes 1-6 on your answer sheet.<br><br>NB You may use any letter more than once.',
            'options' => [
                'A' => 'Tom Flamson',
                'B' => 'Elke Zimmerman',
                'C' => 'Robert Provine',
                'D' => 'Jaak Panksepp'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'Babies and chimps produce similar sounds of laughter.', 'correct_answer' => 'B'],
                    ['id' => '2', 'label' => 'Primates are not the only animals who produce laughter', 'correct_answer' => 'D'],
                    ['id' => '3', 'label' => 'Laughter also suggests that we feel safe and easy with others.', 'correct_answer' => 'A'],
                    ['id' => '4', 'label' => 'Laughter is a response to a polite situation instead of humour.', 'correct_answer' => 'C'],
                    ['id' => '5', 'label' => 'Animal laughter evolved before human laughter', 'correct_answer' => 'B'],
                    ['id' => '6', 'label' => 'Laughter is a social activity.', 'correct_answer' => 'C'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 7-10: Summary Completion with Options
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 7,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '7' => 'I', // play
                '8' => 'C', // origins
                '9' => 'G', // primates
                '10' => 'E', // confidence
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 6,
                'instruction' => 'Complete the summary using the list of words, A-K, below.<br>Write the correct letter, A-K, in boxes 7-10 on your answer sheet.',
                'summary_text' => 'Some researchers believe that laughter first evolved out of <strong>[7]</strong>. The investigation has revealed that human and chimp laughter may have the same <strong>[8]</strong>. Besides, scientists have been aware that <strong>[9]</strong> laugh, however, it now seems that laughter might be more widespread than once we thought. Although the reasons why humans started to laugh are still unknown, it seems that laughter may result from the <strong>[10]</strong> we feel with another person.',
                'placeholders' => [
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10
                ],
                'box_options' => [
                    'A' => 'evolution',
                    'B' => 'chirps',
                    'C' => 'origins',
                    'D' => 'voice',
                    'E' => 'confidence',
                    'F' => 'rats',
                    'G' => 'primates',
                    'H' => 'response',
                    'I' => 'play',
                    'J' => 'children',
                    'K' => 'tickling'
                ]
            ],
            'order' => 2,
        ]);

        // Questions 11-13: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 11,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 1?<br>In boxes 11-13 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 10,
                'sub_questions' => [
                    ['id' => '11', 'label' => 'Both men and women laugh more when they are with members of the same sex.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '12', 'label' => 'Primates lack sufficient breath control to be able to produce laughs the way humans do.', 'correct_answer' => 'TRUE'],
                    ['id' => '13', 'label' => 'Chimpanzees produce laughter in a wider range of situations than rats do.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ],
            'order' => 3,
        ]);


        // --- PASSAGE 2 ---
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Leaf-Cutting Ants and Fungus',
            'content' => '
<p><strong>A</strong></p>
<p>The ants and their agriculture have been extensively studied over the years, but the recent research has uncovered intriguing new findings of the fungus they cultivate, how they domesticated it and how they cultivate it and preserve it from pathogens. For example, the fungus farms, which the ants were thought to keep free of pathogens, turn out to be vulnerable to a devastating mold, found nowhere else but in ants’ nests. To keep the mold in check, the ants long ago made a discovery that would do credit to any pharmaceutical laboratory.</p>

<p><strong>B</strong></p>
<p>Leaf-cutting ants and their fungus farms are a marvel of nature and perhaps the best-known example of symbiosis, the mutual dependence of two species. The ant’s achievement is remarkable – the biologist Edward O. Wilson has called it “one of the major breakthroughs in animal evolution” – because it allows them to eat, courtesy of their mushroom’s digestive powers, the otherwise poisoned harvest of tropical forests whose leaves are laden with terpenoids, alkaloids and other chemicals designed to sicken browsers.</p>

<p><strong>C</strong></p>
<p>Fungus growing seems to have originated only once in evolution because all gardening ants belong to a single tribe, the descendants of the first fungus farmer. There are more than 200 known species of the attine ant tribe, divided into 12 groups, or genera. The leaf-cutters use fresh vegetation; the other groups, known as the lower attines because their nests are smaller and their techniques more primitive, feed their gardens with detritus like dead leaves, insects and faeces.</p>

<p><strong>D</strong></p>
<p>The leaf-cutters’ fungus was indeed descended from a single strain, propagated clonally, or just by budding, for at least 23 million years. But the lower attine ants used different varieties of the fungus, and in one case a quite separate species, the four biologists discovered. The pure strain of fungus grown by the leaf-cutters, it seemed to Mr Currie, resembled the monocultures of various human crops, that are very productive for a while and then succumb to some disastrous pathogen, such as the Irish potato blight. Monocultures, which lack the genetic diversity to respond to changing environmental threats, are sitting ducks for parasites. Mr Currie felt there had to be a parasite in the ant-fungus system. But a century of ant research offered no support for the idea. Textbooks describe how leaf-cutter ants scrupulously weed their gardens of all foreign organisms. “People kept telling me, ‘You know the ants keep their gardens free of parasites, don’t you?’” Mr Currie said of his efforts to find a hidden interloper.</p>

<p><strong>E</strong></p>
<p>But after three years of sifting through attine ant gardens, Mr Currie discovered they are far from free of infection. In last month’s issue of the Proceeding of the National Academy of Sciences, he and two colleagues, Dr Mueller and David Mairoch, isolated several alien organisms, particularly a family of parasitic molds called Escovopsis.</p>

<p><strong>F</strong></p>
<p>Escovopsis turns out to be a highly virulent pathogen that can devastate a fungus garden in a couple of days. It blooms like a while cloud, with the garden dimly visible underneath. In a day or two, the whole garden is enveloped. “Other ants won’t go near it and the ants associated with the garden just starve to death,” Dr. Rehner said. “They just seem to give up, except for those that have rescued their larvae.” The deadly mold then turns greenish-brown as it enters its spore-forming stage.</p>

<p><strong>G</strong></p>
<p>Evidently, the ants usually manage to keep Escovopsis and other parasites under control. But with any lapse in control, or if the ants are removed, Escovopsis will quickly burst forth. Although new leaf-cutter gardens start off free of Escovopsis, within two years some 60 percent become infected. The discovery of Escovopsis’s role brings a new level of understanding of the evolution of the attine ants. “In the last decade, evolutionary biologists have been increasingly aware of the role of parasites as driving forces in evolution,” Dr Schultz said. There is now a possible reason to explain why the lower attine species keep changing the variety of fungus in their mushroom gardens, and occasionally domesticating new ones – to stay one step ahead of the relentless Escovopsis.</p>

<p><strong>H</strong></p>
<p>Interestingly, Mr. Currie found that the leaf-cutters had in general fewer alien molds in their gardens than the lower attines, yet they had more Escovopsis infections. It seems that the price they pay for cultivating a pure variety of fungus is a higher risk from Escovopsis. But the leaf-cutters may have a little alternative: they cultivate a special variety of fungus which, unlike those grown by the lower attines, produces nutritious swollen tips for the ants to eat.</p>

<p><strong>I</strong></p>
<p>Discovery of a third partner in the ant-fungus symbiosis raises the question of how the attine ants, especially the leaf-cutters, keep this dangerous interloper under control. Amazingly enough, Mr Currie has again provided the answer. “People have known for a hundred years that ants have a whitish growth on the cuticle,” said Dr Mueller, referring to the insects’ body surface. “People would say this is like a cuticular wax. But Cameron was the first one in a hundred years to put these things under a microscope. He was it was not inert wax. It is alive.” Mr Currie discovered a specialized patch on the ants’ cuticle that harbors a particular kind of bacterium, one well known to the pharmaceutical industry, because it is the source of half the antibiotics used in medicine. From each of 22 species of attine ant studied, Mr. Cameron and colleagues isolated a species of Streptomyces bacterium, they reported in Nature in April. The Streptomyces does not have much effect on ordinary laboratory funguses. But it is a potent poisoner of Escovopsis, inhibiting its growth and suppressing spore formation. It also stimulates the growth of the ants’ mushroom fungus. The bacterium is carried by virgin queens when they leave to establish new nests but is not found on male ants, playboys who take no responsibility in nest-making or gardening.</p>

<p><strong>J</strong></p>
<p>Because both the leaf-cutters and the lower attines use Streptomyces, the bacterium may have been part of their symbiosis for almost as long as the Escovopsis mold. If so, some Alexander Fleming of an ant discovered antibiotics millions of years before people did. Even now, the ants are accomplishing two feats beyond the powers of human technology. The leaf-cutters are growing a monocultural crop year after year without disaster, and they are using an antibiotic apparently so wisely and prudently that, unlike people, they are not provoking antibiotic resistance in the target pathogen.</p>',
            'order' => 2,
        ]);

        // Questions 14-19: Matching Features
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'type' => 'matching_features',
            'question_text' => 'Use the information in the passage to match the options (listed A-C) with activities or features of ants below.<br>Write the appropriate letters A-C in boxes 14-19 on your answer sheet.<br><br>NB You may use any letter more than once',
            'options' => [
                'A' => 'Leaf-cutting ants',
                'B' => 'Lower attines',
                'C' => 'Both'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 13,
                'sub_questions' => [
                    ['id' => '14', 'label' => 'Build small nests and live with the different foreign fungus.', 'correct_answer' => 'B'],
                    ['id' => '15', 'label' => 'Use toxic leaves to feed the fungus.', 'correct_answer' => 'A'],
                    ['id' => '16', 'label' => 'Raise fungus which doesn’t live with other foreigners.', 'correct_answer' => 'A'],
                    ['id' => '17', 'label' => 'Use substance to fight against Escovopsis.', 'correct_answer' => 'C'],
                    ['id' => '18', 'label' => 'Use dead vegetable to feed the fungus.', 'correct_answer' => 'B'],
                    ['id' => '19', 'label' => 'Are free of parasites explained previously?', 'correct_answer' => 'A'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 20-24: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 20,
            'type' => 'matching_paragraph_information',
            'question_text' => 'The Reading Passage has ten paragraphs A-J.<br>Which paragraph contains the following information?<br>Write the correct letter A-J, in boxes 20-24 on your answer sheet.',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E',
                'F' => 'Paragraph F',
                'G' => 'Paragraph G',
                'H' => 'Paragraph H',
                'I' => 'Paragraph I',
                'J' => 'Paragraph J',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 19,
                'sub_questions' => [
                    ['id' => '20', 'label' => 'Dangerous outcome of Escovopsis.', 'correct_answer' => 'F'],
                    ['id' => '21', 'label' => 'The disadvantage of growing single fungus.', 'correct_answer' => 'H'],
                    ['id' => '22', 'label' => 'comparison of features of two different nests.', 'correct_answer' => 'C'],
                    ['id' => '23', 'label' => 'Two achievements made by ants earlier than human.', 'correct_answer' => 'J'],
                    ['id' => '24', 'label' => 'Advantage of growing a new breed of fungus.', 'correct_answer' => 'G'],
                ]
            ],
            'order' => 2,
        ]);

        // Questions 25-26: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 25,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 25-26 on your answer sheet.<br><br>How does the author think of Currie’s opinion?',
            'options' => [
                'A' => 'his viewpoint was verified later.',
                'B' => 'earlier study has sufficient evidence.',
                'C' => 'no details mentioned in the article.',
                'D' => 'his opinion was proved to be wrong.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 24,
                'sub_questions' => [
                    ['id' => '25', 'label' => 'How does the author think of Currie’s opinion?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 26,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'some white cloud mold embed in their skin',
                'B' => 'that Wax is all over their skin.',
                'C' => 'a substance which is useful to humans.',
                'D' => 'a substance which suppresses the growth of fungus.'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 25,
                'sub_questions' => [
                    ['id' => '26', 'label' => 'What did scientists find on the skin of ants under a microscope?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 4,
        ]);


        // --- PASSAGE 3 ---
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Assessing the risk',
            'content' => '
<p><strong>A</strong></p>
<p>As a title for a supposedly unprejudiced debate on scientific progress, “Panic attack: interrogating our obsession with risk” did not bode well. Held last week at the Royal Institution in London, the event brought together scientists from across the world to ask why society is so obsessed with risk and to call for a “more rational” approach. “We seem to be organising society around the grandmotherly maxim of ‘better safe than sorry’,” exclaimed Spiked, the online publication that organised the event. “What are the consequences of this overbearing concern with risks?”</p>

<p><strong>B</strong></p>
<p>The debate was preceded by a survey of 40 scientists who were invited to describe how awful our lives would be if the “precautionary principle” had been allowed to prevail in the past. Their response was: no heart surgery or antibiotics, and hardly any drugs at all; no aeroplanes, bicycles or high-voltage power grids; no pasteurisation, pesticides or biotechnology; no quantum mechanics; no wheel; no “discovery” of America. In short, their message was: no risk, no gain.</p>

<p><strong>C</strong></p>
<p>They have absolutely missed the point. The precautionary principle is a subtle idea. It has various forms, but all of them generally include some notion of cost-effectiveness. Thus the point is not simply to ban things that are not known to be absolutely safe. Rather, it says: “Of course you can make no progress without risk. But if there is no obvious gain from taking the risk, then don’t take it.”</p>

<p><strong>D</strong></p>
<p>Clearly, all the technologies listed by the 40 well-chosen savants were innately risky at their inception, as all technologies are. But all of them would have received the green light under the precautionary principle because they all had the potential to offer tremendous benefits – the solutions to very big problems – if only the snags could be overcome.</p>

<p><strong>E</strong></p>
<p>If the precautionary principle had been in place, the scientists tell us, we would not have antibiotics. But of course, we would – if the version of the principle that sensible people now understand had been applied. When penicillin was discovered in the 1920s, infective bacteria were laying waste to the world. Children died from diphtheria and whooping cough, every open-drain brought the threat of typhoid, and any wound could lead to septicaemia and even gangrene.</p>

<p><strong>F</strong></p>
<p>Penicillin was turned into a practical drug during the Second World War when the many pestilences that result from were threatened to kill more people than the bombs. Of course antibiotics were a priority. Of course, the risks, such as they could be perceived, were worth taking.</p>

<p><strong>G</strong></p>
<p>And so with the other items on the scientists’ list: electric light bulbs, blood transfusions. CAT scans, knives, the measles vaccine – the precautionary principle would have prevented all of them, they tell us. But this is just plain wrong. If the precautionary principle had been applied properly, all these creations would have passed muster, because all offered incomparable advantages compared to the risks perceived at the time.</p>

<p><strong>H</strong></p>
<p>Another issue is at stake here. Statistics are not the only concept people use when weighing up risk. Human beings, subtle and evolved creatures that we are, do not survive to three-score years and ten simply by thinking like pocket calculators. A crucial issue is the consumer’s choice. In deciding whether to pursue the development of new technology, the consumer’s right to choose should be considered alongside considerations of risk and benefit. Clearly, skiing is more dangerous than genetically modified tomatoes. But people who ski choose to do so; they do not have skiing thrust upon them by portentous experts of the kind who now feel they have the right to reconstruct our crops. Even with skiing, there is the matter of cost-effectiveness to consider: skiing, I am told, is exhilarating. Where is the exhilaration in GM soya?</p>

<p><strong>I</strong></p>
<p>Indeed, in contrast to all the other items on Spiked’s list, GM crops stand out as an example of a technology whose benefits are far from clear. Some of the risks can at least be defined. But in the present economic climate, the benefits that might accrue from them seem dubious. Promoters of GM crops believe that the future population of the world cannot be fed without them. That is untrue. The crops that really matter are wheat and rice, and there is no GM research in the pipeline that will seriously affect the yield of either. GM is used to make production cheaper and hence more profitable, which is an extremely questionable ambition.</p>

<p><strong>J</strong></p>
<p>The precautionary principle provides the world with a very important safeguard. If it had been in place in the past it might, for example, have prevented insouciant miners from polluting major rivers with mercury. We have come to a sorry pass when scientists, who should above all be dispassionate scholars, feel they should misrepresent such a principle for the purposes of commercial and political propaganda. People at large continue to mistrust science and the high technologies it produces partly because they doubt the wisdom of scientists. On such evidence as this, these doubts are fully justified.</p>',
            'order' => 3,
        ]);

        // Questions 27-32: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 3?<br>In boxes 27-32 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => 'The title of the debate is not unbiased.', 'correct_answer' => 'TRUE'],
                    ['id' => '28', 'label' => 'All the scientists invited to the debate were from the field of medicine.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '29', 'label' => 'The message those scientists who conducted the survey were sending was people shouldn’t take risks.', 'correct_answer' => 'FALSE'],
                    ['id' => '30', 'label' => 'All the 40 listed technologies are riskier than other technologies.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '31', 'label' => 'It was worth taking the risks to invent antibiotics.', 'correct_answer' => 'TRUE'],
                    ['id' => '32', 'label' => 'All the other inventions on the list were also judged by the precautionary principle.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 33-39: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 33,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '33' => 'consumer’s choice', // Or consumer's right (to choose), we provide consumer's choice based on typical single-word/phrase grading
                '34' => 'risk and benefit',
                '35' => 'Skiing',
                '36' => 'GM crops',
                '37' => 'wheat and rice',
                '38' => 'production',
                '39' => 'mistrust',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 32,
                'instruction' => 'Complete the following summary of the paragraphs of Reading Passage<br>Using <strong>NO MORE THAN THREE WORDS</strong> from the Reading Passage for each answer.<br>Write your answers in boxes 33-39 on your answer sheet.',
                'summary_text' => 'When applying the precautionary principle to decide whether to invent a new technology, people should also the consideration of the <strong>[33]</strong>, along with the usual consideration of <strong>[34]</strong>. For example, though risky and dangerous enough, people still enjoy <strong>[35]</strong> for the excitement it provides. On the other hand, experts believe that future population desperately needs <strong>[36]</strong> in spite of their undefined risks. However, the researchers conducted so far have not been directed towards increasing the yield of <strong>[37]</strong>, but to reduce the cost of <strong>[38]</strong> and to bring more profit out of it. In the end, such selfish use of the precautionary principle for business and political gain has often led people to <strong>[39]</strong> science for they believe scientists are not to be trusted.',
                'placeholders' => [
                    '33' => 33,
                    '34' => 34,
                    '35' => 35,
                    '36' => 36,
                    '37' => 37,
                    '38' => 38,
                    '39' => 39
                ],
            ],
            'order' => 2,
        ]);

        // Question 40: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 40,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 40 on your answer sheet.<br><br>What is the main theme of the passage?',
            'options' => [
                'A' => 'people have the right to doubt science and technologies',
                'B' => 'the precautionary principle could have prevented the development of science and technology',
                'C' => 'there are not enough people who truly understand the precautionary principle',
                'D' => 'the precautionary principle bids us take risks at all costs'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 39,
                'sub_questions' => [
                    ['id' => '40', 'label' => 'What is the main theme of the passage?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 3,
        ]);

    }
}
