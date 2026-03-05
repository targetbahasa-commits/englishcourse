<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrammarWritingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Meeting 1 Questions Data (from AssignmentController)
        $questions = [
            1 => ['id' => 'Aku belajar di Selandia Baru.', 'en' => 'I study in New Zealand', 'example' => ['id' => 'Saya tinggal di Jakarta.', 'en' => 'I live in Jakarta.'], 'vocab' => ['Study' => ['id' => 'Belajar', 'pos' => '(v)'], 'New Zealand' => ['id' => 'Selandia Baru', 'pos' => '(n)']]],
            2 => ['id' => 'Dosen menanyaiku.', 'en' => 'The lecturer asks me', 'example' => ['id' => 'Ibuku memanggilku.', 'en' => 'My mother calls me.'], 'vocab' => ['Lecturer' => ['id' => 'Dosen', 'pos' => '(n)'], 'Ask' => ['id' => 'Menanyai/Bertanya', 'pos' => '(v)']]],
            3 => ['id' => 'Negaraku memiliki simbol.', 'en' => 'My country has a symbol', 'example' => ['id' => 'Rumahku memiliki taman.', 'en' => 'My house has a garden.'], 'vocab' => ['Country' => ['id' => 'Negara', 'pos' => '(n)'], 'Symbol' => ['id' => 'Simbol', 'pos' => '(n)']]],
            4 => ['id' => 'Kamu mengajukan solusi.', 'en' => 'You propose a solution', 'example' => ['id' => 'Kamu membawa buku.', 'en' => 'You bring a book.'], 'vocab' => ['Propose' => ['id' => 'Mengajukan', 'pos' => '(v)'], 'Solution' => ['id' => 'Solusi', 'pos' => '(n)']]],
            5 => ['id' => 'Aku memanggilmu.', 'en' => 'I call you', 'example' => ['id' => 'Aku mencintaimu.', 'en' => 'I love you.'], 'vocab' => ['Call' => ['id' => 'Memanggil', 'pos' => '(v)']]],
            6 => ['id' => 'Negaramu memiliki banyak pulau.', 'en' => 'Your country has many islands', 'example' => ['id' => 'Mobilmu memiliki empat roda.', 'en' => 'Your car has four wheels.'], 'vocab' => ['Island' => ['id' => 'Pulau', 'pos' => '(n)'], 'Many' => ['id' => 'Banyak', 'pos' => '(adj)']]],
            7 => ['id' => 'Kami berkumpul.', 'en' => 'We gather', 'example' => ['id' => 'Kami makan.', 'en' => 'We eat.'], 'vocab' => ['Gather' => ['id' => 'Berkumpul', 'pos' => '(v)']]],
            8 => ['id' => 'Kamu membantu kami.', 'en' => 'You help us', 'example' => ['id' => 'Mereka mengundang kami.', 'en' => 'They invite us.'], 'vocab' => ['Help' => ['id' => 'Membantu', 'pos' => '(v)']]],
            9 => ['id' => 'Tugas kami selesai.', 'en' => 'Our task is finished', 'example' => ['id' => 'Pekerjaan kami selesai.', 'en' => 'Our work is done.'], 'vocab' => ['Task' => ['id' => 'Tugas', 'pos' => '(n)'], 'Finished' => ['id' => 'Selesai', 'pos' => '(adj)']]],
            10 => ['id' => 'Mereka pergi.', 'en' => 'They go', 'example' => ['id' => 'Mereka tidur.', 'en' => 'They sleep.'], 'vocab' => ['Go' => ['id' => 'Pergi', 'pos' => '(v)']]],
            11 => ['id' => 'Aku melihat mereka.', 'en' => 'I see them', 'example' => ['id' => 'Aku kenal mereka.', 'en' => 'I know them.'], 'vocab' => ['See' => ['id' => 'Melihat', 'pos' => '(v)']]],
            12 => ['id' => 'Hukum mereka melindungi.', 'en' => 'Their law protects', 'example' => ['id' => 'Rencana mereka berhasil.', 'en' => 'Their plan works.'], 'vocab' => ['Law' => ['id' => 'Hukum', 'pos' => '(n)'], 'Protect' => ['id' => 'Melindungi', 'pos' => '(v)']]],
            13 => ['id' => 'Dia(laki-laki) mengemudi.', 'en' => 'He drives', 'example' => ['id' => 'Dia berlari.', 'en' => 'He runs.'], 'vocab' => ['Drive' => ['id' => 'Mengemudi', 'pos' => '(v)']]],
            14 => ['id' => 'Temanku melihatnya(laki-laki).', 'en' => 'My friend sees him', 'example' => ['id' => 'Aku menyukainya.', 'en' => 'I like him.'], 'vocab' => ['Friend' => ['id' => 'Teman', 'pos' => '(n)']]],
            15 => ['id' => 'Aku pinjam bukunya(laki-laki).', 'en' => 'I borrow his book', 'example' => ['id' => 'Aku menggunakan penanya.', 'en' => 'I use his pen.'], 'vocab' => ['Borrow' => ['id' => 'Meminjam', 'pos' => '(v)'], 'Book' => ['id' => 'Buku', 'pos' => '(n)']]],
            16 => ['id' => 'Dia(perempuan) bekerja.', 'en' => 'She works', 'example' => ['id' => 'Dia bernyanyi.', 'en' => 'She sings.'], 'vocab' => ['Work' => ['id' => 'Bekerja', 'pos' => '(v)']]],
            17 => ['id' => 'Walikota menemuinya(perempuan).', 'en' => 'The mayor meets her', 'example' => ['id' => 'Guru mengajarnya.', 'en' => 'The teacher teaches her.'], 'vocab' => ['Mayor' => ['id' => 'Walikota', 'pos' => '(n)'], 'Meet' => ['id' => 'Menemui/Bertemu', 'pos' => '(v)']]],
            18 => ['id' => 'Aku kenal wajahnya(perempuan).', 'en' => 'I know her face', 'example' => ['id' => 'Aku suka gayanya.', 'en' => 'I like her style.'], 'vocab' => ['Know' => ['id' => 'Kenal/Tahu', 'pos' => '(v)'], 'Face' => ['id' => 'Wajah', 'pos' => '(n)']]],
            19 => ['id' => 'Dia(bukan manusia) hidup di air.', 'en' => 'It lives in water', 'example' => ['id' => 'Dia makan rumput.', 'en' => 'It eats grass.'], 'vocab' => ['Live' => ['id' => 'Hidup/Tinggal', 'pos' => '(v)'], 'Water' => ['id' => 'Air', 'pos' => '(n)']]],
            20 => ['id' => 'Kamu menangkapnya(bukan manusia).', 'en' => 'You catch it', 'example' => ['id' => 'Aku membelinya.', 'en' => 'I buy it.'], 'vocab' => ['Catch' => ['id' => 'Menangkap', 'pos' => '(v)']]],
            21 => ['id' => 'Aku suka warnanya(bukan manusia).', 'en' => 'I like its color', 'example' => ['id' => 'Aku melihat ekornya.', 'en' => 'I see its tail.'], 'vocab' => ['Like' => ['id' => 'Suka', 'pos' => '(v)'], 'Color' => ['id' => 'Warna', 'pos' => '(n)'], ]]
        ];

        foreach ($questions as $num => $q) {
            \App\Models\GrammarQuestion::firstOrCreate(
                [
                    'meeting_number' => 1,
                    'question_number' => $num
                ],
                [
                    'question_text' => $q['id'],
                    'correct_answer' => $q['en'],
                    'example_id' => $q['example']['id'] ?? null,
                    'example_en' => $q['example']['en'] ?? null,
                    'vocab' => $q['vocab'] ?? null
                ]
            );
        }

        // Meeting 1 Vocab Data
        $vocabList = [
            'Mother' => ['id' => 'Ibu', 'pos' => '(n)'],
            'Chef' => ['id' => 'Koki', 'pos' => '(n)'],
            'Cook' => ['id' => 'Memasak', 'pos' => '(v)'],
            'Food' => ['id' => 'Makanan', 'pos' => '(n)'],
            'Various' => ['id' => 'Berbagai', 'pos' => '(adj)'],
            'Event' => ['id' => 'Acara', 'pos' => '(n)'],
            'Like' => ['id' => 'Seperti', 'pos' => '(prep)'],
            'Birthday party' => ['id' => 'Pesta ulang tahun', 'pos' => '(n)'],
            'Wedding' => ['id' => 'Pernikahan', 'pos' => '(n)'],
            'Cooking' => ['id' => 'Masakan', 'pos' => '(n)'],
            'Very' => ['id' => 'Sangat', 'pos' => '(adv)'],
            'Delicious' => ['id' => 'Enak', 'pos' => '(adj)'],
            'So' => ['id' => 'Sehingga', 'pos' => '(conj)'],
            'Many' => ['id' => 'Banyak', 'pos' => '(adj)'],
            'People' => ['id' => 'Orang', 'pos' => '(n)'],
            'Like (verb)' => ['id' => 'Menyukai', 'pos' => '(v)'],
            'Work' => ['id' => 'Bekerja', 'pos' => '(v)'],
            'With' => ['id' => 'Dengan', 'pos' => '(prep)'],
            'Passion' => ['id' => 'Semangat', 'pos' => '(n)'],
            'Always' => ['id' => 'Selalu', 'pos' => '(adv)'],
            'Maintain' => ['id' => 'Menjaga', 'pos' => '(v)'],
            'Quality' => ['id' => 'Kualitas', 'pos' => '(n)'],
            'Every day' => ['id' => 'Setiap hari', 'pos' => '(adv)'],
            'Customer' => ['id' => 'Pelanggan', 'pos' => '(n)'],
            'Order' => ['id' => 'Memesan', 'pos' => '(v)'],
            'From' => ['id' => 'Dari', 'pos' => '(prep)']
        ];

        foreach ($vocabList as $word => $data) {
            \App\Models\GrammarVocabulary::firstOrCreate(
                [
                    'meeting_number' => 1,
                    'word' => $word,
                    'section' => 'global'
                ],
                [
                    'translation' => $data['id'],
                    'pos' => $data['pos']
                ]
            );
        }
    }
}
