<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder2 extends Seeder
{
    public function run()
    {
        $topicIds = [8, 9, 10, 11, 12];
        DB::table('grammar_topic_questions')->whereIn('grammar_topic_id', $topicIds)->delete();

        $data = [];

        // Topic 8: Simple Past Tense
        $t8 = [];
        for ($i = 1; $i <= 20; $i++) {
            $t8[] = [
                'grammar_topic_id' => 8,
                'question_id' => "Saya <strong>pergi</strong> ke pasar kemarin (Kalimat $i).",
                'answer_en' => "I went to the market yesterday.",
                'vocab_helper' => json_encode(['pergi' => 'go/went', 'pasar' => 'market', 'kemarin' => 'yesterday']),
                'type' => 'sentence'
            ];
        }
        $t8[] = [
            'grammar_topic_id' => 8,
            'question_id' => "Kemarin, saya <strong>bangun</strong> pagi. Kemudian, saya <strong>makan</strong> sarapan dan <strong>pergi</strong> ke sekolah.",
            'answer_en' => "Yesterday, I woke up early. Then, I ate breakfast and went to school.",
            'vocab_helper' => json_encode(['bangun' => 'wake up/woke up', 'makan' => 'eat/ate', 'pergi' => 'go/went']),
            'type' => 'paragraph'
        ];

        // Topic 9: Simple Future Tense
        $t9 = [];
        for ($i = 1; $i <= 20; $i++) {
            $t9[] = [
                'grammar_topic_id' => 9,
                'question_id' => "Saya <strong>akan pergi</strong> ke Jakarta besok (Kalimat $i).",
                'answer_en' => "I will go to Jakarta tomorrow.",
                'vocab_helper' => json_encode(['akan' => 'will', 'pergi' => 'go', 'besok' => 'tomorrow']),
                'type' => 'sentence'
            ];
        }
        $t9[] = [
            'grammar_topic_id' => 9,
            'question_id' => "Besok, saya <strong>akan mengunjungi</strong> nenek saya. Kami <strong>akan memasak</strong> makanan enak bersama.",
            'answer_en' => "Tomorrow, I will visit my grandmother. We will cook delicious food together.",
            'vocab_helper' => json_encode(['akan mengunjungi' => 'will visit', 'akan memasak' => 'will cook']),
            'type' => 'paragraph'
        ];

        // Topic 10: Present Continuous Tense
        $t10 = [];
        for ($i = 1; $i <= 20; $i++) {
            $t10[] = [
                'grammar_topic_id' => 10,
                'question_id' => "Mereka <strong>sedang bermain</strong> sepak bola sekarang (Kalimat $i).",
                'answer_en' => "They are playing football now.",
                'vocab_helper' => json_encode(['sedang bermain' => 'are playing', 'sekarang' => 'now']),
                'type' => 'sentence'
            ];
        }
        $t10[] = [
            'grammar_topic_id' => 10,
            'question_id' => "Saat ini, ibu <strong>sedang memasak</strong> di dapur dan ayah <strong>sedang membaca</strong> koran.",
            'answer_en' => "Right now, mother is cooking in the kitchen and father is reading a newspaper.",
            'vocab_helper' => json_encode(['sedang memasak' => 'is cooking', 'sedang membaca' => 'is reading']),
            'type' => 'paragraph'
        ];

        // Topic 11: Kalimat Dasar
        $t11 = [];
        for ($i = 1; $i <= 20; $i++) {
            $t11[] = [
                'grammar_topic_id' => 11,
                'question_id' => "<strong>Apakah</strong> kamu seorang siswa? (Kalimat $i)",
                'answer_en' => "Are you a student?",
                'vocab_helper' => json_encode(['apakah' => 'are', 'siswa' => 'student']),
                'type' => 'sentence'
            ];
        }
        $t11[] = [
            'grammar_topic_id' => 11,
            'question_id' => "Dia adalah temanku. Dia <strong>tidak</strong> suka apel. <strong>Apakah</strong> dia suka jeruk?",
            'answer_en' => "He is my friend. He does not like apples. Does he like oranges?",
            'vocab_helper' => json_encode(['tidak suka' => 'does not like', 'apakah' => 'does']),
            'type' => 'paragraph'
        ];

        // Topic 12: Adverbs
        $t12 = [];
        for ($i = 1; $i <= 20; $i++) {
            $t12[] = [
                'grammar_topic_id' => 12,
                'question_id' => "Dia berlari <strong>dengan sangat cepat</strong> (Kalimat $i).",
                'answer_en' => "He runs very quickly.",
                'vocab_helper' => json_encode(['dengan cepat' => 'quickly', 'sangat' => 'very']),
                'type' => 'sentence'
            ];
        }
        $t12[] = [
            'grammar_topic_id' => 12,
            'question_id' => "Dia <strong>selalu</strong> bangun <strong>lebih awal</strong>. Kemudian, dia berjalan <strong>dengan pelan</strong> ke taman.",
            'answer_en' => "He always wakes up early. Then, he walks slowly to the park.",
            'vocab_helper' => json_encode(['selalu' => 'always', 'lebih awal' => 'early', 'dengan pelan' => 'slowly']),
            'type' => 'paragraph'
        ];

        $data = array_merge($t8, $t9, $t10, $t11, $t12);

        // Batch insert
        $chunks = array_chunk($data, 50);
        foreach ($chunks as $chunk) {
            DB::table('grammar_topic_questions')->insert($chunk);
        }
    }
}
