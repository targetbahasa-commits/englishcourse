<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting12Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 12],
            [
                'title' => 'Expressions of Quantity',
                'description' => 'Structure Meeting 12 - Make Verbs Agree After Expressions of Quantity (Skills 20-23)',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Among bees _____ a highly elaborate form of communication.',
                'option_a' => 'occur',
                'option_b' => 'occurs',
                'option_c' => 'it occurs',
                'option_d' => 'they occur',
                'correct_answer' => 'B',
                'explanation' => 'Kesesuaian subjek dan kata kerja pada kalimat inversi (Skill 22): Kalimat ini diawali oleh frasa preposisi tempat/lingkup "Among bees" (bukan subjek kalimat), sehingga mengalami inversi di mana kata kerja diletakkan mendahului subjek. Subjek utamanya adalah frasa benda tunggal "a highly elaborate form" (diikuti keterangan preposisi "of communication"). Karena subjeknya tunggal ("a ... form"), maka kata kerja yang dibutuhkan harus berbentuk tunggal, yaitu "occurs" (B). Pilihan (A) jamak, sedangkan (C) dan (D) menimbulkan subjek ganda (double subject).',
            ],
            [
                'question_number' => 2,
                'question_text' => '_____ heated by solar energy have special collectors on the roofs to trap sunlight.',
                'option_a' => 'A home is',
                'option_b' => 'Homes are',
                'option_c' => 'A home',
                'option_d' => 'Homes',
                'correct_answer' => 'D',
                'explanation' => 'Kesesuaian subjek dan kata kerja utama (Skill 20): Kata kerja utama pada kalimat ini adalah "have" (jamak), sementara frasa "heated by solar energy" merupakan past participle (reduced adjective clause) yang menjelaskan subjek. Oleh karena kata kerja utamanya berbentuk jamak ("have"), maka subjek yang diperlukan adalah kata benda jamak tanpa kata kerja tambahan, yaitu "Homes" (D). Pilihan (A) dan (B) menyebabkan double verb, sedangkan pilihan (C) berbentuk tunggal ("A home") sehingga tidak sesuai dengan kata kerja jamak "have".',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Each number in a <span class="error-option" data-label="A">binary</span> system <span class="error-option" data-label="B">are</span> <span class="error-option" data-label="C">formed</span> from <span class="error-option" data-label="D">only two</span> symbols.',
                'option_a' => 'binary',
                'option_b' => 'are',
                'option_c' => 'formed',
                'option_d' => 'only two',
                'correct_answer' => 'B',
                'explanation' => 'Kesesuaian kata kerja setelah kata tertentu yang selalu tunggal (Skill 23): Subjek kalimat ini adalah "Each number" (diikuti oleh frasa preposisi "in a binary system"). Kata "each" (+ kata benda tunggal) secara gramatikal selalu dihitung tunggal (singular), sehingga harus diikuti oleh kata kerja bantu tunggal "is", bukan "are". Perbaikan: "are" diganti menjadi "is". Kunci: (B).',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Scientists at the medical center <span class="error-option" data-label="A">is trying</span> <span class="error-option" data-label="B">to determine</span> if there <span class="error-option" data-label="C">is</span> a relationship between <span class="error-option" data-label="D">saccharine and cancer</span>.',
                'option_a' => 'is trying',
                'option_b' => 'to determine',
                'option_c' => 'is',
                'option_d' => 'saccharine and cancer',
                'correct_answer' => 'A',
                'explanation' => 'Kesesuaian kata kerja setelah frasa preposisi (Skill 20): Subjek utama klausa pertama adalah kata benda jamak "Scientists", sedangkan "at the medical center" hanyalah frasa preposisi yang tidak memengaruhi bentuk kata kerja. Jangan terkecoh oleh kata benda tunggal "center" tepat di depan kata kerja. Karena subjek "Scientists" berbentuk jamak, kata kerja yang tepat adalah "are trying", bukan "is trying". Perbaikan: "is trying" diganti menjadi "are trying". Kunci: (A).',
            ],
            [
                'question_number' => 5,
                'question_text' => 'On <span class="error-option" data-label="A">the rim</span> of the Kilauea volcano in the <span class="error-option" data-label="B">Hawaiian Islands</span> <span class="error-option" data-label="C">are</span> a hotel <span class="error-option" data-label="D">called</span> the Volcano Hotel.',
                'option_a' => 'the rim',
                'option_b' => 'Hawaiian Islands',
                'option_c' => 'are',
                'option_d' => 'called',
                'correct_answer' => 'C',
                'explanation' => 'Kesesuaian kata kerja pada kalimat inversi (Skill 22): Kalimat ini diawali oleh rangkaian frasa preposisi tempat "On the rim of the Kilauea volcano in the Hawaiian Islands", sehingga kata kerja diletakkan sebelum subjek (inversi). Jangan terkecoh oleh objek preposisi jamak "Hawaiian Islands" tepat sebelum kata kerja; subjek sebenarnya berada setelah kata kerja, yaitu kata benda tunggal "a hotel". Oleh karena itu, kata kerja jamak "are" salah dan harus diganti dengan kata kerja tunggal "is". Perbaikan: "are" diganti menjadi "is". Kunci: (C).',
            ],
            [
                'question_number' => 6,
                'question_text' => 'The <span class="error-option" data-label="A">great digital</span> advances of the electronic age, such as integrated <span class="error-option" data-label="B">circuitry</span> and a microcomputer, <span class="error-option" data-label="C">has</span> been <span class="error-option" data-label="D">planted</span> in tiny chips.',
                'option_a' => 'great digital',
                'option_b' => 'circuitry',
                'option_c' => 'has',
                'option_d' => 'planted',
                'correct_answer' => 'C',
                'explanation' => 'Kesesuaian kata kerja setelah frasa preposisi dan apositif/contoh (Skill 20): Subjek utama kalimat ini adalah kata benda jamak "advances" ("The great digital advances"), sedangkan "of the electronic age" dan "such as integrated circuitry and a microcomputer" adalah frasa penjelas yang tidak menentukan bentuk kata kerja. Karena subjek "advances" berbentuk jamak, maka auxiliary verb yang tepat adalah "have" ("have been planted"), bukan "has". Perbaikan: "has" diganti menjadi "have". Kunci: (C).',
            ],
            [
                'question_number' => 7,
                'question_text' => 'There are many <span class="error-option" data-label="A">frequently</span> <span class="error-option" data-label="B">mentioned</span> reasons why one out of <span class="error-option" data-label="C">four arrests</span> <span class="error-option" data-label="D">involve</span> a juvenile.',
                'option_a' => 'frequently',
                'option_b' => 'mentioned',
                'option_c' => 'four arrests',
                'option_d' => 'involve',
                'correct_answer' => 'D',
                'explanation' => 'Kesesuaian kata kerja setelah frasa preposisi (Skill 20): Pada anak kalimat "why one out of four arrests involve a juvenile", subjek klausa tersebut adalah kata ganti jumlah tunggal "one", sedangkan "out of four arrests" merupakan frasa preposisi. Jangan terkecoh oleh kata benda jamak "arrests" sebelum kata kerja. Karena subjeknya tunggal ("one"), maka kata kerjanya harus berbentuk tunggal dengan akhiran -s, yaitu "involves". Perbaikan: "involve" diganti menjadi "involves". Kunci: (D).',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Kepler\'s Laws, principles outlining planetary movement, <span class="error-option" data-label="A">was</span> <span class="error-option" data-label="B">formulated</span> <span class="error-option" data-label="C">based</span> on observations <span class="error-option" data-label="D">made</span> without a telescope.',
                'option_a' => 'was',
                'option_b' => 'formulated',
                'option_c' => 'based',
                'option_d' => 'made',
                'correct_answer' => 'A',
                'explanation' => 'Kesesuaian subjek dan kata kerja yang dipisahkan oleh apositif: Subjek utama kalimat ini adalah kata benda jamak "Kepler\'s Laws" (diikuti apositif "principles outlining planetary movement"). Karena subjek utamanya jamak ("Laws"), maka kata kerja pasif yang mengikutinya harus berbentuk jamak yaitu "were" ("were formulated"), bukan "was". Perbaikan: "was" diganti menjadi "were". Kunci: (A).',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Only with a <span class="error-option" data-label="A">two-thirds vote</span> by both houses <span class="error-option" data-label="B">are</span> the U.S. Congress <span class="error-option" data-label="C">able to</span> override a presidential <span class="error-option" data-label="D">veto</span>.',
                'option_a' => 'two-thirds vote',
                'option_b' => 'are',
                'option_c' => 'able to',
                'option_d' => 'veto',
                'correct_answer' => 'B',
                'explanation' => 'Kesesuaian kata kerja pada kalimat inversi dengan ekspresi "Only" (Skill 22): Kalimat ini diawali oleh ekspresi pembatas "Only with a two-thirds vote by both houses", sehingga mengalami inversi di mana kata kerja mendahului subjek. Jangan terkecoh oleh kata benda jamak "both houses" tepat di depan kata kerja; subjek kalimat sebenarnya adalah organisasi tunggal "the U.S. Congress". Karena itu, kata kerja "are" harus diganti menjadi bentuk tunggal "is". Perbaikan: "are" diganti menjadi "is". Kunci: (B).',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Of all the evidence that <span class="error-option" data-label="A">has piled</span> up since Webster\'s paper was <span class="error-option" data-label="B">published</span>, there <span class="error-option" data-label="C">is</span> no <span class="error-option" data-label="D">new</span> ideas to contradict his original theory.',
                'option_a' => 'has piled',
                'option_b' => 'published',
                'option_c' => 'is',
                'option_d' => 'new',
                'correct_answer' => 'C',
                'explanation' => 'Kesesuaian kata kerja setelah ungkapan kuantitas (Skill 21) dan pada struktur "there" (Skill 22): Pada bagian (A), ungkapan kuantitas "all (of) the evidence" diikuti kata kerja tunggal "has piled" yang sudah benar karena "evidence" adalah kata benda tak terhitung (uncountable noun). Namun, pada klausa utama "there is no new ideas", kata kerja setelah "there" harus menyesuaikan dengan subjek yang berada di belakangnya, yaitu kata benda jamak "ideas". Oleh karena itu, kata kerja tunggal "is" salah dan harus diganti dengan bentuk jamak "are" ("there are no new ideas"). Perbaikan: "is" diganti menjadi "are". Kunci: (C).',
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
