<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Program;
use App\Models\Meeting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $program = Program::where('slug', 'fast-track-grammar-for-writing')->first();
        if ($program) {
            $topics = [
                1 => 'Silang - silang tenses',
                2 => 'Latihan penerapan tenses',
                3 => 'Modal',
                4 => 'Negative sentence',
                5 => 'To Infinitive & Gerund',
                6 => 'Comparative, superlative, positive degree & Parallel Structures',
                7 => 'Adverbial Clause',
                8 => 'Adjective Clause - RPS / RPP',
                9 => 'Adjective Clause RPP, RA',
                10 => 'Noun Clause',
            ];

            foreach ($topics as $i => $topic) {
                Meeting::updateOrCreate(
                    [
                        'program_id' => $program->id,
                        'meeting_number' => $i,
                    ],
                    [
                        'title' => 'Meeting ' . $i,
                        'description' => 'Fast Track meeting ' . $i,
                        'order' => $i,
                        'is_locked' => false,
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $program = Program::where('slug', 'fast-track-grammar-for-writing')->first();
        if ($program) {
            Meeting::where('program_id', $program->id)->delete();
        }
    }
};
