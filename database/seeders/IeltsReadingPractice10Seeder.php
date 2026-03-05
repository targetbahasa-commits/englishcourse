<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice10Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materialId = 10;

        // Clean up existing data for this practice test
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->pluck('id');
        \App\Models\IeltsReadingQuestion::whereIn('passage_id', $existingPassages)->delete();
        \App\Models\IeltsReadingPassage::where('material_id', $materialId)->delete();


        // ==========================================
        // PASSAGE 1: Copy your neighbour
        // ==========================================
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Copy your neighbour',
            'content' => '
<p><strong>A</strong> THERE’S no animal that symbolises rainforest diversity quite as spectacularly as the tropical butterfly. Anyone lucky enough to see these creatures flitting between patches of sunlight cannot fail to be impressed by the variety of their patterns. But why do they display such colourful exuberance? Until recently, this was almost as pertinent a question as it had been when the 19th-century naturalists, armed only with butterfly nets and insatiable curiosity, battle through the rainforests. These early explorers soon realised that although some of the butterflies’ bright colours are there to attract a mate, others are warning signals. They send out a message to any predators: “Keep off, we’re poisonous.” And because wearing certain patterns affords protection, other species copy them. Biologists use the term “mimicry rings” for these clusters of impostors and their evolutionary idol.</p>

<p><strong>B</strong> But here’s the conundrum. “Classical mimicry theory says that only a single ring should be found in any one area,” explains George Beccaloni of the Natural History Museum, London. The idea is that in each locality there should be just the one pattern that best protects its wearers. Predators would quickly learn to avoid it and eventually, all mimetic species in a region should converge upon it. “The fact that this is patently not the case has been one of the major problems in mimicry research,” says Beccaloni. In pursuit of a solution to the mystery of mimetic exuberance, Beccaloni set off for one of the mega centres for butterfly diversity, the point where the western edge of the Amazon basin meets the foothills of the Andes in Ecuador. “It’s exceptionally rich, but comparatively well collected, so I pretty much knew what was there, says Beccaloni.” The trick was to work out how all the butterflies were organised and how this related to mimicry.</p>

<p><strong>C</strong> Working at the Jatun Sach Biological Research Station on the banks of the Rio Napo, Beccaloni focused his attention on a group of butterflies called ithomiines. These distant relatives of Britain’s Camberwell Beauty are abundant throughout Central and South America and the Caribbean. They are famous for their bright colours, toxic bodies and complex mimetic relationships. “They can comprise up to 85 per cent of the individuals in a mimicry ring and their patterns are mimicked not just by butterflies, but by other insects as diverse as damselflies and true bugs,” says Philip DeVries of the Milwaukee Public Museum’s Center for Biodiversity Studies.</p>

<p><strong>D</strong> Even though all ithomiines are poisonous, it is in their interests to evolve to look like one another because predators that learn to avoid one species will also avoid others that resemble it. This is known as Müllerian mimicry. Mimicry rings may also contain insects that are not toxic but gain protection by looking likes a model species that is: an adaptation called Batesian mimicry. So strong is an experienced predator’s avoidance response that even quite inept resemblance gives some protection. “Often there will be a whole series of species that mimic, with varying degrees of verisimilitude, a focal or model species,” says John Turner from the University of Leeds. “The results of these deceptions are some of the most exquisite examples of evolution known to science.” In addition to colour, many mimics copy behaviours and even the flight pattern of their model species.</p>

<p><strong>E</strong> But why are there so many different mimicry rings? One idea is that species flying at the same height in the forest canopy evolve to look like one another. “It had been suggested since the 1970s that mimicry complexes were stratified by flight height,” says DeVries. The idea is that wing colour patterns are camouflaged against the different patterns of light and shadow at each level in the canopy, providing the first line of defence against predators.” But the light patterns and wing patterns don’t match very well,” he says. And observations show that the insects do not shift in height as the day progresses and the light patterns change. Worse still, according to DeVries, this theory doesn’t explain why the model species is flying at that particular height in the first place.</p>

<p><strong>F</strong> “When I first went out to Ecuador, I didn’t believe the flight height hypothesis and set out to test it,” says Beccaloni. “A few weeks with the collecting net convinced me otherwise. They really flew that way.” What he didn’t accept, however, was the explanation about light patterns. “I thought if this idea really is true, can I can work out why it could help explain why there are so many different warning patterns in any not place. Then we might finally understand how they could evolve in such a complex way.” The job was complicated by the sheer diversity of species involved at Jatun Sach. Not only were there 56 ithomiine butterfly species divided among eight mimicry rings, but there were also 69 other insect species, including 34 day-flying moths and a damselfly, all in a 200-hectare study area. Like many entomologists before him, Beccaloni used a large bag-like net to capture his prey. This allowed him to sample the 2.5 metres immediately above the forest floor. Unlike many previous workers, he kept very precise notes on exactly where he caught his specimens.</p>

<p><strong>G</strong> The attention to detail paid off. Beccaloni found that the mimicry rings were flying at two quite separate altitudes. “Their use of the forest was quite distinctive,” he recalls. “For example, most members of the clear-winged mimicry ring would fly close to the forest floor, while the majority of the 12 species in the tiger-winged ring fly high up.” Each mimicry wing had its own characteristic flight height.</p>

<p><strong>H</strong> However, this being practice rather than theory, things were a bit fuzzy. “They’d spend the majority of their time flying at a certain height. But they’d also spend a smaller proportion of their time flying at other heights,” Beccaloni admits. Species weren’t stacked rigidly like passenger jets waiting to land, but they did appear to have preferred airspace in the forest. So far, so good, but he still hadn’t explained what causes the various groups of ithomiines and their chromatic consorts to fly in formations at these particular heights.</p>

<p><strong>I</strong> Then Beccaloni had a bright idea. “I started looking at the distribution of ithomiine larval food plants within the canopy,” he says. “For each one, I’d record the height to which the host plant grew and the height above the ground at which the eggs or larvae were found. Once I got them back to the field station’s lab, it was just a matter of keeping them alive until they pupated and then hatched into adults which I could identify.”</p>
            ',
            'order' => 1
        ]);

        // Questions 1-5: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'The reading Passage has seven paragraphs A-I. Which paragraph contains the following information?<br>NB You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'Criticism against flight height theory of butterfly', 'text' => 'Criticism against flight height theory of butterfly', 'correct_answer' => 'E'],
                    ['id' => '2', 'label' => 'Explained why Beccaloni carried out research in Ecuador.', 'text' => 'Explained why Beccaloni carried out research in Ecuador.', 'correct_answer' => 'B'],
                    ['id' => '3', 'label' => 'Different mimicry ring flies at different height', 'text' => 'Different mimicry ring flies at different height', 'correct_answer' => 'G'],
                    ['id' => '4', 'label' => 'The method of catching butterfly by Beccaloni', 'text' => 'The method of catching butterfly by Beccaloni', 'correct_answer' => 'F'],
                    ['id' => '5', 'label' => 'Not all Mimicry patterns are toxic information sent out from insects.', 'text' => 'Not all Mimicry patterns are toxic information sent out from insects.', 'correct_answer' => 'D'],
                ]
            ],
        ]);

        // Questions 6-11: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 6,
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 1?<br>Write TRUE if the statement agrees with the information, FALSE if the statement contradicts the information, or NOT GIVEN if there is no information on this.',
            'type' => 'true_false_not_given',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 5,
                'sub_questions' => [
                    ['id' => '6', 'label' => '6. All butterflies’ colours of wings reflect the sense of warning to other predators.', 'correct_answer' => 'FALSE'],
                    ['id' => '7', 'label' => '7. Insects may imitate butterflies’ wing pattern as well.', 'correct_answer' => 'TRUE'],
                    ['id' => '8', 'label' => '8. Flying Altitude of the butterfly is determined by their food.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '9', 'label' => '9. Beccaloni agreed with the flight height hypothesis and decided to reassure its validity.', 'correct_answer' => 'FALSE'],
                    ['id' => '10', 'label' => '10. Jatun Sacha has the richest diversity of breeds in the world.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '11', 'label' => '11. Beccaloni has more detailed records on the location of butterfly collection than others.', 'correct_answer' => 'TRUE'],
                ]
            ],
        ]);

        // Question 12
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 12,
            'question_text' => 'Which is correct about butterflies flight altitude?',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'Flight height theory already established',
                'B' => 'Butterfly always flies at a certain height',
                'C' => 'It is like the airplane’s flying phenomenon',
                'D' => 'Each butterfly has its own favorable height'
            ],
            'correct_answer' => 'D',
            'explanation' => 'Paragraph H states: "Species weren’t stacked rigidly like passenger jets waiting to land, but they did appear to have preferred airspace in the forest."',
            'data' => [
                'start_number' => 11,
                'sub_questions' => [
                    ['id' => '12', 'label' => '12. Which is correct about butterflies flight altitude?', 'correct_answer' => 'D']
                ]
            ]
        ]);

        // Question 13
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 13,
            'question_text' => 'Which is correct about Beccaloni next investigation after flight height?',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'Some certain statistics have already been collected',
                'B' => 'Try to find connections between larval height and adult ones',
                'C' => 'It’s very difficult to raise butterfly larval',
                'D' => 'Different larval favors different kinds of trees'
            ],
            'correct_answer' => 'B',
            'explanation' => 'Paragraph I states: "I started looking at the distribution of ithomiine larval food plants within the canopy... For each one, I’d record the height to which the host plant grew and the height above the ground at which the eggs or larvae were found."',
            'data' => [
                'start_number' => 12,
                'sub_questions' => [
                    ['id' => '13', 'label' => '13. Which is correct about Beccaloni next investigation after flight height?', 'correct_answer' => 'B']
                ]
            ]
        ]);


        // ==========================================
        // PASSAGE 2: European Heat Wave
        // ==========================================
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'European Heat Wave',
            'content' => '
<p><strong>A</strong> IT WAS the summer, scientists now realise, when felt. We knew that summer 2003 was remarkable; global warming, at last, made itself unmistakably Britain experienced its record high temperature and continental Europe saw forest fires raging out of control, great rivers drying of a trickle and thousands of heat-related deaths. But just how remarkable is only now becoming clean.</p>

<p><strong>B</strong> The three months of June, July and August were the warmest ever recorded in western and central Europe, with record national highs in Portugal, Germany and Switzerland as well as Britain. And they were the warmest by a very long way Over a great rectangular block of the earth stretching from west of Paris to northern Italy, taking in Switzerland and southern Germany, the average temperature for the summer months was 3.78°C above the long-term norm, said the Climatic Research Unit (CRU) of the University of East Anglia in Norwich, which is one of the world’s leading institutions for the monitoring and analysis of temperature records.</p>

<p><strong>C</strong> That excess might not seem a lot until you are aware of the context – but then you realise it is enormous. There is nothing like this in previous data, anywhere. It is considered so exceptional that Professor Phil Jones, the CRU’s director, is prepared to say openly – in a way few scientists have done before – that the 2003 extreme may be directly attributed, not to natural climate variability, but to global warming caused by human actions.</p>

<p><strong>D</strong> Meteorologists have hitherto contented themselves with the formula that recent high temperatures are consistent with predictions of climate. For the great block of the map – that stretching between 35-50N and 0-20E – the CRU has reliable temperature records dating back to 1781. Using as a baseline the average summer temperature recorded between 1961 and 1990, departures from the temperature norm, or ‘anomalies’: over the area as a whole can easily be plotted. As the graph shows, such as the variability of our climate that over the past 200 years, there have been at least half a dozen anomalies, in terms of excess temperature – the peaks on the graph denoting very hot years – approaching, or even exceeding, 20°C. But there has been nothing remotely like 2003 when the anomaly is nearly four degrees.</p>

<p><strong>E</strong> “This is quite remarkable,” Professor Jones told The Independent. “It’s very unusual in a statistical sense. If this series had a normal statistical distribution, you wouldn’t get this number. There turn period “how often it could be expected to recur” would be something like one in a thou-sand years. If we look at an excess above the average of nearly four degrees, then perhaps nearly three degrees of that is natural variability, because we’ve seen that in past summers. But the final degree of it is likely to be due to global warming, caused by human actions.</p>

<p><strong>F</strong> The summer of 2003 has, in a sense, been one that climate scientists have long been expecting. Until now, the warming has been manifesting itself mainly in winters that have been less cold than in summers that have been much hotter. Last week, the United Nations predicted that winters were warming so quickly that winter sports would die out in Europe’s lower-level ski resorts. But sooner or later the unprecedentedly hot summer was bound to come, and this year it did.</p>

<p><strong>G</strong> One of the most dramatic features of the summer was the hot nights, especially in the first half of August. In Paris, the temperature never dropped below 230°C (73.40°F) at all between 7 and 14 August, and the city recorded its warmest-ever night on 11-12 August, when the mercury did not drop below 25.50°C (77.90°F). Germany recorded its warmest-ever night at Weinbiet in the Rhine valley with the lowest figure of 27.60°C (80.60°F) on 13 August, and similar record-breaking night-time temperatures were recorded in Switzerland and Italy.</p>

<p><strong>H</strong> The 15,000 excess deaths in France during August, compared with previous years, have been related to the high night-time temperatures. The number gradually increased during the first 12 days of the month, peaking at about 2,000 per day on the night of 12-13 August, the fell off dramatically after 14 August when the minimum temperatures fell by about 50C. The elderly were most affected, with a 70 per cent increase in mortality rate in those aged 75-94.</p>

<p><strong>I</strong> For Britain, the year as a whole is likely to be the warmest ever recorded, but despite the high-temperature record on 10 August, the summer itself – defined as the June, July and August period – still comes behind 1976 and 1955, when there were long periods of intense heat. At the moment, the year is on course to be the third-hottest ever in the global temperature record, which goes back to 1856, behind 1988 and 2002 but when all the records for October, November and December are collated, it might move into second place, Professor Jones said. The 10 hottest years in the record have all now occurred since 1990. Professor Jones is in no doubt about the astonishing nature of the European summer of 2003. “The temperatures recorded were out of all proportion to the previous record,” he said. “It was the warmest summer in the past 500 years and probably way beyond what it was enormously exceptional.”</p>

<p><strong>J</strong> His colleagues at the University of East Anglia’s Tyndall Centre for Climate Change Research are now planning a special study of it. “It was a summer that has not: been experienced before, either in terms of the temperature extremes that were reached, or the range and diversity of the impacts of the extreme heat,” said the centre’s executive director, Professor Mike Hulme. “It will certainly have left its mark on a number of countries, as to how they think and plan for climate change in the future, much as the 2000 floods have revolutionised the way the Government is thinking about flooding in the UK. “The 2003 heatwave will have similar repercussions across Europe.”</p>
            ',
            'order' => 2
        ]);

        // Questions 14-19: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 2?<br>Write TRUE if the statement is true, FALSE if the statement is false, NOT GIVEN if the information is not given in the passage.',
            'type' => 'true_false_not_given',
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
                    ['id' => '14', 'label' => '14. The average summer temperature in 2003 is approximately four degrees higher than that of the past.', 'correct_answer' => 'TRUE'],
                    ['id' => '15', 'label' => '15. Jones believes the temperature statistic is within the normal range.', 'correct_answer' => 'FALSE'],
                    ['id' => '16', 'label' => '16. The human factor is one of the reasons that caused the hot summer.', 'correct_answer' => 'TRUE'],
                    ['id' => '17', 'label' => '17. In a large city, people usually measure temperature twice a day.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '18', 'label' => '18. Global warming has an obvious effect of warmer winter instead of hotter summer before 2003.', 'correct_answer' => 'TRUE'],
                    ['id' => '19', 'label' => '19. New ski resorts are to be built on a high-altitude spot.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ],
        ]);

        // Questions 20-21: Short Answer
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 20,
            'question_text' => 'Answer the questions below using NO MORE THAN THREE WORDS AND/OR NUMBERS from the passage for each answer.',
            'type' => 'short_answer_group',
            'options' => null,
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 19,
                'sub_questions' => [
                    ['id' => '20', 'label' => 'What are the two hottest years in Britain besides 2003?', 'text' => 'What are the two hottest years in Britain besides 2003?', 'correct_answer' => '1976 and 1995'],
                    ['id' => '21', 'label' => 'What will affect UK government policies besides climate change according to Hulme?', 'text' => 'What will affect UK government policies besides climate change according to Hulme?', 'correct_answer' => '2000 floods'],
                ]
            ]
        ]);

        // Questions 22-26: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 22,
            'question_text' => 'Complete the summary below using NO MORE THAN TWO WORDS from the passage.',
            'type' => 'sentence_completion',
            'options' => null,
            'correct_answer' => [
                '22' => 'France',
                '23' => '1856',
                '24' => '1998 and 2002',
                '25' => '1990',
                '26' => '500'
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 21,
                'summary_text' => 'In the summer of 2003, thousands of extra death occurred in the country of [22]. Moreover, world-widely, the third record of hottest summer date from [23], after the year of [24]. According to Jones, all the 10 hottest years happened from [25]. However, the summer of 2003 was at the peak of the previous [26] years, perhaps even more.',
                'placeholders' => [
                    '22' => 22,
                    '23' => 23,
                    '24' => 24,
                    '25' => 25,
                    '26' => 26
                ]
            ]
        ]);

        // Question 27: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 27,
            'question_text' => 'Which one can be best served as the title of this passage in the following options?',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'Global Warming effect',
                'B' => 'Global Warming in Europe',
                'C' => 'The Effects of hot temperature',
                'D' => 'Hottest summer in Europe'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => '27. Which one can be best served as the title of this passage in the following options?', 'correct_answer' => 'D']
                ]
            ]
        ]);


        // ==========================================
        // PASSAGE 3: E-training
        // ==========================================
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'E-training',
            'content' => '
<p><strong>A</strong> E-learning is the unifying term to describe the fields of online learning, web-based training, and technology-delivered instruction, which can be a great benefit to corporate e-learning. IBM, for instance, claims that the institution of its e-training program, Basic Blue, whose purpose is to train new managers, saved the company in the range of $200 million in 1999. Cutting the travel expenses required to bring employees and instructors to a central classroom account for the lion’s share of the savings. With an online course, employees can learn from any Internet-connected PC, anywhere in the world. Ernst and Young reduced training costs by 35 percent while improving consistency and scalability.</p>

<p><strong>B</strong> In addition to generally positive economic benefits, other advantages such as convenience, standardized delivery, self-paced learning, and a variety of available content, have made e-learning a high priority for many corporations. E-learning is widely believed to offer flexible “any time, any place” learning. The claim for “any place” is valid in principle and is a great development. Many people can engage with rich learning materials that simply were not possible in a paper of broadcast distance learning era. For teaching specific information and skills, e-training holds great promise. It can be especially effective at helping employees prepare for IT certification programs. E-learning also seems to effectively address topics such as sexual harassment education’, safety training and management training – all areas where a clear set of objectives can be identified. Ultimately, training experts recommend a “blended” approach that combines both online and in-person training as the instruction requires. E-learning is not an end-all solution. But if it helps decrease costs and windowless classrooms filled with snoring students, it definitely has its advantages.</p>

<p><strong>C</strong> Much of the discussion about implementing e-learning has focused on the technology, but as Driscoll and others have reminded us, e-learning is not just about the technology, but also many human factors. As any capable manager knows, teaching employees new skills is critical to a smoothly run business. Having said that, however, the traditional route of classroom instruction runs the risk of being expensive, slow and, oftentimes, ineffective. Perhaps the classroom’s greatest disadvantage is the fact that it takes employees out of their jobs. Every minute an employee is sitting in a classroom training session is a minute they’re not out on the floor working. It now looks as if there is a way to circumvent these traditional training drawbacks. E-training promises more effective teaching techniques by integrating audio, video, animation, text and interactive materials with the intent of teaching each student at his or her own pace. In addition to higher performance results, there are other immediate benefits to students such as increased time on task, higher levels of motivation, and reduced test anxiety for many learners.</p>

<p><strong>D</strong> On the other hand, nobody said E-training technology would be cheap. E-training service providers, on the average, charge from $10,000 to $60,000 to develop one hour of online instruction. This price varies depending on the complexity of the training topic and the media used. HTML pages are a little cheaper to develop while streaming-video presentations or flash animations cost more. Course content is just the starting place for the cost. A complete e-learning solution also includes the technology platform (the computers, applications and network connections that are used to deliver the courses). This technology platform, known as a learning management system (LMS), can either be installed onsite or outsourced. Add to that cost the necessary investments in network bandwidth to deliver multimedia courses, and you’re left holding one heck of a bill. For the LMS infrastructure and a dozen or so online courses, costs can top $500,000 in the first year. These kinds of costs mean that custom e-training is, for the time being, an option only for large organizations. For those companies that have a large enough staff, the e-training concept pays for itself. Aware of this fact, large companies are investing heavily in online training. Today, over half of the 400-plus courses that Rockwell Collins offers are delivered instantly to its clients in an e-learning format, a change that has reduced its annual training costs by 40%. Many other success stories exist.</p>

<p><strong>E</strong> E-learning isn’t expected to replace the classroom entirely. For one thing, bandwidth limitations are still an issue in presenting multimedia over the Internet. Furthermore, e-training isn’t suited to every mode of instruction or topic. For instance, it’s rather ineffective imparting cultural values or building teams. If your company has a unique corporate culture is would be difficult to convey that to first-time employees through a computer monitor. Group training sessions are more ideal for these purposes. In addition, there is a perceived loss of research time because of the work involved in developing and teaching online classes. Professor Wallin estimated that it required between 500 and 1,000 person-hours, that is, Wallin-hours, to keep the course at the appropriate level of currency and usefulness. (Distance learning instructors often need technical skills, no matter how advanced the courseware system.) That amounts to between a quarter and half of a person-year. Finally, teaching materials require computer literacy and access to equipment. Any e-Learning system involves basic equipment and a minimum level of computer knowledge in order to perform the tasks required by the system. A student that does not possess these skills, or have access to these tools, cannot succeed in an e-Learning program.</p>

<p><strong>F</strong> While few people debate the obvious advantages of e-learning, systematic research is needed to confirm that learners are actually acquiring and using the skills that are being taught online, and that e-learning is the best way to achieve the outcomes in a corporate environment. Nowadays, a go-between style of Blended learning, which refers to a mixing of different learning environments, is gaining popularity. It combines traditional face-to-face classroom methods with more modern computer-mediated activities. According to its proponents, the strategy creates a more integrated approach for both instructors and learners. Formerly, technology-based materials played a supporting role in face-to-face instruction. Through a blended learning approach, technology will be more important.</p>
            ',
            'order' => 3
        ]);

        // Questions 28-33: Matching Headings
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 28,
            'question_text' => 'The reading passage has six paragraphs, A-F. Choose the correct heading for paragraphs A-F from the list below.',
            'type' => 'matching_headings',
            'options' => [
                'i' => 'overview of the benefits for application of E-training',
                'ii' => 'IBM’s successful choice of training',
                'iii' => 'Future directions and a new style of teaching',
                'iv' => 'learners’ achievement and advanced teaching materials',
                'v' => 'limitations when E-training compares with traditional class',
                'vi' => 'multimedia over the Internet can be a solution',
                'vii' => 'technology can be a huge financial burden',
                'viii' => 'the distance learners outperformed the traditional university learners worldwide',
                'ix' => 'other advantages besides economic consideration',
                'x' => 'Training offered to help people learn using computers'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 27,
                'box_title' => 'List of Headings',
                'sub_questions' => [
                    ['id' => '28', 'label' => 'Paragraph A', 'correct_answer' => 'i'],
                    ['id' => '29', 'label' => 'Paragraph B', 'correct_answer' => 'ix'],
                    ['id' => '30', 'label' => 'Paragraph C', 'correct_answer' => 'iv'],
                    ['id' => '31', 'label' => 'Paragraph D', 'correct_answer' => 'vii'],
                    ['id' => '32', 'label' => 'Paragraph E', 'correct_answer' => 'v'],
                    ['id' => '33', 'label' => 'Paragraph F', 'correct_answer' => 'iii'],
                ]
            ]
        ]);

        // Questions 34-37: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 34,
            'question_text' => 'The reading Passage has six paragraphs A-F. Which paragraph contains the following information?<br>NB You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => ['A', 'B', 'C', 'D', 'E', 'F'],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 33,
                'sub_questions' => [
                    ['id' => '34', 'label' => '34. Projected Basic Blue in IBM achieved great success.', 'text' => 'Projected Basic Blue in IBM achieved great success.', 'correct_answer' => 'A'],
                    ['id' => '35', 'label' => '35. E-learning wins as a priority for many corporations as its flexibility.', 'text' => 'E-learning wins as a priority for many corporations as its flexibility.', 'correct_answer' => 'B'],
                    ['id' => '36', 'label' => '36. The combination of traditional and e-training environments may prevail.', 'text' => 'The combination of traditional and e-training environments may prevail.', 'correct_answer' => 'F'],
                    ['id' => '37', 'label' => '37. Example of fast electronic delivery for a company’s products to its customers.', 'text' => 'Example of fast electronic delivery for a company’s products to its customers.', 'correct_answer' => 'D'],
                ]
            ],
        ]);

        // Questions 38-40: Multiple Choice Multiple
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 38,
            'question_text' => 'Choose THREE correct letters, among A-E.',
            'type' => 'multiple_choice_multiple',
            'options' => [
                'A' => 'Technical facilities are hardly obtained.',
                'B' => 'Presenting multimedia over the Internet is restricted due to the bandwidth limit.',
                'C' => 'It is ineffective imparting a unique corporate value to fresh employees.',
                'D' => 'Employees need to block a long time leaving their position attending training.',
                'E' => 'More preparation time is needed to keep the course at a suitable level.'
            ],
            'correct_answer' => ['B', 'C', 'E'],
            'explanation' => null,
            'data' => [
               'start_number' => 37,
               'max_selections' => 3
            ]
        ]);

    }
}
