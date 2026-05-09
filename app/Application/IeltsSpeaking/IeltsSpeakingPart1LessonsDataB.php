<?php

namespace App\Application\IeltsSpeaking;

class IeltsSpeakingPart1LessonsDataB
{
    public function getLessons(): array
    {
        return [
        // Manual Injection for Lesson 6 (Complex Sentences + Mixed Topics)
        [
            'slug' => 'lesson-6',
            'title' => 'Adverbial Clause',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            'color' => 'indigo',
            'questions' => [],
            'subtopics' => [
                [
                    'slug' => 'part-1-routine',
                    'title' => 'Part 1: Daily Routine & Habits',
                    'questions' => [
                        "1. Work/Study\n- What do you usually do as soon as you arrive at your office or school?",
                        "2. Health\n- Do you think you would exercise more if you had more free time?",
                        "3. Relaxation\n- What do you do to unwind when you feel extremely stressed?",
                        "4. Technology\n- Do you check your phone while you are having a meal with others?"
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'creature of habit',
                            'meaning' => 'someone who likes to do the same things at the same time',
                            'meaning_id' => 'orang yang punya kebiasaan tetap',
                            'example' => 'I am a creature of habit; I always have coffee at 7 AM.'
                        ],
                        [
                            'phrase' => 'early bird',
                            'meaning' => 'someone who gets up early',
                            'meaning_id' => 'orang yang bangun pagi',
                            'example' => 'I have always been an early bird, enjoying the quiet morning.'
                        ],
                        [
                            'phrase' => 'night owl',
                            'meaning' => 'someone who stays up late',
                            'meaning_id' => 'orang yang begadang',
                            'example' => 'As a night owl, I do my best work after midnight.'
                        ],
                        [
                            'phrase' => 'kick the habit',
                            'meaning' => 'to stop doing something harmful',
                            'meaning_id' => 'menghentikan kebiasaan buruk',
                            'example' => 'I am trying to kick the habit of checking my phone in bed.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'daily routine',
                            'meaning' => 'pattern of daily actions',
                            'meaning_id' => 'rutinitas harian',
                            'example' => 'Exercise is an important part of my daily routine.'
                        ],
                        [
                            'phrase' => 'stick to a routine',
                            'meaning' => 'to follow a schedule',
                            'meaning_id' => 'patuh pada rutinitas',
                            'example' => 'I find it hard to stick to a routine when I am on holiday.'
                        ],
                        [
                            'phrase' => 'bad habit',
                            'meaning' => 'a negative pattern of behavior',
                            'meaning_id' => 'kebiasaan buruk',
                            'example' => 'Procrastination is a bad habit I need to break.'
                        ]
                    ]
                ],
                [
                    'slug' => 'part-2-goal',
                    'title' => 'Part 2: Long Turn (Describe a Goal)',
                    'questions' => [
                        "Describe a time when you had to work very hard to achieve a goal. You should say:\n* What the goal was.\n* Why you decided to pursue it even though it was difficult.\n* What you did so that you could succeed.\n* And explain how you felt after you had finally achieved it."
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'go the extra mile',
                            'meaning' => 'to make more effort than is expected of you',
                            'meaning_id' => 'berusaha ekstra keras',
                            'example' => 'To succeed in this business, you need to go the extra mile.'
                        ],
                        [
                            'phrase' => 'keep your eyes on the prize',
                            'meaning' => 'to stay focused on the final goal',
                            'meaning_id' => 'fokus pada tujuan akhir',
                            'example' => 'Even when things get tough, keep your eyes on the prize.'
                        ],
                        [
                            'phrase' => 'blood, sweat, and tears',
                            'meaning' => 'a lot of hard work and suffering',
                            'meaning_id' => 'kerja keras dan pengorbanan',
                            'example' => 'Success took blood, sweat, and tears, but it was worth it.'
                        ],
                        [
                            'phrase' => 'move heaven and earth',
                            'meaning' => 'to do everything possible to achieve something',
                            'meaning_id' => 'melakukan segalanya untuk berhasil',
                            'example' => 'I will move heaven and earth to get that ticket.'
                        ],
                        [
                            'phrase' => 'give it your best shot',
                            'meaning' => 'to try as hard as you can',
                            'meaning_id' => 'mencoba sebaik mungkin',
                            'example' => 'Just give it your best shot and don\'t worry about the result.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'achieve a goal',
                            'meaning' => 'to succeed in reaching a target',
                            'meaning_id' => 'mencapai tujuan',
                            'example' => 'It feels great to finally achieve a goal you have worked hard for.'
                        ],
                        [
                            'phrase' => 'face a challenge',
                            'meaning' => 'to deal with something difficult',
                            'meaning_id' => 'menghadapi tantangan',
                            'example' => 'We had to face many challenges before launching the product.'
                        ],
                        [
                            'phrase' => 'ambitious goal',
                            'meaning' => 'a goal that is difficult to achieve',
                            'meaning_id' => 'tujuan yang ambisius',
                            'example' => 'He set an ambitious goal of running a marathon in under 3 hours.'
                        ],
                        [
                            'phrase' => 'overcome an obstacle',
                            'meaning' => 'to successfully deal with a problem that stops you from achieving your goal',
                            'meaning_id' => 'mengatasi rintangan',
                            'example' => 'She overcame many obstacles to become a doctor.'
                        ],
                        [
                            'phrase' => 'reach your full potential',
                            'meaning' => 'to become the best you can be',
                            'meaning_id' => 'mencapai potensi maksimal',
                            'example' => 'With hard work, you can reach your full potential.'
                        ],
                        [
                            'phrase' => 'set a target',
                            'meaning' => 'to decide on a goal to achieve',
                            'meaning_id' => 'menetapkan target',
                            'example' => 'The company set a target of increasing sales by 20%.'
                        ]
                    ]
                ],
                [
                    'slug' => 'part-3-discussion',
                    'title' => 'Part 3: Abstract Discussion',
                    'questions' => [
                        "1. Education\n- Should children start learning a second language before they start primary school?",
                        "2. Society\n- How would the world be different if there were no internet for a week?",
                        "3. Environment\n- Do you think people will stop using plastic unless the government bans it completely?",
                        "4. Work-Life Balance\n- Why do some people continue to work even if they have already earned enough money?"
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'food for thought',
                            'meaning' => 'something worth thinking seriously about',
                            'meaning_id' => 'bahan pemikiran',
                            'example' => 'The documentary gave us plenty of food for thought.'
                        ],
                        [
                            'phrase' => 'see the big picture',
                            'meaning' => 'to understand the most important facts/situation as a whole',
                            'meaning_id' => 'melihat gambaran besar',
                            'example' => 'We need to step back and see the big picture before deciding.'
                        ],
                        [
                            'phrase' => 'in the long run',
                            'meaning' => 'over a long period of time',
                            'meaning_id' => 'dalam jangka panjang',
                            'example' => 'It might be expensive now, but it will save money in the long run.'
                        ],
                        [
                            'phrase' => 'a double-edged sword',
                            'meaning' => 'something that has both advantages and disadvantages',
                            'meaning_id' => 'sesuatu yang punya sisi positif dan negatif',
                            'example' => 'Technology is a double-edged sword; it connects us but also distracts us.'
                        ],
                        [
                            'phrase' => 'drop in the ocean',
                            'meaning' => 'a very small amount compared to what is needed',
                            'meaning_id' => 'jumlah yang sangat sedikit dibanding kebutuhan',
                            'example' => 'My donation was just a drop in the ocean, but every bit helps.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'social issue',
                            'meaning' => 'a problem that affects many people in society',
                            'meaning_id' => 'masalah sosial',
                            'example' => 'Unemployment is a major social issue in many countries.'
                        ],
                        [
                            'phrase' => 'environmental impact',
                            'meaning' => 'the effect of an event on the environment',
                            'meaning_id' => 'dampak lingkungan',
                            'example' => 'We must consider the environmental impact of this project.'
                        ],
                        [
                            'phrase' => 'work-life balance',
                            'meaning' => 'the division of your time between work and family/leisure',
                            'meaning_id' => 'keseimbangan kerja-hidup',
                            'example' => 'It is important to maintain a healthy work-life balance.'
                        ],
                        [
                            'phrase' => 'global warming',
                            'meaning' => 'gradual increase in world temperatures',
                            'meaning_id' => 'pemanasan global',
                            'example' => 'Global warming is a serious threat to our planet.'
                        ],
                        [
                            'phrase' => 'rapid development',
                            'meaning' => 'fast growth or progress',
                            'meaning_id' => 'perkembangan pesat',
                            'example' => 'The rapid development of technology has changed our lives.'
                        ],
                        [
                            'phrase' => 'cultural diversity',
                            'meaning' => 'the existence of a variety of cultural groups',
                            'meaning_id' => 'keberagaman budaya',
                            'example' => 'Cultural diversity makes a society more vibrant and interesting.'
                        ]
                    ]
                ]
            ]
        ],

        // Manual Injection for Lesson 7 (Idiom & Collocation)
        [
            'slug' => 'lesson-7',
            'title' => 'Idiom & Collocation',
            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
            'color' => 'pink',
            'questions' => [],
            'subtopics' => [
                [
                    'slug' => 'part-1-common',
                    'title' => 'Part 1: Common Topics',
                    'questions' => [
                        "1. Topik: Work & Ambition\n- Do you find your job challenging?",
                        "2. Topik: Free Time\n- How do you relax after a long day?",
                        "3. Topik: Habits\n- Are you a morning person?"
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'climb the corporate ladder',
                            'meaning' => 'to advance in your career',
                            'meaning_id' => 'naik jabatan dalam karir',
                            'example' => 'He is working hard to climb the corporate ladder.'
                        ],
                        [
                            'phrase' => 'let your hair down',
                            'meaning' => 'to relax and enjoy yourself',
                            'meaning_id' => 'bersantai dan menikmati waktu',
                            'example' => 'After a week of exams, I just want to let my hair down.'
                        ],
                        [
                            'phrase' => 'creature of habit',
                            'meaning' => 'someone who likes to do the same things at the same time',
                            'meaning_id' => 'orang yang punya kebiasaan tetap',
                            'example' => 'My grandfather is a creature of habit; he eats at 6 PM sharp.'
                        ],
                        [
                            'phrase' => 'burn the candle at both ends',
                            'meaning' => 'to work very hard and stay up very late',
                            'meaning_id' => 'bekerja sangat keras hingga larut',
                            'example' => 'He has been burning the candle at both ends to finish the project.'
                        ],
                        [
                            'phrase' => 'hit the sack',
                            'meaning' => 'to go to bed',
                            'meaning_id' => 'pergi tidur',
                            'example' => 'I am exhausted, I think I will hit the sack now.'
                        ],
                        [
                            'phrase' => 'busy as a bee',
                            'meaning' => 'very busy',
                            'meaning_id' => 'sangat sibuk',
                            'example' => 'She is always busy as a bee, working on multiple projects.'
                        ],
                        [
                            'phrase' => 'take five',
                            'meaning' => 'to take a short break',
                            'meaning_id' => 'istirahat sebentar',
                            'example' => 'Let\'s take five and grab some coffee.'
                        ],
                        [
                            'phrase' => 'working nine to five',
                            'meaning' => 'a regular job with standard hours',
                            'meaning_id' => 'kerja kantoran biasa',
                            'example' => 'He is tired of working nine to five.'
                        ],
                        [
                            'phrase' => 'all work and no play',
                            'meaning' => 'working too much without having fun',
                            'meaning_id' => 'kerja terus tanpa liburan',
                            'example' => 'All work and no play makes Jack a dull boy.'
                        ],
                        [
                            'phrase' => 'crack of dawn',
                            'meaning' => 'very early in the morning',
                            'meaning_id' => 'subuh-subuh sekali',
                            'example' => 'We have to wake up at the crack of dawn to catch the flight.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'career ambition',
                            'meaning' => 'a strong desire to achieve something in career',
                            'meaning_id' => 'ambisi karir',
                            'example' => 'She has high career ambitions and wants to be a CEO.'
                        ],
                        [
                            'phrase' => 'spare time',
                            'meaning' => 'free time',
                            'meaning_id' => 'waktu luang',
                            'example' => 'What do you doing in your spare time?'
                        ],
                        [
                            'phrase' => 'morning person',
                            'meaning' => 'someone who feels awake and energetic in the morning',
                            'meaning_id' => 'orang yang semangat di pagi hari',
                            'example' => 'I am definitely not a morning person; I hate waking up early.'
                        ],
                        [
                            'phrase' => 'heavy workload',
                            'meaning' => 'a large amount of work to do',
                            'meaning_id' => 'beban kerja berat',
                            'example' => 'She has a heavy workload this week.'
                        ],
                        [
                            'phrase' => 'bad habit',
                            'meaning' => 'a negative pattern of behavior',
                            'meaning_id' => 'kebiasaan buruk',
                            'example' => 'Procrastination is a bad habit I need to break.'
                        ],
                        [
                            'phrase' => 'job satisfaction',
                            'meaning' => 'the feeling of pleasure/achievement in your job',
                            'meaning_id' => 'kepuasan kerja',
                            'example' => 'Job satisfaction is more important than a high salary.'
                        ],
                        [
                            'phrase' => 'quality time',
                            'meaning' => 'time spent giving full attention to someone',
                            'meaning_id' => 'waktu berkualitas',
                            'example' => 'I like to spend quality time with my family on weekends.'
                        ],
                        [
                            'phrase' => 'sedentary lifestyle',
                            'meaning' => 'a lifestyle with little physical exercise',
                            'meaning_id' => 'gaya hidup kurang gerak',
                            'example' => 'A sedentary lifestyle can lead to health problems.'
                        ],
                        [
                            'phrase' => 'break a habit',
                            'meaning' => 'to stop doing something you do regularly',
                            'meaning_id' => 'menghentikan kebiasaan',
                            'example' => 'It takes 21 days to break a habit.'
                        ],
                        [
                            'phrase' => 'daily grind',
                            'meaning' => 'hard/boring daily work',
                            'meaning_id' => 'rutinitas kerja sehari-hari',
                            'example' => 'I am looking forward to escaping the daily grind.'
                        ]
                    ]
                ],
                [
                    'slug' => 'part-2-achievement',
                    'title' => 'Part 2: Cue Card (Achievement)',
                    'questions' => [
                        "Describe a time when you achieved something difficult. You should say:\n* What it was.\n* How you felt at the beginning.\n* What you did to succeed.\n* And explain why this achievement was important to you."
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'against all odds',
                            'meaning' => 'despite very difficulties or low probability',
                            'meaning_id' => 'melawan segala rintangan',
                            'example' => 'She succeeded against all odds.'
                        ],
                        [
                            'phrase' => 'sail through',
                            'meaning' => 'to succeed something easily',
                            'meaning_id' => 'melewati dengan mudah',
                            'example' => 'He revised so much that he sailed through the exam.'
                        ],
                        [
                            'phrase' => 'hard nut to crack',
                            'meaning' => 'a difficult problem or person to deal with',
                            'meaning_id' => 'masalah yang sulit dipecahkan',
                            'example' => 'This math problem is a hard nut to crack.'
                        ],
                        [
                            'phrase' => 'with flying colors',
                            'meaning' => 'with great success',
                            'meaning_id' => 'dengan sukses gemilang',
                            'example' => 'She passed the exam with flying colors.'
                        ],
                        [
                            'phrase' => 'pull out all the stops',
                            'meaning' => 'to do everything possible to make something succeed',
                            'meaning_id' => 'melakukan segala upaya',
                            'example' => 'We pulled out all the stops to finish on time.'
                        ],
                        [
                            'phrase' => 'come a long way',
                            'meaning' => 'to make a lot of progress',
                            'meaning_id' => 'berkembang pesat',
                            'example' => 'Technology has come a long way in the last decade.'
                        ],
                        [
                            'phrase' => 'hit the jackpot',
                            'meaning' => 'to have a big success or luck',
                            'meaning_id' => 'mendapat keberuntungan besar',
                            'example' => 'He hit the jackpot with his new business idea.'
                        ],
                        [
                            'phrase' => 'bear fruit',
                            'meaning' => 'to produce successful results',
                            'meaning_id' => 'membuahkan hasil',
                            'example' => 'Our efforts finally began to bear fruit.'
                        ],
                        [
                            'phrase' => 'stand your ground',
                            'meaning' => 'to maintain your position/opinion',
                            'meaning_id' => 'mempertahankan pendirian',
                            'example' => 'You must stand your ground when you know you are right.'
                        ],
                        [
                            'phrase' => 'on the ball',
                            'meaning' => 'alert and competent',
                            'meaning_id' => 'sigap dan cakap',
                            'example' => 'You need to be on the ball to work in this fast-paced environment.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'sense of achievement',
                            'meaning' => 'a proud feeling of having done something difficult',
                            'meaning_id' => 'rasa pencapaian',
                            'example' => 'Finishing the marathon gave me a huge sense of achievement.'
                        ],
                        [
                            'phrase' => 'conquer a fear',
                            'meaning' => 'to successfully overcome a fear',
                            'meaning_id' => 'menaklukkan rasa takut',
                            'example' => 'I finally conquered my fear of public speaking.'
                        ],
                        [
                            'phrase' => 'significant milestone',
                            'meaning' => 'an important event in the development of something',
                            'meaning_id' => 'tonggak penting',
                            'example' => 'Graduating from university was a significant milestone in my life.'
                        ],
                        [
                            'phrase' => 'remarkable achievement',
                            'meaning' => 'an impressive success',
                            'meaning_id' => 'pencapaian luar biasa',
                            'example' => 'Winning the competition was a remarkable achievement.'
                        ],
                        [
                            'phrase' => 'daunting challenge',
                            'meaning' => 'a challenge that makes you feel worried or less confident',
                            'meaning_id' => 'tantangan yang menakutkan',
                            'example' => 'Climbing the mountain was a daunting challenge.'
                        ],
                        [
                            'phrase' => 'outstanding achievement',
                            'meaning' => 'an extremely good achievement',
                            'meaning_id' => 'pencapaian luar biasa',
                            'example' => 'Winning the Nobel Prize is an outstanding achievement.'
                        ],
                        [
                            'phrase' => 'lifelong ambition',
                            'meaning' => 'a strong desire held for a long time',
                            'meaning_id' => 'ambisi seumur hidup',
                            'example' => 'It was his lifelong ambition to visit space.'
                        ],
                        [
                            'phrase' => 'resounding success',
                            'meaning' => 'a complete success',
                            'meaning_id' => 'sukses besar',
                            'example' => 'The event was a resounding success.'
                        ],
                        [
                            'phrase' => 'face failure',
                            'meaning' => 'to accept/deal with lack of success',
                            'meaning_id' => 'menghadapi kegagalan',
                            'example' => 'You must be brave enough to face failure and try again.'
                        ],
                        [
                            'phrase' => 'fulfill a dream',
                            'meaning' => 'to make a dream come true',
                            'meaning_id' => 'mewujudkan mimpi',
                            'example' => 'She worked hard to fulfill her dream of becoming a doctor.'
                        ]
                    ]
                ],
                [
                    'slug' => 'part-3-discussion',
                    'title' => 'Part 3: Discussion',
                    'questions' => [
                        "1. Topik: Success & Society\n- What factors contribute to a person's success?",
                        "2. Topik: Technology in Education\n- How has technology changed the way we learn?",
                        "3. Topik: Global Issues\n- Is it important for people to be aware of global news?"
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'rags to riches',
                            'meaning' => 'from being poor to becoming wealthy',
                            'meaning_id' => 'dari miskin menjadi kaya',
                            'example' => 'His life story is a classic rags to riches tale.'
                        ],
                        [
                            'phrase' => 'game changer',
                            'meaning' => 'a new idea or factor that significantly changes a situation',
                            'meaning_id' => 'sesuatu yang mengubah keadaan',
                            'example' => 'The internet was a game changer for education.'
                        ],
                        [
                            'phrase' => 'hot topic',
                            'meaning' => 'a subject that many people are discussing',
                            'meaning_id' => 'topik hangat',
                            'example' => 'Climate change is a hot topic these days.'
                        ],
                        [
                            'phrase' => 'up and coming',
                            'meaning' => 'likely to become successful or popular soon',
                            'meaning_id' => 'calon sukses / sedang naik daun',
                            'example' => 'He is an up and coming artist.'
                        ],
                        [
                            'phrase' => 'cutting edge',
                            'meaning' => 'the most modern stage of development',
                            'meaning_id' => 'terdepan / canggih',
                            'example' => 'This company uses cutting edge technology.'
                        ],
                        [
                            'phrase' => 'start from scratch',
                            'meaning' => 'to start from the very beginning',
                            'meaning_id' => 'mulai dari nol',
                            'example' => 'The project failed, so we had to start from scratch.'
                        ],
                        [
                            'phrase' => 'think outside the box',
                            'meaning' => 'to think creatively',
                            'meaning_id' => 'berpikir kreatif',
                            'example' => 'To solve this problem, we need to think outside the box.'
                        ],
                        [
                            'phrase' => 'ahead of the curve',
                            'meaning' => 'more advanced than others',
                            'meaning_id' => 'lebih maju dari yang lain',
                            'example' => 'We need to stay ahead of the curve to survive in this market.'
                        ],
                        [
                            'phrase' => 'actions speak louder than words',
                            'meaning' => 'what you do is more important than what you say',
                            'meaning_id' => 'tindakan lebih penting dari ucapan',
                            'example' => 'Don\'t just promise change; actions speak louder than words.'
                        ],
                        [
                            'phrase' => 'turn a blind eye',
                            'meaning' => 'to ignore something that you know is wrong',
                            'meaning_id' => 'pura-pura tidak tahu',
                            'example' => 'The government cannot turn a blind eye to this crisis.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'key to success',
                            'meaning' => 'the most important factor for success',
                            'meaning_id' => 'kunci kesuksesan',
                            'example' => 'Hard work is the key to success.'
                        ],
                        [
                            'phrase' => 'technological advancement',
                            'meaning' => 'improvements in technology',
                            'meaning_id' => 'kemajuan teknologi',
                            'example' => 'Technological advancement has improved our standard of living.'
                        ],
                        [
                            'phrase' => 'current affairs',
                            'meaning' => 'political news about events happening now',
                            'meaning_id' => 'berita terkini',
                            'example' => 'It is important to keep up with current affairs.'
                        ],
                        [
                            'phrase' => 'integral part',
                            'meaning' => 'essential or necessary part',
                            'meaning_id' => 'bagian penting',
                            'example' => 'Mobile phones have become an integral part of our lives.'
                        ],
                        [
                            'phrase' => 'rapid change',
                            'meaning' => 'very fast change',
                            'meaning_id' => 'perubahan cepat',
                            'example' => 'We are living in a time of rapid change.'
                        ],
                        [
                            'phrase' => 'global village',
                            'meaning' => 'the world considered as a single community',
                            'meaning_id' => 'desa global (dunia yang terhubung)',
                            'example' => 'The internet has turned the world into a global village.'
                        ],
                        [
                            'phrase' => 'information age',
                            'meaning' => 'a period where information is widely available',
                            'meaning_id' => 'era informasi',
                            'example' => 'We live in the information age.'
                        ],
                        [
                            'phrase' => 'adverse effect',
                            'meaning' => 'a negative effect',
                            'meaning_id' => 'dampak negatif',
                            'example' => 'Pollution has an adverse effect on health.'
                        ],
                        [
                            'phrase' => 'pressing issue',
                            'meaning' => 'an urgent problem',
                            'meaning_id' => 'masalah mendesak',
                            'example' => 'Housing shortage is a pressing issue in this city.'
                        ],
                        [
                            'phrase' => 'bridging the gap',
                            'meaning' => 'to connect two different things/groups',
                            'meaning_id' => 'menjembatani kesenjangan',
                            'example' => 'We aim at bridging the gap between rich and poor.'
                        ]
                    ]
                ]
            ]
        ],

        // Manual Injection for Lesson 8 (Advanced Adjective)
        [
            'slug' => 'lesson-8',
            'title' => 'Advanced Adjective',
            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
            'color' => 'blue',
            'questions' => [],
            'subtopics' => [
                [
                    'slug' => 'part-1-common',
                    'title' => 'Part 1: Common Topics',
                    'questions' => [
                        "1. Topik: Your Neighborhood\n- Is your neighborhood a quiet place to live?",
                        "2. Topik: Perfumes & Scents\n- Do you like wearing perfume?",
                        "3. Topik: Concentration\n- Is it difficult for you to stay focused?"
                    ],
                    'idioms' => [
                        // Neighborhood/Senses
                        ['phrase' => 'hustle and bustle', 'meaning' => 'busy and noisy activity', 'meaning_id' => 'hiruk pikuk', 'example' => 'I love the hustle and bustle of the city.'],
                        ['phrase' => 'peace and quiet', 'meaning' => 'calmness and silence', 'meaning_id' => 'ketenangan', 'example' => 'I need some peace and quiet to study.'],
                        ['phrase' => 'safe and sound', 'meaning' => 'completely safe', 'meaning_id' => 'aman dan selamat', 'example' => 'We arrived home safe and sound.'],
                        ['phrase' => 'middle of nowhere', 'meaning' => 'far from anywhere else', 'meaning_id' => 'tempat terpencil', 'example' => 'They live in the middle of nowhere.'],
                        ['phrase' => 'home sweet home', 'meaning' => 'expression of pleasure at being home', 'meaning_id' => 'rumahku istanaku', 'example' => 'It was great to be back in home sweet home.'],
                        // Concentration
                        ['phrase' => 'on the ball', 'meaning' => 'alert and competent', 'meaning_id' => 'sigap', 'example' => 'You need to be on the ball today.'],
                        ['phrase' => 'lose your train of thought', 'meaning' => 'to forget what you were speaking about', 'meaning_id' => 'lupa apa yang mau dibilang', 'example' => 'Sorry, I lost my train of thought.'],
                        ['phrase' => 'zoned out', 'meaning' => 'not paying attention', 'meaning_id' => 'melamun', 'example' => 'I completely zoned out during the meeting.'],
                        ['phrase' => 'sharp as a tack', 'meaning' => 'very intelligent/quick-witted', 'meaning_id' => 'sangat cerdas', 'example' => 'He is old but still sharp as a tack.'],
                        ['phrase' => 'keep an eye on', 'meaning' => 'to limit/observe', 'meaning_id' => 'mengawasi', 'example' => 'Please keep an eye on my bag.']
                    ],
                    'collocations' => [
                        ['phrase' => 'leafy neighborhood', 'meaning' => 'a neighborhood with many trees', 'meaning_id' => 'lingkungan yang asri', 'example' => 'He lives in a quiet, leafy neighborhood.'],
                        ['phrase' => 'residential area', 'meaning' => 'area where people live', 'meaning_id' => 'kawasan perumahan', 'example' => 'It is a strictly residential area.'],
                        ['phrase' => 'within walking distance', 'meaning' => 'close enough to walk to', 'meaning_id' => 'bisa ditempuh dengan jalan kaki', 'example' => 'The shops are within walking distance.'],
                        ['phrase' => 'pungent smell', 'meaning' => 'a very strong smell', 'meaning_id' => 'bau menyengat', 'example' => 'Durian has a pungent smell.'],
                        ['phrase' => 'faint scent', 'meaning' => 'a smell that is not strong', 'meaning_id' => 'aroma samar', 'example' => 'There was a faint scent of jasmine in the air.'],
                        ['phrase' => 'short attention span', 'meaning' => 'unable to focus for long', 'meaning_id' => 'rentang perhatian pendek', 'example' => 'Kids often have a short attention span.'],
                        ['phrase' => 'stay focused', 'meaning' => 'to maintain concentration', 'meaning_id' => 'tetap fokus', 'example' => 'It is hard to stay focused in a noisy room.'],
                        ['phrase' => 'distracting noise', 'meaning' => 'noise that stops you from concentrating', 'meaning_id' => 'suara yang mengganggu', 'example' => 'The construction work creates a distracting noise.'],
                        ['phrase' => 'wander off', 'meaning' => 'to stop concentrating (mind)', 'meaning_id' => 'pikiran melayang', 'example' => 'My mind tends to wander off during boring lectures.'],
                        ['phrase' => 'pay attention', 'meaning' => 'to listen/watch carefully', 'meaning_id' => 'memperhatikan', 'example' => 'Please pay attention to the instructions.']
                    ],
                    'advanced_adjectives' => [
                        ['phrase' => 'picturesque', 'level' => 'C1', 'meaning' => 'visually attractive, especially in a quaint or charming way', 'meaning_id' => 'indah permai', 'example' => 'The village is picturesque with its old cottages.'],
                        ['phrase' => 'bustling', 'level' => 'C1', 'meaning' => 'full of activity and noise', 'meaning_id' => 'ramai sibuk', 'example' => 'I live in a bustling city center.'],
                        ['phrase' => 'tranquil', 'level' => 'C1', 'meaning' => 'free from disturbance; calm', 'meaning_id' => 'tenang', 'example' => 'The park provides a tranquil escape from the city.'],
                        ['phrase' => 'run-down', 'level' => 'C2', 'meaning' => 'in very bad condition', 'meaning_id' => 'kumuh / rusak', 'example' => 'They live in a run-down apartment block.'],
                        ['phrase' => 'affluent', 'level' => 'C1', 'meaning' => 'having a great deal of money; wealthy', 'meaning_id' => 'makmur / kaya', 'example' => 'It is an affluent neighborhood with large houses.'],
                        ['phrase' => 'spacious', 'level' => 'B2', 'meaning' => 'having ample space', 'meaning_id' => 'luas', 'example' => 'My new room is very spacious.'],
                        ['phrase' => 'vibrant', 'level' => 'B2', 'meaning' => 'full of energy and life', 'meaning_id' => 'hidup / bersemangat', 'example' => 'Hong Kong is a vibrant city.'],
                        ['phrase' => 'leafy', 'level' => 'C2', 'meaning' => 'having many trees', 'meaning_id' => 'rindang', 'example' => 'We walked through the leafy suburbs.'],
                        ['phrase' => 'congested', 'level' => 'C2', 'meaning' => 'so crowded with traffic or people as to hinder freedom of movement', 'meaning_id' => 'padat / macet', 'example' => 'The roads are heavily congested during rush hour.'],
                        ['phrase' => 'fragrant', 'level' => 'C2', 'meaning' => 'having a pleasant or sweet smell', 'meaning_id' => 'wangi', 'example' => 'The garden was fragrant with roses.'],
                        ['phrase' => 'pungent', 'level' => 'C2', 'meaning' => 'having a sharply strong taste or smell', 'meaning_id' => 'menyengat', 'example' => 'The pungent smell of onions filled the kitchen.'],
                        ['phrase' => 'aromatic', 'level' => 'C2', 'meaning' => 'having a pleasant and distinctive smell', 'meaning_id' => 'beraroma', 'example' => 'The coffee was rich and aromatic.'],
                        ['phrase' => 'subtle', 'level' => 'C2', 'meaning' => 'delicately complex and understated (scent)', 'meaning_id' => 'halus / samar', 'example' => 'She wore a subtle perfume.'],
                        ['phrase' => 'overpowering', 'level' => 'C2', 'meaning' => 'extremely strong or intense', 'meaning_id' => 'terlalu kuat', 'example' => 'The smell of paint was overpowering.'],
                        ['phrase' => 'undivided', 'level' => 'C2', 'meaning' => 'not shared with others; complete', 'meaning_id' => 'penuh / tak terbagi', 'example' => 'You have my undivided attention.'],
                        ['phrase' => 'fleeting', 'level' => 'C2', 'meaning' => 'lasting for a very short time', 'meaning_id' => 'sekilas / singkat', 'example' => 'I caught a fleeting glimpse of the car.'],
                        ['phrase' => 'intense', 'level' => 'C1', 'meaning' => 'of extreme force, degree, or strength', 'meaning_id' => 'intens / kuat', 'example' => 'The concentration required was intense.'],
                        ['phrase' => 'unwavering', 'level' => 'C2', 'meaning' => 'steady or resolute', 'meaning_id' => 'tak tergoyahkan', 'example' => 'His focus was unwavering throughout the game.'],
                        ['phrase' => 'monotonous', 'level' => 'C1', 'meaning' => 'dull, tedious, and repetitious', 'meaning_id' => 'monoton', 'example' => 'The task became monotonous after a while.'],
                        ['phrase' => 'exhilarating', 'level' => 'C2', 'meaning' => 'making one feel very happy, animated, or elated', 'meaning_id' => 'sangat seru', 'example' => 'It was an exhilarating experience.'],
                        ['phrase' => 'meticulous', 'level' => 'C2', 'meaning' => 'showing great attention to detail', 'meaning_id' => 'teliti', 'example' => 'She is meticulous about her presentation.'],
                        ['phrase' => 'diligent', 'level' => 'C1', 'meaning' => 'having or showing care and conscientiousness', 'meaning_id' => 'tekun', 'example' => 'A diligent student always finishes homework.'],
                        ['phrase' => 'gregarious', 'level' => 'C2', 'meaning' => 'fond of company; sociable', 'meaning_id' => 'suka bergaul', 'example' => 'He is a gregarious person who loves parties.'],
                        ['phrase' => 'apprehensive', 'level' => 'C1', 'meaning' => 'anxious or fearful that something bad will happen', 'meaning_id' => 'cemas', 'example' => 'I felt apprehensive about the interview.'],
                        ['phrase' => 'audacious', 'level' => 'C2', 'meaning' => 'showing a willingness to take surprisingly bold risks', 'meaning_id' => 'berani mati', 'example' => 'It was an audacious plan.'],
                        ['phrase' => 'conscientious', 'level' => 'C1', 'meaning' => 'wishing to do one\'s work or duty well and thoroughly', 'meaning_id' => 'bertanggung jawab', 'example' => 'He is a conscientious worker.'],
                        ['phrase' => 'inquisitive', 'level' => 'C1', 'meaning' => 'curious or inquiring', 'meaning_id' => 'ingin tahu', 'example' => 'She has an inquisitive mind.'],
                        ['phrase' => 'impartial', 'level' => 'C1', 'meaning' => 'treating all rivals or disputants equally', 'meaning_id' => 'adil / tidak memihak', 'example' => 'Judges must be impartial.'],
                        ['phrase' => 'candid', 'level' => 'C1', 'meaning' => 'truthful and straightforward; frank', 'meaning_id' => 'jujur / terus terang', 'example' => 'Currently, I will be candid with you.'],
                        ['phrase' => 'apathy', 'level' => 'C1', 'meaning' => 'lack of interest, enthusiasm, or concern', 'meaning_id' => 'apatis / masa bodoh', 'example' => 'There is widespread apathy among the voters.'],
                        ['phrase' => 'obstinate', 'level' => 'C2', 'meaning' => 'stubbornly refusing to change one\'s opinion', 'meaning_id' => 'keras kepala', 'example' => 'He can be very obstinate at times.'],
                        ['phrase' => 'gullible', 'level' => 'C1', 'meaning' => 'easily persuaded to believe something', 'meaning_id' => 'mudah tertipu', 'example' => 'Don\'t be so gullible.'],
                        ['phrase' => 'introverted', 'level' => 'B2', 'meaning' => 'shy and reticent', 'meaning_id' => 'tertutup', 'example' => 'She is introverted and prefers reading.'],
                        ['phrase' => 'extroverted', 'level' => 'B2', 'meaning' => 'outgoing and socially confident', 'meaning_id' => 'terbuka', 'example' => 'He is extroverted and loves meeting new people.'],
                        ['phrase' => 'compassionate', 'level' => 'C1', 'meaning' => 'feeling or showing sympathy and concern for others', 'meaning_id' => 'penuh kasih', 'example' => 'She is a compassionate nurse.'],
                        ['phrase' => 'amiable', 'level' => 'C1', 'meaning' => 'having or displaying a friendly and pleasant manner', 'meaning_id' => 'ramah', 'example' => 'He was an amiable companion.'],
                        ['phrase' => 'witty', 'level' => 'C1', 'meaning' => 'showing or characterized by quick and inventive verbal humor', 'meaning_id' => 'jenaka / cerdas', 'example' => 'She gave a witty reply.'],
                        ['phrase' => 'charismatic', 'level' => 'C1', 'meaning' => 'exercising a compelling charm that inspires devotion', 'meaning_id' => 'karismatik', 'example' => 'A charismatic leader is essential.'],
                        ['phrase' => 'assertive', 'level' => 'C1', 'meaning' => 'having or showing a confident and forceful personality', 'meaning_id' => 'tegas', 'example' => 'You need to be more assertive.'],
                        ['phrase' => 'diffident', 'level' => 'C2', 'meaning' => 'modest or shy because of a lack of self-confidence', 'meaning_id' => 'pemalu / ragu', 'example' => 'He was diffident about his own achievements.'],
                        ['phrase' => 'arrogant', 'level' => 'B2', 'meaning' => 'having or revealing an exaggerated sense of one\'s own importance', 'meaning_id' => 'sombong', 'example' => 'He came across as arrogant.'],
                        ['phrase' => 'narrow-minded', 'level' => 'B2', 'meaning' => 'not willing to accept ideas or ways of behaving that are different from your own', 'meaning_id' => 'berpikiran sempit', 'example' => 'Don\'t be so narrow-minded.'],
                        ['phrase' => 'open-minded', 'level' => 'B2', 'meaning' => 'willing to consider new ideas', 'meaning_id' => 'berpikiran terbuka', 'example' => 'It helps to be open-minded.'],
                        ['phrase' => 'trustworthy', 'level' => 'B2', 'meaning' => 'able to be relied on as honest or truthful', 'meaning_id' => 'dapat dipercaya', 'example' => 'He is a trustworthy employee.'],
                        ['phrase' => 'eccentric', 'level' => 'C1', 'meaning' => 'unconventional and slightly strange', 'meaning_id' => 'nyentrik', 'example' => 'She has an eccentric style of dressing.'],
                        ['phrase' => 'indifferent', 'level' => 'C1', 'meaning' => 'having no particular interest or sympathy', 'meaning_id' => 'acuh tak acuh', 'example' => 'He seemed indifferent to our plight.'],
                        ['phrase' => 'pessimistic', 'level' => 'B2', 'meaning' => 'tending to see the worst aspect of things', 'meaning_id' => 'pesimis', 'example' => 'He is pessimistic about the future.'],
                        ['phrase' => 'optimistic', 'level' => 'B2', 'meaning' => 'hopeful and confident about the future', 'meaning_id' => 'optimis', 'example' => 'She remains optimistic despite the problems.'],
                        ['phrase' => 'ambitious', 'level' => 'B2', 'meaning' => 'having or showing a strong desire and determination to succeed', 'meaning_id' => 'ambisius', 'example' => 'She is an ambitious lawyer.'],
                        ['phrase' => 'resourceful', 'level' => 'C1', 'meaning' => 'having the ability to find quick and clever ways to overcome difficulties', 'meaning_id' => 'banyak akal', 'example' => 'He is very resourceful in a crisis.'],
                        ['phrase' => 'adaptable', 'level' => 'C1', 'meaning' => 'able to adjust to new conditions', 'meaning_id' => 'mudah beradaptasi', 'example' => 'Adaptable employees are valued.'],
                        ['phrase' => 'versatile', 'level' => 'C1', 'meaning' => 'able to adapt or be adapted to many different functions or activities', 'meaning_id' => 'serba guna', 'example' => 'Leather is a versatile material.'],
                        ['phrase' => 'intuitive', 'level' => 'C1', 'meaning' => 'using or based on what one feels to be true even without conscious reasoning', 'meaning_id' => 'intuitif', 'example' => 'She has an intuitive understanding of the problem.'],
                        ['phrase' => 'rational', 'level' => 'C1', 'meaning' => 'based on or in accordance with reason or logic', 'meaning_id' => 'rasional', 'example' => 'We need a rational explanation.'],
                        ['phrase' => 'illogical', 'level' => 'B2', 'meaning' => 'lacking sense or clear, sound reasoning', 'meaning_id' => 'tidak logis', 'example' => 'His argument was illogical.'],
                        ['phrase' => 'coherent', 'level' => 'C1', 'meaning' => 'logical and consistent', 'meaning_id' => 'koheren / masuk akal', 'example' => 'The speaker gave a coherent presentation.'],
                        ['phrase' => 'articulate', 'level' => 'C1', 'meaning' => 'having or showing the ability to speak fluently and coherently', 'meaning_id' => 'pandai bicara', 'example' => 'She is an articulate speaker.'],
                        ['phrase' => 'eloquent', 'level' => 'C2', 'meaning' => 'fluent or persuasive in speaking or writing', 'meaning_id' => 'fasih / menyentuh hati', 'example' => 'He gave an eloquent speech.'],
                        ['phrase' => 'hesitant', 'level' => 'C1', 'meaning' => 'tentative, unsure, or slow in acting or speaking', 'meaning_id' => 'ragu-ragu', 'example' => 'She was hesitant to ask for help.'],
                        ['phrase' => 'reluctant', 'level' => 'C1', 'meaning' => 'unwilling and hesitant; disinclined', 'meaning_id' => 'enggan', 'example' => 'He was reluctant to leave.'],
                        ['phrase' => 'eager', 'level' => 'B2', 'meaning' => 'wanting to do or have something very much', 'meaning_id' => 'sangat ingin', 'example' => 'He was eager to learn.'],
                        ['phrase' => 'frantic', 'level' => 'C1', 'meaning' => 'wild or distraught with fear, anxiety, or other emotion', 'meaning_id' => 'panik / kalut', 'example' => 'She was frantic with worry.'],
                        ['phrase' => 'serene', 'level' => 'C1', 'meaning' => 'calm, peaceful, and untroubled', 'meaning_id' => 'tenang / damai', 'example' => 'Her face remained serene.'],
                        ['phrase' => 'chaotic', 'level' => 'C1', 'meaning' => 'in a state of complete confusion and disorder', 'meaning_id' => 'kacau', 'example' => 'The traffic was chaotic.'],
                        ['phrase' => 'turbulent', 'level' => 'C2', 'meaning' => 'characterized by conflict, disorder, or confusion; not controlled or calm', 'meaning_id' => 'bergejolak', 'example' => 'It was a turbulent period in history.'],
                        ['phrase' => 'impeccable', 'level' => 'C2', 'meaning' => 'in accordance with the highest standards of propriety; faultless', 'meaning_id' => 'sempurna / tanpa cacat', 'example' => 'He has impeccable manners.'],
                        ['phrase' => 'flawless', 'level' => 'C1', 'meaning' => 'without any blemishes or imperfections', 'meaning_id' => 'tanpa cela', 'example' => 'Her performance was flawless.'],
                        ['phrase' => 'pristine', 'level' => 'C2', 'meaning' => 'in its original condition; unspoiled', 'meaning_id' => 'murni / asli', 'example' => 'The beach was pristine.'],
                        ['phrase' => 'spoiled', 'level' => 'B2', 'meaning' => 'diminished or destroyed in value or quality', 'meaning_id' => 'rusak', 'example' => 'The view was spoiled by the building.'],
                        ['phrase' => 'polluted', 'level' => 'B2', 'meaning' => 'contaminated with harmful or poisonous substances', 'meaning_id' => 'tercemar', 'example' => 'The river is heavily polluted.'],
                        ['phrase' => 'contaminated', 'level' => 'C1', 'meaning' => 'made impure by exposure to polluting substances', 'meaning_id' => 'terkontaminasi', 'example' => 'The water supply was contaminated.'],
                        ['phrase' => 'hazardous', 'level' => 'C1', 'meaning' => 'risky; dangerous', 'meaning_id' => 'berbahaya', 'example' => 'These chemicals are hazardous.'],
                        ['phrase' => 'detrimental', 'level' => 'C2', 'meaning' => 'tending to cause harm', 'meaning_id' => 'merugikan', 'example' => 'Smoking is detrimental to health.'],
                        ['phrase' => 'beneficial', 'level' => 'B2', 'meaning' => 'resulting in good; favourable or advantageous', 'meaning_id' => 'bermanfaat', 'example' => 'Exercise is beneficial.'],
                        ['phrase' => 'advantageous', 'level' => 'C1', 'meaning' => 'involving or creating favorable circumstances that increase the chances of success or effectiveness', 'meaning_id' => 'menguntungkan', 'example' => 'It would be advantageous to wait.'],
                        ['phrase' => 'lucrative', 'level' => 'C2', 'meaning' => 'producing a great deal of profit', 'meaning_id' => 'menguntungkan (uang)', 'example' => 'He has a lucrative business.'],
                        ['phrase' => 'profitable', 'level' => 'B2', 'meaning' => 'yielding profit or financial gain', 'meaning_id' => 'menghasilkan untung', 'example' => 'The deal was very profitable.'],
                        ['phrase' => 'costly', 'level' => 'B2', 'meaning' => 'costing a lot; expensive', 'meaning_id' => 'mahal', 'example' => 'Mistakes can be costly.'],
                        ['phrase' => 'exorbitant', 'level' => 'C1', 'meaning' => 'unreasonably high (price)', 'meaning_id' => 'selangit / mahal sekali', 'example' => 'The prices are exorbitant.'],
                        ['phrase' => 'reasonable', 'level' => 'B2', 'meaning' => 'fair and sensible', 'meaning_id' => 'masuk akal', 'example' => 'The price was reasonable.'],
                        ['phrase' => 'affordable', 'level' => 'B2', 'meaning' => 'inexpensive; reasonably priced', 'meaning_id' => 'terjangkau', 'example' => 'Housing here is affordable.'],
                        ['phrase' => 'economical', 'level' => 'C1', 'meaning' => 'giving good value or service in relation to the amount of money, time, or effort spent', 'meaning_id' => 'hemat', 'example' => 'This car is economical to run.'],
                        ['phrase' => 'extravagant', 'level' => 'C1', 'meaning' => 'lacking restraint in spending money or using resources', 'meaning_id' => 'boros / mewah', 'example' => 'It was an extravagant wedding.'],
                        ['phrase' => 'lavish', 'level' => 'C1', 'meaning' => 'sumptuously rich, elaborate, or luxurious', 'meaning_id' => 'mewah berlimpah', 'example' => 'They held a lavish party.'],
                        ['phrase' => 'frugal', 'level' => 'C2', 'meaning' => 'sparing or economical with regard to money or food', 'meaning_id' => 'hemat sederhana', 'example' => 'He leads a frugal life.'],
                        ['phrase' => 'insufficient', 'level' => 'C1', 'meaning' => 'not enough; inadequate', 'meaning_id' => 'tidak cukup', 'example' => 'The funds were insufficient.'],
                        ['phrase' => 'scarce', 'level' => 'C1', 'meaning' => 'insufficient for the demand', 'meaning_id' => 'langka', 'example' => 'Food was scarce during the war.'],
                        ['phrase' => 'abundant', 'level' => 'B2', 'meaning' => 'existing or available in large quantities; plentiful', 'meaning_id' => 'berlimpah', 'example' => 'We have an abundant supply.'],
                        ['phrase' => 'plentiful', 'level' => 'B2', 'meaning' => 'existing in or yielding great quantities; abundant', 'meaning_id' => 'banyak', 'example' => 'Strawberries are plentiful in summer.'],
                        ['phrase' => 'ample', 'level' => 'C1', 'meaning' => 'enough or more than enough; plentiful', 'meaning_id' => 'cukup banyak', 'example' => 'There is ample time.'],
                        ['phrase' => 'excessive', 'level' => 'C1', 'meaning' => 'more than is necessary, normal, or desirable; immoderate', 'meaning_id' => 'berlebihan', 'example' => 'Excessive noise is prohibited.'],
                        ['phrase' => 'moderate', 'level' => 'B2', 'meaning' => 'average in amount, intensity, quality, or degree', 'meaning_id' => 'sedang', 'example' => 'Cook over moderate heat.'],
                        ['phrase' => 'drastic', 'level' => 'C1', 'meaning' => 'likely to have a strong or far-reaching effect; radical and extreme', 'meaning_id' => 'drastis', 'example' => 'Drastic measures are needed.'],
                        ['phrase' => 'radical', 'level' => 'C1', 'meaning' => 'relating to or affecting the fundamental nature of something', 'meaning_id' => 'radikal / mendasar', 'example' => 'We need radical changes.'],
                        ['phrase' => 'subtle', 'level' => 'C2', 'meaning' => 'making use of clever and indirect methods to achieve something', 'meaning_id' => 'halus / cerdik', 'example' => 'He used a subtle approach.'],
                        ['phrase' => 'complex', 'level' => 'B2', 'meaning' => 'consisting of many different and connected parts', 'meaning_id' => 'kompleks', 'example' => 'It is a complex issue.'],
                        ['phrase' => 'complicated', 'level' => 'B2', 'meaning' => 'consisting of many interconnecting parts or elements; intricate', 'meaning_id' => 'rumit', 'example' => 'The rules are complicated.'],
                        ['phrase' => 'intricate', 'level' => 'C2', 'meaning' => 'very complicated or detailed', 'meaning_id' => 'rumit mendetail', 'example' => 'The design is intricate.'],
                        ['phrase' => 'elaborate', 'level' => 'C1', 'meaning' => 'involving many carefully arranged parts or details; detailed and complicated in design and planning', 'meaning_id' => 'rumit terperinci', 'example' => 'They made elaborate plans.'],
                        ['phrase' => 'simplistic', 'level' => 'C1', 'meaning' => 'treating complex issues and problems as if they were much simpler than they really are', 'meaning_id' => 'terlalu sederhana', 'example' => 'His view is simplistic.'],
                        ['phrase' => 'fundamental', 'level' => 'C1', 'meaning' => 'forming a necessary base or core; of central importance', 'meaning_id' => 'mendasar', 'example' => 'Freedom represents a fundamental right.'],
                        ['phrase' => 'crucial', 'level' => 'B2', 'meaning' => 'decisive or critical, especially in the success or failure of something', 'meaning_id' => 'sangat penting', 'example' => 'Speed is crucial.'],
                        ['phrase' => 'essential', 'level' => 'B2', 'meaning' => 'absolutely necessary; extremely important', 'meaning_id' => 'penting sekali', 'example' => 'Water is essential for life.'],
                        ['phrase' => 'vital', 'level' => 'B2', 'meaning' => 'absolutely necessary or important; essential', 'meaning_id' => 'vital', 'example' => 'Trust is vital in a relationship.'],
                        ['phrase' => 'trivial', 'level' => 'C1', 'meaning' => 'of little value or importance', 'meaning_id' => 'sepele', 'example' => 'Don\'t worry about trivial details.'],
                        ['phrase' => 'insignificant', 'level' => 'C1', 'meaning' => 'too small or unimportant to be worth consideration', 'meaning_id' => 'tidak berarti', 'example' => 'The cost was insignificant.'],
                        ['phrase' => 'irrelevant', 'level' => 'B2', 'meaning' => 'not connected with or relevant to something', 'meaning_id' => 'tidak relevan', 'example' => 'That point is irrelevant.'],
                        ['phrase' => 'pertinent', 'level' => 'C2', 'meaning' => 'relevant or applicable to a particular matter', 'meaning_id' => 'relevan / berkaitan', 'example' => 'She asked pertinent questions.'],
                        ['phrase' => 'appropriate', 'level' => 'B2', 'meaning' => 'suitable or proper in the circumstances', 'meaning_id' => 'tepat / pantas', 'example' => 'Wear appropriate clothing.'],
                        ['phrase' => 'inappropriate', 'level' => 'B2', 'meaning' => 'not suitable or proper in the circumstances', 'meaning_id' => 'tidak pantas', 'example' => 'His behavior was inappropriate.'],
                        ['phrase' => 'suitable', 'level' => 'B2', 'meaning' => 'right or appropriate for a particular person, purpose, or situation', 'meaning_id' => 'cocok', 'example' => 'This movie is suitable for children.'],
                        ['phrase' => 'adequate', 'level' => 'B2', 'meaning' => 'satisfactory or acceptable in quality or quantity', 'meaning_id' => 'memadai', 'example' => 'The food was adequate.'],
                        ['phrase' => 'imminent', 'level' => 'C1', 'meaning' => 'about to happen', 'meaning_id' => 'sebentar lagi terjadi', 'example' => 'The storm is imminent.'],
                        ['phrase' => 'impending', 'level' => 'C2', 'meaning' => 'be about to happen', 'meaning_id' => 'menjelang', 'example' => 'He warned of impending danger.'],
                        ['phrase' => 'inevitable', 'level' => 'C1', 'meaning' => 'certain to happen; unavoidable', 'meaning_id' => 'tak terelakkan', 'example' => 'Change is inevitable.'],
                        ['phrase' => 'unavoidable', 'level' => 'B2', 'meaning' => 'not able to be avoided, prevented, or ignored; inevitable', 'meaning_id' => 'tak terhindarkan', 'example' => 'Delays are unavoidable.'],
                        ['phrase' => 'predictable', 'level' => 'B2', 'meaning' => 'able to be predicted', 'meaning_id' => 'mudah ditebak', 'example' => 'The ending was predictable.'],
                        ['phrase' => 'unpredictable', 'level' => 'B2', 'meaning' => 'not able to be foreseen or known beforehand; uncertain', 'meaning_id' => 'sulit ditebak', 'example' => 'The weather is unpredictable.'],
                        ['phrase' => 'reliable', 'level' => 'B2', 'meaning' => 'consistently good in quality or performance; able to be trusted', 'meaning_id' => 'dapat diandalkan', 'example' => 'He is a reliable friend.'],
                        ['phrase' => 'dependable', 'level' => 'C1', 'meaning' => 'trustworthy and reliable', 'meaning_id' => 'dapat bergantung', 'example' => 'She is a dependable worker.'],
                        ['phrase' => 'consistent', 'level' => 'B2', 'meaning' => 'acting or done in the same way over time, especially so as to be fair or accurate', 'meaning_id' => 'konsisten', 'example' => 'He is consistent in his work.'],
                        ['phrase' => 'persistent', 'level' => 'C1', 'meaning' => 'continuing firmly or obstinately in a course of action in spite of difficulty or opposition', 'meaning_id' => 'gigih / persisten', 'example' => 'She is persistent in her studies.'],
                        ['phrase' => 'relentless', 'level' => 'C2', 'meaning' => 'oppressively constant; incessant', 'meaning_id' => 'tak henti-hentinya', 'example' => 'The sun was relentless.'],
                        ['phrase' => 'ceaseless', 'level' => 'C2', 'meaning' => 'constant and unending', 'meaning_id' => 'tiada henti', 'example' => 'The ceaseless rain depressed me.'],
                        ['phrase' => 'eternal', 'level' => 'C1', 'meaning' => 'lasting or existing forever; without end or beginning', 'meaning_id' => 'abadi', 'example' => 'They swore eternal friendship.'],
                        ['phrase' => 'temporary', 'level' => 'B2', 'meaning' => 'lasting for only a limited period of time; not permanent', 'meaning_id' => 'sementara', 'example' => 'This is a temporary solution.'],
                        ['phrase' => 'provisional', 'level' => 'C2', 'meaning' => 'arranged or existing for the present, possibly to be changed later', 'meaning_id' => 'bersifat sementara / darurat', 'example' => 'It is a provisional government.'],
                        ['phrase' => 'tentative', 'level' => 'C2', 'meaning' => 'not certain or fixed; provisional', 'meaning_id' => 'tentatif / belum pasti', 'example' => 'We made a tentative plant.'],
                        ['phrase' => 'definite', 'level' => 'B2', 'meaning' => 'clearly stated or decided; not vague or doubtful', 'meaning_id' => 'pasti', 'example' => 'I need a definite answer.'],
                        ['phrase' => 'ambiguous', 'level' => 'C1', 'meaning' => 'open to more than one interpretation; having a double meaning', 'meaning_id' => 'ambigu / mendua', 'example' => 'The instructions were ambiguous.']
                    ]
                ],
                [
                    'slug' => 'part-2-journey',
                    'title' => 'Part 2: Cue Card (Journey)',
                    'questions' => [
                        "Describe a long journey you went on that you enjoyed. You should say:\n* Where you went and how you traveled.\n* What the scenery was like along the way.\n* What you did during the journey.\n* And explain why this journey was so exhilarating."
                    ],
                    'idioms' => [
                        ['phrase' => 'hit the road', 'meaning' => 'to start a journey', 'meaning_id' => 'memulai perjalanan', 'example' => 'We hit the road at 5 AM.'],
                        ['phrase' => 'off the beaten track', 'meaning' => 'away from popular areas', 'meaning_id' => 'jarang dikunjungi turis', 'example' => 'We like to travel off the beaten track.'],
                        ['phrase' => 'travel light', 'meaning' => 'to travel with little luggage', 'meaning_id' => 'bepergian dengan sedikit barang', 'example' => 'I always try to travel light.'],
                        ['phrase' => 'itchy feet', 'meaning' => 'a strong desire to travel', 'meaning_id' => 'keinginan kuat untuk jalan-jalan', 'example' => 'After a month at home, I got itchy feet.'],
                        ['phrase' => 'hustle and bustle', 'meaning' => 'busy activity (usually city)', 'meaning_id' => 'hiruk pikuk', 'example' => 'We escaped the hustle and bustle of the city.'], 
                        // Note: Repeated idiomp but appropriate for journey context too.
                        ['phrase' => 'live out of a suitcase', 'meaning' => 'to travel constantly', 'meaning_id' => 'hidup berpindah-pindah', 'example' => 'For my job, I have to live out of a suitcase.'],
                        ['phrase' => 'on the move', 'meaning' => 'traveling from place to place', 'meaning_id' => 'dalam perjalanan / bergerak', 'example' => 'We have been on the move for three days.'],
                        ['phrase' => 'scenic route', 'meaning' => 'a road that has beautiful scenery', 'meaning_id' => 'jalan dengan pemandangan indah', 'example' => 'We took the scenic route home.'],
                        ['phrase' => 'bumper to bumper', 'meaning' => 'traffic is very heavy', 'meaning_id' => 'macet total', 'example' => 'The traffic was bumper to bumper all the way.'],
                        ['phrase' => 'backseat driver', 'meaning' => 'passenger who gives unwanted advice', 'meaning_id' => 'penumpang yang suka mengatur', 'example' => 'Stop being a backseat driver!']
                    ],
                    'collocations' => [
                        ['phrase' => 'breathtaking view', 'meaning' => 'an extremely beautiful view', 'meaning_id' => 'pemandangan yang memukau', 'example' => 'The mountain offered a breathtaking view.'],
                        ['phrase' => 'exhilarating experience', 'meaning' => 'making you feel very excited and happy', 'meaning_id' => 'pengalaman yang menggembirakan', 'example' => 'Skydiving was an exhilarating experience.'],
                        ['phrase' => 'tedious journey', 'meaning' => 'long and boring trip', 'meaning_id' => 'perjalanan yang membosankan', 'example' => 'The bus ride was a tedious journey.'],
                        ['phrase' => 'picturesque village', 'meaning' => 'attractive/charming village', 'meaning_id' => 'desa yang indah', 'example' => 'We stopped at a picturesque village for lunch.'],
                        ['phrase' => 'winding road', 'meaning' => 'road with many turns', 'meaning_id' => 'jalan berliku', 'example' => 'Be careful on that winding road.'],
                        ['phrase' => 'stunning scenery', 'meaning' => 'extremely attractive natural features', 'meaning_id' => 'pemandangan menakjubkan', 'example' => 'We drove through some stunning scenery.'],
                        ['phrase' => 'reach a destination', 'meaning' => 'to arrive', 'meaning_id' => 'sampai tujuan', 'example' => 'We reached our destination by sunset.'],
                        ['phrase' => 'embark on a journey', 'meaning' => 'to start a trip', 'meaning_id' => 'memulai perjalanan', 'example' => 'They embarked on a journey across Europe.'],
                        ['phrase' => 'leg of the journey', 'meaning' => 'part of a journey', 'meaning_id' => 'tahap perjalanan', 'example' => 'The final leg of the journey was the hardest.'],
                        ['phrase' => 'memorable trip', 'meaning' => 'unforgettable trip', 'meaning_id' => 'perjalanan yang berkesan', 'example' => 'It was such a memorable trip.']
                    ],
                    'advanced_adjectives' => [
                        ['phrase' => 'scenic', 'level' => 'C1', 'meaning' => 'providing or relating to views of impressive or beautiful natural scenery', 'meaning_id' => 'indah / penuh pemandangan', 'example' => 'We took the scenic route home.'],
                        ['phrase' => 'breathtaking', 'level' => 'C1', 'meaning' => 'astonishing or awe-inspiring in quality, so as to take one\'s breath away', 'meaning_id' => 'memukau', 'example' => 'The view from the top was breathtaking.'],
                        ['phrase' => 'remote', 'level' => 'B2', 'meaning' => 'situated far from the main centers of population; distant', 'meaning_id' => 'terpencil', 'example' => 'They live in a remote mountain village.'],
                        ['phrase' => 'arduous', 'level' => 'C2', 'meaning' => 'involving or requiring strenuous effort; difficult and tiring', 'meaning_id' => 'berat / melelahkan', 'example' => 'It was an arduous journey.'],
                        ['phrase' => 'exotic', 'level' => 'B2', 'meaning' => 'originating in or characteristic of a distant foreign country', 'meaning_id' => 'eksotis', 'example' => 'We tasted exotic fruits.'],
                        ['phrase' => 'accessible', 'level' => 'B2', 'meaning' => 'able to be reached or entered', 'meaning_id' => 'mudah diakses', 'example' => 'The hotel is easily accessible by car.'],
                        ['phrase' => 'cultural', 'level' => 'B1', 'meaning' => 'relating to the ideas, customs, and social behavior of a society', 'meaning_id' => 'budaya', 'example' => 'We explored the city\'s cultural heritage.'],
                        ['phrase' => 'unforgettable', 'level' => 'B2', 'meaning' => 'impossible to forget; very memorable', 'meaning_id' => 'tak terlupakan', 'example' => 'It was an unforgettable experience.'],
                        ['phrase' => 'pristine', 'level' => 'C2', 'meaning' => 'in its original condition; unspoiled', 'meaning_id' => 'murni / belum terjamah', 'example' => 'The beach was pristine.'],
                        ['phrase' => 'bustling', 'level' => 'C1', 'meaning' => 'full of activity and noise', 'meaning_id' => 'ramai sibuk', 'example' => 'I live in a bustling city center.'],
                        ['phrase' => 'pungent', 'level' => 'C2', 'meaning' => 'having a sharply strong taste or smell', 'meaning_id' => 'menyengat', 'example' => 'The pungent smell of onions filled the kitchen.'],
                        ['phrase' => 'aromatic', 'level' => 'C2', 'meaning' => 'having a pleasant and distinctive smell', 'meaning_id' => 'beraroma', 'example' => 'The coffee was rich and aromatic.'],
                        ['phrase' => 'subtle', 'level' => 'C2', 'meaning' => 'delicately complex and understated (scent)', 'meaning_id' => 'halus / samar', 'example' => 'She wore a subtle perfume.'],
                        ['phrase' => 'overpowering', 'level' => 'C2', 'meaning' => 'extremely strong or intense', 'meaning_id' => 'terlalu kuat', 'example' => 'The smell of paint was overpowering.'],
                        ['phrase' => 'undivided', 'level' => 'C2', 'meaning' => 'not shared with others; complete', 'meaning_id' => 'penuh / tak terbagi', 'example' => 'You have my undivided attention.'],
                        ['phrase' => 'fleeting', 'level' => 'C2', 'meaning' => 'lasting for a very short time', 'meaning_id' => 'sekilas / singkat', 'example' => 'I caught a fleeting glimpse of the car.'],
                        ['phrase' => 'intense', 'level' => 'C1', 'meaning' => 'of extreme force, degree, or strength', 'meaning_id' => 'intens / kuat', 'example' => 'The concentration required was intense.'],
                        ['phrase' => 'unwavering', 'level' => 'C2', 'meaning' => 'steady or resolute', 'meaning_id' => 'tak tergoyahkan', 'example' => 'His focus was unwavering throughout the game.'],
                        ['phrase' => 'monotonous', 'level' => 'C1', 'meaning' => 'dull, tedious, and repetitious', 'meaning_id' => 'monoton', 'example' => 'The task became monotonous after a while.'],
                        ['phrase' => 'exhilarating', 'level' => 'C2', 'meaning' => 'making one feel very happy, animated, or elated', 'meaning_id' => 'sangat seru', 'example' => 'It was an exhilarating experience.'],
                        ['phrase' => 'meticulous', 'level' => 'C2', 'meaning' => 'showing great attention to detail', 'meaning_id' => 'teliti', 'example' => 'She is meticulous about her presentation.'],
                        ['phrase' => 'diligent', 'level' => 'C1', 'meaning' => 'having or showing care and conscientiousness', 'meaning_id' => 'tekun', 'example' => 'A diligent student always finishes homework.'],
                        ['phrase' => 'gregarious', 'level' => 'C2', 'meaning' => 'fond of company; sociable', 'meaning_id' => 'suka bergaul', 'example' => 'He is a gregarious person who loves parties.'],
                        ['phrase' => 'apprehensive', 'level' => 'C1', 'meaning' => 'anxious or fearful that something bad will happen', 'meaning_id' => 'cemas', 'example' => 'I felt apprehensive about the interview.'],
                        ['phrase' => 'audacious', 'level' => 'C2', 'meaning' => 'showing a willingness to take surprisingly bold risks', 'meaning_id' => 'berani mati', 'example' => 'It was an audacious plan.'],
                        ['phrase' => 'conscientious', 'level' => 'C1', 'meaning' => 'wishing to do one\'s work or duty well and thoroughly', 'meaning_id' => 'bertanggung jawab', 'example' => 'He is a conscientious worker.'],
                        ['phrase' => 'inquisitive', 'level' => 'C1', 'meaning' => 'curious or inquiring', 'meaning_id' => 'ingin tahu', 'example' => 'She has an inquisitive mind.'],
                        ['phrase' => 'impartial', 'level' => 'C1', 'meaning' => 'treating all rivals or disputants equally', 'meaning_id' => 'adil / tidak memihak', 'example' => 'Judges must be impartial.'],
                        ['phrase' => 'candid', 'level' => 'C1', 'meaning' => 'truthful and straightforward; frank', 'meaning_id' => 'jujur / terus terang', 'example' => 'Currently, I will be candid with you.'],
                        ['phrase' => 'apathy', 'level' => 'C1', 'meaning' => 'lack of interest, enthusiasm, or concern', 'meaning_id' => 'apatis / masa bodoh', 'example' => 'There is widespread apathy among the voters.'],
                        ['phrase' => 'obstinate', 'level' => 'C2', 'meaning' => 'stubbornly refusing to change one\'s opinion', 'meaning_id' => 'keras kepala', 'example' => 'He can be very obstinate at times.'],
                        ['phrase' => 'gullible', 'level' => 'C1', 'meaning' => 'easily persuaded to believe something', 'meaning_id' => 'mudah tertipu', 'example' => 'Don\'t be so gullible.'],
                        ['phrase' => 'introverted', 'level' => 'B2', 'meaning' => 'shy and reticent', 'meaning_id' => 'tertutup', 'example' => 'She is introverted and prefers reading.'],
                        ['phrase' => 'extroverted', 'level' => 'B2', 'meaning' => 'outgoing and socially confident', 'meaning_id' => 'terbuka', 'example' => 'He is extroverted and loves meeting new people.'],
                        ['phrase' => 'compassionate', 'level' => 'C1', 'meaning' => 'feeling or showing sympathy and concern for others', 'meaning_id' => 'penuh kasih', 'example' => 'She is a compassionate nurse.'],
                        ['phrase' => 'amiable', 'level' => 'C1', 'meaning' => 'having or displaying a friendly and pleasant manner', 'meaning_id' => 'ramah', 'example' => 'He was an amiable companion.'],
                        ['phrase' => 'witty', 'level' => 'C1', 'meaning' => 'showing or characterized by quick and inventive verbal humor', 'meaning_id' => 'jenaka / cerdas', 'example' => 'She gave a witty reply.'],
                        ['phrase' => 'charismatic', 'level' => 'C1', 'meaning' => 'exercising a compelling charm that inspires devotion', 'meaning_id' => 'karismatik', 'example' => 'A charismatic leader is essential.'],
                        ['phrase' => 'assertive', 'level' => 'C1', 'meaning' => 'having or showing a confident and forceful personality', 'meaning_id' => 'tegas', 'example' => 'You need to be more assertive.'],
                        ['phrase' => 'diffident', 'level' => 'C2', 'meaning' => 'modest or shy because of a lack of self-confidence', 'meaning_id' => 'pemalu / ragu', 'example' => 'He was diffident about his own achievements.'],
                        ['phrase' => 'arrogant', 'level' => 'B2', 'meaning' => 'having or revealing an exaggerated sense of one\'s own importance', 'meaning_id' => 'sombong', 'example' => 'He came across as arrogant.'],
                        ['phrase' => 'narrow-minded', 'level' => 'B2', 'meaning' => 'not willing to accept ideas or ways of behaving that are different from your own', 'meaning_id' => 'berpikiran sempit', 'example' => 'Don\'t be so narrow-minded.'],
                        ['phrase' => 'open-minded', 'level' => 'B2', 'meaning' => 'willing to consider new ideas', 'meaning_id' => 'berpikiran terbuka', 'example' => 'It helps to be open-minded.'],
                        ['phrase' => 'trustworthy', 'level' => 'B2', 'meaning' => 'able to be relied on as honest or truthful', 'meaning_id' => 'dapat dipercaya', 'example' => 'He is a trustworthy employee.'],
                        ['phrase' => 'eccentric', 'level' => 'C1', 'meaning' => 'unconventional and slightly strange', 'meaning_id' => 'nyentrik', 'example' => 'She has an eccentric style of dressing.'],
                        ['phrase' => 'indifferent', 'level' => 'C1', 'meaning' => 'having no particular interest or sympathy', 'meaning_id' => 'acuh tak acuh', 'example' => 'He seemed indifferent to our plight.'],
                        ['phrase' => 'pessimistic', 'level' => 'B2', 'meaning' => 'tending to see the worst aspect of things', 'meaning_id' => 'pesimis', 'example' => 'He is pessimistic about the future.'],
                        ['phrase' => 'optimistic', 'level' => 'B2', 'meaning' => 'hopeful and confident about the future', 'meaning_id' => 'optimis', 'example' => 'She remains optimistic despite the problems.'],
                        ['phrase' => 'ambitious', 'level' => 'B2', 'meaning' => 'having or showing a strong desire and determination to succeed', 'meaning_id' => 'ambisius', 'example' => 'She is an ambitious lawyer.'],
                        ['phrase' => 'resourceful', 'level' => 'C1', 'meaning' => 'having the ability to find quick and clever ways to overcome difficulties', 'meaning_id' => 'banyak akal', 'example' => 'He is very resourceful in a crisis.'],
                        ['phrase' => 'adaptable', 'level' => 'C1', 'meaning' => 'able to adjust to new conditions', 'meaning_id' => 'mudah beradaptasi', 'example' => 'Adaptable employees are valued.'],
                        ['phrase' => 'versatile', 'level' => 'C1', 'meaning' => 'able to adapt or be adapted to many different functions or activities', 'meaning_id' => 'serba guna', 'example' => 'Leather is a versatile material.'],
                        ['phrase' => 'intuitive', 'level' => 'C1', 'meaning' => 'using or based on what one feels to be true even without conscious reasoning', 'meaning_id' => 'intuitif', 'example' => 'She has an intuitive understanding of the problem.'],
                        ['phrase' => 'rational', 'level' => 'C1', 'meaning' => 'based on or in accordance with reason or logic', 'meaning_id' => 'rasional', 'example' => 'We need a rational explanation.'],
                        ['phrase' => 'illogical', 'level' => 'B2', 'meaning' => 'lacking sense or clear, sound reasoning', 'meaning_id' => 'tidak logis', 'example' => 'His argument was illogical.'],
                        ['phrase' => 'coherent', 'level' => 'C1', 'meaning' => 'logical and consistent', 'meaning_id' => 'koheren / masuk akal', 'example' => 'The speaker gave a coherent presentation.'],
                        ['phrase' => 'articulate', 'level' => 'C1', 'meaning' => 'having or showing the ability to speak fluently and coherently', 'meaning_id' => 'pandai bicara', 'example' => 'She is an articulate speaker.'],
                        ['phrase' => 'eloquent', 'level' => 'C2', 'meaning' => 'fluent or persuasive in speaking or writing', 'meaning_id' => 'fasih / menyentuh hati', 'example' => 'He gave an eloquent speech.'],
                        ['phrase' => 'hesitant', 'level' => 'C1', 'meaning' => 'tentative, unsure, or slow in acting or speaking', 'meaning_id' => 'ragu-ragu', 'example' => 'She was hesitant to ask for help.'],
                        ['phrase' => 'reluctant', 'level' => 'C1', 'meaning' => 'unwilling and hesitant; disinclined', 'meaning_id' => 'enggan', 'example' => 'He was reluctant to leave.'],
                        ['phrase' => 'eager', 'level' => 'B2', 'meaning' => 'wanting to do or have something very much', 'meaning_id' => 'sangat ingin', 'example' => 'He was eager to learn.'],
                        ['phrase' => 'frantic', 'level' => 'C1', 'meaning' => 'wild or distraught with fear, anxiety, or other emotion', 'meaning_id' => 'panik / kalut', 'example' => 'She was frantic with worry.'],
                        ['phrase' => 'serene', 'level' => 'C1', 'meaning' => 'calm, peaceful, and untroubled', 'meaning_id' => 'tenang / damai', 'example' => 'Her face remained serene.'],
                        ['phrase' => 'chaotic', 'level' => 'C1', 'meaning' => 'in a state of complete confusion and disorder', 'meaning_id' => 'kacau', 'example' => 'The traffic was chaotic.'],
                        ['phrase' => 'turbulent', 'level' => 'C2', 'meaning' => 'characterized by conflict, disorder, or confusion; not controlled or calm', 'meaning_id' => 'bergejolak', 'example' => 'It was a turbulent period in history.'],
                        ['phrase' => 'impeccable', 'level' => 'C2', 'meaning' => 'in accordance with the highest standards of propriety; faultless', 'meaning_id' => 'sempurna / tanpa cacat', 'example' => 'He has impeccable manners.'],
                        ['phrase' => 'flawless', 'level' => 'C1', 'meaning' => 'without any blemishes or imperfections', 'meaning_id' => 'tanpa cela', 'example' => 'Her performance was flawless.'],
                        ['phrase' => 'pristine', 'level' => 'C2', 'meaning' => 'in its original condition; unspoiled', 'meaning_id' => 'murni / asli', 'example' => 'The beach was pristine.'],
                        ['phrase' => 'spoiled', 'level' => 'B2', 'meaning' => 'diminished or destroyed in value or quality', 'meaning_id' => 'rusak', 'example' => 'The view was spoiled by the building.'],
                        ['phrase' => 'polluted', 'level' => 'B2', 'meaning' => 'contaminated with harmful or poisonous substances', 'meaning_id' => 'tercemar', 'example' => 'The river is heavily polluted.'],
                        ['phrase' => 'contaminated', 'level' => 'C1', 'meaning' => 'made impure by exposure to polluting substances', 'meaning_id' => 'terkontaminasi', 'example' => 'The water supply was contaminated.'],
                        ['phrase' => 'hazardous', 'level' => 'C1', 'meaning' => 'risky; dangerous', 'meaning_id' => 'berbahaya', 'example' => 'These chemicals are hazardous.'],
                        ['phrase' => 'detrimental', 'level' => 'C2', 'meaning' => 'tending to cause harm', 'meaning_id' => 'merugikan', 'example' => 'Smoking is detrimental to health.'],
                        ['phrase' => 'beneficial', 'level' => 'B2', 'meaning' => 'resulting in good; favourable or advantageous', 'meaning_id' => 'bermanfaat', 'example' => 'Exercise is beneficial.'],
                        ['phrase' => 'advantageous', 'level' => 'C1', 'meaning' => 'involving or creating favorable circumstances that increase the chances of success or effectiveness', 'meaning_id' => 'menguntungkan', 'example' => 'It would be advantageous to wait.'],
                        ['phrase' => 'lucrative', 'level' => 'C2', 'meaning' => 'producing a great deal of profit', 'meaning_id' => 'menguntungkan (uang)', 'example' => 'He has a lucrative business.'],
                        ['phrase' => 'profitable', 'level' => 'B2', 'meaning' => 'yielding profit or financial gain', 'meaning_id' => 'menghasilkan untung', 'example' => 'The deal was very profitable.'],
                        ['phrase' => 'costly', 'level' => 'B2', 'meaning' => 'costing a lot; expensive', 'meaning_id' => 'mahal', 'example' => 'Mistakes can be costly.'],
                        ['phrase' => 'exorbitant', 'level' => 'C1', 'meaning' => 'unreasonably high (price)', 'meaning_id' => 'selangit / mahal sekali', 'example' => 'The prices are exorbitant.'],
                        ['phrase' => 'reasonable', 'level' => 'B2', 'meaning' => 'fair and sensible', 'meaning_id' => 'masuk akal', 'example' => 'The price was reasonable.'],
                        ['phrase' => 'affordable', 'level' => 'B2', 'meaning' => 'inexpensive; reasonably priced', 'meaning_id' => 'terjangkau', 'example' => 'Housing here is affordable.'],
                        ['phrase' => 'economical', 'level' => 'C1', 'meaning' => 'giving good value or service in relation to the amount of money, time, or effort spent', 'meaning_id' => 'hemat', 'example' => 'This car is economical to run.'],
                        ['phrase' => 'extravagant', 'level' => 'C1', 'meaning' => 'lacking restraint in spending money or using resources', 'meaning_id' => 'boros / mewah', 'example' => 'It was an extravagant wedding.'],
                        ['phrase' => 'lavish', 'level' => 'C1', 'meaning' => 'sumptuously rich, elaborate, or luxurious', 'meaning_id' => 'mewah berlimpah', 'example' => 'They held a lavish party.'],
                        ['phrase' => 'frugal', 'level' => 'C2', 'meaning' => 'sparing or economical with regard to money or food', 'meaning_id' => 'hemat sederhana', 'example' => 'He leads a frugal life.'],
                        ['phrase' => 'insufficient', 'level' => 'C1', 'meaning' => 'not enough; inadequate', 'meaning_id' => 'tidak cukup', 'example' => 'The funds were insufficient.'],
                        ['phrase' => 'scarce', 'level' => 'C1', 'meaning' => 'insufficient for the demand', 'meaning_id' => 'langka', 'example' => 'Food was scarce during the war.'],
                        ['phrase' => 'abundant', 'level' => 'B2', 'meaning' => 'existing or available in large quantities; plentiful', 'meaning_id' => 'berlimpah', 'example' => 'We have an abundant supply.'],
                        ['phrase' => 'plentiful', 'level' => 'B2', 'meaning' => 'existing in or yielding great quantities; abundant', 'meaning_id' => 'banyak', 'example' => 'Strawberries are plentiful in summer.'],
                        ['phrase' => 'ample', 'level' => 'C1', 'meaning' => 'enough or more than enough; plentiful', 'meaning_id' => 'cukup banyak', 'example' => 'There is ample time.'],
                        ['phrase' => 'excessive', 'level' => 'C1', 'meaning' => 'more than is necessary, normal, or desirable; immoderate', 'meaning_id' => 'berlebihan', 'example' => 'Excessive noise is prohibited.'],
                        ['phrase' => 'moderate', 'level' => 'B2', 'meaning' => 'average in amount, intensity, quality, or degree', 'meaning_id' => 'sedang', 'example' => 'Cook over moderate heat.'],
                        ['phrase' => 'drastic', 'level' => 'C1', 'meaning' => 'likely to have a strong or far-reaching effect; radical and extreme', 'meaning_id' => 'drastis', 'example' => 'Drastic measures are needed.'],
                        ['phrase' => 'radical', 'level' => 'C1', 'meaning' => 'relating to or affecting the fundamental nature of something', 'meaning_id' => 'radikal / mendasar', 'example' => 'We need radical changes.'],
                        ['phrase' => 'subtle', 'level' => 'C2', 'meaning' => 'making use of clever and indirect methods to achieve something', 'meaning_id' => 'halus / cerdik', 'example' => 'He used a subtle approach.'],
                        ['phrase' => 'complex', 'level' => 'B2', 'meaning' => 'consisting of many different and connected parts', 'meaning_id' => 'kompleks', 'example' => 'It is a complex issue.'],
                        ['phrase' => 'complicated', 'level' => 'B2', 'meaning' => 'consisting of many interconnecting parts or elements; intricate', 'meaning_id' => 'rumit', 'example' => 'The rules are complicated.'],
                        ['phrase' => 'intricate', 'level' => 'C2', 'meaning' => 'very complicated or detailed', 'meaning_id' => 'rumit mendetail', 'example' => 'The design is intricate.'],
                        ['phrase' => 'elaborate', 'level' => 'C1', 'meaning' => 'involving many carefully arranged parts or details; detailed and complicated in design and planning', 'meaning_id' => 'rumit terperinci', 'example' => 'They made elaborate plans.'],
                        ['phrase' => 'simplistic', 'level' => 'C1', 'meaning' => 'treating complex issues and problems as if they were much simpler than they really are', 'meaning_id' => 'terlalu sederhana', 'example' => 'His view is simplistic.'],
                        ['phrase' => 'fundamental', 'level' => 'C1', 'meaning' => 'forming a necessary base or core; of central importance', 'meaning_id' => 'mendasar', 'example' => 'Freedom represents a fundamental right.'],
                        ['phrase' => 'crucial', 'level' => 'B2', 'meaning' => 'decisive or critical, especially in the success or failure of something', 'meaning_id' => 'sangat penting', 'example' => 'Speed is crucial.'],
                        ['phrase' => 'essential', 'level' => 'B2', 'meaning' => 'absolutely necessary; extremely important', 'meaning_id' => 'penting sekali', 'example' => 'Water is essential for life.'],
                        ['phrase' => 'vital', 'level' => 'B2', 'meaning' => 'absolutely necessary or important; essential', 'meaning_id' => 'vital', 'example' => 'Trust is vital in a relationship.'],
                        ['phrase' => 'trivial', 'level' => 'C1', 'meaning' => 'of little value or importance', 'meaning_id' => 'sepele', 'example' => 'Don\'t worry about trivial details.'],
                        ['phrase' => 'insignificant', 'level' => 'C1', 'meaning' => 'too small or unimportant to be worth consideration', 'meaning_id' => 'tidak berarti', 'example' => 'The cost was insignificant.'],
                        ['phrase' => 'irrelevant', 'level' => 'B2', 'meaning' => 'not connected with or relevant to something', 'meaning_id' => 'tidak relevan', 'example' => 'That point is irrelevant.'],
                        ['phrase' => 'pertinent', 'level' => 'C2', 'meaning' => 'relevant or applicable to a particular matter', 'meaning_id' => 'relevan / berkaitan', 'example' => 'She asked pertinent questions.'],
                        ['phrase' => 'appropriate', 'level' => 'B2', 'meaning' => 'suitable or proper in the circumstances', 'meaning_id' => 'tepat / pantas', 'example' => 'Wear appropriate clothing.'],
                        ['phrase' => 'inappropriate', 'level' => 'B2', 'meaning' => 'not suitable or proper in the circumstances', 'meaning_id' => 'tidak pantas', 'example' => 'His behavior was inappropriate.'],
                        ['phrase' => 'suitable', 'level' => 'B2', 'meaning' => 'right or appropriate for a particular person, purpose, or situation', 'meaning_id' => 'cocok', 'example' => 'This movie is suitable for children.'],
                        ['phrase' => 'adequate', 'level' => 'B2', 'meaning' => 'satisfactory or acceptable in quality or quantity', 'meaning_id' => 'memadai', 'example' => 'The food was adequate.'],
                        ['phrase' => 'imminent', 'level' => 'C1', 'meaning' => 'about to happen', 'meaning_id' => 'sebentar lagi terjadi', 'example' => 'The storm is imminent.'],
                        ['phrase' => 'impending', 'level' => 'C2', 'meaning' => 'be about to happen', 'meaning_id' => 'menjelang', 'example' => 'He warned of impending danger.'],
                        ['phrase' => 'inevitable', 'level' => 'C1', 'meaning' => 'certain to happen; unavoidable', 'meaning_id' => 'tak terelakkan', 'example' => 'Change is inevitable.'],
                        ['phrase' => 'unavoidable', 'level' => 'B2', 'meaning' => 'not able to be avoided, prevented, or ignored; inevitable', 'meaning_id' => 'tak terhindarkan', 'example' => 'Delays are unavoidable.'],
                        ['phrase' => 'predictable', 'level' => 'B2', 'meaning' => 'able to be predicted', 'meaning_id' => 'mudah ditebak', 'example' => 'The ending was predictable.'],
                        ['phrase' => 'unpredictable', 'level' => 'B2', 'meaning' => 'not able to be foreseen or known beforehand; uncertain', 'meaning_id' => 'sulit ditebak', 'example' => 'The weather is unpredictable.'],
                        ['phrase' => 'reliable', 'level' => 'B2', 'meaning' => 'consistently good in quality or performance; able to be trusted', 'meaning_id' => 'dapat diandalkan', 'example' => 'He is a reliable friend.'],
                        ['phrase' => 'dependable', 'level' => 'C1', 'meaning' => 'trustworthy and reliable', 'meaning_id' => 'dapat bergantung', 'example' => 'She is a dependable worker.'],
                        ['phrase' => 'consistent', 'level' => 'B2', 'meaning' => 'acting or done in the same way over time, especially so as to be fair or accurate', 'meaning_id' => 'konsisten', 'example' => 'He is consistent in his work.'],
                        ['phrase' => 'persistent', 'level' => 'C1', 'meaning' => 'continuing firmly or obstinately in a course of action in spite of difficulty or opposition', 'meaning_id' => 'gigih / persisten', 'example' => 'She is persistent in her studies.'],
                        ['phrase' => 'relentless', 'level' => 'C2', 'meaning' => 'oppressively constant; incessant', 'meaning_id' => 'tak henti-hentinya', 'example' => 'The sun was relentless.'],
                        ['phrase' => 'ceaseless', 'level' => 'C2', 'meaning' => 'constant and unending', 'meaning_id' => 'tiada henti', 'example' => 'The ceaseless rain depressed me.'],
                        ['phrase' => 'eternal', 'level' => 'C1', 'meaning' => 'lasting or existing forever; without end or beginning', 'meaning_id' => 'abadi', 'example' => 'They swore eternal friendship.'],
                        ['phrase' => 'temporary', 'level' => 'B2', 'meaning' => 'lasting for only a limited period of time; not permanent', 'meaning_id' => 'sementara', 'example' => 'This is a temporary solution.'],
                        ['phrase' => 'provisional', 'level' => 'C2', 'meaning' => 'arranged or existing for the present, possibly to be changed later', 'meaning_id' => 'bersifat sementara / darurat', 'example' => 'It is a provisional government.'],
                        ['phrase' => 'tentative', 'level' => 'C2', 'meaning' => 'not certain or fixed; provisional', 'meaning_id' => 'tentatif / belum pasti', 'example' => 'We made a tentative plant.'],
                        ['phrase' => 'definite', 'level' => 'B2', 'meaning' => 'clearly stated or decided; not vague or doubtful', 'meaning_id' => 'pasti', 'example' => 'I need a definite answer.'],
                        ['phrase' => 'ambiguous', 'level' => 'C1', 'meaning' => 'open to more than one interpretation; having a double meaning', 'meaning_id' => 'ambigu / mendua', 'example' => 'The instructions were ambiguous.']
                    ]
                ],
                [
                    'slug' => 'part-3-discussion',
                    'title' => 'Part 3: Discussion',
                    'questions' => [
                        "1. Topik: Modern Technology\n- Do you think technology has made our lives more complicated?",
                        "2. Topik: Success\n- What qualities are necessary for a person to be successful?",
                        "3. Topik: Cities\n- What are the problems of living in a \"megacity\"?"
                    ],
                    'idioms' => [
                        ['phrase' => 'silver bullet', 'meaning' => 'a simple solution to a complicated problem', 'meaning_id' => 'solusi jitu', 'example' => 'There is no silver bullet for climate change.'],
                        ['phrase' => 'not rocket science', 'meaning' => 'not difficult to understand', 'meaning_id' => 'bukan hal yang rumit', 'example' => 'Using this app is not rocket science.'],
                        ['phrase' => 'light years ahead', 'meaning' => 'much more advanced', 'meaning_id' => 'jauh lebih maju', 'example' => 'Their technology is light years ahead of ours.'],
                        ['phrase' => 'push the envelope', 'meaning' => 'to go beyond limits', 'meaning_id' => 'menembus batas', 'example' => 'This company likes to push the envelope.'],
                        ['phrase' => 'bells and whistles', 'meaning' => 'extra features', 'meaning_id' => 'fitur tambahan', 'example' => 'The new phone has all the bells and whistles.'],
                        ['phrase' => 'sky is the limit', 'meaning' => 'there is no limit', 'meaning_id' => 'tidak ada batas', 'example' => 'For a talented person, the sky is the limit.'],
                        ['phrase' => 'recipe for disaster', 'meaning' => 'situation likely to cause trouble', 'meaning_id' => 'resep bencana', 'example' => 'Ignoring the problem is a recipe for disaster.'],
                        ['phrase' => 'concrete jungle', 'meaning' => 'city with many buildings and no nature', 'meaning_id' => 'hutan beton', 'example' => 'New York is a concrete jungle.'],
                        ['phrase' => 'rat race', 'meaning' => 'competitive struggle for wealth/power', 'meaning_id' => 'persaingan hidup yang keras', 'example' => 'He quit his job to escape the rat race.'],
                        ['phrase' => 'bright lights, big city', 'meaning' => 'excitement of city life', 'meaning_id' => 'gemerlap kota besar', 'example' => 'She was drawn to the bright lights, big city.']
                    ],
                    'collocations' => [
                        ['phrase' => 'indispensable tool', 'meaning' => 'absolutely necessary tool', 'meaning_id' => 'alat yang tak tergantikan', 'example' => 'The internet is an indispensable tool for students.'],
                        ['phrase' => 'user-friendly interface', 'meaning' => 'easy to use system', 'meaning_id' => 'antarmuka yang mudah digunakan', 'example' => 'Software needs a user-friendly interface.'],
                        ['phrase' => 'technological breakthrough', 'meaning' => 'important discovery', 'meaning_id' => 'terobosan teknologi', 'example' => 'Scientists made a major technological breakthrough.'],
                        ['phrase' => 'vital part', 'meaning' => 'very important part', 'meaning_id' => 'bagian vital', 'example' => 'Communication is a vital part of success.'],
                        ['phrase' => 'key factor', 'meaning' => 'important reason', 'meaning_id' => 'faktor kunci', 'example' => 'Education is a key factor in development.'],
                        ['phrase' => 'driving force', 'meaning' => 'power behind something', 'meaning_id' => 'kekuatan pendorong', 'example' => 'Ambition is his driving force.'],
                        ['phrase' => 'densely populated', 'meaning' => 'containing many people', 'meaning_id' => 'padat penduduk', 'example' => 'Jakarta is a densely populated city.'],
                        ['phrase' => 'urban sprawl', 'meaning' => 'spread of city into countryside', 'meaning_id' => 'perluasan kota yang tak terkendali', 'example' => 'Urban sprawl consumes farmland.'],
                        ['phrase' => 'traffic congestion', 'meaning' => 'heavy traffic', 'meaning_id' => 'kemacetan lalu lintas', 'example' => 'Traffic congestion is a major problem.'],
                        ['phrase' => 'high cost of living', 'meaning' => 'expensive to live there', 'meaning_id' => 'biaya hidup tinggi', 'example' => 'Megacities have a high cost of living.']
                    ],
                    'advanced_adjectives' => [
                        ['phrase' => 'innovative', 'level' => 'C1', 'meaning' => 'featuring new methods; advanced and original', 'meaning_id' => 'inovatif', 'example' => 'They have an innovative approach to business.'],
                        ['phrase' => 'cutting-edge', 'level' => 'C1', 'meaning' => 'at the most advanced stage of development', 'meaning_id' => 'canggih / terbaru', 'example' => 'We use cutting-edge technology.'],
                        ['phrase' => 'obsolete', 'level' => 'C1', 'meaning' => 'no longer produced or used; out of date', 'meaning_id' => 'usang / ketinggalan zaman', 'example' => 'The machinery is now obsolete.'],
                        ['phrase' => 'beneficial', 'level' => 'B2', 'meaning' => 'resulting in good; favourable or advantageous', 'meaning_id' => 'bermanfaat', 'example' => 'Exercise is beneficial to health.'],
                        ['phrase' => 'detrimental', 'level' => 'C2', 'meaning' => 'tending to cause harm', 'meaning_id' => 'merugikan', 'example' => 'Pollution is detrimental to the environment.'],
                        ['phrase' => 'substantial', 'level' => 'C1', 'meaning' => 'of considerable importance, size, or worth', 'meaning_id' => 'signifikan / banyak', 'example' => 'A substantial amount of money.'],
                        ['phrase' => 'populous', 'level' => 'C1', 'meaning' => 'having a large population; densely populated', 'meaning_id' => 'padat penduduk', 'example' => 'China is a populous country.'],
                        ['phrase' => 'prosperous', 'level' => 'C1', 'meaning' => 'successful in material terms; flourishing financially', 'meaning_id' => 'makmur', 'example' => 'The country is becoming more prosperous.'],
                        ['phrase' => 'sophisticated', 'level' => 'C1', 'meaning' => 'developed to a high degree of complexity', 'meaning_id' => 'canggih / rumit', 'example' => 'Highly sophisticated computer systems.'],
                        ['phrase' => 'unprecedented', 'level' => 'C2', 'meaning' => 'never done or known before', 'meaning_id' => 'belum pernah terjadi', 'example' => 'The scale of the disaster was unprecedented.'],
                        ['phrase' => 'pungent', 'level' => 'C2', 'meaning' => 'having a sharply strong taste or smell', 'meaning_id' => 'menyengat', 'example' => 'The pungent smell of onions filled the kitchen.'],
                        ['phrase' => 'aromatic', 'level' => 'C2', 'meaning' => 'having a pleasant and distinctive smell', 'meaning_id' => 'beraroma', 'example' => 'The coffee was rich and aromatic.'],
                        ['phrase' => 'subtle', 'level' => 'C2', 'meaning' => 'delicately complex and understated (scent)', 'meaning_id' => 'halus / samar', 'example' => 'She wore a subtle perfume.'],
                        ['phrase' => 'overpowering', 'level' => 'C2', 'meaning' => 'extremely strong or intense', 'meaning_id' => 'terlalu kuat', 'example' => 'The smell of paint was overpowering.'],
                        ['phrase' => 'undivided', 'level' => 'C2', 'meaning' => 'not shared with others; complete', 'meaning_id' => 'penuh / tak terbagi', 'example' => 'You have my undivided attention.'],
                        ['phrase' => 'fleeting', 'level' => 'C2', 'meaning' => 'lasting for a very short time', 'meaning_id' => 'sekilas / singkat', 'example' => 'I caught a fleeting glimpse of the car.'],
                        ['phrase' => 'intense', 'level' => 'C1', 'meaning' => 'of extreme force, degree, or strength', 'meaning_id' => 'intens / kuat', 'example' => 'The concentration required was intense.'],
                        ['phrase' => 'unwavering', 'level' => 'C2', 'meaning' => 'steady or resolute', 'meaning_id' => 'tak tergoyahkan', 'example' => 'His focus was unwavering throughout the game.'],
                        ['phrase' => 'monotonous', 'level' => 'C1', 'meaning' => 'dull, tedious, and repetitious', 'meaning_id' => 'monoton', 'example' => 'The task became monotonous after a while.'],
                        ['phrase' => 'exhilarating', 'level' => 'C2', 'meaning' => 'making one feel very happy, animated, or elated', 'meaning_id' => 'sangat seru', 'example' => 'It was an exhilarating experience.'],
                        ['phrase' => 'meticulous', 'level' => 'C2', 'meaning' => 'showing great attention to detail', 'meaning_id' => 'teliti', 'example' => 'She is meticulous about her presentation.'],
                        ['phrase' => 'diligent', 'level' => 'C1', 'meaning' => 'having or showing care and conscientiousness', 'meaning_id' => 'tekun', 'example' => 'A diligent student always finishes homework.'],
                        ['phrase' => 'gregarious', 'level' => 'C2', 'meaning' => 'fond of company; sociable', 'meaning_id' => 'suka bergaul', 'example' => 'He is a gregarious person who loves parties.'],
                        ['phrase' => 'apprehensive', 'level' => 'C1', 'meaning' => 'anxious or fearful that something bad will happen', 'meaning_id' => 'cemas', 'example' => 'I felt apprehensive about the interview.'],
                        ['phrase' => 'audacious', 'level' => 'C2', 'meaning' => 'showing a willingness to take surprisingly bold risks', 'meaning_id' => 'berani mati', 'example' => 'It was an audacious plan.'],
                        ['phrase' => 'conscientious', 'level' => 'C1', 'meaning' => 'wishing to do one\'s work or duty well and thoroughly', 'meaning_id' => 'bertanggung jawab', 'example' => 'He is a conscientious worker.'],
                        ['phrase' => 'inquisitive', 'level' => 'C1', 'meaning' => 'curious or inquiring', 'meaning_id' => 'ingin tahu', 'example' => 'She has an inquisitive mind.'],
                        ['phrase' => 'impartial', 'level' => 'C1', 'meaning' => 'treating all rivals or disputants equally', 'meaning_id' => 'adil / tidak memihak', 'example' => 'Judges must be impartial.'],
                        ['phrase' => 'candid', 'level' => 'C1', 'meaning' => 'truthful and straightforward; frank', 'meaning_id' => 'jujur / terus terang', 'example' => 'Currently, I will be candid with you.'],
                        ['phrase' => 'apathy', 'level' => 'C1', 'meaning' => 'lack of interest, enthusiasm, or concern', 'meaning_id' => 'apatis / masa bodoh', 'example' => 'There is widespread apathy among the voters.'],
                        ['phrase' => 'obstinate', 'level' => 'C2', 'meaning' => 'stubbornly refusing to change one\'s opinion', 'meaning_id' => 'keras kepala', 'example' => 'He can be very obstinate at times.'],
                        ['phrase' => 'gullible', 'level' => 'C1', 'meaning' => 'easily persuaded to believe something', 'meaning_id' => 'mudah tertipu', 'example' => 'Don\'t be so gullible.'],
                        ['phrase' => 'introverted', 'level' => 'B2', 'meaning' => 'shy and reticent', 'meaning_id' => 'tertutup', 'example' => 'She is introverted and prefers reading.'],
                        ['phrase' => 'extroverted', 'level' => 'B2', 'meaning' => 'outgoing and socially confident', 'meaning_id' => 'terbuka', 'example' => 'He is extroverted and loves meeting new people.'],
                        ['phrase' => 'compassionate', 'level' => 'C1', 'meaning' => 'feeling or showing sympathy and concern for others', 'meaning_id' => 'penuh kasih', 'example' => 'She is a compassionate nurse.'],
                        ['phrase' => 'amiable', 'level' => 'C1', 'meaning' => 'having or displaying a friendly and pleasant manner', 'meaning_id' => 'ramah', 'example' => 'He was an amiable companion.'],
                        ['phrase' => 'witty', 'level' => 'C1', 'meaning' => 'showing or characterized by quick and inventive verbal humor', 'meaning_id' => 'jenaka / cerdas', 'example' => 'She gave a witty reply.'],
                        ['phrase' => 'charismatic', 'level' => 'C1', 'meaning' => 'exercising a compelling charm that inspires devotion', 'meaning_id' => 'karismatik', 'example' => 'A charismatic leader is essential.'],
                        ['phrase' => 'assertive', 'level' => 'C1', 'meaning' => 'having or showing a confident and forceful personality', 'meaning_id' => 'tegas', 'example' => 'You need to be more assertive.'],
                        ['phrase' => 'diffident', 'level' => 'C2', 'meaning' => 'modest or shy because of a lack of self-confidence', 'meaning_id' => 'pemalu / ragu', 'example' => 'He was diffident about his own achievements.'],
                        ['phrase' => 'arrogant', 'level' => 'B2', 'meaning' => 'having or revealing an exaggerated sense of one\'s own importance', 'meaning_id' => 'sombong', 'example' => 'He came across as arrogant.'],
                        ['phrase' => 'narrow-minded', 'level' => 'B2', 'meaning' => 'not willing to accept ideas or ways of behaving that are different from your own', 'meaning_id' => 'berpikiran sempit', 'example' => 'Don\'t be so narrow-minded.'],
                        ['phrase' => 'open-minded', 'level' => 'B2', 'meaning' => 'willing to consider new ideas', 'meaning_id' => 'berpikiran terbuka', 'example' => 'It helps to be open-minded.'],
                        ['phrase' => 'trustworthy', 'level' => 'B2', 'meaning' => 'able to be relied on as honest or truthful', 'meaning_id' => 'dapat dipercaya', 'example' => 'He is a trustworthy employee.'],
                        ['phrase' => 'eccentric', 'level' => 'C1', 'meaning' => 'unconventional and slightly strange', 'meaning_id' => 'nyentrik', 'example' => 'She has an eccentric style of dressing.'],
                        ['phrase' => 'indifferent', 'level' => 'C1', 'meaning' => 'having no particular interest or sympathy', 'meaning_id' => 'acuh tak acuh', 'example' => 'He seemed indifferent to our plight.'],
                        ['phrase' => 'pessimistic', 'level' => 'B2', 'meaning' => 'tending to see the worst aspect of things', 'meaning_id' => 'pesimis', 'example' => 'He is pessimistic about the future.'],
                        ['phrase' => 'optimistic', 'level' => 'B2', 'meaning' => 'hopeful and confident about the future', 'meaning_id' => 'optimis', 'example' => 'She remains optimistic despite the problems.'],
                        ['phrase' => 'ambitious', 'level' => 'B2', 'meaning' => 'having or showing a strong desire and determination to succeed', 'meaning_id' => 'ambisius', 'example' => 'She is an ambitious lawyer.'],
                        ['phrase' => 'resourceful', 'level' => 'C1', 'meaning' => 'having the ability to find quick and clever ways to overcome difficulties', 'meaning_id' => 'banyak akal', 'example' => 'He is very resourceful in a crisis.'],
                        ['phrase' => 'adaptable', 'level' => 'C1', 'meaning' => 'able to adjust to new conditions', 'meaning_id' => 'mudah beradaptasi', 'example' => 'Adaptable employees are valued.'],
                        ['phrase' => 'versatile', 'level' => 'C1', 'meaning' => 'able to adapt or be adapted to many different functions or activities', 'meaning_id' => 'serba guna', 'example' => 'Leather is a versatile material.'],
                        ['phrase' => 'intuitive', 'level' => 'C1', 'meaning' => 'using or based on what one feels to be true even without conscious reasoning', 'meaning_id' => 'intuitif', 'example' => 'She has an intuitive understanding of the problem.'],
                        ['phrase' => 'rational', 'level' => 'C1', 'meaning' => 'based on or in accordance with reason or logic', 'meaning_id' => 'rasional', 'example' => 'We need a rational explanation.'],
                        ['phrase' => 'illogical', 'level' => 'B2', 'meaning' => 'lacking sense or clear, sound reasoning', 'meaning_id' => 'tidak logis', 'example' => 'His argument was illogical.'],
                        ['phrase' => 'coherent', 'level' => 'C1', 'meaning' => 'logical and consistent', 'meaning_id' => 'koheren / masuk akal', 'example' => 'The speaker gave a coherent presentation.'],
                        ['phrase' => 'articulate', 'level' => 'C1', 'meaning' => 'having or showing the ability to speak fluently and coherently', 'meaning_id' => 'pandai bicara', 'example' => 'She is an articulate speaker.'],
                        ['phrase' => 'eloquent', 'level' => 'C2', 'meaning' => 'fluent or persuasive in speaking or writing', 'meaning_id' => 'fasih / menyentuh hati', 'example' => 'He gave an eloquent speech.'],
                        ['phrase' => 'hesitant', 'level' => 'C1', 'meaning' => 'tentative, unsure, or slow in acting or speaking', 'meaning_id' => 'ragu-ragu', 'example' => 'She was hesitant to ask for help.'],
                        ['phrase' => 'reluctant', 'level' => 'C1', 'meaning' => 'unwilling and hesitant; disinclined', 'meaning_id' => 'enggan', 'example' => 'He was reluctant to leave.'],
                        ['phrase' => 'eager', 'level' => 'B2', 'meaning' => 'wanting to do or have something very much', 'meaning_id' => 'sangat ingin', 'example' => 'He was eager to learn.'],
                        ['phrase' => 'frantic', 'level' => 'C1', 'meaning' => 'wild or distraught with fear, anxiety, or other emotion', 'meaning_id' => 'panik / kalut', 'example' => 'She was frantic with worry.'],
                        ['phrase' => 'serene', 'level' => 'C1', 'meaning' => 'calm, peaceful, and untroubled', 'meaning_id' => 'tenang / damai', 'example' => 'Her face remained serene.'],
                        ['phrase' => 'chaotic', 'level' => 'C1', 'meaning' => 'in a state of complete confusion and disorder', 'meaning_id' => 'kacau', 'example' => 'The traffic was chaotic.'],
                        ['phrase' => 'turbulent', 'level' => 'C2', 'meaning' => 'characterized by conflict, disorder, or confusion; not controlled or calm', 'meaning_id' => 'bergejolak', 'example' => 'It was a turbulent period in history.'],
                        ['phrase' => 'impeccable', 'level' => 'C2', 'meaning' => 'in accordance with the highest standards of propriety; faultless', 'meaning_id' => 'sempurna / tanpa cacat', 'example' => 'He has impeccable manners.'],
                        ['phrase' => 'flawless', 'level' => 'C1', 'meaning' => 'without any blemishes or imperfections', 'meaning_id' => 'tanpa cela', 'example' => 'Her performance was flawless.'],
                        ['phrase' => 'pristine', 'level' => 'C2', 'meaning' => 'in its original condition; unspoiled', 'meaning_id' => 'murni / asli', 'example' => 'The beach was pristine.'],
                        ['phrase' => 'spoiled', 'level' => 'B2', 'meaning' => 'diminished or destroyed in value or quality', 'meaning_id' => 'rusak', 'example' => 'The view was spoiled by the building.'],
                        ['phrase' => 'polluted', 'level' => 'B2', 'meaning' => 'contaminated with harmful or poisonous substances', 'meaning_id' => 'tercemar', 'example' => 'The river is heavily polluted.'],
                        ['phrase' => 'contaminated', 'level' => 'C1', 'meaning' => 'made impure by exposure to polluting substances', 'meaning_id' => 'terkontaminasi', 'example' => 'The water supply was contaminated.'],
                        ['phrase' => 'hazardous', 'level' => 'C1', 'meaning' => 'risky; dangerous', 'meaning_id' => 'berbahaya', 'example' => 'These chemicals are hazardous.'],
                        ['phrase' => 'detrimental', 'level' => 'C2', 'meaning' => 'tending to cause harm', 'meaning_id' => 'merugikan', 'example' => 'Smoking is detrimental to health.'],
                        ['phrase' => 'beneficial', 'level' => 'B2', 'meaning' => 'resulting in good; favourable or advantageous', 'meaning_id' => 'bermanfaat', 'example' => 'Exercise is beneficial.'],
                        ['phrase' => 'advantageous', 'level' => 'C1', 'meaning' => 'involving or creating favorable circumstances that increase the chances of success or effectiveness', 'meaning_id' => 'menguntungkan', 'example' => 'It would be advantageous to wait.'],
                        ['phrase' => 'lucrative', 'level' => 'C2', 'meaning' => 'producing a great deal of profit', 'meaning_id' => 'menguntungkan (uang)', 'example' => 'He has a lucrative business.'],
                        ['phrase' => 'profitable', 'level' => 'B2', 'meaning' => 'yielding profit or financial gain', 'meaning_id' => 'menghasilkan untung', 'example' => 'The deal was very profitable.'],
                        ['phrase' => 'costly', 'level' => 'B2', 'meaning' => 'costing a lot; expensive', 'meaning_id' => 'mahal', 'example' => 'Mistakes can be costly.'],
                        ['phrase' => 'exorbitant', 'level' => 'C1', 'meaning' => 'unreasonably high (price)', 'meaning_id' => 'selangit / mahal sekali', 'example' => 'The prices are exorbitant.'],
                        ['phrase' => 'reasonable', 'level' => 'B2', 'meaning' => 'fair and sensible', 'meaning_id' => 'masuk akal', 'example' => 'The price was reasonable.'],
                        ['phrase' => 'affordable', 'level' => 'B2', 'meaning' => 'inexpensive; reasonably priced', 'meaning_id' => 'terjangkau', 'example' => 'Housing here is affordable.'],
                        ['phrase' => 'economical', 'level' => 'C1', 'meaning' => 'giving good value or service in relation to the amount of money, time, or effort spent', 'meaning_id' => 'hemat', 'example' => 'This car is economical to run.'],
                        ['phrase' => 'extravagant', 'level' => 'C1', 'meaning' => 'lacking restraint in spending money or using resources', 'meaning_id' => 'boros / mewah', 'example' => 'It was an extravagant wedding.'],
                        ['phrase' => 'lavish', 'level' => 'C1', 'meaning' => 'sumptuously rich, elaborate, or luxurious', 'meaning_id' => 'mewah berlimpah', 'example' => 'They held a lavish party.'],
                        ['phrase' => 'frugal', 'level' => 'C2', 'meaning' => 'sparing or economical with regard to money or food', 'meaning_id' => 'hemat sederhana', 'example' => 'He leads a frugal life.'],
                        ['phrase' => 'insufficient', 'level' => 'C1', 'meaning' => 'not enough; inadequate', 'meaning_id' => 'tidak cukup', 'example' => 'The funds were insufficient.'],
                        ['phrase' => 'scarce', 'level' => 'C1', 'meaning' => 'insufficient for the demand', 'meaning_id' => 'langka', 'example' => 'Food was scarce during the war.'],
                        ['phrase' => 'abundant', 'level' => 'B2', 'meaning' => 'existing or available in large quantities; plentiful', 'meaning_id' => 'berlimpah', 'example' => 'We have an abundant supply.'],
                        ['phrase' => 'plentiful', 'level' => 'B2', 'meaning' => 'existing in or yielding great quantities; abundant', 'meaning_id' => 'banyak', 'example' => 'Strawberries are plentiful in summer.'],
                        ['phrase' => 'ample', 'level' => 'C1', 'meaning' => 'enough or more than enough; plentiful', 'meaning_id' => 'cukup banyak', 'example' => 'There is ample time.'],
                        ['phrase' => 'excessive', 'level' => 'C1', 'meaning' => 'more than is necessary, normal, or desirable; immoderate', 'meaning_id' => 'berlebihan', 'example' => 'Excessive noise is prohibited.'],
                        ['phrase' => 'moderate', 'level' => 'B2', 'meaning' => 'average in amount, intensity, quality, or degree', 'meaning_id' => 'sedang', 'example' => 'Cook over moderate heat.'],
                        ['phrase' => 'drastic', 'level' => 'C1', 'meaning' => 'likely to have a strong or far-reaching effect; radical and extreme', 'meaning_id' => 'drastis', 'example' => 'Drastic measures are needed.'],
                        ['phrase' => 'radical', 'level' => 'C1', 'meaning' => 'relating to or affecting the fundamental nature of something', 'meaning_id' => 'radikal / mendasar', 'example' => 'We need radical changes.'],
                        ['phrase' => 'subtle', 'level' => 'C2', 'meaning' => 'making use of clever and indirect methods to achieve something', 'meaning_id' => 'halus / cerdik', 'example' => 'He used a subtle approach.'],
                        ['phrase' => 'complex', 'level' => 'B2', 'meaning' => 'consisting of many different and connected parts', 'meaning_id' => 'kompleks', 'example' => 'It is a complex issue.'],
                        ['phrase' => 'complicated', 'level' => 'B2', 'meaning' => 'consisting of many interconnecting parts or elements; intricate', 'meaning_id' => 'rumit', 'example' => 'The rules are complicated.'],
                        ['phrase' => 'intricate', 'level' => 'C2', 'meaning' => 'very complicated or detailed', 'meaning_id' => 'rumit mendetail', 'example' => 'The design is intricate.'],
                        ['phrase' => 'elaborate', 'level' => 'C1', 'meaning' => 'involving many carefully arranged parts or details; detailed and complicated in design and planning', 'meaning_id' => 'rumit terperinci', 'example' => 'They made elaborate plans.'],
                        ['phrase' => 'simplistic', 'level' => 'C1', 'meaning' => 'treating complex issues and problems as if they were much simpler than they really are', 'meaning_id' => 'terlalu sederhana', 'example' => 'His view is simplistic.'],
                        ['phrase' => 'fundamental', 'level' => 'C1', 'meaning' => 'forming a necessary base or core; of central importance', 'meaning_id' => 'mendasar', 'example' => 'Freedom represents a fundamental right.'],
                        ['phrase' => 'crucial', 'level' => 'B2', 'meaning' => 'decisive or critical, especially in the success or failure of something', 'meaning_id' => 'sangat penting', 'example' => 'Speed is crucial.'],
                        ['phrase' => 'essential', 'level' => 'B2', 'meaning' => 'absolutely necessary; extremely important', 'meaning_id' => 'penting sekali', 'example' => 'Water is essential for life.'],
                        ['phrase' => 'vital', 'level' => 'B2', 'meaning' => 'absolutely necessary or important; essential', 'meaning_id' => 'vital', 'example' => 'Trust is vital in a relationship.'],
                        ['phrase' => 'trivial', 'level' => 'C1', 'meaning' => 'of little value or importance', 'meaning_id' => 'sepele', 'example' => 'Don\'t worry about trivial details.'],
                        ['phrase' => 'insignificant', 'level' => 'C1', 'meaning' => 'too small or unimportant to be worth consideration', 'meaning_id' => 'tidak berarti', 'example' => 'The cost was insignificant.'],
                        ['phrase' => 'irrelevant', 'level' => 'B2', 'meaning' => 'not connected with or relevant to something', 'meaning_id' => 'tidak relevan', 'example' => 'That point is irrelevant.'],
                        ['phrase' => 'pertinent', 'level' => 'C2', 'meaning' => 'relevant or applicable to a particular matter', 'meaning_id' => 'relevan / berkaitan', 'example' => 'She asked pertinent questions.'],
                        ['phrase' => 'appropriate', 'level' => 'B2', 'meaning' => 'suitable or proper in the circumstances', 'meaning_id' => 'tepat / pantas', 'example' => 'Wear appropriate clothing.'],
                        ['phrase' => 'inappropriate', 'level' => 'B2', 'meaning' => 'not suitable or proper in the circumstances', 'meaning_id' => 'tidak pantas', 'example' => 'His behavior was inappropriate.'],
                        ['phrase' => 'suitable', 'level' => 'B2', 'meaning' => 'right or appropriate for a particular person, purpose, or situation', 'meaning_id' => 'cocok', 'example' => 'This movie is suitable for children.'],
                        ['phrase' => 'adequate', 'level' => 'B2', 'meaning' => 'satisfactory or acceptable in quality or quantity', 'meaning_id' => 'memadai', 'example' => 'The food was adequate.'],
                        ['phrase' => 'imminent', 'level' => 'C1', 'meaning' => 'about to happen', 'meaning_id' => 'sebentar lagi terjadi', 'example' => 'The storm is imminent.'],
                        ['phrase' => 'impending', 'level' => 'C2', 'meaning' => 'be about to happen', 'meaning_id' => 'menjelang', 'example' => 'He warned of impending danger.'],
                        ['phrase' => 'inevitable', 'level' => 'C1', 'meaning' => 'certain to happen; unavoidable', 'meaning_id' => 'tak terelakkan', 'example' => 'Change is inevitable.'],
                        ['phrase' => 'unavoidable', 'level' => 'B2', 'meaning' => 'not able to be avoided, prevented, or ignored; inevitable', 'meaning_id' => 'tak terhindarkan', 'example' => 'Delays are unavoidable.'],
                        ['phrase' => 'predictable', 'level' => 'B2', 'meaning' => 'able to be predicted', 'meaning_id' => 'mudah ditebak', 'example' => 'The ending was predictable.'],
                        ['phrase' => 'unpredictable', 'level' => 'B2', 'meaning' => 'not able to be foreseen or known beforehand; uncertain', 'meaning_id' => 'sulit ditebak', 'example' => 'The weather is unpredictable.'],
                        ['phrase' => 'reliable', 'level' => 'B2', 'meaning' => 'consistently good in quality or performance; able to be trusted', 'meaning_id' => 'dapat diandalkan', 'example' => 'He is a reliable friend.'],
                        ['phrase' => 'dependable', 'level' => 'C1', 'meaning' => 'trustworthy and reliable', 'meaning_id' => 'dapat bergantung', 'example' => 'She is a dependable worker.'],
                        ['phrase' => 'consistent', 'level' => 'B2', 'meaning' => 'acting or done in the same way over time, especially so as to be fair or accurate', 'meaning_id' => 'konsisten', 'example' => 'He is consistent in his work.'],
                        ['phrase' => 'persistent', 'level' => 'C1', 'meaning' => 'continuing firmly or obstinately in a course of action in spite of difficulty or opposition', 'meaning_id' => 'gigih / persisten', 'example' => 'She is persistent in her studies.'],
                        ['phrase' => 'relentless', 'level' => 'C2', 'meaning' => 'oppressively constant; incessant', 'meaning_id' => 'tak henti-hentinya', 'example' => 'The sun was relentless.'],
                        ['phrase' => 'ceaseless', 'level' => 'C2', 'meaning' => 'constant and unending', 'meaning_id' => 'tiada henti', 'example' => 'The ceaseless rain depressed me.'],
                        ['phrase' => 'eternal', 'level' => 'C1', 'meaning' => 'lasting or existing forever; without end or beginning', 'meaning_id' => 'abadi', 'example' => 'They swore eternal friendship.'],
                        ['phrase' => 'temporary', 'level' => 'B2', 'meaning' => 'lasting for only a limited period of time; not permanent', 'meaning_id' => 'sementara', 'example' => 'This is a temporary solution.'],
                        ['phrase' => 'provisional', 'level' => 'C2', 'meaning' => 'arranged or existing for the present, possibly to be changed later', 'meaning_id' => 'bersifat sementara / darurat', 'example' => 'It is a provisional government.'],
                        ['phrase' => 'tentative', 'level' => 'C2', 'meaning' => 'not certain or fixed; provisional', 'meaning_id' => 'tentatif / belum pasti', 'example' => 'We made a tentative plant.'],
                        ['phrase' => 'definite', 'level' => 'B2', 'meaning' => 'clearly stated or decided; not vague or doubtful', 'meaning_id' => 'pasti', 'example' => 'I need a definite answer.'],
                        ['phrase' => 'ambiguous', 'level' => 'C1', 'meaning' => 'open to more than one interpretation; having a double meaning', 'meaning_id' => 'ambigu / mendua', 'example' => 'The instructions were ambiguous.']
                    ]
                ]
            ]
        ],

        // Manual Injection for Lesson 9 (Advanced Adverb)
        [
            'slug' => 'lesson-9',
            'title' => 'Advanced Adverb',
            'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
            'color' => 'cyan',
            'subtopics' => [
                [
                    'slug' => 'part-1-daily-habits',
                    'title' => 'Part 1: Daily Habits & Preferences',
                    'questions' => [
                        "1. Topik: Daily Routine\n- How do you usually start your morning?",
                        "2. Topik: Learning English\n- How much has your English improved recently?",
                        "3. Topik: Shopping\n- Do you frequently buy things online?"
                    ],
                    'idioms' => [
                        ['phrase' => 'Creature of habit', 'meaning' => 'Someone who likes to do the same things at the same time every day', 'example' => 'I am a creature of habit; I always have coffee at 7 AM.'],
                        ['phrase' => 'Early bird', 'meaning' => 'A person who gets up or arrives early', 'example' => 'I am an early bird, so I love sunrise.'],
                        ['phrase' => 'Night owl', 'meaning' => 'A person who is active late at night', 'example' => 'My brother is a night owl.'],
                        ['phrase' => 'Run like clockwork', 'meaning' => 'To happen exactly as planned, without problems', 'example' => 'My morning routine runs like clockwork.'],
                        ['phrase' => 'In a rut', 'meaning' => 'Trapped in a boring routine', 'example' => 'I feel like I am in a rut lately.']
                    ],
                    'collocations' => [
                        ['phrase' => 'Stick to a routine', 'meaning' => 'To follow a fixed plan', 'example' => 'It is hard to stick to a routine on weekends.'],
                        ['phrase' => 'Break a habit', 'meaning' => 'To stop doing something you do regularly', 'example' => 'It takes time to break a bad habit.'],
                        ['phrase' => 'Daily grind', 'meaning' => 'Everyday work or routine, often boring', 'example' => 'I need a break from the daily grind.'],
                        ['phrase' => 'Spare time', 'meaning' => 'Free time', 'example' => 'In my spare time, I read books.'],
                        ['phrase' => 'Quality time', 'meaning' => 'Time spent giving all your attention to someone', 'example' => 'I spend quality time with my family.']
                    ],
                    'advanced_adjectives' => [
                        ['phrase' => 'meticulous', 'level' => 'C2', 'meaning' => 'showing great attention to detail; very careful and precise', 'meaning_id' => 'sangat teliti', 'example' => 'He is meticulous about his morning routine.'],
                        ['phrase' => 'hectic', 'level' => 'B2', 'meaning' => 'full of incessant or frantic activity', 'meaning_id' => 'sangat sibuk (kebut-kebutan)', 'example' => 'My mornings are usually quite hectic.'],
                        ['phrase' => 'productive', 'level' => 'B1', 'meaning' => 'achieving or producing a significant amount or result', 'meaning_id' => 'produktif', 'example' => 'I try to have a productive start to the day.'],
                        ['phrase' => 'sluggish', 'level' => 'C1', 'meaning' => 'slow-moving or inactive', 'meaning_id' => 'lamban / lesu', 'example' => 'I feel a bit sluggish before my coffee.'],
                        ['phrase' => 'invigorating', 'level' => 'C2', 'meaning' => 'making one feel strong, healthy, and full of energy', 'meaning_id' => 'menyegarkan / membangkitkan semangat', 'example' => 'A cold shower is quite invigorating.'],
                        ['phrase' => 'monotonous', 'level' => 'B2', 'meaning' => 'dull, tedious, and repetitious; lacking in variety and interest', 'meaning_id' => 'monoton / membosankan', 'example' => 'My routine can be a bit monotonous.'],
                        ['phrase' => 'fluent', 'level' => 'B2', 'meaning' => 'able to express oneself easily and articulately', 'meaning_id' => 'lancar', 'example' => 'I aim to become fluent in English.'],
                        ['phrase' => 'articulate', 'level' => 'C1', 'meaning' => 'having or showing the ability to speak fluently and coherently', 'meaning_id' => 'pandai berbicara', 'example' => 'She is an articulate speaker.'],
                        ['phrase' => 'intricate', 'level' => 'C1', 'meaning' => 'very complicated or detailed', 'meaning_id' => 'rumit', 'example' => 'English grammar can be quite intricate.'],
                        ['phrase' => 'comprehensive', 'level' => 'B2', 'meaning' => 'complete; including all or nearly all elements or aspects of something', 'meaning_id' => 'komprehensif / menyeluruh', 'example' => 'I need a comprehensive study plan.'],
                        ['phrase' => 'beneficial', 'level' => 'B2', 'meaning' => 'resulting in good; favourable or advantageous', 'meaning_id' => 'bermanfaat', 'example' => 'Reading is beneficial for vocabulary.'],
                        ['phrase' => 'challenging', 'level' => 'B2', 'meaning' => 'testing one\'s abilities; demanding', 'meaning_id' => 'menantang', 'example' => 'Listening tests can be challenging.'],
                        ['phrase' => 'convenient', 'level' => 'B1', 'meaning' => 'fitting in well with a person\'s needs, activities, and plans', 'meaning_id' => 'praktis / nyaman', 'example' => 'Online shopping is very convenient.'],
                        ['phrase' => 'impulsive', 'level' => 'C1', 'meaning' => 'acting or done without forethought', 'meaning_id' => 'impulsif', 'example' => 'I am an impulsive buyer.'],
                        ['phrase' => 'exorbitant', 'level' => 'C2', 'meaning' => '(of a price or amount charged) unreasonably high', 'meaning_id' => 'sangat mahal / selangit', 'example' => 'The shipping fees were exorbitant.'],
                        ['phrase' => 'affordable', 'level' => 'B2', 'meaning' => 'inexpensive; reasonably priced', 'meaning_id' => 'terjangkau', 'example' => 'I look for affordable clothes.'],
                        ['phrase' => 'durable', 'level' => 'B2', 'meaning' => 'able to withstand wear, pressure, or damage; hard-wearing', 'meaning_id' => 'tahan lama / awet', 'example' => 'I prefer durable products.'],
                        ['phrase' => 'trendy', 'level' => 'B2', 'meaning' => 'very fashionable or up to date', 'meaning_id' => 'kekinian / modis', 'example' => 'She always buys trendy items.'],
                        ['phrase' => 'essential', 'level' => 'B1', 'meaning' => 'absolutely necessary; extremely important', 'meaning_id' => 'penting / esensial', 'example' => 'I only buy essential items online.'],
                        ['phrase' => 'reliable', 'level' => 'B1', 'meaning' => 'consistently good in quality or performance; able to be trusted', 'meaning_id' => 'dapat diandalkan', 'example' => 'That online store is very reliable.']
                    ],
                    'advanced_adverbs' => [
                        ['phrase' => 'habitually', 'level' => 'B2', 'meaning' => 'by way of habit; customarily', 'meaning_id' => 'biasanya / secara kebiasaan', 'example' => 'I habitually drink water first thing in the morning.'],
                        ['phrase' => 'occasionally', 'level' => 'B2', 'meaning' => 'at infrequent or irregular intervals; now and then', 'meaning_id' => 'sesekali', 'example' => 'I occasionally skip breakfast.'],
                        ['phrase' => 'invigoratingly', 'level' => 'C2', 'meaning' => 'in a way that makes one feel strong, healthy, and full of energy', 'meaning_id' => 'dengan menyegarkan', 'example' => 'The cold air hit me invigoratingly.'],
                        ['phrase' => 'meticulously', 'level' => 'C2', 'meaning' => 'in a way that shows great attention to detail', 'meaning_id' => 'dengan sangat teliti', 'example' => 'I meticulously plan my day.'],
                        ['phrase' => 'significantly', 'level' => 'B2', 'meaning' => 'in a sufficiently great or important way as to be worthy of attention', 'meaning_id' => 'secara signifikan', 'example' => 'My English has improved significantly.'],
                        ['phrase' => 'remarkably', 'level' => 'B2', 'meaning' => 'in a way that is worthy of attention; distinctive', 'meaning_id' => 'luar biasa', 'example' => 'She progressed remarkably fast.'],
                        ['phrase' => 'steadily', 'level' => 'B2', 'meaning' => 'in a regular and even manner', 'meaning_id' => 'secara stabil', 'example' => 'My vocabulary is growing steadily.'],
                        ['phrase' => 'slightly', 'level' => 'B1', 'meaning' => 'to a small degree; not considerably', 'meaning_id' => 'sedikit', 'example' => 'My accent has changed slightly.'],
                        ['phrase' => 'constantly', 'level' => 'B2', 'meaning' => 'continuously over a period of time; always', 'meaning_id' => 'terus-menerus', 'example' => 'I am constantly looking for deals.'],
                        ['phrase' => 'rarely', 'level' => 'A2', 'meaning' => 'not often; seldom', 'meaning_id' => 'jarang', 'example' => 'I rarely buy clothes offline.'],
                        ['phrase' => 'impulsively', 'level' => 'C2', 'meaning' => 'without forethought; on impulse', 'meaning_id' => 'secara impulsif', 'example' => 'I sometimes shop impulsively.'],
                        ['phrase' => 'conveniently', 'level' => 'B1', 'meaning' => 'in a way that fits well with a person\'s needs or plans', 'meaning_id' => 'dengan praktis / nyaman', 'example' => 'The store is located conveniently nearby.']
                    ]
                ],
                [
                    'slug' => 'part-2-challenging-task',
                    'title' => 'Part 2: Cue Card (A Challenging Task)',
                    'questions' => [
                        "Describe a time when you had to finish a project quickly. You should say:\n- What the project was.\n- Why you had to do it hurriedly.\n- How efficiently you managed your time.\n- And explain how successfully you completed the task."
                    ],
                    'idioms' => [
                        ['phrase' => 'Bite off more than you can chew', 'meaning' => 'To try to do something that is too difficult for you', 'example' => 'I bit off more than I could chew with this project.'],
                        ['phrase' => 'Burn the midnight oil', 'meaning' => 'To work late into the night', 'example' => 'I had to burn the midnight oil to finish.'],
                        ['phrase' => 'Against the clock', 'meaning' => 'In a great hurry to finish before a deadline', 'example' => 'We were working against the clock.'],
                        ['phrase' => 'Throw in the towel', 'meaning' => 'To give up', 'example' => 'I almost threw in the towel, but I kept going.'],
                        ['phrase' => 'Smooth sailing', 'meaning' => 'Easy progress', 'example' => 'After the initial problems, it was smooth sailing.']
                    ],
                    'collocations' => [
                        ['phrase' => 'Meet a deadline', 'meaning' => 'To finish work on time', 'example' => 'It was stressful to meet the deadline.'],
                        ['phrase' => 'Heavy workload', 'meaning' => 'A large amount of work', 'example' => 'I had a heavy workload last week.'],
                        ['phrase' => 'Take on a challenge', 'meaning' => 'To accept a difficult task', 'example' => 'I decided to take on the challenge.'],
                        ['phrase' => 'Tight schedule', 'meaning' => 'A schedule with very little time between tasks', 'example' => 'We were on a tight schedule.'],
                        ['phrase' => 'Daunting task', 'meaning' => 'A task that seems difficult or frightening', 'example' => 'It seemed like a daunting task at first.']
                    ],
                    'advanced_adjectives' => [
                        ['phrase' => 'arduous', 'level' => 'C2', 'meaning' => 'involving or requiring strenuous effort; difficult and tiring', 'meaning_id' => 'berat / sukar', 'example' => 'The journey was arduous.'],
                        ['phrase' => 'complex', 'level' => 'B2', 'meaning' => 'consisting of many different and connected parts', 'meaning_id' => 'kompleks / rumit', 'example' => 'The problem was more complex than expected.'],
                        ['phrase' => 'demanding', 'level' => 'B2', 'meaning' => 'requiring much skill or effort', 'meaning_id' => 'menuntut (usaha/skill)', 'example' => 'It was a demanding schedule.'],
                        ['phrase' => 'grueling', 'level' => 'C1', 'meaning' => 'extremely tiring and demanding', 'meaning_id' => 'melelahkan / menyiksa', 'example' => 'The training was grueling.'],
                        ['phrase' => 'intricate', 'level' => 'C1', 'meaning' => 'very complicated or detailed', 'meaning_id' => 'rumit / terperinci', 'example' => 'The design was intricate.'],
                        ['phrase' => 'laborious', 'level' => 'C2', 'meaning' => 'requiring considerable effort and time', 'meaning_id' => 'memakan banyak tenaga', 'example' => 'Writing the report was laborious.'],
                        ['phrase' => 'tedious', 'level' => 'C1', 'meaning' => 'too long, slow, or dull; tiresome', 'meaning_id' => 'membosankan / menjemukan', 'example' => 'Data entry can be tedious.'],
                        ['phrase' => 'strenuous', 'level' => 'C1', 'meaning' => 'requiring or using great exertion', 'meaning_id' => 'berat / keras', 'example' => 'Avoid strenuous changes.'],
                        ['phrase' => 'formidable', 'level' => 'C2', 'meaning' => 'inspiring fear or respect through being impressively large or powerful', 'meaning_id' => 'hebat / menakutkan (tantangan)', 'example' => 'We faced a formidable opponent.'],
                        ['phrase' => 'pressing', 'level' => 'B2', 'meaning' => 'requiring quick or immediate action or attention', 'meaning_id' => 'mendesak', 'example' => 'There is a pressing need for change.'],
                        ['phrase' => 'pivotal', 'level' => 'C1', 'meaning' => 'of crucial importance in relation to the development or success of something else', 'meaning_id' => 'sangat penting / krusial', 'example' => 'It was a pivotal moment.'],
                        ['phrase' => 'rewarding', 'level' => 'B2', 'meaning' => 'providing satisfaction; gratifying', 'meaning_id' => 'memuaskan', 'example' => 'Teaching is a rewarding job.'],
                        ['phrase' => 'fulfilling', 'level' => 'B2', 'meaning' => 'making someone satisfied or happy through allowing the development of their character or abilities', 'meaning_id' => 'memuaskan batin', 'example' => 'It was a fulfilling experience.'],
                        ['phrase' => 'time-consuming', 'level' => 'B2', 'meaning' => 'taking a lot of time to do', 'meaning_id' => 'memakan waktu', 'example' => 'The process is very time-consuming.'],
                        ['phrase' => 'repetitive', 'level' => 'B2', 'meaning' => 'containing or characterized by repetition', 'meaning_id' => 'berulang-ulang', 'example' => 'I dislike repetitive tasks.'],
                        ['phrase' => 'urgent', 'level' => 'B1', 'meaning' => 'requiring immediate action or attention', 'meaning_id' => 'darurat / segera', 'example' => 'I have an urgent message.'],
                        ['phrase' => 'crucial', 'level' => 'B2', 'meaning' => 'decisive or critical, especially in the success or failure of something', 'meaning_id' => 'sangat penting', 'example' => 'Time management is crucial.'],
                        ['phrase' => 'vital', 'level' => 'B2', 'meaning' => 'absolutely necessary or important; essential', 'meaning_id' => 'vital / sangat penting', 'example' => 'Water is vital for life.'],
                        ['phrase' => 'painstaking', 'level' => 'C2', 'meaning' => 'done with or employing great care and thoroughness', 'meaning_id' => 'bersusah payah / teliti', 'example' => 'It required painstaking attention.'],
                        ['phrase' => 'rigorous', 'level' => 'C1', 'meaning' => 'extremely thorough, exhaustive, or accurate', 'meaning_id' => 'ketat / teliti', 'example' => 'The testing process was rigorous.']
                    ],
                    'advanced_adverbs' => [
                        ['phrase' => 'frenetically', 'level' => 'C2', 'meaning' => 'in a hurried, excited, or disorganized way', 'meaning_id' => 'dengan panik / terburu-buru', 'example' => 'I worked frenetically to meet the deadline.'],
                        ['phrase' => 'cautiously', 'level' => 'B2', 'meaning' => 'in a way that avoids potential problems or dangers', 'meaning_id' => 'dengan hati-hati', 'example' => 'I cautiously checked the details.'],
                        ['phrase' => 'surprisingly', 'level' => 'B2', 'meaning' => 'in a way that causes surprise; unexpectedly', 'meaning_id' => 'secara mengejutkan', 'example' => 'Surprisingly, I finished on time.'],
                        ['phrase' => 'immensely', 'level' => 'C1', 'meaning' => 'to a great extent; extremely', 'meaning_id' => 'sangat / luar biasa', 'example' => 'The client was immensely satisfied.'],
                        ['phrase' => 'efficiently', 'level' => 'B2', 'meaning' => 'in a way that achieves maximum productivity with minimum wasted effort', 'meaning_id' => 'dengan efisien', 'example' => 'I managed my time efficiently.'],
                        ['phrase' => 'hurriedly', 'level' => 'B2', 'meaning' => 'in a quick or hasty manner', 'meaning_id' => 'dengan tergesa-gesa', 'example' => 'I hurriedly packed my bag.'],
                        ['phrase' => 'successfully', 'level' => 'B2', 'meaning' => 'in a way that accomplishes a desired aim or result', 'meaning_id' => 'dengan sukses', 'example' => 'I completed the task successfully.'],
                        ['phrase' => 'frankly', 'level' => 'B2', 'meaning' => 'in an open, honest, and direct manner', 'meaning_id' => 'jujur saja / sejujurnya', 'example' => 'Frankly, it was difficult.'],
                        ['phrase' => 'inevitably', 'level' => 'B2', 'meaning' => 'as is certain to happen', 'meaning_id' => 'tak terelakkan', 'example' => 'Inevitably, there were some errors.'],
                        ['phrase' => 'personally', 'level' => 'B1', 'meaning' => 'from one\'s own viewpoint; subjectively', 'meaning_id' => 'secara pribadi', 'example' => 'Personally, I enjoyed the challenge.']
                    ]
                ],
                [
                    'slug' => 'part-3-general-trends',
                    'title' => 'Part 3: Discussion (General Trends)',
                    'questions' => [
                        "1. Topik: Technology & Society\n- How drastically has technology changed our communication?",
                        "2. Topik: Work-Life Balance\n- Is it adequately easy for people to find a balance between work and life today?",
                        "3. Topik: The Environment\n- Are people sufficiently aware of environmental issues?"
                    ],
                    'idioms' => [
                        ['phrase' => 'Move with the times', 'meaning' => 'To change and become modern', 'example' => 'Companies must move with the times.'],
                        ['phrase' => 'Turn a blind eye', 'meaning' => 'To ignore something that you know is wrong', 'example' => 'We cannot turn a blind eye to pollution.'],
                        ['phrase' => 'In the loop', 'meaning' => 'Aware of information', 'example' => 'Keep me in the loop about the changes.'],
                        ['phrase' => 'Tip of the iceberg', 'meaning' => 'A small part of a much bigger problem', 'example' => 'Plastic waste is just the tip of the iceberg.'],
                        ['phrase' => 'Blessing in disguise', 'meaning' => 'Something good that seemed bad at first', 'example' => 'Losing that job was a blessing in disguise.']
                    ],
                    'collocations' => [
                        ['phrase' => 'Technological advancement', 'meaning' => 'Progress in technology', 'example' => 'Technological advancement has changed communication.'],
                        ['phrase' => 'Significant impact', 'meaning' => 'A major effect', 'example' => 'Social media has a significant impact on society.'],
                        ['phrase' => 'Rapid change', 'meaning' => 'Change that happens very quickly', 'example' => 'We are seeing rapid change in the climate.'],
                        ['phrase' => 'Environmental awareness', 'meaning' => 'Understanding of environmental problems', 'example' => 'Environmental awareness is growing.'],
                        ['phrase' => 'Social media', 'meaning' => 'Websites and apps for social networking', 'example' => 'Social media connects people globally.']
                    ],
                    'advanced_adjectives' => [
                        ['phrase' => 'pervasive', 'level' => 'C2', 'meaning' => 'spreading widely throughout an area or a group of people', 'meaning_id' => 'meluas / merata', 'example' => 'The influence of tech is pervasive.'],
                        ['phrase' => 'ubiquitous', 'level' => 'C2', 'meaning' => 'present, appearing, or found everywhere', 'meaning_id' => 'ada di mana-mana', 'example' => 'Smartphones are now ubiquitous.'],
                        ['phrase' => 'indispensable', 'level' => 'C1', 'meaning' => 'absolutely necessary', 'meaning_id' => 'tak tergantikan / sangat perlu', 'example' => 'The internet is indispensable.'],
                        ['phrase' => 'revolutionary', 'level' => 'B2', 'meaning' => 'involving or causing a complete or dramatic change', 'meaning_id' => 'revolusioner', 'example' => 'It was a revolutionary idea.'],
                        ['phrase' => 'groundbreaking', 'level' => 'C1', 'meaning' => 'innovative; pioneering', 'meaning_id' => 'terobosan / inovatif', 'example' => 'This is groundbreaking research.'],
                        ['phrase' => 'obsolete', 'level' => 'C1', 'meaning' => 'no longer produced or used; out of date', 'meaning_id' => 'usang / ketinggalan jaman', 'example' => 'Floppy disks are obsolete.'],
                        ['phrase' => 'sustainable', 'level' => 'B2', 'meaning' => 'able to be maintained at a certain rate or level', 'meaning_id' => 'berkelanjutan', 'example' => 'We need sustainable energy.'],
                        ['phrase' => 'detrimental', 'level' => 'C2', 'meaning' => 'tending to cause harm', 'meaning_id' => 'merugikan chahay', 'example' => 'Smoking is detrimental to health.'],
                        ['phrase' => 'catastrophic', 'level' => 'C1', 'meaning' => 'involving or causing sudden great damage or suffering', 'meaning_id' => 'bencana / katastrofik', 'example' => 'The failure was catastrophic.'],
                        ['phrase' => 'unprecedented', 'level' => 'C1', 'meaning' => 'never done or known before', 'meaning_id' => 'belum pernah terjadi sebelumnya', 'example' => 'We face unprecedented challenges.'],
                        ['phrase' => 'widespread', 'level' => 'B2', 'meaning' => 'found or distributed over a large area or number of people', 'meaning_id' => 'tersebar luas', 'example' => 'There is widespread support.'],
                        ['phrase' => 'irreversible', 'level' => 'C1', 'meaning' => 'not able to be undone or altered', 'meaning_id' => 'tak dapat diubah', 'example' => 'The damage is irreversible.'],
                        ['phrase' => 'alarming', 'level' => 'B2', 'meaning' => 'worrying or disturbing', 'meaning_id' => 'mengkhawatirkan', 'example' => 'The rate of change is alarming.'],
                        ['phrase' => 'beneficial', 'level' => 'B2', 'meaning' => 'resulting in good; favourable', 'meaning_id' => 'bermanfaat', 'example' => 'The policy is beneficial.'],
                        ['phrase' => 'controversial', 'level' => 'B2', 'meaning' => 'giving rise or likely to give rise to public disagreement', 'meaning_id' => 'kontroversial', 'example' => 'It is a controversial topic.'],
                        ['phrase' => 'rampant', 'level' => 'C2', 'meaning' => '(especially of something unwelcome) flourishing or spreading unchecked', 'meaning_id' => 'merajalela', 'example' => 'Corruption was rampant.'],
                        ['phrase' => 'vulnerable', 'level' => 'B2', 'meaning' => 'susceptible to physical or emotional attack or harm', 'meaning_id' => 'rentan', 'example' => 'The elderly are vulnerable.'],
                        ['phrase' => 'optimistic', 'level' => 'B2', 'meaning' => 'hopeful and confident about the future', 'meaning_id' => 'optimis', 'example' => 'I am optimistic about the future.'],
                        ['phrase' => 'pessimistic', 'level' => 'B2', 'meaning' => 'tending to see the worst aspect of things', 'meaning_id' => 'pesimis', 'example' => 'Do not be so pessimistic.'],
                        ['phrase' => 'imperative', 'level' => 'C1', 'meaning' => 'of vital importance; crucial', 'meaning_id' => 'sangat penting / mendesak', 'example' => 'It is imperative to act now.']
                    ],
                    'advanced_adverbs' => [
                        ['phrase' => 'fundamentally', 'level' => 'C2', 'meaning' => 'in central or primary respects', 'meaning_id' => 'secara mendasar', 'example' => 'Society has changed fundamentally.'],
                        ['phrase' => 'undeniably', 'level' => 'C2', 'meaning' => 'used to emphasize that something is obviously true', 'meaning_id' => 'tak terbantahkan', 'example' => 'Technology is undeniably useful.'],
                        ['phrase' => 'irreversibly', 'level' => 'C2', 'meaning' => 'in a way that cannot be undone or altered', 'meaning_id' => 'secara permanen / tak bisa diubah', 'example' => 'Our climate is changing irreversibly.'],
                        ['phrase' => 'virtually', 'level' => 'B2', 'meaning' => 'nearly; almost', 'meaning_id' => 'hampir / seolah-olah', 'example' => 'Communication is now virtually instant.'],
                        ['phrase' => 'relatively', 'level' => 'B2', 'meaning' => 'in relation, comparison, or proportion to something else', 'meaning_id' => 'relatif', 'example' => 'It is relatively easy to find information.'],
                        ['phrase' => 'increasingly', 'level' => 'B2', 'meaning' => 'to an increasing extent; more and more', 'meaning_id' => 'semakin', 'example' => 'Prices are becoming increasingly high.'],
                        ['phrase' => 'barely', 'level' => 'B2', 'meaning' => 'only just; almost not', 'meaning_id' => 'nyaris tidak', 'example' => 'We barely have time to relax.'],
                        ['phrase' => 'fortunately', 'level' => 'B2', 'meaning' => 'it is fortunate that', 'meaning_id' => 'untungnya', 'example' => 'Fortunately, I had a backup.'],
                        ['phrase' => 'inadequately', 'level' => 'C1', 'meaning' => 'in a way that lacks the quality or quantity required', 'meaning_id' => 'secara tidak memadai', 'example' => 'The issue was addressed inadequately.'],
                        ['phrase' => 'partially', 'level' => 'B2', 'meaning' => 'only in part; to a limited extent', 'meaning_id' => 'sebagian', 'example' => 'I only partially agree.'],
                        ['phrase' => 'globally', 'level' => 'B2', 'meaning' => 'in a way that relates to the whole world', 'meaning_id' => 'secara global', 'example' => 'We must act globally.'],
                        ['phrase' => 'urgently', 'level' => 'B2', 'meaning' => 'in a way that requires immediate action or attention', 'meaning_id' => 'dengan mendesak', 'example' => 'We need to change urgently.'],
                        ['phrase' => 'regrettably', 'level' => 'C2', 'meaning' => 'unfortunately (used to express apology or sadness)', 'meaning_id' => 'sayangnya', 'example' => 'Regrettably, many ignore the signs.']
                    ]
                ]
            ]
        ],

        // Manual Injection for Lesson 10 (Advanced Verb)
        [
            'slug' => 'lesson-10',
            'title' => 'Advanced Verb',
            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
            'color' => 'emerald',
            'questions' => [], // Main questions empty primarily, using subtopics
            'subtopics' => [
                [
                    'slug' => 'part-1-daily-life',
                    'title' => 'Part 1: City Life & Infrastructure',
                    'questions' => [
                        "1. Topik: Transport Systems\n- How has the transportation system in your city changed recently?",
                        "2. Topik: Public Spaces\n- Do you think the government should invest more in public parks?",
                        "3. Topik: Building Styles\n- What kind of architecture is most common in your hometown?",
                        "4. Topik: Environmental Policy\n- How does your city handle waste management?"
                    ],
                    'idioms' => [
                        ['phrase' => 'bumper to bumper', 'meaning' => 'traffic that is so heavy that cars are touching', 'example' => 'The traffic was bumper to bumper.'],
                        ['phrase' => 'hustle and bustle', 'meaning' => 'busy and noisy activity', 'example' => 'I love the hustle and bustle of the city.'],
                        ['phrase' => 'concrete jungle', 'meaning' => 'a city with a high density of buildings and few green spaces', 'example' => 'This city is a concrete jungle.'],
                        ['phrase' => 'breath of fresh air', 'meaning' => 'a welcome change', 'example' => 'The new park is a breath of fresh air.'],
                        ['phrase' => 'stone\'s throw', 'meaning' => 'a very short distance', 'example' => 'It is just a stone\'s throw away.'],
                        ['phrase' => 'middle of nowhere', 'meaning' => 'a place that is far away from other people and houses', 'example' => 'We live in the middle of nowhere.'],
                        ['phrase' => 'off the beaten track', 'meaning' => 'in a place where few people go', 'example' => 'I like to go off the beaten track.'],
                        ['phrase' => 'quality of life', 'meaning' => 'the standard of health, comfort, and happiness', 'example' => 'The quality of life here is high.'],
                        ['phrase' => 'up and coming', 'meaning' => 'likely to become successful or popular', 'example' => 'It is an up and coming neighborhood.'],
                        ['phrase' => 'home away from home', 'meaning' => 'a place where you feel as comfortable as you do in your own home', 'example' => 'This cafe is my home away from home.']
                    ],
                    'collocations' => [
                        ['phrase' => 'public transport', 'meaning' => 'buses, trains, etc. that are available for the public to use', 'example' => 'I use public transport daily.'],
                        ['phrase' => 'traffic congestion', 'meaning' => 'a condition in which there are too many vehicles', 'example' => 'Traffic congestion is a problem.'],
                        ['phrase' => 'urban sprawl', 'meaning' => 'the uncontrolled expansion of urban areas', 'example' => 'Urban sprawl is increasing.'],
                        ['phrase' => 'waste management', 'meaning' => 'the collection, transport, processing, recycling or disposal of waste materials', 'example' => 'Efficient waste management is key.'],
                        ['phrase' => 'architectural style', 'meaning' => 'a specific method of construction or design', 'example' => 'The architectural style is modern.'],
                        ['phrase' => 'green space', 'meaning' => 'an area of grass, trees, or other vegetation set apart for recreational or aesthetic purposes in an otherwise urban environment', 'example' => 'We need more green space.'],
                        ['phrase' => 'carbon footprint', 'meaning' => 'the amount of carbon dioxide and other carbon compounds emitted due to the consumption of fossil fuels', 'example' => 'Reduce your carbon footprint.'],
                        ['phrase' => 'pedestrian zone', 'meaning' => 'areas of a city or town reserved for pedestrian-only use', 'example' => 'The center is a pedestrian zone.'],
                        ['phrase' => 'rush hour', 'meaning' => 'a time during each day when traffic is at its heaviest', 'example' => 'Avoid traveling during rush hour.'],
                        ['phrase' => 'residential area', 'meaning' => 'a land used in which housing predominates', 'example' => 'It is a quiet residential area.']
                    ],
                    'advanced_adjectives' => [
                        ['phrase' => 'productive', 'level' => 'B2', 'meaning' => 'achieving or producing a significant amount or result', 'meaning_id' => 'produktif', 'example' => 'I had a productive day.'],
                        ['phrase' => 'tedious', 'level' => 'C1', 'meaning' => 'too long, slow, or dull; tiresome or monotonous', 'meaning_id' => 'membosankan / melelahkan', 'example' => 'The journey was tedious.'],
                        ['phrase' => 'hectic', 'level' => 'C1', 'meaning' => 'full of incessant or frantic activity', 'meaning_id' => 'sangat sibuk / hiruk pikuk', 'example' => 'My schedule is hectic.'],
                        ['phrase' => 'challenging', 'level' => 'B2', 'meaning' => 'testing one\'s abilities; demanding', 'meaning_id' => 'menantang', 'example' => 'It was a challenging task.'],
                        ['phrase' => 'rewarding', 'level' => 'B2', 'meaning' => 'providing satisfaction; gratifying', 'meaning_id' => 'memuaskan / berharga', 'example' => 'Teaching is rewarding.'],
                        ['phrase' => 'essential', 'level' => 'B2', 'meaning' => 'absolutely necessary; extremely important', 'meaning_id' => 'sangat penting', 'example' => 'Water is essential.'],
                        ['phrase' => 'beneficial', 'level' => 'B2', 'meaning' => 'resulting in good; favorable or advantageous', 'meaning_id' => 'bermanfaat', 'example' => 'Exercise is beneficial.'],
                        ['phrase' => 'detrimental', 'level' => 'C2', 'meaning' => 'tending to cause harm', 'meaning_id' => 'merugikan', 'example' => 'Smoking is detrimental.'],
                        ['phrase' => 'monotonous', 'level' => 'C1', 'meaning' => 'dull, tedious, and repetitious; lacking in variety and interest', 'meaning_id' => 'monoton', 'example' => 'The work became monotonous.'],
                        ['phrase' => 'flexible', 'level' => 'B2', 'meaning' => 'able to be easily modified to respond to altered circumstances', 'meaning_id' => 'fleksibel', 'example' => 'My hours are flexible.']
                    ],
                    'advanced_adverbs' => [
                        ['phrase' => 'consistently', 'level' => 'C1', 'meaning' => 'in every case or on every occasion; invariably', 'meaning_id' => 'secara konsisten', 'example' => 'I consistently wake up early.'],
                        ['phrase' => 'remarkably', 'level' => 'B2', 'meaning' => 'in a way that is worthy of attention; strictly', 'meaning_id' => 'sangat / luar biasa', 'example' => 'She learns remarkably fast.'],
                        ['phrase' => 'occasionally', 'level' => 'B2', 'meaning' => 'at infrequent or irregular intervals; now and then', 'meaning_id' => 'sesekali', 'example' => 'I occasionally play games.'],
                        ['phrase' => 'rarely', 'level' => 'B1', 'meaning' => 'not often; seldom', 'meaning_id' => 'jarang', 'example' => 'I rarely skip breakfast.'],
                        ['phrase' => 'meticulously', 'level' => 'C2', 'meaning' => 'in a way that shows great attention to detail', 'meaning_id' => 'dengan sangat teliti', 'example' => 'He plans his day meticulously.'],
                        ['phrase' => 'drastically', 'level' => 'C1', 'meaning' => 'in a way that is likely to have a strong or far-reaching effect', 'meaning_id' => 'secara drastis', 'example' => 'My routine changed drastically.'],
                        ['phrase' => 'initially', 'level' => 'B2', 'meaning' => 'at first', 'meaning_id' => 'pada awalnya', 'example' => 'Initially, it was hard.'],
                        ['phrase' => 'ultimately', 'level' => 'C1', 'meaning' => 'finally; in the end', 'meaning_id' => 'pada akhirnya', 'example' => 'Ultimately, I succeeded.'],
                        ['phrase' => 'inevitably', 'level' => 'B2', 'meaning' => 'as is certain to happen; unavoidably', 'meaning_id' => 'secara tak terelakkan', 'example' => 'Inevitably, I get tired.'],
                        ['phrase' => 'significantly', 'level' => 'B2', 'meaning' => 'in a sufficiently great or important way as to be worthy of attention', 'meaning_id' => 'secara signifikan', 'example' => 'It helps significantly.']
                    ],
                    'advanced_verbs' => [
                        // Q1: Transport Systems
                        [
                            ['phrase' => 'undergo', 'level' => 'B2', 'meaning' => 'experience changes', 'meaning_id' => 'mengalami', 'example' => 'The system underwent changes.'],
                            ['phrase' => 'modernize', 'level' => 'B2', 'meaning' => 'adapt to modern needs', 'meaning_id' => 'memodernisasi', 'example' => 'We must modernize the trains.'],
                            ['phrase' => 'expand', 'level' => 'B2', 'meaning' => 'become or make larger', 'meaning_id' => 'memperluas', 'example' => 'They expanded the metro line.'],
                            ['phrase' => 'commute', 'level' => 'B2', 'meaning' => 'travel some distance to work', 'meaning_id' => 'bepergian (kerja)', 'example' => 'I commute daily by bus.'],
                            ['phrase' => 'upgrade', 'level' => 'B2', 'meaning' => 'raise to a higher standard', 'meaning_id' => 'meningkatkan', 'example' => 'They upgraded the ticketing system.'],
                            ['phrase' => 'implement', 'level' => 'B2', 'meaning' => 'put into effect', 'meaning_id' => 'menerapkan', 'example' => 'A new policy was implemented.'],
                            ['phrase' => 'congest', 'level' => 'C1', 'meaning' => 'crowd road so as to hinder freedom of movement', 'meaning_id' => 'memacetkan', 'example' => 'Traffic congests the city center.'],
                            ['phrase' => 'alleviate', 'level' => 'C1', 'meaning' => 'make less severe', 'meaning_id' => 'meringankan', 'example' => 'This will alleviate traffic.'],
                            ['phrase' => 'subsidize', 'level' => 'C1', 'meaning' => 'support financially', 'meaning_id' => 'mensubsidi', 'example' => 'Public transport is subsidized.'],
                            ['phrase' => 'integrate', 'level' => 'C1', 'meaning' => 'combine with another so they become a whole', 'meaning_id' => 'mengintegrasikan', 'example' => 'The buses are integrated with trains.'],
                            ['phrase' => 'optimize', 'level' => 'C1', 'meaning' => 'make the best use of', 'meaning_id' => 'mengoptimalkan', 'example' => 'We must optimize routes.'],
                            ['phrase' => 'rely', 'level' => 'B2', 'meaning' => 'depend on with full trust', 'meaning_id' => 'mengandalkan', 'example' => 'Many rely on cars.'],
                            ['phrase' => 'discourage', 'level' => 'B2', 'meaning' => 'persuade against an action', 'meaning_id' => 'mencegah / tidak menganjurkan', 'example' => 'High parking fees discourage driving.'],
                            ['phrase' => 'promote', 'level' => 'B2', 'meaning' => 'support or encourage', 'meaning_id' => 'mempromosikan', 'example' => 'They promote cycling.'],
                            ['phrase' => 'accessible', 'level' => 'B2', 'meaning' => 'able to be reached or entered', 'meaning_id' => 'dapat diakses', 'example' => 'Stations must be accessible.'],
                            ['phrase' => 'efficient', 'level' => 'B2', 'meaning' => 'achieving maximum productivity', 'meaning_id' => 'efisien', 'example' => 'Trains are efficient.'],
                            ['phrase' => 'sustainable', 'level' => 'B2', 'meaning' => 'able to be maintained', 'meaning_id' => 'berkelanjutan', 'example' => 'Electric buses are sustainable.'],
                            ['phrase' => 'punctual', 'level' => 'B2', 'meaning' => 'happening or doing something at the agreed time', 'meaning_id' => 'tepat waktu', 'example' => 'Buses are rarely punctual.'],
                            ['phrase' => 'affordable', 'level' => 'B2', 'meaning' => 'inexpensive', 'meaning_id' => 'terjangkau', 'example' => 'Fares should be affordable.'],
                            ['phrase' => 'revolutionize', 'level' => 'C1', 'meaning' => 'change radically', 'meaning_id' => 'merevolusi', 'example' => 'This will revolutionize travel.']
                        ],
                        // Q2: Public Spaces
                        [
                            ['phrase' => 'allocate', 'level' => 'C1', 'meaning' => 'distribute for a particular purpose', 'meaning_id' => 'mengalokasikan', 'example' => 'Funds were allocated for parks.'],
                            ['phrase' => 'refurbish', 'level' => 'C1', 'meaning' => 'renovate and redecorate', 'meaning_id' => 'merenovasi', 'example' => 'The park was refurbished.'],
                            ['phrase' => 'enhance', 'level' => 'B2', 'meaning' => 'intensify, increase, or further improve', 'meaning_id' => 'meningkatkan', 'example' => 'Trees enhance the view.'],
                            ['phrase' => 'conserve', 'level' => 'C1', 'meaning' => 'protect from harm or destruction', 'meaning_id' => 'melestarikan', 'example' => 'We must conserve green spaces.'],
                            ['phrase' => 'maintain', 'level' => 'B2', 'meaning' => 'cause or enable to continue', 'meaning_id' => 'memelihara', 'example' => 'The city maintains the gardens.'],
                            ['phrase' => 'beautify', 'level' => 'C1', 'meaning' => 'improve the appearance of', 'meaning_id' => 'mempercantik', 'example' => 'Flowers beautify the street.'],
                            ['phrase' => 'utilize', 'level' => 'B2', 'meaning' => 'make practical and effective use of', 'meaning_id' => 'memanfaatkan', 'example' => 'Residents utilize the park daily.'],
                            ['phrase' => 'preserve', 'level' => 'B2', 'meaning' => 'maintain in its original or existing state', 'meaning_id' => 'menjaga / mengawetkan', 'example' => 'We preserve historic statues.'],
                            ['phrase' => 'neglect', 'level' => 'C1', 'meaning' => 'fail to care for properly', 'meaning_id' => 'menelantarkan', 'example' => 'Some areas are neglected.'],
                            ['phrase' => 'revitalize', 'level' => 'C1', 'meaning' => 'imbue with new life and vitality', 'meaning_id' => 'menghidupkan kembali', 'example' => 'The project revitalized the area.'],
                            ['phrase' => 'designate', 'level' => 'C1', 'meaning' => 'appoint someone to a specified position', 'meaning_id' => 'menunjuk / menetapkan', 'example' => 'This land is designated as a park.'],
                            ['phrase' => 'encourage', 'level' => 'B2', 'meaning' => 'give support, confidence, or hope', 'meaning_id' => 'mendorong', 'example' => 'Parks encourage exercise.'],
                            ['phrase' => 'facilitate', 'level' => 'C1', 'meaning' => 'make an action or process easy or easier', 'meaning_id' => 'memfasilitasi', 'example' => 'Paths facilitate walking.'],
                            ['phrase' => 'prioritize', 'level' => 'B2', 'meaning' => 'designate or treat as more important', 'meaning_id' => 'memprioritaskan', 'example' => 'We prioritize clean air.'],
                            ['phrase' => 'invest', 'level' => 'B2', 'meaning' => 'expend money with expectation of profit', 'meaning_id' => 'berinvestasi', 'example' => 'They invest in playgrounds.'],
                            ['phrase' => 'socialize', 'level' => 'B2', 'meaning' => 'mix socially with others', 'meaning_id' => 'bersosialisasi', 'example' => 'People socialize here.'],
                            ['phrase' => 'gather', 'level' => 'B2', 'meaning' => 'come together; assemble or accumulate', 'meaning_id' => 'berkumpul', 'example' => 'Families gather on weekends.'],
                            ['phrase' => 'relax', 'level' => 'A2', 'meaning' => 'make or become less tense or anxious', 'meaning_id' => 'bersantai', 'example' => 'A place to relax.'],
                            ['phrase' => 'escape', 'level' => 'B1', 'meaning' => 'break free from confinement or control', 'meaning_id' => 'melarikan diri (dari hiruk pikuk)', 'example' => 'Escape the city noise.'],
                            ['phrase' => 'appreciate', 'level' => 'B2', 'meaning' => 'recognize the full worth of', 'meaning_id' => 'menghargai', 'example' => 'We appreciate nature.']
                        ],
                        // Q3: Building Styles
                        [
                            ['phrase' => 'dominate', 'level' => 'B2', 'meaning' => 'have a commanding influence on', 'meaning_id' => 'mendominasi', 'example' => 'Skyscrapers dominate the skyline.'],
                            ['phrase' => 'characterize', 'level' => 'B2', 'meaning' => 'describe the distinctive nature or features of', 'meaning_id' => 'mencirikan', 'example' => 'Red bricks characterize the town.'],
                            ['phrase' => 'resemble', 'level' => 'B2', 'meaning' => 'have qualities or features, especially those of appearance, in common with', 'meaning_id' => 'menyerupai', 'example' => 'It resembles a castle.'],
                            ['phrase' => 'incorporate', 'level' => 'C2', 'meaning' => 'take in or contain as part of a whole', 'meaning_id' => 'menggabungkan', 'example' => 'The design incorporates glass.'],
                            ['phrase' => 'construct', 'level' => 'B2', 'meaning' => 'build or erect', 'meaning_id' => 'membangun', 'example' => 'It was constructed in 1990.'],
                            ['phrase' => 'demolish', 'level' => 'C1', 'meaning' => 'pull or knock down', 'meaning_id' => 'menghancurkan / merobohkan', 'example' => 'Old houses were demolished.'],
                            ['phrase' => 'renovate', 'level' => 'B2', 'meaning' => 'restore somewhat to a good state of repair', 'meaning_id' => 'merenovasi', 'example' => 'They renovated the facade.'],
                            ['phrase' => 'restore', 'level' => 'B2', 'meaning' => 'bring back', 'meaning_id' => 'memulihkan', 'example' => 'They restored the old church.'],
                            ['phrase' => 'modernize', 'level' => 'B2', 'meaning' => 'adapt to modern needs or habits', 'meaning_id' => 'memodernisasi', 'example' => 'They modernized the interior.'],
                            ['phrase' => 'preserve', 'level' => 'B2', 'meaning' => 'maintain in its original or existing state', 'meaning_id' => 'mempertahankan', 'example' => 'We must preserve heritage.'],
                            ['phrase' => 'contrast', 'level' => 'B2', 'meaning' => 'differ strikingly', 'meaning_id' => 'kontras / berbeda', 'example' => 'Old contrasts with new.'],
                            ['phrase' => 'blend', 'level' => 'C1', 'meaning' => 'mix or combine together', 'meaning_id' => 'berpadu', 'example' => 'The styles blend well.'],
                            ['phrase' => 'inspire', 'level' => 'B2', 'meaning' => 'fill with the urge or ability to do or feel something', 'meaning_id' => 'menginspirasi', 'example' => 'Nature inspired the design.'],
                            ['phrase' => 'reflect', 'level' => 'B2', 'meaning' => 'embody or represent', 'meaning_id' => 'mencerminkan', 'example' => 'It reflects local culture.'],
                            ['phrase' => 'occupy', 'level' => 'B2', 'meaning' => 'reside or have one\'s place of business in', 'meaning_id' => 'menempati', 'example' => 'Offices occupy the tower.'],
                            ['phrase' => 'tower', 'level' => 'C1', 'meaning' => 'rise to or reach a great height', 'meaning_id' => 'menjulang', 'example' => 'The spire towers above all.'],
                            ['phrase' => 'house', 'level' => 'B2', 'meaning' => 'provide space for; contain or accommodate', 'meaning_id' => 'menampung', 'example' => 'The building houses a museum.'],
                            ['phrase' => 'adorn', 'level' => 'C2', 'meaning' => 'make more beautiful or attractive', 'meaning_id' => 'menghiasi', 'example' => 'Statues adorn the roof.'],
                            ['phrase' => 'symbolize', 'level' => 'C1', 'meaning' => 'be a symbol of', 'meaning_id' => 'melambangkan', 'example' => 'It symbolizes progress.'],
                            ['phrase' => 'transform', 'level' => 'B2', 'meaning' => 'make a thorough or dramatic change in', 'meaning_id' => 'mengubah', 'example' => 'The skyline transformed.'],
                        ],
                        // Q4: Environmental Policy
                        [
                            ['phrase' => 'implement', 'level' => 'B2', 'meaning' => 'put into effect', 'meaning_id' => 'menerapkan', 'example' => 'They implemented a ban.'],
                            ['phrase' => 'regulate', 'level' => 'B2', 'meaning' => 'control or maintain the rate or speed of', 'meaning_id' => 'mengatur', 'example' => 'We must regulate waste.'],
                            ['phrase' => 'discard', 'level' => 'C1', 'meaning' => 'get rid of as no longer useful or desirable', 'meaning_id' => 'membuang', 'example' => 'Do not discard batteries here.'],
                            ['phrase' => 'recycle', 'level' => 'A2', 'meaning' => 'convert into reusable material', 'meaning_id' => 'mendaur ulang', 'example' => 'We recycle paper.'],
                            ['phrase' => 'pollute', 'level' => 'B2', 'meaning' => 'contaminate with harmful or poisonous substances', 'meaning_id' => 'mencemari', 'example' => 'Factoris pollute the air.'],
                            ['phrase' => 'contaminate', 'level' => 'C1', 'meaning' => 'make impure by exposure to polluting substances', 'meaning_id' => 'mengkontaminasi', 'example' => 'Water was contaminated.'],
                            ['phrase' => 'impose', 'level' => 'C1', 'meaning' => 'force (something welcome or unfamiliar) to be accepted or put in place', 'meaning_id' => 'memberlakukan', 'example' => 'They imposed a fine.'],
                            ['phrase' => 'fine', 'level' => 'B2', 'meaning' => 'punish by making pay money', 'meaning_id' => 'mendenda', 'example' => 'Litterers are fined.'],
                            ['phrase' => 'ban', 'level' => 'B2', 'meaning' => 'officially or legally prohibit', 'meaning_id' => 'melarang', 'example' => 'Plastic bags are banned.'],
                            ['phrase' => 'prohibit', 'level' => 'B2', 'meaning' => 'formally forbid by law', 'meaning_id' => 'melarang keras', 'example' => 'Smoking is prohibited.'],
                            ['phrase' => 'encourage', 'level' => 'B2', 'meaning' => 'give support, confidence, or hope', 'meaning_id' => 'menganjurkan', 'example' => 'We encourage reusing.'],
                            ['phrase' => 'segregate', 'level' => 'C1', 'meaning' => 'set apart from the rest or from each other', 'meaning_id' => 'memisahkan', 'example' => 'Segregate your waste.'],
                            ['phrase' => 'dump', 'level' => 'C1', 'meaning' => 'deposit or dispose of (garbage, waste, or unwanted material), typically in a careless or hurried way', 'meaning_id' => 'membuang sembarangan', 'example' => 'Don\'t dump trash here.'],
                            ['phrase' => 'minimize', 'level' => 'B2', 'meaning' => 'reduce to the smallest possible amount', 'meaning_id' => 'meminimalkan', 'example' => 'Minimize your carbon footprint.'],
                            ['phrase' => 'reduce', 'level' => 'A2', 'meaning' => 'make smaller or less in amount', 'meaning_id' => 'mengurangi', 'example' => 'Reduce plastic use.'],
                            ['phrase' => 'reuse', 'level' => 'B1', 'meaning' => 'use again or more than once', 'meaning_id' => 'menggunakan kembali', 'example' => 'Reuse glass bottles.'],
                            ['phrase' => 'compost', 'level' => 'C2', 'meaning' => 'make into compost', 'meaning_id' => 'membuat kompos', 'example' => 'We compost food scraps.'],
                            ['phrase' => 'adopt', 'level' => 'B2', 'meaning' => 'choose to take up, follow, or use', 'meaning_id' => 'mengadopsi (kebijakan)', 'example' => 'Adopt green habits.'],
                            ['phrase' => 'enforce', 'level' => 'C1', 'meaning' => 'compel observance of or compliance with', 'meaning_id' => 'menegakkan', 'example' => 'Enforce the law.'],
                            ['phrase' => 'monitor', 'level' => 'B2', 'meaning' => 'observe and check the progress or quality of', 'meaning_id' => 'memantau', 'example' => 'We monitor pollution levels.']
                        ]
                    ]
                ],
                [
                    'slug' => 'part-2-change',
                    'title' => 'Part 2: Cue Card (A Change or Achievement)',
                    'questions' => [
                        "Describe a significant change that you made in your life. You should say:\n- What the change was.\n- Why you decided to implement this change.\n- How you executed your plan.\n- And explain how this change has transformed your life."
                    ],
                    'idioms' => [
                        ['phrase' => 'turn over a new leaf', 'meaning' => 'start to act or behave in a better or more responsible way', 'example' => 'I decided to turn over a new leaf.'],
                        ['phrase' => 'fresh start', 'meaning' => 'an opportunity to begin something again', 'example' => 'I needed a fresh start.'],
                        ['phrase' => 'change of heart', 'meaning' => 'move to a different opinion or attitude', 'example' => 'He had a change of heart.'],
                        ['phrase' => 'winds of change', 'meaning' => 'forces that have the power to change things', 'example' => 'The winds of change are blowing.'],
                        ['phrase' => 'break the mold', 'meaning' => 'do something in a new way', 'example' => 'She broke the mold.'],
                        ['phrase' => 'clean slate', 'meaning' => 'an opportunity to start over without prejudice', 'example' => 'Start with a clean slate.'],
                        ['phrase' => 'sea change', 'meaning' => 'a profound or notable transformation', 'example' => 'There was a sea change in opinion.'],
                        ['phrase' => 'change for the better', 'meaning' => 'an improvement', 'example' => 'It was a change for the better.'],
                        ['phrase' => 'teach an old dog new tricks', 'meaning' => 'it is difficult to make someone change their habits', 'example' => 'You can\'t teach an old dog new tricks.'],
                        ['phrase' => 'shake things up', 'meaning' => 'make significant changes', 'example' => 'We need to shake things up.']
                    ],
                    'collocations' => [
                        ['phrase' => 'significant change', 'meaning' => 'important or noticeable change', 'example' => 'A significant change occurred.'],
                        ['phrase' => 'radical transformation', 'meaning' => 'complete change', 'example' => 'It underwent a radical transformation.'],
                        ['phrase' => 'implement a plan', 'meaning' => 'put a plan into action', 'example' => 'I implemented the plan.'],
                        ['phrase' => 'adapt to circumstances', 'meaning' => 'change behavior to fit new situations', 'example' => 'Adapt to changing circumstances.'],
                        ['phrase' => 'dramatic shift', 'meaning' => 'a sudden and striking change', 'example' => 'A dramatic shift in policy.'],
                        ['phrase' => 'gradual process', 'meaning' => 'happening slowly over time', 'example' => 'Healing is a gradual process.'],
                        ['phrase' => 'fundamental difference', 'meaning' => 'a basic and important difference', 'example' => 'There is a fundamental difference.'],
                        ['phrase' => 'welcome change', 'meaning' => 'a change that is pleasing', 'example' => 'It is a welcome change.'],
                        ['phrase' => 'course of action', 'meaning' => 'a procedure adopted to deal with a situation', 'example' => 'Decide on a course of action.'],
                        ['phrase' => 'pace of change', 'meaning' => 'the speed at which change happens', 'example' => 'The pace of change is fast.']
                    ],
                    'advanced_adjectives' => [
                        ['phrase' => 'significant', 'level' => 'B2', 'meaning' => 'sufficiently great or important to be worthy of attention', 'meaning_id' => 'signifikan / penting', 'example' => 'It was a significant change.'],
                        ['phrase' => 'radical', 'level' => 'C1', 'meaning' => 'relating to or affecting the fundamental nature of something', 'meaning_id' => 'radikal / mendasar', 'example' => 'A radical transformation.'],
                        ['phrase' => 'gradual', 'level' => 'B2', 'meaning' => 'taking place or progressing slowly or by degrees', 'meaning_id' => 'bertahap', 'example' => 'Progress was gradual.'],
                        ['phrase' => 'sudden', 'level' => 'B1', 'meaning' => 'occurring or done quickly and unexpectedly', 'meaning_id' => 'tiba-tiba', 'example' => 'It was a sudden decision.'],
                        ['phrase' => 'life-changing', 'level' => 'C1', 'meaning' => 'having such a strong effect that it changes one\'s life', 'meaning_id' => 'mengubah hidup', 'example' => 'It was a life-changing event.'],
                        ['phrase' => 'transformative', 'level' => 'C2', 'meaning' => 'causing a marked change in someone or something', 'meaning_id' => 'transformatif', 'example' => 'It was a transformative experience.'],
                        ['phrase' => 'profound', 'level' => 'C1', 'meaning' => 'very great or intense', 'meaning_id' => 'mendalam', 'example' => 'It had a profound effect.'],
                        ['phrase' => 'momentous', 'level' => 'C2', 'meaning' => 'of great importance or significance, especially in its bearing on the future', 'meaning_id' => 'sangat penting', 'example' => 'A momentous occasion.'],
                        ['phrase' => 'drastic', 'level' => 'C1', 'meaning' => 'likely to have a strong or far-reaching effect; radical and extreme', 'meaning_id' => 'drastis', 'example' => 'He took drastic measures.'],
                        ['phrase' => 'fundamental', 'level' => 'C1', 'meaning' => 'forming a necessary base or core; of central importance', 'meaning_id' => 'mendasar', 'example' => 'A fundamental change.'],
                        ['phrase' => 'unexpected', 'level' => 'B2', 'meaning' => 'not thought of as likely to happen', 'meaning_id' => 'tak terduga', 'example' => 'An unexpected turn of events.'],
                        ['phrase' => 'unprecedented', 'level' => 'C1', 'meaning' => 'never done or known before', 'meaning_id' => 'belum pernah terjadi', 'example' => 'Unprecedented growth.'],
                        ['phrase' => 'substantial', 'level' => 'B2', 'meaning' => 'of considerable importance, size, or worth', 'meaning_id' => 'substansial / cukup besar', 'example' => 'A substantial improvement.'],
                        ['phrase' => 'minor', 'level' => 'A2', 'meaning' => 'lesser in importance, seriousness, or significance', 'meaning_id' => 'kecil / minor', 'example' => 'Only minor changes.'],
                        ['phrase' => 'subtle', 'level' => 'C1', 'meaning' => 'so delicate or precise as to be difficult to analyze or describe', 'meaning_id' => 'halus / samar', 'example' => 'A subtle difference.'],
                        ['phrase' => 'sweeping', 'level' => 'C1', 'meaning' => 'wide in range or effect', 'meaning_id' => 'luas / menyeluruh', 'example' => 'Sweeping reforms.'],
                        ['phrase' => 'rapid', 'level' => 'B2', 'meaning' => 'happening in a short time or at a fast pace', 'meaning_id' => 'cepat', 'example' => 'Rapid development.'],
                        ['phrase' => 'imperceptible', 'level' => 'C2', 'meaning' => 'impossible to perceive', 'meaning_id' => 'tak terlihat / sangat halus', 'example' => 'Changes were imperceptible.'],
                        ['phrase' => 'revolutionary', 'level' => 'B2', 'meaning' => 'involving or causing a complete or dramatic change', 'meaning_id' => 'revolusioner', 'example' => 'A revolutionary idea.'],
                        ['phrase' => 'consistent', 'level' => 'B2', 'meaning' => 'acting or done in the same way over time', 'meaning_id' => 'konsisten', 'example' => 'Consistent effort.']
                    ],
                    'advanced_adverbs' => [
                        ['phrase' => 'drastically', 'level' => 'C1', 'meaning' => 'in a way that is likely to have a strong or far-reaching effect', 'meaning_id' => 'secara drastis', 'example' => 'My life changed drastically.'],
                        ['phrase' => 'fundamentally', 'level' => 'C1', 'meaning' => 'in central or primary respects', 'meaning_id' => 'secara mendasar', 'example' => 'I fundamentally disagree.'],
                        ['phrase' => 'gradually', 'level' => 'B2', 'meaning' => 'in a gradual way; slowly; by degrees', 'meaning_id' => 'secara bertahap', 'example' => 'I improved gradually.'],
                        ['phrase' => 'unexpectedly', 'level' => 'B2', 'meaning' => 'in a way that was not expected or regarded as likely', 'meaning_id' => 'secara tak terduga', 'example' => 'It happened unexpectedly.'],
                        ['phrase' => 'completely', 'level' => 'B1', 'meaning' => 'totally; utterly', 'meaning_id' => 'sepenuhnya', 'example' => 'I am completely sure.'],
                        ['phrase' => 'partially', 'level' => 'B2', 'meaning' => 'only in part; to a limited extent', 'meaning_id' => 'sebagian', 'example' => 'I only partially agree.'],
                        ['phrase' => 'eventually', 'level' => 'B2', 'meaning' => 'in the end, especially after a long delay', 'meaning_id' => 'pada akhirnya', 'example' => 'I eventually succeeded.'],
                        ['phrase' => 'initially', 'level' => 'B2', 'meaning' => 'at first', 'meaning_id' => 'pada awalnya', 'example' => 'Initially, I was scared.'],
                        ['phrase' => 'substantially', 'level' => 'C1', 'meaning' => 'to a great or significant extent', 'meaning_id' => 'secara substansial', 'example' => 'It increased substantially.'],
                        ['phrase' => 'significantly', 'level' => 'B2', 'meaning' => 'in a sufficiently great or important way as to be worthy of attention', 'meaning_id' => 'secara signifikan', 'example' => 'It contributed significantly.'],
                        ['phrase' => 'rapidly', 'level' => 'B2', 'meaning' => 'very quickly; at a great rate', 'meaning_id' => 'dengan cepat', 'example' => 'The disease spread rapidly.'],
                        ['phrase' => 'slowly', 'level' => 'A2', 'meaning' => 'at a slow speed; not quickly', 'meaning_id' => 'perlahan', 'example' => 'Walk slowly.'],
                        ['phrase' => 'noticeably', 'level' => 'B2', 'meaning' => 'easily seen or noticed; clearly', 'meaning_id' => 'secara nyata', 'example' => 'It became noticeably colder.'],
                        ['phrase' => 'remarkably', 'level' => 'B2', 'meaning' => 'in a way that is worthy of attention', 'meaning_id' => 'luar biasa', 'example' => 'She recovered remarkably.'],
                        ['phrase' => 'inevitably', 'level' => 'B2', 'meaning' => 'as is certain to happen; unavoidably', 'meaning_id' => 'niscaya / tak terelakkan', 'example' => 'Inevitably, it rained.'],
                        ['phrase' => 'surprisingly', 'level' => 'B2', 'meaning' => 'in a way that causes surprise; unexpectedly', 'meaning_id' => 'secara mengejutkan', 'example' => 'Surprisingly, he won.'],
                        ['phrase' => 'effectively', 'level' => 'B2', 'meaning' => 'in such a manner as to achieve a desired result', 'meaning_id' => 'secara efektif', 'example' => 'She managed it effectively.'],
                        ['phrase' => 'smoothly', 'level' => 'B2', 'meaning' => 'without problems or difficulties', 'meaning_id' => 'dengan lancar', 'example' => 'It went smoothly.'],
                        ['phrase' => 'abruptly', 'level' => 'C1', 'meaning' => 'suddenly and unexpectedly', 'meaning_id' => 'secara tiba-tiba', 'example' => 'The music stopped abruptly.'],
                        ['phrase' => 'consistently', 'level' => 'C1', 'meaning' => 'in every case or on every occasion; invariably', 'meaning_id' => 'secara konsisten', 'example' => 'He wins consistently.']
                    ],
                    'advanced_verbs' => [
                         [
                            ['phrase' => 'transform', 'level' => 'B2', 'meaning' => 'make a thorough or dramatic change in form, appearance, or character', 'meaning_id' => 'mengubah (total)', 'example' => 'It transformed my outlook.'],
                            ['phrase' => 'adapt', 'level' => 'B2', 'meaning' => 'become adjusted to new conditions', 'meaning_id' => 'beradaptasi', 'example' => 'I adapted to the new city.'],
                            ['phrase' => 'modify', 'level' => 'B2', 'meaning' => 'make partial or minor changes to', 'meaning_id' => 'memodifikasi', 'example' => 'I modified the plan.'],
                            ['phrase' => 'alter', 'level' => 'B2', 'meaning' => 'change or cause to change in character or composition', 'meaning_id' => 'mengubah (sedikit)', 'example' => 'Plans were altered.'],
                            ['phrase' => 'evolve', 'level' => 'C1', 'meaning' => 'develop gradually', 'meaning_id' => 'berkembang (evolusi)', 'example' => 'My style evolved.'],
                            ['phrase' => 'revise', 'level' => 'B2', 'meaning' => 're-examine and make alterations to', 'meaning_id' => 'merevisi', 'example' => 'I revised my strategy.'],
                            ['phrase' => 'revolutionize', 'level' => 'C1', 'meaning' => 'change (something) radically or fundamentally', 'meaning_id' => 'merevolusi', 'example' => 'It revolutionized the industry.'],
                            ['phrase' => 'adjust', 'level' => 'B2', 'meaning' => 'alter or move slightly in order to achieve the desired fit, appearance, or result', 'meaning_id' => 'menyesuaikan', 'example' => 'I adjusted the seat.'],
                            ['phrase' => 'transition', 'level' => 'C1', 'meaning' => 'undergo or cause to undergo a process or period of transition', 'meaning_id' => 'beralih / transisi', 'example' => 'I transitioned to a new job.'],
                            ['phrase' => 'convert', 'level' => 'B2', 'meaning' => 'change into a different form, character, or function', 'meaning_id' => 'mengubah / konversi', 'example' => 'It converted me to a fan.'],
                            ['phrase' => 'embrace', 'level' => 'C1', 'meaning' => 'accept or support (a belief, theory, or change) willingly and enthusiastically', 'meaning_id' => 'merangkul / menerima', 'example' => 'Embrace the change.'],
                            ['phrase' => 'resist', 'level' => 'B2', 'meaning' => 'withstand the action or effect of', 'meaning_id' => 'menolak', 'example' => 'Resistance to change.'],
                            ['phrase' => 'initiate', 'level' => 'C1', 'meaning' => 'cause (a process or action) to begin', 'meaning_id' => 'memulai / menginisiasi', 'example' => 'Initiate a dialogue.'],
                            ['phrase' => 'undergo', 'level' => 'B2', 'meaning' => 'experience or be subjected to (something, typically something unpleasant, painful, or arduous)', 'meaning_id' => 'mengalami', 'example' => 'Undergo surgery.'],
                            ['phrase' => 'shift', 'level' => 'B2', 'meaning' => 'change the position of one\'s body or a particular part of it', 'meaning_id' => 'bergeser / berubah', 'example' => 'Public opinion shifted.'],
                            ['phrase' => 'reform', 'level' => 'C1', 'meaning' => 'make changes in (something, typically a social, political, or economic institution or practice) in order to improve it', 'meaning_id' => 'mereformasi', 'example' => 'Reform the system.'],
                            ['phrase' => 'restructure', 'level' => 'C1', 'meaning' => 'organize differently', 'meaning_id' => 'merestrukturisasi', 'example' => 'Restructure debt.'],
                            ['phrase' => 'innovate', 'level' => 'C1', 'meaning' => 'make changes in something established, especially by introducing new methods, ideas, or products', 'meaning_id' => 'berinovasi', 'example' => 'Innovate or die.'],
                            ['phrase' => 'modernize', 'level' => 'B2', 'meaning' => 'adapt (something) to modern needs or habits', 'meaning_id' => 'memodernisasi', 'example' => 'Modernize the fleet.'],
                            ['phrase' => 'vary', 'level' => 'B2', 'meaning' => 'differ in size, amount, degree, or nature from something else of the same general class', 'meaning_id' => 'bervariasi', 'example' => 'Opinions vary.']
                         ]
                    ]
                ],
                [
                    'slug' => 'part-3-social-issues',
                    'title' => 'Part 3: Discussion (Social Issues & Trends)',
                    'questions' => [
                        "1. Topik: Education & Career\n- How can schools better prepare students for the workplace?",
                        "2. Topik: Government & Environment\n- What should the government do to protect the environment?",
                        "3. Topik: Success\n- Does luck play a part in achieving success?"
                    ],
                    'idioms' => [
                        ['phrase' => 'uphill battle', 'meaning' => 'a difficult struggle', 'example' => 'It is an uphill battle.'],
                        ['phrase' => 'level playing field', 'meaning' => 'a situation in which everyone has a fair and equal chance of succeeding', 'example' => 'We need a level playing field.'],
                        ['phrase' => 'burning issue', 'meaning' => 'an important and urgent problem', 'example' => 'Climate change is a burning issue.'],
                        ['phrase' => 'food for thought', 'meaning' => 'something worth thinking seriously about', 'example' => 'That is food for thought.'],
                        ['phrase' => 'tip of the iceberg', 'meaning' => 'only a small part of a much larger problem', 'example' => 'This is just the tip of the iceberg.'],
                        ['phrase' => 'vicious circle', 'meaning' => 'a sequence of reciprocal cause and effect in which two or more elements intensify and aggravate each other', 'example' => 'Poverty is a vicious circle.'],
                        ['phrase' => 'drop in the ocean', 'meaning' => 'a very small amount compared to what is needed', 'example' => 'My contribution is just a drop in the ocean.'],
                        ['phrase' => 'hot potato', 'meaning' => 'a controversial issue that is difficult to deal with', 'example' => 'The topic is a political hot potato.'],
                        ['phrase' => 'gray area', 'meaning' => 'an ill-defined situation or field not readily conforming to a category or set of rules', 'example' => 'The law is a gray area.'],
                        ['phrase' => 'step in the right direction', 'meaning' => 'an action that increases the possibility of success', 'example' => 'The new law is a step in the right direction.']
                    ],
                    'collocations' => [
                        ['phrase' => 'raise awareness', 'meaning' => 'increase public understanding', 'example' => 'Raise awareness about the issue.'],
                        ['phrase' => 'tackle a problem', 'meaning' => 'make a determined effort to deal with a problem', 'example' => 'Tackle the problem head-on.'],
                        ['phrase' => 'environmental protection', 'meaning' => 'practice of protecting the natural environment', 'example' => 'Environmental protection is vital.'],
                        ['phrase' => 'academic success', 'meaning' => 'achievement in education', 'example' => 'Strive for academic success.'],
                        ['phrase' => 'sustainable development', 'meaning' => 'economic development that is conducted without depletion of natural resources', 'example' => 'Promote sustainable development.'],
                        ['phrase' => 'key factor', 'meaning' => 'an important element', 'example' => 'Education is a key factor.'],
                        ['phrase' => 'root cause', 'meaning' => 'the fundamental reason for the occurrence of a problem', 'example' => 'Address the root cause.'],
                        ['phrase' => 'public opinion', 'meaning' => 'views prevalent among the general public', 'example' => 'Public opinion is divided.'],
                        ['phrase' => 'social inequality', 'meaning' => 'disparity in wealth or opportunities', 'example' => 'Reduce social inequality.'],
                        ['phrase' => 'vital role', 'meaning' => 'a very important function', 'example' => 'Schools play a vital role.']
                    ],
                    'advanced_adjectives' => [
                        ['phrase' => 'controversial', 'level' => 'B2', 'meaning' => 'giving rise or likely to give rise to public disagreement', 'meaning_id' => 'kontroversial', 'example' => 'It is a controversial topic.'],
                        ['phrase' => 'complex', 'level' => 'B2', 'meaning' => 'consisting of many different and connected parts', 'meaning_id' => 'kompleks / rumit', 'example' => 'The issue is complex.'],
                        ['phrase' => 'unprecedented', 'level' => 'C1', 'meaning' => 'never done or known before', 'meaning_id' => 'belum pernah terjadi sebelumnya', 'example' => 'Unprecedented growth.'],
                        ['phrase' => 'widespread', 'level' => 'B2', 'meaning' => 'found or distributed over a large area or number of people', 'meaning_id' => 'tersebar luas', 'example' => 'There is widespread panic.'],
                        ['phrase' => 'urgent', 'level' => 'B2', 'meaning' => 'requiring immediate action or attention', 'meaning_id' => 'mendesak', 'example' => 'Action is urgent.'],
                        ['phrase' => 'pressing', 'level' => 'B2', 'meaning' => 'requiring quick or immediate action or attention', 'meaning_id' => 'mendesak (pressing)', 'example' => 'A pressing matter.'],
                        ['phrase' => 'debatable', 'level' => 'B2', 'meaning' => 'open to discussion or argument', 'meaning_id' => 'dapat diperdebatkan', 'example' => 'The point is debatable.'],
                        ['phrase' => 'critical', 'level' => 'B2', 'meaning' => 'expressing adverse or disapproving comments or judgments', 'meaning_id' => 'kritis', 'example' => 'He was very critical.'],
                        ['phrase' => 'beneficial', 'level' => 'B2', 'meaning' => 'resulting in good; favorable or advantageous', 'meaning_id' => 'bermanfaat', 'example' => 'Beneficial effects.'],
                        ['phrase' => 'detrimental', 'level' => 'C2', 'meaning' => 'tending to cause harm', 'meaning_id' => 'merugikan', 'example' => 'Detrimental to health.'],
                        ['phrase' => 'ethical', 'level' => 'B2', 'meaning' => 'relating to moral principles', 'meaning_id' => 'etis', 'example' => 'Ethical questions.'],
                        ['phrase' => 'global', 'level' => 'B2', 'meaning' => 'relating to the whole world', 'meaning_id' => 'global', 'example' => 'Global warming.'],
                        ['phrase' => 'prevailing', 'level' => 'C1', 'meaning' => 'existing at a particular time; current', 'meaning_id' => 'umum / yang berlaku', 'example' => ' Prevailing opinion.'],
                        ['phrase' => 'alarming', 'level' => 'B2', 'meaning' => 'worrying or disturbing', 'meaning_id' => 'mengkhawatirkan', 'example' => 'Alarming rate.'],
                        ['phrase' => 'inevitable', 'level' => 'B2', 'meaning' => 'certain to happen; unavoidable', 'meaning_id' => 'tak terelakkan', 'example' => 'War was inevitable.'],
                        ['phrase' => 'sustainable', 'level' => 'B2', 'meaning' => 'able to be maintained', 'meaning_id' => 'berkelanjutan', 'example' => 'Sustainable development.'],
                        ['phrase' => 'viable', 'level' => 'C1', 'meaning' => 'capable of working successfully; feasible', 'meaning_id' => 'layak', 'example' => 'A viable plan.'],
                        ['phrase' => 'marginal', 'level' => 'C2', 'meaning' => 'relating to or situated at the edge or margin of something', 'meaning_id' => 'marginal', 'example' => 'Marginal difference.'],
                        ['phrase' => 'drastic', 'level' => 'C1', 'meaning' => 'likely to have a strong or far-reaching effect', 'meaning_id' => 'drastis', 'example' => 'Drastic cuts.'],
                        ['phrase' => 'constructive', 'level' => 'C1', 'meaning' => 'serving a useful purpose; tending to build up', 'meaning_id' => 'konstruktif', 'example' => 'Constructive criticism.']
                    ],
                    'advanced_adverbs' => [
                         ['phrase' => 'arguably', 'level' => 'C1', 'meaning' => 'it may be argued (used to qualify a statement)', 'meaning_id' => 'bisa dibilang', 'example' => 'Arguably the best.'],
                         ['phrase' => 'undeniably', 'level' => 'C1', 'meaning' => 'used to emphasize that something is true', 'meaning_id' => 'tak terbantahkan', 'example' => 'It is undeniably true.'],
                         ['phrase' => 'increasingly', 'level' => 'B2', 'meaning' => 'to an increasing extent; more and more', 'meaning_id' => 'semakin', 'example' => 'It is increasingly rare.'],
                         ['phrase' => 'typically', 'level' => 'B2', 'meaning' => 'in most cases; usually', 'meaning_id' => 'biasanya / khas', 'example' => 'It typically rains here.'],
                         ['phrase' => 'allegedly', 'level' => 'C1', 'meaning' => 'used to convey that something is claimed to be the case or have taken place, although there is no proof', 'meaning_id' => 'diduga', 'example' => 'Allegedly, he left.'],
                         ['phrase' => 'largely', 'level' => 'B2', 'meaning' => 'to a great extent; on the whole; mostly', 'meaning_id' => 'sebagian besar', 'example' => 'It was largely successful.'],
                         ['phrase' => 'predominantly', 'level' => 'C1', 'meaning' => 'mainly; for the most part', 'meaning_id' => 'terutama', 'example' => 'Predominantly white.'],
                         ['phrase' => 'supposedly', 'level' => 'B2', 'meaning' => 'according to what is generally assumed or believed', 'meaning_id' => 'konon', 'example' => 'Supposedly wealthy.'],
                         ['phrase' => 'reportedly', 'level' => 'C1', 'meaning' => 'according to reports or rumors', 'meaning_id' => 'kabarnya', 'example' => 'Reportedly killed.'],
                         ['phrase' => 'ethically', 'level' => 'B2', 'meaning' => 'in a way that relates to moral principles', 'meaning_id' => 'secara etis', 'example' => 'Act ethically.'],
                         ['phrase' => 'morally', 'level' => 'B2', 'meaning' => 'in a way that relates to the principles of right and wrong', 'meaning_id' => 'secara moral', 'example' => 'Morally wrong.'],
                         ['phrase' => 'economically', 'level' => 'B2', 'meaning' => 'in a way that relates to economics or finance', 'meaning_id' => 'secara ekonomi', 'example' => 'Economically viable.'],
                         ['phrase' => 'politically', 'level' => 'B2', 'meaning' => 'in a way that relates to the government or public affairs of a country', 'meaning_id' => 'secara politik', 'example' => 'Politically correct.'],
                         ['phrase' => 'socially', 'level' => 'B2', 'meaning' => 'in a way that relates to society or its organization', 'meaning_id' => 'secara sosial', 'example' => 'Socially acceptable.'],
                         ['phrase' => 'globally', 'level' => 'B2', 'meaning' => 'in a way that relates to the whole world', 'meaning_id' => 'secara global', 'example' => 'Globally connected.'],
                         ['phrase' => 'adversely', 'level' => 'C2', 'meaning' => 'in a way that prevents success or development; harmfully', 'meaning_id' => 'secara merugikan', 'example' => 'Adversely affected.'],
                         ['phrase' => 'effectively', 'level' => 'B2', 'meaning' => 'in such a manner as to achieve a desired result', 'meaning_id' => 'secara efektif', 'example' => 'Work effectively.'],
                         ['phrase' => 'potentially', 'level' => 'B2', 'meaning' => 'with the capacity to develop or happen in the future', 'meaning_id' => 'berpotensi', 'example' => 'Potentially dangerous.'],
                         ['phrase' => 'inevitably', 'level' => 'B2', 'meaning' => 'as is certain to happen', 'meaning_id' => 'niscaya', 'example' => 'Inevitably late.'],
                         ['phrase' => 'seemingly', 'level' => 'B2', 'meaning' => 'so as to give the impression of having a certain quality; apparently', 'meaning_id' => 'tampaknya', 'example' => 'Seemingly impossible.']
                    ],
                    'advanced_verbs' => [
                        // Q1
                        [
                             ['phrase' => 'address', 'level' => 'B2', 'meaning' => 'think about and begin to deal with (an issue or problem)', 'meaning_id' => 'menangani', 'example' => 'We must address this issue.'],
                             ['phrase' => 'prepare', 'level' => 'A2', 'meaning' => 'make something ready for use or consideration', 'meaning_id' => 'mempersiapkan', 'example' => 'Schools prepare students.'],
                             ['phrase' => 'equip', 'level' => 'B2', 'meaning' => 'supply with the necessary items for a particular purpose', 'meaning_id' => 'melengkapi / membekali', 'example' => 'Equip them with skills.'],
                             ['phrase' => 'foster', 'level' => 'C1', 'meaning' => 'encourage or promote the development of', 'meaning_id' => 'mendorong (perkembangan)', 'example' => 'Foster creativity.'],
                             ['phrase' => 'encourage', 'level' => 'B2', 'meaning' => 'give support, confidence, or hope', 'meaning_id' => 'mendorong', 'example' => 'Encourage teamwork.'],
                             ['phrase' => 'nurture', 'level' => 'C1', 'meaning' => 'care for and encourage the growth or development of', 'meaning_id' => 'memelihara / membina', 'example' => 'Nurture talent.'],
                             ['phrase' => 'instill', 'level' => 'C1', 'meaning' => 'gradually establish (an idea or attitude, especially a desirable one) in a person\'s mind', 'meaning_id' => 'menanamkan', 'example' => 'Instill values.'],
                             ['phrase' => 'promote', 'level' => 'B2', 'meaning' => 'support or actively encourage', 'meaning_id' => 'mempromosikan', 'example' => 'Promote learning.'],
                             ['phrase' => 'facilitate', 'level' => 'C1', 'meaning' => 'make easy or easier', 'meaning_id' => 'memfasilitasi', 'example' => 'Facilitate growth.'],
                             ['phrase' => 'guide', 'level' => 'B1', 'meaning' => 'show or indicate the way to', 'meaning_id' => 'membimbing', 'example' => 'Guide them.'],
                             ['phrase' => 'mentor', 'level' => 'C1', 'meaning' => 'advise or train', 'meaning_id' => 'menjadi mentor', 'example' => 'Mentor students.'],
                             ['phrase' => 'assess', 'level' => 'B2', 'meaning' => 'evaluate or estimate', 'meaning_id' => 'menilai', 'example' => 'Assess needs.'],
                             ['phrase' => 'evaluate', 'level' => 'B2', 'meaning' => 'form an idea of the amount, number, or value of', 'meaning_id' => 'mengevaluasi', 'example' => 'Evaluate progress.'],
                             ['phrase' => 'motivate', 'level' => 'B2', 'meaning' => 'provide (someone) with a motive for doing something', 'meaning_id' => 'memotivasi', 'example' => 'Motivate employees.'],
                             ['phrase' => 'inspire', 'level' => 'B2', 'meaning' => 'fill with the urge or ability to do or feel something', 'meaning_id' => 'menginspirasi', 'example' => 'Inspire others.'],
                             ['phrase' => 'acquire', 'level' => 'B2', 'meaning' => 'buy or obtain (an object or asset) for oneself', 'meaning_id' => 'memperoleh', 'example' => 'Acquire skills.'],
                             ['phrase' => 'master', 'level' => 'C1', 'meaning' => 'acquire complete knowledge or skill in', 'meaning_id' => 'menguasai', 'example' => 'Master a trade.'],
                             ['phrase' => 'develop', 'level' => 'B1', 'meaning' => 'grow or cause to grow and become more mature, advanced, or elaborate', 'meaning_id' => 'mengembangkan', 'example' => 'Develop ideas.'],
                             ['phrase' => 'cultivate', 'level' => 'C1', 'meaning' => 'try to acquire or develop (a quality, sentiment, or skill)', 'meaning_id' => 'mengolah / menumbuhkan', 'example' => 'Cultivate habits.'],
                             ['phrase' => 'pursue', 'level' => 'B2', 'meaning' => 'follow (someone or something) in order to catch or attack them', 'meaning_id' => 'mengejar (karir/mimpi)', 'example' => 'Pursue dreams.']
                        ],
                        // Q2
                        [
                             ['phrase' => 'mitigate', 'level' => 'C1', 'meaning' => 'make less severe, serious, or painful', 'meaning_id' => 'mengurangi (dampak buruk)', 'example' => 'Mitigate climate change.'],
                             ['phrase' => 'implement', 'level' => 'B2', 'meaning' => 'put into effect', 'meaning_id' => 'menerapkan', 'example' => 'Implement strict laws.'],
                             ['phrase' => 'prioritize', 'level' => 'B2', 'meaning' => 'designate or treat as more important', 'meaning_id' => 'memprioritaskan', 'example' => 'Prioritize green energy.'],
                             ['phrase' => 'regulate', 'level' => 'B2', 'meaning' => 'control or maintain the rate or speed of', 'meaning_id' => 'mengatur (regulasi)', 'example' => 'Regulate emissions.'],
                             ['phrase' => 'conserve', 'level' => 'C1', 'meaning' => 'protect from harm or destruction', 'meaning_id' => 'melestarikan', 'example' => 'Conserve forests.'],
                             ['phrase' => 'preserve', 'level' => 'B2', 'meaning' => 'maintain in its original or existing state', 'meaning_id' => 'menjaga', 'example' => 'Preserve nature.'],
                             ['phrase' => 'protect', 'level' => 'B1', 'meaning' => 'keep safe from harm or injury', 'meaning_id' => 'melindungi', 'example' => 'Protect wildlife.'],
                             ['phrase' => 'enforce', 'level' => 'C1', 'meaning' => 'compel observance of or compliance with', 'meaning_id' => 'menegakkan (hukum)', 'example' => 'Enforce regulations.'],
                             ['phrase' => 'subsidize', 'level' => 'C1', 'meaning' => 'support financially', 'meaning_id' => 'mensubsidi', 'example' => 'Subsidize solar panels.'],
                             ['phrase' => 'tax', 'level' => 'B2', 'meaning' => 'impose a tax on', 'meaning_id' => 'mengenakan pajak', 'example' => 'Tax carbon.'],
                             ['phrase' => 'penalize', 'level' => 'C1', 'meaning' => 'subject to some form of punishment', 'meaning_id' => 'menghukum / mendenda', 'example' => 'Penalize polluters.'],
                             ['phrase' => 'incentivize', 'level' => 'C1', 'meaning' => 'provide (someone) with an incentive for doing something', 'meaning_id' => 'memberikan insentif', 'example' => 'Incentivize recycling.'],
                             ['phrase' => 'monitor', 'level' => 'B2', 'meaning' => 'observe and check the progress or quality of', 'meaning_id' => 'memantau', 'example' => 'Monitor air quality.'],
                             ['phrase' => 'combat', 'level' => 'C1', 'meaning' => 'take action to reduce or prevent', 'meaning_id' => 'memerangi', 'example' => 'Combat global warming.'],
                             ['phrase' => 'reduce', 'level' => 'A2', 'meaning' => 'make smaller or less in amount', 'meaning_id' => 'mengurangi', 'example' => 'Reduce waste.'],
                             ['phrase' => 'recycle', 'level' => 'A2', 'meaning' => 'convert into reusable material', 'meaning_id' => 'mendaur ulang', 'example' => 'Recycle plastic.'],
                             ['phrase' => 'sustain', 'level' => 'C1', 'meaning' => 'strengthen or support physically or mentally', 'meaning_id' => 'mempertahankan', 'example' => 'Sustain life.'],
                             ['phrase' => 'ban', 'level' => 'B2', 'meaning' => 'officially or legally prohibit', 'meaning_id' => 'melarang', 'example' => 'Ban plastic.'],
                             ['phrase' => 'prohibit', 'level' => 'B2', 'meaning' => 'formally forbid by law', 'meaning_id' => 'melarang keras', 'example' => 'Prohibit dumping.'],
                             ['phrase' => 'advocate', 'level' => 'C1', 'meaning' => 'publicly recommend or support', 'meaning_id' => 'mengadvokasi', 'example' => 'Advocate change.']
                        ],
                        // Q3
                        [
                             ['phrase' => 'achieve', 'level' => 'B1', 'meaning' => 'successfully bring about or reach by effort, skill, or courage', 'meaning_id' => 'mencapai', 'example' => 'Achieve success.'],
                             ['phrase' => 'attribute', 'level' => 'B2', 'meaning' => 'regard something as being caused by', 'meaning_id' => 'menghubungkan / menganggap disebabkan oleh', 'example' => 'Attribute success to hard work.'],
                             ['phrase' => 'hinder', 'level' => 'C1', 'meaning' => 'create difficulties for, resulting in delay or obstruction', 'meaning_id' => 'menghambat', 'example' => 'Bad luck hinders progress.'],
                             ['phrase' => 'determine', 'level' => 'B2', 'meaning' => 'cause (something) to occur in a particular way; be the decisive factor in', 'meaning_id' => 'menentukan', 'example' => 'It determines the outcome.'],
                             ['phrase' => 'facilitate', 'level' => 'C1', 'meaning' => 'make (an action or process) easy or easier', 'meaning_id' => 'memfasilitasi / memudahkan', 'example' => 'Luck facilitates success.'],
                             ['phrase' => 'define', 'level' => 'B2', 'meaning' => 'state or describe exactly the nature, scope, or meaning of', 'meaning_id' => 'mendefinisikan', 'example' => 'Define success.'],
                             ['phrase' => 'measure', 'level' => 'B2', 'meaning' => 'ascertain the size, amount, or degree of', 'meaning_id' => 'mengukur', 'example' => 'Measure success.'],
                             ['phrase' => 'pursue', 'level' => 'B2', 'meaning' => 'follow (someone or something) in order to catch or attack them', 'meaning_id' => 'mengejar', 'example' => 'Pursue goals.'],
                             ['phrase' => 'attain', 'level' => 'C1', 'meaning' => 'succeed in achieving', 'meaning_id' => 'mencapai / meraih', 'example' => 'Attain greatness.'],
                             ['phrase' => 'accomplish', 'level' => 'B2', 'meaning' => 'achieve or complete successfully', 'meaning_id' => 'menyelesaikan / mencapai', 'example' => 'Accomplish tasks.'],
                             ['phrase' => 'struggle', 'level' => 'B2', 'meaning' => 'make forceful or violent efforts to get free of restraint or constriction', 'meaning_id' => 'berjuang', 'example' => 'Struggle for success.'],
                             ['phrase' => 'overcome', 'level' => 'B2', 'meaning' => 'succeed in dealing with (a problem or difficulty)', 'meaning_id' => 'mengatasi', 'example' => 'Overcome obstacles.'],
                             ['phrase' => 'persevere', 'level' => 'C2', 'meaning' => 'continue in a course of action even in the face of difficulty', 'meaning_id' => 'bertahan / gigih', 'example' => 'Persevere through pain.'],
                             ['phrase' => 'dedicate', 'level' => 'B2', 'meaning' => 'devote (time, effort, or oneself) to a particular task or purpose', 'meaning_id' => 'mendedikasikan', 'example' => 'Dedicate your life.'],
                             ['phrase' => 'sacrifice', 'level' => 'B2', 'meaning' => 'give up (something important or valued) for the sake of other considerations', 'meaning_id' => 'mengorbankan', 'example' => 'Sacrifice for success.'],
                             ['phrase' => 'balance', 'level' => 'B2', 'meaning' => 'keep or put (something) in a steady position so that it does not fall', 'meaning_id' => 'menyeimbangkan', 'example' => 'Balance work and life.'],
                             ['phrase' => 'influence', 'level' => 'B2', 'meaning' => 'have an influence on', 'meaning_id' => 'mempengaruhi', 'example' => 'Influence outcomes.'],
                             ['phrase' => 'contribute', 'level' => 'B2', 'meaning' => 'give (something, especially money) in order to help achieve or provide something', 'meaning_id' => 'berkontribusi', 'example' => 'Contribute to success.'],
                             ['phrase' => 'result', 'level' => 'B1', 'meaning' => 'occur or follow as the consequence of something', 'meaning_id' => 'berakibat / menghasilkan', 'example' => 'Result in success.'],
                             ['phrase' => 'deserve', 'level' => 'B1', 'meaning' => 'do something or have or show qualities worthy of', 'meaning_id' => 'pantas mendapatkan', 'example' => 'Deserve success.']
                        ]
                    ]
                ]
            ]
        ],
        ];
    }
}
