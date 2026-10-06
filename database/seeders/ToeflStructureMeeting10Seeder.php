<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting10Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 10],
            [
                'title' => 'Fanboys & Pair Conjunction',
                'description' => 'Structure Meeting 10 - Fanboys & Pair Conjunction (Skills 24-26)',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Truman Capote\'s In Cold Blood is neither journalistically accurate _____.',
                'option_a' => 'a piece of fiction',
                'option_b' => 'nor a fictitious work',
                'option_c' => 'or written in a fictitious way',
                'option_d' => 'nor completely fictitious',
                'correct_answer' => 'D',
                'explanation' => 'Parallel structure dengan paired conjunction "neither... nor..." (Skill 25): unsur setelah "neither" adalah frasa kata sifat dengan keterangan ("journalistically accurate"), sehingga unsur setelah "nor" harus setara/sejajar dalam bentuk frasa kata sifat ("completely fictitious"). Pilihan (B) salah karena "a fictitious work" adalah kata benda (noun phrase); pilihan (C) salah karena menggunakan konjungsi "or" alih-alih "nor". Pilihan yang tepat dan paralel adalah (D).',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Vitamin C is necessary for the prevention and _____ of scurvy.',
                'option_a' => 'it cures',
                'option_b' => 'cures',
                'option_c' => 'cure',
                'option_d' => 'for curing',
                'correct_answer' => 'C',
                'explanation' => 'Parallel structure dengan coordinate conjunction "and" (Skill 24): kata penghubung "and" menghubungkan dua unsur yang setara di bawah pola "for the [noun] and [noun] of scurvy". Kata "prevention" adalah kata benda (noun), sehingga kata setelah "and" harus sejajar berupa kata benda tunggal yaitu "cure" (C). Pilihan (A) adalah klausa, (B) adalah verb/plural, dan (D) adalah prepositional phrase yang tidak sejajar.',
            ],
            [
                'question_number' => 3,
                'question_text' => 'A baby\'s development is influenced by both heredity and _____.',
                'option_a' => 'environment',
                'option_b' => 'environmentally',
                'option_c' => 'the influence of the environment',
                'option_d' => 'by environmental factors',
                'correct_answer' => 'A',
                'explanation' => 'Parallel structure dengan paired conjunction "both... and..." (Skill 25): setelah "both" terdapat kata benda tunggal "heredity", sehingga setelah "and" harus diikuti kata benda tunggal yang sejajar yaitu "environment" (A). Pilihan (D) mengulang preposisi "by", pilihan (B) adalah adverb, dan pilihan (C) berlebihan serta tidak sejajar.',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Because bone loss occurs earlier in women than _____, the effects of osteoporosis are more apparent in women.',
                'option_a' => 'men do',
                'option_b' => 'in men',
                'option_c' => 'as men',
                'option_d' => 'similar to men',
                'correct_answer' => 'B',
                'explanation' => 'Parallel structure dalam perbandingan / comparisons menggunakan "than" (Skill 26): hal yang dibandingkan adalah tempat terjadinya pengeroposan tulang pada wanita ("in women"). Oleh karena itu, pembandingnya setelah kata "than" harus berupa frasa preposisi yang sejajar, yaitu "in men" (B) ("earlier in women than in men").',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Fire <span class="error-option" data-label="A">extinguishers</span> <span class="error-option" data-label="B">can contain</span> liquefied gas, dry chemicals, <span class="error-option" data-label="C">or</span> <span class="error-option" data-label="D">watery</span>.',
                'option_a' => 'extinguishers',
                'option_b' => 'can contain',
                'option_c' => 'or',
                'option_d' => 'watery',
                'correct_answer' => 'D',
                'explanation' => 'Parallel structure dengan coordinate conjunction "or" (Skill 24): konjungsi "or" menghubungkan deretan isi tabung pemadam yaitu "liquefied gas" (noun), "dry chemicals" (noun), dan seharusnya kata benda "water", bukan kata sifat "watery". Perbaikan: "watery" diganti menjadi "water". Kunci: (D).',
            ],
            [
                'question_number' => 6,
                'question_text' => 'The U.S. Congress consists of both the Senate <span class="error-option" data-label="A">as well as</span> <span class="error-option" data-label="B">the</span> <span class="error-option" data-label="C">House</span> of <span class="error-option" data-label="D">Representatives</span>.',
                'option_a' => 'as well as',
                'option_b' => 'the',
                'option_c' => 'House',
                'option_d' => 'Representatives',
                'correct_answer' => 'A',
                'explanation' => 'Parallel structure dengan paired conjunction (Skill 25): pasangan kata hubung yang tepat untuk "both" adalah "and" (both ... and ...), bukan "as well as". Frasa yang benar adalah "both the Senate and the House of Representatives". Perbaikan: "as well as" diganti menjadi "and". Kunci: (A).',
            ],
            [
                'question_number' => 7,
                'question_text' => 'The prison <span class="error-option" data-label="A">population</span> in this state, now <span class="error-option" data-label="B">at an all time high</span>, <span class="error-option" data-label="C">is higher</span> than <span class="error-option" data-label="D">any state</span>.',
                'option_a' => 'population',
                'option_b' => 'at an all time high',
                'option_c' => 'is higher',
                'option_d' => 'any state',
                'correct_answer' => 'D',
                'explanation' => 'Parallel structure dalam perbandingan / comparisons (Skill 26): subjek yang dibandingkan adalah "The prison population" (populasi penjara), bukan negaranya ("state"). Populasi penjara suatu negara bagian tidak bisa dibandingkan langsung dengan negara bagian lain, melainkan harus dibandingkan dengan populasi di negara bagian lain ("that of any other state" atau "in any other state"). Perbaikan: "any state" diganti menjadi "that of any other state". Kunci: (D).',
            ],
            [
                'question_number' => 8,
                'question_text' => 'A <span class="error-option" data-label="A">well-composed</span> baroque opera achieves a delicate balance by <span class="error-option" data-label="B">focusing</span> alternately on the aural, visual, emotional, and <span class="error-option" data-label="C">philosophy</span> <span class="error-option" data-label="D">elements</span>.',
                'option_a' => 'well-composed',
                'option_b' => 'focusing',
                'option_c' => 'philosophy',
                'option_d' => 'elements',
                'correct_answer' => 'C',
                'explanation' => 'Parallel structure dengan coordinate conjunction "and" (Skill 24): konjungsi "and" menghubungkan deretan kata sifat yang memodifikasi kata benda "elements": "aural", "visual", "emotional", dan seharusnya kata sifat "philosophical", bukan kata benda "philosophy". Perbaikan: "philosophy" diganti menjadi "philosophical". Kunci: (C).',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Manufacturers <span class="error-option" data-label="A">may use</span> food additives <span class="error-option" data-label="B">for preserving</span>, to color, to flavor, or to <span class="error-option" data-label="C">fortify</span> <span class="error-option" data-label="D">foods</span>.',
                'option_a' => 'may use',
                'option_b' => 'for preserving',
                'option_c' => 'fortify',
                'option_d' => 'foods',
                'correct_answer' => 'B',
                'explanation' => 'Parallel structure dengan coordinate conjunction "or" (Skill 24): konjungsi "or" menghubungkan serangkaian tujuan dalam bentuk to-infinitive: "to color", "to flavor", atau "to fortify". Oleh karena itu, unsur pertama harus sejajar dalam bentuk to-infinitive yaitu "to preserve", bukan prepositional phrase "for preserving". Perbaikan: "for preserving" diganti menjadi "to preserve". Kunci: (B).',
            ],
            [
                'question_number' => 10,
                'question_text' => '<span class="error-option" data-label="A">A bankruptcy</span> may be either <span class="error-option" data-label="B">voluntary</span> <span class="error-option" data-label="C">nor</span> <span class="error-option" data-label="D">involuntary</span>.',
                'option_a' => 'A bankruptcy',
                'option_b' => 'voluntary',
                'option_c' => 'nor',
                'option_d' => 'involuntary',
                'correct_answer' => 'C',
                'explanation' => 'Parallel structure dengan paired conjunction (Skill 25): pasangan kata hubung yang tepat untuk "either" adalah "or" (either ... or ...), sedangkan "nor" berpasangan dengan "neither" (neither ... nor ...). Oleh karena itu, kata "nor" harus diganti menjadi "or" ("either voluntary or involuntary"). Kunci: (C).',
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
