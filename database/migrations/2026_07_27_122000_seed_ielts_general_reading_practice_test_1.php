<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\IeltsReadingPassage;
use App\Models\IeltsReadingQuestion;

return new class extends Migration
{
    public function up(): void
    {
        $materialId = 101;

        // Clean existing passages and questions for material 101
        $existingPassages = IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            IeltsReadingQuestion::where('passage_id', $passage->id)->delete();
            $passage->delete();
        }

        // ==========================================
        // PASSAGE 1: Top campsites to visit (Section 1A)
        // ==========================================
        $passage1 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Top campsites to visit',
            'order' => 1,
            'content' => '
<p><strong>A Woodside Park</strong></p>
<p>This campsite, which opens in the summer months only, is in the middle of a country park. The site is next to a large lake and there\'s woodland nearby to explore. If you don\'t fancy sleeping in a tent, you can book a pod. These are all heated and furnished with beds. Facilities on site include hot showers and a small shop.</p>
<p><strong>B Treetops Farm</strong></p>
<p>This campsite, which is on a working farm, is open all year. The site itself is a car-free zone and you\'ll need to park near the farmhouse and carry your belongings and tent to the camping area. The facilities are simple but the washrooms, which are closed daily for an hour from midday for cleaning, have free hot water for showers.</p>
<p><strong>C The Downs</strong></p>
<p>This campsite, which is open from April to November but closed during the coldest months, is surrounded by beautiful countryside that\'s perfect for cycling and walking. Facilities on site include a laundry room as well as showers and a small shop. There\'s a pub that serves hot food each evening in the nearby village, which is only a ten-minute drive away.</p>
<p><strong>D Bluewater Bay</strong></p>
<p>This perfectly flat grass campsite, which is open in the summer months only, is only a few minutes\' walk from the beach. There\'s a shower room on site and also a farm shop (which is open until 8 pm), where you can buy anything you need for a BBQ. If you haven\'t got a tent, the site offers pre-pitched ones that can be rented by the day.</p>
<p><strong>E Dean Park</strong></p>
<p>This large campsite, which is open all year, offers a range of facilities. As well as several shower rooms and a café serving cooked meals daily, there\'s an indoor pool and games room. For anyone keen on countryside walks there are miles of footpaths in the nearby national park.</p>
<p><strong>F Rock Harbour</strong></p>
<p>This small, family-owned campsite has space for 50 tents and is only open in the summer. It\'s just a five-minute walk to the sea so is perfect for anyone looking for a beach holiday. There\'s a small shop on site and there\'s always someone in the campsite office from 9 am–9 pm if you need assistance or have a problem.</p>
'
        ]);

        // Q1-5: Matching Campsites A-F
        IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'type' => 'matching',
            'question_text' => 'Look at the six reviews of campsites, A–F.<br>For which campsite are the following statements true?<br>Write the correct letter, A–F.<br><br><strong>A.</strong> Woodside Park<br><strong>B.</strong> Treetops Farm<br><strong>C.</strong> The Downs<br><strong>D.</strong> Bluewater Bay<br><strong>E.</strong> Dean Park<br><strong>F.</strong> Rock Harbour',
            'options' => json_encode(['A', 'B', 'C', 'D', 'E', 'F']),
            'data' => json_encode([
                'start_number' => 1,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'You can pay to hire a tent at this campsite.', 'correct_answer' => 'D'],
                    ['id' => '2', 'label' => 'There is a short period each day when you cannot use the showers.', 'correct_answer' => 'B'],
                    ['id' => '3', 'label' => 'There is a place on site where you can wash clothes.', 'correct_answer' => 'C'],
                    ['id' => '4', 'label' => 'A member of staff is available all day to help visitors.', 'correct_answer' => 'F'],
                    ['id' => '5', 'label' => 'Visitors to this campsite can go swimming in the winter.', 'correct_answer' => 'E'],
                ]
            ]),
            'order' => 1,
        ]);

        // ==========================================
        // PASSAGE 2: Cycling in Plymouth (Section 1B)
        // ==========================================
        $passage2 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Cycling in Plymouth',
            'order' => 2,
            'content' => '
<p>Cycling in the city is relatively stress free. As well as providing a growing number of cycle paths that are traffic free, local government has also added dedicated cycle lanes to many routes. A journey in the city by bike is generally quicker than the same journey by car – especially at peak times, and you can travel door to door, which saves additional time. A further benefit of cycling is that it\'s cheaper than running a car – even if you include the cost of an occasional taxi. It\'s also good for you: you\'ll need to cycle for a recommended minimum of twenty minutes a day if you want to improve your overall fitness.</p>
<p>If you\'ve only recently decided to take up cycling, summer is a good time to start. However, the weather is rarely so bad in Plymouth that it will stop you cycling. To get started, you can hire a bike – various apps are available where you are charged by the hour. If you want to buy a bike, you should think first about the size you\'ll need and what you plan to use it for – commuting, shopping or recreation. When selecting your bike, it\'s helpful to remember that ones with lighter frames and good gears make cycling easier, but are more expensive.</p>
<p>Although most train companies allow bikes on their trains, there are peak-time restrictions. Therefore, if you want to take a bike on a local train at peak times, you will need one that folds up. Even outside peak times, most trains have limited space for bikes of any kind so a reservation in advance of your journey is essential.</p>
<p>If you plan to maintain your bike, you\'ll also need to buy certain equipment: a pump, a spare inner tube, and tyre levers for mending punctures. If you get a puncture, see if you can find out the cause, such as a piece of broken glass, and remove it. If you need to replace an inner tube, its size is usually shown on the tyre.</p>
'
        ]);

        // Q6-14: True / False / Not Given
        IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in the text?<br>On your answer sheet, write:<br><strong>TRUE</strong> if the statement agrees with the information<br><strong>FALSE</strong> if the statement contradicts the information<br><strong>NOT GIVEN</strong> if there is no information on this',
            'options' => json_encode(['TRUE', 'FALSE', 'NOT GIVEN']),
            'data' => json_encode([
                'start_number' => 6,
                'sub_questions' => [
                    ['id' => '6', 'label' => 'The number of traffic-free cycle paths in the city is increasing.', 'correct_answer' => 'TRUE'],
                    ['id' => '7', 'label' => 'You are likely to reach your destination faster if you drive in the city than if you cycle.', 'correct_answer' => 'FALSE'],
                    ['id' => '8', 'label' => 'There are numerous days in the winter when the weather prevents you cycling.', 'correct_answer' => 'FALSE'],
                    ['id' => '9', 'label' => 'Using a bike app to hire a bike is very popular.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '10', 'label' => 'You will have to pay a higher price to buy a bike that is light.', 'correct_answer' => 'TRUE'],
                    ['id' => '11', 'label' => 'Only folding bikes can be taken on local trains at any time.', 'correct_answer' => 'TRUE'],
                    ['id' => '12', 'label' => 'You need to book to take a bike on a train at least a week before you travel.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '13', 'label' => 'If you are repairing a puncture, you will need a piece of equipment called a tyre lever.', 'correct_answer' => 'TRUE'],
                    ['id' => '14', 'label' => 'Broken glass is the most common cause of tyre punctures.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ]),
            'order' => 2,
        ]);

        // ==========================================
        // PASSAGE 3: Learning to conduct difficult conversations in the workplace (Section 2A)
        // ==========================================
        $passage3 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Learning to conduct difficult conversations in the workplace',
            'order' => 3,
            'content' => '
<p>Many of us struggle to say what we need to at work. Whether it\'s asking for a pay rise, or confronting a co-worker over unsatisfactory behaviour, these conversations can be difficult to have without appearing offensive.</p>
<p>There are several reasons why we don\'t raise difficult topics at work. Perhaps we\'ve learned not to rock the boat, we fear being responsible for conflict, or we think that nothing will change even if we do pluck up the courage to speak out. So we stay quiet.</p>
<p>Here are some tips on how to tackle your next difficult conversation:</p>
<p>First, you need to plan what you\'re going to say. Think about how long you need for the conversation and where to have it. The right environment is key – you don\'t want somewhere too formal that will intimidate your colleague, or somewhere too casual where you may be overheard.</p>
<p>The second thing you need to do is write down the key messages you want to get across in the conversation. Practise saying them out loud (I like to record them on my phone and play them back). You are not preparing a script, but this preparation helps you to be brief and clear. If you are particularly nervous, rehearse what you plan to say in front of a friend so you know you are coming across as you wish to.</p>
<p>The language you use is also important. Consider the difference between these two phrases: \'Steve, we\'re very close to deadline date and you told me you\'re a bit behind. I\'d like to support you and agree a way to get the deadlines met.\' and \'Steve, you\'re behind again. This has got to stop!\' If you use the first example, you come across as looking for solutions together. That creates trust and openness. The second example is less likely to get a successful outcome.</p>
<p>Finally, put yourself in the other person\'s shoes – however frustrating that person might be. The useless boss who never gives you feedback is simply struggling with her own extremely heavy workload. The team member who only has negative comments to make in the team meeting simply doesn\'t have the skills to ask for what he wants directly.</p>
<p>To manage your emotions during a difficult conversation, it helps to calm things down by taking some long breaths. And finally, if you feel under pressure, remember to respond slowly rather than reacting quickly.</p>
'
        ]);

        // Q15-21: Sentence Completion
        IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'type' => 'sentence_completion',
            'question_text' => 'Complete the sentences below.<br>Choose <strong>ONE WORD ONLY</strong> from the text for each answer.',
            'options' => null,
            'data' => json_encode([
                'start_number' => 15,
                'sub_questions' => [
                    ['id' => '15', 'label' => 'A lot of people find it hard to challenge colleagues about their poor _______.', 'correct_answer' => 'behaviour'],
                    ['id' => '16', 'label' => 'People are often afraid of causing _______ with colleagues if they raise tricky issues.', 'correct_answer' => 'conflict'],
                    ['id' => '17', 'label' => 'It is important to select the most suitable _______ for a difficult talk.', 'correct_answer' => 'environment'],
                    ['id' => '18', 'label' => 'It may help to consult a _______ for feedback on how you are communicating the main points.', 'correct_answer' => 'friend'],
                    ['id' => '19', 'label' => 'It often works best if the speaker sounds as if they want to find _______ to the problem under discussion.', 'correct_answer' => 'solutions'],
                    ['id' => '20', 'label' => 'A line manager that fails to communicate may have an excessive _______.', 'correct_answer' => 'workload'],
                    ['id' => '21', 'label' => 'If colleagues never have anything good to say, they may lack the appropriate _______ to make requests appropriately.', 'correct_answer' => 'skills'],
                ]
            ]),
            'order' => 3,
        ]);

        // ==========================================
        // PASSAGE 4: Making a success out of a new business (Section 2B)
        // ==========================================
        $passage4 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Making a success out of a new business',
            'order' => 4,
            'content' => '
<p>Running your own business can be very rewarding, but success is not always guaranteed. Half of small businesses fail in the first couple of years, according to official reports, but there are certain steps you can take to give your business the best chance.</p>
<p>First, does your business have a clear mission, yearly goals and a long-term business plan? Ensure your goals are specific, measurable and achievable. Introduce regular reviews of these goals and set new ones when appropriate. Most importantly, communicate your mission and goals to your employees. Their livelihood is tied to the success of your business, so make sure they know what they need to do to keep your business healthy.</p>
<p>A shortage of cash is generally what sinks small businesses, so learning to monitor your cashflow is critical. Check the dates of major outgoings, such as tax and payments for rent and rates, to ensure that you have enough cash for when these need to be paid.</p>
<p>If you\'re setting up a partnership, choosing the right person is vital. Once you have made your choice, put in place an agreement which sets out the rights and responsibilities of each partner in the business. The agreement should also deal with what happens when difficulties arise; for example, does one partner have the ability to buy the other out? Or should the business simply be closed down – which could result in the end of a successful business?</p>
<p>Knowing your market and accurately assessing the potential demand for a product is the key to an idea succeeding or failing. If your product has a very limited market, you won\'t be able to sell enough to create a successful business. You should take time to understand who your competitors are and identify what distinguishes your business from theirs. Perhaps you can provide a better service or compete on price. It all boils down to understanding why customers would rather buy from you than other companies in the field.</p>
<p>There is a lot to think about when starting your own business, but avoiding these common pitfalls will give your business a good chance of success.</p>
'
        ]);

        // Q22-27: Notes Completion
        IeltsReadingQuestion::create([
            'passage_id' => $passage4->id,
            'type' => 'sentence_completion',
            'question_text' => 'Complete the notes below.<br>Choose <strong>ONE WORD ONLY</strong> from the text for each answer.<br><br><strong>Creating a successful business</strong>',
            'options' => null,
            'data' => json_encode([
                'start_number' => 22,
                'sub_questions' => [
                    ['id' => '22', 'label' => 'Statistically, out of all new business ventures, _______ will not survive two years.', 'correct_answer' => 'Half'],
                    ['id' => '23', 'label' => 'Arrange frequent _______ to ensure these goals are still practicable.', 'correct_answer' => 'reviews'],
                    ['id' => '24', 'label' => 'Make sure all _______ are fully aware of them.', 'correct_answer' => 'employees'],
                    ['id' => '25', 'label' => 'Noting _______ for paying tax and other outgoings.', 'correct_answer' => 'dates'],
                    ['id' => '26', 'label' => 'Document stating their _______ and what they are responsible for doing in the business.', 'correct_answer' => 'rights'],
                    ['id' => '27', 'label' => 'Find out how your product differs from what _______ offer.', 'correct_answer' => 'competitors'],
                ]
            ]),
            'order' => 4,
        ]);

        // ==========================================
        // PASSAGE 5: Schoolchildren and local archaeology (Section 3)
        // ==========================================
        $passage5 = IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Schoolchildren and local archaeology',
            'order' => 5,
            'content' => '
<p><strong>A</strong> A group of excited children are instructing community archaeologist Colin Shepherd when to drop a china mug on the floor so that they can see how it breaks on impact. They will use the results of this experiment to better understand an archaeological find: the broken pieces of an old marmalade jar, last used for breakfast around 100 years ago. The children had recently excavated the jar from woodland as part of an archaeological investigation.</p>
<p><strong>B</strong> When schoolchildren are invited to visit archaeological excavations, they rarely have much specific knowledge about the site\'s history. They are normally given straightforward tasks like washing and sorting finds, that is, any discoveries that are of archaeological interest. What is less common is to find primary school pupils working as partners with an archaeologist. Our project lets primary school children take a joint role in an archaeological investigation, working actively alongside an expert in the field.</p>
<p><strong>C</strong> The children\'s archaeological investigations were part of a larger project initiated by a community group which works to study and preserve the landscape of the Bennachie hills region in Aberdeenshire, Scotland. The main project was developed with a team from the University of Aberdeen and funded by a Community Heritage fund and the National Lottery. It focused on the history and archaeology of an abandoned mid-19th-century settlement, located on common ground on the lower slopes of the Bennachie hills. Colin Shepherd set up two additional archaeological projects with local primary school children and their teachers. Each project investigated the history of the place in which the pupils live and go to school.</p>
<p><strong>D</strong> At one of the schools, the excavation took place in woodland where pupils usually take part in outdoor learning. Before the archaeology project began, the children viewed the woodland as existing only in the present. Through their work, they became aware of its history and the people who lived and worked on the land near their school in the past. Taking on the role of historians and working with primary source materials, such as maps, census returns and tax payments, the children were able to develop their own lines of enquiry. Their research suggested that there had been a water mill in the area, so their excavations set out to find it. The children, working with the community archaeologist, found evidence for this. They also discovered the remains of a 19th- or 20th-century midden, or rubbish dump, containing many pieces of broken pottery.</p>
<p><strong>E</strong> My role as a teacher educator specialising in history education was to work alongside pupils and staff to create an exhibition for their families and the general public. Following a visit to the university to see the museum there, the children produced a timeline of everything they had found to show the period in history to which each item belonged. They went on to invent a \'guess the object\' game to engage visitors in their discoveries. The children were given the use of the museum\'s replica of a 17th-century collector\'s cabinet for their exhibition. During the identification of the pottery pieces, one was identified as coming from the distinctive Seaton workshop in Aberdeen, so a complete example was borrowed from the museum and included in the cabinet alongside it. Because it used a high-quality display cabinet, the children\'s exhibition gained a similar status to that of a real museum for the parents and community members who came to see it.</p>
<p><strong>F</strong> The project meant the children could lead their own historical investigations and expand their understanding of the places in which they live and the heritage of their family and community. This is a key principle in the Social Studies section of Scotland\'s Curriculum for Excellence, the national framework for learning for children between the ages of three and 18. Not only did the children learn the history of the place, they learned to understand the process of creating historical knowledge. Through their museum visit, they learned how to select items for display and to think about how to talk to other people about the history they had created.</p>
<p><strong>G</strong> Setting up the exhibition and showing it to people aided conversations between children and their community. One of the children discovered that their great-grandfather had once owned the Seaton workshop. The grandmother of another child recounted her memories of making oatmeal porridge in a small bowl decorated with the same floral design as a pottery piece on display. The archaeological investigations carried out by the children created a real-life context for them to play an active part in learning – educating not just themselves but their community too.</p>
'
        ]);

        // Q28-32: Paragraph Matching A-G
        IeltsReadingQuestion::create([
            'passage_id' => $passage5->id,
            'type' => 'matching',
            'question_text' => 'The text has seven paragraphs, A–G.<br>Which paragraph mentions the following?<br>Write the correct letter, A–G.',
            'options' => json_encode(['A', 'B', 'C', 'D', 'E', 'F', 'G']),
            'data' => json_encode([
                'start_number' => 28,
                'sub_questions' => [
                    ['id' => '28', 'label' => 'how unusual it is for archaeologists and children to have equal responsibilities', 'correct_answer' => 'B'],
                    ['id' => '29', 'label' => 'the relevance of the children\'s achievements to a country\'s educational requirements', 'correct_answer' => 'F'],
                    ['id' => '30', 'label' => 'the location of the archaeologists\' main project', 'correct_answer' => 'C'],
                    ['id' => '31', 'label' => 'a place where a large amount of archaeological material was found', 'correct_answer' => 'D'],
                    ['id' => '32', 'label' => 'a relative\'s connection to a local business', 'correct_answer' => 'G'],
                ]
            ]),
            'order' => 5,
        ]);

        // Q33-36: Multiple Choice
        IeltsReadingQuestion::create([
            'passage_id' => $passage5->id,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.',
            'options' => null,
            'data' => json_encode([
                'start_number' => 33,
                'sub_questions' => [
                    [
                        'id' => '33',
                        'label' => 'The experiment described in paragraph A is designed to show',
                        'options' => [
                            'A' => 'why objects break up when they are left in woodland.',
                            'B' => 'how modern objects differ from those made in the past.',
                            'C' => 'what happens to a breakable object when it hits the ground.',
                            'D' => 'how long it takes to put a broken object back together again.'
                        ],
                        'correct_answer' => 'C'
                    ],
                    [
                        'id' => '34',
                        'label' => 'In paragraph B, what does the writer say most schoolchildren do when they visit archaeological sites?',
                        'options' => [
                            'A' => 'They meet with experts at the site.',
                            'B' => 'They talk to people living near the site.',
                            'C' => 'They are given information about the site.',
                            'D' => 'They engage in simple activities at the site.'
                        ],
                        'correct_answer' => 'D'
                    ],
                    [
                        'id' => '35',
                        'label' => 'The water mill is an example of something that the children',
                        'options' => [
                            'A' => 'had read about in history lessons.',
                            'B' => 'discovered using written documents.',
                            'C' => 'had heard about from local people.',
                            'D' => 'remembered from previous activities.'
                        ],
                        'correct_answer' => 'B'
                    ],
                    [
                        'id' => '36',
                        'label' => 'What does the writer say about one child\'s grandmother?',
                        'options' => [
                            'A' => 'She recognised the pattern on some pottery.',
                            'B' => 'She showed the children how to decorate pottery.',
                            'C' => 'She regularly cooked using a pot that was very old.',
                            'D' => 'She offered the children an old pot that she had kept.'
                        ],
                        'correct_answer' => 'A'
                    ],
                ]
            ]),
            'order' => 6,
        ]);

        // Q37-39: Summary Completion
        IeltsReadingQuestion::create([
            'passage_id' => $passage5->id,
            'type' => 'sentence_completion',
            'question_text' => 'Complete the summary below.<br>Choose <strong>ONE WORD ONLY</strong> from the text for each answer.<br><br><strong>The children\'s exhibition</strong>',
            'options' => null,
            'data' => json_encode([
                'start_number' => 37,
                'sub_questions' => [
                    ['id' => '37', 'label' => 'First the children went to look at the exhibits on display at the _______ museum.', 'correct_answer' => 'university'],
                    ['id' => '38', 'label' => 'Then they created a _______ for visitors to test their knowledge of the items.', 'correct_answer' => 'game'],
                    ['id' => '39', 'label' => 'One piece of pottery was recognised as being made at a particular _______.', 'correct_answer' => 'workshop'],
                ]
            ]),
            'order' => 7,
        ]);

        // Q40: Multiple Choice Title Question
        IeltsReadingQuestion::create([
            'passage_id' => $passage5->id,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.',
            'options' => null,
            'data' => json_encode([
                'start_number' => 40,
                'sub_questions' => [
                    [
                        'id' => '40',
                        'label' => 'What would be a suitable title for the article?',
                        'options' => [
                            'A' => 'Children make an exciting archaeological discovery',
                            'B' => 'Archaeology is becoming a new hobby for children',
                            'C' => 'The benefits for children of working with archaeologists',
                            'D' => 'Communities appreciate the teachings of archaeologists'
                        ],
                        'correct_answer' => 'C'
                    ],
                ]
            ]),
            'order' => 8,
        ]);
    }

    public function down(): void
    {
        $materialId = 101;
        $passages = IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($passages as $passage) {
            IeltsReadingQuestion::where('passage_id', $passage->id)->delete();
            $passage->delete();
        }
    }
};
