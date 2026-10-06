<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting9Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 9],
            [
                'title' => 'Inversi',
                'description' => 'Structure Meeting 9 - Inversion Patterns (Skills 15-19)',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Rarely _____ located near city lights or at lower elevations.',
                'option_a' => 'observatories are',
                'option_b' => 'are',
                'option_c' => 'in the observatories',
                'option_d' => 'are observatories',
                'correct_answer' => 'D',
                'explanation' => 'Inversi setelah kata keterangan negatif/restriktif di awal kalimat "Rarely" (Skill 17): kata kerja bantu/to be diletakkan sebelum subjek ("Rarely + are + observatories + located..."). Pilihan yang tepat adalah "are observatories" (D).',
            ],
            [
                'question_number' => 2,
                'question_text' => 'There are geographic, economic, and cultural reasons why _____ around the world.',
                'option_a' => 'diets differ',
                'option_b' => 'do diets differ',
                'option_c' => 'are diets different',
                'option_d' => 'to differ a diet',
                'correct_answer' => 'A',
                'explanation' => 'Pola susunan kata setelah question word "why" yang berfungsi sebagai penghubung klausa (connector), bukan kalimat tanya langsung (Skill 15): urutan kata harus tetap normal (Subjek + Verb: "diets differ"), bukan inversi. Pilihan yang tepat adalah "diets differ" (A).',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Were _____ millions of dollars each year replenishing eroding beaches, the coastline would be changing even more rapidly.',
                'option_a' => 'the U.S. Army Corps of Engineers not spending',
                'option_b' => 'the U.S. Army Corps of Engineers not spend',
                'option_c' => 'the U.S. Army Corps of Engineers does not spend',
                'option_d' => 'not spending the U.S. Army Corps of Engineers',
                'correct_answer' => 'A',
                'explanation' => 'Inversi kalimat pengandaian (conditional without "if") menggunakan "Were" (Skill 18): bentuk aslinya adalah "If the U.S. Army Corps of Engineers were not spending...". Ketika "if" dihilangkan, "Were" pindah ke depan subjek ("Were + Subject + not + V-ing"), sehingga pilihan yang tepat adalah (A).',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Nowhere _____ more skewed than in the auto industry.',
                'option_a' => 'that retail trade figures',
                'option_b' => 'retail trade figures are',
                'option_c' => 'are retail trade figures',
                'option_d' => 'retail trade figures',
                'correct_answer' => 'C',
                'explanation' => 'Inversi setelah kata negatif "Nowhere" di awal kalimat (Skill 17): kata kerja "are" harus mendahului subjek "retail trade figures" ("Nowhere are retail trade figures..."). Pilihan yang tepat adalah (C).',
            ],
            [
                'question_number' => 5,
                'question_text' => 'New York City\'s Central Park is nearly twice as large _____ second smallest country, Monaco.',
                'option_a' => 'as',
                'option_b' => 'is the',
                'option_c' => 'as is',
                'option_d' => 'as is the',
                'correct_answer' => 'D',
                'explanation' => 'Inversi dalam perbandingan (comparison) dengan pola "as + adj + as" (Skill 19): setelah kata pembanding "as", kata kerja "is" dapat mendahului subjek dengan article "the" ("as is the second smallest country, Monaco"). Pilihan yang tepat dan lengkap adalah (D).',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Potassium has a valence of positive one because it usually loses one electron when _____ with other elements.',
                'option_a' => 'does it combine',
                'option_b' => 'it combines',
                'option_c' => 'in combining',
                'option_d' => 'combination',
                'correct_answer' => 'B',
                'explanation' => 'Klausa adverbia waktu diawali connector "when" dalam kalimat pernyataan (bukan kalimat tanya langsung atau inversi): urutan kata harus normal dengan Subjek + Verb ("when it combines with other elements"). Pilihan yang tepat adalah "it combines" (B).',
            ],
            [
                'question_number' => 7,
                'question_text' => 'The economic background of labor legislation will not be mentioned in this course, _____ be treated.',
                'option_a' => 'trade unionism will not',
                'option_b' => 'nor trade unionism will',
                'option_c' => 'nor will trade unionism',
                'option_d' => 'neither trade unionism will',
                'correct_answer' => 'C',
                'explanation' => 'Inversi setelah kata penghubung negatif "nor" yang menghubungkan dua klausa negatif (Skill 17): pola yang baku adalah "nor + modal/auxiliary + Subject + Verb" ("nor will trade unionism be treated"). Pilihan yang tepat adalah (C).',
            ],
            [
                'question_number' => 8,
                'question_text' => '_____ test positive for antibiotics when tanker trucks arrive at a milk processing plant, according to federal law, the entire truckload must be discarded.',
                'option_a' => 'Should milk',
                'option_b' => 'If milk',
                'option_c' => 'If milk is',
                'option_d' => 'Milk should',
                'correct_answer' => 'A',
                'explanation' => 'Inversi conditional type 1 tanpa kata "if" menggunakan "Should" (Skill 18): bentuk aslinya adalah "If milk should test positive...". Ketika "if" dihilangkan, "Should" diletakkan di awal kalimat mendahului subjek ("Should milk test positive..."). Pilihan yang tepat adalah (A).',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Located behind _____ the two lacrimal glands.',
                'option_a' => 'each eyelid',
                'option_b' => 'is each eyelid',
                'option_c' => 'each eyelid are',
                'option_d' => 'each eyelid which is',
                'correct_answer' => 'C',
                'explanation' => 'Inversi dengan keterangan tempat di awal kalimat (place inversion, Skill 16): frasa tempat "Located behind each eyelid" mendahului kata kerja jamak "are" yang berpasangan dengan subjek jamak di akhir kalimat "the two lacrimal glands" ("Located behind each eyelid are the two lacrimal glands"). Pilihan yang tepat adalah (C).',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Only for a short period of time _____ run at top speed.',
                'option_a' => 'cheetahs',
                'option_b' => 'do cheetahs',
                'option_c' => 'that a cheetah can',
                'option_d' => 'can',
                'correct_answer' => 'B',
                'explanation' => 'Inversi setelah ekspresi restriktif "Only + keterangan waktu" di awal kalimat (Skill 17): memerlukan kata kerja bantu "do" mendahului subjek jamak "cheetahs" ("Only for a short period of time do cheetahs run at top speed"). Pilihan yang tepat adalah (B).',
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
