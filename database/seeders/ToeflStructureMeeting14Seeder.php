<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting14Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 14],
            [
                'title' => 'Make and Do',
                'description' => 'Structure Meeting 14 - Distinguish Make and Do (Skills 58-60)',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'The buffalo and the bison <span class="error-option" data-label="A">are</span> <span class="error-option" data-label="B">like</span> <span class="error-option" data-label="C">except for</span> the <span class="error-option" data-label="D">size</span> and shape of the head and shoulders.',
                'option_a' => 'are',
                'option_b' => 'like',
                'option_c' => 'except for',
                'option_d' => 'size',
                'correct_answer' => 'B',
                'explanation' => 'Membedakan "like" dan "alike" (Skill 59): Kata "like" berfungsi sebagai kata depan (preposition) atau kata sifat yang harus diikuti oleh objek kata benda (misalnya "Buffalo is like bison"). Sebaliknya, karena kedua kata benda telah disebutkan sebelumnya sebagai subjek jamak ("The buffalo and the bison") dan diikuti oleh linking verb "are" tanpa objek benda lagi setelahnya, maka yang dibutuhkan adalah predicate adjective "alike". Perbaikan: "like" diganti menjadi "alike". Kunci: (B).',
            ],
            [
                'question_number' => 2,
                'question_text' => '<span class="error-option" data-label="A">Other</span> <span class="error-option" data-label="B">interesting</span> aspect of tachistopic training in recent years <span class="error-option" data-label="C">has been</span> the newfound <span class="error-option" data-label="D">use</span> by professional teams.',
                'option_a' => 'Other',
                'option_b' => 'interesting',
                'option_c' => 'has been',
                'option_d' => 'use',
                'correct_answer' => 'A',
                'explanation' => 'Membedakan "another" dan "other" (Skill 60): Kata benda "aspect" adalah kata benda tunggal dapat dihitung (singular countable noun) yang belum spesifik (indefinite). Kata "other" tanpa determiner hanya dapat mendampingi kata benda jamak ("other aspects") atau tak terhitung. Untuk mendampingi kata benda tunggal tak tentu ("interesting aspect"), kata yang wajib digunakan adalah "Another" (an + other). Perbaikan: "Other" diganti menjadi "Another". Kunci: (A).',
            ],
            [
                'question_number' => 3,
                'question_text' => '<span class="error-option" data-label="A">Only about</span> 3 percent of <span class="error-option" data-label="B">oil wells</span> <span class="error-option" data-label="C">actually</span> <span class="error-option" data-label="D">do</span> a profit.',
                'option_a' => 'Only about',
                'option_b' => 'oil wells',
                'option_c' => 'actually',
                'option_d' => 'do',
                'correct_answer' => 'D',
                'explanation' => 'Membedakan penggunaan "make" dan "do" (Skill 58): Kata kerja "do" digunakan untuk aktivitas menyelesaikan pekerjaan umum atau tugas ("do work", "do research"), sedangkan "make" digunakan untuk makna menciptakan, menghasilkan, atau membangun sesuatu. Dalam bahasa Inggris, ungkapan baku untuk menghasilkan keuntungan finansial adalah "make a profit", bukan "do a profit". Perbaikan: "do" diganti menjadi "make". Kunci: (D).',
            ],
            [
                'question_number' => 4,
                'question_text' => '<span class="error-option" data-label="A">Dislike</span> sumac <span class="error-option" data-label="B">with</span> red berries, sumac with white berries <span class="error-option" data-label="C">is</span> <span class="error-option" data-label="D">poisonous</span>.',
                'option_a' => 'Dislike',
                'option_b' => 'with',
                'option_c' => 'is',
                'option_d' => 'poisonous',
                'correct_answer' => 'A',
                'explanation' => 'Membedakan "unlike" dan "dislike" (Skill 59): Kata "dislike" adalah kata kerja (verb) yang berarti "tidak menyukai". Pada kalimat ini, dibutuhkan kata depan (preposition) yang berarti "tidak seperti / berbeda dengan" untuk mengawali frasa preposisi pembanding sebelum kata benda "sumac with red berries". Kata depan yang tepat adalah "Unlike". Perbaikan: "Dislike" diganti menjadi "Unlike". Kunci: (A).',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Pittsburgh has reduced <span class="error-option" data-label="A">its</span> smog by requiring <span class="error-option" data-label="B">more</span> complete oxidation of fuel in cars, and <span class="error-option" data-label="C">others</span> cities can <span class="error-option" data-label="D">do</span> the same thing.',
                'option_a' => 'its',
                'option_b' => 'more',
                'option_c' => 'others',
                'option_d' => 'do',
                'correct_answer' => 'C',
                'explanation' => 'Membedakan "other" dan "others" (Skill 60): Kata "others" adalah kata ganti jamak (plural pronoun) yang berdiri sendiri menggantikan kata benda dan tidak boleh diikuti oleh kata benda lagi. Karena di belakangnya terdapat kata benda jamak "cities", maka yang diperlukan adalah kata sifat (adjective) yang tidak pernah berakhiran -s, yaitu "other" ("other cities"). Perhatikan juga bahwa "do the same thing" pada pilihan (D) sudah benar sesuai Skill 58. Perbaikan: "others" diganti menjadi "other". Kunci: (C).',
            ],
            [
                'question_number' => 6,
                'question_text' => '<span class="error-option" data-label="A">Alike</span> <span class="error-option" data-label="B">all</span> <span class="error-option" data-label="C">other</span> mammals, dolphins <span class="error-option" data-label="D">have</span> lungs.',
                'option_a' => 'Alike',
                'option_b' => 'all',
                'option_c' => 'other',
                'option_d' => 'have',
                'correct_answer' => 'A',
                'explanation' => 'Membedakan "like" dan "alike" (Skill 59): Kata "alike" adalah predicate adjective yang hanya digunakan setelah linking verb dan tidak dapat diletakkan di depan kata benda. Karena di awal kalimat ini diikuti oleh objek kata benda "all other mammals", maka yang diperlukan adalah kata depan (preposition) "Like" ("Like all other mammals"). Perbaikan: "Alike" diganti menjadi "Like". Kunci: (A).',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Up to World War II <span class="error-option" data-label="A">almost all</span> important research in physics had been <span class="error-option" data-label="B">made</span> in universities, <span class="error-option" data-label="C">with only</span> university funds <span class="error-option" data-label="D">for support</span>.',
                'option_a' => 'almost all',
                'option_b' => 'made',
                'option_c' => 'with only',
                'option_d' => 'for support',
                'correct_answer' => 'B',
                'explanation' => 'Membedakan penggunaan "make" dan "do" (Skill 58): Kegiatan penelitian ilmiah ("research") merupakan proses pelaksanaan pekerjaan/investigasi, bukan pembuatan objek fisik baru. Oleh karena itu, kata benda "research" berpasangan dengan kata kerja "do" ("do research" / dalam bentuk pasif "research had been done"), bukan "made". Perbaikan: "made" diganti menjadi "done". Kunci: (B).',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Because the plan <span class="error-option" data-label="A">that was made</span> yesterday is <span class="error-option" data-label="B">no longer</span> feasible, the manager <span class="error-option" data-label="C">had to</span> choose another <span class="error-option" data-label="D">alternatives</span>.',
                'option_a' => 'that was made',
                'option_b' => 'no longer',
                'option_c' => 'had to',
                'option_d' => 'alternatives',
                'correct_answer' => 'D',
                'explanation' => 'Kesesuaian kata benda setelah "another" (Skill 60): Kata "another" berasal dari "an + other" sehingga secara mutlak hanya boleh diikuti oleh kata benda tunggal (singular noun). Oleh karena itu, kata benda jamak "alternatives" setelah kata "another" salah dan harus diubah menjadi bentuk tunggal "alternative" ("another alternative"). Perhatikan bahwa frasa "the plan that was made" pada (A) sudah benar sesuai Skill 58 ("make a plan"). Perbaikan: "alternatives" diganti menjadi "alternative". Kunci: (D).',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Particles with <span class="error-option" data-label="A">unlike</span> charges attract each other, <span class="error-option" data-label="B">while</span> particles with <span class="error-option" data-label="C">alike</span> charges repel each <span class="error-option" data-label="D">other</span>.',
                'option_a' => 'unlike',
                'option_b' => 'while',
                'option_c' => 'alike',
                'option_d' => 'other',
                'correct_answer' => 'C',
                'explanation' => 'Membedakan kata sifat "like" dan "alike" (Skill 59): Kata sifat "alike" hanya dapat menempati posisi predikat (setelah linking verb) dan tidak boleh diletakkan sebelum kata benda yang diterangkannya. Untuk menerangkan kata benda "charges" secara langsung di depannya (sebagaimana "unlike charges" pada bagian A), kata sifat yang harus digunakan adalah "like" ("with like charges" = dengan muatan yang sejenis). Perbaikan: "alike" diganti menjadi "like". Kunci: (C).',
            ],
            [
                'question_number' => 10,
                'question_text' => '<span class="error-option" data-label="A">One another</span> <span class="error-option" data-label="B">surprising</span> method of forest <span class="error-option" data-label="C">conservation is</span> <span class="error-option" data-label="D">controlled cutting</span> of trees.',
                'option_a' => 'One another',
                'option_b' => 'surprising',
                'option_c' => 'conservation is',
                'option_d' => 'controlled cutting',
                'correct_answer' => 'A',
                'explanation' => 'Penggunaan determiner "another" (Skill 60): Frasa "one another" adalah kata ganti resiprokal (saling / satu sama lain) yang berfungsi sebagai objek di akhir klausa, bukan sebagai determiner di depan kata benda. Untuk menerangkan kata benda tunggal "surprising method" dengan makna "satu metode mengejutkan lainnya", kata yang tepat di awal kalimat adalah "Another". Perbaikan: "One another" diganti menjadi "Another". Kunci: (A).',
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
