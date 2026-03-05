<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\User;
use App\Models\Enrollment;

class ProgramEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create additional programs
        $programs = [
            [
                'name' => 'Grammar for Speaking',
                'slug' => 'grammar-for-speaking',
                'period' => 'September 2024',
            ],
            [
                'name' => 'IELTS General',
                'slug' => 'ielts-general',
                'period' => 'September 2024',
            ],
            [
                'name' => 'IELTS Academic',
                'slug' => 'ielts-academic',
                'period' => 'September 2024',
            ],
            [
                'name' => 'PTE',
                'slug' => 'pte',
                'period' => 'September 2024',
            ],
        ];

        foreach ($programs as $programData) {
            $program = Program::firstOrCreate(
                ['slug' => $programData['slug']],
                $programData
            );

            // Create 20 meetings for each program
            for ($i = 1; $i <= 20; $i++) {
                \App\Models\Meeting::firstOrCreate(
                    [
                        'program_id' => $program->id,
                        'meeting_number' => $i
                    ],
                    [
                        'title' => "Meeting $i",
                        'is_locked' => true,
                    ]
                );
            }
        }

        // Get the student user
        $student = User::where('email', 'student@targetbahasa.com')->first();
        
        if ($student) {
            // Enroll student in all programs
            $allPrograms = Program::all();
            
            foreach ($allPrograms as $program) {
                Enrollment::firstOrCreate(
                    [
                        'user_id' => $student->id,
                        'program_id' => $program->id
                    ],
                    [
                        'enrolled_at' => now(),
                        'status' => 'active'
                    ]
                );
            }
            
            $this->command->info('Student enrolled in ' . $allPrograms->count() . ' programs successfully!');
        } else {
            $this->command->error('Student user not found!');
        }
    }
}
