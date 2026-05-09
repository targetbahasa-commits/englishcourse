<?php

namespace App\Application\IeltsSpeaking;

class IeltsSpeakingPart2TopicsDataA
{
    public function getTopics(): array
    {
        return [
            [
                'title' => 'Describe a Book',
                'part3_title' => 'Reading & Literature',
                'slug' => 'describe-a-book',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'cyan',
                'questions' => [
                    'Describe a book you have recently read.',
                    'You should say:',
                    '- what kind of book it is',
                    '- what it is about',
                    '- what sort of people would enjoy it',
                    'and explain why you liked it.'
                ],
                'part3_questions' => [
                    'Do you think people read enough books these days?',
                    'What kind of books are most popular in your country?',
                    'Do you think ebooks will eventually replace paper books?',
                    'How can reading help children in their development?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Read between the lines', 'meaning' => 'Memahami makna tersirat', 'example' => 'To understand poetry, you must read between the lines.'],
                    ['phrase' => 'Food for thought', 'meaning' => 'Bahan pemikiran', 'example' => 'The article provided plenty of food for thought.'],
                    ['phrase' => 'Turn a new leaf', 'meaning' => 'Memulai awal baru', 'example' => 'He decided to turn a new leaf and study harder.'],
                    ['phrase' => 'Judge a book by its cover', 'meaning' => 'Menilai dari penampilan', 'example' => 'You shouldn\'t judge a book by its cover.'],
                    ['phrase' => 'Open book', 'meaning' => 'Orang yang mudah ditebak/jujur', 'example' => 'My life is an open book.'],
                    ['phrase' => 'Closed book', 'meaning' => 'Topik yang sulit dipahami/misteri', 'example' => 'Algebra is a closed book to me.'],
                    ['phrase' => 'By the book', 'meaning' => 'Sesuai aturan', 'example' => 'We must do everything by the book.'],
                    ['phrase' => 'In someone\'s good books', 'meaning' => 'Disukai seseorang', 'example' => 'I cleaned the kitchen to be in Mom\'s good books.'],
                    ['phrase' => 'Take a leaf out of someone\'s book', 'meaning' => 'Meniru perilaku baik seseorang', 'example' => 'You should take a leaf out of your brother\'s book.'],
                    ['phrase' => 'Hit the books', 'meaning' => 'Belajar dengan giat', 'example' => 'I have to hit the books for my exam.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Literary masterpiece', 'meaning' => 'Karya sastra agung', 'example' => 'This novel is considered a literary masterpiece.'],
                    ['phrase' => 'Avid reader', 'meaning' => 'Pembaca yang antusias', 'example' => 'She has been an avid reader since childhood.'],
                    ['phrase' => 'Shed light on', 'meaning' => 'Menjelaskan/Menerangkan', 'example' => 'This book sheds light on historical events.'],
                    ['phrase' => 'Thought-provoking', 'meaning' => 'Menggugah pikiran', 'example' => 'It was a thought-provoking discussion.'],
                    ['phrase' => 'Compelling storytelling', 'meaning' => 'Penceritaan yang menarik', 'example' => 'The book is known for its compelling storytelling.'],
                    ['phrase' => 'Character development', 'meaning' => 'Pengembangan karakter', 'example' => 'The character development in this novel is excellent.'],
                    ['phrase' => 'Unexpected twist', 'meaning' => 'Kejutan tak terduga', 'example' => 'The story had an unexpected twist at the end.'],
                    ['phrase' => 'Set within a context', 'meaning' => 'Berlatar dalam konteks', 'example' => 'The story is set within a historical context.'],
                    ['phrase' => 'Opening chapter', 'meaning' => 'Bab pembuka', 'example' => 'The opening chapter really hooks the reader.'],
                    ['phrase' => 'Critical acclaim', 'meaning' => 'Pujian kritis', 'example' => 'The book received critical acclaim.']
                ],
                'advanced_verbs' => [
                    ['phrase' => 'Devour', 'meaning' => 'Membaca dengan lahap', 'level' => 'C1', 'example' => 'I devoured the entire series in a week.', 'meaning_id' => 'Read quickly and eagerly'],
                    ['phrase' => 'Immerse', 'meaning' => 'Tenggelam (dalam cerita)', 'level' => 'B2', 'example' => 'I like to immerse myself in fantasy worlds.', 'meaning_id' => 'Involve oneself deeply'],
                    ['phrase' => 'Depict', 'meaning' => 'Menggambarkan', 'level' => 'C1', 'example' => 'The author depicts the struggle for survival vividly.', 'meaning_id' => 'Represent or characterize'],
                    ['phrase' => 'Narrate', 'meaning' => 'Menceritakan', 'level' => 'B2', 'example' => ' The story is narrated by a young girl.', 'meaning_id' => 'Tell a story'],
                    ['phrase' => 'Critique', 'meaning' => 'Mengkritik/Mengulas', 'level' => 'C1', 'example' => 'Students had to critique the novel\'s themes.', 'meaning_id' => 'Detailed evaluation'],
                    ['phrase' => 'Skim', 'meaning' => 'Membaca sekilas', 'level' => 'B2', 'example' => 'I just skimmed the introduction.', 'meaning_id' => 'Read quickly for main ideas'],
                    ['phrase' => 'Peruse', 'meaning' => 'Membaca dengan teliti', 'level' => 'C2', 'example' => 'She perused the library shelves for hours.', 'meaning_id' => 'Read thoroughly/carefully'],
                    ['phrase' => 'Resonate', 'meaning' => 'Terhubung/Berkesan', 'level' => 'C2', 'example' => 'The main character\'s struggle resonated with me.', 'meaning_id' => 'Evoke a sympathetic response'],
                    ['phrase' => 'Visualize', 'meaning' => 'Membayangkan', 'level' => 'B2', 'example' => 'The descriptions help you visualize the setting.', 'meaning_id' => 'Form a mental image'],
                    ['phrase' => 'Captivate', 'meaning' => 'Memikat', 'level' => 'C1', 'example' => 'The plot captivated me from the first page.', 'meaning_id' => 'Attract and hold interest']
                ],
                'advanced_adverbs' => [
                    ['phrase' => 'Vividly', 'meaning' => 'Dengan jelas/hidup', 'level' => 'B2', 'example' => 'I remember the opening scene vividly.', 'meaning_id' => 'In a clear, lively way'],
                    ['phrase' => 'Profoundly', 'meaning' => 'Secara mendalam', 'level' => 'C1', 'example' => 'The book influenced me profoundly.', 'meaning_id' => 'Deeply or extremely'],
                    ['phrase' => 'Extensively', 'meaning' => 'Secara luas', 'level' => 'B2', 'example' => 'She reads extensively about history.', 'meaning_id' => 'Widely or comprehensively'],
                    ['phrase' => 'Articulately', 'meaning' => 'Dengan fasih/jelas', 'level' => 'C2', 'example' => 'The ideas were expressed articulately.', 'meaning_id' => 'Clearly and effectively'],
                    ['phrase' => 'Compellingly', 'meaning' => 'Secara meyakinkan/menarik', 'level' => 'C1', 'example' => 'The argument was presented compellingly.', 'meaning_id' => 'In a powerful, irresistible way'],
                    ['phrase' => 'Metaphorically', 'meaning' => 'Secara kiasan', 'level' => 'C1', 'example' => 'He was speaking metaphorically.', 'meaning_id' => 'Symbolically'],
                    ['phrase' => 'Eloquently', 'meaning' => 'Dengan indah/fasih', 'level' => 'C2', 'example' => 'The author writes eloquently about nature.', 'meaning_id' => 'Fluent or persuasive in speaking/writing'],
                    ['phrase' => 'Chronologically', 'meaning' => 'Secara berurutan waktu', 'level' => 'C1', 'example' => 'The chapters are arranged chronologically.', 'meaning_id' => 'In order of time'],
                    ['phrase' => 'Intricately', 'meaning' => 'Secara rumit', 'level' => 'C1', 'example' => 'The plot was intricately woven.', 'meaning_id' => 'In a very detailed manner'],
                    ['phrase' => 'Voraciously', 'meaning' => 'Dengan rakus (membaca)', 'level' => 'C2', 'example' => 'As a child, I read voraciously.', 'meaning_id' => 'Eagerly consuming great quantities']
                ],
                'advanced_adjectives' => [
                    ['phrase' => 'Thought-provoking', 'meaning' => 'Menggugah pikiran', 'level' => 'C1', 'example' => 'It was a deeply thought-provoking novel.', 'meaning_id' => 'Stimulating reflection'],
                    ['phrase' => 'Gripping', 'meaning' => 'Sangat seru/menegangkan', 'level' => 'B2', 'example' => 'The gripping storyline kept me up all night.', 'meaning_id' => 'Firmly holding the attention'],
                    ['phrase' => 'Poignant', 'meaning' => 'Mengharukan/Menyedihkan', 'level' => 'C2', 'example' => 'The ending was incredibly poignant.', 'meaning_id' => 'Evoking a keen sense of sadness'],
                    ['phrase' => 'Intricate', 'meaning' => 'Rumit/Detail', 'level' => 'C1', 'example' => 'The book has an intricate plot.', 'meaning_id' => 'Very complicated or detailed'],
                    ['phrase' => 'Compelling', 'meaning' => 'Kuat/Memikat', 'level' => 'C1', 'example' => 'She tells a compelling story of survival.', 'meaning_id' => 'Evoking interest in a powerful way'],
                    ['phrase' => 'Tedious', 'meaning' => 'Membosankan/Bertele-tele', 'level' => 'C1', 'example' => 'The first few chapters were a bit tedious.', 'meaning_id' => 'Too long, slow, or dull'],
                    ['phrase' => 'Inspiring', 'meaning' => 'Menginspirasi', 'level' => 'B2', 'example' => 'It is an inspiring biography.', 'meaning_id' => 'Filling someone with the urge to do something'],
                    ['phrase' => 'Renowned', 'meaning' => 'Terkenal/Ternama', 'level' => 'C1', 'example' => 'Written by a renowned author.', 'meaning_id' => 'Known or talked about by many people'],
                    ['phrase' => 'Overrated', 'meaning' => 'Dinilai terlalu tinggi', 'level' => 'B2', 'example' => 'Personally, I found the bestseller overrated.', 'meaning_id' => 'Rated more highly than is deserved'],
                    ['phrase' => 'Riveting', 'meaning' => 'Sangat menarik', 'level' => 'C2', 'example' => 'I found the courtroom scenes quite riveting.', 'meaning_id' => 'Completely engrossing']
                ]
            ],
            [
                'title' => 'Describe a Journey',
                'part3_title' => 'Travel & Tourism',
                'slug' => 'describe-a-journey',
                'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'emerald',
                'questions' => [
                    'Describe a memorable journey you have taken.',
                    'You should say:',
                    '- where you went',
                    '- how you traveled',
                    '- why you went there',
                    'and explain what made this journey memorable.'
                ],
                'part3_questions' => [
                    'Why do some people prefer to travel alone?',
                    'Do you think tourism has a positive or negative impact on local communities?',
                    'How has travel changed compared to the past?',
                    'Is it better to plan a trip in detail or just go with the flow?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Itchy feet', 'meaning' => 'Keinginan kuat untuk bepergian', 'example' => 'I get itchy feet if I stay in one place too long.'],
                    ['phrase' => 'Off the beaten track', 'meaning' => 'Tempat terpencil/jarang dikunjungi', 'example' => 'We like to go off the beaten track when we travel.'],
                    ['phrase' => 'Broaden the mind', 'meaning' => 'Memperluas wawasan', 'example' => 'Travel certainly broadens the mind.'],
                    ['phrase' => 'Live out of a suitcase', 'meaning' => 'Sering bepergian', 'example' => 'He travels so much he lives out of a suitcase.'],
                    ['phrase' => 'Travel light', 'meaning' => 'Bepergian dengan sedikit barang', 'example' => 'I prefer to travel light.'],
                    ['phrase' => 'Hit the road', 'meaning' => 'Memulai perjalanan', 'example' => 'We hit the road early in the morning.'],
                    ['phrase' => 'Catch the red-eye', 'meaning' => 'Naik penerbangan malam', 'example' => 'We caught the red-eye flight to New York.'],
                    ['phrase' => 'Call it a day', 'meaning' => 'Mengakhiri kegiatan (hari ini)', 'example' => 'After 10 hours of driving, we decided to call it a day.'],
                    ['phrase' => 'Culture shock', 'meaning' => 'Gegar budaya', 'example' => 'Moving to a new country can cause culture shock.'],
                    ['phrase' => 'Thirst for adventure', 'meaning' => 'Haus akan petualangan', 'example' => 'He has a real thirst for adventure.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Cultural heritage', 'meaning' => 'Warisan budaya', 'example' => 'Tourism can help preserve cultural heritage.'],
                    ['phrase' => 'Eco-tourism', 'meaning' => 'Wisata ramah lingkungan', 'example' => 'Eco-tourism is becoming more popular.'],
                    ['phrase' => 'Carbon footprint', 'meaning' => 'Jejak karbon', 'example' => 'Air travel increases your carbon footprint.'],
                    ['phrase' => 'Local economy', 'meaning' => 'Ekonomi lokal', 'example' => 'Tourism boosts the local economy.'],
                    ['phrase' => 'Far-flung destination', 'meaning' => 'Tujuan yang jauh', 'example' => 'She loves visiting far-flung destinations.'],
                    ['phrase' => 'Breathtaking view', 'meaning' => 'Pemandangan menakjubkan', 'example' => 'The hotel room had a breathtaking view.'],
                    ['phrase' => 'Immersive experience', 'meaning' => 'Pengalaman mendalam', 'example' => 'We want an immersive cultural experience.'],
                    ['phrase' => 'Sustainable travel', 'meaning' => 'Perjalanan berkelanjutan', 'example' => 'Sustainable travel is important for the environment.'],
                    ['phrase' => 'Hidden gem', 'meaning' => 'Permata tersembunyi (tempat bagus yg blm terkenal)', 'example' => 'This cafe is a hidden gem.'],
                    ['phrase' => 'Travel restrictions', 'meaning' => 'Pembatasan perjalanan', 'example' => 'We must follow the travel restrictions.']
                ],
            ],
            [
                'title' => 'Describe a Person',
                'part3_title' => 'Role Models & Influence',
                'slug' => 'describe-a-person',
                'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                'color' => 'violet',
                'questions' => [
                    'Describe a person who has influenced you.',
                    'You should say:',
                    '- who this person is',
                    '- how you know them',
                    '- what they did to influence you',
                    'and explain how they have changed your life.'
                ],
                'part3_questions' => [
                    'What qualities make a person a good role model?',
                    'Do you think older people have a lot to teach younger generations?',
                    'How important is it to have positive influences in childhood?',
                    'Can famous people be good role models?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Follow in someone\'s footsteps', 'meaning' => 'Mengikuti jejak seseorang', 'example' => 'He followed in his father\'s footsteps and became a doctor.'],
                    ['phrase' => 'Look up to', 'meaning' => 'Menghormati/Mengagumi', 'example' => 'Children often look up to their parents.'],
                    ['phrase' => 'A bad egg', 'meaning' => 'Orang bermasalah', 'example' => 'Stay away from him, he\'s a bad egg.'],
                    ['phrase' => 'Set a good example', 'meaning' => 'Memberi contoh yang baik', 'example' => 'Teachers should set a good example for students.'],
                    ['phrase' => 'Dark horse', 'meaning' => 'Kuda hitam (orang yg kemampuannya tak terduga)', 'example' => 'She is the dark horse in this competition.'],
                    ['phrase' => 'Down to earth', 'meaning' => 'Rendah hati/sederhana', 'example' => 'Despite his fame, he is very down to earth.'],
                    ['phrase' => 'Heart of gold', 'meaning' => 'Berhati mulia', 'example' => 'My grandmother has a heart of gold.'],
                    ['phrase' => 'Cold shoulder', 'meaning' => 'Mengabaikan seseorang', 'example' => 'She gave me the cold shoulder.'],
                    ['phrase' => 'See eye to eye', 'meaning' => 'Sepaham/setuju', 'example' => 'We don\'t always see eye to eye.'],
                    ['phrase' => 'Role model', 'meaning' => 'Panutan', 'example' => 'He is a great role model for kids.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Positive influence', 'meaning' => 'Pengaruh positif', 'example' => 'She has a positive influence on the team.'],
                    ['phrase' => 'Role model', 'meaning' => 'Panutan', 'example' => 'Athletes are often role models for young people.'],
                    ['phrase' => 'Peer pressure', 'meaning' => 'Tekanan sebaya', 'example' => 'Teenagers often succumb to peer pressure.'],
                    ['phrase' => 'Moral compass', 'meaning' => 'Kompas moral', 'example' => 'He has a strong moral compass.'],
                    ['phrase' => 'Strong character', 'meaning' => 'Karakter kuat', 'example' => 'Adversity builds strong character.'],
                    ['phrase' => 'Set an example', 'meaning' => 'Memberikan contoh', 'example' => 'Parents must set an example for their children.'],
                    ['phrase' => 'Look up to', 'meaning' => 'Mengagumi', 'example' => 'I look up to my mentor.'],
                    ['phrase' => 'Influential figure', 'meaning' => 'Tokoh berpengaruh', 'example' => 'Gandhi was an influential figure.'],
                    ['phrase' => 'Parental guidance', 'meaning' => 'Bimbingan orang tua', 'example' => 'Parental guidance is crucial.'],
                    ['phrase' => 'Social behavior', 'meaning' => 'Perilaku sosial', 'example' => 'They study animal social behavior.']
                ],
            ],
            [
                'title' => 'Describe an Object',
                'part3_title' => 'Materialism & Value',
                'slug' => 'describe-an-object',
                'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'color' => 'amber',
                'questions' => [
                    'Describe an object you own that is very important to you.',
                    'You should say:',
                    '- what it is',
                    '- how you use it',
                    '- how long you have owned it',
                    'and explain why it is important to you.'
                ],
                'part3_questions' => [
                    'Do you think people are too attached to material possessions nowadays?',
                    'What kinds of things do people usually save or collect?',
                    'Do you think advertising influences what people buy?',
                    'Is it better to repair things or buy new ones?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Keep up with the Joneses', 'meaning' => 'Bersaing gaya hidup dengan tetangga', 'example' => 'They ruin themselves trying to keep up with the Joneses.'],
                    ['phrase' => 'Cost an arm and a leg', 'meaning' => 'Sangat mahal', 'example' => 'That car must have cost an arm and a leg.'],
                    ['phrase' => 'Born with a silver spoon', 'meaning' => 'Lahir dari keluarga kaya', 'example' => 'He was born with a silver spoon in his mouth.'],
                    ['phrase' => 'Money talks', 'meaning' => 'Uang berkuasa', 'example' => 'Unfortunately, in this business, money talks.'],
                    ['phrase' => 'Rags to riches', 'meaning' => 'Dari miskin jadi kaya', 'example' => 'It is a classic rags to riches story.'],
                    ['phrase' => 'Penny pincher', 'meaning' => 'Orang pelit/hemat', 'example' => 'She is a bit of a penny pincher.'],
                    ['phrase' => 'Break the bank', 'meaning' => 'Menghabiskan semua uang', 'example' => 'Buying a house doesn\'t have to break the bank.'],
                    ['phrase' => 'Money doesn\'t grow on trees', 'meaning' => 'Uang susah dicari', 'example' => 'I told my kids that money doesn\'t grow on trees.'],
                    ['phrase' => 'Feeling pinch', 'meaning' => 'Kesulitan ekonomi', 'example' => 'Everyone is feeling the pinch of inflation.'],
                    ['phrase' => 'Nest egg', 'meaning' => 'Tabungan masa depan', 'example' => 'They have built up a nice nest egg.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Consumer society', 'meaning' => 'Masyarakat konsumtif', 'example' => 'We live in a consumer society.'],
                    ['phrase' => 'Material possessions', 'meaning' => 'Harta benda', 'example' => 'Happiness is not defined by material possessions.'],
                    ['phrase' => 'Status symbol', 'meaning' => 'Simbol status', 'example' => 'Luxury cars are often seen as status symbols.'],
                    ['phrase' => 'Disposable income', 'meaning' => 'Pendapatan bersih (untuk belanja)', 'example' => 'Young professionals often have high disposable income.'],
                    ['phrase' => 'Brand loyalty', 'meaning' => 'Kesetiaan pada merek', 'example' => 'Companies try to build brand loyalty.'],
                    ['phrase' => 'Impulse buying', 'meaning' => 'Belanja impulsif', 'example' => 'Impulse buying ruins my budget.'],
                    ['phrase' => 'Consumer rights', 'meaning' => 'Hak konsumen', 'example' => 'We must protect consumer rights.'],
                    ['phrase' => 'Target market', 'meaning' => 'Pasar target', 'example' => 'Teenagers are the main target market.'],
                    ['phrase' => 'Goods and services', 'meaning' => 'Barang dan jasa', 'example' => 'The tax applies to all goods and services.'],
                    ['phrase' => 'Economic growth', 'meaning' => 'Pertumbuhan ekonomi', 'example' => 'Consumption drives economic growth.']
                ],
            ],
            [
                'title' => 'Describe a Time You Were Late',
                'part3_title' => 'Time Management',
                'slug' => 'describe-a-time-you-were-late',
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'rose',
                'questions' => [
                    'Describe a time when you were late for something important.',
                    'You should say:',
                    '- when it happened',
                    '- what you were late for',
                    '- why you were late',
                    'and explain what happened as a result.'
                ],
                'part3_questions' => [
                    'Why is punctuality important in some cultures but not others?',
                    'Do you think technology helps us manage time better?',
                    'How does being late affect other people?',
                    'Is it ever acceptable to be late?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Better late than never', 'meaning' => 'Lebih baik terlambat daripada tidak sama sekali', 'example' => 'He finally apologized. Better late than never.'],
                    ['phrase' => 'Beat the clock', 'meaning' => 'Selesai sebelum waktu habis', 'example' => 'We managed to beat the clock and finish the project.'],
                    ['phrase' => 'Kill time', 'meaning' => 'Mengisi waktu luang', 'example' => 'I read a magazine to kill time while waiting.'],
                    ['phrase' => 'In the nick of time', 'meaning' => 'Tepat pada waktunya (mepet)', 'example' => 'We arrived in the nick of time.'],
                    ['phrase' => 'Time flies', 'meaning' => 'Waktu berlalu cepat', 'example' => 'Time flies when you are having fun.'],
                    ['phrase' => 'Against the clock', 'meaning' => 'Berpacu dengan waktu', 'example' => 'We are working against the clock.'],
                    ['phrase' => 'Make up for lost time', 'meaning' => 'Mengejar ketertinggalan waktu', 'example' => 'We drove fast to make up for lost time.'],
                    ['phrase' => 'On the dot', 'meaning' => 'Tepat waktu (presisi)', 'example' => 'The meeting started at 9 am on the dot.'],
                    ['phrase' => 'Around the clock', 'meaning' => 'Sepanjang hari/24 jam', 'example' => 'Doctors worked around the clock.'],
                    ['phrase' => 'Once in a blue moon', 'meaning' => 'Sangat jarang terjadi', 'example' => 'This only happens once in a blue moon.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Time management', 'meaning' => 'Manajemen waktu', 'example' => 'Good time management is essential for students.'],
                    ['phrase' => 'Punctuality', 'meaning' => 'Ketepatan waktu', 'example' => 'Punctuality is highly valued in the workplace.'],
                    ['phrase' => 'Stick to a schedule', 'meaning' => 'Mengikuti jadwal', 'example' => 'It is difficult to stick to a schedule when traveling.'],
                    ['phrase' => 'Waste time', 'meaning' => 'Membuang waktu', 'example' => 'Don\'t waste time worrying about things you can\'t change.'],
                    ['phrase' => 'Strict deadline', 'meaning' => 'Tenggat waktu yang ketat', 'example' => 'We have a strict deadline.'],
                    ['phrase' => 'Time-consuming', 'meaning' => 'Menghabiskan banyak waktu', 'example' => 'This process is very time-consuming.'],
                    ['phrase' => 'Efficient use of time', 'meaning' => 'Penggunaan waktu efisien', 'example' => 'We need more efficient use of time.'],
                    ['phrase' => 'Prioritize tasks', 'meaning' => 'Memprioritaskan tugas', 'example' => 'You need to prioritize tasks effectively.'],
                    ['phrase' => 'Allocate resources', 'meaning' => 'Mengalokasikan sumber daya', 'example' => 'They allocated resources to the project.'],
                    ['phrase' => 'Running out of time', 'meaning' => 'Kehabisan waktu', 'example' => 'We are running out of time.']
                ],
            ],
            [
                'title' => 'Describe a Party',
                'part3_title' => 'Celebrations & Social Gatherings',
                'slug' => 'describe-a-party',
                'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'fuchsia',
                'questions' => [
                    'Describe a party that you enjoyed.',
                    'You should say:',
                    '- whose party it was',
                    '- when and where it took place',
                    '- what happened at the party',
                    'and explain why you enjoyed it.'
                ],
                'part3_questions' => [
                    'Why do people organize parties?',
                    'What kind of parties are popular in your country?',
                    'Do you think parties are important for social bonding?',
                    'How has the way people celebrate changed over time?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Let your hair down', 'meaning' => 'Bersantai dan menikmati diri', 'example' => 'It\'s a good opportunity to let your hair down.'],
                    ['phrase' => 'Paint the town red', 'meaning' => 'Pesta/Bersenang-senang keluar', 'example' => 'They decided to paint the town red after exams.'],
                    ['phrase' => 'Life of the party', 'meaning' => 'Orang yang paling seru di pesta', 'example' => 'He is always the life of the party.'],
                    ['phrase' => 'Throw a party', 'meaning' => 'Mengadakan pesta', 'example' => 'We are throwing a party for her birthday.'],
                    ['phrase' => 'Have a whale of a time', 'meaning' => 'Bersenang-senang sangat', 'example' => 'We had a whale of a time at the concert.'],
                    ['phrase' => 'Let off steam', 'meaning' => 'Melepas penat', 'example' => 'Dancing is good to let off steam.'],
                    ['phrase' => 'Party animal', 'meaning' => 'Orang yang suka pesta', 'example' => 'He used to be a real party animal.'],
                    ['phrase' => 'Full of beans', 'meaning' => 'Penuh energi', 'example' => 'The kids were full of beans at the party.'],
                    ['phrase' => 'Breaking the ice', 'meaning' => 'Mencairkan suasana', 'example' => 'Games are good for breaking the ice.'],
                    ['phrase' => 'Social butterfly', 'meaning' => 'Orang yang mudah bergaul', 'example' => 'She is a real social butterfly.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Social gathering', 'meaning' => 'Pertemuan sosial', 'example' => 'Weddings are important social gatherings.'],
                    ['phrase' => 'Cultural tradition', 'meaning' => 'Tradisi budaya', 'example' => 'Many festivals are rooted in cultural traditions.'],
                    ['phrase' => 'Festive atmosphere', 'meaning' => 'Suasana meriah', 'example' => 'There was a festive atmosphere in the city.'],
                    ['phrase' => 'Celebrate an occasion', 'meaning' => 'Merayakan suatu acara', 'example' => 'We gathered to celebrate a special occasion.'],
                    ['phrase' => 'Host an event', 'meaning' => 'Menjadi tuan rumah acara', 'example' => 'They hosted a charity event.'],
                    ['phrase' => 'Quality time', 'meaning' => 'Waktu berkualitas', 'example' => 'Holidays are for spending quality time with family.'],
                    ['phrase' => 'Memorable experience', 'meaning' => 'Pengalaman berkesan', 'example' => 'It was a truly memorable experience.'],
                    ['phrase' => 'Family reunion', 'meaning' => 'Reuni keluarga', 'example' => 'We have a big family reunion every year.'],
                    ['phrase' => 'Sense of community', 'meaning' => 'Rasa kebersamaan', 'example' => 'Festivals build a sense of community.'],
                    ['phrase' => 'Formal occasion', 'meaning' => 'Acara resmi', 'example' => 'You must dress well for a formal occasion.']
                ],
            ],
            [
                'title' => 'Describe a Gift',
                'part3_title' => 'Generosity & Gifting',
                'slug' => 'describe-a-gift',
                'icon' => 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7',
                'color' => 'pink',
                'questions' => [
                    'Describe a gift you usually give to others.',
                    'You should say:',
                    '- what the gift is',
                    '- who you give it to',
                    '- why you choose this gift',
                    'and explain how people react to it.'
                ],
                'part3_questions' => [
                    'Why do people give gifts?',
                    'Is it the cost of the gift or the thought that counts?',
                    'Do you think commercialism has changed gift-giving traditions?',
                    'What kinds of gifts are popular in your country?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Look a gift horse in the mouth', 'meaning' => 'Mengeluh tentang pemberian', 'example' => 'You shouldn\'t look a gift horse in the mouth.'],
                    ['phrase' => 'It\'s the thought that counts', 'meaning' => 'Niatnya yang penting', 'example' => 'The gift wasn\'t expensive, but it\'s the thought that counts.'],
                    ['phrase' => 'Give someone a hand', 'meaning' => 'Membantu seseorang', 'example' => 'Can you give me a hand with these bags?'],
                    ['phrase' => 'Heart of gold', 'meaning' => 'Hati yang sangat baik', 'example' => 'She has a heart of gold.'],
                    ['phrase' => 'Generous to a fault', 'meaning' => 'Terlalu dermawan', 'example' => 'He is generous to a fault.'],
                    ['phrase' => 'Giving is better than receiving', 'meaning' => 'Memberi lebih baik dari menerima', 'example' => 'I believe that giving is better than receiving.'],
                    ['phrase' => 'Make someone\'s day', 'meaning' => 'Membuat seseorang sangat senang', 'example' => ' Receiving that letter made my day.'],
                    ['phrase' => 'From the bottom of my heart', 'meaning' => 'Dari lubuk hati terdalam', 'example' => 'I thank you from the bottom of my heart.'],
                    ['phrase' => 'With open arms', 'meaning' => 'Dengan tangan terbuka/senang hati', 'example' => 'They welcomed us with open arms.'],
                    ['phrase' => 'Good turn', 'meaning' => 'Perbuatan baik', 'example' => 'One good turn deserves another.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Token of appreciation', 'meaning' => 'Tanda penghargaan', 'example' => 'Please accept this gift as a token of appreciation.'],
                    ['phrase' => 'Generosity', 'meaning' => 'Kedermawanan', 'example' => 'He is known for his generosity.'],
                    ['phrase' => 'Commercialism', 'meaning' => 'Komersialisme', 'example' => 'Many complain about the commercialism of Christmas.'],
                    ['phrase' => 'Express gratitude', 'meaning' => 'Menunjukkan rasa terima kasih', 'example' => 'Gifts are a way to express gratitude.'],
                    ['phrase' => 'Thoughtful gesture', 'meaning' => 'Tindakan penuh perhatian', 'example' => 'It was a very thoughtful gesture.'],
                    ['phrase' => 'Wrapping paper', 'meaning' => 'Kertas kado', 'example' => 'We need more wrapping paper.'],
                    ['phrase' => 'Surprise party', 'meaning' => 'Pesta kejutan', 'example' => 'They threw a surprise party for him.'],
                    ['phrase' => 'Spontaneous gift', 'meaning' => 'Hadiah spontan', 'example' => 'A spontaneous gift can mean a lot.'],
                    ['phrase' => 'Act of kindness', 'meaning' => 'Tindakan kebaikan', 'example' => 'A random act of kindness changes lives.'],
                    ['phrase' => 'Monetary value', 'meaning' => 'Nilai uang', 'example' => 'The gift had little monetary value but high sentimental value.']
                ],
            ],
            [
                'title' => 'Describe a Teacher',
                'part3_title' => 'Education & Learning',
                'slug' => 'describe-a-teacher',
                'icon' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z',
                'color' => 'slate',
                'questions' => [
                    'Describe a teacher who has influenced you in your education.',
                    'You should say:',
                    '- where you met them',
                    '- what subject they taught',
                    '- what was special about them',
                    'and explain why they influenced you so much.'
                ],
                'part3_questions' => [
                    'What qualities make a good teacher?',
                    'Do you think computers will ever replace teachers?',
                    'How has education changed in recent years?',
                    'Should teachers be strict or friendly?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Learn the ropes', 'meaning' => 'Mempelajari dasar-dasar', 'example' => 'It takes time to learn the ropes of a new job.'],
                    ['phrase' => 'Teacher\'s pet', 'meaning' => 'Murid kesayangan guru', 'example' => 'Nobody likes a teacher\'s pet.'],
                    ['phrase' => 'Pass with flying colors', 'meaning' => 'Lulus dengan nilai sangat baik', 'example' => 'She passed the exam with flying colors.'],
                    ['phrase' => 'Hit the books', 'meaning' => 'Belajar dengan giat', 'example' => 'I have to hit the books tonight.'],
                    ['phrase' => 'Bookworm', 'meaning' => 'Orang gemar membaca', 'example' => 'She has always been a bookworm.'],
                    ['phrase' => 'Copycat', 'meaning' => 'Peniru', 'example' => 'Don\'t be a copycat, have your own ideas.'],
                    ['phrase' => 'Brainstorm', 'meaning' => 'Bertukar pikiran', 'example' => 'We need to brainstorm some ideas.'],
                    ['phrase' => 'Old school', 'meaning' => 'Kuno/Tradisional', 'example' => 'His teaching methods are a bit old school.'],
                    ['phrase' => 'From the old school', 'meaning' => 'Berpandangan tradisional', 'example' => 'He is a gentleman from the old school.'],
                    ['phrase' => 'Make the grade', 'meaning' => 'Mencapai standar', 'example' => 'He didn\'t quite make the grade to get into university.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Academic achievement', 'meaning' => 'Prestasi akademik', 'example' => 'They value academic achievement highly.'],
                    ['phrase' => 'Lifelong learning', 'meaning' => 'Belajar sepanjang hayat', 'example' => 'In today\'s world, lifelong learning is essential.'],
                    ['phrase' => 'Critical thinking', 'meaning' => 'Berpikir kritis', 'example' => 'Schools should teach critical thinking skills.'],
                    ['phrase' => 'Curriculum extracurricular', 'meaning' => 'Kurikulum ekstrakurikuler', 'example' => 'Sports are an important part of the extracurricular curriculum.'],
                    ['phrase' => 'Higher education', 'meaning' => 'Pendidikan tinggi', 'example' => 'Access to higher education is growing.'],
                    ['phrase' => 'Teaching method', 'meaning' => 'Metode pengajaran', 'example' => 'Innovative teaching methods engage students.'],
                    ['phrase' => 'Distance learning', 'meaning' => 'Pembelajaran jarak jauh', 'example' => 'Distance learning has become very common.'],
                    ['phrase' => 'Formal education', 'meaning' => 'Pendidikan formal', 'example' => 'He lacks formal education but is very smart.'],
                    ['phrase' => 'Continuous assessment', 'meaning' => 'Penilaian berkelanjutan', 'example' => 'They prefer continuous assessment over exams.'],
                    ['phrase' => 'Vocational training', 'meaning' => 'Pelatihan kejuruan', 'example' => 'Vocational training leads to practical skills.']
                ],
            ],
            [
                'title' => 'Describe a Childhood Friend',
                'part3_title' => 'Friendship & Relationships',
                'slug' => 'describe-a-childhood-friend',
                'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                'color' => 'teal',
                'questions' => [
                    'Describe a childhood friend of yours.',
                    'You should say:',
                    '- how you met this friend',
                    '- what you did together',
                    '- how long you were friends',
                    'and explain why you liked being friends with this person.'
                ],
                'part3_questions' => [
                    'Do you think childhood friendships can last a lifetime?',
                    'What is more important: having many friends or a few close ones?',
                    'How do people make friends differently as adults compared to children?',
                    'What qualities do you look for in a friend?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Through thick and thin', 'meaning' => 'Dalam suka dan duka', 'example' => 'A true friend stays with you through thick and thin.'],
                    ['phrase' => 'Two peas in a pod', 'meaning' => 'Sangat mirip/selalu bersama', 'example' => 'They differ in age, but they are like two peas in a pod.'],
                    ['phrase' => 'Cross paths', 'meaning' => 'Bertemu secara kebetulan', 'example' => 'It was years before our paths crossed again.'],
                    ['phrase' => 'Bury the hatchet', 'meaning' => 'Berdamai (melupakan perselisihan)', 'example' => 'They finally decided to bury the hatchet.'],
                    ['phrase' => 'Shoulder to cry on', 'meaning' => 'Teman curhat', 'example' => 'She needed a shoulder to cry on.'],
                    ['phrase' => 'Fair-weather friend', 'meaning' => 'Teman yang ada saat senang saja', 'example' => 'He turned out to be a fair-weather friend.'],
                    ['phrase' => 'Hit it off', 'meaning' => 'Langsung akrab', 'example' => 'We hit it off immediately.'],
                    ['phrase' => 'Keep in touch', 'meaning' => 'Tetap berkomunikasi', 'example' => 'Let\'s keep in touch.'],
                    ['phrase' => 'Move in the same circles', 'meaning' => 'Bergaul di lingkungan yang sama', 'example' => 'We move in the same circles.'],
                    ['phrase' => 'Know someone inside out', 'meaning' => 'Sangat mengenal seseorang', 'example' => 'I know him inside out.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Platonic relationship', 'meaning' => 'Hubungan tanpa romansa', 'example' => 'Their relationship is purely platonic.'],
                    ['phrase' => 'Mutual trust', 'meaning' => 'Saling percaya', 'example' => 'Friendship is built on mutual trust.'],
                    ['phrase' => 'Support system', 'meaning' => 'Sistem pendukung (teman/keluarga)', 'example' => 'Friends provide an essential support system during hard times.'],
                    ['phrase' => 'Drift apart', 'meaning' => 'Tumbuh menjauh (perlahan)', 'example' => 'It is natural for childhood friends to drift apart.'],
                    ['phrase' => 'Close confidant', 'meaning' => 'Orang kepercayaan', 'example' => 'She is my closest confidant.'],
                    ['phrase' => 'Long-term friendship', 'meaning' => 'Persahabatan jangka panjang', 'example' => 'They have a long-term friendship.'],
                    ['phrase' => 'Childhood bond', 'meaning' => 'Ikatan masa kecil', 'example' => 'The childhood bond is strong.'],
                    ['phrase' => 'Social circle', 'meaning' => 'Lingkaran pergaulan', 'example' => 'He has a wide social circle.'],
                    ['phrase' => 'Extend friendship', 'meaning' => 'Menawarkan persahabatan', 'example' => 'He extended his hand in friendship.'],
                    ['phrase' => 'Enjoy someone\'s company', 'meaning' => 'Menikmati kebersamaan dengan seseorang', 'example' => 'I really enjoy your company.']
                ],
            ],
            [
                'title' => 'Describe a Holiday',
                'part3_title' => 'Vacations & Leisure',
                'slug' => 'describe-a-holiday',
                'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'cyan',
                'questions' => [
                    'Describe a holiday you recently had.',
                    'You should say:',
                    '- where you went',
                    '- who you went with',
                    '- what you did there',
                    'and explain why you enjoyed it.'
                ],
                'part3_questions' => [
                    'How important are holidays for people?',
                    'Do you think people travel more now than in the past?',
                    'What are the benefits of traveling to foreign countries?',
                    'How do different cultures celebrate holidays?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Recharge your batteries', 'meaning' => 'Mengisi ulang tenaga/istirahat', 'example' => 'A holiday helps you recharge your batteries.'],
                    ['phrase' => 'Get away from it all', 'meaning' => 'Pergi menenangkan diri', 'example' => 'Ideally, I\'d like to get away from it all to a remote island.'],
                    ['phrase' => 'Hustle and bustle', 'meaning' => 'Hiruk pikuk (kota)', 'example' => 'I wanted to escape the hustle and bustle of the city.'],
                    ['phrase' => 'Let off steam', 'meaning' => 'Melepas penat/emosi', 'example' => 'Sports are a great way to let off steam.'],
                    ['phrase' => 'Travel broadens the mind', 'meaning' => 'Perjalanan memperluas wawasan', 'example' => 'I truly believe that travel broadens the mind.'],
                    ['phrase' => 'Off the beaten track', 'meaning' => 'Tempat yang jarang dikunjungi', 'example' => 'We like to go off the beaten track.'],
                    ['phrase' => 'Thirst for adventure', 'meaning' => 'Haus akan petualangan', 'example' => 'He has an insatiable thirst for adventure.'],
                    ['phrase' => 'Live like a king', 'meaning' => 'Hidup mewah', 'example' => 'We lived like kings in that hotel.'],
                    ['phrase' => 'On a shoestring budget', 'meaning' => 'Dengan anggaran sangat terbatas', 'example' => 'We traveled on a shoestring budget.'],
                    ['phrase' => 'Take a break', 'meaning' => 'Istirahat sejenak', 'example' => 'You need to take a break from work.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Leisure time', 'meaning' => 'Waktu luang', 'example' => 'People are accumulating more leisure time nowadays.'],
                    ['phrase' => 'Tourist destination', 'meaning' => 'Tujuan wisata', 'example' => 'Bali is a top tourist destination.'],
                    ['phrase' => 'Peak season', 'meaning' => 'Musim ramai liburan', 'example' => 'Prices are higher during peak season.'],
                    ['phrase' => 'Work-life balance', 'meaning' => 'Keseimbangan kerja dan hidup', 'example' => 'Holidays are crucial for work-life balance.'],
                    ['phrase' => 'Package tour', 'meaning' => 'Wisata paket', 'example' => 'We booked a package tour to Italy.'],
                    ['phrase' => 'Holiday resort', 'meaning' => 'Resor liburan', 'example' => 'They stayed at a luxury holiday resort.'],
                    ['phrase' => 'Local cuisine', 'meaning' => 'Masakan lokal', 'example' => 'You must try the local cuisine.'],
                    ['phrase' => 'Scenic route', 'meaning' => 'Rute pemandangan indah', 'example' => 'We took the scenic route home.'],
                    ['phrase' => 'Relaxation techniques', 'meaning' => 'Teknik relaksasi', 'example' => 'Yoga includes relaxation techniques.'],
                    ['phrase' => 'Public holiday', 'meaning' => 'Hari libur nasional', 'example' => 'Monday is a public holiday.']
                ],
            ],
            [
                'title' => 'Describe a Famous Person',
                'part3_title' => 'Fame & Media',
                'slug' => 'describe-a-famous-person',
                'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
                'color' => 'lime',
                'questions' => [
                    'Describe a famous person you would like to meet.',
                    'You should say:',
                    '- who this person is',
                    '- why they are famous',
                    '- what you would talk about with them',
                    'and explain why you want to meet them.'
                ],
                'part3_questions' => [
                    'Why are some people obsessed with celebrities?',
                    'Do famous people have a responsibility to be good role models?',
                    'How does the media influence our opinion of famous people?',
                    'Would you like to be famous?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'In the spotlight', 'meaning' => 'Menjadi pusat perhatian', 'example' => 'She loves being in the spotlight.'],
                    ['phrase' => 'Household name', 'meaning' => 'Nama yang dikenal semua orang', 'example' => 'He became a household name after the movie.'],
                    ['phrase' => 'Claim to fame', 'meaning' => 'Alasan terkenal', 'example' => 'Her claim to fame is a viral video.'],
                    ['phrase' => 'Price of fame', 'meaning' => 'Harga/konsekuensi ketenaran', 'example' => 'Loss of privacy is the price of fame.'],
                    ['phrase' => 'One-hit wonder', 'meaning' => 'Terkenal hanya karena satu karya', 'example' => 'The band was a one-hit wonder.'],
                    ['phrase' => 'Star-studded', 'meaning' => 'Bertabur bintang', 'example' => 'It was a star-studded event.'],
                    ['phrase' => 'Shoot to fame', 'meaning' => 'Tiba-tiba terkenal', 'example' => 'He shot to fame overnight.'],
                    ['phrase' => 'In the public eye', 'meaning' => 'Di mata publik', 'example' => 'The royal family lives in the public eye.'],
                    ['phrase' => 'Brush with fame', 'meaning' => 'Bertemu orang terkenal sebentar', 'example' => 'I had a brush with fame at the airport.'],
                    ['phrase' => 'Walk of life', 'meaning' => 'Latar belakang kehidupan', 'example' => 'People from all walks of life admire him.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Public eye', 'meaning' => 'Sorotan publik', 'example' => 'Growing up in the public eye can be difficult.'],
                    ['phrase' => 'Media scrutiny', 'meaning' => 'Pengawasan media', 'example' => 'Politicians face constant media scrutiny.'],
                    ['phrase' => 'Role model', 'meaning' => 'Panutan', 'example' => 'Celebrities should be positive role models.'],
                    ['phrase' => 'Instant stardom', 'meaning' => 'Ketenaran instan', 'example' => 'Reality TV offers a path to instant stardom.'],
                    ['phrase' => 'Celebrity culture', 'meaning' => 'Budaya selebriti', 'example' => 'Celebrity culture influences teenagers.'],
                    ['phrase' => 'Paparazzi attention', 'meaning' => 'Perhatian paparazzi', 'example' => 'Paparazzi attention can be intrusive.'],
                    ['phrase' => 'Public image', 'meaning' => 'Citra publik', 'example' => 'He hires someone to manage his public image.'],
                    ['phrase' => 'Fan base', 'meaning' => 'Basis penggemar', 'example' => 'The singer has a loyal fan base.'],
                    ['phrase' => 'Gossip column', 'meaning' => 'Kolom gosip', 'example' => 'She is often mentioned in gossip columns.'],
                    ['phrase' => 'Trend setter', 'meaning' => 'Pencipta tren', 'example' => 'She is considered a fashion trend setter.']
                ],
            ],
            [
                'title' => 'Describe a Website',
                'part3_title' => 'Internet & Information',
                'slug' => 'describe-a-website',
                'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m-9 9a9 9 0 019-9',
                'color' => 'indigo',
                'questions' => [
                    'Describe a website you often use.',
                    'You should say:',
                    '- what the website is',
                    '- how often you use it',
                    '- what you use it for',
                    'and explain why you find it useful.'
                ],
                'part3_questions' => [
                    'How has the internet changed the way we access information?',
                    'Do you think children spend too much time online?',
                    'What are the dangers of the internet?',
                    'Will the internet replace traditional media like newspapers and TV?'
                ],
                'part3_idioms' => [
                    ['phrase' => 'Surfing the net', 'meaning' => 'Menjelajah internet', 'example' => 'I spent hours surfing the net.'],
                    ['phrase' => 'At your fingertips', 'meaning' => 'Mudah diakses/dekat', 'example' => 'Information is now at your fingertips.'],
                    ['phrase' => 'Go viral', 'meaning' => 'Menjadi viral', 'example' => 'The video went viral within hours.'],
                    ['phrase' => 'Information overload', 'meaning' => 'Kelebihan informasi', 'example' => 'We suffer from information overload today.'],
                    ['phrase' => 'Digital footprint', 'meaning' => 'Jejak digital', 'example' => 'Be careful about your digital footprint.'],
                    ['phrase' => 'Glued to the screen', 'meaning' => 'Terpaku pada layar', 'example' => 'Kids are glued to the screen all day.'],
                    ['phrase' => 'Tech-savvy', 'meaning' => 'Melek teknologi', 'example' => 'My grandmother is surprisingly tech-savvy.'],
                    ['phrase' => 'Behind the times', 'meaning' => 'Ketinggalan zaman', 'example' => 'His computer is a bit behind the times.'],
                    ['phrase' => 'Cutting edge', 'meaning' => 'Canggih', 'example' => 'This software is cutting edge.'],
                    ['phrase' => 'Click bait', 'meaning' => 'Umpan klik (judul menipu)', 'example' => 'Don\'t click on that, it\'s just click bait.']
                ],
                'part3_collocations' => [
                    ['phrase' => 'Digital literacy', 'meaning' => 'Literasi digital', 'example' => 'Digital literacy is a key skill for the future.'],
                    ['phrase' => 'Cyber security', 'meaning' => 'Keamanan siber', 'example' => 'Cyber security is a major concern.'],
                    ['phrase' => 'Online privacy', 'meaning' => 'Privasi online', 'example' => 'We must protect our online privacy.'],
                    ['phrase' => 'Social media platform', 'meaning' => 'Platform media sosial', 'example' => 'New social media platforms emerge every year.'],
                    ['phrase' => 'Search engine', 'meaning' => 'Mesin pencari', 'example' => 'Google is the most popular search engine.'],
                    ['phrase' => 'User interface', 'meaning' => 'Antarmuka pengguna', 'example' => 'The app has a simple user interface.'],
                    ['phrase' => 'Information age', 'meaning' => 'Era informasi', 'example' => 'We are living in the information age.'],
                    ['phrase' => 'Virtual reality', 'meaning' => 'Realitas virtual', 'example' => 'Virtual reality gaming is growing.'],
                    ['phrase' => 'Online transaction', 'meaning' => 'Transaksi online', 'example' => 'Online transactions are secure.'],
                    ['phrase' => 'Data protection', 'meaning' => 'Perlindungan data', 'example' => 'Data protection laws are strict.']
                ],
            ],
        ];
    }
}
