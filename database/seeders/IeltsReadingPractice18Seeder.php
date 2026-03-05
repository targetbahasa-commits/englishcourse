<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice18Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 18;

        // Clean up any existing records for this material
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // --- PASSAGE 1 ---
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'California’s age of Megafires',
            'content' => '
<p><strong>A</strong></p>
<p>There’s a reason fire squads now battling more than a dozen blazes in southern California are having such difficulty containing the flames, despite better preparedness than ever and decades of experience fighting fires fanned by the notorious Santa Ana winds. The wildfires themselves, experts say, generally are hotter, move faster, and spread more erratically than in the past.</p>

<p><strong>B</strong></p>
<p>The short-term explanation is that the region, which usually has dry summers, has had nine inches less rain than normal this year. Longer-term, climate change across the West is leading to hotter days on average and longer fire seasons. Experts say this is likely to yield more megafires like the conflagrations that this week forced evacuations of at least 300,000 resident in California’s southland and led President Bush to declare a disaster emergency in seven counties on Tuesday.</p>

<p><strong>C</strong></p>
<p>Megafires, also called “siege fires,” are the increasingly frequent blazes that burn 500,000 acres or more – 10 times the size of the average forest fire of 20 years ago. One of the current wildfires is the sixth biggest in California ever, in terms of acreage burned, according to state figures and news reports. The trend to more superhot fires, experts say, has been driven by a century-long policy of the US Forest Service to stop wildfires as quickly as possible. The unintentional consequence was to halt the natural eradication of underbrush, now the primary fuel for megafires. Three other factors contribute to the trend, they add. First is climate change marked by a 1-degree F. rise in average yearly temperature across the West. Second is a fire season that on average is 78 days longer than in the late 1980s. The third is the increased building of homes and other structures in wooded areas.</p>

<p><strong>D</strong></p>
<p>“We are increasingly building our homes … in fire-prone ecosystems,” says Dominik Kulakowski, adjunct professor of biology at Clark University Graduate School of Geography in Worcester, Mass. Doing that “in many of the forests of the Western US … is like building homes on the side of an active volcano.” In California, where population growth has averaged more than 600,000 a year for at least a decade, housing has pushed into such areas. “What once was open space is now residential homes providing fuel to make fires burn with greater intensity,” says Terry McHale of the California Department of Forestry firefighters union. “With so much dryness, so many communities to catch fire, so many fronts to fight, it becomes an almost incredible job.”</p>

<p><strong>E</strong></p>
<p>That said, many experts give California high marks for making progress on preparedness since 2003, when the largest fires in state history scorched 750,000 acres, burned 3,640 homes, and killed 22 people. Stung then by criticism of bungling that allowed fires to spread when they might have been contained, personnel are meeting the peculiar challenges of a neighborhood – and canyon-hopping fires better than in recent years, observers say.</p>

<p><strong>F</strong></p>
<p>State promises to provide newer engines, planes, and helicopters have been fulfilled. Firefighters unions that then complained of dilapidated equipment, old fire engines and insufficient blueprints for fire safety are now praising the state’s commitment, noting that funding for firefighting has increased despite huge cuts in many other programs. “We are pleased that the Schwarzenegger administration has been very proactive in its support of us and come through with budgetary support of the infrastructure needs we have long sought,” says Mr McHale with the firefighters union.</p>

<p><strong>G</strong></p>
<p>Besides providing money to upgrade the fire engines that must traverse the mammoth state and wind along serpentine canyon roads, the state has invested in better command-and-control facilities as well as the strategies to run them. “In the fire sieges of earlier years, we found out that we had the willingness of mutual-aid help from other jurisdictions and states, but we were not able to communicate adequately with them,” says Kim Zagaris, chief of the state’s Office of Emergency Services, fire and rescue branch. After a 2004 blue-ribbon commission examined and revamped those procedures, the statewide response “has become far more professional and responsive,” he says.</p>

<p><strong>H</strong></p>
<p>Besides ordering the California National Guard on Monday to make 1,500 guardsmen available for firefighting efforts, Gov. Arnold Schwarzenegger asked the Pentagon to send all available Modular Airborne Fighting Systems to the area. The military Lockheed C-130 cargo/utility aircraft carry a pressurized 3,000-gallon tank that can eject fire retardant or water in fewer than five seconds through two tubes at the rear of the plane. This load can cover an area 1/4-mile long and 60 feet wide to create a fire barrier. Governor Schwarzenegger also directed 2,300 inmate firefighters and 170 custody staff from the California Department of Corrections and Rehabilitation to work for hand in hand with state and local firefighters.</p>

<p><strong>I</strong></p>
<p>Residents and government officials alike are noting the improvements with gratitude, even amid the loss of homes, churches, businesses, and farms. By Tuesday morning, the fires had burned 1,200 homes and businesses and set 245,957 acres – 384 square miles – ablaze. Despite such losses, there is a sense that the speed, dedication, and coordination of firefighters from several states and jurisdictions are resulting in greater efficiency than in past “siege fire” situations.</p>

<p><strong>J</strong></p>
<p>“I am extraordinarily impressed by the improvements we have witnessed between the last big fire and this,” says Ross Simmons, a San Diego-based lawyer who had to evacuate both his home and business on Monday, taking up residence at a Hampton Inn 30 miles south of his home in Rancho Bernardo. After fires consumed 172,000 acres there in 2003, the San Diego region turned communitywide soul-searching into improved building codes, evacuation procedures, and procurement of new technology. Mr Simmons and neighbors began receiving automated phone calls at 3:30 a.m. Monday morning telling them to evacuate. “Notwithstanding all the damage that will be caused by this, we will not come close to the loss of life because of what we have … put in place since then,” he says.</p>',
            'order' => 1,
        ]);

        // Questions 1-6: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '1' => 'spread',
                '2' => 'rain', // The answer key says rain/rainfall, we will use rain
                '3' => 'climate change',
                '4' => '10 times',
                '5' => 'primary fuel',
                '6' => 'fire season',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'instruction' => 'Complete the following summary of the paragraphs of Reading Passage<br>Using <strong>NO MORE THAN TWO WORDS</strong> from the Reading Passage for each answer.<br>Write your answers in boxes 1-6 on your answer sheet.',
                'summary_text' => 'Experts point out that blazes in California are having more heat, faster speed and they <strong>[1]</strong> more unpredictably compared with former ones. One explanation is that California’s summer is dry, <strong>[2]</strong> is below the average point. Another long term explanation is that hotter and longer potential days occur due to <strong>[3]</strong>. Nowadays, Megafires burn <strong>[4]</strong> the size of forest area caused by an ordinary fire of 20 years ago. The serious trend is mainly caused by well-grown underbrush, which provides <strong>[5]</strong> for the siege fires. Other contributors are climate change and extended <strong>[6]</strong>.',
                'placeholders' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6
                ],
            ],
            'order' => 1,
        ]);

        // Questions 7-9: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 7,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 7-9 on your answer sheet.<br><br>What is the expert’s attitude towards California’s performance after 2003 megafire?',
            'options' => [
                'A' => 'They could have done better',
                'B' => 'Blamed them on casualties',
                'C' => 'Improvement made on preparation',
                'D' => 'Serious criticism'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 6,
                'sub_questions' => [
                    ['id' => '7', 'label' => 'What is the expert’s attitude towards California’s performance after 2003 megafire?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 2,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 8,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Schwarzenegger requested successfully for military weapons',
                'B' => 'Schwarzenegger led many prison management staff to work together with local firefighters',
                'C' => 'Schwarzenegger acted negatively in recent megafire in California',
                'D' => 'Schwarzenegger ordered 1,500 office clerk to join firefighting scene.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 7,
                'sub_questions' => [
                    ['id' => '8', 'label' => 'According to Governor Schwarzenegger, which one is CORRECT about his effort for firefighting?', 'correct_answer' => 'B']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 9,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'He was sleeping till morning',
                'B' => 'He was doing business at Hampton Inn',
                'C' => 'He suffered employee death on that morning',
                'D' => 'He was alarmed by machine calls'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 8,
                'sub_questions' => [
                    ['id' => '9', 'label' => 'What happened to Ross Simmon on the day of megafire breakout?', 'correct_answer' => 'D']
                ]
            ],
            'order' => 4,
        ]);

        // Questions 10-13: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 10,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 1?<br>In boxes 10-13 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 9,
                'sub_questions' => [
                    ['id' => '10', 'label' => 'The area of open space in California has declined during the past decade.', 'correct_answer' => 'TRUE'],
                    ['id' => '11', 'label' => 'Fire squad wants to recruit more firefighters this year.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '12', 'label' => 'Firefighters union declared that firefighters have had the more improved and supportive facility by the local government.', 'correct_answer' => 'TRUE'],
                    ['id' => '13', 'label' => 'Before the year of 2004, well coordination and communication between California and other states already existed in fire siege.', 'correct_answer' => 'FALSE'],
                ]
            ],
            'order' => 5,
        ]);


        // --- PASSAGE 2 ---
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Ancient Storytelling',
            'content' => '
<p><strong>A</strong></p>
<p>It was told, we suppose, to people crouched around a fire: a tale of adventure, most likely-relating some close encounter with death; a remarkable hunt, an escape from mortal danger; a vision, or something else out of the ordinary. Whatever its thread, the weaving of this story was done with a prime purpose. The listeners must be kept listening. They must not fall asleep. So, as the story went on, its audience should be sustained by one question above all. What happens next?</p>

<p><strong>B</strong></p>
<p>The first fireside stories in human history can never be known. They were kept in the heads of those who told them. This method of storage is not necessarily inefficient. From documented oral traditions in Australia, the Balkans and other parts of the world we know that specialised storytellers and poets can recite from memory literally thousands of lines, in verse or prose, verbatim-word for word. But while memory is rightly considered an art in itself, it is clear that a primary purpose of making symbols is to have a system of reminders or mnemonic cues – signs that assist us to recall certain information in the mind’s eye.</p>

<p><strong>C</strong></p>
<p>In some Polynesian communities, a notched memory stick may help to guide a storyteller through successive stages of recitation. But in other parts of the world, the activity of storytelling historically resulted in the development or even the invention of writing systems. One theory about the arrival of literacy in ancient Greece, for example, argues that the epic tales about the Trojan War and the wanderings of Odysseus – traditionally attributed to Homer – were just so enchanting to hear that they had to be preserved. So the Greeks, c.750-700BC, borrowed an alphabet from their neighbors in the eastern Mediterranean, the Phoenicians.</p>

<p><strong>D</strong></p>
<p>The custom of recording stories on parchment and other materials can be traced in many manifestations around the world, from the priestly papyrus archives of ancient Egypt to the birch-bark scrolls on which the North American Ojibway Indians set down their creation-myth. It is a well-tried and universal practice: so much so that to this day storytime is probably most often associated with words on paper. The formal practice of narrating a story aloud would seem-so we assume to have given way to newspapers, novels and comic strips. This, however, is not the case. Statistically, it is doubtful that the majority of humans currently rely upon the written word to get access to stories. So what is the alternative source?</p>

<p><strong>E</strong></p>
<p>Each year, over 7 billion people will go to watch the latest offering from Hollywood, Bollywood and beyond. The supreme storyteller of today is cinema. The movies, as distinct from still photography, seem to be an essential modem phenomenon. This is an illusion, for there are, as we shall see, certain ways in which the medium of film is indebted to very old precedents of arranging ‘sequences’ of images. But any account of visual storytelling must be with the recognition that all storytelling beats with a deeply atavistic pulse: that is, a ‘good story’ relies upon formal patterns of plot and characterisation that have been embedded in the practice of storytelling over many generations.</p>

<p><strong>F</strong></p>
<p>Thousands of scripts arrive every week at the offices of the major film studios. But aspiring screenwriters really need to look no further for essential advice then the fourth-century BC Greek Philosopher Aristotle. He left some incomplete lecture notes on the art of telling stories in various literary and dramatic modes, a slim volume known as The Poetics. Though he can never have envisaged the popcorn-fuelled actuality of a multiplex cinema, Aristotle is almost prescient about the key elements required to get the crowds flocking to such a cultural hub. He analyzed the process with cool rationalism. When a story enchants us, we lose the sense of where we are; we are drawn into the story so thoroughly that we forget it is a story being told. This is, in Aristotle’s phrase, ‘the suspension of disbelief\'.</p>

<p><strong>G</strong></p>
<p>We know the feeling. If ever we have stayed in our seats, stunned with grief, as the credits roll by, or for days after seeing that vivid evocation of horror have been nervous about taking a shower at home, then we have suspended disbelief. We have been caught, or captivated, in the storyteller’s web. Did it all really happen? We really thought so for a while. Aristotle must have witnessed often enough this suspension of disbelief. He taught at Athens, the city where theater developed as a primary form of civic ritual and recreation. Two theatrical types of storytelling, tragedy and comedy, caused Athenian audiences to lose themselves in sadness and laughter respectively. Tragedy, for Aristotle, was particularly potent in its capacity to enlist and then purge the emotions of those watching the story unfold on the stage, so he tried to identify those factors in the storyteller’s art that brought about such engagement. He had, as an obvious sample for analysis, not only the fifth-century BC masterpieces of Classical Greek tragedy written by Aeschylus, Sophocles and Euripides. Beyond them stood Homer, whose stories even then had canonical status: The Iliad and The Odyssey were already considered literary landmarks-stories by which all other stories should be measured. So what was the secret of Homer’s narrative art?</p>

<p><strong>H</strong></p>
<p>It was not hard to find. Homer created credible heroes. His heroes belonged to the past, they were mighty and magnificent, yet they were not, in the end, fantasy figures. He made his heroes sulk, bicker, cheat and cry. They were, in short, characters – protagonists of a story that an audience would care about, would want to follow, would want to know what happens next. As Aristotle saw, the hero who shows a human side-some flaw or weakness to which mortals are prone-is intrinsically dramatic.</p>',
            'order' => 2,
        ]);

        // Questions 14-18: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'type' => 'matching_paragraph_information',
            'question_text' => 'Which paragraph contains the following information?<br>Write the correct letter A-H, in boxes 14-18 on your answer sheet.',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E',
                'F' => 'Paragraph F',
                'G' => 'Paragraph G',
                'H' => 'Paragraph H',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 13,
                'sub_questions' => [
                    ['id' => '14', 'label' => 'A misunderstanding of a modern way for telling stories', 'correct_answer' => 'E'],
                    ['id' => '15', 'label' => 'The typical forms mentioned for telling stories', 'correct_answer' => 'G'],
                    ['id' => '16', 'label' => 'The fundamental aim of storytelling', 'correct_answer' => 'A'],
                    ['id' => '17', 'label' => 'A description of reciting stories without any assistance', 'correct_answer' => 'B'],
                    ['id' => '18', 'label' => 'How to make story characters attractive', 'correct_answer' => 'H'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 19-22: Matching Features
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 19,
            'type' => 'matching_features',
            'question_text' => 'Classify the following information as referring to<br>Write the correct letter, A, B or C in boxes 19-22 on your answer sheet.',
            'options' => [
                'A' => 'adopted the writing system from another country',
                'B' => 'used organic materials to record stories',
                'C' => 'used tools to help to tell stories'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of options',
                'start_number' => 18,
                'sub_questions' => [
                    ['id' => '19', 'label' => 'Egyptians', 'correct_answer' => 'B'],
                    ['id' => '20', 'label' => 'Ojibway', 'correct_answer' => 'B'],
                    ['id' => '21', 'label' => 'Polynesians', 'correct_answer' => 'C'],
                    ['id' => '22', 'label' => 'Greek', 'correct_answer' => 'A'],
                ]
            ],
            'order' => 2,
        ]);

        // Questions 23-26: Short Answer
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 23,
            'type' => 'short_answer_group',
            'question_text' => 'Complete the sentences below with <strong>ONE WORD ONLY</strong> from the passage.<br>Write your answer in boxes 23-26 on your answer sheet.',
            'options' => null,
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 22,
                'sub_questions' => [
                    ['id' => '23', 'label' => 'Aristotle wrote a book on the art of storytelling called', 'correct_answer' => 'the Poetics'],
                    ['id' => '24', 'label' => 'Aristotle believed the most powerful type of story to move listeners is', 'correct_answer' => 'tragedy'],
                    ['id' => '25', 'label' => 'Aristotle viewed Homers works as', 'correct_answer' => 'landmarks'],
                    ['id' => '26', 'label' => 'Aristotle believed attractive heroes should have some', 'correct_answer' => 'flaw/weakness'], // user gave flaw/weakness in image
                ]
            ],
            'order' => 3,
        ]);


        // --- PASSAGE 3 ---
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Paper of Computer?',
            'content' => '
<p><strong>A</strong></p>
<p>Computer technology was supposed to replace paper. But that hasn’t happened. Every country in the Western world uses more paper today, on a per-capita basis, than it did ten years ago. The consumption of uncoated free-sheet paper, for instance – the most common kind of office paper – rose almost fifteen per cent in the United States between 1995 and 2000. This is generally taken as evidence of how hard it is to eradicate old, wasteful habits and of how stubbornly resistant we are to the efficiencies offered by computerization. A number of cognitive psychologists and ergonomics experts, however, don’t agree. Paper has persisted, they argue, for very good reasons: when it comes to performing certain kinds of cognitive tasks, the paper has many advantages over computers. The dismay people feel at the sight of a messy desk – or the spectacle of air-traffic controllers tracking flights through notes scribbled on paper strips – arises from a fundamental confusion about the role that paper plays in our lives.</p>

<p><strong>B</strong></p>
<p>The case for paper is made most eloquently in “The Myth of the Paperless Office”, by two social scientists, Abigail Sellen and Richard Harper. They begin their book with an account of a study they conducted at the International Monetary Fund, in Washington, D.C. Economists at the I.M.F. spend most of their time writing reports on complicated economic questions, work that would seem to be perfectly suited to sitting in front of a computer. Nonetheless, the I.M.F. is awash in paper, and Sellen and Harper wanted to find out why. Their answer is that the business of writing reports – at least at the I.M.F. – is an intensely collaborative process, involving the professional judgments and contributions of many people. The economists bring drafts of reports to conference rooms, spread out the relevant pages, and negotiate changes with one other. They go back to their offices and jot down comments in the margin, taking advantage of the freedom offered by the informality of the handwritten note. Then they deliver the annotated draft to the author in person, taking him, page by page, through the suggested changes. At the end of the process, the author spreads out all the pages with comments on his desk and starts to enter them on the computer – moving the pages around as he works, organizing and reorganizing, saving and discarding.</p>

<p><strong>C</strong></p>
<p>Without paper, this kind of collaborative and iterative work process would be much more difficult. According to Sellen and Harper, the paper has a unique set of “affordances” – that is, qualities that permit specific kinds of uses. Paper is tangible: we can pick up a document, flip through it, read little bits here and there, and quickly get a sense of it. Paper is spatially flexible, meaning that we can spread it out and arrange it in the way that suits us best. And it’s tailorable: we can easily annotate it, and scribble on it as we read, without altering the original text. Digital documents, of course, have their own affordances. They can be easily searched, shared, stored, accessed remotely, and linked to other relevant material. But they lack the affordances that really matter to a group of people working together on a report. Sellen and Harper write:</p>

<p><strong>D</strong></p>
<p>Paper enables a certain kind of thinking. Picture, for instance, the top of your desk. Chances are that you have a keyboard and a computer screen off to one side, and a clear space roughly eighteen inches square in front of your chair. What covers the rest of the desktop is probably piles – piles of papers, journals, magazines, binders, postcards, videotapes, and all the other artefacts of the knowledge economy. The piles look like a mess, but they aren’t. When a group at Apple Computer studied piling behavior several years ago, they found that even the most disorderly piles usually make perfect sense to the piler, and that office workers could hold forth in great detail about the precise history and meaning of their piles. The pile closest to the cleared, eighteen-inch-square working area, for example, generally represents the most urgent business, and within that pile, the most important document of all is likely to be at the top. Piles are living, breathing archives. Over time, they get broken down and resorted, sometimes chronologically and sometimes thematically and sometimes chronologically and thematically; clues about certain documents may be physically embedded in the file by, say, stacking a certain piece of paper at an angle or inserting dividers into the stack.</p>

<p><strong>E</strong></p>
<p>But why do we pile documents instead o filing them? Because piles represent the process of active, ongoing thinking. The psychologists Alison Kidd, whose research Sellen and Harper refer to extensively, argues that “knowledge workers” use the physical space of the desktop to hold “ideas which they cannot yet categorize or even decide how they might use.” The messy desk is not necessarily a sign of disorganization. It may be a sign of complexity: those who deal with many unresolved ideas simultaneously cannot sort and file the papers on their desks, because they haven’t yet sorted and filed the ideas in their head. Kidd writes that many of the people she talked to use the papers on their desks as contextual cues to “recover a complex set of threads without difficulty and delay” when they come in on a Monday morning, or after their work has been interrupted by a phone call. What we see when we look at the piles on our desks is, in a sense, the contents of our brains.</p>

<p><strong>F</strong></p>
<p>This idea that paper facilitates a highly specialized cognitive and social process is a far cry from the way we have historically thought about the stuff. Paper first began to proliferate in the workplace in the late nineteenth century as part of the move toward “systematic management.” To cope with the complexity of the industrial economy, managers were instituting company-wide policies and demanding monthly weekly, or even daily updates from their subordinates. Thus was born the monthly sales report, and the office manual and the internal company newsletter. The typewriter took off in the eighteen-eighties, making it possible to create documents in a fraction of the time it had previously taken, and that was followed closely by the advent of carbon paper, which meant that a typist could create ten copies of that document simultaneously. Paper was important not to facilitate creative collaboration and thought but as an instrument of control.</p>',
            'order' => 3,
        ]);

        // Questions 27-32: Matching Headings
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'type' => 'matching_headings',
            'question_text' => 'Choose the correct heading for paragraphs A-F from the list below.<br>Write the correct number, i-x, in boxes 27-32 on your answer sheet.',
            'options' => [
                'i' => 'paper continued as a sharing or managing must',
                'ii' => 'piles can be more inspiring rather than disorganising',
                'iii' => 'Favorable situations that economists used paper pages',
                'iv' => 'overview of an unexpected situation: paper survived',
                'v' => 'comparison between efficiencies for using paper and using computer',
                'vi' => 'IMF’s paperless office seemed to be a waste of papers',
                'vii' => 'example of failure for the avoidance of paper record',
                'viii' => 'There are advantages of using a paper in offices',
                'ix' => 'piles reflect certain characteristics in people’s thought',
                'x' => 'joy of having the paper square in front of a computer'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of headings',
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => 'Paragraph A', 'correct_answer' => 'iv'],
                    ['id' => '28', 'label' => 'Paragraph B', 'correct_answer' => 'iii'],
                    ['id' => '29', 'label' => 'Paragraph C', 'correct_answer' => 'viii'],
                    ['id' => '30', 'label' => 'Paragraph D', 'correct_answer' => 'ii'],
                    ['id' => '31', 'label' => 'Paragraph E', 'correct_answer' => 'ix'],
                    ['id' => '32', 'label' => 'Paragraph F', 'correct_answer' => 'i'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 33-36: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 33,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '33' => 'collaborative and iterative',
                '34' => 'tangible',
                '35' => 'tailorable',
                '36' => 'group of people',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 32,
                'instruction' => 'Complete the following summary of the paragraphs of Reading Passage.<br>Using <strong>NO MORE THAN THREE WORDS</strong> from the Reading Passage for each answer.<br>Write your answers in boxes 33-36 on your answer sheet.',
                'summary_text' => 'Compared with digital documents, the paper has several advantages. First, it allows clerks to work in a <strong>[33]</strong> way among colleagues. Next, the paper is not like the virtual digital version, it’s <strong>[34]</strong>. Finally, because it is <strong>[35]</strong>, note or comments can be effortlessly added as related information. However, shortcoming comes at the absence of convenience on a task which is for a <strong>[36]</strong>.',
                'placeholders' => [
                    '33' => 33,
                    '34' => 34,
                    '35' => 35,
                    '36' => 36
                ],
            ],
            'order' => 2,
        ]);

        // Questions 37-40: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 37,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 37-40 on your answer sheet.<br><br>What do the economists from IMF say that their way of writing documents?',
            'options' => [
                'A' => 'they note down their comments for freedom on the drafts',
                'B' => 'they finish all writing individually',
                'C' => 'they share ideas on before electronic version was made',
                'D' => 'they use electronic version fully'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 36,
                'sub_questions' => [
                    ['id' => '37', 'label' => 'What do the economists from IMF say that their way of writing documents?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 38,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'they have underlying orders',
                'B' => 'they are necessarily a mess',
                'C' => 'they are in time sequence order',
                'D' => 'they are in alphabetic order'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 37,
                'sub_questions' => [
                    ['id' => '38', 'label' => 'What is the implication of the “Piles” mentioned in the passage?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 4,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 39,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'recorded paper can be a management tool',
                'B' => 'carbon paper should be compulsory',
                'C' => 'Teamwork is the most important',
                'D' => 'monthly report is the best way'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 38,
                'sub_questions' => [
                    ['id' => '39', 'label' => 'What does the manager believe in a sophisticated economy?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 5,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 40,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'paper is inexpensive to buy',
                'B' => 'it contributed to management theories in western countries',
                'C' => 'people need time for changing their old habit',
                'D' => 'it is collaborative and functional for tasks implement and management'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 39,
                'sub_questions' => [
                    ['id' => '40', 'label' => 'According to the end of this passage, what is the reason why the paper is not replaced by electronic vision?', 'correct_answer' => 'D']
                ]
            ],
            'order' => 6,
        ]);

    }
}
