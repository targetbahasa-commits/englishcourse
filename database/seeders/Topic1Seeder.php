<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrammarTopic;
use App\Models\GrammarTopicQuestion;

class Topic1Seeder extends Seeder
{
    public function run()
    {
        $topic = GrammarTopic::find(1);
        if (!$topic) return;

        // Clear existing just in case
        $topic->questions()->delete();

        $sentences = [
            ["Mereka membaca buku <strong>besar</strong>.", "They read a big book.", ['membaca' => ['pos' => 'v', 'id' => 'read'], 'besar' => ['pos' => 'adj', 'id' => 'big']], ['id' => 'Saya makan apel merah.', 'en' => 'I eat a red apple.']],
            ["Anak <strong>pintar</strong> itu belajar setiap hari.", "The smart child studies every day.", ['pintar' => ['pos' => 'adj', 'id' => 'smart'], 'belajar' => ['pos' => 'v', 'id' => 'studies']], null],
            ["<strong>Dia (laki-laki)</strong> berlari <strong>cepat</strong>.", "He runs fast.", ['berlari' => ['pos' => 'v', 'id' => 'runs'], 'cepat' => ['pos' => 'adv', 'id' => 'fast']], null],
            ["Buku <strong>baru</strong> ini sangat <strong>menarik</strong>.", "This new book is very interesting.", ['baru' => ['pos' => 'adj', 'id' => 'new'], 'menarik' => ['pos' => 'adj', 'id' => 'interesting']], null],
            ["<strong>Kami</strong> selalu menulis surat.", "We always write letters.", ['menulis' => ['pos' => 'v', 'id' => 'write'], 'surat' => ['pos' => 'n', 'id' => 'letters']], null],
            ["Kucing hitam itu tidur nyenyak.", "The black cat sleeps soundly.", ['kucing' => ['pos' => 'n', 'id' => 'cat'], 'tidur' => ['pos' => 'v', 'id' => 'sleeps']], null],
            ["<strong>Dia (perempuan)</strong> memiliki mata <strong>indah</strong>.", "She has beautiful eyes.", ['memiliki' => ['pos' => 'v', 'id' => 'has'], 'indah' => ['pos' => 'adj', 'id' => 'beautiful']], null],
            ["Guru <strong>baik</strong> itu membantu murid-murid.", "The kind teacher helps the students.", ['baik' => ['pos' => 'adj', 'id' => 'kind'], 'membantu' => ['pos' => 'v', 'id' => 'helps']], null],
            ["Mereka bermain bola di lapangan.", "They play ball in the field.", ['bermain' => ['pos' => 'v', 'id' => 'play'], 'lapangan' => ['pos' => 'n', 'id' => 'field']], null],
            ["Mobil <strong>merah</strong> itu melaju kencang.", "The red car drives fast.", ['melaju' => ['pos' => 'v', 'id' => 'drives'], 'kencang' => ['pos' => 'adv', 'id' => 'fast']], null],
            ["Dia membeli sepatu <strong>mahal</strong>.", "He bought expensive shoes.", ['membeli' => ['pos' => 'v', 'id' => 'bought'], 'mahal' => ['pos' => 'adj', 'id' => 'expensive']], null],
            ["Air <strong>dingin</strong> ini sangat menyegarkan.", "This cold water is very refreshing.", ['dingin' => ['pos' => 'adj', 'id' => 'cold'], 'menyegarkan' => ['pos' => 'adj', 'id' => 'refreshing']], null],
            ["Saya melihat burung <strong>kecil</strong>.", "I see a small bird.", ['melihat' => ['pos' => 'v', 'id' => 'see'], 'kecil' => ['pos' => 'adj', 'id' => 'small']], null],
            ["Kamu adalah teman <strong>terbaik</strong> saya.", "You are my best friend.", ['teman' => ['pos' => 'n', 'id' => 'friend'], 'terbaik' => ['pos' => 'adj', 'id' => 'best']], null],
            ["Anjing itu menggonggong <strong>keras</strong>.", "The dog barks loudly.", ['menggonggong' => ['pos' => 'v', 'id' => 'barks'], 'keras' => ['pos' => 'adv', 'id' => 'loudly']], null],
            ["Tas <strong>berat</strong> ini milik saya.", "This heavy bag is mine.", ['berat' => ['pos' => 'adj', 'id' => 'heavy'], 'milik saya' => ['pos' => 'pron', 'id' => 'mine']], null],
            ["Mereka selalu <strong>bekerja keras</strong>.", "They always work hard.", ['bekerja' => ['pos' => 'v', 'id' => 'work'], 'keras' => ['pos' => 'adv', 'id' => 'hard']], null],
            ["Kue <strong>manis</strong> ini rasanya enak.", "This sweet cake tastes delicious.", ['manis' => ['pos' => 'adj', 'id' => 'sweet'], 'rasanya' => ['pos' => 'v', 'id' => 'tastes']], null],
            ["Dia sangat <strong>bahagia</strong> hari ini.", "She is very happy today.", ['bahagia' => ['pos' => 'adj', 'id' => 'happy'], 'hari ini' => ['pos' => 'adv', 'id' => 'today']], null],
            ["Langit biru terlihat sangat indah.", "The blue sky looks very beautiful.", ['langit' => ['pos' => 'n', 'id' => 'sky'], 'terlihat' => ['pos' => 'v', 'id' => 'looks']], null]
        ];

        foreach ($sentences as $idx => $s) {
            GrammarTopicQuestion::create([
                'grammar_topic_id' => $topic->id,
                'type' => 'sentence',
                'question_id' => $s[0],
                'answer_en' => $s[1],
                'vocab_helper' => $s[2],
                'example' => $s[3],
                'order' => $idx + 1
            ]);
        }

        GrammarTopicQuestion::create([
            'grammar_topic_id' => $topic->id,
            'type' => 'paragraph',
            'question_id' => '<strong>Saya</strong> memiliki teman <strong>baru</strong>. <strong>Dia</strong> adalah orang yang sangat <strong>baik</strong>. <strong>Kami</strong> sering <strong>bermain</strong> bersama setiap sore. <strong>Mereka</strong> juga bergabung dengan kami di lapangan.',
            'answer_en' => 'I have a new friend. He is a very kind person. We often play together every afternoon. They also join us in the field.',
            'vocab_helper' => [
                'teman' => ['pos' => 'n', 'id' => 'friend'],
                'baik' => ['pos' => 'adj', 'id' => 'kind'],
                'bermain' => ['pos' => 'v', 'id' => 'play'],
                'sore' => ['pos' => 'n', 'id' => 'afternoon'],
                'bergabung' => ['pos' => 'v', 'id' => 'join'],
                'lapangan' => ['pos' => 'n', 'id' => 'field']
            ],
            'example' => null,
            'order' => 21
        ]);
    }
}
