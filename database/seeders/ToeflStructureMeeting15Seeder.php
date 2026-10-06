<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting15Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 15],
            [
                'title' => 'Other, Another, and Others',
                'description' => 'Structure Meeting 15 - Distinguish Other, Another, and Others (Skill 60)',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => '<span class="error-option" data-label="A">Other</span> <span class="error-option" data-label="B">interesting</span> aspect of tachistopic training in recent years <span class="error-option" data-label="C">has been</span> the newfound <span class="error-option" data-label="D">use</span> by professional teams.',
                'option_a' => 'Other',
                'option_b' => 'interesting',
                'option_c' => 'has been',
                'option_d' => 'use',
                'correct_answer' => 'A',
                'explanation' => 'Membedakan "another" dan "other" (Skill 60): Kata benda "aspect" adalah kata benda tunggal dapat dihitung (singular countable noun) yang bersifat tak tentu (indefinite). Kata "other" tanpa determiner hanya digunakan untuk kata benda jamak ("other aspects") atau tak terhitung. Untuk menerangkan kata benda tunggal tak tentu ("interesting aspect"), kata yang wajib digunakan adalah "Another" (an + other). Perbaikan: "Other" diganti menjadi "Another". Kunci: (A).',
            ],
            [
                'question_number' => 2,
                'question_text' => 'The waitress <span class="error-option" data-label="A">will bring</span> you <span class="error-option" data-label="B">the another</span> bowl <span class="error-option" data-label="C">of soup</span> if you <span class="error-option" data-label="D">want</span>.',
                'option_a' => 'will bring',
                'option_b' => 'the another',
                'option_c' => 'of soup',
                'option_d' => 'want',
                'correct_answer' => 'B',
                'explanation' => 'Larangan menggabungkan "the" dan "another" (Skill 60): Kata "another" berasal dari penggabungan artikel tak tentu "an + other", sehingga tidak boleh didahului lagi oleh artikel tentu "the" ("the another" tidak pernah ada dalam bahasa Inggris). Untuk menyatakan satu mangkuk lagi secara tak tentu gunakan "another", atau jika spesifik gunakan "the other". Perbaikan: "the another" diganti menjadi "another". Kunci: (B).',
            ],
            [
                'question_number' => 3,
                'question_text' => 'It is <span class="error-option" data-label="A">difficult</span> to find <span class="error-option" data-label="B">others</span> workers who <span class="error-option" data-label="C">are willing</span> to work <span class="error-option" data-label="D">such long</span> hours.',
                'option_a' => 'difficult',
                'option_b' => 'others',
                'option_c' => 'are willing',
                'option_d' => 'such long',
                'correct_answer' => 'B',
                'explanation' => 'Membedakan kata sifat "other" dan kata ganti "others" (Skill 60): Kata "others" adalah kata ganti jamak (plural pronoun) yang berdiri sendiri tanpa kata benda di belakangnya. Karena setelahnya terdapat kata benda jamak "workers", maka yang dibutuhkan adalah kata sifat (adjective) yang tidak pernah berakhiran -s, yaitu "other" ("other workers"). Perbaikan: "others" diganti menjadi "other". Kunci: (B).',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Because the <span class="error-option" data-label="A">main highway</span> is <span class="error-option" data-label="B">crowded</span> at this hour, the driver <span class="error-option" data-label="C">should try</span> to find another <span class="error-option" data-label="D">routes</span> to the stadium.',
                'option_a' => 'main highway',
                'option_b' => 'crowded',
                'option_c' => 'should try',
                'option_d' => 'routes',
                'correct_answer' => 'D',
                'explanation' => 'Kesesuaian kata benda tunggal setelah "another" (Skill 60): Kata "another" (an + other) hanya boleh diikuti oleh kata benda tunggal dapat dihitung (singular countable noun). Oleh karena itu, kata benda jamak "routes" setelah "another" salah dan harus diubah menjadi bentuk tunggal "route" ("another route"). Perbaikan: "routes" diganti menjadi "route". Kunci: (D).',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Because they were not pleased with the hotel accommodations last year, they have decided to try <span class="error-option" data-label="A">a other</span> <span class="error-option" data-label="B">hotel</span> <span class="error-option" data-label="C">this</span> <span class="error-option" data-label="D">year</span>.',
                'option_a' => 'a other',
                'option_b' => 'hotel',
                'option_c' => 'this',
                'option_d' => 'year',
                'correct_answer' => 'A',
                'explanation' => 'Bentuk baku "another" untuk tunggal tak tentu (Skill 60): Dalam bahasa Inggris, bentuk tunggal tak tentu (indefinite singular) tidak pernah ditulis sebagai "a other" ataupun "an other" secara terpisah, melainkan wajib digabung menjadi satu kata: "another" ("another hotel"). Perbaikan: "a other" diganti menjadi "another". Kunci: (A).',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Pittsburgh has reduced <span class="error-option" data-label="A">its</span> smog by requiring <span class="error-option" data-label="B">more</span> complete oxidation of fuel in cars, and <span class="error-option" data-label="C">others</span> cities can <span class="error-option" data-label="D">do</span> the same thing.',
                'option_a' => 'its',
                'option_b' => 'more',
                'option_c' => 'others',
                'option_d' => 'do',
                'correct_answer' => 'C',
                'explanation' => 'Larangan menggunakan "others" di depan kata benda (Skill 60): Kata "others" berfungsi murni sebagai kata ganti jamak (plural pronoun) dan tidak boleh diletakkan di depan kata benda "cities". Untuk menerangkan kata benda jamak "cities", gunakan kata sifat "other" ("other cities"). Perbaikan: "others" diganti menjadi "other". Kunci: (C).',
            ],
            [
                'question_number' => 7,
                'question_text' => 'While <span class="error-option" data-label="A">some species</span> of birds <span class="error-option" data-label="B">migrate</span> <span class="error-option" data-label="C">thousands</span> of miles each autumn, <span class="error-option" data-label="D">other</span> remain in their native habitats throughout the winter.',
                'option_a' => 'some species',
                'option_b' => 'migrate',
                'option_c' => 'thousands',
                'option_d' => 'other',
                'correct_answer' => 'D',
                'explanation' => 'Penggunaan kata ganti jamak "others" tanpa kata benda (Skill 60): Pada klausa utama, subjek sebelum kata kerja jamak "remain" berdiri sendiri tanpa kata benda (mengacu pada "other species of birds"). Kata "other" tanpa artikel tidak dapat berdiri sendiri sebagai kata ganti subjek jamak; bentuk kata ganti jamak tak tentu (indefinite plural pronoun) yang tepat adalah "others". Perbaikan: "other" diganti menjadi "others". Kunci: (D).',
            ],
            [
                'question_number' => 8,
                'question_text' => 'A pearl develops <span class="error-option" data-label="A">when</span> a tiny grain of sand or some <span class="error-option" data-label="B">another</span> <span class="error-option" data-label="C">irritant</span> accidentally <span class="error-option" data-label="D">enters into</span> the shell of a pearl oyster.',
                'option_a' => 'when',
                'option_b' => 'another',
                'option_c' => 'irritant',
                'option_d' => 'enters into',
                'correct_answer' => 'B',
                'explanation' => 'Larangan menggunakan "another" setelah determiner "some" (Skill 60): Karena kata "another" sudah mengandung determiner "an" (an + other), kata ini tidak boleh didahului oleh determiner lain seperti "some", "the", "this", atau "any". Setelah determiner "some", kata yang harus digunakan adalah "other" ("some other irritant"). Perbaikan: "another" diganti menjadi "other". Kunci: (B).',
            ],
            [
                'question_number' => 9,
                'question_text' => '<span class="error-option" data-label="A">Perhaps</span> the <span class="error-option" data-label="B">designer</span> could select <span class="error-option" data-label="C">others</span> styles <span class="error-option" data-label="D">if these</span> patterns are inappropriate.',
                'option_a' => 'Perhaps',
                'option_b' => 'designer',
                'option_c' => 'others',
                'option_d' => 'if these',
                'correct_answer' => 'C',
                'explanation' => 'Membedakan "other" (adjective) dan "others" (pronoun) (Skill 60): Kata "others" hanya digunakan sebagai kata ganti jamak yang berdiri sendiri (tidak diikuti kata benda). Karena di belakangnya terdapat kata benda jamak "styles", maka yang diperlukan adalah bentuk kata sifat "other" ("other styles"). Perbaikan: "others" diganti menjadi "other". Kunci: (C).',
            ],
            [
                'question_number' => 10,
                'question_text' => '<span class="error-option" data-label="A">One another</span> <span class="error-option" data-label="B">surprising</span> method of forest <span class="error-option" data-label="C">conservation is</span> <span class="error-option" data-label="D">controlled cutting</span> of trees.',
                'option_a' => 'One another',
                'option_b' => 'surprising',
                'option_c' => 'conservation is',
                'option_d' => 'controlled cutting',
                'correct_answer' => 'A',
                'explanation' => 'Penggunaan "Another" di depan kata benda tunggal tak tentu (Skill 60): Frasa "one another" adalah kata ganti resiprokal (saling / satu sama lain) yang tidak dapat berfungsi sebagai determiner di depan kata benda. Untuk menerangkan kata benda tunggal tak tentu "surprising method", gunakan determiner "Another" ("Another surprising method"). Perbaikan: "One another" diganti menjadi "Another". Kunci: (A).',
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
