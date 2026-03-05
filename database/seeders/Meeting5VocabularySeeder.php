<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Meeting5VocabularySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing Meeting 5 vocabularies
        DB::table('grammar_vocabularies')->where('meeting_number', 5)->delete();

        $vocabularies = [
            // Simple Present - verbal
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'menyelesaikan', 'translation' => 'solve', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'masalah', 'translation' => 'problem', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'membantu', 'translation' => 'help', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'melindungi', 'translation' => 'protect', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'hutan', 'translation' => 'forest', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'pemerintah', 'translation' => 'government', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'undang-undang', 'translation' => 'law', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'menjamin', 'translation' => 'guarantee', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'kebebasan', 'translation' => 'freedom', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Present - verbal', 'word' => 'berekspresi', 'translation' => 'expression', 'pos' => 'general'],
            
            // Simple Past - verbal
            ['meeting_number' => 5, 'section' => 'Simple Past - verbal', 'word' => 'mamalia', 'translation' => 'mammal', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Past - verbal', 'word' => 'menyebar', 'translation' => 'spread', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Past - verbal', 'word' => 'secara luas', 'translation' => 'widely', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Past - verbal', 'word' => 'juta', 'translation' => 'million', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Past - verbal', 'word' => 'tahun yang lalu', 'translation' => 'years ago', 'pos' => 'general'],
            
            // Present Continuous - verbal
            ['meeting_number' => 5, 'section' => 'Present Continuous - verbal', 'word' => 'sedang', 'translation' => 'currently', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Present Continuous - verbal', 'word' => 'bekerja', 'translation' => 'work', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Present Continuous - verbal', 'word' => 'proyek', 'translation' => 'project', 'pos' => 'general'],
            
            // Past Continuous - verbal
            ['meeting_number' => 5, 'section' => 'Past Continuous - verbal', 'word' => 'sedang', 'translation' => 'was/were', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Past Continuous - verbal', 'word' => 'belajar', 'translation' => 'study', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Past Continuous - verbal', 'word' => 'saat itu', 'translation' => 'at that time', 'pos' => 'general'],
            
            // Present Perfect - verbal
            ['meeting_number' => 5, 'section' => 'Present Perfect - verbal', 'word' => 'sudah', 'translation' => 'already', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Present Perfect - verbal', 'word' => 'menyelesaikan', 'translation' => 'finish', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Present Perfect - verbal', 'word' => 'tugas', 'translation' => 'task', 'pos' => 'general'],
            
            // Past Perfect - verbal
            ['meeting_number' => 5, 'section' => 'Past Perfect - verbal', 'word' => 'sudah', 'translation' => 'had', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Past Perfect - verbal', 'word' => 'pergi', 'translation' => 'go', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Past Perfect - verbal', 'word' => 'sebelum', 'translation' => 'before', 'pos' => 'general'],
            
            // Simple Future - verbal
            ['meeting_number' => 5, 'section' => 'Simple Future - verbal', 'word' => 'akan', 'translation' => 'will', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Future - verbal', 'word' => 'datang', 'translation' => 'come', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Simple Future - verbal', 'word' => 'besok', 'translation' => 'tomorrow', 'pos' => 'general'],
            
            // Modal - verbal
            ['meeting_number' => 5, 'section' => 'Modal - verbal', 'word' => 'boleh', 'translation' => 'must', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Modal - verbal', 'word' => 'merokok', 'translation' => 'smoke', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Modal - verbal', 'word' => 'mungkin', 'translation' => 'might', 'pos' => 'general'],
            ['meeting_number' => 5, 'section' => 'Modal - verbal', 'word' => 'bisa', 'translation' => 'can', 'pos' => 'general'],
        ];

        DB::table('grammar_vocabularies')->insert($vocabularies);
        
        $this->command->info('Meeting 5 vocabularies seeded successfully!');
    }
}
