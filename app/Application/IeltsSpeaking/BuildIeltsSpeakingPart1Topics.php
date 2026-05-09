<?php

namespace App\Application\IeltsSpeaking;

class BuildIeltsSpeakingPart1Topics
{
    public function __construct(
        private readonly IeltsSpeakingPart1LessonsData $lessonsData
    ) {}

    public function handle(bool $includeLessons = true): array
    {
        $topicTitles = [
            'Hometown and Neighborhood',
            'Work or Study Life',
            'Daily Routine',
            'Morning Habits',
            'Evening Activities',
            'Family Traditions',
            'Friends and Social Life',
            'Favorite Food',
            'Cooking at Home',
            'Restaurants and Cafes',
            'Public Transportation',
            'Traffic in Your City',
            'Travel and Holidays',
            'Weekend Plans',
            'Shopping Habits',
            'Online Shopping',
            'Clothing and Fashion',
            'Weather and Seasons',
            'Sports and Exercise',
            'Outdoor Activities',
            'Music Preferences',
            'Movies and Series',
            'Reading Books',
            'Learning Languages',
            'Technology in Daily Life',
            'Mobile Phone Use',
            'Social Media Habits',
            'Photography',
            'Art and Creativity',
            'Science and Curiosity',
            'History and Culture',
            'Festivals in Your Country',
            'School Memories',
            'University Experience',
            'First Job Experience',
            'Goals for the Future',
            'Saving Money',
            'Giving Gifts',
            'Time Management',
            'Stress and Relaxation',
            'Sleep Quality',
            'Health and Lifestyle',
            'Environment and Recycling',
            'Parks and Public Spaces',
            'Animals and Pets',
            'Childhood Games',
            'Festive Celebrations',
            'Communication Skills',
            'Leadership and Teamwork',
            'Dream Home'
        ];

        $colors = ['blue', 'green', 'indigo', 'orange', 'purple', 'red', 'sky', 'cyan', 'pink', 'teal'];
        $icon = 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z';

        $lexicalBanks = [
            'education_work' => [
                'idioms' => [
                    ['phrase' => 'learn the ropes', 'meaning' => 'belajar dasar-dasar pekerjaan/aktivitas baru', 'example' => 'During my first month at work, I was learning the ropes.'],
                    ['phrase' => 'hit the books', 'meaning' => 'belajar dengan giat', 'example' => 'I usually hit the books before an important exam.'],
                    ['phrase' => 'burn the midnight oil', 'meaning' => 'belajar atau bekerja sampai larut malam', 'example' => 'I had to burn the midnight oil to finish my project.'],
                    ['phrase' => 'climb the career ladder', 'meaning' => 'naik jenjang karier', 'example' => 'She wants to climb the career ladder in her company.'],
                    ['phrase' => 'think on your feet', 'meaning' => 'berpikir cepat dalam situasi sulit', 'example' => 'In interviews, you need to think on your feet.'],
                    ['phrase' => 'get the hang of', 'meaning' => 'mulai terbiasa dan paham', 'example' => 'It took me two weeks to get the hang of online classes.'],
                    ['phrase' => 'pull your weight', 'meaning' => 'berkontribusi dengan adil dalam tim', 'example' => 'Everyone must pull their weight in group assignments.'],
                    ['phrase' => 'go the extra mile', 'meaning' => 'melakukan lebih dari yang diminta', 'example' => 'Good teachers always go the extra mile for students.'],
                    ['phrase' => 'back to square one', 'meaning' => 'kembali ke titik awal', 'example' => 'When our plan failed, we were back to square one.'],
                    ['phrase' => 'in the same boat', 'meaning' => 'berada dalam situasi yang sama', 'example' => 'All final-year students are in the same boat before graduation.'],
                ],
                'collocations' => [
                    ['phrase' => 'meet a deadline', 'meaning' => 'memenuhi tenggat waktu', 'example' => 'I always try to meet a deadline at work.'],
                    ['phrase' => 'practical skills', 'meaning' => 'keterampilan praktis', 'example' => 'Internships help students build practical skills.'],
                    ['phrase' => 'academic performance', 'meaning' => 'performa akademik', 'example' => 'Sleep quality affects academic performance.'],
                    ['phrase' => 'career prospects', 'meaning' => 'prospek karier', 'example' => 'This major offers strong career prospects.'],
                    ['phrase' => 'full-time job', 'meaning' => 'pekerjaan penuh waktu', 'example' => 'She recently started a full-time job.'],
                    ['phrase' => 'team collaboration', 'meaning' => 'kolaborasi tim', 'example' => 'Successful projects require team collaboration.'],
                    ['phrase' => 'learning environment', 'meaning' => 'lingkungan belajar', 'example' => 'A quiet room creates a better learning environment.'],
                    ['phrase' => 'professional growth', 'meaning' => 'perkembangan profesional', 'example' => 'Feedback is important for professional growth.'],
                    ['phrase' => 'study schedule', 'meaning' => 'jadwal belajar', 'example' => 'I follow a study schedule during exam week.'],
                    ['phrase' => 'leadership qualities', 'meaning' => 'kualitas kepemimpinan', 'example' => 'Group projects can reveal leadership qualities.'],
                ],
            ],
            'home_city' => [
                'idioms' => [
                    ['phrase' => 'home sweet home', 'meaning' => 'rumah sendiri terasa paling nyaman', 'example' => 'After traveling, I always feel home sweet home.'],
                    ['phrase' => 'a stone\'s throw away', 'meaning' => 'sangat dekat', 'example' => 'The park is a stone\'s throw away from my house.'],
                    ['phrase' => 'the heart of the city', 'meaning' => 'pusat kota', 'example' => 'My office is in the heart of the city.'],
                    ['phrase' => 'neck of the woods', 'meaning' => 'daerah atau lingkungan tertentu', 'example' => 'There are many cafes in my neck of the woods.'],
                    ['phrase' => 'a breath of fresh air', 'meaning' => 'sesuatu yang menyegarkan', 'example' => 'Weekend walks are a breath of fresh air for me.'],
                    ['phrase' => 'off the beaten track', 'meaning' => 'di tempat yang jarang dikunjungi', 'example' => 'My hometown is off the beaten track.'],
                    ['phrase' => 'close-knit community', 'meaning' => 'komunitas yang akrab', 'example' => 'I grew up in a close-knit community.'],
                    ['phrase' => 'put down roots', 'meaning' => 'menetap dan membangun kehidupan', 'example' => 'My parents put down roots in this neighborhood.'],
                    ['phrase' => 'a place in the sun', 'meaning' => 'tempat yang nyaman untuk hidup', 'example' => 'Many families look for a place in the sun.'],
                    ['phrase' => 'feel at home', 'meaning' => 'merasa nyaman seperti di rumah', 'example' => 'I quickly feel at home in peaceful places.'],
                ],
                'collocations' => [
                    ['phrase' => 'residential area', 'meaning' => 'kawasan perumahan', 'example' => 'I live in a quiet residential area.'],
                    ['phrase' => 'public facilities', 'meaning' => 'fasilitas umum', 'example' => 'Our city has improved public facilities.'],
                    ['phrase' => 'local community', 'meaning' => 'komunitas setempat', 'example' => 'The local community organizes events regularly.'],
                    ['phrase' => 'green spaces', 'meaning' => 'ruang hijau', 'example' => 'Children need more green spaces to play.'],
                    ['phrase' => 'city center', 'meaning' => 'pusat kota', 'example' => 'Traffic is usually heavy in the city center.'],
                    ['phrase' => 'housing costs', 'meaning' => 'biaya perumahan', 'example' => 'Housing costs are rising in big cities.'],
                    ['phrase' => 'neighborhood safety', 'meaning' => 'keamanan lingkungan', 'example' => 'Neighborhood safety is important for families.'],
                    ['phrase' => 'public park', 'meaning' => 'taman umum', 'example' => 'I jog in a public park every weekend.'],
                    ['phrase' => 'urban development', 'meaning' => 'pengembangan perkotaan', 'example' => 'Urban development changed this district quickly.'],
                    ['phrase' => 'peaceful atmosphere', 'meaning' => 'suasana yang tenang', 'example' => 'I prefer neighborhoods with a peaceful atmosphere.'],
                ],
            ],
            'food_lifestyle' => [
                'idioms' => [
                    ['phrase' => 'food for thought', 'meaning' => 'sesuatu untuk dipikirkan serius', 'example' => 'The documentary gave me food for thought about diet.'],
                    ['phrase' => 'piece of cake', 'meaning' => 'sangat mudah', 'example' => 'Cooking simple meals is a piece of cake for me.'],
                    ['phrase' => 'in hot water', 'meaning' => 'dalam masalah', 'example' => 'I was in hot water for skipping breakfast again.'],
                    ['phrase' => 'full of beans', 'meaning' => 'penuh energi', 'example' => 'After exercise, I feel full of beans.'],
                    ['phrase' => 'spill the beans', 'meaning' => 'membocorkan rahasia', 'example' => 'My friend spilled the beans about the surprise dinner.'],
                    ['phrase' => 'on the menu', 'meaning' => 'menjadi pilihan yang dipertimbangkan', 'example' => 'Healthy snacks are always on the menu at home.'],
                    ['phrase' => 'butter someone up', 'meaning' => 'menjilat seseorang', 'example' => 'He tried to butter his parents up for extra allowance.'],
                    ['phrase' => 'salt of the earth', 'meaning' => 'orang yang sangat baik dan sederhana', 'example' => 'My grandmother is the salt of the earth.'],
                    ['phrase' => 'not my cup of tea', 'meaning' => 'bukan kesukaan saya', 'example' => 'Fast food is not my cup of tea.'],
                    ['phrase' => 'eat like a horse', 'meaning' => 'makan sangat banyak', 'example' => 'I eat like a horse after a long workout.'],
                ],
                'collocations' => [
                    ['phrase' => 'balanced diet', 'meaning' => 'pola makan seimbang', 'example' => 'A balanced diet helps me stay productive.'],
                    ['phrase' => 'home-cooked meal', 'meaning' => 'masakan rumahan', 'example' => 'I prefer a home-cooked meal to takeout.'],
                    ['phrase' => 'healthy lifestyle', 'meaning' => 'gaya hidup sehat', 'example' => 'Walking daily supports a healthy lifestyle.'],
                    ['phrase' => 'eating habits', 'meaning' => 'kebiasaan makan', 'example' => 'My eating habits changed after college.'],
                    ['phrase' => 'daily routine', 'meaning' => 'rutinitas harian', 'example' => 'Exercise is part of my daily routine.'],
                    ['phrase' => 'quality sleep', 'meaning' => 'tidur berkualitas', 'example' => 'Quality sleep improves concentration.'],
                    ['phrase' => 'stress management', 'meaning' => 'pengelolaan stres', 'example' => 'Meditation helps with stress management.'],
                    ['phrase' => 'physical activity', 'meaning' => 'aktivitas fisik', 'example' => 'Physical activity is essential for good health.'],
                    ['phrase' => 'leisure time', 'meaning' => 'waktu luang', 'example' => 'I read books in my leisure time.'],
                    ['phrase' => 'personal preference', 'meaning' => 'preferensi pribadi', 'example' => 'Food choices are often a personal preference.'],
                ],
            ],
            'technology_media' => [
                'idioms' => [
                    ['phrase' => 'at your fingertips', 'meaning' => 'mudah diakses kapan saja', 'example' => 'Information is at your fingertips on smartphones.'],
                    ['phrase' => 'behind the times', 'meaning' => 'ketinggalan zaman', 'example' => 'People without digital skills can feel behind the times.'],
                    ['phrase' => 'plugged in', 'meaning' => 'selalu terhubung secara digital', 'example' => 'Teenagers are always plugged in these days.'],
                    ['phrase' => 'break the internet', 'meaning' => 'menjadi viral luar biasa', 'example' => 'That music video almost broke the internet.'],
                    ['phrase' => 'on the same wavelength', 'meaning' => 'sejalan dalam pemikiran', 'example' => 'My teammates are on the same wavelength online.'],
                    ['phrase' => 'go viral', 'meaning' => 'menyebar cepat di internet', 'example' => 'Her short film went viral last week.'],
                    ['phrase' => 'speak volumes', 'meaning' => 'menunjukkan banyak hal tanpa kata-kata', 'example' => 'A good photo can speak volumes.'],
                    ['phrase' => 'light-bulb moment', 'meaning' => 'momen tiba-tiba paham ide', 'example' => 'I had a light-bulb moment while editing a video.'],
                    ['phrase' => 'keep up with', 'meaning' => 'mengikuti perkembangan', 'example' => 'It is hard to keep up with new apps.'],
                    ['phrase' => 'double-edged sword', 'meaning' => 'memiliki sisi positif dan negatif', 'example' => 'Social media is a double-edged sword.'],
                ],
                'collocations' => [
                    ['phrase' => 'digital skills', 'meaning' => 'keterampilan digital', 'example' => 'Students need strong digital skills today.'],
                    ['phrase' => 'screen time', 'meaning' => 'durasi penggunaan layar', 'example' => 'I try to limit my screen time at night.'],
                    ['phrase' => 'social media platform', 'meaning' => 'platform media sosial', 'example' => 'Each social media platform has a different audience.'],
                    ['phrase' => 'online content', 'meaning' => 'konten daring', 'example' => 'I watch educational online content every day.'],
                    ['phrase' => 'mobile device', 'meaning' => 'perangkat seluler', 'example' => 'A mobile device helps me study anywhere.'],
                    ['phrase' => 'internet connection', 'meaning' => 'koneksi internet', 'example' => 'A stable internet connection is essential for meetings.'],
                    ['phrase' => 'data privacy', 'meaning' => 'privasi data', 'example' => 'Many users are concerned about data privacy.'],
                    ['phrase' => 'creative process', 'meaning' => 'proses kreatif', 'example' => 'Music production is part of my creative process.'],
                    ['phrase' => 'visual storytelling', 'meaning' => 'penceritaan visual', 'example' => 'Photography improves visual storytelling skills.'],
                    ['phrase' => 'user experience', 'meaning' => 'pengalaman pengguna', 'example' => 'Simple design improves user experience.'],
                ],
            ],
            'travel_transport' => [
                'idioms' => [
                    ['phrase' => 'hit the road', 'meaning' => 'memulai perjalanan', 'example' => 'We hit the road early in the morning.'],
                    ['phrase' => 'get away from it all', 'meaning' => 'menjauh dari rutinitas', 'example' => 'I travel to get away from it all.'],
                    ['phrase' => 'off the beaten track', 'meaning' => 'tempat wisata yang jarang dikunjungi', 'example' => 'I like destinations off the beaten track.'],
                    ['phrase' => 'in the fast lane', 'meaning' => 'hidup serba cepat', 'example' => 'City life puts people in the fast lane.'],
                    ['phrase' => 'stuck in traffic', 'meaning' => 'terjebak macet', 'example' => 'I was stuck in traffic for an hour.'],
                    ['phrase' => 'from scratch', 'meaning' => 'dari awal', 'example' => 'I planned my trip from scratch.'],
                    ['phrase' => 'a change of scenery', 'meaning' => 'suasana baru', 'example' => 'A short trip gives me a change of scenery.'],
                    ['phrase' => 'go the distance', 'meaning' => 'menempuh perjalanan jauh/bertahan lama', 'example' => 'Our old car can still go the distance.'],
                    ['phrase' => 'on the move', 'meaning' => 'selalu berpindah tempat', 'example' => 'I am always on the move during holidays.'],
                    ['phrase' => 'smooth sailing', 'meaning' => 'berjalan lancar tanpa masalah', 'example' => 'The train ride was smooth sailing.'],
                ],
                'collocations' => [
                    ['phrase' => 'public transportation', 'meaning' => 'transportasi umum', 'example' => 'Public transportation is affordable in my city.'],
                    ['phrase' => 'traffic congestion', 'meaning' => 'kemacetan lalu lintas', 'example' => 'Traffic congestion is worst at rush hour.'],
                    ['phrase' => 'rush hour', 'meaning' => 'jam sibuk', 'example' => 'I avoid traveling during rush hour.'],
                    ['phrase' => 'travel itinerary', 'meaning' => 'rencana perjalanan', 'example' => 'I prepared a travel itinerary for the weekend.'],
                    ['phrase' => 'weekend getaway', 'meaning' => 'liburan singkat akhir pekan', 'example' => 'A weekend getaway helps me recharge.'],
                    ['phrase' => 'tourist destination', 'meaning' => 'destinasi wisata', 'example' => 'Bali is a famous tourist destination.'],
                    ['phrase' => 'commuting time', 'meaning' => 'waktu perjalanan pergi-pulang', 'example' => 'My commuting time is about 40 minutes.'],
                    ['phrase' => 'road safety', 'meaning' => 'keselamatan jalan', 'example' => 'Road safety should be taught at school.'],
                    ['phrase' => 'long-distance trip', 'meaning' => 'perjalanan jarak jauh', 'example' => 'I enjoy long-distance trips by train.'],
                    ['phrase' => 'transport network', 'meaning' => 'jaringan transportasi', 'example' => 'A good transport network reduces traffic.'],
                ],
            ],
            'shopping_money' => [
                'idioms' => [
                    ['phrase' => 'cost an arm and a leg', 'meaning' => 'sangat mahal', 'example' => 'Designer clothes can cost an arm and a leg.'],
                    ['phrase' => 'save for a rainy day', 'meaning' => 'menabung untuk kebutuhan mendadak', 'example' => 'I save for a rainy day every month.'],
                    ['phrase' => 'tighten your belt', 'meaning' => 'menghemat pengeluaran', 'example' => 'We had to tighten our belt this year.'],
                    ['phrase' => 'shop around', 'meaning' => 'membandingkan harga sebelum membeli', 'example' => 'I always shop around before buying electronics.'],
                    ['phrase' => 'worth every penny', 'meaning' => 'sangat layak dengan harganya', 'example' => 'This laptop is worth every penny.'],
                    ['phrase' => 'money talks', 'meaning' => 'uang punya pengaruh besar', 'example' => 'In business, money talks.'],
                    ['phrase' => 'on a shoestring budget', 'meaning' => 'dengan anggaran sangat terbatas', 'example' => 'I traveled on a shoestring budget.'],
                    ['phrase' => 'pay through the nose', 'meaning' => 'membayar terlalu mahal', 'example' => 'Tourists often pay through the nose near landmarks.'],
                    ['phrase' => 'big spender', 'meaning' => 'orang yang boros', 'example' => 'I am not a big spender when shopping online.'],
                    ['phrase' => 'nest egg', 'meaning' => 'tabungan masa depan', 'example' => 'I am building a nest egg for emergencies.'],
                ],
                'collocations' => [
                    ['phrase' => 'online shopping', 'meaning' => 'belanja online', 'example' => 'Online shopping saves a lot of time.'],
                    ['phrase' => 'shopping habits', 'meaning' => 'kebiasaan berbelanja', 'example' => 'My shopping habits changed after I started working.'],
                    ['phrase' => 'budget planning', 'meaning' => 'perencanaan anggaran', 'example' => 'Budget planning helps me avoid impulse buying.'],
                    ['phrase' => 'discount offer', 'meaning' => 'penawaran diskon', 'example' => 'I usually wait for a discount offer.'],
                    ['phrase' => 'fashion trend', 'meaning' => 'tren fesyen', 'example' => 'I follow fashion trends on social media.'],
                    ['phrase' => 'gift ideas', 'meaning' => 'ide hadiah', 'example' => 'I search online for gift ideas before birthdays.'],
                    ['phrase' => 'personal budget', 'meaning' => 'anggaran pribadi', 'example' => 'I track my personal budget every week.'],
                    ['phrase' => 'monthly expenses', 'meaning' => 'pengeluaran bulanan', 'example' => 'Rent is my biggest monthly expense.'],
                    ['phrase' => 'price comparison', 'meaning' => 'perbandingan harga', 'example' => 'Price comparison helps me buy smarter.'],
                    ['phrase' => 'financial goals', 'meaning' => 'tujuan keuangan', 'example' => 'Saving for travel is one of my financial goals.'],
                ],
            ],
            'default' => [
                'idioms' => [
                    ['phrase' => 'once in a blue moon', 'meaning' => 'sangat jarang', 'example' => 'I only skip my routine once in a blue moon.'],
                    ['phrase' => 'break the ice', 'meaning' => 'mencairkan suasana', 'example' => 'Humor helps break the ice in conversations.'],
                    ['phrase' => 'hit the nail on the head', 'meaning' => 'tepat sasaran', 'example' => 'Your answer hit the nail on the head.'],
                    ['phrase' => 'a blessing in disguise', 'meaning' => 'hal buruk yang ternyata membawa kebaikan', 'example' => 'That delay was a blessing in disguise.'],
                    ['phrase' => 'keep an open mind', 'meaning' => 'berpikiran terbuka', 'example' => 'Try to keep an open mind when discussing ideas.'],
                    ['phrase' => 'on the right track', 'meaning' => 'di jalur yang benar', 'example' => 'Your preparation is on the right track.'],
                    ['phrase' => 'step out of your comfort zone', 'meaning' => 'mencoba hal di luar kebiasaan', 'example' => 'Speaking practice helps you step out of your comfort zone.'],
                    ['phrase' => 'take something seriously', 'meaning' => 'menanggapi sesuatu dengan serius', 'example' => 'I take my language goals seriously.'],
                    ['phrase' => 'keep up the good work', 'meaning' => 'teruskan kerja bagus', 'example' => 'Keep up the good work in your daily practice.'],
                    ['phrase' => 'practice makes perfect', 'meaning' => 'latihan membuat sempurna', 'example' => 'Practice makes perfect in speaking tests.'],
                ],
                'collocations' => [
                    ['phrase' => 'personal experience', 'meaning' => 'pengalaman pribadi', 'example' => 'I usually answer with personal experience.'],
                    ['phrase' => 'clear opinion', 'meaning' => 'pendapat yang jelas', 'example' => 'Give a clear opinion in your response.'],
                    ['phrase' => 'real-life example', 'meaning' => 'contoh kehidupan nyata', 'example' => 'A real-life example makes answers stronger.'],
                    ['phrase' => 'daily activity', 'meaning' => 'aktivitas sehari-hari', 'example' => 'This is part of my daily activity.'],
                    ['phrase' => 'future plan', 'meaning' => 'rencana masa depan', 'example' => 'I mentioned my future plan in the answer.'],
                    ['phrase' => 'strong motivation', 'meaning' => 'motivasi kuat', 'example' => 'Strong motivation helps me keep learning.'],
                    ['phrase' => 'common topic', 'meaning' => 'topik umum', 'example' => 'Family is a common topic in IELTS Part 1.'],
                    ['phrase' => 'natural response', 'meaning' => 'respons yang alami', 'example' => 'Try to give a natural response.'],
                    ['phrase' => 'short answer', 'meaning' => 'jawaban singkat', 'example' => 'Part 1 usually requires a short answer.'],
                    ['phrase' => 'speaking confidence', 'meaning' => 'kepercayaan diri berbicara', 'example' => 'Regular practice builds speaking confidence.'],
                ],
            ],
        ];

        $topics = collect($topicTitles)->values()->map(function ($title, $index) use ($colors, $icon, $lexicalBanks) {
            $normalized = strtolower($title);

            if (str_contains($normalized, 'work') || str_contains($normalized, 'study') || str_contains($normalized, 'school') || str_contains($normalized, 'university') || str_contains($normalized, 'job') || str_contains($normalized, 'leadership') || str_contains($normalized, 'teamwork') || str_contains($normalized, 'communication')) {
                $bank = $lexicalBanks['education_work'];
            } elseif (str_contains($normalized, 'home') || str_contains($normalized, 'hometown') || str_contains($normalized, 'neighborhood') || str_contains($normalized, 'family') || str_contains($normalized, 'park') || str_contains($normalized, 'childhood') || str_contains($normalized, 'festival') || str_contains($normalized, 'history') || str_contains($normalized, 'culture') || str_contains($normalized, 'pet')) {
                $bank = $lexicalBanks['home_city'];
            } elseif (str_contains($normalized, 'food') || str_contains($normalized, 'cook') || str_contains($normalized, 'restaurant') || str_contains($normalized, 'sport') || str_contains($normalized, 'exercise') || str_contains($normalized, 'routine') || str_contains($normalized, 'sleep') || str_contains($normalized, 'health') || str_contains($normalized, 'stress') || str_contains($normalized, 'morning') || str_contains($normalized, 'evening') || str_contains($normalized, 'outdoor')) {
                $bank = $lexicalBanks['food_lifestyle'];
            } elseif (str_contains($normalized, 'technology') || str_contains($normalized, 'phone') || str_contains($normalized, 'social media') || str_contains($normalized, 'photography') || str_contains($normalized, 'art') || str_contains($normalized, 'music') || str_contains($normalized, 'movie') || str_contains($normalized, 'reading') || str_contains($normalized, 'language') || str_contains($normalized, 'science')) {
                $bank = $lexicalBanks['technology_media'];
            } elseif (str_contains($normalized, 'travel') || str_contains($normalized, 'holiday') || str_contains($normalized, 'weekend') || str_contains($normalized, 'transportation') || str_contains($normalized, 'traffic')) {
                $bank = $lexicalBanks['travel_transport'];
            } elseif (str_contains($normalized, 'shopping') || str_contains($normalized, 'fashion') || str_contains($normalized, 'money') || str_contains($normalized, 'gift') || str_contains($normalized, 'time management')) {
                $bank = $lexicalBanks['shopping_money'];
            } else {
                $bank = $lexicalBanks['default'];
            }

            return [
                'slug' => 'part1-topic-' . ($index + 1),
                'title' => $title,
                'icon' => $icon,
                'color' => $colors[$index % count($colors)],
                'part' => 1,
                'questions' => [
                    'What do you like most about ' . strtolower($title) . '?',
                    'How often do you think about ' . strtolower($title) . '?',
                    'Was ' . strtolower($title) . ' important in your childhood?',
                    'Do people in your country value ' . strtolower($title) . '?',
                    'Do you think your opinion about ' . strtolower($title) . ' will change in the future?'
                ],
                'idioms' => $bank['idioms'],
                'collocations' => $bank['collocations'],
            ];
        })->toArray();


        if ($includeLessons) {
            // Inject lesson topics from data class for mixed listing pages.
            foreach ($this->lessonsData->getLessons() as $lesson) {
                $topics[] = $lesson;
            }
        }

        // Sort all by slug numerically (1, 2, ..., 10)
        usort($topics, function($a, $b) {
            $numA = (int) preg_replace('/[^0-9]/', '', $a['slug']);
            $numB = (int) preg_replace('/[^0-9]/', '', $b['slug']);
            return $numA <=> $numB;
        });

        return $topics;
    }
}
