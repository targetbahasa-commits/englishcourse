<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting16Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 16],
            [
                'title' => 'Adjectives and Adverbs',
                'description' => 'Structure Meeting 16 - Problems with Adjectives and Adverbs (Skills 46-48)',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => '<span class="error-option" data-label="A">Modern art</span> is on <span class="error-option" data-label="B">display</span> at the Guggenheim Museum, <span class="error-option" data-label="C">a building</span> with an <span class="error-option" data-label="D">unusually</span> design.',
                'option_a' => 'Modern art',
                'option_b' => 'display',
                'option_c' => 'a building',
                'option_d' => 'unusually',
                'correct_answer' => 'D',
                'explanation' => 'Penggunaan dasar kata sifat vs kata keterangan (Skill 46): Kata yang terletak di antara artikel "an" dan kata benda "design" berfungsi menerangkan kata benda "design". Kata keterangan (adverb) "unusually" tidak boleh digunakan untuk menerangkan kata benda secara langsung; yang diperlukan adalah kata sifat (adjective) "unusual" ("an unusual design"). Perbaikan: "unusually" diganti menjadi "unusual". Kunci: (D).',
            ],
            [
                'question_number' => 2,
                'question_text' => 'By the beginning <span class="error-option" data-label="A">of the 1980s</span> fifteen states had <span class="error-option" data-label="B">adopted already</span> <span class="error-option" data-label="C">no-fault</span> <span class="error-option" data-label="D">insurance</span> laws.',
                'option_a' => 'of the 1980s',
                'option_b' => 'adopted already',
                'option_c' => 'no-fault',
                'option_d' => 'insurance',
                'correct_answer' => 'B',
                'explanation' => 'Posisi kata keterangan terhadap kata kerja dan objeknya (Skill 48): Kata keterangan (adverb) yang menerangkan kata kerja tidak boleh disisipkan di antara kata kerja transitif ("adopted") dan objek langsungnya ("no-fault insurance laws"). Kata keterangan "already" harus diletakkan di antara kata kerja bantu "had" dan past participle "adopted" ("had already adopted"). Perbaikan: "adopted already" diganti menjadi "already adopted". Kunci: (B).',
            ],
            [
                'question_number' => 3,
                'question_text' => '<span class="error-option" data-label="A">Heart attacks</span> are <span class="error-option" data-label="B">fatally</span> in 75 <span class="error-option" data-label="C">percent</span> of <span class="error-option" data-label="D">occurrences</span>.',
                'option_a' => 'Heart attacks',
                'option_b' => 'fatally',
                'option_c' => 'percent',
                'option_d' => 'occurrences',
                'correct_answer' => 'B',
                'explanation' => 'Penggunaan kata sifat setelah linking verb (Skill 47): Kata kerja "are" (to be) merupakan linking verb yang menghubungkan subjek "Heart attacks" dengan pelengkap penjelasnya. Setelah linking verb tanpa kata sifat lain di belakangnya, wajib digunakan kata sifat (predicate adjective) untuk menerangkan subjek, bukan kata keterangan (adverb). Perbaikan: "fatally" diganti menjadi "fatal". Kunci: (B).',
            ],
            [
                'question_number' => 4,
                'question_text' => 'In spite of a <span class="error-option" data-label="A">tremendous</span> <span class="error-option" data-label="B">amount</span> of <span class="error-option" data-label="C">electronic</span> gadgetry, air traffic control still depends <span class="error-option" data-label="D">heavy</span> on people.',
                'option_a' => 'tremendous',
                'option_b' => 'amount',
                'option_c' => 'electronic',
                'option_d' => 'heavy',
                'correct_answer' => 'D',
                'explanation' => 'Penggunaan kata keterangan untuk menerangkan kata kerja (Skill 46): Kata "depends" adalah kata kerja aksi/biasa (bukan linking verb). Untuk menerangkan bagaimana "air traffic control depends on people", dibutuhkan kata keterangan (adverb) berakhiran -ly, bukan kata sifat "heavy". Perbaikan: "heavy" diganti menjadi "heavily" ("depends heavily on people"). Kunci: (D).',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Only recently have Gooden’s <span class="error-option" data-label="A">industrially</span> <span class="error-option" data-label="B">designers</span> and engineers been able to optimize Watertred’s <span class="error-option" data-label="C">unusual</span> tread patterns for <span class="error-option" data-label="D">mass production</span>.',
                'option_a' => 'industrially',
                'option_b' => 'designers',
                'option_c' => 'unusual',
                'option_d' => 'mass production',
                'correct_answer' => 'A',
                'explanation' => 'Penggunaan kata sifat untuk menerangkan kata benda (Skill 46): Kata berfungsi menerangkan kata benda "designers and engineers" (desainer dan insinyur industri). Kata keterangan "industrially" tidak dapat menerangkan kata benda; bentuk yang tepat adalah kata sifat (adjective) "industrial". Perhatikan bahwa inversi "Only recently have" sudah benar sesuai Skill 17. Perbaikan: "industrially" diganti menjadi "industrial". Kunci: (A).',
            ],
            [
                'question_number' => 6,
                'question_text' => 'A <span class="error-option" data-label="A">baboon’s</span> arms <span class="error-option" data-label="B">appear</span> as <span class="error-option" data-label="C">lengthily</span> as <span class="error-option" data-label="D">its</span> legs.',
                'option_a' => 'baboon’s',
                'option_b' => 'appear',
                'option_c' => 'lengthily',
                'option_d' => 'its',
                'correct_answer' => 'C',
                'explanation' => 'Penggunaan kata sifat setelah linking verb (Skill 47): Kata kerja "appear" (tampak/terlihat) termasuk dalam kelompok linking verbs (bersama seem, look, feel, become, dll.). Oleh karena itu, kata yang mengikutinya dalam perbandingan "as ... as" untuk menerangkan subjek "arms" harus berupa kata sifat (adjective) "long", bukan kata keterangan "lengthily". Perbaikan: "lengthily" diganti menjadi "long". Kunci: (C).',
            ],
            [
                'question_number' => 7,
                'question_text' => 'A serious problem is how to communicate <span class="error-option" data-label="A">reliable</span> <span class="error-option" data-label="B">with</span> a <span class="error-option" data-label="C">submerged</span> <span class="error-option" data-label="D">submarine</span>.',
                'option_a' => 'reliable',
                'option_b' => 'with',
                'option_c' => 'submerged',
                'option_d' => 'submarine',
                'correct_answer' => 'A',
                'explanation' => 'Penggunaan kata keterangan untuk menerangkan kata kerja (Skill 46): Kata pada pilihan (A) menerangkan kata kerja "communicate" (bagaimana berkomunikasi secara andal). Kata sifat "reliable" tidak dapat menerangkan kata kerja; yang dibutuhkan adalah kata keterangan (adverb) "reliably". Perbaikan: "reliable" diganti menjadi "reliably". Kunci: (A).',
            ],
            [
                'question_number' => 8,
                'question_text' => '<span class="error-option" data-label="A">Americans</span> are <span class="error-option" data-label="B">destroying rapidly</span> wetlands, <span class="error-option" data-label="C">faster than</span> an acre <span class="error-option" data-label="D">every two</span> minutes.',
                'option_a' => 'Americans',
                'option_b' => 'destroying rapidly',
                'option_c' => 'faster than',
                'option_d' => 'every two',
                'correct_answer' => 'B',
                'explanation' => 'Larangan meletakkan adverb di antara kata kerja dan objeknya (Skill 48): Kata kerja "destroying" memiliki objek langsung "wetlands". Kata keterangan "rapidly" tidak boleh diletakkan di antara kata kerja "destroying" dan objeknya "wetlands". Kata keterangan tersebut harus dipindahkan ke depan kata kerja utama ("are rapidly destroying wetlands") atau setelah objek. Perbaikan: "destroying rapidly" diganti menjadi "rapidly destroying". Kunci: (B).',
            ],
            [
                'question_number' => 9,
                'question_text' => 'The <span class="error-option" data-label="A">central</span> <span class="error-option" data-label="B">banking</span> system of the United States <span class="error-option" data-label="C">consists</span> of twelve <span class="error-option" data-label="D">banks district</span>.',
                'option_a' => 'central',
                'option_b' => 'banking',
                'option_c' => 'consists',
                'option_d' => 'banks district',
                'correct_answer' => 'D',
                'explanation' => 'Posisi penjelas (modifier) di depan kata benda yang diterangkan (Skill 48): Dalam bahasa Inggris, kata sifat atau noun adjunct yang menerangkan kata benda lain harus diletakkan sebelum kata benda utamanya (head noun), bukan setelahnya. Karena yang dimaksud adalah dua belas "bank distrik" (dengan "banks" sebagai kata benda utama yang jamak dan "district" sebagai penjelasnya), susunan yang benar adalah "district banks". Perbaikan: "banks district" diganti menjadi "district banks". Kunci: (D).',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Telegraph <span class="error-option" data-label="A">service</span> <span class="error-option" data-label="B">across</span> the Atlantic was <span class="error-option" data-label="C">successful</span> <span class="error-option" data-label="D">established</span> in 1866.',
                'option_a' => 'service',
                'option_b' => 'across',
                'option_c' => 'successful',
                'option_d' => 'established',
                'correct_answer' => 'C',
                'explanation' => 'Penggunaan kata keterangan untuk menerangkan kata kerja pasif/participle (Skill 46): Kata yang mendahului past participle "established" berfungsi menerangkan bagaimana layanan telegraf tersebut dibangun/didirikan. Untuk menerangkan kata kerja/participle "established", harus digunakan kata keterangan (adverb) "successfully", bukan kata sifat "successful". Perbaikan: "successful" diganti menjadi "successfully". Kunci: (C).',
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
