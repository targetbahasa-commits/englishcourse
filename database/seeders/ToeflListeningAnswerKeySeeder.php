<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningAnswerKeySeeder extends Seeder
{
    /**
     * Kunci jawaban Listening Comprehension Diagnostic Pre-Test
     * Berdasarkan gambar yang diberikan user
     */
    public function run(): void
    {
        // Kunci jawaban untuk 50 soal (Part A: 1-30, Part B: 31-37, Part C: 38-50)
        $answerKeys = [
            // Part A - Questions 1-30
            1 => 'C', 2 => 'B', 3 => 'D', 4 => 'C', 5 => 'D',
            6 => 'A', 7 => 'B', 8 => 'D', 9 => 'A', 10 => 'D',
            11 => 'C', 12 => 'D', 13 => 'A', 14 => 'B', 15 => 'D',
            16 => 'C', 17 => 'C', 18 => 'A', 19 => 'B', 20 => 'A',
            21 => 'C', 22 => 'D', 23 => 'C', 24 => 'A', 25 => 'B',
            26 => 'D', 27 => 'B', 28 => 'B', 29 => 'A', 30 => 'C',
            
            // Part B - Questions 31-37
            31 => 'B', 32 => 'C', 33 => 'D', 34 => 'A', 35 => 'D',
            36 => 'B', 37 => 'A',
            
            // Part C - Questions 38-50
            38 => 'D', 39 => 'C', 40 => 'D', 41 => 'D', 42 => 'A',
            43 => 'B', 44 => 'D', 45 => 'D', 46 => 'A', 47 => 'D',
            48 => 'D', 49 => 'A', 50 => 'C',
        ];

        foreach ($answerKeys as $questionNumber => $correctAnswer) {
            ToeflListeningQuestion::where('question_number', $questionNumber)
                ->update(['correct_answer' => $correctAnswer]);
        }

        $this->command->info('Kunci jawaban listening berhasil diupdate!');
    }
}
