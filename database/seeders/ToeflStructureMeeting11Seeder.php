<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting11Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 11],
            [
                'title' => 'Comparative & Superlative',
                'description' => 'Structure Meeting 11 - Comparative & Superlative (Skills 27-29)',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'The speed of light is _____ the speed of sound.',
                'option_a' => 'faster',
                'option_b' => 'much faster than',
                'option_c' => 'the fastest',
                'option_d' => 'as fast',
                'correct_answer' => 'B',
                'explanation' => 'Perbandingan komparatif antara dua hal (Skill 27 & 28): kecepatan cahaya ("The speed of light") dibandingkan dengan kecepatan suara ("the speed of sound"). Bentuk komparatif dari "fast" adalah "faster", yang harus diikuti oleh kata "than" ("faster than"). Kata keterangan penguat "much" dapat diletakkan sebelum bentuk komparatif untuk menyatakan derajat perbandingan ("much faster than"). Pilihan (A) kurang kata "than", pilihan (C) berbentuk superlative padahal hanya membandingkan dua hal, dan pilihan (D) kurang kata "as" kedua ("as fast as"). Pilihan yang tepat dan lengkap adalah (B).',
            ],
            [
                'question_number' => 2,
                'question_text' => 'The use of detail is _____ method of developing a controlling idea, and almost all students employ this method.',
                'option_a' => 'more common',
                'option_b' => 'common',
                'option_c' => 'most common',
                'option_d' => 'the most common',
                'correct_answer' => 'D',
                'explanation' => 'Bentuk superlatif (Skill 27 & 28): kalimat kedua menyatakan bahwa hampir semua siswa menggunakan metode ini ("almost all students employ this method"), yang menunjukkan bahwa metode ini adalah yang paling lazim digunakan di antara semua metode (konteks superlative). Kata sifat bersuku kata banyak "common" membentuk superlative dengan "the most common". Pilihan (A) berbentuk komparatif, pilihan (B) bentuk positif tanpa article "a", dan pilihan (C) tidak memiliki definite article "the". Pilihan yang tepat dan lengkap adalah (D).',
            ],
            [
                'question_number' => 3,
                'question_text' => '_____ in Stevenson\'s landscapes, the more vitality and character the paintings seem to possess.',
                'option_a' => 'The brushwork is loose',
                'option_b' => 'The looser brushwork',
                'option_c' => 'The loose brushwork is',
                'option_d' => 'The looser the brushwork is',
                'correct_answer' => 'D',
                'explanation' => 'Pola parallel comparative / double comparative berpasangan (Skill 29): pola kalimat ini memiliki rumus "The + comparative (+ Subjek + Verb), the + comparative (+ Subjek + Verb)". Klausa kedua berbunyi "the more vitality and character the paintings seem to possess", sehingga klausa pertama harus paralel diawali "The" + comparative ("looser") + Subjek ("the brushwork") + Verb ("is"), yaitu "The looser the brushwork is" (D).',
            ],
            [
                'question_number' => 4,
                'question_text' => '<span class="error-option" data-label="A">Certain types</span> of snakes have been known to survive fasts more <span class="error-option" data-label="B">as</span> a <span class="error-option" data-label="C">year</span> <span class="error-option" data-label="D">long</span>.',
                'option_a' => 'Certain types',
                'option_b' => 'as',
                'option_c' => 'year',
                'option_d' => 'long',
                'correct_answer' => 'B',
                'explanation' => 'Pembentukan komparatif (Skill 27): kata pembanding komparatif "more" harus dipasangkan dengan kata "than", bukan "as" ("more than a year long"). Bentuk "more as" tidak baku dalam perbandingan bahasa Inggris. Perbaikan: "as" diganti menjadi "than". Kunci: (B).',
            ],
            [
                'question_number' => 5,
                'question_text' => 'The grizzly bear, <span class="error-option" data-label="A">which</span> can grow <span class="error-option" data-label="B">up to eight feet</span> tall, has <span class="error-option" data-label="C">been called</span> <span class="error-option" data-label="D">a more</span> dangerous animal of North America.',
                'option_a' => 'which',
                'option_b' => 'up to eight feet',
                'option_c' => 'been called',
                'option_d' => 'a more',
                'correct_answer' => 'D',
                'explanation' => 'Penggunaan superlative (Skill 28): frasa "of North America" menunjukkan cakupan keseluruhan wilayah yang melibatkan banyak binatang (lebih dari dua), sehingga derajat yang digunakan harus superlative, bukan comparative "a more". Bentuk yang tepat adalah "the most" ("the most dangerous animal of North America"). Perbaikan: "a more" diganti menjadi "the most". Kunci: (D).',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Climate, soil type, and availability of water are the most critical factors <span class="error-option" data-label="A">than</span> <span class="error-option" data-label="B">selecting</span> <span class="error-option" data-label="C">the best</span> type of <span class="error-option" data-label="D">grass</span> for a lawn.',
                'option_a' => 'than',
                'option_b' => 'selecting',
                'option_c' => 'the best',
                'option_d' => 'grass',
                'correct_answer' => 'A',
                'explanation' => 'Struktur komparatif vs superlatif (Skill 27 & 28): kata penghubung "than" hanya digunakan setelah derajat perbandingan komparatif (misalnya "more critical than"), bukan setelah bentuk superlatif "the most critical factors". Pada kalimat ini, konteksnya menyatakan faktor paling krusial dalam memilih rumput, sehingga kata "than" keliru dan seharusnya diganti dengan kata depan "in" ("the most critical factors in selecting..."). Perbaikan: "than" diganti menjadi "in". Kunci: (A).',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Peter Abelard, <span class="error-option" data-label="A">a logician and theologian</span>, was <span class="error-option" data-label="B">the</span> <span class="error-option" data-label="C">controversialest</span> teacher <span class="error-option" data-label="D">of his age</span>.',
                'option_a' => 'a logician and theologian',
                'option_b' => 'the',
                'option_c' => 'controversialest',
                'option_d' => 'of his age',
                'correct_answer' => 'C',
                'explanation' => 'Pembentukan bentuk superlatif yang benar (Skill 27): kata sifat yang memiliki lebih dari dua suku kata seperti "controversial" (5 suku kata) membentuk superlative dengan menambahkan kata "most" di depannya ("the most controversial"), bukan dengan menambahkan akhiran "-est" ("controversialest"). Akhiran "-est" hanya digunakan untuk kata sifat bersuku kata satu atau dua berakhiran "-y". Perbaikan: "controversialest" diganti menjadi "most controversial". Kunci: (C).',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Protein molecules <span class="error-option" data-label="A">are</span> <span class="error-option" data-label="B">the most complex</span> <span class="error-option" data-label="C">than</span> the <span class="error-option" data-label="D">molecules</span> of carbohydrates.',
                'option_a' => 'are',
                'option_b' => 'the most complex',
                'option_c' => 'than',
                'option_d' => 'molecules',
                'correct_answer' => 'B',
                'explanation' => 'Penggunaan komparatif vs superlatif (Skill 28): kalimat ini membandingkan dua kelompok entitas ("Protein molecules" dan "the molecules of carbohydrates") yang dihubungkan oleh kata pembanding "than". Oleh karena itu, tingkat perbandingan yang harus digunakan adalah comparative ("more complex"), bukan superlative ("the most complex"). Superlative tidak dapat dipasangkan dengan "than". Perbaikan: "the most complex" diganti menjadi "more complex". Kunci: (B).',
            ],
            [
                'question_number' => 9,
                'question_text' => 'The <span class="error-option" data-label="A">leek, a member</span> of the lily <span class="error-option" data-label="B">family</span>, has a <span class="error-option" data-label="C">mildest</span> taste <span class="error-option" data-label="D">than</span> the onion.',
                'option_a' => 'leek, a member',
                'option_b' => 'family',
                'option_c' => 'mildest',
                'option_d' => 'than',
                'correct_answer' => 'C',
                'explanation' => 'Penggunaan komparatif vs superlatif (Skill 28): kalimat ini membandingkan rasa antara dua jenis tanaman ("The leek" dan "the onion") dengan penanda perbandingan "than". Karena hanya dua hal yang diperbandingkan, bentuk yang harus digunakan adalah komparatif yaitu "milder" ("a milder taste than"), bukan superlatif "mildest". Perbaikan: "mildest" diganti menjadi "milder". Kunci: (C).',
            ],
            [
                'question_number' => 10,
                'question_text' => '<span class="error-option" data-label="A">The widely</span> <span class="error-option" data-label="B">used</span> natural <span class="error-option" data-label="C">fiber</span> of all <span class="error-option" data-label="D">is</span> cotton.',
                'option_a' => 'The widely',
                'option_b' => 'used',
                'option_c' => 'fiber',
                'option_d' => 'is',
                'correct_answer' => 'A',
                'explanation' => 'Pembentukan bentuk superlatif dengan frasa "of all" (Skill 28): keberadaan penjelas "of all" (dari semua serat alami) mengindikasikan perbandingan lebih dari dua entitas yang mensyaratkan bentuk superlatif. Bentuk superlatif untuk frasa adverbial "widely used" adalah "The most widely used", bukan "The widely used". Perbaikan: "The widely" diganti menjadi "The most widely". Kunci: (A).',
            ],
        ];

        foreach ($questions as $q) {
            \App\Models\ToeflStructureQuestion::create([
                'section_id' => $meeting->id,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
                'explanation' => $q['explanation'] ?? null,
            ]);
        }
    }
}
