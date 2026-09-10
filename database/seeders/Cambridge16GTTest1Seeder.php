<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IeltsReadingPassage;
use App\Models\IeltsReadingQuestion;

class Cambridge16GTTest1Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 109; // Cambridge 16 General Training – Test 1

        // Clean up existing passages & questions for this material
        $existingPassages = IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // =====================================================================
        // PASSAGE 1 — Section 1, Part A: Helping pupils choose optional subjects
        // (Questions 1–6)
        // =====================================================================
        $passage1 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title'       => 'Section 1 — Helping pupils to choose optional subjects when they\'re aged 14–15: what some pupils say',
            'order'       => 1,
            'content'     => '
<div class="passage-section-banner">
    <span class="section-title">SECTION 1</span>
    <span class="section-questions">Questions 1–14</span>
</div>

<p class="passage-instruction">Read the text below and answer Questions 1–6.</p>

<h2 class="passage-main-title">Helping pupils to choose optional subjects when they\'re aged 14–15: what some pupils say</h2>

<p><strong style="color: #0056b3; font-size: 1.15rem; margin-right: 1.5rem;">A</strong> <strong style="color: #0056b3; font-size: 1.15rem;">Krishnan</strong><br>
I\'m studying Spanish, because it\'s important to learn foreign languages – and I\'m very pleased when I can watch a video in class and understand it. Mr Peckham really pushes us, and offers us extra assignments, to help us improve. That\'s good for me, because otherwise I\'d be quite lazy.</p>

<p><strong style="color: #0056b3; font-size: 1.15rem; margin-right: 1.5rem;">B</strong> <strong style="color: #0056b3; font-size: 1.15rem;">Lucy</strong><br>
History is my favourite subject, and it\'s fascinating to see how what we learn about the past is relevant to what\'s going on in the world now. It\'s made me understand much more about politics, for instance. My plan is to study history at university, and maybe go into the diplomatic service, so I can apply a knowledge of history.</p>

<p><strong style="color: #0056b3; font-size: 1.15rem; margin-right: 1.5rem;">C</strong> <strong style="color: #0056b3; font-size: 1.15rem;">Mark</strong><br>
Thursdays are my favourite days, because that\'s when we have computing. It\'s the high spot of the week for me – I love learning how to program. I began when I was about eight, so when I started doing it at school, I didn\'t think I\'d have any problem with it, but I was quite wrong! When I leave school, I\'m going into my family retail business, so sadly I can\'t see myself becoming a programmer.</p>

<p><strong style="color: #0056b3; font-size: 1.15rem; margin-right: 1.5rem;">D</strong> <strong style="color: #0056b3; font-size: 1.15rem;">Violeta</strong><br>
My parents both work in leisure and tourism, and they\'ve always talked about their work a lot at home. I find it fascinating. I\'m studying it at school, and the teacher is very knowledgeable, though I think we spend too much time listening to her: I\'d like to meet more people working in the sector, and learn from their experience.</p>

<p><strong style="color: #0056b3; font-size: 1.15rem; margin-right: 1.5rem;">E</strong> <strong style="color: #0056b3; font-size: 1.15rem;">Walid</strong><br>
I\'ve always been keen on art, so I chose it as an optional subject, though I was afraid the lessons might be a bit dull. I needn\'t have worried, though – our teacher gets us to do lots of fun things, so there\'s no risk of getting bored. At the end of the year the class puts on an exhibition for the school, and I\'m looking forward to showing some of my work to other people.</p>
',
        ]);

        // Questions 1–6: Matching Features (Pupils A–E)
        IeltsReadingQuestion::create([
            'passage_id'    => $passage1->id,
            'type'          => 'matching_features',
            'question_text' => 'Look at the five comments about lessons, <strong>A–E</strong>.<br>For which comments are the following statements true?<br>Write the correct letter, <strong>A–E</strong>, in boxes 1–6 on your answer sheet.<br><br><strong>NB</strong> &nbsp;You may use any letter more than once.',
            'options'       => json_encode([
                'A' => 'Krishnan',
                'B' => 'Lucy',
                'C' => 'Mark',
                'D' => 'Violeta',
                'E' => 'Walid',
            ]),
            'data'          => json_encode([
                'box_title'    => 'List of Pupils',
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'This pupil is interested in the subject despite the way it is taught.', 'correct_answer' => 'D'],
                    ['id' => '2', 'label' => 'This pupil is hoping to have a career that makes use of the subject.', 'correct_answer' => 'B'],
                    ['id' => '3', 'label' => 'This pupil finds the subject harder than they expected.', 'correct_answer' => 'C'],
                    ['id' => '4', 'label' => 'This pupil finds the lessons very entertaining.', 'correct_answer' => 'E'],
                    ['id' => '5', 'label' => 'This pupil appreciates the benefit of doing challenging work.', 'correct_answer' => 'A'],
                    ['id' => '6', 'label' => 'This pupil has realised the connection between two things.', 'correct_answer' => 'B'],
                ]
            ]),
            'order'         => 1,
        ]);


        // =====================================================================
        // PASSAGE 2 — Section 1, Part B: It's almost time for the next Ripton Festival!
        // (Questions 7–14)
        // =====================================================================
        $passage2 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title'       => 'Section 1 — It\'s almost time for the next Ripton Festival!',
            'order'       => 2,
            'content'     => '
<p class="passage-instruction">Read the text below and answer Questions 7–14.</p>

<h2 class="passage-main-title">It\'s almost time for the next Ripton Festival!</h2>

<p>As usual, the festival will be held in the last weekend of June, this year on Saturday to Monday, 27–29 June. Ever since last year\'s festival, the committee has been hard at work to make this year\'s the best ever! The theme is Ripton through the ages. Scenes will be acted out showing how the town has developed since it was first established. But there\'s also plenty that\'s up-to-date, from the latest music to local crafts.</p>

<p>The Craft Fair is a regular part of the festival. Come and meet professional artists, designers and craftsmen and women, who will display their jewellery, paintings, ceramics, and much more. They\'ll also take orders, so if you want one of them to make something especially for you, just ask! You\'ll get it within a month of the festival ending.</p>

<p>The Saturday barbecue will start at 2 pm and continue until 10 pm, with a bouncy castle for kids. The barbecue will be held in Palmer\'s Field, or in the town hall if there\'s rain. Book your tickets now, as they always sell out very quickly! Entry for under 16s is free all day; adults can come for free until 6 pm and pay £5 after that. There\'ll be live music throughout, with local amateur bands in the afternoon and professional musicians in the evening.</p>

<p>On Sunday we\'re delighted to introduce an afternoon of boat races, arranged by the Ripton Rowing Club. The spectator area by the bridge has plenty of room to stand and cheer the boats home, in addition to a number of benches. The winners of the races will be presented with trophies by the mayor of Ripton.</p>

<p>All money raised by the festival will go to support the sports clubs in Ripton.</p>
',
        ]);

        // Questions 7–14: True / False / Not Given
        IeltsReadingQuestion::create([
            'passage_id'    => $passage2->id,
            'type'          => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in the text?<br>In boxes 7–14 on your answer sheet, write<br><br><strong>TRUE</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; if the statement agrees with the information<br><strong>FALSE</strong> &nbsp;&nbsp;&nbsp;&nbsp; if the statement contradicts the information<br><strong>NOT GIVEN</strong> &nbsp;if there is no information on this',
            'options'       => json_encode([
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN',
            ]),
            'data'          => json_encode([
                'start_number' => 6,
                'sub_questions' => [
                    ['id' => '7',  'label' => 'The festival is held every year.', 'correct_answer' => 'TRUE'],
                    ['id' => '8',  'label' => 'This year\'s festival focuses on the town\'s history.', 'correct_answer' => 'TRUE'],
                    ['id' => '9',  'label' => 'Goods displayed in the craft fair are unlike ones found in shops.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '10', 'label' => 'The barbecue will be cancelled if it rains.', 'correct_answer' => 'FALSE'],
                    ['id' => '11', 'label' => 'Adults can attend the barbecue at any time without charge.', 'correct_answer' => 'FALSE'],
                    ['id' => '12', 'label' => 'Amateur musicians will perform during the whole of the barbecue.', 'correct_answer' => 'FALSE'],
                    ['id' => '13', 'label' => 'Seating is available for watching the boat races.', 'correct_answer' => 'TRUE'],
                    ['id' => '14', 'label' => 'People attending the festival will be asked to donate some money.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ]),
            'order'         => 1,
        ]);


        // =====================================================================
        // PASSAGE 3 — Section 2, Part A: Reducing injuries on the farm
        // (Questions 15–20)
        // =====================================================================
        $passage3 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title'       => 'Section 2 — Reducing injuries on the farm',
            'order'       => 3,
            'content'     => '
<div class="passage-section-banner">
    <span class="section-title">SECTION 2</span>
    <span class="section-questions">Questions 15–27</span>
</div>

<p class="passage-instruction">Read the text below and answer Questions 15–20.</p>

<h2 class="passage-main-title">Reducing injuries on the farm</h2>

<p>Farms tend to be full of activity. There are always jobs to be done and some tasks require physical manual work. While it is good for people to be active, there are risk factors associated with this, and efforts need to be made to reduce them.</p>

<p>The first risk relates to the carrying of an excessive load or weight. This places undue demands on the spine and can cause permanent damage. Examples of tasks that involve this risk are moving 50-kilogramme fertiliser bags from one site to another or carrying heavy buckets of animal feed around fields. According to the UK Health and Safety Executive, activities such as these \'should be avoided at all times\'. Their documentation states that other methods should be considered, such as breaking down the load into smaller containers prior to movement or transporting the materials using a tractor or other vehicle. The risk posed by excessive force is made worse if the person lifting is also bending over as this increases pressure on the discs in the back.</p>

<p>If a load is bulky or hard to grasp, such as a lively or agitated animal, it will be more difficult to hold while lifting and carrying. The holder may adopt an awkward posture, which is tiring and increases the risk of injury. Sometimes a load has to be held away from the body because there is a large obstacle in the area and the person lifting needs to be able to see where their feet are going. This results in increased stress on the back; holding a load at arm\'s length imposes about five times the stress of a close-to-the-body position. In such cases, handling aids should be purchased that can take the weight off the load and minimise the potential for injury.</p>

<p>Another risk that relates to awkward posture is repetitive bending when carrying out a task. An example might be repairing a gate that has collapsed onto the ground. This type of activity increases the stress on the lower back because the back muscles have to support the weight of the upper body. The farmer should think about whether the job can be performed on a workbench, reducing the need for prolonged awkward posture.</p>
',
        ]);

        // Questions 15–20: Table Completion — Risks and how to avoid them
        IeltsReadingQuestion::create([
            'passage_id'    => $passage3->id,
            'type'          => 'table_completion',
            'question_text' => 'Complete the table below.<br>Choose <strong>ONE WORD ONLY</strong> from the text on page 20 for each answer.<br>Write your answers in boxes 15–20 on your answer sheet.',
            'options'       => json_encode([]),
            'data'          => json_encode([
                'box_title'    => 'Risks and how to avoid them',
                'start_number' => 14,
                'columns'      => [
                    'Risk factor',
                    'Examples of farm activities',
                    'Risk reduction measures to consider'
                ],
                'rows'         => [
                    [
                        'Heavy loads',
                        '• Lifting sacks of 15......<br><br>• Carrying food for animals',
                        '• Divide into containers that weigh less<br><br>• Use a vehicle such as a tractor'
                    ],
                    [
                        'Awkward posture',
                        '• Lifting a restless 16......<br><br>• Moving something around a big 17......',
                        'Buy particular 18...... to help with support'
                    ],
                    [
                        'A lot of 19...... while working',
                        'Fixing a fallen 20......',
                        'Use a workbench instead'
                    ]
                ],
                'sub_questions' => [
                    ['id' => '15', 'label' => 'Lifting sacks of 15......', 'correct_answer' => 'fertiliser'],
                    ['id' => '16', 'label' => 'Lifting a restless 16......', 'correct_answer' => 'animal'],
                    ['id' => '17', 'label' => 'Moving something around a big 17......', 'correct_answer' => 'obstacle'],
                    ['id' => '18', 'label' => 'Buy particular 18...... to help with support', 'correct_answer' => 'handling'],
                    ['id' => '19', 'label' => 'A lot of 19...... while working', 'correct_answer' => 'bending'],
                    ['id' => '20', 'label' => 'Fixing a fallen 20......', 'correct_answer' => 'gate'],
                ]
            ]),
            'order'         => 1,
        ]);


        // =====================================================================
        // PASSAGE 4 — Section 2, Part B: Being a good sales assistant
        // (Questions 21–27)
        // =====================================================================
        $passage4 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title'       => 'Section 2 — Being a good sales assistant',
            'order'       => 4,
            'content'     => '
<p class="passage-instruction">Read the text below and answer Questions 21–27.</p>

<h2 class="passage-main-title">Being a good sales assistant</h2>

<p>Whether you are working in a clothes shop, a bookshop or an electrical goods store, the basic rules for being a successful sales assistant are much the same. So what makes a good sales assistant?</p>

<p><strong>Know your products</strong><br>
First and foremost, you need to know your products inside out. Customers may want to know which model is the most reliable, or which software offers the best value for money. You need to be ready to provide this information. Familiarise yourself with all the products on sale, read the information that comes with them, and try them out if you get the chance.</p>

<p><strong>Get to know your customers</strong><br>
A personal approach to selling works best, and is fine as long as you do not irritate the customer. Try to be friendly, warm and welcoming, while at the same time remaining professional. Find out what customers want or need, so that you can help them buy the right thing, rather than something they will regret. Ask open questions and listen carefully to what they tell you about themselves.</p>

<p><strong>Maximise your sales</strong><br>
Once a customer has decided what they want, consider recommending additional products and accessories without being too forceful. If the customer seems interested in a product but is put off by the price, know how to compare similar products which have different prices. Offer a lower-cost alternative that will still meet their needs.</p>

<p><strong>Handle customer concerns</strong><br>
Learn to deal with problems in a positive way. When a customer says no, always try to say more than just \'no\' yourself. Avoid conflict by always saying more than \'no\' – a negative answer can be turned into a positive with a helpful suggestion. Keep an eye on the expiry dates of goods on the shelves, and report immediately if something is out of date or in poor condition. If a customer has problems paying with their credit card, handle the problem with care. Any rudeness from a customer should not affect how you treat them, or the service you provide.</p>
',
        ]);

        // Questions 21–27: Sentence completion
        IeltsReadingQuestion::create([
            'passage_id'    => $passage4->id,
            'type'          => 'sentence_completion',
            'question_text' => 'Complete the sentences below.<br>Choose <strong>NO MORE THAN TWO WORDS</strong> from the text on page 22 for each answer.<br>Write your answers in boxes 21–27 on your answer sheet.',
            'options'       => json_encode([]),
            'data'          => json_encode([
                'start_number' => 20,
                'sub_questions' => [
                    ['id' => '21', 'label' => 'A 21...... approach to selling is fine as long as you do not irritate the customer.', 'correct_answer' => 'personal'],
                    ['id' => '22', 'label' => 'Recommend additional products and 22...... without being too forceful.', 'correct_answer' => 'accessories'],
                    ['id' => '23', 'label' => 'Know how to compare similar products which have different 23......', 'correct_answer' => 'prices'],
                    ['id' => '24', 'label' => 'Avoid 24...... by always saying more than \'no\'.', 'correct_answer' => 'conflict'],
                    ['id' => '25', 'label' => 'Keep an eye on the 25...... of goods on the shelves.', 'correct_answer' => 'expiry dates'],
                    ['id' => '26', 'label' => 'If a customer has problems paying with their 26......, handle the problem with care.', 'correct_answer' => 'credit card'],
                    ['id' => '27', 'label' => 'Any 27...... from a customer should not affect how you treat them.', 'correct_answer' => 'rudeness'],
                ]
            ]),
            'order'         => 1,
        ]);


        // =====================================================================
        // PASSAGE 5 — Section 3: Plastic is no longer fantastic
        // (Questions 28–40)
        // =====================================================================
        $passage5 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title'       => 'Section 3 — Plastic is no longer fantastic',
            'order'       => 5,
            'content'     => '
<div class="passage-section-banner">
    <span class="section-title">SECTION 3</span>
    <span class="section-questions">Questions 28–40</span>
</div>

<p class="passage-instruction">Read the text and answer Questions 28–40.</p>

<h2 class="passage-main-title">Plastic is no longer fantastic</h2>

<p><strong style="color: #0056b3; font-size: 1.1rem; margin-right: 0.5rem;">A</strong> In 2017, Carlos Ferrando, a Spanish engineer-turned-entrepreneur, saw a piece of art in a museum that profoundly affected him. \'What Lies Under\', a photographic composition by Indonesian digital artist Ferdi Rizkiyanto, shows a child crouching by the edge of the ocean and \'lifting up\' a wave, to reveal a cluster of assorted plastic waste, from polyethylene bags to water bottles. The artwork, designed to raise public awareness, left Ferrando angry – and fuelled with entrepreneurial ideas.</p>

<p><strong style="color: #0056b3; font-size: 1.1rem; margin-right: 0.5rem;">B</strong> Ferrando runs a Spanish-based design company, Closca, that produces an ingenious foldable bicycle helmet. But he has now also designed a stylish glass water bottle with a stretchy silicone strap and magnetic closure mechanism that means it can be attached to almost anything, from a bike to a bag to a pushchair handle. The product comes with an app that tells people where they can fill their bottles with water for free.</p>

<p><strong style="color: #0056b3; font-size: 1.1rem; margin-right: 0.5rem;">C</strong> The intention is to persuade people to stop buying water in plastic bottles, thus saving consumers money and reducing the plastic waste piling up in our oceans. \'Bottled water is now a $100 billion business, and 81 per cent of the bottles are not recycled. It\'s a complete waste – water is only 1.5 per cent of the price of the bottle!\' Ferrando cries. Indeed, environmentalists estimate that by 2050 there will be more plastic in our oceans than fish and that\'s mainly down to such bottles. \'We are trying to create a sense that being environmentally sophisticated is a status symbol,\' he adds. \'We want people to clip their bottles onto what they are wearing, to show that they are recycling – and to look cool.\'</p>

<p><strong style="color: #0056b3; font-size: 1.1rem; margin-right: 0.5rem;">D</strong> Ferrando\'s story is fascinating because it seems like an indicator of something unexpected. Three decades ago, conspicuous consumption – the purchase of luxuries, such as handbags, shoes, cars, etc. on a lavish scale – heightened people\'s social status. Indeed, the closing decades of the 20th century were a time when it seemed that anything could be turned into a commodity. Hence the fact that water became a consumer item, sold in plastic bottles, instead of just emerging, for free, from a tap.</p>

<p><strong style="color: #0056b3; font-size: 1.1rem; margin-right: 0.5rem;">E</strong> Today, though, conspicuous extravagance no longer seems desirable among consumers. Now, recycling is fashionable – as is cycling rather than driving. Plastic water bottles have become so common that they do not command status; instead, what many millennials – young people born in the late 20th century – prefer to post on social media are \'real\' (refillable) bottles or even the once widespread Thermos bottles. Some teenagers currently think that these stainless-steel vacuum-insulated water bottles that are coming back onto the market are ultra \'cool\'; never mind the fact that they feel oddly out-of-date to anyone over the age of 40 or that teenagers in the 1970s would have avoided ever being seen with one.</p>

<p><strong style="color: #0056b3; font-size: 1.1rem; margin-right: 0.5rem;">F</strong> It is uncertain whether Closca will succeed in its goal. Although its foldable bike helmet is available in some outlets in New York, including the Museum of Modern Art, it can be very hard for any design entrepreneur to really take off in the global mass market, though not as hard as it might have been in the past. If an entrepreneur had wanted to fund a smart invention a few decades ago, he or she would have had to either raise a bank loan, borrow money from a family member or use a credit card. Things have moved on slightly since then.</p>

<p><strong style="color: #0056b3; font-size: 1.1rem; margin-right: 0.5rem;">G</strong> Entrepreneurs are still using the last two options, but some are also tapping into the ever-growing pot of money that is becoming available in the management world for \'corporate social responsibility\' (CSR) investments. And then there are other options for those who wish to raise money straight away. Ferrando posted details about his water-bottle venture on a large, recognised platform for funding creative projects. He appealed for people to donate $30,000 of seed money – the money he needed to get his project going – and promised to give a bottle to anyone who provided more than $39 in \'donations\'. If he received the funds, he stated that the company would produce bottles in grey and white; if $60,000 was raised, a multicoloured one would be made. Using this approach, none of the donors has a stake in his idea, nor does he have any debt. Instead, it is almost a pre-sale of the product, in a manner that tests demand in advance and creates a potential crowd of enthusiasts. This old-fashioned community funding with a digital twist is supporting a growing array of projects ranging from films to card games, videos, watches and so on. And, at last count, Closca had raised some $52,838 from 803 backers. Maybe, 20 years from now, it will be the plastic bottle that seems peculiarly old-fashioned.</p>
',
        ]);

        // Questions 28–34: Matching Headings (i–viii)
        IeltsReadingQuestion::create([
            'passage_id'    => $passage5->id,
            'type'          => 'matching_headings',
            'question_text' => 'The text has seven paragraphs, <strong>A–G</strong>.<br>Choose the correct heading for each paragraph from the list of headings below.<br>Write the correct number, <strong>i–viii</strong>, in boxes 28–34 on your answer sheet.',
            'options'       => json_encode([
                'i'    => 'A time when opportunities were limited',
                'ii'   => 'The reasons why Ferrando\'s product is needed',
                'iii'  => 'A no-risk solution',
                'iv'   => 'Two inventions and some physical details',
                'v'    => 'The contrasting views of different generations',
                'vi'   => 'A disturbing experience',
                'vii'  => 'The problems with replacing a consumer item',
                'viii' => 'Looking back at why water was bottled',
            ]),
            'data'          => json_encode([
                'box_title'    => 'List of Headings',
                'start_number' => 27,
                'sub_questions' => [
                    ['id' => '28', 'label' => 'Paragraph A', 'correct_answer' => 'vi'],
                    ['id' => '29', 'label' => 'Paragraph B', 'correct_answer' => 'iv'],
                    ['id' => '30', 'label' => 'Paragraph C', 'correct_answer' => 'ii'],
                    ['id' => '31', 'label' => 'Paragraph D', 'correct_answer' => 'viii'],
                    ['id' => '32', 'label' => 'Paragraph E', 'correct_answer' => 'v'],
                    ['id' => '33', 'label' => 'Paragraph F', 'correct_answer' => 'i'],
                    ['id' => '34', 'label' => 'Paragraph G', 'correct_answer' => 'iii'],
                ]
            ]),
            'order'         => 1,
        ]);

        // Question 35 (Multiple Choice)
        IeltsReadingQuestion::create([
            'passage_id'    => $passage5->id,
            'type'          => 'multiple_choice',
            'question_text' => '35. What does Ferrando say about his glass water bottle?',
            'options'       => json_encode([
                'A' => 'It matches his bicycle helmet.',
                'B' => 'It is cheaper than a plastic bottle.',
                'C' => 'He has designed it to suit all ages.',
                'D' => 'He wants people to be proud to show it.',
            ]),
            'data'          => json_encode([
                'correct_answer' => 'D',
            ]),
            'order'         => 2,
        ]);

        // Question 36 (Multiple Choice)
        IeltsReadingQuestion::create([
            'passage_id'    => $passage5->id,
            'type'          => 'multiple_choice',
            'question_text' => '36. What does the writer find fascinating about Ferrando\'s story?',
            'options'       => json_encode([
                'A' => 'the youthfulness of his ideas',
                'B' => 'the old-fashioned nature of his products',
                'C' => 'the choice it is creating for consumers',
                'D' => 'the change it is revealing in people\'s attitudes',
            ]),
            'data'          => json_encode([
                'correct_answer' => 'D',
            ]),
            'order'         => 3,
        ]);

        // Question 37 (Multiple Choice)
        IeltsReadingQuestion::create([
            'passage_id'    => $passage5->id,
            'type'          => 'multiple_choice',
            'question_text' => '37. What does the writer suggest about Closca\'s bike helmet?',
            'options'       => json_encode([
                'A' => 'It has both functional and artistic value.',
                'B' => 'Its main appeal is to older people.',
                'C' => 'It has had extraordinary success worldwide.',
                'D' => 'It is a more exciting invention than the glass bottle.',
            ]),
            'data'          => json_encode([
                'correct_answer' => 'A',
            ]),
            'order'         => 4,
        ]);

        // Questions 38–40: Summary completion
        IeltsReadingQuestion::create([
            'passage_id'    => $passage5->id,
            'type'          => 'summary_completion',
            'question_text' => 'Complete the summary below.<br>Choose <strong>ONE WORD ONLY</strong> from the text on pages 25 and 26 for each answer.<br>Write your answers in boxes 38–40 on your answer sheet.',
            'options'       => json_encode([]),
            'data'          => json_encode([
                'box_title'    => 'Funding a smart invention',
                'start_number' => 37,
                'sub_questions' => [
                    ['id' => '38', 'label' => 'Thirty years ago, the methods used by creators to fund their projects involved getting money from the bank or from someone in the 38...... Banks today are still a useful source of finance, but investments may also be sought from \'corporate social responsibility\' projects.', 'correct_answer' => 'family'],
                    ['id' => '39', 'label' => 'In order to get immediate funding, the method Ferrando took was to use a well-known 39...... to advertise his product and request financial support. People who gave a certain figure or over were offered a free gift.', 'correct_answer' => 'platform'],
                    ['id' => '40', 'label' => 'In addition, Ferrando advised his donors that his company would create bottles in two colours, followed by a 40...... bottle once they had received a more significant amount. In this way, Ferrando avoided debt and found out how many people might want his products before manufacturing them.', 'correct_answer' => 'multicoloured'],
                ]
            ]),
            'order'         => 5,
        ]);
    }
}
