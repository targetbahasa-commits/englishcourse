<?php

namespace App\Application\IeltsSpeaking;

class IeltsSpeakingPart1LessonsDataA
{
    public function getLessons(): array
    {
        return [
        [
            'slug' => 'lesson-1',
            'title' => 'No Hmmmm',
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'color' => 'red',
            'questions' => null,
            'subtopics' => [
                [
                    'slug' => 'work-or-studies',
                    'title' => 'Work or Studies',
                    'questions' => [
                        'Do you work or are you a student?',
                        'What do you like most about your job/studies?'
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'learn the ropes',
                            'meaning' => 'to learn how to do a job or activity',
                            'meaning_id' => 'belajar cara melakukan pekerjaan atau aktivitas',
                            'example' => 'It took me a few weeks to learn the ropes at my new job.'
                        ],
                        [
                            'phrase' => 'hit the books',
                            'meaning' => 'to study hard',
                            'meaning_id' => 'belajar dengan giat',
                            'example' => 'I need to hit the books tonight for my exam tomorrow.'
                        ],
                        [
                            'phrase' => 'work around the clock',
                            'meaning' => 'to work all day and night',
                            'meaning_id' => 'bekerja siang dan malam',
                            'example' => 'During exam season, I work around the clock to finish my assignments.'
                        ],
                        [
                            'phrase' => 'climb the career ladder',
                            'meaning' => 'to advance in your career',
                            'meaning_id' => 'naik jenjang karir',
                            'example' => 'She worked hard to climb the career ladder and became a manager.'
                        ],
                        [
                            'phrase' => 'burn the midnight oil',
                            'meaning' => 'to work or study late into the night',
                            'meaning_id' => 'bekerja atau belajar hingga larut malam',
                            'example' => 'I had to burn the midnight oil to finish my thesis on time.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'rewarding career',
                            'meaning' => 'a job that gives you satisfaction',
                            'meaning_id' => 'karir yang memuaskan',
                            'example' => 'Teaching is a rewarding career because you help shape young minds.'
                        ],
                        [
                            'phrase' => 'hands-on experience',
                            'meaning' => 'practical experience doing something',
                            'meaning_id' => 'pengalaman praktis',
                            'example' => 'The internship gave me valuable hands-on experience in marketing.'
                        ],
                        [
                            'phrase' => 'steep learning curve',
                            'meaning' => 'something difficult to learn at first',
                            'meaning_id' => 'sulit dipelajari pada awalnya',
                            'example' => 'Programming has a steep learning curve, but it gets easier with practice.'
                        ],
                        [
                            'phrase' => 'gain knowledge',
                            'meaning' => 'to acquire new information or skills',
                            'meaning_id' => 'memperoleh pengetahuan',
                            'example' => 'University is a great place to gain knowledge and meet new people.'
                        ],
                        [
                            'phrase' => 'meet expectations',
                            'meaning' => 'to achieve what is required or hoped for',
                            'meaning_id' => 'memenuhi harapan',
                            'example' => 'My boss was pleased that I met all the expectations for the project.'
                        ]
                    ]
                ],
                [
                    'slug' => 'home-accommodation',
                    'title' => 'Home & Accommodation',
                    'questions' => [
                        'Do you live in a house or an apartment?',
                        'Which is your favorite room in your home? Why?'
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'home sweet home',
                            'meaning' => 'used to express happiness at being in your own home',
                            'meaning_id' => 'rumah yang manis/nyaman',
                            'example' => 'After a long trip, I was so happy to return home sweet home.'
                        ],
                        [
                            'phrase' => 'make yourself at home',
                            'meaning' => 'to relax and feel comfortable',
                            'meaning_id' => 'merasa seperti di rumah sendiri',
                            'example' => 'Please come in and make yourself at home while I prepare some tea.'
                        ],
                        [
                            'phrase' => 'a roof over your head',
                            'meaning' => 'somewhere to live',
                            'meaning_id' => 'tempat tinggal',
                            'example' => "I'm grateful to have a roof over my head and a warm place to sleep."
                        ],
                        [
                            'phrase' => 'feel at home',
                            'meaning' => 'to feel comfortable and relaxed',
                            'meaning_id' => 'merasa nyaman',
                            'example' => 'The warm welcome made me feel at home immediately.'
                        ],
                        [
                            'phrase' => 'home is where the heart is',
                            'meaning' => 'home is where you feel most comfortable',
                            'meaning_id' => 'rumah adalah tempat hati berada',
                            'example' => 'No matter where I travel, home is where the heart is.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'cozy atmosphere',
                            'meaning' => 'a warm and comfortable feeling',
                            'meaning_id' => 'suasana nyaman',
                            'example' => 'My living room has a cozy atmosphere with soft lighting and comfortable furniture.'
                        ],
                        [
                            'phrase' => 'spacious layout',
                            'meaning' => 'a design with lots of room',
                            'meaning_id' => 'tata ruang yang luas',
                            'example' => 'I love the spacious layout of my apartment - it never feels cramped.'
                        ],
                        [
                            'phrase' => 'prime location',
                            'meaning' => 'an excellent place or position',
                            'meaning_id' => 'lokasi strategis',
                            'example' => 'My apartment is in a prime location, close to shops and public transport.'
                        ],
                        [
                            'phrase' => 'modern amenities',
                            'meaning' => 'contemporary facilities and conveniences',
                            'meaning_id' => 'fasilitas modern',
                            'example' => 'The apartment has modern amenities like high-speed internet and air conditioning.'
                        ],
                        [
                            'phrase' => 'residential area',
                            'meaning' => 'a district where people live',
                            'meaning_id' => 'area perumahan',
                            'example' => 'I prefer living in a quiet residential area away from the city center.'
                        ]
                    ]
                ],
                [
                    'slug' => 'hometown',
                    'title' => 'Hometown',
                    'questions' => [
                        'Where is your hometown located?',
                        'What do people in your hometown do for recreation?'
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'off the beaten track',
                            'meaning' => 'in a place where few people go',
                            'example' => 'My hometown is off the beaten track, so tourists rarely visit.'
                        ],
                        [
                            'phrase' => 'a stone\'s throw away',
                            'meaning' => 'very close distance',
                            'example' => 'The beach is just a stone\'s throw away from my hometown.'
                        ],
                        [
                            'phrase' => 'the heart of the city',
                            'meaning' => 'the central or most important part',
                            'meaning_id' => 'pusat kota',
                            'example' => 'I grew up in the heart of the city, surrounded by tall buildings.'
                        ],
                        [
                            'phrase' => 'neck of the woods',
                            'meaning' => 'a particular area or neighborhood',
                            'example' => 'There are many great restaurants in my neck of the woods.'
                        ],
                        [
                            'phrase' => 'home turf',
                            'meaning' => 'one\'s own territory or area',
                            'meaning_id' => 'wilayah sendiri',
                            'example' => 'I always feel more confident when playing on my home turf.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'bustling city',
                            'meaning' => 'a busy, lively city',
                            'example' => 'Jakarta is a bustling city with millions of people and constant activity.'
                        ],
                        [
                            'phrase' => 'tight-knit community',
                            'meaning' => 'a group of people who are very close',
                            'example' => 'My hometown has a tight-knit community where everyone knows each other.'
                        ],
                        [
                            'phrase' => 'rich cultural heritage',
                            'meaning' => 'important cultural traditions and history',
                            'example' => 'Yogyakarta has a rich cultural heritage with ancient temples and traditional arts.'
                        ],
                        [
                            'phrase' => 'local community',
                            'meaning' => 'people living in a particular area',
                            'example' => 'The local community organized a festival to celebrate our heritage.'
                        ],
                        [
                            'phrase' => 'scenic beauty',
                            'meaning' => 'beautiful natural views',
                            'meaning_id' => 'keindahan alam',
                            'example' => 'My hometown is famous for its scenic beauty and mountains.'
                        ]
                    ]
                ],
                [
                    'slug' => 'daily-routine',
                    'title' => 'Daily Routine',
                    'questions' => [
                        'What is your favorite part of the day?',
                        'Do you prefer to get up early in the morning or stay up late at night?'
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'rise and shine',
                            'meaning' => 'wake up and get out of bed',
                            'meaning_id' => 'bangun dan bersiap',
                            'example' => 'I rise and shine at 6 AM every morning to go for a run.'
                        ],
                        [
                            'phrase' => 'call it a day',
                            'meaning' => 'to stop working for the day',
                            'meaning_id' => 'mengakhiri pekerjaan hari ini',
                            'example' => 'After finishing my last task, I decided to call it a day and relax.'
                        ],
                        [
                            'phrase' => 'the crack of dawn',
                            'meaning' => 'very early in the morning',
                            'meaning_id' => 'pagi-pagi sekali',
                            'example' => 'My father wakes up at the crack of dawn to prepare for work.'
                        ],
                        [
                            'phrase' => 'early bird',
                            'meaning' => 'someone who wakes up early',
                            'meaning_id' => 'orang yang bangun pagi',
                            'example' => 'My father is an early bird - he wakes up at 5 AM every day.'
                        ],
                        [
                            'phrase' => 'night owl',
                            'meaning' => 'someone who stays up late',
                            'meaning_id' => 'orang yang begadang',
                            'example' => 'I\'m a night owl, so I do my best work after midnight.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'morning person',
                            'meaning' => 'someone who feels energetic in the morning',
                            'meaning_id' => 'orang yang aktif di pagi hari',
                            'example' => "I'm definitely a morning person - I do my best work before noon."
                        ],
                        [
                            'phrase' => 'hectic schedule',
                            'meaning' => 'a very busy timetable',
                            'meaning_id' => 'jadwal yang padat',
                            'example' => 'I have a hectic schedule this week with back-to-back meetings.'
                        ],
                        [
                            'phrase' => 'wind down',
                            'meaning' => 'to relax after a busy period',
                            'meaning_id' => 'bersantai/rileks',
                            'example' => 'I like to wind down in the evening by reading a book or watching TV.'
                        ],
                        [
                            'phrase' => 'daily commute',
                            'meaning' => 'regular journey to work or school',
                            'meaning_id' => 'perjalanan harian ke tempat kerja/sekolah',
                            'example' => 'My daily commute takes about 45 minutes by train.'
                        ],
                        [
                            'phrase' => 'set routine',
                            'meaning' => 'a fixed pattern of activities',
                            'meaning_id' => 'rutinitas tetap',
                            'example' => 'I follow a set routine every morning to stay organized.'
                        ]
                    ]
                ],
                [
                    'slug' => 'hobbies-interests',
                    'title' => 'Hobbies & Interests',
                    'questions' => [
                        'What do you like to do in your free time?',
                        'Did you have any different hobbies when you were a child?'
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'get the hang of it',
                            'meaning' => 'to learn how to do something',
                            'meaning_id' => 'mulai menguasai/memahami',
                            'example' => 'Playing guitar was difficult at first, but I eventually got the hang of it.'
                        ],
                        [
                            'phrase' => 'pick up a hobby',
                            'meaning' => 'to start a new hobby',
                            'meaning_id' => 'memulai hobi baru',
                            'example' => 'I decided to pick up photography as a hobby during the pandemic.'
                        ],
                        [
                            'phrase' => 'let off steam',
                            'meaning' => 'to release stress or tension',
                            'meaning_id' => 'melepaskan stres',
                            'example' => 'I play basketball on weekends to let off steam after a stressful week.'
                        ],
                        [
                            'phrase' => 'take up',
                            'meaning' => 'to start doing something new',
                            'meaning_id' => 'memulai (aktivitas baru)',
                            'example' => 'I decided to take up yoga to improve my flexibility.'
                        ],
                        [
                            'phrase' => 'get into',
                            'meaning' => 'to become interested in something',
                            'meaning_id' => 'mulai tertarik pada',
                            'example' => 'I recently got into photography and bought a new camera.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'pursue a passion',
                            'meaning' => 'to follow something you love doing',
                            'meaning_id' => 'mengejar passion/minat',
                            'example' => 'I finally have time to pursue my passion for painting.'
                        ],
                        [
                            'phrase' => 'spare time',
                            'meaning' => 'free time when you\'re not working',
                            'meaning_id' => 'waktu luang',
                            'example' => 'In my spare time, I enjoy reading novels and playing video games.'
                        ],
                        [
                            'phrase' => 'broaden your horizons',
                            'meaning' => 'to expand your experiences and knowledge',
                            'meaning_id' => 'memperluas wawasan',
                            'example' => 'Traveling helps you broaden your horizons and see different cultures.'
                        ],
                        [
                            'phrase' => 'leisure activities',
                            'meaning' => 'things done for enjoyment in free time',
                            'meaning_id' => 'kegiatan santai',
                            'example' => 'Reading and hiking are my favorite leisure activities.'
                        ],
                        [
                            'phrase' => 'creative outlet',
                            'meaning' => 'a way to express creativity',
                            'meaning_id' => 'saluran kreativitas',
                            'example' => 'Painting serves as a creative outlet for my emotions.'
                        ]
                    ]
                ]
            ]
        ],

        // Manual Injection for Lesson 2 (Nominal & Passive)
        [
            'slug' => 'lesson-2',
            'title' => 'Nominal & Passive',
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'color' => 'blue',
            'questions' => null,
            'subtopics' => [
                [
                    'slug' => 'hometown',
                    'title' => 'Your Hometown',
                    'questions' => [
                        'Where is your hometown located?',
                        'What is your hometown famous for?'
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'put on the map',
                            'meaning' => 'to make a place famous or well-known',
                            'meaning_id' => 'membuat terkenal',
                            'example' => 'The new museum has really put our small town on the map.'
                        ],
                        [
                            'phrase' => 'the talk of the town',
                            'meaning' => 'something everyone is discussing',
                            'meaning_id' => 'pembicaraan orang banyak',
                            'example' => 'The new shopping mall is the talk of the town right now.'
                        ],
                        [
                            'phrase' => 'a far cry from',
                            'meaning' => 'very different from',
                            'meaning_id' => 'sangat berbeda dari',
                            'example' => 'My hometown today is a far cry from what it was 20 years ago.'
                        ],
                        [
                            'phrase' => 'neck of the woods',
                            'meaning' => 'a particular area',
                            'meaning_id' => 'daerah/wilayah tertentu',
                            'example' => 'What brings you to this neck of the woods?'
                        ],
                        [
                            'phrase' => 'off the map',
                            'meaning' => 'remote or unknown',
                            'meaning_id' => 'terpencil/tidak dikenal',
                            'example' => 'My hometown is so small, it\'s practically off the map.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'be known for',
                            'meaning' => 'to be famous because of something',
                            'meaning_id' => 'dikenal karena',
                            'example' => 'My hometown is known for its beautiful beaches and fresh seafood.'
                        ],
                        [
                            'phrase' => 'be located in/on',
                            'meaning' => 'to be situated in a particular place',
                            'meaning_id' => 'terletak di',
                            'example' => 'My hometown is located on the coast of Java island.'
                        ],
                        [
                            'phrase' => 'tourist attraction',
                            'meaning' => 'a place that tourists visit',
                            'meaning_id' => 'objek wisata',
                            'example' => 'The ancient temple is the main tourist attraction in my hometown.'
                        ],
                        [
                            'phrase' => 'be situated',
                            'meaning' => 'to be in a particular position',
                            'meaning_id' => 'terletak/berada',
                            'example' => 'My hometown is situated in the mountains of West Java.'
                        ],
                        [
                            'phrase' => 'local economy',
                            'meaning' => 'the financial system of a specific area',
                            'meaning_id' => 'ekonomi lokal',
                            'example' => 'Tourism plays a major role in our local economy.'
                        ]
                    ]
                ],
                [
                    'slug' => 'museums-historical-sites',
                    'title' => 'Museums & Historical Sites',
                    'questions' => [
                        'Are there many museums in your city?',
                        'Do you think history should be taught in schools?'
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'a walk down memory lane',
                            'meaning' => 'thinking about the past',
                            'meaning_id' => 'mengenang masa lalu',
                            'example' => 'Visiting the history museum was like a walk down memory lane.'
                        ],
                        [
                            'phrase' => 'stand the test of time',
                            'meaning' => 'to remain valuable or useful for a long time',
                            'meaning_id' => 'bertahan sepanjang waktu',
                            'example' => 'These ancient buildings have stood the test of time for centuries.'
                        ],
                        [
                            'phrase' => 'bring history to life',
                            'meaning' => 'to make history interesting and real',
                            'meaning_id' => 'menghidupkan sejarah',
                            'example' => 'The museum exhibits really bring history to life with interactive displays.'
                        ],
                        [
                            'phrase' => 'turn back the clock',
                            'meaning' => 'to return to the past',
                            'meaning_id' => 'kembali ke masa lalu',
                            'example' => 'Visiting old museums makes me wish I could turn back the clock.'
                        ],
                        [
                            'phrase' => 'a thing of the past',
                            'meaning' => 'something that no longer exists',
                            'meaning_id' => 'sesuatu yang sudah berlalu',
                            'example' => 'Traditional crafts are becoming a thing of the past.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'be preserved',
                            'meaning' => 'to be kept in good condition',
                            'meaning_id' => 'dilestarikan',
                            'example' => 'Many historical sites are carefully preserved by the government.'
                        ],
                        [
                            'phrase' => 'cultural heritage',
                            'meaning' => 'traditions and monuments from the past',
                            'meaning_id' => 'warisan budaya',
                            'example' => 'Museums play an important role in protecting our cultural heritage.'
                        ],
                        [
                            'phrase' => 'be displayed',
                            'meaning' => 'to be shown to the public',
                            'meaning_id' => 'dipamerkan',
                            'example' => 'Ancient artifacts are displayed in glass cases at the museum.'
                        ],
                        [
                            'phrase' => 'be exhibited',
                            'meaning' => 'to be shown publicly',
                            'meaning_id' => 'dipamerkan',
                            'example' => 'Ancient pottery is exhibited in the national museum.'
                        ],
                        [
                            'phrase' => 'historical significance',
                            'meaning' => 'importance in history',
                            'meaning_id' => 'nilai sejarah',
                            'example' => 'This building has great historical significance for our nation.'
                        ]
                    ]
                ],
                [
                    'slug' => 'festivals-celebrations',
                    'title' => 'Festivals & Celebrations',
                    'questions' => [
                        'How is the New Year celebrated in your country?',
                        'Is there a specific food that is eaten during festivals?'
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'paint the town red',
                            'meaning' => 'to go out and celebrate in a lively way',
                            'meaning_id' => 'merayakan dengan meriah',
                            'example' => 'During New Year, people paint the town red with fireworks and parties.'
                        ],
                        [
                            'phrase' => 'the icing on the cake',
                            'meaning' => 'something that makes a good situation even better',
                            'meaning_id' => 'puncak dari sesuatu yang baik',
                            'example' => 'The fireworks display was the icing on the cake for our festival celebration.'
                        ],
                        [
                            'phrase' => 'have a blast',
                            'meaning' => 'to have a great time',
                            'meaning_id' => 'bersenang-senang',
                            'example' => 'We always have a blast during the annual harvest festival.'
                        ],
                        [
                            'phrase' => 'let your hair down',
                            'meaning' => 'to relax and enjoy yourself',
                            'meaning_id' => 'bersantai dan menikmati diri sendiri',
                            'example' => 'Festivals are a great time to let your hair down and have fun.'
                        ],
                        [
                            'phrase' => 'the life of the party',
                            'meaning' => 'the most fun person at an event',
                            'meaning_id' => 'orang paling menyenangkan di pesta',
                            'example' => 'My uncle is always the life of the party at family celebrations.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'be celebrated',
                            'meaning' => 'to be marked with festivities',
                            'meaning_id' => 'dirayakan',
                            'example' => 'Independence Day is celebrated with parades and cultural performances.'
                        ],
                        [
                            'phrase' => 'traditional food',
                            'meaning' => 'food that is customary for a culture',
                            'meaning_id' => 'makanan tradisional',
                            'example' => 'Traditional food like ketupat is eaten during Eid celebrations.'
                        ],
                        [
                            'phrase' => 'mark the occasion',
                            'meaning' => 'to celebrate an important event',
                            'meaning_id' => 'merayakan acara',
                            'example' => 'Special ceremonies are held to mark the occasion of the New Year.'
                        ],
                        [
                            'phrase' => 'be observed',
                            'meaning' => 'to be celebrated or followed',
                            'meaning_id' => 'dirayakan/dijalankan',
                            'example' => 'Religious holidays are observed with special prayers and gatherings.'
                        ],
                        [
                            'phrase' => 'festive atmosphere',
                            'meaning' => 'a celebratory mood',
                            'meaning_id' => 'suasana perayaan',
                            'example' => 'The streets have a festive atmosphere during Chinese New Year.'
                        ]
                    ]
                ],
                [
                    'slug' => 'computers-apps',
                    'title' => 'Computers & Apps',
                    'questions' => [
                        'Is your computer important to you?',
                        'What kind of apps are used by people in your country?'
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'at your fingertips',
                            'meaning' => 'easily accessible',
                            'meaning_id' => 'mudah diakses',
                            'example' => 'With smartphones, information is now at your fingertips.'
                        ],
                        [
                            'phrase' => 'cutting-edge technology',
                            'meaning' => 'the most advanced technology',
                            'meaning_id' => 'teknologi canggih',
                            'example' => 'The new app uses cutting-edge technology for voice recognition.'
                        ],
                        [
                            'phrase' => 'a game changer',
                            'meaning' => 'something that significantly changes a situation',
                            'meaning_id' => 'pengubah permainan/situasi',
                            'example' => 'Mobile payment apps have been a game changer for small businesses.'
                        ],
                        [
                            'phrase' => 'tech-savvy',
                            'meaning' => 'knowledgeable about technology',
                            'meaning_id' => 'paham teknologi',
                            'example' => 'Young people today are very tech-savvy compared to older generations.'
                        ],
                        [
                            'phrase' => 'go viral',
                            'meaning' => 'to become very popular online quickly',
                            'meaning_id' => 'menjadi viral/populer',
                            'example' => 'The funny video went viral and got millions of views.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'be used by',
                            'meaning' => 'to be utilized by someone',
                            'meaning_id' => 'digunakan oleh',
                            'example' => 'Social media apps are used by millions of people every day.'
                        ],
                        [
                            'phrase' => 'rely on',
                            'meaning' => 'to depend on something',
                            'meaning_id' => 'bergantung pada',
                            'example' => 'Many people rely on their computers for work and communication.'
                        ],
                        [
                            'phrase' => 'user-friendly interface',
                            'meaning' => 'easy to use design',
                            'meaning_id' => 'antarmuka yang mudah digunakan',
                            'example' => 'The app has a user-friendly interface that anyone can navigate.'
                        ],
                        [
                            'phrase' => 'be downloaded',
                            'meaning' => 'to be transferred from the internet',
                            'meaning_id' => 'diunduh',
                            'example' => 'The app has been downloaded over 10 million times.'
                        ],
                        [
                            'phrase' => 'digital platform',
                            'meaning' => 'an online system or service',
                            'meaning_id' => 'platform digital',
                            'example' => 'Many businesses now sell their products on digital platforms.'
                        ]
                    ]
                ]
            ]
        ],

        // Manual Injection for Lesson 3 (Part 2 + Adjective Clause)
        [
            'slug' => 'lesson-3',
            'title' => 'Part 2 + Adjective Clause',
            'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
            'color' => 'green',
            'subtopics' => [
                [
                    'slug' => 'describing-person',
                    'title' => 'Soal 1: Describing a Person',
                    'questions' => [
                        "Describe a person you know who is a role model for young people.\nYou should say:\n\n- Who this person is.\n- What kind of work they do which is beneficial for society.\n- What kind of personality they have that makes them special.\n- And explain why you admire this person whose achievements are well-known."
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'look up to',
                            'meaning' => 'to admire and respect someone',
                            'meaning_id' => 'mengagumi dan menghormati',
                            'example' => 'I look up to my father because he is hardworking and honest.'
                        ],
                        [
                            'phrase' => 'follow in someone\'s footsteps',
                            'meaning' => 'to do the same work or achieve the same success as someone else',
                            'meaning_id' => 'mengikuti jejak seseorang',
                            'example' => 'She decided to follow in her mother\'s footsteps and become a doctor.'
                        ],
                        [
                            'phrase' => 'the salt of the earth',
                            'meaning' => 'a very good and honest person',
                            'meaning_id' => 'orang yang sangat baik dan jujur',
                            'example' => 'My grandmother is the salt of the earth; she always helps others.'
                        ],
                        [
                            'phrase' => 'a heart of gold',
                            'meaning' => 'very kind and generous',
                            'meaning_id' => 'sangat baik hati',
                            'example' => 'He has a heart of gold and donates to charity regularly.'
                        ],
                        [
                            'phrase' => 'stand out from the crowd',
                            'meaning' => 'to be clearly better or more noticeable than others',
                            'meaning_id' => 'menonjol dari orang banyak',
                            'example' => 'Her unique style makes her stand out from the crowd.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'role model',
                            'meaning' => 'someone you admire and want to be like',
                            'meaning_id' => 'panutan',
                            'example' => 'Teachers often serve as important role models for their students.'
                        ],
                        [
                            'phrase' => 'profound impact',
                            'meaning' => 'a strong influence or effect',
                            'meaning_id' => 'dampak yang mendalam',
                            'example' => 'His speech had a profound impact on my career choice.'
                        ],
                        [
                            'phrase' => 'strong personality',
                            'meaning' => 'a character that is confident and determined',
                            'meaning_id' => 'kepribadian yang kuat',
                            'example' => 'You need a strong personality to be a leader.'
                        ],
                        [
                            'phrase' => 'set a good example',
                            'meaning' => 'to behave in a way that others should copy',
                            'meaning_id' => 'memberikan contoh yang baik',
                            'example' => 'Parents should set a good example for their children.'
                        ],
                        [
                            'phrase' => 'highly respected',
                            'meaning' => 'admired by many people',
                            'meaning_id' => 'sangat dihormati',
                            'example' => 'He is a highly respected member of the community.'
                        ]
                    ]
                ],
                [
                    'slug' => 'describing-place',
                    'title' => 'Soal 2: Describing a Place or City',
                    'questions' => [
                        "Describe a city or town you have visited where you would like to live in the future.\nYou should say:\n\n- Where it is located.\n- What the buildings and streets that you saw there look like.\n- What the people who live there are like.\n- And explain the reasons why this is a place where you could build a career."
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'hustle and bustle',
                            'meaning' => 'busy and noisy activity',
                            'meaning_id' => 'hiruk-pikuk/kesibukan',
                            'example' => 'I enjoy the hustle and bustle of the city center.'
                        ],
                        [
                            'phrase' => 'a hidden gem',
                            'meaning' => 'a nice place that few people know about',
                            'meaning_id' => 'tempat bagus yang tersembunyi',
                            'example' => 'This small cafe is a hidden gem with the best coffee in town.'
                        ],
                        [
                            'phrase' => 'off the beaten track',
                            'meaning' => 'in a place where few people go',
                            'meaning_id' => 'jauh dari keramaian/terpencil',
                            'example' => 'We found a beautiful beach that was off the beaten track.'
                        ],
                        [
                            'phrase' => 'in the middle of nowhere',
                            'meaning' => 'far away from any towns or cities',
                            'meaning_id' => 'di tempat yang sangat jauh/terpencil',
                            'example' => 'Their house is in the middle of nowhere, surrounded by fields.'
                        ],
                        [
                            'phrase' => 'concrete jungle',
                            'meaning' => 'a city area with many tall modern buildings',
                            'meaning_id' => 'hutan beton (kota padat gedung)',
                            'example' => 'New York is a concrete jungle full of skyscrapers.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'breathtaking view',
                            'meaning' => 'an extremely beautiful view',
                            'meaning_id' => 'pemandangan yang memukau',
                            'example' => 'The hotel room offered a breathtaking view of the ocean.'
                        ],
                        [
                            'phrase' => 'vibrant atmosphere',
                            'meaning' => 'lively and exciting mood',
                            'meaning_id' => 'suasana yang hidup/bersemangat',
                            'example' => 'The night market has a vibrant atmosphere with music and food stalls.'
                        ],
                        [
                            'phrase' => 'bustling city',
                            'meaning' => 'a city full of activity',
                            'meaning_id' => 'kota yang ramai',
                            'example' => 'Tokyo is a bustling city that never sleeps.'
                        ],
                        [
                            'phrase' => 'historical landmark',
                            'meaning' => 'a building/place of historical importance',
                            'meaning_id' => 'landmark bersejarah',
                            'example' => 'The Colosseum is a famous historical landmark in Rome.'
                        ],
                        [
                            'phrase' => 'within walking distance',
                            'meaning' => 'close enough to walk to',
                            'meaning_id' => 'jarak tempuh jalan kaki',
                            'example' => 'The beach is within walking distance of our hotel.'
                        ]
                    ]
                ],
                [
                    'slug' => 'describing-device',
                    'title' => 'Soal 3: Describing a Device or App',
                    'questions' => [
                        "Describe a mobile app or a website that has helped you solve a problem.\nYou should say:\n\n- What the app or website is.\n- What features it has which are most useful for you.\n- How often you use this tool that you find indispensable.\n- And explain how your life which was once complicated has changed because of it."
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'at your fingertips',
                            'meaning' => 'easily accessible',
                            'meaning_id' => 'mudah diakses/di ujung jari',
                            'example' => 'With smartphones, the world is at your fingertips.'
                        ],
                        [
                            'phrase' => 'cutting-edge technology',
                            'meaning' => 'the most advanced technology',
                            'meaning_id' => 'teknologi canggih',
                            'example' => 'This phone uses cutting-edge technology for face recognition.'
                        ],
                        [
                            'phrase' => 'a game changer',
                            'meaning' => 'something that significantly changes a situation',
                            'meaning_id' => 'pengubah permainan/situasi',
                            'example' => 'This new app is a game changer for online shopping.'
                        ],
                        [
                            'phrase' => 'tech-savvy',
                            'meaning' => 'knowing a lot about technology',
                            'meaning_id' => 'paham teknologi',
                            'example' => 'You don\'t need to be tech-savvy to use this simple device.'
                        ],
                        [
                            'phrase' => 'silver bullet',
                            'meaning' => 'a simple solution to a complicated problem',
                            'meaning_id' => 'solusi jitu/sederhana',
                            'example' => 'There is no silver bullet for climate change; we need many solutions.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'user-friendly interface',
                            'meaning' => 'easy to use design',
                            'meaning_id' => 'antarmuka yang mudah digunakan',
                            'example' => 'The app has a user-friendly interface suitable for all ages.'
                        ],
                        [
                            'phrase' => 'indispensable tool',
                            'meaning' => 'a tool you cannot do without',
                            'meaning_id' => 'alat yang sangat diperlukan',
                            'example' => 'My laptop is an indispensable tool for my work.'
                        ],
                        [
                            'phrase' => 'innovative features',
                            'meaning' => 'new and helpful functions',
                            'meaning_id' => 'fitur inovatif',
                            'example' => 'The latest update added several innovative features.'
                        ],
                        [
                            'phrase' => 'efficient way',
                            'meaning' => 'a method that works well without wasting time',
                            'meaning_id' => 'cara yang efisien',
                            'example' => 'Email is an efficient way to communicate with colleagues.'
                        ],
                        [
                            'phrase' => 'integral part',
                            'meaning' => 'essential piece',
                            'meaning_id' => 'bagian integral/penting',
                            'example' => 'Technology is an integral part of modern life.'
                        ]
                    ]
                ]
            ]
        ],

        // Manual Injection for Lesson 4 (Part 3)
        [
            'slug' => 'lesson-4',
            'title' => 'Lesson 4 - Part 3 + Gerund as Subject',
            'icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z',
            'color' => 'indigo',
            'subtopics' => [
                [
                    'slug' => 'part-1-mixed',
                    'title' => 'Part 1: Short Answers (Mixed Topics)',
                    'questions' => [
                        "1. Topik: Reading\n- Do you like reading books?",
                        "2. Topik: Physical Exercise\n- What do you do to stay healthy?",
                        "3. Topik: Coding\n- Is learning to code difficult?",
                        "4. Topik: Traveling\n- Do you prefer traveling alone or in a group?"
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'hit the books',
                            'meaning' => 'to study or read hard',
                            'meaning_id' => 'belajar/membaca dengan giat',
                            'example' => 'I have to hit the books tonight for my exam.'
                        ],
                        [
                            'phrase' => 'as fit as a fiddle',
                            'meaning' => 'to be very healthy and strong',
                            'meaning_id' => 'sangat sehat dan bugar',
                            'example' => 'My grandfather is 90 but he is as fit as a fiddle.'
                        ],
                        [
                            'phrase' => 'crack the code',
                            'meaning' => 'to figure out a difficult problem',
                            'meaning_id' => 'memecahkan masalah sulit',
                            'example' => 'It took me hours to crack the code and fix the bug.'
                        ],
                        [
                            'phrase' => 'hit the road',
                            'meaning' => 'to begin a journey',
                            'meaning_id' => 'memulai perjalanan',
                            'example' => 'We should hit the road early to avoid traffic.'
                        ],
                        [
                            'phrase' => 'learn the ropes',
                            'meaning' => 'to learn how to do a job or activity',
                            'meaning_id' => 'belajar seluk-beluk sesuatu',
                            'example' => 'It takes time to learn the ropes of a new programming language.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'avid reader',
                            'meaning' => 'someone who reads a lot',
                            'meaning_id' => 'pembaca yang antusias',
                            'example' => 'She is an avid reader and finishes a book every week.'
                        ],
                        [
                            'phrase' => 'strenuous exercise',
                            'meaning' => 'exercise that needs a lot of effort',
                            'meaning_id' => 'olahraga berat',
                            'example' => 'Strenuous exercise is good for your heart.'
                        ],
                        [
                            'phrase' => 'steep learning curve',
                            'meaning' => 'hard to learn typically because it is complex',
                            'meaning_id' => 'kurva pembelajaran yang curam (sulit dipelajari)',
                            'example' => 'Coding has a steep learning curve but it is rewarding.'
                        ],
                        [
                            'phrase' => 'solo traveler',
                            'meaning' => 'someone who travels alone',
                            'meaning_id' => 'pelancong solo/sendirian',
                            'example' => 'As a solo traveler, I meet many new people.'
                        ],
                        [
                            'phrase' => 'broaden my horizons',
                            'meaning' => 'to learn more and experience more',
                            'meaning_id' => 'memperluas wawasan saya',
                            'example' => 'Traveling helps to broaden my horizons.'
                        ]
                    ]
                ],
                [
                    'slug' => 'part-2-task',
                    'title' => 'Part 2: Cue Card (Difficult Task)',
                    'questions' => [
                        "Describe a difficult task you completed at work or school.\nYou should say:\n\n- What the task was.\n- Why it was difficult.\n- How you handled it.\n- And explain why completing this task was important to you."
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'bite off more than you can chew',
                            'meaning' => 'to try to do something that is too difficult',
                            'meaning_id' => 'mengambil tanggung jawab berlebihan',
                            'example' => 'I bit off more than I could chew when I accepted two projects at once.'
                        ],
                        [
                            'phrase' => 'burn the midnight oil',
                            'meaning' => 'to work late into the night',
                            'meaning_id' => 'bekerja lembur sampai larut malam',
                            'example' => 'I had to burn the midnight oil to finish the report.'
                        ],
                        [
                            'phrase' => 'back to the drawing board',
                            'meaning' => 'to start over because a previous attempt failed',
                            'meaning_id' => 'memulai dari awal lagi',
                            'example' => 'Our plan failed, so it\'s back to the drawing board.'
                        ],
                        [
                            'phrase' => 'get the hang of it',
                            'meaning' => 'to learn how to do something',
                            'meaning_id' => 'mulai mengerti/bisa melakukan sesuatu',
                            'example' => 'Coding is hard at first, but you will get the hang of it.'
                        ],
                        [
                            'phrase' => 'call it a day',
                            'meaning' => 'to stop working for the day',
                            'meaning_id' => 'mengakhiri pekerjaan hari ini',
                            'example' => 'We have done enough work, let\'s call it a day.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'daunting task',
                            'meaning' => 'a task that seems very difficult',
                            'meaning_id' => 'tugas yang menakutkan/sangat berat',
                            'example' => 'Writing a book can be a daunting task.'
                        ],
                        [
                            'phrase' => 'overcome a challenge',
                            'meaning' => 'to succeed in dealing with a problem',
                            'meaning_id' => 'mengatasi tantangan',
                            'example' => 'She worked hard to overcome the challenge.'
                        ],
                        [
                            'phrase' => 'meet a deadline',
                            'meaning' => 'to finish work by the agreed time',
                            'meaning_id' => 'menyelesaikan sesuai tenggat waktu',
                            'example' => 'We worked all weekend to meet the deadline.'
                        ],
                        [
                            'phrase' => 'gain experience',
                            'meaning' => 'to learn by doing',
                            'meaning_id' => 'mendapatkan pengalaman',
                            'example' => 'This internship helped me gain valuable experience.'
                        ],
                        [
                            'phrase' => 'sense of achievement',
                            'meaning' => 'a proud feeling of having done something difficult',
                            'meaning_id' => 'rasa pencapaian/kebanggaan',
                            'example' => 'Completing the marathon gave me a huge sense of achievement.'
                        ]
                    ]
                ],

            ]
        ],

        // Manual Injection for Lesson 5 (Past + Modal)
        [
            'slug' => 'lesson-5',
            'title' => 'Lesson 5 - Past + Modal',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            'color' => 'yellow',
            'subtopics' => [
                [
                    'slug' => 'part-1-mixed',
                    'title' => 'Part 1: Short Answers (Mixed Topics)',
                    'questions' => [
                        "1. Topik: Childhood Hobbies\n- What hobbies did you have when you were a child?\n- Did other children in your school share these hobbies?\n- Is it important for children to have hobbies?\n- What free-time activities did you enjoy as a child?",
                        "2. Topik: School Days\n- Did you like your secondary school?\n- Which subject did you find most difficult at school?\n- Do you still keep in touch with your friends from school?\n- What was your favorite part of the school day?",
                        "3. Topik: Decisions\n- Was it easy to choose your current profession?\n- Who helps you make major decisions in your life?\n- Have you ever made a decision that you later regretted?\n- Do you prefer making decisions alone or with others?"
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'child\'s play',
                            'meaning' => 'something very easy to do',
                            'meaning_id' => 'sesuatu yang sangat mudah dilakukan',
                            'example' => 'Fixing this computer is child\'s play for him.'
                        ],
                        [
                            'phrase' => 'take a trip down memory lane',
                            'meaning' => 'to remember happy times in the past',
                            'meaning_id' => 'mengenang masa lalu yang indah',
                            'example' => 'Looking at old photos is like taking a trip down memory lane.'
                        ],
                        [
                            'phrase' => 'make up your mind',
                            'meaning' => 'to decide',
                            'meaning_id' => 'membuat keputusan',
                            'example' => 'I can\'t make up my mind about which car to buy.'
                        ],
                        [
                            'phrase' => 'in two minds',
                            'meaning' => 'uncertain about what to decide',
                            'meaning_id' => 'ragu-ragu/bimbang',
                            'example' => 'I was in two minds about accepting the job offer.'
                        ],
                        [
                            'phrase' => 'stand on your own two feet',
                            'meaning' => 'to be independent',
                            'meaning_id' => 'mandiri',
                            'example' => 'After college, you need to stand on your own two feet.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'happy childhood',
                            'meaning' => 'a childhood full of joy',
                            'meaning_id' => 'masa kecil yang bahagia',
                            'example' => 'I had a very happy childhood growing up in the countryside.'
                        ],
                        [
                            'phrase' => 'fond memory',
                            'meaning' => 'something you remember with pleasure',
                            'meaning_id' => 'kenangan indah',
                            'example' => 'I have fond memories of my school days.'
                        ],
                        [
                            'phrase' => 'tough decision',
                            'meaning' => 'a difficult choice to make',
                            'meaning_id' => 'keputusan sulit',
                            'example' => 'Choosing a career is often a tough decision.'
                        ],
                        [
                            'phrase' => 'vivid memory',
                            'meaning' => 'a very clear memory',
                            'meaning_id' => 'ingatan yang sangat jelas',
                            'example' => 'I have a vivid memory of my first day at school.'
                        ],
                        [
                            'phrase' => 'career path',
                            'meaning' => 'the series of jobs you take in your life',
                            'meaning_id' => 'jenjang karir',
                            'example' => 'He is not sure about his future career path.'
                        ]
                    ]
                ],
                [
                    'slug' => 'part-2-task',
                    'title' => 'Part 2: Cue Card (Changed Mind)',
                    'questions' => [
                        "Describe a time when you changed your mind about something.\nYou should say:\n\n- When it happened and what the situation was.\n- What you had planned to do initially.\n- Why you decided to change your mind.\n- And explain what might have happened if you hadn’t changed your mind."
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'have second thoughts',
                            'meaning' => 'to begin to doubt a decision',
                            'meaning_id' => 'ragu-ragu setelah memutuskan',
                            'example' => 'I\'m having second thoughts about selling my house.'
                        ],
                        [
                            'phrase' => 'change of heart',
                            'meaning' => 'to change your opinion or feeling',
                            'meaning_id' => 'berubah pikiran/perasaan',
                            'example' => 'She had a change of heart and decided to stay.'
                        ],
                        [
                            'phrase' => 'on the fence',
                            'meaning' => 'undecided',
                            'meaning_id' => 'belum memutuskan/ragu',
                            'example' => 'I\'m still on the fence about whether to go or not.'
                        ],
                        [
                            'phrase' => 'weigh the pros and cons',
                            'meaning' => 'to consider the advantages and disadvantages',
                            'meaning_id' => 'menimbang untung rugi',
                            'example' => 'You should weigh the pros and cons before deciding.'
                        ],
                        [
                            'phrase' => 'trust your gut',
                            'meaning' => 'to follow your intuition',
                            'meaning_id' => 'percayai instingmu',
                            'example' => 'When in doubt, just trust your gut.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'change your mind',
                            'meaning' => 'to decide to do something different',
                            'meaning_id' => 'berubah pikiran',
                            'example' => 'Nothing will make me change my mind.'
                        ],
                        [
                            'phrase' => 'snap decision',
                            'meaning' => 'a decision made quickly without thinking',
                            'meaning_id' => 'keputusan mendadak/cepat',
                            'example' => 'She made a snap decision to quit her job.'
                        ],
                        [
                            'phrase' => 'careful consideration',
                            'meaning' => 'thinking about something very carefully',
                            'meaning_id' => 'pertimbangan matang',
                            'example' => 'After careful consideration, I accepted the offer.'
                        ],
                        [
                            'phrase' => 'regret a decision',
                            'meaning' => 'to feel sorry about a choice you made',
                            'meaning_id' => 'menyesali keputusan',
                            'example' => 'I don\'t think you will regret this decision.'
                        ],
                        [
                            'phrase' => 'stick to a plan',
                            'meaning' => 'to follow a plan as promised',
                            'meaning_id' => 'berpegang pada rencana',
                            'example' => 'It is important to stick to the plan to finish on time.'
                        ]
                    ]
                ],
                [
                    'slug' => 'part-3-discussion',
                    'title' => 'Part 3: Discussion (Decisions & Change)',
                    'questions' => [
                        "1. Difficulty in Decisions\n- Why do some people find it hard to make decisions?",
                        "2. Teaching Decision Making\n- How can young people be taught to make good decisions?",
                        "3. Changing Personality\n- Do you think people change their personalities as they grow older?",
                        "4. Quick vs Slow Decisions\n- Is it better to make decisions quickly or take time to think?"
                    ],
                    'idioms' => [
                        [
                            'phrase' => 'cross that bridge when we come to it',
                            'meaning' => 'deal with a problem if and when it becomes necessary',
                            'meaning_id' => 'menghadapi masalah saat itu terjadi',
                            'example' => 'I haven\'t thought about that yet - I\'ll cross that bridge when I come to it.'
                        ],
                        [
                            'phrase' => 'sit on the fence',
                            'meaning' => 'delay making a decision',
                            'meaning_id' => 'menunda keputusan',
                            'example' => 'You can\'t sit on the fence forever; you need to choose a side.'
                        ]
                    ],
                    'collocations' => [
                        [
                            'phrase' => 'major turning point',
                            'meaning' => 'a time when an important change happens',
                            'meaning_id' => 'titik balik penting',
                            'example' => 'Graduating from university was a major turning point in my life.'
                        ],
                        [
                            'phrase' => 'far-reaching consequences',
                            'meaning' => 'important and lasting effects',
                            'meaning_id' => 'konsekuensi jangka panjang',
                            'example' => 'This decision will have far-reaching consequences for the company.'
                        ]
                    ]
                ]
            ]
        ],
        ];
    }
}
