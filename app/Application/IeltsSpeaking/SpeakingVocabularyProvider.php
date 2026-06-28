<?php

namespace App\Application\IeltsSpeaking;

class SpeakingVocabularyProvider
{

    public function getAdvancedVocabForTopic(string $slug): array
    {
        $commonVocab = [
            'good' => ['beneficial', 'Gunakan "beneficial" untuk dampak positif.'],
            'bad' => ['detrimental', 'Gunakan "detrimental" untuk dampak negatif.'],
            'important' => ['crucial', 'Artinya sangat penting.'],
            'think' => ['believe', 'Lebih formal untuk menyatakan pendapat.'],
            'like' => ['appreciate', 'Menunjukkan penghargaan.'],
            'very' => ['extremely', 'Penguat yang lebih canggih.'],
            'happy' => ['elated', 'Sangat bahagia.'],
            'sad' => ['devastated', 'Sangat sedih.']
        ];

        $topicVocab = [
            'work' => [
                'job' => ['profession', 'Karir yang butuh keahlian.'],
                'boss' => ['supervisor', 'Istilah lebih formal.'],
                'stressful' => ['demanding', 'Membutuhkan usaha besar.'],
                'busy' => ['hectic', 'Sangat sibuk.'],
                'worker' => ['employee', 'Istilah standar.'],
                'get' => ['acquire', 'Mendapatkan (skill/pengalaman).']
            ],
            'study' => [
                'teacher' => ['educator', 'Pendidik.'],
                'learn' => ['acquire knowledge', 'Mendapatkan ilmu.'],
                'test' => ['examination', 'Ujian formal.'],
                'hard' => ['challenging', 'Menantang.'],
                'school' => ['institution', 'Lembaga pendidikan.']
            ],
            'hometown' => [
                'city' => ['metropolis', 'Kota besar.'],
                'quiet' => ['tranquil', 'Tenang dan damai.'],
                'crowded' => ['congested', 'Padat (lalu lintas/orang).'],
                'live' => ['reside', 'Bertempat tinggal (formal).'],
                'building' => ['infrastructure', 'Bangunan/Fasilitas.']
            ],
            'technology' => [
                'new' => ['cutting-edge', 'Terbaru/Canggih.'],
                'change' => ['revolutionize', 'Mengubah total.'],
                'use' => ['utilize', 'Menggunakan (alat/teknologi).'],
                'fast' => ['rapid', 'Sangat cepat.'],
                'computer' => ['device', 'Perangkat elektronik.']
            ],
            'environment' => [
                'dirty' => ['polluted', 'Tercemar.'],
                'problem' => ['crisis', 'Masalah besar/krisis.'],
                'protect' => ['conserve', 'Melestarikan.'],
                'trash' => ['waste', 'Limbah.'],
                'animals' => ['wildlife', 'Satwa liar.']
            ],
            'travel-holidays' => [
                'trip' => ['excursion', 'Perjalanan singkat/wisata.'],
                'visit' => ['explore', 'Menjelajahi.'],
                'places' => ['destinations', 'Tujuan wisata.'],
                'beautiful' => ['breathtaking', 'Sangat indah.'],
                'famous' => ['renowned', 'Terkenal.'],
                'tourist' => ['visitor', 'Pengunjung.']
            ],
            'music' => [
                'song' => ['composition', 'Komposisi musik.'],
                'listen' => ['appreciate', 'Menikmati/Menghargai.'],
                'singer' => ['vocalist', 'Penyanyi.'],
                'loud' => ['deafening', 'Sangat keras.'],
                'band' => ['ensemble', 'Grup musik.']
            ],
            'movies' => [
                'movie' => ['film', 'Istilah yang lebih umum/formal.'],
                'story' => ['narrative', 'Alur cerita.'],
                'actor' => ['performer', 'Pemeran.'],
                'watch' => ['observe', 'Mengamati (konteks tertentu).'],
                'funny' => ['hilarious', 'Sangat lucu.']
            ],
            'food-cooking' => [
                'eat' => ['consume', 'Mengkonsumsi.'],
                'tasty' => ['delicious', 'Lezat.'],
                'cook' => ['prepare', 'Menyiapkan makanan.'],
                'drink' => ['beverage', 'Minuman (kata benda).'],
                'hungry' => ['famished', 'Sangat lapar.']
            ],
            'sport' => [
                'game' => ['match', 'Pertandingan.'],
                'player' => ['athlete', 'Atlet.'],
                'win' => ['triumph', 'Kemenangan besar.'],
                'run' => ['sprint', 'Lari cepat.'],
                'practice' => ['train', 'Berlatih.']
            ],
            'shopping' => [
                'buy' => ['purchase', 'Membeli (formal).'],
                'expensive' => ['costly', 'Mahal.'],
                'cheap' => ['affordable', 'Terjangkau.'],
                'shop' => ['boutique', 'Toko kecil/khusus.'],
                'pay' => ['transact', 'Melakukan transaksi.']
            ],
            'clothes-fashion' => [
                'wear' => ['don', 'Mengenakan (jarang, tapi formal).'],
                'clothes' => ['garments', 'Pakaian.'],
                'fashionable' => ['trendy', 'Mengikuti tren.'],
                'old' => ['vintage', 'Kuno/Klasik.'],
                'style' => ['aesthetic', 'Estetika/Gaya.']
            ],
            'animals' => [
                'pet' => ['companion', 'Hewan peliharaan/Teman.'],
                'wild' => ['untamed', 'Liar/Belum jinak.'],
                'save' => ['rescue', 'Menyelamatkan.'],
                'scary' => ['intimidating', 'Menakutkan.']
            ],
            'book' => [
                'book' => ['literary work', 'Karya sastra.'],
                'read' => ['peruse', 'Membaca dengan teliti.'],
                'story' => ['narrative', 'Narasi/Cerita.'],
                'character' => ['protagonist', 'Tokoh utama/Karakter.'],
                'write' => ['author', 'Menulis (buku/karya).'],
                'interesting' => ['captivating', 'Sangat menarik.'],
                'funny' => ['witty', 'Cerdas dan lucu.'],
                'sad' => ['poignant', 'Menyedihkan/Mengharukan.']
            ]
        ];

        $selectedVocab = [];
        foreach ($topicVocab as $key => $vocab) {
            if (str_contains($slug, $key)) {
                $selectedVocab = $vocab;
                break;
            }
        }

        return array_merge($commonVocab, $selectedVocab);
    }

    public function getAdvancedAdverbsForTopic($slug)
    {
        $commonAdverbs = [
            ['phrase' => 'significantly', 'level' => 'B2', 'meaning' => 'in a sufficiently great or important way', 'meaning_id' => 'secara signifikan', 'example' => 'The situation has improved significantly.'],
            ['phrase' => 'particularly', 'level' => 'B2', 'meaning' => 'so as to give special emphasis to a point', 'meaning_id' => 'terkhusus / terutama', 'example' => 'I am particularly interested in this topic.'],
            ['phrase' => 'relatively', 'level' => 'B2', 'meaning' => 'in relation, comparison, or proportion to something else', 'meaning_id' => 'relatif', 'example' => 'It is a relatively easy task.'],
            ['phrase' => 'consistently', 'level' => 'C1', 'meaning' => 'in every case or on every occasion', 'meaning_id' => 'secara konsisten', 'example' => 'She has consistently achieved high marks.'],
            ['phrase' => 'undoubtedly', 'level' => 'C1', 'meaning' => 'without doubt; certainly', 'meaning_id' => 'tanpa keraguan / pasti', 'example' => 'He is undoubtedly the best candidate.']
        ];

        $adverbsMap = [
            'hometown' => [
                ['phrase' => 'drastically', 'level' => 'C1', 'meaning' => 'in a way that is likely to have a strong or far-reaching effect', 'meaning_id' => 'secara drastis', 'example' => 'My hometown has changed drastically.'],
                ['phrase' => 'originally', 'level' => 'B2', 'meaning' => 'from or in the beginning; at first', 'meaning_id' => 'awalnya / aslinya', 'example' => 'I am originally from a small village.'],
                ['phrase' => 'currently', 'level' => 'B1', 'meaning' => 'at the present time', 'meaning_id' => 'saat ini', 'example' => 'I currently reside in the city center.'],
                ['phrase' => 'conveniently', 'level' => 'B2', 'meaning' => 'in a way that fits well with particular needs', 'meaning_id' => 'secara strategis / nyaman', 'example' => 'It is conveniently located near the station.'],
                ['phrase' => 'rarely', 'level' => 'A2', 'meaning' => 'not often; seldom', 'meaning_id' => 'jarang', 'example' => 'Tourists rarely visit this area.'],
                ['phrase' => 'typically', 'level' => 'B2', 'meaning' => 'in most cases; usually', 'meaning_id' => 'biasanya', 'example' => 'It is typically quiet at night.'],
                ['phrase' => 'eventually', 'level' => 'B2', 'meaning' => 'in the end, especially after a long delay', 'meaning_id' => 'pada akhirnya', 'example' => 'I hope to eventually move back.'],
                ['phrase' => 'significantly', 'level' => 'B2', 'meaning' => 'in a sufficiently great or important way', 'meaning_id' => 'secara signifikan', 'example' => 'The infrastructure has improved significantly.'],
                ['phrase' => 'particularly', 'level' => 'B2', 'meaning' => 'so as to give special emphasis to a point', 'meaning_id' => 'terkhusus / terutama', 'example' => 'I am particularly fond of the parks.'],
                ['phrase' => 'relatively', 'level' => 'B2', 'meaning' => 'in relation, comparison, or proportion to something else', 'meaning_id' => 'relatif', 'example' => 'It is a relatively small town.']
            ],
            'accommodation' => [
                ['phrase' => 'conveniently', 'level' => 'B2', 'meaning' => 'fitting in well with a person\'s needs', 'meaning_id' => 'strategis / nyaman', 'example' => 'The hotel is conveniently located.'],
                ['phrase' => 'sparingly', 'level' => 'B2', 'meaning' => 'in a restricted or infrequent manner', 'meaning_id' => 'secara hemat / jarang', 'example' => 'Use the space sparingly.'],
                ['phrase' => 'temporarily', 'level' => 'B2', 'meaning' => 'for a limited period of time', 'meaning_id' => 'sementara', 'example' => 'I am staying here temporarily.'],
                ['phrase' => 'permanently', 'level' => 'B2', 'meaning' => 'in a way that lasts indefinitely', 'meaning_id' => 'secara permanen', 'example' => 'I moved here permanently.'],
                ['phrase' => 'comfortably', 'level' => 'B1', 'meaning' => 'in a physically relaxed way', 'meaning_id' => 'dengan nyaman', 'example' => 'The room accommodates four people comfortably.'],
                ['phrase' => 'recently', 'level' => 'A2', 'meaning' => 'at a recent time', 'meaning_id' => 'baru-baru ini', 'example' => 'The house was renovated recently.'],
                ['phrase' => 'centrally', 'level' => 'B2', 'meaning' => 'in the middle of an area', 'meaning_id' => 'di pusat', 'example' => 'We live centrally in London.'],
                ['phrase' => 'typically', 'level' => 'B2', 'meaning' => 'usually', 'meaning_id' => 'biasanya', 'example' => 'Rent is typically paid monthly.'],
                ['phrase' => 'currently', 'level' => 'B1', 'meaning' => 'at the present time', 'meaning_id' => 'saat ini', 'example' => 'I am currently renting.'],
                ['phrase' => 'privately', 'level' => 'B2', 'meaning' => 'in a private manner', 'meaning_id' => 'secara pribadi', 'example' => 'The property is owned privately.']
            ],
            'work' => [
                ['phrase' => 'efficiently', 'level' => 'B2', 'meaning' => 'in a way that achieves maximum productivity', 'meaning_id' => 'secara efisien', 'example' => 'We need to work more efficiently.'],
                ['phrase' => 'professionally', 'level' => 'B2', 'meaning' => 'in a way that shows competence', 'meaning_id' => 'secara profesional', 'example' => 'She handled the client professionally.'],
                ['phrase' => 'diligently', 'level' => 'C1', 'meaning' => 'in a way that shows care and conscientiousness', 'meaning_id' => 'dengan rajin', 'example' => 'He worked diligently on the report.'],
                ['phrase' => 'tirelessly', 'level' => 'C1', 'meaning' => 'with great effort or energy', 'meaning_id' => 'tanpa lelah', 'example' => 'They worked tirelessly to finish the project.'],
                ['phrase' => 'collaboratively', 'level' => 'C1', 'meaning' => 'jointly with others', 'meaning_id' => 'secara kolaboratif', 'example' => 'We work collaboratively on most tasks.'],
                ['phrase' => 'independently', 'level' => 'B2', 'meaning' => 'without outside help', 'meaning_id' => 'secara mandiri', 'example' => 'I am required to work independently.'],
                ['phrase' => 'productively', 'level' => 'B2', 'meaning' => 'in a way that produces positive results', 'meaning_id' => 'secara produktif', 'example' => 'I spent the day productively.'],
                ['phrase' => 'systematically', 'level' => 'C1', 'meaning' => 'according to a fixed plan or system', 'meaning_id' => 'secara sistematis', 'example' => 'We approached the problem systematically.'],
                ['phrase' => 'remotely', 'level' => 'B2', 'meaning' => 'from a distance (e.g. working from home)', 'meaning_id' => 'jarak jauh (remote)', 'example' => 'Many employees now work remotely.'],
                ['phrase' => 'voluntarily', 'level' => 'B2', 'meaning' => 'of one\'s own free will', 'meaning_id' => 'secara sukarela', 'example' => 'She took on the extra tasks voluntarily.']
            ],
            'study' => [
                ['phrase' => 'thoroughly', 'level' => 'B2', 'meaning' => 'very much; completely', 'meaning_id' => 'secara menyeluruh', 'example' => 'I researched the topic thoroughly.'],
                ['phrase' => 'academically', 'level' => 'B2', 'meaning' => 'in regard to education', 'meaning_id' => 'secara akademis', 'example' => 'He is academically gifted.'],
                ['phrase' => 'intensely', 'level' => 'B2', 'meaning' => 'with extreme force or strength', 'meaning_id' => 'dengan intens', 'example' => 'We studied intensely for the exam.'],
                ['phrase' => 'studiously', 'level' => 'C2', 'meaning' => 'with concentration and care', 'meaning_id' => 'dengan sungguh-sungguh', 'example' => 'He ignored the noise and read studiously.'],
                ['phrase' => 'intellectually', 'level' => 'B2', 'meaning' => 'relating to the intellect', 'meaning_id' => 'secara intelektual', 'example' => 'The course is intellectually stimulating.'],
                ['phrase' => 'continuously', 'level' => 'B2', 'meaning' => 'without interruption', 'meaning_id' => 'terus menerus', 'example' => 'You should assess your progress continuously.'],
                ['phrase' => 'formally', 'level' => 'B2', 'meaning' => 'in accordance with rules or convention', 'meaning_id' => 'secara formal', 'example' => 'She was formally educated in Europe.'],
                ['phrase' => 'primarily', 'level' => 'B2', 'meaning' => 'for the most part; mainly', 'meaning_id' => 'terutama', 'example' => 'The course is primarily for beginners.'],
                ['phrase' => 'critically', 'level' => 'B2', 'meaning' => 'in a way that expresses analysis', 'meaning_id' => 'secara kritis', 'example' => 'Students are encouraged to think critically.'],
                ['phrase' => 'eagerly', 'level' => 'B2', 'meaning' => 'wth keen interest', 'meaning_id' => 'dengan antusias', 'example' => 'He eagerly answered the questions.']
            ],
            'hobbies-interests' => [
                ['phrase' => 'passionately', 'level' => 'B2', 'meaning' => 'in a way that shows strong feelings', 'meaning_id' => 'dengan penuh semangat', 'example' => 'He spoke passionately about his hobby.'],
                ['phrase' => 'regularly', 'level' => 'B1', 'meaning' => 'at uniform intervals', 'meaning_id' => 'secara teratur', 'example' => 'I play tennis regularly.'],
                ['phrase' => 'creatively', 'level' => 'B2', 'meaning' => 'in an original or imaginative way', 'meaning_id' => 'secara kreatif', 'example' => 'She expresses herself creatively through painting.'],
                ['phrase' => 'actively', 'level' => 'B2', 'meaning' => 'in a deliberate and positive way', 'meaning_id' => 'secara aktif', 'example' => 'I am actively involved in the club.'],
                ['phrase' => 'enthusiastically', 'level' => 'B2', 'meaning' => 'with intense and eager enjoyment', 'meaning_id' => 'dengan antusias', 'example' => 'They participated enthusiastically.'],
                ['phrase' => 'skillfully', 'level' => 'B2', 'meaning' => 'with skill', 'meaning_id' => 'dengan mahir', 'example' => 'He played the guitar skillfully.'],
                ['phrase' => 'leisurely', 'level' => 'C1', 'meaning' => 'without hurry', 'meaning_id' => 'dengan santai', 'example' => 'We strolled leisurely through the park.'],
                ['phrase' => 'avidly', 'level' => 'C1', 'meaning' => 'with great interest', 'meaning_id' => 'dengan tekun / penuh minat', 'example' => 'She reads avidly about history.'],
                ['phrase' => 'socially', 'level' => 'B2', 'meaning' => 'in the company of others', 'meaning_id' => 'secara sosial', 'example' => 'Video games can be played socially.'],
                ['phrase' => 'obsessively', 'level' => 'C1', 'meaning' => 'to a very great or excessive degree', 'meaning_id' => 'secara obsesif', 'example' => 'He follows football obsessively.']
            ],
            'travel-holidays' => [
                ['phrase' => 'abroad', 'level' => 'B1', 'meaning' => 'in or to a foreign country', 'meaning_id' => 'ke luar negeri', 'example' => 'I love traveling abroad.'],
                ['phrase' => 'annually', 'level' => 'B2', 'meaning' => 'once every year', 'meaning_id' => 'setiap tahun', 'example' => 'We go on holiday annually.'],
                ['phrase' => 'spontaneously', 'level' => 'C1', 'meaning' => 'impulsively', 'meaning_id' => 'secara spontan', 'example' => 'We decided to leave spontaneously.'],
                ['phrase' => 'locally', 'level' => 'B1', 'meaning' => 'in the area of one\'s home', 'meaning_id' => 'di dalam negeri / lokal', 'example' => 'We prefer to travel locally.'],
                ['phrase' => 'globally', 'level' => 'B2', 'meaning' => 'throughout the world', 'meaning_id' => 'secara global', 'example' => 'The trend has spread globally.'],
                ['phrase' => 'comfortably', 'level' => 'B1', 'meaning' => 'in a physically relaxed way', 'meaning_id' => 'dengan nyaman', 'example' => 'We traveled comfortably by train.'],
                ['phrase' => 'luxuriously', 'level' => 'C1', 'meaning' => 'in a rich and comfortable way', 'meaning_id' => 'dengan mewah', 'example' => 'They stayed luxuriously at a resort.'],
                ['phrase' => 'economically', 'level' => 'C1', 'meaning' => 'in a way that saves money', 'meaning_id' => 'secara hemat', 'example' => 'Backpacking is a way to travel economically.'],
                ['phrase' => 'adventurously', 'level' => 'C1', 'meaning' => 'in a daring way', 'meaning_id' => 'secara petualang', 'example' => 'She eats adventurously when traveling.'],
                ['phrase' => 'frequently', 'level' => 'B1', 'meaning' => 'often', 'meaning_id' => 'sering', 'example' => 'I travel frequently for work.']
            ],
            'music' => [
                ['phrase' => 'melodically', 'level' => 'C2', 'meaning' => 'in terms of melody', 'meaning_id' => 'secara melodi', 'example' => 'The song is melodically complex.'],
                ['phrase' => 'rhythmically', 'level' => 'C2', 'meaning' => 'relating to rhythm', 'meaning_id' => 'secara ritmis', 'example' => 'It is rhythmically interesting.'],
                ['phrase' => 'loudly', 'level' => 'A2', 'meaning' => 'with a lot of noise', 'meaning_id' => 'dengan keras', 'example' => 'Don\'t play music too loudly.'],
                ['phrase' => 'softly', 'level' => 'A2', 'meaning' => 'with a quiet voice or volume', 'meaning_id' => 'dengan lembut', 'example' => 'She sang softly.'],
                ['phrase' => 'harmoniously', 'level' => 'C1', 'meaning' => 'in a tuneul way', 'meaning_id' => 'secara harmonis', 'example' => 'Their voices blended harmoniously.'],
                ['phrase' => 'instrumentally', 'level' => 'C1', 'meaning' => 'by means of instruments', 'meaning_id' => 'secara instrumental', 'example' => 'The track is instrumentally rich.'],
                ['phrase' => 'vocally', 'level' => 'C1', 'meaning' => 'relating to the human voice', 'meaning_id' => 'secara vokal', 'example' => 'He is vocally talented.'],
                ['phrase' => 'emotionally', 'level' => 'B2', 'meaning' => 'with deep feeling', 'meaning_id' => 'secara emosional', 'example' => 'She performed the song emotionally.'],
                ['phrase' => 'acoustically', 'level' => 'C1', 'meaning' => 'without electrical amplification', 'meaning_id' => 'secara akustik', 'example' => 'They played the set acoustically.'],
                ['phrase' => 'live', 'level' => 'B1', 'meaning' => 'at the actual time of occurrence', 'meaning_id' => 'secara langsung (live)', 'example' => 'I prefer hearing music live.']
            ],
            'movies' => [
                ['phrase' => 'visually', 'level' => 'B2', 'meaning' => 'relating to seeing', 'meaning_id' => 'secara visual', 'example' => 'The film was visually stunning.'],
                ['phrase' => 'dramatically', 'level' => 'B2', 'meaning' => 'in an exciting or impressive way', 'meaning_id' => 'secara dramatis', 'example' => 'The plot changed dramatically.'],
                ['phrase' => 'cinematically', 'level' => 'C2', 'meaning' => 'regarding motion pictures', 'meaning_id' => 'secara sinematis', 'example' => 'It was cinematically beautiful.'],
                ['phrase' => 'realistically', 'level' => 'B2', 'meaning' => 'in a way that seems true to life', 'meaning_id' => 'secara realistis', 'example' => 'The characters were portrayed realistically.'],
                ['phrase' => 'superbly', 'level' => 'C1', 'meaning' => 'very well; excellently', 'meaning_id' => 'dengan luar biasa', 'example' => 'It was superbly acted.'],
                ['phrase' => 'convincingly', 'level' => 'C1', 'meaning' => 'in a way that causes someone to believe', 'meaning_id' => 'secara meyakinkan', 'example' => 'He played the villain convincingly.'],
                ['phrase' => 'hilariously', 'level' => 'B2', 'meaning' => 'extremely amusingly', 'meaning_id' => 'dengan sangat lucu', 'example' => 'The script was hilariously funny.'],
                ['phrase' => 'incredibly', 'level' => 'B2', 'meaning' => 'to a great degree', 'meaning_id' => 'sungguh / sangat', 'example' => 'The ending was incredibly sad.'],
                ['phrase' => 'artificially', 'level' => 'B2', 'meaning' => 'not naturally', 'meaning_id' => 'secara buatan', 'example' => 'The lighting looked artificially bright.'],
                ['phrase' => 'emotionally', 'level' => 'B2', 'meaning' => 'with regards to feelings', 'meaning_id' => 'secara emosional', 'example' => 'I connected emotionally with the hero.']
            ],
            'food-cooking' => [
                ['phrase' => 'freshly', 'level' => 'B1', 'meaning' => 'recently; newly', 'meaning_id' => 'segar / baru saja', 'example' => 'I love the smell of freshly baked bread.'],
                ['phrase' => 'occasionally', 'level' => 'B1', 'meaning' => 'sometimes but not often', 'meaning_id' => 'sesekali', 'example' => 'I cook fish occasionally.'],
                ['phrase' => 'traditionally', 'level' => 'B2', 'meaning' => 'according to tradition', 'meaning_id' => 'secara tradisional', 'example' => 'The dish is traditionally spicy.'],
                ['phrase' => 'hygienically', 'level' => 'C1', 'meaning' => 'in a clean way', 'meaning_id' => 'secara higienis', 'example' => 'Food must be prepared hygienically.'],
                ['phrase' => 'tastefully', 'level' => 'B2', 'meaning' => 'with good taste', 'meaning_id' => 'dengan selera tinggi', 'example' => 'The table was tastefully decorated.'],
                ['phrase' => 'hungrily', 'level' => 'B2', 'meaning' => 'with great hunger', 'meaning_id' => 'dengan lahap', 'example' => 'We ate hungrily after the hike.'],
                ['phrase' => 'moderately', 'level' => 'C1', 'meaning' => 'within reasonable limits', 'meaning_id' => 'secara moderat / sedang', 'example' => 'You should eat sweets moderately.'],
                ['phrase' => 'daily', 'level' => 'A2', 'meaning' => 'every day', 'meaning_id' => 'setiap hari', 'example' => 'I cook dinner daily.'],
                ['phrase' => 'locally', 'level' => 'B2', 'meaning' => 'from the nearby area', 'meaning_id' => 'secara lokal', 'example' => 'We source ingredients locally.'],
                ['phrase' => 'organically', 'level' => 'C1', 'meaning' => 'without artificial chemicals', 'meaning_id' => 'secara organik', 'example' => 'The vegetables were grown organically.']
            ],
            'sport' => [
                ['phrase' => 'physically', 'level' => 'B2', 'meaning' => 'relating to the body', 'meaning_id' => 'secara fisik', 'example' => 'Rugby is physically demanding.'],
                ['phrase' => 'competitively', 'level' => 'B2', 'meaning' => 'in a way that strives to gain an advantage', 'meaning_id' => 'secara kompetitif', 'example' => 'He plays tennis competitively.'],
                ['phrase' => 'mentally', 'level' => 'B2', 'meaning' => 'in the mind', 'meaning_id' => 'secara mental', 'example' => 'You need to be mentally strong.'],
                ['phrase' => 'strategically', 'level' => 'C1', 'meaning' => 'with a long-term plan', 'meaning_id' => 'secara strategis', 'example' => 'They played strategically.'],
                ['phrase' => 'aggressively', 'level' => 'B2', 'meaning' => 'forcefully', 'meaning_id' => 'secara agresif', 'example' => 'The team attacked aggressively.'],
                ['phrase' => 'fairly', 'level' => 'B1', 'meaning' => 'according to the rules', 'meaning_id' => 'secara adil', 'example' => 'It is important to play fairly.'],
                ['phrase' => 'professionally', 'level' => 'B2', 'meaning' => 'as a paid job', 'meaning_id' => 'secara profesional', 'example' => 'She engages in sports professionally.'],
                ['phrase' => 'regularly', 'level' => 'B1', 'meaning' => 'often', 'meaning_id' => 'secara rutin', 'example' => 'I exercise regularly.'],
                ['phrase' => 'naturally', 'level' => 'B1', 'meaning' => 'by nature', 'meaning_id' => 'secara alami', 'example' => 'He is naturally athletic.'],
                ['phrase' => 'effortlessly', 'level' => 'C1', 'meaning' => 'without apparent strain', 'meaning_id' => 'dengan mudah', 'example' => 'She ran the marathon effortlessly.']
            ],
            'technology' => [
                ['phrase' => 'rapidly', 'level' => 'B2', 'meaning' => 'very quickly', 'meaning_id' => 'dengan cepat', 'example' => 'Technology is changing rapidly.'],
                ['phrase' => 'automatically', 'level' => 'B1', 'meaning' => 'by itself', 'meaning_id' => 'secara otomatis', 'example' => 'The lights switch on automatically.'],
                ['phrase' => 'digitally', 'level' => 'B2', 'meaning' => 'using digital signals', 'meaning_id' => 'secara digital', 'example' => 'Photos are stored digitally.'],
                ['phrase' => 'virtually', 'level' => 'C1', 'meaning' => 'by means of software', 'meaning_id' => 'secara virtual / hampir', 'example' => 'We met virtually via Zoom.'],
                ['phrase' => 'manually', 'level' => 'B2', 'meaning' => 'by hand', 'meaning_id' => 'secara manual', 'example' => 'You have to update it manually.'],
                ['phrase' => 'electronically', 'level' => 'B2', 'meaning' => 'using electronic devices', 'meaning_id' => 'secara elektronik', 'example' => 'Data is transferred electronically.'],
                ['phrase' => 'instantly', 'level' => 'B2', 'meaning' => 'immediately', 'meaning_id' => 'secara instan', 'example' => 'Messages are delivered instantly.'],
                ['phrase' => 'constantly', 'level' => 'B2', 'meaning' => 'all the time', 'meaning_id' => 'secara konstan', 'example' => 'I check my phone constantly.'],
                ['phrase' => 'innovatively', 'level' => 'C1', 'meaning' => 'in a new and original way', 'meaning_id' => 'secara inovatif', 'example' => 'They solve problems innovatively.'],
                ['phrase' => 'wirelessly', 'level' => 'C1', 'meaning' => 'without wires', 'meaning_id' => 'tanpa kabel (wireless)', 'example' => 'The mouse connects wirelessly.']
            ],
            'transportation' => [
                ['phrase' => 'frequently', 'level' => 'B1', 'meaning' => 'often', 'meaning_id' => 'sering', 'example' => 'Buses run frequently.'],
                ['phrase' => 'safely', 'level' => 'A2', 'meaning' => 'without danger', 'meaning_id' => 'dengan aman', 'example' => 'Drive safely.'],
                ['phrase' => 'comfortably', 'level' => 'B1', 'meaning' => 'physically relaxed', 'meaning_id' => 'dengan nyaman', 'example' => 'Passengers can travel comfortably.'],
                ['phrase' => 'punctually', 'level' => 'C1', 'meaning' => 'on time', 'meaning_id' => 'tepat waktu', 'example' => 'Trains do not always arrive punctually.'],
                ['phrase' => 'rapidly', 'level' => 'B2', 'meaning' => 'fast', 'meaning_id' => 'dengan cepat', 'example' => 'The metro moves rapidly.'],
                ['phrase' => 'slowly', 'level' => 'A2', 'meaning' => 'at a low speed', 'meaning_id' => 'dengan lambat', 'example' => 'The traffic moved slowly.'],
                ['phrase' => 'smoothly', 'level' => 'B2', 'meaning' => 'without problems', 'meaning_id' => 'dengan lancar', 'example' => 'The flight went smoothly.'],
                ['phrase' => 'publicly', 'level' => 'B2', 'meaning' => 'using public facilities', 'meaning_id' => 'secara umum', 'example' => 'I prefer to travel publicly.'],
                ['phrase' => 'privately', 'level' => 'B2', 'meaning' => 'using private vehicle', 'meaning_id' => 'secara pribadi', 'example' => 'He drove privately to the coast.'],
                ['phrase' => 'directly', 'level' => 'B1', 'meaning' => 'without changing direction or stopping', 'meaning_id' => 'langsung', 'example' => 'This bus goes directly to the airport.']
            ],
            'shopping' => [
                ['phrase' => 'impulsively', 'level' => 'C1', 'meaning' => 'without forethought', 'meaning_id' => 'secara impulsif', 'example' => 'I tend to buy things impulsively.'],
                ['phrase' => 'excessively', 'level' => 'C1', 'meaning' => 'too much', 'meaning_id' => 'secara berlebihan', 'example' => 'Avoid spending excessively.'],
                ['phrase' => 'online', 'level' => 'A2', 'meaning' => 'via the internet', 'meaning_id' => 'secara online', 'example' => 'I do most of my shopping online.'],
                ['phrase' => 'thriftily', 'level' => 'C2', 'meaning' => 'carefully and economically', 'meaning_id' => 'secara hemat', 'example' => 'She manages her budget thriftily.'],
                ['phrase' => 'luxuriously', 'level' => 'C1', 'meaning' => 'in an expensive way', 'meaning_id' => 'dengan mewah', 'example' => 'They spent luxuriously on gifts.'],
                ['phrase' => 'selectively', 'level' => 'C1', 'meaning' => 'by careful selection', 'meaning_id' => 'secara selektif', 'example' => 'I shop selectively for clothes.'],
                ['phrase' => 'weekly', 'level' => 'A2', 'meaning' => 'every week', 'meaning_id' => 'mingguan', 'example' => 'We do a big shop weekly.'],
                ['phrase' => 'cheaply', 'level' => 'B1', 'meaning' => 'for a low price', 'meaning_id' => 'dengan murah', 'example' => 'You can buy fruit cheaply here.'],
                ['phrase' => 'reasonably', 'level' => 'B2', 'meaning' => 'to a moderate or acceptable degree', 'meaning_id' => 'dengan wajar', 'example' => 'The prices are reasonably low.'],
                ['phrase' => 'frequently', 'level' => 'B1', 'meaning' => 'often', 'meaning_id' => 'sering', 'example' => 'I visit the mall frequently.']
            ],
            'clothes-fashion' => [
                ['phrase' => 'fashionably', 'level' => 'B2', 'meaning' => 'in a style that is currently popular', 'meaning_id' => 'secara modis', 'example' => 'She is always dressed fashionably.'],
                ['phrase' => 'casually', 'level' => 'B2', 'meaning' => 'in a relaxed way', 'meaning_id' => 'santai', 'example' => 'He was dressed casually.'],
                ['phrase' => 'elegantly', 'level' => 'B2', 'meaning' => 'gracefully and stylishly', 'meaning_id' => 'secara elegan', 'example' => 'She dresses elegantly for work.'],
                ['phrase' => 'smartly', 'level' => 'B1', 'meaning' => 'neatly and fashionably', 'meaning_id' => 'dengan rapi', 'example' => 'You should dress smartly for the interview.'],
                ['phrase' => 'neatly', 'level' => 'B1', 'meaning' => 'in a tidy way', 'meaning_id' => 'dengan rapi', 'example' => 'His clothes were folded neatly.'],
                ['phrase' => 'stylishly', 'level' => 'B2', 'meaning' => 'in a fashionable way', 'meaning_id' => 'secara bergaya / stylish', 'example' => 'The coat is cut stylishly.'],
                ['phrase' => 'formally', 'level' => 'B2', 'meaning' => 'in accordance with rules or convention', 'meaning_id' => 'secara formal', 'example' => 'Guests must dress formally.'],
                ['phrase' => 'inappropriately', 'level' => 'C1', 'meaning' => 'not suitably', 'meaning_id' => 'secara tidak pantas', 'example' => 'He was dressed inappropriately.'],
                ['phrase' => 'traditionally', 'level' => 'B2', 'meaning' => 'according to tradition', 'meaning_id' => 'secara tradisional', 'example' => 'They dressed traditionally for the festival.'],
                ['phrase' => 'conservatively', 'level' => 'C1', 'meaning' => 'in a modest way', 'meaning_id' => 'secara konservatif', 'example' => 'She prefers to dress conservatively.']
            ],
            'colors' => [
                ['phrase' => 'brightly', 'level' => 'B1', 'meaning' => 'with much light', 'meaning_id' => 'dengan cerah', 'example' => 'The room was brightly colored.'],
                ['phrase' => 'dimly', 'level' => 'C1', 'meaning' => 'with faint light', 'meaning_id' => 'remang-remang', 'example' => 'The room was dimly lit.'],
                ['phrase' => 'vividly', 'level' => 'C1', 'meaning' => 'strongly or intensely', 'meaning_id' => 'secara jelas / hidup', 'example' => 'I remember the colors vividly.'],
                ['phrase' => 'faintly', 'level' => 'C1', 'meaning' => 'weakly', 'meaning_id' => 'samar-samar', 'example' => 'The line was faintly red.'],
                ['phrase' => 'softly', 'level' => 'B2', 'meaning' => 'with a pleasing low brightness', 'meaning_id' => 'dengan lembut', 'example' => 'The walls were painted softly.'],
                ['phrase' => 'darkly', 'level' => 'B2', 'meaning' => 'with little light', 'meaning_id' => 'gelap', 'example' => 'It was darkly colored.'],
                ['phrase' => 'richly', 'level' => 'C1', 'meaning' => 'in a full and pleasing way', 'meaning_id' => 'kaya (warna)', 'example' => 'The fabric was richly dyed.'],
                ['phrase' => 'naturally', 'level' => 'B1', 'meaning' => 'by nature', 'meaning_id' => 'secara alami', 'example' => 'Her hair is naturally blond.'],
                ['phrase' => 'artificially', 'level' => 'B2', 'meaning' => 'by human intervention', 'meaning_id' => 'secara buatan', 'example' => 'The flowers were artificially colored.'],
                ['phrase' => 'uniformly', 'level' => 'C1', 'meaning' => 'in the same way usually', 'meaning_id' => 'secara seragam', 'example' => 'The houses were uniformly grey.']
            ],
            'animals' => [
                ['phrase' => 'socially', 'level' => 'B2', 'meaning' => 'in the company of others', 'meaning_id' => 'secara sosial', 'example' => 'Some animals live socially in groups.'],
                ['phrase' => 'instinctively', 'level' => 'C1', 'meaning' => 'without conscious thought', 'meaning_id' => 'secara naluriah', 'example' => 'Animals react instinctively to danger.'],
                ['phrase' => 'wildly', 'level' => 'B2', 'meaning' => 'in a wild manner', 'meaning_id' => 'secara liar', 'example' => 'It looked around wildly.'],
                ['phrase' => 'domestically', 'level' => 'C1', 'meaning' => 'in the home', 'meaning_id' => 'di lingkungan rumah', 'example' => 'Cats live domestically with humans.'],
                ['phrase' => 'fiercely', 'level' => 'C1', 'meaning' => 'with powerful aggressiveness', 'meaning_id' => 'dengan garang', 'example' => 'The lion roared fiercely.'],
                ['phrase' => 'protectively', 'level' => 'B2', 'meaning' => 'in order to protect', 'meaning_id' => 'secara protektif', 'example' => 'The mother watched her cubs protectively.'],
                ['phrase' => 'aggressively', 'level' => 'B2', 'meaning' => 'forcefully', 'meaning_id' => 'secara agresif', 'example' => 'The dog barked aggressively.'],
                ['phrase' => 'peacefully', 'level' => 'B2', 'meaning' => 'without violence', 'meaning_id' => 'dengan damai', 'example' => 'They grazed peacefully.'],
                ['phrase' => 'naturally', 'level' => 'B1', 'meaning' => 'by nature', 'meaning_id' => 'secara alami', 'example' => 'They naturally avoid bright light.'],
                ['phrase' => 'playfully', 'level' => 'B2', 'meaning' => 'in a way that is ful of fun', 'meaning_id' => 'dengan main-main', 'example' => 'The kitten jumped playfully.']
            ],
            'daily-routine' => [
                ['phrase' => 'habitually', 'level' => 'C1', 'meaning' => 'by way of habit', 'meaning_id' => 'secara kebiasaan', 'example' => 'He checks his phone habitually.'],
                ['phrase' => 'punctually', 'level' => 'C1', 'meaning' => 'on time', 'meaning_id' => 'tepat waktu', 'example' => 'She arrives punctually every day.'],
                ['phrase' => 'efficiently', 'level' => 'B2', 'meaning' => 'without waste', 'meaning_id' => 'secara efisien', 'example' => 'I try to work efficiently.'],
                ['phrase' => 'hurriedly', 'level' => 'B2', 'meaning' => 'in a rush', 'meaning_id' => 'terburu-buru', 'example' => 'I ate breakfast hurriedly.'],
                ['phrase' => 'consistently', 'level' => 'B2', 'meaning' => 'always the same way', 'meaning_id' => 'secara konsisten', 'example' => 'I exercise consistently.'],
                ['phrase' => 'daily', 'level' => 'A1', 'meaning' => 'every day', 'meaning_id' => 'harian', 'example' => 'I read the news daily.'],
                ['phrase' => 'early', 'level' => 'A1', 'meaning' => 'before the usual time', 'meaning_id' => 'lebih awal', 'example' => 'I wake up early.'],
                ['phrase' => 'late', 'level' => 'A1', 'meaning' => 'after the usual time', 'meaning_id' => 'terlambat', 'example' => 'I slept late.'],
                ['phrase' => 'meticulously', 'level' => 'C2', 'meaning' => 'with great attention to detail', 'meaning_id' => 'dengan sangat teliti', 'example' => 'He planned his day meticulously.'],
                ['phrase' => 'lazily', 'level' => 'B2', 'meaning' => 'without energy', 'meaning_id' => 'dengan malas', 'example' => 'We spent the Sunday lazily.']
            ],
            'dictionaries' => [
                ['phrase' => 'accurately', 'level' => 'B2', 'meaning' => 'correctly', 'meaning_id' => 'secara akurat', 'example' => 'Translate the text accurately.'],
                ['phrase' => 'precisely', 'level' => 'B2', 'meaning' => 'exactly', 'meaning_id' => 'secara tepat', 'example' => 'Define the word precisely.'],
                ['phrase' => 'definitively', 'level' => 'C1', 'meaning' => 'decisively and with authority', 'meaning_id' => 'secara definitif', 'example' => 'It definitively explains the term.'],
                ['phrase' => 'clearly', 'level' => 'A2', 'meaning' => 'in a way that is easy to perceive', 'meaning_id' => 'dengan jelas', 'example' => 'The meaning is stated clearly.'],
                ['phrase' => 'linguistically', 'level' => 'C1', 'meaning' => 'relating to language', 'meaning_id' => 'secara linguistik', 'example' => 'It is linguistically complex.'],
                ['phrase' => 'alphabetically', 'level' => 'C1', 'meaning' => 'in the order of the letters', 'meaning_id' => 'sesuai abjad', 'example' => 'Words are listed alphabetically.'],
                ['phrase' => 'correctly', 'level' => 'B1', 'meaning' => 'right', 'meaning_id' => 'dengan benar', 'example' => 'Spell the word correctly.'],
                ['phrase' => 'fluently', 'level' => 'B2', 'meaning' => 'readily and smoothly', 'meaning_id' => 'dengan lancar', 'example' => 'He speaks fluently.'],
                ['phrase' => 'effectively', 'level' => 'B2', 'meaning' => 'in a way that produces a result', 'meaning_id' => 'secara efektif', 'example' => 'Use the dictionary effectively.'],
                ['phrase' => 'literally', 'level' => 'B2', 'meaning' => 'in a literal manner', 'meaning_id' => 'secara harfiah', 'example' => 'Don\'t translate it literally.']
            ],
            'gifts' => [
                ['phrase' => 'generously', 'level' => 'B2', 'meaning' => 'giving more than expected', 'meaning_id' => 'dengan murah hati', 'example' => 'He gave generously to charity.'],
                ['phrase' => 'thoughtfully', 'level' => 'C1', 'meaning' => 'with consideration', 'meaning_id' => 'dengan penuh pemikiran', 'example' => 'She chose the gift thoughtfully.'],
                ['phrase' => 'gratefully', 'level' => 'B2', 'meaning' => 'with appreciation', 'meaning_id' => 'dengan penuh rasa syukur', 'example' => 'I accepted the gift gratefully.'],
                ['phrase' => 'personally', 'level' => 'B2', 'meaning' => 'in person', 'meaning_id' => 'secara pribadi', 'example' => 'I delivered it personally.'],
                ['phrase' => 'secretly', 'level' => 'B1', 'meaning' => 'without anyone knowing', 'meaning_id' => 'secara diam-diam', 'example' => 'He bought the ring secretly.'],
                ['phrase' => 'beautifully', 'level' => 'A2', 'meaning' => 'in a beautiful manner', 'meaning_id' => 'dengan indah', 'example' => 'It was wrapped beautifully.'],
                ['phrase' => 'extravagantly', 'level' => 'C1', 'meaning' => 'spending too much', 'meaning_id' => 'secara mewah / boros', 'example' => 'Don\'t spend extravagantly.'],
                ['phrase' => 'kindly', 'level' => 'B1', 'meaning' => 'in a kind way', 'meaning_id' => 'dengan baik hati', 'example' => 'She kindly offered me a gift.'],
                ['phrase' => 'graciously', 'level' => 'C2', 'meaning' => 'in a courteous and pleasant way', 'meaning_id' => 'dengan ramah / anggun', 'example' => 'He accepted the refusal graciously.'],
                ['phrase' => 'unexpectedly', 'level' => 'B2', 'meaning' => 'as a surprise', 'meaning_id' => 'secara tak terduga', 'example' => 'The gift arrived unexpectedly.']
            ],
            'family-friends' => [
                ['phrase' => 'closely', 'level' => 'B2', 'meaning' => 'in a way that involves a strong relationship', 'meaning_id' => 'secara dekat', 'example' => 'We work closely together.'],
                ['phrase' => 'affectionately', 'level' => 'B2', 'meaning' => 'in a way that displays fondness', 'meaning_id' => 'dengan penuh kasih sayang', 'example' => 'She hugged him affectionately.'],
                ['phrase' => 'mutually', 'level' => 'B2', 'meaning' => 'with mutual action or relationship', 'meaning_id' => 'secara timbal balik', 'example' => 'The feeling is mutually shared.'],
                ['phrase' => 'loyally', 'level' => 'B2', 'meaning' => 'in a faithful way', 'meaning_id' => 'dengan setia', 'example' => 'He supported his friend loyally.'],
                ['phrase' => 'constantly', 'level' => 'B2', 'meaning' => 'continuously over a period of time', 'meaning_id' => 'terus menerus', 'example' => 'They talk constantly.'],
                ['phrase' => 'briefly', 'level' => 'B1', 'meaning' => 'for a short time', 'meaning_id' => 'sebentar', 'example' => 'We met briefly.'],
                ['phrase' => 'regularly', 'level' => 'B1', 'meaning' => 'at uniform intervals', 'meaning_id' => 'secara teratur', 'example' => 'We meet regularly for coffee.'],
                ['phrase' => 'occasionally', 'level' => 'B1', 'meaning' => 'now and then', 'meaning_id' => 'sesekali', 'example' => 'We argue occasionally.'],
                ['phrase' => 'socially', 'level' => 'B2', 'meaning' => 'in social situations', 'meaning_id' => 'secara sosial', 'example' => 'We interact socially only.'],
                ['phrase' => 'emotionally', 'level' => 'B2', 'meaning' => 'with regard to feelings', 'meaning_id' => 'secara emosional', 'example' => 'He supported her emotionally.']
            ],
            'weather' => [
                ['phrase' => 'heavily', 'level' => 'B1', 'meaning' => 'with great force (rain)', 'meaning_id' => 'dengan lebat', 'example' => 'It rained heavily.'],
                ['phrase' => 'intermittently', 'level' => 'C2', 'meaning' => 'at irregular intervals', 'meaning_id' => 'berselang-seling', 'example' => 'It snowed intermittently.'],
                ['phrase' => 'unexpectedly', 'level' => 'B2', 'meaning' => 'without warning', 'meaning_id' => 'secara tak terduga', 'example' => 'The storm hit unexpectedly.'],
                ['phrase' => 'seasonally', 'level' => 'C1', 'meaning' => 'depending on the season', 'meaning_id' => 'secara musiman', 'example' => 'The weather changes seasonally.'],
                ['phrase' => 'severely', 'level' => 'B2', 'meaning' => 'strictly or harshly', 'meaning_id' => 'dengan parah / keras', 'example' => 'The area was affected severely.'],
                ['phrase' => 'regionally', 'level' => 'B2', 'meaning' => 'relating to a particular region', 'meaning_id' => 'secara regional', 'example' => 'Temperatures vary regionally.'],
                ['phrase' => 'constantly', 'level' => 'B2', 'meaning' => 'all the time', 'meaning_id' => 'terus menerus', 'example' => 'It drizzles constantly here.'],
                ['phrase' => 'drastically', 'level' => 'C1', 'meaning' => 'in a strong way', 'meaning_id' => 'secara drastis', 'example' => 'The climate changed drastically.'],
                ['phrase' => 'unpredictably', 'level' => 'C1', 'meaning' => 'in a way that cannot be foreseen', 'meaning_id' => 'secara tidak terduga', 'example' => 'The wind blows unpredictably.'],
                ['phrase' => 'mildly', 'level' => 'B2', 'meaning' => 'not severely or seriously', 'meaning_id' => 'secara ringan', 'example' => 'It is only mildly cold.']
            ]
        ];

        $keys = array_keys($adverbsMap);
        usort($keys, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($keys as $key) {
            if (str_contains($slug, $key)) {
                return $adverbsMap[$key];
            }
        }

        return $commonAdverbs;
    }

    public function getAdvancedVerbsForTopic($slug)
    {
        $commonVerbs = [
            ['phrase' => 'enhance', 'level' => 'B2', 'meaning' => 'intensify, increase, or further improve the quality', 'meaning_id' => 'meningkatkan / memperbaiki', 'example' => 'This will enhance your performance.'],
            ['phrase' => 'demonstrate', 'level' => 'B2', 'meaning' => 'clearly show the existence or truth of', 'meaning_id' => 'menunjukkan / mendemonstrasikan', 'example' => 'The study demonstrates the benefits.'],
            ['phrase' => 'evaluate', 'level' => 'B2', 'meaning' => 'form an idea of the amount, number, or value of', 'meaning_id' => 'mengevaluasi / menilai', 'example' => 'We need to evaluate the results.'],
            ['phrase' => 'facilitate', 'level' => 'C1', 'meaning' => 'make (an action or process) easy or easier', 'meaning_id' => 'memfasilitasi / memudahkan', 'example' => 'The new software will facilitate the process.'],
            ['phrase' => 'implement', 'level' => 'B2', 'meaning' => 'put (a decision, plan, agreement, etc.) into effect', 'meaning_id' => 'menerapkan', 'example' => 'We will implement the new policy next month.']
        ];

        $verbsMap = [
            'hometown' => [
                ['phrase' => 'reside', 'level' => 'C1', 'meaning' => 'have one\'s permanent home in a particular place', 'meaning_id' => 'bertempat tinggal', 'example' => 'I reside in a quiet neighborhood.'],
                ['phrase' => 'originate', 'level' => 'C1', 'meaning' => 'have a specified beginning', 'meaning_id' => 'berasal', 'example' => 'My family originates from this area.'],
                ['phrase' => 'develop', 'level' => 'B1', 'meaning' => 'grow or cause to grow', 'meaning_id' => 'berkembang', 'example' => 'The town developed into a city.'],
                ['phrase' => 'transform', 'level' => 'B2', 'meaning' => 'make a thorough or dramatic change', 'meaning_id' => 'mengubah / bertransformasi', 'example' => 'Tourism transformed the local economy.'],
                ['phrase' => 'boast', 'level' => 'C1', 'meaning' => 'possess a feature that is a source of pride', 'meaning_id' => 'membanggakan (memiliki)', 'example' => 'The city boasts a beautiful park.'],
                ['phrase' => 'lack', 'level' => 'B1', 'meaning' => 'be without or deficient in', 'meaning_id' => 'kekurangan', 'example' => 'It lacks modern facilities.'],
                ['phrase' => 'accommodate', 'level' => 'B2', 'meaning' => 'provide lodging or sufficient space for', 'meaning_id' => 'menampung', 'example' => 'New hotels accommodate tourists.'],
                ['phrase' => 'preserve', 'level' => 'B2', 'meaning' => 'maintain something in its original or existing state', 'meaning_id' => 'melestarikan', 'example' => 'We must preserve our heritage.'],
                ['phrase' => 'commute', 'level' => 'B2', 'meaning' => 'travel some distance between one\'s home and place of work', 'meaning_id' => 'bepergian (pulang-pergi kerja)', 'example' => 'I commute to the capital daily.'],
                ['phrase' => 'relocate', 'level' => 'B2', 'meaning' => 'move to a new place', 'meaning_id' => 'pindah', 'example' => 'Many people relocate here for work.']
            ],
            'accommodation' => [
                ['phrase' => 'accommodate', 'level' => 'B2', 'meaning' => 'provide lodging or sufficient space for', 'meaning_id' => 'menampung', 'example' => 'The hotel can accommodate 500 guests.'],
                ['phrase' => 'renovate', 'level' => 'C1', 'meaning' => 'restore to a good state of repair', 'meaning_id' => 'merenovasi', 'example' => 'They plan to renovate the old house.'],
                ['phrase' => 'lease', 'level' => 'C1', 'meaning' => 'grant property on lease; rent', 'meaning_id' => 'menyewakan (kontrak)', 'example' => 'He leased the apartment for a year.'],
                ['phrase' => 'furnish', 'level' => 'C1', 'meaning' => 'provide (a house or room) with furniture', 'meaning_id' => 'mengisi perabot', 'example' => 'The room is fully furnished.'],
                ['phrase' => 'occupy', 'level' => 'B2', 'meaning' => 'reside or have one\'s place of business in', 'meaning_id' => 'menempati', 'example' => 'The family has occupied the house for generations.'],
                ['phrase' => 'construct', 'level' => 'B2', 'meaning' => 'build or erect', 'meaning_id' => 'membangun', 'example' => 'They are constructing a new building.'],
                ['phrase' => 'maintain', 'level' => 'B2', 'meaning' => 'keep in good condition', 'meaning_id' => 'memelihara', 'example' => 'It is expensive to maintain a large house.'],
                ['phrase' => 'decorate', 'level' => 'B1', 'meaning' => 'make more attractive', 'meaning_id' => 'mendekorasi', 'example' => 'We decorated the living room.'],
                ['phrase' => 'search', 'level' => 'A2', 'meaning' => 'try to find', 'meaning_id' => 'mencari', 'example' => 'I am searching for a flat.'],
                ['phrase' => 'dwell', 'level' => 'C2', 'meaning' => 'live in or at a specified place', 'meaning_id' => 'tinggal / berdiam', 'example' => 'They dwell in the forest.']
            ],
            'work' => [
                ['phrase' => 'delegate', 'level' => 'C1', 'meaning' => 'entrust (a task or responsibility) to another person', 'meaning_id' => 'mendelegasikan', 'example' => 'A good manager knows when to delegate.'],
                ['phrase' => 'negotiate', 'level' => 'B2', 'meaning' => 'obtain or bring about by discussion', 'meaning_id' => 'bernegosiasi', 'example' => 'We need to negotiate a better deal.'],
                ['phrase' => 'collaborate', 'level' => 'C1', 'meaning' => 'work jointly on an activity or project', 'meaning_id' => 'berkolaborasi', 'example' => 'We collaborated with a local firm.'],
                ['phrase' => 'manage', 'level' => 'B2', 'meaning' => 'be in charge of', 'meaning_id' => 'mengelola', 'example' => 'I manage a team of five.'],
                ['phrase' => 'oversee', 'level' => 'C1', 'meaning' => 'supervise a person or work', 'meaning_id' => 'mengawasi', 'example' => 'She oversees the marketing department.'],
                ['phrase' => 'execute', 'level' => 'C1', 'meaning' => 'carry out or put into effect', 'meaning_id' => 'menjalankan / mengeksekusi', 'example' => 'We need to execute the plan.'],
                ['phrase' => 'prioritize', 'level' => 'B2', 'meaning' => 'treat as more important', 'meaning_id' => 'memprioritaskan', 'example' => 'You must prioritize your tasks.'],
                ['phrase' => 'specialize', 'level' => 'B2', 'meaning' => 'concentrate on a particular area', 'meaning_id' => 'berspesialisasi', 'example' => 'I specialize in digital marketing.'],
                ['phrase' => 'undertake', 'level' => 'C1', 'meaning' => 'commit oneself to and begin', 'meaning_id' => 'menjalankan / mengambil tanggung jawab', 'example' => 'I undertook the new project.'],
                ['phrase' => 'implement', 'level' => 'B2', 'meaning' => 'put a decision or plan into effect', 'meaning_id' => 'menerapkan', 'example' => 'We will implement the changes soon.']
            ],
            'study' => [
                ['phrase' => 'acquire', 'level' => 'B2', 'meaning' => 'learn or develop', 'meaning_id' => 'memperoleh', 'example' => 'I hope to acquire new skills.'],
                ['phrase' => 'revise', 'level' => 'B1', 'meaning' => 'reread work done previously to improve one\'s knowledge', 'meaning_id' => 'merevisi / belajar ulang', 'example' => 'I need to revise for the exam.'],
                ['phrase' => 'demonstrate', 'level' => 'B2', 'meaning' => 'show clearly', 'meaning_id' => 'menunjukkan', 'example' => 'He demonstrated a good understanding of the topic.'],
                ['phrase' => 'comprehend', 'level' => 'C1', 'meaning' => 'grasp mentally; understand', 'meaning_id' => 'memahami', 'example' => 'It was hard to comprehend the theory.'],
                ['phrase' => 'analyze', 'level' => 'B2', 'meaning' => 'examine in detail', 'meaning_id' => 'menganalisis', 'example' => 'We analyzed the data.'],
                ['phrase' => 'evaluate', 'level' => 'C1', 'meaning' => 'form an idea of value', 'meaning_id' => 'mengevaluasi', 'example' => 'Evaluate the importance of this event.'],
                ['phrase' => 'research', 'level' => 'B1', 'meaning' => 'investigate systematically', 'meaning_id' => 'meneliti', 'example' => 'I researched the history of the city.'],
                ['phrase' => 'master', 'level' => 'B2', 'meaning' => 'acquire complete knowledge or skill', 'meaning_id' => 'menguasai', 'example' => 'He mastered the language quickly.'],
                ['phrase' => 'submit', 'level' => 'B2', 'meaning' => 'present for consideration', 'meaning_id' => 'mengumpulkan / menyerahkan', 'example' => 'I submitted my assignment.'],
                ['phrase' => 'graduate', 'level' => 'B1', 'meaning' => 'successfully complete an academic degree', 'meaning_id' => 'lulus', 'example' => 'She graduated from university last year.']
            ],
            'hobbies-interests' => [
                ['phrase' => 'dedicate', 'level' => 'C1', 'meaning' => 'devote (time or effort) to a particular task', 'meaning_id' => 'mendedikasikan', 'example' => 'I dedicate my weekends to painting.'],
                ['phrase' => 'socialize', 'level' => 'B2', 'meaning' => 'mix socially with others', 'meaning_id' => 'bersosialisasi', 'example' => 'Hobbies help me socialize with new people.'],
                ['phrase' => 'unwind', 'level' => 'C1', 'meaning' => 'relax after a period of work or tension', 'meaning_id' => 'bersantai', 'example' => 'Reading helps me unwind.'],
                ['phrase' => 'pursue', 'level' => 'B2', 'meaning' => 'follow or seek to attain', 'meaning_id' => 'menekuni', 'example' => 'I want to pursue photograpy.'],
                ['phrase' => 'engage', 'level' => 'B2', 'meaning' => 'participate or become involved in', 'meaning_id' => 'terlibat', 'example' => 'I engage in outdoor activities.'],
                ['phrase' => 'collect', 'level' => 'B1', 'meaning' => 'bring or gather together', 'meaning_id' => 'mengoleksi', 'example' => 'He collects stamps.'],
                ['phrase' => 'participate', 'level' => 'B1', 'meaning' => 'take part', 'meaning_id' => 'berpartisipasi', 'example' => 'I participate in a book club.'],
                ['phrase' => 'practice', 'level' => 'A2', 'meaning' => 'perform repeatedly to improve', 'meaning_id' => 'berlatih', 'example' => 'I practice piano daily.'],
                ['phrase' => 'cultivate', 'level' => 'C1', 'meaning' => 'try to acquire or develop', 'meaning_id' => 'mengembangkan', 'example' => 'Reading helps cultivate knowledge.'],
                ['phrase' => 'exhibit', 'level' => 'B2', 'meaning' => 'show publicly', 'meaning_id' => 'memamerkan', 'example' => 'She exhibits her art in galleries.']
            ],
            'travel-holidays' => [
                ['phrase' => 'explore', 'level' => 'B1', 'meaning' => 'travel through an unfamiliar area in order to learn about it', 'meaning_id' => 'menjelajahi', 'example' => 'We explored the ancient ruins.'],
                ['phrase' => 'immerse', 'level' => 'C1', 'meaning' => 'involve oneself deeply in a particular activity', 'meaning_id' => 'membenamkan diri', 'example' => 'I like to immerse myself in the local culture.'],
                ['phrase' => 'venture', 'level' => 'C2', 'meaning' => 'dare to do or go somewhere', 'meaning_id' => 'berpetualang / memberanikan diri', 'example' => 'We ventured into the jungle.'],
                ['phrase' => 'wander', 'level' => 'C1', 'meaning' => 'walk or move in a leisurely way', 'meaning_id' => 'mengembara / berjalan-jalan', 'example' => 'We wandered around the old town.'],
                ['phrase' => 'embark', 'level' => 'C1', 'meaning' => 'go on board a ship, aircraft, or other vehicle', 'meaning_id' => 'naik (kendaraan) / memulai', 'example' => 'We embarked on our journey.'],
                ['phrase' => 'discover', 'level' => 'A2', 'meaning' => 'find unexpectedly or during a search', 'meaning_id' => 'menemukan', 'example' => 'We discovered a hidden beach.'],
                ['phrase' => 'plan', 'level' => 'A2', 'meaning' => 'decide in advance', 'meaning_id' => 'merencanakan', 'example' => 'I love planning my trips.'],
                ['phrase' => 'experience', 'level' => 'B1', 'meaning' => 'encounter or undergo', 'meaning_id' => 'mengalami / merasakan', 'example' => 'I want to experience new things.'],
                ['phrase' => 'sightsee', 'level' => 'B1', 'meaning' => 'visit places of interest', 'meaning_id' => 'berwisata', 'example' => 'We went sightseeing in Paris.'],
                ['phrase' => 'navigate', 'level' => 'B2', 'meaning' => 'plan and direct the route', 'meaning_id' => 'menavigasi', 'example' => 'It was hard to navigate the city.']
            ],
            'music' => [
                ['phrase' => 'compose', 'level' => 'B2', 'meaning' => 'write or create', 'meaning_id' => 'menggubah', 'example' => 'He composes his own music.'],
                ['phrase' => 'perform', 'level' => 'B1', 'meaning' => 'present to an audience', 'meaning_id' => 'tampil', 'example' => 'The band performed live.'],
                ['phrase' => 'appreciate', 'level' => 'B2', 'meaning' => 'recognize the full worth of', 'meaning_id' => 'menghargai', 'example' => 'I appreciate classical music.'],
                ['phrase' => 'rehearse', 'level' => 'C1', 'meaning' => 'practice for later public performance', 'meaning_id' => 'berlatih (resik)', 'example' => 'They rehearsed for weeks.'],
                ['phrase' => 'conduct', 'level' => 'C1', 'meaning' => 'lead (an orchestra)', 'meaning_id' => 'memimpin (orkestra)', 'example' => 'He conducts the symphony orchestra.'],
                ['phrase' => 'record', 'level' => 'B1', 'meaning' => 'set down in writing or some other permanent form', 'meaning_id' => 'merekam', 'example' => 'They recorded a new album.'],
                ['phrase' => 'listen', 'level' => 'A1', 'meaning' => 'give one\'s attention to a sound', 'meaning_id' => 'mendengarkan', 'example' => 'I listen to music daily.'],
                ['phrase' => 'produce', 'level' => 'B1', 'meaning' => 'create or manufacture', 'meaning_id' => 'memproduksi', 'example' => 'He produces hip-hop tracks.'],
                ['phrase' => 'improvise', 'level' => 'C1', 'meaning' => 'create and perform spontaneously', 'meaning_id' => 'berimprovisasi', 'example' => 'Jazz musicians often improvise.'],
                ['phrase' => 'harmonize', 'level' => 'C1', 'meaning' => 'add notes to a melody to produce harmony', 'meaning_id' => 'menyelaraskan', 'example' => 'The singers harmonized beautifully.']
            ],
             'movies' => [
                ['phrase' => 'depict', 'level' => 'C1', 'meaning' => 'show or represent', 'meaning_id' => 'menggambarkan', 'example' => 'The movie depicts the war accurately.'],
                ['phrase' => 'star', 'level' => 'B1', 'meaning' => 'have (someone) as a principal performer', 'meaning_id' => 'membintangi', 'example' => 'The film stars a famous actor.'],
                ['phrase' => 'direct', 'level' => 'B2', 'meaning' => 'control the operations', 'meaning_id' => 'menyutradarai', 'example' => 'Spielberg directed this movie.'],
                ['phrase' => 'release', 'level' => 'B2', 'meaning' => 'make available for publication', 'meaning_id' => 'merilis', 'example' => 'The movie was released last year.'],
                ['phrase' => 'screen', 'level' => 'C1', 'meaning' => 'show (a movie)', 'meaning_id' => 'menayangkan', 'example' => 'The film was screened at the festival.'],
                ['phrase' => 'portray', 'level' => 'C1', 'meaning' => 'describe in a particular way', 'meaning_id' => 'memerankan / menggambarkan', 'example' => 'She portrays a strong leader.'],
                ['phrase' => 'review', 'level' => 'B1', 'meaning' => 'assess formally', 'meaning_id' => 'mengulas', 'example' => 'Critics reviewed the film positively.'],
                ['phrase' => 'dub', 'level' => 'C1', 'meaning' => 'provide a film with a soundtrack in a different language', 'meaning_id' => 'mengisi suara (dubbing)', 'example' => 'The movie was dubbed into English.'],
                ['phrase' => 'feature', 'level' => 'B2', 'meaning' => 'have as a prominent attribute', 'meaning_id' => 'menampilkan', 'example' => 'The film features great effects.'],
                ['phrase' => 'entertain', 'level' => 'B1', 'meaning' => 'provide amusement', 'meaning_id' => 'menghibur', 'example' => 'The comedy entertained us.'],
            ],
            'food-cooking' => [
                ['phrase' => 'savor', 'level' => 'C2', 'meaning' => 'taste and enjoy completely', 'meaning_id' => 'menikmati', 'example' => 'Savor every bite of this meal.'],
                ['phrase' => 'consume', 'level' => 'B2', 'meaning' => 'eat, drink, or ingest', 'meaning_id' => 'mengkonsumsi', 'example' => 'Don\'t consume too much sugar.'],
                ['phrase' => 'prepare', 'level' => 'A2', 'meaning' => 'make ready for use', 'meaning_id' => 'menyiapkan', 'example' => 'I will prepare dinner.'],
                ['phrase' => 'roast', 'level' => 'B1', 'meaning' => 'cook (food) in an oven', 'meaning_id' => 'memanggang', 'example' => 'We roasted a chicken.'],
                ['phrase' => 'marinate', 'level' => 'C1', 'meaning' => 'soak in a marinade', 'meaning_id' => 'memarinasi', 'example' => 'Marinate the meat overnight.'],
                ['phrase' => 'digest', 'level' => 'C1', 'meaning' => 'break down food', 'meaning_id' => 'mencerna', 'example' => 'It takes time to digest food.'],
                ['phrase' => 'serve', 'level' => 'A2', 'meaning' => 'present (food or drink)', 'meaning_id' => 'menyajikan', 'example' => 'Dinner is served.'],
                ['phrase' => 'devour', 'level' => 'C1', 'meaning' => 'eat hungrily or quickly', 'meaning_id' => 'melahap', 'example' => 'He devoured the burger.'],
                ['phrase' => 'feast', 'level' => 'C1', 'meaning' => 'eat and drink sumptuously', 'meaning_id' => 'berpesta (makan)', 'example' => 'We feasted on seafood.'],
                ['phrase' => 'indulge', 'level' => 'C1', 'meaning' => 'allow oneself to enjoy the pleasure of', 'meaning_id' => 'memanjakan diri', 'example' => 'I indulged in dessert.']
            ],
            'sport' => [
                ['phrase' => 'compete', 'level' => 'B1', 'meaning' => 'strive to gain or win something', 'meaning_id' => 'berkompetisi', 'example' => 'Athletes compete for gold medals.'],
                ['phrase' => 'train', 'level' => 'B1', 'meaning' => 'undertake a course of exercise', 'meaning_id' => 'berlatih', 'example' => 'I train five days a week.'],
                ['phrase' => 'defeat', 'level' => 'B2', 'meaning' => 'win a victory over', 'meaning_id' => 'mengalahkan', 'example' => 'We defeated the rival team.'],
                ['phrase' => 'score', 'level' => 'B1', 'meaning' => 'gain (a point, goal, etc.)', 'meaning_id' => 'mencetak skor', 'example' => 'He scored the winning goal.'],
                ['phrase' => 'challenge', 'level' => 'B2', 'meaning' => 'invite to contest', 'meaning_id' => 'menantang', 'example' => 'I challenged him to a race.'],
                ['phrase' => 'tackle', 'level' => 'B2', 'meaning' => 'make determined efforts to deal with', 'meaning_id' => 'menangani / merebut', 'example' => 'The defender tackled the player.'],
                ['phrase' => 'qualify', 'level' => 'B2', 'meaning' => 'become eligible', 'meaning_id' => 'lolos kualifikasi', 'example' => 'She qualified for the final.'],
                ['phrase' => 'coach', 'level' => 'B1', 'meaning' => 'train or instruct', 'meaning_id' => 'melatih', 'example' => 'He coaches the junior team.'],
                ['phrase' => 'sprint', 'level' => 'C1', 'meaning' => 'run at full speed', 'meaning_id' => 'berlari cepat (sprint)', 'example' => 'They sprinted to the finish line.'],
                ['phrase' => 'participate', 'level' => 'B1', 'meaning' => 'take part', 'meaning_id' => 'berpartisipasi', 'example' => 'Many countries participate in the Olympics.']
            ],
            'technology' => [
                ['phrase' => 'revolutionize', 'level' => 'C1', 'meaning' => 'change fundamentally', 'meaning_id' => 'merevolusi', 'example' => 'The internet revolutionized communication.'],
                ['phrase' => 'facilitate', 'level' => 'C1', 'meaning' => 'make easier', 'meaning_id' => 'memfasilitasi', 'example' => 'Computers facilitate our work.'],
                ['phrase' => 'install', 'level' => 'B2', 'meaning' => 'place or fix in position', 'meaning_id' => 'menginstal', 'example' => 'I installed the new software.'],
                ['phrase' => 'upgrade', 'level' => 'B2', 'meaning' => 'raise to a higher standard', 'meaning_id' => 'meningkatkan / upgrade', 'example' => 'You should upgrade your phone.'],
                ['phrase' => 'browse', 'level' => 'B2', 'meaning' => 'survey goods or text', 'meaning_id' => 'menjelajah (browsing)', 'example' => 'I browse the internet daily.'],
                ['phrase' => 'download', 'level' => 'A2', 'meaning' => 'copy data', 'meaning_id' => 'mengunduh', 'example' => 'I downloaded the file.'],
                ['phrase' => 'navigate', 'level' => 'B2', 'meaning' => 'move around a website or screen', 'meaning_id' => 'menavigasi', 'example' => 'It is easy to navigate the menu.'],
                ['phrase' => 'program', 'level' => 'B1', 'meaning' => 'provide with coded instructions', 'meaning_id' => 'memprogram', 'example' => 'He programmed the app.'],
                ['phrase' => 'stream', 'level' => 'B2', 'meaning' => 'transmit or receive data', 'meaning_id' => 'streaming', 'example' => 'We stream movies online.'],
                ['phrase' => 'connect', 'level' => 'A2', 'meaning' => 'join together', 'meaning_id' => 'menghubungkan', 'example' => 'Connect to the Wi-Fi.']
            ],
            'transportation' => [
                ['phrase' => 'commute', 'level' => 'B2', 'meaning' => 'travel between home and work', 'meaning_id' => 'bepergian (pulang-pergi)', 'example' => 'I commute by train.'],
                ['phrase' => 'depart', 'level' => 'B2', 'meaning' => 'leave, especially in order to start a journey', 'meaning_id' => 'berangkat', 'example' => 'The train departs at noon.'],
                ['phrase' => 'arrive', 'level' => 'A2', 'meaning' => 'reach a place', 'meaning_id' => 'tiba', 'example' => 'We arrived late.'],
                ['phrase' => 'transfer', 'level' => 'B2', 'meaning' => 'move from one place to another', 'meaning_id' => 'transfer / pindah kendaraan', 'example' => 'We transferred to a bus.'],
                ['phrase' => 'board', 'level' => 'B2', 'meaning' => 'get on or into', 'meaning_id' => 'naik (pesawat/kapal)', 'example' => 'Passengers boarded the plane.'],
                ['phrase' => 'operate', 'level' => 'B2', 'meaning' => 'control the functioning of', 'meaning_id' => 'mengoperasikan', 'example' => 'He operates heavy machinery.'],
                ['phrase' => 'delay', 'level' => 'B1', 'meaning' => 'make late or slow', 'meaning_id' => 'menunda', 'example' => 'The flight was delayed.'],
                ['phrase' => 'transport', 'level' => 'B2', 'meaning' => 'take or carry', 'meaning_id' => 'mengangkut', 'example' => 'Goods are transported by truck.'],
                ['phrase' => 'accelerate', 'level' => 'C1', 'meaning' => 'begin to move more quickly', 'meaning_id' => 'mempercepat / akselerasi', 'example' => 'The car accelerated.'],
                ['phrase' => 'steer', 'level' => 'C1', 'meaning' => 'guide or control', 'meaning_id' => 'mengemudi / mengarahkan', 'example' => 'He steered the boat.'],
            ],
            'shopping' => [
                ['phrase' => 'purchase', 'level' => 'B2', 'meaning' => 'acquire by paying for it; buy', 'meaning_id' => 'membeli', 'example' => 'I purchased a new laptop.'],
                ['phrase' => 'afford', 'level' => 'B1', 'meaning' => 'have enough money to pay for', 'meaning_id' => 'mampu membayar', 'example' => 'I can\'t afford that car.'],
                ['phrase' => 'browse', 'level' => 'B1', 'meaning' => 'look at goods without buying', 'meaning_id' => 'melihat-lihat', 'example' => 'I\'m just browsing.'],
                ['phrase' => 'refund', 'level' => 'C1', 'meaning' => 'pay back money', 'meaning_id' => 'mengembalikan dana', 'example' => 'They refunded my money.'],
                ['phrase' => 'exchange', 'level' => 'B1', 'meaning' => 'give something and receive something else', 'meaning_id' => 'menukar', 'example' => 'I exchanged the shirt for a smaller size.'],
                ['phrase' => 'compare', 'level' => 'B1', 'meaning' => 'estimate similarity or difference', 'meaning_id' => 'membandingkan', 'example' => 'Compare prices before buying.'],
                ['phrase' => 'select', 'level' => 'B2', 'meaning' => 'choose', 'meaning_id' => 'memilih', 'example' => 'Select the items you want.'],
                ['phrase' => 'bargain', 'level' => 'C1', 'meaning' => 'negotiate the price', 'meaning_id' => 'menawar', 'example' => 'You can bargain in the market.'],
                ['phrase' => 'spend', 'level' => 'A1', 'meaning' => 'pay out money', 'meaning_id' => 'menghabiskan (uang)', 'example' => 'I spent 50 dollars.'],
                ['phrase' => 'consume', 'level' => 'B2', 'meaning' => 'buy goods or services', 'meaning_id' => 'mengkonsumsi / memakai', 'example' => 'We consume a lot of energy.']
            ],
            'clothes-fashion' => [
                ['phrase' => 'dress', 'level' => 'A1', 'meaning' => 'put on clothes', 'meaning_id' => 'berpakaian', 'example' => 'She dresses very elegantly.'],
                ['phrase' => 'suit', 'level' => 'B1', 'meaning' => 'be convenient for or acceptable to', 'meaning_id' => 'cocok', 'example' => 'This color suits you.'],
                ['phrase' => 'wear', 'level' => 'A1', 'meaning' => 'have on one\'s body like clothing', 'meaning_id' => 'memakai', 'example' => 'He is wearing a hat.'],
                ['phrase' => 'fit', 'level' => 'B1', 'meaning' => 'be of the right size or shape', 'meaning_id' => 'pas / muat', 'example' => 'The shoes fit perfectly.'],
                ['phrase' => 'match', 'level' => 'B1', 'meaning' => 'correspond or be compatible', 'meaning_id' => 'cocok / serasi', 'example' => 'The bag matches the shoes.'],
                ['phrase' => 'design', 'level' => 'B1', 'meaning' => 'decide upon the look of', 'meaning_id' => 'mendesain', 'example' => 'She designs her own clothes.'],
                ['phrase' => 'accessorize', 'level' => 'C1', 'meaning' => 'add accessories to', 'meaning_id' => 'menambah aksesoris', 'example' => 'She accessorized with a scarf.'],
                ['phrase' => 'tailor', 'level' => 'C1', 'meaning' => 'make or adapt for a particular purpose', 'meaning_id' => 'menjahit / menyesuaikan', 'example' => 'The suit was tailored for him.'],
                ['phrase' => 'showcase', 'level' => 'C1', 'meaning' => 'exhibit; display', 'meaning_id' => 'memamerkan', 'example' => 'The event showcases new trends.'],
                ['phrase' => 'model', 'level' => 'B2', 'meaning' => 'display clothes by wearing them', 'meaning_id' => 'memperagakan', 'example' => 'She models for a magazine.']
            ],
            'colors' => [
                ['phrase' => 'symbolize', 'level' => 'C1', 'meaning' => 'be a symbol of', 'meaning_id' => 'melambangkan', 'example' => 'Red often symbolizes danger.'],
                ['phrase' => 'fade', 'level' => 'C1', 'meaning' => 'lose color or brightness', 'meaning_id' => 'memudar', 'example' => 'The colors faded in the sun.'],
                ['phrase' => 'blend', 'level' => 'C1', 'meaning' => 'mix together', 'meaning_id' => 'mencampur / membaur', 'example' => 'The colors blend well.'],
                ['phrase' => 'clash', 'level' => 'C1', 'meaning' => 'be incompatible', 'meaning_id' => 'bertabrakan (warna)', 'example' => 'Those colors clash.'],
                ['phrase' => 'brighten', 'level' => 'B2', 'meaning' => 'make or become more light', 'meaning_id' => 'mencerahkan', 'example' => 'The paint brightens the room.'],
                ['phrase' => 'darken', 'level' => 'B2', 'meaning' => 'make or become dark', 'meaning_id' => 'menggelapkan', 'example' => 'The sky darkened.'],
                ['phrase' => 'dye', 'level' => 'C1', 'meaning' => 'change the color of', 'meaning_id' => 'mewarnai (celup)', 'example' => 'She dyed her hair.'],
                ['phrase' => 'match', 'level' => 'B1', 'meaning' => 'correspond in color', 'meaning_id' => 'cocok', 'example' => 'The curtains match the carpet.'],
                ['phrase' => 'distinguish', 'level' => 'B2', 'meaning' => 'recognize or treat as different', 'meaning_id' => 'membedakan', 'example' => 'I can\'t distinguish the shades.'],
                ['phrase' => 'contrast', 'level' => 'B2', 'meaning' => 'differ strikingly', 'meaning_id' => 'kontras', 'example' => 'The dark blue contrasts with the white.']
            ],
             'animals' => [
                ['phrase' => 'inhabit', 'level' => 'C1', 'meaning' => 'live in', 'meaning_id' => 'menghuni', 'example' => 'Polar bears inhabit the Arctic.'],
                ['phrase' => 'migrate', 'level' => 'C1', 'meaning' => 'move from one region to another', 'meaning_id' => 'bermigrasi', 'example' => 'Birds migrate south in winter.'],
                ['phrase' => 'hunt', 'level' => 'B1', 'meaning' => 'pursue and kill for food', 'meaning_id' => 'berburu', 'example' => 'Lions hunt in packs.'],
                ['phrase' => 'breed', 'level' => 'B2', 'meaning' => 'mate and produce offspring', 'meaning_id' => 'berkembang biak', 'example' => 'Rabbits breed quickly.'],
                ['phrase' => 'survive', 'level' => 'B2', 'meaning' => 'continue to live', 'meaning_id' => 'bertahan hidup', 'example' => 'Only the strongest survive.'],
                ['phrase' => 'adapt', 'level' => 'B2', 'meaning' => 'become adjusted to new conditions', 'meaning_id' => 'beradaptasi', 'example' => 'Animals adapt to their environment.'],
                ['phrase' => 'graze', 'level' => 'C1', 'meaning' => 'eat grass in a field', 'meaning_id' => 'merumput', 'example' => 'Cattle graze in the meadow.'],
                ['phrase' => 'domesticate', 'level' => 'C1', 'meaning' => 'tame (an animal)', 'meaning_id' => 'menjinakkan', 'example' => 'Dogs were domesticated long ago.'],
                ['phrase' => 'protect', 'level' => 'B1', 'meaning' => 'keep safe from harm', 'meaning_id' => 'melindungi', 'example' => 'They protect their young.'],
                ['phrase' => 'prey', 'level' => 'C1', 'meaning' => 'hunt and kill for food', 'meaning_id' => 'memangsa', 'example' => 'Owls prey on mice.']
            ],
            'daily-routine' => [
                ['phrase' => 'prioritize', 'level' => 'B2', 'meaning' => 'designate or treat as more important', 'meaning_id' => 'memprioritaskan', 'example' => 'I prioritize my tasks every morning.'],
                ['phrase' => 'schedule', 'level' => 'B2', 'meaning' => 'arrange or plan', 'meaning_id' => 'menjadwalkan', 'example' => 'I scheduled a meeting.'],
                ['phrase' => 'organize', 'level' => 'B1', 'meaning' => 'arrange systematically', 'meaning_id' => 'mengorganisir', 'example' => 'I organize my desk daily.'],
                ['phrase' => 'wake', 'level' => 'A1', 'meaning' => 'emerge from sleep', 'meaning_id' => 'bangun', 'example' => 'I wake at 6 AM.'],
                ['phrase' => 'retire', 'level' => 'C1', 'meaning' => 'leave one\'s job or go to bed', 'meaning_id' => 'pensiun / tidur', 'example' => 'I retire to bed early.'],
                ['phrase' => 'repeat', 'level' => 'A2', 'meaning' => 'do again', 'meaning_id' => 'mengulangi', 'example' => 'I repeat this routine daily.'],
                ['phrase' => 'manage', 'level' => 'B2', 'meaning' => 'be in charge of', 'meaning_id' => 'mengatur', 'example' => 'I manage my time well.'],
                ['phrase' => 'accomplish', 'level' => 'B2', 'meaning' => 'achieve or complete', 'meaning_id' => 'mencapai', 'example' => 'I accomplished a lot today.'],
                ['phrase' => 'delay', 'level' => 'B1', 'meaning' => 'make late', 'meaning_id' => 'menunda', 'example' => 'Don\'t delay your work.'],
                ['phrase' => 'rush', 'level' => 'B2', 'meaning' => 'move with urgent haste', 'meaning_id' => 'terburu-buru', 'example' => 'I rushed to catch the bus.']
            ],
            'dictionaries' => [
                ['phrase' => 'translate', 'level' => 'B1', 'meaning' => 'express the sense of words in another language', 'meaning_id' => 'menerjemahkan', 'example' => 'Translate this sentence into English.'],
                ['phrase' => 'define', 'level' => 'B2', 'meaning' => 'state or describe the nature/meaning', 'meaning_id' => 'mendefinisikan', 'example' => 'Define the following terms.'],
                ['phrase' => 'pronounce', 'level' => 'B2', 'meaning' => 'make the sound of (a word)', 'meaning_id' => 'mengucapkan', 'example' => 'How do you pronounce this?'],
                ['phrase' => 'spell', 'level' => 'A1', 'meaning' => 'write or name the letters', 'meaning_id' => 'mengeja', 'example' => 'Spell your name, please.'],
                ['phrase' => 'interpret', 'level' => 'B2', 'meaning' => 'explain the meaning of', 'meaning_id' => 'menginterpretasikan', 'example' => 'Interpret the results.'],
                ['phrase' => 'consult', 'level' => 'C1', 'meaning' => 'seek information from', 'meaning_id' => 'berkonsultasi / merujuk', 'example' => 'Consult a dictionary.'],
                ['phrase' => 'comprehend', 'level' => 'C1', 'meaning' => 'grasp mentally', 'meaning_id' => 'memahami', 'example' => 'Comprehend the definition.'],
                ['phrase' => 'reference', 'level' => 'C1', 'meaning' => 'refer to', 'meaning_id' => 'merujuk', 'example' => 'Reference the index.'],
                ['phrase' => 'clarify', 'level' => 'C1', 'meaning' => 'make less confused and more clearly', 'meaning_id' => 'mengklarifikasi', 'example' => 'Clarify the meaning.'],
                ['phrase' => 'learn', 'level' => 'A1', 'meaning' => 'gain or acquire knowledge', 'meaning_id' => 'belajar', 'example' => 'I want to learn new words.']
            ],
            'gifts' => [
                ['phrase' => 'present', 'level' => 'B2', 'meaning' => 'give formally', 'meaning_id' => 'memberikan / mempersembahkan', 'example' => 'He presented the award.'],
                ['phrase' => 'receive', 'level' => 'A2', 'meaning' => 'be given or presented with', 'meaning_id' => 'menerima', 'example' => 'I received a lovely gift.'],
                ['phrase' => 'appreciate', 'level' => 'B2', 'meaning' => 'be grateful for', 'meaning_id' => 'menghargai', 'example' => 'I appreciate your kindness.'],
                ['phrase' => 'wrap', 'level' => 'B1', 'meaning' => 'cover or enclose in paper', 'meaning_id' => 'membungkus', 'example' => 'Wrap the present carefully.'],
                ['phrase' => 'exchange', 'level' => 'B1', 'meaning' => 'give and receive', 'meaning_id' => 'bertukar', 'example' => 'We exchanged gifts.'],
                ['phrase' => 'surprise', 'level' => 'B1', 'meaning' => 'give a shock', 'meaning_id' => 'memberi kejutan', 'example' => 'He surprised me with flowers.'],
                ['phrase' => 'donate', 'level' => 'B2', 'meaning' => 'give for a good cause', 'meaning_id' => 'menyumbangkan', 'example' => 'She donated money to charity.'],
                ['phrase' => 'select', 'level' => 'B2', 'meaning' => 'choose', 'meaning_id' => 'memilih', 'example' => 'Select a gift for him.'],
                ['phrase' => 'offer', 'level' => 'A2', 'meaning' => 'present for acceptance', 'meaning_id' => 'menawarkan', 'example' => 'She offered him a drink.'],
                ['phrase' => 'cherish', 'level' => 'C1', 'meaning' => 'protect and care for lovingly', 'meaning_id' => 'menghargai / menyayangi', 'example' => 'I cherish this gift.']
            ],
            'family-friends' => [
                ['phrase' => 'support', 'level' => 'B1', 'meaning' => 'give assistance to', 'meaning_id' => 'mendukung', 'example' => 'My family supports my decisions.'],
                ['phrase' => 'trust', 'level' => 'B1', 'meaning' => 'believe in the reliability of', 'meaning_id' => 'mempercayai', 'example' => 'I trust my best friend.'],
                ['phrase' => 'rely', 'level' => 'B2', 'meaning' => 'depend on with full trust', 'meaning_id' => 'mengandalkan', 'example' => 'You can rely on me.'],
                ['phrase' => 'bond', 'level' => 'B2', 'meaning' => 'establish a relationship', 'meaning_id' => 'menjalin ikatan', 'example' => 'We bonded over music.'],
                ['phrase' => 'socialize', 'level' => 'B2', 'meaning' => 'participate in social activities', 'meaning_id' => 'bersosialisasi', 'example' => 'I like to socialize with friends.'],
                ['phrase' => 'confide', 'level' => 'C1', 'meaning' => 'tell someone about a secret or private matter', 'meaning_id' => 'mencurahkan isi hati', 'example' => 'I confide in my sister.'],
                ['phrase' => 'reunite', 'level' => 'C1', 'meaning' => 'come together again', 'meaning_id' => 'beruni / bertemu kembali', 'example' => 'The family reunited for Christmas.'],
                ['phrase' => 'admire', 'level' => 'B1', 'meaning' => 'regard with respect', 'meaning_id' => 'mengagumi', 'example' => 'I admire my father.'],
                ['phrase' => 'argue', 'level' => 'B1', 'meaning' => 'exchange diverging or opposite views', 'meaning_id' => 'berdebat / bertengkar', 'example' => 'We rarely argue.'],
                ['phrase' => 'resolve', 'level' => 'B2', 'meaning' => 'settle or find a solution', 'meaning_id' => 'menyelesaikan', 'example' => 'We resolved our differences.']
            ],
            'weather' => [
                ['phrase' => 'forecast', 'level' => 'B2', 'meaning' => 'predict (weather)', 'meaning_id' => 'meramalkan (cuaca)', 'example' => 'Rain is forecasted for tomorrow.'],
                ['phrase' => 'pour', 'level' => 'B1', 'meaning' => 'rain heavily', 'meaning_id' => 'turun hujan deras', 'example' => 'It is pouring outside.'],
                ['phrase' => 'drizzle', 'level' => 'C2', 'meaning' => 'rain lightly', 'meaning_id' => 'gerimis', 'example' => 'It started to drizzle.'],
                ['phrase' => 'freeze', 'level' => 'A2', 'meaning' => 'turn to ice', 'meaning_id' => 'membeku', 'example' => 'The lake freezes in winter.'],
                ['phrase' => 'scorch', 'level' => 'C2', 'meaning' => 'burn surface with heat', 'meaning_id' => 'menghanguskan (panas terik)', 'example' => 'The sun scorched the land.'],
                ['phrase' => 'accumulate', 'level' => 'C1', 'meaning' => 'gather together', 'meaning_id' => 'terakumulasi', 'example' => 'Snow accumulated on the roof.'],
                ['phrase' => 'clear up', 'level' => 'B1', 'meaning' => 'become bright', 'meaning_id' => 'menjadi cerah', 'example' => 'The sky cleared up.'],
                ['phrase' => 'howl', 'level' => 'C1', 'meaning' => 'make a loud noise (wind)', 'meaning_id' => 'menderu (angin)', 'example' => 'The wind howled all night.'],
                ['phrase' => 'fluctuate', 'level' => 'C1', 'meaning' => 'change continually', 'meaning_id' => 'berfluktuasi', 'example' => 'Temperatures fluctuate wildly.'],
                ['phrase' => 'persist', 'level' => 'C1', 'meaning' => 'continue firmly', 'meaning_id' => 'bertahan / berlanjut', 'example' => 'The rain persisted all day.']
            ]
        ];

        $keys = array_keys($verbsMap);
        usort($keys, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($keys as $key) {
            if (str_contains($slug, $key)) {
                return $verbsMap[$key];
            }
        }

        return $commonVerbs;
    }

    public function getAdvancedAdjectivesForTopic($slug)
    {
        $commonAdjectives = [
            ['phrase' => 'crucial', 'level' => 'B2', 'meaning' => 'decisive or critical, especially in the success or failure of something', 'meaning_id' => 'sangat penting / krusial', 'example' => 'It is a crucial step.'],
            ['phrase' => 'beneficial', 'level' => 'B2', 'meaning' => 'favorable or advantageous', 'meaning_id' => 'bermanfaat', 'example' => 'The changes will be highly beneficial.'],
            ['phrase' => 'significant', 'level' => 'B2', 'meaning' => 'sufficiently great or important to be worthy of attention', 'meaning_id' => 'penting / signifikan', 'example' => 'A significant difference was observed.'],
            ['phrase' => 'diverse', 'level' => 'B2', 'meaning' => 'showing a great deal of variety', 'meaning_id' => 'beragam', 'example' => 'A culturally diverse population.'],
            ['phrase' => 'fundamental', 'level' => 'C1', 'meaning' => 'forming a necessary base or core', 'meaning_id' => 'mendasar / fundamental', 'example' => 'A fundamental change in approach.']
        ];

        $adjectivesMap = [
            'hometown' => [
                ['phrase' => 'picturesque', 'level' => 'B2', 'meaning' => 'visually attractive, especially in a quaint or charming way', 'meaning_id' => 'indah dipandang', 'example' => 'The village is picturesque.'],
                ['phrase' => 'bustling', 'level' => 'B2', 'meaning' => 'full of activity', 'meaning_id' => 'ramai / sibuk', 'example' => 'It is a bustling city.'],
                ['phrase' => 'tranquil', 'level' => 'C1', 'meaning' => 'free from disturbance; calm', 'meaning_id' => 'tenang', 'example' => 'I love the tranquil atmosphere.'],
                ['phrase' => 'historic', 'level' => 'B1', 'meaning' => 'famous or important in history', 'meaning_id' => 'bersejarah', 'example' => 'It has many historic buildings.'],
                ['phrase' => 'spacious', 'level' => 'B1', 'meaning' => 'having ample space', 'meaning_id' => 'luas', 'example' => 'The houses are spacious.'],
                ['phrase' => 'isolated', 'level' => 'B2', 'meaning' => 'far away from other places', 'meaning_id' => 'terisolasi / terpencil', 'example' => 'The town is somewhat isolated.'],
                ['phrase' => 'industrial', 'level' => 'B2', 'meaning' => 'relating to industry', 'meaning_id' => 'industri', 'example' => 'It is largely an industrial area.'],
                ['phrase' => 'cosmopolitan', 'level' => 'C1', 'meaning' => 'including people from many different countries', 'meaning_id' => 'kosmopolitan', 'example' => 'The city is very cosmopolitan.'],
                ['phrase' => 'vibrant', 'level' => 'B2', 'meaning' => 'full of energy and enthusiasm', 'meaning_id' => 'bersemangat (hidup)', 'example' => 'The nightlife is vibrant.'],
                ['phrase' => 'suburban', 'level' => 'B2', 'meaning' => 'dull and ordinary (or relating to suburbs)', 'meaning_id' => 'pinggiran kota', 'example' => 'It has a suburban feel.']
            ],
            'accommodation' => [
                ['phrase' => 'spacious', 'level' => 'B1', 'meaning' => 'having ample space', 'meaning_id' => 'luas', 'example' => 'The living room is very spacious.'],
                ['phrase' => 'cramped', 'level' => 'C1', 'meaning' => 'uncomfortably small or crowded', 'meaning_id' => 'sempit / sesak', 'example' => 'The apartment is a bit cramped.'],
                ['phrase' => 'cozy', 'level' => 'B2', 'meaning' => 'giving a feeling of comfort, warmth, and relaxation', 'meaning_id' => 'nyaman (homey)', 'example' => 'It is a small but cozy cottage.'],
                ['phrase' => 'luxurious', 'level' => 'C1', 'meaning' => 'extremely comfortable, elegant, or enjoyable', 'meaning_id' => 'mewah', 'example' => 'They stayed in a luxurious hotel.'],
                ['phrase' => 'dilapidated', 'level' => 'C2', 'meaning' => 'in a state of disrepair or ruin', 'meaning_id' => 'bobrok / rusak', 'example' => 'The old house is dilapidated.'],
                ['phrase' => 'airy', 'level' => 'B2', 'meaning' => 'spacious and well ventilated', 'meaning_id' => 'berventilasi baik / lega', 'example' => 'The room is light and airy.'],
                ['phrase' => 'furnished', 'level' => 'B2', 'meaning' => 'available to be rented with furniture', 'meaning_id' => 'berperabot', 'example' => 'We are looking for a furnished flat.'],
                ['phrase' => 'affordable', 'level' => 'B2', 'meaning' => 'inexpensive; reasonably priced', 'meaning_id' => 'terjangkau', 'example' => 'Housing here is affordable.'],
                ['phrase' => 'modern', 'level' => 'A1', 'meaning' => 'relating to the present or recent times', 'meaning_id' => 'modern', 'example' => 'The kitchen has modern appliances.'],
                ['phrase' => 'homely', 'level' => 'C1', 'meaning' => 'simple but cozy and comfortable', 'meaning_id' => 'nyaman seperti rumah', 'example' => 'The atmosphere was warm and homely.']
            ],
            'work' => [
                ['phrase' => 'monotonous', 'level' => 'B2', 'meaning' => 'dull, tedious, and repetitious', 'meaning_id' => 'monoton', 'example' => 'The work can be monotonous.'],
                ['phrase' => 'demanding', 'level' => 'B2', 'meaning' => 'requiring much skill or effort', 'meaning_id' => 'menuntut (sulit)', 'example' => 'It is a physically demanding job.'],
                ['phrase' => 'lucrative', 'level' => 'C1', 'meaning' => 'producing a great deal of profit', 'meaning_id' => 'menguntungkan', 'example' => 'He has a lucrative business.'],
                ['phrase' => 'hectic', 'level' => 'C1', 'meaning' => 'full of incessant or frantic activity', 'meaning_id' => 'sibuk sekali', 'example' => 'It was a hectic day.'],
                ['phrase' => 'rewarding', 'level' => 'B2', 'meaning' => 'providing satisfaction', 'meaning_id' => 'memuaskan', 'example' => 'Teaching is a rewarding career.'],
                ['phrase' => 'stressful', 'level' => 'B1', 'meaning' => 'causing mental or emotional stress', 'meaning_id' => 'membuat stres', 'example' => 'The job is very stressful.'],
                ['phrase' => 'collaborative', 'level' => 'C1', 'meaning' => 'produced by or involving two or more parties working together', 'meaning_id' => 'kolaboratif', 'example' => 'It was a collaborative effort.'],
                ['phrase' => 'flexible', 'level' => 'B2', 'meaning' => 'able to be easily modified', 'meaning_id' => 'fleksibel', 'example' => 'We have flexible working hours.'],
                ['phrase' => 'challenging', 'level' => 'B1', 'meaning' => 'testing one\'s abilities', 'meaning_id' => 'menantang', 'example' => 'It is a challenging role.'],
                ['phrase' => 'repetitive', 'level' => 'B2', 'meaning' => 'containing or characterized by repetition', 'meaning_id' => 'berulang-ulang', 'example' => 'Data entry is repetitive.']
            ],
            'study' => [
                ['phrase' => 'tedious', 'level' => 'B2', 'meaning' => 'too long, slow, or dull', 'meaning_id' => 'membosankan', 'example' => 'The lecture was tedious.'],
                ['phrase' => 'intellectual', 'level' => 'B2', 'meaning' => 'relating to the intellect', 'meaning_id' => 'intelektual', 'example' => 'The job requires intellectual ability.'],
                ['phrase' => 'prestigious', 'level' => 'B2', 'meaning' => 'inspiring respect and admiration', 'meaning_id' => 'bergengsi', 'example' => 'She attends a prestigious university.'],
                ['phrase' => 'academic', 'level' => 'B1', 'meaning' => 'relating to education and scholarship', 'meaning_id' => 'akademis', 'example' => 'He has a strong academic background.'],
                ['phrase' => 'theoretical', 'level' => 'C1', 'meaning' => 'concerned with the theory of a subject rather than its practical application', 'meaning_id' => 'teoretis', 'example' => 'The course is very theoretical.'],
                ['phrase' => 'practical', 'level' => 'B1', 'meaning' => 'relating to the actual doing or use of something', 'meaning_id' => 'praktis', 'example' => 'We need practical experience.'],
                ['phrase' => 'intensive', 'level' => 'B2', 'meaning' => 'concentrated on a single area or subject', 'meaning_id' => 'intensif', 'example' => 'It is an intensive course.'],
                ['phrase' => 'compulsory', 'level' => 'B2', 'meaning' => 'required by law or a rule', 'meaning_id' => 'wajib', 'example' => 'English is a compulsory subject.'],
                ['phrase' => 'optional', 'level' => 'B2', 'meaning' => 'available to be chosen but not obligatory', 'meaning_id' => 'opsional', 'example' => 'Music is an optional class.'],
                ['phrase' => 'vocational', 'level' => 'C1', 'meaning' => 'relating to an occupation or employment', 'meaning_id' => 'kejuruan', 'example' => 'He attends a vocational school.']
            ],
            'hobbies-interests' => [
                ['phrase' => 'engaging', 'level' => 'B2', 'meaning' => 'charming and attractive', 'meaning_id' => 'menarik', 'example' => 'It is an engaging hobby.'],
                ['phrase' => 'time-consuming', 'level' => 'B2', 'meaning' => 'taking a lot of time', 'meaning_id' => 'memakan waktu', 'example' => 'Painting can be time-consuming.'],
                ['phrase' => 'fascinating', 'level' => 'B1', 'meaning' => 'extremely interesting', 'meaning_id' => 'sangat menarik', 'example' => 'I find history fascinating.'],
                ['phrase' => 'creative', 'level' => 'A2', 'meaning' => 'relating to the use of imagination', 'meaning_id' => 'kreatif', 'example' => 'She is very creative.'],
                ['phrase' => 'relaxing', 'level' => 'A2', 'meaning' => 'making one feel relaxed', 'meaning_id' => 'menenangkan', 'example' => 'Gardening is relaxing.'],
                ['phrase' => 'active', 'level' => 'A2', 'meaning' => 'engaging in physical activity', 'meaning_id' => 'aktif', 'example' => 'He has an active lifestyle.'],
                ['phrase' => 'solitary', 'level' => 'C1', 'meaning' => 'done or existing alone', 'meaning_id' => 'sendirian / soliter', 'example' => 'Fishing is a solitary hobby.'],
                ['phrase' => 'social', 'level' => 'A2', 'meaning' => 'relating to society or organization', 'meaning_id' => 'sosial', 'example' => 'Dancing is a social activity.'],
                ['phrase' => 'expensive', 'level' => 'A1', 'meaning' => 'costing a lot of money', 'meaning_id' => 'mahal', 'example' => 'Golf can be expensive.'],
                ['phrase' => 'addictive', 'level' => 'B2', 'meaning' => 'causing someone to become addicted', 'meaning_id' => 'membuat ketagihan', 'example' => 'Video games can be addictive.']
            ],
            'travel-holidays' => [
                ['phrase' => 'scenic', 'level' => 'B2', 'meaning' => 'providing or relating to views of impressive or beautiful natural scenery', 'meaning_id' => 'pemandangan indah', 'example' => 'We took a scenic route.'],
                ['phrase' => 'exotic', 'level' => 'B2', 'meaning' => 'originating in or characteristic of a distant foreign country', 'meaning_id' => 'eksotis', 'example' => 'We tasted exotic fruits.'],
                ['phrase' => 'unspoiled', 'level' => 'C1', 'meaning' => 'not spoiled, in particular (of a place) not marred by development', 'meaning_id' => 'masih alami', 'example' => 'The island is relatively unspoiled.'],
                ['phrase' => 'memorable', 'level' => 'B2', 'meaning' => 'worth remembering', 'meaning_id' => 'berkesan', 'example' => 'It was a memorable trip.'],
                ['phrase' => 'breathtaking', 'level' => 'C1', 'meaning' => 'astonishing or awe-inspiring', 'meaning_id' => 'memukau', 'example' => 'The view was breathtaking.'],
                ['phrase' => 'luxurious', 'level' => 'C1', 'meaning' => 'extremely comfortable, elegant, or enjoyable', 'meaning_id' => 'mewah', 'example' => 'We stayed in a luxurious hotel.'],
                ['phrase' => 'remote', 'level' => 'B2', 'meaning' => 'situated far from the main centers of population', 'meaning_id' => 'terpencil', 'example' => 'We visited a remote village.'],
                ['phrase' => 'touristy', 'level' => 'C1', 'meaning' => 'full of or designed for tourists', 'meaning_id' => 'penuh turis', 'example' => 'The area is very touristy.'],
                ['phrase' => 'adventurous', 'level' => 'B2', 'meaning' => 'willing to take risks or to try out new methods', 'meaning_id' => 'berjiwa petualang', 'example' => 'He is an adventurous traveler.'],
                ['phrase' => 'cultural', 'level' => 'B1', 'meaning' => 'relating to the ideas, customs, and social behavior of a society', 'meaning_id' => 'budaya', 'example' => 'We enjoyed the cultural events.']
            ],
            'music' => [
                ['phrase' => 'harmonious', 'level' => 'B2', 'meaning' => 'tuneful; not discordant', 'meaning_id' => 'harmonis', 'example' => 'The melody is harmonious.'],
                ['phrase' => 'uplifting', 'level' => 'B2', 'meaning' => 'morally or spiritually elevating', 'meaning_id' => 'membangkitkan semangat', 'example' => 'The lyrics are uplifting.'],
                ['phrase' => 'deafening', 'level' => 'B2', 'meaning' => 'so loud as to make it impossible to hear anything else', 'meaning_id' => 'memekakkan telinga', 'example' => 'The music was deafening.'],
                ['phrase' => 'melodic', 'level' => 'C1', 'meaning' => 'of, having, or producing melody', 'meaning_id' => 'melodi / merdu', 'example' => 'It has a melodic sound.'],
                ['phrase' => 'rhythmic', 'level' => 'C1', 'meaning' => 'having or relating to rhythm', 'meaning_id' => 'berirama', 'example' => 'The drumming was rhythmic.'],
                ['phrase' => 'acoustic', 'level' => 'B2', 'meaning' => 'not having electrical amplification', 'meaning_id' => 'akustik', 'example' => 'I prefer acoustic guitar.'],
                ['phrase' => 'classical', 'level' => 'B1', 'meaning' => 'serious or conventional music', 'meaning_id' => 'klasik', 'example' => 'She plays classical piano.'],
                ['phrase' => 'contemporary', 'level' => 'B2', 'meaning' => 'belonging to or occurring in the present', 'meaning_id' => 'kontemporer', 'example' => 'We like contemporary jazz.'],
                ['phrase' => 'instrumental', 'level' => 'B2', 'meaning' => 'performed on instruments', 'meaning_id' => 'instrumental', 'example' => 'The song is instrumental.'],
                ['phrase' => 'vocal', 'level' => 'B2', 'meaning' => 'relating to the human voice', 'meaning_id' => 'vokal', 'example' => 'She has great vocal range.']
            ],
             'movies' => [
                ['phrase' => 'predictable', 'level' => 'B2', 'meaning' => 'able to be predicted', 'meaning_id' => 'mudah ditebak', 'example' => 'The ending was predictable.'],
                ['phrase' => 'hilarious', 'level' => 'B2', 'meaning' => 'extremely amusing', 'meaning_id' => 'sangat lucu', 'example' => 'The comedy was hilarious.'],
                ['phrase' => 'suspenseful', 'level' => 'C1', 'meaning' => 'arousing excited expectation or uncertainty', 'meaning_id' => 'menegangkan', 'example' => 'The thriller was suspenseful.'],
                ['phrase' => 'moving', 'level' => 'B2', 'meaning' => 'arousing strong emotion', 'meaning_id' => 'mengharukan', 'example' => 'It was a moving story.'],
                ['phrase' => 'dramatic', 'level' => 'B2', 'meaning' => 'relating to drama or the performance or study of drama', 'meaning_id' => 'dramatis', 'example' => 'The movie was very dramatic.'],
                ['phrase' => 'entertaining', 'level' => 'B1', 'meaning' => 'providing amusement or enjoyment', 'meaning_id' => 'menghibur', 'example' => 'It was an entertaining film.'],
                ['phrase' => 'violent', 'level' => 'B1', 'meaning' => 'using or involving physical force', 'meaning_id' => 'kekerasan', 'example' => 'Wait, some scenes were violent.'],
                ['phrase' => 'realistic', 'level' => 'B2', 'meaning' => 'representing familiar things in a way that is accurate or true to life', 'meaning_id' => 'realistis', 'example' => 'The effects were realistic.'],
                ['phrase' => 'informative', 'level' => 'B2', 'meaning' => 'providing useful or interesting information', 'meaning_id' => 'informatif', 'example' => 'The documentary was informative.'],
                ['phrase' => 'fictional', 'level' => 'B2', 'meaning' => 'related to fiction', 'meaning_id' => 'fiksi', 'example' => 'It is a fictional story.']
            ],
            'food-cooking' => [
                ['phrase' => 'nutritious', 'level' => 'B2', 'meaning' => 'nourishing; efficient as food', 'meaning_id' => 'bergizi', 'example' => 'Vegetables are very nutritious.'],
                ['phrase' => 'appetizing', 'level' => 'B2', 'meaning' => 'stimulating one\'s appetite', 'meaning_id' => 'menggugah selera', 'example' => 'The food looks appetizing.'],
                ['phrase' => 'delicious', 'level' => 'A1', 'meaning' => 'highly pleasant to the taste', 'meaning_id' => 'lezat', 'example' => 'The meal was delicious.'],
                ['phrase' => 'spicy', 'level' => 'A2', 'meaning' => 'flavored with or fragrant with spice', 'meaning_id' => 'pedas', 'example' => 'I like spicy food.'],
                ['phrase' => 'bitter', 'level' => 'B1', 'meaning' => 'having a sharp, pungent taste or smell', 'meaning_id' => 'pahit', 'example' => 'The coffee is bitter.'],
                ['phrase' => 'sweet', 'level' => 'A1', 'meaning' => 'having the pleasant taste characteristic of sugar', 'meaning_id' => 'manis', 'example' => 'The cake is too sweet.'],
                ['phrase' => 'crunchy', 'level' => 'B2', 'meaning' => 'making a sharp noise when bitten or crushed', 'meaning_id' => 'renyah', 'example' => 'The apple is crunchy.'],
                ['phrase' => 'creamy', 'level' => 'B1', 'meaning' => 'resembling or containing cream', 'meaning_id' => 'krim', 'example' => 'The soup is creamy.'],
                ['phrase' => 'salty', 'level' => 'A2', 'meaning' => 'tasting of, containing, or preserved with salt', 'meaning_id' => 'asin', 'example' => 'The fries are salty.'],
                ['phrase' => 'fresh', 'level' => 'A1', 'meaning' => 'recently made or obtained', 'meaning_id' => 'segar', 'example' => 'Buy fresh vegetables.']
            ],
            'sport' => [
                ['phrase' => 'exhausting', 'level' => 'B1', 'meaning' => 'making one feel very tired', 'meaning_id' => 'melelahkan', 'example' => 'The match was exhausting.'],
                ['phrase' => 'athletic', 'level' => 'B1', 'meaning' => 'physically strong, fit, and active', 'meaning_id' => 'atletis', 'example' => 'She is very athletic.'],
                ['phrase' => 'competitive', 'level' => 'B2', 'meaning' => 'relating to or characterized by competition', 'meaning_id' => 'kompetitif', 'example' => 'Sports are very competitive.'],
                ['phrase' => 'amateur', 'level' => 'B2', 'meaning' => 'engaging in a pursuit as a pastime rather than professionally', 'meaning_id' => 'amatir', 'example' => 'It is an amateur league.'],
                ['phrase' => 'professional', 'level' => 'B1', 'meaning' => 'engaged in a specified activity as one\'s main paid occupation', 'meaning_id' => 'profesional', 'example' => 'He is a professional player.'],
                ['phrase' => 'challenging', 'level' => 'B1', 'meaning' => 'testing one\'s abilities; endurance', 'meaning_id' => 'menantang', 'example' => 'The course is challenging.'],
                ['phrase' => 'rewarding', 'level' => 'B2', 'meaning' => 'providing satisfaction', 'meaning_id' => 'memuaskan', 'example' => 'Winning is rewarding.'],
                ['phrase' => 'skillful', 'level' => 'B2', 'meaning' => 'having or showing skill', 'meaning_id' => 'terampil', 'example' => 'He is a skillful player.'],
                ['phrase' => 'energetic', 'level' => 'B1', 'meaning' => 'showing or involving great activity or vitality', 'meaning_id' => 'energik', 'example' => 'The game was energetic.'],
                ['phrase' => 'intense', 'level' => 'C1', 'meaning' => 'of extreme force, degree, or strength', 'meaning_id' => 'intens', 'example' => 'The training is intense.']
            ],
            'technology' => [
                ['phrase' => 'innovative', 'level' => 'B2', 'meaning' => 'featuring new methods; advanced and original', 'meaning_id' => 'inovatif', 'example' => 'It is an innovative design.'],
                ['phrase' => 'obsolete', 'level' => 'C1', 'meaning' => 'no longer produced or used; out of date', 'meaning_id' => 'usang', 'example' => 'Walkmans are now obsolete.'],
                ['phrase' => 'advanced', 'level' => 'B1', 'meaning' => 'modern and recently developed', 'meaning_id' => 'canggih', 'example' => 'We use advanced technology.'],
                ['phrase' => 'efficient', 'level' => 'B2', 'meaning' => 'achieving maximum productivity', 'meaning_id' => 'efisien', 'example' => 'The new system is efficient.'],
                ['phrase' => 'digital', 'level' => 'A2', 'meaning' => 'using digits or discrete signals', 'meaning_id' => 'digital', 'example' => 'We live in a digital age.'],
                ['phrase' => 'automated', 'level' => 'C1', 'meaning' => 'operated by largely automatic equipment', 'meaning_id' => 'otomatis', 'example' => 'The process is automated.'],
                ['phrase' => 'complex', 'level' => 'B2', 'meaning' => 'consisting of many different and connected parts', 'meaning_id' => 'kompleks', 'example' => 'The algorithm is complex.'],
                ['phrase' => 'reliable', 'level' => 'B1', 'meaning' => 'consistently good in quality or performance', 'meaning_id' => 'dapat diandalkan', 'example' => 'The connection is reliable.'],
                ['phrase' => 'user-friendly', 'level' => 'B2', 'meaning' => 'easy to use or understand', 'meaning_id' => 'ramah pengguna', 'example' => 'The app is user-friendly.'],
                ['phrase' => 'cutting-edge', 'level' => 'C1', 'meaning' => 'at the most advanced stage of development', 'meaning_id' => 'terdepan / canggih', 'example' => 'It is cutting-edge tech.']
            ],
            'transportation' => [
                ['phrase' => 'congested', 'level' => 'B2', 'meaning' => 'blocked up with or too full of something', 'meaning_id' => 'macet / padat', 'example' => 'The roads are congested.'],
                ['phrase' => 'reliable', 'level' => 'B1', 'meaning' => 'consistently good in quality or performance', 'meaning_id' => 'dapat diandalkan', 'example' => 'Trains are reliable here.'],
                ['phrase' => 'efficient', 'level' => 'B2', 'meaning' => 'achieving maximum productivity', 'meaning_id' => 'efisien', 'example' => 'The metro is efficient.'],
                ['phrase' => 'affordable', 'level' => 'B2', 'meaning' => 'inexpensive; reasonably priced', 'meaning_id' => 'terjangkau', 'example' => 'Bus fares are affordable.'],
                ['phrase' => 'convenient', 'level' => 'B1', 'meaning' => 'fitting in well with a person\'s needs', 'meaning_id' => 'nyaman (strategis / praktis)', 'example' => 'A taxi is convenient.'],
                ['phrase' => 'rapid', 'level' => 'B2', 'meaning' => 'happening in a short time or at a fast pace', 'meaning_id' => 'cepat', 'example' => 'We have a rapid transit system.'],
                ['phrase' => 'comfortable', 'level' => 'A2', 'meaning' => 'providing physical ease', 'meaning_id' => 'nyaman', 'example' => 'The seats are comfortable.'],
                ['phrase' => 'crowded', 'level' => 'A2', 'meaning' => 'full of people', 'meaning_id' => 'ramai / penuh sesak', 'example' => 'The bus was crowded.'],
                ['phrase' => 'safe', 'level' => 'A1', 'meaning' => 'protected from or not exposed to danger', 'meaning_id' => 'aman', 'example' => 'Is it safe to drive?'],
                ['phrase' => 'eco-friendly', 'level' => 'B2', 'meaning' => 'not harmful to the environment', 'meaning_id' => 'ramah lingkungan', 'example' => 'Cyclng is eco-friendly.']
            ],
            'shopping' => [
                ['phrase' => 'extravagant', 'level' => 'C1', 'meaning' => 'lacking restraint in spending money', 'meaning_id' => 'boros', 'example' => 'It was an extravagant purchase.'],
                ['phrase' => 'expensive', 'level' => 'A1', 'meaning' => 'costing a lot', 'meaning_id' => 'mahal', 'example' => 'The bag is expensive.'],
                ['phrase' => 'cheap', 'level' => 'A1', 'meaning' => 'low in price', 'meaning_id' => 'murah', 'example' => 'The shoes were cheap.'],
                ['phrase' => 'affordable', 'level' => 'B2', 'meaning' => 'reasonably priced', 'meaning_id' => 'terjangkau', 'example' => 'The prices are affordable.'],
                ['phrase' => 'stylish', 'level' => 'B1', 'meaning' => 'fashionable and attractve', 'meaning_id' => 'bergaya', 'example' => 'It is a stylish coat.'],
                ['phrase' => 'trendy', 'level' => 'B2', 'meaning' => 'fashionable', 'meaning_id' => 'trendy', 'example' => 'He likes trendy shops.'],
                ['phrase' => 'impulsive', 'level' => 'C2', 'meaning' => 'acting or done without forethought', 'meaning_id' => 'impulsif', 'example' => 'It was an impulsive buy.'],
                ['phrase' => 'bargain', 'level' => 'B1', 'meaning' => 'a thing bought for less than the usual price', 'meaning_id' => 'murah / tawaran bagus', 'example' => 'This dress was a bargain.'],
                ['phrase' => 'exclusive', 'level' => 'C1', 'meaning' => 'restricted or limited to the person, group, or area concerned', 'meaning_id' => 'eksklusif', 'example' => 'An exclusive boutique.'],
                ['phrase' => 'essential', 'level' => 'B1', 'meaning' => 'absoutely necessary', 'meaning_id' => 'penting / pokok', 'example' => 'We bought essential items.']
            ],
            'clothes-fashion' => [
                ['phrase' => 'trendy', 'level' => 'B2', 'meaning' => 'very fashionable or up to date', 'meaning_id' => 'trendy / kekinian', 'example' => 'She wears trendy clothes.'],
                ['phrase' => 'immaculate', 'level' => 'C1', 'meaning' => 'perfectly clean, neat, or tidy', 'meaning_id' => 'sangat rapi / bersih', 'example' => 'His suit was immaculate.'],
                ['phrase' => 'stylish', 'level' => 'B1', 'meaning' => 'fashionable', 'meaning_id' => 'bergaya', 'example' => 'She looks very stylish.'],
                ['phrase' => 'casual', 'level' => 'A2', 'meaning' => 'relaxed and unconcerned', 'meaning_id' => 'santai', 'example' => 'I wear casual clothes.'],
                ['phrase' => 'formal', 'level' => 'B1', 'meaning' => 'done in accordance with rules', 'meaning_id' => 'formal', 'example' => 'It is a formal event.'],
                ['phrase' => 'elegant', 'level' => 'B2', 'meaning' => 'graceful and stylish', 'meaning_id' => 'elegan', 'example' => 'The dress is elegant.'],
                ['phrase' => 'loose', 'level' => 'B1', 'meaning' => 'not strictly fitted', 'meaning_id' => 'longgar', 'example' => 'I prefer loose clothing.'],
                ['phrase' => 'tight', 'level' => 'B1', 'meaning' => 'fixed, fastened, or closed firmly', 'meaning_id' => 'ketat', 'example' => 'The jeans are tight.'],
                ['phrase' => 'vintage', 'level' => 'C1', 'meaning' => 'denoting something of high quality from the past', 'meaning_id' => 'vintage / klasik', 'example' => 'She loves vintage fashion.'],
                ['phrase' => 'designer', 'level' => 'B2', 'meaning' => 'made by a famous designer', 'meaning_id' => 'desainer (bermerek)', 'example' => 'He wears designer labels.']
            ],
            'colors' => [
                ['phrase' => 'vivid', 'level' => 'B2', 'meaning' => 'producing powerful feelings or strong, clear images in the mind', 'meaning_id' => 'hidup / tajam', 'example' => 'The dress is a vivid red.'],
                ['phrase' => 'dull', 'level' => 'B1', 'meaning' => 'lacking brightness', 'meaning_id' => 'kusam', 'example' => 'The color is dull.'],
                ['phrase' => 'pastel', 'level' => 'C1', 'meaning' => 'of a soft and delicate shade or color', 'meaning_id' => 'pastel / lembut', 'example' => 'She likes pastel colors.'],
                ['phrase' => 'neutral', 'level' => 'B2', 'meaning' => 'having no strongly marked or positive characteristics', 'meaning_id' => 'netral', 'example' => 'Wear neutral colors.'],
                ['phrase' => 'bright', 'level' => 'A2', 'meaning' => 'giving out or reflecting a lot of light', 'meaning_id' => 'cerah', 'example' => 'It is a bright yellow.'],
                ['phrase' => 'dark', 'level' => 'A2', 'meaning' => 'with little or no light', 'meaning_id' => 'gelap', 'example' => 'Dark blue suits you.'],
                ['phrase' => 'monochromatic', 'level' => 'C2', 'meaning' => 'containing or using only one color', 'meaning_id' => 'monokromatik', 'example' => 'A monochromatic painting.'],
                ['phrase' => 'vibrant', 'level' => 'B2', 'meaning' => 'full of energy and enthusiasm', 'meaning_id' => 'cerah bersemangat', 'example' => 'Vibrant colors everywhere.'],
                ['phrase' => 'pale', 'level' => 'B2', 'meaning' => 'light in color or having little color', 'meaning_id' => 'pucat', 'example' => 'She wore a pale pink dress.'],
                ['phrase' => 'bold', 'level' => 'C1', 'meaning' => 'distinct; clear', 'meaning_id' => 'berani / mencolok', 'example' => 'He chose bold colors.']
            ],
             'animals' => [
                ['phrase' => 'tame', 'level' => 'B2', 'meaning' => '(of an animal) not dangerous or frightened of people', 'meaning_id' => 'jinak', 'example' => 'The bird is quite tame.'],
                ['phrase' => 'wild', 'level' => 'A2', 'meaning' => '(of an animal) living in a state of nature', 'meaning_id' => 'liar', 'example' => 'Wild animals roam here.'],
                ['phrase' => 'dangerous', 'level' => 'A2', 'meaning' => 'able or likely to cause harm', 'meaning_id' => 'berbahaya', 'example' => 'Some snakes are dangerous.'],
                ['phrase' => 'endangered', 'level' => 'B2', 'meaning' => 'seriously at risk of extinction', 'meaning_id' => 'terancam punah', 'example' => 'The panda is endangered.'],
                ['phrase' => 'nocturnal', 'level' => 'C1', 'meaning' => 'done, occurring, or active at night', 'meaning_id' => 'nokturnal', 'example' => 'Owls are nocturnal.'],
                ['phrase' => 'aquatic', 'level' => 'C1', 'meaning' => 'relating to water', 'meaning_id' => 'akuatik (air)', 'example' => 'Dolphins are aquatic animals.'],
                ['phrase' => 'carnivorous', 'level' => 'C1', 'meaning' => 'feeding on other animals', 'meaning_id' => 'karnivora', 'example' => 'Lions are carnivorous.'],
                ['phrase' => 'herbivorous', 'level' => 'C1', 'meaning' => 'feeding on plants', 'meaning_id' => 'herbivora', 'example' => 'Cows are herbivorous.'],
                ['phrase' => 'venomous', 'level' => 'C2', 'meaning' => '(of animals) secreting venom', 'meaning_id' => 'berbisa', 'example' => 'A venomous spider.'],
                ['phrase' => 'furry', 'level' => 'B1', 'meaning' => 'covered with fur', 'meaning_id' => 'berbulu', 'example' => 'A furry kitten.']
            ],
            'daily-routine' => [
                ['phrase' => 'mundane', 'level' => 'C1', 'meaning' => 'lacking interest or excitement; dull', 'meaning_id' => 'biasa-biasa saja', 'example' => 'I’m tired of my mundane routine.'],
                ['phrase' => 'productive', 'level' => 'B2', 'meaning' => 'achieving or producing a significant amount or result', 'meaning_id' => 'produktif', 'example' => 'It was a productive day.'],
                ['phrase' => 'regular', 'level' => 'A2', 'meaning' => 'done or happening frequently', 'meaning_id' => 'rutin / teratur', 'example' => 'I have a regular schedule.'],
                ['phrase' => 'flexible', 'level' => 'B2', 'meaning' => 'able to be easily modified', 'meaning_id' => 'fleksibel', 'example' => 'My routine is flexible.'],
                ['phrase' => 'strict', 'level' => 'B2', 'meaning' => 'demanding that rules concerning behavior are obeyed', 'meaning_id' => 'ketat', 'example' => 'He has a strict routine.'],
                ['phrase' => 'busy', 'level' => 'A1', 'meaning' => 'having a great deal to do', 'meaning_id' => 'sibuk', 'example' => 'I am very busy.'],
                ['phrase' => 'stressful', 'level' => 'B1', 'meaning' => 'causing mental or emotional stress', 'meaning_id' => 'membuat stres', 'example' => 'Mornings can be stressful.'],
                ['phrase' => 'monotonous', 'level' => 'B2', 'meaning' => 'dull, tedious, and repetitious', 'meaning_id' => 'monoton', 'example' => 'It gets monotonous.'],
                ['phrase' => 'balanced', 'level' => 'B2', 'meaning' => 'keeping or showing a balance', 'meaning_id' => 'seimbang', 'example' => 'A balanced lifestyle.'],
                ['phrase' => 'organized', 'level' => 'B1', 'meaning' => 'arranged in a systematic way', 'meaning_id' => 'terorganisir', 'example' => 'She is very organized.']
            ],
            'dictionaries' => [
                ['phrase' => 'comprehensive', 'level' => 'B2', 'meaning' => 'including or dealing with all or nearly all elements or aspects of something', 'meaning_id' => 'lengkap / komprehensif', 'example' => 'This is a comprehensive guide.'],
                ['phrase' => 'concise', 'level' => 'C1', 'meaning' => 'giving a lot of information clearly and in a few words', 'meaning_id' => 'ringkas', 'example' => 'A concise definition.'],
                ['phrase' => 'accurate', 'level' => 'B2', 'meaning' => 'correct in all details; exact', 'meaning_id' => 'akurat', 'example' => 'The translation is accurate.'],
                ['phrase' => 'detailed', 'level' => 'B1', 'meaning' => 'having many details', 'meaning_id' => 'terperinci', 'example' => 'A detailed explanation.'],
                ['phrase' => 'helpful', 'level' => 'A2', 'meaning' => 'giving or ready to give help', 'meaning_id' => 'membantu', 'example' => 'Dictionaries are helpful.'],
                ['phrase' => 'bilingual', 'level' => 'B2', 'meaning' => 'speaking two languages fluently', 'meaning_id' => 'dwibahasa', 'example' => 'A bilingual dictionary.'],
                ['phrase' => 'useful', 'level' => 'A2', 'meaning' => 'able to be used for a practical purpose', 'meaning_id' => 'berguna', 'example' => 'It is a useful tool.'],
                ['phrase' => 'essential', 'level' => 'B2', 'meaning' => 'absolutey necessary', 'meaning_id' => 'penting', 'example' => 'Good vocabulary is essential.'],
                ['phrase' => 'complex', 'level' => 'B2', 'meaning' => 'consisting of many different and connected parts', 'meaning_id' => 'kompleks', 'example' => 'The language is complex.'],
                ['phrase' => 'reliable', 'level' => 'B2', 'meaning' => 'consistently good in quality', 'meaning_id' => 'terpercaya', 'example' => 'Use a reliable source.']
            ],
            'gifts' => [
                ['phrase' => 'generous', 'level' => 'B2', 'meaning' => 'showing a readiness to give more of something', 'meaning_id' => 'murah hati', 'example' => 'It was a generous gift.'],
                ['phrase' => 'thoughtful', 'level' => 'B2', 'meaning' => 'showing anticipation of needs', 'meaning_id' => 'penuh perhatian', 'example' => 'A thoughtful present.'],
                ['phrase' => 'meaningful', 'level' => 'B2', 'meaning' => 'having a serious, important, or useful quality or purpose', 'meaning_id' => 'bermakna', 'example' => 'A meaningful gesture.'],
                ['phrase' => 'expensive', 'level' => 'A1', 'meaning' => 'costing a lot', 'meaning_id' => 'mahal', 'example' => 'An expensive watch.'],
                ['phrase' => 'handmade', 'level' => 'B1', 'meaning' => 'made by hand', 'meaning_id' => 'buatan tangan', 'example' => 'A handmade card.'],
                ['phrase' => 'practical', 'level' => 'B1', 'meaning' => 'relating to the actual doing or use of something', 'meaning_id' => 'praktis / berguna', 'example' => 'A practical gift.'],
                ['phrase' => 'personalized', 'level' => 'B2', 'meaning' => 'design or produce (something) to meet someone\'s individual requirements', 'meaning_id' => 'dibuat khusus (personal)', 'example' => 'A personalized mug.'],
                ['phrase' => 'unexpected', 'level' => 'B1', 'meaning' => 'not expected', 'meaning_id' => 'tak terduga', 'example' => 'An unexpected surprise.'],
                ['phrase' => 'valuable', 'level' => 'B1', 'meaning' => 'worth a great deal of money', 'meaning_id' => 'berharga', 'example' => 'A valuable antique.'],
                ['phrase' => 'precious', 'level' => 'B2', 'meaning' => 'of great value', 'meaning_id' => 'berharga / mulia', 'example' => 'A precious gem.']
            ],
            'family-friends' => [
                ['phrase' => 'supportive', 'level' => 'B2', 'meaning' => 'providing encouragement or emotional help', 'meaning_id' => 'mendukung', 'example' => 'She is very supportive.'],
                ['phrase' => 'loyal', 'level' => 'B2', 'meaning' => 'giving or showing firm and constant support', 'meaning_id' => 'setia', 'example' => 'A loyal friend.'],
                ['phrase' => 'trustworthy', 'level' => 'B2', 'meaning' => 'able to be relied on as honest or truthful', 'meaning_id' => 'dapat dipercaya', 'example' => 'He is trustworthy.'],
                ['phrase' => 'close', 'level' => 'B1', 'meaning' => 'on affectionate or intimate terms', 'meaning_id' => 'dekat', 'example' => 'We are very close.'],
                ['phrase' => 'distant', 'level' => 'B2', 'meaning' => 'not intimate; cool or reserved', 'meaning_id' => 'jauh (hubungan)', 'example' => 'A distant relative.'],
                ['phrase' => 'sociable', 'level' => 'B2', 'meaning' => 'willing to talk and engage in activities with others', 'meaning_id' => 'mudah bergaul', 'example' => 'He is very sociable.'],
                ['phrase' => 'introverted', 'level' => 'C1', 'meaning' => 'shy and reticent', 'meaning_id' => 'introvert / tertutup', 'example' => 'She is a bit introverted.'],
                ['phrase' => 'outgoing', 'level' => 'B2', 'meaning' => 'friendly and socially confident', 'meaning_id' => 'supel / ramah', 'example' => 'He has an outgoing personality.'],
                ['phrase' => 'nuclear', 'level' => 'C1', 'meaning' => 'relating to a nuclear family', 'meaning_id' => 'inti (keluarga)', 'example' => 'I live with my nuclear family.'],
                ['phrase' => 'extended', 'level' => 'C1', 'meaning' => 'related to an extended family', 'meaning_id' => 'besar (keluarga)', 'example' => 'My extended family lives nearby.']
            ],
            'transportation' => [
                ['phrase' => 'congested', 'level' => 'B2', 'meaning' => 'blocked up with traffic', 'meaning_id' => 'macet', 'example' => 'The city center is heavily congested.'],
                ['phrase' => 'accessible', 'level' => 'B2', 'meaning' => 'easy to reach', 'meaning_id' => 'mudah diakses', 'example' => 'The station is easily accessible.'],
                ['phrase' => 'efficient', 'level' => 'B2', 'meaning' => 'working well', 'meaning_id' => 'efisien', 'example' => 'The train service is efficient.'],
                ['phrase' => 'reliable', 'level' => 'B2', 'meaning' => 'consistently good', 'meaning_id' => 'dapat diandalkan', 'example' => 'Buses are not always reliable.'],
                ['phrase' => 'affordable', 'level' => 'B2', 'meaning' => 'inexpensive', 'meaning_id' => 'terjangkau', 'example' => 'We need affordable transport.'],
                ['phrase' => 'public', 'level' => 'A1', 'meaning' => 'open to or shared by all', 'meaning_id' => 'umum', 'example' => 'Public transport is vital.'],
                ['phrase' => 'private', 'level' => 'A2', 'meaning' => 'for the use of a single person or group', 'meaning_id' => 'pribadi', 'example' => 'He owns a private jet.'],
                ['phrase' => 'eco-friendly', 'level' => 'B2', 'meaning' => 'not harmful to the environment', 'meaning_id' => 'ramah lingkungan', 'example' => 'Electric cars are eco-friendly.'],
                ['phrase' => 'overcrowded', 'level' => 'B2', 'meaning' => 'filled with too many people', 'meaning_id' => 'terlalu padat', 'example' => 'The metro is often overcrowded.'],
                ['phrase' => 'scenic', 'level' => 'B2', 'meaning' => 'providing beaautiful views', 'meaning_id' => 'indah pemandangannya', 'example' => 'We took a scenic route.']
            ],
            'weather' => [
                ['phrase' => 'humid', 'level' => 'B1', 'meaning' => 'marked by a relatively high level of water vapor', 'meaning_id' => 'lembab', 'example' => 'It is very humid today.'],
                ['phrase' => 'overcast', 'level' => 'C2', 'meaning' => 'covered with clouds', 'meaning_id' => 'mendung', 'example' => 'The sky is overcast.'],
                ['phrase' => 'brisk', 'level' => 'C2', 'meaning' => 'cold but fresh and enlivening', 'meaning_id' => 'dingin segar', 'example' => 'A brisk wind is blowing.'],
                ['phrase' => 'torrential', 'level' => 'C2', 'meaning' => '(of rain) falling rapidly', 'meaning_id' => 'deras (hujan)', 'example' => 'Torrential rain fell.'],
                ['phrase' => 'sweltering', 'level' => 'C2', 'meaning' => 'uncomfortably hot', 'meaning_id' => 'panas terik', 'example' => 'It was a sweltering day.'],
                ['phrase' => 'gloomy', 'level' => 'B2', 'meaning' => 'dark or poorly lit', 'meaning_id' => 'suram / mendung gelap', 'example' => 'The weather is gloomy.'],
                ['phrase' => 'unpredictable', 'level' => 'B2', 'meaning' => 'not able to be foreseen', 'meaning_id' => 'tidak dapat diprediksi', 'example' => 'The weather is unpredictable.'],
                ['phrase' => 'severe', 'level' => 'B2', 'meaning' => 'very bad', 'meaning_id' => 'parah / ekstrem', 'example' => 'Severe storms are coming.'],
                ['phrase' => 'mild', 'level' => 'B1', 'meaning' => 'not severe', 'meaning_id' => 'ringan / sedang', 'example' => 'We have a mild winter.'],
                ['phrase' => 'breezy', 'level' => 'B2', 'meaning' => 'pleasantly windy', 'meaning_id' => 'berangin sepoi-sepoi', 'example' => 'It is a breezy afternoon.']
            ]
        ];

        $keys = array_keys($adjectivesMap);
        usort($keys, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($keys as $key) {
            if (str_contains($slug, $key)) {
                return $adjectivesMap[$key];
            }
        }

        return $commonAdjectives;
    }

}
