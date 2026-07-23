<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class FinalTestResultsSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('final_test_results')->insert([
            [
                'user_id' => null,
                'name' => 'Budi Santoso',
                'email' => 'budi@example.test',
                'candidate_id' => 'FT-0001',
                'test_type' => 'toefl_itp',
                'test_label' => 'TOEFL ITP',
                'status' => 'completed',
                'duration_minutes' => 90,
                'time_spent_seconds' => 5400,
                'score' => 560.5,
                'answers_data' => json_encode(['listening' => 20, 'structure' => 22, 'reading' => 21]),
                'evaluation_data' => json_encode(['graded_by' => 'system']),
                'started_at' => $now->subHours(3),
                'completed_at' => $now->subHours(1),
                'created_at' => $now->subHours(1),
                'updated_at' => $now->subHours(1),
            ],
            [
                'user_id' => null,
                'name' => 'Siti Rahma',
                'email' => 'siti@example.test',
                'candidate_id' => 'FT-0002',
                'test_type' => 'ielts_academic',
                'test_label' => 'IELTS Academic',
                'status' => 'in_progress',
                'duration_minutes' => 120,
                'time_spent_seconds' => 3600,
                'score' => null,
                'answers_data' => json_encode([]),
                'evaluation_data' => json_encode([]),
                'started_at' => $now->subHours(2),
                'completed_at' => null,
                'created_at' => $now->subHours(2),
                'updated_at' => $now->subHours(2),
            ],
        ]);
    }
}
